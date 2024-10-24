@extends('layouts.main.popup')

@section('title')
    Thêm mới định hướng du học
@endsection
@php
    $formId = 'F_' . uniqid();
@endphp

@section('content')
    <form id="{{ $formId}}"
        action="{{ action(
            [App\Http\Controllers\Sales\AbroadController::class, 'doneCreateCulturalOrientation'],
            [
                'id' => $id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y pe-7 py-10 px-lg-17" >

            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <div class="row mb-4">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-2">
                        <div class="form-outline">
                            <label class=" fs-6 fw-semibold mb-2" for="american-cultural-education-select"> Tình trạng (học văn hoá Mỹ) </label>
                            <select id="american-cultural-education-select" class="form-select form-control" name="american_cultural_education_status"
                                data-control="select2" data-placeholder="Tình trạng (học văn hoá Mỹ)"
                                data-allow-clear="true">
                                <option value="">Tình trạng (học văn hoá Mỹ)</option>
                                <option value="">Chọn</option>
                                <option value="1">Hoàn thành</option>
                                <option value="0">Chưa hoàn thành</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-2">
                        <div class="form-outline">
                            <label class=" fs-6 fw-semibold mb-2" for="need-open-bank-account-select"> Học viên có cần mở tài khoản ngân hàng </label>
                            <select id="need-open-bank-account-select" class="form-select form-control" name="need_open_bank_account"
                                data-control="select2" data-placeholder="Học viên có cần mở tài khoản ngân hàng"
                                data-allow-clear="true">
                                <option value="">Học viên có cần mở tài khoản ngân hàng </option>
                                <option value="">Chọn</option>
                                <option value="1">Có</option>
                                <option value="0">Không</option>
                            </select>
                        </div>
                    </div>
        
                    <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-2">
                        <div class="form-outline">
                            <label class=" fs-6 fw-semibold mb-2" for="need-buy-sim-select">
                                Học sinh cần mua  sim điện thoại ?
                            </label>
                            <select id="need-buy-sim-select-select" class="form-select form-control"
                                name="need_buy_sim" data-control="select2"
                                data-placeholder="Học sinh cần mua  sim điện thoại ?"
                                data-allow-clear="false">
                                <option value="">Chọn</option>
                                <option value="1">Có</option>
                                <option value="0">Không</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Input group-->

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateCulturalOrientationButton" type="submit" class="btn btn-primary">
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
            CreateCulturalOrientation.init();
        })

        var CreateCulturalOrientation = function() {
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
                            culturalOrientations.load();
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
                    submitBtn = document.querySelector("#CreateCulturalOrientationButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
