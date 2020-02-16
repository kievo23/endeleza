<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'customer_id',
        'gl_account_id',
        'loan_account_id',
        'msisdn',
        'paid_by',
        'transaction_reference',
        'transaction_amount',
        'debit',
        'credit',
        'gl_debit',
        'gl_credit',
        'transaction_time',
        'transaction_status',
        'transaction_type'
    ];

    public function customer()
    {
        return $this->belongsTo('App\Customer', 'customer_id');
    }

    // public function getLoanAccountIdAttribute($value)
    // {
    // return $value ?: '(No ID provided)';
    // }
}
