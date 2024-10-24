@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa lịch sử tư vấn {{ $noteLog->id }}
@endsection

@section('content')
    <form id="UpdateNoteLogForm"
        action="{{ action(
            [App\Http\Controllers\Hk\SoftwareRequestNoteController::class, 'update'],
            [
                'id' => $noteLog->id,
            ],
        ) }}">
        @csrf
        <!--begin::Scroll-->

        <div class="scroll-y pe-7  py-5 px-lg-17" id="kt_modal_add_note_log_scroll">
            <!--begin::Input group-->
            <input type="hidden" name="note_id" value="{{ $noteLog->id }}">
            <label class="fs-6 fw-semibold mb-2" for="contact_time">Thời gian liên hệ tiếp</label>
            <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                <input data-control="input" name="contact_time" placeholder="=asas" type="datetime-local"
                    class="form-control" value="{{ isset($noteLog->contact_time) ? $noteLog->contact_time : '' }}" />

                <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
            </div>

            <div class="col-md-12 fv-row">

                <div class="row">
                    <div class="col-md-12">
                        <div>
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Nội dung trao đổi</label>
                            <!--end::Label-->
                            <!--begin::Textarea-->
                            <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="content" rows="5" cols="40">{{ $noteLog->content }}</textarea>
                            <!--end::Textarea-->
                            <x-input-error :messages="$errors->get('content')" class="mt-2" />
                        </div>
                    </div>
                </div>
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
                <button type="reset" id="kt_modal_add_note_log_cancel" class="btn btn-light me-3"
                    data-bs-dismiss="modal">Hủy</button>
                <!--end::Button-->
            </div>
    </form>
    <script>
        $(() => {
            UpdateNotLog.init();
        })

        var UpdateNotLog = function() {
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
                var url = form.getAttribute('action');
                var data = $(form).serialize();

                $.ajax({
                    // alert('2');
                    url: url,
                    method: 'POST',
                    data: data,
                }).done(response => {

                    UpdateNotelogPopup.getPopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: () => {
                            if (typeof SoftwareRequetList !== 'undefined') {
                                if (typeof SoftwareRequetList != 'undefined')
                                    SoftwareRequetList.getList().load();
                            }
                        }
                    });

                }).fail(message => {
                    UpdateNotelogPopup.getPopup().setContent(message.responseText);
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

                UpdateNotLog = null;
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
