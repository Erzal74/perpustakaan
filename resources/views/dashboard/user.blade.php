@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-indigo-700">Daftar Koleksi Softfile</h2>
            <div class="text-sm text-gray-500">
                Total: {{ $files->count() }} buku
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-indigo-50">
                    <tr>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Judul</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Pengarang</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Penerbit</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tahun</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ISBN/ISSN</th>
                        <th class="px-6 py-3 border-b text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($files as $file)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="font-medium text-gray-900">{{ $file->title }}</div>
                            <div class="text-xs text-gray-500">{{ $file->edition ?? 'Edisi tidak tersedia' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $file->author ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $file->publisher ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $file->publication_year ?? '-' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($file->isbn)
                                ISBN: {{ $file->isbn }}<br>
                            @endif
                            @if($file->issn)
                                ISSN: {{ $file->issn }}
                            @endif
                            @if(!$file->isbn && !$file->issn)
                                -
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-3">
                                <a href="{{ route('user.preview', $file->id) }}" 
                                   class="text-indigo-600 hover:text-indigo-900 flex items-center"
                                   title="Pratinjau">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Preview
                                </a>
                                <a href="{{ route('user.download', $file->id) }}" 
                                   class="text-green-600 hover:text-green-900 flex items-center"
                                   title="Unduh">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                            Tidak ada data softfile yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($files->hasPages())
        <div class="mt-4">
            {{ $files->links() }}
        </div>
        @endif
    </div>
@endsection