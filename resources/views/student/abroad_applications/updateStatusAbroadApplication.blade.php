@extends('layouts.main.popup')

@section('title')
    Bàn giao hồ sơ du học
@endsection
@php
    $updateStatusAbroadApplication = 'updateStatusAbroadApplication_' . uniqid();
@endphp
@section('content')
    <form id="{{ $updateStatusAbroadApplication }}"
        action="{{ action(
            [App\Http\Controllers\Student\AbroadController::class, 'doneAssignmentAbroadApplication'],
            [
                'id' => $abroadApplication->id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y
        pe-7 py-10 px-lg-17" >
            <!--begin::Input group-->
            <input type="hidden" name="abroadApplication" value="{{ $abroadApplication->id }}" />
            <!--end::Input group-->
            <div class="row">
                <div class="col-md-12">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2 mt-4">
                        <span class="">Nhân viên tư vấn du học chiến lược</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="form-outline">
                        <select name="account_id_1" data-control="select2-ajax" list-action="sales-select"
                            data-url="{{ action('App\Http\Controllers\AccountController@select2') }}" class="form-control"
                            data-dropdown-parent="" data-control="select2" data-placeholder="Chọn nhân viên">
                            
                        </select>
                    </div>
                    <!--end::Input-->
                </div>
                <div class="col-md-6 d-none">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2 mt-4">
                        <span class="">Nhân viên truyền thông & sự kiện</span>
                    </label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <div class="form-outline">
                        <select name="account_id_2" data-control="select2-ajax" list-action="sales-select"
                            data-url="{{ action('App\Http\Controllers\AccountController@select2') }}" class="form-control"
                            data-dropdown-parent="" data-control="select2" data-placeholder="Chọn nhân viên">
                           
                        </select>
                    </div>
                    <!--end::Input-->
                </div>

            </div>

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="UpdateStatusAbroadApplicationButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Duyệt & Bàn giao</span>
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
            updateStatusAbroadApplication.init();
        })

        var updateStatusAbroadApplication = function() {
            let form;
            let submitBtn;

            const handleFormSubmit = () => {

                form.addEventListener('submit', e => {

                    e.preventDefault();

                    submit();
                })
            }

            submit = () => {

                const abroadApplication = document.querySelector('input[name="abroadApplication"]')
                    .value;
                const formData = $(form).serialize();
                var url = form.getAttribute('action');


                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: formData,
                }).done(response => {

                    UpdateNotelogPopup.getUpdatePopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // location.reload();
                            abroadApplicationsList.getList().load();
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

            deleteUpdatePopup = () => {
                form.removeEventListener('submit', submit);

                updateStatusAbroadApplication = null;
            }

            return {
                init: () => {

                    form = document.querySelector('#{{ $updateStatusAbroadApplication }}');
                    submitBtn = document.querySelector("#UpdateStatusAbroadApplicationButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
