<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checker extends Model
{
    //
    protected $table = 'approvals';

    protected $fillable = [
        'user_id','approver_id','model','operation','values','changes',
        'is_approved', 'approved_by', 'approved_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id')->withDefault(function ($user) {
            $user->email = 'Ghost';
        });
    }

    public function approver()
    {
        return $this->belongsTo(User::class,'approved_by','id')->withDefault(function ($user) {
            $user->email = 'Ghost';
        });
    }
}
