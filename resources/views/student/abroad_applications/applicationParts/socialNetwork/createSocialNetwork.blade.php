@extends('layouts.main.popup')

@section('title')
    Thêm mới mạng xã hội
@endsection
@php
    $createSocialNetwork = 'createSocialNetwork_' . uniqid();
@endphp
@section('content')
    <form id="{{ $createSocialNetwork }}"
        action="{{ action(
            [App\Http\Controllers\Student\AbroadController::class, 'doneCreateSocialNetwork'],
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
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Trang mạng xã hội</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input class="form-control" name="page" placeholder="Nhập tên trang mạng xã hội!" type="text">
                <!--end::Input-->
                <!--begin::Label-->
                <label class="mt-3 fs-6 fw-semibold mb-2">
                    <span class="">Link</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="link" placeholder="Nhập nội dung link!" rows="5" cols="40"></textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('link')" class="mt-2" />
            </div>
            <!--end::Input group-->
            <div id="error-message-page" class="error-message text-danger" style="display: none;"></div>

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateSocialNetworkButton" type="submit" class="btn btn-primary">
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
            createSocialNetwork.init();
        })

        var createSocialNetwork = function() {
            let form;
            let submitBtn;

            function hasInputPage() {
                const inputPage = document.querySelector('[name="page"]').value;

                return inputPage == '';
            }
            const handleFormSubmit = () => {

                form.addEventListener('submit', e => {

                    e.preventDefault();

                    submit();
                })
            }

            submit = () => {
                if (hasInputPage()) {
                    const errorContainer = document.getElementById('error-message-page');
                    errorContainer.textContent =
                        'Vui lòng điền tên chứng chỉ cần có!';
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

                    CreateSocialNetworkPopup.getUpdatePopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // location.reload();
                            socialNetworkPopup.getPopup().load();
                            networkSocialManager.load();
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

                createSocialNetwork = null;
            }

            return {
                init: () => {

                    form = document.querySelector('#{{ $createSocialNetwork }}');
                    submitBtn = document.querySelector("#CreateSocialNetworkButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
