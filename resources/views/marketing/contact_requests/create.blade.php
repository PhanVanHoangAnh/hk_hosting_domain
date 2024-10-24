@extends('layouts.main.popup')

@section('title')
Thêm đơn hàng
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp

    <form id="{{ $formId }}" action="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'store']) }}"
        method="post" enctype="multipart/form-data">
        @csrf

        <!--begin::Scroll-->
        @include('marketing.contact_requests._form', [
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
            var $marketingSourceSub = $('#sub_channel');

            let marketingSourceElement = document.getElementById('channel');
            let marketingSourceSubElement = document.getElementById('sub_channel');
            const marketingSourceSubValue = "{{ $contactRequest->sub_channel }}";
            
            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    submit();
                });
            }

            var submit = () => {
                var data = $(form).serialize();
                var url = form.getAttribute('action');
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
                        }
                    });
                }).fail(function(response) {
                    CreateContactRequestPopup.getPopup().setContent(response.responseText);
                });
            }

            var addSubmitEffect = () => {
                // btn effect
                btnSubmit.setAttribute('data-kt-indicator', 'on');
                btnSubmit.setAttribute('disabled', true);
            }

            var removeSubmitEffect = () => {
                // btn effect
                btnSubmit.removeAttribute('data-kt-indicator');
                btnSubmit.removeAttribute('disabled');
            }

            return {
                init: function() {
                    form = document.getElementById('{{ $formId }}');
                    btnSubmit = form.querySelector('[form-control="save"]');

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection