<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Providers\Contracts\LoginFacebookContract;
use Illuminate\Http\Request;
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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    
    public function redirectToProvider(LoginFacebookContract $loginFacebook)
    {
//        return Socialite::driver('facebook')->redirect();
        
       return $loginFacebook->redirectToProvider();
        
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(LoginFacebookContract $loginFacebook)
    {
        return $loginFacebook->handleProviderCallback();
    }
    
    public function findAll(LoginFacebookContract $loginFacebook)
    {
        return $loginFacebook->findAll();
    }
    
    public function findByName(LoginFacebookContract $loginFacebook, Request $request,$name){
        
        $token = $request->header('Authorization');
        $user = $this->getHeader($token);
        if(empty($user)){
            return 'Please login Token is Expired or Invaild';
        }
        return $loginFacebook->findByName($name);
    }
    
    public function sendRequest(LoginFacebookContract $loginFacebook, Request $request){
        $token = $request->header('Authorization');
        $user = $this->getHeader($token);
        if(empty($user)){
            return 'Please login Token is Expired or Invaild';
        }
        
        return $loginFacebook->sendRequest($request,$user);
    }
    
    public function friendRequest(LoginFacebookContract $loginFacebook,Request $request){
        $token = $request->header('Authorization');
        $user = $this->getHeader($token);
        if(empty($user)){
            return 'Please login Token is Expired';
        }
        return $loginFacebook->friendRequest($user);
    }
    
    
    
    public function getHeader($token){
        
        $user = User::where('token',$token)->first();
           
        return $user;
    }
}
