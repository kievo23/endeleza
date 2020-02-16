<?php

namespace App\Http\Controllers\Agent\Auth;
//App\Http\Controllers\Agent\Auth\LoginController

use App\Http\Controllers\Controller;
//use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';


    /**
     * Show the application's login form.
     * 
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('agents.login');
    }

    public function login(Request $req)
    {
        //dd($req->all());
        
        $this->validate($req, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $credentials = [
            "email" => $req->email,
            "password" => $req->password,
            "active" => 1
        ];
        //$credentials = $req->only('email', 'password');
        if(Auth::guard('agents')->attempt($credentials)){
            //dd("Authenticated");
            return redirect()->route('agent.dashboard');
        }else{
            //dd("Something Happened");
            return redirect()->back()->withInput($req->only('email'));
        }        
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */

    protected function guard()
    {
        return Auth::guard('agents');
    }

    //use AuthenticatesUsers;

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard("agents")->logout();

        $request->session()->invalidate();

        return redirect()->route('agents.login');
    }
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
