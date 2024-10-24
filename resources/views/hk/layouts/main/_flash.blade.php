@if (session('warning'))
    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-light-warning d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <span class="material-symbols-rounded text-warning me-3" style="padding-top:2px;">
            error
        </span>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <!--begin::Content-->
            <span>{{ session('warning') }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
@endif

@if (session('error'))
    <!--begin::Alert-->
    <div class="alert alert-dismissible bg-light-danger d-flex flex-column flex-sm-row p-5 mb-10">
        <!--begin::Icon-->
        <span class="material-symbols-rounded text-danger me-3" style="padding-top:2px;">
            error
        </span>
        <!--end::Icon-->

        <!--begin::Wrapper-->
        <div class="d-flex flex-column pe-0 pe-sm-10">
            <!--begin::Content-->
            <span>{{ session('error') }}</span>
            <!--end::Content-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Alert-->
@endif