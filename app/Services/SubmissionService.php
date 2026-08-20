<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\LeaveRequest;
use App\Models\RecruitmentRequest;
use App\Models\AmbulanceRequest;
use Illuminate\Support\Facades\DB;

class SubmissionService
{
    /**
     * Buat pengajuan izin/cuti.
     */
    public function createLeaveRequest(array $data, array $leaveData): Submission
    {
        return DB::transaction(function () use ($data, $leaveData) {
            $leave = LeaveRequest::create($leaveData);

            return $leave->submission()->create([
                'user_id'           => $data['user_id'],
                'type'              => 'leave',
                'submittable_type'  => LeaveRequest::class,
                'submittable_id'    => $leave->id,
                'status'            => 'draft',
                'notes'             => $data['notes'] ?? null,
                'attachments'       => $data['attachments'] ?? null,
            ]);
        });
    }

    /**
     * Buat pengajuan rekrutmen tenaga kesehatan.
     */
    public function createRecruitmentRequest(array $data, array $recruitData): Submission
    {
        return DB::transaction(function () use ($data, $recruitData) {
            $recruit = RecruitmentRequest::create($recruitData);

            return $recruit->submission()->create([
                'user_id'           => $data['user_id'],
                'type'              => 'recruitment',
                'submittable_type'  => RecruitmentRequest::class,
                'submittable_id'    => $recruit->id,
                'status'            => 'draft',
                'notes'             => $data['notes'] ?? null,
                'attachments'       => $data['attachments'] ?? null,
            ]);
        });
    }

    /**
     * Buat pengajuan peminjaman ambulans.
     */
    public function createAmbulanceRequest(array $data, array $ambulanceData): Submission
    {
        return DB::transaction(function () use ($data, $ambulanceData) {
            $request = AmbulanceRequest::create($ambulanceData);

            return $request->submission()->create([
                'user_id'           => $data['user_id'],
                'type'              => 'ambulance',
                'submittable_type'  => AmbulanceRequest::class,
                'submittable_id'    => $request->id,
                'status'            => 'draft',
                'notes'             => $data['notes'] ?? null,
                'attachments'       => $data['attachments'] ?? null,
            ]);
        });
    }

    /**
     * Pegawai mengajukan (submit) pengajuan.
     */
    public function submit(Submission $submission): Submission
    {
        if ($submission->status !== 'draft') {
            throw new \Exception('Hanya pengajuan berstatus draft yang dapat diajukan.');
        }

        $submission->update(['status' => 'submitted']);

        return $submission->fresh('submittable', 'approvalLogs');
    }
}
