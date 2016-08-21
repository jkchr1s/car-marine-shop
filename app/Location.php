<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * Get the customer that owns the location.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
