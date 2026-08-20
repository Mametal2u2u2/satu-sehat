<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Services\SubmissionService;
use Illuminate\Http\Request;
use Exception;

class SubmissionController extends Controller
{
    protected SubmissionService $service;

    public function __construct(SubmissionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $query = Submission::with(['user', 'submittable', 'latestApproval.approver']);

        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        return response()->json(['success' => true, 'message' => 'Daftar pengajuan', 'data' => $query->latest()->paginate(15)]);
    }

    public function storeLeave(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type'  => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'reason'      => 'required|string',
            'substitute'  => 'nullable|string',
            'notes'       => 'nullable|string',
        ]);

        $submission = $this->service->createLeaveRequest(
            ['user_id' => $request->user()->id, 'notes' => $request->notes],
            $validated
        );

        return response()->json(['success' => true, 'message' => 'Pengajuan izin/cuti berhasil dibuat', 'data' => $submission->load('submittable')], 201);
    }

    public function storeRecruitment(Request $request)
    {
        $validated = $request->validate([
            'branch_id'      => 'required|exists:branches,id',
            'employee_type'  => 'required|string',
            'count'          => 'integer|min:1',
            'needed_by'      => 'nullable|date',
            'reason'         => 'required|string',
            'qualifications' => 'nullable|string',
            'notes'          => 'nullable|string',
        ]);

        $submission = $this->service->createRecruitmentRequest(
            ['user_id' => $request->user()->id, 'notes' => $request->notes],
            $validated
        );

        return response()->json(['success' => true, 'message' => 'Pengajuan rekrutmen berhasil dibuat', 'data' => $submission->load('submittable')], 201);
    }

    public function storeAmbulance(Request $request)
    {
        $validated = $request->validate([
            'ambulance_id' => 'nullable|exists:ambulances,id',
            'patient_id'   => 'nullable|exists:patients,id',
            'destination'  => 'required|string',
            'purpose'      => 'required|string',
            'requested_at' => 'required|date',
            'notes'        => 'nullable|string',
        ]);

        $submission = $this->service->createAmbulanceRequest(
            ['user_id' => $request->user()->id, 'notes' => $request->notes],
            array_merge($validated, ['requester_id' => $request->user()->id])
        );

        return response()->json(['success' => true, 'message' => 'Pengajuan ambulans berhasil dibuat', 'data' => $submission->load('submittable')], 201);
    }

    public function submit(Submission $submission)
    {
        try {
            $updated = app(SubmissionService::class)->submit($submission);

            return response()->json(['success' => true, 'message' => 'Pengajuan berhasil diajukan', 'data' => $updated]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
