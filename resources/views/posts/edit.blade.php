@extends('layouts.master_clean')

@section('title','修改公告')

@section('content')
<section class="section">
    <div class="container">
        <div class="row no-gutters-lg">
            <div class="col-lg-12 mb-5 mb-lg-0">
                <div class="row">
                    <h2 class="section-title mb-3">修改公告</h2>
                    <div class="container my-4">
                      <div class="card">                    
                        <div class="card-body">                          
                            <form action="{{ route('post.update',$post->id) }}" method="post" enctype="multipart/form-data" id="update_post">
                                @csrf
                                <div class="mb-3">
                                    <label for="title" class="form-label text-danger">公告標題*</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{ $post->title }}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label text-danger">公告內容*</label>
                                    <textarea class="form-control" id="content" name="content" rows="6" required>{{ $post->content }}</textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="files" class="form-label">附加檔案</label>
                                    @if(!empty($files))  
                                        @foreach($files as $k=>$v)
                                        <a href="#!" class="text-danger" onclick="sw_confirm1('確定刪除？','{{ route('post.delete_file',['post'=>$post->id,'filename'=>$v]) }}')" style="margin: 5px;"><i class="fas fa-times-circle"></i> (刪除){{ $v }}</a>                                
                                        @endforeach                                       
                                    @endif 
                                    <input class="form-control" type="file" id="files" name="files[]" multiple>
                                </div>
                                @include('layouts.errors')                                  
                                <a href="#!" class="btn btn-primary" onclick="sw_confirm2('確定儲存？','update_post')">儲存公告</a>
                            </form>
                        </div>
                      </div>                                                           
                    </div>                                                                           
                </div>
            </div>            
        </div>
    </div>
</section>
@endsection