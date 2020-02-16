<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerType;

class CustomerTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_types = CustomerType::paginate(10);

        return view('customer_types/index', compact('customer_types'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customer_types/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        CustomerType::create([
            'customer_account_type' => $request->customer_type,
            'description' => $request->description,
            'minimum_account_balance' => $request->description
        ]);

        return redirect()->route('customer_types.index')
                        ->with('success', 'Customer profile created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(CustomerType $customertype)
    {
        return view('customer_types.show', compact('customertype'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerType $customertype)
    {
        dd($customertype);
        
        return view('customer_types.edit', compact('customertype'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerType $customertype)
    {
        $request->validate([
            'CUSTOMER_TYPE' => 'nullable',
            'DESCRIPTION'=> 'nullable'
        ]);
  
        $customertype->update($request->all());
  
        return redirect()->route('customer_types.index')
                        ->with('success','Customer profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerType $customertype)
    {
        $customertype->delete();

        // dd($customertype->delete());
  
        return redirect()->route('customer_types.index')
                        ->with('success','Customer profile deleted successfully');
    }
}