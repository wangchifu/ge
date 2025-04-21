@extends('layouts.master')

@section('title','首頁')

@section('content')
<section class="section">
    <div class="container">
        <div class="row no-gutters-lg">
            <div class="col-lg-12 mb-5 mb-lg-0">
                <div class="row">
                    <h2 class="section-title mb-3">帳號登入</h2>
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 mx-auto">    
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                      <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">1.彰化 GSuite 登入</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <!--
                                       <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"></button>
                                        -->
                                       <a class="nav-link" href="{{ route('sso') }}">2.彰化縣雲端帳號登入</a>
                                    </li>
                                </ul>
                                <br>                            
                                <form method="POST" action="{{ route('gauth') }}" class="row">
                                    @csrf
                                    <div class="col-md-6">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control mb-4" placeholder="Gsuite 帳號" name="username" aria-label="Recipient's username" aria-describedby="basic-addon2" autofocus tabindex="1">
                                            <span class="input-group-text mb-4" id="basic-addon2">@chc.edu.tw</span>
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control mb-4" placeholder="密碼" name="password" id="password" tabindex="2">
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('glogin') }}"><img src="{{ route('pic') }}" class="img-fluid"></a><small class="text-secondary"> (按一下更換)</small>
                                        <input type="text" class="form-control mb-4" placeholder="上圖數字" name="chaptcha" id="chaptcha" maxlength="5" tabindex="3">
                                    </div>                                    
                                    <div class="col-12">
                                        <button class="btn btn-outline-primary" type="submit" tabindex="4">送出</button>
                                    </div>
                                </form>
                                @include('layouts.errors')        
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
        </div>
    </div>
</section>
@endsection