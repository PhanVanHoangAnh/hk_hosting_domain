<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mb-3">
    <li class="nav-item mt-2 pe-2">
        <a class="nav-link text-active-primary ms-0  py-5 {{ $menu == 'edit' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Teacher\ProfileController::class, 'edit']) }}">
            Thông tin tài khoản
        </a>
    </li>

  
    
    

    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0  py-5 {{ $menu == 'updatePassword' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Teacher\ProfileController::class, 'updatePassword']) }}">
            Cập nhật mật khẩu
        </a>
    </li>

    <li class="nav-item mt-2 px-2 ">
        <a data-action="under-construction" class="nav-link text-active-primary ms-0  py-5 {{ $menu == 'freetime' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Teacher\ProfileController::class, 'freetimes']) }}">
          Lịch rảnh
        </a>
    </li>
    
</ul>