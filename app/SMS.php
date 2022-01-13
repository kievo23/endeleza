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

    public static function sendSmsLeopard($phone,$sms){
        $url = 'https://api.smsleopard.com/v1/sms/send';
        //sort the numbers
        $destination = [[]];
        if(is_array($phone)){
            foreach ($phone as $key => $val) {
                # code...
                $destination[$key]['number'] = $val;
            }
        }else{
            $destination = array(
                array(
                    "number" => $phone
                )
            );
        }

        $data = array(
            "source" => config('app.SMS_SENDER_ID'),
            "message" => $sms,
            "destination" => $destination
        );
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                "accept: application/json",
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

    public static function sendSmsUjumbe($phone,$sms){
        $url = 'http://ujumbesms.co.ke/api/messaging';
        //sort the numbers
        
        $destination = array(
            array(
                "message_bag" => array(
                    "numbers"=>$phone,
                    "message"=>$sms,
                    "sender"=>"EndelezaCap"
                )
            )
        );

        $data = array(
            "data" => $destination,
        );
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'Content-Type: application/json',
                'Content-Length: ' . strlen(json_encode($data)),
                'email: '.config('app.SMS_UJUMBE_EMAIL'),
                'X-Authorization: '.config('app.SMS_UJUMBE_TOKEN'),
            ),
        ));
        
        $response = curl_exec($curl);
        if ($response === false) {
            $err = 'Curl error: ' . curl_error($curl);
            curl_close($curl);
            return $err;
        } else {
            curl_close($curl);

            return $response;
        }
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