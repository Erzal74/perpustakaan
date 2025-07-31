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

                        <div class="flex flex-col space-y-3">
                            @if ($fileExists)
                                <a href="{{ route('user.download', $softfile->id) }}"
                                    class="flex items-center justify-center bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white px-6 py-3 rounded-xl transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5"
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
                                    Download Tidak Tersedia
                                </button>
                            @endif
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

                    @if (isset($previewToken))
                        <div class="mt-8 bg-blue-50 border border-blue-200 text-blue-800 rounded-xl px-6 py-4 shadow-sm">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"
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

        @if ($fileExists)
            <div class="mt-8">
                <div
                    class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-xl">
                    <div class="flex flex-col h-[80vh]">
                        <!-- Preview Header with Lihat Pratinjau Button -->
                        <div
                            class="p-4 bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 flex justify-between items-center">
                            <h3 class="text-lg font-semibold text-gray-800">Pratinjau File</h3>
                            <a href="{{ route('user.show-file', ['id' => $softfile->id, 'token' => $previewToken]) }}"
                                target="_blank"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-indigo-600 to-blue-600 hover:from-indigo-700 hover:to-blue-700 text-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat
                            </a>
                        </div>

                        <!-- Preview Content -->
                        <a href="{{ route('user.show-file', ['id' => $softfile->id, 'token' => $previewToken]) }}"
                            target="_blank"
                            class="flex-1 block relative group hover:bg-gray-50/50 transition-all duration-300">
                            <div
                                class="absolute inset-0 bg-transparent group-hover:bg-blue-100/10 group-hover:cursor-pointer z-10">
                            </div>
                            @if ($canPreview)
                                @if ($fileExtension === 'pdf')
                                    <iframe src="{{ $safeFilePath }}#toolbar=0&navpanes=0"
                                        class="w-full h-full border-none rounded-b-2xl" title="PDF Preview"></iframe>
                                @elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    <div class="flex-1 overflow-auto flex items-center justify-center p-6">
                                        <img src="{{ $safeFilePath }}" alt="Preview {{ $softfile->title }}"
                                            class="max-w-full max-h-full object-contain rounded-lg shadow-md group-hover:shadow-lg transition-all duration-300">
                                    </div>
                                @elseif (in_array($fileExtension, ['txt', 'rtf', 'xml', 'html', 'htm']))
                                    <div class="flex-1 overflow-auto bg-white p-6 rounded-b-2xl">
                                        <pre class="whitespace-pre-wrap font-mono text-sm text-gray-700 leading-relaxed">
                                            {{ htmlentities(Storage::disk('public')->get($softfile->file_path)) }}
                                        </pre>
                                    </div>
                                @elseif ($fileExtension === 'csv')
                                    <div class="flex-1 overflow-auto bg-white p-6 rounded-b-2xl">
                                        @php
                                            $rows = [];
                                            if (
                                                ($handle = fopen(
                                                    Storage::disk('public')->path($softfile->file_path),
                                                    'r',
                                                )) !== false
                                            ) {
                                                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                                                    $rows[] = $data;
                                                }
                                                fclose($handle);
                                            }
                                        @endphp
                                        <div class="overflow-auto max-h-[70vh]">
                                            <table
                                                class="table-auto w-full text-sm border-collapse border border-gray-200">
                                                @foreach ($rows as $i => $row)
                                                    <tr
                                                        class="{{ $i === 0 ? 'bg-gray-100 font-semibold text-gray-800' : 'hover:bg-gray-50' }} border-b border-gray-200">
                                                        @foreach ($row as $cell)
                                                            <td class="border border-gray-200 px-4 py-2.5 text-gray-700">
                                                                {{ $cell }}</td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>
                                    </div>
                                @elseif (in_array($fileExtension, ['doc', 'docx', 'ppt', 'pptx', 'xls', 'xlsx']))
                                    <div class="h-full flex flex-col rounded-b-2xl">
                                        <iframe
                                            src="https://view.officeapps.live.com/op/embed.aspx?src={{ urlencode($safeFilePath) }}"
                                            width="100%" height="95%" frameborder="0"
                                            class="flex-grow rounded-b-2xl">
                                        </iframe>
                                        <div class="bg-gray-50 p-2 text-center text-sm text-gray-600">
                                            Menggunakan Microsoft Office Online Viewer. Dokumen tidak disimpan oleh
                                            Microsoft.
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            const iframe = document.querySelector('iframe[src*="officeapps.live.com"]');
                                            if (iframe) {
                                                iframe.onload = function() {
                                                    setTimeout(function() {
                                                        try {
                                                            if (iframe.contentDocument && iframe.contentDocument.body.innerText
                                                                .includes('We\'re sorry')) {
                                                                document.getElementById('office-fallback').classList.remove('hidden');
                                                                iframe.classList.add('hidden');
                                                            }
                                                        } catch (e) {
                                                            console.log('Cannot check iframe content: ', e);
                                                        }
                                                    }, 3000);
                                                };
                                            }
                                        });
                                    </script>

                                    <div id="office-fallback"
                                        class="hidden flex-1 flex flex-col items-center justify-center p-8 text-center">
                                        <div
                                            class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mb-4">
                                            ⚠️
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Gagal Memuat Preview</h3>
                                        <p class="text-gray-600 mb-4">
                                            Tidak dapat memuat preview dokumen. Klik untuk melihat pratinjau lengkap.
                                        </p>
                                    </div>
                                @else
                                    <div class="flex-1 flex flex-col items-center justify-center p-8 text-center">
                                        <div
                                            class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                            📄
                                        </div>
                                        <h3 class="text-xl font-semibold text-gray-800 mb-2">Pratinjau Tidak Didukung</h3>
                                        <p class="text-gray-600 mb-4">
                                            Format file .{{ $fileExtension }} tidak dapat dipratinjau langsung di sini.
                                            Klik untuk melihat pratinjau lengkap.
                                        </p>
                                    </div>
                                @endif
                            @else
                                <div class="flex-1 flex flex-col items-center justify-center p-8 text-center">
                                    <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                                        📄
                                    </div>
                                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Pratinjau Tidak Tersedia</h3>
                                    <p class="text-gray-600 mb-4">
                                        Format file .{{ $fileExtension }} tidak dapat dipratinjau langsung di sini. Klik
                                        untuk melihat pratinjau lengkap.
                                    </p>
                                </div>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Additional Information -->
        <div class="mt-8 bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
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
                            class="inline-flex items-center justify-center px-5 py-2.5 border border-gray-300 shadow-sm text-sm font-medium rounded-xl text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300">
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
