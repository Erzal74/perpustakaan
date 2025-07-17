<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'KMS') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <script defer>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            const bars = document.getElementById('icon-bars');
            const times = document.getElementById('icon-times');

            menu.classList.toggle('hidden');
            bars.classList.toggle('hidden');
            times.classList.toggle('hidden');
        }
    </script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50 text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-3">
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-2 rounded-xl shadow-lg">
                        <i class="fas fa-book-reader text-white text-lg"></i>
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-lg font-bold text-gray-800">KMS</div>
                        <div class="text-xs text-gray-500">Knowledge Management System</div>
                    </div>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-6">
                    @auth
                        <div class="flex items-center space-x-3">
                            <div class="bg-gradient-to-r from-blue-500 to-indigo-500 w-8 h-8 rounded-full flex items-center justify-center shadow-md">
                                <i class="fas fa-user text-white text-sm"></i>
                            </div>
                            <div class="text-sm">
                                <div class="font-semibold">{{ Auth::user()->name }}</div>
                                @if (Auth::user()->role)
                                    <div class="text-xs text-gray-500 capitalize">{{ Auth::user()->role }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="h-6 w-px bg-gray-300"></div>
                    @endauth
                    <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="flex items-center text-sm text-gray-600 hover:text-red-600 transition px-3 py-2 rounded-lg hover:bg-red-50">
                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                    </button>
                </div>

                <!-- Mobile Toggle -->
                <div class="md:hidden">
                    <button onclick="toggleMenu()" data-menu-toggle
                        class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg">
                        <i id="icon-bars" class="fas fa-bars text-lg"></i>
                        <i id="icon-times" class="fas fa-times text-lg hidden"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white/95 border-t border-gray-200 backdrop-blur-md">
            <div class="px-4 py-4 space-y-4">
                @auth
                    <div class="flex items-center space-x-3 pb-3 border-b border-gray-200">
                        <div class="bg-gradient-to-r from-blue-500 to-indigo-500 w-10 h-10 rounded-full flex items-center justify-center shadow-md">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <div class="font-semibold">{{ Auth::user()->name }}</div>
                            @if (Auth::user()->role)
                                <div class="text-sm text-gray-500 capitalize">{{ Auth::user()->role }}</div>
                            @endif
                        </div>
                    </div>
                @endauth
                <button onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="w-full flex items-center text-left text-gray-600 hover:text-red-600 transition p-3 rounded-lg hover:bg-red-50">
                    <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                </button>
            </div>
        </div>
    </nav>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>

    <!-- Main Content -->
    <main class="flex-1 relative">
        <!-- Background Decoration -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-gradient-to-br from-blue-400/20 to-indigo-600/20 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-gradient-to-br from-indigo-400/20 to-purple-600/20 rounded-full blur-3xl"></div>
        </div>

        <!-- Main Content Wrapper -->
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-white/70 backdrop-blur-sm rounded-2xl shadow-xl border border-gray-200 p-6 sm:p-8">
                @yield('content')
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="relative z-10 bg-white/60 backdrop-blur-sm border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Knowledge Management System
        </div>
    </footer>

</body>
</html>
