<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'show' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'show'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Thông tin chung
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'class' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'class'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Lớp học
        </a>
    </li>

    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'schedule' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'section'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Thời khóa biểu</a>
    </li>

    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'refund' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'refund'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Yêu cầu hoàn phí</a>
    </li>

    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'reserveStudentDetail' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'reserveStudentDetail'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Bảo lưu</a>
    </li>

    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'transferStudentDetail' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'transferStudentDetail'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Chuyển phí</a>
    </li>



    <li class="nav-item mt-2 px-2 d-none">
        <a data-action="under-construction"
            class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'contract' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'contract'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Hợp đồng
        </a>
    </li>

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2 d-none">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'note-logs' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'noteLog'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Ghi chú</a>
    </li>


    <!--end::Nav item-->

    <li class="nav-item mt-2 px-2 d-none">
        <a data-action="under-construction"
            class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'extra-activity' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'extraActivity'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Ngoại khóa</a>
    </li>


    <li class="nav-item mt-2 px-2 d-none">
        <a data-action="under-construction"
            class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'kid-tech' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Edu\StudentController::class, 'kidTech'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Kidtech</a>
    </li>


    <!--end::Nav item-->

</ul>
<!--begin::Navs-->
