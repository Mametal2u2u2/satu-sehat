<?php

namespace Database\Seeders;

use App\Models\ShiftType;
use Illuminate\Database\Seeder;

class ShiftTypeSeeder extends Seeder
{
    public function run(): void
    {
        ShiftType::insert([
            ['name' => 'Pagi',  'start_time' => '07:00:00', 'end_time' => '14:00:00', 'color' => '#3B82F6', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Siang', 'start_time' => '14:00:00', 'end_time' => '21:00:00', 'color' => '#F59E0B', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Malam', 'start_time' => '21:00:00', 'end_time' => '07:00:00', 'color' => '#8B5CF6', 'status' => true, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
