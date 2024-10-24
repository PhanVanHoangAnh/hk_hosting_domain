@extends('layouts.main.popup')

@section('title')
    Thêm lịch sử ghi chú cho {{ $contact->name }}
@endsection

@section('content')
    <form id="CreateNoteLogForm" tabindex="-1">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-5 px-lg-17" id="kt_modal_add_note_log_scroll">
            <!--begin::Input group-->

            <div class="row g-9 mb-5 d-none">
                <div class="fv-row mb-7">
                    <label class="required fs-6 fw-semibold">Tên</label>
                    <select id="CreateNoteSelect2" class="form-select" data-control="select2"
                        data-dropdown-parent="#CreateNoteLogForm" data-placeholder="Tìm khách hàng" name="contact_id"
                        style="margin-top: 0px; padding-top: 0px">
                        <option></option>
                        <option value="{{ $contact->id }}" selected>{{ $contact->name }}</option>

                    </select>

                </div>
            </div>
            <div class="col-md-12 fv-row">
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
        $(function() {
            //
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
                var contactId = "{{ $contact->id }}";

                var data = $(form).serialize();


                $.ajax({
                    url: "{{ action('\App\Http\Controllers\Marketing\NoteLogController@storeNoteLog', ['id' => 'contactId']) }}",
                    method: "POST",
                    data: data
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
                            // NoteList.getList().load();


                        }
                    });
                }).fail(response => {
                    CreateNotePopup.getCreatePopup().setContent(response.responseText);

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
