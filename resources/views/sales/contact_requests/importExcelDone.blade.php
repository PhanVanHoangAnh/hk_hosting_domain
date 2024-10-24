@extends('layouts.main.popup')
@section('title')
Nhập dữ liệu đơn hàng
@endsection
@section('content')
<div class="stepper stepper-pills" id="kt_stepper_example_basic">
    <!--begin::Nav-->
    <div class="stepper-nav flex-center flex-wrap mt-5">
        <!--begin::Step 1-->
        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">
                        <i class="bi bi-check-lg fs-3 fw-bold"></i>
                    </span>
                </div>
                <!--end::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-upload fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black">
                        Tải dữ liệu
                    </div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Line-->
            <div class="stepper-line h-40px"></div>
            <!--end::Line-->
        </div>
        <!--end::Step 1-->

        <!--begin::Step 2-->
        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">
                        <i class="bi bi-check-lg fs-3 fw-bold"></i>
                    </span>
                </div>
                <!--begin::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-graph-down-arrow fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black">
                        Xem trước
                    </div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Line-->
            <div class="stepper-line h-40px"></div>
            <!--end::Line-->
        </div>
        <!--end::Step 2-->

        <!--begin::Step 3-->
        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">
                        <i class="bi bi-check-lg fs-3 fw-bold"></i>
                    </span>
                </div>
                <!--begin::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-save fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black">
                        Nhập dữ liệu
                    </div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Line-->
            <div class="stepper-line h-40px"></div>
            <!--end::Line-->
        </div>
        <!--end::Step 3-->

        <!--begin::Step 4-->
        <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px bg-primary">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number text-white">4</span>
                </div>
                <!--begin::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-list-check fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black">
                        Kết quả
                    </div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Line-->
            <div class="stepper-line h-40px"></div>
            <!--end::Line-->
        </div>
        <!--end::Step 4-->
    </div>
    <!--end::Nav-->
</div>

<div id="test">
    @csrf
    <!--begin::Modal body-->
    <div class="modal-body pt-10 pb-15 px-lg-17">
        <!--begin::Input group-->
        <div class="form-group">
            <!--begin::Dropzone-->
            <div class="dropzone dropzone-queue mb-2" id="kt_modal_upload_dropzone">
                <label class="form-label">Đã hoàn thành quá trình nhập dữ liệu đơn hàng</label>
                <div class="mb-10">
                    <div class="progress" style="height: 30px">
                        <div class="progress-bar bg-success" role="progressbar"
                            style="width: {{ ($status['totalRowsSuccess'] / $status['totalRowsProcessed']) * 100 }}%"
                            aria-valuenow="{{ ($status['totalRowsSuccess'] / $status['totalRowsProcessed']) * 100 }}"
                            aria-valuemin="0" aria-valuemax="100">
                            {{ round(($status['totalRowsSuccess'] / $status['totalRowsProcessed']) * 100) }}%</div>
                        <div class="progress-bar bg-danger" role="progressbar"
                            style="width: {{ ($status['totalRowsFailure'] / $status['totalRowsProcessed']) * 100 }}%"
                            aria-valuenow="{{ ($status['totalRowsFailure'] / $status['totalRowsProcessed']) * 100 }}"
                            aria-valuemin="0" aria-valuemax="100">
                            {{ round(($status['totalRowsFailure'] / $status['totalRowsProcessed']) * 100) }}%</div>
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ ($status['totalRowsDuplicate'] / $status['totalRowsProcessed']) * 100 }}%"
                            aria-valuenow="{{ ($status['totalRowsDuplicate'] / $status['totalRowsProcessed']) * 100 }}"
                            aria-valuemin="0" aria-valuemax="100">
                            {{ round(($status['totalRowsDuplicate'] / $status['totalRowsProcessed']) * 100) }}%</div>
                    </div>
                </div>
                <div class="mb-10">
                    <label class="form-label">
                        <span class="badge badge-primary">Đã xử lý: {{ $status['totalRowsProcessed'] }}</span>
                    </label><br>
                    <label class="form-label">
                        <span class="badge badge-success">Thành công: {{ $status['totalRowsSuccess'] }}</span>
                    </label><br>
                    <label class="form-label">
                        <span class="badge badge-danger">Thất bại: {{ $status['totalRowsFailure'] }}</span>
                    </label><br>
                    <label class="form-label">
                        <span class="badge badge-warning">Trùng dữ liệu: {{ $status['totalRowsDuplicate'] }}</span>
                    </label>
                </div>
                <div>
                    <button id="denyProgressBtn" class="btn btn-primary">Đóng</button>
                    <a id="downLogBtn"
                        href="{{ action([\App\Http\Controllers\Sales\ContactRequestController::class, 'downloadLog']) }}"
                        class="btn btn-primary">Tải log</a>
                </div>
            </div>

            <!--end::Dropzone-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Modal body-->
</div>

<script>
$(() => {
    document.querySelector("#denyProgressBtn").addEventListener('click', e => {
        e.preventDefault();
        ExcelPopup.getPopup().hide();
    })
})
</script>

@endsection