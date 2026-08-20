<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineBatch;
use App\Models\StockTransaction;
use Illuminate\Support\Facades\DB;
use Exception;

class PharmacyService
{
    /**
     * Deduct stock for a medicine (FIFO batch processing).
     */
    public function deductStock(Medicine $medicine, int $quantity, ?int $userId = null, string $notes = 'Pengeluaran resep'): void
    {
        DB::transaction(function () use ($medicine, $quantity, $userId, $notes) {
            if ($medicine->current_stock < $quantity) {
                throw new Exception("Stok obat {$medicine->name} tidak mencukupi. (Tersedia: {$medicine->current_stock}, Dibutuhkan: {$quantity})");
            }

            $remainingNeeded = $quantity;

            $batches = MedicineBatch::where('medicine_id', $medicine->id)
                ->where('quantity', '>', 0)
                ->orderBy('expired_date', 'asc')
                ->get();

            foreach ($batches as $batch) {
                if ($remainingNeeded <= 0) {
                    break;
                }

                $deductFromBatch = min($batch->quantity, $remainingNeeded);
                $batch->decrement('quantity', $deductFromBatch);
                $remainingNeeded -= $deductFromBatch;

                StockTransaction::create([
                    'transaction_number' => 'TRX-OUT-' . time() . '-' . rand(100, 999),
                    'medicine_id' => $medicine->id,
                    'medicine_batch_id' => $batch->id,
                    'user_id' => $userId,
                    'type' => 'out',
                    'quantity' => $deductFromBatch,
                    'notes' => $notes,
                ]);
            }

            $medicine->decrement('current_stock', $quantity);
        });
    }
}
