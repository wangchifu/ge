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
                    <label for="category" class="form-label">請選擇分類</label>
                    <select name="type_id" id="type_id" class="form-select" onchange="redirectToType(this)">
                        @foreach ($type_select as $key => $label)
                        <?php                             
                            $selected = ($key==$type_id)?"selected":"";
                        ?>
                        <option value="{{ $key }}" {{ $selected }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                          <tr>
                            <th scope="col">分類</th>
                            <th scope="col">檔案名稱</th>
                            <th scope="col">下載</th>
                            <th scope="col">下載數</th>
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
                              <td>{{ $upload->name }}</td>
                              <td>
                                <?php $url = route('upload.item_download',$upload->id); ?>
                                <a href="#!" class="btn btn-sm btn-success" onclick="openFileAndReload('{{ $url }}'); return false;">
                                  下載
                                </a>
                                @auth
                                    @if(auth()->user()->admin==1 or strpos(auth()->user()->power,$power) !== false)
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
    function redirectToType(select) {
        const typeId = select.value;
        // 假設要跳到 /types/{id} 這個路徑
        window.location.href = '/upload/index/{{ $power }}/' + typeId;
    }

    function openFileAndReload(url) {
        window.open(url, '_blank');
    
        setTimeout(() => {
            location.reload();
        }, 300); // 延遲一點點，確保 reload 執行（300~500ms 效果較穩）
    }
</script>
    
@endsection