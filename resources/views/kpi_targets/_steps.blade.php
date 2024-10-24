<!--begin::Nav-->
<div class="stepper-nav flex-cente">
    <!--begin::Step 1-->
    <div class="stepper-item me-5 {{ $step == 'upload' ? 'current' : '' }}" data-kt-stepper-element="nav">
        <!--begin::Wrapper-->
        <div class="stepper-wrapper d-flex align-items-center">
            <!--begin::Icon-->
            <div class="stepper-icon w-40px h-40px">
                <i class="stepper-check fas fa-check"></i>
                <span class="stepper-number">1</span>
            </div>
            <!--end::Icon-->

            <!--begin::Label-->
            <div class="stepper-label">
                <h3 class="stepper-title">
                    Bước 1: Tải dữ liệu
                </h3>

                <div class="stepper-desc">
                    Tải dữ liệu cần nhập
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
    <div class="stepper-item me-5 {{ $step == 'preview' ? 'current' : '' }}" data-kt-stepper-element="nav">
        <!--begin::Wrapper-->
        <div class="stepper-wrapper d-flex align-items-center">
            <!--begin::Icon-->
            <div class="stepper-icon w-40px h-40px">
                <i class="stepper-check fas fa-check"></i>
                <span class="stepper-number">2</span>
            </div>
            <!--begin::Icon-->

            <!--begin::Label-->
            <div class="stepper-label">
                <h3 class="stepper-title">
                    Bước 2: Xem trước
                </h3>

                <div class="stepper-desc">
                    Xem trước dữ liệu kế hoạch KPI
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
    <div class="stepper-item me-5 {{ $step == 'result' ? 'current' : '' }}" data-kt-stepper-element="nav">
        <!--begin::Wrapper-->
        <div class="stepper-wrapper d-flex align-items-center">
            <!--begin::Icon-->
            <div class="stepper-icon w-40px h-40px">
                <i class="stepper-check fas fa-check"></i>
                <span class="stepper-number">3</span>
            </div>
            <!--begin::Icon-->

            <!--begin::Label-->
            <div class="stepper-label">
                <h3 class="stepper-title">
                    Bước 3: Hoàn thành
                </h3>

                <div class="stepper-desc">
                    Kết quả nhập dữ liệu KPI
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
</div>
<!--end::Nav-->