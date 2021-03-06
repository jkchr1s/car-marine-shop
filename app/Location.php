<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'location_type_id',
        'address1',
        'address2',
        'city',
        'state',
        'zip',
    ];

    /**
     * Get the customer type associated with the customer.
     */
    public function location_type()
    {
        return $this->belongsTo('App\LocationType');
    }

    /**
     * Get the customer that owns the location.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
