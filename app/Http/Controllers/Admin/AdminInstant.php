<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Instant;
use App\Models\Job;
use Illuminate\Http\Request;

class AdminInstant extends Controller
{

    public function index(){
        return view('admin.instant',[
            "title" => "Admin | Riwayat Rekomendasi",
            "instants" => Instant::all(),
            "jobs" => Job::all(),
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

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $instant = Instant::find($request->id);

        //Check if the instant is found
        if($instant){
            Instant::destroy($request->id);    // Delete job
            return ['status'=>'success','message'=>'Rekomendasi berhasil dihapus'];
        }else{
            return ['status'=>'error','message'=>'Rekomendasi tidak ditemukan'];
        }
    }
}
