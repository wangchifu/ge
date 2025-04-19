<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', [HomeController::class,'index'])->name('index');
Route::get('glogin', [HomeController::class,'glogin'])->name('glogin');
Route::post('gauth', [HomeController::class,'gauth'])->name('gauth');
//Route::get('login', [HomeController::class,'login'])->name('login');
//Route::post('auth', [HomeController::class,'auth'])->name('auth');
Route::get('logout', [HomeController::class,'logout'])->name('logout');
Route::get('pic', [HomeController::class,'pic'])->name('pic');

//openid登入
Route::get('sso', [OpenIDController::class,'sso'])->name('sso');
Route::get('auth/callback', [OpenIDController::class,'callback'])->name('callback');

Route::get('post/show/{post}', [PostController::class,'show'])->name('post.show');

//管理者可用
Route::group(['middleware' => 'admin'],function(){
    Route::get('user/index', [UserController::class,'index'])->name('user.index');
    Route::get('user/{user}/change', [UserController::class,'change'])->name('user.change');
    Route::get('user/{user}/edit_power', [UserController::class,'edit_power'])->name('user.edit_power');
    Route::post('user/{user}/update_power', [UserController::class,'update_power'])->name('user.update_power');

    Route::get('post/create', [PostController::class,'create'])->name('post.create');    
    Route::post('post/store', [PostController::class,'store'])->name('post.store');        
    Route::get('post/edit/{post}', [PostController::class,'edit'])->name('post.edit');
    Route::post('post/update/{post}', [PostController::class,'update'])->name('post.update');
    Route::get('post/destroy/{post}', [PostController::class,'destroy'])->name('post.destroy');
    Route::get('post/{post}/delete_file/{filename}', [PostController::class,'delete_file'])->name('post.delete_file');
});