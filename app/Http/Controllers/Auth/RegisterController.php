<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;


class RegisterController extends Controller
{
    private $status;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)],
            'email' => 'required|email|regex:/^[A-Za-z0-9\.]*@(neu)[.](edu)[.](ph)$/|unique:users'
        ]);

        $user = User::firstOrCreate([
            'last_name' => $request->lastname,
            'first_name' => $request->firstname,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'email' => $request->email
        ]);
 
        if(!$user->hasVerifiedEmail())
        {
            event(new Registered($user));
            Auth::login($user);
            return redirect()->route('verification.notice');
        }

        return redirect()->route('login');
    }

    public function index()
    {
        return view('auth.register');
    }

    public function verify(Request $request)
    {
        if($request->user()->hasVerifiedEmail())
        {
            return back();
        }
        return view('auth.verify-email');
    }

    public function verificationNotification(Request $request)
    { 
        $request->user()->sendEmailVerificationNotification();  
        return back()->with('message', 'Verification link sent!');     
    }
    //TEST
    public function resendEmailVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $user = User::where('email', $request->email)->firstOr(function(){
            return back()->with('error', 'Email does not exist!');
        });

        if(session('error'))
        {
            return back()->with('error', session('error'));
        }
        
        if(!$user->hasVerifiedEmail())
        {
            $user->sendEmailVerificationNotification();
        }else
        {
            return back()->with('error', 'Email already verified');
        }
        // $request->email->sendEmailVerificationNotification();
        return back()->with('success', 'Verification link sent!');
    }

    public function emailVerification(EmailVerificationRequest $request)
    {
        $request->fulfill();
        return redirect()->route('student.index');
    }
}
