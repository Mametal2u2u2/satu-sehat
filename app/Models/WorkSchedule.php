<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id', 'branch_id', 'shift_type_id', 'room_id', 'schedule_date', 'notes',
    ];

    protected $casts = ['schedule_date' => 'date'];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
    public function shiftType() { return $this->belongsTo(ShiftType::class); }
    public function room() { return $this->belongsTo(Room::class); }
}
