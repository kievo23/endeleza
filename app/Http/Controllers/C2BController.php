<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\OnlineCheckout;
use App\LoanAccount;
use Illuminate\Support\Facades\Log;

class C2BController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function confirmUrlMpesa(Request $req){
        //Log::info("confirmationURL".json_decode($req->getContent(), true));
        Log::info("ConfirmURL");
        Log::info(json_encode($req->all()));
        
        $rst = json_decode(json_encode($req->all()));
        
        
        $mpesaCode = $rst->TransID;
        $account_no = $rst->BillRefNumber;
        $msisdn = $rst->MSISDN;
        $amt = $rst->TransAmount;
        $timestamp = $rst->TransTime;
        $balance = $rst->OrgAccountBalance;
        // "FirstName": "KELVIN",
        // "MiddleName": "CHEGE",
        // "LastName": "MAINA",
        $desc = "Payment C2B";
        $PaidByNames = $rst->FirstName ." ".$rst->MiddleName." ".$rst->LastName;

        $find_record = OnlineCheckout::where('mpesa_receipt_number',$mpesaCode)->first();
        
        if(!$find_record){
            OnlineCheckout::create([
                //"transaction_identifier" => $conversationId,
                "mpesa_receipt_number" => $mpesaCode,
                "amount" => $amt,
                "payer_number" => $msisdn,
                "msisdn" => $account_no,
                "stk_callback" => json_encode($req->all()),
                "mpesa_transaction_date" => $timestamp,
                //"result_description" => $resultDesc,
                //"result_code" => $resultCode
            ]);

            $mpesa= new \Safaricom\Mpesa\Mpesa();
            $trasactionStatus = $mpesa->transactionStatus(
            $Initiator = "kakituchege",
            $SecurityCredential = config('app.MPESA_C2B_SECURITY_CREDENTIAL'),
            $CommandID = 'TransactionStatusQuery',
            $TransactionID = $mpesaCode,
            $PartyA = config('app.MPESA_C2B_SHORT_CODE'),
            $IdentifierType = 4,
            $ResultURL = config('app.APP_DOMAIN')."/api/CtoBReceiveConfirmation",
            $QueueTimeOutURL = config('app.APP_DOMAIN')."/api/CRBCtoBReceiveTimeOut",
            $Remarks = "Test",
            $Occasion = "PAYMENT");
            $callbackData = $mpesa->finishTransaction();
        }
        //Check if the BillRefNumber exists and if not store it in suspense account
        $transaction = Transaction::where('transaction_reference',$mpesaCode)->first();
        if(!$transaction){
            LoanAccount::offsetUser($msisdn,$amt,$mpesaCode,$timestamp,"PAYMENT_PAYBILL",$account_no);                
        }
        return response('{"ResultCode":0,"ResultDesc":"Confirmation received successfully"}', 200)
                ->header('Content-Type', 'application/json');
        
        //dd(json_decode($req->getContent(), true));
    }

    public function validateUrlMpesa(Request $req){
        Log::info("ValidationURL");
        Log::info(json_encode($req->all()));
        //dd(json_decode($req->getContent(), true));
        // if(!isset($req->token)){
        //   return response('{"ResultCode":1, "ResultDesc":"Token doesnt exist", "ThirdPartyTransID": 401}', 400)->header('Content-Type', 'application/json');
        //   exit();
        // }
        // if($req->token != "wLYSuwXcHnanB2TE"){
        //   return response('{"ResultCode":1, "ResultDesc":"Invalid Token", "ThirdPartyTransID": 400}', 400)->header('Content-Type', 'application/json');
        //   exit();
        // }else{
          return response('{"ResultCode":0, "ResultDesc":"Success", "ThirdPartyTransID": 0}', 200)->header('Content-Type', 'application/json');
        //}
    }
    public function index()
    {
        //
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
