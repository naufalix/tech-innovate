<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class AdminQuestion extends Controller
{

    public function index(){
        return view('admin.question',[
            "title" => "Admin | Question",
            "questions" => Question::all(),
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
            'name' => 'required',
            'tags' => 'required',
        ]);
        
        // Create new job
        Job::create($validatedData);
        return ['status'=>'success','message'=>'Job added successfully'];
        
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'id'=>'required|numeric',
            'name'=>'required',
            'tags' => 'required',
        ]);

        $job = Job::find($request->id);
        
        //Check if the job is found
        if($job){
            // Update job
            $job->update($validatedData);   
            return ['status'=>'success','message'=>'Job updated successfully']; 
        }else{
            return ['status'=>'error','message'=>'Job not found'];
        }
    }

    public function destroy(Request $request){
        
        $validatedData = $request->validate([
            'id'=>'required|numeric',
        ]);

        $job = Job::find($request->id);

        //Check if the job is found
        if($job){
            Job::destroy($request->id);    // Delete job
            return ['status'=>'success','message'=>'Job deleted successfully'];
        }else{
            return ['status'=>'error','message'=>'Job not found'];
        }
    }
}
