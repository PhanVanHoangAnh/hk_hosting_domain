@extends('layouts.main.popup')
@section('title')
    Nhập dữ liệu đơn hàng từ file excel
@endsection
@section('content')
    <style>
        .scrollable-table-excel {
            overflow: scroll;
            max-height: 300px;
        }

        #dtHorizontalVerticalExample {
            border-collapse: collapse;
        }

        #dtHorizontalVerticalExample th,
        #dtHorizontalVerticalExample td {
            padding: 8px 16px;
            border: 1px solid #ddd;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #dtHorizontalVerticalExample thead {
            position: sticky;
            inset-block-start: 0;
            background-color: #ddd;
        }

        #dtHorizontalVerticalExample th {
            text-align: center;
        }

        #dtHorizontalVerticalExample td {
            /* text-align: center; */
            vertical-align: middle;
        }

        .table-bordered>:not(caption)>* {
            border-width: 0px;
        }
    </style>


    <div class="stepper stepper-pills" id="kt_stepper_example_basic">
        <!--begin::Nav-->
        <div class="stepper-nav flex-center flex-wrap mt-5">
            <!--begin::Step 1-->
            <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px bg-primary">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">
                            <i class="bi bi-check-lg fs-3 font-weight-bold"></i>
                        </span>
                    </div>
                    <!--end::Icon-->

                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title text-left">
                            <i class="bi bi-upload fs-2"></i>
                        </h3>

                        <div class="stepper-desc text-black text-black">
                            Tải dữ liệu
                        </div>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
            </div>
            <!--end::Step 1-->

            <!--begin::Step 2-->
            <div class="stepper-item mark-completed mx-8 my-4" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px bg-primary">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number text-white">2</span>
                    </div>
                    <!--begin::Icon-->

                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title text-left">
                            <i class="bi bi-graph-down-arrow fs-2"></i>
                        </h3>

                        <div class="stepper-desc text-black">
                            Xem trước
                        </div>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
            </div>
            <!--end::Step 2-->

            <!--begin::Step 3-->
            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">3</span>
                    </div>
                    <!--begin::Icon-->

                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title text-left">
                            <i class="bi bi-save fs-2"></i>
                        </h3>

                        <div class="stepper-desc text-black">
                            Nhập dữ liệu
                        </div>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
            </div>
            <!--end::Step 3-->

            <!--begin::Step 4-->
            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">4</span>
                    </div>
                    <!--begin::Icon-->

                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title text-left">
                            <i class="bi bi-list-check fs-2"></i>
                        </h3>

                        <div class="stepper-desc text-black text-black">
                            Kết quả
                        </div>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
            </div>
            <!--end::Step 4-->
        </div>
        <!--end::Nav-->
    </div>

    <form class="form" id="kt_modal_upload_form">
        @csrf
        <!--begin::Modal body-->
        <div class="modal-body pt-10 pb-15 px-lg-17">
            <!--begin::Input group-->
            <div class="form-group">
                <!--begin::Dropzone-->
                <div class="dropzone dropzone-queue mb-2" id="kt_modal_upload_dropzone">
                    <!--begin::Controls-->
                    <div class="mb-10">
                        <label for="dtHorizontalVerticalExample" class="required form-label">Danh sách đơn hàng từ file dữ
                            liệu (Tổng số đơn hàng: <strong>{{ count($datas) }}</strong>)</label>
                        <div class="scrollable-table-excel">
                            <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm "
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th>Thao tác</th>
                                        <th>Trạng thái</th>
                                        <th>Họ và tên</th>
                                        <th>Số điện thoại</th>
                                        <th>Email</th>
                                        <th>Đơn hàng</th>
                                        <th>Trường học</th>
                                        <th>Ngày sinh</th>
                                        <th>Thời gian phù hợp</th>
                                        <th>Quốc gia</th>
                                        <th>Thành phố</th>
                                        <th>Quận</th>
                                        <th>Phường</th>
                                        <th>Địa chỉ</th>

                                        <th>Efc</th>
                                        <th>Target</th>
                                        <th>list</th>
                                        <th>Date</th>

                                        <th>Phân loại nguồn</th>
                                        <th>channel</th>
                                        <th>sub channel</th>
                                        <th>campaign</th>
                                        <th>adset</th>
                                        <th>ads</th>
                                        <th>device</th>
                                        <th>placement</th>
                                        <th>term</th>
                                        <th>Type Match</th>
                                        <th>UID FB</th>
                                        <th>UID GG</th>
                                        <th>first url</th>
                                        <th>Conversion Url</th>
                                        <th>contact owner</th>
                                        <th>lifecycle stage</th>
                                        <th>lead status</th>
                                        <th>note sales</th>

                                    </tr>
                                </thead>
                                <tbody class="text-gray-600">
                                    <!-- Thêm dữ liệu của bạn vào đây -->
                                    @foreach ($datas as $key => $data)
                                        <tr class="{{ $key === 2 ? 'bg-warning' : '' }}" list-control="item">



                                            @if ($key === 2)
                                                <td class="text-center ps-1">
                                                    <div class="form-check form-check-sm form-check-custom">
                                                        <input list-action="check-item" class="form-check-input"
                                                            type="checkbox" value="1" checked />
                                                    </div>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="badge bg-danger text-white">
                                                        Trùng
                                                    </span>
                                                </td>
                                            @else
                                                <td class="text-center ps-1">
                                                    <div class="form-check form-check-sm form-check-custom">
                                                        <input list-action="check-item" class="form-check-input"
                                                            type="checkbox" value="1" checked />
                                                    </div>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="badge bg-success text-white">
                                                        Mới
                                                    </span>
                                                </td>
                                            @endif

                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->name }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked name="name{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->name }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->displayPhoneNumberByUser(Auth::user()) }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked name="phone{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->displayPhoneNumberByUser(Auth::user()) }}
                                                    @endif
                                                </span>
                                            </td>
                                            @if ($key === 2)
                                                <td data-filter="mastercard">
                                                    {{ $data->email }}
                                                    <div class="highlighted-text text-danger">
                                                        &#10038; Email bị trùng
                                                    </div>

                                                </td>
                                            @else
                                                <td data-filter="mastercard">
                                                    {{ $data->email }}
                                                </td>
                                            @endif
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->demand }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="demand{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->demand }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->school }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="school{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->school }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->birthday ? date('d/m/Y', strtotime($data->birthday)) : '--' }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="birthday{{ $key }}" />
                                                        </span>
                                                    @else
                                                    {{ $data->birthday ? date('d/m/Y', strtotime($data->birthday)) : '--' }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->timeToCall }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="timeToCall{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->timeToCall }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->country }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="country{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->country }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->city }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="city{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->city }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->district }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="district{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->district }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->ward }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="ward{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->ward }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->address }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="address{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->address }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->efc }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="efc{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->efc }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->target }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="target{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->target }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->list }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="list{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->list }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->date }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="date{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->date }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->source_type }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="source_type{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->source_type }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->channel }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="channel{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->channel }}
                                                    @endif
                                                </span>
                                            </td>
                                            <td data-filter="mastercard">
                                                <span class="d-flex align-items-center">
                                                    @if ($key === 2)
                                                        <span class="me-auto">
                                                            {{ $data->campaign }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" checked
                                                                name="campaign{{ $key }}" />
                                                        </span>
                                                    @else
                                                        {{ $data->campaign }}
                                                    @endif
                                                </span>
                                            </td>


                                            <td data-filter="mastercard">
                                                {{ $data->adset }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->ads }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->device }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->placement }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->term }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->type_match }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->fbclid }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->gclid }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->first_url }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->last_url }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->contact_owner }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->lifecycle_stage }}
                                                w </td>
                                            <td data-filter="mastercard">
                                                {{ $data->lead_status }}
                                            </td>
                                            <td data-filter="mastercard">
                                                {{ $data->note_sales }}
                                            </td>


                                        </tr>

                                        @if ($key === 2)
                                            <tr class="bg-gray-200">
                                                <td colspan="10" class="py-1 small fw-bold">Danh sách đơn hàng trùng:
                                                </td>
                                            </tr>
                                            <tr class="bg-gray-300 text-gray-600" list-control="item">
                                                <td class="text-center ps-1" colspan="2">
                                                    <select list-action="contact-select" class="form-select"
                                                        data-allow-clear="true">
                                                        <option value="all" selected>Cùng đơn hàng</option>
                                                        <option value="all">Đơn hàng khác</option>
                                                    </select>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            Phạm Trường
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="name{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            086564246
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="phone{{ $key }}" />
                                                        </span>
                                                    </span>

                                                </td>
                                                @if ($key === 2)
                                                    <td data-filter="mastercard">
                                                        {{ $data->email }}
                                                        <div class="highlighted-text text-danger">
                                                            &#10038; Email bị trùng
                                                        </div>

                                                    </td>
                                                @else
                                                    <td data-filter="mastercard">
                                                        {{ $data->email }}
                                                    </td>
                                                @endif

                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->demand }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="demand{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->school }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="school{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->birthday ? date('d/m/Y', strtotime($data->birthday)) : '--' }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="birthday{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                {{-- <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->demand }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="demand{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td> --}}
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->timeToCall }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="timeToCall{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->country }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="country{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->city }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="city{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->district }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="district{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->ward }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="ward{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->address }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="address{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->efc }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="efc{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->target }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="target{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->list }}

                                                        </span>
                                                        <span>
                                                            <input type="radio" name="list{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->date }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="date{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->source_type }}
                                                        </span>
                                                        <span>
                                                            <input type="radio"
                                                                name="source_type{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->channel }}
                                                        </span>
                                                        <span>
                                                            <input type="radio" name="channel{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span class="d-flex align-items-center">
                                                        <span class="me-auto">
                                                            {{ $data->sub_channel }}
                                                        </span>
                                                        <span>
                                                            <input type="radio"
                                                                name="sub_channel{{ $key }}" />
                                                        </span>
                                                    </span>
                                                </td>

                                                <td data-filter="mastercard">
                                                    {{ $data->campaign }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->adset }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->ads }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->device }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->placement }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->term }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->type_match }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->fbclid }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->gclid }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->first_url }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->last_url }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->contact_owner }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->lifecycle_stage }}
                                                    w </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->lead_status }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data->note_sales }}
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div>
                        <label for="dtHorizontalVerticalExample" class="required form-label">Chọn tài khoản account mặc
                            định
                            (Tùy chọn)</label>
                        <select id="account-select-import-excel" class="form-select mb-5" data-control="select2"
                            data-placeholder="Select an option" name="accounts">
                            @foreach (App\Models\Account::all() as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <button id="confirmAndSaveDataBtn" class="btn btn-primary">Xác nhận & nhập dữ liệu</button>
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Dropzone-->
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Modal body-->
    </form>

    <script>
        $(() => {
            formEvents.init();
        })

        var formEvents = function() {
            let csrfToken;

            const datas = @json($datas); // Data getted form server (From excel file user fill)

            return {
                init: () => {
                    csrfToken = document.querySelector('input[name="_token"]').value;
                    document.querySelector('#kt_modal_upload_form').addEventListener('submit', e => {
                        e.preventDefault();

                        ExcelPopup.updateUrlSaveDatas(
                            "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@importExcelRunning') }}",
                            'POST', csrfToken, {
                                excelDatas: datas,
                                accountId: document.querySelector("#account-select-import-excel")
                                    .value // ID account selected 
                            });
                    })
                }
            }
        }();
    </script>
@endsection
