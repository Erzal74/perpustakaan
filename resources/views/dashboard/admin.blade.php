@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-white p-4 sm:p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 sm:p-6 mb-6">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4 sm:gap-6">
                    <div class="flex items-center gap-3 sm:gap-4">
                        <div
                            class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 rounded-lg flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-800">Manajemen Koleksi Buku</h1>
                            <p class="text-gray-600 text-sm sm:text-base mt-1">Kelola koleksi digital perpustakaan Anda</p>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                        <!-- Bulk Actions Container -->
                        <div id="bulk-actions-container" class="hidden w-full sm:w-auto">
                            <div class="flex items-center gap-3 bg-blue-50 p-2 sm:p-3 rounded-lg border border-blue-100">
                                <span id="selected-count" class="text-xs sm:text-sm font-medium text-blue-800">0 item
                                    dipilih</span>
                                <button id="bulk-delete-button" type="button"
                                    class="inline-flex items-center justify-center gap-1 px-2 py-1 sm:px-3 sm:py-1.5 border border-transparent rounded-md shadow-sm text-xs font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 sm:h-4 sm:w-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <a href="{{ route('admin.softfiles.create') }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2 sm:px-6 sm:py-3 border border-transparent rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 font-medium text-sm sm:text-base">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Tambah Buku
                        </a>
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
                            <p class="text-gray-600 text-sm sm:text-base font-medium">Total Buku</p>
                            <p class="text-2xl sm:text-3xl font-bold text-gray-800">{{ $files->count() }}</p>
                        </div>
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6 text-blue-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-4 sm:p-6">
                    <form action="{{ route('admin.search') }}" method="GET">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}"
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-white shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Cari judul buku, pengarang...">
                            <div class="absolute inset-y-0 right-0 flex items-center">
                                @if (request('search'))
                                    <button type="button" onclick="window.location.href='{{ route('admin.index') }}'"
                                        class="mr-2 text-gray-400 hover:text-gray-600">
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm font-medium">
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
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Buku</h3>
                    <p class="text-gray-600 text-sm mt-1">Kelola koleksi buku digital Anda</p>
                </div>

                <div class="overflow-x-auto">
                    <form id="bulk-form" method="POST" action="{{ route('admin.softfiles.bulk') }}">
                        @csrf
                        @method('DELETE')
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <!-- Kolom Checkbox -->
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-10">
                                        <input type="checkbox" id="select-all"
                                            class="h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                    </th>

                                    <!-- Kolom NO -->
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                        NO
                                    </th>

                                    <!-- Kolom Judul Buku -->
                                    <th scope="col"
                                        class="px-4 sm:px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px] sm:min-w-[300px]">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('sort') === 'title' && request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center justify-between group hover:text-gray-700">
                                            <span>Judul Buku</span>
                                            <span class="ml-2 flex flex-col items-center">
                                                <svg class="h-3 w-3 @if (request('sort') === 'title' && request('direction') === 'asc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                </svg>
                                                <svg class="h-3 w-3 @if (request('sort') === 'title' && request('direction') === 'desc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </span>
                                        </a>
                                    </th>

                                    <!-- Kolom Pengarang -->
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'author', 'direction' => request('sort') === 'author' && request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center justify-between group hover:text-gray-700">
                                            <span>Pengarang</span>
                                            <span class="ml-2 flex flex-col items-center">
                                                <svg class="h-3 w-3 @if (request('sort') === 'author' && request('direction') === 'asc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                </svg>
                                                <svg class="h-3 w-3 @if (request('sort') === 'author' && request('direction') === 'desc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </span>
                                        </a>
                                    </th>

                                    <!-- Kolom Edisi -->
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                        Edisi
                                    </th>

                                    <!-- Kolom Genre -->
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                        Genre
                                    </th>

                                    <!-- Kolom Penerbit -->
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'publisher', 'direction' => request('sort') === 'publisher' && request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center justify-between group hover:text-gray-700">
                                            <span>Penerbit</span>
                                            <span class="ml-2 flex flex-col items-center">
                                                <svg class="h-3 w-3 @if (request('sort') === 'publisher' && request('direction') === 'asc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                </svg>
                                                <svg class="h-3 w-3 @if (request('sort') === 'publisher' && request('direction') === 'desc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </span>
                                        </a>
                                    </th>

                                    <!-- Kolom Tahun -->
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">
                                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'publication_year', 'direction' => request('sort') === 'publication_year' && request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                            class="flex items-center justify-between group hover:text-gray-700">
                                            <span>Tahun</span>
                                            <span class="ml-2 flex flex-col items-center">
                                                <svg class="h-3 w-3 @if (request('sort') === 'publication_year' && request('direction') === 'asc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M5 15l7-7 7 7" />
                                                </svg>
                                                <svg class="h-3 w-3 @if (request('sort') === 'publication_year' && request('direction') === 'desc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </span>
                                        </a>
                                    </th>

                                    <!-- Kolom File -->
                                    <th scope="col"
                                        class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        File
                                    </th>

                                    <!-- Kolom Aksi -->
                                    <th scope="col"
                                        class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($files as $file)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <!-- Checkbox per baris -->
                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="ids[]" value="{{ $file->id }}"
                                                class="item-checkbox h-4 w-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ ($files->currentPage() - 1) * $files->perPage() + $loop->iteration }}</td>

                                        <td class="px-4 sm:px-6 py-4 min-w-[200px] sm:min-w-[300px]">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="w-8 h-8 sm:w-10 sm:h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="font-medium text-gray-900 truncate"
                                                        title="{{ $file->title }}">
                                                        {{ $file->title }}
                                                    </p>
                                                    <p class="text-xs text-gray-500 mt-1 sm:hidden">
                                                        {{ $file->author ?? '-' }}</p>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-4 py-4 text-sm text-gray-700 hidden sm:table-cell">
                                            <div class="max-w-[120px] truncate">{{ $file->author ?? '-' }}</div>
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 hidden md:table-cell">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs">
                                                {{ $file->edition ?? '-' }}
                                            </span>
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700 hidden lg:table-cell">
                                            @if ($file->genre)
                                                <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded-full text-xs">
                                                    {{ $file->genre }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-4 text-sm text-gray-700 hidden lg:table-cell">
                                            <div class="max-w-[120px] truncate">{{ $file->publisher ?? '-' }}</div>
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap hidden sm:table-cell">
                                            @if ($file->publication_year)
                                                <span
                                                    class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                    {{ $file->publication_year }}
                                                </span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap">
                                            <button data-id="{{ $file->id }}"
                                                data-token="{{ $file->preview_token }}"
                                                class="preview-button inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 text-sm">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <span class="sr-only">Preview</span>
                                            </button>
                                        </td>

                                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-center gap-1 sm:gap-2">
                                                <a href="{{ route('admin.softfiles.edit', $file->id) }}"
                                                    class="text-blue-600 hover:text-blue-900 p-1 sm:p-2 rounded-md hover:bg-blue-50 transition-colors"
                                                    title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>

                                                <form action="{{ route('admin.softfiles.destroy', $file->id) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" onclick="confirmDelete(this)"
                                                        class="text-red-600 hover:text-red-900 p-1 sm:p-2 rounded-md hover:bg-red-50 transition-colors"
                                                        title="Hapus">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-4 w-4 sm:h-5 sm:w-5" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="12" class="px-6 py-16 text-center">
                                            <div class="flex flex-col items-center justify-center">
                                                <div
                                                    class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                    </svg>
                                                </div>
                                                <h3 class="text-lg font-medium text-gray-800 mb-2">Belum ada buku</h3>
                                                <p class="text-gray-500 mb-4">Mulai dengan menambahkan buku pertama Anda
                                                </p>
                                                <a href="{{ route('admin.softfiles.create') }}"
                                                    class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 sm:px-6 sm:py-2 rounded-lg font-medium text-sm sm:text-base">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M12 4v16m8-8H4" />
                                                    </svg>
                                                    Tambah Buku
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </form>
                </div>

                <!-- Pagination -->
                @if ($files->hasPages())
                    <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                        {{ $files->withQueryString()->links() }}
                    </div>
                @endif

                <!-- Modal untuk Preview -->
                <div id="preview-modal"
                    class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden z-50">
                    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl max-h-[90vh] overflow-auto">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h2 id="preview-title" class="text-xl font-bold"></h2>
                                <button id="close-preview" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <div id="preview-content" class="overflow-auto"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Bulk actions functionality
            const bulkActionsContainer = document.getElementById('bulk-actions-container');
            const bulkDeleteBtn = document.getElementById('bulk-delete-button');
            const bulkForm = document.getElementById('bulk-form');
            const selectAllCheckbox = document.getElementById('select-all');
            const selectedCount = document.getElementById('selected-count');
            const previewModal = document.getElementById('preview-modal');
            const previewTitle = document.getElementById('preview-title');
            const previewContent = document.getElementById('preview-content');
            const closePreview = document.getElementById('close-preview');

            function updateBulkUI() {
                const checkboxes = document.querySelectorAll('input.item-checkbox[name="ids[]"]');
                const checked = document.querySelectorAll('input.item-checkbox[name="ids[]"]:checked');

                selectedCount.textContent = `${checked.length} item dipilih`;
                bulkActionsContainer.classList.toggle('hidden', checked.length === 0);

                selectAllCheckbox.checked = checked.length === checkboxes.length;
                selectAllCheckbox.indeterminate = checked.length > 0 && checked.length < checkboxes.length;
            }

            selectAllCheckbox.addEventListener('change', function() {
                const isChecked = this.checked;
                document.querySelectorAll('input.item-checkbox[name="ids[]"]').forEach(checkbox => {
                    checkbox.checked = isChecked;
                });
                updateBulkUI();
            });

            document.addEventListener('change', function(e) {
                if (e.target && e.target.matches('input.item-checkbox[name="ids[]"]')) {
                    updateBulkUI();
                }
            });

            bulkDeleteBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const checked = document.querySelectorAll('input.item-checkbox[name="ids[]"]:checked');

                if (checked.length === 0) {
                    alert('Pilih setidaknya satu item untuk dihapus.');
                    return;
                }

                if (confirm(`Anda yakin ingin menghapus ${checked.length} item yang dipilih?`)) {
                    bulkForm.submit();
                }
            });

            // Preview functionality
            document.querySelectorAll('.preview-button').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    const id = this.dataset.id;
                    const token = this.dataset.token;

                    fetch(`{{ route('admin.softfiles.preview', ['id' => ':id']) }}?token=${token}`
                            .replace(':id', id), {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                alert(data.error);
                                return;
                            }

                            previewTitle.textContent = `Preview: ${data.filename || 'File'}`;
                            previewContent.innerHTML = data.html;
                            previewModal.classList.remove('hidden');
                        })
                        .catch(error => {
                            console.error('Error fetching preview:', error);
                            alert('Gagal memuat pratinjau: ' + error.message);
                        });
                });
            });

            closePreview.addEventListener('click', function() {
                previewModal.classList.add('hidden');
                previewContent.innerHTML = '';
                previewTitle.textContent = '';
            });

            // Close modal when clicking outside
            previewModal.addEventListener('click', function(e) {
                if (e.target === previewModal) {
                    previewModal.classList.add('hidden');
                    previewContent.innerHTML = '';
                    previewTitle.textContent = '';
                }
            });

            function confirmDelete(formButton) {
                if (confirm('Yakin ingin menghapus buku ini?')) {
                    const form = formButton.closest('form');
                    if (form) {
                        form.submit();
                    }
                }
            }

            function dismissNotification(id) {
                document.getElementById(id).remove();
            }
        });
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

        /* Pagination styling */
        .pagination {
            @apply flex items-center justify-between;
        }

        .pagination .page-item {
            @apply mx-1;
        }

        .pagination .page-link {
            @apply px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50;
        }

        .pagination .active .page-link {
            @apply bg-blue-600 text-white border-blue-600;
        }

        .pagination .disabled .page-link {
            @apply text-gray-400 bg-gray-100 cursor-not-allowed;
        }
    </style>
@endpush
