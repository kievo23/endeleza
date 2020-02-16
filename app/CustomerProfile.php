<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerProfile extends Model
{
    protected $table = 'customer_profile';

    protected $primaryKey = 'profileID';
}
