<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleModel extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vehicle_type_id',
        'vehicle_make_id',
        'model',
    ];

    /**
     * Get the type record associated with the vehicle.
     */
    public function type()
    {
        return $this->belongsTo('App\VehicleType', 'vehicle_type_id');
    }

    /**
     * Get the make record associated with the vehicle.
     */
    public function make()
    {
        return $this->belongsTo('App\VehicleMake', 'vehicle_make_id');
    }
}
