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

        // 1. Super Admin
        $superAdmin = User::updateOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Super Administrator',
                'email' => 'admin@eklinik.com',
                'password' => Hash::make('password'),
                'phone' => '081234567890',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $superAdmin->syncRoles(['Super Admin']);

        // 2. Admin Klinik
        $adminKlinik = User::updateOrCreate(
            ['username' => 'adminklinik'],
            [
                'name' => 'Admin Operasional Klinik',
                'email' => 'adminklinik@eklinik.com',
                'password' => Hash::make('password'),
                'phone' => '081299990001',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $adminKlinik->syncRoles(['Admin Klinik']);

        // 3. Dokter
        $doctorUser = User::updateOrCreate(
            ['username' => 'drbudi'],
            [
                'name' => 'dr. Budi Santoso, Sp.PD',
                'email' => 'budi@eklinik.com',
                'password' => Hash::make('password'),
                'phone' => '081298765432',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $doctorUser->syncRoles(['Dokter']);

        // 4. Perawat
        $perawatUser = User::updateOrCreate(
            ['username' => 'perawat'],
            [
                'name' => 'Ns. Siti Rahma, S.Kep',
                'email' => 'perawat@eklinik.com',
                'password' => Hash::make('password'),
                'phone' => '081233334444',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $perawatUser->syncRoles(['Perawat']);

        // 5. Petugas Pendaftaran
        $pendaftaranUser = User::updateOrCreate(
            ['username' => 'pendaftaran'],
            [
                'name' => 'Ahmad Fauzi (Front Desk)',
                'email' => 'pendaftaran@eklinik.com',
                'password' => Hash::make('password'),
                'phone' => '081255556666',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $pendaftaranUser->syncRoles(['Petugas Pendaftaran']);

        // 6. Pasien
        $pasienUser = User::updateOrCreate(
            ['username' => 'pasien'],
            [
                'name' => 'Budi Santoso (Pasien)',
                'email' => 'pasien@eklinik.com',
                'password' => Hash::make('password'),
                'phone' => '085612345678',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $pasienUser->syncRoles(['Pasien']);

        // 7. Apoteker (Staff Farmasi)
        $apotekerUser = User::updateOrCreate(
            ['username' => 'apoteker'],
            [
                'name' => 'Apt. Farhan, S.Farm',
                'email' => 'apoteker@eklinik.com',
                'password' => Hash::make('password'),
                'phone' => '081211112222',
                'branch_id' => $branch?->id,
                'status' => true,
            ]
        );
        $apotekerUser->syncRoles(['Apoteker']);
    }
}
