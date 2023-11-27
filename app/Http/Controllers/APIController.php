<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Admin;
use App\Models\Job;
use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;

class APIController extends Controller
{
  public function admin(Admin $admin){
    return ApiFormatter::createApi(200,"Success",$admin);
  }
  public function job(Job $job){
    return ApiFormatter::createApi(200,"Success",$job);
  }
  public function question(Question $question){
    return ApiFormatter::createApi(200,"Success",$question);
  }
  public function user(User $user){
    return ApiFormatter::createApi(200,"Success",$user);
  }
}
