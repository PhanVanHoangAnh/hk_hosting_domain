@extends('layouts.main.app', [
    'menu' => 'edu',
])

@section('sidebar')
    @include('edu.modules.sidebar', [
        'menu' => 'dashboard',
        'sidebar' => 'dashboard',
    ])
@endsection
@section('head')
    <script src="{{ url('/lib/echarts/echarts.js') }}?v=4"></script>
@endsection


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="toolbar d-flex flex-stack flex-wrap mb-3 mb-lg-3 ps-4 w-100" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title w-100">
            <div class="d-flex align-items-center w-100">
                <div>
                    <!--begin::Title-->
                    <h1 class="d-flex align-items-center my-0">
                        <span class="text-dark fw-bold fs-2">Education Dashboard</span>
                    </h1>
                    <!--end::Title-->
                </div>

                
            </div>
                
        </div>
        <!--end::Page title-->

    </div>

    <div id="" class="position-relative" id="kt_post">
        <!--begin::Card-->

        {{-- LINE 1 --}}
        <div class="div">
            <div class="row">
                <!--begin::Col-->
                <a class="col-md-3 h-100 " href="{{ action(
                    [App\Http\Controllers\Edu\StudentController::class, 'index'],
                    [
                        'status' =>  App\Models\Contact::NOTENROLLED,
                    ],
                ) }}">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span  class="fs-1 fw-semibold">
                                            {{ App\Models\Contact::notenrolled()->count() }} học viên</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Đợi xếp lớp</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        hourglass_top
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </a>

                <!--begin::Col-->
                <a class="col-md-3 h-100 " href="{{ action(
                    [App\Http\Controllers\Edu\StudentController::class, 'index'],
                    [
                        'status' =>  App\Models\Contact::LEARNING,
                    ],
                ) }}">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span class="fs-1 fw-semibold">
                                            {{ App\Models\Contact::learning()->count() }} học viên</span>
                                        <!--end::Amount-->
                                        
                                        <span class="d-block text-gray-400 fw-semibold fs-6">Đang học</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        design_services
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </a>

                <!--begin::Col-->
                <a class="col-md-3 h-100  " href="{{ action(
                    [App\Http\Controllers\Edu\StudentController::class, 'index'],
                    [
                        'status' =>  App\Models\Contact::FINISHED,
                    ],
                ) }}">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span class="fs-1 fw-semibold"> {{ App\Models\OrderItem::getFinishedLearning()->count() }} học viên</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Đã học xong</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        task_alt
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </a>

                <!--begin::Col-->
                <a class="col-md-3 h-100" href="{{ action(
                    [App\Http\Controllers\Edu\ReserveController::class, 'index'],
                    [
                        'status' => 'reserve',
                    ],
                ) }}">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0" >
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span class="fs-1 fw-semibold">{{ App\Models\Reserve::distinct('student_id')->count() }} học viên</span>

                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Bảo lưu</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        info
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </a>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-md-3 h-100 d-none">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-1 fw-semibold"></span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Hợp đồng mới tháng này</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        order_approve
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </div>
                <!--end::Col-->
            </div>

        </div>
        <div class="row g-5 g-xl-6 mb-5 mb-xl-6" >
            <!--begin::Col-->
            <div class="col-xl-8">
                

                {{-- LINE 2 --}}
                <div class="row" >
                    <!--begin::Col-->
                    <div class="col-xl-6"  style="height: 264px">
                        @include('edu.dashboard.module3')
                    </div>
                    <div class="col-xl-6"  style="height: 264px">
                       
                        @include('edu.dashboard.module6')
                    </div>
                   
                    <!--end::Col-->
                </div>
                <div style="height: 300px" class="mb-6  mt-4">
                    @include('edu.dashboard.module1')
                </div>
            </div>

            <div class="col-xl-4" style="height: 583px">
                @include('edu.dashboard.module2')
            </div>

            
            <!--end::Col-->
        </div>
        <div class="row" >
            <div class="col-xl-4 "  style="height: 364px">
                @include('edu.dashboard.module4')
            </div>
            <div class="col-xl-4 "  style="height: 364px">
                @include('edu.dashboard.module7')
            </div>
            
            <div class="col-xl-4 "  style="height: 364px">
                @include('edu.dashboard.module8')
            </div>
        </div>
        
    </div>
@endsection