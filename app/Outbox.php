<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    //
    protected $table = 'outbox';
    protected $fillable = [
        'phone',
        'text',
        'status',
        'cost'
    ];

    public static function log($data,$sms){
        $encoded = json_decode(json_encode($data));
        $encodedArray = $encoded->data->SMSMessageData->Recipients;
        foreach ($encodedArray as $key => $log) {
            # code...
            Outbox::create([
                'phone' => $log->number,
                'text' => $sms,
                'status' => $log->status,
                'cost' => $log->cost
            ]);
        }
        return true;
    }
}
