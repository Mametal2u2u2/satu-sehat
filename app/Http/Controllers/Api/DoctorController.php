<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::with(['user', 'branch', 'schedules'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar dokter',
            'data' => $doctors
        ]);
    }

    public function show(Doctor $doctor)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail dokter',
            'data' => $doctor->load(['user', 'branch', 'schedules'])
        ]);
    }
}
