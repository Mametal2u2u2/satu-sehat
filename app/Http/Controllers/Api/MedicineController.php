<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index()
    {
        $medicines = Medicine::with(['category', 'batches'])->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar sediaan obat & stok',
            'data' => $medicines,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'nullable|exists:medicine_categories,id',
            'code' => 'required|string|unique:medicines,code',
            'name' => 'required|string',
            'dosage_form' => 'nullable|string',
            'unit' => 'required|string',
            'dosage_strength' => 'nullable|string',
            'minimum_stock' => 'integer',
        ]);

        $medicine = Medicine::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Obat berhasil ditambahkan',
            'data' => $medicine,
        ], 201);
    }

    public function lowStock()
    {
        $medicines = Medicine::whereRaw('current_stock <= minimum_stock')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar obat stok menipis/habis',
            'data' => $medicines,
        ]);
    }
}
