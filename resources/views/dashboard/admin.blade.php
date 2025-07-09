@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6 bg-white shadow rounded">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-indigo-600">Manajemen Softfile</h2>
            <a href="{{ route('admin.create') }}"
                class="bg-indigo-600 text-black px-4 py-2 rounded hover:bg-indigo-700 transition">
                + Tambah Softfile
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 text-green-600 font-medium">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">#</th>
                        <th class="border px-4 py-2">Judul</th>
                        <th class="border px-4 py-2">Deskripsi</th>
                        <th class="border px-4 py-2">File</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($files as $file)
                        <tr>
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $file->title }}</td>
                            <td class="border px-4 py-2">{{ $file->description }}</td>
                            <td class="border px-4 py-2">
                                <a href="{{ asset('storage/' . $file->file_path) }}" class="text-blue-600 underline"
                                    target="_blank">Lihat File</a>
                            </td>
                            <td class="border px-4 py-2 flex space-x-2">
                                <a href="{{ route('admin.edit', $file->id) }}"
                                    class="bg-yellow-400 text-black px-3 py-1 rounded hover:bg-yellow-500">Edit</a>
                                <form action="{{ route('admin.delete', $file->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus softfile ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-black px-3 py-1 rounded hover:bg-red-600">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-4">Belum ada softfile.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
