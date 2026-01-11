<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Inertia\Inertia;

class NewPasswordController extends Controller
{

    public function create()
    {   
        $otpVerified = session('otp-verified');
        if(!$otpVerified){
            return redirect()->route('home');
        }
        $email = session('email');
        if($email){
            session()->keep(['email']);
        }
        return Inertia::render('Auth/ResetPassword', [
            'email' => $email,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $user=User::where('email',session('email'))->first(); // ဒီနေရာမှာ request ထဲက email ကိုမသုံးတာက user ကသာ password reset form မှာ email ကို တစ်ခြားလူရဲ့ email ပြောင်းထည့်လိုက်ရင် အဲ့ email ရဲ့ password ကို update လုပ်သလိုဖြစ်သွားမှာစိုးလို့
        DB::transaction(function() use($user,$request){
            $user->update([
                'password'=>$request->password
            ]);
            DB::table('password_reset_tokens')->where('email',session('email'))->delete();
        });
        session()->forget(['otp-verified','email']);
        return redirect()->route('login')->with('status','Your password has been reset.');
    }
}
