@php
    $menu = $menu ?? null;
    $sidebar = $sidebar ?? null;
    $status = $status ?? null;
@endphp

<button id="kt_aside_show"
    class="aside-toggle btn btn-sm btn-icon border end-0 bottom-0 d-lg-flex rounded bg-white"
    data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
    data-kt-toggle-name="aside-minimize">

    <i class="ki-duotone ki-arrow-left fs-2 rotate-180"><span class="path1"></span><span
            class="path2"></span></i>
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
                    <!--begin::Nav item-->
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index']) }}"
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
                    <!--begin::Nav item-->
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Sales\ContactRequestController::class, 'index']) }}"
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

                    <!--Menu LIÊN HỆ-->
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Liên hệ"
                        data-bs-original-title="Liên hệ" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'contact' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Liên hệ" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                contacts
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Liên hệ
                                </span>
                            </div>
                        </a>
                        <!--end::Nav link-->
                    </li>

                    <!--Menu HỢP ĐỒNG-->
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\Sales\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL]) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'orders' && (isset($orderType) && $orderType != App\Models\Order::TYPE_REQUEST_DEMO) ? 'active' : '' }}"
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

                    <!--Menu KHÁCH HÀNG-->
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Học viên" data-bs-original-title="Học viên" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'customer' || $sidebar == 'customer' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Học viên" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                group
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Học viên
                                </span>
                            </div>
                        </a>
                        <!--end::Nav link-->
                    </li>

                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Ghi chú" data-bs-original-title="Ghi chú" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Sales\NoteLogController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'note-logs' || $sidebar == 'note-logs' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Ghi chú" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                event_note
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Ghi chú
                                </span>
                            </div>
                        </a>
                        <!--end::Nav link-->
                    </li>


                    <!--Menu KHÁCH HÀNG-->
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Dự thu"
                        data-bs-original-title="Dự thu" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\AccountKpiNoteController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'accountKpiNote' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Dự thu" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                lab_profile
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Dự thu
                                </span>
                            </div>
                        </a>
                        <!--end::Nav link-->
                    </li>
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\Sales\RefundRequestController::class, 'index']) }}"
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
                    <!--Menu BÁO CÁO-->
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Báo cáo"
                        data-bs-original-title="Báo cáo" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Sales\Report\ContractStatusController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'reporting' ? 'active' : '' }}"
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
                    <!--end::Nav item-->

                </ul>
                <!--end::Tabs-->
            </div>
            <!--end::Nav-->

        </div>
        <!--end::Nav-->
    </div>
    <!--end::Primary-->

    <!--begin::Secondary-->
    <div class="aside-secondary d-flex flex-row-fluid w-lg-230px  {{ $menu == 'dashboard' ? 'd-none' : '' }}">
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

                        @if ($menu == 'contact_request' || ($menu == 'orders' && (isset($orderType) && $orderType == App\Models\Order::TYPE_REQUEST_DEMO)))
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
                                                class="menu-item menu-accordion {{ $menu == 'contact_request' || $menu == 'tags' || ($menu == 'orders' && (isset($orderType) && $orderType == App\Models\Order::TYPE_REQUEST_DEMO)) ? ' show' : '' }}">
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#category-accordion">
                                                    <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                        Đơn hàng
                                                    </span>
                                                    {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                                </span>

                                                <div id="category-accordion-"
                                                    class="accordion-collapse collapse {{ $menu == 'contact_request' || $menu == 'tags' || ($menu == 'orders' && (isset($orderType) && $orderType == App\Models\Order::TYPE_REQUEST_DEMO)) ? ' hover show' : '' }}">

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
                                                        <a href="{{ action([App\Http\Controllers\Sales\ContactRequestController::class, 'index']) }}"
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

                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a href="{{ action([App\Http\Controllers\Sales\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_REQUEST_DEMO]) }}"
                                                            class="menu-link py-3 {{ $menu == 'orders' ? ' active' : '' }}">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    contract_edit
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Yêu cầu học thử</span></a>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>

                                                    {{-- <div
                                                        class="menu-item menu-accordion {{ $menu == 'tags' ? ' hover show' : '' }}">
                                                        <!--begin:Menu link-->
                                                        <span class="accordion-button menu-link d-none"
                                                            data-bs-toggle="collapse" data-bs-target="#tag-accordion">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    style
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Quản lý tags
                                                            </span>
                                                            <span
                                                                class="menu-arrow {{ $menu == 'tags' ? ' rotate ' : '' }}"></span>
                                                        </span>
                                                        <!--end:Menu link-->
                                                        <!--begin:Menu sub-->
                                                        <div id="tag-accordion"
                                                            class="accordion-collapse collapse {{ $menu == 'tags' ? ' hover show' : '' }}">
                                                            <!--begin:Menu item-->
                                                            <div class="menu-item ps-10 {{ $menu == 'tags' ? 'show' : '' }}"data-is-nav="nav"
                                                                data-nav="tag">

                                                                <!--begin:Menu link-->
                                                                <a class="menu-link {{ $menu == 'tags' ? 'active' : '' }}"
                                                                    data-action="under-construction"
                                                                    href="{{ action([App\Http\Controllers\Sales\TagController::class, 'index']) }}">
                                                                    <span class="menu-title">Danh sách</span>
                                                                </a>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu item-->
                                                            <!--begin:Menu item-->
                                                            <div class="menu-item ps-10">
                                                                <!--begin:Menu link-->
                                                                <a class="menu-link" data-action="under-construction"
                                                                    href="{{ action([App\Http\Controllers\Sales\TagController::class, 'create']) }}">
                                                                    <span class="menu-title">Thêm mới</span>
                                                                </a>
                                                                <!--end:Menu link-->
                                                            </div>

                                                        </div>

                                                    </div> --}}

                                                </div>


                                            </div>
                                        </div>
                                        <!--END::Danh mục chính-->

                                        <!--BEGIN::Trạng thái-->
                                        <div>
                                            <div
                                                class="menu-item menu-accordion {{ request()->lead_status_menu != '' || request()->lifecycle_stage_menu != '' ? ' ' : 'show' }}">
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#status-accordion">
                                                    <span
                                                        class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                        thái</span>
                                                    <span
                                                        class="menu-arrow {{ request()->status || $menu == 'customer' ? ' rotate' : '' }}"></span>
                                                </span>
                                                <div id="status-accordion"
                                                    class="accordion-collapse collapse {{ request()->status || $menu == 'customer' ? 'hide' : '' }} {{ request()->lead_status_menu != '' || request()->lifecycle_stage_menu != '' ? '' : 'show' }}">

                                                    <div class="menu-item">
                                                        <a href="{{ action([App\Http\Controllers\Sales\ContactRequestController::class, 'index']) }}"
                                                            class="menu-link {{ !request()->status && !request()->lead_status_menu && !request()->lifecycle_stage_menu ? 'active' : '' }}">
                                                            <span class="menu-title">Được bàn giao</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="15-00">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isAssigned()->count() : ''  }}
                                                                @else
                                                                    {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->isAssigned()->count() : '' }}
                                                                @endif </span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item d-none">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'is_new',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'is_new' ? 'active' : '' }}">
                                                            <span class="menu-title">Đơn hàng mới</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="11-1">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isNew()->count() : ''  }}
                                                                @else
                                                                    {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->isNew()->count() : '' }}
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item d-none">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'is_assigned',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'is_assigned' ? 'active' : '' }}">
                                                            <span class="menu-title">Được bàn giao</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="11-2">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isAssigned()->count() : ''  }}
                                                                @else
                                                                    {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->isAssigned()->count() : '' }}
                                                                @endif </span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'no_action_yet',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'no_action_yet' ? 'active' : '' }}">
                                                            <span class="menu-title">Chưa khai thác</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="11-3">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->noActionYet()->count() : ''  }}
                                                                @else
                                                                    {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->noActionYet()->count() : '' }}
                                                                @endif   </span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'has_action',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'has_action' ? 'active' : '' }}">
                                                            <span class="menu-title">Đã khai thác</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="11-4">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->hasAction()->count() : ''  }}
                                                                @else
                                                                    {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->hasAction()->count() : '' }}
                                                                @endif  </span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'has_order',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'has_order' ? 'active' : '' }}">
                                                            <span class="menu-title">Đã có hợp đồng</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="11-6">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->withOrders()->count() : ''  }}
                                                                @else
                                                                    {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->withOrders()->count() : '' }}
                                                                @endif  </span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'no_has_order',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'no_has_order' ? 'active' : '' }}">
                                                            <span class="menu-title">Chưa có hợp đồng</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="11-7">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isAssigned()->withoutOrders()->count() : ''  }}
                                                                @else
                                                                    {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->isAssigned()->withoutOrders()->count() : '' }}
                                                                @endif  </span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'has_reminder',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'has_reminder' ? 'active' : '' }}">
                                                            <span class="menu-title">Đã đặt lịch</span>
                                                            <span
                                                                class="menu-badge" sidebar-counter="11-8">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                
                                                                {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isAssigned()->haveReminder()->count() : ''  }}
                                                            @else
                                                                {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->isAssigned()->haveReminder()->count() : '' }}
                                                            @endif 
                                                          </span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'deleted',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                            <span class="menu-title">Đã xóa</span>
                                                            <span class="menu-badge" sidebar-counter="11-5">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isDeleted()->count() : ''  }}
                                                                @else
                                                                    {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->isDeleted()->count() : '' }}
                                                                @endif    
                                                            </span>

                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'outdated',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'outdated' ? 'active' : '' }}">
                                                            <span class="menu-title">Hết hạn (2 giờ)</span>
                                                            <span class="badge badge-danger" sidebar-counter="11-5x">
                                                                @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    {{ request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->outdated()->count() : ''  }}
                                                                @else
                                                                    {{ request()->ajax() ? Auth::user()->account->contactRequestsByAccount()->outdated()->count() : '' }}
                                                                @endif 
                                                                
                                                            </span>
                                                        </a>
                                                    </div>

                                                </div>

                                            </div>
                                        </div>
                                        <!--END::Trạng thái-->


                                        @if (false)
                                            <!--BEGIN::Lifecycle stage-->
                                            <div>
                                                <div
                                                    class="menu-item menu-accordion {{ request()->lifecycle_stage_menu != '' ? ' hover show ' : '' }}">
                                                    <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                        data-bs-target="#lifecycle-stage-accordion">
                                                        <span
                                                            class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Lifecycle
                                                            stage</span>
                                                        <span
                                                            class="menu-arrow {{ request()->lifecycle_stage_menu != '' ? ' rotate ' : '' }}"></span>
                                                    </span>
                                                    <div id="lifecycle-stage-accordion"
                                                        class="accordion-collapse collapse {{ request()->lifecycle_stage_menu != '' ? ' hover show ' : '' }}">
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'marketing-qualified-lead'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'marketing-qualified-lead' ? 'active' : '' }}">
                                                                <span class="menu-title">Marketing Qualified Lead</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="11-6">
                                                                    @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                        {{ request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isMarketingQualifiedLead()->count() : ''  }}
                                                                    @else
                                                                        {{ request()->ajax() ? Auth::user()->account->contactRequests()->isMarketingQualifiedLead()->count() : '' }}
                                                                    @endif   
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <!--end:Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'sale-qualified-lead'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'sale-qualified-lead' ? 'active' : '' }}">
                                                                <span class="menu-title">Sale Qualified Lead</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="11-7">
                                                                    @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                        {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isSaleQualifiedLead()->count() : ''  }}
                                                                    @else
                                                                        {{ request()->ajax() ? Auth::user()->account->contactRequests()->isSaleQualifiedLead()->count() : '' }}
                                                                    @endif    </span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'customer'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'customer' ? 'active' : '' }}">
                                                                <span class="menu-title">Customer</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="11-8">
                                                                    @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                        {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->lifecycleStageIsCustomer()->count() : ''  }}
                                                                    @else
                                                                        {{ request()->ajax() ? Auth::user()->account->contactRequests()->lifecycleStageIsCustomer()->count() : '' }}
                                                                    @endif    
                                                                        </span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'vip-customer'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'vip-customer' ? 'active' : '' }}">
                                                                <span class="menu-title">VIP Customer</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="11-9">
                                                                    @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                        {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isVIPCustomer()->count() : ''  }}
                                                                    @else
                                                                        {{ request()->ajax() ? Auth::user()->account->contactRequests()->isVIPCustomer()->count() : '' }}
                                                                    @endif    
                                                                    </span>
                                                            </a>
                                                        </div>
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Sales\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'lead'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'lead' ? 'active' : '' }}">
                                                                <span class="menu-title">Lead</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="14-1">
                                                                    @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                        {{request()->ajax() ? App\Models\ContactRequest::byBranch(\App\Library\Branch::getCurrentBranch())->isLead()->count() : ''  }}
                                                                    @else
                                                                        {{ request()->ajax() ? Auth::user()->account->contactRequests()->isLead()->count() : '' }}
                                                                    @endif  
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END::Lifecycle stage-->
                                        @endif
                                    </div>

                                </div>



                            </div>
                            <!--END::Đơn hàng-->
                        @endif


                        @if ($menu == 'contact')
                            <!--START::CONTACT-->

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
                                                    {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
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
                                                        <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index']) }}"
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
                                                            class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                            thái</span>
                                                        <span
                                                            class="menu-arrow {{ request()->status || $menu == 'customer' ? ' rotate' : '' }}"></span>
                                                    </span>
                                                    <div id="status-accordion" class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index']) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Đang hoạt động</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="13-2">
                                                                    @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    
                                                                        {{request()->ajax() ? App\Models\Contact::byBranch(\App\Library\Branch::getCurrentBranch())->active()->isNotCustomer()->count() : ''  }}
                                                                    @else
                                                                        {{ request()->ajax() ? Auth::user()->account->contacts()->active()->isNotCustomer()->count() : '' }}
                                                                @endif
                                                                    
                                                                
                                                                
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu items-->

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Sales\ContactController::class, 'index'],
                                                                [
                                                                    'status' => 'deleted',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                                <span class="menu-title">Đã xóa</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="13-3">
                                                                    @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                    
                                                                        {{request()->ajax() ? App\Models\Contact::byBranch(\App\Library\Branch::getCurrentBranch())->isDeleted()->count() : ''  }}
                                                                    @else
                                                                        {{ request()->ajax() ? Auth::user()->account->contacts()->isDeleted()->count() : '' }}
                                                                @endif
                                                                    </span>
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
                        @endif

                        @if ($menu == 'customer' || $sidebar)
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
                                                        Học viên
                                                    </span>
                                                    {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                                </span>

                                                <div id="category-accordion-"
                                                    class="accordion-collapse collapse {{ $menu == 'customer' || $sidebar == 'note-logs' ? ' hover show' : '' }}">

                                                    <div class="menu-item">
                                                        <!--begin:Menu link-->
                                                        <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index']) }}"
                                                            class="menu-link py-3 {{ $menu == 'customer' ? ' active' : '' }}">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    group
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Học viên</span></a>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>

                                                    <div
                                                        class="menu-item menu-accordion {{   $menu == 'note-logs' ||$sidebar == 'note-logs' ? 'hover show' : '' }}">
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
                                                                <a class="menu-link {{ $sidebar == 'note-logs'&& $status == '' ? ' active' : '' }}"
                                                                    href="{{ action([App\Http\Controllers\Sales\NoteLogController::class, 'index']) }}">
                                                                    <span class="menu-title">Danh sách</span>
                                                                </a>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu item-->
                                                            <!--begin:Menu item-->
                                                            <div class="menu-item ps-10">
                                                                <!--begin:Menu link-->
                                                                <a class="menu-link" id="addNoteLogSlideBar"
                                                                    href="{{ action([App\Http\Controllers\Sales\NoteLogController::class, 'create']) }}">
                                                                    <span class="menu-title">Thêm mới</span></a>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu item-->
                                                            <!--begin:Menu item-->
                                                            <div class="menu-item ps-10">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\NoteLogController::class, 'index'],
                                                                    [
                                                                        'status' => 'deleted',
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ $status == 'deleted' ? 'active' : '' }}">
                                                                    <span class="menu-title">Đã xóa</span>
                                                                    <span class="menu-badge" sidebar-counter="13-4">
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                        
                                                                            {{request()->ajax() ? App\Models\NoteLog::byBranch(\App\Library\Branch::getCurrentBranch())->deleted()->count() : ''  }}
                                                                        @else
                                                                        {{ request()->ajax() ? Auth::user()->account->noteLogs()->deleted()->count() : '' }}
                                                                    @endif </span>
                                                                
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
                                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng thái</span>
                                                                <span
                                                                    class="menu-arrow {{ request()->status || $menu == 'customer' ? ' rotate' : '' }}"></span>
                                                            </span>
                                                            <div id="status-accordion"
                                                                class="accordion-collapse collapse show">
                                                                <!--begin::Menu items-->
                                                                <div class="menu-item">
                                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index']) }}"
                                                                        class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                        <span class="menu-title">Đang hoạt động</span>
                                                                        <span
                                                                            class="menu-badge" sidebar-counter="13-5">{{ request()->ajax() ? Auth::user()->account->customers()->active()->count() : '' }}</span>
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu items-->

                                                                <div class="menu-item">
                                                                    <a href="{{ action(
                                                                        [App\Http\Controllers\Sales\CustomerController::class, 'index'],
                                                                        [
                                                                            'status' => 'deleted',
                                                                        ],
                                                                    ) }}"
                                                                        class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                                        <span class="menu-title">Đã xóa</span>
                                                                        <span
                                                                            class="menu-badge" sidebar-counter="13-6">{{ request()->ajax() ? Auth::user()->account->customers()->isDeleted()->count() : '' }}</span>
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
                        @endif

                        @if ($menu == 'orders' && (isset($orderType) && $orderType != App\Models\Order::TYPE_REQUEST_DEMO))
                            <!--START::ORDER-->
                            <div class="tab-pane fade {{ $menu == 'orders' && (isset($orderType) && $orderType != App\Models\Order::TYPE_REQUEST_DEMO) ? 'active show' : '' }}"
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
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>
                                            <div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Sales\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL]) }}"
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
                                                        <span class="menu-title">Thêm hợp đồng</span>
                                                    </a>
                                                </div>



                                                <!--BEGIN::Trạng thái-->
                                                <div>
                                                    <div class="menu-item menu-accordion show">
                                                        <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                            data-bs-target="#status-accordion">
                                                            <span
                                                                class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                                thái hợp đồng</span>
                                                        </span>
                                                        <div id="status-accordion"
                                                            class="accordion-collapse collapse show">
                                                            <!--begin::Menu items-->
                                                            <div class="menu-item">
                                                                <a href="{{ action([App\Http\Controllers\Sales\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL], ['type' => App\Models\Order::TYPE_GENERAL]) }}"
                                                                    class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                    <span class="menu-title">Tất cả</span>
                                                                    <span
                                                                        class="menu-badge" sidebar-counter="13-7">
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ Auth::user()->account->saleOrdersByAccount()->notDeleted()->getGeneral()->count() }}
                                                                        @endif
                                                                        </span>
                                                                </a>
                                                            </div>

                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\OrderController::class, 'index'],
                                                                    [
                                                                        'type' => App\Models\Order::TYPE_GENERAL,
                                                                        'status' => 'draft',
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == 'draft' ? 'active' : '' }}">
                                                                    <span
                                                                        class="menu-title">{{ trans('messages.order.status.draft') }}</span>
                                                                    <span
                                                                        class="menu-badge" sidebar-counter="13-8">
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->draft()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ request()->ajax() ? Auth::user()->account->saleOrdersByAccount()->notDeleted()->draft()->getGeneral()->count() : '' }}
                                                                        @endif 
                                                                    </span>
                                                                </a>
                                                            </div>

                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\OrderController::class, 'index'],
                                                                    [
                                                                        'type' => App\Models\Order::TYPE_GENERAL,
                                                                        'status' => 'pending',
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == 'pending' ? 'active' : '' }}">
                                                                    <span
                                                                        class="menu-title">{{ trans('messages.order.status.pending') }}</span>
                                                                    <span
                                                                        class="menu-badge" sidebar-counter="13-9">
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->pending()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ request()->ajax() ? Auth::user()->account->saleOrdersByAccount()->notDeleted()->pending()->getGeneral()->count() : '' }}
                                                                        @endif 
                                                                        </span>
                                                                </a>
                                                            </div>

                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\OrderController::class, 'index'],
                                                                    [
                                                                        'type' => App\Models\Order::TYPE_GENERAL,
                                                                        'status' => App\Models\Order::STATUS_APPROVED,
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == App\Models\Order::STATUS_APPROVED ? 'active' : '' }}">
                                                                    <span
                                                                        class="menu-title">{{ trans('messages.order.status.approved') }}</span>
                                                                    <span
                                                                        class="menu-badge" sidebar-counter="14-3">
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->approved()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ request()->ajax() ? Auth::user()->account->saleOrdersByAccount()->notDeleted()->approved()->getGeneral()->count() : '' }}
                                                                        @endif 
                                                                        </span>
                                                                </a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\OrderController::class, 'index'],
                                                                    [
                                                                        'type' => App\Models\Order::TYPE_GENERAL,
                                                                        'status' => App\Models\Order::STATUS_DELETED,
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == App\Models\Order::STATUS_DELETED ? 'active' : '' }}">
                                                                    <span class="menu-title">Đã xóa</span>
                                                                    <span class="menu-badge" sidebar-counter="14-4">
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->deleted()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ request()->ajax() ? Auth::user()->account->saleOrdersByAccount()->deleted()->getGeneral()->count() : '' }}
                                                                        @endif 
                                                                    </span>

                                                                </a>
                                                            </div>
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\OrderController::class, 'index'],
                                                                    [
                                                                        'type' => App\Models\Order::TYPE_GENERAL,
                                                                        'status' => 'rejected',
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == 'rejected' ? 'active' : '' }}">
                                                                    <span
                                                                        class="menu-title">{{ trans('messages.order.status.rejected') }}</span>

                                                                    <span class="menu-badge" sidebar-counter="14-5">
                                                                        
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->rejected()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ request()->ajax() ? Auth::user()->account->saleOrdersByAccount()->notDeleted()->rejected()->getGeneral()->count() : '' }}
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
                                                            data-bs-target="#status-accordion">
                                                            <span
                                                                class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Công
                                                                nợ</span>
                                                        </span>
                                                        <div id="status-accordion"
                                                            class="accordion-collapse collapse show">
                                                            <!--begin::Menu items-->
                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\OrderController::class, 'index'],
                                                                    [
                                                                        'type' => App\Models\Order::TYPE_GENERAL,
                                                                        'status' => App\Models\Order::STATUS_REACHING_DUE_DATE,
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == App\Models\Order::STATUS_REACHING_DUE_DATE ? 'active' : '' }}">
                                                                    <span
                                                                        class="menu-title">{{ trans('messages.payment_reminders.status.reaching_due_date') }}</span>
                                                                    <span
                                                                        class="menu-badge" sidebar-counter="14-6">
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->reachingDueDate()->checkIsNotPaid()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ request()->ajax() ? Auth::user()->account->saleOrders()->notDeleted()->reachingDueDate()->checkIsNotPaid()->getGeneral()->count() : '' }}
                                                                        
                                                                        @endif 
                                                                    </span>
                                                                </a>
                                                            </div>

                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\OrderController::class, 'index'],
                                                                    [
                                                                        'type' => App\Models\Order::TYPE_GENERAL,
                                                                        'status' => App\Models\Order::STATUS_PART_PAID,
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == App\Models\Order::STATUS_PART_PAID ? 'active' : '' }}">
                                                                    <span
                                                                        class="menu-title">{{ trans('messages.payment_reminders.status.part_paid') }}</span>
                                                                    <span
                                                                        class="menu-badge" sidebar-counter="14-7">
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->approved()->partPaid()->checkIsNotPaid()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ request()->ajax() ? Auth::user()->account->saleOrders()->notDeleted()->approved()->partPaid()->checkIsNotPaid()->getGeneral()->count() : '' }}
                                                                        
                                                                        @endif 
                                                                    </span>
                                                                        
                                                                </a>
                                                            </div>

                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\OrderController::class, 'index'],
                                                                    [
                                                                        'type' => App\Models\Order::TYPE_GENERAL,
                                                                        'status' => App\Models\Order::STATUS_PAID,
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == App\Models\Order::STATUS_PAID ? 'active' : '' }}">
                                                                    <span
                                                                        class="menu-title">{{ trans('messages.payment_reminders.status.paid') }}</span>
                                                                    <span
                                                                        class="menu-badge" sidebar-counter="14-8">
                                                                        @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->checkIsPaid()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ request()->ajax() ? Auth::user()->account->saleOrders()->notDeleted()->checkIsPaid()->getGeneral()->count() : '' }}
                                                                        
                                                                        @endif  
                                                                    </span>
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Sales\OrderController::class, 'index'],
                                                                    [
                                                                        'type' => App\Models\Order::TYPE_GENERAL,
                                                                        'status' => App\Models\Order::STATUS_OVER_DUE_DATE,
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link {{ request()->status == App\Models\Order::STATUS_OVER_DUE_DATE ? 'active' : '' }}">
                                                                    <span
                                                                        class="menu-title">{{ trans('messages.payment_reminders.status.over_due_date') }}</span>
                                                                        <span
                                                                        class="badge badge-danger" sidebar-counter="14-8rr">
                                                                            @if ( Auth::user()->hasPermission(App\Library\Permission::SALES_DASHBOARD_ALL))
                                                                            {{request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDeleted()->overDueDate()->checkIsNotPaid()->getGeneral()->count() : ''  }}
                                                                        @else
                                                                            {{ request()->ajax() ? Auth::user()->account->saleOrders()->notDeleted()->overDueDate()->checkIsNotPaid()->getGeneral()->count() : '' }}
                                                                        
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
                        @endif

                        <!--START::Dự thu-->
                        @if ($menu == 'accountKpiNote')
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
                                                        <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index']) }}"
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
                        @endif

                        <!--END::Dự thu-->
                        @if ($menu == 'refunds')
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
                                                        <a href="{{ action([App\Http\Controllers\Sales\RefundRequestController::class, 'index']) }}"
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
                                                                    <a href="{{ action([App\Http\Controllers\Sales\RefundRequestController::class, 'index']) }}"
                                                                        class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                        <span class="menu-title">Tất cả</span>
                                                                        <span
                                                                            class="menu-badge" sidebar-counter="14-9">{{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}</span>
                                                                    </a>
                                                                </div>
        
                                                                <div class="menu-item">
                                                                    <a href="{{ action(
                                                                        [App\Http\Controllers\Sales\RefundRequestController::class, 'index'],
                                                                        [
                                                                            'status' => App\Models\RefundRequest::STATUS_PENDING,
                                                                        ],
                                                                    ) }}"
                                                                        class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_PENDING ? 'active' : '' }}">
                                                                        <span
                                                                            class="menu-title">{{ trans('messages.refund_requests.status.pending') }}</span>
                                                                        <span
                                                                            class="menu-badge" sidebar-counter="15-1">{{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->pending()->count() : ''  }}</span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="{{ action(
                                                                        [App\Http\Controllers\Sales\RefundRequestController::class, 'index'],
                                                                        [
                                                                            'status' => App\Models\RefundRequest::STATUS_APPROVED,
                                                                        ],
                                                                    ) }}"
                                                                        class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_APPROVED ? 'active' : '' }}">
                                                                        <span
                                                                            class="menu-title">{{ trans('messages.refund_requests.status.approved') }}</span>
                                                                        <span class="menu-badge" sidebar-counter="15-2">
                                                                            {{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->approved()->count() : ''  }}
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="{{ action(
                                                                        [App\Http\Controllers\Sales\RefundRequestController::class, 'index'],
                                                                        [
                                                                            'status' => App\Models\RefundRequest::STATUS_REJECTED,
                                                                        ],
                                                                    ) }}"
                                                                        class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_REJECTED ? 'active' : '' }}">
                                                                        <span
                                                                            class="menu-title">{{ trans('messages.refund_requests.status.rejected') }}</span>
                                                                        <span class="menu-badge" sidebar-counter="15-3">
                                                                            {{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->rejected()->count() : ''  }}
                                                                        </span>
                                                                    </a>
                                                                </div>
                                                                <div class="menu-item">
                                                                    <a href="{{ action(
                                                                        [App\Http\Controllers\Sales\RefundRequestController::class, 'index'],
                                                                        [
                                                                            'status' => App\Models\RefundRequest::STATUS_CANCEL,
                                                                        ],
                                                                    ) }}"
                                                                        class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_CANCEL ? 'active' : '' }}">
                                                                        <span
                                                                            class="menu-title">{{ trans('messages.refund_requests.status.cancel') }}</span>
                                                                        <span class="menu-badge" sidebar-counter="15-4">
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
                        @endif

                        <!--START::REPORT-->
                        @if ($menu == 'reporting')
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
                                                <a class="menu-link py-3 {{ $sidebar == 'contract-status' ? 'active ' : '' }}"
                                                    href="{{ action([App\Http\Controllers\Sales\Report\ContractStatusController::class, 'index']) }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            contract
                                                        </span></span>
                                                    <span class="menu-title">Báo cáo tình trạng yêu cầu hợp đồng</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link py-3 {{ $sidebar == 'sales-report' ? 'active ' : '' }}"
                                                    href="{{ action([App\Http\Controllers\Sales\Report\SalesReportController::class, 'index']) }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            real_estate_agent
                                                        </span></span>
                                                    <span class="menu-title">Báo cáo doanh thu</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <div
                                                class="menu-item menu-accordion {{ $sidebar == 'daily-sales-kpi-report' || $sidebar == 'monthly-sales-kpi-report' ? 'hover show' : '' }}">
                                                <!--begin:Menu link-->
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#note-log-accordion">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            lab_profile
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">Báo cáo KPI của Sale</span>
                                                    <span
                                                        class="menu-arrow {{ $sidebar == 'daily-sales-kpi-report' || $sidebar == 'monthly-sales-kpi-report' ? ' rotate ' : '' }}"></span>
                                                </span>

                                                <!--end:Menu link-->
                                                <!--begin:Menu sub-->
                                                <div id="note-log-accordion"
                                                    class="accordion-collapse collapse {{ $sidebar == 'daily-sales-kpi-report' || $sidebar == 'monthly-sales-kpi-report' ? ' hover show' : '' }}">
                                                    <!--begin:Menu item-->
                                                    <div class="menu-item ps-10">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link {{ $sidebar == 'daily-sales-kpi-report' ? ' active' : '' }}"
                                                            href="{{ action([App\Http\Controllers\Sales\Report\KPIReportController::class, 'indexDailyKPIReportIndex']) }}">
                                                            <span class="menu-title">Theo khoảng thời gian</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->
                                                    {{-- <div class="menu-item ps-10 d-none">
                                                        <!--begin:Menu link-->
                                                        <a class="menu-link {{ $sidebar == 'monthly-sales-kpi-report' ? ' active' : '' }}"
                                                            href="{{ action([App\Http\Controllers\Sales\Report\KPIReportController::class, 'indexMonthlyKPIReport']) }}">
                                                            <span class="menu-title">Theo quý</span>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div> --}}
                                                    <!--end:Menu item-->
                                                    <!--begin:Menu item-->

                                                </div>
                                                <!--end:Menu sub-->
                                            </div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link py-3 {{ $sidebar == 'upsell-report' ? 'active ' : '' }}"
                                                    href="{{ action([App\Http\Controllers\Sales\Report\UpsellReportController::class, 'index']) }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            sell
                                                        </span></span>
                                                    <span class="menu-title">Báo cáo upsell đào tạo</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link py-3 {{ $sidebar == 'payment-report' ? 'active ' : '' }}"
                                                    href="{{ action([App\Http\Controllers\Sales\Report\PaymentReportController::class, 'index']) }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            payments
                                                        </span></span>
                                                    <span class="menu-title">Báo cáo tiến độ thanh toán theo hợp
                                                        đồng</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link py-3 {{ $sidebar == 'revenue-report' ? 'active ' : '' }}"
                                                    href="{{ action([App\Http\Controllers\Sales\Report\RevenueReportController::class, 'index']) }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            point_of_sale
                                                        </span></span>
                                                    <span class="menu-title">Báo cáo dự thu của Sale</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link py-3 {{ $sidebar == 'conversion-rate' ? 'active ' : '' }}"
                                                    href="{{ action([App\Http\Controllers\Sales\Report\ConversionRateReportController::class, 'index']) }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            conversion_path
                                                        </span></span>
                                                    <span class="menu-title">Báo cáo tỷ lệ chuyển đổi theo đơn hàng</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif
                        <!--END::REPORT-->
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Wrapper-->
            </div>
        </div>
        <!--end::Workspace-->
    </div>
    <!--end::Secondary-->


</div>

<script>
    $(() => {
        sideBarIndex.init();
        // AddCustomer.init();
        AddContact.init();
        sidebarShow.init();
        addNotlogHandle.init();

        AddContactKpiNote.init();

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

    var sideBarIndex = function() {
        return {
            init: () => {
                pickContactPopup.init();
            }
        }
    }();

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

    // navItems.forEach(function(navItem) {
    //     navItem.addEventListener('click', function() {
    //         aside.classList.toggle('d-none');
    //         // toggleButton.classList.toggle('active');
    //     });
    // });

    // var AddCustomer = function() {
    //     return {
    //         init: function() {
    //             btnSubmit = document.getElementById('addCustomerSearch');
    //             btnSubmit.addEventListener('click', function() {
    //                 CreateCustomerPopup.getPopup().load();

    //             })
    //         }
    //     }
    // }();

    var AddContact = function() {
        return {
            init: function() {
                btnSubmit = document.getElementById('addContactSearch');

                if (btnSubmit) {
                    btnSubmit.addEventListener('click', function() {
                        CreateContactPopup.getPopup().load();

                    })
                }
            }
        }
    }();

    var AddContactKpiNote = function() {
        return {
            init: function() {
                btnSubmit = document.getElementById('addAccountKpiNote');

                if (btnSubmit) {
                    btnSubmit.addEventListener('click', function() {
                        CreateAccountKpiPopup.getPopup().load();

                    });
                }
            }
        }
    }();

    var addNotlogHandle = function() {
        return {
            init: () => {
                document.querySelector('#addNoteLogSlideBar').addEventListener('click', e => {
                    e.preventDefault();
                    CreateNotePopup.updateUrl(
                        "{{ action('\App\Http\Controllers\Sales\NoteLogController@create') }}");
                });
            }
        }
    }();



    // document.querySelector("#menu-customer-par").addEventListener('click', function() {
    //     const upIcon = this.querySelector('.up-status-icon');
    //     const downIcon = this.querySelector('.down-status-icon');

    //     if (upIcon.classList.contains('d-none')) {
    //         upIcon.classList.remove('d-none');
    //         downIcon.classList.add('d-none');
    //     } else {
    //         upIcon.classList.add('d-none');
    //         downIcon.classList.remove('d-none');
    //     }
    // });

    // document.querySelector("#menu-order-par").addEventListener('click', function() {
    //     const upIcon = this.querySelector('.up-status-icon');
    //     const downIcon = this.querySelector('.down-status-icon');

    //     if (upIcon.classList.contains('d-none')) {
    //         upIcon.classList.remove('d-none');
    //         downIcon.classList.add('d-none');
    //     } else {
    //         upIcon.classList.add('d-none');
    //         downIcon.classList.remove('d-none');
    //     }
    // });

    //
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
                    url: "{{ action('\App\Http\Controllers\Sales\ContactRequestController@create') }}",
                });

                // create campaign button
                btnCreate = document.getElementById('addContactRequestButton');

                // click on create campaign button
                if (btnCreate) {
                    btnCreate.addEventListener('click', (e) => {
                        e.preventDefault();

                        // show create campaign modal
                        showContactModal();
                    });
                }
            },

            getPopup: function() {
                return popup;
            }
        };
    }();
</script>
