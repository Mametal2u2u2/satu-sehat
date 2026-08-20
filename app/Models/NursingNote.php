<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursingNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'nurse_id',
        'vital_signs',
        'nursing_care_notes',
        'patient_condition',
    ];

    protected $casts = [
        'vital_signs' => 'array',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }
}
