<nav class="bg-white shadow sticky top-0 z-50 w-full">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">
            Knowledge Management System
        </h1>

        @auth
            <div class="flex items-center gap-4">
                <span class="text-gray-700">Halo, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-red-600 hover:underline">
                        Logout
                    </button>
                </form>
            </div>
        @endauth
    </div>
</nav>
