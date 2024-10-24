@extends('layouts.main.popup')

@section('title')
    Thêm lịch sử ghi chú cho {{ $contactRequest->contact->name }} sd
@endsection 

@section('content')

    <form id="CreateNoteLogForm" tabindex="-1" enctype="multipart/form-data">
        @csrf
        <!--begin::Scroll-->
        
        <div class="scroll-y pe-7  py-5 px-lg-17" id="kt_modal_add_note_log_scroll">
            <!--begin::Input group-->
            <input type="hidden" name="contact_id" value="{{$contactRequest->contact->id}}">
            <label class="fs-6 fw-semibold mb-2" for="reminder">Đặt lịch hẹn</label>    
            <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">       
                <input data-control="input" name="reminder"
                placeholder="=asas" type="datetime-local" class="form-control"
                value="{{ isset($contactRequest->reminder) ? $contactRequest->reminder : '' }}" />

                <span data-control="clear"
                    class="material-symbols-rounded clear-button"
                    style="display:none;">close</span>
            </div>
            <div class="form-group mb-5">
                
            </div>
            <div class="row g-9 mb-5 d-none">
                <div class="fv-row mb-7">
                    <label class="required fs-6 fw-semibold">Tên</label>
                    <select id="CreateNoteSelect2" class="form-select" data-control="select2"
                        data-dropdown-parent="#CreateNoteLogForm" data-placeholder="Tìm khách hàng" name="contact_request_id"
                        style="margin-top: 0px; padding-top: 0px">
                        <option></option>
                        <option value="{{ $contactRequest->id }}" selected>{{ $contactRequest->name }}</option>

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
                var contactId = "{{ $contactRequest->contact->id }}";

                var data = $(form).serialize();


                $.ajax({
                    url: "{{ action('\App\Http\Controllers\Sales\NoteLogController@storeNoteLog', ['id' => $contactRequest->id ]) }}",
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
                                if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
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
