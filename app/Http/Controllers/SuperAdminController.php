<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

        // Cek jika user yang akan dinonaktifkan adalah superadmin yang sedang login
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menonaktifkan akun sendiri.');
        }

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
        if (Auth::guest() || Auth::user()->role !== 'superadmin') {
            return back()->with('error', 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nip' => [
                'required',
                'string',
                'size:8', // HARUS tepat 8 digit
                'regex:/^\d{8}$/', // hanya angka, 8 digit
                'unique:users,email', // simpan di kolom email, jadi cek uniqueness di kolom email
            ],
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,superadmin'
        ]);

        try {
            // Buat user baru
            User::create([
                'name' => $validated['name'],
                'email' => $validated['nip'], // simpan NIP ke kolom email
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'status' => 'approved',
                'email_verified_at' => now()
            ]);

            return redirect()
                ->route('superadmin.admins.list')
                ->with('success', 'Admin baru berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Gagal menambahkan admin: ' . $e->getMessage());
        }
    }

    public function listAdmins(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'superadmin'])
                    ->orderBy('role')
                    ->orderBy('name');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        $admins = $query->get();

        return view('dashboard.admin-list', compact('admins'));
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        $user->forceDelete();

        return back()->with('success', 'User berhasil dihapus permanen.');
    }
}
