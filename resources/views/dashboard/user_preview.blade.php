@extends('layouts.app')

@section('content')
@php
// Helper function to format file size
function formatBytes($bytes, $precision = 2) {
if ($bytes <= 0) return '0 B' ; $units=['B', 'KB' , 'MB' , 'GB' , 'TB' ]; $pow=floor(($bytes ? log($bytes) : 0) /
    log(1024)); $pow=min($pow, count($units) - 1); $bytes /=pow(1024, $pow); return round($bytes, $precision) . ' ' .
    $units[$pow]; } try { $filePath=$softfile->file_path;
    $fileExists = Storage::disk('public')->exists($filePath);
    $fileSize = $fileExists ? Storage::disk('public')->size($filePath) : 0;
    $fileExtension = strtoupper(pathinfo($filePath, PATHINFO_EXTENSION));
    $safeFilePath = asset('storage/softfiles/' . rawurlencode(basename($filePath)));

    } catch (Exception $e) {
    $fileExists = false;
    $fileSize = 0;
    $fileExtension = 'UNKNOWN';
    $safeFilePath = '#';
    }
    @endphp


    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Book Header Section -->
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="md:flex">
                <!-- Book Cover with Gradient Placeholder -->
                <div
                    class="md:w-1/3 lg:w-1/4 bg-gradient-to-br from-blue-50 to-indigo-100 flex flex-col items-center justify-center p-8">
                    <div class="text-center w-full">
                        <div
                            class="relative w-40 h-56 mx-auto mb-6 rounded-lg shadow-md bg-white flex items-center justify-center">
                            <svg class="w-16 h-16 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div class="space-y-2">
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
                                {{ $fileExtension }}
                            </span>
                            <p class="text-sm text-gray-600">
                                @if($fileSize > 0)
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
                                @if($softfile->edition)
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
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                            Penerbit</h3>
                                        <p class="mt-1 text-lg font-medium text-gray-900">
                                            {{ $softfile->publisher ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">Tahun
                                            Terbit</h3>
                                        <p class="mt-1 text-lg font-medium text-gray-900">
                                            {{ $softfile->publication_year ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">ISBN
                                        </h3>
                                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $softfile->isbn ?? '-' }}
                                        </p>
                                    </div>
                                    <div>
                                        <h3 class="text-xs font-semibold uppercase tracking-wider text-gray-500">ISSN
                                        </h3>
                                        <p class="mt-1 text-lg font-medium text-gray-900">{{ $softfile->issn ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-3">
                            @if($fileExists)
                            <a href="{{ route('user.download', $softfile->id) }}"
                                class="flex items-center justify-center bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl transition-all shadow-md hover:shadow-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download
                            </a>
                            @else
                            <button disabled
                                class="flex items-center justify-center bg-gray-300 text-gray-500 px-6 py-3 rounded-xl cursor-not-allowed">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download Tidak Tersedia
                            </button>
                            @endif
                            <a href="#"
                                class="flex items-center justify-center bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-xl transition-all shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Bagikan
                            </a>
                        </div>
                    </div>

                    @if($softfile->description)
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

        <!-- File Preview Section -->
        <!-- File Preview Section -->
        @if($fileExists)
        <div x-data="{ open: false }" class="mt-8">

            <!-- Tombol Preview -->
            <div
                class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100 px-6 py-5 flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 font-serif">Pratinjau Dokumen</h2>
                    <p class="mt-1 text-sm text-gray-500">Nama file:
                        <span class="font-medium text-amber-600">{{ $softfile->original_filename }}</span>
                    </p>
                </div>
                <div class="flex items-center gap-3">
                    <button @click="open = true"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-4.553a1 1 0 10-1.414-1.414L13 8.586l-5.293-5.293a1 1 0 00-1.414 1.414L11 10l-4.707 4.707a1 1 0 001.414 1.414L13 11.414l4.553 4.553a1 1 0 001.414-1.414L15 10z" />
                        </svg>
                        Lihat Pratinjau
                    </button>
                </div>
            </div>

            <!-- Modal Overlay -->
            <div x-show="open" x-transition
                class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                <!-- Modal Content -->
                <div @click.away="open = false"
                    class="bg-white rounded-xl shadow-lg overflow-hidden w-full max-w-6xl h-[80vh] relative">
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-800">Pratinjau Dokumen</h3>
                        <button @click="open = false"
                            class="text-gray-600 hover:text-red-500 transition ease-in-out duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="w-full h-full">
                        <iframe src="{{ $safeFilePath }}" class="w-full h-full border-none" frameborder="0"
                            loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- Jika file tidak ditemukan -->
        <div class="mt-8 bg-amber-50 rounded-xl shadow-lg overflow-hidden border border-amber-200">
            <div class="px-6 py-4">
                <div class="flex items-center">
                    <svg class="h-5 w-5 text-amber-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                            clip-rule="evenodd" />
                    </svg>
                    <h3 class="text-lg font-medium text-amber-800">File tidak tersedia</h3>
                </div>
                <div class="mt-2 text-sm text-amber-700">
                    <p>File "{{ $softfile->original_filename }}" tidak ditemukan di server.</p>
                    <p class="mt-2">Silakan hubungi administrator untuk melaporkan masalah ini.</p>
                </div>
            </div>
        </div>
        @endif



        <!-- Additional Information and Actions -->
        <div class="mt-8 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
            <div class="px-6 py-5 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                <h3 class="text-lg font-semibold text-gray-800">Informasi Tambahan</h3>
            </div>
            <div class="px-6 py-4">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div class="space-y-3">
                        <div class="flex items-center text-gray-600">
                            <svg class="flex-shrink-0 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm">Diunggah pada <span
                                    class="font-medium">{{ $softfile->created_at->translatedFormat('d F Y H:i') }}</span></span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <svg class="flex-shrink-0 mr-3 h-5 w-5 text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm">Terakhir diupdate <span
                                    class="font-medium">{{ $softfile->updated_at->translatedFormat('d F Y H:i') }}</span></span>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        @if($fileExists)
                        <a href="{{ route('user.download', $softfile->id) }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-white bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download File
                        </a>
                        @else
                        <button disabled
                            class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-xl shadow-sm text-gray-400 bg-gray-200 cursor-not-allowed">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            File Tidak Tersedia
                        </button>
                        @endif
                        <a href="{{ route('user.index') }}"
                            class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection