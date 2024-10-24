@extends('layouts.main.popup')

@section('title')
    Them tags vao khach hang da chon
@endsection

@section('content')
    <form id="AddTagsForm">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_contact_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_modal_add_contact_header"
            data-kt-scroll-wrappers="#kt_modal_add_contact_scroll" data-kt-scroll-offset="300px">
            <!--begin::Input group-->
            <!--end::Input group-->
            <div class="fv-row ">
                <label class="fs-6 fw-semibold mb-2">Chọn tag</label>
                <div>
                    <select class="form-select" data-control="select2" data-placeholder="Select an option"
                        multiple="multiple" name="tags[]">
                        {{-- <option></option> --}}
                        @foreach ($tags as $tag)
                            <option value="{{ $tag->id }}" id="tag_{{ $tag->id }}" for="tag_{{ $tag->id }}">
                                {{ $tag->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>



        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="AddTagsSubmitButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
        $(function() {
            TagsUpdate.init();
        });

        var TagsUpdate = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                var contactRequestIdInput = form.querySelector('input[name="contact_request_id"]');
                var contactRequestId = contactRequestIdInput.value;
                var data = $(form).serialize();
                addSubmitEffect();

                $.ajax({
                    url: '/sales/contact_requests/' + contactRequestId,
                    method: 'PUT',
                    data: data,

                }).done(function(response) {
                    // hide popup
                    UpdateTagsPopup.getPopup().hide();
                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload listss
                            if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                        }
                    });
                    // UpdateTagsPopup.getPopup().show();
                }).fail(function(response) {
                    UpdateTagsPopup.getPopup().setContent(response.responseText);

                    // 
                    removeSubmitEffect();
                });
            }

            addSubmitEffect = () => {
                // btn effect
                btnSubmit.setAttribute('data-kt-indicator', 'on');
                btnSubmit.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {
                // btn effect
                btnSubmit.removeAttribute('data-kt-indicator');
                btnSubmit.removeAttribute('disabled');
            }

            return {
                init: function() {
                    form = document.getElementById('UpdateTagsForm');
                    btnSubmit = document.getElementById('UpdateTagsSubmitButton');

                    //data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
