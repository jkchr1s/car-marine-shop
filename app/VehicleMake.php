<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleMake extends Model
{
    /**
     * Get the vehicle type associated with the make
     */
    public function vehicle_type()
    {
        return $this->belongsTo('App\VehicleType', 'id');
    }
}
