<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    protected $fillable = ['customer_id', 'type', 'number'];

    /**
     * Get the customer that owns the phone.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
