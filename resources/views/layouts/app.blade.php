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
    <nav class="bg-white shadow px-4 sm:px-6 lg:px-8 py-4">
        <div class="w-full flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <i class="fas fa-book-reader text-blue-600 text-xl"></i>
                <span class="text-lg font-semibold">Knowledge Management System</span>
            </div>
            <div class="flex items-center space-x-4 text-sm">
                @auth
                    <span class="text-gray-700">
                        Selamat datang,
                        <span class="font-semibold text-blue-600">{{ Auth::user()->name }}</span>
                        @if (Auth::user()->role)
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full ml-2">
                                {{ ucfirst(Auth::user()->role) }}
                            </span>
                        @endif
                    </span>
                    <a href="{{ route('logout') }}" class="text-red-600 hover:text-red-700 transition"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                @endauth
            </div>
        </div>
    </nav>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

    <!-- Main Content -->
    <main class="flex-1 w-full">
        <div class="py-6 px-4 sm:px-6 lg:px-8">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="text-center text-sm text-gray-500 py-4 border-t">
        &copy; {{ date('Y') }} Knowledge Management System.
    </footer>
</body>

</html>
