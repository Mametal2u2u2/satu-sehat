<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            BranchSeeder::class,
            UserSeeder::class,
            DoctorSeeder::class,
            PatientSeeder::class,
            MedicineSeeder::class,
            ShiftTypeSeeder::class,
            AmbulanceSeeder::class,
            EmployeeSeeder::class,
            ArticleSeeder::class,
        ]);
    }
}
