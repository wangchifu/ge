<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
         
        $users= User::orderBy('disable')->orderBy('admin','desc')->orderBy('power','desc')->paginate('10');
        $data = [
            'users'=>$users,
        ];
        return view('users.index',$data);
    }
    public function change(User $user){
        $att['disable'] = ($user->disable)?null:1;
        
        $user->update($att);
        return back();
    }

    public function edit_power(User $user){
        $data = [
            'user'=>$user,
        ];
        return view('users.edit_power',$data);
    }

    public function update_power(Request $request,User $user){                
        if($request->input('admin') == 1){
            $att['admin'] = 1;
            $user->update($att);            
        }else{
            $att['admin'] = null;
            $att['power'] = "";
            if(!empty($request->input('power'))){
                foreach($request->input('power') as $k=>$v){
                    $att['power'] = $att['power'].$v.",";
                }
            }

            $user->update($att);
        }
        echo "
        <script>
            // 嘗試重整母頁面
            window.parent.location.reload();

            // 嘗試關掉 venobox
            if (window.parent.VenoBox && typeof window.parent.VenoBox.close === 'function') {
                window.parent.VenoBox.close();
            } else {
                // 傳統 venobox 方式（模擬點擊關閉按鈕）
                const closeBtn = window.parent.document.querySelector('.vbox-close');
                if (closeBtn) closeBtn.click();
            }
            </script>
        ";
    }
}
