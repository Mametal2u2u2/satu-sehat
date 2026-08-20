<?php

namespace App\Services;

use App\Models\Prescription;
use App\Models\Medicine;
use Illuminate\Support\Facades\DB;
use Exception;

class PrescriptionService
{
    protected PharmacyService $pharmacyService;

    public function __construct(PharmacyService $pharmacyService)
    {
        $this->pharmacyService = $pharmacyService;
    }

    public function createPrescription(array $data, array $items): Prescription
    {
        return DB::transaction(function () use ($data, $items) {
            $data['prescription_number'] = 'RX-' . date('Ymd') . '-' . rand(1000, 9999);
            $data['status'] = $data['status'] ?? 'draft';

            $prescription = Prescription::create($data);

            foreach ($items as $item) {
                $prescription->items()->create([
                    'medicine_id' => $item['medicine_id'],
                    'dosage' => $item['dosage'] ?? null,
                    'frequency' => $item['frequency'] ?? null,
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'] ?? 'pcs',
                    'instructions' => $item['instructions'] ?? null,
                ]);
            }

            return $prescription->load('items.medicine');
        });
    }

    public function updateStatus(Prescription $prescription, string $status, ?int $userId = null): Prescription
    {
        return DB::transaction(function () use ($prescription, $status, $userId) {
            if ($prescription->status === 'completed') {
                throw new Exception('Resep yang sudah diserahkan (completed) tidak dapat diubah lagi.');
            }

            if ($status === 'completed') {
                foreach ($prescription->items as $item) {
                    $medicine = $item->medicine;
                    $this->pharmacyService->deductStock(
                        $medicine,
                        $item->quantity,
                        $userId,
                        "Pengeluaran Resep No: {$prescription->prescription_number}"
                    );
                }
            }

            $prescription->update(['status' => $status]);

            return $prescription->load('items.medicine');
        });
    }
}
