<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        Patient::create([
            'rm_number' => 'RM-2026-0001',
            'nik' => '3171012005900002',
            'name' => 'Siti Nurhaliza',
            'birth_place' => 'Jakarta',
            'birth_date' => '1990-05-20',
            'gender' => 'P',
            'address' => 'Jl. Kebon Jeruk No. 12, Jakarta Barat',
            'phone' => '085612345678',
            'email' => 'siti@example.com',
            'emergency_contact' => '085699998888 (Suami)',
            'allergies' => 'Paracetamol, Penicillin',
            'status' => 'active',
        ]);
    }
}
