<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();

        // Super Admin
        $admin = User::create([
            'name' => 'Super Administrator',
            'email' => 'admin@eklinik.com',
            'password' => Hash::make('password'),
            'username' => 'superadmin',
            'phone' => '081234567890',
            'branch_id' => $branch?->id,
            'status' => true,
        ]);
        $admin->assignRole('Super Admin');

        // Dokter Dummy User
        $doctorUser = User::create([
            'name' => 'dr. Budi Santoso, Sp.PD',
            'email' => 'budi@eklinik.com',
            'password' => Hash::make('password'),
            'username' => 'drbudi',
            'phone' => '081298765432',
            'branch_id' => $branch?->id,
            'status' => true,
        ]);
        $doctorUser->assignRole('Dokter');
    }
}
