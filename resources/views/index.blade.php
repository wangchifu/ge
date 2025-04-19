@extends('layouts.master')

@section('title','首頁')

@section('content')
<section class="section">
    <div class="container">
        <div class="row no-gutters-lg">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="row">
                    @auth
                        @if(auth()->user()->admin==1)
                            <div class="col-2 mb-4">
                                <a class="btn btn-outline-primary" href="{{ route('post.create') }}">新增公告</a>
                            </div>
                            <div class="col-2 mb-4">
                                <a class="btn btn-outline-primary" href="{{ route('user.index') }}">帳號管理</a>
                            </div>
                        @endif
                    @endauth
                    <h2 class="section-title mb-3">最新公告</h2>
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                          <tr>
                            <th>標題</th>
                            <th>發佈者</th>
                            <th>點閱</th>
                            <th>發佈日期</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($posts as $post)
                            <tr>
                              <td><a href="{{ route('post.show',$post->id) }}" data-vbtype="iframe" class="venobox-link">{{ $post->title }}</a></td>
                              <td>{{ $post->user->name }}</td>
                              <td>{{ $post->views }}</td>
                              <td>{{ \Illuminate\Support\Str::limit($post->created_at, 10, '') }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>                    
                    <div class="col-12 mb-4">
                        {{ $posts->withQueryString()->links('pagination::bootstrap-5') }}
                    </div>            
                </div>
                <div class="row">
                    <h2 class="section-title mb-3">專業人才庫</h2>         
                </div>
                <div class="row">
                    <h2 class="section-title mb-3">性平媒材</h2>        
                </div>
                <div class="row">
                    <h2 class="section-title mb-3">性平事件處理</h2>          
                </div>
            </div>
            <div class="col-lg-4">
                <div class="widget-blocks">
                    <div class="row">
                        <div class="col-lg-12 col-md-6">
                            <div class="widget">
                                <h2 class="section-title mb-3">友站連結</h2>
                                <div class="widget-body">
                                    <div class="widget-list">
                                        <article class="card mb-4">
                                            <div class="card-image">
                                            <div class="post-info"> <span class="text-uppercase">1 minutes read</span>
                                            </div>
                                            <img loading="lazy" decoding="async" src="images/post/post-9.jpg" alt="Post Thumbnail" class="w-100">
                                            </div>
                                            <div class="card-body px-0 pb-1">
                                            <h3>
                                                <a class="post-title post-title-sm" href="article.html">
                                                    Portugal and France Now Allow Unvaccinated Tourists
                                                </a>
                                            </h3>                                        
                                            </div>
                                        </article>                            
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="widget">
                                <h2 class="section-title mb-3">相關法規</h2>
                                <div class="widget-body">
                                    <ul class="widget-list">
                                    <li><a href="#!">computer<span class="ml-auto">(3)</span></a>
                                    </li>
                                    <li><a href="#!">cruises<span class="ml-auto">(2)</span></a>
                                    </li>
                                    <li><a href="#!">destination<span class="ml-auto">(1)</span></a>
                                    </li>
                                    <li><a href="#!">internet<span class="ml-auto">(4)</span></a>
                                    </li>
                                    <li><a href="#!">lifestyle<span class="ml-auto">(2)</span></a>
                                    </li>
                                    <li><a href="#!">news<span class="ml-auto">(5)</span></a>
                                    </li>
                                    <li><a href="#!">telephone<span class="ml-auto">(1)</span></a>
                                    </li>
                                    <li><a href="#!">tips<span class="ml-auto">(1)</span></a>
                                    </li>
                                    <li><a href="#!">travel<span class="ml-auto">(3)</span></a>
                                    </li>
                                    <li><a href="#!">website<span class="ml-auto">(4)</span></a>
                                    </li>
                                    <li><a href="#!">hugo<span class="ml-auto">(2)</span></a>
                                    </li>
                                    </ul>
                                </div>
                            </div>                        
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="widget">
                                <h2 class="section-title mb-3">資源分享</h2>
                                <div class="widget-body">
                                    <ul class="widget-list">
                                    <li><a href="#!">computer<span class="ml-auto">(3)</span></a>
                                    </li>
                                    <li><a href="#!">cruises<span class="ml-auto">(2)</span></a>
                                    </li>
                                    <li><a href="#!">destination<span class="ml-auto">(1)</span></a>
                                    </li>
                                    <li><a href="#!">internet<span class="ml-auto">(4)</span></a>
                                    </li>
                                    <li><a href="#!">lifestyle<span class="ml-auto">(2)</span></a>
                                    </li>
                                    <li><a href="#!">news<span class="ml-auto">(5)</span></a>
                                    </li>
                                    <li><a href="#!">telephone<span class="ml-auto">(1)</span></a>
                                    </li>
                                    <li><a href="#!">tips<span class="ml-auto">(1)</span></a>
                                    </li>
                                    <li><a href="#!">travel<span class="ml-auto">(3)</span></a>
                                    </li>
                                    <li><a href="#!">website<span class="ml-auto">(4)</span></a>
                                    </li>
                                    <li><a href="#!">hugo<span class="ml-auto">(2)</span></a>
                                    </li>
                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('my_js')
<script>
    $(document).ready(function(){
        var vb = new VenoBox({
            selector: '.venobox-link',
            numeration: true,
            infinigall: true,
            //share: ['facebook', 'twitter', 'linkedin', 'pinterest', 'download'],
            spinner: 'rotating-plane'
        });

    $(document).on('click', '.vbox-close', function() {
            vb.close();
        });

    // 監聽 iframe 發送的消息
    window.addEventListener('message', function(event) {
        // 檢查消息內容，並且只處理關閉的請求
        if (event.data === 'closeVenobox') {
            vb.VBclose(); // 關閉 Venobox 視窗
        }
    }, false);
    });  
</script>
@endsection