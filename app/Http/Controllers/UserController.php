<?php

namespace App\Http\Controllers;

use App\Models\Network;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function loadregister(){

        return view('register');
    }

    public function  registered(Request $request){
        $request->validate([
            'name'=>'required|string|min:2',
            'email'=>'required|string|email|max:100|unique:users',
            // 'password'=> 'required|min:8|confirmed',
            'password'=> 'min:8|required_with:re_pass|same:re_pass',
            're_pass' => 'required_with:password|same:password|min:8',
            'agree-term'=> 'accepted'
        ]);

        $referralCode = Str::random(10);

        if(isset($request->referral_code)){

            $userData = User::where('referral_code',$request->referral_code)->get();

            if(count($userData) > 0){

                $user_id = User::insertGetId([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=> Hash::make($request->password),
                    'referral_code'=> $referralCode,
                ]);
                Network::insert([

                    'referral_code'=> $request->referral_code,
                    'user_id' => $user_id,
                    'parent_user_id' => $userData[0]['id'],
                ]);

            }else{
                return back()->with('error','please enter a valid referral code !');

            }
        }
        else{
            User::insert([

                'name'=>$request->name,
                'email'=>$request->email,
                'password'=> Hash::make($request->password),
                'referral_code'=> $referralCode,
            ]);
        }

        // return view('register');
        return back()->with('success','Your Registration has been Successful!');
    }


    public function loadlogin(){
        return view('login');
    }
}
