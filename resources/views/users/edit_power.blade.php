@extends('layouts.master_clean')

@section('title','修改權限')

@section('content')
<section class="section">
    <div class="container">
        <div class="row no-gutters-lg">
            <div class="col-lg-12 mb-5 mb-lg-0">
                <div class="row">
                    <h2 class="section-title mb-3">修改「{{ $user->name }}」權限</h2>
                    <form action="{{ route('user.update_power',$user->id) }}" method="post">                        
                          <!-- 第一組 -->                        
                            @csrf
                            <?php 
                                    $checked1 = ($user->admin==1)?"checked":null;
                                ?>
                            <div class="mb-3">
                                <label class="form-label fw-bold">身分權限</label>
                                <div class="form-check">                                
                                <input class="form-check-input" type="checkbox" id="adminCheck" name="admin" value="1" {{ $checked1 }}>
                                <label class="form-check-label" for="adminCheck">
                                    系統管理員(公告管理、帳號管理)
                                </label>
                                </div>
                            </div>
                            <?php                                     
                                    $checked['A'] = (strpos($user->power, 'A') !== false)?"checked":null;
                                    $checked['B'] = (strpos($user->power, 'B') !== false)?"checked":null;
                                    $checked['C'] = (strpos($user->power, 'C') !== false)?"checked":null;
                                    $checked['D'] = (strpos($user->power, 'D') !== false)?"checked":null;
                                    $checked['E'] = (strpos($user->power, 'E') !== false)?"checked":null;
                                    $checked['F']= (strpos($user->power, 'F') !== false)?"checked":null;                                    
                                    $checked['G'] = (strpos($user->power, 'G') !== false)?"checked":null;
                            ?>
                            <div class="mb-3">
                            <label class="form-label fw-bold">使用權限</label>
                                @foreach($power_items as $k=>$v)
                                  <div class="form-check">
                                    <input class="form-check-input power-check" type="checkbox" id="power{{ $k }}" name="power[]" value="{{ $k }}" {{ $checked[$k] }}>
                                    <label class="form-check-label" for="power{{ $k }}">{{ $v }}({{ $k }})</label>
                                  </div>
                                @endforeach                                
                            </div>
                        <button type="submit" class="btn btn-primary">儲存</button>
                    </form>                                                           
                </div>
            </div>            
        </div>
    </div>
</section>
@endsection

@section('my_js')
<script>
    const adminCheckbox = document.getElementById('adminCheck');
    const powerCheckboxes = document.querySelectorAll('.power-check');
  
    function updatePowerOnChange() {
      if (adminCheckbox.checked) {
        powerCheckboxes.forEach(cb => {
          cb.checked = true;
          cb.disabled = true;
        });
      } else {
        powerCheckboxes.forEach(cb => {
          cb.disabled = false;
          cb.checked = false;
        });
      }
    }
  
    function initPowerCheckboxes() {
      if (adminCheckbox.checked) {
        powerCheckboxes.forEach(cb => {
          cb.checked = true;
          cb.disabled = true;
        });
      }
      // 若 admin 沒打勾，不動作，保留原始狀態
    }
  
    // 使用者互動時執行
    adminCheckbox.addEventListener('change', updatePowerOnChange);
  
    // 初始載入執行
    window.addEventListener('DOMContentLoaded', initPowerCheckboxes);
  </script>
@endsection