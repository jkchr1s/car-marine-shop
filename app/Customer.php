<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'company', 'customer_type_id'];

    /**
     * Get the customer type associated with the customer.
     */
    public function customer_type()
    {
        return $this->belongsTo('App\CustomerType', 'customer_type_id', 'id');
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

    /**
     * Gets the display name for the customer.
     *
     * @return string
     */
    public function getDisplayNameAttribute()
    {
        return empty($this->company)
            ? sprintf('%s %s', $this->first_name, $this->last_name)
            : $this->company;
    }
}
