<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
    <li class="nav-item px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'calendar' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Student\SectionController::class, 'calendar']) }}">
            Lịch
        </a>
    </li>
    <li class="nav-item px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'list' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Student\SectionController::class, 'index']) }}">
            Thời khóa biểu
        </a>
    </li>
</ul>