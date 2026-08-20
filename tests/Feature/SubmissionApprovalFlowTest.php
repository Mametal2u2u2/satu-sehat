<?php

namespace Tests\Feature;

use App\Models\Branch;
use App\Models\Employee;
use App\Models\Submission;
use App\Models\User;
use App\Services\ApprovalService;
use App\Services\SubmissionService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SubmissionApprovalFlowTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_full_leave_submission_and_approval_flow(): void
    {
        $branch  = Branch::first();
        $employee = Employee::first();

        // 1. Pegawai membuat pengajuan izin (status: draft)
        $submissionService = app(SubmissionService::class);
        $submission = $submissionService->createLeaveRequest(
            ['user_id' => $employee->user_id, 'notes' => 'Mohon persetujuannya'],
            [
                'employee_id' => $employee->id,
                'leave_type'  => 'izin',
                'start_date'  => now()->addDays(2)->toDateString(),
                'end_date'    => now()->addDays(3)->toDateString(),
                'reason'      => 'Ada keperluan keluarga mendesak',
                'substitute'  => 'Budi Santoso',
            ]
        );

        $this->assertEquals('draft', $submission->status);
        $this->assertEquals('leave', $submission->type);
        $this->assertDatabaseHas('leave_requests', ['employee_id' => $employee->id]);

        // 2. Pegawai submit pengajuan (draft → submitted)
        $submissionService->submit($submission);
        $this->assertEquals('submitted', $submission->fresh()->status);

        // 3. Tidak boleh submit ulang setelah sudah submitted
        $this->expectException(\Exception::class);
        $submissionService->submit($submission->fresh());
    }

    public function test_approver_can_approve_submitted_submission(): void
    {
        $employee = Employee::first();
        $approver = User::where('username', 'superadmin')->first();

        $submissionService = app(SubmissionService::class);
        $approvalService   = app(ApprovalService::class);

        // Create and submit
        $submission = $submissionService->createLeaveRequest(
            ['user_id' => $employee->user_id],
            [
                'employee_id' => $employee->id,
                'leave_type'  => 'cuti',
                'start_date'  => now()->addDays(5)->toDateString(),
                'end_date'    => now()->addDays(7)->toDateString(),
                'reason'      => 'Cuti tahunan',
            ]
        );
        $submissionService->submit($submission);

        // Approver melihat pending submissions
        $pending = $approvalService->getPendingSubmissions();
        $this->assertGreaterThan(0, $pending->count());

        // Approver approve
        $updated = $approvalService->process($submission->fresh(), $approver->id, 'approve', 'Disetujui. Silakan cuti.');

        $this->assertEquals('approved', $updated->status);

        // Verifikasi ApprovalLog tercatat
        $this->assertDatabaseHas('approval_logs', [
            'submission_id' => $submission->id,
            'approver_id'   => $approver->id,
            'action'        => 'approve',
        ]);
    }

    public function test_approver_can_reject_with_comment(): void
    {
        $employee = Employee::first();
        $approver = User::where('username', 'superadmin')->first();

        $submissionService = app(SubmissionService::class);
        $approvalService   = app(ApprovalService::class);

        $submission = $submissionService->createLeaveRequest(
            ['user_id' => $employee->user_id],
            [
                'employee_id' => $employee->id,
                'leave_type'  => 'izin',
                'start_date'  => now()->addDays(1)->toDateString(),
                'end_date'    => now()->addDays(1)->toDateString(),
                'reason'      => 'Keperluan mendadak',
            ]
        );
        $submissionService->submit($submission);

        $updated = $approvalService->process($submission->fresh(), $approver->id, 'reject', 'Tidak dapat disetujui: jadwal padat.');

        $this->assertEquals('rejected', $updated->status);
        $this->assertDatabaseHas('approval_logs', [
            'submission_id' => $submission->id,
            'action'        => 'reject',
            'comment'       => 'Tidak dapat disetujui: jadwal padat.',
        ]);
    }
}
