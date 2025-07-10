@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4 flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-white">Edit Book Information</h2>
                    <p class="text-blue-100 mt-1">Update the details below</p>
                </div>
                <a href="{{ route('admin.index') }}"
                    class="text-white hover:text-blue-200 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </a>
            </div>

            <!-- Form Section -->
            <form action="{{ route('admin.update', $softfile->id) }}" method="POST" enctype="multipart/form-data"
                class="p-6">
                @csrf
                @method('PUT')

                <!-- Success/Error Messages -->
                @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <p class="text-green-700 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
                @endif

                @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-red-700 font-medium">Please fix the following errors:</p>
                    </div>
                    <ul class="mt-2 list-disc list-inside text-red-600 text-sm">
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <!-- Two Column Layout -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-5">
                        <!-- Book Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Book Title</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="title" id="title" value="{{ old('title', $softfile->title) }}"
                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>

                        <!-- Author -->
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 mb-1">Author</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="author" id="author"
                                    value="{{ old('author', $softfile->author) }}"
                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>

                        <!-- Publisher -->
                        <div>
                            <label for="publisher"
                                class="block text-sm font-medium text-gray-700 mb-1">Publisher</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="publisher" id="publisher"
                                    value="{{ old('publisher', $softfile->publisher) }}"
                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>

                        <!-- Publication Year -->
                        <div>
                            <label for="publication_year"
                                class="block text-sm font-medium text-gray-700 mb-1">Publication Year</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="number" name="publication_year" id="publication_year"
                                    value="{{ old('publication_year', $softfile->publication_year) }}"
                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-5">
                        <!-- ISBN -->
                        <div>
                            <label for="isbn" class="block text-sm font-medium text-gray-700 mb-1">ISBN</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="isbn" id="isbn" value="{{ old('isbn', $softfile->isbn) }}"
                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>

                        <!-- ISSN -->
                        <div>
                            <label for="issn" class="block text-sm font-medium text-gray-700 mb-1">ISSN</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="issn" id="issn" value="{{ old('issn', $softfile->issn) }}"
                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>

                        <!-- Edition -->
                        <div>
                            <label for="edition" class="block text-sm font-medium text-gray-700 mb-1">Edition</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="edition" id="edition"
                                    value="{{ old('edition', $softfile->edition) }}"
                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>

                        <!-- Genre -->
                        <div>
                            <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Genre</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="genre" id="genre" value="{{ old('genre', $softfile->genre) }}"
                                    class="pl-10 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('description', $softfile->description) }}</textarea>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Book File (PDF)</label>

                    <!-- Current File Info -->
                    @if($softfile->file_path)
                    <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-700 truncate">
                                        {{ $softfile->original_filename }}
                                    </p>
                                    <p class="text-xs text-gray-500">
                                        @if (Storage::disk('public')->exists($softfile->file_path))
                                        {{ round(Storage::disk('public')->size($softfile->file_path) / 1024) }} KB
                                        @else
                                        <span class="text-red-500">File not found</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <button type="button"
                                onclick="openPdfModal('{{ asset('storage/' . $softfile->file_path) }}')"
                                class="ml-4 text-sm font-medium text-blue-600 hover:text-blue-500">
                                View
                            </button>
                        </div>

                        <!-- Edit Filename -->
                        <div class="mt-3">
                            <label for="filename" class="block text-xs font-medium text-gray-500 mb-1">Change filename
                                (without extension)</label>
                            <div class="relative rounded-md shadow-sm">
                                <input type="text" name="filename" id="filename"
                                    value="{{ old('filename', pathinfo($softfile->original_filename, PATHINFO_FILENAME)) }}"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    placeholder="Nama file (tanpa ekstensi .pdf)">
                                @error('filename')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- PDF Viewer Modal Portrait -->
                    <div id="pdfModal" class="fixed inset-0 z-50 hidden bg-gray-900/90 backdrop-blur-sm">
                        <div class="flex items-center justify-center min-h-screen p-4">
                            <div class="relative bg-white rounded-lg shadow-xl w-full max-w-md mx-auto">
                                <!-- Header -->
                                <div class="flex justify-between items-center p-4 border-b">
                                    <h3 class="text-lg font-medium text-gray-900">
                                        {{ $softfile->original_filename }}
                                    </h3>
                                    <button onclick="closePdfModal()" class="text-gray-500 hover:text-gray-700">
                                        ✕
                                    </button>
                                </div>

                                <!-- PDF Container -->
                                <div class="p-4">
                                    <div class="h-[70vh] w-full bg-gray-100 flex items-center justify-center">
                                        <iframe id="pdfViewer" class="w-full h-full border"
                                            style="aspect-ratio: 1/1.4142;" <!-- Rasio kertas A4 -->
                                            frameborder="0"></iframe>
                                    </div>
                                </div>

                                <!-- Controls -->
                                <div class="flex justify-between p-4 border-t">
                                    <div class="flex gap-2">
                                        <button onclick="zoomOut()" class="p-2 bg-gray-100 rounded">-</button>
                                        <span id="zoomLevel" class="p-2">100%</span>
                                        <button onclick="zoomIn()" class="p-2 bg-gray-100 rounded">+</button>
                                    </div>
                                    <button onclick="closePdfModal()" class="px-4 py-2 bg-blue-600 text-white rounded">
                                        Tutup
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-end space-x-4">
                        <!-- Cancel Button -->
                        <a href="{{ route('admin.index') }}"
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            Cancel
                        </a>

                        <!-- Save Button -->
                        <button type="submit"
                            class="px-6 py-2 border border-gray-150 rounded-lg shadow-sm text-black bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            Save Changes
                        </button>
                    </div>

                    <script>
                    let currentZoom = 100;

                    function openPdfModal(pdfUrl) {
                        const iframe = document.getElementById('pdfViewer');
                        iframe.src = `${pdfUrl}#view=FitV&zoom=${currentZoom}`; // FitV untuk portrait
                        document.getElementById('pdfModal').classList.remove('hidden');
                        document.body.style.overflow = 'hidden';
                        updateZoomDisplay();
                    }

                    function zoomIn() {
                        currentZoom = Math.min(currentZoom + 10, 150);
                        updatePdfZoom();
                    }

                    function zoomOut() {
                        currentZoom = Math.max(currentZoom - 10, 50);
                        updatePdfZoom();
                    }

                    function updatePdfZoom() {
                        const iframe = document.getElementById('pdfViewer');
                        const baseUrl = iframe.src.split('#')[0];
                        iframe.src = `${baseUrl}#zoom=${currentZoom}`;
                        updateZoomDisplay();
                    }

                    function updateZoomDisplay() {
                        document.getElementById('zoomLevel').textContent = `${currentZoom}%`;
                    }

                    function closePdfModal() {
                        document.getElementById('pdfModal').classList.add('hidden');
                        document.body.style.overflow = 'auto';
                        document.getElementById('pdfViewer').src = '';
                    }
                    </script>
                    @endsection