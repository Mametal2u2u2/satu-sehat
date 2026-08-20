<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use App\Services\SatuSehatService;
use Illuminate\Http\Request;
use Exception;

class SatuSehatController extends Controller
{
    protected SatuSehatService $service;

    public function __construct(SatuSehatService $service)
    {
        $this->service = $service;
    }

    /**
     * Sync Encounter (Kunjungan + Diagnosis) ke SatuSehat FHIR.
     */
    public function syncEncounter(Request $request)
    {
        $request->validate(['medical_record_id' => 'required|exists:medical_records,id']);

        $mr = MedicalRecord::with(['visit.patient', 'visit.doctor', 'diagnoses'])->findOrFail($request->medical_record_id);

        try {
            $result = $this->service->syncEncounter($mr);

            return response()->json(['success' => true, 'message' => 'Sync Encounter berhasil', 'data' => $result]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal sync: ' . $e->getMessage()], 400);
        }
    }

    /**
     * Sync Observation (Vital Signs) ke SatuSehat FHIR.
     */
    public function syncObservation(Request $request)
    {
        $request->validate(['medical_record_id' => 'required|exists:medical_records,id']);

        $mr = MedicalRecord::with(['visit.patient'])->findOrFail($request->medical_record_id);

        if (empty($mr->vital_signs)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data vital signs pada rekam medis ini.',
            ], 422);
        }

        try {
            $results = $this->service->syncObservation($mr);

            return response()->json([
                'success' => true,
                'message' => 'Sync Observation berhasil (' . count($results) . ' parameter)',
                'data'    => $results,
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal sync observation: ' . $e->getMessage()], 400);
        }
    }
}
