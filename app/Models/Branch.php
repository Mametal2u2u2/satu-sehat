<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'address',
        'phone',
        'email',
        'pic',
        'status',
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
