<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\TextRun;
use PhpOffice\PhpWord\Element\Text;

class UserController extends Controller
{
    public static function formatBytes($bytes, $precision = 2)
    {
        if ($bytes <= 0) {
            return '0 B';
        }
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    public function index(Request $request)
    {
        $validSorts = ['title', 'author', 'publisher', 'publication_year', 'created_at', 'downloads_count'];
        $sort = in_array($request->sort, $validSorts) ? $request->sort : 'created_at';
        $direction = $request->direction === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');
        $filter = $request->get('filter', 'all');

        $files = Softfile::query()
        ->select(['id', 'title', 'author', 'publisher', 'publication_date', 'isbn', 'issn', 'file_path', 'created_at', 'preview_token'])
        ->withCount(['downloads as downloads_count'])
        ->when($search, function ($query) use ($search) {
            $searchLower = strtolower($search);
            $query->where(function ($q) use ($searchLower) {
                $q->whereRaw("LOWER(title) LIKE ?", ["%{$searchLower}%"])
                    ->orWhereRaw("LOWER(author) LIKE ?", ["%{$searchLower}%"])
                    ->orWhereRaw("LOWER(publisher) LIKE ?", ["%{$searchLower}%"])
                    ->orWhereRaw("LOWER(isbn) LIKE ?", ["%{$searchLower}%"])
                    ->orWhereRaw("LOWER(issn) LIKE ?", ["%{$searchLower}%"]);
            });
        })
        ->when($filter, function ($query) {
            switch (request()->get('filter')) {
                case 'popular':
                    $query->orderBy('downloads_count', 'desc');
                    break;
                case 'new':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'recommended':
                    if (Auth::check()) {
                        $genres = Auth::user()->preferred_genres ?? [];
                        $query->whereIn('genre', $genres);
                    }
                    break;
                case 'textbook':
                    $query->where('category', 'textbook');
                    break;
            }
        })
        ->orderBy($sort, $direction)
        ->paginate(5)
        ->withQueryString();

        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        $stats = [
            'totalBooks' => Softfile::count(),
            'newThisMonth' => Softfile::where('created_at', '>=', now()->startOfMonth())->count(),
            'popularBook' => Softfile::withCount(['downloads as downloads_count' => function ($query) {
                $query->where('created_at', '>=', now()->startOfMonth());
            }])->orderBy('downloads_count', 'desc')->first(),
            'userDownloads' => $user ? $user->downloads()->count() : 0,
            'lastDownload' => $user ? optional($user->downloads()->latest()->first())->created_at : null,
            'monthlyDownloads' => Download::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        $recentlyViewed = $user
            ? $user->downloads()->with('softfile')->latest()->limit(4)->get()->pluck('softfile')
            : collect();

        $recommendedBooks = Softfile::withCount('downloads')
            ->orderBy('downloads_count', 'desc')
            ->limit(4)
            ->get();

        return view('dashboard.user', [
            'files' => $files,
            'currentSort' => $sort,
            'currentDirection' => $direction,
            'newBooksThisMonth' => $stats['newThisMonth'],
            'mostPopularBook' => $stats['popularBook'],
            'userDownloadsCount' => $stats['userDownloads'],
            'lastDownloadTime' => $stats['lastDownload'],
            'totalDownloadsThisMonth' => $stats['monthlyDownloads'],
            'recentlyViewed' => $recentlyViewed,
            'recommendedBooks' => $recommendedBooks,
            'searchQuery' => $search,
            'activeFilter' => $filter,
            'maxDownloads' => Softfile::withCount('downloads')->get()->max('downloads_count') ?? 1,
            'downloadGrowth' => $this->calculateDownloadGrowth(),
        ]);
    }

    private function calculateDownloadGrowth()
    {
        $currentMonth = Download::where('created_at', '>=', now()->startOfMonth())->count();
        $lastMonth = Download::whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])->count();

        if ($lastMonth == 0) {
            return 0;
        }

        return (($currentMonth - $lastMonth) / $lastMonth) * 100;
    }

    public function showFile($id, Request $request)
    {
        $file = Softfile::findOrFail($id);

        // Validasi token
        if ($request->query('token') !== $file->preview_token) {
            abort(403, 'Token pratinjau tidak valid.');
        }

        $filePath = storage_path('app/public/' . $file->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan.');
        }

        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $mimeTypes = [
            'pdf' => 'application/pdf',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'doc' => 'application/msword',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'csv' => 'text/csv',
            'txt' => 'text/plain',
            'rtf' => 'application/rtf',
            'xml' => 'application/xml',
            'html' => 'text/html',
            'htm' => 'text/html',
            'ppt' => 'application/vnd.ms-powerpoint',
            'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        if (!array_key_exists($extension, $mimeTypes)) {
            abort(415, 'Format file tidak didukung untuk pratinjau.');
        }

        return response()->file($filePath, [
            'Content-Type' => $mimeTypes[$extension],
            'Content-Disposition' => 'inline; filename="' . basename($filePath) . '"',
        ]);
    }

    public function search(Request $request)
    {
        $keyword = $request->query('search');
        $sort = $request->query('sort', 'title');
        $direction = $request->query('direction', 'asc');

        $query = Softfile::query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('author', 'like', "%{$keyword}%")
                ->orWhere('publisher', 'like', "%{$keyword}%");
            });
        }

        $files = $query->orderBy($sort, $direction)->get()->map(function ($file) {
            return [
                'id' => $file->id,
                'title' => $file->title,
                'author' => $file->author,
                'publisher' => $file->publisher,
                'publication_year' => $file->publication_year,
                'isbn' => $file->isbn,
                'issn' => $file->issn,
                'downloads_count' => $file->downloads_count,
                'created_at' => $file->created_at,
                'preview_token' => $file->preview_token,
                'file_extension' => strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)),
                'file_size' => Storage::disk('public')->exists($file->file_path)
                    ? $this->formatBytes(Storage::disk('public')->size($file->file_path))
                    : '-',
            ];
        });

        return response()->json($files);
    }

    public function preview($id, Request $request)
    {
        $file = Softfile::findOrFail($id);

        // Validasi token
        if ($request->query('token') !== $file->preview_token) {
            abort(403, 'Token pratinjau tidak valid.');
        }

        $canPreview = in_array(
            strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)),
            ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'doc', 'docx', 'txt', 'rtf', 'xml', 'html', 'htm', 'csv']
        );

        return view('dashboard.user_detail', [
            'softfile' => $file,
            'previewToken' => $request->query('token'),
            'canPreview' => $canPreview,
        ]);
    }

    private function detectMimeType($path)
    {
        if (!file_exists($path)) {
            return 'application/octet-stream';
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $path);
        finfo_close($finfo);

        return $mime ?: 'application/octet-stream';
    }

    public function download(Softfile $softfile): BinaryFileResponse
    {
        try {
            $softfile->downloads()->create([
                'user_id' => Auth::id()
            ]);

            $relativePath = $softfile->file_path;

            if (empty($relativePath)) {
                abort(404, 'Path file tidak valid');
            }

            if (!Storage::disk('public')->exists($relativePath)) {
                abort(404, 'File tidak ditemukan di penyimpanan');
            }

            $fullPath = Storage::disk('public')->path($relativePath);
            $mimeType = $this->detectMimeType($fullPath);

            $headers = [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="' . basename($softfile->original_filename) . '"',
                'Content-Length' => filesize($fullPath),
                'Pragma' => 'public',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            return new BinaryFileResponse($fullPath, 200, $headers, true);

        } catch (\Exception $e) {
            Log::error('Download error: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat mengunduh file');
        }
    }

    public function previewDoc(Request $request, $id)
    {
        $softfile = Softfile::findOrFail($id);
        $filePath = Storage::disk('public')->path($softfile->file_path);

        $pdfPath = tempnam(sys_get_temp_dir(), 'docpreview') . '.pdf';
        exec("libreoffice --headless --convert-to pdf --outdir " . escapeshellarg(dirname($pdfPath)) . " " . escapeshellarg($filePath));

        if (file_exists($pdfPath)) {
            return response()->file($pdfPath, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename=\"preview.pdf\"'
            ]);
        }

        abort(500, 'Gagal mengkonversi dokumen');
    }

    public function previewDocText($id)
    {
        $softfile = Softfile::findOrFail($id);
        $filePath = Storage::disk('public')->path($softfile->file_path);

        $phpWord = IOFactory::load($filePath);
        $html = '';

        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if ($element instanceof TextRun) {
                    foreach ($element->getElements() as $text) {
                        if ($text instanceof Text) {
                            $html .= $text->getText() . '<br>';
                        }
                    }
                }
            }
        }

        return view('dashboard.doc_preview', [
            'content' => $html,
            'softfile' => $softfile
        ]);
    }
}