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
        <div class="col-lg-6 col-xl-6 col-md-6 col-sm-10 col-10">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2" for="price-create-input">Tên nhân sự</label>
                <input id="price-create-input" type="text" class="form-control"
                    placeholder="Nhập tên nhân sự..." name="name" value="{{ isset($staff) ? $staff->name : '' }}">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <div class="col-lg-4 col-xl-4 col-md-4 col-sm-10 col-10">
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
                url: "{{ action([App\Http\Controllers\Edu\StaffController::class, 'store']) }}",
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
