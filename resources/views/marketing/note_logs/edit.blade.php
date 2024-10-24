@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa thông tin ghi chú
@endsection

@section('content')
    <form id="UpdateNoteLogForm" enctype="multipart/form-data">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-5 px-lg-17" >
            <!--begin::Input group-->
            <input type="hidden" name="note_id" value="{{ $noteLog->id }}" />
            <!--end::Input group-->
            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <div class="row">
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
            </div>
            <!--end::Input group-->

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="UpdateNoteLogSubmitButton" type="submit" class="btn btn-primary">
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
            updateNotLog.init();
        })

        var updateNotLog = function() {
            let form;
            let submitBtn;

            const handleFormSubmit = () => {

                form.addEventListener('submit', e => {

                    e.preventDefault();

                    submit();
                })
            }

            submit = () => {

                const noteId = document.querySelector('input[name="note_id"]').value;
                var formData = new FormData(form);

                $.ajax({
                    url: `/marketing/note-logs/${noteId}`,
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false
                }).done(response => {

                    UpdateNotelogPopup.getUpdatePopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {

                            //load contact list
                            if (typeof ContactsList !== 'undefined') {
                                ContactsList.getList().load();
                            }

                            //load contact Note logs popup
                            if (typeof NodeLogsContactPopup !== 'undefined') {
                                NodeLogsContactPopup.getPopup().load();
                            }
                            // reload list
                            if (typeof NoteList !== 'undefined') {
                                NoteList.getList().load();
                            }

                            if (typeof CustomersList !== 'undefined') {
                                CustomersList.getList().load();
                            }

                            if (typeof NodeLogsCustomerPopup !== 'undefined') {
                                NodeLogsCustomerPopup.getPopup().load();
                            }
                            // NoteList.getList().load();



                        }
                    });

                }).fail(message => {
                    UpdateNotelogPopup.getUpdatePopup().setContent(message.responseText);
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

                updateNotLog = null;
            }

            return {
                init: () => {

                    form = document.querySelector("#UpdateNoteLogForm");
                    submitBtn = document.querySelector("#UpdateNoteLogSubmitButton");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
