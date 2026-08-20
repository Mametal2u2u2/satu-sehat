<?php

namespace App\Services;

use App\Models\Submission;
use App\Models\ApprovalLog;
use Illuminate\Support\Facades\DB;

class ApprovalService
{
    /**
     * Proses approve atau reject oleh approver.
     */
    public function process(Submission $submission, int $approverId, string $action, ?string $comment = null): Submission
    {
        $allowedFromStatus = ['submitted', 'review'];

        if (!in_array($submission->status, $allowedFromStatus)) {
            throw new \Exception("Pengajuan dengan status '{$submission->status}' tidak dapat diproses.");
        }

        $newStatus = match ($action) {
            'approve' => 'approved',
            'reject'  => 'rejected',
            'review'  => 'review',
            default   => throw new \Exception("Aksi '{$action}' tidak valid."),
        };

        return DB::transaction(function () use ($submission, $approverId, $action, $comment, $newStatus) {
            ApprovalLog::create([
                'submission_id' => $submission->id,
                'approver_id'   => $approverId,
                'action'        => $action,
                'comment'       => $comment,
            ]);

            $submission->update(['status' => $newStatus]);

            return $submission->fresh('submittable', 'approvalLogs.approver');
        });
    }

    /**
     * Daftar pengajuan yang perlu direview oleh approver.
     */
    public function getPendingSubmissions()
    {
        return Submission::with(['user', 'submittable', 'latestApproval.approver'])
            ->whereIn('status', ['submitted', 'review'])
            ->latest()
            ->get();
    }
}
