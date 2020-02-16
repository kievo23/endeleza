<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use TraknPay\EloquentApproval\ApprovalTrait;
use Spatie\Activitylog\Traits\LogsActivity;

class CustomerMC extends Model
{
    use ApprovalTrait,LogsActivity;

    protected static $logName = 'customer';
    //protected static $logAttributes = ['*'];
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;
    //protected static $submitEmptyLogs = false;

    public static function isApprover(): bool
    {
        $user = auth()->user();
        if($user->hasRole('admin') || $user->hasPermissionTo('checker') ){
            return true;
        }else if($user == null){
            return false;
        }else{
            return false;
        }
    }
    protected $table = 'customers';

    // public function setPinAttribute($pass){
    //     $this->attributes['password'] = Hash::make($pass); 
    // }

    protected $fillable = [
        'blocked','active','customer_account_msisdn','pin','salt_key','pin_reset','account_limit', 'person_id', 'agent_id','rollover'
    ];

    protected $hidden = [
        'pin', 'salt_key'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class,'person_id','id')->withDefault(function ($person) {
            $person->first_name = 'Guest';
        });
    }

    public function agent()
    {
        return $this->belongsTo(Agent::class,'agent_id','id')->withDefault(function ($person) {
            $person->first_name = 'Guest';
        });
    }

    public function loanaccounts()
    {
        return $this->hasMany('App\LoanAccount', 'customer_account_id');
    }

    public static function activeCustomers(){
        return self::where('active', 1)
        ->get();
    }
    public static function customersWithLoans(){
        return self::select('customers.id','customers.customer_account_msisdn','people.surname','people.first_name')
            ->where('customers.active', 1)
            ->distinct()
            ->where('loan_account.loan_balance','>', 0)            
            ->leftJoin('loan_account', 'customers.id', '=', 'loan_account.customer_account_id')
            ->leftJoin('people', 'people.id', '=', 'customers.person_id')
            ->get();
    }
}
