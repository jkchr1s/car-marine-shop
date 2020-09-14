<?php

namespace App\Http\Controllers;

use App\VehicleType;
use Illuminate\Http\Request;

use App\Http\Requests;

class VehicleTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = VehicleType::orderBy('type')->get();

        return view('vehicle_type.index', [
            'types' => $types
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response('Not Implemented', 501);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->has('type')) {
            return response(['error' => 'You must specify type']);
        } else {
            $type = new VehicleType();
            $type->type = $request->input('type');
            $type->icon = $request->input('icon');
            $type->save();
            return redirect('/vehicle_type');
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
        return response('Not Implemented', 501);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response('Not Implemented', 501);
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
        if (!$request->has('type')) {
            return response(['error' => 'No type specified']);
        }
        $item = VehicleType::find($id);
        $item->type = $request->input('type');
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
        $item = VehicleType::find($id);
        $result = $item->delete();
        return response(['deleted' => $result]);
    }
}
