<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Menampilkan daftar softfile user dengan fitur pencarian & sorting
    public function index(Request $request)
    {
        $validSorts = ['title', 'author', 'publisher', 'publication_year', 'created_at'];
        $sort = in_array($request->sort, $validSorts) ? $request->sort : 'created_at';
        $direction = $request->direction === 'asc' ? 'asc' : 'desc';
        $query = $request->get('q');

        $files = Softfile::query()
            ->when($query, function ($qBuilder) use ($query) {
                $qBuilder->where('title', 'ILIKE', "%{$query}%")
                         ->orWhere('author', 'ILIKE', "%{$query}%")
                         ->orWhere('publisher', 'ILIKE', "%{$query}%");
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

    // Untuk fitur autocomplete / live search (AJAX)
    public function search(Request $request)
    {
        $keyword = $request->get('search');

        $files = Softfile::query()
            ->where('title', 'ILIKE', "%{$keyword}%")
            ->orWhere('author', 'ILIKE', "%{$keyword}%")
            ->orWhere('publisher', 'ILIKE', "%{$keyword}%")
            ->orderBy('title')
            ->limit(20)
            ->get();

        return response()->json($files);
    }

    // Menampilkan halaman preview detail softfile
    public function show(Softfile $softfile)
    {
        return view('dashboard.user_preview', compact('softfile'));
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