@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-white p-6">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-6">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800">Koleksi Digital Perpustakaan</h1>
                            <p class="text-gray-600 mt-1">Temukan dan unduh koleksi digital terbaik</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden md:flex items-center gap-2 bg-blue-50 px-4 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <span class="text-sm font-medium text-blue-600">{{ Auth::user()->name }}</span>
                        </div>
                        <div class="flex items-center gap-2 bg-green-50 px-4 py-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-medium text-green-600">Aktif</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Total Books -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Total Buku</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $files->total() }}</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                        <span>{{ $newBooksThisMonth }} baru bulan ini</span>
                    </div>
                </div>

                <!-- Most Popular Book -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Buku Terpopuler</p>
                            <p class="text-lg font-bold text-gray-800 truncate max-w-[180px]">{{ $mostPopularBook->title ?? '-' }}</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                        </svg>
                        <span>{{ $mostPopularBook->downloads_count ?? 0 }} unduhan bulan ini</span>
                    </div>
                </div>

                <!-- Your Activity -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Aktivitas Anda</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $userDownloadsCount }}</p>
                        </div>
                        <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Terakhir diunduh {{ $lastDownloadTime ? $lastDownloadTime->diffForHumans() : '-' }}</span>
                    </div>
                </div>

                <!-- Monthly Downloads -->
                <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-600 text-sm font-medium">Unduhan Bulan Ini</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalDownloadsThisMonth }}</p>
                        </div>
                        <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        @if($downloadGrowth > 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                            </svg>
                            <span>Naik {{ abs($downloadGrowth) }}% dari bulan lalu</span>
                        @elseif($downloadGrowth < 0)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                            </svg>
                            <span>Turun {{ abs($downloadGrowth) }}% dari bulan lalu</span>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14" />
                            </svg>
                            <span>Stabil dari bulan lalu</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Search Section -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm p-6 mb-8">
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
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 border border-transparent rounded-lg shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>

                        <a href="{{ route('user.index') }}"
                            class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white border border-gray-300 rounded-lg shadow-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200 font-medium">
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
                <div class="mt-4 flex flex-wrap gap-2">
                    <a href="{{ route('user.index', ['filter' => 'popular']) }}"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ request('filter') === 'popular' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Populer
                    </a>
                    <a href="{{ route('user.index', ['filter' => 'new']) }}"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ request('filter') === 'new' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Terbaru
                    </a>
                    <a href="{{ route('user.index', ['filter' => 'recommended']) }}"
                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium {{ request('filter') === 'recommended' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                        Rekomendasi
                    </a>
                    
                </div>
            </div>

            <!-- Data Table -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">Daftar Buku</h3>
                            <p class="text-gray-600 mt-1">Temukan dan unduh koleksi buku digital</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-gray-500">Urutkan:</span>
                            <select id="sortSelect" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="title_asc" {{ request('sort') === 'title' && request('direction') === 'asc' ? 'selected' : '' }}>Judul (A-Z)</option>
                                <option value="title_desc" {{ request('sort') === 'title' && request('direction') === 'desc' ? 'selected' : '' }}>Judul (Z-A)</option>
                                <option value="downloads_desc" {{ request('sort') === 'downloads_count' && request('direction') === 'desc' ? 'selected' : '' }}>Paling Populer</option>
                                <option value="year_desc" {{ request('sort') === 'publication_year' && request('direction') === 'desc' ? 'selected' : '' }}>Terbaru</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <!-- Kolom NO -->
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">
                                    NO
                                </th>

                                <!-- Kolom Judul Buku -->
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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

                                <!-- Kolom Popularity -->
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'downloads_count', 'direction' => request('sort') === 'downloads_count' && request('direction') === 'asc' ? 'desc' : 'asc']) }}"
                                        class="flex items-center justify-between group hover:text-gray-700">
                                        <span>Popularitas</span>
                                        <span class="ml-2 flex flex-col items-center">
                                            <svg class="h-3 w-3 @if (request('sort') === 'downloads_count' && request('direction') === 'asc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 15l7-7 7 7" />
                                            </svg>
                                            <svg class="h-3 w-3 @if (request('sort') === 'downloads_count' && request('direction') === 'desc') text-gray-700 @else text-gray-300 group-hover:text-gray-400 @endif"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </span>
                                    </a>
                                </th>

                                <!-- Kolom Penerbit -->
                                <th scope="col"
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                    class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
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
                                
                                <!-- Kolom Aksi -->
                                <th scope="col"
                                    class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="softfileTable">
                            @forelse ($files as $file)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ ($files->currentPage() - 1) * $files->perPage() + $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <div class="flex items-center gap-2">
                                                    <p class="font-medium text-gray-900 whitespace-nowrap overflow-hidden text-ellipsis"
                                                        title="{{ $file->title }}">
                                                        {{ $file->title }}
                                                    </p>
                                                    @if($file->downloads_count >= 50)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                            </svg>
                                                            Populer
                                                        </span>
                                                    @endif
                                                    @if(now()->diffInDays($file->created_at) <= 30)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                            </svg>
                                                            Baru
                                                        </span>
                                                    @endif
                                                </div>
                                                <div class="mt-1 flex items-center text-xs text-gray-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                                    </svg>
                                                    <span>Diunduh {{ $file->downloads_count }} kali bulan ini</span>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-gray-700">
                                        <div class="max-w-[150px]">
                                            <p class="truncate">{{ $file->author ?? '-' }}</p>
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" 
                                                    style="width: {{ min(100, ($file->downloads_count / max(1, $maxDownloads)) * 100) }}%"></div>
                                            </div>
                                            <span class="ml-2 text-xs text-gray-500">{{ $file->downloads_count }}</span>
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
                                                class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                                {{ $file->publication_year }}
                                            </span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm space-x-2">
                                        <a href="{{ route('user.preview', ['id' => $file->id, 'token' => $file->preview_token]) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            Lihat
                                        </a>
                                        <a href="{{ route('user.download', $file->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                </path>
                                            </svg>
                                            Unduh
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="px-6 py-16 text-center">
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
                                            <p class="text-gray-500">Silakan gunakan fitur pencarian untuk menemukan buku
                                            </p>
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
                            Menampilkan {{ $files->firstItem() ?? 0 }} - {{ $files->lastItem() ?? 0 }} dari
                            {{ $files->total() }} hasil
                        </div>
                        <div class="pagination-wrapper">
                            {{ $files->links() }}
                        </div>
                    </div>
                </div>
            </div>
            
           
            
            <!-- Recommended For You Section -->
            @if($recommendedBooks->count() > 0)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mt-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Rekomendasi Untuk Anda</h3>
                    <p class="text-gray-600 mt-1">Buku yang mungkin Anda sukai berdasarkan aktivitas Anda</p>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
                    @foreach($recommendedBooks as $file)
                    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200">
                        <div class="p-4">
                            <div class="flex items-center justify-center bg-gray-100 h-40 rounded-lg mb-4">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                            <h4 class="font-medium text-gray-900 mb-1 truncate">{{ $file->title }}</h4>
                            <p class="text-sm text-gray-500 mb-3 truncate">{{ $file->author ?? 'Penulis tidak diketahui' }}</p>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-medium px-2 py-1 bg-green-100 text-green-800 rounded-full">Direkomendasikan</span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('user.preview', ['id' => $file->id, 'token' => $file->preview_token]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat</a>
                                    <a href="{{ route('user.download', $file->id) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Unduh</a>
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
    <!-- Recently Viewed Section -->
@if($recentlyViewed->count() > 0)
<div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mt-8">
    <div class="p-6 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-800">Baru Saja Dilihat</h3>
        <p class="text-gray-600 mt-1">Buku yang baru saja Anda lihat</p>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
        @foreach($recentlyViewed as $file)
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-4">
                <div class="flex items-center justify-center bg-gray-100 h-40 rounded-lg mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
                <h4 class="font-medium text-gray-900 mb-1 truncate">{{ $file->title }}</h4>
                <p class="text-sm text-gray-500 mb-3 truncate">{{ $file->author ?? 'Penulis tidak diketahui' }}</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-medium px-2 py-1 bg-blue-100 text-blue-800 rounded-full">{{ $file->publication_year ?? '-' }}</span>
                    <div class="flex space-x-2">
                        <a href="{{ route('user.preview', ['id' => $file->id, 'token' => $file->preview_token]) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Lihat</a>
                        <a href="{{ route('user.download', $file->id) }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Unduh</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif
@endsection

@push('scripts')
    <script>
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('softfileTable');
        const sortSelect = document.getElementById('sortSelect');
        
        // Sort select change handler
        sortSelect.addEventListener('change', function() {
            const value = this.value;
            let sort, direction;
            
            switch(value) {
                case 'title_asc':
                    sort = 'title';
                    direction = 'asc';
                    break;
                case 'title_desc':
                    sort = 'title';
                    direction = 'desc';
                    break;
                case 'downloads_desc':
                    sort = 'downloads_count';
                    direction = 'desc';
                    break;
                case 'year_desc':
                    sort = 'publication_year';
                    direction = 'desc';
                    break;
            }
            
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sort);
            url.searchParams.set('direction', direction);
            window.location.href = url.toString();
        });

        // AJAX Live Search with improved styling
        searchInput.addEventListener('input', function() {
            const keyword = this.value;
            const currentUrl = new URL(window.location.href);
            const params = new URLSearchParams(currentUrl.search);
            const sort = params.get('sort');
            const direction = params.get('direction');

            // Add loading state
            if (keyword.length > 0) {
                tableBody.innerHTML = `
            <tr>
                <td colspan="10" class="text-center py-8">
                    <div class="flex items-center justify-center space-x-2">
                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                        <span class="text-gray-600">Mencari...</span>
                    </div>
                </td>
            </tr>
        `;
            }

            fetch(
                    `{{ route('user.search') }}?search=${encodeURIComponent(keyword)}&sort=${sort || ''}&direction=${direction || ''}`
                )
                .then(res => res.json())
                .then(data => {
                    tableBody.innerHTML = '';
                    if (data.length === 0) {
                        tableBody.innerHTML = `
                    <tr>
                        <td colspan="10" class="text-center py-12">
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
                        return;
                    }

                    data.forEach((item, index) => {
                        const popularBadge = item.downloads_count >= 50 ? `
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                Populer
                            </span>
                        ` : '';
                        
                        const newBadge = new Date(item.created_at) > new Date(Date.now() - 30 * 24 * 60 * 60 * 1000) ? `
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Baru
                            </span>
                        ` : '';
                        
                        const row = `
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            ${index + 1}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="font-medium text-gray-900 whitespace-nowrap overflow-hidden text-ellipsis">
                                            ${item.title}
                                        </p>
                                        ${popularBadge}
                                        ${newBadge}
                                    </div>
                                    <div class="mt-1 flex items-center text-xs text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10" />
                                        </svg>
                                        <span>Diunduh ${item.downloads_count} kali bulan ini</span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <div class="max-w-[150px]">
                                <p class="truncate">${item.author ?? '-'}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-blue-600 h-2.5 rounded-full" 
                                        style="width: ${Math.min(100, (item.downloads_count / ${Math.max(1, data.reduce((max, book) => Math.max(max, book.downloads_count), 0))}) * 100}%"></div>
                                </div>
                                <span class="ml-2 text-xs text-gray-500">${item.downloads_count}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4 text-sm text-gray-700">
                            <div class="max-w-[140px]">
                                <p class="truncate">${item.publisher ?? '-'}</p>
                            </div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            ${item.publication_year ?
                                `<span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-800 rounded-full">
                                    ${item.publication_year}
                                </span>` :
                                '<span class="text-gray-400">-</span>'}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="/dashboard/user/preview/${item.id}?token=${item.preview_token}"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat
                            </a>
                            <a href="/dashboard/user/download/${item.id}"
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Unduh
                            </a>
                        </td>
                    </tr>
                `;
                        tableBody.innerHTML += row;
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    tableBody.innerHTML = `
                <tr>
                    <td colspan="10" class="text-center py-8">
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
                });
        });
    </script>

    <style>
        /* Custom pagination styling */
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
            @apply bg-blue-600 text-white border-transparent shadow-lg;
        }

        .pagination-wrapper .pagination li.disabled span {
            @apply text-gray-400 cursor-not-allowed border-gray-200;
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
        /* Recently Viewed Card Styles */
.recently-viewed-card {
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.recently-viewed-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.recently-viewed-card .file-icon {
    transition: all 0.3s ease;
}

.recently-viewed-card:hover .file-icon {
    transform: scale(1.05);
}
    </style>
@endpush