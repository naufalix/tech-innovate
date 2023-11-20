<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\APIController;
use App\Http\Controllers\Auth\UserAuthController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminHome;
use App\Http\Controllers\Admin\AdminJob;
use App\Http\Controllers\Admin\AdminUser;
use App\Http\Controllers\Dashboard\DashboardHome;
use App\Http\Controllers\Dashboard\DashboardProfile;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/dashboard');
});

// DASHBOARD AUTH
Route::get('/dashboard/login', [UserAuthController::class, 'index'])->name('login');
Route::post('/dashboard/login', [UserAuthController::class, 'login']);
Route::get('/dashboard/logout', [UserAuthController::class, 'logout']);

// DASHBOARD PAGE
Route::group(['prefix'=> 'dashboard','middleware'=>['auth:user']], function(){
    Route::get('/', [DashboardHome::class, 'index']);
    Route::get('/home', [DashboardHome::class, 'index']);
    Route::get('/profile', [DashboardProfile::class, 'index']);
    
    Route::post('/profile', [DashboardProfile::class, 'postHandler']);
});

// ADMIN AUTH
Route::get('/admin/login', [AdminAuthController::class, 'index']);
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::get('/admin/logout', [AdminAuthController::class, 'logout']);

// ADMIN PAGE
Route::group(['prefix'=> 'admin','middleware'=>['auth:admin']], function(){
    Route::get('/', [AdminHome::class, 'index']);
    Route::get('/home', [AdminHome::class, 'index']);
    Route::get('/job', [AdminJob::class, 'index']);
    Route::get('/user', [AdminUser::class, 'index']);
    
    Route::post('/job', [AdminJob::class, 'postHandler']);
    Route::post('/user', [AdminUser::class, 'postHandler']);
});

// API
Route::group(['prefix'=> 'api'], function(){
    Route::get('user/{user:id}', [APIController::class, 'User']);
    Route::get('job/{job:id}', [APIController::class, 'Job']);
});