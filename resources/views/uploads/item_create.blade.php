@extends('layouts.master')

@section('title','新增類別')

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
                    <form action="{{ route('upload.item_store',$power) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="order_by" class="form-label">排序（可不填）</label>
                        <input type="number" class="form-control" name="order_by" id="order_by" placeholder="請輸入排序值">
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">分類</label>
                        <select name="type_id" id="type_id" class="form-select">
                          @foreach ($type_select as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                          @endforeach
                        </select>
                    </div>
                    
                    @if($power == "D")
                        <div class="mb-3">
                            <label for="files" class="form-label">上傳網站截圖（單選）</label>
                            <input accept="image/*" class="form-control" type="file" name="files[]" id="files" required>
                        </div>

                        <div class="mb-3">
                            <label for="name" class="form-label">網站名稱 <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="sitename" id="sitename" required placeholder="請輸入網站名稱">
                        </div>

                        <div class="mb-3">
                            <label for="url" class="form-label">網址</label>
                            <input type="text" class="form-control" name="url" id="url" placeholder="請輸入網址 含 https://" required>
                        </div>
                    @else
                        <div class="mb-3">
                            <label for="files" class="form-label">上傳檔案（可多選）</label>
                            <input class="form-control" type="file" name="files[]" id="files" multiple required>
                        </div>
                    @endif                    
                    
                    <button type="submit" class="btn btn-primary">上傳</button>
                    </form>                                                        
                </div>
            </div>               
        </div>
    </div>
</section>
@endsection