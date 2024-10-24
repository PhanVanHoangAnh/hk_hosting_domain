@extends('layouts.main.popup')

@section('title')
    Thêm hồ sơ du học
@endsection
@php
    $formId = 'createStudyAbroadApplicationPopup_' . uniqid();
@endphp
@section('content')
    <form id="{{ $formId }}"
        action="{{ action(
            [App\Http\Controllers\Student\AbroadController::class, 'saveStudyAbroadApplication'],
            [
                'id' => $abroadApplication->id,
            ],
        ) }}">
            @csrf

        <!--begin::Scroll-->
        <div class="scroll-ype-7 py-10 px-lg-17"  data-kt-scroll-offset="300px">

            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <input type="hidden" name="abroad_application_id" value="{{ $abroadApplication->id }}"/>
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Tên</span>
                </label>
                <input class="form-control" name="name" placeholder="Nhập tên loại hồ sơ!" type="text">
                

                <div >
                    <label for="" class="required form-label">Chọn tập tin bài luận</label>
                    <input type="file" class="form-control test-input-file" name="path"  accept=".pdf, .docx, .doc, .txt"/>
                    <x-input-error :messages="$errors->get('file')" class="mt-2" />
                    <!--begin::Hint-->
                    <p class="form-text fs-6 small mt-2 mb-0">Dung lượng tối đa của tập tin là <strong>{{ ini_get('upload_max_filesize') }}</strong>.</p>
                    <!--end::Hint-->
                </div>
            </div>
            <!--end::Input group-->
            <div id="error-message-page" class="error-message text-danger" style="display: none;"></div>

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button data-action="save-create-btn" type="submit" class="btn btn-primary">
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
            Create.init();

          
        }) 

        var Create = function() {
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
                
                const input = $(form).find('input[type=file]')[0];
                const file = input.files[0]; 
                const csrfToken = '{{ csrf_token() }}';
                formData.append('_token', csrfToken);

                if (file) {
                    formData.append('path', file);
                }
                var url = form.getAttribute('action');
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(response => {
                    
                    // UpdatePopup.getUpdatePopup().hide();
                    
                    ASTool.alert({
                        message: response.message,
                        ok: () => {
                            CreatePopup.getPopup().hide();
                            UpdatePopup.getUpdatePopup().load();
                            studyAbroadApplicationManager.load();

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

            return {
                init: () => {

                    form = document.querySelector("#{{$formId}}");
                    submitBtn = document.querySelector('[data-action="save-create-btn"]');

                    handleFormSubmit();
                    
                }
            }
        }();
    </script>
@endsection
