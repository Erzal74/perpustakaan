<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
    $softfile = Softfile::findOrFail($id);

    $token = $request->query('token');

    if (!$token || $softfile->preview_token !== $token) {
        abort(403, 'Token pratinjau tidak valid.');
    }

    return view('dashboard.user_preview', [
        'softfile' => $softfile,
        'previewToken' => $token,
    ]);
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