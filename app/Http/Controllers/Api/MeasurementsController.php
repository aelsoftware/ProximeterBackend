<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMeasurementRequest;
use App\Models\Measurement;
use App\Http\Requests\UpdateMeasurementRequest;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Request;

class MeasurementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = Auth::id();
        return Measurement::where('user_id',$user_id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMeasurementRequest $request)
    {
        $user_id = Auth::id();

        $measurement = Measurement::create([
            'name' => $request->name,
            'user_id' => $user_id,
            'area' => $request->area,
        ]);

        return response()->json($measurement);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return response()->json(Measurement::findOrFail($request->id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMeasurementRequest $request)
    {
        Measurement::where('id',$request->id)->update([
            'name' => $request->name,
            'area' => $request->area,
        ]);

        return response()->json(Measurement::findOrFail($request->id));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Measurement $measurement)
    {
        Measurement::where('id',$measurement->id)->destroy();
        
        return response()->json([ 
                'status' => true,
                "message"=>"success",
            ],200);
    }
}
