<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

use App\Http\Requests;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->has('customer_id')) {
            return response(['error' => 'You must specify customer_id']);
        }
        $item = new Location();
        $item->customer_id = intval($request->input('customer_id'));
        $item->location_type_id = intval($request->input('location_type_id'));
        $item->address1 = $request->input('address_1');
        $item->address2 = $request->has('address_2') ? $request->input('address_2') : '';
        $item->city = $request->has('city') ? $request->input('city') : '';
        $item->state = $request->has('state') ? $request->input('state') : '';
        $item->zip = $request->has('zip') ? $request->input('zip') : '';
        $item->save();
        return redirect('/customer/'.$request->input('customer_id'));
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Location::find($id);
        $item->delete();
        return response(['success' => true]);
    }
}
