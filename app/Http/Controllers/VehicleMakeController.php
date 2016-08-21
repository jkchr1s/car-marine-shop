<?php

namespace App\Http\Controllers;

use App\VehicleMake;
use Illuminate\Http\Request;

use App\Http\Requests;

class VehicleMakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $makes = VehicleMake::orderBy('make')->get();

        return view('vehicle.vehicle-make', [
            'makes' => $makes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->has('make')) {
            return response(['error' => 'You must specify make']);
        } else {
            $make = new VehicleMake();
            $make->make = $request->input('make');
            $make->save();
            return redirect('/vehicle_make');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        echo "edit ".$id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!$request->has('make')) {
            return response(['error' => 'No make specified']);
        }
        $item = VehicleMake::find($id);
        $item->type = $request->input('make');
        $result = $item->save();
        return response(['modified' => $result]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = VehicleMake::find($id);
        $result = $item->delete();
        return response(['deleted' => $result]);
    }
}
