<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryNotification;
use App\Customer;
use App\LoanAccount;
use App\SMS;
use App\Outbox;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeliveryNotificationsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $title = "All Requests";
        $delivery_notifications = DeliveryNotification::with('customer')->where('status',2)->orWhere('status',0)->orderBy('created_at','DESC')->limit(500)->get();
        $deliveriesWithLoans = DeliveryNotification::where('status',1)->count();
        $valueOfAllDeliveries = DeliveryNotification::sum('amount');
        $valueOfDeliveriesWithLoans = DeliveryNotification::where('status',1)->sum('amount');
        //dd($delivery_notifications);
        return view('delivery_notifications/index', compact('delivery_notifications','deliveriesWithLoans','valueOfAllDeliveries','valueOfDeliveriesWithLoans','title'));
    }

    public function ajax(Request $request)
    {
        if ($request->ajax()) {
            $data = DeliveryNotification::with('customer')->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){

                           $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm">View</a>';

                            return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function convert($id,Request $req)
    {
        //
        $request = DeliveryNotification::findOrFail($id);
        $status = null;
        //dd($req->status);
        if($req->status == "deny"){
            $status = 2;
            $request->status = $status;
            $rst = $request->save();         
            return redirect("loan_requests")
            //->route('loan_accounts.index')
            ->with('success','Loan denied successfully.');
        }else if($req->status == "give"){
            $status = 1;
            $request->status = $status;
            $rst = $request->save();
            //dd($rst);
            $loan = LoanAccount::where("delivery_id",$request->id)->first();
            if($loan){
                return redirect("loan_accounts")
                //->route('loan_accounts.index')
                ->with('error','Loan is already created.');
            }else{
                $customer = Customer::findOrFail($request->customer_id);
                $interest = number_format(($customer->interest/100 * $request->amount), 2, '.', '');
                
                $rst = LoanAccount::create([
                    'customer_account_id' => $request->customer_id,
                    'principal_amount' => $request->amount,
                    'trn_charge' => '0.00',
                    'delivery_id' => $request->id,
                    'till_number' => $request->till_number,
                    'interest_charged' => $interest,
                    'loan_amount' => $request->amount + $interest,
                    'loan_balance' => $request->amount + $interest,
                    'loan_penalty' => 0.00,
                    'loan_status' => 0
                ]);
                return redirect("loan_accounts")
                //->route('loan_accounts.index')
                ->with('success','Loan created successfully.');
            }
        }
    }

    public function newRequests(){
        $title = "New Requests";
        $delivery_notifications = DeliveryNotification::where('status',0)->get();
        return view('delivery_notifications/index', compact('delivery_notifications','title'));
    }

    public function approvedRequests(){
        $title = "Approved Requests";
        $delivery_notifications = DeliveryNotification::where('status',1)->get();
        return view('delivery_notifications/index', compact('delivery_notifications','title'));
    }

    public function deniedRequests(){
        $title = "Denied Request";
        $delivery_notifications = DeliveryNotification::where('status',2)->get();
        return view('delivery_notifications/index', compact('delivery_notifications','title'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        return view('delivery_notifications/create',compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        
        //dd($req->all());
        $customer = Customer::where('customer_account_msisdn',$req->customer)->first();
        //dd($customer);
        $create_loan = DeliveryNotification::create([
            //'customer_stall_id' => $req->customer_stall_id,
            'delivery_id' => $req->delivery_id,
            'receipt_number' => $req->receipt_no,
            'amount' => $req->amount,
            'delivery_date' => $req->date,
            'till_number' => $req->till,
            'phone' => $req->phone,
            'twiga_customer_id' => $req->customer_id,
            'customer_id' => $customer->id,
            'CREATED_BY' => 4,
            'payload' => json_encode($req->all())
        ]);

        $sms = "Endeleza Capital has initiated a loan of ".$req->amount."KES on your behalf on ".Carbon::now()->isoFormat('LLL');
        $res = SMS::sendSmsLeopard($customer->customer_account_msisdn,$sms);
        Outbox::log(json_decode($res),$sms);
        Log::alert($res);
        return redirect()->route('loan_accounts.index')
                        ->with('success','Loan Request created successfully.');

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
