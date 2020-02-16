<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OnlineCheckout extends Model
{
    protected $table = 'online_checkout';  

    protected $fillable = [
        'transaction_identifier',
        'msisdn',
        'paybill',
        'amount',
        'payer_number',
        'transaction_id',
        'description',
        'transaction_time',
        'merchant_request_id',
        'checkout_request_id',
        'response_description',
        'response_code',
        'customer_message',
        'result_body',
        'stk_callback',
        'result_code',
        'result_description',
        'callback_metadata',
        'item',
        'mpesa_receipt_number',
        'pay_bill_balance',
        'mpesa_transaction_date',
        'error_code',
        'error_message',
        'processing_code',
        'core_response_code',
        'core_response_message',
        'created_at'
    ];
}