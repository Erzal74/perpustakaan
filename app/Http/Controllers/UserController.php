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
    public function index(Request $request)
    {
        $validSorts = ['title', 'author', 'publisher', 'publication_year', 'created_at', 'downloads_count'];
        $sort = in_array($request->sort, $validSorts) ? $request->sort : 'created_at';
        $direction = $request->direction === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search');
        $filter = $request->get('filter', 'all');

        $files = Softfile::query()
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
            ->paginate(10)
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

    public function search(Request $request)
    {
        $keyword = $request->get('search');

        $files = Softfile::query()
            ->where('title', 'ILIKE', "%{$keyword}%")
            ->orWhere('author', 'ILIKE', "%{$keyword}%")
            ->orWhere('publisher', 'ILIKE', "%{$keyword}%")
            ->orderBy('title')
            ->limit(20)
            ->get(['id', 'title', 'edition', 'author', 'publisher', 'publication_year', 'isbn', 'issn', 'preview_token']);

        return response()->json($files);
    }

    public function preview(Request $request, $id)
    {
        try {
            $softfile = Softfile::findOrFail($id);

            if ($request->has('token') && $softfile->preview_token !== $request->token) {
                abort(403, 'Token pratinjau tidak valid');
            }

            $relativePath = $softfile->file_path;

            if (!Storage::disk('public')->exists($relativePath)) {
                abort(404, 'File tidak ditemukan');
            }

            $extension = strtolower(pathinfo($relativePath, PATHINFO_EXTENSION));
            $fileUrl = asset('storage/' . $relativePath);

            $previewableInBrowser = [
                'pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp',
                'txt', 'csv', 'rtf', 'xml', 'html', 'htm',
                'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'
            ];

            $allPreviewable = array_merge($previewableInBrowser, [
                'odt', 'ods', 'odp', 'odg', 'odf',
                'epub', 'mobi', 'fb2'
            ]);

            $canPreview = in_array($extension, $previewableInBrowser);

            return view('dashboard.user_preview', [
                'softfile' => $softfile,
                'fileExists' => true,
                'safeFilePath' => $fileUrl,
                'fileExtension' => $extension,
                'previewToken' => $softfile->preview_token ?? null,
                'canPreview' => $canPreview,
                'isPreviewable' => in_array($extension, $allPreviewable)
            ]);

        } catch (\Exception $e) {
            Log::error('Preview error: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat pratinjau');
        }
    }

    public function previewFile($id)
    {
        try {
            $softfile = Softfile::findOrFail($id);
            $filePath = $softfile->file_path;

            if (!Storage::disk('public')->exists($filePath)) {
                abort(404, 'File tidak ditemukan');
            }

            $absolutePath = Storage::disk('public')->path($filePath);

            $mimeType = Storage::mimeType($filePath);

            return response()->file($absolutePath, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="'.$softfile->original_filename.'"'
            ]);

        } catch (\Exception $e) {
            Log::error('File preview error: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat file');
        }
    }

    public function detail($id, $token = null)
    {
        try {
            $softfile = Softfile::withCount('downloads')->findOrFail($id);

            // Verifikasi token jika disertakan
            if ($token && $softfile->preview_token !== $token) {
                abort(403, 'Token pratinjau tidak valid');
            }

            $relativePath = $softfile->file_path;
            $fileExists = Storage::disk('public')->exists($relativePath);
            $extension = strtolower(pathinfo($relativePath, PATHINFO_EXTENSION));
            $fileUrl = asset('storage/' . $relativePath);

            // Daftar ekstensi yang bisa dipratinjau di browser
            $previewableInBrowser = [
                'pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp',
                'txt', 'csv', 'rtf', 'xml', 'html', 'htm',
                'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'
            ];

            $canPreview = $fileExists && in_array($extension, $previewableInBrowser);

            return view('dashboard.user_detail', [
                'softfile' => $softfile,
                'fileExists' => $fileExists,
                'safeFilePath' => $fileUrl,
                'fileExtension' => $extension,
                'previewToken' => $token,
                'canPreview' => $canPreview
            ]);

        } catch (\Exception $e) {
            Log::error('Detail error: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat detail');
        }
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
