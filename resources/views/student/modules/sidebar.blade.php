@php
    $menu = $menu ?? null;
    $sidebar = $sidebar ?? null;
@endphp

<button id="kt_aside_show" class="aside-toggle btn btn-sm btn-icon border end-0 bottom-0 d-lg-flex rounded bg-white"
    data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">
    <i class="ki-duotone ki-arrow-left fs-2 rotate-180"><span class="path1"></span><span class="path2"></span></i>
</button>
<div id="kt_aside" class="aside aside-extended pe-3" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">

    <!--begin::Primary-->
    <div class="aside-primary d-flex flex-column align-items-lg-end flex-row-auto pt-2">
        <!--begin::Nav-->
        <div class="aside-nav border-end-dashed d-flex flex-column align-items-center flex-column-fluid w-100 pt-5 pt-lg-0 border-gray-300"
            style="border-width: 1px;" id="kt_aside_nav">

            <!--begin::Wrapper-->
            <div class="hover-scroll-overlay-y mb-5 h-100" data-kt-scroll="true"
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto">
                <!--begin::Nav-->

                <ul class="nav flex-column w-100 pe-3" id="kt_aside_nav_tabs" role="tablist">
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Student\DashboardController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'dashboard' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Dashboard" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                dashboard
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Dashboard 
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Hợp đồng" data-bs-original-title="Hợp đồng" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\Student\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL], ['type' => App\Models\Order::TYPE_GENERAL]) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'orders' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Hợp đồng" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                order_approve
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Hợp đồng
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Thời khóa biểu"
                        data-bs-original-title="Thời khóa biểu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Student\SectionController::class, 'calendar']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'sections' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Thời khóa biểu" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                calendar_month
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    T.K.Biểu
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Quản lý đào tạo"
                        data-bs-original-title="Quản lý đào tạo" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Student\CourseController2::class, 'class'], ['title' => 'class']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'courses' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Quản lý đào tạo" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                school
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Đào tạo
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Quản lý hoạt động ngoại khóa"
                        data-bs-original-title="Ngoại khóa" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Student\ExtracurricularController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'extracurricular' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Ngoại khóa" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                directions_run
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Ngoại khóa
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Du học"
                        data-bs-original-title="Du học" data-kt-initialized="1">
                        <a href="{{ action(
                            [App\Http\Controllers\Student\AbroadApplicationController::class, 'detail'],
                        ) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'abroad-application' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Du học"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                send_money
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Du học
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label=" Học phí" data-bs-original-title="Học phí" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Student\PaymentReminderController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'payment_reminder' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Học phí"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                paid
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Học phí
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Tài khoản của tôi" data-bs-original-title="Tài khoản của tôi" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Student\ProfileController::class, 'edit']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'profile' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Tài khoản của tôi"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                assignment_ind
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Tài khoản
                                </span>
                            </div>
                        </a>
                    </li>

                    {{-- <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Báo cáo kết quả học tập" data-bs-original-title="Báo cáo kết quả học tập" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Student\Report\TeacherHourReportController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'reporting' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Báo cáo kết quả học tập" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1" data-action="under-construction">
                            <span class="material-symbols-rounded fs-3x d-block">
                                monitoring
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Báo cáo
                                </span>
                            </div>
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>

    <div class="aside-secondary d-flex flex-row-fluid w-lg-230px {{ $menu == 'dashboard' || $menu == 'profile'? 'd-none' : '' }}">
        <!--begin::Workspace-->
        <div class="aside-workspace mb-5" id="kt_aside_wordspace" style="width:100%">
            <div class="d-flex h-100 flex-column">
                <!--begin::Wrapper-->
                <div class="flex-column-fluid hover-scroll-y h-100" data-kt-scroll="true"
                    data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                    data-kt-scroll-wrappers="#kt_aside_wordspace"
                    data-ktscroll-dependencies="#kt_aside_secondary_footer" data-kt-scroll-offset="0px"
                    style="height: 100vh; scrollbar-width: 40px;">

                    {{-- EDU --}}
                    <div class="tab-content">
                        <!--START::CONTACT-->
                        <div class="tab-pane fade {{ $menu == 'courses' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Quản lý đào tạo
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="menu-item menu-accordion">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng thái</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div id="status-accordion"
                                                class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'courses' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Student\CourseController2::class, 'class'], ['title' => 'class']) }}"
                                                        class="menu-link {{ request()->title == 'class' ? 'active' : '' }}">
                                                        <span class="menu-title">Lớp học</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="19-00"> {{ App\Models\Contact::whichHasCousrse(Auth::user()->getStudent()->id) }}
                                                            </span>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Student\CourseController2::class, 'refund'], ['title' => 'refund']) }}"
                                                        class="menu-link {{ request()->title == 'refund' ? 'active' : '' }} ">
                                                        <span class="menu-title">Yêu cầu hoàn phí</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="16-1">{{ request()->ajax() ? App\Models\RefundRequest::where('student_id',Auth::user()->getStudent()->id)->count() : ''  }}
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\CourseController2::class, 'reserveStudent'],
                                                        [
                                                            'title' => 'reserveStudent',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->title == 'reserveStudent' ? 'active' : '' }}">
                                                        <span class="menu-title">Bảo lưu</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="16-2">{{ request()->ajax() ? App\Models\Reserve::where('student_id',Auth::user()->getStudent()->id)->count() : ''  }}
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\CourseController2::class, 'transfer'],
                                                        [
                                                            'title' => 'transfer',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'courses' && request()->title == 'transfer' ? 'active' : '' }}">
                                                        <span class="menu-title">Chuyển phí</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="16-3">{{ request()->ajax() ? App\Models\Course::getIsUnstudied()->count() : ''  }}
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\CourseController2::class, 'reportsection'],
                                                        [
                                                            'title' => 'reportsection',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'courses' && request()->title == 'reportsection' ? 'active' : '' }}">
                                                        <span class="menu-title">Báo cáo học tập</span>
                                                        
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- EXTRACURRICULAR --}}
                    <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'extracurricular' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Quản lý HĐNK
                                                </span>
                                            </span>

                                            <div class="menu-item menu-accordion">
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#as-extras">
                                                    <span class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                        HĐNK tại AS
                                                    </span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <div id="as-extras" class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'extracurricular' ? 'show' : '' }}">
                                                    <div class="menu-item">
                                                        <a href="{{ action([App\Http\Controllers\Student\ExtracurricularController::class, 'index']) }}"
                                                            class="menu-link py-3 {{ $sidebar == 'extracurricular' && !isset($filter) ? ' active' : '' }}">
                                                            <span class="ps-5 menu-title {{ $sidebar == 'extracurricular' && !isset($filter) ? '' : 'fw-light' }}">
                                                                Tất cả
                                                            </span>
                                                            <span class="menu-badge" sidebar-counter="16-4">
                                                                {{ App\Models\Extracurricular::count() }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="menu-item menu-accordion">
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#student-extras">
                                                    <span class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                        HĐNK của bạn
                                                    </span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <div id="student-extras" class="accordion-collapse">
                                                    <div class="menu-item">
                                                        <a href="{{ action([App\Http\Controllers\Student\ExtracurricularController::class, 'index'], [
                                                            'filter' => \App\Models\Extracurricular::FILTER_KEY_REGISTED
                                                        ]) }}"
                                                            class="menu-link py-3 {{ $sidebar == 'extracurricular' && isset($filter) && $filter == \App\Models\Extracurricular::FILTER_KEY_REGISTED ? ' active' : '' }}">
                                                            <span class="ps-5 menu-title {{ $sidebar == 'extracurricular' && isset($filter) && $filter == \App\Models\Extracurricular::FILTER_KEY_REGISTED ? '' : 'fw-light' }}">
                                                                Đã đăng ký (Chưa diễn ra)
                                                            </span>
                                                            <span class="menu-badge" sidebar-counter="16-5">
                                                                {{ request()->ajax() ? App\Models\Extracurricular::filterByStudent(\Auth::user()->getStudent())->haventHappenedYet()->count() : ''  }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div id="student-extras" class="accordion-collapse">
                                                    <div class="menu-item">
                                                        <a href="{{ action([App\Http\Controllers\Student\ExtracurricularController::class, 'index'], [
                                                            'filter' => \App\Models\Extracurricular::FILTER_KEY_DONE
                                                        ]) }}"
                                                            class="menu-link py-3 {{ $sidebar == 'extracurricular' && isset($filter) && $filter == \App\Models\Extracurricular::FILTER_KEY_DONE ? ' active' : '' }}">
                                                            <span class="ps-5 menu-title {{ $sidebar == 'extracurricular' && isset($filter) && $filter == \App\Models\Extracurricular::FILTER_KEY_DONE ? '' : 'fw-light' }}">
                                                                Đã hoàn thành
                                                            </span>
                                                            <span class="menu-badge" sidebar-counter="16-6">
                                                                {{ request()->ajax() ? App\Models\Extracurricular::filterByStudent(\Auth::user()->getStudent())->done()->count() : ''  }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab pane-->
                        <div class="tab-pane fade  {{ $menu == 'contact' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <!--begin::Items-->
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ $menu == 'contact' ? ' show' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Liên hệ
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse {{ $menu == 'contact' ? ' hover show' : '' }}">
                                                <div data-is-nav="nav" data-nav="add-customer" class="menu-item">
                                                    <a class="menu-link py-3" id="addContactSearch">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                person_add
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Thêm liên hệ</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Student\ContactController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $menu == 'contact' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                contacts
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Liên hệ</span></a>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--BEGIN::Trạng thái-->
                                        <div>
                                            <div class="menu-item menu-accordion show">
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#status-accordion">
                                                    <span
                                                        class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng thái</span>
                                                    <span
                                                        class="menu-arrow {{ request()->status || $menu == 'customer' ? ' rotate' : '' }}"></span>
                                                </span>
                                                <div id="status-accordion" class="accordion-collapse collapse show">
                                                    <!--begin::Menu items-->
                                                    <div class="menu-item">
                                                        <a href="{{ action([App\Http\Controllers\Student\ContactController::class, 'index']) }}"
                                                            class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                            <span class="menu-title">Đang hoạt động</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="16-7">{{ Auth::user()->account->contacts()->active()->isNotCustomer()->count() }}</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu items-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Student\ContactController::class, 'index'],
                                                            [
                                                                'status' => 'deleted',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                            <span class="menu-title">Đã xóa</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="16-8">{{ Auth::user()->account->contacts()->isDeleted()->count() }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--END::Trạng thái-->
                                    </div>
                                </div>
                                <!--end::Menu-->
                            </div>
                            <!--end::Items-->
                        </div>

                        <!--END::CONTACT-->

                        <!--START::CUSTOMER-->
                        <div class="tab-pane fade  {{ $menu == 'customer' || $sidebar == 'note-logs' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_customers" role="tabpanel">
                            <!--begin::Items-->

                            <!--begin::Item-->
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ $menu == 'customer' || $sidebar == 'note-logs' ? ' show' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Khách hàng
                                                </span>
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>

                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse {{ $menu == 'customer' || $sidebar == 'note-logs' ? ' hover show' : '' }}">

                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Student\CustomerController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $menu == 'customer' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                group
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Khách hàng</span></a>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>

                                                <div
                                                    class="menu-item menu-accordion {{ $sidebar == 'note-logs' ? 'hover show' : '' }}">
                                                    <!--begin:Menu link-->
                                                    <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                        data-bs-target="#note-log-accordion">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                event_note
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Ghi chú</span>
                                                        <span
                                                            class="menu-arrow {{ $sidebar == 'note-logs' ? ' rotate ' : '' }}"></span>
                                                    </span>

                                                    <!--end:Menu link-->
                                                    <!--begin:Menu sub-->
                                                    <div id="note-log-accordion"
                                                        class="accordion-collapse collapse {{ $sidebar == 'note-logs' ? ' hover show' : '' }}">
                                                        <!--begin:Menu item-->
                                                        <div class="menu-item ps-10">
                                                            <!--begin:Menu link-->
                                                            <a class="menu-link {{ $sidebar == 'note-logs' ? ' active' : '' }}"
                                                                href="{{ action([App\Http\Controllers\Student\NoteLogController::class, 'index']) }}">
                                                                <span class="menu-title">Danh sách</span>
                                                            </a>
                                                            <!--end:Menu link-->
                                                        </div>
                                                        <!--end:Menu item-->
                                                        <!--begin:Menu item-->
                                                        <div class="menu-item ps-10">
                                                            <!--begin:Menu link-->
                                                            <a class="menu-link" id="addNoteLogSlideBar"
                                                                href="{{ action([App\Http\Controllers\Student\NoteLogController::class, 'create']) }}">
                                                                <span class="menu-title">Thêm mới</span></a>
                                                            <!--end:Menu link-->
                                                        </div>
                                                        <!--end:Menu item-->
                                                        <!--begin:Menu item-->
                                                        <div class="menu-item ps-10">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\NoteLogController::class, 'index'],
                                                                [
                                                                    'status' => 'deleted',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ $sidebar == 'note-logss' ? 'active' : '' }}">
                                                                <span class="menu-title">Đã xóa</span>
                                                                <span>{{ request()->ajax() ? App\Models\NoteLog::isDeleted()->count() : ''  }}</span></a>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <!--end:Menu sub-->
                                                </div>

                                                <!--BEGIN::Trạng thái-->
                                                <div class="d-none">
                                                    <div class="menu-item menu-accordion show">
                                                        <span class="accordion-button menu-link"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#status-accordion">
                                                            <span
                                                                class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                                thái</span>
                                                            <span
                                                                class="menu-arrow {{ request()->status || $menu == 'customer' ? ' rotate' : '' }}"></span>
                                                        </span>
                                                        <div id="status-accordion"
                                                            class="accordion-collapse collapse show">
                                                            <!--begin::Menu items-->
                                                            <div class="menu-item">
                                                                <a href="{{ action([App\Http\Controllers\Student\CustomerController::class, 'index']) }}"
                                                                    class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                    <span class="menu-title">Đang hoạt động</span>
                                                                    <span
                                                                        class="menu-badge" sidebar-counter="16-9">{{ Auth::user()->account->customers()->active()->count() }}</span>
                                                                </a>
                                                            </div>
                                                            <!--end::Menu items-->

                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Student\CustomerController::class, 'index'],
                                                                    [
                                                                        'status' => 'deleted',
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                                    <span class="menu-title">Đã xóa</span>
                                                                    <span
                                                                        class="menu-badge" sidebar-counter="17-1">{{ Auth::user()->account->customers()->isDeleted()->count() }}</span>
                                                                </a>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                                <!--END::Trạng thái-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Menu-->
                            </div>

                            <!--end::Items-->

                        </div>
                        <!--END::CUSTOMER-->

                        <div class="tab-pane fade {{ $menu == 'payment_reminder' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contracts" role="tabpanel">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-5 pe-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">

                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div class="menu-item">
                                        <!--begin:Menu content-->
                                        <span class="accordion-button menu-link ms-4" data-bs-toggle="collapse"
                                            data-bs-target="#category-accordion">
                                            <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                Học phí
                                            </span>
                                            {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                        </span>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a
                                                    class="menu-link py-3  {{ $sidebar == 'payment_reminder' ? 'active ' : '' }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            assignment
                                                        </span>

                                                    </span>
                                                    <span class="menu-title">Danh sách</span></a>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>


                                            <!--BEGIN::Trạng thái-->
                                            <div>
                                                <div class="menu-item menu-accordion show">
                                                    <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                        data-bs-target="#status-accordion">
                                                        <span
                                                            class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                            thái</span>
                                                    </span>
                                                    <div id="status-accordion"
                                                        class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Student\PaymentReminderController::class, 'index']) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span class="menu-badge" sidebar-counter="17-2">
                                                                    {{ Auth::user()->getStudent()->paymentRemindersOfStudent()->count() }}</span>
                                                            </a>
                                                        </div>


                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\PaymentReminderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentReminder::STATUS_REACHING_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentReminder::STATUS_REACHING_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.reaching_due_date') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="17-3">{{ Auth::user()->getStudent()->paymentRemindersOfStudent()->reachingDueDate()->checkIsNotPaid()->count() }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\PaymentReminderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentReminder::STATUS_OVER_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentReminder::STATUS_OVER_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.over_due_date') }}</span>
                                                                @if (request()->ajax() && App\Models\PaymentReminder::approved()->overDueDate()->checkIsNotPaid()->count() )
                                                                    <span
                                                                        class="badge badge-danger">{{ Auth::user()->getStudent()->paymentRemindersOfStudent()->overDueDate()->checkIsNotPaid()->count() }}</span>
                                                                @else
                                                                    0
                                                                @endif


                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\PaymentReminderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentReminder::STATUS_PART_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentReminder::STATUS_PART_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.part_paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="17-4">{{ Auth::user()->getStudent()->paymentRemindersOfStudent()->partPaid()->checkIsNotPaid()->count() }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\PaymentReminderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentReminder::STATUS_IS_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentReminder::STATUS_IS_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="17-5">{{ Auth::user()->getStudent()->paymentRemindersOfStudent()->checkIsPaid()->count() }}</span>
                                                            </a>
                                                        </div>



                                                        <!--end::Menu items-->

                                                    </div>

                                                </div>
                                            </div>
                                            <!--END::Trạng thái-->

                                        </div>
                                        <!--end:Menu content-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!--START::ORDER-->
                        <div class="tab-pane fade {{ $menu == 'orders' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_orders" role="tabpanel">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-5 pe-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">

                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div class="menu-item">
                                        <!--begin:Menu content-->
                                        <span class="accordion-button menu-link ms-4" data-bs-toggle="collapse"
                                            data-bs-target="#category-accordion">
                                            <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                {{ isset($order->type) && $order->type == App\Models\Order::TYPE_REQUEST_DEMO
                                                    ? 'yêu cầu học thử'
                                                    : (isset($screenType) && $screenType == App\Models\Order::TYPE_REQUEST_DEMO
                                                        ? 'yêu cầu học thử'
                                                        : 'hợp đồng') }}
                                            </span>
                                        </span>
                                        <div>
                                            <div class="menu-item d-none">
                                                <!--begin:Menu link-->
                                                <a href="{{ action([App\Http\Controllers\Student\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL]) }}"
                                                    class="menu-link py-3  {{ $sidebar == 'orders' ? 'active ' : '' }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            assignment
                                                        </span>

                                                    </span>
                                                    <span class="menu-title">Danh sách</span></a>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <div list-action="{{ isset($order->type) && $order->type == App\Models\Order::TYPE_REQUEST_DEMO
                                                ? 'add-request-demo'
                                                : (isset($screenType) && $screenType == App\Models\Order::TYPE_REQUEST_DEMO
                                                    ? 'add-request-demo'
                                                    : 'create-constract') }}"
                                                data-is-nav="nav" data-nav="add-contract" class="menu-item d-none">
                                                <a class="menu-link py-3 {{ $sidebar == 'create_constract' ? 'active ' : '' }}"
                                                    id="addContractSlideBar">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            assignment_add
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">Thêm hợp đồng</span>
                                                </a>
                                            </div>

                                            <!--BEGIN::Trạng thái-->
                                            <div>
                                                <div class="menu-item menu-accordion show">
                                                    <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                        data-bs-target="#status-accordion">
                                                        <span class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng thái hợp đồng</span>
                                                    </span>
                                                    <div id="status-accordion"
                                                        class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Student\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL], ['type' => App\Models\Order::TYPE_GENERAL]) }}"
                                                                class="menu-link">
                                                                <span class="menu-title">Số lượng hợp đồng</span>
                                                                <span class="menu-badge" sidebar-counter="17-6">{{ Auth::user()->getStudent()->signedOrStudentOfOrders()->approved()->count() }}</span>
                                                            </a>
                                                        </div>

                                                        {{-- <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_GENERAL,
                                                                    'status' => 'draft',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'draft' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.draft') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="17-7">{{ Auth::user()->account->saleOrders()->notDeleted()->draft()->count() }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_GENERAL,
                                                                    'status' => 'pending',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'pending' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.pending') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="17-8">{{ Auth::user()->account->saleOrders()->notDeleted()->pending()->count() }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_GENERAL,
                                                                    'status' => App\Models\Order::STATUS_APPROVED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_APPROVED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.approved') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="17-9">{{ Auth::user()->account->saleOrders()->notDeleted()->approved()->count() }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_GENERAL,
                                                                    'status' => App\Models\Order::STATUS_DELETED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_DELETED ? 'active' : '' }}">
                                                                <span class="menu-title">Đã xóa</span>
                                                                <span class="menu-badge" sidebar-counter="18-1">
                                                                    {{ Auth::user()->account->saleOrders()->deleted()->count() }}
                                                                </span>

                                                            </a>
                                                        </div>
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_GENERAL,
                                                                    'status' => 'rejected',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'rejected' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.rejected') }}</span>

                                                                <span class="menu-badge" sidebar-counter="18-2">
                                                                    @if (Auth::user()->account->saleOrders()->notDeleted()->rejected()->count())
                                                                        <span
                                                                            class="badge badge-danger">{{ Auth::user()->account->saleOrders()->notDeleted()->rejected()->count() }}</span>
                                                                    @else
                                                                        0
                                                                    @endif
                                                                </span>
                                                            </a>
                                                        </div> --}}
                                                        <!--end::Menu items-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END::Trạng thái-->


                                            <!--BEGIN::Công nợ-->
                                            <div>
                                                <div class="menu-item menu-accordion show">
                                                    <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                        data-bs-target="#status-accordion">
                                                        <span
                                                            class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Công nợ</span>
                                                    </span>
                                                    <div id="status-accordion"
                                                        class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_GENERAL,
                                                                    'status' => App\Models\Order::STATUS_REACHING_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_REACHING_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.reaching_due_date') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="18-3">{{ Auth::user()->getStudent()->signedOrStudentOfOrders()->approved()->reachingDueDate()->checkIsNotPaid()->count() }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_GENERAL,
                                                                    'status' => App\Models\Order::STATUS_PART_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_PART_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.part_paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="18-4">{{ Auth::user()->getStudent()->signedOrStudentOfOrders()->approved()->partPaid()->checkIsNotPaid()->count() }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_GENERAL,
                                                                    'status' => App\Models\Order::STATUS_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="18-5">{{ Auth::user()->getStudent()->signedOrStudentOfOrders()->approved()->checkIsPaid()->count() }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_GENERAL,
                                                                    'status' => App\Models\Order::STATUS_OVER_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_OVER_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.over_due_date') }}</span>

                                                                @if (Auth::user()->account->saleOrders()->notDeleted()->approved()->overDueDate()->checkIsNotPaid()->count())
                                                                    <span
                                                                        class="badge badge-danger">{{ Auth::user()->getStudent()->signedOrStudentOfOrders()->approved()->overDueDate()->checkIsNotPaid()->count() }}</span>
                                                                @else
                                                                    0
                                                                @endif

                                                            </a>
                                                        </div>
                                                        <!--end::Menu items-->

                                                    </div>

                                                </div>
                                            </div>
                                            <!--END::Công nợ-->

                                        </div>
                                        <!--end:Menu content-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--END::ORDER -->

                        <!--START::Dự thu-->

                        <div class="tab-pane fade  {{ $menu == 'accountKpiNote' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <!--begin::Items-->

                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ $menu == 'accountKpiNote' ? ' show' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Quản lý dự thu
                                                </span>
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse {{ $menu == 'accountKpiNote' ? ' hover show' : '' }}">

                                                <div data-is-nav="nav" data-nav="add-customer" class="menu-item">
                                                    <a class="menu-link py-3" id="addAccountKpiNote">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                lab_profile
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Thêm dự thu</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Student\ContactController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $menu == 'accountKpiNote' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                contacts
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Dự thu</span></a>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <!--end::Menu-->
                            </div>

                            <!--end::Items-->

                        </div>

                        <!--END::Dự thu-->
                    </div>
                    <!--end::Tab content-->

                    <div class="tab-content">
                        <!--START::CONTACT-->
                        <div class="tab-pane fade {{ $menu == 'abroad-application' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Tài khoản học viên
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">

                                                <div data-is-nav="nav" data-nav="abroad-application"
                                                    class="menu-item">
                                                    <a href="javascript:;"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'new' ? ' active' : '' }}"
                                                        id="allAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                stacks
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Xem chi tiết</span>
                                                    </a>
                                                </div>

                                                <div data-is-nav="nav" data-nav="waiting-abroad-application"
                                                    class="menu-item d-none">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\AbroadController::class, 'index'],
                                                        [
                                                            'status' => 'waiting',
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'waiting' ? ' active' : '' }}" id="">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                hourglass
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Chờ duyệt</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="18-6">
                                                            {{-- {{ request()->ajax() ? App\Models\AbroadApplication::filterByWaiting()->count() : ''  }} --}}
                                                        </span>
                                                    </a>
                                                </div>

                                                <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                    class="menu-item d-none">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\AbroadController::class, 'index'],
                                                        [
                                                            'status' => 'assigned',
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'assigned' ? ' active' : '' }}"
                                                        id="assignedAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                done_outline
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Bàn giao</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="18-7">
                                                            {{-- {{ request()->ajax() ? App\Models\AbroadApplication::filterByAssigned()->count() : ''  }} --}}
                                                        </span>
                                                    </a>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'sections' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Thời khoá biểu
                                                </span>
                                            </span>
                                            <div id="category-accordion-" class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Student\SectionController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sections' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Danh sách</span></a>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="menu-item menu-accordion">
                                            @php
                                                $currContact = Auth()->user()->getStudent();
                                                $sectionStudents = \App\Models\StudentSection::where('student_id', $currContact->id)->get();
                                                $sectionIds = $sectionStudents->pluck('section_id')->toArray();
                                            @endphp

                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Loại hình thời khóa biểu</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div id="status-accordion" class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'sections' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Student\SectionController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả </span>
                                                        <span class="menu-badge" sidebar-counter="18-8">{{ \request()->ajax() ? App\Models\Section::whereIn('id', $sectionIds)->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_NOT_ACTIVE,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_NOT_ACTIVE ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa học</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="18-9">{{ \request()->ajax() ? App\Models\Section::whereIn('id', $sectionIds)->notStudyYet()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_ACTIVE,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_ACTIVE ? 'active' : '' }}">
                                                        <span class="menu-title">Đang học</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="19-1">{{ \request()->ajax() ? App\Models\Section::whereIn('id', $sectionIds)->learning()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::COMPLETED_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::COMPLETED_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Đã học</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="19-2"> {{ \request()->ajax() ? App\Models\Section::whereIn('id', $sectionIds)->studied()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_DESTROY,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_DESTROY ? 'active' : '' }}">
                                                        <span class="menu-title">Đã hủy</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="19-3">{{ \request()->ajax() ? App\Models\Section::whereIn('id', $sectionIds)->isDestroy()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Student\SectionController::class, 'index'],
                                                        [
                                                            'status' => 'absent',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == 'absent' ? 'active' : '' }}">
                                                        <span class="menu-title">Xin phép vắng </span>
                                                        <span
                                                            class="badge badge-danger">{{ \request()->ajax() ? App\Models\Section::whereIn('id', $sectionIds)->hasAbsentStudents()->count() : ''  }} 
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'reserve' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Bảo lưu
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Student\ReserveController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'reserve' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Danh sách</span></a>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'refunds' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contracts" role="tabpanel">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-5 pe-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">

                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div class="menu-item">
                                        <!--begin:Menu content-->
                                        <span class="accordion-button menu-link ms-4" data-bs-toggle="collapse"
                                            data-bs-target="#category-accordion">
                                            <span
                                                class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                Yêu cầu hoàn phí
                                            </span>
                                            {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                        </span>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a href="{{ action([App\Http\Controllers\Accounting\RefundRequestController::class, 'index']) }}"
                                                    class="menu-link py-3  {{ $menu == 'refunds' ? 'active ' : '' }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            assignment
                                                        </span>

                                                    </span>
                                                    <span class="menu-title">Danh sách</span></a>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>

                                            <!--BEGIN::Trạng thái-->
                                            <div>
                                                <div class="menu-item menu-accordion show">
                                                    <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                        data-bs-target="#status-accordion">
                                                        <span
                                                            class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                            thái</span>
                                                    </span>
                                                    <div id="status-accordion"
                                                        class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Student\RefundRequestController::class, 'index']) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="19-4">{{ App\Models\RefundRequest::count() }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_PENDING,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_PENDING ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.pending') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="19-5">{{ request()->ajax() ? App\Models\RefundRequest::pending()->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_APPROVED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_APPROVED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.approved') }}</span>
                                                                <span class="menu-badge" sidebar-counter="19-6">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::approved()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_REJECTED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_REJECTED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.rejected') }}</span>
                                                                <span class="menu-badge" sidebar-counter="19-7">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::rejected()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Student\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_CANCEL,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_CANCEL ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.cancel') }}</span>
                                                                <span class="menu-badge" sidebar-counter="19-8">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::cancel()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>


                                                    </div>

                                                </div>
                                            </div>
                                            <!--END::Trạng thái-->

                                        </div>
                                        <!--end:Menu content-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--START::REPORT-->
                    <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'reporting' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Báo cáo đào tạo
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Student\Report\TeacherHourReportController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'teacher_hour_report' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Báo cáo giờ dạy của giảng
                                                            viên</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                            </div>

                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Student\Report\StudentHourReportController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'student_hour_report' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Báo cáo giờ tồn của học viên</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--END::REPORT-->
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    $(() => {
        sidebarShow.init();

        CheckStatus();
    })

    var sidebarShow = {
        init: function() {
            const aside = document.querySelector('.aside-secondary');
            const toggleButton = document.getElementById('kt_aside_show');
            var hasSecondary = $('.aside-secondary .tab-pane:visible').length;

            if (!hasSecondary) {
                $(toggleButton).remove();
                return;
            }

            toggleButton.addEventListener('click', function() {
                aside.classList.toggle('d-none');
            });
        }
    };
    var CheckStatus = function() {
        var abroadLink = document.querySelector('li[aria-label="Du học"] a'); 
        abroadLink.addEventListener('click', function(event) { 
            var hasAbroadApplications = {!! Auth::user()->getStudent()->abroadApplications()->exists() ? 'true' : 'false' !!}; 
            if (hasAbroadApplications === false) {
                event.preventDefault();
                ASTool.warning({
                    message: 'Bạn chưa đăng ký chương trình du học nào!', 
                });
            }
        });
    }



</script>
