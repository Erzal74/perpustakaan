@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-white p-4 sm:p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 sm:p-6 mb-6">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 sm:gap-6">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-indigo-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Admin & Superadmin Management</h1>
                            <p class="text-gray-600 text-sm sm:text-base mt-1">Kelola akses dan peran administrator sistem
                            </p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <a href="{{ route('superadmin.dashboard') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:px-6 sm:py-3 border border-gray-300 rounded-lg shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 font-medium text-sm sm:text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Dashboard
                        </a>
                        <button onclick="openCreateAdminModal()"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:px-6 sm:py-3 border border-transparent rounded-lg shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200 font-medium text-sm sm:text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Admin/Superadmin
                        </button>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            @if (session('success'))
                <div id="success-notification"
                    class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg animate-fade-in">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                        <button onclick="dismissNotification('success-notification')"
                            class="text-green-500 hover:text-green-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div id="error-notification" class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg animate-fade-in">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-red-700 font-medium">{{ session('error') }}</p>
                        </div>
                        <button onclick="dismissNotification('error-notification')" class="text-red-500 hover:text-red-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            @endif

            <!-- Stats and Search -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Stats Card -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 sm:p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm sm:text-base font-medium">Total Admin</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $admins->count() }}</p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-indigo-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 sm:p-6">
                    <form action="{{ route('superadmin.admins.list') }}" method="GET">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                placeholder="Cari nama admin, email...">
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                @if (request('search'))
                                    <button type="button"
                                        onclick="window.location.href='{{ route('superadmin.admins.list') }}'"
                                        class="mr-2 text-gray-400 hover:text-gray-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                                <button type="submit"
                                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm font-medium">
                                    Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="px-4 py-4 sm:px-6 sm:py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Administrator</h3>
                    <p class="text-gray-600 text-sm mt-1">Kelola akses dan peran administrator sistem</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                    NO
                                </th>
                                <th scope="col"
                                    class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[250px]">
                                    Admin
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                    Email
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($admins as $admin)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 min-w-[250px]">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center flex-shrink-0
                                                {{ $admin->role === 'superadmin' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }} font-medium">
                                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="font-medium text-gray-900 truncate"
                                                    title="{{ $admin->name }}">
                                                    {{ $admin->name }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1">
                                                    Terdaftar: {{ $admin->created_at->diffForHumans() }}
                                                </p>
                                                <p class="text-xs text-gray-500 mt-1 sm:hidden">
                                                    {{ $admin->email }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-4 py-4 text-sm text-gray-700 hidden sm:table-cell">
                                        <div class="max-w-[200px] truncate">{{ $admin->email }}</div>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if ($admin->role === 'superadmin')
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                                Superadmin
                                            </span>
                                        @else
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Admin
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 text-xs font-semibold rounded-full
                                            {{ $admin->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $admin->status === 'approved' ? 'Aktif' : 'Nonaktif' }}
                                        </span>
                                    </td>

                                    <td class="px-4 py-4 whitespace-nowrap text-center text-sm font-medium">
                                        <div class="flex justify-center gap-1 sm:gap-2">
                                            @if ($admin->id !== Auth::id())
                                                @if ($admin->status === 'approved')
                                                    <form action="{{ route('superadmin.disable', $admin->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="button"
                                                            onclick="confirmAction(this, 'nonaktifkan')"
                                                            class="text-red-600 hover:text-red-900 p-1 sm:p-2 rounded-md hover:bg-red-50 transition-colors"
                                                            title="Nonaktifkan">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('superadmin.enable', $admin->id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        <button type="button" onclick="confirmAction(this, 'aktifkan')"
                                                            class="text-green-600 hover:text-green-900 p-1 sm:p-2 rounded-md hover:bg-green-50 transition-colors"
                                                            title="Aktifkan">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
                                            @else
                                                <span class="px-2 py-1 text-xs text-gray-500 bg-gray-100 rounded-full">
                                                    Current User
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-800 mb-2">Belum ada admin</h3>
                                            <p class="text-gray-500 mb-4">Mulai dengan menambahkan admin pertama</p>
                                            <button onclick="openCreateAdminModal()"
                                                class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 sm:px-6 sm:py-2 rounded-lg font-medium text-sm sm:text-base">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v16m8-8H4" />
                                                </svg>
                                                Tambah Admin
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create Admin Modal -->
    <div id="createAdminModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title"
        role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('superadmin.create-admin') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Tambah Admin/Superadmin baru
                                    <div class="mt-4 space-y-4">
                                        <div>
                                            <label for="name" class="block text-sm font-medium text-gray-700">Nama
                                                Lengkap</label>
                                            <input type="text" name="name" id="name" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="email"
                                                class="block text-sm font-medium text-gray-700">Email</label>
                                            <input type="email" name="email" id="email" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="password"
                                                class="block text-sm font-medium text-gray-700">Password</label>
                                            <input type="password" name="password" id="password" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                        </div>
                                        <div>
                                            <label for="role"
                                                class="block text-sm font-medium text-gray-700">Role</label>
                                            <select name="role" id="role" required
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                <option value="admin">Admin</option>
                                                <option value="superadmin">Superadmin</option>
                                            </select>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Tambah
                        </button>
                        <button type="button" onclick="closeCreateAdminModal()"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function openCreateAdminModal() {
            document.getElementById('createAdminModal').classList.remove('hidden');
        }

        function closeCreateAdminModal() {
            document.getElementById('createAdminModal').classList.add('hidden');
        }

        function confirmAction(formButton, action) {
            if (confirm(`Yakin ingin ${action} admin ini?`)) {
                formButton.closest('form').submit();
            }
        }

        function dismissNotification(id) {
            document.getElementById(id).remove();
        }
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@endpush
