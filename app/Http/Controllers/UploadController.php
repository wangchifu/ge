<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Type;
use App\Models\Upload;

class UploadController extends Controller
{
    public function index($power=null,$type_id=null){
        if(is_null($type_id)) $type_id="999";
        $power_items = config('ge.power_items');
        $power_item = $power_items[$power];
        if(is_null($type_id) or $type_id == 999){
            $uploads = Upload::where('power',$power)->orderBy('id','DESC')->paginate(10);
        }else{            
            $uploads = Upload::where('power',$power)->where('type_id',$type_id)->orderBy('order_by')->orderBy('id','DESC')->paginate(10);
        }
        
        $types = Type::where('power',$power)->orderBy('order_by')->get();
        $type_select[999] = "全部";
        foreach($types as $type){
            $type_select[$type->id] = $type->name;
        }
        $type_select[0] = "不分類";        
        $data = [
            'power'=>$power,
            'type_id'=>$type_id,
            'power_item'=>$power_item,
            'uploads'=>$uploads,
            'type_select'=>$type_select,
        ];
        return view('uploads.index',$data);
    }    

    public function type_index($power=null){
        if(strpos(auth()->user()->power,$power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        $power_items = config('ge.power_items');
        $power_item = $power_items[$power];
        $types = Type::where('power',$power)->orderBy('order_by')->get();
        $data = [
            'power'=>$power,
            'power_item'=>$power_item,
            'types'=>$types,
        ];
        return view('uploads.type_index',$data);

    }

    public function type_create($power=null){
        if(strpos(auth()->user()->power,$power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        $power_items = config('ge.power_items');
        $power_item = $power_items[$power];
        $data = [
            'power'=>$power,
            'power_item'=>$power_item,
        ];
        return view('uploads.type_create',$data);

    }

    public function type_store(Request $request,$power){
        if(strpos(auth()->user()->power,$power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        $power_items = config('ge.power_items');
        $power_item = $power_items[$power];
        $att['order_by'] = $request->input('order_by');
        $att['name'] = $request->input('name');
        $att['power'] = $power;
        Type::create($att);

        return redirect()->route('upload.type_index',$power);

    }

    public function type_edit(Type $type){
        if(strpos(auth()->user()->power,$type->power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        $power_items = config('ge.power_items');
        $power_item = $power_items[$type->power];
        $data = [
            'power'=>$type->power,
            'power_item'=>$power_item,
            'type'=>$type,
        ];
        return view('uploads.type_edit',$data);

    }

    public function type_update(Request $request,Type $type){
        if(strpos(auth()->user()->power,$type->power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }     
        $power_items = config('ge.power_items');
        $power_item = $power_items[$type->power];
        $att['order_by'] = $request->input('order_by');
        $att['name'] = $request->input('name');
        
        $type->update($att);

        return redirect()->route('upload.type_index',$type->power);
    }

    public function type_delete(Type $type){
        if(strpos(auth()->user()->power,$type->power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        $power = $type->power;        
        $folder = storage_path('app/public/uploads/'.$power.'/'.$type->id);        
        if(file_exists($folder)){
            del_folder($folder);
        }
        Upload::where('type_id',$type->id)->delete();
        $type->delete();

        return redirect()->route('upload.type_index',$power);
    }

    public function item_create($power=null){
        if(strpos(auth()->user()->power,$power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        $power_items = config('ge.power_items');
        $power_item = $power_items[$power];
        $types = Type::where('power',$power)->orderBy('order_by')->get();
        $type_select[0] = "不分類";
        foreach($types as $type){
            $type_select[$type->id] = $type->name;
        }
        $data = [
            'power'=>$power,
            'power_item'=>$power_item,
            'type_select'=>$type_select,
        ];
        return view('uploads.item_create',$data);

    }

    public function item_store(Request $request,$power){
        if(strpos(auth()->user()->power,$power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        //處理檔案上傳        
        if($power == "F"){
            $att['order_by'] = $request->input('order_by');
            $att['power'] = $power;             
            $att['name'] = "相關法規";
            $att['type_id'] = $request->input('type_id');
            $att['sitename'] = $request->input('sitename');
            $att['url'] = $request->input('url');
            $att['user_id'] = auth()->user()->id;
            $att['views'] = 0;

            $upload = Upload::create($att);
        }else{
            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
    
                        // 移除空格或轉換為底線
                    $safeName = str_replace(' ', '', $originalName);                
    
                    $att['order_by'] = $request->input('order_by');
                    $att['power'] = $power;             
                    $att['name'] = $safeName;
                    $att['type_id'] = $request->input('type_id');
                    $att['sitename'] = $request->input('sitename');
                    $att['url'] = $request->input('url');
                    $att['user_id'] = auth()->user()->id;
                    $att['views'] = 0;
    
                    $upload = Upload::create($att);
    
                    $file->storeAs('public/uploads/'.$power.'/'.$att['type_id'].'/', $safeName);
                }
            }
        }

        

        return redirect()->route('upload.index',$power);
    }

    public function item_edit(Upload $upload,$power=null){
        if(strpos(auth()->user()->power,$power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        $power_items = config('ge.power_items');
        $power_item = $power_items[$power];
        $types = Type::where('power',$power)->orderBy('order_by')->get();
        $type_select[0] = "不分類";
        foreach($types as $type){
            $type_select[$type->id] = $type->name;
        }
        $data = [
            'power'=>$power,
            'power_item'=>$power_item,
            'type_select'=>$type_select,
            'upload'=>$upload,
        ];
        return view('uploads.item_edit',$data);

    }

    public function item_update(Request $request,Upload $upload){
        if(strpos(auth()->user()->power,$upload->power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        $att['order_by'] = $request->input('order_by');
        $att['power'] = $upload->power;                             
        $att['sitename'] = $request->input('sitename');
        $att['url'] = $request->input('url');
        $att['user_id'] = auth()->user()->id;        

        $upload->update($att);

        return redirect()->route('upload.index',$upload->power);
    }

    public function item_download(Upload $upload){        
        $file = storage_path('app/public/uploads/'.$upload->power.'/'.$upload->type_id.'/'.$upload->name);        
        $s_key = "item_down" . $upload->id;
        if (!session($s_key)) {
            $att['views'] = $upload->views;
            $att['views']++;        
            $upload->update($att); 
        }
        session([$s_key => '1']);
        //return response()->download($file);        
        return response()->file($file);        
    }
    public function item_link(Upload $upload){     
        $s_key = "item_down" . $upload->id;
        if (!session($s_key)) {
            $att['views'] = $upload->views;
            $att['views']++;        
            $upload->update($att); 
        }
        session([$s_key => '1']);                            
        return redirect($upload->url);        
    }

    public function item_delete(Upload $upload){
        if(strpos(auth()->user()->power,$upload->power) === false){
            if(empty(auth()->user()->admin)){
                return back();
            }            
        }
        $file = storage_path('app/public/uploads/'.$upload->power.'/'.$upload->type_id.'/'.$upload->name);
        if(file_exists($file)){
            unlink($file);
        }
        $upload->delete();
        return back();
    }


}
