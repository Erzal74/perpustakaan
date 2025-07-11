<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
    // app/Http/Controllers/UserController.php
public function preview(Request $request, $id)
{
    try {
        $softfile = Softfile::findOrFail($id);

        // Debugging
        \Log::info('Preview request', [
            'id' => $id,
            'file_path' => $softfile->file_path,
            'token' => $request->query('token')
        ]);

        // Validasi token (jika menggunakan token)
        if ($request->has('token') && $softfile->preview_token !== $request->token) {
            abort(403, 'Token pratinjau tidak valid');
        }

        // Verifikasi file
        $relativePath = str_replace('\\', '/', ltrim($softfile->file_path, '/\\'));
        $fullPath = storage_path('app/public/' . $relativePath);

        if (!Storage::disk('public')->exists($relativePath)) {
            \Log::error('File not found', [
                'expected' => $relativePath,
                'storage' => Storage::disk('public')->files('softfiles')
            ]);
            abort(404, 'File tidak ditemukan');
        }

        // Return view dengan data yang diperlukan
        return view('dashboard.user_preview', [
            'softfile' => $softfile,
            'fileExists' => true,
            'safeFilePath' => Storage::disk('public')->url($relativePath),
            'previewToken' => $softfile->preview_token ?? null
        ]);

    } catch (\Exception $e) {
        \Log::error('Preview error: ' . $e->getMessage());
        abort(500, 'Terjadi kesalahan saat memuat pratinjau');
    }
}
private function detectMimeType($path)
{
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $path);
    finfo_close($finfo);

    return $mime ?: 'application/octet-stream';
}
    // Fungsi download file dengan pengecekan keamanan path
    public function download(Softfile $softfile)
    {
        $path = storage_path('app/public/' . $softfile->file_path);

        if (!file_exists($path)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($path, $softfile->original_filename);
    }
}