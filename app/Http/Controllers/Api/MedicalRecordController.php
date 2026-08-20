<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Services\MedicalRecordService;
use Illuminate\Http\Request;

class MedicalRecordController extends Controller
{
    protected MedicalRecordService $service;

    public function __construct(MedicalRecordService $service)
    {
        $this->service = $service;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'visit_id' => 'required|exists:visits,id',
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'chief_complaint' => 'required|string',
            'illness_history' => 'nullable|string',
            'physical_examination' => 'nullable|string',
            'vital_signs' => 'nullable|array',
            'doctor_notes' => 'nullable|string',
            'follow_up_date' => 'nullable|date',
            'diagnoses' => 'nullable|array',
            'diagnoses.*.icd10_code' => 'required_with:diagnoses|string',
            'diagnoses.*.description' => 'required_with:diagnoses|string',
            'diagnoses.*.type' => 'nullable|in:primary,secondary',
        ]);

        $record = $this->service->createMedicalRecord($validated, $request->input('diagnoses', []));

        return response()->json([
            'success' => true,
            'message' => 'Rekam medis berhasil disimpan',
            'data' => $record,
        ], 201);
    }

    public function show(MedicalRecord $medicalRecord)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail rekam medis',
            'data' => $medicalRecord->load(['diagnoses', 'visit', 'patient', 'doctor.user']),
        ]);
    }
}
