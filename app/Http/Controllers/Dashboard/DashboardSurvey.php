<?php

namespace App\Http\Controllers\Dashboard;
use App\Http\Controllers\Controller;
use App\Models\Job;
use App\Models\Question;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardSurvey extends Controller
{
    
    public function index(){
        return view('dashboard.survey',[
            "title" => "Dashboard | Asesmen",
            "surveys" => Survey::whereUserId(auth()->user()->id)->get(),
            "questions" => Question::all(),
            "jobs" => Job::all()
        ]);
    }

    public function postHandler(Request $request){
        if($request->submit=="survey"){
            $res = $this->store($request);
            return back()->with($res['status'],$res['message']);
        }
        if($request->submit=="update"){
            $res = $this->update($request);
            return redirect('/dev/admin')->with($res['status'],$res['message']);
        }
        if($request->submit=="destroy"){
            $res = $this->destroy($request);
            return back()->with($res['status'],$res['message']);
            // return redirect('/dashboard/user')->with("info","Fitur hapus sementara dinonaktifkan");
        }else{
            return redirect('/dev/admin')->with("info","Submit not found");
        }
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'questions'=>'required',
        ]);
        $validatedData['user_id'] = auth()->user()->id;

        // Make promp form user profile
        $prompt = auth()->user()->education." ".auth()->user()->experience." ".auth()->user()->passion." ".auth()->user()->skill;
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
        Survey::create($validatedData);
        return ['status'=>'success','message'=>'Asesmen berhasil disimpan'];
        
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
