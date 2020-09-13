<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'vehicle_type_id',
        'vehicle_make_id',
        'vehicle_model_id',
        'year'
    ];

    /**
     * Get the identification records associated with the vehicle.
     */
    public function identifications()
    {
        return $this->hasMany('App\VehicleIdentification');
    }
    
    /**
     * Get the make record associated with the vehicle.
     */
    public function make()
    {
        return $this->hasOne('App\VehicleMake');
    }

    /**
     * Get the model record associated with the vehicle.
     */
    public function model()
    {
        return $this->hasOne('App\VehicleModel');
    }

    /**
     * Get the note records associated with the vehicle.
     */
    public function notes()
    {
        return $this->hasMany('App\VehicleNote');
    }

    /**
     * Get the part records associated with the vehicle.
     */
    public function parts()
    {
        return $this->hasMany('App\VehiclePart');
    }

    /**
     * Get the type record associated with the vehicle.
     */
    public function type()
    {
        return $this->hasOne('App\VehicleType');
    }
}
