<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambulance extends Model
{
    use HasFactory;

    protected $fillable = [
        'license_plate', 'type', 'brand', 'driver_name', 'driver_phone', 'status', 'notes',
    ];

    public function requests() { return $this->hasMany(AmbulanceRequest::class); }
    public function submission() { return $this->morphOne(Submission::class, 'submittable'); }
}
