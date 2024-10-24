@php
    $menu = $menu ?? null;
    $sidebar = $sidebar ?? null;
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
                    <!--Menu DASHBOARD-->
                    <li class="nav-item mb-2 pb-3" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Đơn hàng"
                        data-bs-original-title="Đơn hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Accounting\DashboardController::class, 'index']) }}"
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
                    <!--Menu LIÊN HỆ-->
                    <li class="nav-item mb-2 pb-3 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover"
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
                                    Hợp đồng
                                </span>
                            </div>
                        </a>
                        <!--end::Nav link-->
                    </li>



                    <!--Menu KHÁCH HÀNG-->
                    <li class="nav-item mb-2 pb-3 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Khách hàng"
                        data-bs-original-title="Khách hàng" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'customer' || $sidebar == 'note-logs' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Khách hàng" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">

                            <span class="material-symbols-rounded fs-3x d-block">
                                group
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Khách hàng
                                </span>
                            </div>
                        </a>
                        <!--end::Nav link-->
                    </li>



                    <!--Menu Duyệt hợp đồng-->
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\Accounting\OrderController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'orders' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Duyệt hợp đồng"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">
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

                    <!--Menu Kế hoạch KPI-->
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\KpiTargetController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'kpi-target' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Kế hoạch KPI" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                crisis_alert
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    KPI
                                </span>
                            </div>
                        </a>

                    </li>

                    <!--Menu Theo dõi công nợ-->
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\Accounting\PaymentReminderController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'payment_reminder' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Theo dõi công nợ"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                paid
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Công nợ
                                </span>
                            </div>
                        </a>

                    </li>

                    <!--Menu THU/CHI-->
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\Accounting\PaymentRecordController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'payments' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Thu/ Chi" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                receipt_long
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Thu / Chi
                                </span>
                            </div>
                        </a>

                    </li>

                    <li class="nav-item mb-2 py-1 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\Accounting\RefundRequestController::class, 'index']) }}" 
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'refunds' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Yêu cầu hoàn phí" aria-selected="false"
                            role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                            tabindex="-1">
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

                    <!--Menu Baack lương-->
                      <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                      data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                      aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                      <!--begin::Nav link-->

                      <a href="{{ action([App\Http\Controllers\Accounting\PayrateController::class, 'index']) }}"
                          class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'pay-rate' ? 'active' : '' }}"
                          data-toggle="tooltip" data-placement="bottom" title="Quản lý lương giảng viên" aria-selected="false"
                          role="tab" data-bs-toggle="tooltip" data-bs-placement="right" style=""
                          tabindex="-1">
                          <span class="material-symbols-rounded fs-3x d-block">
                            currency_exchange
                          </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    {{-- Bậc lương --}}
                                    Lương GV
                                </span>
                            </div>
                      </a>

                  </li>

                    <!--Menu Tài khoản thanh toán-->
                    <li class="nav-item mb-2 py-1  {{ (Auth::user()->can('changeBranch', \App\Models\User::class)) ? '' : 'd-none' }}" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href="{{ action([App\Http\Controllers\Accounting\PaymentAccountController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'payment_accounts' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Tài khoản thanh toán"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                account_balance_wallet
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Tài khoản
                                </span>
                            </div>
                        </a>

                    </li>
                    <li class="nav-item mb-2 py-1  " data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="{{ action([App\Http\Controllers\Accounting\AccountGroupController::class, 'index']) }}"
                            class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'account_groups' ? 'active' : '' }}"
                            data-toggle="tooltip" data-placement="bottom" title="Nhóm và Tài khoản"
                            aria-selected="false" role="tab" data-bs-toggle="tooltip" data-bs-placement="right"
                            style="" tabindex="-1">
                            <span class="material-symbols-rounded fs-3x d-block">
                                account_balance_wallet
                            </span>
                            <div>
                                <span class="fs-9 fs-lg-8 fw-bold text-nowrap">
                                    Nhóm TKhoản
                                </span>
                            </div>
                        </a>

                    </li>
                    <!--end::Nav item-->
                    <!--Menu Báo cáo-->
                    <li class="nav-item mb-2 py-1" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation" aria-label="Báo cáo"
                        data-bs-original-title="Báo cáo" data-kt-initialized="1">

                        <a href="{{ action([App\Http\Controllers\Accounting\Report\DemoReportController::class, 'index']) }}"
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

                        <!--START::CONTACT-->

                        <div class="tab-pane fade d-none  {{ $menu == 'contact' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contacts" role="tabpanel">
                            <!--begin::Items-->

                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion {{ $menu == 'contact' ? ' show' : '' }}">
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
                                    </div>






                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ request()->lead_status_menu != '' ? ' ' : 'show' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                    thái</span>
                                                <span
                                                    class="menu-arrow {{ request()->status || $menu == 'contact' ? ' rotate' : '' }}"></span>
                                            </span>
                                            <div id="status-accordion"
                                                class="accordion-collapse collapse {{ request()->status || $menu == 'contact' ? 'hide' : '' }} {{ request()->lead_status_menu != '' ? '' : 'show' }}">

                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status && !request()->lead_status_menu ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="34">{{ Auth()->user()->account->onlyContacts()->count() }}</span>
                                                    </a>
                                                </div>


                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Sales\ContactController::class, 'index'],
                                                        [
                                                            'status' => 'has_action',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->status == 'has_action' ? 'active' : '' }}">
                                                        <span class="menu-title">Đã khai thác</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="35">{{ Auth()->user()->account->onlyContacts()->hasAction()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Sales\ContactController::class, 'index'],
                                                        [
                                                            'status' => 'no_action_yet',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->status == 'no_action_yet' ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa khai thác</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="36">{{ Auth()->user()->account->onlyContacts()->noActionYet()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Sales\ContactController::class, 'index'],
                                                        [
                                                            'status' => 'outdated',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->status == 'outdated' ? 'active' : '' }}">
                                                        <span class="menu-title">Hết hạn (2 giờ)</span>
                                                        <span class="menu-badge" sidebar-counter="37">
                                                            @if (request()->ajax() && App\Models\Contact::outdated()->count() )
                                                                <span
                                                                    class="badge badge-danger">{{ Auth()->user()->account->onlyContacts()->outdated()->count() }}</span>
                                                            @else
                                                                0
                                                            @endif
                                                        </span>
                                                    </a>
                                                </div>

                                            </div>


                                            <!--end:Menu sub-->
                                        </div>
                                    </div>



                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ request()->lead_status_menu ? 'show ' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#lead-status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Status</span>
                                                <span
                                                    class="menu-arrow {{ request()->lead_status_menu ? ' rotate' : '' }}"></span>
                                            </span>
                                            <div id="lead-status-accordion"
                                                class="accordion-collapse collapse {{ request()->lead_status_menu ? 'show ' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Sales\ContactController::class, 'index'],
                                                        ['lead_status_menu' => 'have_not_called'],
                                                    ) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'have_not_called' ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa gọi</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="38">{{ Auth()->user()->account->onlyContacts()->haveNotCalled()->count() }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index'], ['lead_status_menu' => 'knm_gls']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'knm_gls' ? 'active' : '' }}">
                                                        <span class="menu-title">KNM/GLS</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="39">{{ Auth()->user()->account->onlyContacts()->isKNMGLS()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index'], ['lead_status_menu' => 'is_error']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'is_error' ? 'active' : '' }}">
                                                        <span class="menu-title">Sai số</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="40">{{ Auth()->user()->account->onlyContacts()->isError()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index'], ['lead_status_menu' => 'kcnc']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'kcnc' ? 'active' : '' }}">
                                                        <span class="menu-title">KCNC</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="41">{{ Auth()->user()->account->onlyContacts()->isKCNC()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index'], ['lead_status_menu' => 'demand']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'demand' ? 'active' : '' }}">
                                                        <span class="menu-title">Có đơn hàng</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="42">{{ Auth()->user()->account->onlyContacts()->isDemand()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index'], ['lead_status_menu' => 'follow']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'follow' ? 'active' : '' }}">
                                                        <span class="menu-title">Follow Dài</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="43">{{ Auth()->user()->account->onlyContacts()->isFollow()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index'], ['lead_status_menu' => 'potential']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'potential' ? 'active' : '' }}">
                                                        <span class="menu-title">Tiềm năng</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="44">{{ Auth()->user()->account->onlyContacts()->isPotential()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index'], ['lead_status_menu' => 'agreement']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'agreement' ? 'active' : '' }}">
                                                        <span class="menu-title">Đang làm hợp đồng</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="45">{{ Auth()->user()->account->onlyContacts()->isAgreement()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index'], ['lead_status_menu' => 'as-agreement']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'as-agreement' ? 'active' : '' }}">
                                                        <span class="menu-title">Hợp đồng AS</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="46">{{ Auth()->user()->account->onlyContacts()->isASAgreement()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\ContactController::class, 'index'], ['lead_status_menu' => 'referrer']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'referrer' ? 'active' : '' }}">
                                                        <span class="menu-title">Khách giới thiệu khách hàng
                                                            khác</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="47">{{ Auth()->user()->account->onlyContacts()->isReferrer()->count() }}</span>
                                                    </a>
                                                </div>

                                            </div>


                                            <!--end:Menu sub-->
                                        </div>
                                    </div>


                                </div>
                                <!--end::Menu-->
                            </div>

                            <!--end::Items-->

                        </div>

                        <!--END::CONTACT-->






                        <!--START::CUSTOMER-->

                        <div class="tab-pane fade d-none  {{ $menu == 'customer' || $sidebar == 'note-logs' ? 'active show' : '' }}"
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
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index']) }}"
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

                                                    </div>
                                                    <!--end:Menu sub-->
                                                </div>


                                            </div>


                                        </div>
                                    </div>

                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ request()->lead_status_menu != '' || $sidebar == 'note-logs' ? ' ' : 'show' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Trạng
                                                    thái</span>
                                                <span
                                                    class="menu-arrow {{ request()->status || $menu == 'customer' ? ' rotate' : '' }}"></span>
                                            </span>
                                            <div id="status-accordion"
                                                class="accordion-collapse collapse
                                            {{ request()->lead_status_menu != '' || $sidebar == 'note-logs' ? ' ' : 'show' }}">





                                                {{-- <div id="status-accordion"
                                                class="accordion-collapse collapse {{ request()->status || $menu == 'customer' ? 'show ' : '' }}"> --}}
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status && !request()->lead_status_menu && $sidebar != 'note-logs' ? 'active' : '' }}">

                                                        <span class="menu-title">Tất cả</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="48">{{ Auth()->user()->account->customers()->count() }}</span>
                                                    </a>
                                                </div>


                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Sales\CustomerController::class, 'index'],
                                                        [
                                                            'status' => 'has_action',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->status == 'has_action' ? 'active' : '' }}">
                                                        <span class="menu-title">Đã khai thác</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="49">{{ Auth()->user()->account->customers()->hasAction()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Sales\CustomerController::class, 'index'],
                                                        [
                                                            'status' => 'no_action_yet',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->status == 'no_action_yet' ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa khai thác</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="50">{{ Auth()->user()->account->customers()->noActionYet()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->

                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Sales\CustomerController::class, 'index'],
                                                        [
                                                            'status' => 'outdated',
                                                        ],
                                                    ) }}"
                                                        class="menu-link {{ request()->status == 'outdated' ? 'active' : '' }}">
                                                        <span class="menu-title">Hết hạn (2 giờ)</span>
                                                        <span class="menu-badge" sidebar-counter="51">
                                                            @if (request()->ajax() && App\Models\Contact::outdated()->count() )
                                                                <span
                                                                    class="badge badge-danger">{{ Auth()->user()->account->customers()->outdated()->count() }}</span>
                                                            @else
                                                                0
                                                            @endif
                                                        </span>
                                                    </a>
                                                </div>

                                            </div>


                                            <!--end:Menu sub-->
                                        </div>
                                    </div>



                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ request()->lead_status_menu ? 'show ' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#lead-status-accordion">
                                                <span
                                                    class="menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">Status</span>
                                                <span
                                                    class="menu-arrow {{ request()->lead_status_menu ? ' rotate' : '' }}"></span>
                                            </span>
                                            <div id="lead-status-accordion"
                                                class="accordion-collapse collapse {{ request()->lead_status_menu ? 'show ' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Sales\CustomerController::class, 'index'],
                                                        ['lead_status_menu' => 'have_not_called'],
                                                    ) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'have_not_called' ? 'active' : '' }}">
                                                        <span class="menu-title">Chưa gọi</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="52">{{ Auth()->user()->account->customers()->haveNotCalled()->count() }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index'], ['lead_status_menu' => 'knm_gls']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'knm_gls' ? 'active' : '' }}">
                                                        <span class="menu-title">KNM/GLS</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="53">{{ Auth()->user()->account->customers()->isKNMGLS()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index'], ['lead_status_menu' => 'is_error']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'is_error' ? 'active' : '' }}">
                                                        <span class="menu-title">Sai số</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="54">{{ Auth()->user()->account->customers()->isError()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index'], ['lead_status_menu' => 'kcnc']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'kcnc' ? 'active' : '' }}">
                                                        <span class="menu-title">KCNC</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="55">{{ Auth()->user()->account->customers()->isKCNC()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index'], ['lead_status_menu' => 'demand']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'demand' ? 'active' : '' }}">
                                                        <span class="menu-title">Có đơn hàng</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="56">{{ Auth()->user()->account->customers()->isDemand()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index'], ['lead_status_menu' => 'follow']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'follow' ? 'active' : '' }}">
                                                        <span class="menu-title">Follow Dài</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="57">{{ Auth()->user()->account->customers()->isFollow()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index'], ['lead_status_menu' => 'potential']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'potential' ? 'active' : '' }}">
                                                        <span class="menu-title">Tiềm năng</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="58">{{ Auth()->user()->account->customers()->isPotential()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index'], ['lead_status_menu' => 'agreement']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'agreement' ? 'active' : '' }}">
                                                        <span class="menu-title">Đang làm hợp đồng</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="59">{{ Auth()->user()->account->customers()->isAgreement()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index'], ['lead_status_menu' => 'as-agreement']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'as-agreement' ? 'active' : '' }}">
                                                        <span class="menu-title">Hợp đồng AS</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="60">{{ Auth()->user()->account->customers()->isASAgreement()->count() }}</span>
                                                    </a>
                                                </div>
                                                <!--end::Menu item-->
                                                <!--begin::Menu item-->
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index'], ['lead_status_menu' => 'referrer']) }}"
                                                        class="menu-link {{ request()->lead_status_menu == 'referrer' ? 'active' : '' }}">
                                                        <span class="menu-title">Khách giới thiệu khách hàng
                                                            khác</span>
                                                        <span
                                                            class="menu-badge" sidebar-counter="61">{{ Auth()->user()->account->customers()->isReferrer()->count() }}</span>
                                                    </a>
                                                </div>

                                            </div>


                                            <!--end:Menu sub-->
                                        </div>
                                    </div>


                                </div>
                                <!--end::Menu-->
                            </div>

                            <!--end::Items-->

                        </div>
                        <!--START::CUSTOMER-->



                        <!--START::ORDER-->
                        <div class="tab-pane fade {{ $menu == 'orders' ? 'active show' : '' }}"
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
                                                    DUYỆT HỢP ĐỒNG
                                                </span>
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a href="{{ action([App\Http\Controllers\Accounting\OrderController::class, 'index']) }}"
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

                                            <div list-action="create-constract" data-is-nav="nav"
                                                data-nav="add-contract" class="menu-item d-none">
                                                <a class="menu-link py-3 {{ $sidebar == 'create_constract' ? 'active ' : '' }}"
                                                    id="addContractSlideBar">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            assignment_add
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">Thêm mới</span>
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
                                                    </span>
                                                    <div id="status-accordion"
                                                        class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Accounting\OrderController::class, 'index']) }}"
                                                                class="menu-link {{ $sidebar == 'orders' && !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="62">{{ request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDemo()->notDeleted()->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\OrderController::class, 'index'],
                                                                [
                                                                    'status' => 'pending',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'pending' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.pending') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="63">{{ request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDemo()->notDeleted()->pending()->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\OrderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\Order::STATUS_APPROVED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_APPROVED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.approved') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="64">{{ request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDemo()->notDeleted()->approved()->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\OrderController::class, 'index'],
                                                                [
                                                                    'status' => 'rejected',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'rejected' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.order.status.rejected') }}</span>

                                                                <span class="menu-badge" sidebar-counter="65">
                                                                    @if (request()->ajax() && App\Models\Order::rejected()->count() )
                                                                        <span
                                                                            class="badge badge-danger">{{ request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDemo()->notDeleted()->rejected()->count() : ''  }}</span>
                                                                    @else
                                                                        0
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
                                                <div class="menu-item menu-accordion show d-none">
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
                                                                [App\Http\Controllers\Accounting\OrderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\Order::STATUS_REACHING_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_REACHING_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.reaching_due_date') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="66">{{ request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDemo()->notDeleted()->approved()->reachingDueDate()->checkIsNotPaid()->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\OrderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\Order::STATUS_PART_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_PART_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.part_paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="67">{{ request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDemo()->notDeleted()->approved()->partPaid()->checkIsNotPaid()->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\OrderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\Order::STATUS_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="68">{{ request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDemo()->notDeleted()->approved()->checkIsPaid()->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\OrderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\Order::STATUS_OVER_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\Order::STATUS_OVER_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.over_due_date') }}</span>
                                                                @if (request()->ajax() && App\Models\Order::approved()->overDueDate()->checkIsNotPaid()->count() )
                                                                    <span
                                                                        class="badge badge-danger">{{ request()->ajax() ? App\Models\Order::byBranch(\App\Library\Branch::getCurrentBranch())->notDraft()->notDemo()->notDeleted()->approved()->overDueDate()->checkIsNotPaid()->count() : ''  }}</span>
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
                                <!--Yêu cầu hoàn phí-->
                                <div>
                                    <div class="menu-item menu-accordion show">
                                        <span data-box-toggle="#xldt" class="accordion-button menu-link" data-bs-toggle="collapse"
                                            data-bs-target="#category-accordion">
                                            <span
                                                class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                    
                                                <span class="d-flex align-items-center w-100">
                                                    <span>Yêu cầu hoàn phí</span>
                                                    <span box-toggle="anchor" class="material-symbols-rounded text-light ms-auto">
                                                        expand_more
                                                    </span>
                                                </span>
                                            </span>
                                        </span>
                                        <div id="xldt" class="accordion-collapse collapse hover show">
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a href="{{ action([App\Http\Controllers\Accounting\RefundRequestController::class, 'index']) }}"
                                                    class="menu-link py-3  {{ $sidebar == 'refund' ? 'active ' : '' }}">
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
                                                <div class="menu-item menu-accordion {{ $sidebar == 'refund'  ? 'show' : '' }}">
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
                                                            <a href="{{ action([App\Http\Controllers\Accounting\RefundRequestController::class, 'index']) }}"
                                                                class="menu-link {{ $sidebar == 'refund' && !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="69">{{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_PENDING,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ $sidebar == 'refund' &&  request()->status == App\Models\RefundRequest::STATUS_PENDING ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.pending') }}</span>
                                                                <span class="menu-badge" sidebar-counter="71">{{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->pending()->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_APPROVED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ $sidebar == 'refund' &&  request()->status == App\Models\RefundRequest::STATUS_APPROVED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.approved') }}</span>
                                                                <span class="menu-badge" sidebar-counter="71">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->approved()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_REJECTED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ $sidebar == 'refund' &&  request()->status == App\Models\RefundRequest::STATUS_REJECTED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.rejected') }}</span>
                                                                <span class="menu-badge" sidebar-counter="72">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->rejected()->count() : ''  }}
                                                                </span>
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
                        <!--END::ORDER -->

                        <!--START::Kế hoạch KPI-->
                        <div class="tab-pane fade  {{ $menu == 'kpi-target' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_kpi_target" role="tabpanel">
                            <!--begin::Items-->

                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ $menu == 'kpi-target' ? ' show' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Kế hoạch KPI
                                                </span>
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse {{ $menu == 'kpi-target' ? ' hover show' : '' }}">

                                                <div data-is-nav="nav" data-nav="add-customer"
                                                    class="menu-item d-none">
                                                    <a class="menu-link py-3" id="addKpiTarget">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                person_add
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Thêm kế hoạch</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\KpiTargetController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $menu == 'kpi-target' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                contacts
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Kế hoạch KPI</span></a>
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


                        <!--END::Kế hoạch KPI-->


                        <!--START::Theo dõi công nợ-->
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
                                                Theo dõi công nợ
                                            </span>
                                            {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                        </span>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a
                                                    class="menu-link py-3  {{ $menu == 'payment_reminder' ? 'active ' : '' }}">
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
                                                            <a href="{{ action([App\Http\Controllers\Accounting\PaymentReminderController::class, 'index']) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span class="menu-badge" sidebar-counter="73x">
                                                                    {{ request()->ajax() ? App\Models\PaymentReminder::byOrderBranch(\App\Library\Branch::getCurrentBranch())->approved()->count() : ''  }}</span>
                                                            </a>
                                                        </div>


                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentReminderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentReminder::STATUS_REACHING_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentReminder::STATUS_REACHING_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.reaching_due_date') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="73">{{ request()->ajax() ? App\Models\PaymentReminder::getReachingDueDateRemindersByBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentReminderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentReminder::STATUS_OVER_DUE_DATE,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentReminder::STATUS_OVER_DUE_DATE ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.over_due_date') }}</span>
                                                                @if (request()->ajax() && App\Models\PaymentReminder::approved()->overDueDate()->checkIsNotPaid()->count() )
                                                                    <span
                                                                        class="badge badge-danger">{{ request()->ajax() ? App\Models\PaymentReminder::getOverDueRemindersByBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}</span>
                                                                @else
                                                                    0
                                                                @endif


                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentReminderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentReminder::STATUS_PART_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentReminder::STATUS_PART_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.part_paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="75">{{ request()->ajax() ? App\Models\PaymentReminder::getPartPaidRemindersByBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentReminderController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentReminder::STATUS_IS_PAID,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentReminder::STATUS_IS_PAID ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_reminders.status.paid') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="76">{{ request()->ajax() ? App\Models\PaymentReminder::getPaidRemindersByBranch(\App\Library\Branch::getCurrentBranch())->count() : '' }}</span>
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
                        <!--END::Theo dõi công nợ -->


                        <!--START::PAYMENTS  -->
                        <div class="tab-pane fade {{ $menu == 'payments' ? 'active show' : '' }}"
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
                                                Thu / Chi
                                            </span>
                                            {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                        </span>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a href="{{ action([App\Http\Controllers\Accounting\PaymentRecordController::class, 'index']) }}"
                                                    class="menu-link py-3  {{ $menu == 'payments' ? 'active ' : '' }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            assignment
                                                        </span>

                                                    </span>
                                                    <span class="menu-title">Danh sách</span></a>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>




                                            <div data-is-nav="nav" data-nav="add-contract" class="menu-item ">
                                                <a class="menu-link py-3" list-action='create-receipt'>
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            add
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">Tạo phiếu thu</span>
                                                </a>
                                            </div>

                                            <div data-is-nav="nav" data-nav="add-contract" class="menu-item d-none">
                                                <a class="menu-link py-3" data-action="under-construction">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            add
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">Thêm phiếu chi</span>
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
                                                    </span>
                                                    <div id="status-accordion"
                                                        class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Accounting\PaymentRecordController::class, 'index']) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="77">{{ request()->ajax() ? App\Models\PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentRecordController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentRecord::TYPE_RECEIVED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentRecord::TYPE_RECEIVED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payments.status.received') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="78">{{ request()->ajax() ? App\Models\PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch())->received()->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="ms-5">
                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Accounting\PaymentRecordController::class, 'index'],
                                                                    [
                                                                        'status' => App\Models\PaymentRecord::STATUS_PENDING,
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link
                                                                {{ request()->status == 'pending'  ? 'active' : '' }}">
                                                                    <span class="menu-title">Chờ xác nhận</span>
                                                                    <span
                                                                    class="menu-badge" sidebar-counter="79">{{ request()->ajax() ? App\Models\PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch())->received()->pending()->count() : ''  }}</span>
        
                                                                </a>
                                                            </div>
                                                            <div class="menu-item">
                                                                <a href="{{ action(
                                                                    [App\Http\Controllers\Accounting\PaymentRecordController::class, 'index'],
                                                                    [
                                                                        'status' => App\Models\PaymentRecord::STATUS_PAID,
                                                                    ],
                                                                ) }}"
                                                                    class="menu-link
                                                                {{ request()->status == 'paid' ? 'active' : '' }}">
                                                                    <span class="menu-title">Đã thanh toán</span>
                                                                    <span
                                                                    class="menu-badge" sidebar-counter="80">{{ request()->ajax() ? App\Models\PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch())->received()->paid()->count() : ''  }}</span>
        
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentRecordController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\PaymentRecord::TYPE_REFUND,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\PaymentRecord::TYPE_REFUND ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payments.status.refund') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="81">{{ request()->ajax() ? App\Models\PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch())->refund()->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                        
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentRecordController::class, 'index'],
                                                                [
                                                                    'status' => 'reject',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'reject' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">Từ chối</span>
                                                                <span class="menu-badge" sidebar-counter="82">
                                                                    {{ request()->ajax() ? App\Models\PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch())->rejected()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentRecordController::class, 'index'],
                                                                [
                                                                    'status' => 'deleted',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payments.status.delete') }}</span>
                                                                <span class="menu-badge" sidebar-counter="83">
                                                                    {{ request()->ajax() ? App\Models\PaymentRecord::byOrderBranch(\App\Library\Branch::getCurrentBranch())->isDeleted()->count() : ''  }}
                                                                </span>
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
                        <!--END::PAYMENTS  -->

                        
                        <div class="tab-pane fade {{ $menu == 'refunds' ? 'active show' : '' }} d-none"
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
                                                            <a href="{{ action([App\Http\Controllers\Accounting\RefundRequestController::class, 'index']) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="84">{{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_PENDING,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_PENDING ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.pending') }}</span>
                                                                <span class="menu-badge" sidebar-counter="85">{{ request()->ajax() ? App\Models\RefundRequest::pending()->count() : ''  }}</span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_APPROVED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_APPROVED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.approved') }}</span>
                                                                <span class="menu-badge" sidebar-counter="86">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->approved()->count() : ''  }}
                                                                </span>
                                                            </a>
                                                        </div>
                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\RefundRequestController::class, 'index'],
                                                                [
                                                                    'status' => App\Models\RefundRequest::STATUS_REJECTED,
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == App\Models\RefundRequest::STATUS_REJECTED ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.refund_requests.status.rejected') }}</span>
                                                                <span class="menu-badge" sidebar-counter="87">
                                                                    {{ request()->ajax() ? App\Models\RefundRequest::byBranch(\App\Library\Branch::getCurrentBranch())->rejected()->count() : ''  }}
                                                                </span>
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

                        <!--START::Bậc lương-->
                        <div class="tab-pane fade  {{ $menu == 'pay-rate' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_kpi_target" role="tabpanel">
                            <!--begin::Items-->

                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ $menu == 'pay-rate' ? ' show' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    {{-- Bậc lương --}}
                                                    Quản lý lương giảng viên
                                                </span>
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>
                                            <div id="category-accordion-"
                                                class="accordion-collapse collapse {{ $menu == 'pay-rate' ? ' hover show' : '' }}">

                                                <div data-is-nav="nav" data-nav="add-customer"
                                                    class="menu-item d-none">
                                                    <a class="menu-link py-3" id="addKpiTarget">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                person_add
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Thêm bậc lương</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action([App\Http\Controllers\Accounting\PayrateController::class, 'index']) }}"
                                                        class="menu-link py-3 {{ $menu == 'pay-rate' ? ' active' : '' }}">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Bậc lương</span></a>
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


                        <!--END::Kế hoạch KPI-->


                        <!--START::PAYMENT ACCOUNTS  -->
                        <div class="tab-pane fade {{ $menu == 'payment_accounts' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contracts" role="tabpanel">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-5 pe-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">

                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div class="menu-item">
                                        <!--begin:Menu content-->
                                        <div class="menu-content"><span
                                                class="menu-heading fw-bold text-uppercase fs-7 ps-5">
                                                Tài khoản thanh toán</span>
                                        </div>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a href="{{ action([App\Http\Controllers\Accounting\PaymentAccountController::class, 'index']) }}"
                                                    class="menu-link py-3  {{ $menu == 'payment_accounts' ? 'active ' : '' }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            account_balance_wallet
                                                        </span>

                                                    </span>
                                                    <span class="menu-title">Danh sách</span></a>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>

                                            <div data-is-nav="nav" data-nav="add-contract" class="menu-item ">
                                                <a class="menu-link py-3" row-action="request-add-payment-account"
                                                    list-action='create-receipt'>
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            add
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">Tạo tài khoản thanh toán</span>
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
                                                    </span>
                                                    <div id="status-accordion"
                                                        class="accordion-collapse collapse show">
                                                        <!--begin::Menu items-->
                                                        <div class="menu-item">
                                                            <a href="{{ action([App\Http\Controllers\Accounting\PaymentAccountController::class, 'index']) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="88">{{ App\Models\PaymentAccount::count() }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentAccountController::class, 'index'],
                                                                [
                                                                    'status' => 'active',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'active' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_accounts.status.active') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="89">{{ request()->ajax() ? App\Models\PaymentAccount::active()->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentAccountController::class, 'index'],
                                                                [
                                                                    'status' => 'pause',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'pause' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_accounts.status.pause') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="90">{{ request()->ajax() ? App\Models\PaymentAccount::isPause()->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        {{-- <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentAccountController::class, 'index'],
                                                                [
                                                                    'status' => 'deleted',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'deleted' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_accounts.status.deleted') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="90">{{ request()->ajax() ? App\Models\PaymentAccount::deleted()->count() : ''  }}</span>
                                                            </a>
                                                        </div> --}}

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
                        <!--END::PAYMENTS ACCOUNTS -->


                        <div class="tab-pane fade {{ $menu == 'account_groups' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_contracts" role="tabpanel">
                            <!--begin::Menu-->
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-5 pe-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">

                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div class="menu-item">
                                        <!--begin:Menu content-->
                                        <div class="menu-content"><span
                                                class="menu-heading fw-bold text-uppercase fs-7 ps-5">
                                                Nhóm và tài khoản TT</span>
                                        </div>
                                        <div>
                                            <div class="menu-item">
                                                <!--begin:Menu link-->
                                                <a href="{{ action([App\Http\Controllers\Accounting\AccountGroupController::class, 'index']) }}"
                                                    class="menu-link py-3  {{ $menu == 'account_groups' ? 'active ' : '' }}">
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            account_balance_wallet
                                                        </span>

                                                    </span>
                                                    <span class="menu-title">Danh sách</span></a>
                                                </a>
                                                <!--end:Menu link-->
                                            </div>

                                            <div data-is-nav="nav" data-nav="add-contract" class="menu-item d-none">
                                                <a class="menu-link py-3" row-action="request-add-payment-account"
                                                    list-action='create-receipt'>
                                                    <span class="menu-icon">
                                                        <span class="material-symbols-rounded">
                                                            add
                                                        </span>
                                                    </span>
                                                    <span class="menu-title">Tạo tài khoản thanh toán</span>
                                                </a>
                                            </div>

                                            <!--BEGIN::Trạng thái-->
                                            <div>
                                                <div class="menu-item menu-accordion show d-none">
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
                                                            <a href="{{ action([App\Http\Controllers\Accounting\PaymentAccountController::class, 'index']) }}"
                                                                class="menu-link {{ !request()->status || request()->status == 'all' ? 'active' : '' }}">
                                                                <span class="menu-title">Tất cả</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="91">{{ App\Models\PaymentAccount::count() }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentAccountController::class, 'index'],
                                                                [
                                                                    'status' => 'active',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'active' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_accounts.status.active') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="92">{{ request()->ajax() ? App\Models\PaymentAccount::active()->count() : ''  }}</span>
                                                            </a>
                                                        </div>

                                                        <div class="menu-item">
                                                            <a href="{{ action(
                                                                [App\Http\Controllers\Accounting\PaymentAccountController::class, 'index'],
                                                                [
                                                                    'status' => 'inactive',
                                                                ],
                                                            ) }}"
                                                                class="menu-link {{ request()->status == 'inactive' ? 'active' : '' }}">
                                                                <span
                                                                    class="menu-title">{{ trans('messages.payment_accounts.status.inactive') }}</span>
                                                                <span
                                                                    class="menu-badge" sidebar-counter="93">{{ request()->ajax() ? App\Models\PaymentAccount::get()->count() : ''  }}</span>
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

                        <!--START::REPORT-->
                        <div class="tab-pane fade {{ $menu == 'reporting' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_reports" role="tabpanel">
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-5 pe-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">

                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div class="menu-item">
                                        <span class="accordion-button menu-link ms-4" data-bs-toggle="collapse"
                                            data-bs-target="#category-accordion">
                                            <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                Báo cáo kế toán
                                            </span>
                                            {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                        </span>
                                    </div>
                                    <div>
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3 {{ $sidebar == 'demo_report' ? 'active ' : '' }}"
                                                href="{{ action([App\Http\Controllers\Accounting\Report\DemoReportController::class, 'index']) }}">
                                                <span class="menu-icon">
                                                    <span class="material-symbols-rounded">
                                                        contract
                                                    </span></span>
                                                <span class="menu-title">Báo cáo Demo</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        {{-- <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3 {{ $sidebar == 'fee_collection_report' ? 'active ' : '' }}"
                                                href="{{ action([App\Http\Controllers\Accounting\Report\FeeCollectionReportController::class, 'index']) }}">
                                                <span class="menu-icon">
                                                    <span class="material-symbols-rounded">
                                                        contract
                                                    </span></span>
                                                <span class="menu-title">Báo cáo thu phí</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div> --}}
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3 {{ $sidebar == 'debt_report' ? 'active ' : '' }}"
                                                href="{{ action([App\Http\Controllers\Accounting\Report\DebtReportController::class, 'index']) }}">
                                                <span class="menu-icon">
                                                    <span class="material-symbols-rounded">
                                                        contract
                                                    </span></span>
                                                <span class="menu-title">Báo cáo công nợ</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3 {{ $sidebar == 'refund_report' ? 'active ' : '' }}"
                                                href="{{ action([App\Http\Controllers\Accounting\Report\RefundReportController::class, 'index']) }}">
                                                <span class="menu-icon">
                                                    <span class="material-symbols-rounded">
                                                        contract
                                                    </span></span>
                                                <span class="menu-title">Báo cáo hoàn phí</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3 {{ $sidebar == 'teacher_hour_report' ? 'active ' : '' }}"
                                                href="{{ action([App\Http\Controllers\Accounting\Report\TeacherHourReportController::class, 'index']) }}">
                                                <span class="menu-icon">
                                                    <span class="material-symbols-rounded">
                                                        contract
                                                    </span></span>
                                                <span class="menu-title">Báo cáo giờ dạy của giảng viên</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3 {{ $sidebar == 'student_hour_report' ? 'active ' : '' }}"
                                                href="{{ action([App\Http\Controllers\Accounting\Report\StudentHourReportController::class, 'index']) }}">
                                                <span class="menu-icon">
                                                    <span class="material-symbols-rounded">
                                                        contract
                                                    </span></span>
                                                <span class="menu-title">Báo cáo giờ tồn của học viên</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link py-3 {{ $sidebar == 'sales_report' ? 'active ' : '' }}"
                                                href="{{ action([App\Http\Controllers\Accounting\Report\SalesReportController::class, 'index']) }}">
                                                <span class="menu-icon">
                                                    <span class="material-symbols-rounded">
                                                        contract
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
                                                        href="{{ action([App\Http\Controllers\Accounting\Report\KPIReportController::class, 'indexDailyKPIReport']) }}">
                                                        <span class="menu-title">Theo khoảng thời gian</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                                <!--begin:Menu item-->
                                                {{-- <div class="menu-item ps-10">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link {{ $sidebar == 'monthly-sales-kpi-report' ? ' active' : '' }}"
                                                        href="{{ action([App\Http\Controllers\Accounting\Report\KPIReportController::class, 'indexMonthlyKPIReport']) }}">
                                                        <span class="menu-title">Theo quý</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div> --}}
                                                <!--end:Menu item-->
                                                <!--begin:Menu item-->

                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

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

        AddReceipt.init();

        AddPaymentAccount.init();


    })

    var AddPaymentAccount = function() {
        return {
            init: function() {
                btnSubmit = document.querySelectorAll('[row-action="request-add-payment-account"]');

                btnSubmit.forEach(function(element) {
                    element.addEventListener('click', function() {
                        CreatePaymentAccountPopup.getPopup().load();
                    });
                });
            }
        }
    }();

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
                pickContactForRequestDemoPopup.init();
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

    var pickContactForRequestDemoPopup = function() {
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
                btnSubmit.addEventListener('click', function() {
                    CreateContactPopup.getPopup().load();

                })
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



    var AddReceipt = function() {
        return {
            init: function() {
                btnSubmit = document.querySelector('[list-action="create-receipt"]');


                btnSubmit.addEventListener('click', function() {
                    CreateReceiptPopup.updateUrl(
                        "{{ action('\App\Http\Controllers\Accounting\PaymentRecordController@create') }}"
                    );
                })


            }
        }
    }();
</script>
