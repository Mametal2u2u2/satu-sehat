<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysiotherapyRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'visit_id',
        'therapist_id',
        'assessment',
        'diagnosis',
        'target_therapy',
        'intervention',
        'evaluation',
    ];

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function therapist()
    {
        return $this->belongsTo(User::class, 'therapist_id');
    }
}
