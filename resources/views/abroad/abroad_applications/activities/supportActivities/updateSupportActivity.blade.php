@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa thông tin hoạt động hỗ trợ
@endsection

@php
    $formId = 'F_' . uniqid();
@endphp

@section('content')
    <form id="{{$formId}}"
        action="{{ action(
            [App\Http\Controllers\Abroad\AbroadController::class, 'doneUpdateSupportActivity'],
            [
                'id' => $supportActivity->id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y pe-7 py-10 px-lg-17" >
            <!--begin::Input group-->
            <input type="hidden" name="supportActivityId" value="{{ $supportActivity->id }}" />
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Người đưa đón sân bay</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="airport_pickup_person" placeholder="Nhập tên người đưa đón sân bay!" rows="1" cols="40">{{$supportActivity->airport_pickup_person}}</textarea>

                <label class="mt-3 fs-6 fw-semibold mb-2">
                    <span class="">Người giám hộ</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="guardian_person" placeholder="Nhập tên người giám hộ!" rows="1" cols="40">{{$supportActivity->guardian_person}}</textarea>

                <label class="mt-3 fs-6 fw-semibold mb-2">
                    <span class="">Địa chỉ nhà ở</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="address" placeholder="Nhập địa chỉ nhà ở!" rows="1" cols="40">{{$supportActivity->address}}</textarea>
            </div>
            <!--end::Input group-->

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="updateSupportActivityButton" type="submit" class="btn btn-primary">
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
            updateSupportActivity.init();
        })

        var updateSupportActivity = function() {
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
                            supportActivities.load();
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
                    submitBtn = document.querySelector("#updateSupportActivityButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
