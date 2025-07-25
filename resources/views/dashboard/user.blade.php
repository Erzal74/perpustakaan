@extends('layouts.app')

@section('content')
    @php
        if (!function_exists('formatFileSize')) {
            function formatFileSize($bytes, $precision = 2)
            {
                $units = ['B', 'KB', 'MB', 'GB', 'TB'];

                if ($bytes <= 0) {
                    return '0 B';
                }

                $pow = floor(log($bytes) / log(1024));
                $pow = min($pow, count($units) - 1);

                $size = $bytes / 1024 ** $pow;

                return round($size, $precision) . ' ' . $units[$pow];
            }
        }
    @endphp
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-blue-50 p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-8 backdrop-blur-sm bg-white/80">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">Koleksi Digital Perpustakaan</h1>
                            <p class="text-gray-600 mt-1">Temukan dan unduh koleksi digital terbaik</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div
                            class="hidden md:flex items-center gap-2 bg-blue-50 px-4 py-2.5 rounded-xl border border-blue-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-700">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-green-50 px-4 py-2.5 rounded-xl border border-green-100">
                            <div class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></div>
                            <span class="text-sm font-medium text-green-700">Online</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Books -->
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Buku</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $files->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span class="text-green-600 font-medium">{{ $newBooksThisMonth }}</span>
                        <span class="text-gray-500 ml-1">baru bulan ini</span>
                    </div>
                </div>

                <!-- Most Popular Book -->
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-gray-600 text-sm font-medium">Buku Terpopuler</p>
                            <p class="text-lg font-bold text-gray-900 truncate max-w-[160px] mt-1"
                                title="{{ $mostPopularBook->title ?? '-' }}">
                                {{ $mostPopularBook->title ?? '-' }}
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>
                        <span class="text-blue-600 font-medium">{{ $mostPopularBook->downloads_count ?? 0 }}</span>
                        <span class="text-gray-500 ml-1">unduhan</span>
                    </div>
                </div>

                <!-- Your Activity -->
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Aktivitas Anda</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $userDownloadsCount }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-amber-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-gray-600 text-xs">
                            {{ $lastDownloadTime ? $lastDownloadTime->diffForHumans() : 'Belum ada aktivitas' }}
                        </span>
                    </div>
                </div>

                <!-- Monthly Downloads -->
                <div
                    class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 hover:shadow-md transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Unduhan Bulan Ini</p>
                            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalDownloadsThisMonth }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm">
                        @if ($downloadGrowth > 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span class="text-green-600 font-medium">+{{ abs($downloadGrowth) }}%</span>
                        @elseif($downloadGrowth < 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-red-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                            </svg>
                            <span class="text-red-600 font-medium">-{{ abs($downloadGrowth) }}%</span>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                            <span class="text-gray-600 font-medium">Stabil</span>
                        @endif
                        <span class="text-gray-500 ml-1 text-xs">dari bulan lalu</span>
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm p-6 mb-8">
                <form method="GET" action="{{ route('user.index') }}" class="flex flex-col md:flex-row gap-4"
                    id="searchForm">
                    <div class="flex-1 relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="searchInput"
                            placeholder="Cari judul, pengarang, atau penerbit..." value="{{ request('search') }}"
                            class="w-full pl-12 pr-4 py-3.5 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white">
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 border border-transparent rounded-xl shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>

                        <a href="{{ route('user.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3.5 bg-white border border-gray-300 rounded-xl shadow-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </a>
                    </div>
                </form>

                <!-- Quick Filter Chips -->
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="text-sm font-medium text-gray-700 mr-2">Filter Cepat:</span>
                    <a href="{{ route('user.index', ['filter' => 'popular']) }}"
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('filter') === 'popular' ? 'bg-purple-100 text-purple-800 border border-purple-200' : 'bg-gray-100 text-gray-700 hover:bg-purple-50 border border-gray-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Populer
                    </a>
                    <a href="{{ route('user.index', ['filter' => 'new']) }}"
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('filter') === 'new' ? 'bg-blue-100 text-blue-800 border border-blue-200' : 'bg-gray-100 text-gray-700 hover:bg-blue-50 border border-gray-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Terbaru
                    </a>
                    <a href="{{ route('user.index', ['filter' => 'recommended']) }}"
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request('filter') === 'recommended' ? 'bg-green-100 text-green-800 border border-green-200' : 'bg-gray-100 text-gray-700 hover:bg-green-50 border border-gray-200' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Rekomendasi
                    </a>
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-blue-50">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Daftar Buku</h3>
                            <p class="text-gray-600 mt-1">Temukan dan unduh koleksi buku digital</p>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            Total: {{ $files->total() }} buku
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white" id="softfileTable">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <!-- Kolom NO -->
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-16">
                                    NO
                                </th>

                                <!-- Kolom Judul Buku -->
                                <th
                                    class="px-8 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider min-w-[320px]">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('sort') === 'title' && request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center justify-between group hover:text-blue-600 transition-colors">
                                        <span>Judul Buku</span>
                                        @include('partials.sort-icons', ['field' => 'title'])
                                    </a>
                                </th>

                                <!-- Kolom Pengarang -->
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider min-w-[160px]">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'author', 'direction' => request('sort') === 'author' && request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center justify-between group hover:text-blue-600 transition-colors">
                                        <span>Pengarang</span>
                                        @include('partials.sort-icons', ['field' => 'author'])
                                    </a>
                                </th>

                                <!-- Kolom ISBN -->
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                    ISBN
                                </th>

                                <!-- Kolom ISSN -->
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                    ISSN
                                </th>

                                <!-- Kolom Format -->
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-24">
                                    Format
                                </th>

                                <!-- Kolom Ukuran -->
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-24">
                                    Ukuran
                                </th>

                                <!-- Kolom Popularitas -->
                                <th
                                    class="px-4 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider w-32">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'downloads_count', 'direction' => request('sort') === 'downloads_count' && request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center justify-between group hover:text-blue-600 transition-colors">
                                        <span>Popularitas</span>
                                        @include('partials.sort-icons', ['field' => 'downloads_count'])
                                    </a>
                                </th>

                                <!-- Kolom Aksi -->
                                <th
                                    class="px-6 py-4 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider w-52">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($files as $index => $file)
                                <tr
                                    class="{{ $loop->even ? 'bg-gray-100/100' : 'bg-white' }} hover:bg-blue-50/70 transition-all duration-200 group">
                                    <!-- Kolom NO -->
                                    <td class="px-4 py-6 whitespace-nowrap text-sm font-medium text-gray-600">
                                        {{ ($files->currentPage() - 1) * $files->perPage() + $loop->iteration }}
                                    </td>

                                    <!-- Kolom Judul Buku -->
                                    <td class="px-8 py-6">
                                        <div class="flex items-start gap-4">
                                            <div
                                                class="w-12 h-12 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg flex items-center justify-center flex-shrink-0 shadow-sm group-hover:shadow-md transition-all duration-200">
                                                @php
                                                    $extension = strtolower(
                                                        pathinfo($file->file_path, PATHINFO_EXTENSION),
                                                    );
                                                    $iconClasses = [
                                                        'pdf' => 'text-red-500',
                                                        'doc' => 'text-blue-500',
                                                        'docx' => 'text-blue-500',
                                                        'xls' => 'text-green-500',
                                                        'xlsx' => 'text-green-500',
                                                        'ppt' => 'text-orange-500',
                                                        'pptx' => 'text-orange-500',
                                                        'txt' => 'text-gray-500',
                                                        'zip' => 'text-purple-500',
                                                        'rar' => 'text-purple-500',
                                                    ];
                                                @endphp
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                    class="h-6 w-6 {{ $iconClasses[$extension] ?? 'text-gray-400' }}"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0 pr-4">
                                                <div class="flex items-start gap-3 mb-2">
                                                    <h4 class="font-semibold text-gray-900 text-base leading-relaxed line-clamp-2"
                                                        title="{{ $file->title }}">
                                                        {{ $file->title }}
                                                    </h4>
                                                    <div class="flex flex-wrap gap-1.5 flex-shrink-0">
                                                        @if ($file->downloads_count >= 50)
                                                            <span class="badge-popular">
                                                                <svg class="w-3 h-3 mr-1" fill="currentColor"
                                                                    viewBox="0 0 20 20">
                                                                    <path
                                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                                </svg>
                                                                Populer
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="flex items-center text-sm text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1.5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                                    </svg>
                                                    <span
                                                        class="font-medium">{{ number_format($file->downloads_count) }}</span>
                                                    <span class="ml-1">unduhan</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Kolom Pengarang -->
                                    <td class="px-4 py-6 text-sm">
                                        <div class="max-w-[140px]">
                                            <p class="font-medium text-gray-900 truncate"
                                                title="{{ $file->author ?? '-' }}">
                                                {{ $file->author ?? '-' }}
                                            </p>
                                        </div>
                                    </td>

                                    <!-- Kolom ISBN -->
                                    <td class="px-4 py-6 text-sm">
                                        @if ($file->isbn)
                                            <div class="badge-isbn">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                                {{ $file->isbn }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>

                                    <!-- Kolom ISSN -->
                                    <td class="px-4 py-6 text-sm">
                                        @if ($file->issn)
                                            <div class="badge-issn">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                                </svg>
                                                {{ $file->issn }}
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-xs">-</span>
                                        @endif
                                    </td>

                                    <!-- Kolom Format -->
                                    <td class="px-4 py-6 text-sm">
                                        @php
                                            $extension = strtolower(pathinfo($file->file_path, PATHINFO_EXTENSION));
                                            $badgeClasses = [
                                                'pdf' => 'badge-pdf',
                                                'doc' => 'badge-word',
                                                'docx' => 'badge-word',
                                                'xls' => 'badge-excel',
                                                'xlsx' => 'badge-excel',
                                                'ppt' => 'badge-powerpoint',
                                                'pptx' => 'badge-powerpoint',
                                                'txt' => 'badge-text',
                                                'zip' => 'badge-zip',
                                                'rar' => 'badge-zip',
                                            ];
                                        @endphp
                                        <span class="{{ $badgeClasses[$extension] ?? 'badge-default' }}">
                                            {{ strtoupper($extension) }}
                                        </span>
                                    </td>

                                    <!-- Kolom Ukuran -->
                                    <td class="px-4 py-6 text-sm">
                                        @php
                                            try {
                                                $fileSize = Storage::disk('public')->size($file->file_path);
                                                $size = formatFileSize($fileSize);
                                            } catch (\Exception $e) {
                                                $size = '-';
                                            }
                                        @endphp
                                        <span class="badge-size">{{ $size }}</span>
                                    </td>

                                    <!-- Kolom Popularitas -->
                                    <td class="px-4 py-6 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2 overflow-hidden">
                                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-300"
                                                    style="width: {{ min(100, ($file->downloads_count / max(1, $maxDownloads)) * 100) }}%">
                                                </div>
                                            </div>
                                            <span class="text-xs font-medium text-gray-600 min-w-[2rem] text-right">
                                                {{ number_format($file->downloads_count) }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Kolom Aksi -->
                                    <td class="px-6 py-6 whitespace-nowrap text-sm">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('user.detail', ['id' => $file->id, 'token' => $file->preview_token]) }}"
                                                class="btn-detail-improved" title="Lihat Detail">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('user.preview-file', $file->id) }}" target="_blank"
                                                class="btn-preview-improved" title="Preview File">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('user.download', $file->id) }}"
                                                class="btn-download-improved" title="Download File">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-16 text-center">
                                        <div class="empty-state">
                                            <div
                                                class="w-16 h-16 mx-auto mb-4 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada buku</h3>
                                            <p class="text-gray-500">Silakan gunakan fitur pencarian untuk menemukan buku
                                                yang Anda cari</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-700">
                            <span class="font-medium">Menampilkan {{ $files->firstItem() ?? 0 }} -
                                {{ $files->lastItem() ?? 0 }}</span>
                            dari <span class="font-medium">{{ number_format($files->total()) }}</span> hasil
                        </div>
                        <div class="pagination-wrapper">
                            {{ $files->links() }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommended For You Section -->
            @if ($recommendedBooks->count() > 0)
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden mt-8">
                    <div class="p-6 border-b border-gray-200 bg-gradient-to-r from-green-50 to-blue-50">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Rekomendasi Untuk Anda</h3>
                                <p class="text-gray-600 mt-1">Buku yang mungkin Anda sukai berdasarkan aktivitas Anda</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
                        @foreach ($recommendedBooks as $file)
                            <div
                                class="bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 group">
                                <div class="p-5">
                                    <div
                                        class="flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 h-32 rounded-lg mb-4 group-hover:shadow-md transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 mb-2 leading-tight"
                                        title="{{ $file->title }}">
                                        {{ Str::limit($file->title, 40) }}
                                    </h4>
                                    <p class="text-sm text-gray-500 mb-4"
                                        title="{{ $file->author ?? 'Penulis tidak diketahui' }}">
                                        {{ Str::limit($file->author ?? 'Penulis tidak diketahui', 30) }}
                                    </p>
                                    <div class="flex justify-between items-center">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('user.detail', ['id' => $file->id, 'token' => $file->preview_token]) }}"
                                                class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors px-2 py-1 rounded hover:bg-blue-50">
                                                Lihat
                                            </a>
                                            <a href="{{ route('user.download', $file->id) }}"
                                                class="text-green-600 hover:text-green-800 text-sm font-medium transition-colors px-2 py-1 rounded hover:bg-green-50">
                                                Unduh
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('styles')
    <style>
        /* Modern Badge Styles */
        .badge-popular {
            @apply inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200;
        }

        .badge-new {
            @apply inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200;
        }

        .badge-isbn {
            @apply inline-flex items-center px-2.5 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-xs font-medium border border-blue-200;
        }

        .badge-issn {
            @apply inline-flex items-center px-2.5 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-medium border border-emerald-200;
        }

        .badge-pdf {
            @apply px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200;
        }

        .badge-word {
            @apply px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200;
        }

        .badge-excel {
            @apply px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200;
        }

        .badge-powerpoint {
            @apply px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 border border-orange-200;
        }

        .badge-zip {
            @apply px-2.5 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 border border-purple-200;
        }

        .badge-text {
            @apply px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200;
        }

        .badge-default {
            @apply px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200;
        }

        .badge-size {
            @apply px-2.5 py-1.5 bg-gray-100 text-gray-800 rounded-lg text-xs font-medium border border-gray-200;
        }

        /* Improved Action Button Styles */
        .btn-detail-improved {
            @apply inline-flex items-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-1 transition-all duration-200 text-xs font-medium shadow-sm hover:shadow-md;
        }

        .btn-preview-improved {
            @apply inline-flex items-center gap-2 px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 focus:ring-2 focus:ring-purple-500 focus:ring-offset-1 transition-all duration-200 text-xs font-medium shadow-sm hover:shadow-md;
        }

        .btn-download-improved {
            @apply inline-flex items-center gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-green-500 focus:ring-offset-1 transition-all duration-200 text-xs font-medium shadow-sm hover:shadow-md;
        }

        .btn-text {
            @apply hidden sm:inline;
        }

        /* Line clamp for title */
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5;
            max-height: 3em;
        }

        /* Zebra striping enhancement */
        tbody tr:nth-child(even) {
            background-color: rgba(249, 250, 251, 0.8);
        }

        tbody tr:nth-child(odd) {
            background-color: rgba(255, 255, 255, 1);
        }

        tbody tr:hover {
            background-color: rgba(219, 234, 254, 0.7) !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Empty State */
        .empty-state {
            @apply flex flex-col items-center py-8;
        }

        /* Modern Pagination Styles */
        .pagination-wrapper .pagination {
            @apply flex items-center space-x-1;
        }

        .pagination-wrapper .pagination li {
            @apply list-none;
        }

        .pagination-wrapper .pagination li a,
        .pagination-wrapper .pagination li span {
            @apply px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200;
        }

        .pagination-wrapper .pagination li a {
            @apply text-gray-600 hover:text-blue-600 hover:bg-blue-50 border border-gray-300 hover:border-blue-300;
        }

        .pagination-wrapper .pagination li.active span {
            @apply bg-blue-600 text-white border-blue-600 shadow-lg;
        }

        .pagination-wrapper .pagination li.disabled span {
            @apply text-gray-400 cursor-not-allowed border-gray-200 bg-gray-50;
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
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 6px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        /* Responsive button text */
        @media (max-width: 640px) {
            .btn-text {
                display: none;
            }

            .btn-detail-improved,
            .btn-preview-improved,
            .btn-download-improved {
                @apply px-2 py-2;
            }
        }

        /* Smooth transitions */
        * {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
@endpush
