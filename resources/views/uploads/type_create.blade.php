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
                            <a class="btn btn-outline-dark" href="{{ route('upload.type_index',$power) }}">返回上頁</a>
                        </div>                      
                    @endif
                @endauth 
                </div>
            </div>
            <div class="col-lg-4 mb-5 mb-lg-0">
            </div>
            <div class="col-lg-6 mb-5 mb-lg-0 mx-auto">
                <div class="row">                                       
                    <h2 class="section-title mb-3">{{ $power_item }}-新增類別</h2>
                    <form method="POST" action="{{ route('upload.type_store',$power) }}">
                        @csrf

                        <div class="mb-3">
                          <label for="order_by" class="form-label fw-bold">排序（可不填）</label>
                          <input type="number" class="form-control" name="order_by" id="order_by" placeholder="請輸入排序值">
                        </div>
                      
                        <div class="mb-3">
                          <label for="name" class="form-label fw-bold">名稱 <span class="text-danger">*</span></label>
                          <input type="text" class="form-control" name="name" id="name" required placeholder="請輸入名稱">
                        </div>
                      
                        <button type="submit" class="btn btn-primary btn-sm">送出</button>
                      </form>
                                                        
                </div>
            </div>               
        </div>
    </div>
</section>
@endsection