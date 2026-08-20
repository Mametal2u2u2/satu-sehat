<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();

        // Buat user perawat baru
        $nurseUser = User::create([
            'name'      => 'Sari Dewi, S.Kep',
            'email'     => 'sari@eklinik.com',
            'password'  => bcrypt('password'),
            'username'  => 'sari_kep',
            'phone'     => '085711122233',
            'branch_id' => $branch?->id,
            'status'    => true,
        ]);
        $nurseUser->assignRole('Perawat');

        Employee::create([
            'user_id'       => $nurseUser->id,
            'branch_id'     => $branch->id,
            'nik'           => '3171012345678901',
            'str'           => 'STR-KEP-112233',
            'employee_type' => 'perawat',
            'position'      => 'Perawat Pelaksana',
            'join_date'     => '2024-01-15',
            'status'        => true,
        ]);

        // Buat profil employee untuk dokter yang sudah ada
        $doctorUser = User::where('username', 'drbudi')->first();
        if ($doctorUser) {
            Employee::create([
                'user_id'       => $doctorUser->id,
                'branch_id'     => $branch->id,
                'nik'           => '3171012345670001',
                'str'           => 'STR-9988776655',
                'sip'           => 'SIP-449/123/2024',
                'employee_type' => 'dokter',
                'position'      => 'Dokter Spesialis Penyakit Dalam',
                'join_date'     => '2023-06-01',
                'status'        => true,
            ]);
        }
    }
}
