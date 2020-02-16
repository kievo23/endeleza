<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens,HasRoles,CausesActivity,LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected static $logName = 'users';
    //protected static $logAttributes = ['*'];
    protected static $logFillable = true;

    protected static $logOnlyDirty = true;
    
    protected $guard = 'web';
    protected $table = 'users';

    protected $fillable = [
        'name', 'email', 'password', 'active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function role()
    // {
    //     return $this->hasMany('App\Role', 'model_id');
    // }
}
