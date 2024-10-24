@section('footer')
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="{{ url('core/assets/js/custom/apps/projects/list/list.js') }}"></script>
    <script src="{{ url('core/assets/js/widgets.bundle.js') }}"></script>
    <script src="{{ url('core/assets/js/custom/widgets.js') }}"></script>
    <script src="{{ url('core/assets/js/custom/apps/chat/chat.js') }}"></script>
    <!--end::Custom Javascript-->
@endsection
<div class="d-flex flex-wrap flex-sm-nowrap">
    <!--begin: Pic-->
    <div class="me-7 mb-4">
        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
            <img src="{{ url('/core/assets/media/avatars/blank.png') }}" alt="image" />
            <div
                class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border-4 border-body h-20px w-20px">
            </div>
        </div>
    </div>
    <!--end::Pic-->

    <!--begin::Info-->
    <div class="flex-grow-1">
        <!--begin::Title-->
        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
            <!--begin::User-->
            <div class="col-lg-9" id="ContactsInformation">
                <!--begin::Row-->
                <div class="row mb-3">
                    <div class="col-lg-4">
                        <span
                            class="fw-bold fs-6 text-gray-800">{{ $softwareRequest->contact ? $softwareRequest->contact->name : '--' }}</span>
                    </div>

                    <label class="col-lg-2 text-muted">Trạng thái:</label>
                    <div class="col-lg-2 d-flex align-items-center">
                        {{-- <select id="status" class="form-select d-inline-block w-auto">
                            <option selected="">ComboBox</option>
                            <!-- Add other options here -->
                        </select> --}}
                        @php
                            $bgs = [
                                App\Models\SoftwareRequest::STATUS_NEW => 'secondary',
                                App\Models\SoftwareRequest::STATUS_CARE => 'warning',
                                App\Models\SoftwareRequest::STATUS_DELIVERED => 'success',
                            ];
                        @endphp
                        <span class="fw-bold fs-6 badge bg-{{ $bgs[$softwareRequest->status] ?? 'info' }}">
                            {{ trans('messages.hk.software_requests.status.' . $softwareRequest->status) ?? '--' }}
                        </span>
                    </div>

                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-2 text-muted">Mã KH:</label>
                    <div class="col-lg-2">
                        <span class="fs-6 text-gray-800 me-2">
                            {{ $softwareRequest->contact ? $softwareRequest->contact->id : '--'}}
                        </span>
                    </div>
                    <label class="col-lg-2 text-muted">Liên hệ cuối:</label>
                    <div class="col-lg-2">
                        <span class="fs-6 text-gray-800 me-2">2024-07-10 11:11:11</span>
                    </div>
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-2 text-muted">Email:</label>
                    <div class="col-lg-2">
                        <span class="fs-6 text-gray-800 me-2">
                            {{ $softwareRequest->contact ? $softwareRequest->contact->email : '--'}}
                        </span>
                    </div>

                    <label class="col-lg-2 text-muted">Liên hệ cuối:</label>
                    <div class="col-lg-2">
                        <span class="fs-6 text-gray-800 me-2">2024-07-10 11:11:11</span>
                    </div>
                </div>
                <!--end::Row-->

                <!--begin::Row-->
                <div class="row mb-7">
                    <label class="col-lg-2 text-muted">Số điện thoại</label>
                    <div class="col-lg-2">
                        <span class="fs-6 text-gray-800 me-2">
                            {{ $softwareRequest->contact ? $softwareRequest->contact->phone : '--'}}
                        </span>
                    </div>
                    <label class="col-lg-2 text-muted">NV tư vấn:</label>
                    <div class="col-lg-2">
                        <span class="fs-6 text-gray-800 me-2">
                            {{ $softwareRequest->account ? $softwareRequest->account->name : '--' }}
                        </span>
                    </div>
                </div>
                <!--end::Row-->
            </div>
            <!--end::User-->
        </div>
        <!--end::Title-->
    </div>
    <!--end::Info-->
</div>
