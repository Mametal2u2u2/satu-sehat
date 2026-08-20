<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['user', 'branch'])->get();

        return response()->json(['success' => true, 'message' => 'Daftar tenaga kesehatan', 'data' => $employees]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'branch_id'     => 'required|exists:branches,id',
            'nik'           => 'required|string|unique:employees,nik',
            'str'           => 'nullable|string',
            'sip'           => 'nullable|string',
            'employee_type' => 'required|string',
            'position'      => 'nullable|string',
            'join_date'     => 'nullable|date',
        ]);

        $employee = Employee::create($validated);

        return response()->json(['success' => true, 'message' => 'Data nakes berhasil ditambahkan', 'data' => $employee->load('user', 'branch')], 201);
    }

    public function show(Employee $employee)
    {
        return response()->json(['success' => true, 'message' => 'Detail nakes', 'data' => $employee->load('user', 'branch', 'workSchedules.shiftType')]);
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'branch_id'     => 'sometimes|exists:branches,id',
            'str'           => 'nullable|string',
            'sip'           => 'nullable|string',
            'employee_type' => 'sometimes|string',
            'position'      => 'nullable|string',
            'status'        => 'boolean',
        ]);

        $employee->update($validated);

        return response()->json(['success' => true, 'message' => 'Data nakes berhasil diperbarui', 'data' => $employee->fresh('user', 'branch')]);
    }
}
