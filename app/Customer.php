<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    /**
     * Get the email records associated with the customer.
     */
    public function emails()
    {
        return $this->hasMany('App\Email');
    }

    /**
     * Get the phone records associated with the customer.
     */
    public function phones()
    {
        return $this->hasMany('App\Phone');
    }

    /**
     * Get the location records associated with the customer.
     */
    public function locations()
    {
        return $this->hasMany('App\Location');
    }

    /**
     * Get the vehicle records associated with the customer.
     */
    public function vehicles()
    {
        return $this->hasMany('App\Vehicle');
    }
}
