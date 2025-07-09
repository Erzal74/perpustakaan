@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6 bg-white shadow rounded">
        <h2 class="text-2xl font-bold text-indigo-600 mb-6">Manajemen User</h2>

        @if (session('success'))
            <div class="mb-4 text-green-600 font-medium">
                {{ session('success') }}
            </div>
        @endif

        {{-- Pending Approval --}}
        <h3 class="text-lg font-semibold text-gray-700 mb-3">User Menunggu Persetujuan</h3>
        <div class="overflow-x-auto mb-6">
            <table class="min-w-full bg-white border rounded">
                <thead class="bg-yellow-100">
                    <tr>
                        <th class="border px-4 py-2">#</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pendingUsers as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2 space-x-2">
                                <form action="{{ route('superadmin.approve', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-green-500 text-black py-1 rounded hover:bg-green-600">
                                        Setujui
                                    </button>
                                </form>
                                <form action="{{ route('superadmin.reject', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-black py-1 rounded hover:bg-red-600">
                                        Tolak
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-4">
                                Tidak ada user yang menunggu persetujuan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Approved Users --}}
        <h3 class="text-lg font-semibold text-gray-700 mb-3">User Aktif</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border rounded">
                <thead class="bg-green-100">
                    <tr>
                        <th class="border px-4 py-2">#</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($approvedUsers as $user)
                        <tr>
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2">{{ $user->name }}</td>
                            <td class="border px-4 py-2">{{ $user->email }}</td>
                            <td class="border px-4 py-2">
                                <form action="{{ route('superadmin.disable', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-gray-700 text-black py-1 rounded hover:bg-gray-800">
                                        Nonaktifkan
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-4">
                                Belum ada user aktif.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
