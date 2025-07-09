<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'KMS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 text-gray-800">
    {{-- Navbar --}}
    <x-navbar />

    <div class="flex">
        {{-- Sidebar (opsional, bisa dihilangkan kalau tidak perlu) --}}
        {{-- <x-sidebar /> --}}

        <main class="flex-1 px-4 py-6">
            @yield('content')
        </main>
    </div>
</body>

</html>
