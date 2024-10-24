@extends('layouts.main.popup')

@section('title')
Chỉnh sửa hợp đồng
@endsection

@section('content')
<form id="UpdateCustomerForm" action="{{ action([App\Http\Controllers\Marketing\ContactListController::class, 'update'], [
    'id' => $contact->id,]) }}" method="put">
    @csrf

    <!--begin::Scroll-->
    <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_customer_scroll" data-kt-scroll="true"
        data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
        data-kt-scroll-dependencies="#kt_modal_add_customer_header"
        data-kt-scroll-wrappers="#kt_modal_add_customer_scroll" data-kt-scroll-offset="300px">
        <!--begin::Input group-->
        <input type="hidden" name="contact_id" value="{{ $contact->id }}" />


        <!--begin::Input group-->
        <div class="fv-row mb-7">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold mb-2">
                <span class="">Name</span>
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif"
                name="name" placeholder="" value="{{ $contact->name }}" />
            <!--end::Input-->
        </div>
        <!--end::Input group-->


    </div>
    <!--end::Scroll-->

    <div class="modal-footer flex-center">
        <!--begin::Button-->
        <button id="UpdateCustomerSubmitButton" type="submit" class="btn btn-primary">
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
    CustomersUpdate.init();
});

var CustomersUpdate = function() {
    var form;
    var btnSubmit;

    var handleFormSubmit = () => {
        form.addEventListener('submit', (e) => {
            e.preventDefault();

            submit();
        });
    }


    submit = () => {
        var customerIdInput = form.querySelector('input[name="contact_id"]');
        var customerId = customerIdInput.value;
        var data = $(form).serialize();
        addSubmitEffect();

        $.ajax({
            url: '/marketing/contact-lists/' + customerId,
            method: 'PUT',
            data: data,

        }).done(function(response) {
            // hide popup
            UpdateCampaignPopup.getPopup().hide();

            removeSubmitEffect();

            // success alert
            ASTool.alert({
                message: response.message,
                ok: function() {
                    // reload list
                    ContactsList.getList().load();
                }
            });
            // UpdateCampaignPopup.getPopup().show();
        }).fail(function(response) {
            UpdateCampaignPopup.getPopup().setContent(response.responseText);

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
            form = document.getElementById('UpdateCustomerForm');
            btnSubmit = document.getElementById('UpdateCustomerSubmitButton');

            //data-kt-indicator="on"

            handleFormSubmit();
        }
    }
}();
</script>
@endsection