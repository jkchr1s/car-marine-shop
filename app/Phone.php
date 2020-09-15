<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id',
        'phone_type_id',
        'number',
    ];

    public function phone_type()
    {
        return $this->belongsTo('App\PhoneType', 'phone_type_id', 'id');
    }

    /**
     * Get the customer that owns the phone.
     */
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
