<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
         
        $users= User::orderBy('admin','desc')->orderBy('power','desc')->paginate('10');
        $data = [
            'users'=>$users,
        ];
        return view('user.index',$data);
    }
}
