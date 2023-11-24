<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAdmin extends Controller
{

    public function index(){
        return view('admin.admin',[
            "title" => "Admin | Admin Settings",
            "admins" => Admin::all(),
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
            'password' => 'required'
        ]);
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Check Username
        if(!Admin::whereUsername($request->username)->first()){
            // Create new user
            Admin::create($validatedData);
            return ['status'=>'success','message'=>'Admin berhasil ditambahkan'];
        }else{
            return ['status'=>'error','message'=>'Username telah terpakai'];
        }
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'username' => 'required',
        ]);
        
        $admin = Admin::find($request->id);
        $oldUsername = $admin->username;
        $newUsername = $request->username;
        
        //Check if password empty
        if(!$request->password){
            $validatedData['password'] = $admin->password;
        }else{
            $validatedData['password'] = Hash::make($request->password);
        }
        
        //Check if the admin is found
        if($admin){
            //Check username
            if($newUsername!=$oldUsername){
                if(Admin::whereUsername($request->username)->first()){
                    return ['status'=>'error','message'=>'Username telah terpakai'];
                }
            }
            // Update admin
            $admin->update($validatedData);   
            return ['status'=>'success','message'=>'Admin berhasil diupdate']; 
        }else{
            return ['status'=>'error','message'=>'Admin tidak ditemukan'];
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
            return ['status'=>'success','message'=>'Admin berhasil dihapus'];
        }else{
            return ['status'=>'error','message'=>'Admin tidak ditemukan'];
        }
    }
}
