@php
    $menu = $menu ?? null;
    $sidebar = $sidebar ?? null;
@endphp

{{-- <button id="kt_aside_show"
    class="aside-toggle btn btn-sm btn-icon border end-0 bottom-0 d-lg-flex rounded bg-white d-none"
    data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body"
    data-kt-toggle-name="aside-minimize">

    <i class="ki-duotone ki-arrow-left fs-2 rotate-180"><span class="path1"></span><span
            class="path2"></span></i>
</button> --}}
<div id="kt_aside" class="aside aside-extended pe-3" data-kt-drawer="true" data-kt-drawer-name="aside"
    data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-direction="start"
    data-kt-drawer-toggle="#kt_aside_mobile_toggle">

    <!--begin::Primary-->
    <div class="aside-primary d-flex flex-column align-items-lg-end flex-row-auto pt-2 d-none">
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
                    
                    <li class="nav-item mb-2 py-1 d-none" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->

                        <a href="" 
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

                      <a href=""
                          class="aside-level1 nav-link btn btn-custom-warning-color btn-color-gray-400 btn-active btn-active-primary rounded py-0 {{ $menu == 'software_requests' ? 'active' : '' }}"
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
                    <li class="nav-item mb-2 py-1  " data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="right" data-bs-dismiss="click" role="presentation"
                        aria-label="Nhập dữ liệu" data-bs-original-title="Nhập dữ liệu" data-kt-initialized="1">
                        <!--begin::Nav link-->
                        <a href=""
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
                                                    <a href="{{ action([App\Http\Controllers\Hk\ContactController::class, 'index']) }}"
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

                                                


                                                <!--begin::Menu item-->
                                                

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
                                                    <a href="{{ action([App\Http\Controllers\Hk\ContactController::class, 'index']) }}"
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
                                                                href="{{ action([App\Http\Controllers\Hk\ContactController::class, 'index']) }}">
                                                                <span class="menu-title">Danh sách</span>
                                                            </a>
                                                            <!--end:Menu link-->
                                                        </div>
                                                        <!--end:Menu item-->
                                                        <!--begin:Menu item-->
                                                        <div class="menu-item ps-10">
                                                            <!--begin:Menu link-->
                                                            <a class="menu-link" id="addNoteLogSlideBar"
                                                                href="{{ action([App\Http\Controllers\Hk\ContactController::class, 'create']) }}">
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





                                                <div id="status-accordion"
                                                class="accordion-collapse collapse {{ request()->status || $menu == 'customer' ? 'show ' : '' }}">
                                               

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
                                                <a href=""
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
                                            
                                            <!--END::Trạng thái-->

                                        </div>
                                        <!--end:Menu content-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade  {{ $menu == 'software_requests' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_kpi_target" role="tabpanel">
                            <!--begin::Items-->

                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div class="menu-item menu-accordion {{ $menu == 'software_requests' ? ' show' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    {{-- Bậc lương --}}
                                                    Yêu cầu tư vấn
                                                </span>
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>
                                            <div id="category-accordion-"
                                            class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'software_requests' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Hk\SoftwareRequestController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::get()->count() }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Hk\SoftwareRequestController::class, 'index'],
                                                        [
                                                            'status' => App\Models\SoftwareRequest::STATUS_NEW,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'software_requests' && request()->status == App\Models\SoftwareRequest::STATUS_NEW ? 'active' : '' }}
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        
                                                        <span class="menu-title">Yêu cầu mới</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::new()->count() }}</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Hk\SoftwareRequestController::class, 'index'],
                                                        [
                                                            'status' => App\Models\SoftwareRequest::STATUS_CARE,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'software_requests' && request()->status == App\Models\SoftwareRequest::STATUS_CARE ? 'active' : '' }}
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        
                                                        <span class="menu-title">Cần chăm sóc</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::care()->count() }}</span>
                                                    </a>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                        <div class="menu-item menu-accordion {{ $menu == 'software_requests' ? ' show' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    {{-- Bậc lương --}}
                                                    Trạng thái bàn giao
                                                </span>
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>
                                            <div id="category-accordion-"
                                            class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'software_requests' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Hk\SoftwareRequestController::class, 'index'],
                                                        [
                                                            'status' => App\Models\SoftwareRequest::STATUS_DELIVERED,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'software_requests' && request()->status == App\Models\SoftwareRequest::STATUS_DELIVERED ? 'active' : '' }}
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        
                                                        <span class="menu-title">Đã bàn giao</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::delivered()->count() }}</span>
                                                        
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Hk\SoftwareRequestController::class, 'index'],
                                                        [
                                                            'status' => App\Models\SoftwareRequest::STATUS_PROGRESS,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'software_requests' && request()->status == App\Models\SoftwareRequest::STATUS_PROGRESS ? 'active' : '' }}
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        
                                                        <span class="menu-title">Đang xử lý</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::progress()->count() }}</span>
                                                        
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Hk\SoftwareRequestController::class, 'index'],
                                                        [
                                                            'status' => App\Models\SoftwareRequest::STATUS_COMPLETED,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'software_requests' && request()->status == App\Models\SoftwareRequest::STATUS_COMPLETED ? 'active' : '' }}
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        
                                                        <span class="menu-title">Hoàn thành</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::completed()->count() }}</span>
                                                        
                                                    </a>
                                                </div>
                                                
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>













                        <div class="tab-pane fade  {{ $menu == 'contacts' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_kpi_target" role="tabpanel">
                            <!--begin::Items-->
                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ $menu == 'contacts' ? ' show' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    Trạng thái
                                                </span>
                                            </span>
                                            <div id="category-accordion-" class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'contacts' ? 'show' : '' }}">
                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Hk\ContactController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả</span>
                                                        <span class="menu-badge">{{ App\Models\Contact::query()->count() }}</span>
                                                    </a>
                                                </div>
                                            
                                                <div class="menu-item ps-1">
                                                    <a href="{{ action([App\Http\Controllers\Hk\ContactController::class, 'index'], ['status' => App\Models\Contact::STATUS_DELETED]) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'contacts' && request()->status == App\Models\Contact::STATUS_DELETED ? 'active' : '' }} text-muted">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Đã ngưng</span>
                                                        <span class="menu-badge">{{ App\Models\Contact::query()->deleted()->count() }}</span>
                                                    </a>
                                                </div>

                                                <div class="menu-item ps-1">
                                                    <a href="{{ action([App\Http\Controllers\Hk\ContactController::class, 'index'], ['status' => App\Models\Contact::STATUS_ACTIVE]) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'contacts' && request()->status == App\Models\Contact::STATUS_ACTIVE ? 'active' : '' }} text-muted">
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        </span>
                                                        <span class="menu-title">Hoạt động</span>
                                                        <span class="menu-badge">{{ App\Models\Contact::query()->active()->count() }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>














                        <div class="tab-pane fade  {{ $menu == 'assigned_requests' ? 'active show' : '' }}"
                            id="kt_aside_nav_tab_kpi_target" role="tabpanel">
                            <!--begin::Items-->

                            <div class="menu menu-column menu-fit menu-rounded menu-title-gray-600 menu-icon-gray-400 menu-state-primary menu-state-icon-primary menu-state-bullet-primary menu-arrow-gray-500 fw-semibold fs-6 my-5 my-lg-0"
                                id="kt_aside_menu" data-kt-menu="true">
                                <div id="kt_aside_menu_wrapper" class="menu-fit">
                                    <div>
                                        <div
                                            class="menu-item menu-accordion {{ $menu == 'assigned_requests' ? ' show' : '' }}">
                                            <span class="accordion-button menu-link" data-bs-toggle="collapse"
                                                data-bs-target="#category-accordion">
                                                <span class="aside-top-heading menu-title fw-bold text-uppercase fs-7 hover-none text-gray-500">
                                                    {{-- Bậc lương --}}
                                                    Trạng thái
                                                </span>
                                                {{-- <span class="menu-arrow  {{ $menu == 'contact' || $menu == 'tags' ? ' rotate' : '' }}"></span> --}}
                                            </span>
                                            <div id="category-accordion-"
                                            class="accordion-collapse collapse {{ isset($sidebar) && $sidebar == 'assigned_requests' ? 'show' : '' }}">

                                                <div class="menu-item">
                                                    <a href="{{ action([App\Http\Controllers\Hk\SoftwareRequestController::class, 'index']) }}"
                                                        class="menu-link {{ !request()->status ? 'active' : '' }}">
                                                        <span class="menu-title">Tất cả yêu cầu</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::get()->count() }}</span>
                                                    </a>
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Hk\SoftwareRequestController::class, 'index'],
                                                        [
                                                            'status' => App\Models\SoftwareRequest::STATUS_NEW,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'assigned_requests' && request()->status == App\Models\SoftwareRequest::STATUS_NEW ? 'active' : '' }}
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        
                                                        <span class="menu-title">Yêu cầu mới</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::new()->count() }}</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Hk\SoftwareRequestController::class, 'index'],
                                                        [
                                                            'status' => App\Models\SoftwareRequest::STATUS_CARE,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'assigned_requests' && request()->status == App\Models\SoftwareRequest::STATUS_CARE ? 'active' : '' }}
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        
                                                        <span class="menu-title">Hoàn thành</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::care()->count() }}</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a href="{{ action(
                                                        [App\Http\Controllers\Hk\SoftwareRequestController::class, 'index'],
                                                        [
                                                            'status' => App\Models\SoftwareRequest::STATUS_DELIVERED,
                                                        ],
                                                    ) }}"
                                                        class="menu-link py-3 {{ $sidebar == 'assigned_requests' && request()->status == App\Models\SoftwareRequest::STATUS_DELIVERED ? 'active' : '' }}
                                                        <span class="menu-icon">
                                                            <span class="material-symbols-rounded">
                                                                view_list
                                                            </span>
                                                        
                                                        <span class="menu-title">Đang xử lý</span>
                                                        <span class="menu-badge" >{{ App\Models\SoftwareRequest::delivered()->count() }}</span>
                                                        
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
        // sidebarShow.init();
        // addNotlogHandle.init();

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
