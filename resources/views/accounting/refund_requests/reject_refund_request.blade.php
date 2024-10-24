    @extends('layouts.main.popup')

    @section('title')
        Từ chối duyệt hoàn phí của {{ $refundRequest->student->name }} trong khóa học  {{ $refundRequest->orderItem->orders->code }}
    @endsection

    @php
        $formId = 'F' . uniqid();
    @endphp

    @section('content')
        <form id="{{ $formId }}">
            @csrf

            <!-- begin::Scroll -->
            <div class="scroll-y pe-7 py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
                <!-- begin::Input group -->
                <div class="col-md-12 fv-row">
                    <!-- begin::Label -->
                    <label class="required fs-6 fw-semibold mb-2">Vui lòng nhập lý do bên dưới</label>
                    <!-- end::Label -->
                    <!-- begin::Textarea -->
                    <textarea class="form-control" placeholder="Lý do từ chối duyệt!" name="reject_reason" rows="5" cols="40">{{ $refundRequest->reject_reason }}</textarea>
                    <!-- end::Textarea -->
                    <x-input-error :messages="$errors->get('reject_reason')" class="mt-2" />                
                </div>
                
                <!-- end::Scroll -->

                <div class="modal-footer flex-center">
                    <!-- begin::Button -->
                    <button id="RejectSubmitButton" type="submit" class="btn btn-primary">
                        <span class="indicator-label">Lưu</span>
                        <span class="indicator-progress">Đang xử lý...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                    <!-- end::Button -->
                    <!-- begin::Button -->
                    <button type="reset" id="kt_modal_add_note_log_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Hủy</button>
                    <!-- end::Button -->
                </div>
            </div>
        </form>

        <script>
            $(() => {
                RejectRequest.init();
            });

            var RejectRequest = function() {
                var form;
                var btnSubmit;

                var handleFormSubmit = () => {
                    form.addEventListener('submit', (e) => {
                        e.preventDefault();
                        submit();
                    });
                };

                var submit = () => {
                    var data = $(form).serialize();
                    addSubmitEffect();
                    $.ajax({
                        url: "{{ action('App\Http\Controllers\Accounting\RefundRequestController@reject', ['id' => $refundRequest->id]) }}",
                        method: 'POST',
                        data: data,
                    }).done(function(response) {
                        UpdatePopup.getUpdatePopup().hide();
                        removeSubmitEffect();
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                RefundRequestList.getList().load();
                            }
                        });
                        UpdateRequestPopup.getUpdatePopup().hide();
                    }).fail(function(response) {
                        UpdatePopup.getUpdatePopup().setContent(response.responseText);
                        removeSubmitEffect();
                    });
                };

                var addSubmitEffect = () => {
                    btnSubmit.setAttribute('data-kt-indicator', 'on');
                    btnSubmit.setAttribute('disabled', true);
                };

                var removeSubmitEffect = () => {
                    btnSubmit.removeAttribute('data-kt-indicator');
                    btnSubmit.removeAttribute('disabled');
                };

                return {
                    init: function() {
                        form = document.getElementById('{{ $formId }}');
                        btnSubmit = document.getElementById('RejectSubmitButton');

                        handleFormSubmit();
                    }
                };
            }();
        </script>
    @endsection
