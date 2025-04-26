@extends('layouts.master')

@section('title','帳號管理')

@section('content')
<section class="section">
    <div class="container">
        <div class="row no-gutters-lg">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="row">
                @auth
                    @if(auth()->user()->admin==1 or strpos(auth()->user()->power,$power) !== false)
                        <div class="col-2 mb-4">
                            <a class="btn btn-outline-primary" href="{{ route('upload.type_index',$power) }}">類別管理</a>
                        </div>                            
                        <div class="col-2 mb-4">
                            <a class="btn btn-outline-primary" href="{{ route('upload.item_create',$power) }}">新增項目</a>
                        </div>
                    @endif
                @endauth 
                </div>
            </div>
            <div class="col-lg-12 mb-5 mb-lg-0">
                <div class="row">                                       
                    <h2 class="section-title mb-3">{{ $power_item }}</h2>
                    <div class="btn-container" style="white-space: nowrap; overflow-x: auto;">
                        @foreach ($type_select as $key => $label)
                            <?php  $btn_style=($key==$type_id)?"btn-primary":"btn-outline-primary"; ?>
                            <div class="me-2 mb-2 d-inline-block">
                                <a href="{{ route('upload.index',['power'=>$power,'type_id'=>$key]) }}" class="btn btn-sm {{ $btn_style }}">{{ $label }}</a>
                            </div>
                        @endforeach
                    </div>                    
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                          <tr>
                            <th scope="col" nowrap>分類</th>
                            @auth
                                @if(auth()->user()->admin==1 or strpos(auth()->user()->power,$power) !== false)
                                    <th scope="col" nowrap>排序</th>
                                @endif                            
                            @endauth
                            <th scope="col" nowrap>名稱</th>
                            <th scope="col" nowrap>動作</th>
                            <th scope="col" nowrap>點擊</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($uploads as $upload)
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
                              @auth
                                @if(auth()->user()->admin==1 or strpos(auth()->user()->power,$power) !== false)
                                  <td>
                                    {{ $upload->order_by }}
                                  </td>
                                @endif                            
                              @endauth                              
                              <td>
                                @if($power == "E")
                                    <img src="{{ asset('storage/uploads/'.$power.'/'.$type_id.'/'.$upload->name) }}" width="100">
                                    {{ $upload->sitename }}
                                @elseif($power == "F")
                                    {{ $upload->sitename }}
                                @else
                                    {{ $upload->name }}
                                @endif
                              </td>
                              <td>                                
                                @if($power == "E" or $power == "F")
                                <?php $url = route('upload.item_link',$upload->id); ?>
                                    <a href="#!" class="btn btn-sm btn-success" onclick="openFileAndReload('{{ $url }}'); return false;" style="white-space: nowrap;">
                                        連結
                                    </a>
                                @else          
                                    <?php $url = route('upload.item_download',$upload->id); ?>                      
                                    <a href="#!" class="btn btn-sm btn-success" onclick="openFileAndReload('{{ $url }}'); return false;" style="white-space: nowrap;">
                                        下載
                                    </a>
                                @endif
                                @auth
                                    @if(auth()->user()->admin==1 or strpos(auth()->user()->power,$power) !== false)
                                        <a href="{{ route('upload.item_edit',['upload'=>$upload->id,'power'=>$power]) }}" class="btn btn-sm btn-outline-primary">
                                            編輯排序
                                        </a>
                                        <a href="#!" class="btn btn-sm btn-danger" onclick="sw_confirm1('確定刪除？','{{ route('upload.item_delete',$upload->id) }}')">
                                            刪除
                                        </a>                                    
                                    @endif
                                @endauth
                              </td>
                              <td>{{ $upload->views }}</td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>       
                      {{ $uploads->withQueryString()->links('pagination::bootstrap-5') }}                                   
                </div>
            </div>               
        </div>
    </div>
</section>
@endsection

@section('my_js')
<script>
    function openFileAndReload(url) {
        window.open(url, '_blank');
    
        setTimeout(() => {
            location.reload();
        }, 300); // 延遲一點點，確保 reload 執行（300~500ms 效果較穩）
    }
</script>
    
@endsection