<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold mb-3">
    <!--begin::Nav item-->
    <li class="nav-item mt-2 pe-2">
        <a class="nav-link text-active-primary ms-0  py-5 {{ $menu == 'edit' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\ProfileController::class, 'edit']) }}">
            Thông tin tài khoản
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 pe-2">
        <a class="nav-link text-active-primary ms-0  py-5 {{ $menu == 'changePassword' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\ProfileController::class, 'changePassword']) }}">
            Thay đổi mật khẩu
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 pe-2">
        <a class="nav-link text-active-primary ms-0  py-5 {{ $menu == 'notification' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\ProfileController::class, 'notification']) }}">
            Thông báo
        </a>
    </li>
    <!--end::Nav item-->

    <li class="nav-item mt-2 px-2 d-none">
        <a data-action="under-construction" class="nav-link text-active-primary ms-0  py-5 {{ $menu == 'activities' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\ProfileController::class, 'activities']) }}">
            Hoạt động</a>
    </li>
</ul>
<!--begin::Navs-->