@extends('layouts.main.popup')
@section('title')
    Nhập dữ liệu từ HubSpot
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
    <form class="form">
        @csrf

        <!--begin::Modal body-->
        <div class="modal-body">
            <!--begin::Input group-->
            <div class="form-group">
                <!--begin::Dropzone-->
                <div class="dropzone dropzone-queue">
                    <label class="form-label d-flex">Dữ liệu đang được nhập vào hệ thống</label>
                    <div class="d-inline-block w-100">
                        @include('marketing.import.hubspot.progressHandlerHubspot', [
                            // 'newContactsCount' => $status['totalRowsProcessed'],
                            // 'updatedContactsCount' => $status['totalRowsDuplicate'],
                            // 'errorsCount' => $status['totalRowsFailure'],
                        ])
                    </div>
                    <!--end::Error message-->

                    <!--end::Items-->
                </div>
                <!--end::Dropzone-->

            </div>
            <!--end::Input group-->
        </div>
        <!--end::Modal body-->
    </form>
@endsection
