<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ambulance;
use Illuminate\Http\Request;

class AmbulanceController extends Controller
{
    public function index()
    {
        $ambulances = Ambulance::withCount(['requests as active_requests_count' => function ($q) {
            $q->whereIn('status', ['pending', 'verified', 'approved', 'in_use']);
        }])->get();

        return response()->json(['success' => true, 'message' => 'Daftar armada ambulans', 'data' => $ambulances]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|unique:ambulances,license_plate',
            'type'          => 'nullable|string',
            'brand'         => 'nullable|string',
            'driver_name'   => 'nullable|string',
            'driver_phone'  => 'nullable|string',
        ]);

        $ambulance = Ambulance::create($validated);

        return response()->json(['success' => true, 'message' => 'Armada ambulans berhasil ditambahkan', 'data' => $ambulance], 201);
    }

    public function updateStatus(Request $request, Ambulance $ambulance)
    {
        $request->validate(['status' => 'required|in:available,in_use,maintenance']);
        $ambulance->update(['status' => $request->status]);

        return response()->json(['success' => true, 'message' => 'Status ambulans diperbarui', 'data' => $ambulance]);
    }
}
