<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\Room;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branch = Branch::create([
            'code' => 'KKL-001',
            'name' => 'Klinik Utama Jakarta',
            'address' => 'Jl. Jendral Sudirman No. 45, Jakarta Pusat',
            'phone' => '021-5551234',
            'email' => 'jakarta@eklinik.com',
            'pic' => 'Dr. H. Ahmad Wijaya',
            'status' => true,
        ]);

        Room::create([
            'branch_id' => $branch->id,
            'name' => 'Poli Umum 1',
            'type' => 'Poli Umum',
            'capacity' => 1,
            'status' => true,
        ]);

        Room::create([
            'branch_id' => $branch->id,
            'name' => 'Poli Gigi',
            'type' => 'Poli Gigi',
            'capacity' => 1,
            'status' => true,
        ]);
    }
}
