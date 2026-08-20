<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\StockTransaction;
use App\Models\User;
use App\Models\Visit;
use App\Services\MedicalRecordService;
use App\Services\PrescriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClinicalFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_full_clinical_patient_flow_and_automatic_stock_deduction(): void
    {
        $patient = Patient::first();
        $doctor = Doctor::first();
        $branch = Branch::first();
        $medicine = Medicine::where('code', 'MED-PCT-500')->first();

        // Initial stock verification
        $this->assertEquals(100, $medicine->current_stock);
        $this->assertEquals(100, $medicine->batches()->first()->quantity);

        // 1. Patient Visit
        $visit = Visit::create([
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'branch_id' => $branch->id,
            'visit_date' => now()->toDateString(),
            'status' => 'waiting',
        ]);
        $this->assertEquals('waiting', $visit->status);

        // 2. Doctor Medical Record & Diagnosis
        $medicalRecordService = app(MedicalRecordService::class);
        $record = $medicalRecordService->createMedicalRecord([
            'visit_id' => $visit->id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'chief_complaint' => 'Demam tinggi dan sakit kepala sejak 2 hari lalu',
            'illness_history' => 'Tidak ada riwayat hipertensi',
            'physical_examination' => 'Kompos mentis, turgor kulit baik',
            'vital_signs' => [
                'blood_pressure' => '120/80',
                'pulse' => 84,
                'temp' => 38.5,
                'weight' => 65,
            ],
            'doctor_notes' => 'Istirahat cukup dan minum obat teratur',
        ], [
            [
                'icd10_code' => 'R50.9',
                'description' => 'Fever, unspecified',
                'type' => 'primary',
            ]
        ]);

        $this->assertDatabaseHas('medical_records', ['id' => $record->id]);
        $this->assertDatabaseHas('diagnoses', ['icd10_code' => 'R50.9']);
        $this->assertEquals('examining', $visit->fresh()->status);

        // 3. Electronic Prescription
        $prescriptionService = app(PrescriptionService::class);
        $prescription = $prescriptionService->createPrescription([
            'visit_id' => $visit->id,
            'doctor_id' => $doctor->id,
            'patient_id' => $patient->id,
            'status' => 'published',
            'notes' => 'Minum sesudah makan',
        ], [
            [
                'medicine_id' => $medicine->id,
                'dosage' => '500mg',
                'frequency' => '3x1 hari',
                'quantity' => 10,
                'instructions' => 'Sesudah makan',
            ]
        ]);

        $this->assertEquals('published', $prescription->status);

        // Stock should NOT be deducted yet while status is published
        $this->assertEquals(100, $medicine->fresh()->current_stock);

        // 4. Pharmacy Dispensing (Status change to completed)
        $apotekerUser = User::where('username', 'superadmin')->first();
        $prescriptionService->updateStatus($prescription, 'completed', $apotekerUser->id);

        // 5. Verification Assertions
        $updatedMedicine = $medicine->fresh();
        $this->assertEquals(90, $updatedMedicine->current_stock);
        $this->assertEquals(90, $medicine->batches()->first()->fresh()->quantity);

        // Stock transaction logged
        $this->assertDatabaseHas('stock_transactions', [
            'medicine_id' => $medicine->id,
            'type' => 'out',
            'quantity' => 10,
        ]);
    }
}
