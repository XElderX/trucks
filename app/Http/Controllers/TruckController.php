<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Truck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TruckController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function browse(Request $request)
    {
        $paginate = (int) $request->input('limit', 50);
        $trucks = Truck::latest()->paginate($paginate);
        return response()->json($trucks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $truck = Truck::create($request->all());
        return response()->json($truck, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, string $id)
    {
        $truck = Truck::findOrFail($id);

        $truck->fill($request->all())->save();
        return response()->json($truck);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(string $id)
    {
        $truck = Truck::findOrFail($id);
        $truck->delete();
        return response()->json(null, 204);
    }
}
