<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id', 'ambulance_id', 'patient_id',
        'destination', 'purpose', 'requested_at', 'status', 'notes',
    ];

    protected $casts = ['requested_at' => 'datetime'];

    public function requester() { return $this->belongsTo(User::class, 'requester_id'); }
    public function ambulance() { return $this->belongsTo(Ambulance::class); }
    public function patient() { return $this->belongsTo(Patient::class); }
    public function submission() { return $this->morphOne(Submission::class, 'submittable'); }
}
