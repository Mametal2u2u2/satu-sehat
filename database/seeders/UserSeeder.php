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
        $doctorUser = User::firstOrCreate(
            ['email' => 'budi@eklinik.com'],
            [
                'name' => 'dr. Budi Santoso, Sp.PD',
                'password' => Hash::make('password'),
                'username' => 'drbudi',
                'phone' => '081298765432',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $doctorUser->syncRoles(['Dokter']);

        // Apoteker Dummy User
        $apotekerUser = User::firstOrCreate(
            ['email' => 'apoteker@eklinik.com'],
            [
                'name' => 'Apt. Farhan, S.Farm',
                'password' => Hash::make('password'),
                'username' => 'apoteker',
                'phone' => '081211112222',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $apotekerUser->syncRoles(['Apoteker']);

        // Perawat Dummy User
        $perawatUser = User::firstOrCreate(
            ['email' => 'perawat@eklinik.com'],
            [
                'name' => 'Ns. Siti Rahma, S.Kep',
                'password' => Hash::make('password'),
                'username' => 'perawat',
                'phone' => '081233334444',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $perawatUser->syncRoles(['Perawat']);
    }
}
