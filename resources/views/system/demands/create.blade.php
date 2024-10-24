@extends('layouts.main.popup')

@section('title')
    Thêm Đơn Hàng
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp

    <form id="{{ $formId }}" action="{{ action([App\Http\Controllers\System\DemandController::class, 'store']) }}" method="post" enctype="multipart/form-data">
        @csrf

        <!--begin::Scroll-->
        @include('system.demands._form', [
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
            DemandsCreate.init();
        });

        var DemandsCreate = function() {
            var form;
            var btnSubmit;
            var popup;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    submit();
                });
            }

            // $('[list-action="marketing-source-select"]').on('change', function() {
            //     loadSourceSubs();
            //     });

            var submit = () => {
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
                    popup.hide();

                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            if (typeof(DemandsList) !== 'undefined') {
                                // reload list
                                DemandsList.getList().load();
                            }
                        }
                    });

                    // success callback
                    if (typeof(popup.success) !== 'undefined') {
                        popup.success(response);
                    }
                }).fail(function(response) {
                    popup.setContent(response.responseText);

                    // fail callback
                    if (typeof(popup.fail) !== 'undefined') {
                        popup.fail(response);
                    }
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
                    popup = window.popups[$(form).closest('.modal').attr('id')];

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
