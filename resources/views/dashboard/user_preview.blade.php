@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Book Header Section -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="md:flex">
            <!-- Book Cover Placeholder -->
            <div class="md:w-1/4 bg-gray-100 flex items-center justify-center p-8">
                <div class="text-center">
                    <svg class="w-20 h-20 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Cover Buku</p>
                </div>
            </div>
            
            <!-- Book Metadata -->
            <div class="md:w-3/4 p-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">{{ $softfile->title }}</h1>
                        <p class="text-lg text-gray-600 mt-1">{{ $softfile->edition ?? 'Edisi Standar' }} • {{ $softfile->publication_year ?? 'Tahun tidak tersedia' }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('user.download', $softfile->id) }}" 
                           class="flex items-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg transition-colors shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download
                        </a>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Pengarang</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $softfile->author ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Penerbit</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $softfile->publisher ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Tahun Terbit</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $softfile->publication_year ?? '-' }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">ISBN</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $softfile->isbn ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">ISSN</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $softfile->issn ?? '-' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Format File</h3>
                            <p class="mt-1 text-lg text-gray-900 uppercase">{{ pathinfo($softfile->file_path, PATHINFO_EXTENSION) }}</p>
                        </div>
                    </div>
                </div>

                @if($softfile->description)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Deskripsi</h3>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($softfile->description)) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- File Preview Section -->
    <div class="mt-8 bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold text-gray-800">Pratinjau Dokumen</h2>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                    {{ strtoupper(pathinfo($softfile->file_path, PATHINFO_EXTENSION)) }} File
                </span>
            </div>
            <p class="mt-1 text-sm text-gray-500">Nama file: {{ $softfile->original_filename }}</p>
        </div>
        <div class="p-4">
            <div class="border-2 border-dashed border-gray-200 rounded-lg h-[700px]">
                <iframe src="{{ asset('storage/' . $softfile->file_path) }}" 
                        class="w-full h-full" 
                        frameborder="0"
                        loading="lazy"></iframe>
            </div>
        </div>
    </div>

    <!-- Additional Information and Actions -->
    <div class="mt-6 bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="mb-4 md:mb-0">
                    <h3 class="text-sm font-medium text-gray-500">Informasi Tambahan</h3>
                    <div class="mt-1 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                        Diunggah pada: {{ $softfile->created_at->format('d M Y H:i') }}
                    </div>
                    <div class="mt-1 flex items-center text-sm text-gray-500">
                        <svg class="flex-shrink-0 mr-1.5 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                        </svg>
                        Terakhir diupdate: {{ $softfile->updated_at->format('d M Y H:i') }}
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                    <a href="{{ route('user.download', $softfile->id) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Download File
                    </a>
                    <a href="{{ route('user.dashboard') }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Kembali ke Daftar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection