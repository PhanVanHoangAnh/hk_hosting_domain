@extends('hk.layouts.main.app',[
    
])

@section('sidebar')
    @include('hk.modules.sidebar', [
        'menu' => 'assigned_requests',
        'sidebar' => 'assigned_requests',
    ])
@endsection
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Thông tin yêu cầu</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        
        <!--end::Actions-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div id="SalariesIndexContainer" class="position-relative" id="kt_post">
        <!--begin::Card-->
        <div class="container mt-5">
            <form>
                <div class="row mb-3">
                    <div class="col-2">
                        <label for="customerCode" class="form-label">Mã Khách Hàng</label>
                        <input type="text" class="form-control" id="customerCode" value="{{$softwareRequest->id}}" readonly>
                    </div>
                    <div class="col-2">
                        <label for="employeeCount" class="form-label">Số lượng nhân viên</label>
                        <input type="text" class="form-control" id="employeeCount" value="{{$softwareRequest->company_size}}" readonly>
                    </div>
                    <div class="col-2">
                        <label for="branchCount" class="form-label">Số lượng chi nhánh</label>
                        <input type="text" class="form-control" id="branchCount" value="{{$softwareRequest->company_branch}}" readonly>
                    </div>
                    <div class="col-3">
                        <label for="deploymentTime" class="form-label">Thời gian triển khai</label>
                        <input type="date" class="form-control" id="deploymentTime" readonly>
                    </div>
                    <div class="col-3">
                        <label for="budget" class="form-label">Ngân sách dự kiến</label>
                        <input type="text" class="form-control" id="budget" value="{{ number_format($softwareRequest->estimated_cost, 0, ',', ',') }} đ" readonly>
                    </div>
                    
                </div>
                
                <div class="row mb-3">
                    
                </div>
                <div class="mb-3">
                    <label for="customerRequest" class="form-label">Mô tả chi tiết yêu cầu của khách hàng để BP Tech tính giá và lên phương án sản xuất</label>
                    <textarea class="form-control" id="customerRequest"  rows="4" readonly>{{$softwareRequest->note}}</textarea>
                </div>
                <h5 class="mt-12">BÁO GIÁ & PHƯƠNG ÁN</h5>
                <div class="row mb-3">
                    <div class="col-3">
                        <label for="proposedPrice" class="form-label">Giá Đề Xuất</label>
                        <input type="number" class="form-control" id="proposedPrice">
                    </div>
                    <div class="col-3">
                        <label for="executionTime" class="form-label">Thời gian thực hiện</label>
                        <input type="date" class="form-control" id="executionTime">
                    </div>
                    <div class="col-6">
                        <label for="planFile" class="form-label">Upload File Phương Án</label>
                        <input type="file" class="form-control" id="planFile">
                    </div>
                    
                </div>
                <div class="row mb-3 mt-10">
                    <div class="col">
                        <input type="checkbox" class="form-check-input " id="hasDemo">

                        <label class="form-label ">Có Demo</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="shortNotes" class="form-label">Ghi chú ngắn</label>
                    <textarea class="form-control" id="shortNotes" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">GỬI CHO KHÁCH HÀNG</button>
            </form>
        </div>
        <!--end::Toolbar-->

        <div id="SalariesIndexListContent">
        </div>
    </div>
    <!--end::Post-->
    <script>
        window.onload = function() {
            const deploymentTimeInput = document.getElementById('deploymentTime');
            const currentDate = new Date();
            currentDate.setDate(currentDate.getDate() + 14);
            const year = currentDate.getFullYear();
            const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            const day = currentDate.getDate().toString().padStart(2, '0');
            deploymentTimeInput.value = `${year}-${month}-${day}`;
        }


    </script>
@endsection
