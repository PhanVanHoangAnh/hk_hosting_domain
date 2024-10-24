@extends('layouts.main.popup')

@section('title')
    Thêm Role
@endsection

@section('content')
    <form id="CreateRoleForm" action="{{ action([App\Http\Controllers\System\RoleController::class, 'store']) }}" method="post">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" >
            <!--begin::Input group-->
            <div class="fv-row mb-10 fv-plugins-icon-container">
                <!--begin::Label-->
                <label class="fs-5 fw-bold form-label mb-2 required">
                    Tên
                </label>
                <!--end::Label-->

                <!--begin::Input-->
                <!--begin::Input-->
                <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif" placeholder="" name="name"
                    value="{{ $role->name }}" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <!--end::Input group-->

            <div class="col-md-4 mb-5">
                <label class="form-label required">Phân hệ</label>
                <select data-control="module-select" name="module" class="form-select @if ($errors->has('module')) is-invalid @endif" data-control="select2"
                    data-close-on-select="false" data-placeholder="Chọn phân hệ" data-allow-clear="true" required
                    >
                        <option value="">Chọn phân hệ</option>
                        @foreach (App\Library\Module::getAll() as $module)
                            <option {{ $module == $role->module ? 'selected' : '' }} value="{{ $module }}">{{ trans('messages.module.' . $module) }}</option>
                        @endforeach
                </select>
            </div>

            <!--begin::Permissions-->
            <div class="fv-row">
                <!--begin::Label-->
                <label class="fs-5 fw-bold form-label mb-2">Quyền của vai trò</label>
            <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
                <li class="nav-item">
                    <a class="nav-link btn btn-active-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0 {{ $role->module == 'marketing' ? 'active' : '' }} active" data-bs-toggle="tab" href="#kt_tab_pane_marketing">Marketing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0 {{ $role->module == 'sales' ? 'active' : '' }} " data-bs-toggle="tab" href="#kt_tab_pane_sales">Kinh doanh</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0 {{ $role->module == 'accounting' ? 'active' : '' }}" data-bs-toggle="tab" href="#kt_tab_pane_accounting">Kế toán</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0 {{ $role->module == 'edu' ? 'active' : '' }}" data-bs-toggle="tab" href="#kt_tab_pane_edu">Đào tạo</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0 {{ $role->module == 'abroad' ? 'active' : '' }}" data-bs-toggle="tab" href="#kt_tab_pane_abroad">Du học</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0 {{ $role->module == 'extracurricular' ? 'active' : '' }}" data-bs-toggle="tab" href="#kt_tab_pane_extracurricular">Ngoại khóa</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0 {{ $role->module == 'teacher' ? 'active' : '' }}" data-bs-toggle="tab" href="#kt_tab_pane_teacher">Giảng viên / Trợ giảng</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link btn btn-active-primary btn-color-gray-600 btn-active-color-primary rounded-bottom-0 {{ $role->module == 'system' ? 'active' : '' }}" data-bs-toggle="tab" href="#kt_tab_pane_system">Hệ thống</a>
                </li>
            </ul>
            
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show {{ $role->module == 'marketing' ? 'active' : '' }} active" id="kt_tab_pane_marketing" role="tabpanel">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                
                                @foreach (App\Library\Permission::getAllMarketings() as $category => $permissions)
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">
                                            {{ trans('messages.module.' . $category) }}</td>
                                        <!--end::Label-->
    
                                        <!--begin::Input group-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div>
                                                @foreach ($permissions as $permission)
                                                    <!--begin::Checkbox-->
                                                    <div class="mb-2">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" type="checkbox" value="{{ $permission }}" name="role_permission[]"
                                                                {{ $role->rolePermissions->contains('permission', $permission) ? 'checked' : '' }}>
    
                                                            <span class="form-check-label">
                                                                {{ trans('messages.permission.' . $permission) }}
                                                                
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Checkbox-->
                                                @endforeach
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="tab-pane fade show {{ $role->module == 'sales' ? 'active' : '' }}" id="kt_tab_pane_sales" role="tabpanel">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                
                                @foreach (App\Library\Permission::getAllSales() as $category => $permissions)
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">
                                            {{ trans('messages.module.' . $category) }}</td>
                                        <!--end::Label-->
    
                                        <!--begin::Input group-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div>
                                                @foreach ($permissions as $permission)
                                                    <!--begin::Checkbox-->
                                                    <div class="mb-2">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" type="checkbox" value="{{ $permission }}" name="role_permission[]"
                                                                {{ $role->rolePermissions->contains('permission', $permission) ? 'checked' : '' }}>
    
                                                            <span class="form-check-label">
                                                                {{ trans('messages.permission.' . $permission) }}
                                                                
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Checkbox-->
                                                @endforeach
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="tab-pane fade show {{ $role->module == 'accounting' ? 'active' : '' }}" id="kt_tab_pane_accounting" role="tabpanel">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                
                                @foreach (App\Library\Permission::getAllAccountings() as $category => $permissions)
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">
                                            {{ trans('messages.module.' . $category) }}</td>
                                        <!--end::Label-->
    
                                        <!--begin::Input group-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div>
                                                @foreach ($permissions as $permission)
                                                    <!--begin::Checkbox-->
                                                    <div class="mb-2">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" type="checkbox" value="{{ $permission }}" name="role_permission[]"
                                                                {{ $role->rolePermissions->contains('permission', $permission) ? 'checked' : '' }}>
    
                                                            <span class="form-check-label">
                                                                {{ trans('messages.permission.' . $permission) }}
                                                                
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Checkbox-->
                                                @endforeach
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="tab-pane fade show {{ $role->module == 'edu' ? 'active' : '' }}" id="kt_tab_pane_edu" role="tabpanel">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                
                                @foreach (App\Library\Permission::getAllEdus() as $category => $permissions)
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">
                                            {{ trans('messages.module.' . $category) }}</td>
                                        <!--end::Label-->
    
                                        <!--begin::Input group-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div>
                                                @foreach ($permissions as $permission)
                                                    <!--begin::Checkbox-->
                                                    <div class="mb-2">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" type="checkbox" value="{{ $permission }}" name="role_permission[]"
                                                                {{ $role->rolePermissions->contains('permission', $permission) ? 'checked' : '' }}>
    
                                                            <span class="form-check-label">
                                                                {{ trans('messages.permission.' . $permission) }}
                                                                
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Checkbox-->
                                                @endforeach
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="tab-pane fade show {{ $role->module == 'abroad' ? 'active' : '' }}" id="kt_tab_pane_abroad" role="tabpanel">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                
                                @foreach (App\Library\Permission::getAllAbroads() as $category => $permissions)
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">
                                            {{ trans('messages.module.' . $category) }}</td>
                                        <!--end::Label-->
    
                                        <!--begin::Input group-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div>
                                                @foreach ($permissions as $permission)
                                                    <!--begin::Checkbox-->
                                                    <div class="mb-2">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" type="checkbox" value="{{ $permission }}" name="role_permission[]"
                                                                {{ $role->rolePermissions->contains('permission', $permission) ? 'checked' : '' }}>
    
                                                            <span class="form-check-label">
                                                                {{ trans('messages.permission.' . $permission) }}
                                                                
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Checkbox-->
                                                @endforeach
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="tab-pane fade show {{ $role->module == 'extracurricular' ? 'active' : '' }}" id="kt_tab_pane_extracurricular" role="tabpanel">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                
                                @foreach (App\Library\Permission::getAllExtracurriculars() as $category => $permissions)
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">
                                            {{ trans('messages.module.' . $category) }}</td>
                                        <!--end::Label-->
    
                                        <!--begin::Input group-->
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div>
                                                @foreach ($permissions as $permission)
                                                    <!--begin::Checkbox-->
                                                    <div class="mb-2">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" type="checkbox" value="{{ $permission }}" name="role_permission[]"
                                                                {{ $role->rolePermissions->contains('permission', $permission) ? 'checked' : '' }}>
    
                                                            <span class="form-check-label">
                                                                {{ trans('messages.permission.' . $permission) }}
                                                                
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Checkbox-->
                                                @endforeach
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show {{ $role->module == 'teacher' || $role->module == 'teaching_assistant' ? 'active' : '' }}" id="kt_tab_pane_teacher" role="tabpanel">
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                                <!--begin::Table body-->
                                <tbody class="text-gray-600 fw-semibold">
                                    
                                    @foreach (App\Library\Permission::getAllTeachers() as $category => $permissions)
                                        <tr>
                                            <!--begin::Label-->
                                            <td class="text-gray-800">
                                                {{ trans('messages.module.' . $category) }}</td>
                                            <!--end::Label-->
        
                                            <!--begin::Input group-->
                                            <td>
                                                <!--begin::Wrapper-->
                                                <div>
                                                    @foreach ($permissions as $permission)
                                                        <!--begin::Checkbox-->
                                                        <div class="mb-2">
                                                            <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                                <input class="form-check-input" type="checkbox" value="{{ $permission }}" name="role_permission[]"
                                                                    {{ $role->rolePermissions->contains('permission', $permission) ? 'checked' : '' }}>
        
                                                                <span class="form-check-label">
                                                                    {{ trans('messages.permission.' . $permission) }}
                                                                    
                                                                </span>
                                                            </label>
                                                        </div>
                                                        <!--end::Checkbox-->
                                                    @endforeach
                                                </div>
                                                <!--end::Wrapper-->
                                            </td>
                                            <!--end::Input group-->
                                        </tr>
                                    @endforeach
                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                    </div>
                <div class="tab-pane fade show {{ $role->module == 'system' ? 'active' : '' }}" id="kt_tab_pane_system" role="tabpanel">
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5 ">
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                
                                @foreach (App\Library\Permission::getAllSystems() as $category => $permissions)
                                    <tr>
                                        <!--begin::Label-->
                                        <td class="text-gray-800">
                                            {{ trans('messages.module.' . $category) }}</td> 
                                        <td>
                                            <!--begin::Wrapper-->
                                            <div>
                                                @foreach ($permissions as $permission)
                                                    <!--begin::Checkbox-->
                                                    <div class="mb-2">
                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5 me-lg-20">
                                                            <input class="form-check-input" type="checkbox" value="{{ $permission }}" name="role_permission[]"
                                                                {{ $role->rolePermissions->contains('permission', $permission) ? 'checked' : '' }}>
    
                                                            <span class="form-check-label">
                                                                {{ trans('messages.permission.' . $permission) }}
                                                                
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Checkbox-->
                                                @endforeach
                                            </div>
                                            <!--end::Wrapper-->
                                        </td>
                                        <!--end::Input group-->
                                    </tr>
                                @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                        <!--end::Table-->
                    </div>
                </div>
            </div>
                <!--end::Table wrapper-->
            </div>

        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateRoleSubmitButton" type="submit" class="btn btn-primary">
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
            RoleCreate.init();
        });

        var RoleCreate = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                // Lấy dữ liệu từ biểu mẫu.
                var data = $(form).serialize();
                // Thêm hiệu ứng
                addSubmitEffect();

                $.ajax({
                    url: '',
                    method: 'POST',
                    data: data,
                }).done(function(response) {
                    // hide popup
                    CreateRolePopup.getPopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            RolesList.getList().load();
                        }
                    });
                }).fail(function(response) {
                    CreateRolePopup.getPopup().setContent(response.responseText);

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
                    form = document.getElementById('CreateRoleForm');
                    btnSubmit = document.getElementById('CreateRoleSubmitButton');

                    //data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
