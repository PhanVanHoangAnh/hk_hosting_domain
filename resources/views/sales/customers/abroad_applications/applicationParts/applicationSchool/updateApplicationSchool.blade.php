@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa trường yêu cầu tuyển sinh
@endsection
@php
    $updateApplicationSchool = 'updateApplicationSchool_' . uniqid();
@endphp
@section('content')
    <form id="{{ $updateApplicationSchool }}"
        action="{{ action(
            [App\Http\Controllers\Sales\AbroadController::class, 'doneUpdateApplicationSchool'],
            [
                'id' => $applicationSchool->id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y
        pe-7 py-10 px-lg-17" >

            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <div class="row">
                    <div class="col-md-4">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Phân loại</span>
                        </label>
                        <select list-action="abroad_status" name="type_school" class="form-select filter-select "  data-control="select2"
                            data-close-on-select="false" data-placeholder="Chọn nhóm trường" data-allow-clear="true" >
                            <option value="" selected disabled hidden></option>
                            @foreach (\App\Models\ApplicationSchool::getAllType() as $type)
                                <option value="{{ $type }}" {{ isset($applicationSchool) && $applicationSchool->type == $type? 'selected' : '' }}> {{ trans('messages.application_school.type.' . $type) }} </option>  
                            @endforeach

                        </select>
                        <!--end::Label-->
                    </div>

                    <div class="col-md-4">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 ">
                            <span class="">Chọn trường trường</span>
                        </label>
                        <select list-action="abroad_status" name="school" class="form-select filter-select" data-control="select2"
                            data-close-on-select="false" data-placeholder="Chọn nhóm trường" data-allow-clear="true" >
                            <option value="" selected disabled hidden></option>
                            @foreach(\App\Models\School::all()  as $school)
                                <option value="{{ $school->id }}" {{ isset($applicationSchool) && $applicationSchool->school_id == $school->id? 'selected' : '' }}> {{ $school->name }} </option>  
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 ">
                            <span class="">Thời điểm nộp hồ sơ</span>
                        </label>
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" value="{{$applicationSchool->apply_date}}" name="apply_date" 
                                placeholder="=asas" type="date" class="form-control">
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                    </div>

            </div>
            <!--begin::Label-->
            <label class="fs-6 fw-semibold mb-2 mt-4 d-none">
                <span class="">Yêu cầu</span>
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input class="form-control d-none" name="requirement" placeholder="Nhập yêu cầu" type="text" value="{{ $applicationSchool->requirement }}">

            <!--end::Input-->
            
         
            <!--end::Input group-->
            <div id="error-message-certification" class="error-message text-danger mt-4" style="display: none;"></div>

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="UpdateApplicationSchoolButton" type="submit" class="btn btn-primary">
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
            updateApplicationSchool.init();
        })

        var updateApplicationSchool = function() {
            let form;
            let submitBtn;

            function hasSelectSchool() {
                const selectSchool = document.querySelector('[name="school"]').value;
                return selectSchool == '';
            }
            function hasSelectType() {
                const selectType = document.querySelector('[name="type_school"]').value;

                return selectType == '';
            }
            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    submit();
                })
            }


            submit = () => {
                if (hasSelectType()) {
                    const errorContainer = document.getElementById('error-message-certification');
                    errorContainer.textContent =
                        'Vui lòng chọn phân loại!';
                    errorContainer.style.display = 'block';
                    return;
                }
                if (hasSelectSchool()) {
                    const errorContainer = document.getElementById('error-message-certification');
                    errorContainer.textContent =
                        'Vui lòng chọn trường!';
                    errorContainer.style.display = 'block';
                    return;
                }
                
                const formData = $(form).serialize();
                var url = form.getAttribute('action');


                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: formData,
                }).done(response => {
                    // success alert
                    UpdateApplicationSchoolPopup.getUpdatePopup().hide();
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // location.reload();
                            applicationSchoolPopup.getPopup().load();

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

                updateApplicationSchool = null;
            }

            return {
                init: () => {

                    form = document.querySelector('#{{ $updateApplicationSchool }}');
                    submitBtn = document.querySelector("#UpdateApplicationSchoolButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
