<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkSchedule;
use App\Models\ShiftType;
use Illuminate\Http\Request;

class WorkScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = WorkSchedule::with(['employee.user', 'branch', 'shiftType', 'room']);

        if ($request->has('employee_id')) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->has('date')) {
            $query->where('schedule_date', $request->date);
        }

        return response()->json(['success' => true, 'message' => 'Jadwal dinas', 'data' => $query->orderBy('schedule_date')->get()]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id'    => 'required|exists:employees,id',
            'branch_id'      => 'required|exists:branches,id',
            'shift_type_id'  => 'required|exists:shift_types,id',
            'room_id'        => 'nullable|exists:rooms,id',
            'schedule_date'  => 'required|date',
            'notes'          => 'nullable|string',
        ]);

        $schedule = WorkSchedule::create($validated);

        return response()->json(['success' => true, 'message' => 'Jadwal dinas berhasil ditambahkan', 'data' => $schedule->load('employee.user', 'shiftType')], 201);
    }

    public function shiftTypes()
    {
        return response()->json(['success' => true, 'data' => ShiftType::where('status', true)->get()]);
    }
}
