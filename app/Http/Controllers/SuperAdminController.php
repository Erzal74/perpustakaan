<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}
