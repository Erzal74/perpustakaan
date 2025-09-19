@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 p-4 md:p-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900">Koleksi Digital Perpustakaan</h1>
                            <p class="text-gray-600 mt-1 text-sm">Temukan dan unduh koleksi digital terbaik</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden md:flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-600">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-green-50 px-4 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium text-green-600">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-8">
                <form method="GET" action="{{ route('user.index') }}" class="flex flex-col md:flex-row gap-4"
                    id="searchForm">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="searchInput"
                            placeholder="Cari judul, pengarang, atau penerbit..." value="{{ request('search') }}"
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                    </div>
                    <div class="flex gap-3">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>
                        <a href="{{ route('user.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Data Section -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Daftar Buku</h3>
                            <p class="text-gray-600 mt-1 text-sm">Temukan koleksi buku digital</p>
                        </div>
                    </div>
                </div>

                <!-- Desktop Table View -->
                <div class="hidden md:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                    NO
                                </th>
                                <th scope="col"
                                    class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
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
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
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
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-20">
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
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
                                    ISBN
                                </th>
                                <th scope="col"
                                    class="px-4 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-36">
                                    ISSN
                                </th>
                                <th scope="col"
                                    class="px-6 py-3.5 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                                    Ukuran
                                </th>
                                <th scope="col"
                                    class="px-4 py-3.5 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-64">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200" id="softfileTable">
                            @forelse ($files as $file)
                                <tr
                                    class="{{ $loop->odd ? 'bg-gray-50' : 'bg-white' }} hover:bg-gray-100 transition-colors duration-300 rounded-lg">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ ($files->currentPage() - 1) * $files->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if (strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)) === 'pdf') bg-red-100 text-red-800
                                        @elseif (in_array(strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) bg-blue-100 text-blue-800
                                        @elseif (in_array(strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)), ['doc', 'docx'])) bg-green-100 text-green-800
                                        @elseif (strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)) === 'csv') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                                {{ strtoupper(pathinfo($file->file_path, PATHINFO_EXTENSION)) }}
                                            </span>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <p class="font-medium text-gray-900 whitespace-nowrap overflow-hidden text-ellipsis"
                                                        title="{{ $file->title }}">
                                                        {{ $file->title }}
                                                    </p>
                                                    @if (now()->diffInDays($file->created_at) <= 30)
                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                            </svg>
                                                            Baru
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-[150px]">
                                            <p class="truncate">{{ $file->author ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-[140px]">
                                            <p class="truncate">{{ $file->publisher ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        @if ($file->publication_year)
                                            <span
                                                class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                {{ $file->publication_year }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-[140px]">
                                            <p class="truncate">{{ $file->isbn ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-[140px]">
                                            <p class="truncate">{{ $file->issn ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        @if (Storage::disk('public')->exists($file->file_path))
                                            <span>{{ \App\Http\Controllers\UserController::formatBytes(Storage::disk('public')->size($file->file_path)) }}</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm space-x-3 text-center">
                                        <a href="{{ route('user.preview', ['id' => $file->id, 'token' => $file->preview_token]) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Detail
                                        </a>
                                        <a href="{{ route('user.show-file', ['id' => $file->id, 'token' => $file->preview_token]) }}"
                                            target="_blank"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 0118 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Preview
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-800 mb-2">Belum ada buku</h3>
                                            <p class="text-gray-500 text-sm">Silakan gunakan fitur pencarian untuk
                                                menemukan buku</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card View -->
                <div class="md:hidden" id="mobileCardContainer">
                    @forelse ($files as $file)
                        <div class="p-6 border-b border-gray-200 last:border-b-0">
                            <div class="flex items-start gap-4 mb-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if (strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)) === 'pdf') bg-red-100 text-red-800
                            @elseif (in_array(strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) bg-blue-100 text-blue-800
                            @elseif (in_array(strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)), ['doc', 'docx'])) bg-green-100 text-green-800
                            @elseif (strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION)) === 'csv') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                                    {{ strtoupper(pathinfo($file->file_path, PATHINFO_EXTENSION)) }}
                                </span>
                                @if (now()->diffInDays($file->created_at) <= 30)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        Baru
                                    </span>
                                @endif
                            </div>
                            <div class="mb-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $file->title }}</h3>
                            </div>
                            <div class="space-y-3 mb-4">
                                <div class="grid grid-cols-1 gap-3">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500">Pengarang</span>
                                        <span class="text-sm text-gray-900">{{ $file->author ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500">Penerbit</span>
                                        <span class="text-sm text-gray-900">{{ $file->publisher ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500">Tahun</span>
                                        <span class="text-sm text-gray-900">
                                            @if ($file->publication_year)
                                                <span class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">{{ $file->publication_year }}</span>
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500">ISBN</span>
                                        <span class="text-sm text-gray-900">{{ $file->isbn ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500">ISSN</span>
                                        <span class="text-sm text-gray-900">{{ $file->issn ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm font-medium text-gray-500">Ukuran</span>
                                        <span class="text-sm text-gray-900">
                                            @if (Storage::disk('public')->exists($file->file_path))
                                                {{ \App\Http\Controllers\UserController::formatBytes(Storage::disk('public')->size($file->file_path)) }}
                                            @else
                                                -
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('user.preview', ['id' => $file->id, 'token' => $file->preview_token]) }}"
                                    class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Lihat Detail
                                </a>
                                <a href="{{ route('user.show-file', ['id' => $file->id, 'token' => $file->preview_token]) }}"
                                    target="_blank"
                                    class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 0118 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Preview File
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="p-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-800 mb-2">Belum ada buku</h3>
                                <p class="text-gray-500 text-sm">Silakan gunakan fitur pencarian untuk menemukan buku</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                        <div class="text-sm text-gray-700">
                            Menampilkan {{ $files->firstItem() ?? 0 }} - {{ $files->lastItem() ?? 0 }} dari
                            {{ $files->total() }} hasil
                        </div>
                        <div class="pagination-wrapper">
                            {{ $files->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const searchInput = document.getElementById('searchInput');
            const tableBody = document.getElementById('softfileTable');
            const mobileCardContainer = document.getElementById('mobileCardContainer');

            // AJAX Live Search
            searchInput.addEventListener('input', function() {
                const keyword = this.value;
                const currentUrl = new URL(window.location.href);
                const params = new URLSearchParams(currentUrl.search);
                const sort = params.get('sort');
                const direction = params.get('direction');

                // Add loading state
                if (keyword.length > 0) {
                    // Desktop loading
                    tableBody.innerHTML = `
                        <tr>
                            <td colspan="9" class="text-center py-8">
                                <div class="flex items-center justify-center space-x-2">
                                    <div class="animate-spin rounded-full h-6 w-6 border-t-2 border-blue-600"></div>
                                    <span class="text-gray-600">Mencari...</span>
                                </div>
                            </td>
                        </tr>
                    `;
                    
                    // Mobile loading
                    mobileCardContainer.innerHTML = `
                        <div class="p-12 text-center">
                            <div class="flex items-center justify-center space-x-2">
                                <div class="animate-spin rounded-full h-6 w-6 border-t-2 border-blue-600"></div>
                                <span class="text-gray-600">Mencari...</span>
                            </div>
                        </div>
                    `;
                }

                fetch(
                        `{{ route('user.search') }}?search=${encodeURIComponent(keyword)}&sort=${sort || ''}&direction=${direction || ''}`
                    )
                    .then(res => res.json())
                    .then(data => {
                        tableBody.innerHTML = '';
                        mobileCardContainer.innerHTML = '';
                        
                        if (data.length === 0) {
                            // Desktop empty state
                            tableBody.innerHTML = `
                                <tr>
                                    <td colspan="9" class="text-center py-12">
                                        <div class="flex flex-col items-center space-y-4">
                                            <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <div class="text-center">
                                                <p class="text-gray-500 text-lg font-medium">Tidak ada hasil ditemukan</p>
                                                <p class="text-gray-400 text-sm">Coba gunakan kata kunci yang berbeda</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            `;
                            
                            // Mobile empty state
                            mobileCardContainer.innerHTML = `
                                <div class="p-12 text-center">
                                    <div class="flex flex-col items-center space-y-4">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        <div class="text-center">
                                            <p class="text-gray-500 text-lg font-medium">Tidak ada hasil ditemukan</p>
                                            <p class="text-gray-400 text-sm">Coba gunakan kata kunci yang berbeda</p>
                                        </div>
                                    </div>
                                </div>
                            `;
                            return;
                        }

                        data.forEach((item, index) => {
                            const newBadge = new Date(item.created_at) > new Date(Date.now() - 30 * 24 * 60 * 60 * 1000) ? `
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Baru
                                </span>
                            ` : '';

                            const fileBadgeClass = item.file_extension === 'pdf' ?
                                'bg-red-100 text-red-800' : ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(
                                    item.file_extension) ? 'bg-blue-100 text-blue-800' : ['doc', 'docx']
                                .includes(item.file_extension) ? 'bg-green-100 text-green-800' : ['csv']
                                .includes(item.file_extension) ? 'bg-yellow-100 text-yellow-800' :
                                'bg-gray-100 text-gray-800';

                            // Desktop table row
                            const tableRow = `
                                <tr class="${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'} hover:bg-gray-100 transition-colors duration-300 rounded-lg">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-600">
                                        ${index + 1}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${fileBadgeClass}">
                                                ${item.file_extension.toUpperCase()}
                                            </span>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <p class="font-medium text-gray-900 whitespace-nowrap overflow-hidden text-ellipsis"
                                                        title="${item.title}">
                                                        ${item.title}
                                                    </p>
                                                    ${newBadge}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-[150px]">
                                            <p class="truncate">${item.author ?? '-'}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-[140px]">
                                            <p class="truncate">${item.publisher ?? '-'}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        ${item.publication_year ?
                                            `<span class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">${item.publication_year}</span>` :
                                            '<span class="text-gray-400">-</span>'}
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-[140px]">
                                            <p class="truncate">${item.isbn ?? '-'}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-[140px]">
                                            <p class="truncate">${item.issn ?? '-'}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-700">
                                        ${item.file_size ?
                                            `<span>${item.file_size}</span>` :
                                            '<span class="text-gray-400">-</span>'}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm space-x-3 text-center">
                                        <a href="/dashboard/user/preview/${item.id}?token=${item.preview_token}"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Detail
                                        </a>
                                        <a href="/dashboard/user/show-file/${item.id}?token=${item.preview_token}"
                                            target="_blank"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 0118 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Preview
                                        </a>
                                    </td>
                                </tr>
                            `;

                            // Mobile card
                            const mobileCard = `
                                <div class="p-6 border-b border-gray-200 last:border-b-0">
                                    <div class="flex items-start gap-4 mb-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium ${fileBadgeClass}">
                                            ${item.file_extension.toUpperCase()}
                                        </span>
                                        ${newBadge}
                                    </div>
                                    <div class="mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900 mb-2">${item.title}</h3>
                                    </div>
                                    <div class="space-y-3 mb-4">
                                        <div class="grid grid-cols-1 gap-3">
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-500">Pengarang</span>
                                                <span class="text-sm text-gray-900">${item.author ?? '-'}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-500">Penerbit</span>
                                                <span class="text-sm text-gray-900">${item.publisher ?? '-'}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-500">Tahun</span>
                                                <span class="text-sm text-gray-900">
                                                    ${item.publication_year ?
                                                        `<span class="px-2.5 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">${item.publication_year}</span>` :
                                                        '-'}
                                                </span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-500">ISBN</span>
                                                <span class="text-sm text-gray-900">${item.isbn ?? '-'}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-500">ISSN</span>
                                                <span class="text-sm text-gray-900">${item.issn ?? '-'}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-medium text-gray-500">Ukuran</span>
                                                <span class="text-sm text-gray-900">${item.file_size ?? '-'}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-col sm:flex-row gap-3">
                                        <a href="/dashboard/user/preview/${item.id}?token=${item.preview_token}"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Lihat Detail
                                        </a>
                                        <a href="/dashboard/user/show-file/${item.id}?token=${item.preview_token}"
                                            target="_blank"
                                            class="flex-1 inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 0118 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            Preview File
                                        </a>
                                    </div>
                                </div>
                            `;

                            tableBody.innerHTML += tableRow;
                            mobileCardContainer.innerHTML += mobileCard;
                        });
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        
                        // Desktop error state
                        tableBody.innerHTML = `
                            <tr>
                                <td colspan="9" class="text-center py-8">
                                    <div class="text-red-600">
                                        <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                        </svg>
                                        <p class="text-lg font-medium">Terjadi kesalahan</p>
                                        <p class="text-sm">Silakan coba lagi</p>
                                    </div>
                                </td>
                            </tr>
                        `;
                        
                        // Mobile error state
                        mobileCardContainer.innerHTML = `
                            <div class="p-12 text-center">
                                <div class="text-red-600">
                                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                    <p class="text-lg font-medium">Terjadi kesalahan</p>
                                    <p class="text-sm">Silakan coba lagi</p>
                                </div>
                            </div>
                        `;
                    });
            });
        </script>

        <style>
            /* Custom table styling */
            table {
                border-collapse: separate;
                border-spacing: 0;
            }

            th,
            td {
                align-items: center;
                vertical-align: middle;
            }

            /* Custom badge styling */
            .inline-flex {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            /* Custom pagination styling */
            .pagination-wrapper .pagination {
                @apply flex items-center space-x-1;
            }

            .pagination-wrapper .pagination li {
                @apply list-none;
            }

            .pagination-wrapper .pagination li a,
            .pagination-wrapper .pagination li span {
                @apply px-3 py-2 text-sm font-medium rounded-lg transition-all duration-300;
            }

            .pagination-wrapper .pagination li a {
                @apply text-gray-600 hover:text-blue-600 hover:bg-blue-50 border border-gray-200 hover:border-blue-300;
            }

            .pagination-wrapper .pagination li.active span {
                @apply bg-blue-600 text-white border-transparent shadow-md;
            }

            .pagination-wrapper .pagination li.disabled span {
                @apply text-gray-400 cursor-not-allowed border-gray-200 opacity-50;
            }

            /* Loading animation */
            @keyframes spin {
                to {
                    transform: rotate(360deg);
                }
            }

            .animate-spin {
                animation: spin 1s linear infinite;
            }

            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 6px;
                height: 6px;
            }

            ::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb {
                background: #c1c1c1;
                border-radius: 4px;
            }

            ::-webkit-scrollbar-thumb:hover {
                background: #a1a1a1;
            }

            /* Mobile responsive improvements */
            @media (max-width: 767px) {
                .pagination-wrapper .pagination {
                    @apply flex-wrap justify-center;
                }
                
                .pagination-wrapper .pagination li a,
                .pagination-wrapper .pagination li span {
                    @apply px-2 py-1 text-xs;
                }
            }
        </style>
    @endpush
@endsection