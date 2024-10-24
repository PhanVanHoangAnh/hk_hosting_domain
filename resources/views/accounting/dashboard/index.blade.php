@extends('layouts.main.app', [
    'menu' => 'accounting',
])

@section('sidebar')
    @include('accounting.modules.sidebar', [
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
                        <span class="text-dark fw-bold fs-2">Accounting Dashboard</span>
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
                <a class="col h-100 " href="{{ action(
                    [App\Http\Controllers\Accounting\OrderController::class, 'index']) }}">
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
                                            class="fs-1 fw-semibold">{{ App\Helpers\Functions::formatNumber($sumTotalCacheThisMonth) }}₫</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-7">Tổng giá trị hợp đồng ký tháng này</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                       request_quote
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </a>

                

                <!--begin::Col-->
                <a class="col h-100  " href="{{ action(
                    [App\Http\Controllers\Accounting\PaymentRecordController::class, 'index'],) }}">
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
                                            class="fs-1 fw-semibold">{{ App\Helpers\Functions::formatNumber($sumAmountPaid) }}₫</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-7">Đã thu trong tháng</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        price_check
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </a>

                <!--begin::Col-->
                <a class="col h-100 " href="{{ action(
                        [App\Http\Controllers\Accounting\PaymentReminderController::class, 'index'],
                        [
                            'status' => App\Models\PaymentReminder::STATUS_OVER_DUE_DATE,
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
                                        <span
                                            class="fs-1 fw-semibold">{{ App\Helpers\Functions::formatNumber(App\Models\PaymentReminder::sumAmountFromReminders(App\Models\PaymentReminder::getOverDueRemindersByBranch(\App\Library\Branch::getCurrentBranch()))) }}₫</span></span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-7">Giá trị các khoản quá hạn thanh toán</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
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
                <a class="col h-100 " href="{{ action(
                    [App\Http\Controllers\Accounting\PaymentReminderController::class, 'index'],
                    [
                        'status' => App\Models\PaymentReminder::STATUS_REACHING_DUE_DATE,
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
                                        <span
                                            class="fs-1 fw-semibold">
                                            {{ App\Helpers\Functions::formatNumber(App\Models\PaymentReminder::sumAmountFromReminders(App\Models\PaymentReminder::getReachingDueDateRemindersByBranch(\App\Library\Branch::getCurrentBranch()))) }}₫
                                        </span>
                                        <!--end::Amount-->
                                        
                                        <span class="d-block text-gray-400 fw-semibold fs-7">Giá trị các khoản sắp tới hạn</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        mintmark
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </a>

                <!--begin::Col-->
                <div class="col h-100 ">
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
                                            class="fs-1 fw-semibold">{{ App\Helpers\Functions::formatNumber($sumAmountRefund) }}₫</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-7">Giá trị đã hoàn phí trong tháng</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        send_money
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
                <div style="height: 300px" class="mb-6">
                    @include('accounting.dashboard.module1')
                </div>

                {{-- LINE 2 --}}
                <div class="row mt-4" >
                    <!--begin::Col-->
                    <div class="col-xl-6"  style="height: 264px">
                        @include('accounting.dashboard.module3')
                    </div>
                    <div class="col-xl-6"  style="height: 264px">
                        
                        @include('accounting.dashboard.module6')
                    </div>
                    <div class="col-xl-4 d-none"  style="height: 264px">
                        @include('accounting.dashboard.module5')
                    </div>
                    <!--end::Col-->
                </div>
            </div>

            <div class="col-xl-4" style="height: 583px">
                @include('accounting.dashboard.module2')
            </div>
            <!--end::Col-->
        </div>
    </div>
@endsection
