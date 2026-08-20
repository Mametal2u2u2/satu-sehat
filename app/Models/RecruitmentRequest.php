<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecruitmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id', 'employee_type', 'count', 'needed_by', 'reason', 'qualifications',
    ];

    protected $casts = ['needed_by' => 'date'];

    public function branch() { return $this->belongsTo(Branch::class); }
    public function submission() { return $this->morphOne(Submission::class, 'submittable'); }
}
