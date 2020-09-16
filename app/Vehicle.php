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
        'year',
    ];

    /**
     * Get the related customer object.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

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
        return $this->belongsTo('App\VehicleMake', 'vehicle_make_id');
    }

    /**
     * Get the model record associated with the vehicle.
     */
    public function model()
    {
        return $this->belongsTo('App\VehicleModel', 'vehicle_model_id');
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
        return $this->belongsTo('App\VehicleType', 'vehicle_type_id');
    }

    /**
     * Gets the description of the vehicle.
     *
     * @return string
     */
    public function getDescriptionAttribute()
    {
        return sprintf('%s %s %s', $this->year, $this->make->make, $this->model->model);
    }
}
