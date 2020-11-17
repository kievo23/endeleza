<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Person extends Model
{
    //
    use LogsActivity;

    protected static $logName = 'persons';
    //protected static $logAttributes = ['*'];
    protected static $logFillable = true;
    protected static $logOnlyDirty = true;

    protected $table = 'people';

    protected $fillable = ['surname', 'first_name', 'other_names', 'gender','twiga_response', 'date_of_birth', 'id_number', 'primary_msisdn', 'alternate_msisdn', 'postal_address', 'physical_location','business_name'];

    public function customers()
    {
        return $this->hasMany(Customer::class,'person_id','person_id');
    }

    public function salesagents()
    {
        return $this->hasMany('App\Agent');
    }

    public function getFullNameAttribute(){
        return $this->first_name." ".$this->surname." ".$this->other_names;
    }

    public function getTwoNameAttribute(){
        return $this->first_name." ".$this->surname;
    }
}
