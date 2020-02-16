<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    protected $table = 'customer_account_types';
    // protected $primaryKey = 'CUSTOMER_TYPE_ID';
    protected $fillable = ['customer_account_type', 'description', 'minimum_account_balance'];
}
