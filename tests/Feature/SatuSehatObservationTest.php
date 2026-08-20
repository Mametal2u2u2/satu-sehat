<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Patient;
use App\Models\User;
use App\Models\Visit;
use App\Services\SatuSehatService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SatuSehatObservationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /**
     * Helper: buat MedicalRecord lengkap dengan vital signs.
     */
    protected function makeMedicalRecord(array $vitalSigns = []): MedicalRecord
    {
        $visit = Visit::create([
            'branch_id'    => Branch::first()->id,
            'patient_id'   => Patient::first()->id,
            'doctor_id'    => Doctor::first()->id,
            'visit_date'   => today(),
            'queue_number' => 1,
            'status'       => 'completed',
        ]);

        return MedicalRecord::create([
            'visit_id'   => $visit->id,
            'patient_id' => Patient::first()->id,
            'doctor_id'  => Doctor::first()->id,
            'chief_complaint' => 'Pusing dan lemas',
            'vital_signs'     => $vitalSigns,
        ]);
    }

    public function test_satusehat_sync_observation_sends_vital_signs(): void
    {
        $mr = $this->makeMedicalRecord([
            'systolic'    => 120,
            'diastolic'   => 80,
            'heart_rate'  => 72,
            'temperature' => 36.5,
            'spo2'        => 98,
        ]);

        Http::fake([
            '*/oauth2/v1/accesstoken' => Http::response(['access_token' => 'mocked_token'], 200),
            '*/Observation'           => Http::response(['resourceType' => 'Observation', 'id' => 'obs-mock'], 201),
        ]);

        $service = new SatuSehatService();
        $results = $service->syncObservation($mr->fresh('visit.patient'));

        // 5 parameter vital sign → 5 Observation sync
        $this->assertCount(5, $results);
        $this->assertArrayHasKey('systolic', $results);
        $this->assertArrayHasKey('heart_rate', $results);

        // Assert 5 log entries terbuat di DB
        $this->assertDatabaseCount('satu_sehat_logs', 5);
        $this->assertDatabaseHas('satu_sehat_logs', [
            'medical_record_id' => $mr->id,
            'is_success'        => 1,
        ]);
    }

    public function test_sync_observation_skips_missing_vital_signs(): void
    {
        // Hanya ada 2 parameter vital sign
        $mr = $this->makeMedicalRecord([
            'systolic'  => 130,
            'diastolic' => 85,
        ]);

        Http::fake([
            '*/oauth2/v1/accesstoken' => Http::response(['access_token' => 'mocked_token'], 200),
            '*/Observation'           => Http::response(['resourceType' => 'Observation', 'id' => 'obs-mock'], 201),
        ]);

        $service = new SatuSehatService();
        $results = $service->syncObservation($mr->fresh('visit.patient'));

        // Hanya 2 parameter yang disync
        $this->assertCount(2, $results);
        $this->assertDatabaseCount('satu_sehat_logs', 2);
    }

    public function test_sync_observation_endpoint_returns_422_if_no_vital_signs(): void
    {
        $user = User::factory()->create();
        $mr   = $this->makeMedicalRecord([]); // Tanpa vital signs

        $response = $this->actingAs($user)->postJson('/api/satusehat/sync-observation', [
            'medical_record_id' => $mr->id,
        ]);

        $response->assertStatus(422)
                 ->assertJson(['success' => false]);
    }

    public function test_sync_observation_endpoint_returns_200_on_success(): void
    {
        $user = User::factory()->create();
        $mr   = $this->makeMedicalRecord([
            'systolic'   => 118,
            'diastolic'  => 76,
            'heart_rate' => 68,
        ]);

        Http::fake([
            '*/oauth2/v1/accesstoken' => Http::response(['access_token' => 'mocked_token'], 200),
            '*/Observation'           => Http::response(['resourceType' => 'Observation', 'id' => 'obs-ok'], 201),
        ]);

        $response = $this->actingAs($user)->postJson('/api/satusehat/sync-observation', [
            'medical_record_id' => $mr->id,
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true])
                 ->assertJsonPath('message', 'Sync Observation berhasil (3 parameter)');
    }
}
