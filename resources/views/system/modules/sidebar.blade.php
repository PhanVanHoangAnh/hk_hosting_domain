@php
$menu = $menu ?? null;
$sidebar = $sidebar ?? null;
@endphp

<button id="kt_aside_show" class="aside-toggle btn btn-sm btn-icon border end-0 bottom-0 d-lg-flex rounded bg-white" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">

    <i class="ki-duotone ki-arrow-left fs-2 rotate-180"><span class="path1"></span><span class="path2"></span></i>
</button>
<div id="kt_aside" class="aside aside-extended pe-3" data-kt-drawer="true" data-kt-drawer-name="aside" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_aside_mobile_toggle">

    <!--begin::Primary-->
    <div class="aside-primary d-flex flex-column align-items-lg-end flex-row-auto pt-2">
        <!--begin::Nav-->
        <div class="aside-nav border-end-dashed d-flex flex-column align-items-center flex-column-fluid w-100 pt-5 pt-lg-0 border-gray-300" style="border-width: 1px;" id="kt_aside_nav">

            <!--begin::Wrapper-->
            <div class="hover-scroll-overlay-y mb-5 h-100" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto">
                <!--begin::Nav-->

                <ul class="nav flex-column w-100 pe-3" id="kt_aside_nav_tabs" role="tablist">
                    <li class="nav-item mb-2 py-1 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\System\AccountController::class, 'index']) }}" class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'accounts' ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="Tài khoản" aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                supervisor_account
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Tài khoản
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\System\UserController::class, 'index']) }}" class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'users' ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="Người dùng" aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                person
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Người dùng
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu"
                        data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\System\TeacherController::class, 'index']) }}"
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
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\System\RoleController::class, 'index']) }}" class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'roles' ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="Quản lý vai trò" aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                manage_accounts
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Vai trò
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a data-action="under-construction" href="{{ action([App\Http\Controllers\System\AccountGroupController::class, 'index']) }}" class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'account-groups' ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="Nhóm tài khoản" aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                group
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Nhóm
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\System\StaffGroupController::class, 'index']) }}" class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'staff_groups' ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="Nhóm nhân sự" aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                diversity_3
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Nhóm nhân sự
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 py-1 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\System\StaffController::class, 'index']) }}" class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'staffs' ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="Nhân sự đào tạo" aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style="" tabindex="-1">
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

                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\System\BackupController::class, 'index']) }}" class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'backup' ? 'active' : '' }}" data-toggle="tooltip" data-placement="bottom" title="Sao Lưu & Phục hồi" aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                cloud_sync
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Sao lưu HT
                                </span>
                            </div>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="aside-secondary d-flex flex-row-fluid w-lg-230px {{ $menu == 'dashboard' || $menu == 'backup' ? 'd-none' : '' }}">
        <!--begin::Workspace-->
        <div class="aside-workspace mb-5" id="kt_aside_wordspace" style="width:100%">
            <div class="d-flex h-100 flex-column">
                <!--begin::Wrapper-->
                <div class="flex-column-fluid hover-scroll-y h-100" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_aside_wordspace" data-ktscroll-dependencies="#kt_aside_secondary_footer" data-kt-scroll-offset="0px" style="height: 100vh; scrollbar-width: 40px;">

                    
                    <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'settings' ? 'active show' : '' }}"
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
                                                    Dữ liệu hệ thống
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'demands' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Đơn hàng</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'source_type' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Source Types</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Channels</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Sub channels</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Sản phẩm du học (abroad products)</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">academicAwards</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">aims</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">banks</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">classTypes</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">constants</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">constractServices</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">contentNoteLog</span></a>
                                                    </a>
                                                    <!--end:Menu link-->

                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\DemandController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'sub_channel' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">contentNoteLog</span></a>
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
                                                    <a href="{{ action([App\Http\Controllers\System\TeacherController::class, 'index']) }}"
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
                                                    <a href="{{ action([App\Http\Controllers\System\TeacherController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->type ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="21-00">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\System\TeacherController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_VIETNAM,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_VIETNAM ? 'active' : '' }}">
                                                        <span class="menu-title">Giáo viên Việt Nam</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="20-1">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isVietNam()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\System\TeacherController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_FOREIGN,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_FOREIGN ? 'active' : '' }}">
                                                        <span class="menu-title">Giáo viên nước ngoài</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="20-2">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isForeign()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\System\TeacherController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_TUTOR,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_TUTOR ? 'active' : '' }}">
                                                        <span class="menu-title">Gia sư</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="20-3">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isTutor()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\System\TeacherController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_HOMEROOM,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_HOMEROOM ? 'active' : '' }}">
                                                        <span class="menu-title">Chủ nhiệm</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="20-4">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isHomeRoom()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\System\TeacherController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_ASSISTANT,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_ASSISTANT ? 'active' : '' }}">
                                                        <span class="menu-title">Trợ giảng</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="20-5">{{ request()->ajax() ?  App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isAssistant()->count()  : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\System\TeacherController::class, 'index'],
                                                        [
                                                            'type' => App\Models\Teacher::TYPE_ASSISTANT_KID,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'staffs' && request()->type == App\Models\Teacher::TYPE_ASSISTANT_KID ? 'active' : '' }}">
                                                        <span class="menu-title">Trợ giảng KID</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="20-3">{{ request()->ajax() ? App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isAssistantKid()->count() : ''  }}</span>
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
                        <div class="tab-pane fade {{ $menu == 'staff_groups' ? 'active show' : '' }}" id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0" id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse" data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Nhóm nhân sự
                                                </span>
                                            </span>
                                            <div id="category-accordion-" class="accordion-collapse collapse hover show">
                                                <div data-is-nav="nav" data-nav="add-course" class="menu-item d-none">
                                                    <a list-action="add-staff" href="javascript:;" class="menu-link py-3 {{ $sidebar == 'addStaff' ? ' active' : '' }}" id="addStaffLinks">
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
                                                    <a href="{{ action([App\Http\Controllers\System\StaffGroupController::class, 'index']) }}" class="menu-link py-3 {{ $sidebar == 'staffs' ? ' active' : '' }}">
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
                        <div class="tab-pane fade {{ $menu == 'accounts' ? 'active show' : '' }}" id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0" id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse" data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Tài khoản
                                                </span>
                                            </span>
                                            <div id="category-accordion-" class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\AccountController::class, 'index']) }}" class="menu-link py-3 {{ $sidebar == 'accounts' ? ' active' : '' }}">
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
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse" data-bs-target="#status-accordion">
                                                <span class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Nhóm tài khoản</span>
                                            </span>
                                            <div id="status-accordion" class="accordion-collapse collapse show">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\System\AccountController::class, 'index']) }}" 
                                                    class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span class="menu-badge" sidebar-counter="20-6">{{ request()->ajax() ? App\Models\Account::get()->count() : ''  }}</span>
                                                    </a>
                                                </div>

                                            </div>
                                          
                                            @foreach(App\Models\AccountGroup::query()->get() as $accountGroup)
                                            <div class="menu-item">
                                                <a href="{{ action(
                                                    [App\Http\Controllers\System\AccountController::class, 'index'],
                                                    [
                                                        'type' => $accountGroup->id,
                                                    ],
                                                ) }}"
                                                    class="menu-link
                                                {{ request()->type == $accountGroup->id ? 'active' : '' }}">
                                                    <span class="menu-title">{{ $accountGroup->name }}</span>
                                                    <span
                                                        class="menu-badge" sidebar-counter="20-7">{{ $accountGroup->accounts()->count() }}</span>

                                                </a>
                                            </div>
                                            {{-- <div id="status-accordion" class="accordion-collapse collapse show">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\System\AccountController::class, 'index'], 
                                                    [
                                                        'type' => $accountGroup->id
                                                    ]) }}" 
                                                        class="menu-link  {{ $sidebar == 'accounts' && request()->type == $accountGroup->name ? 'active' : '' }}">
                                                        <span class="menu-title">{{ $accountGroup->name }}</span>
                                                        <span class="menu-badge" sidebar-counter="20-8">{{ $accountGroup->accounts()->count() }}</span>
                                                    </a>
                                                </div>
                                            </div> --}}
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-content">
                        <div class="tab-pane fade {{ $menu == 'users' ? 'active show' : '' }}" id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0" id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse" data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Người dùng
                                                </span>
                                            </span>
                                            <div id="category-accordion-" class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\UserController::class, 'index']) }}" class="menu-link py-3 {{ $sidebar == 'users' ? ' active' : '' }}">
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
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse" data-bs-target="#status-accordion">
                                                <span class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Nhóm tài khoản</span>
                                            </span>
                                            <div id="status-accordion" class="accordion-collapse collapse show">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\System\UserController::class, 'index']) }}" class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span class="menu-badge" sidebar-counter="88">{{ request()->ajax() ? App\Models\User::byBranch(\App\Library\Branch::getCurrentBranch())->count() : '' }}</span>
                                                    </a>
                                                </div>
                                    
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\System\UserController::class, 'index'], ['status' => 'active']) }}" class="menu-link {{ request()->status == 'active' ? 'active' : '' }}">
                                                        <span class="menu-title">{{ trans('messages.users.status.active') }}</span>
                                                        <span class="menu-badge" sidebar-counter="89">{{ request()->ajax() ? App\Models\User::byBranch(\App\Library\Branch::getCurrentBranch())->active()->count() : '' }}</span>
                                                    </a>
                                                </div>
                                    
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\System\UserController::class, 'index'], ['status' => 'out_of_job']) }}" class="menu-link {{ request()->status == 'out_of_job' ? 'active' : '' }}">
                                                        <span class="menu-title">{{ trans('messages.users.status.out_of_job') }}</span>
                                                        <span class="menu-badge" sidebar-counter="90">{{ request()->ajax() ? App\Models\User::byBranch(\App\Library\Branch::getCurrentBranch())->isOutOfJob()->count() : '' }}</span>
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
                        <div class="tab-pane fade {{ $menu == 'roles' ? 'active show' : '' }}" id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0" id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse" data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Vai trò
                                                </span>
                                            </span>
                                            <div id="category-accordion-" class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\RoleController::class, 'index']) }}" class="menu-link py-3 {{ $sidebar == 'roles' ? ' active' : '' }}">
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
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse" data-bs-target="#status-accordion">
                                                <span class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Nhóm vai trò</span>
                                            </span>
                                            <div id="status-accordion" class="accordion-collapse collapse show">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\System\UserController::class, 'index']) }}" class="menu-link {{ !request()->type ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span class="menu-badge" sidebar-counter="21-1">{{ request()->ajax() ? App\Models\Role::get()->count() : ''  }}</span>
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
                        <div class="tab-pane fade {{ $menu == 'account-groups' ? 'active show' : '' }}" id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0" id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse" data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Nhóm tài khoản
                                                </span>
                                            </span>
                                            <div id="category-accordion-" class="accordion-collapse collapse hover show">
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\System\RoleController::class, 'index']) }}" class="menu-link py-3 {{ $sidebar == 'account-groups' ? ' active' : '' }}">
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
                                        <div class="menu-item menu-accordion show">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse" data-bs-target="#status-accordion">
                                                <span class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500 d-none">Nhóm vai trò</span>
                                            </span>
                                            <div id="status-accordion" class="accordion-collapse collapse show">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\System\AccountGroupController::class, 'index']) }}" class="menu-link {{ !request()->type ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span class="menu-badge" sidebar-counter="21-2">{{ request()->ajax() ? App\Models\AccountGroup::get()->count() : ''  }}</span>
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
