@extends('layouts.main.popup')

@section('title')
    Xóa accounts của khách hàng đã chọn
@endsection

@section('content')
    <form id="DeleteAccountsForm">
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
                            @foreach ($accounts as $account)
                                <input type="hidden" name="account_ids[]" value="{{ $account->id }}">
                                <tr>
                                    <td>{{ $account->name }} </td>
                                    <td> {{ $account->updated_at }}</td>
                                    <td> {{ $account->created_at }}</td>
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
            <button id="DeleteAccountsSubmitButton" type="submit" class="btn btn-danger">
                <span class="indicator-label">Xóa accounts</span>
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
            DeleteAccounts.init();
        });

        var DeleteAccounts = function() {
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
                    url: '/accounts/action-delete-accounts',
                    method: 'DELETE',
                    data: data,

                }).done(function(response) {
                    // hide popup
                    // hide popup
                    DeleteAccountsPopup.getPopup().hide();
                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            AccountsList.getList().load();
                        }
                    });

                }).fail(function(response) {


                    // 
                    // hide popup
                    DeleteAccountsPopup.getPopup().hide();
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
                    form = document.getElementById('DeleteAccountsForm');
                    btnSubmit = document.getElementById('DeleteAccountsSubmitButton');

                    //data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
