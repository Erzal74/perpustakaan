<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminAndSuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@kms.test'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'), // ganti di production
                'role' => 'superadmin',
                'status' => 'approved',
            ]
        );

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@kms.test'],
            [
                'name' => 'Admin KMS',
                'password' => Hash::make('password'), // ganti di production
                'role' => 'admin',
                'status' => 'approved',
            ]
        );
    }
}
