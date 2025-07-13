<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class UserController extends Controller
{
    // Menampilkan daftar softfile user dengan fitur pencarian & sorting
    public function index(Request $request)
    {
        $validSorts = ['title', 'author', 'publisher', 'publication_year', 'created_at'];
        $sort = in_array($request->sort, $validSorts) ? $request->sort : 'created_at';
        $direction = $request->direction === 'asc' ? 'asc' : 'desc';
        $search = $request->get('search'); // Ubah dari 'q' ke 'search'

        $files = Softfile::query()
            ->when($search, function ($qBuilder) use ($search) {
                $qBuilder->where('title', 'ILIKE', "%{$search}%")
                         ->orWhere('author', 'ILIKE', "%{$search}%")
                         ->orWhere('publisher', 'ILIKE', "%{$search}%");
            })
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        return view('dashboard.user', [
            'files' => $files,
            'currentSort' => $sort,
            'currentDirection' => $direction
        ]);
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
            ->get(['id', 'title', 'edition', 'author', 'publisher', 'publication_year', 'isbn', 'issn', 'preview_token']); // tambahkan token

        return response()->json($files);
    }

    // Menampilkan halaman preview detail softfile
    public function preview(Request $request, $id)
    {
        try {
            $softfile = Softfile::findOrFail($id);

            // Validate token if using token
            if ($request->has('token') && $softfile->preview_token !== $request->token) {
                abort(403, 'Token pratinjau tidak valid');
            }

            $relativePath = $softfile->file_path;

            if (!Storage::disk('public')->exists($relativePath)) {
                Log::error('File not found in storage', [
                    'expected_path' => $relativePath,
                    'available_files' => Storage::disk('public')->allFiles()
                ]);
                abort(404, 'File tidak ditemukan');
            }

            // Generate correct URL for the view
            $fileUrl = asset('storage/' . $relativePath);

            return view('dashboard.user_preview', [
                'softfile' => $softfile,
                'fileExists' => true,
                'safeFilePath' => $fileUrl,
                'previewToken' => $softfile->preview_token ?? null
            ]);

        } catch (\Exception $e) {
            Log::error('Preview error: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat pratinjau');
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

    /**
     * Download the specified softfile
     *
     * @param Softfile $softfile
     * @return BinaryFileResponse
     */
    public function download(Softfile $softfile): BinaryFileResponse
    {
        try {
            // Dapatkan path relatif
            $relativePath = $softfile->file_path;

            // Debugging
            Log::info('Download attempt', [
                'file_id' => $softfile->id,
                'stored_path' => $relativePath,
                'storage_path' => storage_path('app/public/'.$relativePath),
                'files_in_storage' => Storage::disk('public')->allFiles()
            ]);

            // Validasi path
            if (empty($relativePath)) {
                Log::error('Empty file path for softfile: '.$softfile->id);
                abort(404, 'Path file tidak valid');
            }

            // Cek eksistensi file
            if (!Storage::disk('public')->exists($relativePath)) {
                Log::error('File not found', [
                    'expected_path' => $relativePath,
                    'available_files' => Storage::disk('public')->allFiles()
                ]);
                abort(404, 'File tidak ditemukan di penyimpanan');
            }

            // Dapatkan full path
            $fullPath = Storage::disk('public')->path($relativePath);

            // Dapatkan mime type
            $mimeType = $this->detectMimeType($fullPath);

            // Persiapkan headers
            $headers = [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'attachment; filename="'.basename($softfile->original_filename).'"',
                'Content-Length' => filesize($fullPath),
                'Pragma' => 'public',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Expires' => '0'
            ];

            // Return response download
            return new BinaryFileResponse($fullPath, 200, $headers, true);

        } catch (\Exception $e) {
            Log::error('Download error: '.$e->getMessage());
            abort(500, 'Terjadi kesalahan saat mengunduh file');
        }
    }
}
