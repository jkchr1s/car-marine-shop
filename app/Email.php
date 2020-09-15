<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Email extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'customer_id',
    ];

    /**
     * Get the customer that owns the email.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
