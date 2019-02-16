<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Providers\Containers;

use App\Providers\Contracts\LoginFacebookContract;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use App\UserFriend;

class LoginFacebookContainer implements LoginFacebookContract {

    public function redirectToProvider() {

        return Socialite::driver('facebook')->redirect();
    }

    public function handleProviderCallback() {
        $users = Socialite::driver('facebook')->user();
        $saveUser = new User;
        $exist = User::where('email', $users->email)->first();
        if (empty($exist)) {
            $saveUser->name = $users->name;
            $saveUser->email = $users->email;

            $saveUser->token = $users->token;

            $saveUser->save();
            return "User Registered";
        }
        $exist->token =  $users->token;
        $exist->save();
        return "User Logged in ";
    }
    
    public function findAll(){
        return User::all() ;
    }
    
    public function findByName($name){
        $user = User::select('name','email')->where('name',$name)->get();
        return $user;
    }
    
    public function sendRequest($request,$user){
        
        $param = $request->all();
        $rules = array(
            'email' => 'required',
          
        );
        $validator = Validator::make($param, $rules);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 400);
        }
        
        $friend = User::where('email',$param['email'])->first();
        if(empty($friend)){
            return "No such user found in application";
        }
        $saveData = new UserFriend;
        
        $check = UserFriend::where('user_id',$friend->id)
                            ->where('friend_by',$user->email )
                            ->where('request' , 1)->first();
        if(!empty($check)){
            return "Freind Request is already being sent";
        }
        
        $saveData->user_id = $friend->id;
        $saveData->friend_by = $user->email;
        $saveData->request = 1;
        $saveData->save();
        
        return "Friend Request sent";
    }
    
    public function friendRequest($user){
        return User::find($user->id)->friend;
    }
}
