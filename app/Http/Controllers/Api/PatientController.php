<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(15);

        return response()->json([
            'success' => true,
            'message' => 'Daftar pasien',
            'data' => $patients
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'rm_number' => 'required|string|unique:patients,rm_number',
            'name' => 'required|string',
            'nik' => 'nullable|string|unique:patients,nik',
            'birth_place' => 'nullable|string',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:L,P',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'emergency_contact' => 'nullable|string',
            'allergies' => 'nullable|string',
        ]);

        $patient = Patient::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Pasien berhasil didaftarkan',
            'data' => $patient
        ], 201);
    }

    public function show(Patient $patient)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail pasien',
            'data' => $patient
        ]);
    }
}
