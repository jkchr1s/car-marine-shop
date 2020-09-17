<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleMake extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vehicle_type_id',
        'make', 'icon',
    ];

    /**
     * Get the vehicle type associated with the make.
     */
    public function vehicle_type()
    {
        return $this->belongsTo('App\VehicleType', 'vehicle_type_id', 'id');
    }
}
