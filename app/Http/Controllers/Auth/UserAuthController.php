<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAuthController extends Controller
{

    public function index(){
        if(Auth::guard('admin')->check()){ return redirect('/admin/'); }
        return view('dashboard.login',[
            "title" => "TechInnovate | Login",
        ]);
    }

    public function login(Request $request){
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // if(Auth::attempt($credentials)){
        //     $request->session()->regenerate();
        //     return redirect()->intended('dashboard/home');
        // }

        if(Auth::guard('user')->attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/dashboard/');
        }
 
        return back()->with('error','Login failed!');
    }


    public function logout(){
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
        }
        return redirect('/dashboard/login');
    }
}
