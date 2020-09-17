<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'icon',
    ];

    /**
     * One-to-many relationship for vehicle makes.
     *
     * @return void
     */
    public function vehicle_makes()
    {
        return $this->hasMany('App\VehicleMake');
    }
}
