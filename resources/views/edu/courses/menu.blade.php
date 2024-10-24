<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'showDetail' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'showDetail'], [
                'id' => $course->id,
            ]) }}">
            Thông tin cơ bản
        </a>
    </li>
    <!--end::Nav item-->

     <!--begin::Nav item-->
     <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'students' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'students'], [
                'id' => $course->id,
            ]) }}">
            Học viên
        </a>
    </li>
    <!--end::Nav item-->

     <!--begin::Nav item-->
     <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'schedule' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'schedule'], [
                'id' => $course->id,
            ]) }}">
            Calendar
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'sections' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'sections'], [
                'id' => $course->id,
            ]) }}">
            Thời khóa biểu
        </a>
    </li>
    <!--end::Nav item-->
</ul>
<!--begin::Navs-->