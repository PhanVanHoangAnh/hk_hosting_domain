@extends('layouts.main.popup')

@section('title')
    Tài khoản Liên hệ/Khách hàng
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp
    <form id="ContactAccountForm_{{ $formId }}" action="{{ action([App\Http\Controllers\ContactController::class, 'account'], [
        'id' => $contact->id,
    ]) }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17">
            <!--begin::Input group-->
            <div class="row g-9 mb-7">
                <!--begin::Name-->
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Tên</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text"
                        class="form-control @if ($errors->has('name')) is-invalid @endif"
                        id="name" name="name" value="{{ $user->name }}" />
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <!--end::Name-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row g-9 mb-7">
                <!--begin::Name-->
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Email</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="text"
                        class="form-control @if ($errors->has('email')) is-invalid @endif"
                        id="email" name="email" value="{{ $user->email }}" required />
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <!--end::Name-->
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="row g-9 mb-7">
                <!--begin::Name-->
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="{{ $user->id ? '' : 'required' }} fs-6 fw-semibold mb-2">Mật Khẩu</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="password"
                        class="form-control @if ($errors->has('password')) is-invalid @endif"
                        id="password" name="password" {{ $user->id ? '' : 'required' }} autocomplete="new-password" />
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!--end::Name-->
            </div>
            <!--end::Input group-->

            <!--begin::Checkbox-->
            <div class="mb-10">
                <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                    <input class="form-check-input" {{ $user->change_password_required ? 'checked' : '' }} type="checkbox" value="yes" name="change_password_required" >

                    <span class="form-check-label">
                        Yêu cầu người dùng đổi mật khầu trong lần đăng nhập kế tiếp
                    </span>
                </label>
            </div>
            <!--end::Checkbox-->
        </div>
        <!--end::Scroll-->

        

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="ContactAccountForm_{{ $formId }}_Submit" type="submit" class="btn btn-primary">
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
        $(function() {
            UsersCreate.init();
        });

        var UsersCreate = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            //Pthuc xử lý việc gửi biểu mẫu lên máy chủ thông qua AJAX
            submit = () => {
                // Lấy dữ liệu từ biểu mẫu.
                // var data = $(form).serialize();
                var formData = new FormData($(form)[0]);
                var url = $(form).attr('action');

                // Thêm hiệu ứng
                addSubmitEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    // data: data,
                    data: formData,
                    processData: false, // Không xử lý dữ liệu gửi đi
                    contentType: false, // Không đặt kiểu dữ liệu gửi đi
                }).done(function(response) {
                    // hide popup
                    window.contactAccount.popup.hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            UsersList.getList().load();
                        }
                    });
                    // Userslist.getList().load();
                }).fail(function(response) {
                    window.contactAccount.popup.setContent(response.responseText);

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
                    form = document.getElementById('ContactAccountForm_{{ $formId }}');
                    btnSubmit = document.getElementById('ContactAccountForm_{{ $formId }}_Submit');

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
