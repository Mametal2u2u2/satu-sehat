<?php

namespace Database\Seeders;

use App\Models\Ambulance;
use Illuminate\Database\Seeder;

class AmbulanceSeeder extends Seeder
{
    public function run(): void
    {
        Ambulance::create([
            'license_plate' => 'B 1234 PKM',
            'type'          => 'Roda 4',
            'brand'         => 'Toyota Hiace',
            'driver_name'   => 'Andi Supriadi',
            'driver_phone'  => '081298765400',
            'status'        => 'available',
            'notes'         => 'Ambulans utama klinik. Periksa rutin tiap bulan.',
        ]);
    }
}
