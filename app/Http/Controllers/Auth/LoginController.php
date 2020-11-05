<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Auth;
use App\User;

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

    //use AuthenticatesUsers;

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
        return view('auth.login');
    }

    public function login(Request $req)
    {
        //dd($req->all());
        
        $validator = Validator::make($req->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6'
        ]);

        $credentials = [
            "email" => $req->email,
            "password" => $req->password
        ];

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($req->only('email'));
        } else{
            $user = User::where('email',$req->email)->first();
            if($user){
                if(Hash::check($req->password, $user->password)){
                    if($user->active == 1){
                        if(Auth::guard('web')->attempt($credentials)){
                            return redirect()->route('dashboard');
                            
                        }else{
                            //dd('Wrong credentials or account not active');
                            return back()->with('error', 'Wrong credentials or account not active');
                        }
                    }else{
                        return back()->with('error', 'Wrong credentials or account not active'); 
                    }
                }else{
                    return back()->with('error', 'Wrong credentials');
                }
            }else{
                return back()->with('error', 'No user is registered with that email');
            }
        }
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */

    protected function guard()
    {
        return Auth::guard('web');
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
        $this->guard("web")->logout();

        $request->session()->invalidate();

        return redirect()->route('login');
    }

    public function __construct()
    {
        $this->middleware('guest:web')->except('logout');
    }
}
