<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use App\Services\ApprovalService;
use Illuminate\Http\Request;
use Exception;

class ApprovalController extends Controller
{
    protected ApprovalService $service;

    public function __construct(ApprovalService $service)
    {
        $this->service = $service;
    }

    public function pending()
    {
        $submissions = $this->service->getPendingSubmissions();

        return response()->json(['success' => true, 'message' => 'Daftar pengajuan menunggu persetujuan', 'data' => $submissions]);
    }

    public function process(Request $request, Submission $submission)
    {
        $validated = $request->validate([
            'action'  => 'required|in:approve,reject,review',
            'comment' => 'nullable|string',
        ]);

        try {
            $updated = $this->service->process(
                $submission,
                $request->user()->id,
                $validated['action'],
                $validated['comment'] ?? null
            );

            $actionLabel = match ($validated['action']) {
                'approve' => 'disetujui',
                'reject'  => 'ditolak',
                'review'  => 'dikembalikan untuk review',
            };

            return response()->json(['success' => true, 'message' => "Pengajuan berhasil {$actionLabel}", 'data' => $updated]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
        }
    }
}
