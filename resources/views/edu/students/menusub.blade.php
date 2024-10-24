<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">

     <!--begin::Nav item-->
     <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menusub == 'calendar' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Edu\StudentController::class, 'calendar'], [
                'id' => $contact->id,
            ]) }}">
            Calendar</a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a  class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menusub == 'section' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Edu\StudentController::class, 'section'], [
                'id' => $contact->id,
            ]) }}">
            Thời khóa biểu</a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a  class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menusub == 'freetime' ? 'active' : ''}}" href="{{ action([App\Http\Controllers\Edu\StudentController::class, 'showFreeTimeSchedule'], [
                'id' => $contact->id,
            ]) }}">
            Lịch rảnh</a>
    </li>
    <!--end::Nav item-->
</ul>
<!--begin::Navs-->