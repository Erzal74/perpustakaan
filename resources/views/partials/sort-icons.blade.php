@php
    // Mendapatkan parameter sorting dari request
    $currentField = request('sort');
    $currentDirection = request('direction');
@endphp

@if ($field === $currentField)
    @if ($currentDirection === 'asc')
        {{-- Tampilkan ikon panah atas jika sorting ascending --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-blue-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    @else
        {{-- Tampilkan ikon panah bawah jika sorting descending --}}
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-blue-500" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    @endif
@else
    {{-- Tampilkan ikon default (dua panah) jika kolom tidak sedang di-sort --}}
    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 text-gray-400" fill="none" viewBox="0 0 24 24"
        stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
    </svg>
@endif
