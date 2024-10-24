@extends('layouts.main.app')
<script src="{{ url('core/assets/js/widgets.bundle.js') }}"></script>
@section('content')
<!--begin::Toolbar-->
<div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
    <!--begin::Page title-->
    <div class="page-title d-flex flex-column py-1">
        <!--begin::Title-->
        <h1 class="d-flex align-items-center my-1">
            <span class="text-dark fw-bold fs-1">Thông tin chi tiết</span>
        </h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="../../demo5/dist/index.html" class="text-muted text-hover-primary">Trang chủ</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">Tài khoản</li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Thông tin</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->

</div>
<!--end::Toolbar-->
<!--begin::Post-->
<div class="post" id="kt_post">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <div class="card-body pt-9 pb-0">

            <!--begin::Details-->
            @include('abroad.extracurricular.contacts.detail', [
            'detail' => 'debt',
            ])
            <!--end::Details-->

            @include('abroad.extracurricular.contacts.menu', [
            'menu' => 'debt',
            ])
        </div>
    </div>
    <!--end::Navbar-->
    <!--begin::Row-->
    <div class="row gy-5 g-xl-10 pb-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            <div class="card card-flush h-xl-100">
                <div class="d-flex flex-nowrap">
                    <div class=" border-gray-300  rounded min-w-125px py-3 me-3 mb-3">

                        <!--begin::Header-->
                        <div class="card-header py-5 border-0">
                            <!--begin::Title-->
                            <h3 class="card-title fw-bold text-gray-800">Doanh thu</h3>
                            <!--end::Title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                                    class="btn btn-sm btn-light d-flex align-items-center px-4">
                                    <!--begin::Display range-->
                                    <div class="text-gray-600 fw-bold">Loading date range...</div>
                                    <!--end::Display range-->
                                    <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                </div>
                                <!--end::Daterangepicker-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Card body-->
                        <div class="card-body d-flex justify-content-between flex-column pb-0 px-0 pt-1">
                            <!--begin::Items-->
                            <div class="d-flex flex-nowrap d-grid gap-5 px-9 mb-5">
                                <!--begin::Item-->
                                <div class="me-md-2">
                                    <!--begin::Statistics-->
                                    <div class="d-flex mb-2">
                                        <span class="fs-4 fw-semibold text-gray-400 me-1">$</span>
                                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">12,706</span>
                                    </div>
                                    <!--end::Statistics-->
                                    <!--begin::Description-->
                                    <span class="fs-6 fw-semibold text-gray-400">Mục tiêu</span>
                                    <!--end::Description-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div
                                    class="border-start-dashed border-end-dashed border-start border-end border-gray-300 px-5 ps-md-10 pe-md-7 me-md-5">
                                    <!--begin::Statistics-->
                                    <div class="d-flex mb-2">
                                        <span class="fs-4 fw-semibold text-gray-400 me-1">$</span>
                                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">8,035</span>
                                    </div>
                                    <!--end::Statistics-->
                                    <!--begin::Description-->
                                    <span class="fs-6 fw-semibold text-gray-400">Thực tếl</span>
                                    <!--end::Description-->
                                </div>
                                <!--end::Item-->
                                <!--begin::Item-->
                                <div class="m-0">
                                    <!--begin::Statistics-->
                                    <div class="d-flex align-items-center mb-2">
                                        <!--begin::Currency-->
                                        <span class="fs-4 fw-semibold text-gray-400 align-self-start me-1">$</span>
                                        <!--end::Currency-->
                                        <!--begin::Value-->
                                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">4,684</span>
                                        <!--end::Value-->
                                        <!--begin::Label-->
                                        <span class="badge badge-light-success fs-base">
                                            <i class="ki-duotone ki-black-up fs-7 text-success ms-n1"></i>4.5%</span>
                                        <!--end::Label-->
                                    </div>
                                    <!--end::Statistics-->
                                    <!--begin::Description-->
                                    <span class="fs-6 fw-semibold text-gray-400">GAP</span>
                                    <!--end::Description-->
                                </div>
                                <!--end::Item-->
                            </div>
                            <!--end::Items-->
                            <!--begin::Chart-->
                            <div id="kt_charts_widget_20" class="min-h-auto ps-4 pe-6" data-kt-chart-info="Revenue"
                                style="height: 300px"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <div class=" border-gray-300  rounded min-w-125px py-3 me-3 mb-3">
                        <!--begin::Header-->

                        <!--begin::Chart widget 38-->

                        <!--begin::Header-->
                        <div class="card-header pt-7 border-0 d-flex flex-nowrap">
                            <!--begin::Title-->
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold text-gray-800">LOI Issued by Departments</span>
                                <span class="text-gray-400 mt-1 fw-semibold fs-6">Counted in Millions</span>
                            </h3>
                            <!--end::Title-->
                            <!--begin::Toolbar-->
                            <div class="card-toolbar">
                                <!--begin::Daterangepicker(defined in src/js/layout/app.js)-->
                                <div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left"
                                    class="btn btn-sm btn-light d-flex align-items-center px-4">
                                    <!--begin::Display range-->
                                    <div class="text-gray-600 fw-bold">Loading date range...</div>
                                    <!--end::Display range-->
                                    <i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                        <span class="path5"></span>
                                        <span class="path6"></span>
                                    </i>
                                </div>
                                <!--end::Daterangepicker-->
                            </div>
                            <!--end::Toolbar-->
                        </div>
                        <!--end::Header-->
                        <!--begin::Body-->
                        <div class="card-body d-flex align-items-end px-0 pt-3 pb-5">
                            <!--begin::Chart-->
                            <div id="kt_charts_widget_38_chart" class="h-325px w-100 min-h-auto ps-4 pe-6"></div>
                            <!--end::Chart-->
                        </div>
                        <!--end: Card Body-->

                        <!--end::Chart widget 38-->

                    </div>

                </div>
            </div>

        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
    <!--begin::Row-->
    <div class="row gy-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            <!--begin::Table Widget 5-->
            <div class="card card-flush h-xl-100">
                <!--begin::Card header-->
                <div class="card-header pt-7">
                    <!--begin::Title-->
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bold text-dark">Thông tin thu chi</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6"></span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Actions-->
                    <div class="card-toolbar">
                        <!--begin::Filters-->
                        <div class="d-flex flex-stack flex-wrap gap-4">
                            <!--begin::Range-->
                            <div class="d-flex align-items-center fw-bold">
                                <!--begin::Label-->
                                <div class="text-muted fs-7 me-2">Chọn khoảng thời gian</div>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <input class="form-control form-control-transparent " placeholder="Pick date range"
                                    id="InputDateRangerPicker" />
                                <!--end::Select-->
                            </div>
                            <!--end::Range-->
                            <!--begin::Status-->
                            <div class="d-flex align-items-center fw-bold">
                                <!--begin::Label-->
                                <div class="text-muted fs-7 me-2">Thanh toán</div>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select
                                    class="form-select form-select-transparent text-dark fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                    data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px"
                                    data-placeholder="Select an option" data-kt-table-widget-5="filter_status">
                                    <option></option>
                                    <option value="Show All" selected="selected">Chọn tất cả</option>
                                    <option value="Completed">Đã thanh toán</option>
                                    <option value="In Progress">Chưa thanh toán</option>

                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Status-->

                        </div>
                        <!--begin::Filters-->
                    </div>
                    <!--end::Actions-->
                </div>
                <!--end::Card header-->


                <!--begin::Card body-->
                <div class="card-body">
                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-3" id="kt_table_widget_5_table">
                        <!--begin::Table head-->
                        <thead>
                            <!--begin::Table row-->
                            <tr class="text-start fs-tx fw-bold text-dark text-uppercase gs-0">
                                <th class="min-w-150px fs-tx  text-dark">Tên hợp đồng</th>
                                <th class="text-end pe-3 min-w-100px text-dark">Giá trị hợp đồng</th>
                                <th class="text-end pe-3 min-w-50px text-dark">Đã thanh toán</th>
                                <th class="text-end pe-3 min-w-100px text-dark">Ngày thanh toán</th>
                                <th class="text-end pe-3 min-w-70px text-dark">Phương thức thanh toán</th>
                                <th class="text-end pe-3 min-w-70px text-dark">Còn lại</th>
                                <th class="text-end pe-3 min-w-100px text-dark">Tình trạng thanh toán</th>
                                <th class="text-end pe-3 min-w-100px text-dark">Nhân viên phụ trách</th>
                                <th class="text-end pe-3 min-w-50px text-dark">Action</th>
                            </tr>
                            <!--end::Table row-->
                        </thead>
                        <!--end::Table head-->
                        <!--begin::Table body-->
                        <tbody class="fw-bold text-gray-600">
                            <tr>
                                <!--begin::Item-->
                                <td>
                                    <a href="../../demo5/dist/apps/ecommerce/catalog/edit-product.html"
                                        class="text-dark text-hover-primary">
                                        Python for Data Science and Machine Learning Bootcamp
                                    </a>
                                </td>
                                <!--end::Item-->

                                <!--begin::Date added-->
                                <td class="text-end text-dark">$1,230</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end text-success">$530</td>
                                <!--end::Price-->
                                <!--begin::Price-->
                                <td class="text-end ">11 Aug, 2023</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end text-primary"><i class="ki-duotone ki-dollar fs-2hx mb-2 pe-0">
                                        <span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span>
                                    </i> <span class=" d-block">Cash</span></td>
                                <!--end::Status-->
                                <td class="text-end text-warning">700</td>
                                <td class="text-end text-danger"><span
                                        class="badge badge-light-danger">Chưa thanh toán</span></td>
                                <td class="text-end ">Cleora Orn</td>
                                <td class="text-end text-success">
                                    <a href="#"
                                        class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Thao tác
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xem
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Chỉnh sửa
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xóa
                                        </div>
                                        <!--end::Menu item-->
                                </td>
                            </tr>
                            <tr>
                                <!--begin::Item-->
                                <td>
                                    <a href="../../demo5/dist/apps/ecommerce/catalog/edit-product.html"
                                        class="text-dark text-hover-primary">
                                        R Programming for Statistics and Data Science
                                    </a>
                                </td>
                                <!--end::Item-->

                                <!--begin::Date added-->
                                <td class="text-end text-dark">$1,000</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end text-success">$530</td>
                                <!--end::Price-->
                                <!--begin::Price-->
                                <td class="text-end ">11 Aug, 2023</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end text-primary"><i
                                        class="ki-duotone ki-credit-cart fs-2hx mb-2 pe-0"><span
                                            class="path1"></span><span class="path2"></span></i>
                                    </i> <span class=" d-block">Card</span></td>
                                <!--end::Status-->
                                <td class="text-end text-warning">470</td>
                                <td class="text-end text-danger"><span
                                        class="badge badge-light-danger">Chưa thanh toán</span></td>
                                <td class="text-end ">Cleora Orn</td>
                                <td class="text-end text-success">
                                    <a href="#"
                                        class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Thao tác
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xem
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Chỉnh sửa
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xóa
                                        </div>
                                        <!--end::Menu item-->
                                </td>

                            </tr>
                            <tr>
                                <!--begin::Item-->
                                <td>
                                    <a href="../../demo5/dist/apps/ecommerce/catalog/edit-product.html"
                                        class="text-dark text-hover-primary">
                                        Statistics for Business Analytics and Data Science
                                    </a>
                                </td>
                                <!--end::Item-->

                                <!--begin::Date added-->
                                <td class="text-end text-dark">$700</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end text-success">$700</td>
                                <!--end::Price-->
                                <!--begin::Price-->
                                <td class="text-end ">11 Aug, 2023</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end text-primary"><i class="ki-duotone ki-paypal fs-2hx mb-2 pe-0"><span
                                            class="path1"></span><span class="path2"></span></i>
                                    <span class=" d-block">Wallet</span>
                                </td>
                                <!--end::Status-->
                                <td class="text-end text-dark">0</td>
                                <td class="text-end text-danger"><span
                                        class="badge badge-light-success">Đã thanh toán</span></td>
                                <td class="text-end ">Cleora Orn</td>
                                <td class="text-end text-success">
                                    <a href="#"
                                        class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Thao tác
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xem
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Chỉnh sửa
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xóa
                                        </div>
                                        <!--end::Menu item-->
                                </td>

                            </tr>
                            <tr>
                                <!--begin::Item-->
                                <td>
                                    <a href="../../demo5/dist/apps/ecommerce/catalog/edit-product.html"
                                        class="text-dark text-hover-primary">
                                        The Ultimate Graph Neural Network Course
                                    </a>
                                </td>
                                <!--end::Item-->

                                <!--begin::Date added-->
                                <td class="text-end text-dark">$2230</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end text-success">$2000</td>
                                <!--end::Price-->
                                <!--begin::Price-->
                                <td class="text-end ">11 Mar, 2023</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end text-primary"><i class="ki-duotone ki-dollar fs-2hx mb-2 pe-0">
                                        <span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span>
                                    </i> <span class=" d-block">Cash</span></td>
                                <!--end::Status-->
                                <td class="text-end text-warning">230</td>
                                <td class="text-end text-danger"><span
                                        class="badge badge-light-danger">Chưa thanh toán</span></td>
                                <td class="text-end ">Cleora Orn</td>
                                <td class="text-end text-success">
                                    <a href="#"
                                        class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Thao tác
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xem
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Chỉnh sửa
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xóa
                                        </div>
                                        <!--end::Menu item-->
                                </td>

                            </tr>
                            <tr>
                                <!--begin::Item-->
                                <td>
                                    <a href="../../demo5/dist/apps/ecommerce/catalog/edit-product.html"
                                        class="text-dark text-hover-primary">
                                        Statistics for Data Science and Business Analysis
                                    </a>
                                </td>
                                <!--end::Item-->

                                <!--begin::Date added-->
                                <td class="text-end text-dark">$500</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end text-success">$500</td>
                                <!--end::Price-->
                                <!--begin::Price-->
                                <td class="text-end ">21 Feb, 2023</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end text-primary"><i class="ki-duotone ki-paypal fs-2hx mb-2 pe-0"><span
                                            class="path1"></span><span class="path2"></span></i><span
                                        class=" d-block">Wallet</span></td>
                                <!--end::Status-->
                                <td class="text-end text-dark">0</td>
                                <td class="text-end text-danger"><span
                                        class="badge badge-light-success">Đã thanh toán</span></td>
                                <td class="text-end ">Cleora Orn</td>
                                <td class="text-end text-success">
                                    <a href="#"
                                        class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Thao tác
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xem
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Chỉnh sửa
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xóa
                                        </div>
                                        <!--end::Menu item-->
                                </td>

                            </tr>
                            <tr>
                                <!--begin::Item-->
                                <td>
                                    <a href="../../demo5/dist/apps/ecommerce/catalog/edit-product.html"
                                        class="text-dark text-hover-primary">
                                        Learn data science and analytics from scratch
                                    </a>
                                </td>
                                <!--begin::Date added-->
                                <td class="text-end text-dark">$1,230</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end text-success">$530</td>
                                <!--end::Price-->
                                <!--begin::Price-->
                                <td class="text-end ">11 Aug, 2023</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end text-primary"><i class="ki-duotone ki-dollar fs-2hx mb-2 pe-0">
                                        <span class="path1"></span><span class="path2"></span><span
                                            class="path3"></span>
                                    </i> <span class=" d-block">Cash</span></td>
                                <!--end::Status-->
                                <td class="text-end text-warning">700</td>
                                <td class="text-end text-danger"><span
                                        class="badge badge-light-danger">Chưa thanh toán</span></td>
                                <td class="text-end ">Cleora Orn</td>
                                <td class="text-end text-success">
                                    <a href="#"
                                        class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                        Thao tác
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                    <!--begin::Menu-->
                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                        data-kt-menu="true">
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xem
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Chỉnh sửa
                                        </div>
                                        <!--end::Menu item-->
                                        <!--begin::Menu item-->
                                        <div class="menu-item px-3">
                                            Xóa
                                        </div>
                                        <!--end::Menu item-->
                                </td>

                            </tr>

                        </tbody>
                        <!--end::Table body-->
                    </table>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Table Widget 5-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
<!--end::Post-->

<script>
$(function() {
    //
    ContactsDebt.init();
});

var ContactsDebt = function() {
    var inputDateRangerPicker;

    var initDateRangerPicker = function() {
        inputDateRangerPicker.daterangepicker({
                opens: 'left',
                locale: {
                    format: 'DD/MM/YYYY'
                }
            },
            function(start, end, label) {});
    }

    return {
        init: function() {
            // variables
            inputDateRangerPicker = $('#InputDateRangerPicker');

            // init functions
            initDateRangerPicker();
        }
    }
}();
</script>
@endsection