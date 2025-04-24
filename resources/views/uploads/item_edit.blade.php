@extends('layouts.master')

@section('title','編輯項目')

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
                    @endif
                @endauth 
                </div>
            </div>
            <div class="col-lg-4 mb-5 mb-lg-0">
            </div>
            <div class="col-lg-6 mb-5 mb-lg-0 mx-auto">
                <div class="row">                                       
                    <h2 class="section-title mb-3">{{ $power_item }}-新增項目</h2>
                    <form action="{{ route('upload.item_update',$upload->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="order_by" class="form-label fw-bold">排序（可不填）</label>
                        <input type="number" class="form-control" name="order_by" value="{{ $upload->order_by }}" id="order_by" placeholder="請輸入排序值">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label fw-bold">分類（不可改）</label>
                        <select name="type_id" id="type_id" class="form-select" disabled>
                          @foreach ($type_select as $key => $label)
                            <?php $selected = ($upload->type_id == $key)?"selected":null; ?>
                            <option value="{{ $key }}" {{ $selected }}>{{ $label }}</option>
                          @endforeach
                        </select>
                    </div>
                    
                    @if($power == "D")
                        <div class="mb-3">
                            <label for="files" class="form-label fw-bold">網站截圖（不可改）</label><br>
                            <img src="{{ asset('storage/uploads/'.$power.'/'.$upload->type_id.'/'.$upload->name) }}" width="100">
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">網站名稱 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="sitename" value="{{ $upload->sitename }}" id="sitename" required placeholder="請輸入網站名稱">
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label fw-bold">網址</label>
                            <input type="text" class="form-control" name="url" value="{{ $upload->url }}" id="url" placeholder="請輸入網址 含 https://" required>
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="files" class="form-label fw-bold">上傳檔案(不可改) </label><br>
                            {{ $upload->name }}
                        </div>
                    @endif                    
                    
                    <button type="submit" class="btn btn-primary">更新</button>
                    </form>                                                        
                </div>
            </div>               
        </div>
    </div>
</section>
@endsection