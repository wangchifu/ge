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
                            <td>{{ $user->name }}</td>
                            <td>                                
                                @if($user->admin==1)
                                    管理員
                                @endif
                                @if(!empty($user->power))
                                    {{ $user->power }}
                                @endif
                            </td>
                            <td></td>
                          </tr>
                        @endforeach
                          <tr>
                        </tbody>
                      </table>
                      註：A:專業人才庫,B:性平媒材,C:性平事件處理表單,D:友站連結,E:相關法規,F:資源分享
                </div>
            </div>            
        </div>
    </div>
</section>
@endsection