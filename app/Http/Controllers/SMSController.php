<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SMS;
use App\Customer;
use App\Outbox;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;

class SMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
        
    // }

    public function __construct()
    {
        //$this->middleware(['permission:sms']);
    }
    
    public function index()
    {
        //
        //$permission = Permission::create(['name' => 'logs']);
        $customers = Customer::all();
        return view('messages/index',compact('customers'));
    }

    public function list()
    {
        //
        $outbox = Outbox::all()->toArray();
        return response()->json(['data' => $outbox],200);
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
    public function send(Request $req)
    {
        //
        $interestedCustomers = [];
        if($req->category == "all"){
            $interestedCustomers = Customer::all();
        }else if($req->category == "active"){
            $interestedCustomers = Customer::activeCustomers();
        }else if($req->category == "customers_with_loans"){
            $interestedCustomers = Customer::customersWithLoans();
        }
        
        
        if($req->category == "custom"){
            $phones = explode(',',$req->phones);
            $rst = SMS::sendSmsLeopard($phones, $req->sms);
            //Log::alert($rst);
            //$rst = '{"success":true,"message":"Sent to 2/2. Cost KES 1.90","recipients":[{"id":"95da5359-1133-4f4f-8800-4e6a954c607b","cost":0.9,"number":"+254710345130","status":"queued"},{"id":"638ccbdc-caf9-47a8-b748-095ff0505a21","cost":1,"number":"+254105730538","status":"queued"}]}';
            //Log::alert(json_decode($rst));
            Outbox::log(json_decode($rst),$req->sms);
        }else if($req->category == "select_customers"){
            $rst = SMS::sendSmsLeopard($req->customers, $req->sms);
            Outbox::log(json_decode($rst),$req->sms);
        }else{
            foreach ($interestedCustomers as $key => $value) {
                $rst = SMS::sendSmsLeopard($value->customer_account_msisdn, $req->sms);
                Outbox::log(json_decode($rst),$req->sms);
            }
        }        
        
        return redirect('messages')->with('status', 'Messages queued for Sending!!');
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
