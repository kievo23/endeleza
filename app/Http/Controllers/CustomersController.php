<?php

namespace App\Http\Controllers;

use App\SMS;
use App\Person;
use App\Customer;
use App\CustomerMC;
use App\Agent;
use App\Bcrypt;
use Illuminate\Http\Request;
use App\LoanAccount;
use App\LoanAccountMC;
use App\Transaction;
use App\DeliveryNotification;
use DB;

class CustomersController extends Controller
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
        //
        $customers = Customer::all();
        $activeCustomers = Customer::where('active',1)->count();
        $title = "List of customers";

        return view('customers/index', compact('customers','activeCustomers','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $persons = Person::all();
        $agents = Agent::all();

        return view('customers/create', compact('persons', 'agents'));
    }

    public function searchresults(Request $req)
    {
        //trim, get the last 9 digits, append "+254"
        $number = "+254" . substr(trim($req->search), -9);
        
        $id = $req->search;

        // dd($number);
        
        // dd($req->all());

        // $posts = Person::where('PRIMARY_MSISDN', $number)->paginate(5);

        $identity = Person::where('id_number', $id)->first();

        // dd($identity);       ->with('success','Person created successfully.'

        return view('customers/searchresults', compact('identity'));
    }

    public function searchcreate(Request $request)
    {
        $search = $request->get('search');

        return view('customers/searchcreate');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd(($request));     

        $code = rand(1000, 9999);
        $phone = "+254".substr(trim($request->phone), -9);
        // use a stronger salt
        $salt   = Bcrypt::salt(10); // 2^24 iterations
        $hashed = Bcrypt::hash($code, $salt);
        //dd($hashed);

        $customer = CustomerMC::create([
            'person_id' => intval($request->person),
            'agent_id' => intval($request->agent),
            'customer_account_msisdn' => $phone,
            'pin_reset' => 1,
            'interest' => $request->interest,
            'pin' => $hashed,
            'salt_key' => $salt
        ]);

        //dd($agent);

        $rst = SMS::sendsms($phone, "You have been registered as an M-Weza customer. This is a one time password ". $code);
        
        return redirect()->route('customers.index')
                        ->with('success','Customer created successfully.');
    }

    public function find(Request $req){
        //return redirect('home/dashboard');
        //dd($req->all());
        return redirect()->route('statement', ['phone' => $req->input('phone')]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customerStatement($phone)
    {
        //
        $phone = "+254" . substr(trim($phone), -9);
        $customer = Customer::where('customer_account_msisdn',$phone)->first();
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
            //dd($results);
            //$title = "Customer Statement"; 
            $title = "My customer: ".$customer->person->full_name. " (".$customer->customer_account_msisdn.")";
            $loans = LoanAccount::where('customer_account_id',$customer->id)->get();
            $transactions = Transaction::where('customer_id',$customer->id)->get();
            $delivery_notifications = DeliveryNotification::where('customer_id',$customer->id)->get();           
            return view('customers.statement', compact('results','title','customer','loans','transactions','delivery_notifications'));
        }else{
            return redirect()->route('dashboard')
            ->with('warning','Customer Not Found');
        }
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
        $customer = CustomerMC::findOrFail($id);
        $agents = Agent::all();

        return view('customers/edit',compact('customer','agents'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        //
        $customer = CustomerMC::findOrFail($id);
        $customer->update([
            "blocked" => $req->blocked,
            "active" => $req->active,
            "rollover" => $req->rollover,
            "agent_id" => $req->agent,
            'interest' => $req->interest,
            "account_limit" => $req->account_limit.".00"
        ]);
  
        return redirect()->route('customers.index')
                        ->with('success','Customer updated successfully');
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

    public function sendsms(){

        $sms = SMS::sendsms();

        print_r($sms);

    }
}
