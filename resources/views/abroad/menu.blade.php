<!--begin::Navs-->
<ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-3 py-5 {{ $menu == 'general' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Abroad\AbroadController::class, 'general'],
                [
                    'id' => $abroadApplication->id,
                ],
            ) }}">
            Thông tin chung
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-3 py-5  {{ $menu == 'pathway' ? 'active' : '' }}" href="">
            Xây dựng lộ trình
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-3 py-5  {{ $menu == 'abroad-application-school' ? 'active' : '' }}"
            href="">
            Xác định trường
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-3 py-5 {{ $menu == 'extracurricular-plan' ? 'active' : '' }}"
            href="">
            Kế hoạch ngoại khóa
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-3 py-5 {{ $menu == 'certifications' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Abroad\AbroadController::class, 'certifications'],
                [
                    'id' => $abroadApplication->id,
                ],
            ) }}">
            Chứng chỉ
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item
            mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-3 py-5 {{ $menu == 'extracurriculars' ? 'active' : '' }}"
            href="">
            Hoạt động ngoại khóa
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-3 py-5 {{ $menu == 'recommendation-letter' ? 'active' : '' }}"
            href="">
            Thư giới thiệu
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-3 py-5 {{ $menu == 'social-network' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Abroad\AbroadController::class, 'socialNetwork'],
                [
                    'id' => $abroadApplication->id,
                ],
            ) }}">
            Mạng xã hội
        </a>
    </li>
    <!--end::Nav item-->

    <!--begin::Nav item-->
    <li class="nav-item mt-2 px-2">
        <a class="nav-link text-active-primary ms-0 me-3 py-5 {{ $menu == 'essay' ? 'active' : '' }}"
            href="{{ action(
                [App\Http\Controllers\Abroad\AbroadController::class, 'essay'],
                [
                    'id' => $abroadApplication->id,
                ],
            ) }}">
            Bài luận
        </a>
    </li>
    <!--end::Nav item-->


</ul>
<!--begin::Navs-->
