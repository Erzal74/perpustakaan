@extends('layouts.app')

@section('content')
    <div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-xl font-bold mb-6 text-indigo-600">Edit Softfile</h2>

        <form action="{{ route('admin.update', $softfile->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium">Judul</label>
                <input type="text" name="title" value="{{ $softfile->title }}" required
                    class="w-full border px-3 py-2 rounded" />
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full border px-3 py-2 rounded">{{ $softfile->description }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium">Ganti File (Opsional)</label>
                <input type="file" name="file" class="w-full" />
            </div>

            <button type="submit" class="bg-indigo-600 text-black px-4 py-2 rounded hover:bg-indigo-700">Update</button>
        </form>
    </div>
@endsection
