@extends('layouts.app')

@section('content')
    @php $role = Auth::user()->role; @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h2 class="text-3xl font-bold mb-8 text-indigo-600">
            @if ($role === 'user')
                Daftar Softfile
            @elseif ($role === 'admin')
                Manajemen Softfile
            @elseif ($role === 'superadmin')
                Manajemen User
            @endif
        </h2>

        {{-- USER: Daftar Softfile --}}
        @if ($role === 'user')
            <form method="GET" class="mb-6">
                <input type="text" name="q" placeholder="Cari judul, penulis, atau penerbit"
                    value="{{ request('q') }}"
                    class="w-full sm:w-96 px-4 py-2 rounded border border-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse ($files as $file)
                    <div class="bg-white p-4 rounded shadow border hover:shadow-lg transition">
                        <h3 class="text-lg font-semibold text-indigo-700">{{ $file->title }}</h3>
                        <p class="text-sm text-gray-600">Penulis: {{ $file->author }}</p>
                        <p class="text-sm text-gray-600">Penerbit: {{ $file->publisher }}</p>
                        <p class="text-sm text-gray-600">Tahun: {{ $file->publication_year }}</p>
                        <div class="mt-4 flex justify-between text-sm">
                            <a href="{{ route('user.preview', $file) }}"
                               class="text-blue-600 hover:underline">Preview</a>
                            <a href="{{ route('user.download', $file) }}"
                               class="text-green-600 hover:underline">Download</a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-full">Tidak ada file ditemukan.</p>
                @endforelse
            </div>

            <div class="mt-6">
                {{ $files->links() }}
            </div>

        {{-- ADMIN: Manajemen Softfile --}}
        @elseif ($role === 'admin')
            <div class="mb-6">
                <a href="{{ route('admin.create') }}"
                   class="inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">+ Tambah Softfile</a>
            </div>

            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Judul</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Penulis</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tahun</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($files as $file)
                            <tr>
                                <td class="px-4 py-2">{{ $file->title }}</td>
                                <td class="px-4 py-2">{{ $file->author }}</td>
                                <td class="px-4 py-2">{{ $file->publication_year }}</td>
                                <td class="px-4 py-2 space-x-2">
                                    <a href="{{ route('admin.edit', $file) }}"
                                       class="text-indigo-600 hover:underline">Edit</a>
                                    <form action="{{ route('admin.destroy', $file) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        {{-- SUPERADMIN: Manajemen User --}}
        @elseif ($role === 'superadmin')
            <div class="overflow-x-auto bg-white rounded shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-indigo-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Nama</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Role</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($users as $user)
                            <tr>
                                <td class="px-4 py-2">{{ $user->name }}</td>
                                <td class="px-4 py-2">{{ $user->email }}</td>
                                <td class="px-4 py-2 capitalize">{{ $user->role }}</td>
                                <td class="px-4 py-2">
                                    @if ($user->is_approved)
                                        <span class="text-green-600 font-medium">Aktif</span>
                                    @else
                                        <span class="text-yellow-600 font-medium">Belum Disetujui</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 space-x-2">
                                    @if (!$user->is_approved)
                                        <form action="{{ route('superadmin.approve', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="text-blue-600 hover:underline">Setujui</button>
                                        </form>
                                        <form action="{{ route('superadmin.reject', $user->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Tolak</button>
                                        </form>
                                    @else
                                        @if ($user->is_disabled)
                                            <form action="{{ route('superadmin.enable', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="text-green-600 hover:underline">Aktifkan</button>
                                            </form>
                                        @else
                                            <form action="{{ route('superadmin.disable', $user->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button class="text-yellow-600 hover:underline">Nonaktifkan</button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
