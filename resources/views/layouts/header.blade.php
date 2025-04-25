<header class="navigation">
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light px-0">
        <a class="navbar-brand order-1 py-0" href="{{ route('index') }}">
          <img loading="prelaod" decoding="async" class="img-fluid" src="{{ asset('images/logo.png') }}" alt="Reporter Hugo">
        </a>
        <div class="navbar-actions order-3 ml-0 ml-md-4">
          <button aria-label="navbar toggler" class="navbar-toggler border-0" type="button" data-toggle="collapse"
            data-target="#navigation"> <span class="navbar-toggler-icon"></span>
          </button>
        </div>        
        <div class="collapse navbar-collapse text-center order-lg-2 order-4" id="navigation">
          <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
            <li class="nav-item"> <a class="nav-link" href="{{ route('upload.index','A') }}">相關表單</a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('upload.index','B') }}">案例分享</a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('upload.index','C') }}">專業人才庫</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    性平媒材
                </a>
              <div class="dropdown-menu"> 
                <?php
                  $types = \App\Models\Type::where('power','D')->orderBy('order_by')->get();
                ?>
                @foreach($types as $type)
                  <a class="dropdown-item" href="{{ route('upload.index',['power'=>'D','type_id'=>$type->id]) }}">{{ $type->name }}</a>
                @endforeach                
              </div>
            </li>
            
            <li class="nav-item"> <a class="nav-link" href="{{ route('upload.index','E') }}">友站連結</a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('upload.index','F') }}">相關法規</a>
            </li>
            <li class="nav-item"> <a class="nav-link" href="{{ route('upload.index','G') }}">資源分享</a>
            </li>          
            @guest  
            <li class="nav-item"> <a class="nav-link" href="{{ route('glogin') }}">登入</a>
            </li>
            @endguest
            @auth
              <li class="nav-item"> <a class="nav-link" href="#!" onclick="sw_confirm1('確定登出？','{{ route('logout') }}')">{{ auth()->user()->name }} 登出</a>
              </li>
            @endauth
          </ul>
        </div>
      </nav>
    </div>
</header>