@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-6 text-indigo-600">Tambah Softfile Baru</h2>

        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium">Judul</label>
                <input type="text" name="title" required class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium">File (pdf/docx/xlsx/pptx)</label>
                <input type="file" name="file" required class="w-full" />
            </div>

            <button type="submit" class="bg-indigo-600 text-black py-2 rounded hover:bg-indigo-700">Simpan</button>
        </form>
    </div>
@endsection
