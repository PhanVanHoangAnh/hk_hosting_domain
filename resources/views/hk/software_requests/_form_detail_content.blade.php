@csrf
<div id="kt_post">
    <!--begin::Navbar-->
    <div class="card mb-5 mb-xl-10">
        <!--end::Consulting History-->
        <div class="card-body pt-0 mt-5">
            <div class="card-title m-0">
                <h3 class="fw-bold m-0">Thông tin chi tiết</h3>
            </div>
            <!--end::Card title-->
            <!--begin::Card body-->
            <div class="scroll-y pe-7 py-10 px-lg" id="ContactsInformation">
                <!--begin::Row-->
                <div class="row mb-6">
                    <label for="employeeCount" class=" col-lg-1 text-mute">Số lượng nhân viên</label>
                    <select list-action="type-select" class=" col-lg-2" id="employeeCount"
                        data-placeholder="Chọn đơn hàng" data-allow-clear="true" name="company_size">
                        <option value="">Chọn số lượng nhân viên</option>
                        @foreach (\App\Models\SoftwareRequest::all() as $softwareRequest)
                            <option value="{{ $softwareRequest->company_size }}"
                                {{ isset($softwareRequest) && $softwareRequest->company_size ? 'selected' : '' }}>
                                {{ $softwareRequest->company_size }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('company_size')" class="mt-2" />

                    <label for="branchCount" class=" col-lg-1 text-mute">Số lượng chi nhánh</label>
                    <input type="text" class=" col-lg-2" id="branchCount" name="company_branch"
                        value="{{ $softwareRequest->company_branch }}">
                    <x-input-error :messages="$errors->get('company_branch')" class="mt-2" />

                </div>
                <!--begin::Row-->
                <div class="row mb-6">
                    <label for="deploymentTime" class="col-lg-1 text-muted">Thời gian triển khai</label>
                    <input type="date" class="col-lg-2 @if ($errors->has('start_date')) is-invalid @endif" id="deploymentTime" value="{{ $softwareRequest->start_date }}" name="start_date">
                    <x-input-error :messages="$errors->get('start_date')" class="mt-2" />

                    <label for="budget" class="col-lg-1 text-muted">Ngân sách dự kiến</label>
                    <input type="text" class="col-lg-2 " id="budget" name="estimated_cost"
                        {{-- value="{{ number_format($softwareRequest->estimated_cost, 0, ',', ',') }} "> --}}
                        value="{{ $softwareRequest->estimated_cost }} ">
                    <x-input-error :messages="$errors->get('estimated_cost')" class="mt-2" />

                </div>
            </div>
            <!--end::Card body-->
            <div class="row">
                <textarea class="form-control" id="detailedDescription" rows="4" name="note"
                    placeholder="Mô tả chi tiết yêu cầu của khách hàng">{{ $softwareRequest->note }}</textarea>
            </div>
        </div>
    </div>
</div>
