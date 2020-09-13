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
        $validatedData = $request->validate([
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
                'exlucde-if:vehicle_model_id,',
                Rule::exists('vehicle_models')->where(function ($query) use ($request) {
                    $query->where('vehicle_type_id', intval($request->input('vehicle_type_id')))
                        ->where('vehicle_make_id', intval($request->input('vehicle_make_id')))
                        ->where('id', intval($request->input('vehicle_model_id')));
                }),
            ]
        ]);

        return view('vehicle.create', [
            'customer' => Customer::find($validatedData['customer_id']),
            'makes' => isset($validatedData['vehicle_type_id'])
                ? VehicleMake::where('vehicle_type_id', $validatedData['vehicle_type_id'])
                    ->select('id', 'make')
                    ->orderBy('make')
                    ->get()
                : collect([]),
            'models' => isset($validatedData['vehicle_make_id'])
                ? VehicleModel::where('vehicle_type_id', $validatedData['vehicle_type_id'])
                    ->where('vehicle_make_id', $validatedData['vehicle_make_id'])
                    ->select('id', 'model')
                    ->orderBy('model')
                    ->get()
                : collect([]),
            'data' => $validatedData,
            'types' => VehicleType::select('id', 'type')
                ->orderBy('type')
                ->get(),
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
        $validatedData = $request->validateWithBag('post', [
            'customer_id' => ['required', 'integer', 'exists:customers,id'],
            'vehicle_type_id' => ['required', 'integer', 'exists:vehicle_types,id'],
            'vehicle_make_id' => ['required', 'integer', 'exists:vehicle_makes,id'],
            'vehicle_model_id' => ['required', 'integer', 'exists:vehicle_models,id'],
            'year' => ['required', 'string', 'regex:/\d{4}/'],
        ]);
        Vehicle::create($validatedData);
        return redirect('customer.show', [$validatedData['customer_id']]);
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
        //
    }
}
