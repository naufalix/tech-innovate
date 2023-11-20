<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{

    public function index(){
        return view('admin.login',[
            "title" => "Admin | Login",
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

        if(Auth::guard('admin')->attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->intended('/admin/');
        }
 
        return back()->with('error','Login failed!');
    }


    public function logout(){
        if(Auth::check()){
            Auth::logout();
        }
        return redirect('/admin/login');
    }
}
