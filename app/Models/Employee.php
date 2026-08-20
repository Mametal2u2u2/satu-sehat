<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'branch_id', 'nik', 'str', 'sip',
        'employee_type', 'position', 'join_date', 'status',
    ];

    protected $casts = ['join_date' => 'date'];

    public function user() { return $this->belongsTo(User::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
    public function leaveRequests() { return $this->hasMany(LeaveRequest::class); }
    public function workSchedules() { return $this->hasMany(WorkSchedule::class); }
}
