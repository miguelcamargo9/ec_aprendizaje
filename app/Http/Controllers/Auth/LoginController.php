<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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
    
    public function authenticated($request){
        $user = Auth::user();
        $menus = HomeController::getMenus($user->profiles_id);
        $request->session()->put('profile', HomeController::getProfile($user->profiles_id)->profile);
        $request->session()->put('menu', $menus);
        $request->session()->put('user', $user);
    }
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
