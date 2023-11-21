<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Instant;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardInstant extends Controller
{
    
    public function index(){
        return view('dashboard.instant',[
            "title" => "Dashboard | Instant Recommendation",
            "instants" => Instant::whereUserId(auth()->user()->id)->get(),
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
            'prompt'=>'required',
        ]);
        $validatedData['user_id'] = auth()->user()->id;

        // Make array words from user prompt
        $prompt = $request->prompt;
        $words = explode(" ",$prompt);
        
        // Get job from database
        $jobs = Job::all();

        // Make array to save recommendation
        $result = [];

        // Recomentations
        foreach($words as $word){
            foreach($jobs as $job){
                if(str_contains($job->tags, $word)){
                    array_push($result,$job->id);
                }
            }
        }

        // Menghitung frekuensi kemunculan setiap nilai dalam array
        $counter = array_count_values($result);

        // Mengurutkan array frekuensi secara menurun
        arsort($counter);

        $i=1;
        foreach ($counter as $value => $frequency) {
            if($i>3){break;}
            $validatedData['jobs'.$i] = $value;
            $i++;
        }

        // Create new instant
        Instant::create($validatedData);
        return ['status'=>'success','message'=>'Prompt executed successfully'];
        
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
