<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineBatch;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $catAnalgesik = MedicineCategory::create([
            'name' => 'Analgesik & Antipiretik',
            'description' => 'Obat pereda nyeri dan penurun panas',
        ]);

        $catAntibiotik = MedicineCategory::create([
            'name' => 'Antibiotik',
            'description' => 'Obat pengobatan infeksi bakteri',
        ]);

        // Paracetamol
        $pct = Medicine::create([
            'category_id' => $catAnalgesik->id,
            'code' => 'MED-PCT-500',
            'name' => 'Paracetamol 500mg',
            'dosage_form' => 'Tablet',
            'unit' => 'tablet',
            'dosage_strength' => '500mg',
            'minimum_stock' => 20,
            'current_stock' => 100,
            'status' => true,
        ]);

        MedicineBatch::create([
            'medicine_id' => $pct->id,
            'batch_number' => 'BATCH-PCT-001',
            'expired_date' => '2027-12-31',
            'quantity' => 100,
            'purchase_price' => 500,
            'selling_price' => 1000,
        ]);

        // Amoxicillin
        $amox = Medicine::create([
            'category_id' => $catAntibiotik->id,
            'code' => 'MED-AMX-500',
            'name' => 'Amoxicillin 500mg',
            'dosage_form' => 'Kaplet',
            'unit' => 'kaplet',
            'dosage_strength' => '500mg',
            'minimum_stock' => 15,
            'current_stock' => 50,
            'status' => true,
        ]);

        MedicineBatch::create([
            'medicine_id' => $amox->id,
            'batch_number' => 'BATCH-AMX-001',
            'expired_date' => '2026-11-30',
            'quantity' => 50,
            'purchase_price' => 1200,
            'selling_price' => 2500,
        ]);
    }
}
