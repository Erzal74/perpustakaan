@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white shadow-xl rounded-lg overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold text-white">Admin & Superadmin Management</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('superadmin.dashboard') }}" 
                       class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white bg-opacity-20 text-white hover:bg-opacity-30">
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        <!-- Add Admin Button -->
        <div class="px-6 py-4 border-b border-gray-200">
            <button onclick="openCreateAdminModal()"
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Tambah Admin/Superadmin
            </button>
        </div>

        <!-- Admin List Section -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($admins as $admin)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full flex items-center justify-center 
                                        {{ $admin->role === 'superadmin' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' }} font-medium">
                                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $admin->name }}</div>
                                    <div class="text-sm text-gray-500">Registered: {{ $admin->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $admin->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($admin->role === 'superadmin')
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
                                    Superadmin
                                </span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    Admin
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $admin->status === 'approved' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($admin->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                @if ($admin->status === 'approved')
                                    <form action="{{ route('superadmin.disable', $admin->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            Disable
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('superadmin.enable', $admin->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-900">
                                            Enable
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Reuse the same Create Admin Modal from superadmin.blade.php -->
<div id="createAdminModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- ... (copy the exact same modal content from your superadmin.blade.php) ... -->
</div>

<script>
    function openCreateAdminModal() {
        document.getElementById('createAdminModal').classList.remove('hidden');
    }
    
    function closeCreateAdminModal() {
        document.getElementById('createAdminModal').classList.add('hidden');
    }
</script>
@endsection