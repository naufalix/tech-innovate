<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;
use App\Models\Job;
use App\Models\User;
use Illuminate\Http\Request;

class APIController extends Controller
{
  public function job(Job $job){
    return ApiFormatter::createApi(200,"Success",$job);
  }
}
