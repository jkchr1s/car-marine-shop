<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = ['customer_id', 'location_type_id', 'address1', 'address2', 'city', 'state', 'zip'];

    /**
     * Get the customer type associated with the customer
     */
    public function type()
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
