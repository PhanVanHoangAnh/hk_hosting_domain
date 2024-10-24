@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa nhóm nhân sự
@endsection

@section('content')
<form id="editStaffGroupForm" tabindex="-1" method="post"
action="javascript:;">
@csrf

@php
    $editStaffGroupPopupUniqId = 'editStaffGroupPopupUniqId_' . uniqid()
@endphp

<!--begin::Scroll-->
<div id="{{ $editStaffGroupPopupUniqId }}" class="scroll-y pe-7 py-20 px-lg-17">
    <!--begin::Input group-->
    <div class="row g-9 mb-5 d-flex justify-content-center">
        <div class="col-lg-5 col-xl-5 col-md-5 col-sm-10 col-10">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2" for="price-create-input">Tên nhóm</label>
                <input id="price-create-input" type="text" class="form-control"
                    placeholder="Nhập tên nhóm..." name="name" value="{{ isset($staffGroup) ? $staffGroup->name : '' }}">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
        </div>

        <div class="col-lg-5 col-xl-5 col-md-5 col-sm-10 col-10">
            <div class="form-outline">
                <label class="fs-6 fw-semibold mb-2" for="staff-group-type-select">Loại hình nhân sự</label>
                <select id="staff-group-type-select" class="form-select form-control " name="type"
                    data-dropdown-parent="#{{ $editStaffGroupPopupUniqId }}" data-allow-clear="true"
                    data-control="select2" data-placeholder="Chọn loại hình nhóm">
                    <option value="">Chọn loại hình nhóm</option>
                    @foreach( App\Models\StaffGroup::getAllType() as $type )
                        <option value="{{ $type }}" {{ isset($staffGroup) && $staffGroup->type == $type ? 'selected' : '' }}>{{ trans('messages.staff_groups.type.' . $type) }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="row g-9 mb-5 d-flex justify-content-center">
        <div class="col-lg-5 col-xl-5 col-md-5 col-sm-10 col-10">
            <div class="form-outline">
                <label class="fs-6 fw-semibold mb-2" for="staff-group-manager-select">Quản lý nhóm</label>
                <select id="staff-group-manager-select" class="form-select form-control " name="group_manager_id"
                    data-dropdown-parent="#{{ $editStaffGroupPopupUniqId }}" data-allow-clear="true"
                    data-control="select2" data-placeholder="Chọn người quản lý nhóm">
                    <option value="">Chọn người quản lý nhóm</option>
                    @foreach( App\Models\Account::all() as $manager )
                        <option value="{{ $manager->id }}" {{ isset($staffGroup) && $staffGroup->group_manager_id == $manager->id ? 'selected' : '' }}>{{ $manager->name }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('group_manager_id')" class="mt-2" />
            </div>
        </div>

        <div class="col-lg-5 col-xl-5 col-md-5 col-sm-10 col-10">
            <div class="form-outline">
                <label class="fs-6 fw-semibold mb-2" for="staff-group-default-payment-account-select">Tài khoản thanh toán mặc định</label>
                <select id="staff-group-default-payment-account-select" class="form-select form-control " name="default_payment_account_id"
                    data-dropdown-parent="#{{ $editStaffGroupPopupUniqId }}" data-allow-clear="true"
                    data-control="select2" data-placeholder="Chọn tài khoản thanh toán mặc định">
                    <option value="">Chọn tài khoản thanh toán mặc định</option>
                    @foreach( App\Models\PaymentAccount::all() as $account )
                        <option value="{{ $account->id }}" {{ isset($staffGroup) && $staffGroup->default_payment_account_id == $account->id ? 'selected' : '' }}>{{ $account->account_name . ' - ' . $account->account_number . ' - ' . $account->bank }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('default_payment_account_id')" class="mt-2" />
            </div>
        </div>
    </div>

    <div class="modal-footer flex-center">
        <!--begin::Button-->
        <button id="editStaffGroupSubmitButton" type="submit" class="btn btn-primary">
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
        CreateStaffGroup.init();
    });

    var CreateStaffGroup = function() {
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
                url: "{{ action([App\Http\Controllers\System\StaffGroupController::class, 'update']) }}",
                method: 'POST',
                data: data
            }).done(response => {
                CreateStaffGroupPopup.getPopup().hide();

                ASTool.alert({
                    message: response.message,
                    ok: () => {
                        StaffGroupsList.getList().load();
                    }
                });
            }).fail(response => {
                CreateStaffGroupPopup.getPopup().setContent(response.responseText);
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
                form = document.querySelector("#editStaffGroupForm");
                submitDataBtn = document.querySelector("#editStaffGroupSubmitButton");

                handleFormSubmit();
            }
        }
    }();
</script>
@endsection
