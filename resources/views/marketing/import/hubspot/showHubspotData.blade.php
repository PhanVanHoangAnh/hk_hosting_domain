@extends('layouts.main.popup', [
    'size' => 'full',
])
@section('title')
    Nhập dữ liệu liên hệ từ Hubspot
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
                        <label for="dtHorizontalVerticalExample" class="required form-label">Danh sách liên hệ từ file dữ
                            liệu (Tổng số liên hệ: <strong>{{ count($datas) }}</strong>)</label>
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
                                        <th>Địa chỉ</th>
                                        <th>Phường</th>
                                        <th>Quận</th>
                                        <th>Thành phố</th>
                                        <th>Quốc gia</th>
                                        {{-- <th>Ngày sinh</th> --}}
                                        <th>Thời gian phù hợp</th>
                                        <th>Efc</th>
                                        <th>Target</th>
                                        <th>list</th>
                                        {{-- <th>Ngày tạo</th>
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
                                        <th>lifecycle_stage</th>
                                        <th>lead_status</th>
                                        <th>note sales</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    <!-- Thêm dữ liệu của bạn vào đây -->
                                    @foreach ($datas as $key => $data)
                                        <tr list-control="itemm">
                                            <td class="text-center ps-1">
                                                <div class="form-check form-check-sm form-check-custom">
                                                    <input list-action="check-item" class="form-check-input" type="checkbox"
                                                        value="1" checked />
                                                </div>
                                            </td>

                                            @if (isset($existingContacts[$key]) && !empty($existingContacts[$key]))
                                                <td data-filter="mastercard">
                                                    <span class="badge bg-danger text-white">
                                                        Trùng
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="name{{ $key }}" checked
                                                            value="  {{ $data['name'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['name'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard" duplicate-check="phone"
                                                    value=" {{ $data['phone'] }}">
                                                    <span>
                                                        <input type="radio" name="phone{{ $key }}"
                                                            value=" {{ $data['phone'] }}" checked />
                                                    </span>
                                                    <span>
                                                        {{ $data['phone'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard" duplicate-check="email">
                                                    <span>
                                                        <input type="radio" name="email{{ $key }}" checked
                                                            value=" {{ $data['email'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['email'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="demand{{ $key }}" checked
                                                            value="    {{ $data['demand'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['demand'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="school{{ $key }}" checked
                                                            value=" {{ $data['school'] }}" />
                                                    </span>

                                                    <span>
                                                        {{ $data['school'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="address{{ $key }}" checked
                                                            value=" {{ $data['address'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['address'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="ward{{ $key }}" checked
                                                            value=" {{ $data['ward'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['ward'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="district{{ $key }}" checked
                                                            value="  {{ $data['district'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['district'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="city{{ $key }}" checked
                                                            value="  {{ $data['city'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['city'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="country{{ $key }}" checked
                                                            value=" {{ $data['country'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['country'] }}
                                                    </span>
                                                </td>
                                                {{-- <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="birthday{{ $key }}" checked
                                                            value="{{ $data['birthday'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['birthday'] }}
                                                    </span>
                                                </td> --}}
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="time_to_call{{ $key }}"
                                                            checked value=" {{ $data['time_to_call'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['time_to_call'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="efc{{ $key }}" checked
                                                            value=" {{ $data['efc'] }}" />
                                                    </span>

                                                    <span>
                                                        {{ $data['efc'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="target{{ $key }}" checked
                                                            value="  {{ $data['target'] }}" />
                                                    </span>

                                                    <span>
                                                        {{ $data['target'] }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="list{{ $key }}" checked
                                                            value="  {{ $data['list'] }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data['list'] }}
                                                    </span>
                                                </td>
                                                {{-- <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="date{{ $key }}" checked
                                                            value="   {{ $data->date }}" />
                                                    </span>

                                                    <span>
                                                        {{ $data->date }}
                                                    </span>

                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="source_type{{ $key }}"
                                                            checked value=" {{ $data->source_type }}" />
                                                    </span>

                                                    <span>
                                                        {{ $data->source_type }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="channel{{ $key }}" checked
                                                            value=" {{ $data->channel }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->channel }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="sub_channel{{ $key }}"
                                                            checked value="  {{ $data->sub_channel }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->sub_channel }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="campaign{{ $key }}" checked
                                                            value="  {{ $data->campaign }}" />
                                                    </span>

                                                    <span>
                                                        {{ $data->campaign }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="adset{{ $key }}" checked
                                                            value="   {{ $data->adset }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->adset }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="ads{{ $key }}" checked
                                                            value=" {{ $data->ads }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->ads }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="device{{ $key }}" checked
                                                            value=" {{ $data->device }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->device }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="placement{{ $key }}" checked
                                                            value=" {{ $data->placement }}" />
                                                    </span>

                                                    <span>
                                                        {{ $data->placement }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="term{{ $key }}" checked
                                                            value="   {{ $data->term }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->term }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="type_match{{ $key }}"
                                                            checked value=" {{ $data->type_match }}" />
                                                    </span>

                                                    <span>
                                                        {{ $data->type_match }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="fbclid{{ $key }}" checked
                                                            value="   {{ $data->fbclid }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->fbclid }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="gclid{{ $key }}" checked
                                                            value="   {{ $data->gclid }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->gclid }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="first_url{{ $key }}" checked
                                                            value="{{ $data->first_url }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->first_url }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="last_url{{ $key }}" checked
                                                            value=" {{ $data->last_url }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->last_url }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="contact_owner{{ $key }}"
                                                            checked value=" {{ $data->contact_owner }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->contact_owner }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="lifecycle_stage{{ $key }}"
                                                            checked value=" {{ $data->lifecycle_stage }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->lifecycle_stage }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="lead_status{{ $key }}"
                                                            checked value=" {{ $data->lead_status }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->lead_status }}
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    <span>
                                                        <input type="radio" name="note_sales{{ $key }}"
                                                            checked value=" {{ $data->note_sales }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->note_sales }}
                                                    </span>
                                                </td> --}}
                                            @else
                                                <td data-filter="mastercard">
                                                    <span class="badge bg-success text-white">
                                                        Mới
                                                    </span>
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['name'] }}
                                                </td>
                                                <td data-filter="mastercard" duplicate-check="phone">
                                                    {{ $data['phone'] }}
                                                </td>

                                                <td data-filter="mastercard" duplicate-check="email">
                                                    {{ $data['email'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['demand'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['school'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['address'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['ward'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['district'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['city'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['country'] }}
                                                </td>
                                                {{-- <td data-filter="mastercard">
                                                    {{ $data['birthday'] }}
                                                </td> --}}
                                                <td data-filter="mastercard">
                                                    {{ $data['time_to_call'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['efc'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['target'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['list'] }}
                                                </td>
                                                {{-- <td data-filter="mastercard">
                                                        {{ $data['date'] }}
                                                    </td> --}}
                                                {{-- <td data-filter="mastercard">
                                                    {{ $data['source_type'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['channel'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['sub_channel'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['campaign'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['adset'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['ads'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['device'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['placement'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['term'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['type_match'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['fbclid'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['gclid'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['first_url'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['last_url'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['contact_owner'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['lifecycle_stage'] }}
                                                    w </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['lead_status'] }}
                                                </td>
                                                <td data-filter="mastercard">
                                                    {{ $data['note_sales'] }}
                                                </td> --}}
                                            @endif

                                            {{-- @endif --}}

                                        </tr>
                                        @if (isset($existingContacts[$key]) && !empty($existingContacts[$key]))
                                            <span class="bg-gray-200">
                                                <td colspan="10" class="py-1 small fw-bold">Danh sách liên hệ trùng:
                                                </td>
                                            </span>
                                            @foreach ($existingContacts[$key] as $existingContact)
                                                <tr class="bg-gray-300 text-gray-600" list-control="item">
                                                    <td class="text-center ps-1" colspan="2">
                                                        <select list-action="contact-select{{ $key }}"
                                                            class="form-select" data-allow-clear="true">
                                                            <option value="all" selected>Cùng liên hệ</option>
                                                            <option value="{{ $key }}">Liên hệ khác</option>
                                                        </select>
                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="name{{ $key }}"
                                                                input-radio="{{ $key }}" class="contact-radio"
                                                                value=" {{ $existingContact['name'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['name'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="phone{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['phone'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['phone'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="email{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['email'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['email'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="demand{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="{{ $existingContact['demand'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['demand'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="school{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['school'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['school'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="address{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['address'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['address'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="ward{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['ward'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['ward'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="district{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['district'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['district'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="city{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['city'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['city'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="country{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['country'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['country'] }}
                                                        </span>

                                                    </td>
                                                    {{-- <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="birthday{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['birthday'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['birthday'] }}
                                                        </span>


                                                    </td> --}}
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="time_to_call{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['time_to_call'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['time_to_call'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="efc{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['efc'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['efc'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="target{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['target'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['target'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="list{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['list'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['list'] }}
                                                        </span>

                                                    </td>
                                                    {{-- <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="created_at{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['created_at'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['created_at'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="source_type{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="{{ $existingContact['source_type'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['source_type'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="channel{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="{{ $existingContact['channel'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['channel'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="sub_channel{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="   {{ $existingContact['sub_channel'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['sub_channel'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="campaign{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['campaign'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['campaign'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="adset{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['adset'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['adset'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="ads{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['ads'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['ads'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="device{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['device'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['device'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="placement{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['placement'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['placement'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="term{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="   {{ $existingContact['term'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['term'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="type_match{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['type_match'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['type_match'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="fbcid{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['fbcid'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $existingContact['fbcid'] }}
                                                        </span>

                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="gclid{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['gclid'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['gclid'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="first_url{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['first_url'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['first_url'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="last_url{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['last_url'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['last_url'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio"
                                                                name="contact_owner{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value=" {{ $existingContact['contact_owner'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['contact_owner'] }}
                                                        </span>


                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio"
                                                                name="lifecycle_stage{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="  {{ $existingContact['lifecycle_stage'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['lifecycle_stage'] }}
                                                        </span>



                                                    </td>
                                                    <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="lead_status{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="    {{ $existingContact['lead_status'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['lead_status'] }}
                                                        </span>


                                                    </td> --}}
                                                    {{-- <td data-filter="mastercard">
                                                        <span>
                                                            <input type="radio" name="note_sales{{ $key }}"
                                                                class="contact-radio" input-radio="{{ $key }}"
                                                                value="    {{ $existingContact['note_sales'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $existingContact['note_sales'] }}
                                                        </span>


                                                    </td> --}}

                                                </tr>
                                            @endforeach
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
                                <option></option>
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
            // ContactRequestsList js
            ContactRequestsListInline.init();

            $('[list-action="contact-select"]').change(function() {
                var selectedValue = $(this).val();

                if (selectedValue !== "all") {
                    var key = selectedValue;
                    $('.contact-radio[input-radio^="' + key + '"]').addClass('d-none');
                } else {
                    $('.contact-radio').removeClass('d-none');
                }
            });
        })

        var formEvents = function() {
            let csrfToken;
            var importDatas = function() {
                // Lấy tất cả các hàng trong tbody của bảng
                var table = document.getElementById('dtHorizontalVerticalExample');
                var tbody = table.getElementsByTagName('tbody')[0];
                var rows = tbody.querySelectorAll('tr[list-control="itemm"]');

                // Khởi tạo một mảng để lưu trữ các đối tượng
                let datas = [];

                // Lặp qua từng hàng trong bảng và lấy thông tin từ các cột tương ứng
                for (let i = 0; i < rows.length; i++) {
                    var checkbox = rows[i].querySelector('input[type="checkbox"]');

                    if (checkbox && checkbox.checked) {
                        var columns = rows[i].getElementsByTagName('td');
                        var isDuplicate = columns[1].querySelector('.badge.bg-danger');
                        if (isDuplicate) {

                            var name = document.querySelector('input[name="name' + i + '"]:checked').value;
                            var phone = document.querySelector('input[name="phone' + i + '"]:checked').value;
                            var email = document.querySelector('input[name="email' + i + '"]:checked').value;
                            var demand = document.querySelector('input[name="demand' + i + '"]:checked').value;
                            var school = document.querySelector('input[name="school' + i + '"]:checked').value;
                            var address = document.querySelector('input[name="address' + i + '"]:checked').value;
                            var ward = document.querySelector('input[name="ward' + i + '"]:checked').value;
                            var district = document.querySelector('input[name="district' + i + '"]:checked')
                                .value;
                            var city = document.querySelector('input[name="city' + i + '"]:checked').value;
                            var country = document.querySelector('input[name="country' + i + '"]:checked').value;
                            // var birthday = document.querySelector('input[name="birthday' + i + '"]:checked').value;
                            var time_to_call = document.querySelector('input[name="time_to_call' + i +
                                    '"]:checked')
                                .value;
                            var efc = document.querySelector('input[name="efc' + i + '"]:checked').value;
                            var target = document.querySelector('input[name="target' + i + '"]:checked').value;
                            var list = document.querySelector('input[name="list' + i + '"]:checked').value;
                            // var date = document.querySelector('input[name="date' + i + '"]:checked').value;
                            // var source_type = document.querySelector('input[name="source_type' + i +
                            //         '"]:checked')
                            //     .value;
                            // var channel = document.querySelector('input[name="channel' + i + '"]:checked').value;
                            // var sub_channel = document.querySelector('input[name="sub_channel' + i +
                            //         '"]:checked')
                            //     .value;
                            // var campaign = document.querySelector('input[name="campaign' + i + '"]:checked')
                            //     .value;
                            // var adset = document.querySelector('input[name="adset' + i + '"]:checked').value;
                            // var ads = document.querySelector('input[name="ads' + i + '"]:checked').value;
                            // var device = document.querySelector('input[name="device' + i + '"]:checked').value;
                            // var placement = document.querySelector('input[name="placement' + i + '"]:checked')
                            //     .value;
                            // var term = document.querySelector('input[name="term' + i + '"]:checked').value;
                            // var type_match = document.querySelector('input[name="type_match' + i + '"]:checked')
                            //     .value;
                            // var fbclid = document.querySelector('input[name="fbclid' + i + '"]:checked').value;
                            // var gclid = document.querySelector('input[name="gclid' + i + '"]:checked').value;
                            // var first_url = document.querySelector('input[name="first_url' + i + '"]:checked')
                            //     .value;
                            // var last_url = document.querySelector('input[name="last_url' + i + '"]:checked')
                            //     .value;
                            // var contact_owner = document.querySelector('input[name="contact_owner' + i +
                            //     '"]:checked').value;
                            // var lifecycle_stage = document.querySelector('input[name="lifecycle_stage' + i +
                            //     '"]:checked').value;
                            // var lead_status = document.querySelector('input[name="lead_status' + i +
                            //         '"]:checked')
                            //     .value;
                            // var note_sales = document.querySelector('input[name="note_sales' + i + '"]:checked')
                            //     .value;
                            var selectedValue = document.querySelector('select[list-action="contact-select' + i +
                                    '"]')
                                .value;
                        } else {
                            // Lấy nội dung của từng ô trong hàng
                            var name = columns[2].textContent.trim();
                            var phone = columns[3].textContent.trim();
                            var email = columns[4].textContent.trim();
                            var demand = columns[5].textContent.trim();
                            var school = columns[6].textContent.trim();
                            var address = columns[7].textContent.trim();
                            var ward = columns[8].textContent.trim();
                            var district = columns[9].textContent.trim();
                            var city = columns[10].textContent.trim();
                            var country = columns[11].textContent.trim();
                            // var birthday = columns[12].textContent.trim();
                            var time_to_call = columns[12].textContent.trim();
                            var efc = columns[13].textContent.trim();
                            var target = columns[14].textContent.trim();
                            var list = columns[15].textContent.trim();
                            // var date = columns[17].textContent.trim();
                            // var source_type = columns[18].textContent.trim();
                            // var channel = columns[19].textContent.trim();
                            // var sub_channel = columns[20].textContent.trim();
                            // var campaign = columns[21].textContent.trim();
                            // var adset = columns[22].textContent.trim();
                            // var ads = columns[23].textContent.trim();
                            // var device = columns[24].textContent.trim();
                            // var placement = columns[25].textContent.trim();
                            // var term = columns[26].textContent.trim();
                            // var type_match = columns[27].textContent.trim();
                            // var fbclid = columns[28].textContent.trim();
                            // var gclid = columns[29].textContent.trim();
                            // var first_url = columns[30].textContent.trim();
                            // var last_url = columns[31].textContent.trim();
                            // var contact_owner = columns[32].textContent.trim();
                            // var lifecycle_stage = columns[33].textContent.trim();
                            // var lead_status = columns[34].textContent.trim();
                            // var note_sales = columns[35].textContent.trim();
                            var selectedValue = '';

                        };

                        var obj = {
                            name: name,
                            phone: phone,
                            email: email,
                            demand: demand,
                            school: school,
                            address: address,
                            ward: ward,
                            district: district,
                            city: city,
                            country: country,
                            // birthday: birthday,
                            time_to_call: time_to_call,
                            efc: efc,
                            target: target,
                            list: list,
                            // date: date,
                            // source_type: source_type,
                            // channel: channel,
                            // sub_channel: sub_channel,
                            // campaign: campaign,
                            // adset: adset,
                            // ads: ads,
                            // device: device,
                            // placement: placement,
                            // term: term,
                            // type_match: type_match,
                            // fbclid: fbclid,
                            // gclid: gclid,
                            // first_url: first_url,
                            // last_url: last_url,
                            // contact_owner: contact_owner,
                            // lifecycle_stage: lifecycle_stage,
                            // lead_status: lead_status,
                            // note_sales: note_sales,
                        };
                        if (selectedValue) {
                            obj.selectedValue = selectedValue;
                        }
                        datas.push(obj);
                    }
                }

                // Hiển thị kết quả: log cả mảng data trong một lần
                return datas // Data getted form server (From excel file user fill)
            };

            return {
                init: () => {
                    csrfToken = document.querySelector('input[name="_token"]').value;
                    document.querySelector('#kt_modal_upload_form').addEventListener('submit', e => {
                        e.preventDefault();

                        var datas = importDatas();
                        var element = document.querySelector("#account-select-import-excel");
                        var accountId = element ? element.value : null;
                        ExcelPopup.updateUrlSaveDatas(
                            "{{ action('\App\Http\Controllers\HubSpotController@importHubSpotRunning') }}",
                            'POST', csrfToken, {
                                excelDatas: datas,
                                accountId: accountId
                            });
                        TokenHubSpotPopup.getPopup().hide();
                    })
                }
            }
        }();
        var ContactRequestsListInline = function() {
            return {
                init: function() {

                    // Email inline edit
                    document.querySelectorAll('[list-control="email-inline-edit"]').forEach(control => {
                        var url = control.getAttribute('data-url');
                        var emailInlineEdit = new EmailInlineEdit({
                            container: control,
                            url: url,
                        });
                    });

                    //Phone inline edit
                    document.querySelectorAll('[list-control="phone-inline-edit"]').forEach(control => {
                        var url = control.getAttribute('data-url');
                        var phoneInlineEdit = new PhoneInlineEdit({
                            container: control,
                            url: url,
                        });
                    });


                }
            };
        }();
        var EmailInlineEdit = class {
            constructor(options) {
                this.container = options.container;
                this.saveUrl = options.url;

                //
                this.events();
            }

            getEditButtonEmail() {
                return this.container.querySelector('[inline-control="edit-button-email"]');
            }
            hideEditButtonEmail() {
                this.getEditButtonEmail().style.display = 'none';
            }
            showEditButtonEmail() {
                this.getEditButtonEmail().style.display = 'inline-block';
            }

            getFormBoxEditEmail() {
                return this.container.querySelector('[inline-control="form-edit-email"]');
            }
            showFormBoxEditEmail() {
                this.getFormBoxEditEmail().style.display = 'inline-block';
            }
            hideFormBoxEditEmail() {
                this.getFormBoxEditEmail().style.display = 'none';
            }

            getDataContainerEmail() {
                return this.container.querySelector('[inline-control="data-email"]')
            }

            hideDataContainerEmail() {
                this.getDataContainerEmail().style.display = 'none';
            }

            showDataContainerEmail() {
                this.getDataContainerEmail().style.display = 'inline-block';
            }

            updateEmail(email) {
                this.getDataContainerEmail().innerHTML = email;
            }

            getInputControlEditEmail() {
                return this.container.querySelector('[inline-control="input-edit-email"]');
            }

            getCloseButtonEmail() {
                return this.container.querySelector('[inline-control="close-button-email"]');
            }

            // getEmail() {
            //     return this.getInputControlEditEmail().value;
            // }

            getDoneButtonEmail() {
                return this.container.querySelector('[inline-control="done-button-email"]');
            }

            save(afterSave) {
                var _this = this;
                _this.updateEmail(this.getInputControlEditEmail().value);
                if (typeof(afterSave) !== 'undefined') {
                    afterSave();
                }
            }

            setEditEmail() {
                this.showFormBoxEditEmail();
                this.hideDataContainerEmail();
                this.hideEditButtonEmail();
            }

            closeEditEmail() {
                this.hideFormBoxEditEmail();
                this.showDataContainerEmail();
                this.showEditButtonEmail();
            }

            events() {
                var _this = this;

                //click
                this.getEditButtonEmail().addEventListener('click', (e) => {
                    this.setEditEmail();
                })

                // close
                this.getCloseButtonEmail().addEventListener('click', (e) => {
                    this.closeEditEmail();
                });

                // Click để lưu thay đổi
                $(this.getDoneButtonEmail()).on('click', (e) => {
                    this.save(function() {
                        //
                        ASTool.alert({
                            message: 'Đã cập nhật email thành công!',
                            ok: function() {
                                // close box
                                _this.closeEditEmail();
                            }
                        });
                    });
                });
            }
        };
    </script>
@endsection
