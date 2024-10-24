@extends('layouts.main.app')

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
            'detail' => 'contract',
            ])
            <!--end::Details-->

            @include('abroad.extracurricular.contacts.menu', [
            'menu' => 'contract',
            ])
        </div>
    </div>
    <!--end::Navbar-->

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
                        <span class="card-label fw-bold text-dark">Thông tin</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6"></span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Actions-->
                    <div class="card-toolbar">
                        <!--begin::Filters-->
                        <div class="d-flex flex-stack flex-wrap gap-4">
                            <!--begin::Range-->
                            <div class="d-flex align-items-center my-2">
                                <!--begin::Select wrapper-->
                                <div class="w-100px me-5">
                                    <!--begin::Select-->
                                    <select name="status" data-control="select2" data-hide-search="true"
                                        class="form-select form-select-sm">
                                        <option value="1" selected="selected">30 Days</option>
                                        <option value="2">90 Days</option>
                                        <option value="3">6 Months</option>
                                        <option value="4">1 Year</option>
                                    </select>
                                    <!--end::Select-->
                                </div>
                                <!--end::Select wrapper-->

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
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-150px">Tên hợp đồng</th>
                                <th class="text-end pe-3 min-w-50px">Ngày đăng kí</th>
                                <th class="text-end pe-3 min-w-100px">Giá trị hợp đồng</th>
                                <th class="text-end pe-3 min-w-150px">Tình trạng thanh toán</th>
                                <th class="text-end pe-3 min-w-150px">Nhân viên phụ trách</th>

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
                                <td class="text-end">01 Apr, 2023</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end">$1,230</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end">
                                    <span class="badge badge-light-success">Đã thanh toán</span>
                                </td>
                                <!--end::Status-->
                                <!--begin::User -->
                                <td class="text-end">Lila Hill</td>
                                <!--end::User-->

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
                                <td class="text-end">11 Aug, 2023</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end ">$730</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end">
                                    <span class="badge badge-light-danger">Chưa thanh toán</span>
                                </td>
                                <!--end::Status-->
                                <!--begin::User -->
                                <td class="text-end">Lila Hill</td>
                                <!--end::User-->

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
                                <td class="text-end">01 May, 2023</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end">$500</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end">
                                    <span class="badge badge-light-success">Đã thanh toán</span>
                                </td>
                                <!--end::Status-->
                                <!--begin::User -->
                                <td class="text-end">Lila Hill</td>
                                <!--end::User-->


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
                                <td class="text-end">15 Mar, 2023</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end">$590</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end">
                                    <span class="badge badge-light-success">Đã hoàn thành</span>
                                </td>
                                <!--end::Status-->
                                <!--begin::User -->
                                <td class="text-end">Lila Hill</td>
                                <!--end::User-->

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
                                <td class="text-end">01 Jan, 2023</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end">$250</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end">
                                    <span class="badge badge-light-success">Đã thanh toán</span>
                                </td>
                                <!--end::Status-->
                                <!--begin::User -->
                                <td class="text-end">Lila Hill</td>
                                <!--end::User-->

                            </tr>
                            <tr>
                                <!--begin::Item-->
                                <td>
                                    <a href="../../demo5/dist/apps/ecommerce/catalog/edit-product.html"
                                        class="text-dark text-hover-primary">
                                        Learn data science and analytics from scratch
                                    </a>
                                </td>
                                <!--end::Item-->

                                <!--begin::Date added-->
                                <td class="text-end">01 Dec, 2022</td>
                                <!--end::Date added-->
                                <!--begin::Price-->
                                <td class="text-end">$500</td>
                                <!--end::Price-->
                                <!--begin::Status-->
                                <td class="text-end">
                                    <span class="badge badge-light-danger">Chưa thanh toán</span>
                                </td>
                                <!--end::Status-->
                                <!--begin::User -->
                                <td class="text-end">Lila Hill</td>
                                <!--end::User-->

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
@endsection