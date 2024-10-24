@extends('layouts.main.popup')

@section('title')
    Thêm tài khoản thanh toán
@endsection

@section('content')
    <form id="CreatePaymentAccountForm" action="{{ action([App\Http\Controllers\Accounting\PaymentAccountController::class, 'store']) }}" method="post">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" >
            <!--begin::Input group-->
            <div class="fv-row mb-10 fv-plugins-icon-container">
                <!--begin::Label-->
                <div class="row">
                    

                    <div class="col-md-12">

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="">Ngân hàng</span>
                            </label>

                            <input type="text" class="form-control" id="" name="bank" placeholder="Ngân hàng"
                                required/>
                            <x-input-error :messages="$errors->get('bank')" class="mt-2" />
                        </div>

                    </div>

                </div>

                <div class="row">
                    <div class="col-md-6">

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="">Tên tài khoản ngân hàng</span>
                            </label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="text" class="form-control" id="" name="account_name" placeholder="Tên tài khoản ngân hàng"
                            required />
                            <x-input-error :messages="$errors->get('account_name')" class="mt-2" />
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="fv-row mb-7">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="">Số tài khoản</span>
                            </label>

                            <input type="text" class="form-control" id="" name="account_number" placeholder="Số tài khoản"
                            required  />
                            <x-input-error :messages="$errors->get('account_number')" class="mt-2" />
                        </div>

                    </div>

                </div>
                

                <div class="col-md-12 fv-row">
                <!--begin::Label-->
                <label class=" fs-6 fw-semibold mb-2">Ghi chú</label>
                <!--end::Label-->
                <!--begin::Textarea-->
                <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="description" rows="5" cols="40"></textarea>
                <!--end::Textarea-->
            </div>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />

            </div>
            <!--end::Input group-->

            
        </div>

        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreatePaymentAccountSubmitButton" type="submit" class="btn btn-primary">
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
            PaymentAccountCreate.init();
        });

        var PaymentAccountCreate = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

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
                    CreatePaymentAccountPopup.getPopup().hide();
                
                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            AccountsList.getList().load();
                        }
                    });
                }).fail(function(response) {
                    CreatePaymentAccountPopup.getPopup().setContent(response.responseText);

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
                    form = document.getElementById('CreatePaymentAccountForm');
                    btnSubmit = document.getElementById('CreatePaymentAccountSubmitButton');

                    //data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection