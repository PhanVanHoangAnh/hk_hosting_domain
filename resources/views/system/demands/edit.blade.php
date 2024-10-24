@extends('layouts.main.popup')

@section('title')
    Chỉnh Sửa Đơn Hàng
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp

    <form id="{{ $formId }}"
        action="{{ action(
            [App\Http\Controllers\System\DemandController::class, 'update'],
            [
                'id' => $demand->id,
            ],
        ) }}"
        method="post">
        @csrf

        <!--begin::Scroll-->
            <!--begin::Input group-->


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
            DemandUpdate.init();
        });

        var DemandUpdate = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            //Pthuc xử lý việc gửi biểu mẫu lên máy chủ thông qua AJAX
            submit = () => {
                // Lấy dữ liệu từ biểu mẫu.
                var url = form.getAttribute('action');
                var data = $(form).serialize();

                // Thêm hiệu ứng
                addSubmitEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                }).done(function(response) {
                    // hide popup
                    UpdateDemandPopup.getPopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            DemandsList.getList().load();
                        }
                    });

                    // reload list
                    if (DemandsList) {
                        DemandsList.getList().load();
                    }
                }).fail(function(response) {
                    UpdateDemandPopup.getPopup().setContent(response.responseText);

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
                    form = document.getElementById('{{ $formId }}');
                    btnSubmit = form.querySelector('[form-control="save"]');

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
