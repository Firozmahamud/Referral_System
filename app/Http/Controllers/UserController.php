<?php

namespace App\Http\Controllers;

use Share;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Network;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

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
        $token = Str::random(50);

        if(isset($request->referral_code)){

            $userData = User::where('referral_code',$request->referral_code)->get();

            if(count($userData) > 0){

                $user_id = User::insertGetId([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=> Hash::make($request->password),
                    'referral_code'=> $referralCode,
                    'remember_token'=> $token,
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
                'remember_token'=> $token,

            ]);
        }
        // return view('register');

        $domain = URL::to('/');
        $url = $domain.'/referral-register?ref='.$referralCode;

        $data['url']=$url;
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['password']=$request->password;
        $data['title']='Registered';

        Mail::send('emails.registerMail',['data'=> $data],function($message) use($data){

            $message->to($data['email'])->subject($data['title']);

        });


        //verification mail send

        $url = $domain.'/email-verification/'.$token;

        $data['url']=$url;
        $data['name']=$request->name;
        $data['email']=$request->email;
        $data['title']='verification email';


        Mail::send('emails.verifyMail',['data'=> $data],function($message) use($data){

            $message->to($data['email'])->subject($data['title']);

        });


        return back()->with('success','Your Registration has been Successful & please verify your mail !');
    }


    public function loadreferralregister(Request $request){
        // return view('404');
        if(isset($request->ref)){

            $referral = $request->ref;
            $userData = User::where('referral_code',$referral)->get();
            if(count($userData) > 0){
                return view('referralRegister',compact('referral'));
            }
            else{
                return view('404');
            }
        }
        else{
            return redirect('/');
        }
    }


    public function emailverification($token){

        $userData = User::where('remember_token',$token)->get();

        if(count($userData) > 0){

            if($userData[0]['is_verified'] == 1){
              return view('emails.verified',['message'=>'your mail is already verified!']);
            }

            User::where('id',$userData[0]['id'])->update([

                'is_verified' => 1,
                'email_verified_at'=> date('Y-m-d H:i:s'),
            ]);
            return view('emails.verified',['message'=>'your'.$userData[0]['email'].'mail verified Successfully!']);

        }

        else{

        return view('emails.verified',['message'=>'404 page not found !']);

        }
    }

    public function loadlogin(){
        return view('login');
    }


    public function userlogin(Request $request){
        // return view('login');
        $request->validate([

            'email'=>'required|string|email',
            'password'=> 'required',

        ]);

        $userData = User::where('email',$request->email)->first();

        if(!empty($userData)){
            if($userData->is_verified == 0){
                return back()->with('error','please verify your email !');
            }
        }

        $userCredential = $request->only('email','password');
        if(Auth::attempt($userCredential)){
            return redirect('/dashboard');
        }
        else{
            return back()->with('error','email or password is incorrect');
        }

    }

    public function loaddashboard(){

        $networkCount = Network::where('parent_user_id',Auth::user()->id)->orWhere('user_id',Auth::user()->id)->count();
        // return ('welcome to the Dashboard');

        $networkData = Network::with('user')->where('parent_user_id',Auth::user()->id)->get();

        $shareComponent = \Share::page(
            URL::to('/').'/referral-register?ref='.Auth::user()->referral_code,
            'Share and Earn Points by Referral Link',
        )
        ->facebook()
        ->twitter()
        ->linkedin()
        ->telegram()
        ->whatsapp()
        ->reddit();



        return view('dashboard.home',compact('networkCount','networkData',"shareComponent"));
    }

    public function logout(Request $request){
        // $request->session()->flash();
        // Auth::logout();
        // // return ('welcome to the Dashboard');
        // return redirect('/');
        Session::flush();

        Auth::logout();

        return redirect('login');
    }


    public function loadreferralTrack(){
        $networkCount = Network::where('parent_user_id',Auth::user()->id)->orWhere('user_id',Auth::user()->id)->count();

        $dateLabels =[];
        $dateData =[];

        for($i = 30; $i >=0; $i--){
            $dateLabels[] = Carbon::now()->subDays($i)->format('d-m-Y');

            // $dateLabels[] = $date;
            $dateData[] = Network::whereDate('created_at',Carbon::now()->subDays($i)->format('Y-m-d'))
            ->where('parent_user_id',Auth::user()->id)->count();

        }

        $dateLabels = json_encode($dateLabels);
        $dateData = json_encode($dateData);

        // echo"<pre>";
        // print_r($dateLabels);
        // die;

        return view('dashboard.referralTrack',compact('networkCount','dateLabels','dateData'));
    }

    public function deleteAccount(Request $request){

        try{

        User::where('id',Auth::user()->id)->delete();
        $request->session()->flush();
        Auth::logout();
        return response()->json(['success'=>true]);

        }catch(\Exception $e){
            return response()->json(['success'=>false,'msg'=>$e->getMessage()]);

        }
    }

}
