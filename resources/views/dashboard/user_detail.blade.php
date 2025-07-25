@extends('layouts.app')

@section('content')
    @php
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

        try {
            $filePath = $softfile->file_path;
            $fileExists = Storage::disk('public')->exists($filePath);
            $fileSize = $fileExists ? Storage::disk('public')->size($filePath) : 0;
            $fileExtension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
            $safeFilePath = Storage::disk('public')->url($filePath);

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
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
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
                                class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800">
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
                                <h1 class="text-3xl font-bold text-gray-900 leading-tight cursor-pointer hover:text-blue-600 transition-colors"
                                    onclick="window.open('{{ route('user.preview-file', $softfile->id) }}', '_blank')">
                                    {{ $softfile->title }}
                                </h1>
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

                        <div class="flex flex-col space-y-3">
                            @if ($fileExists)
                                <a href="{{ route('user.preview-file', $softfile->id) }}" target="_blank"
                                    class="flex items-center justify-center bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3 rounded-xl transition-all shadow-md hover:shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview File
                                </a>

                                <a href="{{ route('user.download', $softfile->id) }}"
                                    class="flex items-center justify-center bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl transition-all shadow-md hover:shadow-lg"
                                    download="{{ $softfile->original_filename }}">
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
                                    File Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>

                    @if ($softfile->description)
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Deskripsi</h3>
                            <div class="prose max-w-none text-gray-700 cursor-pointer hover:bg-gray-50 p-2 rounded"
                                onclick="window.open('{{ route('user.preview-file', $softfile->id) }}', '_blank')">
                                {!! nl2br(e($softfile->description)) !!}
                            </div>
                        </div>
                    @endif

                    @if (isset($previewToken))
                        <div class="mt-8 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl px-6 py-4 shadow">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 11c0 .828-.895 1.5-2 1.5s-2-.672-2-1.5.895-1.5 2-1.5 2 .672 2 1.5zM12 17.25c0 .966-.784 1.75-1.75 1.75S8.5 18.216 8.5 17.25 9.284 15.5 10.25 15.5s1.75.784 1.75 1.75zM18 11.25c0 .966-.784 1.75-1.75 1.75S14.5 12.216 14.5 11.25s.784-1.75 1.75-1.75 1.75.784 1.75 1.75z" />
                                </svg>
                                <p class="text-sm">
                                    Token pratinjau: <span class="font-mono font-semibold">{{ $previewToken }}</span>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        @if ($fileExists && $canPreview)
            <div class="mt-8 bg-white rounded-xl shadow-lg overflow-hidden border border-gray-100">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-gray-900">Preview Dokumen</h3>
                        <div class="flex items-center space-x-3">
                            <button onclick="window.open('{{ route('user.preview-file', $softfile->id) }}', '_blank')"
                                class="inline-flex items-center px-3 py-1.5 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="-ml-0.5 mr-2 h-4 w-4" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Buka di Tab Baru
                            </button>
                        </div>
                    </div>
                </div>

                <div class="w-full h-[70vh] bg-gray-50 relative overflow-hidden">
                    {{-- PDF --}}
                    @if ($fileExtension === 'pdf')
                        <iframe src="{{ $safeFilePath }}#toolbar=0&navpanes=0" class="w-full h-full border-none"
                            title="PDF Preview" allowfullscreen>
                        </iframe>

                        {{-- Gambar --}}
                    @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <div class="h-full overflow-auto flex items-center justify-center p-4">
                            <img src="{{ $safeFilePath }}" alt="Preview {{ $softfile->title }}"
                                class="max-w-full max-h-full object-contain rounded shadow-lg">
                        </div>

                        {{-- Teks --}}
                    @elseif (in_array($fileExtension, ['txt', 'rtf', 'xml', 'html', 'htm']))
                        <div class="h-full overflow-auto bg-white p-4">
                            <pre class="whitespace-pre-wrap font-mono text-sm text-gray-700">{{ htmlentities(Storage::disk('public')->get($softfile->file_path)) }}</pre>
                        </div>

                        {{-- Dokumen Office --}}
                    @elseif (in_array($fileExtension, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']))
                        <div class="h-full flex flex-col">
                            <iframe
                                src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($safeFilePath) }}"
                                width="100%" height="100%" frameborder="0" class="flex-grow"></iframe>
                            <div class="bg-gray-100 p-2 text-center text-sm text-gray-600">
                                Menggunakan Microsoft Office Online Viewer
                            </div>
                        </div>
                    @endif
                </div>

                <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-500">
                        Gunakan tombol <span class="font-medium">"Buka di Tab Baru"</span> untuk pengalaman melihat dokumen
                        yang lebih baik
                    </p>
                </div>
            </div>
        @endif

        <!-- Additional Information -->
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

    @push('styles')
        <style>
            .clickable {
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .clickable:hover {
                background-color: #f8f9fa;
            }

            /* Improved scrollbar styling */
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
                background: #a8a8a8;
            }

            /* Better iframe handling */
            iframe {
                display: block;
                background: white;
            }
        </style>
    @endpush
@endsection
