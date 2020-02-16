<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerStall extends Model
{
    //
    protected $table = 'customer_stall';

    public function deliverynotifications()
    {
        return $this->hasMany('App\DeliveryNotification');
    }
}
