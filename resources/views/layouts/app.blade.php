<!DOCTYPE html>
<html lang="id" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'KMS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
@stack('scripts')

<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow px-6 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <i class="fas fa-book-reader text-indigo-600 text-xl"></i>
                <span class="text-lg font-bold">Knowledge Management System</span>
            </div>
            <div class="flex items-center space-x-4 text-sm">
                @auth
                    <span class="text-gray-700">
                        Selamat datang,
                        <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span>
                        @if (Auth::user()->role)
                            <span class="text-xs bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full ml-2">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        @endif
                    </span>
                @endauth
                <a href="{{ route('logout') }}" class="text-red-600 hover:underline"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
            </div>
        </div>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

    <!-- Main Content -->
    <main class="flex-1">
        <div class="max-w-7xl mx-auto py-10 px-4">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center text-sm text-gray-500 py-4 border-t">
        &copy; {{ date('Y') }} Knowledge Management System.
    </footer>

</body>

</html>
