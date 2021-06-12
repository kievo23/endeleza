<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        $encodedArray = $data->recipients;
        
        try {
            //code...
            foreach ($encodedArray as $key => $log) {
                # code...
                Outbox::create([
                    'phone' => $log->number,
                    'text' => $sms,
                    'status' => $log->status,
                    'cost' => $log->cost
                ]);
            }
        } catch (\Throwable $th) {
            //throw $th;
            Log::error("Throw error: ".$th);
        }
        
        return true;
    }
}
