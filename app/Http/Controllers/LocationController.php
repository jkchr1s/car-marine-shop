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
        return response('Not Implemented', 501);
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
        $data = $request->validate([
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'location_type_id' => ['required', 'integer', 'exists:location_types,id'],
            'address1' => ['required', 'string'],
            'address2' => ['nullable'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'zip' => ['required', 'string'],
        ]);
        Location::create($data);
        return $request->ajax()
            ? response(['success' => true])
            : redirect(route('customer.show', $data['customer_id']));
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
        return response('Not Implemented', 501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $item = Location::findOrFail($id);
        $customerId = $item->customer_id;
        $item->delete();
        return $request->ajax()
            ? response(['success' => true])
            : redirect(route('customer.show', $customerId));
    }
}
