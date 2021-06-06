<?php

namespace App\Http\Controllers;

use App\User;
use App\LoanAccount;
use App\DeliveryNotification;
use App\Customer;
use App\OnlineCheckout;
use App\Transaction;
use App\SMS;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Response;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $req)
    {
        //
        // $req->validate([
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:6',],
        // ]);

        $client = new \GuzzleHttp\Client;
        //dd(config("services.passport.url"));
        $options = [
            "form_params" => [
                "username" => $req->username,
                "password" => $req->password,
                "client_id" => config("services.passport.client_id"),
                "client_secret" => config("services.passport.client_secret"),
                "grant_type" => "password",
            ]
        ]; 
        try {            
            $response = $client->post(config("services.passport.url"), $options);
            //dd($response->getBody()->getContents());
            //return $response->getBody();
            return response()->json(json_decode($response->getBody()));
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            //throw $th;
            if($e->getCode() == 400){
                return response(array("msg"=>"Please provide username and password","code"=>$e->getCode()), 400)
                  ->header('Content-Type', 'application/json');
            }else if($e->getCode() == 401){
                return response(array("msg"=>"Your credentials are incorrect, please try again ","code"=>$e->getCode()), 401)
                  ->header('Content-Type', 'application/json');
            }
            return response(array("msg"=>"something went wrong on the serve","code"=>$e->getCode()), 500)
                  ->header('Content-Type', 'application/json');
        }
    }

    public function deliveryNotification(Request $req){
        //$req = $req->all();
        $wednesday = Carbon::createFromFormat('Y-m-d H:i:s', "2020-02-12 00:00:00");
        if(Carbon::now()->lt($wednesday)){
            $validator = Validator::make($req->all(), [
                'customer_stall_id' => [ 'string','min:1', 'max:255'],
                'receipt_no' => ['required', 'string', 'min:3'],
                'amount' => ['required', 'min:2'],
                'date' => ['required', 'string', 'min:3'],
                'delivery_id' => ['required','min:1'],
                'customer_id' => ['required','min:1'],
                'phone_number' => ['required', 'min:1'],
                'till_number' => ['required', 'min:1']
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(),400);
            }else{
                $customer = Customer::where('customer_account_msisdn', $req->phone_number)->first();
    
                if($customer){
                    $delivery = DeliveryNotification::create([
                        //'customer_stall_id' => $req->customer_stall_id,
                        'delivery_id' => $req->delivery_id,
                        'receipt_number' => $req->receipt_no,
                        'amount' => $req->amount,
                        'delivery_date' => $req->date,
                        'till_number' => $req->till_number,
                        'phone' => $req->phone_number,
                        'twiga_customer_id' => $req->customer_id,
                        'customer_id' => $customer->id,
                        'CREATED_BY' => 4,
                        'payload' => json_encode($req->all())
                    ]);
    
                    $rst = SMS::sendsms($req->phone_number, "Dear ".$customer->person->first_name.", would you like M-Weza to facilitate your payment for the Twiga Delivery you just received? Dial *483*818# to make your request.");
                }
                //To be edited
                //
                //dd($customer);
                
                // if($customer){
                //     $rst = LoanAccount::create([
                //         //'customer_stall_id' => $req->customer_stall_id,
                //         'customer_account_id' => $customer->id,
                //         'delivery_id' => $delivery->id,
                //         'principal_amount' => $req->amount,
                //         'interest_charged' => 25.00,
                //         'loan_amount' => $req->amount + 25.00,
                //         'loan_balance' => $req->amount + 25.00,
                //         'loan_penalty' => 0.00,
                //         'loan_status' => 0
                //     ]);
                // }
    
                //ADD LOAN RECORD ON THE DATABASE 
                return response()->json(["responseCode"=>0,"responseDescription"=> "Delivery record received successfully"], 200);
            }
        }else{
            return response()->json(["responseCode"=>1,"responseDescription"=> "Delivery record not accepted, contact mweza"], 400);
        }        
    }

    public function lipanampesa(Request $req){
        Log::alert(json_encode($req->all()));
        //dd($req->all());
        $rst = json_decode(json_encode($req->all()));

        $stk_callback = json_encode($req->all());

        $amt = $rst->Body->stkCallback->CallbackMetadata->Item[0]->Value;
        $amtPaid = $amt;
        $mpesaCode = $rst->Body->stkCallback->CallbackMetadata->Item[1]->Value;
        $timestamp = $rst->Body->stkCallback->CallbackMetadata->Item[2]->Value;
        $msisdn = $rst->Body->stkCallback->CallbackMetadata->Item[3]->Value;
        $MerchantRequestID = $rst->Body->stkCallback->MerchantRequestID;
        $resultCode = $rst->Body->stkCallback->ResultCode;
        $resultDesc = $rst->Body->stkCallback->ResultDesc;

        //dd($MerchantRequestID);

        $stk_record = OnlineCheckout::where('merchant_request_id',$MerchantRequestID)
            ->where('result_code',null)
            ->first();
        //dd($stk_record);
        if($stk_record){
            $stk_record->result_code = $resultCode;
            $stk_record->result_description = $resultDesc;
            $stk_record->mpesa_receipt_number = $mpesaCode;
            $stk_record->transaction_time = $timestamp;
            $stk_record->stk_callback = $stk_callback;
            $stk_record->save();

            // Proceed with loan offsetting
            // 1. Check Customer
            //dd($msisdn);
            
            //Offset User
            $transaction = Transaction::where('transaction_reference',$mpesaCode)->first();
            if(!$transaction){    
                LoanAccount::offsetUser($msisdn,$amt,$mpesaCode,$timestamp,"PAYMENT_STK",$msisdn,$PaidByNames="NONE");
            }
        }
        return response(array("msg"=>"End point reached"), 200)
                  ->header('Content-Type', 'application/json');
    }

    public static function loanRepaymentTwiga($data,$loan){
        
        $curl = curl_init();
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => config('app.TWIGA_URL')."loan_repayment",
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
                "Authorization: Bearer ".config('app.TWIGA_BEARER_TOKEN'),
            ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);
        
        curl_close($curl);
        
        if ($err) {
            $loan->twiga_response = json_encode("cURL Error #:" . $err);
            $loan->save();
            return "cURL Error #:" . $err;
        } else {
            $loan->twiga_response = $response;
            $loan->save();
            return $response;
        };
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        // return Validator::make($data, [
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'string', 'min:8', 'confirmed'],
        // ]);
        User::create([
            'email' => 'twiga@mweza.ke',
            'password' => Hash::make('greatestPasswordIn2019'),
        ]);
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
