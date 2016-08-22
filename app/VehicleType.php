<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    public function vehicle_makes() {
        return $this->hasMany('App\VehicleMake');
    }
}
