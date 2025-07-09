<aside class="w-64 bg-white shadow h-screen sticky top-0 p-4">
    <nav class="space-y-4 text-sm">
        @auth
            @if (Auth::user()->role === 'user')
                <div class="font-semibold text-gray-600 mb-2">User Menu</div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('user.dashboard') }}" class="text-blue-600 hover:underline">
                            Dashboard User
                        </a>
                    </li>
                </ul>
            @elseif(Auth::user()->role === 'admin')
                <div class="font-semibold text-gray-600 mb-2">Admin Menu</div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">
                            Dashboard Admin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.create') }}" class="text-gray-700 hover:underline">
                            Tambah Softfile
                        </a>
                    </li>
                </ul>
            @elseif(Auth::user()->role === 'superadmin')
                <div class="font-semibold text-gray-600 mb-2">Super Admin Menu</div>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('superadmin.dashboard') }}" class="text-blue-600 hover:underline">
                            Dashboard Superadmin
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('superadmin.dashboard') }}" class="text-gray-700 hover:underline">
                            Kelola User
                        </a>
                    </li>
                </ul>
            @endif
        @endauth
    </nav>
</aside>
