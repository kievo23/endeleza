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
use Illuminate\Support\Facades\Cache;

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

        // A day, half a day
        $a_day = 60 * 60;
        $half_day = 60 * 60;
        $valueOfLoans = Cache::remember('valueOfLoans',$a_day, function(){
            return LoanAccount::sum('principal_amount');
        });

        $valueOfInterests = Cache::remember('valueOfInterests', $a_day, function(){
            return LoanAccount::sum('interest_charged');
        });
        $valueOfLoanPenalty = Cache::remember('valueOfLoanPenalty',$a_day, function(){
            return LoanAccount::sum('loan_penalty');
        });
        $valueOfLoanPenaltyNotPaid = Cache::remember('valueOfLoanPenaltyNotPaid',$a_day,function(){
            return LoanAccount::where('loan_status',0)->sum('loan_penalty');
        });
        $valueOfOutstandingLoans = Cache::remember('valueOfOutstandingLoans',$a_day, function(){
            return LoanAccount::sum('loan_balance');
        });

        $oneWeek = Cache::remember('oneWeek',$half_day,function(){
            return LoanAccount::leftJoin('customers','customers.id','loan_account.customer_account_id')
                ->whereBetween('loan_account.created_at', [Carbon::now()->subDays(29) ,Carbon::now()->subDays(8) ])
                ->where('customers.interest',6)
                ->sum('loan_account.loan_balance');
        });
        $twoWeeks = Cache::remember('twoWeek',$half_day,function(){
            return LoanAccount::leftJoin('customers','customers.id','loan_account.customer_account_id')
                ->whereBetween('loan_account.created_at', [Carbon::now()->subDays(29) ,Carbon::now()->subDays(15) ])
                ->where('customers.interest',10.5)
                ->sum('loan_account.loan_balance');
        });
        $lateLoans = $oneWeek + $twoWeeks;

        $defaulters = Cache::remember('defaulters',$half_day,function(){
            return LoanAccount::where('created_at', '<', Carbon::now()->subDays(29))
                ->sum('loan_balance') - LoanAccount::where('created_at', '<', Carbon::now()->subDays(29))
                ->sum('loan_penalty');
        });

        $customers = Cache::remember('customers',$half_day,function(){
            return Customer::count();
        });
        $activeCustomers = Cache::remember('activeCustomers',$half_day,function(){
            return Customer::where('active',1)->count();
        });
        $transactions = Cache::remember('transactions',$half_day,function(){
            return Transaction::count();
        });
        $valueOfAllTransactions = Cache::remember('valueOfAllTransactions',$half_day,function(){
            return Transaction::whereNotNull('customer_id')->sum('transaction_amount');
        });

        $layout = "app"; 
        return view('dashboard/welcome',compact(
            'valueOfLoans',
            'valueOfInterests',
            'valueOfLoanPenalty',
            'valueOfOutstandingLoans',
            'customers',
            'activeCustomers',
            'transactions',
            'valueOfAllTransactions',
            'valueOfLoanPenaltyNotPaid',
            'layout',
            'dates',
            'graph_d',
            'graph_r',
            'graph_l',
            'lateLoans',
            'defaulters',
            'oneWeek',
            'twoWeeks'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function report()
    {
        //
        $data = DB::table('loan_account')
            ->select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(principal_amount) as amount_advanced'),
                DB::raw('SUM(loan_amount) + SUM(loan_penalty) as expected_amount'),
                DB::raw('SUM(loan_amount - loan_balance) + SUM(loan_penalty) as amount_paid')
            )
            ->whereYear('created_at', '=', Carbon::now()->year)
            ->orWhereYear('created_at', '=', Carbon::now()->subYear()->year)
            ->groupBy('year', 'month')
            ->get();

        $graph_aa = [];
        $graph_ea = [];
        $graph_ap = [];
        $graph_pl = [];
        $graph_pa = [];
        $graph_op = [];
        $dates = [];
        $countd = 0;
        $countr = 0;
        $countl = 0;

        foreach($data as $key => $d){
            try {
                array_push($graph_aa, $d->amount_advanced);
                array_push($graph_ea, $d->expected_amount);
                array_push($graph_ap, $d->amount_paid);
                array_push($dates, $d->year." ".date("M", strtotime('00-'.$d->month.'-01')));
                array_push($graph_pl,($d->amount_paid - $d->amount_advanced));
                array_push($graph_pa,($d->expected_amount - $d->amount_paid));
                if($d->amount_advanced > $d->amount_paid){
                    array_push($graph_op,($d->amount_advanced - $d->amount_paid));
                }else{
                    array_push($graph_op,0);
                }
            } catch (\Throwable $th) {
                //throw $th;
                //print_r($th);
            }
        }

        return view('dashboard/report',compact(
            'graph_aa',
            'graph_ea',
            'graph_ap',
            'graph_pl',
            'graph_pa',
            'graph_op',
            'dates',
            'data'
        ));
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
