<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_number',
        'year',
        'notes',
    ];

    public function subunits()
    {
        return $this->belongsToMany(
            Truck::class,
            'truck_subunit',
            'main_truck_id',
            'subunit_truck_id'
        )
        ->withPivot('start_date', 'end_date')
        ->withTimestamps();
    }

    public function mainTrucks()
    {
        return $this->belongsToMany(
            Truck::class,
            'truck_subunit',
            'subunit_truck_id',
            'main_truck_id'
        )
        ->withPivot('start_date', 'end_date')
        ->withTimestamps();
    }
}
