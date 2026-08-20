<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'branch_id',
        'room_id',
        'queue_id',
        'queue_number',
        'visit_date',
        'status',
        'notes',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function queue()
    {
        return $this->belongsTo(Queue::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }

    public function nursingNotes()
    {
        return $this->hasMany(NursingNote::class);
    }

    public function physiotherapyRecords()
    {
        return $this->hasMany(PhysiotherapyRecord::class);
    }

    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }
}
