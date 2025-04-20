@extends('layouts.master')

@section('title','類別管理')

@section('content')
<section class="section">
    <div class="container">
        <div class="row no-gutters-lg">
            <div class="col-lg-8 mb-5 mb-lg-0">
                <div class="row">
                @auth
                    @if(auth()->user()->admin==1 or strpos(auth()->user()->power,$power) !== false)   
                        <div class="col-2 mb-4">
                            <a class="btn btn-outline-dark" href="{{ route('upload.index',$power) }}">返回上頁</a>
                        </div>                      
                        <div class="col-2 mb-4">
                            <a class="btn btn-outline-primary" href="{{ route('upload.type_create',$power) }}">新增類別</a>
                        </div>
                    @endif
                @endauth 
                </div>
            </div>
            <div class="col-lg-12 mb-5 mb-lg-0">
                <div class="row">                                       
                    <h2 class="section-title mb-3">{{ $power_item }}-類別總覽</h2>
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-secondary">
                          <tr>
                            <th scope="col">排序</th>
                            <th scope="col">名稱</th>
                            <th scope="col">動作</th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($types as $type)
                            <tr>
                              <td>{{ $type->order_by }}</td>
                              <td>{{ $type->name }}</td>
                              <td>
                                <a href="{{ route('upload.type_edit',$type->id) }}" class="btn btn-sm btn-outline-primary">編輯</a>
                                <form action="{{ route('upload.type_delete',$type->id) }}" method="POST" class="d-inline" id="delete{{ $type->id }}">
                                  @csrf
                                  @method('DELETE')
                                  <a class="btn btn-sm btn-outline-danger" onclick="sw_confirm2('確定要刪除嗎？連同底下的檔案一起刪除喔！！','delete{{ $type->id }}')">刪除</a>
                                </form>
                              </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>                                                        
                </div>
            </div>               
        </div>
    </div>
</section>
@endsection