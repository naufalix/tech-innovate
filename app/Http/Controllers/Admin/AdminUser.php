<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUser extends Controller
{

    public function index(){
        return view('admin.user',[
            "title" => "Admin | User Settings",
            "users" => User::all(),
        ]);
    }

    public function postHandler(Request $request){
        if($request->submit=="store"){
            $res = $this->store($request);
            return back()->with($res['status'],$res['message']);
        }
        if($request->submit=="update"){
            $res = $this->update($request);
            return back()->with($res['status'],$res['message']);
        }
        if($request->submit=="destroy"){
            $res = $this->destroy($request);
            return back()->with($res['status'],$res['message']);
            // return redirect('/dashboard/user')->with("info","Fitur hapus sementara dinonaktifkan");
        }else{
            return back()->with("info","Submit not found");
        }
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name'=>'required',
            'username' => 'required',
            'password' => 'required',
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);
        $validatedData['education'] = $request['education'];
        $validatedData['experience'] = $request['experience'];
        $validatedData['passion'] = $request['passion'];
        $validatedData['skill'] = $request['skill'];

        // Check Username
        if(!User::whereUsername($request->username)->first()){
            // Create new user
            User::create($validatedData);
            return ['status'=>'success','message'=>'User berhasil ditambahkan'];
        }else{
            return ['status'=>'error','message'=>'Username sudah terpakai'];
        }
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'username' => 'required',
        ]);
        $validatedData['education'] = $request['education'];
        $validatedData['experience'] = $request['experience'];
        $validatedData['passion'] = $request['passion'];
        $validatedData['skill'] = $request['skill'];

        $user = User::find($request->id);
        $oldUsername = $user->username;
        $newUsername = $request->username;
        
        //Check if password empty
        if(!$request->password){
            $validatedData['password'] = $user->password;
        }else{
            $validatedData['password'] = Hash::make($request->password);
        }
        
        //Check if the User is found
        if($user){
            //Check username
            if($newUsername!=$oldUsername){
                if(User::whereUsername($request->username)->first()){
                    return ['status'=>'error','message'=>'Username sudah terpakai'];
                }
            }
            // Update User
            $user->update($validatedData);   
            return ['status'=>'success','message'=>'User berhasil diupdate']; 
        }else{
            return ['status'=>'error','message'=>'User tidak ditemukan'];
        }
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $user = User::find($request->id);

        //Check if the User is found
        if($user){
            User::destroy($request->id);    // Delete User
            return ['status'=>'success','message'=>'User berhasil dihapus'];
        }else{
            return ['status'=>'error','message'=>'User tidak ditemukan'];
        }
    }
}
