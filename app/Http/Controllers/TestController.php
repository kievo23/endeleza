<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\SMS;
use App\Outbox;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $sms = "welewele inadecode";
        $res = SMS::sendSmsLeopard($sms,'0710345130');
        //$res = '{"success":true,"message":"Sent to 1/1. Cost KES 0.90","recipients":[{"id":"a75ec5de-2fe0-424a-a5b3-f25bad1cbbef","cost":0.9,"number":"+254710345130","status":"queued"}]}';
        //Log::alert($res);
        //print_r(json_decode($res)->recipients);
        Outbox::log(json_decode($res),$sms);
        return $res;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function report()
    {
        //
        $data = DB::table('loan_account')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(principal_amount) as amount_advanced'),
                DB::raw('SUM(loan_amount) as expected_amount'),
                DB::raw('SUM(loan_amount - loan_balance) as amount_paid')
            )
            ->whereYear('created_at', '=', Carbon::now()->year)
            ->orWhereYear('created_at', '=', Carbon::now()->subYear()->year)
            ->groupBy('year', 'month')
            ->get(); 
        return response()
            ->json(['data'=>$data])
            ->header('Content-Type', 'application/json');
    }

    public function registerUrlMpesa(){
        $url = 'https://api.safaricom.co.ke/mpesa/c2b/v1/registerurl';
  
  
        $mpesa= new \Safaricom\Mpesa\Mpesa();
        $AccessToken = $mpesa::generateLiveToken();
        //echo $AccessToken;
  
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Authorization:Bearer '.$AccessToken)); //setting custom header
  
        $curl_post_data = array(
          //Fill in the request parameters with valid values
          'ShortCode' => env('MPESA_C2B_SHORT_CODE'),
          'ResponseType' => 'Completed',
          'ConfirmationURL' => 'https://app.endelezacapital.com/api/confirmTransactionUrl',
          'ValidationURL' => 'https://app.endelezacapital.com/api/validateTransactionUrl'
        );
  
        $data_string = json_encode($curl_post_data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);
  
        $curl_response = curl_exec($curl);
        print_r($curl_response);
      }  

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
