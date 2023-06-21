<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
//use App\Http\Controllers\Auth\Request;
use \Illuminate\Http\Request;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password', 'blocked');
    }
    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */


    protected function attemptLogin(Request $request)
    {
        $request->merge(['blocked' => '0']);
        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }


    /* protected function attemptLogin(Request $request)
    {
        return Auth::attempt(['email' => $request->email, 'password' => $request->password, 'blocked' => 0 ]);
    }  */

    
}
