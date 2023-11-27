<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Survey;
use App\Models\Job;
use Illuminate\Http\Request;

class AdminSurvey extends Controller
{

    public function index(){
        return view('admin.survey',[
            "title" => "Admin | Riwayat Asesmen",
            "surveys" => Survey::all(),
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

        $survey = Survey::find($request->id);

        //Check if the survey is found
        if($survey){
            Survey::destroy($request->id);    // Delete survey
            return ['status'=>'success','message'=>'Asesmen berhasil dihapus'];
        }else{
            return ['status'=>'error','message'=>'Asesmen tidak ditemukan'];
        }
    }
}
