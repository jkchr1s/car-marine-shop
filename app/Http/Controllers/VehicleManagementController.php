<?php

// namespace App\Http\Controllers;

// use App\VehicleMake;
// use Illuminate\Http\Request;

// use App\Http\Requests;

// class VehicleManagementController extends Controller
// {
//     /**
//      * Create a new controller instance.
//      *
//      * @return void
//      */
//     public function __construct()
//     {
//         $this->middleware('auth');
//     }

//     /**
//      * Function that gets the vehicle makes.
//      *
//      * @param \Illuminate\Http\Request $request
//      * @return \Illuminate\Http\Response
//      */
//     public function getMakes(Request $request)
//     {
//         $list = VehicleMake::select('make as value', 'id as data')
//             ->where('make', 'like', '%'.$request->input('query', '').'%')
//             ->orderBy('make')
//             ->get();
//         return response(['suggestions' => $list]);
//     }

//     /**
//      * Function the gets the specified vehicle make
//      *
//      * @param $id
//      * @return \Illuminate\Http\Response
//      */
//     public function getMake($id)
//     {
//         $item = VehicleMake::find($id);
//         return response($item);
//     }

//     /**
//      * Function the gets the specified vehicle make
//      *
//      * @param $id
//      * @return \Illuminate\Http\Response
//      */
//     public function delMake($id)
//     {
//         $item = VehicleMake::find($id);
//         $result = $item->delete();
//         return response(['deleted' => $result]);
//     }
// }
