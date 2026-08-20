<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class QueueController extends Controller
{
    /**
     * Dapatkan antrian saat ini (yang sedang dilayani) dan nomor pasien.
     */
    public function current(Request $request)
    {
        $branchId = $request->query('branch_id');
        $doctorId = $request->query('doctor_id');

        if (!$branchId || !$doctorId) {
            return response()->json(['success' => false, 'message' => 'branch_id and doctor_id are required'], 400);
        }

        // Cari nomor antrian yang sedang diperiksa (examining) atau panggil (called)
        $currentServing = Visit::where('branch_id', $branchId)
            ->where('doctor_id', $doctorId)
            ->whereDate('visit_date', today())
            ->whereIn('status', ['examining'])
            ->orderBy('queue_number')
            ->first();

        // Cari antrian milik pasien yang sedang login (jika ada kunjungan hari ini)
        $patientId = $request->query('patient_id', 0);
        $myVisit = Visit::where('patient_id', $patientId)
            ->where('branch_id', $branchId)
            ->where('doctor_id', $doctorId)
            ->whereDate('visit_date', today())
            ->first();

        $myQueueNumber = $myVisit ? $myVisit->queue_number : null;
        $currentQueueNumber = $currentServing ? $currentServing->queue_number : 0;
        
        // Kalkulasi sisa antrian di depan (jika antrian pasien > antrian saat ini)
        $remaining = 0;
        $estimatedTimeMinutes = 0;

        if ($myQueueNumber && $myQueueNumber > $currentQueueNumber) {
            $remaining = Visit::where('branch_id', $branchId)
                ->where('doctor_id', $doctorId)
                ->whereDate('visit_date', today())
                ->where('queue_number', '>', $currentQueueNumber)
                ->where('queue_number', '<', $myQueueNumber)
                ->where('status', 'waiting')
                ->count();
            
            // Asumsi 1 pasien = 15 menit
            $estimatedTimeMinutes = $remaining * 15;
        }

        return response()->json([
            'success' => true,
            'data' => [
                'current_queue' => $currentQueueNumber,
                'my_queue'      => $myQueueNumber,
                'remaining'     => $remaining,
                'estimated_time_minutes' => $estimatedTimeMinutes,
                'status'        => $myVisit ? $myVisit->status : null,
            ]
        ]);
    }
}
