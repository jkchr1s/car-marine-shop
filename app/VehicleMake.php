<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleMake extends Model
{
    protected $fillable = ['vehicle_type_id', 'make', 'icon'];

    /**
     * Get the vehicle type associated with the make
     */
    public function vehicle_type()
    {
        return $this->belongsTo('App\VehicleType', 'vehicle_type_id', 'id');
    }
}
