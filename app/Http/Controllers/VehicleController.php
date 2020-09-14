<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Vehicle;
use App\VehicleMake;
use App\VehicleModel;
use App\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // validate filters so we can refresh the page as the user drills down into type / make / model
        $data = $request->validate([
            'year' => ['nullable'],
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'vehicle_type_id' => ['exclude-if:vehicle_type_id,', 'exists:vehicle_types,id'],
            'vehicle_make_id' => [
                'exclude-if:vehicle_type_id,',
                'exclude-if:vehicle_make_id,',
                'exists:vehicle_makes,id'
            ],
            'vehicle_model_id' => [
                'exclude-if:vehicle_type_id,',
                'exclude-if:vehicle_make_id,',
                'exclude-if:vehicle_model_id,',
            ]
        ]);

        // process vehicle types
        $types = VehicleType::select('id', 'type')->orderBy('type')->get();
        if (!isset($data['vehicle_type_id']) && $types->first()) {
            // default to the first match
            $data['vehicle_type_id'] = $types->first()->id;
        }

        // process vehicle makes
        $makes = isset($data['vehicle_type_id']) || $types->first()
            ? VehicleMake::select('id', 'make')
                ->where('vehicle_type_id', isset($data['vehicle_type_id']) ? $data['vehicle_type_id'] : $types->first()->id)
                ->select('id', 'make')
                ->orderBy('make')
                ->get()
            : collect([]);
        if ((!isset($data['vehicle_make_id']) || !$makes->find($data['vehicle_make_id'])) && $makes->first()) {
            // default to the first match
            $data['vehicle_make_id'] = $makes->first()->id;
        }

        // process vehicle models
        $models = (isset($data['vehicle_type_id']) && isset($data['vehicle_make_id'])) || ($types->first() && $makes->first())
            ? VehicleModel::select('id', 'model')
                ->where('vehicle_type_id', isset($data['vehicle_type_id']) ? $data['vehicle_type_id'] : $types->first()->id)
                ->where('vehicle_make_id', isset($data['vehicle_make_id']) ? $data['vehicle_make_id'] : $makes->first()->id)
                ->orderBy('model')
                ->get()
            : collect([]);
        if ((!isset($data['vehicle_model_id']) || !$models->find($data['vehicle_model_id'])) && $models->first()) {
            // default to the first match
            $data['vehicle_model_id'] = $models->first()->id;
        }

        // render response
        return view('vehicle.create', [
            'customer' => Customer::find($data['customer_id']),
            'makes' => $makes,
            'models' => $models,
            'data' => $data,
            'types' => $types,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validateWithBag('post', [
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'vehicle_type_id' => ['required', 'integer', 'exists:vehicle_types,id'],
            'vehicle_make_id' => ['required', 'integer', 'exists:vehicle_makes,id'],
            'vehicle_model_id' => ['required', 'integer', 'exists:vehicle_models,id'],
            'year' => ['required', 'string', 'regex:/\d{4}/'],
        ]);
        Vehicle::create($data);
        return $request->ajax()
            ? response(['success' => true])
            : redirect(route('customer.show', ['customer' => $data['customer_id']]));
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
        $vehicle = Vehicle::findOrFail(intval($id));
        $customerId = $vehicle->customer_id;
        $vehicle->delete();
        return $request->ajax()
            ? response(['success' => true])
            : redirect(route('customer.show', ['customer' => $customerId]));
    }
}
