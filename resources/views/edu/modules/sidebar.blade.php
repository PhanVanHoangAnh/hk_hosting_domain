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
                        <a href="{{ action([App\Http\Controllers\Edu\DashboardController::class, 'index']) }}"
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

                    {{-- <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu"
                        data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'class-assignment' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Quản lý xếp lớp" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                view_timeline
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Xếp lớp
                                </span>
                            </div>
                        </a>
                    </li> --}}

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu"
                        data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'index']) }}"
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
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu"
                        data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Edu\StaffController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'staffs' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Nhân sự đào tạo" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                assignment_ind
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Nhân sự
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu"
                        data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Edu\StudentController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'students' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Học viên" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                groups
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    QL học viên
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Edu\SectionController::class, 'calendar']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'sections' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Thời khóa biểu"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">
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
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\Edu\RefundRequestController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'refunds' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Yêu cầu hoàn phí"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                send_money
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Hoàn phí
                                </span>
                            </div>
                        </a>

                    </li>


                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Edu\Report\TeacherHourReportController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'reporting' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Báo cáo" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1" >
                            <span class="material-symbols-rounded fs-3x d-block">
                                monitoring
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Báo cáo
                                </span>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="aside-secondary d-flex flex-row-fluid w-lg-230px {{ $menu == 'dashboard' ? 'd-none' : '' }}">
        <!--begin::Workspace-->
        <div class="aside-workspace mb-5" id="kt_aside_wordspace" style="width:100%">
            <div class="d-flex h-100 flex-column">
                <!--begin::Wrapper-->
                <div class="flex-column-fluid hover-scroll-y h-100" data-kt-scroll="true"
                    data-kt-scroll-activate="true" data-kt-scroll-height="auto"
                    data-kt-scroll-wrappers="#kt_aside_wordspace"
                    data-ktscroll-dependencies="#kt_aside_secondary_footer" data-kt-scroll-offset="0px"
                    style="height: 100vh; scrollbar-width: 40px;">

                    <!--begin::Tab content-->
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
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">

                                                @if ($sidebar !== 'editCalendar')
                                                    <div data-is-nav="nav" data-nav="add-course" class="menu-item">
                                                        <a href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'add']) }}"
                                                            class="menu-link py-3 {{ $sidebar == 'addCourse' ? ' active' : '' }}"
                                                            id="addCourseLinks">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    add_home
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Mở lớp</span>
                                                        </a>
                                                    </div>
                                                @else
                                                    <div data-is-nav="nav" data-nav="add-course" class="menu-item">
                                                        <a href="javascript:;"
                                                            class="menu-link py-3 {{ $sidebar == 'editCalendar' ? ' active' : '' }}"
                                                            id="addCourseLinks">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    edit_calendar
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Sửa lịch</span>
                                                        </a>
                                                    </div>
                                                @endif

                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'index']) }}"
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
                                                    <a href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge">
                                                            
                                                            {{-- @if (Auth::user()->can('leaderEdu', Auth::user()) || !Auth::user()->account->teacher_id)
                                                                {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->count()}}
                                                            @else
                                                                {{  Auth::user()->account->getCoursesForUser()->count() }}
                                                            @endif --}}
                                                            {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->count()  }}
                                                           </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Course::OPENING_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link  {{ request()->status == App\Models\Course::OPENING_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Đang học</span>
                                                        <span
                                                            class="menu-badge"  >
                                                            {{-- @if (Auth::user()->can('leaderEdu', Auth::user()) || !Auth::user()->account->teacher_id)
                                                                {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->getIsLearning()->count()  }}
                                                            @else
                                                                {{ Auth::user()->account->getCoursesForUser()->getIsLearning()->count() }}
                                                            @endif --}}
                                                            {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->getIsLearning()->count() }}
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Course::COMPLETED_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->status == App\Models\Course::COMPLETED_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Hoàn thành</span>
                                                        <span
                                                            class="menu-badge" >
                                                            {{-- @if (Auth::user()->can('leaderEdu', Auth::user()) || !Auth::user()->account->teacher_id)
                                                                {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->getIsStudied()->count()  }}
                                                            @else
                                                                {{ Auth::user()->account->getCoursesForUser()->getIsStudied()->count() }}
                                                            @endif --}}
                                                          
                                                            {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->getIsStudied()->count() }}
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Course::WAITING_OPEN_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'courses' && request()->status == App\Models\Course::WAITING_OPEN_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa học</span>
                                                        <span
                                                            class="menu-badge" >
                                                            {{-- @if (Auth::user()->can('leaderEdu', Auth::user()) || !Auth::user()->account->teacher_id)
                                                                {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->getIsUnstudied()->count()  }}
                                                            @else
                                                                {{ Auth::user()->account->getCoursesForUser()->getIsUnstudied()->count() }}
                                                            @endif --}}
                                                            {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->getIsUnstudied()->count() }}
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_STOPPED,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'courses' && request()->status == App\Models\Section::STATUS_STOPPED ? 'active' : '' }}">
                                                        <span class="menu-title">Đã dừng</span>
                                                        <span
                                                            class="menu-badge" >
                                                            {{-- @if (Auth::user()->can('leaderEdu', Auth::user()) || !Auth::user()->account->teacher_id)
                                                                {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->getStoppedClass()->count() }}
                                                            @else
                                                                {{ Auth::user()->account->getCoursesForUser()->getStoppedClass()->count() }}
                                                            @endif --}}
                                                            {{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->getStoppedClass()->count() }}
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

                    <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'staffs' ? 'active show' : '' }}"
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
                                                    Nhân sự đào tạo
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div data-is-nav="nav" data-nav="add-course"
                                                    class="menu-item d-none">
                                                    <a list-action="add-staff" href="javascript:;"
                                                        class="menu-link py-3 {{ $sidebar == 'addStaff' ? ' active' : '' }}"
                                                        id="addStaffLinks">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                playlist_add
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Thêm nhân sự</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Edu\StaffController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'staffs' ? ' active' : '' }}">
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
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Loại
                                                    hình nhân viên</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div id="status-accordion"
                                                class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'staffs' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Edu\StaffController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->type ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="99">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\StaffController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_VIETNAM,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_VIETNAM ? 'active' : '' }}">
                                                        <span class="menu-title">Giáo viên Việt Nam</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="1-1">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isVietNam()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\StaffController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_FOREIGN,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_FOREIGN ? 'active' : '' }}">
                                                        <span class="menu-title">Giáo viên nước ngoài</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="1-2">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isForeign()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\StaffController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_TUTOR,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_TUTOR ? 'active' : '' }}">
                                                        <span class="menu-title">Gia sư</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="1-3">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isTutor()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\StaffController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_HOMEROOM,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_HOMEROOM ? 'active' : '' }}">
                                                        <span class="menu-title">Chủ nhiệm</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="1-4">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isHomeRoom()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\StaffController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_ASSISTANT,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_ASSISTANT ? 'active' : '' }}">
                                                        <span class="menu-title">Trợ giảng</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="1-5">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isAssistant()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'students' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span data-box-toggle="#qlhv" class="accordion-button menu-link"
                                                data-bs-toggle="collapse" data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    <span class="d-flex align-items-center w-100">
                                                        <span>Quản lý học viên</span>
                                                        <span box-toggle="anchor"
                                                            class="material-symbols-rounded text-light ms-auto">
                                                            expand_more
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show d-none">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Edu\StudentController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'students' ? ' active' : '' }}">
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
                                    <div id="qlhv">
                                        <div class="menu-item menu-accordion">
                                            <span class="accordion-button menu-link d-none" data-bs-toggle="collapse"
                                                data-bs-target="#status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Loại
                                                    hình học viên</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div id="status-accordion"
                                                class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'students' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Edu\StudentController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status && !request()->type ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="1-6">{{ request()->ajax() ? App\Models\Contact::byBranch(\App\Library\Branch::getCurrentBranch())->student()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\StudentController::class, 'index'],
                                                        [
                                                            'status' => 'notenrolled',
                                                        ],
                                                    ) }}"
                                                        class="menu-link
                                                        {{ request()->status == 'notenrolled' && !request()->type ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="1-7">{{ request()->ajax() ? App\Models\Contact::byBranch(\App\Library\Branch::getCurrentBranch())->student()->notenrolled()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\StudentController::class, 'index'],
                                                        [
                                                            'status' => 'enrolled',
                                                        ],
                                                    ) }}"
                                                        class="menu-link
                                                        {{ request()->status == 'enrolled' && !request()->type ? 'active' : '' }}">
                                                        <span class="menu-title">Đã xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="1-8">{{ request()->ajax() ? App\Models\Contact::byBranch(\App\Library\Branch::getCurrentBranch())->student()->enrolled()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="ms-5">
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Edu\StudentController::class, 'index'],
                                                            [
                                                                'status' => 'waiting',
                                                            ],
                                                        ) }}"
                                                            class="menu-link
                                                        {{ request()->status == 'waiting' && !request()->type ? 'active' : '' }}">
                                                            <span class="menu-title">Chờ khai giảng</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="1-9">{{ request()->ajax() ? App\Models\Contact::byBranch(\App\Library\Branch::getCurrentBranch())->waiting()->count() : ''  }}</span>

                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Edu\StudentController::class, 'index'],
                                                            [
                                                                'status' => 'learning',
                                                            ],
                                                        ) }}"
                                                            class="menu-link
                                                        {{ request()->status == 'learning' && !request()->type ? 'active' : '' }}">
                                                            <span class="menu-title">Đang học</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="2-1">{{ request()->ajax() ? App\Models\Contact::byBranch(\App\Library\Branch::getCurrentBranch())->learning()->count() : ''  }}</span>

                                                        </a>
                                                    </div>
                                                    <div class="menu-item ">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Edu\ReserveController::class, 'index'],
                                                            [
                                                                'status' => 'reserve',
                                                            ],
                                                        ) }}"
                                                            class="menu-link
                                                        {{ request()->status == 'reserve' && !request()->type ? 'active' : '' }}">
                                                            <span class="menu-title">Bảo lưu</span>

                                                            <span
                                                                class="menu-badge" sidebar-counter="2-2">{{ request()->ajax() ? App\Models\Reserve::byBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}</span>
                                                        </a>
                                                    </div>
                                                    <div class="ms-4">
                                                        <div class="menu-item ">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Edu\ReserveController::class, 'index'],
                                                                [
                                                                    'status' => 'reserve',
                                                                    'type' => 'limit',
                                                                ],
                                                            ) }}"
                                                                class="menu-link
                                                        {{ request()->status == 'reserve' && request()->type == 'limit' ? 'active' : '' }}">
                                                                <span class="menu-title">Sắp hết hạn bảo lưu</span>

                                                                <span
                                                                    class="menu-badge" sidebar-counter="2-3">{{ request()->ajax() ? App\Models\Reserve::byBranch(\App\Library\Branch::getCurrentBranch())->limit()->get()->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item ">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Edu\ReserveController::class, 'index'],
                                                                [
                                                                    'status' => 'reserve',
                                                                    'type' => 'expired',
                                                                ],
                                                            ) }}"
                                                                class="menu-link
                                                        {{ request()->status == 'reserve' && request()->type == 'expired' ? 'active' : '' }}">
                                                                <span class="menu-title">Hết hạn bảo lưu</span>

                                                                <span
                                                                    class="menu-badge" sidebar-counter="2-4">{{ request()->ajax() ? App\Models\Reserve::byBranch(\App\Library\Branch::getCurrentBranch())->expired()->get()->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="menu-item ">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Edu\StudentController::class, 'index'],
                                                            [
                                                                'status' => 'reserveLimit',
                                                            ],
                                                        ) }}"
                                                            class="menu-link
                                                        {{ request()->status == 'reserve' && !request()->type ? 'active' : '' }}">
                                                            <span class="menu-title">Sắp hết hạn bảo lưu</span>

                                                            <span
                                                                class="menu-badge" sidebar-counter="5-9">{{ request()->ajax() ? App\Models\Contact::reserveOrderItem()->count() : ''  }}</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item ">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Edu\StudentController::class, 'index'],
                                                            [
                                                                'status' => 'reserve',
                                                            ],
                                                        ) }}"
                                                            class="menu-link
                                                        {{ request()->status == 'reserve' && !request()->type ? 'active' : '' }}">
                                                            <span class="menu-title">Hết hạn bảo lưu</span>

                                                            <span
                                                                class="menu-badge" sidebar-counter="6-00">{{ request()->ajax() ? App\Models\Contact::reserveOrderItem()->count() : ''  }}</span>
                                                        </a>
                                                    </div> --}}
                                                    <div class="menu-item ">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Edu\StudentController::class, 'index'],
                                                            [
                                                                'status' => 'refund',
                                                            ],
                                                        ) }}"
                                                            class="menu-link
                                                        {{ request()->status == 'refund' && !request()->type ? 'active' : '' }}">
                                                            <span class="menu-title">Hoàn phí</span>

                                                            <span
                                                                class="menu-badge" sidebar-counter="6-2">{{ request()->ajax() ? App\Models\Contact::byBranch(\App\Library\Branch::getCurrentBranch())->refund()->count() : ''  }}</span>
                                                        </a>
                                                    </div>

                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                            [
                                                                'status' => 'transfer',
                                                            ],
                                                        ) }}"
                                                            class="menu-link
                                                            {{ request()->status == 'transfer' ? 'active' : '' }}">
                                                            <span class="menu-title">Chuyển phí</span>

                                                            <span
                                                                class="menu-badge" sidebar-counter="2-5">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->transfer()->count() : ''  }}</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Edu\StudentController::class, 'index'],
                                                            [
                                                                'status' => 'finished',
                                                            ],
                                                        ) }}"
                                                            class="menu-link
                                                        {{ request()->status == 'finished' && !request()->type ? 'active' : '' }}">
                                                            <span class="menu-title">Học xong</span>

                                                            <span
                                                                class="menu-badge" sidebar-counter="2-6">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->finishedLearning()->count() : ''  }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Quản lý xếp lớp --}}
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span data-box-toggle="#xldt" class="accordion-button menu-link"
                                                data-bs-toggle="collapse" data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">

                                                    <span class="d-flex align-items-center w-100">
                                                        <span>Xếp lớp đào tạo</span>
                                                        <span box-toggle="anchor"
                                                            class="material-symbols-rounded text-light ms-auto">
                                                            expand_more
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                            <div id="xldt" class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'type' => 'edu',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->type == 'edu' && !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="2-7">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->typeEdu()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'notEnrolled',
                                                            'type' => \App\Models\OrderItem::TYPE_EDU,
                                                        ],
                                                    ) }}"
                                                        class="menu-link  {{ request()->type == \App\Models\OrderItem::TYPE_EDU && request()->status == 'notEnrolled' ? 'active' : '' }}">
                                                        <span class="menu-title">Chờ xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="2-8">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->whichDoesntHasCousrseCount(\App\Models\OrderItem::TYPE_EDU)->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'enrolled',
                                                            'type' => \App\Models\OrderItem::TYPE_EDU,
                                                        ],
                                                    ) }}"
                                                        class="menu-link
                                                        {{ request()->type == \App\Models\OrderItem::TYPE_EDU && request()->status == 'enrolled' ? 'active' : '' }}">
                                                        <span class="menu-title">Đã xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="2-9">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->whichHasCousrseByType(\App\Models\OrderItem::TYPE_EDU)->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                {{-- <div class="ms-4"> --}}
                                                <div class="menu-item d-none">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'reserve',
                                                            'type' => 'edu',
                                                        ],
                                                    ) }}"
                                                        class="menu-link
                                                        {{ request()->type == 'edu' && request()->status == 'reserve' ? 'active' : '' }}">
                                                        <span class="menu-title">Bảo lưu</span>

                                                        <span
                                                            class="menu-badge" sidebar-counter="6-3">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->reserveCount()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item d-none">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'refund',
                                                            'type' => 'edu',
                                                        ],
                                                    ) }}"
                                                        class="menu-link
                                                        {{ request()->type == 'edu' && request()->status == 'refund' ? 'active' : '' }}">
                                                        <span class="menu-title">Hoàn phí</span>

                                                        <span
                                                            class="menu-badge" sidebar-counter="3-1">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->refund()->count() : ''  }}</span>
                                                    </a>
                                                </div>

                                                {{-- </div> --}}

                                            </div>
                                        </div>
                                        <div class="menu-item menu-accordion show">
                                            <span data-box-toggle="#xldm" class="accordion-button menu-link"
                                                data-bs-toggle="collapse" data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">

                                                    <span class="d-flex align-items-center w-100">
                                                        <span>Xếp lớp demo</span>
                                                        <span box-toggle="anchor"
                                                            class="material-symbols-rounded text-light ms-auto">
                                                            expand_more
                                                        </span>
                                                    </span>
                                                </span>
                                            </span>
                                            <div id="xldm" class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'type' => 'request-demo',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->type == 'request-demo' && !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="3-2">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->countAssignments('request-demo')->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'enrolled',
                                                            'type' => 'request-demo',
                                                        ],
                                                    ) }}"
                                                        class="menu-link
                                                        {{ request()->type == 'request-demo' && request()->status == 'enrolled' ? 'active' : '' }}">
                                                        <span class="menu-title">Đã xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="3-3">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->whichHasCousrseByType('request-demo')->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'notEnrolled',
                                                            'type' => 'request-demo',
                                                        ],
                                                    ) }}"
                                                        class="menu-link  {{ request()->type == 'request-demo' && request()->status == 'notEnrolled' ? 'active' : '' }}">
                                                        <span class="menu-title">Chờ xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="3-4">{{ request()->ajax() ? App\Models\OrderItem::byBranch(\App\Library\Branch::getCurrentBranch())->whichDoesntHasCousrseCount('request-demo')->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'class-assignment' ? 'active show' : '' }}"
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
                                                    Quản lý xếp lớp
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'type' => 'edu',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->type == 'edu' && !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="3-5">{{ request()->ajax() ? App\Models\OrderItem::eduCount()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'enrolled',
                                                            'type' => 'edu',
                                                        ],
                                                    ) }}"
                                                        class="menu-link
                                                        {{ request()->type == 'edu' && request()->status == 'enrolled' ? 'active' : '' }}">
                                                        <span class="menu-title">Đã xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="3-6">{{ request()->ajax() ? App\Models\OrderItem::whichHasCousrseByType('Đào tạo')->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'notEnrolled',
                                                            'type' => 'edu',
                                                        ],
                                                    ) }}"
                                                        class="menu-link  {{ request()->type == 'edu' && request()->status == 'notEnrolled' ? 'active' : '' }}">
                                                        <span class="menu-title">Chờ xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="3-7">{{ request()->ajax() ? App\Models\OrderItem::whichDoesntHasCousrseCount('Đào tạo')->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Quản lý xếp lớp demo
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'type' => 'request-demo',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->type == 'request-demo' && !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="3-8">{{ App\Models\OrderItem::countAssignments('request-demo') }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'enrolled',
                                                            'type' => 'request-demo',
                                                        ],
                                                    ) }}"
                                                        class="menu-link
                                                        {{ request()->type == 'request-demo' && request()->status == 'enrolled' ? 'active' : '' }}">
                                                        <span class="menu-title">Đã xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="3-9">{{ request()->ajax() ? App\Models\OrderItem::whichHasCousrseByType('request-demo')->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\ClassAssignmentsController::class, 'index'],
                                                        [
                                                            'status' => 'notEnrolled',
                                                            'type' => 'request-demo',
                                                        ],
                                                    ) }}"
                                                        class="menu-link  {{ request()->type == 'request-demo' && request()->status == 'notEnrolled' ? 'active' : '' }}">
                                                        <span class="menu-title">Chờ xếp lớp</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="4-1">{{ request()->ajax() ? App\Models\OrderItem::whichDoesntHasCousrseCount('request-demo')->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}

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
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Edu\SectionController::class, 'index']) }}"
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
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Loại hình thời khóa biểu</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div id="status-accordion"
                                                class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'sections' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Edu\SectionController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="4-2">{{ request()->ajax() ? App\Models\Section::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_NOT_ACTIVE,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_NOT_ACTIVE ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa học</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="4-3">{{ request()->ajax() ? App\Models\Section::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->notStudyYet()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_ACTIVE,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_ACTIVE ? 'active' : '' }}">
                                                        <span class="menu-title">Đang học</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="4-4">{{ request()->ajax() ? App\Models\Section::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->learning()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::COMPLETED_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::COMPLETED_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Đã học</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="4-5">{{ request()->ajax() ? App\Models\Section::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->studied()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_DESTROY,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_DESTROY ? 'active' : '' }}">
                                                        <span class="menu-title">Đã hủy</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="4-6">{{ request()->ajax() ? App\Models\Section::byBranch(\App\Library\Branch::getCurrentBranch())->edu()->isDestroy()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="menu-item menu-accordion">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#shift-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Chốt
                                                    ca</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <div id="shift-accordion"
                                                class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'sections' ? 'show' : '' }}">

                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_NOT_SHIFT_CLOSED,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_NOT_SHIFT_CLOSED ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa chốt</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="4-7">{{ request()->ajax() ? App\Models\Section::byBranch(\App\Library\Branch::getCurrentBranch())->isNotShiftClosed()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Edu\SectionController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_OVERDUE_SHIFT_CLOSED,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_OVERDUE_SHIFT_CLOSED ? 'active' : '' }}">
                                                        <span class="menu-title">Quá hạn</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="4-8">{{ request()->ajax() ? App\Models\Section::byBranch(\App\Library\Branch::getCurrentBranch())->isOverdueShiftClosed()->count() : ''  }}</span>
                                                    </a>
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
                                                    <a href="{{ action([App\Http\Controllers\Edu\ReserveController::class, 'index']) }}"
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
                                                            <a href="{{ action([App\Http\Controllers\Edu\RefundRequestController::class, 'index']) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="5-1">{{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Edu\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_PENDING,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_PENDING ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.pending') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="5-2">{{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->pending()->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Edu\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_APPROVED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_APPROVED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.approved') }}</span>
                                                                <span class="menu-badge" sidebar-counter="5-3">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->approved()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Edu\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_REJECTED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_REJECTED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.rejected') }}</span>
                                                                <span class="menu-badge" sidebar-counter="5-4">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->rejected()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Edu\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_CANCEL,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_CANCEL ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.cancel') }}</span>
                                                                <span class="menu-badge" sidebar-counter="5-5">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->cancel()->count() : ''  }}
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
                                                    <a href="{{ action([App\Http\Controllers\Edu\Report\TeacherHourReportController::class, 'index']) }}"
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
                                                    <a href="{{ action([App\Http\Controllers\Edu\Report\StudentHourReportController::class, 'index']) }}"
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
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Edu\Report\StudentSectionReportController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'student_section_report' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Bảng kê chi tiết buổi học theo ngày</span>
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
