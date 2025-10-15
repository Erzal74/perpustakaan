<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Added to resolve Undefined type 'DB' error

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
            ->paginate(20);

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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv|max:10240',
            'edition' => 'nullable|string|max:50',
            'author' => 'required|string|max:255',
            'genre' => 'nullable|string|max:100',
            'isbn' => 'nullable|string|max:20',
            'issn' => 'nullable|string|max:20',
            'publisher' => 'required|string|max:255',
            'publication_date' => 'nullable|date_format:Y-m',
        ]);

        $file = $request->file('file');
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('softfiles', $filename, 'public');

        $publicationDate = null;
        if ($request->publication_date) {
            $publicationDate = \Carbon\Carbon::createFromFormat('Y-m', $request->publication_date)
                ->startOfMonth()
                ->toDateString();
        }

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
            'publication_date' => $publicationDate,
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
            'isbn' => 'nullable|string|max:20',
            'issn' => 'nullable|string|max:20',
            'edition' => 'nullable|string|max:50',
            'genre' => 'nullable|string|max:100',
            'filename' => 'required|string|max:255|regex:/^[a-zA-Z0-9_\-. ]+$/',
        ]);

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

        $extension = pathinfo($softfile->original_filename, PATHINFO_EXTENSION);
        $newFileName = $request->filename . '.' . $extension;
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

            if (!$request->query('token') || $softfile->preview_token !== $request->query('token')) {
                abort(403, 'Token pratinjau tidak valid');
            }

            $relativePath = str_replace('\\', '/', ltrim($softfile->file_path, '/\\'));
            $fullPath = storage_path('app/public/' . $relativePath);

            if (!Storage::disk('public')->exists($relativePath)) {
                abort(404, 'File tidak ditemukan di penyimpanan');
            }

            $extension = strtolower(pathinfo($softfile->original_filename, PATHINFO_EXTENSION));
            $mime = $this->detectMimeType($fullPath);

            if ($extension === 'csv') {
                return $this->previewCsv($fullPath, $softfile->original_filename);
            }

            // Tambahkan handling untuk doc, docx, xls, xlsx, ppt, pptx menggunakan Google Docs
            if (in_array($extension, ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
                if (in_array($extension, ['xls', 'xlsx'])) {
                    return $this->previewExcel($fullPath, $softfile->original_filename);
                } elseif (in_array($extension, ['ppt', 'pptx'])) {
                    return $this->previewPpt($fullPath, $softfile->original_filename);
                } else {
                    return $this->previewDoc($fullPath, $softfile->original_filename);
                }
            }

            // Untuk format lain (pdf, txt, dll.), tampilkan inline
            return response()->file($fullPath, [
                'Content-Type' => $mime,
                'Content-Disposition' => 'inline; filename="'.$softfile->original_filename.'"'
            ]);

        } catch (\Exception $e) {
            Log::error('Preview error: ' . $e->getMessage());
            abort(500, 'Terjadi kesalahan saat memuat pratinjau');
        }
    }

    private function previewCsv($filePath, $filename)
    {
        $csvData = array_map('str_getcsv', file($filePath));
        $html = view('previews.csv', [
            'data' => $csvData,
            'filename' => $filename
        ])->render();

        return response($html);
    }

    private function previewDoc($filePath, $filename)
    {
        $publicUrl = asset('storage/' . str_replace('storage/app/public/', '', $filePath));
        $googleDocsUrl = "https://docs.google.com/gview?url=" . urlencode($publicUrl) . "&embedded=true";

        return view('previews.doc', [
            'googleDocsUrl' => $googleDocsUrl,
            'filename' => $filename
        ]);
    }

    private function previewExcel($filePath, $filename)
    {
        $publicUrl = asset('storage/' . str_replace('storage/app/public/', '', $filePath));
        $googleDocsUrl = "https://docs.google.com/gview?url=" . urlencode($publicUrl) . "&embedded=true";

        return view('previews.excel', [
            'googleDocsUrl' => $googleDocsUrl,
            'filename' => $filename
        ]);
    }

    private function previewPpt($filePath, $filename)
    {
        $publicUrl = asset('storage/' . str_replace('storage/app/public/', '', $filePath));
        $googleDocsUrl = "https://docs.google.com/gview?url=" . urlencode($publicUrl) . "&embedded=true";

        return view('previews.ppt', [
            'googleDocsUrl' => $googleDocsUrl,
            'filename' => $filename
        ]);
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

            // Hapus semua data di downloads yang terkait
            DB::table('downloads')->where('softfile_id', $softfile->id)->delete();

            // Hapus file fisik
            if (Storage::disk('public')->exists($softfile->file_path)) {
                Storage::disk('public')->delete($softfile->file_path);
            }

            // Hapus record softfile
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
                    // Hapus semua data di downloads yang terkait
                    DB::table('downloads')->where('softfile_id', $file->id)->delete();

                    // Hapus file fisik
                    if (Storage::disk('public')->exists($file->file_path)) {
                        Storage::disk('public')->delete($file->file_path);
                    }

                    // Hapus record softfile
                    $file->delete();
                    $count++;
                }
            }
            return redirect()->route('admin.index')->with('success', "Berhasil menghapus $count buku.");
        } catch (\Exception $e) {
            Log::error('Bulk delete error: ' . $e->getMessage());
            return redirect()->route('admin.index')->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
    }
}