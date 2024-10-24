<!--begin::Modal dialog-->
<div class="modal-dialog modal-lg modal-{{ $size ?? '' }} modal-dialog-centered" tabindex="-1" id="popup">
    <!--begin::Modal content-->
    <div class="modal-content">
        <!--begin::Modal header-->
        <div class="modal-header @hasSection('title') @else border-0 justify-content-end @endif">
            @hasSection('title')
                <!--begin::Modal title-->
                <h2 class="fw-bold mb-0">@yield('title')</h2>
                <!--end::Modal title-->
            @endif
            <!--begin::Close-->
            <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                <i class="material-symbols-rounded fs-1">
                    close
                </i>
            </div>
            <!--end::Close-->
        </div>
        <!--end::Modal header-->
        <!--begin::Modal body-->
        <div class="modal-body p-0">
            
            @yield('content')

        </div>
        <!--end::Modal body-->
    </div>
    <!--end::Modal content-->
</div>
<!--end::Modal dialog-->