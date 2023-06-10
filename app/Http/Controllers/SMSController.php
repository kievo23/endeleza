<?php

namespace App\Http\Controllers;

use App\Jobs\SendSMSJob;
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
            dispatch(new SendSMSJob($phones, $req->sms));
        }else if($req->category == "select_customers"){
            dispatch(new SendSMSJob($req->customers, $req->sms));
        }else{
            foreach ($interestedCustomers as $key => $value) {
                dispatch(new SendSMSJob($value->customer_account_msisdn, $req->sms));
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
