<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price_per_hour', 'total_units'];

    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function getAvailableUnitsAttribute()
    {
        $activeRentals = $this->rentals()->where('status', 'active')->count();
        return $this->total_units - $activeRentals;
    }

    // Accessor untuk menampilkan status setiap unit (tersedia atau disewa + timer)
    public function getUnitsStatusAttribute()
    {
        $units = [];
        $activeRentals = $this->rentals()
            ->where('status', 'active')
            ->get()
            ->keyBy('unit_number');

        for ($i = 1; $i <= $this->total_units; $i++) {
            $rental = $activeRentals->get($i);
            $units[] = [
                'number' => $i,
                'available' => !$rental,
                'rental' => $rental ? [
                    'customer' => $rental->customer_name,
                    'ends_at'  => $rental->rental_date->copy()->addHours((float) $rental->duration_hours),
                    'rental_id'=> $rental->id,
                ] : null,
            ];
        }
        return $units;
    }
}
