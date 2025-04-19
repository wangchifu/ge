@extends('layouts.master')

@section('title','帳號管理')

@section('content')
<section class="section">
    <div class="container">
        <div class="row no-gutters-lg">
            <div class="col-lg-12 mb-5 mb-lg-0">
                <div class="row">
                    <h2 class="section-title mb-3">帳號管理</h2>
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                          <tr>
                            <th>學校</th>
                            <th>職稱</th>
                            <th>姓名</th>
                            <th>權限</th>
                            <th>動作</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                          <tr>
                            <td>{{ $user->school_name }}</td>
                            <td>{{ $user->title }}</td>
                            <td>
                                {{ $user->name }}
                                @if($user->disable)
                                    <span class="text-danger">(已停用)</span>
                                @endif
                            </td>
                            <td>                                
                                @if($user->admin==1)
                                    系統管理員
                                @endif
                                @if(!empty($user->power))
                                    {{ $user->power }}
                                @endif
                            </td>
                            <td>                                
                                <a href="{{ route('user.edit_power',$user->id) }}" data-vbtype="iframe" class="btn btn-outline-secondary btn-sm venobox-link">編輯權限</a>
                                @if($user->disable)
                                    <a class="btn btn-outline-success btn-sm" href="#!" onclick="sw_confirm1('確定啟用？','{{ route('user.change',$user->id) }}')">啟用</a>
                                @else
                                    <a class="btn btn-outline-danger btn-sm" href="#!" onclick="sw_confirm1('確定停用？','{{ route('user.change',$user->id) }}')">停用</a>
                                @endif
                            </td>
                          </tr>
                        @endforeach
                          <tr>
                        </tbody>
                      </table>
                      註：A:專業人才庫,B:性平媒材,C:性平事件處理表單,D:友站連結,E:相關法規,F:資源分享
                      {{ $users->withQueryString()->links('pagination::bootstrap-5') }}
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