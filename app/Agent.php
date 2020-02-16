<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Activitylog\Traits\LogsActivity;

class Agent extends Authenticatable
{
    use Notifiable,HasApiTokens,LogsActivity;

    protected static $logName = 'loans';
    //protected static $logAttributes = ['*'];
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    
    protected $table = 'sales_agents';

    protected $guard = 'agents';

    protected $fillable = [
        'person_id','agent_msisdn','pin_reset','pin','salt_key','email', 'password',
    ];

    protected $hidden = [
        'pin', 'salt_key','password'
    ];

    // public function setPinAttribute($pass){
    //     $this->attributes['password'] = Hash::make($pass);
    // }

    public function person()
    {
        return $this->belongsTo('App\Person');
    }
}
