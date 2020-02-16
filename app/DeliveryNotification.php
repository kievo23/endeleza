<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryNotification extends Model
{
    protected $table = 'delivery_notification';

    protected $fillable = [
        'customer_stall_id',
        'notification_identifier',
        'receipt_number',
        'amount',
        'delivery_id',
        'delivery_date',
        'route_team_id',
        'twiga_customer_id',
        'till_number',
        'customer_id',
        'phone',
        'status',
        'payload',
        'created_by'
    ];

    public function loanaccounts()
    {
        return $this->hasOne('App\LoanAccount');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id','id')->withDefault(function ($customer) {
            $customer->first_name = 'Customer Not Found';
        });
    }

    public function customerstalls()
    {
        return $this->belongsTo('App\CustomerStall');
    }
}