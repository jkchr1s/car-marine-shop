<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\VehicleMake;
use App\VehicleType;
use Illuminate\Http\Request;

class VehicleMakeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // validate input
        $filter = $request->validate([
            'type' => ['nullable', 'integer', 'exists:vehicle_types,id'],
        ]);

        // fetch vehicle types
        $types = VehicleType::orderBy('type')->get();

        // handle filtering
        if (isset($filter['type'])) {
            $filterName = sprintf('Showing %s', $types->find($filter['type'])->type);
            $makes = VehicleMake::where('vehicle_type_id', $filter['type'])
                ->orderBy('make')
                ->get();
        } else {
            $filterName = 'Showing All Vehicle Types';
            $makes = VehicleMake::orderBy('make')
                ->get();
        }

        // return view
        return view('vehicle_make.index', [
            'makes' => $makes,
            'types' => $types,
            'filter' => $filterName,
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
            'vehicle_type_id' => ['required', 'integer', 'exists:vehicle_types,id'],
            'make' => ['required', 'string'],
            'icon' => ['nullable'],
        ]);
        VehicleMake::create($data);

        return $request->ajax()
            ? response(['success' => true])
            : redirect(route('vehicle_make.index', ['type' => $data['vehicle_type_id']]));
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
            'make' => ['required', 'string'],
        ]);
        $result = VehicleMake::where('id', $id)->update($data);

        return $request->ajax()
            ? response(['modified' => $result])
            : redirect(route('vehicle_make.index'));
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
        $item = VehicleMake::find($id);
        $result = $item->delete();

        return $request->ajax()
            ? response(['deleted' => $result])
            : redirect(route('vehicle_make.index'));
    }
}
