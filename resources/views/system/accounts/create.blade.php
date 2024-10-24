@extends('layouts.main.popup')

@section('title')
    Thêm Account Khách Hàng
@endsection
@php
    $formId = 'F' . uniqid();
@endphp
@section('content')
    <form id="{{ $formId }}" action="{{ action([App\Http\Controllers\System\AccountController::class, 'store']) }}"
        method="post">
        {{-- <input type="hidden" name="account_id" value="{{ $account_id }}"> --}}
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" >
            <!--begin::Input group-->
            <div class="row g-9 mb-7">
                <!--begin::Col-->
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Tên Account</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif"
                        placeholder="" name="name" value="{{ $accounts->name }}" />
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!--end::Col-->
            </div>
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="mb-7">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold mb-2">Chọn Nhóm Tài Khoản</label>
                <!--end::Label-->
                <select name="account_group_id" data-control="select2-ajax"
                    data-url="{{ action('App\Http\Controllers\AccountGroupController@select2') }}"
                    class="form-control @if ($errors->has('account_group_id')) is-invalid @endif"
                    data-dropdown-parent="#{{ $formId }}"
                    data-control="select2" data-placeholder="Chọn Nhóm Tài Khoản"
                >
                    @if (isset($account->accountGroup))
                        <option value="{{ $account->account_group_id }}" selected>{{ $account->accountGroup->name }}</option>
                    @endif
                </select>
                <x-input-error :messages="$errors->get('account_group_id')" class="mt-2" />
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateAccountSubmitButton" type="submit" class="btn btn-primary">
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
            AccountsCreate.init();
        });

        var AccountsCreate = function() {
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
                    CreateAccountPopup.getPopup().hide();
                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            AccountsList.getList().load();
                        }
                    });
                    // Accountslist.getList().load();
                }).fail(function(response) {
                    CreateAccountPopup.getPopup().setContent(response.responseText);

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
                    btnSubmit = document.getElementById('CreateAccountSubmitButton');

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
