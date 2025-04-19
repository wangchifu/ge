<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function create(){

        return view('posts.create');
    }

    public function store(Request $request){        
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $att['title'] = $request->input('title');
        $att['content'] = $request->input('content');
        $att['user_id'] = auth()->user()->id;
        $att['views'] = 0;
        $post = Post::create($att);

        //處理檔案上傳        
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $info = [
                    'original_filename' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                ];

                $file->storeAs('public/posts/'.$post->id, $info['original_filename']);
            }
        }
        return redirect()->route('index');
    }

    public function show(Post $post){
        $s_key = "pv" . $post->id;
        if (!session($s_key)) {
            $att['views'] = $post->views + 1;
            $post->update($att);
        }
        session([$s_key => '1']);

        $files = get_files(storage_path('app/public/posts/'.$post->id));        
        $data = [
            'post'=>$post,  
            'files'=>$files,
        ];
        return view('posts.show',$data);
    }

    public function destroy(Post $post)
    {
        if (auth()->user()->id != $post->user_id) {
            return back();
        }        
        $folder = storage_path('app/public/posts/' . $post->id);
        if (is_dir($folder)) {
            del_folder($folder);
        }

        $post->delete();

        if(file_exists(storage_path('app/public/posts/'.$post->id))){
            del_folder(storage_path('app/public/posts/'.$post->id));
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

    public function edit(Post $post){
        $files = get_files(storage_path('app/public/posts/'.$post->id));        
        $data = [
            'post'=>$post,  
            'files'=>$files,
        ];
        return view('posts.edit',$data);
    }

    public function update(Request $request,Post $post){        
        $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);
        $att['title'] = $request->input('title');
        $att['content'] = $request->input('content');
                
        $post->update($att);

        //處理檔案上傳        
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                $info = [
                    'original_filename' => $file->getClientOriginalName(),
                    'extension' => $file->getClientOriginalExtension(),
                ];

                $file->storeAs('public/posts/'.$post->id, $info['original_filename']);
            }
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

    public function delete_file(Post $post, $filename)
    {
        if ($post->user_id != auth()->user()->id) {
            return back();
        }
        
        $file = storage_path('app/public/posts/'.$post->id.'/'.$filename);

        if (file_exists($file)) {
            unlink($file);
        }
        return back();
    }
}
