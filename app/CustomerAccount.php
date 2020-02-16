<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerAccount extends Model
{
    protected $table = 'customer';
    
    protected $primaryKey = 'CUSTOMER_ID';

    public function loanaccounts()
    {
        return $this->hasMany('App\LoanAccount');
    }
}