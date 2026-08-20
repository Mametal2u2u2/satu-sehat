<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'rm_number',
        'nik',
        'name',
        'birth_place',
        'birth_date',
        'gender',
        'address',
        'phone',
        'email',
        'emergency_contact',
        'allergies',
        'status',
    ];
}
