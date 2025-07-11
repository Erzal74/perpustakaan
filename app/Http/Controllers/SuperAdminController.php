<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function index()
    {
        $pendingUsers = User::where('role', 'user')->where('status', 'pending')->get();
        $approvedUsers = User::where('role', 'user')->whereIn('status', ['approved', 'disabled'])->get();

        return view('dashboard.superadmin', compact('pendingUsers', 'approvedUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        return back()->with('success', 'User berhasil disetujui.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return back()->with('success', 'User ditolak dan dihapus.');
    }

    public function disable($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'disabled';
        $user->save();

        return back()->with('success', 'User berhasil dinonaktifkan.');
    }

    public function enable($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        return back()->with('success', 'User berhasil diaktifkan kembali.');
    }
    public function createAdmin(Request $request)
{
    // Pastikan hanya superadmin yang bisa membuat admin/superadmin
    if (auth()->user()->role !== 'superadmin') {
        return back()->with('error', 'Unauthorized action.');
    }

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:admin,superadmin'
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'status' => 'approved', // Gunakan status bukan is_approved
        'email_verified_at' => now() // Verifikasi email otomatis
    ]);

    return back()->with('success', ucfirst($request->role) . ' berhasil dibuat');
}
public function listAdmins()
{
    $admins = User::whereIn('role', ['admin', 'superadmin'])
                ->orderBy('role')
                ->orderBy('name')
                ->get();

    return view('dashboard.admin-list', compact('admins'));
}
}
