@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-green-600 to-blue-700 px-6 py-4 flex items-center justify-between">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Tambah Softfile Baru</h2>
                        <p class="text-green-100 mt-1">Silakan isi informasi berikut</p>
                    </div>
                    <a href="{{ route('admin.index') }}"
                        class="text-white hover:text-green-200 transition-colors duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </a>
                </div>

                <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                    @csrf

                    @if (session('success'))
                        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <p class="text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($errors->any())
                        )
                        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-red-700 font-medium">Silakan perbaiki kesalahan berikut:</p>
                            </div>
                            <ul class="mt-2 list-disc list-inside text-red-600 text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-5">
                            <div class="space-y-1">
                                <label for="title" class="block text-sm font-medium text-gray-700">Judul Buku</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div class="space-y-1">
                                <label for="author" class="block text-sm font-medium text-gray-700">Pengarang</label>
                                <input type="text" name="author" id="author" value="{{ old('author') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div class="space-y-1">
                                <label for="publisher" class="block text-sm font-medium text-gray-700">Penerbit</label>
                                <input type="text" name="publisher" id="publisher" value="{{ old('publisher') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div class="space-y-1">
                                <label for="publication_date" class="block text-sm font-medium text-gray-700">Tahun
                                    Terbit</label>
                                <input type="month" name="publication_date" id="publication_date"
                                    value="{{ old('publication_date') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg">
                            </div>
                        </div>

                        <div class="space-y-5">
                            <div class="space-y-1">
                                <label for="isbn" class="block text-sm font-medium text-gray-700">ISBN</label>
                                <input type="number" name="isbn" id="isbn" value="{{ old('isbn') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div class="space-y-1">
                                <label for="issn" class="block text-sm font-medium text-gray-700">ISSN</label>
                                <input type="number" name="issn" id="issn" value="{{ old('issn') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div class="space-y-1">
                                <label for="edition" class="block text-sm font-medium text-gray-700">Edisi</label>
                                <input type="text" name="edition" id="edition" value="{{ old('edition') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>

                            <div class="space-y-1">
                                <label for="genre" class="block text-sm font-medium text-gray-700">Genre</label>
                                <input type="text" name="genre" id="genre" value="{{ old('genre') }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">{{ old('description') }}</textarea>
                    </div>

                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">File Buku</label>
                        <input type="file" name="file" required
                            class="w-full text-gray-600 file:border-0 file:bg-indigo-100 file:text-indigo-700 file:px-4 file:py-2 file:rounded-lg file:cursor-pointer" />
                    </div>

                    <div class="mt-8 flex justify-end space-x-4">
                        <a href="{{ route('admin.index') }}"
                            class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                            Batal
                        </a>

                        <button type="submit"
                            class="px-6 py-2 border border-gray-150 rounded-lg shadow-sm text-black bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-200">
                            Simpan Softfile
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
