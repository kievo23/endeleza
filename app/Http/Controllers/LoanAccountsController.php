<?php

namespace App\Http\Controllers;

use App\Customer;
use Carbon\Carbon;
use App\LoanAccount;
use App\Transaction;
use App\LoanAccountMC;
use Illuminate\Http\Request;
use App\DeliveryNotification;
use Illuminate\Support\Collection;

class LoanAccountsController extends Controller
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
    
    public function index(Request $request)
    {
        //$loan_accounts = LoanAccount::paginate(10);
        
        if (! empty($request->start_date)) {
            $loan_accounts = LoanAccount::whereBetween('created_at', [$request->start_date, $request->end_date])
                ->orderBy('id','desc')->get();
        } else {
            $loan_accounts = LoanAccount::orderBy('id','desc')->get();
        }
        $clearedLoans = LoanAccount::where('loan_status',1)->count();
        $valueOfLoans = LoanAccount::sum('loan_amount');
        $valueOfTransactions = LoanAccount::sum('trn_charge');
        $valueOfInterests = LoanAccount::sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::sum('loan_balance');
        $title = "All Loans";
        
        return view('loan_accounts/index',
            compact('title', 'loan_accounts', 'clearedLoans','valueOfLoans','valueOfOutstandingLoans','valueOfTransactions','valueOfLoanPenalty','valueOfOutstandingLoans','valueOfInterests')
        );
    }

    public function customerLoans($customerId){
        $customer = Customer::findOrFail($customerId);
        $loan_accounts = LoanAccount::where('customer_account_id',$customerId)->get();
        $clearedLoans = LoanAccount::where('customer_account_id',$customerId)->where('loan_status',1)->count();
        $valueOfLoans = LoanAccount::where('customer_account_id',$customerId)->sum('loan_amount');
        $valueOfTransactions = LoanAccount::where('customer_account_id',$customerId)->sum('trn_charge');
        $valueOfInterests = LoanAccount::where('customer_account_id',$customerId)->sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::where('customer_account_id',$customerId)->sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::where('customer_account_id',$customerId)->sum('loan_balance');
        $title = "Loans from ".$customer->person->first_name." ".$customer->person->other_names." (Phone:".$customer->customer_account_msisdn.")";
        //dd("hjsgdhjf");

        $transactions = Transaction::where('customer_id',$customer->id)->get();
        $delivery_notifications = DeliveryNotification::where('customer_id',$customer->id)->get();

        

        return view('loan_accounts/index', 
            compact('title','transactions','delivery_notifications','loan_accounts','clearedLoans','valueOfLoans','valueOfOutstandingLoans','valueOfTransactions','valueOfLoanPenalty','valueOfOutstandingLoans','valueOfInterests')
        );
    }

    public function fullypaid()
    {
        $loan_accounts = LoanAccount::where('loan_status',1)->get();
        $clearedLoans = LoanAccount::where('loan_status',1)->count();
        $valueOfLoans = LoanAccount::where('loan_status',1)->sum('loan_amount');
        $valueOfTransactions = LoanAccount::where('loan_status',1)->sum('trn_charge');
        $valueOfInterests = LoanAccount::where('loan_status',1)->sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::where('loan_status',1)->sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::where('loan_status',1)->sum('loan_balance');
        $title = "Fully Paid Loans";
        //dd($loan_accounts);
        
        return view('loan_accounts/index', 
            compact('title','loan_accounts','clearedLoans','valueOfLoans','valueOfOutstandingLoans','valueOfTransactions','valueOfLoanPenalty','valueOfOutstandingLoans','valueOfInterests')
        );
    }

    public function pending()
    {
        $loan_accounts = LoanAccount::where('loan_status',0)->get();
        $clearedLoans = LoanAccount::where('loan_status',0)->count();
        $valueOfLoans = LoanAccount::where('loan_status',0)->sum('loan_amount');
        $valueOfTransactions = LoanAccount::where('loan_status',0)->sum('trn_charge');
        $valueOfInterests = LoanAccount::where('loan_status',0)->sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::where('loan_status',0)->sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::where('loan_status',0)->sum('loan_balance');
        $title = "Actively Pending Loans";
        //dd($loan_accounts);
        
        return view('loan_accounts/index', 
            compact('title','loan_accounts','clearedLoans','valueOfLoans','valueOfOutstandingLoans','valueOfTransactions','valueOfLoanPenalty','valueOfOutstandingLoans','valueOfInterests')
        );
    }

    public function yesterday(){
        $loan_accounts = LoanAccount::whereDate('created_at', '=', Carbon::now()->subDays(1)->toDateString())->get();
        //dd($loan_accounts);
        $clearedLoans = LoanAccount::whereDate('created_at', '=', Carbon::now()->subDays(1)->toDateString())->count();
        $valueOfLoans = LoanAccount::whereDate('created_at', '=', Carbon::now()->subDays(1)->toDateString())->sum('loan_amount');
        $valueOfTransactions = LoanAccount::whereDate('created_at', '=', Carbon::now()->subDays(1)->toDateString())->sum('trn_charge');
        $valueOfInterests = LoanAccount::whereDate('created_at', '=', Carbon::now()->subDays(1)->toDateString())->sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::whereDate('created_at', '=', Carbon::now()->subDays(1)->toDateString())->sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::whereDate('created_at', '=', Carbon::now()->subDays(1)->toDateString())->sum('loan_balance');
        $title = "Yesterday Loans";
        return view('loan_accounts/index', 
            compact('title','loan_accounts','clearedLoans','valueOfLoans','valueOfOutstandingLoans','valueOfTransactions','valueOfLoanPenalty','valueOfOutstandingLoans','valueOfInterests')
        );
    }

    public function today(){
        $loan_accounts = LoanAccount::whereDate('created_at', Carbon::now()->toDateString())->get();
        
        $clearedLoans = LoanAccount::whereDate('created_at', '=', Carbon::now()->toDateString())->count();
        $valueOfLoans = LoanAccount::whereDate('created_at', '=', Carbon::now()->toDateString())->sum('loan_amount');
        $valueOfTransactions = LoanAccount::whereDate('created_at', '=', Carbon::now()->toDateString())->sum('trn_charge');
        $valueOfInterests = LoanAccount::whereDate('created_at', '=', Carbon::now()->toDateString())->sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::whereDate('created_at', '=', Carbon::now()->toDateString())->sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::whereDate('created_at', '=', Carbon::now()->toDateString())->sum('loan_balance');
        $title = "Today Loans";

        return view('loan_accounts/index', 
            compact('title','loan_accounts','clearedLoans','valueOfLoans','valueOfOutstandingLoans','valueOfTransactions','valueOfLoanPenalty','valueOfOutstandingLoans','valueOfInterests')
        );
    }

    public function aboveThirty(){
        $loan_accounts = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays(30)->toDateTimeString())->where('loan_status',0)->get();
        $clearedLoans = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays(30)->toDateTimeString())->where('loan_status',0)->count();
        $valueOfLoans = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays(30)->toDateTimeString())->where('loan_status',0)->sum('loan_amount');
        $valueOfTransactions = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays(30)->toDateTimeString())->where('loan_status',0)->sum('trn_charge');
        $valueOfInterests = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays(30)->toDateTimeString())->where('loan_status',0)->sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays(30)->toDateTimeString())->where('loan_status',0)->sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays(30)->toDateTimeString())->where('loan_status',0)->sum('loan_balance');
        $title = "Loans Above 30 days";
        return view('loan_accounts/index', 
            compact('title','loan_accounts','clearedLoans','valueOfLoans','valueOfOutstandingLoans','valueOfTransactions','valueOfLoanPenalty','valueOfOutstandingLoans','valueOfInterests')
        );
    }

    public function pendingBelow($days){
        //dd(Carbon::now()->subDays($days)->toDateTimeString());
        $offset = 0;
        if($days == "6"){
            $offset = 3; 
        }else if($days == 10){
            $offset = 6;
        }else if($days == 15){
            $offset = 10;
        }else if($days == 30){
            $offset = 15;
        }
        $data = self::formatLoans($days,$offset);


        $loan_accounts = $data['loans'];
        $clearedLoans = $data['cleared'];
        $valueOfLoans = $data['valueOfLoans'];
        $valueOfTransactions = $data['valueOfTransactions'];
        $valueOfInterests = $data['valueOfInterests'];
        $valueOfLoanPenalty = $data['valueOfLoanPenalty'];
        $valueOfOutstandingLoans = $data['valueOfOutstandingLoans'];

        $title = "Pending loans ".$days;
        
        return view('loan_accounts/index', 
            compact('title','loan_accounts','clearedLoans','valueOfLoans','valueOfOutstandingLoans','valueOfTransactions','valueOfLoanPenalty','valueOfOutstandingLoans','valueOfInterests')
        );
    }

    private static function formatLoans($days,$offset){
        $loan_accounts = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays($offset)->toDateString())
            ->whereDate('created_at', '>', Carbon::now()->subDays($days)->toDateString())
            ->where('loan_status',0)
            ->get();
        $clearedLoans = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays($offset)->toDateString())
            ->whereDate('created_at', '>', Carbon::now()->subDays($days)->toDateString())
            ->where('loan_status',1)->count();
        $valueOfLoans = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays($offset)->toDateString())
            ->whereDate('created_at', '>', Carbon::now()->subDays($days)->toDateString())
            ->where('loan_status',0)
            ->sum('loan_principal');
        $valueOfTransactions = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays($offset)->toDateString())
            ->whereDate('created_at', '>', Carbon::now()->subDays($days)->toDateString())
            ->where('loan_status',0)
            ->sum('trn_charge');
        $valueOfInterests = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays($offset)->toDateString())
            ->whereDate('created_at', '>', Carbon::now()->subDays($days)->toDateString())
            ->where('loan_status',0)
            ->sum('interest_charged');
        $valueOfLoanPenalty = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays($offset)->toDateString())
            ->whereDate('created_at', '>', Carbon::now()->subDays($days)->toDateString())
            ->where('loan_status',0)
            ->sum('loan_penalty');
        $valueOfOutstandingLoans = LoanAccount::whereDate('created_at', '<=', Carbon::now()->subDays($offset)->toDateString())
            ->whereDate('created_at', '>', Carbon::now()->subDays($days)->toDateString())
            ->where('loan_status',0)
            ->sum('loan_balance');
        return [
            "loans" => $loan_accounts,
            "cleared" => $clearedLoans,
            "valueOfLoans" => $valueOfLoans,
            "valueOfTransactions" => $valueOfTransactions,
            "valueOfInterests" => $valueOfInterests,
            "valueOfLoanPenalty" => $valueOfLoanPenalty,
            "valueOfOutstandingLoans" => $valueOfOutstandingLoans
        ];
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
    public function destroy($loanId)
    {
        $rst = LoanAccountMC::destroy($loanId);
        if($rst){
            return redirect()->route('loan_accounts.index')
                        ->with('success','You have successfully implemented the new changes');
        }else{
            return redirect()->route('loan_accounts.index')
                        ->with('error','Record not found');
        }
    }
}
