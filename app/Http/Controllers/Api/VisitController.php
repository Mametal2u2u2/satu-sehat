<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Visit;
use Illuminate\Http\Request;

class VisitController extends Controller
{
    public function index()
    {
        $visits = Visit::with(['patient', 'doctor.user', 'branch', 'room'])->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Daftar kunjungan pasien',
            'data' => $visits,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:doctors,id',
            'branch_id' => 'required|exists:branches,id',
            'room_id' => 'nullable|exists:rooms,id',
            'visit_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $visit = Visit::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Kunjungan pasien berhasil dibuat',
            'data' => $visit->load(['patient', 'doctor', 'branch']),
        ], 201);
    }

    public function show(Visit $visit)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail kunjungan',
            'data' => $visit->load(['patient', 'doctor.user', 'branch', 'room', 'medicalRecord.diagnoses', 'prescription.items.medicine']),
        ]);
    }

    public function updateStatus(Request $request, Visit $visit)
    {
        $request->validate([
            'status' => 'required|in:waiting,triage,examining,pharmacy,completed,cancelled',
        ]);

        $visit->update(['status' => $request->status]);

        // Dispatch broadcasting event for realtime queue tracking
        event(new \App\Events\QueueUpdated($visit));

        return response()->json([
            'success' => true,
            'message' => 'Status kunjungan berhasil diperbarui',
            'data' => $visit,
        ]);
    }
}
