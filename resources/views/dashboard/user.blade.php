@extends('layouts.app')

@section('content')
@php
$currentSort = $currentSort ?? 'created_at';
$currentDirection = $currentDirection ?? 'desc';

function getSortIcon($field, $currentSort, $currentDirection) {
if ($field === $currentSort) {
return $currentDirection === 'asc'
? '<svg class="inline h-4 w-4 ml-1 text-blue-600 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none"
    viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
</svg>'
: '<svg class="inline h-4 w-4 ml-1 text-blue-600 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none"
    viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
</svg>';
}
return '<svg class="inline h-4 w-4 ml-1 text-gray-400 hover:text-gray-600 transition-colors"
    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
</svg>';
}
@endphp

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="text-center mb-8">
                <h1
                    class="text-4xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-2">
                    Koleksi Softfile
                </h1>
                <p class="text-gray-600 text-lg">Temukan dan unduh koleksi digital terbaik</p>
            </div>

            <!-- Search Section -->
            <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-lg border border-white/20 p-6 mb-8">
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
                            class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-white/70 backdrop-blur-sm transition-all duration-200 hover:shadow-md">
                    </div>

                    <div class="flex gap-2">
                        <button type="submit"
                            class="px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transform hover:scale-105 transition-all duration-200 shadow-lg font-medium">
                            <svg class="inline h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            Cari
                        </button>

                        <a href="{{ route('user.index') }}"
                            class="px-6 py-3 bg-white/80 text-gray-700 rounded-xl hover:bg-white border border-gray-200 transform hover:scale-105 transition-all duration-200 shadow-lg font-medium">
                            <svg class="inline h-4 w-4 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table Section -->
        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <span
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">No</span>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => $currentSort === 'title' && $currentDirection === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center hover:text-blue-600 transition-colors duration-200 group">
                                    <span
                                        class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent group-hover:from-blue-700 group-hover:to-indigo-700">Judul</span>
                                    {!! getSortIcon('title', $currentSort, $currentDirection) !!}
                                </a>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <span
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Edisi</span>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'author', 'direction' => $currentSort === 'author' && $currentDirection === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center hover:text-blue-600 transition-colors duration-200 group">
                                    <span
                                        class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent group-hover:from-blue-700 group-hover:to-indigo-700">Pengarang</span>
                                    {!! getSortIcon('author', $currentSort, $currentDirection) !!}
                                </a>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'publisher', 'direction' => $currentSort === 'publisher' && $currentDirection === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center hover:text-blue-600 transition-colors duration-200 group">
                                    <span
                                        class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent group-hover:from-blue-700 group-hover:to-indigo-700">Penerbit</span>
                                    {!! getSortIcon('publisher', $currentSort, $currentDirection) !!}
                                </a>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <a href="{{ request()->fullUrlWithQuery(['sort' => 'publication_year', 'direction' => $currentSort === 'publication_year' && $currentDirection === 'asc' ? 'desc' : 'asc']) }}"
                                    class="flex items-center hover:text-blue-600 transition-colors duration-200 group">
                                    <span
                                        class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent group-hover:from-blue-700 group-hover:to-indigo-700">Tahun</span>
                                    {!! getSortIcon('publication_year', $currentSort, $currentDirection) !!}
                                </a>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <span
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">ISBN</span>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <span
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">ISSN</span>
                            </th>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                <span
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100" id="softfileTable">
                        @foreach($files as $index => $file)
                        <tr
                            class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 group">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                <span
                                    class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                    {{ ($files->currentPage() - 1) * $files->perPage() + $index + 1 }}
                                </span>
                            </td>
                            <td
                                class="px-6 py-4 text-sm font-semibold text-gray-900 group-hover:text-blue-800 transition-colors">
                                {{ $file->title }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $file->edition ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $file->author ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $file->publisher ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $file->publication_year ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $file->isbn ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $file->issn ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                                <a href="{{ route('user.preview', ['id' => $file->id, 'token' => $file->preview_token]) }}"
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Lihat
                                </a>
                                <a href="{{ route('user.download', $file->id) }}"
                                    class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                    Unduh
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-t border-gray-200">
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
    </div>
</div>
@endsection

@push('scripts')
<script>
const searchInput = document.getElementById('searchInput');
const tableBody = document.getElementById('softfileTable');

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
                <td colspan="9" class="text-center py-8">
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
                return;
            }

            data.forEach((item, index) => {
                const row = `
                    <tr class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-200 group">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                            <span class="bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">
                                ${index + 1}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900 group-hover:text-blue-800 transition-colors">
                            ${item.title}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${item.edition ?? '-'}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">${item.author ?? '-'}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">${item.publisher ?? '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${item.publication_year ?? '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${item.isbn ?? '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">${item.issn ?? '-'}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                            <a href="/dashboard/user/preview/${item.id}?token=${item.preview_token}" 
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transform hover:scale-105 transition-all duration-200 shadow-md">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                Lihat
                            </a>
                            <a href="/dashboard/user/download/${item.id}" 
                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transform hover:scale-105 transition-all duration-200 shadow-md">
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
    @apply text-gray-600 hover: text-blue-600 hover:bg-blue-50 border border-gray-300 hover:border-blue-300;
}

.pagination-wrapper .pagination li.active span {
    @apply bg-gradient-to-r from-blue-600 to-indigo-600 text-white border-transparent shadow-lg;
}

.pagination-wrapper .pagination li.disabled span {
    @apply text-gray-400 cursor-not-allowed border-gray-200;
}

/* Smooth scrolling for mobile */
@media (max-width: 768px) {
    .overflow-x-auto {
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f1f5f9;
    }

    .overflow-x-auto::-webkit-scrollbar {
        height: 6px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
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
</style>
@endpush