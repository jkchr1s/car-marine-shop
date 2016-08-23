<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

use App\Customers;

Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::get('/api/vehicle/make', 'VehicleManagementController@getMakes');
Route::get('/api/vehicle/make/{id}', 'VehicleManagementController@getMake');
Route::delete('/api/vehicle/make/{id}', 'VehicleManagementController@getMake');

Route::group(['middleware' => 'auth'], function() {
   Route::resource('/vehicle_make', 'VehicleMakeController');
   Route::resource('/vehicle_type', 'VehicleTypeController');
   Route::resource('/customer', 'CustomerController');
   Route::resource('/email', 'EmailController');
   Route::resource('/phone', 'PhoneController');
});
