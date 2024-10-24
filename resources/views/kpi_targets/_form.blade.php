<!--begin::Scroll-->
<div class="pe-7 py-10 px-lg-17">
    <div class="mb-8">
        <!--begin::Label-->
        <label class="required fs-6 fw-semibold mb-3">Chọn loại</label>
        <!--end::Label-->
        <!--begin::Input-->
        {{-- <select name="type"
            class="form-select @if ($errors->has('type')) is-invalid @endif"
            data-control="select2" data-placeholder="Chọn loại"
        >
            <option></option>
            @foreach (\App\Models\KpiTarget::getTypeOptions() as $option)
                <option {{ $kpiTarget->type == $option['value'] ? 'selected' : '' }} value="{{ $option['value'] }}">{{ $option['text'] }}</option>
            @endforeach
        </select> --}}

        <div class="d-flex align-items-center">
            <div class="me-10">
                <div class="form-check form-check-custom form-check-solid">
                    <input {{ $kpiTarget->type == App\Models\KpiTarget::TYPE_MONTH ? 'checked' : '' }} class="form-check-input" type="radio" name="type" value="{{ App\Models\KpiTarget::TYPE_MONTH }}" id="kpiTargetMonth"  />
                    <label class="form-check-label" for="kpiTargetMonth">
                        Theo tháng
                    </label>
                </div>
            </div>
            <div>
                <div class="form-check form-check-custom form-check-solid">
                    <input {{ $kpiTarget->type == App\Models\KpiTarget::TYPE_QUARTER ? 'checked' : '' }} class="form-check-input" type="radio" name="type" value="{{ App\Models\KpiTarget::TYPE_QUARTER }}" value="" id="kpiTargetQuarter"  />
                    <label class="form-check-label" for="kpiTargetQuarter">
                        Theo quý
                    </label>
                </div>
            </div>
        </div>

        <!--end::Input-->
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>

    <div class="mb-7">
        <!--begin::Label-->
        <label class="required fs-6 fw-semibold mb-2">Chọn nhân viên</label>
        <!--end::Label-->
        <select name="account_id" data-control="select2-ajax"
            data-url="{{ action('App\Http\Controllers\AccountController@select2') }}"
            class="form-control @if ($errors->has('account_id')) is-invalid @endif"
            data-dropdown-parent="#{{ $formId }}"
            data-control="select2" data-placeholder="Chọn nhân viên"
        >
            @if (isset($kpiTarget->account))
                <option value="{{ $kpiTarget->account_id }}" selected>{{ $kpiTarget->account->name }}</option>
            @endif
        </select>
        <x-input-error :messages="$errors->get('account_id')" class="mt-2" />
    </div>

    <div class="mb-7">
        <!--begin::Label-->
        <label class="required fs-6 fw-semibold mb-2">Chỉ tiêu (VNĐ)</label>
        <!--end::Label-->
        <!--begin::Input-->
        <input name="amount" type="text" class="form-control @if ($errors->has('amount')) is-invalid @endif"
            placeholder="" value="{{ $kpiTarget->amount }}" />
        <!--end::Input-->
        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
    </div>

    <div class="row mb-7">
        <div class="col-md-6">
            <!--begin::Label-->
            <label class="required fs-6 fw-semibold mb-2">Từ ngày</label>
            <!--end::Label-->
            <!--begin::Input-->
            <input name="start_at" type="date" class="form-control @if ($errors->has('start_at')) is-invalid @endif"
                placeholder="" value="{{ $kpiTarget->start_at->format('Y-m-d') }}" />
            <!--end::Input-->
            <x-input-error :messages="$errors->get('start_at')" class="mt-2" />
        </div>

        <div class="col-md-6">
            <!--begin::Label-->
            <label class="fs-6 fw-semibold mb-2">
                <span class="required fs-6 fw-semibold mb-2">Đến ngày</span>
            </label>
            <!--end::Label-->
            <!--begin::Input-->
            <input name="end_at" type="date" class="form-control @if ($errors->has('end_at')) is-invalid @endif"
               placeholder="" value="{{ $kpiTarget->end_at->format('Y-m-d') }}" />
            <!--end::Input-->
            <x-input-error :messages="$errors->get('end_at')" class="mt-2" />
        </div>
    </div>

</div>
<!--end::Scroll-->