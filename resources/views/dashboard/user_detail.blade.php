@extends('layouts.app')

@section('content')
    @php
        // Improved file size formatting function
        function formatBytes($bytes, $precision = 2)
        {
            if ($bytes <= 0) {
                return '0 B';
            }
            $units = ['B', 'KB', 'MB', 'GB', 'TB'];
            $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
            $pow = min($pow, count($units) - 1);
            $bytes /= pow(1024, $pow);
            return round($bytes, $precision) . ' ' . $units[$pow];
        }

        // File information handling with better error handling
        try {
            $filePath = $softfile->file_path;
            $fileExists = Storage::disk('public')->exists($filePath);
            $fileSize = $fileExists ? Storage::disk('public')->size($filePath) : 0;
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));

            // Generate safe file URL
            $safeFilePath = Storage::disk('public')->url($filePath);

            // Fallback if storage URL doesn't work
            if (!filter_var($safeFilePath, FILTER_VALIDATE_URL)) {
                $safeFilePath = asset('storage/' . ltrim($filePath, '/'));
            }
        } catch (Exception $e) {
            $fileExists = false;
            $fileSize = 0;
            $fileExtension = 'UNKNOWN';
            $safeFilePath = '#';
            \Log::error('File preview error: ' . $e->getMessage());
        }
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Book Header Section -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
            <div class="md:flex">
                <!-- Book Cover with Gradient Placeholder -->
                <div
                    class="md:w-1/3 lg:w-1/4 bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col items-center justify-center p-8">
                    <div class="text-center w-full">
                        <div
                            class="relative w-40 h-56 mx-auto mb-6 rounded-lg shadow-md bg-white flex items-center justify-center">
                            @if ($fileExtension === 'pdf')
                                <svg class="w-16 h-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif ($fileExtension === 'csv')
                                <svg class="w-16 h-16 text-yellow-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            @elseif (in_array($fileExtension, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']))
                                <svg class="w-16 h-16 text-green-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @else
                                <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            @endif
                        </div>
                        <div class="space-y-2">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 uppercase">
                                {{ $fileExtension }}
                            </span>
                            <p class="text-sm text-gray-600">
                                @if ($fileSize > 0)
                                    {{ formatBytes($fileSize) }}
                                @else
                                    Ukuran tidak tersedia
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Book Metadata -->
                <div class="md:w-2/3 lg:w-3/4 p-8">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <h1 class="text-3xl font-bold text-gray-900 leading-tight">{{ $softfile->title }}</h1>
                                @if ($softfile->edition)
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        Edisi {{ $softfile->edition }}
                                    </span>
                                @endif
                            </div>
                            <p class="text-xl text-gray-600">{{ $softfile->author ?? 'Penulis tidak tersedia' }}</p>

                            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Penerbit
                                        </h3>
                                        <p class="mt-1 text-lg font-medium text-gray-900">
                                            {{ $softfile->publisher ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Tahun
                                            Terbit</h3>
                                        <p class="mt-1 text-lg font-medium text-gray-900">
                                            {{ optional($softfile->publication_date)->format('Y') ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">ISBN</h3>
                                        <p class="mt-1 text-lg font-medium text-gray-900">
                                            {{ $softfile->isbn ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">ISSN</h3>
                                        <p class="mt-1 text-lg font-medium text-gray-900">
                                            {{ $softfile->issn ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($softfile->description)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                            <div class="prose max-w-none text-gray-700">
                                {!! nl2br(e($softfile->description)) !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection