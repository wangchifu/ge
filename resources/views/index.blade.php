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
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                          <tr>
                            <th scope="col">分類</th>
                            <th scope="col">名稱</th>
                            <th scope="col">動作</th>
                            <th scope="col">點擊</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($Auploads as $upload)
                            <tr>
                              <td>
                                @if($upload->type_id == 0)
                                    <?php $type_id = 0; ?>
                                    不分類
                                @else
                                    <?php $type_id = $upload->type_id; ?>
                                    {{ $upload->type->name }}
                                @endif
                              </td>
                              <td>
                                @if($upload->power == "D")
                                    <img src="{{ asset('storage/uploads/'.$upload->power.'/'.$type_id.'/'.$upload->name) }}" width="100">
                                @else
                                    {{ $upload->name }}
                                @endif
                              </td>
                              <td>                                
                                @if($upload->power == "D")
                                <?php $url = route('upload.item_link',$upload->id); ?>
                                    <a href="#!" class="btn btn-sm btn-success" onclick="openFileAndReload('{{ $url }}'); return false;">
                                        連結
                                    </a>
                                @else          
                                    <?php $url = route('upload.item_download',$upload->id); ?>                      
                                    <a href="#!" class="btn btn-sm btn-success" onclick="openFileAndReload('{{ $url }}'); return false;" style="white-space: nowrap;">
                                        下載
                                    </a>
                                @endif
                              </td>
                              <td>{{ $upload->views }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>      
                      <div class="col-12 mb-4">    
                        <small>[<a href="{{ route('upload.index','A') }}">更多專業人才庫...</a>]</small>                    
                    </div>                                  
                </div>
                <div class="row">
                    <h2 class="section-title mb-3">性平媒材</h2>
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                          <tr>
                            <th scope="col">分類</th>
                            <th scope="col">名稱</th>
                            <th scope="col">動作</th>
                            <th scope="col">點擊</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($Buploads as $upload)
                            <tr>
                              <td>
                                @if($upload->type_id == 0)
                                    <?php $type_id = 0; ?>
                                    不分類
                                @else
                                    <?php $type_id = $upload->type_id; ?>
                                    {{ $upload->type->name }}
                                @endif
                              </td>
                              <td>
                                @if($upload->power == "D")
                                    <img src="{{ asset('storage/uploads/'.$upload->power.'/'.$type_id.'/'.$upload->name) }}" width="100">
                                @else
                                    {{ $upload->name }}
                                @endif
                              </td>
                              <td>                                
                                @if($upload->power == "D")
                                <?php $url = route('upload.item_link',$upload->id); ?>
                                    <a href="#!" class="btn btn-sm btn-success" onclick="openFileAndReload('{{ $url }}'); return false;">
                                        連結
                                    </a>
                                @else          
                                    <?php $url = route('upload.item_download',$upload->id); ?>                      
                                    <a href="#!" class="btn btn-sm btn-success" onclick="openFileAndReload('{{ $url }}'); return false;" style="white-space: nowrap;">
                                        下載
                                    </a>
                                @endif
                              </td>
                              <td>{{ $upload->views }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>      
                      <div class="col-12 mb-4">         
                        <small>[<a href="{{ route('upload.index','B') }}">更多性平媒材...</a>]</small>                                   
                    </div>                                            
                </div>
                <div class="row">
                    <h2 class="section-title mb-3">性平事件處理表單</h2>     
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                          <tr>
                            <th scope="col">分類</th>
                            <th scope="col">名稱</th>
                            <th scope="col">動作</th>
                            <th scope="col">點擊</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($Cuploads as $upload)
                            <tr>
                              <td>
                                @if($upload->type_id == 0)
                                    <?php $type_id = 0; ?>
                                    不分類
                                @else
                                    <?php $type_id = $upload->type_id; ?>
                                    {{ $upload->type->name }}
                                @endif
                              </td>
                              <td>
                                @if($upload->power == "D")
                                    <img src="{{ asset('storage/uploads/'.$upload->power.'/'.$type_id.'/'.$upload->name) }}" width="100">
                                @else
                                    {{ $upload->name }}
                                @endif
                              </td>
                              <td>                                
                                @if($upload->power == "D")
                                <?php $url = route('upload.item_link',$upload->id); ?>
                                    <a href="#!" class="btn btn-sm btn-success" onclick="openFileAndReload('{{ $url }}'); return false;">
                                        連結
                                    </a>
                                @else          
                                    <?php $url = route('upload.item_download',$upload->id); ?>                      
                                    <a href="#!" class="btn btn-sm btn-success" onclick="openFileAndReload('{{ $url }}'); return false;" style="white-space: nowrap;">
                                        下載
                                    </a>
                                @endif
                              </td>
                              <td>{{ $upload->views }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>    
                      <div class="col-12 mb-4">        
                        <small>[<a href="{{ route('upload.index','C') }}">更多性平事件處理表單...</a>]</small>                                    
                    </div>                                           
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
                                        @foreach($Duploads as $upload)
                                            <article class="card mb-4">
                                                <div class="card-image">
                                                <div class="post-info"> <span class="text-uppercase">{{ $upload->created_at }}</span>
                                                </div>
                                                <a href="{{ $upload->url }}" target="_blank">
                                                    <img loading="lazy" decoding="async" src="{{ asset('storage/uploads/'.$upload->power.'/'.$upload->type_id.'/'.$upload->name) }}" alt="Post Thumbnail" class="w-100">
                                                </a>
                                                </div>
                                                <div class="card-body px-0 pb-1">
                                                <h3>
                                                    <a class="post-title post-title-sm" href="{{ $upload->url }}" target="_blank">
                                                        {{ $upload->sitename }}
                                                    </a>
                                                </h3>                                        
                                                </div>
                                            </article>                   
                                        @endforeach  
                                        <small>[<a href="{{ route('upload.index','D') }}">更多友站連結...</a>]</small>                                           
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="widget">
                                <h2 class="section-title mb-3">相關法規</h2>
                                <div class="widget-body">
                                    <ul class="widget-list">
                                    @foreach ($Euploads as $upload)
                                        <?php $url = route('upload.item_download',$upload->id); ?>
                                        <li><a href="#!" onclick="openFileAndReload('{{ $url }}'); return false;">{{ $upload->name }} ({{ $upload->views }})</a>
                                        </li>
                                    @endforeach                                                                        
                                    </ul>
                                    <small>[<a href="{{ route('upload.index','E') }}">更多相關法規...</a>]</small>                                    
                                </div>
                            </div>                        
                        </div>
                        <div class="col-lg-12 col-md-6">
                            <div class="widget">
                                <h2 class="section-title mb-3">資源分享</h2>
                                <div class="widget-body">
                                    <ul class="widget-list">
                                    @foreach ($Fuploads as $upload)
                                        <?php $url = route('upload.item_download',$upload->id); ?>
                                        <li><a href="#!" onclick="openFileAndReload('{{ $url }}'); return false;">{{ $upload->name }} ({{ $upload->views }})</a>
                                        </li>
                                    @endforeach                                    
                                    </ul>
                                    <small>[<a href="{{ route('upload.index','F') }}">更多資源分享...</a>]</small>                                    
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

    function openFileAndReload(url) {
        window.open(url, '_blank');
    
        setTimeout(() => {
            location.reload();
        }, 300); // 延遲一點點，確保 reload 執行（300~500ms 效果較穩）
    }    
</script>
@endsection