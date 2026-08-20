<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Mendaftarkan kunjungan baru (booking online) untuk pasien.
     * Otomatis assign nomor antrian berdasarkan kunjungan yang sudah ada hari itu.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id'  => 'required|exists:doctors,id',
            'branch_id'  => 'required|exists:branches,id',
            'visit_date' => 'required|date|after_or_equal:today',
            'notes'      => 'nullable|string|max:500',
        ]);

        // Cek apakah pasien sudah punya booking pada dokter & tanggal yang sama
        $existing = Visit::where('patient_id', $validated['patient_id'])
            ->where('doctor_id', $validated['doctor_id'])
            ->whereDate('visit_date', $validated['visit_date'])
            ->whereNotIn('status', ['cancelled', 'completed'])
            ->exists();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Pasien sudah memiliki kunjungan aktif pada dokter dan tanggal yang sama.',
            ], 409);
        }

        // Assign nomor antrian berikutnya untuk kombinasi dokter+cabang+tanggal
        $lastQueue = Visit::where('doctor_id', $validated['doctor_id'])
            ->where('branch_id', $validated['branch_id'])
            ->whereDate('visit_date', $validated['visit_date'])
            ->max('queue_number') ?? 0;

        $queueNumber = $lastQueue + 1;

        $visit = Visit::create([
            'patient_id'   => $validated['patient_id'],
            'doctor_id'    => $validated['doctor_id'],
            'branch_id'    => $validated['branch_id'],
            'visit_date'   => $validated['visit_date'],
            'queue_number' => $queueNumber,
            'status'       => 'waiting',
            'notes'        => $validated['notes'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil. Nomor antrian Anda: ' . $queueNumber,
            'data'    => [
                'visit_id'     => $visit->id,
                'queue_number' => $queueNumber,
                'visit_date'   => $visit->visit_date,
                'status'       => $visit->status,
            ],
        ], 201);
    }

    /**
     * Riwayat kunjungan milik pasien tertentu.
     */
    public function index(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
        ]);

        $visits = Visit::with(['doctor.user', 'branch'])
            ->where('patient_id', $request->patient_id)
            ->orderByDesc('visit_date')
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'Riwayat kunjungan',
            'data'    => $visits,
        ]);
    }

    /**
     * Membatalkan booking kunjungan (pasien dapat membatalkan sebelum examined).
     */
    public function cancel(Request $request, Visit $visit)
    {
        if (!in_array($visit->status, ['waiting'])) {
            return response()->json([
                'success' => false,
                'message' => 'Kunjungan tidak dapat dibatalkan karena sudah dalam status: ' . $visit->status,
            ], 422);
        }

        $visit->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Kunjungan berhasil dibatalkan.',
        ]);
    }
}
