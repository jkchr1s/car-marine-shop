<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\VehicleType;
use Illuminate\Http\Request;

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
            'types' => $types,
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
        $data = $request->validate([
            'type' => ['required', 'string'],
            'icon' => ['required', 'string'],
        ]);
        VehicleType::create($data);

        return $request->ajax()
            ? response(['success' => true])
            : redirect(route('vehicle_type.index'));
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
        $data = $request->validate([
            'type' => ['required', 'string'],
            'icon' => ['nullable'],
        ]);
        $item = VehicleType::findOrFail($id);
        $item->type = $data['type'];
        if (isset($data['icon']) && ! empty($data['icon'])) {
            $item->icon = $data['icon'];
        }
        $modified = $item->save();

        return $request->ajax()
            ? response(['modified' => $modified])
            : redirect(route('vehicle_type.index'));
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
        $item = VehicleType::findOrFail($id);
        $result = $item->delete();

        return $request->ajax()
            ? response(['deleted' => $result])
            : redirect(route('vehicle_type.index'));
    }
}
