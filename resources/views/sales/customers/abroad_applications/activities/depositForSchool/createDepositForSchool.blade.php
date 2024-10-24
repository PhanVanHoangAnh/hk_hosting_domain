@extends('layouts.main.popup')

@section('title')
    Thêm mới phiếu đặt cọc
@endsection
@php
    $formId = 'F_' . uniqid();
@endphp

@section('content')
    <form id="{{ $formId}}"
        action="{{ action(
            [App\Http\Controllers\Sales\AbroadController::class, 'doneCreateDepositForSchool'],
            [
                'id' => $id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y pe-7 py-10 px-lg-17" >

            
            <div class="row">
                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Ngày đặt cọc</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="date" placeholder="=asas" type="date"
                                    class="form-control" placeholder="" required />
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6"> 
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Số tiền</span>
                        </label>

                        <input type="text" class="form-control" id="amount-input" list-action='format-number' name="amount" placeholder="Số tiền"
                            required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div> 
                </div>

            </div>
            <div class="row">
                <label class="mt-3 fs-6 fw-semibold mb-2">
                    <span class="">Link phiết đặt cọc</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="deposit_receipt_link" placeholder="Nhập link phiếu đặt cọc!" rows="5" cols="40"></textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('link')" class="mt-2" />
            </div>
        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateDepositForSchoolButton" type="submit" class="btn btn-primary">
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
        $(() => {
            CreateDepositForSchool.init(); 
        })


        var CreateDepositForSchool = function() {
            let form;
            let submitBtn;

            const handleFormSubmit = () => {

                form.addEventListener('submit', e => {

                    e.preventDefault();

                    submit();
                })
            }

            submit = () => {

                const formData = $(form).serialize();
                var url = form.getAttribute('action');


                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: formData,
                }).done(response => {

                    UpdatePopup.getUpdatePopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            depositForSchool.load();
                        }
                    });

                }).fail(message => {
                    // UpdatePopup.getUpdatePopup().setContent(message.responseText);
                    removeSubmitEffect();
                })
            }

            addSubmitEffect = () => {

                // btn effect
                submitBtn.setAttribute('data-kt-indicator', 'on');
                submitBtn.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {

                // btn effect
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.removeAttribute('disabled');
            }
            return {
                init: () => {

                    form = document.querySelector("#{{$formId}}");
                    submitBtn = document.querySelector("#CreateDepositForSchoolButton");


                    // amount input mask
                    new IMask(form.querySelector('[name="amount"]'), {
                        mask: Number,
                        scale: 0,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                    });
                    
                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
