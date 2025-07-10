@extends('layouts.app')

@section('content')
@php
    $currentSort = $currentSort ?? 'created_at';
    $currentDirection = $currentDirection ?? 'desc';
    
    function getSortIcon($field, $currentSort, $currentDirection) {
        if ($field === $currentSort) {
            return $currentDirection === 'asc' 
                ? '<svg class="inline h-4 w-4 ml-1 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>'
                : '<svg class="inline h-4 w-4 ml-1 text-indigo-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>';
        }
        return '<svg class="inline h-4 w-4 ml-1 text-gray-300 hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" /></svg>';
    }
@endphp

<div class="max-w-7xl mx-auto mt-10 p-6 bg-white rounded-xl shadow-md">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-4">
        <h2 class="text-2xl font-semibold text-indigo-700 mb-4 md:mb-0">Daftar Koleksi Softfile</h2>
        <div class="flex space-x-2">
            <input type="text" id="searchInput" placeholder="Cari judul, pengarang, atau penerbit..."
                class="w-full md:w-80 px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200 focus:outline-none">
            <button id="resetSort" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                Reset
            </button>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-indigo-50">
                <tr>
                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                    
                    <!-- Kolom Judul -->
                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => $currentSort === 'title' && $currentDirection === 'asc' ? 'desc' : 'asc']) }}"
                           class="flex items-center hover:text-indigo-700">
                            Judul
                            {!! getSortIcon('title', $currentSort, $currentDirection) !!}
                        </a>
                    </th>
                    
                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Edisi</th>
                    
                    <!-- Kolom Pengarang -->
                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'author', 'direction' => $currentSort === 'author' && $currentDirection === 'asc' ? 'desc' : 'asc']) }}"
                           class="flex items-center hover:text-indigo-700">
                            Pengarang
                            {!! getSortIcon('author', $currentSort, $currentDirection) !!}
                        </a>
                    </th>
                    
                    <!-- Kolom Penerbit -->
                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'publisher', 'direction' => $currentSort === 'publisher' && $currentDirection === 'asc' ? 'desc' : 'asc']) }}"
                           class="flex items-center hover:text-indigo-700">
                            Penerbit
                            {!! getSortIcon('publisher', $currentSort, $currentDirection) !!}
                        </a>
                    </th>
                    
                    <!-- Kolom Tahun -->
                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                        <a href="{{ request()->fullUrlWithQuery(['sort' => 'publication_year', 'direction' => $currentSort === 'publication_year' && $currentDirection === 'asc' ? 'desc' : 'asc']) }}"
                           class="flex items-center hover:text-indigo-700">
                            Tahun
                            {!! getSortIcon('publication_year', $currentSort, $currentDirection) !!}
                        </a>
                    </th>
                    
                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ISBN</th>
                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ISSN</th>
                    <th class="px-4 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200" id="softfileTable">
                @foreach($files as $index => $file)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-sm text-gray-500">{{ ($files->currentPage() - 1) * $files->perPage() + $index + 1 }}</td>
                    <td class="px-4 py-3 text-sm text-gray-900">{{ $file->title }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $file->edition ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $file->author ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $file->publisher ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $file->publication_year ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $file->isbn ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $file->issn ?? '-' }}</td>
                    <td class="px-4 py-3 text-sm text-indigo-600">
                        <a href="{{ route('user.preview', $file->id) }}" class="hover:underline">Preview</a> |
                        <a href="{{ route('user.download', $file->id) }}" class="text-green-600 hover:underline">Download</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <!-- Pagination -->
        <div class="mt-4">
            {{ $files->links() }}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.getElementById('softfileTable');
    const resetSort = document.getElementById('resetSort');

    // Fungsi untuk live search
    searchInput.addEventListener('input', function () {
        const keyword = this.value;
        const currentUrl = new URL(window.location.href);
        const params = new URLSearchParams(currentUrl.search);
        
        // Simpan parameter sort saat ini
        const sort = params.get('sort');
        const direction = params.get('direction');
        
        fetch(`{{ route('user.search') }}?search=${encodeURIComponent(keyword)}&sort=${sort || ''}&direction=${direction || ''}`)
            .then(res => res.json())
            .then(data => {
                tableBody.innerHTML = '';

                if (data.length === 0) {
                    tableBody.innerHTML = `<tr><td colspan="9" class="text-center text-sm text-gray-500 py-4">Tidak ada hasil ditemukan.</td></tr>`;
                    return;
                }

                data.forEach((item, index) => {
                    const row = `
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-500">${index + 1}</td>
                            <td class="px-4 py-3 text-sm text-gray-900">${item.title}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${item.edition ?? '-'}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${item.author ?? '-'}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${item.publisher ?? '-'}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${item.publication_year ?? '-'}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${item.isbn ?? '-'}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">${item.issn ?? '-'}</td>
                            <td class="px-4 py-3 text-sm text-indigo-600">
                                <a href="/dashboard/user/preview/${item.id}" class="hover:underline">Preview</a> |
                                <a href="/dashboard/user/download/${item.id}" class="text-green-600 hover:underline">Download</a>
                            </td>
                        </tr>`;
                    tableBody.innerHTML += row;
                });
            });
    });

    // Fungsi untuk reset sorting
    resetSort.addEventListener('click', function() {
        window.location.href = "{{ route('user.index') }}";
    });
</script>
@endpush