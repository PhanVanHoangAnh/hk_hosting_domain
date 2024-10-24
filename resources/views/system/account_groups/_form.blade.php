<!--begin::Scroll-->
<div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_customer_scroll" data-kt-scroll="true"
    data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
    data-kt-scroll-dependencies="#kt_modal_add_customer_header" data-kt-scroll-wrappers="#kt_modal_add_customer_scroll"
    data-kt-scroll-offset="300px">
    <!--begin::Input group-->
    <input type="hidden" name="account_group_id" value="{{ $accountGroup->id }}"/>
    <div class="row g-9 mb-7">
        <!--begin::Col-->
        
        <div class="col-md-12 fv-row">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Tên nhóm tài khoản</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif"
                placeholder="" name="name" value="{{ $accountGroup->name }}" />
            <!--end::Input-->
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div class="col-md-12 fv-row">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Quản lý nhóm</label>
            <!--end::Label-->
            <!--begin::Input-->
            <div class="form-outline">
                <select name="manager_id" data-control="select2-ajax" list-action="sales-select"
                    data-url="{{ action('App\Http\Controllers\AccountController@select2') }}"
                    class="form-control" data-dropdown-parent="" data-control="select2"
                    data-placeholder="Chọn quản lý nhóm"
                >
                    @if ($accountGroup->manager)
                        <option value="{{ $accountGroup->manager_id }}">{{ $accountGroup->manager->name }}</option>
                    @endif
                </select>
            </div>
            <!--end::Input-->
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
       
        <!--end::Col-->
    </div>
    <!--end::Input group-->

</div>
<!--end::Scroll-->
