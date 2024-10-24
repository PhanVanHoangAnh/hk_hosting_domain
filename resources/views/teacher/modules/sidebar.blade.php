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
                        <a href="{{ action([App\Http\Controllers\Teacher\DashboardController::class, 'index']) }}"
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
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Thời khóa biểu"
                        data-bs-original-title="Thời khóa biểu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Teacher\SectionController::class, 'calendar']) }}"
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
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu"
                        data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Teacher\CourseController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'courses' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Quản lý lớp học" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                meeting_room
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Lớp học
                                </span>
                            </div>
                        </a>
                    </li> 

                   
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Thông tin tài khoản" data-bs-original-title="Thông tin tài khoản" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Teacher\ProfileController::class, 'edit']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'profile' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Hồ sơ"
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
                        <a href="javascript:;"
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
                        <!--begin::Tab pane-->

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
                                                    Quản lý lớp học
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Teacher\CourseController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'courses' ? ' active' : '' }}">
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
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                    thái</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div id="status-accordion"
                                                class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'courses' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Teacher\CourseController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="22-00">{{ request()->ajax() ? App\Models\Course::getByTeacherUser(Auth()->user()->getTeacher())->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Teacher\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Course::OPENING_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link  {{ request()->status == App\Models\Course::OPENING_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Đang học</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="22-1">{{ request()->ajax() ? App\Models\Course::getByTeacherUser(Auth()->user()->getTeacher())->getIsLearning()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Teacher\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Course::COMPLETED_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->status == App\Models\Course::COMPLETED_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Hoàn thành</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="22-2">{{request()->ajax() ? App\Models\Course::getByTeacherUser(Auth()->user()->getTeacher())->getIsStudied()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Teacher\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Course::WAITING_OPEN_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'courses' && request()->status == App\Models\Course::WAITING_OPEN_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa học</span>
                                                        <span
                                                        class="menu-badge" sidebar-counter="22-3">{{request()->ajax() ? App\Models\Course::getByTeacherUser(Auth()->user()->getTeacher())->getIsUnstudied()->count() : ''  }}</span>

                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Teacher\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_STOPPED,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'courses' && request()->status == App\Models\Section::STATUS_STOPPED ? 'active' : '' }}">
                                                        <span class="menu-title">Đã dừng</span>
                                                        <span
                                                        
                                                        class="menu-badge" sidebar-counter="22-4">{{request()->ajax() ? App\Models\Course::getByTeacherUser(Auth()->user()->getTeacher())->getStoppedClass()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
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
                                                    <a href="javascript:;"
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
                                                    <a href="javascript:;"
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
                                                    <a href="{{ action([App\Http\Controllers\Teacher\SectionController::class, 'index']) }}"
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
                                                $currContact = Auth()->user()->getTeacher();
                                                
                                            @endphp

                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Loại hình thời khóa biểu</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div id="status-accordion" class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'sections' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Teacher\SectionController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả </span>
                                                        <span class="menu-badge" sidebar-counter="22-5">{{ \request()->ajax() ? App\Models\Teacher::allSections($currContact)->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Teacher\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_DESTROY,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_DESTROY ? 'active' : '' }}">
                                                        <span class="menu-title">Đã hủy</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="22-6">{{ \request()->ajax() ? App\Models\Teacher::allSections($currContact)->isDestroy()->count() : ''  }}</span>
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
            </div>
        </div>
    </div>
</div>

<script>
    $(() => {
        sidebarShow.init();
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
   



</script>
