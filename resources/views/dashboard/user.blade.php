@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded shadow">
        <h2 class="text-2xl font-bold text-indigo-600 mb-6">Daftar Softfile</h2>

        <table class="w-full table-auto border border-gray-300">
            <thead class="bg-indigo-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Judul</th>
                    <th class="px-4 py-2 border">Deskripsi</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($files as $file)
                    <tr>
                        <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border px-4 py-2">{{ $file->title }}</td>
                        <td class="border px-4 py-2">{{ $file->description }}</td>
                        <td class="border px-4 py-2 space-x-3">
                            <a href="{{ route('user.preview', $file->id) }}"
                                class="text-blue-600 hover:underline">Preview</a>
                            <a href="{{ route('user.download', $file->id) }}"
                                class="text-green-600 hover:underline">Download</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-gray-500">Belum ada softfile tersedia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
