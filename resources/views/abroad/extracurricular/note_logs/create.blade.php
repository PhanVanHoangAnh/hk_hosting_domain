@extends('layouts.main.popup')

@section('title')
    Thêm mới ghi chú
@endsection

@section('content')
    <form id="CreateNoteLogForm" tabindex="-1" method="post"
        action="{{ action([App\Http\Controllers\Abroad\NoteLogController::class, 'store']) }}">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
            <!--begin::Input group-->
            <div class="row g-9 mb-5">
                <div class="fv-row mb-7">
                    <label class="required fs-6 fw-semibold mb-2">Khách hàng/Liên hệ</label>
                    @include('helpers.contactSelector', [
                        'name' => 'contact_id',
                        'url' => action('App\Http\Controllers\Abroad\ContactController@select2'),
                        'controlParent' => '#CreateNoteLogForm',
                        'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
                        'value' => $notelog->contact_id ? $notelog->contact_id : null,
                        'text' => $notelog->contact_id ? $notelog->contact->getSelect2Text() : null,
                        'createUrl' => action('\App\Http\Controllers\Abroad\ContactController@create'),
                        'editUrl' => action('\App\Http\Controllers\Abroad\ContactController@edit', 'CONTACT_ID'),
                    ])
                    <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
                </div>
            </div>

            <div class="col-md-12 fv-row">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold mb-2">Nội dung hỗ trợ</label>
                <!--end::Label-->
                <!--begin::Textarea-->
                <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="content" rows="5" cols="40"></textarea>
                <!--end::Textarea-->
            </div>
            <x-input-error :messages="$errors->get('content')" class="mt-2" />

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

                var data = $(form).serialize();
                addSubmitEffect();

                $.ajax({
                    url: "{{ action([App\Http\Controllers\Abroad\NoteLogController::class, 'store']) }}",
                    method: 'POST',
                    data: data
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
