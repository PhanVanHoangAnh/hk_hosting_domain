@extends('layouts.main.app', [
    'menu' => 'marketing',
])

@section('sidebar')
    @include('marketing.modules.sidebar', [
        'menu' => 'dashboard',
        'sidebar' => 'dashboard',
    ])
@endsection

@section('head')
    <script src="{{ url('/lib/echarts/echarts.js') }}?v=4"></script>
@endsection


@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="toolbar d-flex flex-stack flex-wrap mb-3 mb-lg-3 ps-4" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-0">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-0">
                <span class="text-dark fw-bold fs-2">Marketing Dashboard</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->

        </div>
        <!--end::Page title-->

    </div>
    <div id="" class="position-relative" id="kt_post" >
        <!--begin::Card-->
        <div class="div">

            <div class="row g-5 g-xl-6 mb-5 mb-xl-6" >
                <!--begin::Col-->
                <div class="col-xl-8">
                    <div style="height: 300px" class="mb-6">
                        @include('marketing.dashboard.module1')
                    </div>

                    {{-- LINE 2 --}}
                    <div class="row mt-4" >
                        <!--begin::Col-->
                        <div class="col-xl-6"  style="height: 280px">
                            @include('marketing.dashboard.module3')
                        </div>
                        <div class="col-xl-6"  style="height: 280px">
                            @include('marketing.dashboard.module4')
                        </div>
                        <div class="col-xl-4 d-none"  style="height: 280px">
                            @include('marketing.dashboard.module5')
                        </div>
                        <!--end::Col-->
                    </div>
                </div>

                <div class="col-xl-4" style="height: 599px">
                    @include('marketing.dashboard.module2')
                </div>
                <!--end::Col-->
            </div>
            @include('marketing.dashboard.conversion_rate')
        </div>
    </div>
@endsection
