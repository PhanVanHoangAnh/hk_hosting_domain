@extends('layouts.main.popup')

@section('title')
Thêm Đơn hàng
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp

    <form id="{{ $formId }}" action="{{ action([App\Http\Controllers\Abroad\ContactRequestController::class, 'store']) }}"
        method="post"  enctype="multipart/form-data">
        @csrf

        <!--begin::Scroll-->
        @include('abroad.extracurricular.contact_requests._form', [
            'formId' => $formId,
        ])

        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button form-control="save" type="submit" class="btn btn-primary">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
    $(function() {
        ContactRequestsCreate.init();
    });

    var ContactRequestsCreate = function() {
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
            var url = form.getAttribute('action');
            // Thêm hiệu ứng
            addSubmitEffect();

            $.ajax({
                url: url,
                method: 'POST',
                data: data,

            }).done(function(response) {
                // hide popup
                CreateContactRequestPopup.getPopup().hide();
                removeSubmitEffect();
                // success alert
                ASTool.alert({
                    message: response.message,
                    ok: function() {
                        // reload list
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();

                        if (typeof pickContactPopup != 'undefined') pickContactPopup.updateUrl("{{ action([App\Http\Controllers\Abroad\OrderController::class, 'pickContact'], ['contact_id' => isset($contactRequest->contact_id) ? $contactRequest->contact_id : '']) }}");
                        // Trick
                        setTimeout(() => {
                            if (typeof addNewContactRequestPopup != 'undefined') addNewContactRequestPopup.hide();
                        }, 0);
                    }
                });
            }).fail(function(response) {
                CreateContactRequestPopup.getPopup().setContent(response.responseText);
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
                form = document.getElementById('{{ $formId }}');
                btnSubmit = form.querySelector('[form-control="save"]');

                //data-kt-indicator="on"

                handleFormSubmit();
            }
        }
    }();
    </script>
@endsection