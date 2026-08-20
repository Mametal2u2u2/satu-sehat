<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Models\Visit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MobileApiFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_patient_can_get_current_queue(): void
    {
        $branch = Branch::first();
        $doctor = Doctor::first();
        
        $patient = Patient::create([
            'rm_number' => 'RM001', 'nik' => '111', 'name' => 'Budi'
        ]);
        $user = User::factory()->create();
        
        $otherPatient1 = Patient::create(['rm_number' => 'RM002', 'nik' => '222', 'name' => 'A']);
        $otherPatient2 = Patient::create(['rm_number' => 'RM003', 'nik' => '333', 'name' => 'B']);

        // Buat 3 kunjungan simulasi
        Visit::create([
            'branch_id' => $branch->id,
            'patient_id' => $otherPatient1->id, // Pasien lain
            'doctor_id' => $doctor->id,
            'visit_date' => today(),
            'queue_number' => 1,
            'status' => 'examining',
        ]);

        Visit::create([
            'branch_id' => $branch->id,
            'patient_id' => $otherPatient2->id, // Pasien lain
            'doctor_id' => $doctor->id,
            'visit_date' => today(),
            'queue_number' => 2,
            'status' => 'waiting',
        ]);

        // Kunjungan pasien yang login
        $myVisit = Visit::create([
            'branch_id' => $branch->id,
            'patient_id' => $patient->id,
            'doctor_id' => $doctor->id,
            'visit_date' => today(),
            'queue_number' => 3,
            'status' => 'waiting',
        ]);

        $response = $this->actingAs($user)->getJson("/api/mobile/queues/current?branch_id={$branch->id}&doctor_id={$doctor->id}&patient_id={$patient->id}");

        $response->assertStatus(200)
                 ->assertJson([
                     'success' => true,
                     'data' => [
                         'current_queue' => 1,
                         'my_queue' => 3,
                         'remaining' => 1, // Ada antrian nomor 2 di antara 1 dan 3
                         'estimated_time_minutes' => 15,
                         'status' => 'waiting',
                     ]
                 ]);
    }

    public function test_patient_can_submit_rating_after_visit_completed(): void
    {
        $user = User::factory()->create();
        $patient = Patient::create([
            'rm_number' => 'RM004', 'nik' => '444', 'name' => 'C'
        ]);

        // Kunjungan selesai
        $visit = Visit::create([
            'branch_id' => Branch::first()->id,
            'patient_id' => $patient->id,
            'doctor_id' => Doctor::first()->id,
            'visit_date' => today(),
            'queue_number' => 1,
            'status' => 'completed',
        ]);

        $response = $this->actingAs($user)->postJson('/api/mobile/ratings', [
            'visit_id' => $visit->id,
            'rating'   => 5,
            'comment'  => 'Dokter sangat ramah dan informatif.',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('ratings', [
            'visit_id' => $visit->id,
            'patient_id' => $patient->id,
            'rating' => 5,
        ]);
    }

    public function test_cannot_submit_rating_if_visit_not_completed(): void
    {
        $user = User::factory()->create();
        $patient = Patient::create([
            'rm_number' => 'RM005', 'nik' => '555', 'name' => 'D'
        ]);

        // Kunjungan masih waiting
        $visit = Visit::create([
            'branch_id' => Branch::first()->id,
            'patient_id' => $patient->id,
            'doctor_id' => Doctor::first()->id,
            'visit_date' => today(),
            'queue_number' => 1,
            'status' => 'waiting',
        ]);

        $response = $this->actingAs($user)->postJson('/api/mobile/ratings', [
            'visit_id' => $visit->id,
            'rating'   => 5,
            'comment'  => 'Mantap!',
        ]);

        $response->assertStatus(400); // Bad request
    }

    public function test_patient_can_book_visit_online(): void
    {
        $user    = User::factory()->create();
        $branch  = Branch::first();
        $doctor  = Doctor::first();
        $patient = Patient::create([
            'rm_number' => 'RM010', 'nik' => '1010101', 'name' => 'Siti Rahayu',
        ]);

        $response = $this->actingAs($user)->postJson('/api/mobile/bookings', [
            'patient_id' => $patient->id,
            'doctor_id'  => $doctor->id,
            'branch_id'  => $branch->id,
            'visit_date' => today()->addDay()->toDateString(),
        ]);

        $response->assertStatus(201)
                 ->assertJson([
                     'success' => true,
                     'data'    => [
                         'queue_number' => 1, // Antrian pertama
                         'status'       => 'waiting',
                     ],
                 ]);

        $this->assertDatabaseHas('visits', [
            'patient_id'   => $patient->id,
            'doctor_id'    => $doctor->id,
            'queue_number' => 1,
            'status'       => 'waiting',
        ]);
    }

    public function test_booking_auto_increments_queue_number(): void
    {
        $user    = User::factory()->create();
        $branch  = Branch::first();
        $doctor  = Doctor::first();
        $date    = today()->addDay()->toDateString();

        $patient1 = Patient::create(['rm_number' => 'RM011', 'nik' => '1111', 'name' => 'Andi']);
        $patient2 = Patient::create(['rm_number' => 'RM012', 'nik' => '2222', 'name' => 'Bela']);

        // Booking pertama
        $this->actingAs($user)->postJson('/api/mobile/bookings', [
            'patient_id' => $patient1->id,
            'doctor_id'  => $doctor->id,
            'branch_id'  => $branch->id,
            'visit_date' => $date,
        ]);

        // Booking kedua
        $response = $this->actingAs($user)->postJson('/api/mobile/bookings', [
            'patient_id' => $patient2->id,
            'doctor_id'  => $doctor->id,
            'branch_id'  => $branch->id,
            'visit_date' => $date,
        ]);

        $response->assertStatus(201)
                 ->assertJson(['data' => ['queue_number' => 2]]);
    }

    public function test_cannot_book_same_doctor_same_date_twice(): void
    {
        $user    = User::factory()->create();
        $branch  = Branch::first();
        $doctor  = Doctor::first();
        $patient = Patient::create(['rm_number' => 'RM013', 'nik' => '3333', 'name' => 'Cita']);
        $date    = today()->addDay()->toDateString();

        // Booking pertama
        $this->actingAs($user)->postJson('/api/mobile/bookings', [
            'patient_id' => $patient->id,
            'doctor_id'  => $doctor->id,
            'branch_id'  => $branch->id,
            'visit_date' => $date,
        ]);

        // Booking kedua (duplikat)
        $response = $this->actingAs($user)->postJson('/api/mobile/bookings', [
            'patient_id' => $patient->id,
            'doctor_id'  => $doctor->id,
            'branch_id'  => $branch->id,
            'visit_date' => $date,
        ]);

        $response->assertStatus(409); // Conflict
    }

    public function test_patient_can_view_booking_history(): void
    {
        $user    = User::factory()->create();
        $branch  = Branch::first();
        $doctor  = Doctor::first();
        $patient = Patient::create(['rm_number' => 'RM014', 'nik' => '4444', 'name' => 'Dewi']);

        // Buat 2 kunjungan
        Visit::create([
            'patient_id' => $patient->id, 'doctor_id' => $doctor->id,
            'branch_id'  => $branch->id, 'visit_date' => today()->subDay(),
            'queue_number' => 1, 'status' => 'completed',
        ]);
        Visit::create([
            'patient_id' => $patient->id, 'doctor_id' => $doctor->id,
            'branch_id'  => $branch->id, 'visit_date' => today(),
            'queue_number' => 2, 'status' => 'waiting',
        ]);

        $response = $this->actingAs($user)->getJson("/api/mobile/bookings?patient_id={$patient->id}");

        $response->assertStatus(200)
                 ->assertJson(['success' => true])
                 ->assertJsonPath('data.total', 2);
    }
}
