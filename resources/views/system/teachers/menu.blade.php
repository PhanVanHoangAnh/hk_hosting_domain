<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2 d-none">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'show' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\System\TeacherController::class, 'show'], [
                'id' => $teacher->id,
            ]) }}">
            Thông tin chung
        </a>
    </li>
    <!--end::Nav item-->

     <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5  {{ $menu == 'class' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\System\TeacherController::class, 'class'], [
                'id' => $teacher->id,
            ]) }}">
           Lớp học
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{$courses->isNotEmpty() ? 'd-none': ''}} {{ $menu == 'schedule' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\System\TeacherController::class, 'teachingSchedule'], [
                'id' => $teacher->id,
            ]) }}">
            Lịch dạy
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a  data-action="under-construction" class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'salarySheet' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\System\TeacherController::class, 'salarySheet'], [
                'id' => $teacher->id,
            ]) }}">
            Bảng lương
        </a>
    </li>
    <!--end::Nav item-->

     <!--begin::Nav item-->
     <li class="nav-item mt-2 px-2 d-none">
        <a  data-action="under-construction"  class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'expenseHistory' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\System\TeacherController::class, 'expenseHistory'], [
                'id' => $teacher->id,
            ]) }}">
           Lịch sử chi
        </a>
    </li>
    <!--end::Nav item-->

</ul>
<!--begin::Navs-->