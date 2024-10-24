<button id="kt_aside_show" class="aside-toggle btn btn-sm btn-icon border end-0 bottom-0 d-lg-flex rounded bg-white"
    data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="aside-minimize">

    <i class="ki-duotone ki-arrow-left fs-2 rotate-180"><span class="path1"></span><span class="path2"></span></i>
</button>
<div id="kt_aside" class="aside aside-extended pe-3" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">
    <!--begin::Primary-->
    <div class="aside-primary d-flex flex-column align-items-lg-end flex-row-auto pt-2 ">

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
                        <a href="{{ action([App\Http\Controllers\Marketing\DashboardController::class, 'index']) }}"
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
                        <!--end::Nav link-->
                    </li>
                    <!--end::Nav item-->

                    <!--begin::Nav item-->
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'contact_request' ? 'active' : '' }}"
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
                    <!--begin::Nav item-->
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Liên hệ"
                        data-bs-original-title="Liên hệ" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Marketing\ContactController::class, 'index']) }}"
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
                    <!--end::Nav item-->
                    <!--begin::Nav item-->
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập/ Xuất dữ liệu" data-bs-original-title="Nhập/ Xuất dữ liệu"
                        data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Marketing\ExportController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'importExport' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Nhập/ Xuất dữ liệu"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                downloading
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Nhập/Xuất
                                </span>
                            </div>
                        </a>
                        <!--end::Nav link-->
                    </li>
                    <!--end::Nav item-->






                    <!--begin::Nav item-->
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Báo cáo"
                        data-bs-original-title="Báo cáo" data-kt-initialized="1">
                        <a href="{{ action([App\Http\Controllers\Marketing\ReportController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'report' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Báo cáo" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                monitoring
                            </span>
                            <div>
                                <span class="pt-2 fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Báo cáo
                                </span>
                            </div>

                        </a>
                        <!--begin::Nav link-->

                        <!--end::Nav link-->
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
    <div
        class="aside-secondary d-flex flex-row-fluid w-lg-230px {{ $menu == 'report' || $menu == 'dashboard' ? 'd-none' : '' }}">
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
                        @if ($menu == 'contact_request')
                            <!--BEGIN::Đơn hàng -->
                            <div class="tab-pane fade {{ $menu == 'contact_request' ? 'active show' : '' }}"
                                id="kt_aside_nav_tab_contacts" role="tabpanel">
                                <!--begin::Items-->


                                <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                    id="kt_aside_menu" data-kt-menu="true">
                                    <div id="kt_aside_menu_wrapper" class="menu-fit">

                                        <!--BEGIN::Danh mục chính-->
                                        <div>
                                            <div
                                                class="menu-item menu-accordion {{ $menu == 'contact_request' || $menu == 'tags' ? ' show' : '' }}">
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#category-accordion">
                                                    <span
                                                        class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                        đơn hàng
                                                    </span>
                                                    {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                                </span>

                                                <div id="category-accordion-"
                                                    class="accordion-collapse collapse {{ $menu == 'contact_request' || $menu == 'tags' ? ' hover show' : '' }}">

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
                                                        <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index']) }}"
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

                                                    <div
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
                                                                    href="{{ action([App\Http\Controllers\Marketing\TagController::class, 'index']) }}">
                                                                    <span class="menu-title">Danh sách</span>
                                                                </a>
                                                                <!--end:Menu link-->
                                                            </div>
                                                            <!--end:Menu item-->
                                                            <!--begin:Menu item-->
                                                            <div class="menu-item ps-10">
                                                                <!--begin:Menu link-->
                                                                <a class="menu-link" data-action="under-construction"
                                                                    href="{{ action([App\Http\Controllers\Marketing\TagController::class, 'create']) }}">
                                                                    <span class="menu-title">Thêm mới</span>
                                                                </a>
                                                                <!--end:Menu link-->
                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>


                                            </div>
                                        </div>
                                        <!--END::Danh mục chính-->



                                        <!--BEGIN::Trạng thái-->
                                        <div>
                                            <div
                                                class="menu-item menu-accordion {{ request()->lead_status_menu != '' || request()->lifecycle_stage_menu != '' ? ' ' : 'show' }}">
                                                <span class="accordion-button menu-link show" data-bs-toggle="collapse"
                                                    data-bs-target="#status-accordion">
                                                    <span
                                                        class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                        thái</span>
                                                        {{ request()->ajax() ? App\Models\ContactRequest::activeCount() : '' }}
                                                    <span
                                                        class="menu-arrow {{ request()->status || $menu == 'customer' ? ' rotate' : '' }}"></span>
                                                </span>
                                                <div id="status-accordion"
                                                    class="accordion-collapse collapse {{ request()->status || $menu == 'customer' ? 'hide' : '' }} {{ request()->lead_status_menu != '' || request()->lifecycle_stage_menu != '' ? '' : 'show' }}">

                                                    <div class="menu-item">
                                                        <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index']) }}"
                                                            class="menu-link {{ !request()->status && !request()->lead_status_menu && !request()->lifecycle_stage_menu ? 'active' : '' }}">
                                                            <span class="menu-title">Tất cả</span>
                                                            <span class="menu-badge"
                                                                sidebar-counter="7-1">{{ request()->ajax() ? App\Models\ContactRequest::activeCount() : '' }}</span>
                                                        </a>
                                                    </div>
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'is_new',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'is_new' ? 'active' : '' }}">
                                                            <span class="menu-title">Đơn hàng mới</span>
                                                            <span class="menu-badge"
                                                                sidebar-counter="7-2">{{ request()->ajax() ? App\Models\ContactRequest::isNew()->count() : '' }}</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'is_assigned',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'is_assigned' ? 'active' : '' }}">
                                                            <span class="menu-title">Đã bàn giao</span>
                                                            <span class="menu-badge"
                                                                sidebar-counter="7-3">{{ request()->ajax() ? App\Models\ContactRequest::isAssignedCount() : '' }}</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'has_action',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'has_action' ? 'active' : '' }}">
                                                            <span class="menu-title">Đã khai thác</span>
                                                            <span class="menu-badge"
                                                                sidebar-counter="7-4">{{ request()->ajax() ? App\Models\ContactRequest::hasActionCount() : '' }}</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->

                                                    <!--begin::Menu item-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'no_action_yet',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'no_action_yet' ? 'active' : '' }}">
                                                            <span class="menu-title">Chưa khai thác</span>
                                                            <span class="menu-badge"
                                                                sidebar-counter="7-5">{{ request()->ajax() ? App\Models\ContactRequest::noActionYet()->count() : '' }}</span>
                                                        </a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'deleted',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                            <span class="menu-title">Đã xóa</span>
                                                            <span class="menu-badge" sidebar-counter="7-6">
                                                                {{ request()->ajax() ? App\Models\ContactRequest::isDeleted()->count() : '' }}
                                                            </span>

                                                        </a>
                                                    </div>
                                                    {{-- <div class="menu-item">
                                                        <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'is_error']) }}"
                                                            class="menu-link {{ request()->status == 'outdated' ? 'active' : '' }}">
                                                            <span class="menu-title">Sai số</span>
                                                            <span class="menu-badge" sidebar-counter="7-7">
                                                                @if (request()->ajax() && App\Models\ContactRequest::outdated()->count())
                                                                    <span
                                                                        class="badge badge-danger">{{ request()->ajax() ? App\Models\ContactRequest::outdated()->count() : ''  }}</span>
                                                                @else
                                                                    0
                                                                @endif
                                                            </span>
                                                        </a>
                                                    </div> --}}
                                                
                                                    <div class="menu-item d-none">
                                                        <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'ls_error']) }}"
                                                            class="menu-link {{ request()->lead_status_menu == 'ls_error' ? 'active' : '' }}">
                                                            <span class="menu-title">Sai số</span>
                                                            <span class="menu-badge"
                                                                sidebar-counter="7-8">{{ request()->ajax() ? App\Models\ContactRequest::isError()->count() : '' }}</span>
                                                        </a>
                                                    </div>
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item">
                                                        <a href="{{ action(
                                                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                            [
                                                                'status' => 'outdated',
                                                            ],
                                                        ) }}"
                                                            class="menu-link {{ request()->status == 'outdated' ? 'active' : '' }}">
                                                            <span class="menu-title">Hết hạn (2 giờ)</span>
                                                            <span class="menu-badge">
                                                                <span class="badge badge-danger" sidebar-counter="7-9">
                                                                    {{ request()->ajax() ? App\Models\ContactRequest::outdated()->count() : '' }}
                                                                </span>
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
                                                                [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'marketing-qualified-lead'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'marketing-qualified-lead' ? 'active' : '' }}">
                                                                <span class="menu-title">Marketing Qualified Lead</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-1">{{ request()->ajax() ? App\Models\ContactRequest::isMarketingQualifiedLead()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end:Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'sale-qualified-lead'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'sale-qualified-lead' ? 'active' : '' }}">
                                                                <span class="menu-title">Sale Qualified Lead</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-2">{{ request()->ajax() ? App\Models\ContactRequest::isSaleQualifiedLead()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'customer'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'customer' ? 'active' : '' }}">
                                                                <span class="menu-title">Customer</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-3">{{ request()->ajax() ? App\Models\ContactRequest::lifecycleStageIsCustomer()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'vip-customer'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'vip-customer' ? 'active' : '' }}">
                                                                <span class="menu-title">VIP Customer</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-4">{{ request()->ajax() ? App\Models\ContactRequest::isVIPCustomer()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                                                                ['lifecycle_stage_menu' => 'lead'],
                                                            ) }}"
                                                                class="menu-link {{ request()->lifecycle_stage_menu == 'lead' ? 'active' : '' }}">
                                                                <span class="menu-title">Lead</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-5">{{ request()->ajax() ? App\Models\ContactRequest::isLead()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!--END::Lifecycle stage-->
                                        @endif

                                        @if (true)
                                            <!--BEGIN::Lead status-->
                                            <div>
                                                <div
                                                    class="menu-item menu-accordion {{ request()->lead_status_menu != '' ? ' hover show ' : '' }}">
                                                    <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                        data-bs-target="#lead-status-accordion">
                                                        <span
                                                            class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Lead
                                                            status</span>
                                                        <span
                                                            class="menu-arrow {{ request()->lead_status_menu != '' ? ' rotate ' : '' }}"></span>
                                                    </span>
                                                    <div id="lead-status-accordion" 
                                                        class="accordion-collapse collapse  {{ request()->lead_status_menu != '' ? ' hover show ' : '' }}">
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                                [
                                                                    'lead_status_menu' => App\Models\ContactRequest::LS_ERROR,
                                                                    ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_error' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_error') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-8">{{ request()->ajax() ? App\Models\ContactRequest::isError()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                            [
                                                                'lead_status_menu' => App\Models\ContactRequest::LS_NOT_PICK_UP,
                                                            ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_not_pick_up' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_not_pick_up') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-7">{{ request()->ajax() ? App\Models\ContactRequest::isNotPickup()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                                [
                                                                    'lead_status_menu' => App\Models\ContactRequest::LS_NOT_PICK_UP_MANY_TIMES,
                                                                    ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_not_pick_up_many_times' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_not_pick_up_many_times') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-9">{{ request()->ajax() ? App\Models\ContactRequest::isNotPickupManyTimes()->count() : '' }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                                [
                                                                    'lead_status_menu' => App\Models\ContactRequest::LS_DUPLICATE_DATA,
                                                                    ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_duplicate_data' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_duplicate_data') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-10">{{ request()->ajax() ? App\Models\ContactRequest::isDuplicateData()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                                [
                                                                    'lead_status_menu' => App\Models\ContactRequest::LS_NOT_POTENTIAL,
                                                                    ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_not_potential' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_not_potential') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-11">{{ request()->ajax() ? App\Models\ContactRequest::isNotPotential()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                                [
                                                                    'lead_status_menu' => App\Models\ContactRequest::LS_HAS_REQUEST,
                                                                    ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_has_request' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_has_request') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-12">{{ request()->ajax() ? App\Models\ContactRequest::isHasRequest()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                                [
                                                                    'lead_status_menu' => App\Models\ContactRequest::LS_FOLLOW,
                                                                    ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_follow' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_follow') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-13">{{ App\Models\ContactRequest::isFollow()->count() }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                                [
                                                                    'lead_status_menu' => App\Models\ContactRequest::LS_POTENTIAL,
                                                                    ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_potential' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_potential') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-14">{{ request()->ajax() ? App\Models\ContactRequest::isPotential()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                            [
                                                                'lead_status_menu' => App\Models\ContactRequest::LS_MAKING_CONSTRACT,
                                                                ]) }}"
                                                            class="menu-link {{ request()->lead_status_menu == 'ls_making_contract' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_making_contract') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-15">{{ request()->ajax() ? App\Models\ContactRequest::isAgreement()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                                [
                                                                    'lead_status_menu' => App\Models\ContactRequest::LS_HAS_CONSTRACT,
                                                                    ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_customer' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_customer') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-16">{{ request()->ajax() ? App\Models\ContactRequest::isHasContract()->count() : '' }}</span>
                                                            </a>
                                                        </div>

                                                        {{-- <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], 
                                                                [
                                                                    'lead_status_menu' => App\Models\ContactRequest::LS_NA,
                                                                    ]) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'ls_na' ? 'active' : '' }}">
                                                                <span class="menu-title">{{ trans('messages.contact_request.lead_status.ls_na') }}</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-16">{{ request()->ajax() ? App\Models\ContactRequest::isNA()->count() : '' }}</span>
                                                            </a>
                                                        </div> --}}

                                                    
                                                    
                                                        {{-- <div class="menu-item d-none">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'kcnc']) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'kcnc' ? 'active' : '' }}">
                                                                <span class="menu-title">KCNC</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="8-9">{{ request()->ajax() ? App\Models\ContactRequest::isKCNC()->count() : '' }}</span>
                                                            </a>
                                                        </div> --}}
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        {{-- <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'khach_hang']) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'khach_hang' ? 'active' : '' }}">
                                                                <span class="menu-title">Khách hàng</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="10-00">{{ request()->ajax() ? App\Models\ContactRequest::isKhachHang()->count() : ''  }}</span>
                                                            </a>
                                                        </div> --}}
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        {{-- <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'deposits']) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'deposits' ? 'active' : '' }}">
                                                                <span class="menu-title">Đã đặt cọc</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="9-1">{{ request()->ajax() ? App\Models\ContactRequest::isDeposits()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item d-none">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'demand']) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'demand' ? 'active' : '' }}">
                                                                <span class="menu-title">Có đơn hàng</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="9-2">{{ request()->ajax() ? App\Models\ContactRequest::isDemand()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'follow']) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'follow' ? 'active' : '' }}">
                                                                <span class="menu-title">Follow Dài</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="9-3">{{ request()->ajax() ? App\Models\ContactRequest::isFollow()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'potential']) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'potential' ? 'active' : '' }}">
                                                                <span class="menu-title">Tiềm năng</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="9-4">{{ request()->ajax() ? App\Models\ContactRequest::isPotential()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'agreement']) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'agreement' ? 'active' : '' }}">
                                                                <span class="menu-title">Đang làm hợp đồng</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="9-5">{{ request()->ajax() ? App\Models\ContactRequest::isAgreement()->count() : '' }}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'as-agreement']) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'as-agreement' ? 'active' : '' }}">
                                                                <span class="menu-title">Hợp đồng AS</span>
                                                                <span class="menu-badge"
                                                                    sidebar-counter="9-6">{{ request()->ajax() ? App\Models\ContactRequest::isASAgreement()->count() : '' }}</span>
                                                            </a>
                                                        </div> --}}
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        {{-- <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index'], ['lead_status_menu' => 'referrer']) }}"
                                                                class="menu-link {{ request()->lead_status_menu == 'referrer' ? 'active' : '' }}">
                                                                <span class="menu-title">Khách giới thiệu khách hàng
                                                                    khác</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="9-7">{{ request()->ajax() ? App\Models\ContactRequest::isReferrer()->count() : ''  }}</span>
                                                            </a>
                                                        </div> --}}

                                                    </div>



                                                </div>
                                            </div>
                                            <!--END::Lead status-->
                                        @endif

                                    </div>

                                </div>



                            </div>
                            <!--END::Đơn hàng-->
                        @endif


                        @if ($menu == 'contact')
                            <!--BEGIN::Liên hệ-->
                            <div class="tab-pane fade {{ $menu == 'contact' ? 'active show' : '' }}"
                                id="kt_aside_nav_tab_contacts" role="tabpanel">
                                <!--begin::Items-->


                                <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                    id="kt_aside_menu" data-kt-menu="true">
                                    <div id="kt_aside_menu_wrapper" class="menu-fit">

                                        <!--BEGIN::Danh mục chính-->
                                        <div>
                                            <div
                                                class="menu-item menu-accordion {{ $menu == 'contact' || $menu == 'tags' || $menu == 'note-logs' ? ' show' : '' }}">
                                                <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                    data-bs-target="#category-accordion">
                                                    <span
                                                        class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                        Liên hệ
                                                    </span>
                                                    {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                                </span>

                                                <div id="category-accordion-"
                                                    class="accordion-collapse collapse {{ $menu == 'contact' || $menu == 'tags' ? ' hover show' : '' }}">

                                                    <div data-is-nav="nav" data-nav="add-customer"
                                                        class="menu-item d-none">
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
                                                        <a href="{{ action([App\Http\Controllers\Marketing\ContactController::class, 'index']) }}"
                                                            class="menu-link py-3 {{ $sidebar == 'contact' ? ' active' : '' }}">
                                                            <span class="menu-icon">
                                                                <span class="material-symbols-rounded">
                                                                    contacts
                                                                </span>
                                                            </span>
                                                            <span class="menu-title">Liên hệ</span></a>
                                                        </a>
                                                        <!--end:Menu link-->
                                                    </div>

                                                    <div id="category-accordion-"
                                                        class="accordion-collapse collapse {{ $menu == 'contact' || $sidebar == 'note-logs' ? ' hover show' : '' }}">

                                                        <div
                                                            class="menu-item menu-accordion {{ $sidebar == 'note-logs' ? 'hover show' : '' }}">
                                                            <!--begin:Menu link-->
                                                            <span class="accordion-button menu-link"
                                                                data-bs-toggle="collapse"
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
                                                                    <a class="menu-link {{ !request()->status || request()->status == 'note-logs' ? ' active' : '' }}"
                                                                        href="{{ action([App\Http\Controllers\Marketing\NoteLogController::class, 'index']) }}">
                                                                        <span class="menu-title">Danh sách</span>
                                                                    </a>
                                                                    <!--end:Menu link-->
                                                                </div>
                                                                <!--end:Menu item-->
                                                                <!--begin:Menu item-->
                                                                <div class="menu-item ps-10">
                                                                    <!--begin:Menu link-->
                                                                    <a class="menu-link d-none" id="addNoteLogSlideBar"
                                                                        href="{{ action([App\Http\Controllers\Marketing\NoteLogController::class, 'create']) }}">
                                                                        <span class="menu-title">Thêm mới</span></a>
                                                                    <!--end:Menu link-->
                                                                </div>
                                                                <!--end:Menu item-->
                                                                <!--begin:Menu item-->
                                                                <div class="menu-item ps-10">
                                                                    <a href="{{ action(
                                                                        [App\Http\Controllers\Marketing\NoteLogController::class, 'index'],
                                                                        [
                                                                            'status' => 'deleted',
                                                                        ],
                                                                    ) }}"
                                                                        class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                                        <span class="menu-title">Đã xóa</span>
                                                                        <span>{{ request()->ajax() ? App\Models\NoteLog::isDeleted()->count() : '' }}</span></a>
                                                                    </a>
                                                                </div>

                                                            </div>
                                                            <!--end:Menu sub-->
                                                        </div>


                                                    </div>
                                                    <!--BEGIN::Trạng thái-->
                                                    <div>
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
                                                                    <a href="{{ action([App\Http\Controllers\Marketing\ContactController::class, 'index']) }}"
                                                                        class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                        <span class="menu-title">Đang hoạt động</span>
                                                                        <span class="menu-badge"
                                                                            sidebar-counter="9-8">{{ request()->ajax() ? App\Models\Contact::active()->isNotCustomer()->count() : '' }}</span>
                                                                    </a>
                                                                </div>
                                                                <!--end::Menu items-->

                                                                <div class="menu-item">
                                                                    <a href="{{ action(
                                                                        [App\Http\Controllers\Marketing\ContactController::class, 'index'],
                                                                        [
                                                                            'status' => 'deleted',
                                                                        ],
                                                                    ) }}"
                                                                        class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                                        <span class="menu-title">Đã xóa</span>
                                                                        <span class="menu-badge"
                                                                            sidebar-counter="9-9">{{ request()->ajax() ? App\Models\Contact::isDeleted()->count() : '' }}</span>
                                                                    </a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--END::Trạng thái-->
                                                </div>


                                            </div>
                                        </div>
                                        <!--END::Danh mục chính-->

                                    </div>

                                </div>



                            </div>
                            <!--END::Liên hệ-->

                            <!--START::CUSTOMER-->

                        @endif

                        @if ($menu == 'importExport')
                            <!--BEGIN::Nhập xuất dữ liệu-->


                            <div class="tab-pane fade {{ $menu == 'importExport' ? 'active show' : '' }}"
                                id="kt_aside_nav_tab_reports" role="tabpanel">
                                <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-5 pe-6 my-5 my-lg-0"
                                    id="kt_aside_menu" data-kt-menu="true">

                                    <div id="kt_aside_menu_wrapper" class="menu-fit">
                                        <div class="menu-item">
                                            <span class="accordion-button menu-link ms-4" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span
                                                    class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    NHẬP XUẤT
                                                </span>
                                            </span>
                                        </div>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link py-3 {{ $sidebar == 'import' ? 'active ' : '' }}"
                                                    href="{{ action([App\Http\Controllers\Marketing\ImportController::class, 'index']) }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded me-2">
                                                            deployed_code_update
                                                        </span></span>
                                                    <span class="menu-title">Nhập dữ liệu</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link py-3 {{ $sidebar == 'export' ? 'active ' : '' }}"
                                                    href="{{ action([App\Http\Controllers\Marketing\ExportController::class, 'index']) }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded me-2">
                                                            export_notes
                                                        </span></span>
                                                    <span class="menu-title">Xuất dữ liệu</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>




                                            <!--end:Menu content-->
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--END::Nhập xuất dữ liệu-->
                        @endif



                        @if ($menu == 'report')
                            <!--begin::Tab pane-->
                            <div class="tab-pane fade {{ $menu == 'report' ? 'active show' : '' }}"
                                id="kt_aside_nav_tab_reports" role="tabpanel">
                                <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-5 pe-6 my-5 my-lg-0"
                                    id="kt_aside_menu" data-kt-menu="true">

                                    <div id="kt_aside_menu_wrapper" class="menu-fit">
                                        <div class="menu-item pt-5">
                                            <!--begin:Menu content-->
                                            <div class="menu-content"><span
                                                    class="menu-heading fw-bold text-uppercase fs-7 ps-5">
                                                    Báo cáo</span>
                                            </div>
                                            <!--end:Menu content-->
                                        </div>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a class="menu-link" href="#" data-action="under-construction">
                                                    <span class="menu-icon">
                                                        <i class="ki-duotone ki-address-book fs-2">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                            <span class="path3"></span></i></span>
                                                    <span class="menu-title">Báo cáo</span>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endif

                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Wrapper-->
            </div>
        </div>
        <!--end::Workspace-->
    </div>
    <!--end::Secondary-->

    <!--begin::Aside Toggle-->

    <!--end::Aside Toggle-->
</div>

<script>
    //    $(document).ready(function() {
    //         $(".accordion-button").on('click', function() {
    //             const menuArrow = $(this).find(".menu-arrow");
    //             const isExpanded = $(this).attr('aria-expanded');

    //             if (isExpanded === 'false') {
    //                 menuArrow.removeClass("rotate");
    //             } else {
    //                 menuArrow.addClass("rotate");
    //             }
    //         });
    //     });

    $(function() {
        AddCustomer.init();
        sidebarShow.init();

        // AddNotlogHandle.init();

        CreateContactRequestPopup.init();
    });

    var sidebarShow = {
        init: function() {
            const aside = document.querySelector('.aside-secondary');
            var toggleButton = document.getElementById('kt_aside_show');
            var hasSecondary = $('.aside-secondary .tab-pane:visible').length;

            if (!hasSecondary) {
                $(toggleButton).remove();
                return;
            }

            toggleButton.addEventListener('click', function(e) {
                aside.classList.toggle('d-none');
            });
            // navItems.forEach(function(navItem) {
            //     navItem.addEventListener('click', function() {
            //         aside.classList.toggle('d-none');
            //         // toggleButton.classList.toggle('active');
            //     });
            // });
        }
    };
    //
    // var AddNotlogHandle = function() {
    //     return {
    //         init: () => {
    //             document.querySelector('#addNoteLogSlideBar').addEventListener('click', e => {
    //                 e.preventDefault();
    //                 CreateNotePopup.updateUrl(
    //                     "{{ action('\App\Http\Controllers\Marketing\NoteLogController@create') }}");
    //             });
    //         }
    //     }
    // }();

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
                    url: "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@create') }}",
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

    var AddCustomer = function() {
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
</script>
