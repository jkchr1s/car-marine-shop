<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['first_name', 'last_name', 'company', 'customer_type_id'];

    /**
     * Get the customer type associated with the customer
     */
    public function customer_type()
    {
        return $this->belongsTo('App\CustomerType', 'id');
    }

    /**
     * Get the email records associated with the customer.
     */
    public function emails()
    {
        return $this->hasMany('App\Email', 'customer_id', 'id');
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
