<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LoanAccount;
use App\SMS;
use App\Person;
use App\Customer;
use App\DeliveryNotification;
use App\Transaction;
use Carbon\Carbon;
use DB;

class AdminController extends Controller
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
        
        $startMonth = Carbon::now()->format('Y-m-d');
        $endMonth = Carbon::now()->subMonth()->format('Y-m-d');
        $period = Carbon::parse($endMonth)->daysUntil($startMonth);
        //dd($period);
        $dates = [];
        $datesCompute = [];
        foreach ($period as $key => $date) {
            $day = $date->format('m-d');
            array_push($dates,$day);
            array_push($datesCompute, $date->format('Y-m-d'));
        }
        
        $graph_loans = LoanAccount::select([
            DB::raw('sum(principal_amount) as `amount`'),
            DB::raw('DATE(created_at) as day')
          ])->groupBy('day')
          ->where('created_at', '>=', Carbon::now()->subMonth())
          ->get();

        $graph_repayments = Transaction::select([
            // This aggregates the data and makes available a 'count' attribute
            DB::raw('sum(transaction_amount) as `amount`'), 
            // This throws away the timestamp portion of the date
            DB::raw('DATE(created_at) as day')
          // Group these records according to that day
          ])->groupBy('day')
          // And restrict these results to only those created in the last week
          ->where('created_at', '>=', Carbon::now()->subMonth())
          ->get();

        $graph_deliveries = DeliveryNotification::select([
            // This aggregates the data and makes available a 'count' attribute
            DB::raw('sum(amount) as `amount`'), 
            // This throws away the timestamp portion of the date
            DB::raw('DATE(created_at) as day')
          // Group these records according to that day
          ])->groupBy('day')
          // And restrict these results to only those created in the last week
          ->where('created_at', '>=', Carbon::now()->subMonth())
          ->get();

        // $graph_loans_customer = LoanAccount::select([
        //     DB::raw('sum(loan_amount) as `amount`'),
        //     DB::raw('customer_account_id as customer')
        //   ])->groupBy('customer')
        //   //->where('created_at', '>=', Carbon::now()->subMonth())
        //   ->orderBy('amount','desc')
        //   ->get();

        // $graph_repayments_customer = Transaction::select([
        //     // This aggregates the data and makes available a 'count' attribute
        //     DB::raw('sum(transaction_amount) as `amount`'), 
        //     // This throws away the timestamp portion of the date
        //     DB::raw('customer_id as customer')
        //   // Group these records according to that day
        //   ])->groupBy('customer')
        //   // And restrict these results to only those created in the last week
        //   //->where('created_at', '>=', Carbon::now()->subMonth())
        //   ->orderBy('amount','desc')
        //   ->get();

        $graph_d = [];
        $graph_r = [];
        $graph_l = [];
        $countd = 0;
        $countr = 0;
        $countl = 0;
        //dd(count($datesCompute));
        foreach($datesCompute as $key => $date){
            //dd($graph_deliveries[$count]->day);
            try {
                if($date == $graph_deliveries[$countd]->day){
                    array_push($graph_d, $graph_deliveries[$countd]->amount);
                    $countd ++;
                }else{
                    array_push($graph_d, 0);
                }

                if($date == $graph_repayments[$countr]->day){
                    array_push($graph_r, $graph_repayments[$countr]->amount);
                    $countr ++;
                }else{
                    array_push($graph_r, 0);
                }

                if($date == $graph_loans[$countl]->day){
                    array_push($graph_l, $graph_loans[$countl]->amount);
                    $countl ++;
                }else{
                    array_push($graph_l, 0);
                }
            } catch (\Throwable $th) {
                //throw $th;
                //print_r($th);
            }
        }
        //dd($graph_d);
        // foreach ($graph_deliveries as $key => $delivery) {
        //     array_push($graph_d, $delivery->amount);
        // }

        // foreach ($graph_repayments as $key => $repayment) {
        //     array_push($graph_r, $repayment->amount);
        // }

        // foreach ($graph_loans as $key => $loan) {
        //     array_push($graph_l, $loan->amount);
        // }        
        
        
        //dd($dates);
        //exit();
        //END OF GRAPH

        //Data
        $loan_accounts = LoanAccount::count();
        $clearedLoans = LoanAccount::where('loan_status',1)->count();
        $valueOfLoans = LoanAccount::sum('principal_amount');
        $valueOfPrincipalOnLoans = LoanAccount::where('loan_status',1)->sum('loan_amount');
        $valueOfTransactions = LoanAccount::sum('trn_charge');
        $valueOfInterests = LoanAccount::sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::sum('loan_balance');
        //$healthyLoans = LoanAccount::where('created_at', '>', Carbon::now()->subDays(8))->sum('loan_balance');

        $lateLoans = LoanAccount::whereBetween('created_at', [Carbon::now()->subDays(29) ,Carbon::now()->subDays(8) ])
            ->sum('loan_balance');

        $defaulters = LoanAccount::where('created_at', '<', Carbon::now()->subDays(29))
            ->sum('loan_balance');

        $customers = Customer::count();
        $activeCustomers = Customer::where('active',1)->count();

        $delivery_notifications = DeliveryNotification::where('status',null)->count();
        $deliveriesWithLoans = DeliveryNotification::where('status',1)->count();
        $requests = DeliveryNotification::where('status',null)->count();
        $valueOfAllRequests = DeliveryNotification::where('status',null)->sum('amount');
        $valueOfDeliveriesWithLoans = DeliveryNotification::where('status',1)->sum('amount');

        $transactions = Transaction::count();
        $valueOfAllTransactions = Transaction::whereNotNull('customer_id')->sum('transaction_amount');
        $transactionsWithoutACustomer = Transaction::where('customer_id',NULL)->count();

        $layout = "app"; 
        return view('dashboard/welcome',compact(
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
            'valueOfDeliveriesWithLoans',
            'transactions',
            'requests',
            'valueOfAllRequests',
            'valueOfAllTransactions',
            'transactionsWithoutACustomer',
            'layout',
            'dates',
            'graph_d',
            'graph_r',
            'graph_l',
            'lateLoans',
            'defaulters'
            //'healthyLoans'
        ));
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
        $transaction = Transaction::find($id);
        return view('admin.show', compact('transaction'));
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
