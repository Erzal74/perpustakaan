@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Preview Excel: {{ $filename }}</h1>
                <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800">
                    Kembali
                </a>
            </div>

            <div class="w-full" style="height: 80vh;">
                <iframe src="{{ $googleDocsUrl }}" class="w-full h-full border-0"></iframe>
            </div>
        </div>
    </div>
@endsection
