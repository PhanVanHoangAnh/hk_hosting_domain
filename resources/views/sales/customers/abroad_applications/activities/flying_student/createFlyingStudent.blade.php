@extends('layouts.main.popup')

@section('title')
    Thời điểm học sinh lên đường
@endsection
@php
    $formId = 'F_' . uniqid();
@endphp

@section('content')
    <form id="{{ $formId }}" method="POST" tabindex="-1" enctype="multipart/form-data"
        action="{{ action(
            [App\Http\Controllers\Sales\AbroadController::class, 'doneCreateFlyingStudent'],
            [
                'id' => $abroadApplication->id,
            ],
        ) }}">
        @csrf
        <div class="pe-7 py-5   px-lg-17">
            <input type="hidden" name="abroad_application_id" value="{{ $abroadApplication->id }}">
            <div class="row py-3">
                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Ngày khởi hành</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="flight_date" placeholder="=asas" type="date"
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
                            <span class="">Giờ khởi hành</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="flight_time" placeholder="=asas" type="time"
                                    class="form-control" placeholder="" required />
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row py-3">
                <div class="col-md-12 fv-row ">
                    <label class="required fs-6 fw-semibold mb-2">Hãng hàng không</label>
                    <input type="text" class="form-control " placeholder="" name="air" value="" />
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
            CreateFlyingStudent.init();
        });

        var CreateFlyingStudent = function() {
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
