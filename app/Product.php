<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'PRODUCT_ID';

    public function loanaccounts()
    {
        return $this->hasMany('App\LoanAccount');
    }
}
