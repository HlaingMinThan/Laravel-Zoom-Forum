<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OtpVerifyController extends Controller
{
    public function verify(Request $request){
        $email = session('email');
        $expire_at = session('expire_at');
        $status = session('status');
        if($email && $expire_at && $status){
            session()->keep(['email','expire_at','status']);
        }
        $record=DB::table('password_reset_tokens')->where('email',session('email'))->first();
        $now = time(); // show current time as second
        $createdAt = strtotime($record->created_at); // $record->created_at က string ဖြစ်လို့ strtotime က စာသားကနေ အချိန်ကို စက္ကန့်အဖြစ်နဲ့ပြောင်းပေး
        if (($now - $createdAt) > 180) {
            return back()->withErrors(['otp' => 'This OTP has expired. Please request a new one.']);
        }
        if (!Hash::check($request['otp'],$record->token)) {
            return back()->withErrors(['otp' => 'The verification code is incorrect.']);
        }
        session(['otp-verified'=>true]);
        return redirect()->route('password.reset')->with('email',session('email'));
    }
}