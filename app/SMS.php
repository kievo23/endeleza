<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AfricasTalking\SDK\AfricasTalking;



class SMS extends Model
{
    public static function sendsms($phone,$message)
    {
        $username = 'ossKenya'; // use 'sandbox' for development in the test environment
        $apiKey   = 'fafaec7bdf65ab007a11936c4d5e1000ed105e9280f9f776199ef1de4d19f1a4'; // use your sandbox app API key for development in the test environment
        $AT = new AfricasTalking($username, $apiKey);

        // Get one of the services
        $sms      = $AT->sms();

        // Use the service
        $result   = $sms->send([
            'to'      => $phone,
            'message' => $message,
            'from' => 'M-WEZA'
        ]);

        return $result;
        
    }

    
}

/*

"sms": {
        "URL" : "https://api.africastalking.com/restless/send",
        "username" : "ossKenya",
        "apiKey" : "fafaec7bdf65ab007a11936c4d5e1000ed105e9280f9f776199ef1de4d19f1a4",
        "senderID" : "M-WEZA"
    }

*/