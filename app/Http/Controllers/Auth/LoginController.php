<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class LoginController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /*
        Login to the system
     */
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            return $this->redirectUserAccordingToRole();
        }

        return back()->with('status','Invalid Credentials');
    }
        
    
    public function index()
    {
        return view('auth.login');
    }

    private function redirectUserAccordingToRole()
    {
        if(auth()->user()->role_id == Role::STUDENT)
        {
            return redirect()->route('student.index');
        }
        if(auth()->user()->role_id == Role::ADMIN)
        {
            return redirect()->route('library.index');
        }
        if(auth()->user()->role_id == Role::STAFF)
        {
            return redirect()->route('staff.index');
        } 
    }

}
