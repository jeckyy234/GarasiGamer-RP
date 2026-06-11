<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    protected $fillable = ['ps_type_id', 'name'];

    public function psType()
    {
        return $this->belongsTo(PsType::class);
    }
}
