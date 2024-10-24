@extends('layouts.main.popup')

@section('title')
    Chỉnh Sửa AccountGroup
@endsection

@php
    $formId = 'F' . uniqid();
@endphp

@section('content')
    <form id="{{ $formId }}">
        @csrf

        @include('account_groups._form', [
            'formId' => $formId,
        ])
        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="UpdateAccountGroupSubmitButton" type="submit" class="btn btn-primary">
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
            AccountGroupsEdit.init();
        });

        //
        var AccountGroupsEdit = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                var accountGroupIdInput = form.querySelector('input[name="account_group_id"]');
                var accountGroupId = accountGroupIdInput.value;
                var data = $(form).serialize();

                //hieu ung
                addSubmitEffect();

                $.ajax({
                    url: '/account-group/' + accountGroupId,
                    method: 'PUT',
                    data: data,
                }).done(function(response) {
                    // hide popup
                    UpdateAccountGroupPopup.getPopup().hide();
                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // load lai list
                            AccountGroupsList.getList().load();
                        }
                    });
                }).fail(function(response) {
                    UpdateAccountGroupPopup.getPopup().setContent(response.responseText);

                    // remove hieu ung
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
                    btnSubmit = document.getElementById('UpdateAccountGroupSubmitButton');

                    // data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
