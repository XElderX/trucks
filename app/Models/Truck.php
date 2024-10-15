<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'truck_subunits',
            'main_truck_id',
            'subunit_truck_id'
        )->withPivot('start_date', 'end_date')
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

    /**
     * Add a subunit for this truck.
     *
     * @param  array  $data
     * @return int
     */
    public function addSubunit(Request $request): int
    {
        return DB::table('truck_subunits')->insertGetId([
            'main_truck_id'    => $request->main_truck,
            'subunit_truck_id' => $request->subunit,
            'start_date'       => $request->start_date,
            'end_date'         => $request->end_date,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }
}
