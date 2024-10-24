@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa thông tin User
@endsection

@section('content')
    <form id="UpdateUserForm">

        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17">
            <!--begin::Input group-->
            <input type="hidden" name="user_id" value="{{ $user->id }}" />

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
                                style="background-image: url('{{ file_exists(public_path("storage/users/{$user->id}/profile_picture.jpg")) ? asset("/storage/users/{$user->id}/profile_picture.jpg") : '/core/assets/media/avatars/blank.png' }}')">
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

            {{-- <!--begin::Input group-->
            <div class="row g-9 mb-7">
                <!--begin::Name-->
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label for="current_password" class="required fs-6 fw-semibold mb-2">Current Password</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="password" class="form-control @if ($errors->has('password')) is-invalid  @endif" id="current_password"
                        name="current_password" autocomplete="current-password" />
                    <!--end::Input-->
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
                </div>
                <!--end::Name-->
            </div>
            <!--end::Input group--> --}}

            <!--begin::Input group-->
            <div class="row g-9 mb-7">
                <!--begin::Name-->
                <div class="col-md-12 fv-row">
                    <!--begin::Label-->
                    <label class="fs-6 fw-semibold mb-2">Mật khẩu</label>
                    <!--end::Label-->
                    <!--begin::Input-->
                    <input type="password"
                        class="form-control @if ($errors->has('password')) is-invalid @endif"
                        id="password" name="password" autocomplete="new-password" />
                    <!--end::Input-->
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <!--end::Name-->
            </div>
            <!--end::Input group-->
            <!--end::Scroll-->

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

            @include('users._module_role_select')

            <div class="mb-7">
                <!--begin::Label-->
                <label class="form-label fw-semibold ">Chi nhánh:</label>
                <!--end::Label-->

                <select name="branch" class="form-select filter-select @if ($errors->has('branch')) is-invalid @endif" data-control="select2"
                    data-close-on-select="false" data-placeholder="Chọn lớp học" data-allow-clear="true"
                    >
                        <option {{ $user->account->branch == \App\Library\Branch::BRANCH_HN ? 'selected' : '' }} value="{{ \App\Library\Branch::BRANCH_HN }}">Hà Nội</option>
                        <option {{ $user->account->branch == \App\Library\Branch::BRANCH_SG ? 'selected' : '' }} value="{{ \App\Library\Branch::BRANCH_SG }}">Sài Gòn</option>
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
                        'is_not' => $user->account->id,
                    ]) }}"
                    class="form-control" data-dropdown-parent="#UpdateUserForm" data-control="select2"
                    data-placeholder="Chọn team leader"
                >
                    @if ($user->account->accountGroup && $user->account->accountGroup->manager)
                        <option value="{{ $user->account->accountGroup->manager_id }}">{{ $user->account->accountGroup->manager->name }}</option>
                    @else
                        <option value="">Chọn team leader</option>
                    @endif
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
                    class="form-control" data-dropdown-parent="#UpdateUserForm" data-control="select2"
                    data-placeholder="Chọn mentor"
                >
                    @if ($user->mentor)
                        <option value="{{ $user->mentor_id }}">{{ $user->mentor->name }}</option>
                    @else
                        <option value="">Chọn mentor</option>
                    @endif
                </select>
                <x-input-error :messages="$errors->get('mentor_id')" class="mt-2" />
            </div>
            <!--end::Input group-->

            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button id="UpdateUserSubmitButton" type="submit" class="btn btn-primary">
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
            UsersEdit.init();
            // ImageEdit.int();
        });

        //
        var UsersEdit = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                var userIdInput = form.querySelector('input[name="user_id"]');
                var userId = userIdInput.value;
                var data = $(form).serialize();

                //hieu ung
                addSubmitEffect();

                $.ajax({
                    url: '/users/' + userId,
                    method: 'PUT',
                    data: data,
                }).done(function(response) {
                    // hide popup
                    UpdateUserPopup.getPopup().hide();
                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // load lai list
                            UsersList.getList().load();
                        }
                    });
                }).fail(function(response) {
                    UpdateUserPopup.getPopup().setContent(response.responseText);

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
                    form = document.getElementById('UpdateUserForm');
                    btnSubmit = document.getElementById('UpdateUserSubmitButton');

                    // data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();

        //
        var ImageEdit = function() {
            var fileInputElements;

            var handleFileInputChange = () => {
                fileInputElements.forEach(function(fileInput) {
                    fileInput.addEventListener('change', function() {
                        handleFileUpload(this);
                    });
                });
            };

            var handleFileUpload = (input) => {
                var file = input.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var previewImage = input.closest('.image-input').querySelector('.image-input-wrapper');
                        previewImage.style.backgroundImage = 'url(' + e.target.result + ')';
                    };
                    reader.readAsDataURL(file);
                }
            };

            return {
                init: function() {
                    fileInputElements = document.querySelectorAll(".avatar");
                    handleFileInputChange();
                }
            };
        }();
    </script>
@endsection
