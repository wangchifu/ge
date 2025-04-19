@extends('layouts.master_clean')

@section('title',$post->title)

@section('content')
<section class="section">
    <div class="container">
        <div class="row no-gutters-lg">
            <div class="col-lg-12 mb-5 mb-lg-0">
                <div class="row">
                    <h2 class="section-title mb-3">{{ $post->title }}</h2>
                    <div class="container my-4">
                      @auth
                      @if(auth()->user()->admin==1)
                        <a href="{{ route('post.edit',$post->id) }}" class="btn btn-primary btn-sm">編輯</a>
                        <a href="#!" class="btn btn-danger btn-sm" onclick="sw_confirm1('確定刪除？','{{ route('post.destroy',$post->id) }}')">刪除</a>
                      @endif
                      @endauth
                      <div class="card border-dark shadow">                          
                        <div class="card-body">
                          <dl class="row mb-0">
                            <dt class="col-sm-2">內容</dt>
                            <dd class="col-sm-10">{{ $post->content }}</dd>
                    
                            <dt class="col-sm-2">點閱</dt>
                            <dd class="col-sm-10">{{ $post->views }}</dd>
                    
                            <dt class="col-sm-2">發佈人</dt>
                            <dd class="col-sm-10">{{ $post->user->name }}</dd>
                    
                            <dt class="col-sm-2">發佈時間</dt>
                            <dd class="col-sm-10">{{ $post->created_at->format('Y-m-d H:i') }}</dd>
                            @if(!empty($files))         
                              <dt class="col-sm-2">檔案下載</dt>
                              <dd class="col-sm-10">
                                @foreach($files as $k=>$v)  
                                  <a href="{{ asset('storage/posts/'.$post->id.'/'.$v) }}" target="_blank"><i class="fas fa-download"></i> {{ $v }}</a><br>
                                @endforeach
                              </dd>
                            @endif
                          </dl>
                        </div>
                      </div>                                                               
                    </div>                                                                           
                </div>
            </div>            
        </div>
    </div>
</section>
@endsection