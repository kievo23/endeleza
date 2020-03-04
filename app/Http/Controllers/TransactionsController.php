<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Transaction;

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
            $transactions = Transaction::whereBetween('created_at', [$request->start_date, $request->end_date])->get();
        } else {
            $transactions = Transaction::all();
        }
        //dd($transactions);
        //$deliveriesWithLoans = Transaction::where('status',1)->count();
        $valueOfAllTransactions = Transaction::sum('transaction_amount');
        $transactionsWithoutACustomer = Transaction::where('customer_id',NULL)->count();
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
