<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleModel extends Model
{
    /**
     * Get the make record associated with the vehicle.
     */
    public function make()
    {
        return $this->hasOne('App\VehicleMake');
    }
}
