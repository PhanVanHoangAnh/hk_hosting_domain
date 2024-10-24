<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">

     <!--begin::Nav item-->
     <li class="nav-item px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menusub == 'calendar' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\System\TeacherController::class, 'calendar'], [
                'id' => $teacher->id,
            ]) }}">
            Calendar</a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item px-2">
        <a  class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menusub == 'teachingSchedule' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\System\TeacherController::class, 'teachingSchedule'], [
                'id' => $teacher->id,
            ]) }}">
            Thời khóa biểu</a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item px-2">
        <a  class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menusub == 'busySchedule' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\System\TeacherController::class, 'showFreeTimeSchedule'], [
                'id' => $teacher->id,
            ]) }}">
            Lịch rảnh</a>
    </li>
    <!--end::Nav item-->
</ul>
<!--begin::Navs-->