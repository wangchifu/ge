<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\OpenIDController;

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
//Route::get('glogin', [HomeController::class,'glogin'])->name('glogin');
//Route::post('gauth', [HomeController::class,'gauth'])->name('gauth');
//Route::get('login', [HomeController::class,'login'])->name('login');
//Route::post('auth', [HomeController::class,'auth'])->name('auth');
Route::get('logout', [HomeController::class,'logout'])->name('logout');
Route::get('pic', [HomeController::class,'pic'])->name('pic');

//openid登入
Route::get('sso', [OpenIDController::class,'sso'])->name('sso');
Route::get('auth/callback', [OpenIDController::class,'callback'])->name('callback');

Route::get('post/show/{post}', [PostController::class,'show'])->name('post.show');

Route::get('upload/index/{power}/{type_id?}', [UploadController::class,'index'])->name('upload.index');

Route::get('upload/item_download/{upload}', [UploadController::class,'item_download'])->name('upload.item_download');
Route::get('upload/item_link/{upload}', [UploadController::class,'item_link'])->name('upload.item_link');

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

//具有管理權限者
Route::group(['middleware' => 'power'],function(){
    Route::get('upload/type_index/{power}', [UploadController::class,'type_index'])->name('upload.type_index');
    
    Route::get('upload/type_create/{power}', [UploadController::class,'type_create'])->name('upload.type_create');
    Route::post('upload/type_store/{power}', [UploadController::class,'type_store'])->name('upload.type_store');
    Route::get('upload/type_edit/{type}', [UploadController::class,'type_edit'])->name('upload.type_edit');
    Route::post('upload/type_update/{type}', [UploadController::class,'type_update'])->name('upload.type_update');
    Route::delete('upload/type_delete/{type}', [UploadController::class,'type_delete'])->name('upload.type_delete');

    Route::get('upload/item_create/{power}', [UploadController::class,'item_create'])->name('upload.item_create');    
    Route::post('upload/item_store/{power}', [UploadController::class,'item_store'])->name('upload.item_store');
    Route::get('upload/item_edit/{upload}/{power}', [UploadController::class,'item_edit'])->name('upload.item_edit');
    Route::post('upload/item_update/{upload}', [UploadController::class,'item_update'])->name('upload.item_update');
    Route::get('upload/item_delete/{upload}', [UploadController::class,'item_delete'])->name('upload.item_delete');    
});    