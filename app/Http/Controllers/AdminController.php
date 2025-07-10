<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
{
    $sortField = request('sort', 'created_at');
    $sortDirection = request('direction', 'desc');
    
    $files = SoftFile::query()
        ->when(request('sort'), function ($query) use ($sortField, $sortDirection) {
            $query->orderBy($sortField, $sortDirection);
        }, function ($query) {
            $query->latest();
        })
        ->get();

    return view('dashboard.admin', compact('files'));
}

    public function create()
    {
        return view('dashboard.admin_create');
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'file' => 'required|file|mimes:pdf,docx,xlsx,pptx',
        'edition' => 'nullable|string',
        'author' => 'nullable|string',
        'genre' => 'nullable|string',
        'isbn' => 'nullable|string',
        'issn' => 'nullable|string',
        'publisher' => 'nullable|string',
        'publication_year' => 'nullable|date_format:Y-m',
    ]);

    $file = $request->file('file'); // ✅ tambahkan ini
    $filename = uniqid() . '.' . $file->getClientOriginalExtension(); // nama acak
    $path = $file->storeAs('softfiles', $filename, 'public'); // simpan di public

    Softfile::create([
        'title' => $request->title,
        'description' => $request->description,
        'file_path' => $path, // relatif ke storage/app/public
        'edition' => $request->edition,
        'author' => $request->author,
        'genre' => $request->genre,
        'isbn' => $request->isbn,
        'issn' => $request->issn,
        'publisher' => $request->publisher,
        'publication_year' => $request->publication_year ? substr($request->publication_year, 0, 4) : null,
        'original_filename' => $file->getClientOriginalName(),
    ]);

    return redirect()->route('admin.index')->with('success', 'Softfile berhasil ditambahkan.');
}


    public function edit($id)
    {
        $softfile = Softfile::findOrFail($id);
        return view('dashboard.admin_edit', compact('softfile'));
    }

    public function update(Request $request, $id)
{
    $softfile = Softfile::findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'author' => 'required|string|max:255',
        'publisher' => 'required|string|max:255',
        'publication_year' => 'nullable|integer|min:1000|max:' . date('Y'),
        'isbn' => 'nullable|string|max:20',
        'issn' => 'nullable|string|max:20',
        'edition' => 'nullable|string|max:50',
        'genre' => 'nullable|string|max:100',
        'filename' => 'required|string|max:255|regex:/^[a-zA-Z0-9_\-. ]+$/',
    ]);

    $updateData = [
        'title' => $request->title,
        'description' => $request->description,
        'author' => $request->author,
        'publisher' => $request->publisher,
        'publication_year' => $request->publication_year,
        'isbn' => $request->isbn,
        'issn' => $request->issn,
        'edition' => $request->edition,
        'genre' => $request->genre,
    ];

    // Proses rename file
    $newFileName = $request->filename . '.pdf';
    $currentFileName = $softfile->original_filename;

    if ($newFileName !== $currentFileName) {
        try {
            // Dapatkan full path sebenarnya
            $oldRelativePath = $softfile->file_path;
            $oldFullPath = storage_path('app/public/' . $oldRelativePath);
            
            // Pastikan file lama ada
            if (!file_exists($oldFullPath)) {
                throw new \Exception("File tidak ditemukan di: " . $oldFullPath);
            }

            // Buat path baru
            $newRelativePath = dirname($oldRelativePath) . '/' . $newFileName;
            $newFullPath = storage_path('app/public/' . $newRelativePath);

            // Rename file menggunakan PHP native (lebih reliable)
            if (!rename($oldFullPath, $newFullPath)) {
                throw new \Exception("Gagal mengubah nama file");
            }

            // Update database
            $updateData['file_path'] = $newRelativePath;
            $updateData['original_filename'] = $newFileName;

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal memperbarui file: ' . $e->getMessage());
        }
    }

    $softfile->update($updateData);

    return redirect()
        ->route('admin.index')
        ->with('success', 'Buku berhasil diperbarui');
}
public function destroy($id)
{
    try {
        $softfile = Softfile::findOrFail($id);
        
        // Hapus file dari storage
        if (Storage::disk('public')->exists($softfile->file_path)) {
            Storage::disk('public')->delete($softfile->file_path);
        }
        
        // Hapus record dari database
        $softfile->delete();
        
        return redirect()
            ->route('admin.index')
            ->with('success', 'Buku berhasil dihapus');
            
    } catch (\Exception $e) {
        return redirect()
            ->route('admin.index')
            ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
    }
}
}