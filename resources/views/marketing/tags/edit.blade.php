@extends('layouts.main.popup')

@section('title')
    Chỉnh Sửa Tag
@endsection

@section('content')
    <form id="UpdateTagForm">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" >
            <!--begin::Input group-->
            <input type="hidden" name="tag_id" value="{{ $tag->id }}"/>

            <div class="row g-9 mb-7">
                <!--begin::Col-->
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Tên</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text"
                        class="form-control @if ($errors->has('name')) is-invalid @endif"
                        placeholder="" name="name" value="{{ $tag->name }}" />
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!--end::Col-->
            </div>
            <!--end::Scroll-->

            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button id="UpdateTagSubmitButton" type="submit" class="btn btn-primary">
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
        </div>
    </form>

    <script>
        $(function() {
            TagsEdit.init();
        });

        //
        var TagsEdit = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                var tagIdInput = form.querySelector('input[name="tag_id"]');
                var tagId = tagIdInput.value;
                var data = $(form).serialize();

                //hieu ung
                addSubmitEffect();

                $.ajax({
                    url: '/marketing/tags/'+ tagId,
                    method: 'PUT',
                    data: data,
                }).done(function(response) {
                    // hide popup
                    UpdateTagPopup.getPopup().hide();
                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // load lai list
                            TagsList.getList().load();
                        }
                    });
                }).fail(function(response) {
                    UpdateTagPopup.getPopup().setContent(response.responseText);

                    // remove hieu ung
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
                    form = document.getElementById('UpdateTagForm');
                    btnSubmit = document.getElementById('UpdateTagSubmitButton');

                    // data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
