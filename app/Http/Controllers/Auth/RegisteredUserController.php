<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form registrasi.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Tangani proses registrasi pengguna baru.
     *
     * Catatan: Meskipun input disebut "NIP", data disimpan di kolom `email`
     * di database untuk memanfaatkan infrastruktur otentikasi Laravel yang sudah ada.
     * NIP divalidasi sebagai string angka dengan panjang maksimal 8 digit.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input dengan aturan khusus NIP
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'regex:/^\d{1,8}$/',
                'max:8',
                'unique:users'
            ],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            // Pesan error kustom
            'email.regex' => 'NIP harus berupa angka tanpa spasi atau simbol.',
            'email.max' => 'NIP tidak boleh lebih dari 8 digit.',
            'email.unique' => 'NIP ini sudah terdaftar. Silakan gunakan NIP lain.',
        ]);

        // Simpan user — NIP disimpan di kolom `email`
        User::create([
            'name' => $request->name,
            'email' => $request->email, // ← ini sebenarnya NIP
            'password' => Hash::make($request->password),
            'role' => 'user', // default: hanya user yang bisa register
            'status' => 'pending', // harus di-approve oleh superadmin
        ]);

        return redirect()->route('login')->with('status', 'Registrasi berhasil! Menunggu persetujuan superadmin.');
    }
}