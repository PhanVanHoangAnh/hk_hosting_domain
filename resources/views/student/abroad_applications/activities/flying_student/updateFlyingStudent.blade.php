@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa thời điểm học sinh lên đường
@endsection
@php
    $formId = 'F_' . uniqid();
@endphp

@section('content')
    <div>
        <form id="{{ $formId }}" method="POST" tabindex="-1" enctype="multipart/form-data"s
            action="{{ action(
                [App\Http\Controllers\Student\AbroadController::class, 'doneUpdateFlyingStudent'],
                [
                    'id' => $flyingStudent->id,
                ],
            ) }}">
            @csrf
            <div class="pe-7 py-5   px-lg-17">
                <!--begin::Input group-->
                <input type="hidden" name="abroad_application_id" value="{{ $abroadApplication->id }}">
                <!--end::Input group-->
                <!--begin::Input group-->
                <div class="row py-3">
                    <div class="col-md-6 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Ngày khởi hành</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input data-control="input" name="flight_date" placeholder="=asas" type="date"
                            class="form-control" placeholder="" value="{{ $flyingStudent->flight_date }}" required>
                        <span data-control="clear" class="material-symbols-rounded clear-button"
                            style="display:none;">close</span>
                    </div>

                    <div class="col-md-6 fv-row">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Giờ bay</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <input type="time" class="form-control " placeholder="" name="flight_time"
                            value="{{ $flyingStudent->flight_time }}" />
                        <!--end::Input-->

                    </div>
                </div>

                <div class="row py-3">
                    <div class="col-md-12 fv-row ">
                        <label class="required fs-6 fw-semibold mb-2">Hãng hàng không</label>
                        <input type="text" class="form-control " placeholder="" name="air"
                            value="{{ $flyingStudent->air }}" />
                    </div>

                </div>

            </div>

            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button id="CreateFlyingStudentButton" type="submit" class="btn btn-primary">
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
                UpdateFlyingStudent.init();
            });

            var UpdateFlyingStudent = function() {
                let form;
                let submitBtn;

                const handleFormSubmit = () => {

                    form.addEventListener('submit', e => {

                        e.preventDefault();

                        submit();
                    })
                }

                submit = () => {

                    var formData = new FormData(form);
                    const csrfToken = '{{ csrf_token() }}';
                    formData.append('_token', csrfToken);

                    var url = form.getAttribute('action');


                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false
                    }).done(response => {

                        UpdatePopup.getUpdatePopup().hide();

                        // success alert
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                flyingStudent.load();
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

                        form = document.querySelector("#{{ $formId }}");
                        submitBtn = document.querySelector("#CreateFlyingStudentButton");

                        handleFormSubmit();
                    }
                }
            }();
        </script>
    @endsection
