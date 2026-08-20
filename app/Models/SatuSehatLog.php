<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SatuSehatLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_record_id', 'endpoint', 'request_payload',
        'response_payload', 'status_code', 'is_success', 'error_message',
    ];

    protected $casts = [
        'request_payload' => 'array',
        'response_payload' => 'array',
        'is_success' => 'boolean',
    ];

    public function medicalRecord() { return $this->belongsTo(MedicalRecord::class); }
}
