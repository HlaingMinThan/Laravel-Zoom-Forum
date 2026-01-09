<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    public function create(): Response
    {
        $email = session('email');
        if($email){
            session()->keep(['email']);
        }
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status'),
            'email' => $email
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user=User::where('email',$request['email'])->first();
        $status = $user ? 'passwords.otp-sent' : 'passwords.user';
        if(!$user){
            throw ValidationException::withMessages([
                'email' => [trans($status)], // trans and __ is same logic, different syntx (search inside lang/en/passwords.php/otp-sent)
            ]);
        }
        $user->generateOtpAndSend();
        return back()->with('status', __($status))
                    ->with('email',$request->email);
    }
    
    public function change(){
        session()->forget('email');
        return back();
    }
}
