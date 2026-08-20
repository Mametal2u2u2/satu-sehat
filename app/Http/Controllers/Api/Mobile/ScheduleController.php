<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $branchId = $request->query('branch_id');

        $query = DoctorSchedule::with(['doctor', 'room'])->where('status', 'active');

        if ($branchId) {
            $query->where('branch_id', $branchId);
        }

        // Tampilkan jadwal untuk hari ini hingga 7 hari ke depan (simulasi query per hari)
        $schedules = $query->get()->groupBy('day_of_week');

        return response()->json([
            'success' => true,
            'message' => 'Jadwal praktik dokter',
            'data'    => $schedules
        ]);
    }
}
