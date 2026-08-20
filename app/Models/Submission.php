<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'submittable_type', 'submittable_id',
        'status', 'notes', 'attachments',
    ];

    protected $casts = ['attachments' => 'array'];

    public function user() { return $this->belongsTo(User::class); }
    public function submittable() { return $this->morphTo(); }
    public function approvalLogs() { return $this->hasMany(ApprovalLog::class); }
    public function latestApproval() { return $this->hasOne(ApprovalLog::class)->latestOfMany(); }
}
