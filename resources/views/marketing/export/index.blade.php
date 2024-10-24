@extends('layouts.main.app', [
    'menu' => 'marketing',
])

@section('sidebar')
    @include('marketing.modules.sidebar', [
        'menu' => 'importExport',
        'sidebar' => 'export',
    ])
@endsection


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Xuất dữ liệu</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->

        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1 d-none">
            <!--begin::Button-->
            <button class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" id="exportButton">

                <span class="material-symbols-rounded me-2">
                    add
                </span>
                Xuất file excel
            </button>



            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <div id="" class="position-relative" id="kt_post">
        <!--begin::Card-->
        @if (Auth::user()->can('exportContactRequest', \App\Models\Contact::class)) 
        <div class="row g-6 g-xl-9">
            <!--begin::Col-->
            <div class="col-md-6 col-xl-4">

                <!--begin::Card-->
                <div  class="card ">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-9">
                        <!--begin::Card Title-->
                        <div class="card-title m-0">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-70px w-70px">
                                <span class="menu-icon">
                                    <span class="svg-icon svg-icon-custom">
                                        <span class="material-symbols-rounded fs-4hx">
                                        contacts
                                         
                                        </span>
                                    </span>

                                </span>
                            </div>
                            <!--end::Avatar-->
                        </div>
                        <!--end::Car Title-->
                    </div>
                    <!--end:: Card header-->

                    <!--begin:: Card body-->
                    <div class="card-body p-9">
                        <!--begin::Name-->
                        <div class="fs-3 fw-bold text-dark">XUẤT LIÊN HỆ</div>
                        <!--end::Name-->

                        <!--begin::Description-->
                        <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">Xuất dữ liệu liên hệ từ excel theo điều kiện. Nhấn nút bên dưới để bắt đầu.
                        </p>
                        <!--end::Description-->

                        {{-- <!--begin::Info-->
                        <div class="d-flex flex-wrap mb-5">
                            <!--begin::Due-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                <div class="fs-6 text-gray-800 fw-bold">Jun 24, 2023</div>
                                <div class="fw-semibold text-gray-400">Lần gần nhất</div>
                            </div>
                            <!--end::Due-->

                            <!--begin::Budget-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                <div class="fs-6 text-gray-800 fw-bold">284,900</div>
                                <div class="fw-semibold text-gray-400">Đã xuất</div>
                            </div>
                            <!--end::Budget-->
                        </div>
                        <!--end::Info--> --}}

                        {{-- <!--begin::Progress-->
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                            aria-label="This project 50% completed" data-bs-original-title="This project 50% completed"
                            data-kt-initialized="1">
                            <div class="bg-dark rounded h-4px" role="progressbar" style="width: 50%" aria-valuenow=" 50"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--end::Progress--> --}}

                        <button  list-action="export-contact" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_create_project">
                            Bắt đầu xuất
                        </button>
                        <!--end::Users-->
                    </div>
                    <!--end:: Card body-->
                </div>
                <!--end::Card-->
            </div>
            <!--end::Col-->

            <!--begin::Col-->
            <div class="col-md-6 col-xl-4">

                <!--begin::Card-->
                <a  class="card ">
                    <!--begin::Card header-->
                    <div class="card-header border-0 pt-9">
                        <!--begin::Card Title-->
                        <div class="card-title m-0">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-70px w-70px">
                                <span class="menu-icon">
                                    <span class="svg-icon svg-icon-custom">
                                        <span class="material-symbols-rounded fs-4hx">
                                        psychology_alt
                                                           
                                        </span>
                                    </span>

                                </span>
                            </div>
                            <!--end::Avatar-->
                        </div>
                        <!--end::Car Title-->
                    </div>
                    <!--end:: Card header-->

                    <!--begin:: Card body-->
                    <div class="card-body p-9">
                        <!--begin::Name-->
                        <div class="fs-3 fw-bold text-dark">XUẤT ĐƠN HÀNG</div>
                        <!--end::Name-->

                        <!--begin::Description-->
                        <p class="text-gray-400 fw-semibold fs-5 mt-1 mb-7">Xuất dữ liệu đơn hàng từ excel theo điều kiện. Nhấn nút bên dưới để bắt đầu.
                        </p>
                        <!--end::Description-->

                        {{-- <!--begin::Info-->
                        <div class="d-flex flex-wrap mb-5">
                            <!--begin::Due-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                <div class="fs-6 text-gray-800 fw-bold">Jun 24, 2023</div>
                                <div class="fw-semibold text-gray-400">Lần gần nhất</div>
                            </div>
                            <!--end::Due-->

                            <!--begin::Budget-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                <div class="fs-6 text-gray-800 fw-bold">284,900</div>
                                <div class="fw-semibold text-gray-400">Đã xuất</div>
                            </div>
                            <!--end::Budget-->
                        </div>
                        <!--end::Info--> --}}

                        {{-- <!--begin::Progress-->
                        <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip"
                            aria-label="This project 50% completed" data-bs-original-title="This project 50% completed"
                            data-kt-initialized="1">
                            <div class="bg-dark rounded h-4px" role="progressbar" style="width: 50%" aria-valuenow=" 50"
                                aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                        <!--end::Progress--> --}}

                        <button  list-action="export-contact-request" class="btn btn-secondary" data-bs-toggle="modal"
                            data-bs-target="#kt_modal_create_project">Bắt đầu xuất</button>
                        <!--end::Users-->
                    </div>
                    <!--end:: Card body-->
                </a>
                <!--end::Card-->
            </div>

        </div>
        @else
        <div class="alert alert-warning text-dark" role="alert">
            Bạn không có quyền xuất dữ liệu!
        </div>
        @endif
        <!--end::Card header-->


    </div>

<script>
$(function() {
            //
            ExportIndex.init();
        });

        //
        var ExportIndex = function() {
            return {
                init: function() {
                   
                    
                    //export
                    ExportContactRequestHandle.init();

                    ExportContactHandle.init();
                }
            };
        }();

        var ExportContactHandle = function() {
            var popupExportContactRequest;

            // show campaign modal
            var showExportModal = function() {
                popupExportContactRequest.load();
            };

            return {
                init: function() {
                    // create campaign popup
                    popupExportContactRequest = new Popup({
                        url: "{{ action('\App\Http\Controllers\Marketing\ContactController@showFilterForm') }}",
                    });

                    // create campaign button
                    var buttonCreateExportList = document.querySelectorAll('[list-action="export-contact"]');

                    // Add click event listener to each button
                    buttonCreateExportList.forEach(function(buttonCreateExport) {
                        buttonCreateExport.addEventListener('click', function(e) {
                            e.preventDefault();

                            // show create campaign modal
                            showExportModal();
                        });
                    });
                },

                getPopup: function() {
                    return popupExportContactRequest;
                }
            };
        }();

        var ExportContactRequestHandle = function() {
            var popupExportContactRequest;

            // show campaign modal
            var showExportModal = function() {
                popupExportContactRequest.load();
            };

            return {
                init: function() {
                    // create campaign popup
                    popupExportContactRequest = new Popup({
                        url: "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@showFilterForm') }}",
                    });

                    // create campaign button
                    var buttonCreateExportList = document.querySelectorAll('[list-action="export-contact-request"]');

                    // Add click event listener to each button
                    buttonCreateExportList.forEach(function(buttonCreateExport) {
                        buttonCreateExport.addEventListener('click', function(e) {
                            e.preventDefault();

                            // show create campaign modal
                            showExportModal();
                        });
                    });
                },

                getPopup: function() {
                    return popupExportContactRequest;
                }
            };
        }();

</script>
@endsection
