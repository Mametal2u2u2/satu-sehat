<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number',
        'medicine_id',
        'medicine_batch_id',
        'user_id',
        'type',
        'quantity',
        'notes',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function batch()
    {
        return $this->belongsTo(MedicineBatch::class, 'medicine_batch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
