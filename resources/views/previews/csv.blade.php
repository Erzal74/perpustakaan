@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h1 class="text-2xl font-bold">Preview CSV: {{ $filename }}</h1>
                <a href="{{ url()->previous() }}" class="text-blue-600 hover:text-blue-800">
                    Kembali
                </a>
            </div>

            <div class="overflow-auto">
                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        @if (isset($data[0]))
                            <tr>
                                @foreach ($data[0] as $header)
                                    <th class="border px-4 py-2">{{ $header }}</th>
                                @endforeach
                            </tr>
                        @endif
                    </thead>
                    <tbody>
                        @foreach (array_slice($data, 1) as $row)
                            <tr>
                                @foreach ($row as $cell)
                                    <td class="border px-4 py-2">{{ $cell }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
