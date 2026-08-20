<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovalLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id', 'approver_id', 'action', 'comment',
    ];

    public function submission() { return $this->belongsTo(Submission::class); }
    public function approver() { return $this->belongsTo(User::class, 'approver_id'); }
}
