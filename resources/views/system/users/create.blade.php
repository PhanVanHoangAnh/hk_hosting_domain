@extends('layouts.main.popup')

@section('title')
    Thêm Người Dùng
@endsection

@section('content')
    <form id="CreateUserForm" action="{{ action([App\Http\Controllers\System\UserController::class, 'store']) }}" method="post"
        enctype="multipart/form-data">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17">
            <!--begin::Input group-->
            <div class="row g-9 mb-7">
                <!--begin::Hinh-->
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="required fs-6 fw-semibold mb-2">Ảnh</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-8">
                        <!--begin::Image input-->
                        <div class="image-input image-input-outline" data-kt-image-input="true"
                            style="background-image: url('/core/assets/media/avatars/blank.png')">
                            <!--begin::Preview existing avatar-->
                            <div class="image-input-wrapper w-125px h-125px"
                                style="background-image: url('/core/assets/media/avatars/blank.png')">
                            </div>
                            <!--end::Preview existing avatar-->
                            <!--begin::Label-->
                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                <i class="ki-duotone ki-pencil fs-7">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                                <!--begin::Inputs-->
                                <input type="file" name="file" accept=".png, .jpg, .jpeg" id="upload"
                                    class="avatar" />
                                <input type="hidden" name="avatar_remove" />
                                <!--end::Inputs-->
                            </label>
                            <!--end::Label-->
                            <!--begin::Cancel-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <!--end::Cancel-->
                            <!--begin::Remove-->
                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                <i class="ki-duotone ki-cross fs-2">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </span>
                            <!--end::Remove-->
                        </div>
                        <!--end::Image input-->
                        <!--begin::Hint-->
                        <div class="form-text">Allowed file types: png, jpg, jpeg.
                        </div>
                        <!--end::Hint-->
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Hinh-->
            </div>
            <!--end::Input group-->

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
                        id="email" name="email" value="{{ $user->email }}" />
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
                    <label class="required fs-6 fw-semibold mb-2">Mật Khẩu</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="password"
                        class="form-control @if ($errors->has('password')) is-invalid @endif"
                        id="password" name="password" required autocomplete="new-password" />
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

            @include('system.users._module_role_select')

            <div class="mb-7">
                <!--begin::Label-->
                <label class="form-label fw-semibold ">Chi nhánh:</label>
                <!--end::Label-->

                <select name="branch" class="form-select filter-select @if ($errors->has('branch')) is-invalid @endif" data-control="select2"
                    data-close-on-select="false" data-placeholder="Chọn lớp học" data-allow-clear="true"
                    >
                        <option value="{{ \App\Library\Branch::BRANCH_HN }}">Hà Nội</option>
                        <option value="{{ \App\Library\Branch::BRANCH_SG }}">Sài Gòn</option>
                </select>

                 <!--end::Input-->
                 <x-input-error :messages="$errors->get('branch')" class="mt-2" />
            </div>

            <!--begin::Input group-->
            <div class="mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Chọn team leader</label>
                <!--end::Label-->
                <select name="team_leader_id" data-control="select2-ajax" list-action="sales-select"
                    data-url="{{ action('App\Http\Controllers\AccountController@select2', [
                        'filter' => 'team_leader',
                    ]) }}"
                    class="form-control" data-dropdown-parent="#CreateUserForm" data-control="select2"
                    data-placeholder="Chọn team leader"
                >
                    <option value="">Chọn team leader</option>
                </select>
                <x-input-error :messages="$errors->get('team_leader_id')" class="mt-2" />
            </div>
            <!--end::Input group-->

            <!--begin::Input group-->
            <div class="mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">Chọn mentor</label>
                <!--end::Label-->
                <select name="mentor_id" data-control="select2-ajax" list-action="sales-select"
                    data-url="{{ action('App\Http\Controllers\AccountController@select2', [
                        'filter' => 'mentor',
                    ]) }}"
                    class="form-control" data-dropdown-parent="#CreateUserForm" data-control="select2"
                    data-placeholder="Chọn mentor"
                >
                    <option value="">Chọn mentor</option>
                </select>
                <x-input-error :messages="$errors->get('mentor_id')" class="mt-2" />
            </div>
            <!--end::Input group-->

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateUserSubmitButton" type="submit" class="btn btn-primary">
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
            UploadImage.init();
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
                
                // Lấy dữ liệu từ tệp hình ảnh đã chọn
                var fileData = $('#upload')[0].files[0]; // Thay #upload bằng id của input file hình ảnh
                
                // Thêm hình ảnh đã chọn vào dữ liệu biểu mẫu
                // data.append("file", fileData);
                formData.append("file", fileData);

                // Thêm hiệu ứng
                addSubmitEffect();

                $.ajax({
                    url: '',
                    method: 'POST',
                    // data: data,
                    data: formData,
                    processData: false, // Không xử lý dữ liệu gửi đi
                    contentType: false, // Không đặt kiểu dữ liệu gửi đi
                }).done(function(response) {
                    // hide popup
                    CreateUserPopup.getPopup().hide();
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
                    CreateUserPopup.getPopup().setContent(response.responseText);

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
                    form = document.getElementById('CreateUserForm');
                    btnSubmit = document.getElementById('CreateUserSubmitButton');

                    handleFormSubmit();
                }
            }
        }();

        var UploadImage = function() {
            var fileInputElements;
            var fileData;

            return {
                init: () => {
                    fileInputElements = document.querySelectorAll(".avatar");

                    fileInputElements.forEach(function(fileInput) {
                        fileInput.addEventListener("change", function(event) {
                            // Lấy dữ liệu hình ảnh được chọn
                            fileData = event.target.files[0];
                            // Hiển thị hình ảnh đã chọn (nếu muốn)
                            // Ví dụ: Hiển thị hình ảnh trong một div
                            var imagePreview = document.querySelector(".image-input-wrapper");
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                imagePreview.style.backgroundImage = 'url(' + e.target.result +
                                    ')';
                            };
                            reader.readAsDataURL(fileData);
                        });
                    });
                }
            };
        }();
    </script>
@endsection
