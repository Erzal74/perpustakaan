@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold text-indigo-600 mb-4">{{ $softfile->title }}</h2>
        <p class="mb-4 text-gray-600">{{ $softfile->description }}</p>

        <iframe src="{{ asset('storage/' . $softfile->file_path) }}" class="w-full h-[600px] border" frameborder="0"></iframe>

        <div class="mt-4">
            <a href="{{ route('user.download', $softfile->id) }}"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Download File</a>
            <a href="{{ route('user.dashboard') }}" class="ml-2 text-gray-600 hover:underline">← Kembali</a>
        </div>
    </div>
@endsection
