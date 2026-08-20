<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BranchController;
use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\VisitController;
use App\Http\Controllers\Api\MedicalRecordController;
use App\Http\Controllers\Api\PrescriptionController;
use App\Http\Controllers\Api\MedicineController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\SubmissionController;
use App\Http\Controllers\Api\ApprovalController;
use App\Http\Controllers\Api\WorkScheduleController;
use App\Http\Controllers\Api\AmbulanceController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // ── PHASE 1.5: Master Data ──────────────────────────────
    Route::get('/branches', [BranchController::class, 'index']);
    Route::post('/branches', [BranchController::class, 'store']);
    Route::get('/branches/{branch}', [BranchController::class, 'show']);

    Route::get('/doctors', [DoctorController::class, 'index']);
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show']);

    Route::get('/patients', [PatientController::class, 'index']);
    Route::post('/patients', [PatientController::class, 'store']);
    Route::get('/patients/{patient}', [PatientController::class, 'show']);

    // ── PHASE 2: e-Klinik Core ──────────────────────────────
    Route::get('/visits', [VisitController::class, 'index']);
    Route::post('/visits', [VisitController::class, 'store']);
    Route::get('/visits/{visit}', [VisitController::class, 'show']);
    Route::patch('/visits/{visit}/status', [VisitController::class, 'updateStatus']);

    Route::post('/medical-records', [MedicalRecordController::class, 'store']);
    Route::get('/medical-records/{medicalRecord}', [MedicalRecordController::class, 'show']);

    Route::post('/prescriptions', [PrescriptionController::class, 'store']);
    Route::patch('/prescriptions/{prescription}/status', [PrescriptionController::class, 'updateStatus']);

    Route::get('/medicines', [MedicineController::class, 'index']);
    Route::post('/medicines', [MedicineController::class, 'store']);
    Route::get('/medicines/low-stock', [MedicineController::class, 'lowStock']);

    // ── PHASE 3: Simplekan / HR Module ─────────────────────
    // Employees
    Route::get('/employees', [EmployeeController::class, 'index']);
    Route::post('/employees', [EmployeeController::class, 'store']);
    Route::get('/employees/{employee}', [EmployeeController::class, 'show']);
    Route::patch('/employees/{employee}', [EmployeeController::class, 'update']);

    // Submissions
    Route::get('/submissions', [SubmissionController::class, 'index']);
    Route::post('/submissions/leave', [SubmissionController::class, 'storeLeave']);
    Route::post('/submissions/recruitment', [SubmissionController::class, 'storeRecruitment']);
    Route::post('/submissions/ambulance', [SubmissionController::class, 'storeAmbulance']);
    Route::patch('/submissions/{submission}/submit', [SubmissionController::class, 'submit']);

    // Approvals (for Approver role)
    Route::get('/approvals/pending', [ApprovalController::class, 'pending']);
    Route::post('/approvals/{submission}/process', [ApprovalController::class, 'process']);

    // Work Schedules / Shift
    Route::get('/work-schedules', [WorkScheduleController::class, 'index']);
    Route::post('/work-schedules', [WorkScheduleController::class, 'store']);
    Route::get('/shift-types', [WorkScheduleController::class, 'shiftTypes']);

    // Ambulances
    Route::get('/ambulances', [AmbulanceController::class, 'index']);
    Route::post('/ambulances', [AmbulanceController::class, 'store']);
    Route::patch('/ambulances/{ambulance}/status', [AmbulanceController::class, 'updateStatus']);

    // ── PHASE 4: Mobile App API & SatuSehat ────────────────
    Route::prefix('mobile')->group(function () {
        Route::get('/queues/current', [\App\Http\Controllers\Api\Mobile\QueueController::class, 'current']);
        Route::get('/schedules', [\App\Http\Controllers\Api\Mobile\ScheduleController::class, 'index']);
        Route::post('/ratings', [\App\Http\Controllers\Api\Mobile\RatingController::class, 'store']);
        Route::get('/articles', [\App\Http\Controllers\Api\Mobile\ArticleController::class, 'index']);
        Route::get('/articles/{article}', [\App\Http\Controllers\Api\Mobile\ArticleController::class, 'show']);

        // Booking Online
        Route::get('/bookings', [\App\Http\Controllers\Api\Mobile\BookingController::class, 'index']);
        Route::post('/bookings', [\App\Http\Controllers\Api\Mobile\BookingController::class, 'store']);
        Route::patch('/bookings/{visit}/cancel', [\App\Http\Controllers\Api\Mobile\BookingController::class, 'cancel']);
    });

    Route::post('/satusehat/sync', [\App\Http\Controllers\Api\SatuSehatController::class, 'syncEncounter']);
    Route::post('/satusehat/sync-observation', [\App\Http\Controllers\Api\SatuSehatController::class, 'syncObservation']);
});

