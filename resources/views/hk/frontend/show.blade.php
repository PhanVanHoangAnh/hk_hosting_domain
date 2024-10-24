<!--begin::Post-->
@extends('hk.layouts.main.app', [])
@section('content')
    <div class="post" id="kt_post">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                @include('hk.frontend._detail', [])
                <!--end::Details-->
            </div>
            <div class="card-body mb-5 mb-xl-10">
                <div class="container">
                    <h1 class="my-4">THÔNG TIN YÊU CẦU</h1>
                    <!-- First Card -->
                    <div class="card mb-10">
                        <div class=" d-flex justify-content-between align-items-center">
                            <div class="card-body" id="ContactsInformation">
                                <div class="row">
                                    <div class="mb-2 col-lg-1">
                                        <span class="text-muted">ID:6789456123</span>
                                    </div>
                                    <div class="col-lg-2">
                                        <span class="fs-6 text-gray-800 me-2">Đang xử lý</span>
                                    </div>
                                    <div class="mb-2 col-lg-2">
                                        <span class="text-muted">Liên hệ:Nhân viên A</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-lg-1">
                                        <span class="text-muted">Ngày:08/07/2024</span>
                                    </div>

                                    <div class="col-lg-2">
                                        <span class="fs-6 text-gray-800 me-2"></span>
                                    </div>

                                    <div class="mb-2 col-lg-2">
                                        <span class="text-muted">Di động:0123456789</span>
                                    </div>
                                    <div class="mb-2 col-lg-7 d-flex justify-content-end">
                                        <a class="text-muted">cance</a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-lg-3">
                                        <span class="text-muted"></span>
                                    </div>
                                    <div class="mb-2 col-lg-2">
                                        <span class="text-muted">Email:infoa@hkincotech.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="flex-grow-1 mx-2">
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-2 col-lg-4">
                                    <span class="text-muted">Tên dự Án:Phần Mền Quản Lý Giáo Viên Trung Tâm Anh Ngữ ABC</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-2 col-lg-2">
                                    <span class="text-muted">Số lượng nhân viên: 50</span>
                                </div>
                                <div class="mb-2 col-lg-2">
                                    <span class="text-muted">Số lượng chi nhánh: 10</span>
                                </div>
                                <div class="mb-2 col-lg-2">
                                    <span class="text-muted">Chi phí dự  kiến: Chưa có</span>
                                </div>
                                <div class="mb-2 col-lg-2">
                                    <span class="text-muted">Thời gian hoàn thành: 10/2024</span>
                                </div>
                            </div>
                        </div>

                        <hr class="flex-grow-1 mx-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-2 col-lg-3">
                                    <span class="text-muted">Chi phí đề xuất: ...</span>
                                </div>
                                <div class="mb-2 col-lg-3">
                                    <span class="text-muted">Thời gian thực hiện: ...</span>
                                </div>
                                <div class="mb-2 col-lg-3">
                                    <span class="text-muted">Phương án thực hiện: ...</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Second Card -->
                    <div class="card mb-10">
                        <div class=" d-flex justify-content-between align-items-center">
                            <div class="card-body" id="ContactsInformation">
                                <div class="row">
                                    <div class="mb-2 col-lg-1">
                                        <span class="text-muted">ID:56439766</span>
                                    </div>
                                    <div class="col-lg-2">
                                        <span class="fs-6 text-gray-800 me-2">Hoàn thành</span>
                                    </div>
                                    <div class="mb-2 col-lg-2">
                                        <span class="text-muted">Liên hệ:Nhân viên A</span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-lg-1">
                                        <span class="text-muted">Ngày:18/02/2024</span>
                                    </div>

                                    <div class="col-lg-2">
                                        <span class="fs-6 text-gray-800 me-2"></span>
                                    </div>

                                    <div class="mb-2 col-lg-2">
                                        <span class="text-muted">Di động:0123456789</span>
                                    </div>
                                    <div class="mb-2 col-lg-7 d-flex justify-content-end d-none">
                                        <a class="text-muted">cance</a>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-2 col-lg-3">
                                        <span class="text-muted"></span>
                                    </div>
                                    <div class="mb-2 col-lg-2">
                                        <span class="text-muted">Email:infoa@hkincotech.com</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <hr class="flex-grow-1 mx-2">
                        
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-2 col-lg-4">
                                    <span class="text-muted">Tên dự Án:Phần Mền Quản Lý Học Sinh Trung Tâm Anh Ngữ ABC</span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-2 col-lg-2">
                                    <span class="text-muted">Số lượng nhân viên: 50</span>
                                </div>
                                <div class="mb-2 col-lg-2">
                                    <span class="text-muted">Số lượng chi nhánh: 10</span>
                                </div>
                                <div class="mb-2 col-lg-2">
                                    <span class="text-muted">Chi phí dự  kiến: 500.000.000</span>
                                </div>
                                <div class="mb-2 col-lg-2">
                                    <span class="text-muted">Thời gian hoàn thành: 10/2024</span>
                                </div>
                            </div>
                        </div>

                        <hr class="flex-grow-1 mx-2">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-2 col-lg-3">
                                    <span class="text-muted">Chi phí đề xuất: 980.000.000</span>
                                </div>
                                <div class="mb-2 col-lg-3">
                                    <span class="text-muted">Thời gian thực hiện: 400h</span>
                                </div>
                                <div class="mb-2 col-lg-3">
                                    <span class="text-muted">
                                        Phương án thực hiện:
                                        <a class="text-primary text-decoration-underline">download</a>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
