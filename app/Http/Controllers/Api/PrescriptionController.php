<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Services\PrescriptionService;
use Illuminate\Http\Request;
use Exception;

class PrescriptionController extends Controller
{
    protected PrescriptionService $service;

    public function __construct(PrescriptionService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'doctor_id' => 'required|exists:doctors,id',
            'patient_id' => 'required|exists:patients,id',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medicine_id' => 'required|exists:medicines,id',
            'items.*.dosage' => 'nullable|string',
            'items.*.frequency' => 'nullable|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.instructions' => 'nullable|string',
        ]);

        $prescription = $this->service->createPrescription($validated, $request->items);

        return response()->json([
            'success' => true,
            'message' => 'Resep elektronik berhasil diterbitkan',
            'data' => $prescription,
        ], 201);
    }

    public function updateStatus(Request $request, Prescription $prescription)
    {
        $request->validate([
            'status' => 'required|in:draft,published,processing,completed,cancelled',
        ]);

        try {
            $updated = $this->service->updateStatus($prescription, $request->status, $request->user()?->id);

            return response()->json([
                'success' => true,
                'message' => 'Status resep berhasil diperbarui',
                'data' => $updated,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }
}
