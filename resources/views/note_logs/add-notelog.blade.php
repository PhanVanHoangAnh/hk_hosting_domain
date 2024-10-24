@extends('layouts.main.popup')

@section('title')
    Thêm lịch sử ghi chú cho {{ $contact->name }}
@endsection

@php
    $CreateNoteLogForm = 'CreateNoteLogForm_' . uniqid();
@endphp

@section('content')
    <form id="{{ $CreateNoteLogForm }}" tabindex="-1" enctype="multipart/form-data">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7 py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
            <!--begin::Input group-->
            <input type="hidden" name="contact_request_id" value="{{ $contactRequest->id }}">
            <div class="row g-9 mb-5 d-none">
                <div class="fv-row mb-7">
                    <label class="required fs-6 fw-semibold">Tên</label>
                    <select id="CreateNoteSelect2" class="form-select" data-control="select2"
                        data-dropdown-parent="#{{ $CreateNoteLogForm }}" data-placeholder="Tìm khách hàng" name="contact_id"
                        style="margin-top: 0px; padding-top: 0px">
                        <option></option>
                        <option value="{{ $contact->id }}" selected>{{ $contact->name }}</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 fv-row pb-2">
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
            

            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button id="{{ $CreateNoteLogForm }}_SubmitButton" type="submit" class="btn btn-primary">
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

            const submit = () => {
                var formData = new FormData(form);
                addSubmitEffect();
                var contactId = "{{ $contact->id }}";

                $.ajax({
                    url: "{{ action([App\Http\Controllers\NoteLogController::class, 'doneAddNoteLogMarketingContactRequest'], [
                        'id' => $contact->id
                    ]) }}",
                    method: "POST",
                    data: formData,
                    processData: false,
                    contentType: false
                }).done(response => {
                    CreateNotePopup.getCreatePopup().hide();
                    removeSubmitEffect();
                    ASTool.alert({
                        message: response.message,
                        ok: () => {
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

                            if (typeof ContactRequestsList !== 'undefined') {
                                if (typeof ContactRequestsList != 'undefined')
                                    ContactRequestsList.getList().load();
                            }
                        }
                    });
                }).fail(response => {
                    CreateNotePopup.getCreatePopup().setContent(response.responseText);
                });
            };

            const addSubmitEffect = () => {
                submitDataBtn.setAttribute('data-kt-indicator', 'on');
                submitDataBtn.setAttribute('disabled', true);
            }

            const removeSubmitEffect = () => {
                submitDataBtn.removeAttribute('data-kt-indicator');
                submitDataBtn.removeAttribute('disabled');
            }

            return {
                init: () => {
                    form = document.querySelector('#{{ $CreateNoteLogForm }}');
                    submitDataBtn = document.querySelector("#{{ $CreateNoteLogForm }}_SubmitButton");
                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
