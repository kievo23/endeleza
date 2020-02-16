<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'id', 'name', 'guard_name'
    ];

    public function role()
    {
        return $this->belongsTo(User::class,'model_id','id')->withDefault(function ($customer) {
            $customer->first_name = 'Role Not Found';
        });
    }
}