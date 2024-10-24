@extends('layouts.main.popup')

@section('title')
    ThêmAccountGroup Khách Hàng
@endsection

@php
    $formId = 'F' . uniqid();
@endphp

@section('content')
    <form id="{{ $formId }}" action="{{ action([App\Http\Controllers\AccountGroupController::class, 'store']) }}" method="post">
        @csrf

        @include('account_groups._form', [
            'formId' => $formId,
        ])

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateAccountGroupSubmitButton" type="submit" class="btn btn-primary">
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
            AccountGroupsCreate.init();
        });

        var AccountGroupsCreate = function() {
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
                var data = $(form).serialize();
                // Thêm hiệu ứng
                addSubmitEffect();

                $.ajax({
                    url: '',
                    method: 'POST',
                    data: data,
                }).done(function(response) {
                    // hide popup
                    CreateAccountGroupPopup.getPopup().hide();
                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            AccountGroupsList.getList().load();
                        }
                    });
                    // AccountGroupslist.getList().load();
                }).fail(function(response) {
                    CreateAccountGroupPopup.getPopup().setContent(response.responseText);

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
                    btnSubmit = document.getElementById('CreateAccountGroupSubmitButton');

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
