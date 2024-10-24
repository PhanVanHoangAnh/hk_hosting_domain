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
            @include('marketing.contacts.detail', [
            'detail' => 'education',
            ])
            <!--end::Details-->

            @include('marketing.contacts.menu', [
            'menu' => 'education',
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
                        <span class="card-label fw-bold text-dark">Khóa học</span>
                        <span class="text-gray-400 mt-1 fw-semibold fs-6">Tổng 8 khóa học</span>
                    </h3>
                    <!--end::Title-->
                    <!--begin::Actions-->
                    <div class="card-toolbar">
                        <!--begin::Filters-->
                        <div class="d-flex flex-stack flex-wrap gap-4">
                            <!--begin::Destination-->
                            <div class="d-flex align-items-center fw-bold">
                                <!--begin::Label-->
                                <div class="text-muted fs-7 me-2">Cấp độ</div>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select
                                    class="form-select form-select-transparent text-dark fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                    data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px"
                                    data-placeholder="Select an option">
                                    <option></option>
                                    <option value="Show All" selected="selected">Chọn tất cả</option>
                                    <option value="beginner">Sơ cấp</option>
                                    <option value="intermediate">Trung cấp</option>
                                    <option value="advanced">Nâng cao</option>
                                </select>
                                <!--end::Select-->
                            </div>
                            <!--end::Destination-->
                            <!--begin::Status-->
                            <div class="d-flex align-items-center fw-bold">
                                <!--begin::Label-->
                                <div class="text-muted fs-7 me-2">Trạng thái</div>
                                <!--end::Label-->
                                <!--begin::Select-->
                                <select
                                    class="form-select form-select-transparent text-dark fs-7 lh-1 fw-bold py-0 ps-3 w-auto"
                                    data-control="select2" data-hide-search="true" data-dropdown-css-class="w-150px"
                                    data-placeholder="Select an option" data-kt-table-widget-5="filter_status">
                                    <option></option>
                                    <option value="Show All" selected="selected">Chọn tất cả</option>
                                    <option value="Completed">Đã hoàn thành</option>
                                    <option value="Đang học">Đang học</option>
                                    <option value="Pending">Chờ</option>

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
                <!--begin::Row-->
                <div class="row g-6 g-xl-9 p-7">
                    <!--begin::Col-->
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Card-->
                        <a href="../../demo5/dist/apps/projects/project.html" class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-9">
                                <!--begin::Card Title-->
                                <div class="card-title m-0">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px w-50px bg-light">
                                        <img src="{{ url('/core/assets/media/svg/brand-logos/plurk.svg') }}" alt="image"
                                            class="p-3" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::Car Title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <span class="badge badge-light-primary fw-bold me-auto px-4 py-3">Đang học</span>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end:: Card header-->
                            <!--begin:: Card body-->
                            <div class="card-body p-9">
                                <!--begin::Name-->
                                <div class="fs-3 fw-bold text-dark">Fitnes App</div>
                                <!--end::Name-->
                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency
                                </p>
                                <!--end::Description-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-5">
                                    <!--begin::Due-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">May 05, 2023</div>
                                        <div class="fw-semibold text-gray-400">Ngày đăng kí</div>
                                    </div>
                                    <!--end::Due-->
                                    <!--begin::Budget-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                        <div class="fw-semibold text-gray-400">Học phí</div>
                                    </div>
                                    <!--end::Budget-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Progress-->
                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                    title="This project 50% completed">
                                    <div class="bg-primary rounded h-4px" role="progressbar" style="width: 50%"
                                        aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--end::Progress-->
                                <!--begin::Level-->
                                <div class="d-flex align-items-center fw-semibold">
                                    <span class="badge bg-light text-warning px-3 py-2 me-2">Trung cấp</span>
                                    <span class="text-primary fs-5">Ana Quil</span>

                                </div>
                                <!--end::Level-->
                            </div>
                            <!--end:: Card body-->
                        </a>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Card-->
                        <a href="../../demo5/dist/apps/projects/project.html" class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-9">
                                <!--begin::Card Title-->
                                <div class="card-title m-0">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px w-50px bg-light">
                                        <img src="{{ url('/core/assets/media/svg/brand-logos/disqus.svg') }}"
                                            alt="image" class="p-3" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::Car Title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <span class="badge badge-light fw-bold me-auto px-4 py-3">Chờ</span>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end:: Card header-->
                            <!--begin:: Card body-->
                            <div class="card-body p-9">
                                <!--begin::Name-->
                                <div class="fs-3 fw-bold text-dark">Leaf CRM</div>
                                <!--end::Name-->
                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency
                                </p>
                                <!--end::Description-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-5">
                                    <!--begin::Due-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">May 10, 2021</div>
                                        <div class="fw-semibold text-gray-400">Ngày đăng kí</div>
                                    </div>
                                    <!--end::Due-->
                                    <!--begin::Budget-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">$36,400.00</div>
                                        <div class="fw-semibold text-gray-400">Học phí</div>
                                    </div>
                                    <!--end::Budget-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Progress-->
                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                    title="This project 30% completed">
                                    <div class="bg-info rounded h-4px" role="progressbar" style="width: 10%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--end::Progress-->
                                <!--begin::Level-->
                                <div class="d-flex align-items-center fw-semibold">
                                    <span class="badge bg-light text-danger px-3 py-2 me-2">Nâng cao</span>
                                    <span class="text-primary fs-5">Ana Quil</span>
                                </div>
                                <!--end::Level-->
                            </div>
                            <!--end:: Card body-->
                        </a>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Card-->
                        <a href="../../demo5/dist/apps/projects/project.html" class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-9">
                                <!--begin::Card Title-->
                                <div class="card-title m-0">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px w-50px bg-light">
                                        <img src="{{ url('/core/assets/media/svg/brand-logos/figma-1.svg') }}"
                                            alt="image" class="p-3" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::Car Title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <span class="badge badge-light-success fw-bold me-auto px-4 py-3">Đã hoàn
                                        thành</span>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end:: Card header-->
                            <!--begin:: Card body-->
                            <div class="card-body p-9">
                                <!--begin::Name-->
                                <div class="fs-3 fw-bold text-dark">Atica Banking</div>
                                <!--end::Name-->
                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency
                                </p>
                                <!--end::Description-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-5">
                                    <!--begin::Due-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">Mar 14, 2021</div>
                                        <div class="fw-semibold text-gray-400">Ngày đăng kí</div>
                                    </div>
                                    <!--end::Due-->
                                    <!--begin::Budget-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">$605,100.00</div>
                                        <div class="fw-semibold text-gray-400">Học phí</div>
                                    </div>
                                    <!--end::Budget-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Progress-->
                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                    title="This project 100% completed">
                                    <div class="bg-success rounded h-4px" role="progressbar" style="width: 100%"
                                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--end::Progress-->
                                <!--begin::Level-->
                                <div class="d-flex align-items-center fw-semibold">
                                    <span class="badge bg-light text-warning px-3 py-2 me-2">Trung cấp</span>
                                    <span class="text-primary fs-5">Ana Quil</span>
                                </div>
                                <!--end::Level-->
                            </div>
                            <!--end:: Card body-->
                        </a>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Card-->
                        <a href="../../demo5/dist/apps/projects/project.html" class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-9">
                                <!--begin::Card Title-->
                                <div class="card-title m-0">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px w-50px bg-light">
                                        <img src="{{ url('/core/assets/media/svg/brand-logos/sentry-3.svg') }}"
                                            alt="image" class="p-3" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::Car Title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <span class="badge badge-light fw-bold me-auto px-4 py-3">Chờ</span>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end:: Card header-->
                            <!--begin:: Card body-->
                            <div class="card-body p-9">
                                <!--begin::Name-->
                                <div class="fs-3 fw-bold text-dark">Finance Dispatch</div>
                                <!--end::Name-->
                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency
                                </p>
                                <!--end::Description-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-5">
                                    <!--begin::Due-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">Nov 10, 2023</div>
                                        <div class="fw-semibold text-gray-400">Ngày đăng kí</div>
                                    </div>
                                    <!--end::Due-->
                                    <!--begin::Budget-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                        <div class="fw-semibold text-gray-400">Học phí</div>
                                    </div>
                                    <!--end::Budget-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Progress-->
                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                    title="This project 60% completed">
                                    <div class="bg-info rounded h-4px" role="progressbar" style="width: 10%"
                                        aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--end::Progress-->
                                <!--begin::Level-->
                                <div class="d-flex align-items-center fw-semibold">
                                    <span class="badge bg-light text-primary px-3 py-2 me-2">Sơ cấp</span>
                                    <span class="text-primary fs-5">Ana Quil</span>
                                </div>
                                <!--end::Level-->
                            </div>
                            <!--end:: Card body-->
                        </a>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Card-->
                        <a href="../../demo5/dist/apps/projects/project.html" class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-9">
                                <!--begin::Card Title-->
                                <div class="card-title m-0">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px w-50px bg-light">
                                        <img src="{{ url('/core/assets/media/svg/brand-logos/xing-icon.svg') }}"
                                            alt="image" class="p-3" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::Car Title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <span class="badge badge-light-primary fw-bold me-auto px-4 py-3">Đang học</span>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end:: Card header-->
                            <!--begin:: Card body-->
                            <div class="card-body p-9">
                                <!--begin::Name-->
                                <div class="fs-3 fw-bold text-dark">9 Degree</div>
                                <!--end::Name-->
                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency
                                </p>
                                <!--end::Description-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-5">
                                    <!--begin::Due-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">Dec 20, 2023</div>
                                        <div class="fw-semibold text-gray-400">Ngày đăng kí</div>
                                    </div>
                                    <!--end::Due-->
                                    <!--begin::Budget-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                        <div class="fw-semibold text-gray-400">Học phí</div>
                                    </div>
                                    <!--end::Budget-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Progress-->
                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                    title="This project 40% completed">
                                    <div class="bg-primary rounded h-4px" role="progressbar" style="width: 40%"
                                        aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--end::Progress-->
                                <!--begin::Level-->
                                <div class="d-flex align-items-center fw-semibold">
                                    <span class="badge bg-light text-danger px-3 py-2 me-2">Nâng cao</span>
                                    <span class="text-primary fs-5">Ana Quil</span>
                                </div>
                                <!--end::Level-->
                            </div>
                            <!--end:: Card body-->
                        </a>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Card-->
                        <a href="../../demo5/dist/apps/projects/project.html" class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-9">
                                <!--begin::Card Title-->
                                <div class="card-title m-0">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px w-50px bg-light">
                                        <img src="{{ url('/core/assets/media/svg/brand-logos/tvit.svg') }}" alt="image"
                                            class="p-3" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::Car Title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <span class="badge badge-light-primary fw-bold me-auto px-4 py-3">Đang học</span>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end:: Card header-->
                            <!--begin:: Card body-->
                            <div class="card-body p-9">
                                <!--begin::Name-->
                                <div class="fs-3 fw-bold text-dark">GoPro App</div>
                                <!--end::Name-->
                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency
                                </p>
                                <!--end::Description-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-5">
                                    <!--begin::Due-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">May 05, 2023</div>
                                        <div class="fw-semibold text-gray-400">Ngày đăng kí</div>
                                    </div>
                                    <!--end::Due-->
                                    <!--begin::Budget-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                        <div class="fw-semibold text-gray-400">Budget</div>
                                    </div>
                                    <!--end::Budget-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Progress-->
                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                    title="This project 70% completed">
                                    <div class="bg-primary rounded h-4px" role="progressbar" style="width: 70%"
                                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--end::Progress-->
                                <!--begin::Level-->
                                <div class="d-flex align-items-center fw-semibold">
                                    <span class="badge bg-light text-primary px-3 py-2 me-2">Sơ cấp</span>
                                    <span class="text-primary fs-5">Ana Quil</span>
                                </div>
                                <!--end::Level-->
                            </div>
                            <!--end:: Card body-->
                        </a>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Card-->
                        <a href="../../demo5/dist/apps/projects/project.html" class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-9">
                                <!--begin::Card Title-->
                                <div class="card-title m-0">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px w-50px bg-light">
                                        <img src="{{ url('/core/assets/media/svg/brand-logos/aven.svg') }}" alt="image"
                                            class="p-3" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::Car Title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <span class="badge badge-light-primary fw-bold me-auto px-4 py-3">Đang học</span>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end:: Card header-->
                            <!--begin:: Card body-->
                            <div class="card-body p-9">
                                <!--begin::Name-->
                                <div class="fs-3 fw-bold text-dark">Buldozer CRM</div>
                                <!--end::Name-->
                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency
                                </p>
                                <!--end::Description-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-5">
                                    <!--begin::Due-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">Sep 22, 2023</div>
                                        <div class="fw-semibold text-gray-400">Ngày đăng kí</div>
                                    </div>
                                    <!--end::Due-->
                                    <!--begin::Budget-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                        <div class="fw-semibold text-gray-400">Budget</div>
                                    </div>
                                    <!--end::Budget-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Progress-->
                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                    title="This project 70% completed">
                                    <div class="bg-primary rounded h-4px" role="progressbar" style="width: 70%"
                                        aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--end::Progress-->
                                <!--begin::Level-->
                                <div class="d-flex align-items-center fw-semibold">
                                    <span class="badge bg-light text-primary px-3 py-2 me-2">Sơ cấp</span>
                                    <span class="text-primary fs-5">Ana Quil</span>
                                </div>
                                <!--end::Level-->
                            </div>
                            <!--end:: Card body-->
                        </a>
                        <!--end::Card-->
                    </div>

                    <!--end::Col-->
                    <!--begin::Col-->
                    <div class="col-md-6 col-xl-4">
                        <!--begin::Card-->
                        <a href="../../demo5/dist/apps/projects/project.html" class="card">
                            <!--begin::Card header-->
                            <div class="card-header border-0 pt-9">
                                <!--begin::Card Title-->
                                <div class="card-title m-0">
                                    <!--begin::Avatar-->
                                    <div class="symbol symbol-50px w-50px bg-light">
                                        <img src="{{ url('/core/assets/media/svg/brand-logos/kanba.svg') }}" alt="image"
                                            class="p-3" />
                                    </div>
                                    <!--end::Avatar-->
                                </div>
                                <!--end::Car Title-->
                                <!--begin::Card toolbar-->
                                <div class="card-toolbar">
                                    <span class="badge badge-light-success fw-bold me-auto px-4 py-3">Đã hoàn
                                        thành</span>
                                </div>
                                <!--end::Card toolbar-->
                            </div>
                            <!--end:: Card header-->
                            <!--begin:: Card body-->
                            <div class="card-body p-9">
                                <!--begin::Name-->
                                <div class="fs-3 fw-bold text-dark">Oppo CRM</div>
                                <!--end::Name-->
                                <!--begin::Description-->
                                <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency
                                </p>
                                <!--end::Description-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap mb-5">
                                    <!--begin::Due-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">Jun 20, 2023</div>
                                        <div class="fw-semibold text-gray-400">Ngày đăng kí</div>
                                    </div>
                                    <!--end::Due-->
                                    <!--begin::Budget-->
                                    <div
                                        class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                        <div class="fw-semibold text-gray-400">Học phí</div>
                                    </div>
                                    <!--end::Budget-->
                                </div>
                                <!--end::Info-->
                                <!--begin::Progress-->
                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                                    title="This project 100% completed">
                                    <div class="bg-success rounded h-4px" role="progressbar" style="width: 100%"
                                        aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <!--end::Progress-->
                                <!--begin::Level-->
                                <div class="d-flex align-items-center fw-semibold">

                                    <span class="badge badge-light-success bg-light text-warning  px-3 py-2 me-2">Trung
                                        cấp</span>
                                    <span class="text-primary fs-5">Ana Quil</span>
                                </div>
                                <!--end::Level-->
                            </div>
                            <!--end:: Card body-->
                        </a>
                        <!--end::Card-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Row-->
            </div>
            <!--end::Table Widget 5-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->
</div>
<!--end::Post-->
@endsection