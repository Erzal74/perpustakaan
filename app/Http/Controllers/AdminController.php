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

        $files = Softfile::query() // Perbaikan: Softfile bukan SoftFile
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
            'isbn' => 'nullable|regex:/^\d+$/',
            'issn' => 'nullable|regex:/^\d+$/',
            'publisher' => 'nullable|string',
            'publication_date' => 'nullable|date_format:Y-m',
        ]);

        $file = $request->file('file');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('softfiles', $filename, 'public');

        // Pastikan publication_date dalam format yang benar
        $publicationDate = $request->publication_date ? $request->publication_date . '-01' : null;

        Softfile::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'edition' => $request->edition,
            'author' => $request->author,
            'genre' => $request->genre,
            'isbn' => $request->isbn,
            'issn' => $request->issn,
            'publisher' => $request->publisher,
            'publication_date' => $publicationDate, // Format YYYY-MM-DD
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
            'publication_date' => 'nullable|date_format:Y-m',
            'isbn' => 'nullable|regex:/^\d+$/',
            'issn' => 'nullable|regex:/^\d+$/',
            'edition' => 'nullable|string|max:50',
            'genre' => 'nullable|string|max:100',
            'filename' => 'required|string|max:255|regex:/^[a-zA-Z0-9_\-. ]+$/',
        ]);

        // Format publication_date untuk database
        $publicationDate = $request->publication_date ? $request->publication_date . '-01' : null;

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'publication_date' => $publicationDate,
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
                $oldRelativePath = $softfile->file_path;
                $oldFullPath = storage_path('app/public/' . $oldRelativePath);

                if (!file_exists($oldFullPath)) {
                    throw new \Exception("File tidak ditemukan di: " . $oldFullPath);
                }

                $newRelativePath = dirname($oldRelativePath) . '/' . $newFileName;
                $newFullPath = storage_path('app/public/' . $newRelativePath);

                if (!rename($oldFullPath, $newFullPath)) {
                    throw new \Exception("Gagal mengubah nama file");
                }

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

    public function preview($id)
    {
        $file = Softfile::findOrFail($id);

        if (!Storage::disk('public')->exists($file->file_path)) {
            abort(404);
        }

        $path = storage_path('app/public/' . $file->file_path);
        $mime = mime_content_type($path);

        return response()->file($path, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="'.$file->original_filename.'"'
        ]);
    }

    public function destroy($id)
    {
        try {
            $softfile = Softfile::findOrFail($id);

            if (Storage::disk('public')->exists($softfile->file_path)) {
                Storage::disk('public')->delete($softfile->file_path);
            }

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
