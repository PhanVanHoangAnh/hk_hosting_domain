@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa thông tin đơn hàng
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp

    <form id="{{ $formId }}" method="put"
        action="{{ action(
            [App\Http\Controllers\Marketing\ContactRequestController::class, 'update'],
            [
                'id' => $contactRequest->id,
            ],
        ) }}">
        @csrf

        <!--begin::Scroll-->
            <!--begin::Input group-->
            <input type="hidden" name="contact_request_id" value="{{ $contactRequest->id }}" />

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
            ContactRequestsUpdate.init();
        });

        var ContactRequestsUpdate = function() {
            var form;
            var btnSubmit;
            const marketingSourceSubValue = "{{ $contactRequest->sub_channel }}";

            var handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();
                    submit();
                });
            };

            submit = () => {
                var contactRequestIdInput = form.querySelector('input[name="contact_request_id"]');
                var contactRequestId = contactRequestIdInput.value;
                var data = $(form).serialize();
                var url = form.getAttribute('action');
                addSubmitEffect();

                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: data,

                }).done(function(response) {
                    // hide popup
                    UpdateContactRequestPopup.getPopup().hide();

                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list

                            if (typeof ContactRequestsList !== 'undefined') {
                                if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();

                            } else {
                                throw new Error('ContactRequestsList undefined');
                            }
                        }
                    });
                    // UpdateContactRequestPopup.getPopup().show();
                }).fail(function(response) {
                    UpdateContactRequestPopup.getPopup().setContent(response.responseText);
                    // removeSubmitEffect();
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

            function reloadShowView(contactRequestId) {
                var data = $(form).serialize();
                $.ajax({
                    url: "{{ action('App\Http\Controllers\Marketing\ContactRequestController@show', ['id' => $contactRequest->id]) }}",
                    method: 'GET',
                    data: data,
                }).done(function(refresh) {
                    var newData = $("#ContactRequestsInformation", data)
                    $("#ContactRequestsInformation").html(newData);
                    location.reload();
                }).fail(function(response) {
                });
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
