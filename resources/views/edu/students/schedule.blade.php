@extends('layouts.main.app', [
    'menu' => 'edu',
])
@section('sidebar')
@include('edu.modules.sidebar', [
    'menu' => 'students',
    'sidebar' => 'students',
])
@endsection
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
                    <a href="{{ action([App\Http\Controllers\Edu\StudentController::class, 'index']) }}"
                        class="text-muted text-hover-primary">Trang chủ</a>
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
                @include('edu.students.detail', [
                    'detail' => 'schedule',
                ])
                <!--end::Details-->

                @include('edu.students.menu', [
                    'menu' => 'schedule',
                ])

            </div>
        </div>
        <!--end::Navbar-->
        
        <div class="card" id="ClassesIndexContainer">
            <!--begin::Card header-->
            <div class="card-header border-0 px-4">
                <!--begin::Group actions-->
                <div list-action="top-action-box" class="menu d-flex justify-content-end align-items-center d-none"
                    data-kt-menu="true">
                    <div class="menu-item" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start">
                        <!--begin::Menu link-->
                        <button type="button" class="btn btn-outline btn-outline-default px-9 "
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Thao tác
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                        </button>
                        <!--end::Menu link-->

                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown p-3 w-150px">
                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="#" class="menu-link px-3"
                                    data-kt-customer-table-select="delete_selected" row-action="delete-all"
                                    id="">

                                    <span class="menu-title">Xoá</span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                        </div>
                        <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->
                    <div class="m-2 font-weight-bold">
                        <div list-control="count-note-selected-label"></div>
                    </div>

                </div>
                <!--end::Group actions-->
                <div class="card-title" list-action="search-action-box">
                   
                    <!--end::Details-->

                    @include('edu.students.menusub', [
                        'menusub' => 'schedule',
                    ])
                    <!--begin::Search-->


                    <!--end::Search-->
                </div>

                <!--begin::Card toolbar-->
                <div class="card-toolbar" list-action="tool-action-box">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end">
                        <div class="d-flex align-items-center me-3 d-none">
                            <!--begin::Button-->
                            <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px"
                                id="buttonCreateNoteLog">
                                <i class="ki-duotone ki-abstract-10">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>
                                Thêm Ghi Chú
                            </a>
                            <!--end::Button-->
                        </div>


                        <!--begin::Filter-->
                        <button type="button" class="btn btn-outline btn-outline-default" id="filterButton">
                            <span class="d-flex align-items-center">
                                <span class="material-symbols-rounded me-2 text-gray-600">
                                    filter_alt
                                </span>
                                <span>Lọc</span>

                                <span class="material-symbols-rounded me-2 text-gray-600">
                                    <span id="filterIcon">expand_more</span>
                                </span>

                            </span>
                        </button>

                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--begin::Card toolbar-->
            <div class=" border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
                <!--begin::Card toolbar-->
                <div class="card-toolbar mb-0" list-action="tool-action-box">
                    <!--begin::Toolbar-->

                    <div class="row">

                        <!--begin::Input-->
                        <div class="col-md-4 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Người ghi chú</label>
                            <!--end::Label-->
                            <div>
                                <select list-action="account-select" class="form-select" data-control="select2"
                                    data-allow-clear="true" data-placeholder="Chọn người ghi chú">
                                    <option></option>
                                   
                                </select>
                            </div>
                        </div>
                        <!--end::Input-->
                        
                        <div class="col-md-4 mb-5">
                            <label class="form-label">Ngày tạo (Từ - Đến)</label>
                            <div class="row" list-action="created_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="created_at_from" placeholder="=asas"
                                                type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="created_at_to" placeholder="=asas"
                                                type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-5">
                            <label class="form-label">Ngày cập nhật (Từ - Đến)</label>
                            <div class="row" list-action="updated_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="updated_at_from" placeholder="=asas"
                                                type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="updated_at_to" placeholder="=asas"
                                                type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end::Toolbar-->
                <!--end::Card header-->


                <!--end::Card-->
            </div>
        </div>
            <!--begin::Card body-->
        <div class="card-body pt-0 mt-5">
            Thời khóa biểu
        </div>

    </div>
    <!--end::Post-->

    
@endsection
