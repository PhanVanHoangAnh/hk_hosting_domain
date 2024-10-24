@extends('layouts.main.popup')

@section('title')
    Thêm lịch sử tư vấn cho {{ $softwareRequest->contact->name }}
@endsection

@section('content')
    <form id="CreateNoteLogForm" tabindex="-1" method="post" enctype="multipart/form-data">
        @csrf
        <!--begin::Scroll-->

        <div class="scroll-y pe-7  py-5 px-lg-17" id="kt_modal_add_note_log_scroll">
            <!--begin::Input group-->
            <input type="hidden" name="software_request_id" value="{{ $softwareRequest->id }}">
            <label class="fs-6 fw-semibold mb-2" for="contact_time">Thời gian liên hệ tiếp</label>
            <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                <input data-control="input" name="contact_time" placeholder="=asas" type="datetime-local"
                    class="form-control"
                    value="{{ isset($softwareRequest->contact_time) ? $softwareRequest->contact_time : '' }}" />

                <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
            </div>
            <div class="form-group mb-5">
            </div>
            <div class="row g-9 mb-5 d-none">
                <div class="fv-row mb-7">
                    <label class="required fs-6 fw-semibold">Tên</label>
                    <select id="CreateNoteSelect2" class="form-select" data-control="select2"
                        data-dropdown-parent="#CreateNoteLogForm" data-placeholder="Tìm khách hàng" name="contact_id"
                        style="margin-top: 0px; padding-top: 0px">
                        <option></option>
                        <option value="{{ $softwareRequest->contact->id }}" selected>{{ $softwareRequest->contact->name }}
                        </option>

                    </select>

                </div>
            </div>
            <div class="col-md-12 fv-row">

                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Nội dung trao đổi</label>
                            <!--end::Label-->
                            <!--begin::Textarea-->
                            <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="content" rows="5" cols="40"></textarea>
                            <!--end::Textarea-->
                            {{-- <x-input-error :messages="$errors->get('content')" class="mt-2" /> --}}
                        </div>
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
                var contactId = "{{ $softwareRequest->contact->id }}";

                var data = $(form).serialize();

                $.ajax({
                    url: "{{ action('App\Http\Controllers\Hk\SoftwareRequestNoteController@store', ['id' => $softwareRequest->id]) }}",
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
                            if (typeof SoftwareRequetList !== 'undefined') {
                                if (typeof SoftwareRequetList != 'undefined')
                                    SoftwareRequetList.getList().load();
                            }
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
