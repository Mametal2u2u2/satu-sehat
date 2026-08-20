<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'patient_id',
        'doctor_id',
        'chief_complaint',
        'illness_history',
        'physical_examination',
        'vital_signs',
        'doctor_notes',
        'follow_up_date',
    ];

    protected $casts = [
        'vital_signs' => 'array',
        'follow_up_date' => 'date',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function diagnoses()
    {
        return $this->hasMany(Diagnosis::class);
    }
}
