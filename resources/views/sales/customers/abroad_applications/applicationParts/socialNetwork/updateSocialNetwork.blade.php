@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa thông tin mạng xã hội
@endsection
@php
    $updateSocialNetwork = 'updateSocialNetwork_' . uniqid();
@endphp
@section('content')
    <form id="{{ $updateSocialNetwork }}"
        action="{{ action(
            [App\Http\Controllers\Sales\AbroadController::class, 'doneUpdateSocialNetwork'],
            [
                'id' => $socialNetwork->id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y
        pe-7 py-10 px-lg-17" >
            <!--begin::Input group-->
            <input type="hidden" name="socialNetworkId" value="{{ $socialNetwork->id }}" />
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Link</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="link" placeholder="Nhập nội dung ghi chú mới!" rows="5" cols="40">{!! $socialNetwork->link !!}</textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('link')" class="mt-2" />
            </div>
            <!--end::Input group-->

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="UpdateSocialNetworkButton" type="submit" class="btn btn-primary">
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
            updateSocialNetwork.init();
        })

        var updateSocialNetwork = function() {
            let form;
            let submitBtn;

            const handleFormSubmit = () => {

                form.addEventListener('submit', e => {

                    e.preventDefault();

                    submit();
                })
            }

            submit = () => {

                const socialNetworkId = document.querySelector('input[name="socialNetworkId"]').value;
                const formData = $(form).serialize();
                var url = form.getAttribute('action');


                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: formData,
                }).done(response => {

                    UpdateSocialNetworkPopup.getUpdatePopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            socialNetworkPopup.getPopup().load();
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

                updateSocialNetwork = null;
            }

            return {
                init: () => {
                    form = document.querySelector('#{{ $updateSocialNetwork }}');
                    submitBtn = document.querySelector("#UpdateSocialNetworkButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
