<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $fillable = [
        'ps_type_id',
        'unit_number',
        'customer_name',
        'duration_hours',
        'total_price',
        'rental_date',
        'status',
    ];

    protected $casts = [
        'rental_date' => 'datetime',
    ];

    public function psType()
    {
        return $this->belongsTo(PsType::class);
    }
}
