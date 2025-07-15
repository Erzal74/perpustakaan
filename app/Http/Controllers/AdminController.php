<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log; // Added this line

class AdminController extends Controller
{
    // Tambahkan method search dan perbaiki method index
    public function index()
    {
        $sortField = request('sort', 'created_at');
        $sortDirection = request('direction', 'desc');
        $searchQuery = request('search');

        $files = Softfile::query()
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $query->where(function($q) use ($searchQuery) {
                    $q->where('title', 'like', '%'.$searchQuery.'%')
                    ->orWhere('author', 'like', '%'.$searchQuery.'%')
                    ->orWhere('publisher', 'like', '%'.$searchQuery.'%')
                    ->orWhere('isbn', 'like', '%'.$searchQuery.'%')
                    ->orWhere('issn', 'like', '%'.$searchQuery.'%');
                });
            })
            ->when(request('sort'), function ($query) use ($sortField, $sortDirection) {
                $query->orderBy($sortField, $sortDirection);
            }, function ($query) {
                $query->latest();
            })
            ->paginate(10);

        return view('dashboard.admin', compact('files'));
    }

    public function search(Request $request)
    {
        return $this->index();
    }


    public function create()
    {
        return view('dashboard.admin_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // ... validasi existing
        ]);

        $file = $request->file('file');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('softfiles', $filename, 'public');

        // Format publication_date
        $publicationDate = null;
        if ($request->publication_date) {
            $publicationDate = \Carbon\Carbon::createFromFormat('Y-m', $request->publication_date)
                ->startOfMonth()
                ->toDateString();
        }

        // Token akan otomatis dibuat oleh model boot()
        $softfile = Softfile::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
            'edition' => $request->edition,
            'author' => $request->author,
            'genre' => $request->genre,
            'isbn' => $request->isbn,
            'issn' => $request->issn,
            'publisher' => $request->publisher,
            'publication_date' => $publicationDate,
            'original_filename' => $file->getClientOriginalName(),
            // preview_token tidak perlu diisi manual
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
        $publicationDate = null;
        if ($request->publication_date) {
            $publicationDate = \Carbon\Carbon::createFromFormat('Y-m', $request->publication_date)
                ->startOfMonth()
                ->toDateString();
        }

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

    public function preview(Request $request, $id)
    {
        try {
            $softfile = Softfile::findOrFail($id);

            // Validasi token
            if (!$request->query('token') || $softfile->preview_token !== $request->query('token')) {
                abort(403, 'Token pratinjau tidak valid');
            }

            // Verifikasi path file
            $relativePath = str_replace('\\', '/', ltrim($softfile->file_path, '/\\'));
            $fullPath = storage_path('app/public/' . $relativePath);

            if (!Storage::disk('public')->exists($relativePath)) {
                abort(404, 'File tidak ditemukan di penyimpanan');
            }

            // Dapatkan mime type
            $mime = $this->detectMimeType($fullPath);

            return response()->file($fullPath, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="'.$softfile->original_filename.'"'
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Softfile tidak ditemukan');
        } catch (\Exception $e) {
            Log::error('Preview error: ' . $e->getMessage());
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
   public function bulkDestroy(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:softfiles,id',
    ]);

    try {
        $count = 0;
        foreach ($request->ids as $id) {
            $file = Softfile::find($id);
            if ($file) {
                if (Storage::disk('public')->exists($file->file_path)) {
                    Storage::disk('public')->delete($file->file_path);
                }
                $file->delete();
                $count++;
            }
        }

        return back()->with('success', "Berhasil menghapus $count buku.");

    } catch (\Exception $e) {
        Log::error('Bulk delete error: ' . $e->getMessage());
        return back()->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
    }
}

}
