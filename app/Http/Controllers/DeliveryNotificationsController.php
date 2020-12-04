<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeliveryNotification;
use App\Customer;
use App\LoanAccount;

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
        if($req->status == "denay"){
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
        $delivery_notifications = DeliveryNotification::where('status',0)->get();
        return view('delivery_notifications/index', compact('delivery_notifications','title'));
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
