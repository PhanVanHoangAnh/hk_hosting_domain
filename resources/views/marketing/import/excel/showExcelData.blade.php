@extends('layouts.main.popup', [
    'size' => 'full',
])
@section('title')
    Nhập dữ liệu liên hệ từ file excel
@endsection
@section('content')
    <style>
        .scrollable-table-excel {
            overflow: scroll;
            max-height: 400px;
        }

        #dtHorizontalVerticalExample {
            border-collapse: collapse;
        }

        #dtHorizontalVerticalExample th,
        #dtHorizontalVerticalExample td {
            padding: 8px 16px;
            border: 1px solid #ddd;
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

    <form class="form" id="kt_modal_upload_form_show">
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
                            liệu (Trang <strong class="fs-2">{{ App\Helpers\Functions::formatNumber($currentPage) }}</strong>/<strong class="fs-2">{{ App\Helpers\Functions::formatNumber($totalPage) }}</strong>. 
                            Liên hệ từ <strong class="fs-2">{{ App\Helpers\Functions::formatNumber($offset+1) }}</strong> -> <strong class="fs-2">{{ App\Helpers\Functions::formatNumber($offset + $perPage) }}</strong>.
                            Tổng số liên hệ: <strong class="fs-2">{{ App\Helpers\Functions::formatNumber($total) }}</strong>)</label>
                        <div class="scrollable-table-excel">


                            <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm "
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        {{-- <th>Thao tác</th> --}}
                                        {{-- @php
                                            $isEmptyArrays = false;
                                            if (isset($coincideContacts) && is_array($coincideContacts)) {
                                                $isEmptyArrays =
                                                    count(
                                                        array_filter($coincideContacts, function ($item) {
                                                            return !empty($item);
                                                        }),
                                                    ) === 0;
                                            }
                                        @endphp

                                        @if (isset($coincideContacts) && !empty($coincideContacts) && $coincideContacts !== null && !$isEmptyArrays)
                                            <th>Trạng thái</th>
                                        @endif --}}
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
                                        <th class="d-none">Ngày sinh</th>
                                        <th>Thời gian phù hợp</th>
                                        <th>Efc</th>
                                        <th>Target</th>
                                        <th>list</th>
                                        <th>Ngày tạo</th>
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
                                        <th>note sales</th>
                                    </tr>
                                </thead>
                                <tbody class="fw-semibold text-gray-600">
                                    <!-- Thêm dữ liệu của bạn vào đây -->
                                    @foreach ($datas as $key => $data)
                                        <tr list-control="itemm">
                                            <td class="text-center ps-1 d-none">
                                                <div class="form-check form-check-sm form-check-custom">
                                                    <input list-action="check-item" class="form-check-input" type="checkbox"
                                                        value="1" checked />
                                                </div>
                                            </td>

                                            @if (isset($coincideContacts[$key]) && !empty($coincideContacts[$key]))
                                                <td class="text-center">
                                                    <span class="badge bg-danger text-white">
                                                        Trùng
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="name"
                                                            value="  {{ $data->name }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->name }}
                                                    </span>
                                                </td>
                                                <td duplicate-check="phone"
                                                    value=" {{ $data->displayPhoneNumberByUser(Auth::user()) }}">
                                                    <span>
                                                        <input name="phone"  
                                                            value=" {{ $data->displayPhoneNumberByUser(Auth::user()) }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->displayPhoneNumberByUser(Auth::user()) }}
                                                    </span>
                                                </td>
                                                <td duplicate-check="email">
                                                    <span>
                                                        <input name="email" 
                                                            value=" {{ $data->email }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->email }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="demand" 
                                                            value="    {{ $data->demand }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->demand }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="school" 
                                                            value=" {{ $data->school }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->school }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="address" 
                                                            value=" {{ $data->address }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->address }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="ward" 
                                                            value=" {{ $data->ward }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->ward }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="district" 
                                                            value="  {{ $data->district }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->district }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="city" 
                                                            value="  {{ $data->city }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->city }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="country" 
                                                            value=" {{ $data->country }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->country }}
                                                    </span>
                                                </td>
                                                <td class="d-none">
                                                    <span>
                                                        <input name="birthday" 
                                                            value="{{ $data->birthday }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->birthday ? date('d/m/Y', strtotime($data->birthday)) : '--' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="time_to_call" 
                                                            value=" {{ $data->time_to_call }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->time_to_call }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="efc" 
                                                            value=" {{ $data->efc }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->efc }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="target" 
                                                            value="  {{ $data->target }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->target }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="list" 
                                                            value="  {{ $data->list }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->list }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="date" 
                                                            value="   {{ $data->date }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->date }}
                                                    </span>

                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="source_type" 
                                                            value=" {{ $data->source_type }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->source_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="channel" 
                                                            value=" {{ $data->channel }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->channel }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="sub_channel" 
                                                            value="  {{ $data->sub_channel }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->sub_channel }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="campaign" 
                                                            value="  {{ $data->campaign }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->campaign }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="adset" 
                                                            value="   {{ $data->adset }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->adset }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="ads" 
                                                            value=" {{ $data->ads }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->ads }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="device" 
                                                            value=" {{ $data->device }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->device }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="placement" 
                                                            value=" {{ $data->placement }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->placement }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="term" 
                                                            value="   {{ $data->term }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->term }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="type_match" 
                                                            value=" {{ $data->type_match }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->type_match }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="fbclid" 
                                                            value="   {{ $data->fbclid }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->fbclid }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="gclid" 
                                                            value="   {{ $data->gclid }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->gclid }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="first_url" 
                                                            value="{{ $data->first_url }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->first_url }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="last_url" 
                                                            value=" {{ $data->last_url }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->last_url }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="contact_owner" 
                                                            value=" {{ $data->contact_owner }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->contact_owner }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="lifecycle_stage" 
                                                            value=" {{ $data->lifecycle_stage }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->lifecycle_stage }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="lead_status" 
                                                            value=" {{ $data->lead_status }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->lead_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="note_sales" 
                                                            value=" {{ $data->note_sales }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->note_sales }}
                                                    </span>
                                                </td>
                                            @elseif (isset($existingContacts[$key]) && !empty($existingContacts[$key]))
                                                <td class="text-center">
                                                    <span class="badge bg-success update text-white">
                                                        Đơn hàng mới 
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="name" 
                                                            value="  {{ $data->name }}" />
                                                    </span>
                                                    <span>
                                                        {{ $data->name }}
                                                    </span>
                                                </td>
                                                <td duplicate-check="phone"
                                                    value=" {{ $data->displayPhoneNumberByUser(Auth::user()) }}">
                                                    <span>
                                                        <input name="phone" 
                                                            value=" {{ $data->displayPhoneNumberByUser(Auth::user()) }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->displayPhoneNumberByUser(Auth::user()) }}
                                                    </span>
                                                </td>
                                                <td duplicate-check="email">
                                                    <span>
                                                        <input name="email" 
                                                            value=" {{ $data->email }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->email }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="demand" 
                                                            value="    {{ $data->demand }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->demand }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="school" 
                                                            value=" {{ $data->school }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->school }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="address" 
                                                            value=" {{ $data->address }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->address }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="ward" 
                                                            value=" {{ $data->ward }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->ward }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="district" 
                                                            value="  {{ $data->district }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->district }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="city" 
                                                            value="  {{ $data->city }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->city }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="country" 
                                                            value=" {{ $data->country }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->country }}
                                                    </span>
                                                </td>
                                                <td class="d-none">
                                                    <span>
                                                        <input name="birthday" 
                                                            value="{{ $data->birthday }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->birthday ? date('d/m/Y', strtotime($data->birthday)) : '--' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="time_to_call" 
                                                            value=" {{ $data->time_to_call }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->time_to_call }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="efc" 
                                                            value=" {{ $data->efc }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->efc }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="target" 
                                                            value="  {{ $data->target }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->target }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="list" 
                                                            value="  {{ $data->list }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->list }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="date" 
                                                            value="   {{ $data->date }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->date }}
                                                    </span>

                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="source_type" 
                                                            value=" {{ $data->source_type }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->source_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="channel" 
                                                            value=" {{ $data->channel }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->channel }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="sub_channel" 
                                                            value="  {{ $data->sub_channel }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->sub_channel }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="campaign" 
                                                            value="  {{ $data->campaign }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->campaign }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="adset" 
                                                            value="   {{ $data->adset }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->adset }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="ads" 
                                                            value=" {{ $data->ads }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->ads }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="device" 
                                                            value=" {{ $data->device }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->device }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="placement" 
                                                            value=" {{ $data->placement }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->placement }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="term" 
                                                            value="   {{ $data->term }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->term }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="type_match" 
                                                            value=" {{ $data->type_match }}" readonly/>
                                                    </span>

                                                    <span>
                                                        {{ $data->type_match }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="fbclid" 
                                                            value="   {{ $data->fbclid }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->fbclid }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="gclid" 
                                                            value="   {{ $data->gclid }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->gclid }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="first_url" 
                                                            value="{{ $data->first_url }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->first_url }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="last_url" 
                                                            value=" {{ $data->last_url }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->last_url }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="contact_owner" 
                                                            value=" {{ $data->contact_owner }}" readonly/>
                                                    </span>
                                                    <span>
                                                        {{ $data->contact_owner }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="lifecycle_stage" 
                                                            value=" {{ $data->lifecycle_stage }}"readonly />
                                                    </span>
                                                    <span>
                                                        {{ $data->lifecycle_stage }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="lead_status" 
                                                            value=" {{ $data->lead_status }}"readonly />
                                                    </span>
                                                    <span>
                                                        {{ $data->lead_status }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span>
                                                        <input name="note_sales" 
                                                            value=" {{ $data->note_sales }}"readonly />
                                                    </span>
                                                    <span>
                                                        {{ $data->note_sales }}
                                                    </span>
                                                </td>
                                            @else
                                                <td class="text-center">
                                                    <span class="badge bg-success text-white">
                                                        Đơn hàng mới
                                                    </span>
                                                </td>
                                                <td>
                                                    {{ $data->name }}
                                                </td>
                                                <td duplicate-check="phone"
                                                    value=" {{ $data->displayPhoneNumberByUser(Auth::user()) }}">
                                                    {{ $data->displayPhoneNumberByUser(Auth::user()) }}
                                                </td>

                                                <td duplicate-check="email">
                                                    {{ $data->email }}
                                                </td>
                                                <td>
                                                    {{ $data->demand }}
                                                </td>
                                                <td>
                                                    {{ $data->school }}
                                                </td>
                                                <td>
                                                    {{ $data->address }}
                                                </td>
                                                <td>
                                                    {{ $data->ward }}
                                                </td>
                                                <td>
                                                    {{ $data->district }}
                                                </td>
                                                <td>
                                                    {{ $data->city }}
                                                </td>
                                                <td>
                                                    {{ $data->country }}
                                                </td>
                                                <td class="d-none">
                                                    {{ $data->birthday ? date('d/m/Y', strtotime($data->birthday)) : '--' }}
                                                </td>
                                                <td>
                                                    {{ $data->time_to_call }}
                                                </td>
                                                <td>
                                                    {{ $data->efc }}
                                                </td>
                                                <td>
                                                    {{ $data->target }}
                                                </td>
                                                <td>
                                                    {{ $data->list }}
                                                </td>
                                                <td>
                                                    {{ $data->date }}
                                                </td>
                                                <td>
                                                    {{ $data->source_type }}
                                                </td>
                                                <td>
                                                    {{ $data->channel }}
                                                </td>
                                                <td>
                                                    {{ $data->sub_channel }}
                                                </td>
                                                <td>
                                                    {{ $data->campaign }}
                                                </td>
                                                <td>
                                                    {{ $data->adset }}
                                                </td>
                                                <td>
                                                    {{ $data->ads }}
                                                </td>
                                                <td>
                                                    {{ $data->device }}
                                                </td>
                                                <td>
                                                    {{ $data->placement }}
                                                </td>
                                                <td>
                                                    {{ $data->term }}
                                                </td>
                                                <td>
                                                    {{ $data->type_match }}
                                                </td>
                                                <td>
                                                    {{ $data->fbclid }}
                                                </td>
                                                <td>
                                                    {{ $data->gclid }}
                                                </td>
                                                <td>
                                                    {{ $data->first_url }}
                                                </td>
                                                <td>
                                                    {{ $data->last_url }}
                                                </td>
                                                <td>
                                                    {{ $data->contact_owner }}
                                                </td>
                                                <td>
                                                    {{ $data->lifecycle_stage }}
                                                </td>
                                                <td>
                                                    {{ $data->lead_status }}
                                                </td>
                                                <td>
                                                    {{ $data->note_sales }}
                                                </td>
                                            @endif

                                            {{-- @endif --}}

                                        </tr>
                                        @if (isset($coincideContacts[$key]) && !empty($coincideContacts[$key]))
                                            <span class="bg-gray-200" class="">
                                                <td colspan="10" class="py-1 small fw-bold text-danger">Danh sách liên
                                                    hệ trùng:
                                                </td>
                                            </span>
                                            @foreach ($coincideContacts[$key] as $coincideContact)
                                                <tr class="bg-gray-300 text-gray-600" list-control="item">
                                                    {{-- <td class="text-center ps-1" colspan="2">
                                                        <select list-action="contact-select" 
                                                            class="form-select" data-allow-clear="true">
                                                            <option value="all" selected>Cùng liên hệ</option>
                                                            <option value="" >Liên hệ khác</option>
                                                        </select>
                                                    </td> --}}
                                                    <td class="text-center text-danger">
                                                        <span class="material-symbols-rounded">
                                                            error
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="name"  class="contact-radio"
                                                                value=" {{ $coincideContact['name'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['name'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="phone"  class="contact-radio"
                                                                value=" {{ $coincideContact['phone'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['phone'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="email"  class="contact-radio"
                                                                value=" {{ $coincideContact['email'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['email'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="demand" 
                                                                class="contact-radio"
                                                                value="{{ $coincideContact['demand'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['demand'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="school" 
                                                                class="contact-radio"
                                                                value=" {{ $coincideContact['school'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['school'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="address" 
                                                                class="contact-radio"
                                                                value="  {{ $coincideContact['address'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['address'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="ward"  class="contact-radio"
                                                                value="  {{ $coincideContact['ward'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['ward'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="district" 
                                                                class="contact-radio"
                                                                value="  {{ $coincideContact['district'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['district'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="city"  class="contact-radio"
                                                                value="  {{ $coincideContact['city'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['city'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="country" 
                                                                class="contact-radio"
                                                                value="  {{ $coincideContact['country'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['country'] }}
                                                        </span>

                                                    </td>
                                                    <td class="d-none">
                                                        <span>
                                                            <input name="birthday" 
                                                                class="contact-radio"
                                                                value="  {{ $coincideContact['birthday'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['birthday'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="time_to_call" 
                                                                class="contact-radio"
                                                                value=" {{ $coincideContact['time_to_call'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['time_to_call'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="efc"  class="contact-radio"
                                                                value="  {{ $coincideContact['efc'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['efc'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="target" 
                                                                class="contact-radio"
                                                                value=" {{ $coincideContact['target'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['target'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="list"  class="contact-radio"
                                                                value=" {{ $coincideContact['list'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['list'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="created_at" 
                                                                class="contact-radio"
                                                                value=" {{ $coincideContact['created_at'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['created_at'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="source_type" 
                                                                class="contact-radio"
                                                                value="{{ $coincideContact['source_type'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['source_type'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="channel" 
                                                                class="contact-radio"
                                                                value="{{ $coincideContact['channel'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['channel'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="sub_channel" 
                                                                class="contact-radio"
                                                                value="   {{ $coincideContact['sub_channel'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['sub_channel'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="campaign" 
                                                                class="contact-radio"
                                                                value=" {{ $coincideContact['campaign'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['campaign'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="adset"  class="contact-radio"
                                                                value="  {{ $coincideContact['adset'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['adset'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="ads"  class="contact-radio"
                                                                value=" {{ $coincideContact['ads'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['ads'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="device" 
                                                                class="contact-radio"
                                                                value=" {{ $coincideContact['device'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['device'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="placement" 
                                                                class="contact-radio"
                                                                value=" {{ $coincideContact['placement'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['placement'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="term"  class="contact-radio"
                                                                value="   {{ $coincideContact['term'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['term'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="type_match" 
                                                                class="contact-radio"
                                                                value="  {{ $coincideContact['type_match'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['type_match'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="fbcid"  class="contact-radio"
                                                                value=" {{ $coincideContact['fbcid'] }}" />
                                                        </span>

                                                        <span>
                                                            {{ $coincideContact['fbcid'] }}
                                                        </span>

                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="gclid"  class="contact-radio"
                                                                value="  {{ $coincideContact['gclid'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['gclid'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="first_url" 
                                                                class="contact-radio"
                                                                value=" {{ $coincideContact['first_url'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['first_url'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="last_url" 
                                                                class="contact-radio"
                                                                value="  {{ $coincideContact['last_url'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['last_url'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="contact_owner" 
                                                                class="contact-radio"
                                                                value=" {{ $coincideContact['contact_owner'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['contact_owner'] }}
                                                        </span>


                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="lifecycle_stage" 
                                                                class="contact-radio"
                                                                value="  {{ $coincideContact['lifecycle_stage'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['lifecycle_stage'] }}
                                                        </span>



                                                    </td>
                                                    <td>
                                                        <span>
                                                            <input name="lead_status" 
                                                                class="contact-radio"
                                                                value="    {{ $coincideContact['lead_status'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['lead_status'] }}
                                                        </span>


                                                    </td>
                                                    {{-- <td>
                                                        <span>
                                                            <input type="radio" name="note_sales" 
                                                                class="contact-radio" 
                                                                value="    {{ $coincideContact['note_sales'] }}" />
                                                        </span>
                                                        <span>
                                                            {{ $coincideContact['note_sales'] }}
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
                    <div class="d-none">
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
                    {{-- <div>
                        <button id="confirmAndSaveDataBtn" class="btn btn-primary">Xác nhận & nhập dữ liệu</button>
                    </div> --}}
                    {{-- <div class="row">
                        <div class=""></div>
                        <div class="col-4"><button id="confirmAndSaveDataBtn" class="btn btn-primary">Xác nhận & nhập dữ liệu</button></div>
                        <div class="col-4"><button id="confirmAndSaveDataBtn" class="btn btn-primary">Xác nhận & nhập dữ liệu</button></div>

                        <div class="col-4"><button id="confirmAndSaveDataBtn" class="btn btn-primary">Xác nhận & nhập dữ liệu</button></div>

                    </div> --}}
                    
                    <!--end::Items-->
                </div>
                <!--end::Dropzone-->
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Modal body-->
    </form>
    <div class="d-flex flex-row-reverse bd-highlight mb-3 me-3">
        <div class="p-2  bd-highlight"><button id="saveAllData" class="btn btn-primary">Tạo mới nếu trùng thì cập nhật </button></div>
        <div class="p-2 bd-highlight"><button id="justCreateNew" class="btn btn-primary">Chỉ tạo mới nếu trùng bỏ qua</button></div>
        <div class="p-2 bd-highlight"><button id="updateData" class="btn btn-primary">Chỉ Cập nhật cái trùng</button></div>
      </div>
    <script>
        $(() => {
            formEvents.init();
            // ContactRequestsList js
            ContactRequestsListInline.init();
          
            datasManager = new DatasManager({
                container: document.querySelector('#kt_modal_upload_form_show'),
            });
        })

        var DatasManager = class {
            constructor(options) {
                this.container = options.container;
                this.events();
            };
            getContactSelections() {
                return this.container.querySelectorAll('[list-action="contact-select"]')
            };
            setContactSelections() {
                return this.getContactSelections().value;
            };
            events() {
                var _this = this;
                $('[list-action="contact-select"]').change(function() {
                    var selections = _this.getContactSelections();
                    if (this.setContactSelections()) {
                        $('.contact-radio[input-radio^="' + this.setContactSelections() + '"]').addClass(
                            'd-none');
                    } else {
                        $('.contact-radio').removeClass('d-none');
                    }
                })
            }

        };

        var formEvents = function() {
            let csrfToken;
            var importDatas = function() {
                // Lấy tất cả các hàng trong tbody của bảng
                var table = document.getElementById('dtHorizontalVerticalExample');
                var tbody = table.getElementsByTagName('tbody')[0];
                var rows = tbody.querySelectorAll('tr[list-control="itemm"]');

                var counting = $('[data-control="mask-counting"]');
                counting.html('0/'+rows.length);

                // Khởi tạo một mảng để lưu trữ các đối tượng
                let datas = [];

                // Lặp qua từng hàng trong bảng và lấy thông tin từ các cột tương ứng
                for (let i = 0; i < rows.length; i++) {
                    var checkbox = rows[i].querySelector('input[type="checkbox"]');
                    
                    if (checkbox && checkbox.checked) {
                        var columns = rows[i].getElementsByTagName('td');
                        var isDuplicate = columns[1].querySelector('.badge.bg-success.update');
                        var isCoincide = columns[1].querySelector('.badge.bg-danger');

                        
                     
                        if (isDuplicate) {
                            var formdata = $(rows[i]).find(':input').serializeArray();
                            var data = {};
                            $(formdata ).each(function(index, obj){
                                data[obj.name] = obj.value;
                            });
                            
                            // var name = document.querySelector('input[name="name' + i + '"]').value;
                            // var phone = document.querySelector('input[name="phone' + i + '"]').value;
                            // var email = document.querySelector('input[name="email' + i + '"]').value;
                            // var demand = document.querySelector('input[name="demand' + i + '"]').value;
                            // var school = document.querySelector('input[name="school' + i + '"]').value;
                            // var address = document.querySelector('input[name="address' + i + '"]').value;
                            // var ward = document.querySelector('input[name="ward' + i + '"]').value;
                            // var district = document.querySelector('input[name="district' + i + '"]')
                            //     .value;
                            // var city = document.querySelector('input[name="city' + i + '"]').value;
                            // var country = document.querySelector('input[name="country' + i + '"]').value;
                            // var birthday = document.querySelector('input[name="birthday' + i + '"]').value;
                            // var time_to_call = document.querySelector('input[name="time_to_call' + i +
                            //         '"]')
                            //     .value;
                            // var efc = document.querySelector('input[name="efc' + i + '"]').value;
                            // var target = document.querySelector('input[name="target' + i + '"]').value;
                            // var list = document.querySelector('input[name="list' + i + '"]').value;
                            // var date = document.querySelector('input[name="date' + i + '"]').value;
                            // var source_type = document.querySelector('input[name="source_type' + i +
                            //         '"]')
                            //     .value;
                            // var channel = document.querySelector('input[name="channel' + i + '"]').value;
                            // var sub_channel = document.querySelector('input[name="sub_channel' + i +
                            //         '"]')
                            //     .value;
                            // var campaign = document.querySelector('input[name="campaign' + i + '"]')
                            //     .value;
                            // var adset = document.querySelector('input[name="adset' + i + '"]').value;
                            // var ads = document.querySelector('input[name="ads' + i + '"]').value;
                            // var device = document.querySelector('input[name="device' + i + '"]').value;
                            // var placement = document.querySelector('input[name="placement' + i + '"]')
                            //     .value;
                            // var term = document.querySelector('input[name="term' + i + '"]').value;
                            // var type_match = document.querySelector('input[name="type_match' + i + '"]')
                            //     .value;
                            // var fbclid = document.querySelector('input[name="fbclid' + i + '"]').value;
                            // var gclid = document.querySelector('input[name="gclid' + i + '"]').value;
                            // var first_url = document.querySelector('input[name="first_url' + i + '"]')
                            //     .value;
                            // var last_url = document.querySelector('input[name="last_url' + i + '"]')
                            //     .value;
                            // var contact_owner = document.querySelector('input[name="contact_owner' + i +
                            //     '"]').value;
                            // var lifecycle_stage = document.querySelector('input[name="lifecycle_stage' + i +
                            //     '"]').value;
                            // var lead_status = document.querySelector('input[name="lead_status' + i +
                            //         '"]')
                            //     .value;
                            // var note_sales = document.querySelector('input[name="note_sales' + i + '"]')
                            //     .value;
                            data.selectedValue = 'all';

                            var obj = data;

                        } else if (isCoincide) {
                            // Lấy nội dung của từng ô trong hàng
                            var name = columns[2].textContent.trim() == '' ? 'Không có trường tên' : columns[2].textContent.trim();
                            var phone = columns[3].textContent.trim();
                            var email = columns[4].textContent.trim();
                            var demand = columns[5].textContent.trim();
                            var school = columns[6].textContent.trim();
                            var address = columns[7].textContent.trim();
                            var ward = columns[8].textContent.trim();
                            var district = columns[9].textContent.trim();
                            var city = columns[10].textContent.trim();
                            var country = columns[11].textContent.trim();
                            var birthday = columns[12].textContent.trim();
                            var time_to_call = columns[13].textContent.trim();
                            var efc = columns[14].textContent.trim();
                            var target = columns[15].textContent.trim();
                            var list = columns[16].textContent.trim();
                            var date = columns[17].textContent.trim();
                            var source_type = columns[18].textContent.trim();
                            var channel = columns[19].textContent.trim();
                            var sub_channel = columns[20].textContent.trim();
                            var campaign = columns[21].textContent.trim();
                            var adset = columns[22].textContent.trim();
                            var ads = columns[23].textContent.trim();
                            var device = columns[24].textContent.trim();
                            var placement = columns[25].textContent.trim();
                            var term = columns[26].textContent.trim();
                            var type_match = columns[27].textContent.trim();
                            var fbclid = columns[28].textContent.trim();
                            var gclid = columns[29].textContent.trim();
                            var first_url = columns[30].textContent.trim();
                            var last_url = columns[31].textContent.trim();
                            var contact_owner = columns[32].textContent.trim();
                            var lifecycle_stage = columns[33].textContent.trim();
                            var lead_status = columns[34].textContent.trim();
                            var note_sales = columns[35].textContent.trim();
                            var selectedValue = 'isCoincide';
                           
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
                                birthday: birthday,
                                time_to_call: time_to_call,
                                efc: efc,
                                target: target,
                                list: list,
                                date: date,
                                source_type: source_type,
                                channel: channel,
                                sub_channel: sub_channel,
                                campaign: campaign,
                                adset: adset,
                                ads: ads,
                                device: device,
                                placement: placement,
                                term: term,
                                type_match: type_match,
                                fbclid: fbclid,
                                gclid: gclid,
                                first_url: first_url,
                                last_url: last_url,
                                contact_owner: contact_owner,
                                lifecycle_stage: lifecycle_stage,
                                lead_status: lead_status,
                                note_sales: note_sales,
                            };
                        } else {
                           
                            var name = columns[2].textContent.trim() == '' ? 'Không có trường tên' : columns[2].textContent.trim();
                            var phone = columns[3].textContent.trim();
                            var email = columns[4].textContent.trim();
                            var demand = columns[5].textContent.trim();
                            var school = columns[6].textContent.trim();
                            var address = columns[7].textContent.trim();
                            var ward = columns[8].textContent.trim();
                            var district = columns[9].textContent.trim();
                            var city = columns[10].textContent.trim();
                            var country = columns[11].textContent.trim();
                            var birthday = columns[12].textContent.trim();
                            var time_to_call = columns[13].textContent.trim();
                            var efc = columns[14].textContent.trim();
                            var target = columns[15].textContent.trim();
                            var list = columns[16].textContent.trim();
                            var date = columns[17].textContent.trim();
                            var source_type = columns[18].textContent.trim();
                            var channel = columns[19].textContent.trim();
                            var sub_channel = columns[20].textContent.trim();
                            var campaign = columns[21].textContent.trim();
                            var adset = columns[22].textContent.trim();
                            var ads = columns[23].textContent.trim();
                            var device = columns[24].textContent.trim();
                            var placement = columns[25].textContent.trim();
                            var term = columns[26].textContent.trim();
                            var type_match = columns[27].textContent.trim();
                            var fbclid = columns[28].textContent.trim();
                            var gclid = columns[29].textContent.trim();
                            var first_url = columns[30].textContent.trim();
                            var last_url = columns[31].textContent.trim();
                            var contact_owner = columns[32].textContent.trim();
                            var lifecycle_stage = columns[33].textContent.trim();
                            var lead_status = columns[34].textContent.trim();
                            var note_sales = columns[35].textContent.trim();
                            var selectedValue = '';

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
                                birthday: birthday,
                                time_to_call: time_to_call,
                                efc: efc,
                                target: target,
                                list: list,
                                date: date,
                                source_type: source_type,
                                channel: channel,
                                sub_channel: sub_channel,
                                campaign: campaign,
                                adset: adset,
                                ads: ads,
                                device: device,
                                placement: placement,
                                term: term,
                                type_match: type_match,
                                fbclid: fbclid,
                                gclid: gclid,
                                first_url: first_url,
                                last_url: last_url,
                                contact_owner: contact_owner,
                                lifecycle_stage: lifecycle_stage,
                                lead_status: lead_status,
                                note_sales: note_sales,
                            };
                        };

                        
                        if (selectedValue) {
                            obj.selectedValue = selectedValue;
                        }
                        datas.push(obj);

                        counting.html(i + '/' + rows.length);
                    }
                }
                // Hiển thị kết quả: log cả mảng data trong một lần
                return datas // Data getted form server (From excel file user fill)

            };
            return {
                init: () => {
                    csrfToken = '{{ csrf_token() }}';
                    document.querySelector('#justCreateNew').addEventListener('click', () => {
                        // e.preventDefault();
                        addMaskLoading('Đang xử lý dữ liệu <span data-control="mask-counting"></span>');

                        setTimeout(() => {
                            var datas = importDatas();
                            addMaskLoading('Đang nhập dữ liệu. Vui lòng chờ...');
                            ExcelPopup.updateUrlSaveDatas(
                                "{{ action('\App\Http\Controllers\Marketing\ContactController@importExcelRunning') }}",
                                'POST', csrfToken, {
                                    type:'justCreateNew',
                                    excelDatas: datas,
                                    current_page: {{ $currentPage }},
                                    total_page: {{ $totalPage }},
                                    path: '{{ $path }}',
                                    accountId: document.querySelector("#account-select-import-excel")
                                        .value // ID account selected 
                                });
                        }, 500);
                            
                    });
                    document.querySelector('#saveAllData').addEventListener('click', () => {
                        // e.preventDefault();
                        addMaskLoading('Đang xử lý dữ liệu <span data-control="mask-counting"></span>');

                        setTimeout(() => {
                            var datas = importDatas();
                            addMaskLoading('Đang nhập dữ liệu. Vui lòng chờ...');
                            ExcelPopup.updateUrlSaveDatas(
                                "{{ action('\App\Http\Controllers\Marketing\ContactController@importExcelRunning') }}",
                                'POST', csrfToken, {
                                    type:'saveAllData',
                                    excelDatas: datas,
                                    current_page: {{ $currentPage }},
                                    total_page: {{ $totalPage }},
                                    path: '{{ $path }}',
                                    accountId: document.querySelector("#account-select-import-excel")
                                        .value // ID account selected 
                                });
                        }, 500);
                            
                    });
                    document.querySelector('#updateData').addEventListener('click', () => {
                        // e.preventDefault();
                        addMaskLoading('Đang xử lý dữ liệu <span data-control="mask-counting"></span>');

                        setTimeout(() => {
                            var datas = importDatas();
                            addMaskLoading('Đang nhập dữ liệu. Vui lòng chờ...');
                            ExcelPopup.updateUrlSaveDatas(
                                "{{ action('\App\Http\Controllers\Marketing\ContactController@importExcelRunning') }}",
                                'POST', csrfToken, {
                                    type:'updateData',
                                    excelDatas: datas,
                                    current_page: {{ $currentPage }},
                                    total_page: {{ $totalPage }},
                                    path: '{{ $path }}',
                                    accountId: document.querySelector("#account-select-import-excel")
                                        .value // ID account selected 
                                });
                        }, 500);
                            
                    });
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
