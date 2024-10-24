@extends('layouts.main.popup')

@section('title')
    Thêm mới nhân sự đào tạo
@endsection

@section('content')
<form id="CreateStaffForm" tabindex="-1" method="post"
action="javascript:;">
@csrf

<!--begin::Scroll-->
<div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_staff_scroll">
    <!--begin::Input group-->
    <div class="row g-9 mb-5 d-flex justify-content-center">
        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2" for="price-create-input">Tên nhân sự</label>
                <input id="price-create-input" type="text" class="form-control"
                    placeholder="Nhập tên nhân sự..." name="name" value="{{ isset($staff) ? $staff->name : '' }}">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-12 col-12">
            <div class="form-outline">
                <label class="fs-6 fw-semibold mb-2" for="staff-type-select">Loại hình nhân sự</label>
                <select id="staff-type-select" class="form-select form-control " name="type"
                    data-control="select2" data-placeholder="Chọn loại hình nhân sự" data-allow-clear="true">
                    <option value="">Chọn loại hình</option>
                    @foreach( App\Models\Teacher::getAllTypeVariable() as $type )
                        <option value="{{ $type }}" {{ isset($staff) && $staff->type == $type ? 'selected' : '' }}>{{ trans('messages.role.' . $type) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">

            <!--begin::Input group-->
            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Địa chỉ E-mail</span>
                    <span class="ms-1" data-bs-toggle="tooltip" title="Địa chỉ email phải xác thực">
                        <i class="ki-outline ki-information fs-7">
                        </i>
                    </span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input type="email" id="email"
                    class="form-control @if ($errors->has('email')) is-invalid @endif" name="email"
                    placeholder="e.g., sean@dellito.com" value="" />

                <!--end::Input-->
                <span id="error-message-email" class="text-danger"></span>
                <div id="table-email-coincide">

                </div>
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
            <!--end::Input group-->
        </div>

        <div class="col-md-6">

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Số điện thoại</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <input id="phone" type="text"
                    class="form-control @if ($errors->has('phone')) is-invalid @endif" name="phone"
                    placeholder="" value="" />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                <span id="error-message-phone" class="text-danger"></span>
                <div id="table-phone-coincide"> </div>

            </div>

        </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="branch-select">Chọn chi nhánh</label>
                    <select id="branch-select" class="form-select form-control" data-control="select2"  name="area"
                        data-placeholder="Chọn chi nhánh">
                        <option value="">Chọn chi nhánh</option>
                        @foreach (App\Models\TrainingLocation::getBranchs() as $branch)
                            <option value="{{ $branch }}"
                                {{ isset($trainingLocation) && $trainingLocation->branch === $branch
                                    ? 'selected'
                                    : '' }}>
                                {{ trans('messages.training_location.' . $branch) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer flex-center">
        <!--begin::Button-->
        <button id="CreateStaffSubmitButton" type="submit" class="btn btn-primary">
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
        CreateStaff.init();
    });

    var CreateStaff = function() {
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

            $.ajax({
                url: "{{ action([App\Http\Controllers\System\TeacherController::class, 'store']) }}",
                method: 'POST',
                data: data
            }).done(response => {
                CreateStaffPopup.getPopup().hide();

                ASTool.alert({
                    message: response.message,
                    ok: () => {
                        StaffsList.getList().load();
                    }
                });
            }).fail(response => {
                CreateStaffPopup.getPopup().setContent(response.responseText);
                removeSubmitEffect();
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
                form = document.querySelector("#CreateStaffForm");
                submitDataBtn = document.querySelector("#CreateStaffSubmitButton");

                handleFormSubmit();
            }
        }
    }();
</script>
@endsection
