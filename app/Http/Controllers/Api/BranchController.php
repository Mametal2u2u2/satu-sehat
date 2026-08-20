<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with('rooms')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar cabang klinik',
            'data' => $branches
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:branches,code',
            'name' => 'required|string',
            'address' => 'nullable|string',
            'phone' => 'nullable|string',
            'email' => 'nullable|email',
            'pic' => 'nullable|string',
            'status' => 'boolean',
        ]);

        $branch = Branch::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cabang berhasil ditambahkan',
            'data' => $branch
        ], 201);
    }

    public function show(Branch $branch)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail cabang',
            'data' => $branch->load('rooms')
        ]);
    }
}
