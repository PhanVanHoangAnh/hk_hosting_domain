@extends('layouts.main.popup')

@section('title')
    Thêm mới ghi chú
@endsection

@section('content')
    <form id="CreateNoteLogForm" tabindex="-1" method="post"
        action="{{ action([App\Http\Controllers\Sales\NoteLogController::class, 'store']) }}" enctype="multipart/form-data">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17 pb-20" id="kt_modal_add_note_log_scroll">
            <!--begin::Input group-->
            <div class="mb-7">
                <div class="">
                    <label class="required fs-6 fw-semibold mb-2">Khách hàng/Liên hệ</label>
                    @include('helpers.contactSelector', [
                        'name' => 'contact_id',
                        'url' => action('App\Http\Controllers\Sales\ContactController@select2'),
                        'controlParent' => '#CreateNoteLogForm',
                        'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
                        'value' => $noteLog->contact_id ? $noteLog->contact_id : null,
                        'text' => $noteLog->contact_id ? $noteLog->contact->getSelect2Text() : null,
                        'createUrl' => action('\App\Http\Controllers\Sales\ContactController@create'),
                        'editUrl' => action('\App\Http\Controllers\Sales\ContactController@edit', 'CONTACT_ID'),
                    ])
                    <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
                </div>
            </div>

            <div class="row mb-7">
                <div class="col-md-10">
                    <div>
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Nội dung hỗ trợ</label>
                        <!--end::Label-->
                        <!--begin::Textarea-->
                        <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="content" rows="5" cols="40">{{ $noteLog->content }}</textarea>
                        <!--end::Textarea-->
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>
                </div>
                <div class="col-md-2">
                    @include('note_logs._form_image')
                </div>
            </div>

            <!--end::Scroll-->

            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button id="CreateNoteLogSubmitButton" type="submit" class="btn btn-primary">
                    <span class="indicator-label">Lưu</span>
                    <span class="indicator-progress">Đang xử lý...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="reset" id="kt_modal_add_note_log_cancel" class="btn btn-light me-3"
                    data-bs-dismiss="modal">Hủy</button>
                <!--end::Button-->
            </div>
    </form>
    <script>
        $(() => {
            CreateNoteLog.init();
        });

        var CreateNoteLog = function() {
            let form;
            let submitDataBtn;

            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    submit();
                });
            };

            submit = () => {

                var formData = new FormData(form);
                addSubmitEffect();

                $.ajax({
                    url: "{{ action([App\Http\Controllers\Sales\NoteLogController::class, 'store']) }}",
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false
                }).done(response => {
                    CreateNotePopup.getCreatePopup().hide();

                    ASTool.alert({
                        message: response.message,
                        ok: () => {
                            NoteList.getList().load();
                        }
                    });
                }).fail(response => {
                    CreateNotePopup.getCreatePopup().setContent(response.responseText);
                    removeSubmitEffect();
                });
            };

            addSubmitEffect = () => {
                submitDataBtn.setAttribute('data-kt-indicator', 'on');
                submitDataBtn.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {
                submitDataBtn.removeAttribute('data-kt-indicator');
                submitDataBtn.removeAttribute('disabled');
            }

            return {
                init: () => {
                    form = document.querySelector("#CreateNoteLogForm");
                    submitDataBtn = document.querySelector("#CreateNoteLogSubmitButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
