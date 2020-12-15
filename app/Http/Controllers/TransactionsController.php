<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;
use App\Customer;
use App\LoanAccount;
use Illuminate\Support\Facades\URL;

class TransactionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //$transactions = Transaction::paginate(10);
        if (! empty($request->start_date)) {
            $transactions = Transaction::whereNotNull('customer_id')->whereBetween('created_at', [$request->start_date, $request->end_date])->get();
            $valueOfAllTransactions = Transaction::whereBetween('created_at', [$request->start_date, $request->end_date])->sum('transaction_amount');
            $transactionsWithoutACustomer = Transaction::whereBetween('created_at', [$request->start_date, $request->end_date])->where('customer_id',NULL)->count();
        } else {
            $transactions = Transaction::whereNotNull('customer_id')->get();
            $valueOfAllTransactions = Transaction::sum('transaction_amount');
            $transactionsWithoutACustomer = Transaction::where('customer_id',NULL)->count();
        }
        //dd($transactions);
        //$deliveriesWithLoans = Transaction::where('status',1)->count();
        
        return view('transactions/index', compact('transactions','valueOfAllTransactions','transactionsWithoutACustomer'));
    }

    public function suspense()
    {
        //$transactions = Transaction::paginate(10);
        $transactions = Transaction::whereNull('customer_id')->get();
        //dd($transactions);
        //$deliveriesWithLoans = Transaction::where('status',1)->count();
        $valueOfAllTransactions = Transaction::whereNull('customer_id')->sum('transaction_amount');
        $transactionsWithoutACustomer = Transaction::whereNull('customer_id')->where('customer_id',NULL)->count();
        return view('transactions/index', compact('transactions','valueOfAllTransactions','transactionsWithoutACustomer'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function reconcile($transId)
    {
        //Test
        //LoanAccount::offsetUser("0710345130","20","wewerersdf","","desc","0710345130",$PaidByNames="Ghost");
        
        //real
        $title = "Reconcile This Orphan Transaction";
        $customers = Customer::all();
        $transaction = Transaction::find($transId);
        return view('transactions/reconcile', compact('title','customers','transaction'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $customer = Customer::find($req->customer);
        if($customer){
            $transaction = Transaction::find($req->transId);
            //dd($transaction);
            if($transaction->customer_id){
                //Transaction Already assigned to a customer.
                return redirect('transactions')
                    ->with('error','Ooops, this transaction can not be offset as its already assigned');
            }else{
                $msisdn = $customer->customer_account_msisdn;
                $amt = $transaction->transaction_amount;
                $mpesaCode = $transaction->transaction_reference;
                $timestamp = $transaction->transaction_time;
                $payment_desc = "RECONCILIATION";
                $PaidByNames = $transaction->payer_names;

                //offset user
                LoanAccount::offsetUser($msisdn,$amt,$mpesaCode,$timestamp,$payment_desc,$msisdn,$PaidByNames);

                $transaction->customer_id = $req->customer;
                $transaction->save();
                return redirect('transactions')
                ->with('status','Great, customer has been offset successfully!');
            }
        }else{
            //Customer doesn't exist
            return redirect('transactions')
                ->with('error','Ooops, Customer does not exist');
        }
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
