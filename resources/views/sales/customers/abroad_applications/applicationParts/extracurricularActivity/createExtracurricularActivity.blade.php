@extends('layouts.main.popup')

@section('title')
    Thêm mới hoạt động ngoại khoá
@endsection
@php
    $createExtracurricularActivity = 'createExtracurricularActivity_' . uniqid();
@endphp
@section('content')
    <form id="{{ $createExtracurricularActivity }}"
        action="{{ action(
            [App\Http\Controllers\Sales\AbroadController::class, 'doneCreateExtracurricularActivity'],
            [
                'id' => $id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y
        pe-7 py-10 px-lg-17" >

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
                            @foreach (\App\Models\ExtracurricularActivity::getAllCategory() as $category)
                                <option  value="{{ $category }}">{{ trans('messages.extracurricular_activity.category.' . $category) }}</option>
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
                            @foreach (\App\Models\ExtracurricularActivity::getAllRole() as $role)
                                <option  value="{{ $role }}">{{ trans('messages.extracurricular_activity.role.' . $role) }}</option>
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
                        <input class="form-control" name="name" placeholder="Nhập tên hoạt động ngoại khoá!" type="text">
                        <!--end::Input-->
                    </div>
                </div>
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 mt-4">
                    <span class="">Địa điểm</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="address" placeholder="Nhập địa điểm ngoại khoá!" rows="1" cols="40"></textarea>
                <!--end::Input-->
                <div class="row">
                    <div class="col-md-6">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 mt-4">
                            <span class="">Thời điểm bắt đầu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" value="{{ date('Y-m-d') }}" name="start_at" id="start_at"
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
                            <input data-control="input" value="{{ date('Y-m-d') }}" name="end_at" id="end_at"
                                placeholder="=asas" type="date" class="form-control">
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                        <!--end::Input-->
                    </div>
                </div>
               

                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2 mt-4">
                    <span class="">Link tài liệu chương trình</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="link_document" placeholder="Nhập link tài liệu chương trình!" rows="1" cols="40"></textarea>
                <!--end::Input-->
                <label class="fs-6 fw-semibold mb-2 mt-4">
                    <span class="">Link file</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="link_file" placeholder="Nhập link file!" rows="1" cols="40"></textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('link')" class="mt-2" />
            </div>
            <!--end::Input group-->
            <div id="error-message-name" class="error-message text-danger" style="display: none;"></div>

        </div>
        <!--end::Scroll-->
        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateExtracurricularActivityButton" type="submit" class="btn btn-primary">
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
            createExtracurricularActivity.init();
        })

        var createExtracurricularActivity = function() {
            let form;
            let submitBtn;

            function hasInputName() {
                const inputPage = document.querySelector('[name="name"]').value;

                return inputPage == '';
            }

            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    submit();
                })
            }

            submit = () => {
                const formData = $(form).serialize();
                var url = form.getAttribute('action');
                if (hasInputName()) {
                    const errorContainer = document.getElementById('error-message-name');

                    errorContainer.textContent = 'Vui lòng điền tên ngoại khoá!';
                    errorContainer.style.display = 'block';
                    
                    return;
                }

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
                            extracurricularActivityPopup.getPopup().load();
                        }
                    });

                }).fail(message => {
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

                createExtracurricularActivity = null;
            }

            return {
                init: () => {
                    form = document.querySelector('#{{ $createExtracurricularActivity }}');
                    submitBtn = document.querySelector("#CreateExtracurricularActivityButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
