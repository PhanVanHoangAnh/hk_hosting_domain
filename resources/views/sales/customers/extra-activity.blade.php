@extends('layouts.main.app', [
    'menu' => 'sales',
])
@section('sidebar')
    @include('sales.modules.sidebar', [
        'menu' => 'customer',
        'sidebar' => 'customer',
    ])
@endsection

@section('content')
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
            @include('sales.customers.detail', [
            'detail' => 'extra-activity',
            ])
            <!--end::Details-->

            @include('sales.customers.menu', [
            'menu' => 'extra-activity',
            ])
        </div>
    </div>
   
    <div class="card mb-10 ">
        @if (isset($abroadApplication))
            <div class="ms-5 mt-5 me-5">

                 <!-- 1. Thông tin học viên -->
                 @include('sales.customers.abroad_applications._studentInfo',['abroadApplication'=>$abroadApplication])

                 <!-- 2. Thông tin quản lý chung -->
                 @include('sales.customers.abroad_applications._managementInfo',['abroadApplication'=>$abroadApplication])

                 @include('sales.customers.abroad_applications._serviceInfo',['abroadApplication'=>$abroadApplication])


                <!-- 4. Thành phần hồ sơ-->
                {{-- @include('sales.customers.abroad_applications._applicationParts',['abroadApplication'=>$abroadApplication]) --}}
                @include('sales.customers.extracurricular._applicationParts',['abroadApplication'=>$abroadApplication])
            </div>
            <!--end::Col-->
            @else
            <div class="py-15">
                <div class="text-center mb-7">
                    <svg style="width:120px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.8 173.8">
                        <g style="isolation:isolate">
                            <g id="Layer_2" data-name="Layer 2">
                                <g id="layer1">
                                    <path
                                        d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z"
                                        style="fill:#cdcdcd" />
                                    <path
                                        d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z"
                                        style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2" />
                                    <path d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z"
                                        style="fill:#f5f5f5" />
                                    <rect x="31.7" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="73.6" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="115.5" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="31.7" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="73.6" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="115.5" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <path d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                        style="fill:#dbdbdb" />
                                    <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                        style="fill:#f5f5f5" />
                                    <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z" style="fill:#f5f5f5" />
                                    <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z" style="fill:#f5f5f5" />
                                    <rect x="32.1" y="29.8" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                    <rect x="32.1" y="36.7" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                    <rect x="73.3" y="96.7" width="10.1" height="8.42"
                                        transform="translate(-38.3 152.9) rotate(-76.2)" style="fill:#595959" />
                                    <path
                                        d="M94.4,35.7a33.2,33.2,0,1,0,24.3,40.1A33.1,33.1,0,0,0,94.4,35.7ZM80.5,92.2a25,25,0,1,1,30.2-18.3A25.1,25.1,0,0,1,80.5,92.2Z"
                                        style="fill:#f8a11f" />
                                    <path
                                        d="M57.6,154.1c-.7,2.8,2,5.9,6,6.9h0c4,1,7.9-.5,8.6-3.3l11.4-46.6c.7-2.8-2-5.9-6-6.9h0c-4.1-1-7.9.5-8.6,3.3Z"
                                        style="fill:#253f8e" />
                                    <path d="M62.2,61.9A25,25,0,1,1,80.5,92.2,25,25,0,0,1,62.2,61.9Z"
                                        style="fill:#fff;mix-blend-mode:screen;opacity:0.6000000000000001" />
                                    <path
                                        d="M107.6,72.9a12.1,12.1,0,0,1-.5,1.8A21.7,21.7,0,0,0,65,64.4a11.6,11.6,0,0,1,.4-1.8,21.7,21.7,0,1,1,42.2,10.3Z"
                                        style="fill:#dbdbdb" />
                                    <path
                                        d="M54.3,60A33.1,33.1,0,0,0,74.5,98.8l-1.2,5.3c-2.2.4-3.9,1.7-4.3,3.4L57.6,154.1c-.7,2.8,2,5.9,6,6.9L94.4,35.7A33.1,33.1,0,0,0,54.3,60Z"
                                        style="fill:#dbdbdb;mix-blend-mode:screen;opacity:0.2" />
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <p class="fs-4 text-center mb-5">
                    Chưa có hoạt động ngoại khoá nào!
                </p>
                
            </div>
        @endif
    
    </div>
@endsection