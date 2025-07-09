<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $files = Softfile::latest()->get();
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
        ]);

        $path = $request->file('file')->store('softfiles');

        Softfile::create([
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $path,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Softfile berhasil ditambahkan.');
    }

    public function edit(Softfile $softfile)
    {
        return view('dashboard.admin_edit', compact('softfile'));
    }

    public function update(Request $request, Softfile $softfile)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,docx,xlsx,pptx',
        ]);

        if ($request->hasFile('file')) {
            Storage::delete($softfile->file_path);
            $softfile->file_path = $request->file('file')->store('softfiles');
        }

        $softfile->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Softfile berhasil diperbarui.');
    }

    public function destroy(Softfile $softfile)
    {
        Storage::delete($softfile->file_path);
        $softfile->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Softfile berhasil dihapus.');
    }
}
