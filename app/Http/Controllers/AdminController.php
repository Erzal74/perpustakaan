<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $sortField = request('sort', 'created_at');
        $sortDirection = request('direction', 'desc');
        $searchQuery = request('search');

        $files = Softfile::query()
            ->when($searchQuery, function ($query) use ($searchQuery) {
                $searchQuery = strtolower($searchQuery);
                $query->where(function($q) use ($searchQuery) {
                    $q->whereRaw("LOWER(title) LIKE ?", ["{$searchQuery}%"])
                      ->orWhereRaw("LOWER(author) LIKE ?", ["{$searchQuery}%"])
                      ->orWhereRaw("LOWER(publisher) LIKE ?", ["{$searchQuery}%"])
                      ->orWhereRaw("LOWER(isbn) LIKE ?", ["{$searchQuery}%"])
                      ->orWhereRaw("LOWER(issn) LIKE ?", ["{$searchQuery}%"]);
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
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,jpg,png|max:20480', // Tambahkan jpg,png
                'edition' => 'nullable|string|max:50',
                'author' => 'required|string|max:255',
                'genre' => 'nullable|string|max:100',
                'isbn' => 'nullable|string|max:20',
                'issn' => 'nullable|string|max:20',
                'publisher' => 'required|string|max:255',
                'publication_date' => 'nullable|date_format:Y-m',
            ]);

            // Menangani unggahan file
            $file = $request->file('file');
            $originalFilename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $filename = Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME)) . '-' . time() . '.' . $extension;
            $path = $file->storeAs('softfiles', $filename, 'public');

            // Menangani tanggal publikasi
            $publicationDate = null;
            if ($request->publication_date) {
                $publicationDate = \Carbon\Carbon::createFromFormat('Y-m', $request->publication_date)
                    ->startOfMonth()
                    ->toDateString();
            }

            // Membuat record baru
            Softfile::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'file_path' => $path,
                'edition' => $validated['edition'],
                'author' => $validated['author'],
                'genre' => $validated['genre'],
                'isbn' => $validated['isbn'],
                'issn' => $validated['issn'],
                'publisher' => $validated['publisher'],
                'publication_date' => $publicationDate,
                'original_filename' => $originalFilename,
                'preview_token' => Str::random(32),
            ]);

            return redirect()->route('admin.index')->with('success', 'Buku berhasil ditambahkan.');
        } catch (\Exception $e) {
            Log::error('Store error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan buku: ' . $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $softfile = Softfile::findOrFail($id);
        return view('dashboard.admin_edit', compact('softfile'));
    }

    public function update(Request $request, $id)
    {
        try {
            $softfile = Softfile::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'author' => 'required|string|max:255',
                'publisher' => 'required|string|max:255',
                'publication_date' => 'nullable|date_format:Y-m',
                'isbn' => 'nullable|string|max:20',
                'issn' => 'nullable|string|max:20',
                'edition' => 'nullable|string|max:50',
                'genre' => 'nullable|string|max:100',
                'filename' => 'required|string|max:255|regex:/^[a-zA-Z0-9_\-. ]+$/',
                'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,jpg,png|max:20480', // Tambahkan jpg,png
            ]);

            // Menangani tanggal publikasi
            $publicationDate = null;
            if ($request->publication_date) {
                $publicationDate = \Carbon\Carbon::createFromFormat('Y-m', $request->publication_date)
                    ->startOfMonth()
                    ->toDateString();
            }

            $updateData = [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'author' => $validated['author'],
                'publisher' => $validated['publisher'],
                'publication_date' => $publicationDate,
                'isbn' => $validated['isbn'],
                'issn' => $validated['issn'],
                'edition' => $validated['edition'],
                'genre' => $validated['genre'],
            ];

            // Menangani unggahan file baru jika ada
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($softfile->file_path && Storage::disk('public')->exists($softfile->file_path)) {
                    Storage::disk('public')->delete($softfile->file_path);
                }

                $file = $request->file('file');
                $originalFilename = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $filename = Str::slug(pathinfo($originalFilename, PATHINFO_FILENAME)) . '-' . time() . '.' . $extension;
                $path = $file->storeAs('softfiles', $filename, 'public');

                $updateData['file_path'] = $path;
                $updateData['original_filename'] = $originalFilename;
                $updateData['preview_token'] = Str::random(32);
            } else {
                // Mengubah nama file jika tidak ada file baru
                $extension = pathinfo($softfile->original_filename, PATHINFO_EXTENSION);
                $newFileName = $request->filename . '.' . $extension;
                $currentFileName = $softfile->original_filename;

                if ($newFileName !== $currentFileName) {
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
                }
            }

            $softfile->update($updateData);

            return redirect()->route('admin.index')->with('success', 'Buku berhasil diperbarui.');
        } catch (\Exception $e) {
            Log::error('Update error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui buku: ' . $e->getMessage())->withInput();
        }
    }

    public function preview(Request $request, $id)
    {
        try {
            $softfile = Softfile::findOrFail($id);

            if (!$request->query('token') || $softfile->preview_token !== $request->query('token')) {
                return response()->json(['error' => 'Token pratinjau tidak valid'], 403);
            }

            $relativePath = str_replace('\\', '/', ltrim($softfile->file_path, '/\\'));
            $fullPath = storage_path('app/public/' . $relativePath);

            if (!Storage::disk('public')->exists($relativePath)) {
                return response()->json(['error' => 'File tidak ditemukan di penyimpanan'], 404);
            }

            $extension = strtolower(pathinfo($softfile->original_filename, PATHINFO_EXTENSION));

            if ($extension === 'csv') {
                $csvData = array_map('str_getcsv', file($fullPath));
                $html = view('previews.csv', [
                    'data' => $csvData,
                    'filename' => $softfile->original_filename
                ])->render();
                return response()->json([
                    'html' => $html,
                    'type' => 'csv',
                    'filename' => $softfile->original_filename
                ]);
            }

            if (in_array($extension, ['doc', 'docx'])) {
                $publicUrl = asset('storage/' . $relativePath);
                $googleDocsUrl = "https://docs.google.com/gview?url=" . urlencode($publicUrl) . "&embedded=true";
                $html = view('previews.doc', [
                    'googleDocsUrl' => $googleDocsUrl,
                    'filename' => $softfile->original_filename
                ])->render();
                return response()->json([
                    'html' => $html,
                    'type' => 'doc',
                    'filename' => $softfile->original_filename
                ]);
            }

            if (in_array($extension, ['jpg', 'png'])) {
                $publicUrl = asset('storage/' . $relativePath);
                $html = '<div class="p-4"><img src="' . $publicUrl . '" class="max-w-full h-auto" alt="Preview"></div>';
                return response()->json([
                    'html' => $html,
                    'type' => 'image',
                    'filename' => $softfile->original_filename
                ]);
            }

            // Untuk format lain seperti PDF
            $mime = $this->detectMimeType($fullPath);
            $html = '<div class="p-4"><iframe src="' . asset('storage/' . $relativePath) . '" class="w-full h-[80vh] border-0"></iframe></div>';
            return response()->json([
                'html' => $html,
                'type' => 'other',
                'filename' => $softfile->original_filename
            ]);

        } catch (\Exception $e) {
            Log::error('Preview error: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan saat memuat pratinjau'], 500);
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

        // Hapus relasi di tabel downloads
        $softfile->downloads()->delete();

<<<<<<< HEAD
        if (Storage::disk('public')->exists($softfile->file_path)) {
            Storage::disk('public')->delete($softfile->file_path);
=======
            $softfile->delete();

            return redirect()->route('admin.index')->with('success', 'Buku berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Destroy error: ' . $e->getMessage());
            return redirect()->route('admin.index')->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
>>>>>>> 7cb708d303840bb92434217d084b5fda1f7b6c03
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
                // 🔥 Hapus data relasi di downloads
                $file->downloads()->delete();

                // 🔥 Hapus file fisik dari storage
                if (Storage::disk('public')->exists($file->file_path)) {
                    Storage::disk('public')->delete($file->file_path);
                }

                // 🔥 Hapus data dari tabel softfiles
                $file->delete();
                $count++;
            }
<<<<<<< HEAD
=======

            return redirect()->route('admin.index')->with('success', "Berhasil menghapus $count buku.");
        } catch (\Exception $e) {
            Log::error('Bulk delete error: ' . $e->getMessage());
            return redirect()->route('admin.index')->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
>>>>>>> 7cb708d303840bb92434217d084b5fda1f7b6c03
        }

        return redirect()->route('admin.index')->with('success', "Berhasil menghapus $count buku.");

    } catch (\Exception $e) {
        Log::error('Bulk delete error: ' . $e->getMessage());
        return redirect()->route('admin.index')->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
    }
}
<<<<<<< HEAD

}
=======
>>>>>>> 7cb708d303840bb92434217d084b5fda1f7b6c03
