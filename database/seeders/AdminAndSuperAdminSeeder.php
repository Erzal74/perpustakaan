<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAndSuperAdminSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk membuat akun Super Admin dan Admin.
     *
     * Catatan: Kolom 'email' digunakan untuk menyimpan NIP (Nomor Induk Pegawai)
     * karena sistem sekarang menggunakan NIP sebagai identifier login.
     * Format NIP: string angka, maksimal 8 digit.
     */
    public function run(): void
    {
        // Super Admin — NIP: 10000001
        User::updateOrCreate(
            ['email' => '10000001'], // ← Ini NIP, bukan email
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // ⚠️ Ganti di production!
                'role' => 'superadmin',
                'status' => 'approved',
            ]
        );

        // Admin — NIP: 10000002
        User::updateOrCreate(
            ['email' => '10000002'], // ← Ini NIP
            [
                'name' => 'Admin KMS',
                'password' => Hash::make('password'), // ⚠️ Ganti di production!
                'role' => 'admin',
                'status' => 'approved',
            ]
        );
    }
}