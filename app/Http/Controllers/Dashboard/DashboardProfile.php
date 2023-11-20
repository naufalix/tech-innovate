<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardProfile extends Controller
{
    
    public function index(){
        return view('dashboard.profile',[
            "title" => "Dashboard | Profile",
        ]);
    }

    public function postHandler(Request $request){
        if($request->submit=="profile"){
            $res = $this->update($request);
            return back()->with($res['status'],$res['message']);
        }
        if($request->submit=="update"){
            $res = $this->update($request);
            return redirect('/dev/admin')->with($res['status'],$res['message']);
        }
        if($request->submit=="destroy"){
            $res = $this->destroy($request);
            return redirect('/dev/admin')->with($res['status'],$res['message']);
            // return redirect('/dashboard/user')->with("info","Fitur hapus sementara dinonaktifkan");
        }else{
            return redirect('/dev/admin')->with("info","Submit not found");
        }
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
            'username' => 'required',
            'password' => 'required',
            'status' => 'required',
            'privilege'=>'required',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['privilege'] = implode(",",$validatedData['privilege']);
        //dd($validatedData);

        // Check Username
        if(!Admin::whereUsername($request->username)->first()){
            // Create new user
            Admin::create($validatedData);
            return ['status'=>'success','message'=>'Admin added successfully'];
        }else{
            return ['status'=>'error','message'=>'Username already taken'];
        }
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
            'education' => 'required',
            'experience' => 'required',
            'passion' => 'required',
            'skill' => 'required',
        ]);
        $validatedData['id'] = auth()->user()->id;

        $user = User::find(auth()->user()->id);
        
        //Check if password empty
        if(!$request->password){
            $validatedData['password'] = $user->password;
        }else{
            $validatedData['password'] = Hash::make($request->password);
        }
        
        //Check if the user is found
        if($user){
            // Update user
            $user->update($validatedData);   
            return ['status'=>'success','message'=>'Profile updated successfully']; 
        }else{
            return ['status'=>'error','message'=>'User not found'];
        }
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $admin = Admin::find($request->id);

        //Check if the admin is found
        if($admin){
            Admin::destroy($request->id);    // Delete admin
            return ['status'=>'success','message'=>'Admin deleted successfully'];
        }else{
            return ['status'=>'error','message'=>'Admin not found'];
        }
    }
}
