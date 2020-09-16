<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::auth();
Route::get('/logout', 'Auth\LoginController@logout');

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('/vehicle_make', 'VehicleMakeController');
    Route::resource('/vehicle_type', 'VehicleTypeController');
    Route::resource('/vehicle_model', 'VehicleModelController');
    Route::resource('/customer', 'CustomerController');
    Route::resource('/email', 'EmailController');
    Route::resource('/phone', 'PhoneController');
    Route::resource('/location', 'LocationController');
    Route::resource('/vehicle', 'VehicleController');
});
