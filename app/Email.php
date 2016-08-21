<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * Get the customer that owns the email.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
