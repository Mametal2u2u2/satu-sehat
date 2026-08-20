<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'leave_type', 'start_date', 'end_date', 'reason', 'substitute',
    ];

    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];

    public function employee() { return $this->belongsTo(Employee::class); }

    // Polymorphic: this model can be the "submittable" in a Submission
    public function submission() { return $this->morphOne(Submission::class, 'submittable'); }
}
