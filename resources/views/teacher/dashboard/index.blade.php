@extends('layouts.main.teacher', [
    'menu' => 'teacher',
])

@section('sidebar')
    @include('teacher.modules.sidebar', [
        'menu' => 'dashboard',
        'sidebar' => 'dashboard',
    ])
@endsection

@section('head')
    <script src="{{ url('/lib/echarts/echarts.js') }}?v=4"></script>
@endsection

<style>
    .card.h-md-100[data-action="under-construction"]::after {
        font-size: xxx-large;
        right: 10px;
    }

</style>
@section('content')
<div class="toolbar d-flex flex-stack flex-wrap mb-3 mb-lg-3 w-100" id="kt_toolbar">
    <!--begin::Page title-->
    <div class="page-title w-100">
        <div class="d-flex align-items-center w-100">
            <div>
                <!--begin::Title-->
                <h1 class="d-flex align-items-center my-0">
                    <span class="text-dark fw-bold fs-2">Teacher Dashboard</span>
                </h1>
                <!--end::Title-->
            </div>
        </div>
    </div>
    <!--end::Page title-->
</div>


<div class="row mb-7">
    <div class="col-md-8" >
        <div class="card h-md-100" dir="ltr"> 
            <!--begin::Body-->
            <div class="card-body px-7 pt-5" style="height:370px!important;overflow-y:auto;">  
                <h2 class="mb-4">Lịch sử hoạt động</h2>
                {{-- @foreach (Auth::user()->notifications as $notification)
                        <div class="alert alert-info d-flex align-items-center p-5 mb-5 w-100">
                            <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span></i>                    <div class="d-flex flex-column w-100">
                                <div class="d-flex algin-items-center w-100">
                                    <div>
                                        <h4 class="mb-1 text-primary">Hệ thống</h4>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="d-flex align-items-center">
                                            <span class="material-symbols-rounded me-2">
                                                history
                                            </span>
                                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        </span>
                                    </div>
                                </div>
                                <div>{!! $notification->data['message'] ?? null !!}</div>
                            </div>
                        </div>
                    @endforeach --}}
                    @foreach (Auth::user()->notifications as $notification)
                        <div class="alert alert-info d-flex align-items-center p-5 mb-5 w-100">
                            <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span></i>                    <div class="d-flex flex-column w-100">
                                <div class="d-flex algin-items-center w-100">
                                    <div>
                                        <h4 class="mb-1 text-primary">Hệ thống</h4>
                                    </div>
                                    <div class="ms-auto">
                                        <span class="d-flex align-items-center">
                                            <span class="material-symbols-rounded me-2">
                                                history
                                            </span>
                                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                                        </span>
                                    </div>
                                </div>
                                <div>{!! $notification->data['message'] ?? null !!}</div>
                            </div>
                        </div>
                    @endforeach

                    @if (!Auth::user()->notifications->count())
                        <div class="card-body">
                            <div class="py-5">
                                <div class="text-center mb-7">
                                    <svg style="width:100px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.8 173.8">
                                        <g style="isolation:isolate">
                                            <g id="Layer_2" data-name="Layer 2">
                                                <g id="layer1">
                                                    <path d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z" style="fill:#cdcdcd"></path>
                                                    <path d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z" style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2"></path>
                                                    <path d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z" style="fill:#f5f5f5"></path>
                                                    <rect x="31.7" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb"></rect>
                                                    <rect x="73.6" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb"></rect>
                                                    <rect x="115.5" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb"></rect>
                                                    <rect x="31.7" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb"></rect>
                                                    <rect x="73.6" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb"></rect>
                                                    <rect x="115.5" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb"></rect>
                                                    <path d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z" style="fill:#dbdbdb"></path>
                                                    <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z" style="fill:#f5f5f5"></path>
                                                    <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z" style="fill:#f5f5f5"></path>
                                                    <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z" style="fill:#f5f5f5"></path>
                                                    <rect x="32.1" y="29.8" width="116.6" height="3.85" style="fill:#dbdbdb"></rect>
                                                    <rect x="32.1" y="36.7" width="116.6" height="3.85" style="fill:#dbdbdb"></rect>
                                                    <rect x="73.3" y="96.7" width="10.1" height="8.42" transform="translate(-38.3 152.9) rotate(-76.2)" style="fill:#595959"></rect>
                                                    <path d="M94.4,35.7a33.2,33.2,0,1,0,24.3,40.1A33.1,33.1,0,0,0,94.4,35.7ZM80.5,92.2a25,25,0,1,1,30.2-18.3A25.1,25.1,0,0,1,80.5,92.2Z" style="fill:#f8a11f"></path>
                                                    <path d="M57.6,154.1c-.7,2.8,2,5.9,6,6.9h0c4,1,7.9-.5,8.6-3.3l11.4-46.6c.7-2.8-2-5.9-6-6.9h0c-4.1-1-7.9.5-8.6,3.3Z" style="fill:#253f8e"></path>
                                                    <path d="M62.2,61.9A25,25,0,1,1,80.5,92.2,25,25,0,0,1,62.2,61.9Z" style="fill:#fff;mix-blend-mode:screen;opacity:0.6000000000000001"></path>
                                                    <path d="M107.6,72.9a12.1,12.1,0,0,1-.5,1.8A21.7,21.7,0,0,0,65,64.4a11.6,11.6,0,0,1,.4-1.8,21.7,21.7,0,1,1,42.2,10.3Z" style="fill:#dbdbdb"></path>
                                                    <path d="M54.3,60A33.1,33.1,0,0,0,74.5,98.8l-1.2,5.3c-2.2.4-3.9,1.7-4.3,3.4L57.6,154.1c-.7,2.8,2,5.9,6,6.9L94.4,35.7A33.1,33.1,0,0,0,54.3,60Z" style="fill:#dbdbdb;mix-blend-mode:screen;opacity:0.2"></path>
                                                </g>
                                            </g>
                                        </g>
                                    </svg>
                                </div>
                                <p class="fs-4 text-center">
                                    Chưa có dữ liệu hoạt động!
                                </p>
                            </div>
                        </div>
                    @endif

                    {{-- <div class="alert alert-info d-flex align-items-center p-5 mb-5">
                        <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span></i>                    <div class="d-flex flex-column">
                            <h4 class="mb-1 text-primary">Thanh toán</h4>
                            <div>Bạn đang có 1 hợp đồng tới hạn thanh toán. <a href="" class="fw-semibold d-inline-block">Nhấn vào đây</a> để thanh toán hợp đồng.</div>
                        </div>
                    </div>

                    <div class="alert alert-success d-flex align-items-center p-5 mb-5">
                        <i class="ki-duotone ki-shield-tick fs-2hx text-secondary me-4"><span class="path1"></span><span class="path2"></span></i>                    <div class="d-flex flex-column">
                            <h4 class="mb-1 text-secondary">Hoàn phí</h4>
                            <div class=" text-secondary">Hoàn phí cho dịch vụ SAT đã được xác nhận thành công vào lúc 20:00 ngày 01/04/2024</div>
                        </div>
                    </div> --}}
            </div>
            <!--end::Body-->
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-md-100" dir="ltr" data-action="under-construction"> 
            <!--begin::Body-->
            <div class="card-body d-flex flex-column flex-center">  
                <!--begin::Heading-->
                <div class="mb-2">
                    <!--begin::Title-->
                    <h1 class="fw-semibold text-gray-800 text-center lh-lg">           
                        Xem các khóa học mới mở
                    </h1>
                    <!--end::Title--> 
                    
                    <!--begin::Illustration-->
                    <div class="py-10 text-center">
                            <img src="https://preview.keenthemes.com//metronic8/demo1/assets/media/svg/illustrations/easy/2.svg" class="theme-light-show w-200px" alt="">
                            <img src="https://preview.keenthemes.com//metronic8/demo1/assets/media/svg/illustrations/easy/2-dark.svg" class="theme-dark-show w-200px" alt="">
                    </div>
                    <!--end::Illustration-->
                </div>
                <!--end::Heading-->
        
                <!--begin::Links-->
                <div class="text-center mb-1"> 
                    <!--begin::Link-->
                    <a class="btn btn-sm btn-light me-2 pe-none" data-bs-target="#kt_modal_create_account" data-bs-toggle="modal">
                        Sắp sửa ra mắt
                    </a>
                    <!--end::Link-->
                </div>
                <!--end::Links-->
            </div>
            <!--end::Body-->
        </div>
    </div>
</div>

<div id="" class="position-relative" id="kt_post">
    <div class="div">
        <div class="row" >
            <!--begin::Col-->
            
            
            <a class="col-md-4 h-100  "  >
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
                                        {{ $totalStudentCount }} học viên
                                    </span>
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
                                    hourglass_top
                                </span>
                            </span>
                        </div>
                    </div>
                    <!--end::Header-->
                </div>
            </a>
            <a class="col-md-4 h-100"  >
                <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                    <!--begin::Header-->
                    <div class="card-header py-0" >
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column ">
                            <!--begin::Info-->
                            <div class="d-flex align-items-top"    >
                                <div  >
                                    <!--begin::Amount-->
                                    <span class="fs-1 fw-semibold"  >
                                        {{$totalStudentReserveCount}} học viên
                                    </span> 
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
                                    task_alt
                                </span>
                            </span>
                        </div>
                    </div>
                    <!--end::Header-->
                </div>
            </a>

            <a class="col-md-4 h-100"  >
                <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                    <!--begin::Header-->
                    <div class="card-header py-0" >
                        <!--begin::Title-->
                        <div class="card-title d-flex flex-column ">
                            <!--begin::Info-->
                            <div class="d-flex align-items-top">
                                <div>
                                    <!--begin::Amount-->
                                    <span class="fs-1 fw-semibold">
                                        {{$totalStudentRefundCount}} học viên
                                    </span>
                                    <!--end::Amount-->
                                    <span class="d-block text-gray-400 fw-semibold fs-6">Hoàn phí</span>
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
        </div>
    </div>
    <div class="row g-5 g-xl-6 mb-5 mb-xl-6" >
        <!--begin::Col-->
        <div class="col-xl-8">
            {{-- LINE 2 --}}
            
            <div style="height: 450px" class="mb-6  ">
                @include('teacher.dashboard.module1')
            </div>
            <div class="row" >
                
                <div class="col-xl-6"  style="height: 264px">
                    @include('teacher.dashboard.module2')
                </div>
                <div class="col-xl-6"  style="height: 264px">
                    @include('teacher.dashboard.module3')
                </div> 
            </div>
        </div>

        <div class="col-xl-4" style="height: 730px">
            @include('teacher.dashboard.module4')
        </div>

        
    </div>
    
</div>
@endsection