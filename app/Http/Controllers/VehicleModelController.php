<?php

namespace App\Http\Controllers;

use App\VehicleMake;
use App\VehicleType;
use App\VehicleModel;
use Illuminate\Http\Request;

class VehicleModelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'vehicle_type_id' => [
                'nullable',
                'integer',
                'exclude-if:vehicle_type_id,',
                'exists:vehicle_types,id'
            ],
            'vehicle_make_id' => [
                'nullable',
                'integer',
                'exclude-if:vehicle_make_id,',
                'exists:vehicle_makes,id'
            ]
        ]);

        // fetch our vehicle models, and apply any filters that are present
        $models = VehicleModel::orderBy('model');
        foreach ($filters as $key => $value) {
            $models = $models->where($key, $value);
        }

        // fetch vehicle makes for filter drop-down, and filter types if present
        $makes = VehicleMake::select('id', 'make')->orderBy('make');
        if (isset($filters['vehicle_type_id'])) {
            $makes = $makes->where('vehicle_type_id', $filters['vehicle_type_id']);
        }

        // render our view
        return view('vehicle_model.index', [
            'types' => VehicleType::select('id', 'type')->orderBy('type')->get(),
            'makes' => $makes->get(),
            'filters' => $filters,
            'models' => $models->get(),
        ]);
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
        $data = $request->validate([
            'vehicle_type_id' => [
                'nullable',
                'integer',
                'exclude-if:vehicle_type_id,',
                'exists:vehicle_types,id'
            ],
            'vehicle_make_id' => [
                'nullable',
                'integer',
                'exclude-if:vehicle_make_id,',
                'exists:vehicle_makes,id'
            ],
            'model' => ['required', 'string']
        ]);

        $model = VehicleModel::create($data);
        return $request->ajax()
            ? response('', 201)
            : redirect(route('vehicle_model.show', ['vehicle_model' => $model->id]));
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (is_numeric($id)) {
            VehicleModel::destroy($id);
        }
        return $request->ajax()
            ? response('', 204)
            : redirect(route('vehicle_model.index'));
    }
}
