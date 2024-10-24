@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa kế hoạch ngoại khoá
@endsection
@php
    $updateExtracurricularSchedule = 'updateExtracurricularSchedule_' . uniqid();
@endphp
@section('content')
    <form id="{{ $updateExtracurricularSchedule }}"
        action="{{ action(
            [App\Http\Controllers\Abroad\AbroadController::class, 'doneUpdateExtracurricularSchedule'],
            [
                'id' => $extracurricularSchedule->id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y
        pe-7 py-10 px-lg-17" >
            <!--begin::Input group-->
            <input type="hidden" name="extracurricularScheduleId" value="{{ $extracurricularSchedule->id }}" />
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <div class="row">
                    <div class="col-md-3">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Hạng mục</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select list-action="abroad_status" name="category" class="form-select filter-select "  data-control="select2"
                            data-close-on-select="false" data-placeholder="Chọn nhóm trường" data-allow-clear="true" >
                            <option value="" selected disabled hidden></option>
                            @foreach (\App\Models\ExtracurricularSchedule::getAllCategory() as $category)
                                <option  value="{{ $category }}" {{ isset($extracurricularSchedule) && $extracurricularSchedule->category == $category? 'selected' : '' }}>{{ trans('messages.extracurricular_schedule.category.' . $category) }}</option>
                            @endforeach

                        </select>
                        <!--end::Input-->
                    </div>
                    <div class="col-md-3">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Vai trò</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select list-action="abroad_status" name="role" class="form-select filter-select "  data-control="select2"
                            data-close-on-select="false" data-placeholder="Chọn vai trò" data-allow-clear="true" >
                            <option value="" selected disabled hidden></option>
                            @foreach (\App\Models\ExtracurricularSchedule::getAllRole() as $role)
                                <option  value="{{ $role }}" {{ isset($extracurricularSchedule) && $extracurricularSchedule->role == $role? 'selected' : '' }} >{{ trans('messages.extracurricular_schedule.role.' . $role) }}</option>
                            @endforeach

                        </select>
                        <!--end::Input-->
                    </div>
                    <div class="col-md-6">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Tên hoạt động ngoại khoá</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <select list-action="abroad_status" name="extracurricularId" class="form-select filter-select" data-control="select2"
                            data-close-on-select="false" data-placeholder="Chọn kế hoạch ngoại khoá" data-allow-clear="true" >
                            <option value="" selected disabled hidden></option>
                            @foreach(\App\Models\Extracurricular::all()  as $extracurricular)
                                <option  value="{{ $extracurricular->id}}" {{ isset($extracurricularSchedule) && $extracurricularSchedule->extracurricular_id == $extracurricular->id? 'selected' : '' }}>{{ $extracurricular->name }}</option>
                               
                            @endforeach
                        </select>
                        <!--end::Input-->
                    </div>
                </div> 
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 mt-4 d-none">
                    <span class="">Địa điểm</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input class="form-control d-none" name="address" value="{{$extracurricularSchedule->address}}" placeholder="Nhập địa điểm ngoại khoá!" type="text">
                <!--end::Input-->
                <div class="row d-none">
                    <div class="col-md-6">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                            <span class="">Thời điểm bắt đầu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" value="{{ $extracurricularSchedule->start_at }}" name="start_at" id="start_at"
                                placeholder="=asas" type="date" class="form-control">
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                        <!--end::Input-->
                    </div>
                    <div class="col-md-6">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                            <span class="">Thời điểm kết thúc</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" value="{{ $extracurricularSchedule->end_at }}" name="end_at" id="end_at"
                                placeholder="=asas" type="date" class="form-control">
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>
               

                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 mt-4 d-none">
                    <span class="">Link tài liệu chương trình</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input class="form-control d-none" name="link" value="{{$extracurricularSchedule->link}}" placeholder="Nhập link tài liệu!" type="text">
                <!--end::Input-->

                <x-input-error :messages="$errors->get('link')" class="mt-2" />
            </div>
            <!--end::Input group-->
            <div id="error-message-name" class="error-message text-danger" style="display: none;"></div>
        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="UpdateExtracurricularScheduleButton" type="submit" class="btn btn-primary">
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
            updateExtracurricularSchedule.init();
        })

        var updateExtracurricularSchedule = function() {
            let form;
            let submitBtn;

            function hasInputName() {
                const inputPage = document.querySelector('[name="extracurricularId"]').value;
                
                return inputPage !== null ? true : false;
            }

            const handleFormSubmit = () => {

                form.addEventListener('submit', e => {

                    e.preventDefault();

                    submit();
                })
            }

            submit = () => {

                const extracurricularScheduleId = document.querySelector('input[name="extracurricularScheduleId"]')
                    .value;
                const formData = $(form).serialize();
                var url = form.getAttribute('action');
                // if (hasInputName()) {
                //     const errorContainer = document.getElementById('error-message-name');
                //     errorContainer.textContent =
                //         'Vui lòng điền tên ngoại khoá!';
                //     errorContainer.style.display = 'block';
                //     return;
                // }
                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: formData,
                }).done(response => {

                    CreateSocialNetworkPopup.getUpdatePopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // location.reload();
                            extracurricularSchedulePopup.getPopup().load();
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

                updateExtracurricularSchedule = null;
            }

            return {
                init: () => {
                    form = document.querySelector('#{{ $updateExtracurricularSchedule }}');
                    submitBtn = document.querySelector("#UpdateExtracurricularScheduleButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
