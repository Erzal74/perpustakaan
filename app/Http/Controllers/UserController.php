<?php

namespace App\Http\Controllers;

use App\Models\Softfile;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $files = Softfile::latest()->get();
        return view('dashboard.user', compact('files'));
    }

    public function show(Softfile $softfile)
    {
        return view('dashboard.user_preview', compact('softfile'));
    }

    public function download(Softfile $softfile)
    {
        return response()->download(storage_path("app/" . $softfile->file_path));
    }
}
