<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Agent;
use App\Person;
use App\SMS;
use App\Bcrypt;
use App\Customer;

class AgentsController extends Controller
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

    public function dashboard()
    {
        dd("Agent is logged in");
    }
    
    public function index()
    {
        $agents = Agent::paginate(10);

        return view('agents/index', compact('agents'));
    }

    public function listOfCustomers($agentId){
        $customers = Customer::where('agent_id',$agentId)->get();
        $activeCustomers = Customer::where('agent_id',$agentId)
            ->where('active',1)
            ->count();
        $agent = Agent::findOrFail($agentId);

        //dd($customers);
        $title = "List of Customers from ".$agent->person->full_name;

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
        return view('agents/create', compact('persons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $code = rand(1000, 9999);
        $phone = "+254".substr(trim($request->phone), -9);
        // use a stronger salt
        $salt   = Bcrypt::salt(10); // 2^24 iterations
        $hashed = Bcrypt::hash($code, $salt);
        //dd($hashed);

        $agent = Agent::create([
            'person_id' => $request->person,
            'agent_msisdn' => $phone,
            'pin_reset' => 1,
            'pin' => $hashed,
            'salt_key' => $salt
        ]);

        //dd($agent);

        $rst = SMS::sendsms($phone, "You have been registered as an M-Weza agent. This is a one time password ". $code);
        return redirect()->route('agents.index')
                        ->with('success','Person created successfully.');
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
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $persons = Person::all();
        $agent = Agent::findOrFail($id);
        return view('agents/edit', compact('persons','agent'));
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
        $customer = Agent::findOrFail($id);
        $customer->update([
            "agent_msisdn" => $req->phone
        ]);
  
        return redirect()->route('agents.index')
                        ->with('success','agent updated successfully');
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
