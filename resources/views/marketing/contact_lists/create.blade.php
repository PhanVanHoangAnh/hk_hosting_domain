@extends('layouts.main.popup')

@section('title')
Hợp đồng
@endsection

@section('content')
<form id="CreateContactForm" action="{{ action([App\Http\Controllers\Marketing\ContactListController::class, 'store']) }}"
    method="post">
    @csrf

    <!--begin::Scroll-->
    <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_customer_scroll" data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
        data-kt-scroll-dependencies="#kt_modal_add_customer_header"
        data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
        <!--begin::Input group-->
        <div class="row g-9 mb-7">
            <!--begin::Col-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold mb-2">Tên</label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="text" class="form-control is-invalid" placeholder="" name="name"
                    value="{{ $contact->name }}" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!--end::Col-->

        </div>
        <!--end::Input group-->


    </div>

    <!--end::Scroll-->

    <div class="modal-footer flex-center">
        <!--begin::Button-->
        <button id="CreateContactSubmitButton" type="submit" class="btn btn-primary">
            <span class="indicator-label">Lưu</span>
            <span class="indicator-progress">Đang xử lý...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
        <!--end::Button-->
        <!--begin::Button-->
        <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
            data-bs-dismiss="modal">Hủy</button>
        <!--end::Button-->
    </div>
</form>

<script>
$(function() {
    ContactCreate.init();
});

var ContactCreate = function() {
    var form;
    var btnSubmit;

    var handleFormSubmit = () => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            submit();
        });
    }

    submit = () => {
        // Lấy dữ liệu từ biểu mẫu.
        var data = $(form).serialize();
        // Thêm hiệu ứng
        addSubmitEffect();

        $.ajax({
            url: '',
            method: 'POST',
            data: data,
        }).done(function(response) {
            // hide popup
            CreateCampaignPopup.getPopup().hide();

            // success alert
            ASTool.alert({
                message: response.message,
                ok: function() {
                    // reload list
                    ContactsList.getList().load();
                }
            });
        }).fail(function(response) {
            CreateCampaignPopup.getPopup().setContent(response.responseText);

            // 
            removeSubmitEffect();
        });
    }

    addSubmitEffect = () => {
        // btn effect
        btnSubmit.setAttribute('data-kt-indicator', 'on');
        btnSubmit.setAttribute('disabled', true);
    }

    removeSubmitEffect = () => {
        // btn effect
        btnSubmit.removeAttribute('data-kt-indicator');
        btnSubmit.removeAttribute('disabled');
    }

    return {
        init: function() {
            form = document.getElementById('CreateContactForm');
            btnSubmit = document.getElementById('CreateContactSubmitButton');

            //data-kt-indicator="on"

            handleFormSubmit();
        }
    }
}();
</script>
@endsection