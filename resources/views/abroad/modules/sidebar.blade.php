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
            <div class="hover-scroll-overlay-y mb-5 h-100  {{ in_array($menu, ['abroad-application','abroad-student', 'reporting', 'courses','sections']) ? 'active show' : 'd-none' }}" data-kt-scroll="true" 
                data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto">
                <!--begin::Nav-->

                <ul class="nav flex-column w-100 pe-3" id="kt_aside_nav_tabs" role="tablist">
                    <li class="nav-item mb-2 pb-3 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="javascript:;"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'dashboard' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="dashboard" aria-selected="false"
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

                    <!--Menu HỢP ĐỒNG-->
                    

                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $sidebar == 'abroad' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Duyệt và bàn giao" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                person_pin
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Duyệt & BG
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Abroad\AbroadApplicationController::class, 'abroadApplicationIndex']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $sidebar == 'abroad-application' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Quản lý học viên" aria-selected="false"
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

                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Abroad\CourseController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $sidebar == 'courses' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Quản lý lớp học" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                meeting_room
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    QL lớp học
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Abroad\SectionController::class, 'calendar']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $sidebar == 'sections' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Thời khóa biểu"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                calendar_month
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Thời khóa biểu
                                </span>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Báo cáo"
                        data-bs-original-title="Báo cáo" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Abroad\Report\UpsellReportController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $sidebar == 'upsell' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Báo cáo" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
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



            <div class="hover-scroll-overlay-y mb-5 h-100  tab-pane fade {{ in_array($menu, ['extracurricular-application','contact_request', 'orders']) ? 'active show' : 'd-none' }}" data-kt-scroll="true"
                            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto">
                            <!--begin::Nav-->

                <ul class="nav flex-column w-100 pe-3" id="kt_aside_nav_tabs" role="tablist">
                    <li class="nav-item mb-2 pb-3 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="javascript:;"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'dashboard' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="dashboard" aria-selected="false"
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
                    @if (!Auth::user()->can('adminExtracurricular', \App\Models\User::class) ) 
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action(
                            [App\Http\Controllers\Abroad\ExtracurricularController::class, 'approval'],
                            [
                                // 'status' => App\Models\AbroadStatus::STATUS_NEW,
                            ],
                        ) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $sidebar == 'approval-extracurricular'  ? ' active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Duyệt và bàn giao" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                person_pin
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Duyệt & BG
                                </span>
                            </div>
                        </a>
                    </li>
                    @endif

                    
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Abroad\ExtracurricularController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $sidebar == 'extracurricular-application'  ? ' active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Quản lý hoạt động ngoại khoá" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                groups
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Quản lý HDNK
                                </span>
                            </div>
                        </a>
                    </li>
                    

                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action(
                            [App\Http\Controllers\Abroad\ExtracurricularController::class, 'management'],
                            [
                                'status' => 'management',
                            ],
                        ) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $sidebar == 'extracurricular-student' && request()->status == 'management' ? ' active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Quản lý học viên" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                meeting_room
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    QL học viên
                                </span>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Abroad\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_EXTRACURRICULAR]) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $sidebar == 'orders' ? ' active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Hợp đồng ngoại khoá" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                order_approve
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Hợp đồng NK
                                </span>
                            </div>
                        </a>
                    </li>
                     <!--begin::Nav item-->
                     <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Abroad\ContactRequestController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'contact_request' || ($menu == 'orders' && (isset($orderType) && $orderType == App\Models\Order::TYPE_REQUEST_DEMO)) ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Đơn hàng" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                psychology_alt
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Đơn hàng
                                </span>
                            </div>
                        </a>
                        <!--end::Nav link-->
                    </li>
                 <!--end::Nav item-->
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

                        <!--BEGIN::Đơn hàng -->
                        <div class="tab-pane fade {{ $menu == 'contact_request' || ($menu == 'orders' && (isset($orderType) && $orderType == App\Models\Order::TYPE_REQUEST_DEMO)) ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <!--begin::Items-->


                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">

                                    <!--BEGIN::Danh mục chính-->
                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ $menu == 'contact_request' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Đơn hàng
                                                </span>
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>

                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse {{ $menu == 'contact_request' ? ' hover show' : '' }}">

                                                <div data-is-nav="nav" data-nav="add-customer" class="menu-item">
                                                    <a class="menu-link py-3" id="addContactRequestButton">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                person_add
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Thêm đơn hàng</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Abroad\ContactRequestController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $menu == 'contact_request' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                psychology_alt
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Danh sách</span></a>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>

                                            </div>


                                        </div>
                                    </div>
                                    <!--END::Danh mục chính-->

                                    


                                </div>

                            </div>



                        </div>
                        <!--END::Đơn hàng-->









                        <!--START::CONTACT-->
                        <div class="tab-pane fade {{ $menu == 'abroad-application' || $menu == 'abroad-student' ? 'active show' : '' }}"
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
                                                    Duyệt và bàn giao 
                                                </span>
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse hover show">

                                                <div data-is-nav="nav" data-nav="abroad-application"
                                                    class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                        [
                                                            'status' => App\Models\AbroadStatus::STATUS_NEW,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'new' ? ' active' : '' }}"
                                                        id="allAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                stacks
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="1">
                                                           @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count() : ''  }}
                                                            
                                                            @else

                                                                {{ request()->ajax() ? Auth::user()->account->abroadApplications()->count() : ''  }}
                                                            @endif
                                                           
                                                        </span>
                                                    </a>
                                                </div>
                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                    <div data-is-nav="nav" data-nav="waiting-abroad-application"
                                                        class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                            [
                                                                'status' => 'waiting-manager',
                                                            ],
                                                        ) }}"
                                                            class="menu-link py-3 {{ isset($status) && $status == 'waiting-manager' ? ' active' : '' }}" id="">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    hourglass_top
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Chờ bàn giao trường nhóm</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="35">
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByNotAssignedAcountManagerAbroad()->count() : ''  }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class) || Auth::user()->can('manager', \App\Models\User::class)) 
                                                    <div data-is-nav="nav" data-nav="waiting-abroad-application"
                                                        class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                            [
                                                                'status' => 'approval-manager',
                                                            ],
                                                        ) }}"
                                                            class="menu-link py-3 {{ isset($status) && $status == 'approval-manager' ? ' active' : '' }}" id="">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    hourglass_bottom
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Đã bàn giao trưởng nhóm</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="36">
                                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                    {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByAssignedAcountManagerAbroad()->count() : ''  }}
                                                                @elseif (Auth::user()->can('manager', Auth::user()))
                                                                    {{ request()->ajax() ? Auth::user()->account->abroadApplications()->filterByAssignedAcountManagerAbroad()->count(): ''  }}
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class) || Auth::user()->can('manager', \App\Models\User::class)) 
                                                    <div data-is-nav="nav" data-nav="waiting-abroad-application"
                                                        class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
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
                                                            <span class="menu-title">Chờ bàn giao</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="3">
                                                             
                                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                    {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByWaiting()->count() : ''  }}
                                                                @elseif (Auth::user()->can('manager', Auth::user()))
                                                                    {{ request()->ajax() ? Auth::user()->account->abroadApplications()->filterByWaiting()->count(): ''  }}
                                                                @endif
                                                              
                                                            </span>
                                                        </a>
                                                    </div>
                                                    @endif
                                                
                                                    <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                        class="menu-item ">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                            [
                                                                'status' => 'assigned-account',
                                                            ],
                                                        ) }}"
                                                            class="menu-link py-3 {{ isset($status) && $status == 'assigned-account' ? ' active' : '' }}"
                                                            id="assignedAbroadApplicationsLink">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    handshake
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Đã bàn giao</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="2">
                                                            
                                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByAssignedAcountAbroad()->count() : ''  }}
                                                            @else
                                                                {{ request()->ajax() ? Auth::user()->account->abroadApplications()->filterByAssignedAcountAbroad()->count(): ''  }}
                                                            @endif
                                                            
                                                            </span>
                                                        </a>
                                                    </div>
                                              
                                               
                                                <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                    class="menu-item ">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                        [
                                                            'status' => App\Models\AbroadApplication::STATUS_HSDT_WAIT_FOR_APPROVAL,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'wait_for_approval' ? ' active' : '' }}"
                                                        id="assignedAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                pending_actions
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Chờ duyệt HSDT</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="4">
                                                           @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByWaitForApproval()->count() : ''  }} 
                                                           
                                                            @else

                                                                {{Auth::user()->account->abroadApplications()->filterByWaitForApproval()->count()}}
                                                            @endif
                                                           
                                                        
                                                            
                                                        </span>
                                                    </a>
                                                </div>
                                               
                                                <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                    class="menu-item ">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                        [
                                                            'status' => App\Models\AbroadApplication::STATUS_HSDT_APPROVED,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'approved' ? ' active' : '' }}"
                                                        id="assignedAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                assignment_turned_in
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Hoàn thành HSDT</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="5">
                                                           @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByApproved()->count() : ''  }} 
                                                            
                                                            @else

                                                                {{Auth::user()->account->abroadApplications()->filterByApproved()->count()}}
                                                            @endif
                                                           
                                                        
                                                             
                                                        </span>
                                                    </a>
                                                </div>
                                                <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                    class="menu-item ">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                        [
                                                            'status' => 'done',
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'done' ? ' active' : '' }}"
                                                        id="assignedAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                check_circle
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Đã hoàn thành</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="6">
                                                        @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                            {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByDone()->count() : ''  }} 
                                                    
                                                        @else

                                                            {{Auth::user()->account->abroadApplications()->filterByDone()->count()}}
                                                        @endif
                                                        
                                                        </span>
                                                    </a>
                                                </div>
                                                <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                    class="menu-item ">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                        [
                                                            'status' => App\Models\AbroadApplication::STATUS_CANCEL,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'cancel' ? ' active' : '' }}"
                                                        id="assignedAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                cancel_presentation
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Đã huỷ</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="97">
                                                        @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByCancel()->count() : ''  }} 
                                                            
                                                            @else

                                                                {{Auth::user()->account->abroadApplications()->filterByCancel()->count()}}
                                                            @endif
                                                        
                                                        
                                                            
                                                        </span>
                                                    </a>
                                                </div>
                                                <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                    class="menu-item ">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                        [
                                                            'status' => App\Models\AbroadApplication::STATUS_RESERVE,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'reserve' ? ' active' : '' }}"
                                                        id="assignedAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                new_label
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Bảo lưu</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="98">
                                                        @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByReserve()->count() : ''  }} 
                                                            
                                                            @else

                                                                {{Auth::user()->account->abroadApplications()->filterByReserve()->count()}}
                                                            @endif
                                                        
                                                        
                                                            
                                                        </span>
                                                    </a>
                                                </div>
                                                <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                    class="menu-item ">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\AbroadController::class, 'index'],
                                                        [
                                                            'status' => App\Models\AbroadApplication::STATUS_UNRESERVE,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'unreserve' ? ' active' : '' }}"
                                                        id="assignedAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                label_off
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Đã dừng bảo lưu</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="99">
                                                        @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByUnreserve()->count() : ''  }} 
                                                            
                                                            @else

                                                                {{Auth::user()->account->abroadApplications()->filterByUnreserve()->count()}}
                                                            @endif
                                                        
                                                        
                                                            
                                                        </span>
                                                    </a>
                                                </div>



                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        {{-- Temporarily hide, and if use it again later, remember to leave a comment here. --}}
                                        
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
                                                <div id="category-accordion-"
                                                    class="accordion-collapse collapse hover show">
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a href="{{ action([App\Http\Controllers\Abroad\SectionController::class, 'index']) }}"
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
                                                        class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Loại
                                                        hình thời khóa biểu</span>
                                                    <span class="menu-arrow"></span>
                                                </span>
                                                <div id="status-accordion"
                                                    class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'sections' ? 'show' : '' }}">
                                                    <div class="menu-item">
                                                        <a href="{{ action([App\Http\Controllers\Abroad\SectionController::class, 'index']) }}"
                                                            class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                            <span class="menu-title">Tất cả</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="7">{{ request()->ajax() ? App\Models\Section::abroad()->count() : ''  }}</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\SectionController::class, 'index'],
                                                            [
                                                                'status' => App\Models\Section::STATUS_NOT_ACTIVE,
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_NOT_ACTIVE ? 'active' : '' }}">
                                                            <span class="menu-title">Chưa học</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="8">{{ request()->ajax() ? App\Models\Section::abroad()->notStudyYet()->count() : ''  }}</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\SectionController::class, 'index'],
                                                            [
                                                                'status' => App\Models\Section::STATUS_ACTIVE,
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_ACTIVE ? 'active' : '' }}">
                                                            <span class="menu-title">Đang học</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="9">{{ request()->ajax() ? App\Models\Section::abroad()->learning()->count() : ''  }}</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\SectionController::class, 'index'],
                                                            [
                                                                'status' => App\Models\Section::COMPLETED_STATUS,
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::COMPLETED_STATUS ? 'active' : '' }}">
                                                            <span class="menu-title">Đã học</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="10">{{ request()->ajax() ? App\Models\Section::abroad()->studied()->count() : ''  }}</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\SectionController::class, 'index'],
                                                            [
                                                                'status' => App\Models\Section::STATUS_DESTROY,
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ $sidebar == 'sections' && request()->status == App\Models\Section::STATUS_DESTROY ? 'active' : '' }}">
                                                            <span class="menu-title">Đã hủy</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="11">{{ request()->ajax() ? App\Models\Section::abroad()->isDestroy()->count() : ''  }}</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             <!--START::ORDER-->
                            <div class="tab-pane fade {{ $menu == 'orders'  ? 'active show' : '' }}"
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
                                                        : 'Hợp đồng NK') }}
                                            </span>
                                            {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                        </span>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a href="{{ action([App\Http\Controllers\Abroad\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_EXTRACURRICULAR]) }}"
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
                                                data-is-nav="nav" data-nav="add-contract" class="menu-item">
                                                <a class="menu-link py-3 {{ $sidebar == 'create_constract' ? 'active ' : '' }}"
                                                    id="addContractSlideBar">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            assignment_add
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">Thêm dịch vụ</span>
                                                </a>
                                            </div>

                                            <!--BEGIN::Trạng thái-->
                                            <div>
                                                <div class="menu-item menu-accordion show">
                                                    <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                        data-bs-target="#status-accordion">
                                                        <span
                                                            class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                            thái</span>
                                                        <span
                                                            class="menu-arrow {{ request()->status || $menu == 'orders' ? ' rotate' : '' }}"></span>
                                                    </span>
                                                    
                                                    <div id="status-accordion"
                                                        class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Abroad\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_EXTRACURRICULAR]) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="12">
                                                                    @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrdersByAccount()->notDeleted()->extracurriculars()->count() }}
                                                                    @endif
                                                                    </span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_EXTRACURRICULAR,
                                                                    'status' => 'draft',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'draft' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.draft') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="13">
                                                                    @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->draft()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrdersByAccount()->notDeleted()->draft()->extracurriculars()->count() }}
                                                                    @endif 
                                                                </span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_EXTRACURRICULAR,
                                                                    'status' => 'pending',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'pending' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.pending') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="14">
                                                                    @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->pending()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrdersByAccount()->notDeleted()->pending()->extracurriculars()->count() }}
                                                                    @endif 
                                                                </span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_EXTRACURRICULAR,
                                                                    'status' => App\Models\Order::STATUS_APPROVED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_APPROVED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.approved') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="15">
                                                                    @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->approved()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrdersByAccount()->notDeleted()->approved()->extracurriculars()->count() }}
                                                                    @endif 
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_EXTRACURRICULAR,
                                                                    'status' => App\Models\Order::STATUS_DELETED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_DELETED ? 'active' : '' }}">
                                                                <span class="menu-title">Đã xóa</span>
                                                                <span class="menu-badge" sidebar-counter="16">
                                                                    @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->deleted()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrdersByAccount()->deleted()->extracurriculars()->count() }}
                                                                    @endif 
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_EXTRACURRICULAR,
                                                                    'status' => 'rejected',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'rejected' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.rejected') }}</span>

                                                                <span class="menu-badge" sidebar-counter="33">
                                                                    
                                                                    @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->rejected()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrdersByAccount()->notDeleted()->rejected()->extracurriculars()->count() }}
                                                                    @endif 
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu items-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END::Trạng thái-->

                                            <!--BEGIN::Công nợ-->
                                            <div>
                                                <div class="menu-item menu-accordion show">
                                                    <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                        data-bs-target="#status-accordion-2">
                                                        <span
                                                            class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Công nợ</span>
                                                        <span
                                                            class="menu-arrow {{ request()->status || $menu == 'orders' ? ' rotate' : '' }}"></span>
                                                    </span>
                                                    <div id="status-accordion-2"
                                                        class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_EXTRACURRICULAR,
                                                                    'status' => App\Models\Order::STATUS_REACHING_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_REACHING_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.reaching_due_date') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="17">
                                                                    @if (Auth::user()->hasPermission(App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL))
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->reachingDueDate()->checkIsNotPaid()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrders()->notDeleted()->reachingDueDate()->checkIsNotPaid()->extracurriculars()->count() }}
                                                                    @endif 
                                                                </span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_EXTRACURRICULAR,
                                                                    'status' => App\Models\Order::STATUS_PART_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_PART_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.part_paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="18">
                                                                    @if (Auth::user()->hasPermission(App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL))
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->approved()->partPaid()->checkIsNotPaid()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrders()->notDeleted()->approved()->partPaid()->checkIsNotPaid()->extracurriculars()->count() }}
                                                                    @endif 
                                                                </span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_EXTRACURRICULAR,
                                                                    'status' => App\Models\Order::STATUS_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="19">
                                                                    @if (Auth::user()->hasPermission(App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL))
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->checkIsPaid()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrders()->notDeleted()->checkIsPaid()->extracurriculars()->count() }}
                                                                    @endif  
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\OrderController::class, 'index'],
                                                                [
                                                                    'type' => App\Models\Order::TYPE_EXTRACURRICULAR,
                                                                    'status' => App\Models\Order::STATUS_OVER_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_OVER_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.over_due_date') }}</span>
                                                                    <span
                                                                    class="badge badge-danger">
                                                                        @if (Auth::user()->hasPermission(App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL))
                                                                        {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->overDueDate()->checkIsNotPaid()->extracurriculars()->count() : ''  }}
                                                                    @else
                                                                        {{ Auth::user()->account->saleOrders()->notDeleted()->overDueDate()->checkIsNotPaid()->extracurriculars()->count() }}
                                                                    
                                                                    @endif  
                                                                </span>
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
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade {{ $menu == 'extracurricular-application' ? 'active show' : '' }}"
                                id="kt_aside_nav_tab_contacts" role="tabpanel">
                                <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                    id="kt_aside_menu" data-kt-menu="true">
                                    <div id="kt_aside_menu_wrapper" class="menu-fit">
                                        <div>
                                            <div class="menu-item menu-accordion {{ $sidebar == 'extracurricular-student' || $sidebar == 'extracurricular-application' ? ' ' : 'd-none' }} ">
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#category-accordion">
                                                    <span
                                                        class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                        Ngoại khoá
                                                    </span>
                                                </span>
                                                <div id="category-accordion-"
                                                    class="accordion-collapse collapse hover {{ $sidebar == 'extracurricular-application'? ' show' : '' }}">
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->

                                                        <a href="{{ action([App\Http\Controllers\Abroad\ExtracurricularController::class, 'index']) }}"
                                                            class="menu-link py-3 {{ $sidebar == 'extracurricular-application' && request()->status == '' ? ' active' : '' }}">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    nature_people
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Quản lý HDNK</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="20">
                                                                {{ request()->ajax() ? App\Models\Extracurricular::byBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}
                                                            </span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                        
                                                    </div>
                                                    <div id="status-accordion"
                                                        class="accordion-collapse collapse hover {{ isset($sidebar) && $sidebar == 'extracurricular-application' ? ' show' : '' }}">
                                                       
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\ExtracurricularController::class, 'index'],
                                                                [
                                                                    'status' => 'notFinished',
                                                                ],
                                                            ) }}"
                                                                class="menu-link  {{ request()->status == 'notFinished' ? 'active' : '' }}">
                                                                <span class="menu-title">Chưa kết thúc</span>
                                                                <span class="menu-badge" sidebar-counter="21">
                                                                    {{ request()->ajax() ? App\Models\Extracurricular::byBranch(\App\Library\Branch::getCurrentBranch())->notFinished()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\ExtracurricularController::class, 'index'],
                                                                [
                                                                    'status' => 'finished',
                                                                ],
                                                            ) }}"
                                                                class="menu-link  {{ request()->status == 'finished' ? 'active' : '' }}">
                                                                <span class="menu-title">Đã kết thúc</span>
                                                                <span class="menu-badge" sidebar-counter="22">
                                                                    {{ request()->ajax() ? App\Models\Extracurricular::byBranch(\App\Library\Branch::getCurrentBranch())->finish()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Abroad\ExtracurricularController::class, 'index'],
                                                                [
                                                                    'status' => 'finalized',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'finalized' ? 'active' : '' }}">
                                                                <span class="menu-title">Đã quyết toán</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="23">
                                                                    {{ request()->ajax() ? App\Models\Extracurricular::byBranch(\App\Library\Branch::getCurrentBranch())->finalized()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                
                                                
                                                <div id="category-accordion-"
                                                    class="accordion-collapse collapse hover {{ $sidebar == 'extracurricular-student' && request()->status == 'management' ? ' show' : '' }} ">
                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->

                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\ExtracurricularController::class, 'management'],
                                                            [
                                                                'status' => 'management',
                                                            ],
                                                        ) }}"
                                                            class="menu-link py-3 {{ $sidebar == 'extracurricular-student' && request()->status == 'management' ? ' active' : '' }}">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    groups
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Quản lý học viên</span></a>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="menu-item menu-accordion {{ $sidebar == 'approval-extracurricular'? ' ' : 'd-none' }} ">
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#category-accordion">
                                                    <span
                                                        class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                        Duyệt và bàn giao
                                                    </span>
                                                </span>
                                                <div data-is-nav="nav" data-nav="abroad-application"
                                                    class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\ExtracurricularController::class, 'approval'],
                                                    ) }}"
                                                        class="menu-link py-3 {{ !request()->status || request()->status == 'all' ? 'active' : '' }}"
                                                        id="allAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                stacks
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="24">
                                                            @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count() : ''  }}
                                                            @else 
                                                                {{ request()->ajax() ? Auth::user()->account->abroadApplicationExtracurriculars()->count(): ''  }}
                                                            @endif
                                                          </span>
                                                    </a>
                                                </div>
                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                    <div data-is-nav="nav" data-nav="waiting-abroad-application"
                                                        class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\ExtracurricularController::class, 'approval'],
                                                            [
                                                                'status' => 'waiting-manager',
                                                            ],
                                                        ) }}"
                                                            class="menu-link py-3 {{ isset($status) && $status == 'waiting-manager' ? ' active' : '' }}" id="">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    hourglass_top
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Chờ bàn giao trường nhóm</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="33">
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByNotAssignedAcountManagerExtracurricular()->count() : ''  }}
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class) || Auth::user()->can('manager', \App\Models\User::class)) 
                                                    <div data-is-nav="nav" data-nav="waiting-abroad-application"
                                                        class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\ExtracurricularController::class, 'approval'],
                                                            [
                                                                'status' => 'approval-manager',
                                                            ],
                                                        ) }}"
                                                            class="menu-link py-3 {{ isset($status) && $status == 'approval-manager' ? ' active' : '' }}" id="">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    hourglass_bottom
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Đã bàn giao trưởng nhóm</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="34">
                                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                    {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByAssignedAcountManagerExtracurricular()->count() : ''  }}
                                                                @elseif (Auth::user()->can('manager', Auth::user()))
                                                                    {{ request()->ajax() ? Auth::user()->account->abroadApplicationExtracurriculars()->filterByAssignedAcountManagerExtracurricular()->count(): ''  }}
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endif
                                                  
                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class) || Auth::user()->can('manager', \App\Models\User::class)) 
                                                    <div data-is-nav="nav" data-nav="waiting-abroad-application"
                                                        class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Abroad\ExtracurricularController::class, 'approval'],
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
                                                            <span class="menu-title">Chờ bàn giao</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="25">
                                                                @if (Auth::user()->can('changeBranch', \App\Models\User::class))  
                                                                    {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByWaitingExtracurricular()->count() : ''  }}
                                                                @elseif (Auth::user()->can('manager', Auth::user()))
                                                                    {{ request()->ajax() ? Auth::user()->account->abroadApplicationExtracurriculars()->filterByWaitingExtracurricular()->count(): ''  }}
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </div>
                                                @endif

                                                <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                    class="menu-item ">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\ExtracurricularController::class, 'approval'],
                                                        [
                                                            'status' => 'assigned-account',
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'assigned-account' ? ' active' : '' }}"
                                                        id="assignedAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                handshake
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Đã được bàn giao</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="26">
                                                           @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                                                {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByAssignedAcountExtracurricular()->count() : ''  }}
                                                            @else
                                                                {{ request()->ajax() ? Auth::user()->account->abroadApplicationExtracurriculars()->filterByAssignedAcountExtracurricular()->count(): ''  }}
                                                            @endif
                                                         
                                                        </span>
                                                    </a>
                                                </div>
                                                <div data-is-nav="nav" data-nav="assigned-abroad-application"
                                                    class="menu-item d-none">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\ExtracurricularController::class, 'approval'],
                                                        [
                                                            'status' => 'done',
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ isset($status) && $status == 'done' ? ' active' : '' }}"
                                                        id="assignedAbroadApplicationsLink">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                check_circle
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Đã hoàn thành</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="27">
                                                            {{ request()->ajax() ? App\Models\AbroadApplication::byBranch(\App\Library\Branch::getCurrentBranch())->filterByDone()->count() : ''  }}
                                                        </span>
                                                    </a>
                                                </div>
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>  
                        </div>



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
                                                        <a href="{{ action([App\Http\Controllers\Abroad\CourseController::class, 'add']) }}"
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
                                                    <a href="{{ action([App\Http\Controllers\Abroad\CourseController::class, 'index']) }}"
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
                                                    <a href="{{ action([App\Http\Controllers\Abroad\CourseController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="28">{{ request()->ajax() ? App\Models\Course::abroad()->get()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Course::OPENING_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link  {{ request()->status == App\Models\Course::OPENING_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Đang học</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="29">{{ request()->ajax() ? App\Models\Course::abroad()->getIsLearning()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Course::COMPLETED_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->status == App\Models\Course::COMPLETED_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Hoàn thành</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="30">{{ request()->ajax() ? App\Models\Course::abroad()->getIsStudied()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Course::WAITING_OPEN_STATUS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'courses' && request()->status == App\Models\Course::WAITING_OPEN_STATUS ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa học</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="31">{{ request()->ajax() ? App\Models\Course::abroad()->getIsUnstudied()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Abroad\CourseController::class, 'index'],
                                                        [
                                                            'status' => App\Models\Section::STATUS_STOPPED,
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ $sidebar == 'courses' && request()->status == App\Models\Section::STATUS_STOPPED ? 'active' : '' }}">
                                                        <span class="menu-title">Đã dừng</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="32">{{ request()->ajax() ? App\Models\Course::abroad()->getStoppedClass()->count() : ''  }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade {{ $menu == 'reporting' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_reports" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-5 pe-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">

                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div class="menu-item">
                                        <span class="accordion-button menu-link ms-4" data-bs-toggle="collapse"
                                            data-bs-target="#category-accordion">
                                            <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                Báo cáo
                                            </span>
                                            {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                        </span>
                                    </div>
                                    <div>
                                        
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3 {{ $sidebar == 'upsell' ? 'active ' : '' }}"
                                                href="{{ action([App\Http\Controllers\Abroad\Report\UpsellReportController::class, 'index']) }}">
                                                <span class="menu-icon">
                                                    <span class="material-symbols-rounded">
                                                        conversion_path
                                                    </span></span>
                                                <span class="menu-title">Báo cáo upsell</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                    </div>
                                    <div>
                                        
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3 {{ $sidebar == 'honorsThesis' ? 'active ' : '' }}"
                                                href="{{ action([App\Http\Controllers\Abroad\Report\HonorsThesisReportController::class, 'index']) }}">
                                                <span class="menu-icon">
                                                    <span class="material-symbols-rounded">
                                                        conversion_path
                                                    </span></span>
                                                <span class="menu-title">Báo cáo học luận</span>
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
        </div>
    </div>
</div>

<script>
    $(() => {
        sidebarShow.init();
        pickContactPopup.init();
        CreateContactRequestPopup.init();
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

    var pickContactPopup = function() {
        let popup;

        return {
            init: () => {
                popup = new Popup();
            },
            updateUrl: newUrl => {
                popup.url = newUrl;
                popup.load();
            },
            getPopup: () => {
                return popup;
            }
        }
    }();
    var CreateContactRequestPopup = function() {
        var popup;
        var btnCreate;

        // show campaign modal
        var showContactModal = function() {
            popup.load();
        };

        return {
            init: function() {
                // create campaign popup
                popup = new Popup({
                    url: "{{ action('\App\Http\Controllers\Abroad\ContactRequestController@create') }}",
                });

                // create campaign button
                btnCreate = document.getElementById('addContactRequestButton');

                // click on create campaign button
                btnCreate.addEventListener('click', (e) => {
                    e.preventDefault();

                    // show create campaign modal
                    showContactModal();
                });
            },

            getPopup: function() {
                return popup;
            }
        };
    }();
</script>
