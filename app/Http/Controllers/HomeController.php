<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Post;
use App\Models\Upload;

class HomeController extends Controller
{
    public function index(){
         
        $posts = Post::orderBy('created_at','DESC')
            ->paginate(10); 
        
        $Auploads = Upload::where('power','A')->orderBy('id','DESC')->paginate(5);
        $Buploads = Upload::where('power','B')->orderBy('id','DESC')->paginate(5);
        $Cuploads = Upload::where('power','C')->orderBy('id','DESC')->paginate(5);
        $Duploads = Upload::where('power','D')->orderBy('id','DESC')->paginate(5);
        $Euploads = Upload::where('power','E')->orderBy('id','DESC')->paginate(5);
        $Fuploads = Upload::where('power','F')->orderBy('id','DESC')->paginate(5);
        $Guploads = Upload::where('power','G')->orderBy('id','DESC')->paginate(5);

        $data = [
            'posts'=>$posts,
            'Auploads'=>$Auploads,
            'Buploads'=>$Buploads,
            'Cuploads'=>$Cuploads,
            'Duploads'=>$Duploads,
            'Euploads'=>$Euploads,
            'Fuploads'=>$Fuploads,                        
            'Guploads'=>$Guploads,  
        ];
        return view('index',$data);
    }
    public function glogin(){
        $key = rand(10000, 99999);
        session(['chaptcha' => $key]);

        $data = [

        ];
        return view('glogin',$data);
    }

    public function pic()
    {
        //$key = rand(10000, 99999);
        //session(['chaptcha' => $key]);
        $key = session('chaptcha');

        $back = rand(0, 9);
        /*
        $r = rand(0,255);
        $g = rand(0,255);
        $b = rand(0,255);
        */
        $r = 0;
        $g = 0;
        $b = 0;        

        //$cht = array(0=>"零",1=>"壹",2=>"貳",3=>"參",4=>"肆",5=>"伍",6=>"陸",7=>"柒",8=>"捌",9=>"玖");
        $cht = array(0 => "0", 1 => "1", 2 => "2", 3 => "3", 4 => "4", 5 => "5", 6 => "6", 7 => "7", 8 => "8", 9 => "9");
        $cht_key = "";
        for ($i = 0; $i < 5; $i++) $cht_key .= $cht[substr($key, $i, 1)];

        header("Content-type: image/gif");
        $im = imagecreatefromgif(asset('images/back.gif')) or die("無法建立GD圖片");
        $text_color = imagecolorallocate($im, $r, $g, $b);

        imagettftext($im, 25, 0, 5, 32, $text_color, public_path('font/AdobeGothicStd-Bold.otf'), $cht_key);
        imagegif($im);
        imagedestroy($im);
    }

    public function gauth(Request $request)
    {
        if ($request->input('chaptcha') != session('chaptcha')) {
            return back()->withErrors(['gsuite_error' => ['驗證碼錯誤！']]);
        }
        $username = explode('@', $request->input('username'));

        $data = array("email" => $username[0], "password" => $request->input('password'));
        $data_string = json_encode($data);
        $ch = curl_init(env('GSUITE_AUTH'));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string)
            )
        );
        $result = curl_exec($ch);
        $obj = json_decode($result, true);        

        //學生禁止訪問
        if ($obj['success']) {

            if ($obj['kind'] == "學生") {
                return back()->withErrors(['errors' => ['學生禁止進入錯誤']]);
            }

            // 找出隸屬於哪一所學校 id 代號
            //$school = School::where('code_no', 'like', $obj['code'] . '%')->first();
            $schools_id = config('ge.schools_id');
            $school_id = !isset($schools_id[$obj['code']]) ? 0 : $schools_id[$obj['code']];

            //是否已有此帳號
            $user = User::where('edu_key', $obj['edu_key'])         
                ->where('school_code', $obj['code'])        
                ->first();

            if (empty($user)) {
                //查有無曾用openid登入者
                //已取消openid登入 
                //$user2 = User::where('edu_key', $obj['edu_key'])
                //    ->where('login_type', 'gsuite')
                //    ->first();

                $att['username'] = $username[0];
                $att['password'] = bcrypt($request->input('password'));                
                $att['name'] = $obj['name'];
                $att['school_code'] = $obj['code'];
                $att['school_name'] = $obj['school'];
                $att['kind'] = $obj['kind'];
                $att['title'] = $obj['title'];
                $att['edu_key'] = $obj['edu_key'];
                $att['uid'] = $obj['uid'];
                $att['login_type'] = "gsuite";                
                //if (empty($user2)) {
                    //無使用者，即建立使用者資料
                    $user = User::create($att);
                //} else {
                //    $user2->update($att);
                //}
            } else {

                if($user->disable==1){
                    return back()->withErrors(['errors' => ['此帳號被停用，無法登入！']]);
                }

                //有此使用者，即更新使用者資料
                $att['name'] = $obj['name'];
                $att['password'] = bcrypt($request->input('password'));
                $att['school_code'] = $obj['code'];
                $att['school_name'] = $obj['school'];
                $att['kind'] = $obj['kind'];
                $att['title'] = $obj['title'];
                $att['edu_key'] = $obj['edu_key'];
                $att['uid'] = $obj['uid'];                                                
                $user->update($att);
            }            

            //if (Auth::attempt([
            //    'username' => $username[0],
            //    'password' => $request->input('password')
            //])) {                                                         
            //}

            Auth::login($user);
            //到本來的要求頁面
            if (empty($request->session()->get('url.intended'))) {
                return redirect()->route('index');
            } else {
                return redirect($request->session()->get('url.intended'));
            }               
        };        

        return back()->withErrors(['errors' => ['帳號密碼錯誤']]);
    }

    public function logout()
    {
        Auth::logout();        
        $url = "https://chc.sso.edu.tw/oidc/v1/logout-to-go";
        $post_logout_redirect_uri = env('APP_URL');
        $id_token_hint = session('id_token');
        $link = $url . "?post_logout_redirect_uri=".$post_logout_redirect_uri."&id_token_hint=" . $id_token_hint;

        Session::flush();
        return redirect($link);        
    }
}
