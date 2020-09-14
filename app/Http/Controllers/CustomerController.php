<?php

namespace App\Http\Controllers;

use App\CustomerType;
use App\LocationType;
use App\PhoneType;
use Log;
use App\Customer;
use Illuminate\Http\Request;

use App\Http\Requests;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::orderBy('last_name')->get();
        $types = CustomerType::orderBy('type')->get();

        if (empty($customers)) {
            $customers = [];
        }

        return view('customer.customers-all', [
            'customers' => $customers,
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
        return view('customer.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       $customer = new Customer();
       $customer->customer_type_id = intval($request->input('customer_type'));
       $customer->first_name = $request->has('first_name') ? $request->input('first_name') : '';
       $customer->last_name = $request->has('last_name') ? $request->input('last_name') : '';
       $customer->company = $request->has('company') ? $request->input('company') : '';
       $customer->save();
       return redirect('/customer/'.$customer->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customer.customer', [
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'company' => $customer->company,
            'customer_type' => $customer->customer_type,
            'emails' => $customer->emails,
            'phones' => $customer->phones,
            'locations' => $customer->locations,
            'vehicles' => $customer->vehicles,
            'customer_id' => $id,
            'phone_types' => PhoneType::orderBy('type')->get(),
            'location_types' => LocationType::orderBy('type')->get()
        ]);
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
