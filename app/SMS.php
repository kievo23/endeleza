<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use AfricasTalking\SDK\AfricasTalking;
use Illuminate\Support\Facades\Log;


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

    public static function sendSmsLeopard($sms,$phone){
        $url = 'https://api.smsleopard.com/v1/sms/send';
        $data = array(
            "source" => config('app.SMS_SENDER_ID'),
            "message" => $sms, 
            "destination" => array(
                array(
                    "number" => $phone
                )
            )
        );
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url = 'https://api.smsleopard.com/v1/sms/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "accept: */*",
                "accept-language: en-US,en;q=0.8",
                "content-type: application/json",
                "Authorization: Basic ".base64_encode(config('app.SMS_ACCOUNT_ID').":".config('app.SMS_SECRET_KEY')),
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        return $response;
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