<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\Visit;
use App\Services\SatuSehatService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SatuSehatServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_satusehat_sync_encounter_logs_request(): void
    {
        // Setup mock data
        $visit = Visit::create([
            'branch_id' => Branch::first()->id,
            'patient_id' => Patient::first()->id,
            'doctor_id' => Doctor::first()->id,
            'visit_date' => today(),
            'queue_number' => 1,
            'status' => 'completed',
        ]);
        $doctor = Doctor::first();
        $patient = Patient::first();

        $medicalRecord = MedicalRecord::create([
            'visit_id' => $visit->id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'chief_complaint' => 'Demam',
            'physical_examination' => 'Suhu 38C',
        ]);

        Diagnosis::create([
            'medical_record_id' => $medicalRecord->id,
            'icd10_code'        => 'R50.9',
            'description'       => 'Fever, unspecified',
        ]);

        // Mock Http Facade
        Http::fake([
            // Mock auth token
            '*/oauth2/v1/accesstoken' => Http::response(['access_token' => 'mocked_token'], 200),
            // Mock Encounter endpoint
            '*/Encounter' => Http::response([
                'resourceType' => 'Encounter',
                'id' => 'mocked-encounter-id',
            ], 201),
        ]);

        $service = new SatuSehatService();
        $result = $service->syncEncounter($medicalRecord->fresh('visit.patient', 'visit.doctor', 'diagnoses'));

        // Assert response dari mock ter-return
        $this->assertEquals('mocked-encounter-id', $result['id']);

        // Assert Log tercatat di database
        $this->assertDatabaseHas('satu_sehat_logs', [
            'medical_record_id' => $medicalRecord->id,
            'status_code' => 201,
            'is_success' => 1,
        ]);
    }
}
