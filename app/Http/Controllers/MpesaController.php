<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\OnlineCheckout;
use App\Transaction;
use App\LoanAccount;

class MpesaController extends Controller
{
    
    //Confirm C2B transaction
    public function transactionQuery(){
        return view('transactions.verify');
      }
  
      public function transactionQueryPost(Request $req){
        Log::info(json_encode($req->all()));
        //dd(self::generateLiveToken());
        //dd($req->all());
        //dd(config('app.APP_DOMAIN'));
        $mpesa = new \Safaricom\Mpesa\Mpesa();
          $trasactionStatus = $mpesa->transactionStatus(
            $Initiator = config('app.MPESA_C2B_INITIATOR'),
            $SecurityCredential = config('app.MPESA_C2B_SECURITY_CREDENTIAL'),
            $CommandID = 'TransactionStatusQuery',
            $TransactionID = $req->mpesaCode,
            //$PartyA = $req->msisdn,
            $PartyA = config('app.MPESA_C2B_SHORT_CODE'),
            $IdentifierType = 4,
            $ResultURL = config('app.APP_DOMAIN')."/api/transactionQueryResult",
            $QueueTimeOutURL = config('app.APP_DOMAIN')."/api/CRBCtoBReceiveTimeOut",
            $Remarks = "Missed_Payment",
            $Occasion = "Loan_PAYMENT");
          $callbackData = $mpesa->finishTransaction();
          Log::info(json_encode($callbackData));
          //dd(json_encode($callbackData));
          return view('transactions.verify');
      }
  
      public function transactionQueryResult(Request $req){
        Log::info("Query Result");
        Log::info(json_encode($req->all()));
        //dd("Done");
        
        $rst = json_decode(json_encode($req->all()));
        $resultCode = $rst->Result->ResultCode;
        $resultDesc = $rst->Result->ResultDesc;
        if($resultCode == "0"){
          $mpesaCode = $rst->Result->ResultParameters->ResultParameter[12]->Value;
          $amt = $rst->Result->ResultParameters->ResultParameter[10]->Value;
          $timestamp = $rst->Result->ResultParameters->ResultParameter[9]->Value;
          $conversationId = $rst->Result->ConversationID;
          $payer = explode("-", $rst->Result->ResultParameters->ResultParameter[0]->Value);
          $msisdn = trim($payer[0]);
          //dd($phone);

          $checkout_record = OnlineCheckout::where('mpesa_receipt_number',$mpesaCode)
            ->first();
          $trans_record = Transaction::where('transaction_reference',$mpesaCode)
            ->first();
  
          //$transaction = TransactionLogs::where('receipt',$mpesaCode)->first();
          if(!$trans_record){
            Log::info("No record Found");          
            LoanAccount::offsetUser($msisdn,$amt,$mpesaCode,$timestamp,"PAYMENT_QUERY",$msisdn);
          }
          
          if(empty($checkout_record)){
            OnlineCheckout::create([
              "transaction_identifier" => $conversationId,
              "mpesa_receipt_number" => $mpesaCode,
              "amount" => $amt,
              "payer_number" => $payer,
              "msisdn" => $msisdn,
              "stk_callback" => json_encode($req->all()),
              "mpesa_transaction_date" => $timestamp,
              "result_description" => $resultDesc,
              "result_code" => $resultCode
            ]);
          }else{
            Log::info("Record Found");
          }        
        }else{
            Log::info("Result Code not successful");
        }  
        return response('{"ResultCode": 0,"ResultDesc": "Accepted"}', 200)->header('Content-Type', 'application/json');
      }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
