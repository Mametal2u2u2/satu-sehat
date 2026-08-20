<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::first();
        $doctorUser = User::where('username', 'drbudi')->first();

        if ($doctorUser && $branch) {
            Doctor::create([
                'user_id' => $doctorUser->id,
                'branch_id' => $branch->id,
                'nik' => '3171012345670001',
                'sip' => 'SIP-449/123/2024',
                'str' => 'STR-9988776655',
                'specialization' => 'Penyakit Dalam',
                'phone' => '081298765432',
                'email' => 'budi@eklinik.com',
                'status' => true,
            ]);
        }
    }
}
