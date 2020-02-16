<?php

namespace App\Http\Controllers\Agent;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Customer;
use App\LoanAccount;
use App\DeliveryNotification;
use App\Transaction;
use Illuminate\Support\Facades\Log;

class AgentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:agents');
    }

    public function customers()
    {
        $customers = Customer::where('agent_id',Auth::user()->id)->get();
        $title = "List of my customers";
        return view('agentsGuard.mycustomers',compact('customers','title'));
    }

    public function customer($id)
    {
        $customer = Customer::where("agent_id",Auth::user()->id)->where("id",$id)->first();
        //dd($customer);
        if($customer){
            $query = 'SELECT * FROM (
                (SELECT loan_account.id,1 as type, trn_charge, interest_charged, loan_amount, loan_penalty, NULL as receipt,NULL as amount, created_at 
                FROM loan_account WHERE customer_account_id = '.$customer->id.')
                UNION ALL
                (SELECT transactions.id AS id,2 as type, null as trn_charge, NULL as interest_charged, NULL AS loan_amount, NULL AS loan_penalty,	transaction_reference as receipt,transaction_amount as amount, created_at 
                FROM transactions WHERE customer_id = '.$customer->id.')
            ) results
            ORDER BY `results`.`created_at`  ASC';
            $results = DB::select( $query);

            $title = "My customer: ".$customer->person->full_name. " (".$customer->customer_account_msisdn.")";
            $loans = LoanAccount::where('customer_account_id',$customer->id)->get();
            $transactions = Transaction::where('customer_id',$customer->id)->get();
            $delivery_notifications = DeliveryNotification::where('customer_id',$customer->id)->get();
            return view('agentsGuard.customer',compact('title','loans','transactions','delivery_notifications','results'));
        }else{
            return redirect()->route('agent.dashboard')
            ->with('error','You probably are not authorized to view this customer');
        }
    }

    public function dashboard(){
        //
        $customers = Customer::where('agent_id',Auth::user()->id)->pluck('id')->all();
        $collection = collect($customers);
        //dd($customers);
        //Log::alert($collection);
        //dd("done");
        $customers = Customer::where('agent_id',Auth::user()->id)->count();
        $activeCustomers = Customer::where('active',1)->where('agent_id',Auth::user()->id)->count();

        $loan_accounts = LoanAccount::whereIn('customer_account_id', $collection)->count();
        $clearedLoans = LoanAccount::whereIn('customer_account_id', $collection)->where('loan_status',1)->count();
        $valueOfLoans = LoanAccount::whereIn('customer_account_id', $collection)->sum('loan_amount');
        $valueOfTransactions = LoanAccount::whereIn('customer_account_id', $collection)->sum('trn_charge');
        $valueOfInterests = LoanAccount::whereIn('customer_account_id', $collection)->sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::whereIn('customer_account_id', $collection)->sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::whereIn('customer_account_id', $collection)->sum('loan_balance');

        $delivery_notifications = DeliveryNotification::whereIn('customer_id', $collection)->count();
        $deliveriesWithLoans = DeliveryNotification::whereIn('customer_id', $collection)->where('status',1)->count();
        $valueOfAllDeliveries = DeliveryNotification::whereIn('customer_id', $collection)->sum('amount');
        $valueOfDeliveriesWithLoans = DeliveryNotification::whereIn('customer_id', $collection)->where('status',1)->sum('amount');

        $transactions = Transaction::whereIn('customer_id', $collection)->count();
        $valueOfAllTransactions = Transaction::whereIn('customer_id', $collection)->sum('transaction_amount');
        $transactionsWithoutACustomer = Transaction::whereIn('customer_id', $collection)->where('customer_id',NULL)->count();
        $layout = "agent"; 
        $graph_d = [];
        $graph_r = [];
        $graph_l = [];
        $dates = [];
        return view('dashboard/agent',compact(
            'loan_accounts',
            'clearedLoans',
            'valueOfLoans',
            'valueOfTransactions',
            'valueOfInterests',
            'valueOfLoanPenalty',
            'valueOfOutstandingLoans',
            'customers',
            'activeCustomers',
            'delivery_notifications',
            'deliveriesWithLoans',
            'valueOfAllDeliveries',
            'valueOfDeliveriesWithLoans',
            'transactions',
            'valueOfAllTransactions',
            'transactionsWithoutACustomer',
            'layout',
            'graph_d',
            'graph_r',
            'graph_l',
            'dates'
        ));
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
