<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'show' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Marketing\ContactController::class, 'show'],
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
        <a data-action="under-construction"
            class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'debt' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Marketing\ContactController::class, 'debt'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Thu chi
        </a>
    </li>
    <!--end::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a data-action="under-construction"
            class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'contract' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Marketing\ContactController::class, 'contract'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Hợp đồng
        </a>
    </li>

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a data-action="under-construction"
            class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'education' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Marketing\ContactController::class, 'education'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Đào tạo
        </a>
    </li>


    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a data-action="under-construction"
            class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'study-abroad' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Marketing\ContactController::class, 'studyAbroad'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Du học</a>
    </li>

    <li class="nav-item mt-2 px-2">
        <a data-action="under-construction"
            class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'extra-activity' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Marketing\ContactController::class, 'extraActivity'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Ngoại khóa</a>
    </li>

    <li class="nav-item mt-2 px-2">
        <a data-action="under-construction"
            class="nav-link text-active-primary ms-0 me-10 py-5 {{ $menu == 'kid-tech' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Marketing\ContactController::class, 'kidTech'],
                [
                    'id' => $contact->id,
                ],
            ) }}">
            Kidtech</a>
    </li>


    <!--end::Nav item-->
</ul>
<!--begin::Navs-->
