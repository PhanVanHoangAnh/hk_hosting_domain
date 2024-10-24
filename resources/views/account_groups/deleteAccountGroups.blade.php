@extends('layouts.main.popup')

@section('title')
    Xóa accountGroups của khách hàng đã chọn
@endsection
@php
    $formId = 'F' . uniqid();
@endphp

@section('content')
    <form id="{{ $formId }}">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" >
            <!--begin::Input group-->
            <!--end::Input group-->
            <div class="fv-row ">
                <label class="fs-6 fw-semibold mb-2 ">Danh sách khách hàng </label>
                <div class="table-responsive">
                    <table class="table  table-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th>Name</th>
                                <th>Ngày cập nhật</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($accountGroups as $accountGroup)
                                <input type="hidden" name="account_group_ids[]" value="{{ $accountGroup->id }}">
                                <tr>
                                    <td>{{ $accountGroup->name }} </td>
                                    <td> {{ $accountGroup->updated_at }}</td>
                                    <td> {{ $accountGroup->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>



        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="DeleteAccountGroupsSubmitButton" type="submit" class="btn btn-danger">
                <span class="indicator-label">Xóa account Groups</span>
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
            DeleteAccountGroups.init();
        });

        var DeleteAccountGroups = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                var data = $(form).serialize();
                addSubmitEffect();

                $.ajax({
                    url: '/account-group/action-delete-account-group',
                    method: 'DELETE',
                    data: data,

                }).done(function(response) {
                    // hide popup
                    // hide popup
                    DeleteAccountGroupsPopup.getPopup().hide();
                    removeSubmitEffect();
                    
                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            AccountGroupsList.getList().load();
                        }
                    });

                }).fail(function(response) {
                    // 
                    // hide popup
                    DeleteAccountGroupsPopup.getPopup().hide();
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
                    btnSubmit = document.getElementById('DeleteAccountGroupsSubmitButton');

                    //data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
