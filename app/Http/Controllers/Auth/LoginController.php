<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Setting;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        parent::__construct();
    }
    //  public function login(Request $request)
    // {
    //     $creds = [
    //         'email' => $request->get('email'),
    //         'password' => $request->get('password')
    //     ];
    //     $rememberMe = $request->has('remember_me');
    //     if (auth()->guard('web')->attempt($creds, $rememberMe)) {
    //         return redirect()->route('home');
    //     }
    //     return redirect()->back()->with('alert-danger', "Email and password don't match");
    // }

    public function logout(Request $request)
    {
        $url = Setting::findByKey('onlineurl');
        if($url){
            $connected = @fsockopen("www.google.com", 80);
            if (!$connected){
                request()->session()->flash('alert-danger', 'You can not Log Out, The computer is not connected to the Internet');
                return back();
            }
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET', route('sync'));
        }
        $this->guard()->logout();
        $request->session()->invalidate();
        return $this->loggedOut($request) ?: redirect('/');
    }
}
