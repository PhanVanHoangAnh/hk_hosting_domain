<!--begin::Scroll-->
<div class="pe-7  py-10 px-lg-17" >
    <!--begin::Input group-->
    <input type="hidden" name="account_group_id" value="{{ $accountGroup->id }}"/>
    <div class="row g-9 mb-7">
        <!--begin::Col-->
        <div class="col-md-6 fv-row">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Du học</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select  class="form-select form-control " name="abroad_payment_account_id"
                data-dropdown-parent="#{{ $formId }}" data-allow-clear="false"
                data-control="select2" data-placeholder="Chọn tài khoản thanh toán ">
                <option value="">Chọn tài khoản thanh toán </option>
                @foreach( App\Models\PaymentAccount::active()->get() as $account )
                    <option value="{{ $account->id }}" {{ isset($accountGroup) && $accountGroup->abroad_payment_account_id == $account->id ? 'selected' : '' }}>{{ $account->account_name . ' - ' . $account->account_number . ' - ' . $account->bank }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('abroad_payment_account_id')" class="mt-2" />
            <!--end::Input-->
            
        </div>
        <div class="col-md-6 fv-row">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Đào tạo</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select  class="form-select form-control " name="edu_payment_account_id"
                data-dropdown-parent="#{{ $formId }}" data-allow-clear="false"
                data-control="select2" data-placeholder="Chọn tài khoản thanh toán ">
                <option value="">Chọn tài khoản thanh toán </option>
                @foreach( App\Models\PaymentAccount::active()->get() as $account )
                    <option value="{{ $account->id }}" {{ isset($accountGroup) && $accountGroup->edu_payment_account_id == $account->id ? 'selected' : '' }}>{{ $account->account_name . ' - ' . $account->account_number . ' - ' . $account->bank }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('edu_payment_account_id')" class="mt-2" />
        </div>
        <div class="col-md-6 fv-row">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Ngoại khóa</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select  class="form-select form-control " name="extracurricular_payment_account_id"
                data-dropdown-parent="#{{ $formId }}" data-allow-clear="false"
                data-control="select2" data-placeholder="Chọn tài khoản thanh toán ">
                <option value="">Chọn tài khoản thanh toán </option>
                @foreach( App\Models\PaymentAccount::active()->get() as $account )
                    <option value="{{ $account->id }}" {{ isset($accountGroup) && $accountGroup->extracurricular_payment_account_id == $account->id ? 'selected' : '' }}>{{ $account->account_name . ' - ' . $account->account_number . ' - ' . $account->bank }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('extracurricular_payment_account_id')" class="mt-2" />
        </div>
        <div class="col-md-6 fv-row">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Công nghệ</label>
            <!--end::Label-->
            <!--begin::Input-->
            <select  class="form-select form-control " name="teach_payment_account_id"
                data-dropdown-parent="#{{ $formId }}" data-allow-clear="false"
                data-control="select2" data-placeholder="Chọn tài khoản thanh toán ">
                <option value="">Chọn tài khoản thanh toán </option>
                @foreach( App\Models\PaymentAccount::active()->get() as $account )
                    <option value="{{ $account->id }}" {{ isset($accountGroup) && $accountGroup->teach_payment_account_id == $account->id ? 'selected' : '' }}>{{ $account->account_name . ' - ' . $account->account_number . ' - ' . $account->bank }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('teach_payment_account_id')" class="mt-2" />
        </div>
        <!--end::Col-->
    </div>
    <!--end::Input group-->

</div>
<!--end::Scroll-->
