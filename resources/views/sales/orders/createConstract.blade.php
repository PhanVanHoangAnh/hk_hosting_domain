@extends('layouts.main.app', [
    'menu' => 'sales',
])

@section('sidebar')
    @include('sales.modules.sidebar', [
        'menu' => 'orders',
        'sidebar' => 'create_constract',
        'orderType' => $order->type,
    ])
@endsection

@section('content')
    <div id="create-constract-content">
        <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="order-content">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column py-1">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center my-1">
                    <span class="text-dark fw-bold fs-1">{{ $order && $order->type == App\Models\Order::TYPE_REQUEST_DEMO ? 'yêu cầu học thử' : 'Hợp đồng' }}</span>
                </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a class="text-muted text-hover-primary">Trang chính</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        {{ $order && $order->type == App\Models\Order::TYPE_REQUEST_DEMO ? 'yêu cầu học thử' : 'Hợp đồng' }}
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-dark">Thêm mới</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->
        </div>

        <div class="card-header border-0 mb-10" id="create-constract-container">
            <form id="create-constract-form">
                <input id="last-copied-order-item" data-id="{{ isset($newOrderItemId) ? $newOrderItemId : '' }}"
                    data-type="{{ isset($type) ? $type : '' }}" type="hidden" disabled>
                @csrf
                <h3 class="mb-5 text-nowrap fs-2 text-primary">Thông tin chung</h3>
                <div class="row mb-10">
                    <div class="col-6">
                        <div class="form-outline">
                            <label class="fs-6 fw-semibold mb-2" for="order-request-number-input">
                                @if ($order->contact_id == $order->student_id)
                                    Khách hàng,
                                    {{ $order && $order->type == App\Models\Order::TYPE_REQUEST_DEMO ? 'Người liên hệ' : 'Người ký hợp đồng' }},
                                    Học viên
                                @else
                                    {{ trans('messages.order.customer_name') }}
                                @endif
                            </label>

                            @include('helpers.contactSelector', [
                                'name' => 'contact_id',
                                'url' => action('App\Http\Controllers\Sales\ContactController@select2'),
                                'controlParent' => '#create-constract-content',
                                'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
                                'value' => $order->contact_id ? $order->contact_id : null,
                                'text' => $order->contact_id ? $order->contacts->getSelect2Text() : null,
                                'createUrl' => action('\App\Http\Controllers\Sales\ContactController@create'),
                                'editUrl' => action('\App\Http\Controllers\Sales\ContactController@edit','CONTACT_ID'),
                                'editOnly' => true,
                            ])

                            <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
                        </div>
                    </div>
                    <div class="col-6">
                        <div data-control="contact-info">

                        </div>
                        <script>
                            $(function() {
                                new ContactInfoBox({
                                    container: document.querySelector('[data-control="contact-info"]'),
                                    selectBox: document.querySelector('[name="contact_id"]'),
                                    url: '{{ action('\App\Http\Controllers\Sales\ContactController@infoBox', 'CONTACT_ID') }}',
                                });
                            });
                        </script>
                    </div>
                </div>

                {{-- SELECT2 PICK CONTACT --}}
                @if ($order->contact_id !== $order->student_id)
                    <div class="row mb-7">
                        <div class="col-6">
                            <div class="form-outline">
                                <label class="fs-6 fw-semibold mb-2" for="order-request-number-input">Học viên</label>

                                @include('helpers.contactSelector', [
                                    'name' => 'student_id',
                                    'url' => action('App\Http\Controllers\Sales\ContactController@select2'),
                                    'controlParent' => '',
                                    'placeholder' => 'Tìm khách hàng/liên hệ từ hệ thống',
                                    'value' => $order->student_id ? $order->student_id : null,
                                    'text' => $order->student_id ? $order->student->getSelect2Text() : null,
                                    'createUrl' => action('\App\Http\Controllers\Sales\ContactController@create'),
                                    'editUrl' => action(
                                        '\App\Http\Controllers\Sales\ContactController@edit',
                                        'CONTACT_ID'),
                                    'editOnly' => true,
                                ])

                                <x-input-error :messages="$errors->get('contact_id')" class="mt-2"/>
                            </div>
                        </div>
                        <div class="col-6">
                            <div data-control="student-info">
                            </div>
                            <script>
                                $(function() {
                                    new ContactInfoBox({
                                        container: document.querySelector('[data-control="student-info"]'),
                                        selectBox: document.querySelector('[name="student_id"]'),
                                        url: '{{ action('\App\Http\Controllers\Sales\ContactController@infoBox', 'CONTACT_ID') }}',
                                    });
                                });
                            </script>
                        </div>
                    </div>
                @endif

                {{-- SALES MANAGER --}}
                @include('sales.orders._salesManager')

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="form-outline">
                            <label class="required fs-6 fw-semibold mb-2" for="order-notes-text">Ghi chú</label>
                            <textarea id="order-notes-text" rows="4" cols="50" class="form-control" placeholder="Nhập ghi chú..."
                                name="parent_note">{{ $order->parent_note }}</textarea>
                        </div>
                    </div>
                </div>
                <h2 class="mt-15 text-primary text-start separator separator-content my-10 text-nowrap">DANH SÁCH DỊCH VỤ</h2>
                @if ($order->type != \App\Models\Order::TYPE_REQUEST_DEMO)
                    <div class="form-outline mt-5 d-flex justify-content-start" section-control>
                        {{-- ADD ABROAD ITEM BUTTON --}}
                        <button id="addTStudyAbroadOrder"
                            class="btn btn-info me-3 {{ $order->isAbroad() ? '' : 'd-none' }}">
                            <span class="material-symbols-rounded" style="vertical-align: middle;">
                                flightsmode
                            </span>
                            <span class="mx-2">Dịch vụ du học</span>
                        </button>

                        {{-- ADD EDU ITEM BUTTON --}}
                        <div class="d-flex align-items-center">
                            <div>
                                <button id="addTrainOrder" class="btn btn-info me-3 {{ $order->isEdu() ? '' : 'd-none' }}">
                                    <span class="material-symbols-rounded" style="vertical-align: middle;">
                                        school
                                    </span>
                                    <span class="mx-2">Thêm môn học vào hợp đồng</span>
                                </button>
                            </div>
                            <div class="{{ $order->isEdu() ? '' : 'd-none' }}">
                                <span class="d-flex align-items-center">
                                    <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                                        error
                                    </span>
                                    <span>Có thể thêm nhiều môn học vào cùng 1 hợp đồng</span>
                                </span>
                            </div>
                        </div>

                        {{-- ADD EXTRACURRICULAR ITEM BUTTON --}}
                        <button id="addExtraOrder" data-href="{{ action([App\Http\Controllers\Sales\OrderController::class, 'showCreateExtraPopup'], ['orderId' => $order->id]) }}"
                            class="btn btn-info me-3 {{ $order->isExtra() ? '' : 'd-none' }}">
                            <span class="material-symbols-rounded" style="vertical-align: middle;">directions_run</span> 
                            <span class="mx-2">Dịch vụ ngoại khóa</span>
                        </button>

                     
                    </div>
                @else
                    <div class="form-outline mt-10 d-flex justify-content-start">
                        <button id="addDemoOrder" class="btn btn-info">
                            <span class="material-symbols-rounded" style="vertical-align: middle;">school</span>
                            <span class="mx-2">Thêm mới yêu cầu học thử</span>
                        </button>
                    </div>
                @endif
                <div id="orderItemsListContent">
                    <div class="card px-10 py-10 mt-10">
                    <?php
                    if(count($orderItems) > 0) {
                    ?>
                        {{-- LIST EDU ITEMS --}}
                        @if (count($orderItems) > 0 &&
                                collect($orderItems)->contains(function ($item) {
                                    return $item->type == App\Models\Order::TYPE_EDU;
                                }))
                            <div class="form-outline">
                                <label class="fs-6 fw-semibold mb-5 fs-3 d-flex align-items-center"
                                    for="order-type-select">
                                    Dịch vụ đào tạo đã chọn:
                                    <span class="badge badge-primary ms-2 p-2">{{ $orderItems->count() }}
                                        Dịch vụ</span>
                                </label>
                                <div class="table-responsive scrollable-orders-table">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5"
                                        id="dtHorizontalVerticalOrder">
                                        <thead>
                                            <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                                <th class="min-w-125px text-left">Dịch vụ</th>
                                                <th class="min-w-125px text-left">Môn học</th>
                                                <th class="min-w-125px text-left">Giá dịch vụ</th>
                                                <th class="min-w-125px text-left">Giá dịch vụ sau khuyến mãi</th>
                                                <th class="min-w-125px text-left">Trình độ</th>
                                                <th class="min-w-125px text-left">Loại hình lớp</th>
                                                <th class="min-w-125px text-left">Số lượng học viên</th>
                                                <th class="min-w-125px text-left">Hình thức học</th>
                                                <th class="min-w-125px text-left">Địa điểm đào tạo</th>
                                                <th class="min-w-125px text-left">Số giờ GVNN</th>
                                                <th class="min-w-125px text-left">Số giờ GV Việt Nam</th>
                                                <th class="min-w-125px text-left">Số giờ gia sư</th>
                                                {{-- <th class="min-w-125px text-left">Số giờ TA</th> --}}
                                                <th class="min-w-125px text-left">Đơn vị tính</th>
                                                <th class="min-w-125px text-left">target</th>
                                                <th class="min-w-125px text-left">Số dịch vụ demo đã trừ</th>
                                                <th class="min-w-125px text-left">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listTrainOrderItemContent" class="text-gray-600">
                                            @foreach ($orderItems as $orderItem)
                                                <?php
                                                if($orderItem->type == App\Models\Order::TYPE_EDU) {
                                                ?>
                                                    <tr list-control="train-order-item">
                                                        <td class="text-left">{{ trans('messages.order_item.' . $orderItem->type) }}</td>
                                                        <td class="text-left">
                                                            {{ $orderItem->subject->name ?? '--' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ App\Helpers\Functions::formatNumber($orderItem->getTotalPriceOfEdu()) }} ₫</td>
                                                        <td class="text-left">
                                                            {{ App\Helpers\Functions::formatNumber($orderItem->getTotalPriceAfterDiscountOfEdu()) }}
                                                            ₫
                                                        </td>
                                                        <td class="text-left">{{ $orderItem->level }}</td>
                                                        <td class="text-left">
                                                            {{ trans('messages.courses.class_type.' . $orderItem->class_type) }}
                                                        </td>
                                                        <td class="text-left">{{ $orderItem->num_of_student }}</td>
                                                        <td class="text-left">
                                                            {{ $orderItem->study_type }}</td>
                                                        <td class="text-left">{{ $orderItem->getTrainingLocationName() }} <span class="fw-bold">{{ trans('messages.training_locations.'. $orderItem->getTrainingLocationBranch()) }}</span></td>
                                                        <td class="text-left">
                                                            {{ number_format($orderItem->getTotalForeignMinutes() / 60, 2) }} giờ
                                                        </td>
                                                        <td class="text-left">
                                                            {{ number_format($orderItem->getTotalVnMinutes() / 60, 2) }} giờ
                                                        </td>
                                                        <td class="text-left">
                                                            {{ number_format($orderItem->getTotalTutorMinutes() / 60, 2) }} giờ
                                                        </td>
                                                        {{-- <td class="text-left">
                                                            {{ number_format($orderItem->getTotalMinutes() / 60, 2) }} giờs
                                                        </td> --}}
                                                        <td class="text-left">
                                                            {{ $orderItem->unit == 'hour' ? 'Giờ' : 'Phút' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ App\Helpers\Functions::formatNumber($orderItem->target) }} 
                                                        </td>
                                                        <td class="text-left">
                                                            {{ number_format($orderItem->getTotalMinutesForSubtractedDemoItems() / 60, 2) }} giờ
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="#"
                                                                class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                                                data-kt-menu-trigger="click"
                                                                data-kt-menu-placement="bottom-end" style="margin-left: 0px">
                                                                Thao tác
                                                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                            <!--begin::Menu-->
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                                                data-kt-menu="true">
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a data-order-item-id="{{ $orderItem->id }}"
                                                                        row-action="update-train-order"
                                                                        class="menu-link px-3">Chỉnh sửa</a>
                                                                </div>
                                                                <div class="menu-item px-3">
                                                                    <a data-order-item-id="{{ $orderItem->id }}"
                                                                        row-action="copy-order-item" href="javascript:;"
                                                                        data-link="{{ action(
                                                                            [App\Http\Controllers\Sales\OrderItemController::class, 'copy'],
                                                                            [
                                                                                'id' => $orderItem->id,
                                                                            ],
                                                                        ) }}"
                                                                        class="menu-link px-3">Copy</a>
                                                                </div>
                                                                <div class="menu-item px-3">
                                                                    <a data-order-item-id="{{ $orderItem->id }}"
                                                                        href="{{ action(
                                                                            [App\Http\Controllers\Sales\OrderItemController::class, 'delete'],
                                                                            [
                                                                                'id' => $orderItem->id,
                                                                            ],
                                                                        ) }}"
                                                                        row-action="delete-train-order"
                                                                        class="menu-link px-3">Xóa</a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu-->
                                                        </td>
                                                    </tr>
                                                <?php
                                                }   
                                                ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        {{-- LIST ABROAD ITEMS --}}
                        @if (count($orderItems) > 0 &&
                                collect($orderItems)->contains(function ($item) {
                                    return $item->type == App\Models\Order::TYPE_ABROAD;
                                }))
                            <div class="form-outline">
                                <label class="fs-6 fw-semibold mb-5 fs-3 d-flex align-items-center"
                                    for="order-type-select">
                                    Dịch vụ du học đã chọn:
                                    <span
                                        class="badge badge-primary ms-2 p-2">{{ $orderItems->where('type', App\Models\Order::TYPE_ABROAD)->count() }}
                                        Dịch vụ</span>
                                </label>
                                <div class="table-responsive scrollable-orders-table">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5"
                                        id="dtHorizontalVerticalOrder">
                                        <thead>
                                            <tr
                                                class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                                <th class="min-w-125px text-left">Loại dịch vụ</th>
                                                <th class="min-w-125px text-left">Giá dịch vụ</th>
                                                <th class="min-w-125px text-left">Giá dịch vụ sau khuyến mãi</th>
                                                <th class="min-w-125px text-left">Thời điểm apply</th>
                                                <th class="min-w-125px text-left">Thời điểm dự kiến nhập học</th>
                                                {{-- <th class="min-w-175px text-left">Số trường apply</th> --}}
                                                <th class="min-w-400px text-left">Top trường</th>
                                                <th class="min-w-125px text-left">Chương trình đang học</th>
                                                <th class="min-w-125px text-left">GPA lớp 9, 10, 11, 12</th>
                                                <th class="min-w-125px text-left">Điểm thi chuẩn hóa</th>
                                                <th class="min-w-125px text-left">Điểm thi tiếng anh</th>
                                                <th class="min-w-125px text-left">Chương trình dự kiến apply</th>
                                                <th class="min-w-125px text-left">Ngành học dự kiến apply</th>
                                                <th class="min-w-125px text-left">Các giải thưởng học thuật</th>
                                                <th class="min-w-125px text-left">Kế hoạch sau đại học</th>
                                                <th class="min-w-125px text-left">Bạn là người</th>
                                                <th class="min-w-125px text-left">Sở thích trong các môn học</th>
                                                <th class="min-w-125px text-left">Về ngôn ngữ, văn hóa</th>
                                                <th class="min-w-125px text-left">Đã tìm hiểu về hồ sơ</th>
                                                <th class="min-w-125px text-left">Mục tiêu nhắm đến</th>
                                                <th class="min-w-125px text-left">Khả năng viết bài luận tiếng anh</th>
                                                <th class="min-w-125px text-left">hoạt động ngoại khóa</th>
                                                <th class="min-w-125px text-left">Đơn hàng tư vấn cá nhân</th>
                                                <th class="min-w-125px text-left">Mong muốn khác</th>
                                                <th class="min-w-125px text-left">Nghề nghiệp phụ huynh</th>
                                                <th class="min-w-125px text-left">Học vị cao nhất của phụ huynh</th>
                                                <th class="min-w-125px text-left">Bố mẹ từng đi du học?</th>
                                                <th class="min-w-125px text-left">Thu nhập của phụ huynh</th>
                                                <th class="min-w-125px text-left">Mức am hiểu về du học của phụ huynh</th>
                                                <th class="min-w-125px text-left">Phụ huynh có anh chị em đã/đang/sắp đi du học</th>
                                                <th class="min-w-125px text-left">Thời gian đồng hành cùng con</th>
                                                <th class="min-w-125px text-left">Khả năng chi trả mỗi năm</th>
                                                <th class="min-w-125px text-left">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listAbroadOrderItemContent" class="text-gray-600">
                                            @foreach ($orderItems as $orderItem)
                                                <?php
                                                if($orderItem->type == App\Models\Order::TYPE_ABROAD) {
                                                ?>
                                                <tr list-control="abroad-order-item">
                                                    <td class="text-left">
                                                        {{ trans('messages.order.type.' .  \App\Models\Order::TYPE_ABROAD) }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ App\Helpers\Functions::formatNumber($orderItem->price) }}₫
                                                    </td>
                                                    <td class="text-left">
                                                        {{ App\Helpers\Functions::formatNumber($orderItem->getTotalPriceAfterDiscountOfAbroad()) }}₫
                                                    </td>
                                                    <td class="text-left">{{ date('d/m/Y', strtotime($orderItem->apply_time)) }}</td>
                                                    
                                                    <td class="text-left">{{ date('d/m/Y', strtotime($orderItem->estimated_enrollment_time)) }}</td>
                                                    <td class="text-left">
                                                        @foreach ($orderItem->getTopSchool() ?? [] as $topSchoolItem) 
                                                            <div><li>{{ $topSchoolItem['num_of_school_from'] ? $topSchoolItem['num_of_school_from'] . " trường" : '' }} {{ $topSchoolItem['top_school_from'] ? "TOP " . $topSchoolItem['top_school_from'] : '' }} {{ $topSchoolItem['country'] ? " tại " . $topSchoolItem['country'] : '' }}</li></div>
                                                        @endforeach
                                                    </td>

                                                    <td class="text-left">{{ isset($orderItem->current_program_id) ? \App\Models\CurrentProgram::find($orderItem->current_program_id)->name : '--' }}</td>
                                                    <td class="text-left">
                                                        @foreach ($orderItem->grades() as $grade)
                                                            <span class="fw-bold">{{ $grade['gpa']->grade }}</span>: 
                                                            <span>{{ $grade['point'] }}</span>
                                                            <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-left">{{ $orderItem->std_score }}</td>
                                                    <td class="text-left">{{ $orderItem->eng_score }}</td>
                                                    <td class="text-left">{{ isset($orderItem->plan_apply_program_id) ? \App\Models\PlanApplyProgram::find($orderItem->plan_apply_program_id)->name : '--' }}</td>
                                                    <td class="text-left">{{ isset($orderItem->intended_major_id) ? \App\Models\IntendedMajor::find($orderItem->intended_major_id)->name : '--' }}</td>
                                                    <td class="text-left">
                                                        @foreach ($orderItem->academicAwards() as $award)
                                                            <span class="fw-bold">{{ $award['academicAward']->name }}</span>: 
                                                            <span>{{ $award['academicAwardText'] }}</span>
                                                            <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-left">{{ $orderItem->postgraduate_plan }}</td>
                                                    <td class="text-left">{{ $orderItem->personality }}</td>
                                                    <td class="text-left">{{ $orderItem->subject_preference }}</td>
                                                    <td class="text-left">{{ $orderItem->language_culture }}</td>
                                                    <td class="text-left">{{ $orderItem->research_info }}</td>
                                                    <td class="text-left">{{ $orderItem->aim }}</td>
                                                    <td class="text-left">{{ $orderItem->essay_writing_skill }}</td>
                                                    <td class="text-left">
                                                        @foreach ($orderItem->extraActivities() as $activity)
                                                            <span class="fw-bold">{{ $activity['extraActivity']->name }}</span>: 
                                                            <span>{{ $activity['extraActivityText'] }}</span>
                                                            <br>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-left">{{ $orderItem->personal_countling_need }}</td>
                                                    <td class="text-left">{{ $orderItem->other_need_note }}</td>
                                                    <td class="text-left">{{ $orderItem->parent_job }}</td>
                                                    <td class="text-left">{{ $orderItem->parent_highest_academic }}</td>
                                                    <td class="text-left">{{ $orderItem->is_parent_studied_abroad }}</td>
                                                    <td class="text-left">{{ $orderItem->parent_income }}</td>
                                                    <td class="text-left">{{ $orderItem->parent_familiarity_abroad }}</td>
                                                    <td class="text-left">
                                                        {{ $orderItem->is_parent_family_studied_abroad == 'yes' ? 'Có' : 'Không có' }}
                                                    </td>
                                                    <td class="text-left">{{ $orderItem->parent_time_spend_with_child }}
                                                    </td>
                                                    <td class="text-left">{{ $orderItem->financial_capability }} $</td>
                                                    <td class="text-left">
                                                        <a href="#"
                                                            class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                                            data-kt-menu-trigger="click"
                                                            data-kt-menu-placement="bottom-end" style="margin-left: 0px">
                                                            Thao tác
                                                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                        <!--begin::Menu-->
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                                            data-kt-menu="true">
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a data-order-item-id="{{ $orderItem->id }}"
                                                                    row-action="update-abroad-order"
                                                                    class="menu-link px-3">Chỉnh sửa
                                                                </a>
                                                            </div>
                                                            <div class="menu-item px-3">
                                                                <a data-order-item-id="{{ $orderItem->id }}"
                                                                    row-action="copy-order-item" href="javascript:;"
                                                                    data-link="{{ action(
                                                                        [App\Http\Controllers\Sales\OrderItemController::class, 'copy'],
                                                                        [
                                                                            'id' => $orderItem->id,
                                                                        ],
                                                                    ) }}"
                                                                    class="menu-link px-3">Copy</a>
                                                            </div>
                                                            <div class="menu-item px-3">
                                                                <a data-order-item-id="{{ $orderItem->id }}"
                                                                    href="{{ action(
                                                                        [App\Http\Controllers\Sales\OrderItemController::class, 'delete'],
                                                                        [
                                                                            'id' => $orderItem->id,
                                                                        ],
                                                                    ) }}"
                                                                    row-action="delete-abroad-order"
                                                                    class="menu-link px-3">Xóa</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                        </div>
                                                        <!--end::Menu-->
                                                    </td>
                                                </tr>
                                                <?php
                                         }   
                                        ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        {{-- LIST EXTRA ITEMS --}}
                        {{-- LIST ABROAD ITEMS --}}
                        @if (count($orderItems) > 0 &&
                                collect($orderItems)->contains(function ($item) {
                                    return $item->type == App\Models\Order::TYPE_EXTRACURRICULAR;
                                }))
                            <div class="form-outline">
                                <label class="fs-6 fw-semibold mb-5 fs-3 d-flex align-items-center"
                                    for="order-type-select">
                                    Dịch vụ ngoại khóa đã chọn:
                                    <span class="badge badge-primary ms-2 p-2">{{ $orderItems->where('type', App\Models\Order::TYPE_EXTRACURRICULAR)->count() }}Dịch vụ</span>
                                </label>
                                <div class="table-responsive scrollable-orders-table">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5"
                                        id="dtHorizontalVerticalOrder">
                                        <thead>
                                            <tr
                                                class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                                <th class="min-w-125px text-left">Dịch vụ</th>
                                                <th class="min-w-125px text-left">Giá dịch vụ</th>
                                                <th class="min-w-125px text-left">Giá dịch vụ sau giảm giá</th>
                                                <th class="min-w-125px text-left">Hoạt động</th>
                                                <th class="min-w-125px text-left">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listExtraOrderItemContent" class="text-gray-600">
                                            @foreach ($orderItems as $orderItem)
                                                <?php
                                         if($orderItem->type == App\Models\Order::TYPE_EXTRACURRICULAR) {
                                        ?>
                                                <tr list-control="abroad-order-item">
                                                    <td class="text-left">
                                                        {{ trans('messages.order_item.' . $orderItem->type) }}
                                                    </td>
                                                    <td class="text-left">
                                                        {{ App\Helpers\Functions::formatNumber(\App\Helpers\Functions::convertStringPriceToNumber($orderItem->price)) }}đ
                                                    </td>
                                                    <td class="text-left">
                                                        {{ App\Helpers\Functions::formatNumber(\App\Helpers\Functions::convertStringPriceToNumber($orderItem->getTotalPriceAfterDiscountOfExtra())) }}đ
                                                    </td>
                                                    <td class="text-left">
                                                        {{ isset($orderItem->extracurricular_id) ? \App\Models\Extracurricular::find($orderItem->extracurricular_id)->name : '--' }}
                                                    </td>
                                                    <td class="text-left">
                                                        <a href="#"
                                                            class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                                            data-kt-menu-trigger="click"
                                                            data-kt-menu-placement="bottom-end" style="margin-left: 0px">
                                                            Thao tác
                                                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                        <!--begin::Menu-->
                                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                                            data-kt-menu="true">
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item px-3">
                                                                <a data-order-item-id="{{ $orderItem->id }}"
                                                                    row-action="update-extra-order"
                                                                    class="menu-link px-3">Chỉnh sửa
                                                                </a>
                                                            </div>
                                                            <div class="menu-item px-3">
                                                                <a data-order-item-id="{{ $orderItem->id }}"
                                                                    row-action="copy-order-item" href="javascript:;"
                                                                    data-link="{{ action(
                                                                        [App\Http\Controllers\Sales\OrderItemController::class, 'copy'],
                                                                        [
                                                                            'id' => $orderItem->id,
                                                                        ],
                                                                    ) }}"
                                                                    class="menu-link px-3">Copy</a>
                                                            </div>
                                                            <div class="menu-item px-3">
                                                                <a data-order-item-id="{{ $orderItem->id }}"
                                                                    href="{{ action(
                                                                        [App\Http\Controllers\Sales\OrderItemController::class, 'delete'],
                                                                        [
                                                                            'id' => $orderItem->id,
                                                                        ],
                                                                    ) }}"
                                                                    row-action="delete-abroad-order"
                                                                    class="menu-link px-3">Xóa</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                        </div>
                                                        <!--end::Menu-->
                                                    </td>
                                                </tr>
                                                <?php
                                         }   
                                        ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        {{-- LIST REQUEST DEMO ITEMS --}}
                        @if (count($orderItems) > 0 &&
                                collect($orderItems)->contains(function ($item) {
                                    return $item->type == App\Models\Order::TYPE_REQUEST_DEMO;
                                }))
                            <div class="form-outline">
                                <label class="fs-6 fw-semibold mb-5 fs-3 d-flex align-items-center" for="order-type-select">
                                    Dịch vụ demo đã chọn:
                                    <span class="badge badge-primary ms-2 p-2">{{ $orderItems->where('type', App\Models\Order::TYPE_REQUEST_DEMO)->count() }}
                                        Dịch vụ
                                    </span>
                                </label>
                                <div class="table-responsive scrollable-orders-table">
                                    <!--begin::Table-->
                                    <table class="table align-middle table-row-dashed fs-6 gy-5"
                                        id="dtHorizontalVerticalOrder">
                                        <thead>
                                            <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                                <th class="min-w-125px text-left">Dịch vụ</th>
                                                <th class="min-w-125px text-left">Môn học</th>
                                                <th class="min-w-125px text-left">Giá dịch vụ</th>
                                                <th class="min-w-125px text-left">Giá dịch vụ sau khuyến mãi</th>
                                                <th class="min-w-125px text-left">Trình độ</th>
                                                <th class="min-w-125px text-left">Loại hình lớp</th>
                                                <th class="min-w-125px text-left">Số lượng học viên</th>
                                                <th class="min-w-125px text-left">Hình thức học</th>
                                                <th class="min-w-125px text-left">Địa điểm đào tạo</th>
                                                <th class="min-w-125px text-left">Số giờ GVNN</th>
                                                <th class="min-w-125px text-left">Số giờ GV Việt Nam</th>
                                                <th class="min-w-125px text-left">Số giờ gia sư</th>
                                                <th class="min-w-125px text-left">Số giờ TA</th>
                                                <th class="min-w-125px text-left">Đơn vị tính</th>
                                                <th class="min-w-125px text-left">target</th>
                                                <th class="min-w-125px text-left">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listTrainOrderItemContent" class="text-gray-600">
                                            @foreach ($orderItems as $orderItem)
                                                <?php
                                                if($orderItem->type == App\Models\Order::TYPE_REQUEST_DEMO) {
                                                ?>
                                                    <tr list-control="train-order-item">
                                                        <td class="text-left">{{ trans('messages.order_item.' . $orderItem->type) }}</td>
                                                        <td class="text-left">
                                                            {{ $orderItem->subject->name ?? '--' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ App\Helpers\Functions::formatNumber($orderItem->getTotalPriceOfEdu()) }} ₫</td>
                                                        <td class="text-left">
                                                            {{ App\Helpers\Functions::formatNumber($orderItem->getTotalPriceAfterDiscountOfEdu()) }}
                                                            ₫
                                                        </td>
                                                        <td class="text-left">{{ $orderItem->level }}</td>
                                                        <td class="text-left">
                                                            {{ trans('messages.courses.class_type.' . $orderItem->class_type) }}
                                                        </td>
                                                        <td class="text-left">{{ $orderItem->num_of_student }}</td>
                                                        <td class="text-left">
                                                            {{ $orderItem->study_type }}</td>
                                                        <td class="text-left">{{ $orderItem->getTrainingLocationName() }} <span class="fw-bold">{{ trans('messages.training_locations.'. $orderItem->getTrainingLocationBranch()) }}</span></td>
                                                        <td class="text-left">
                                                            {{ number_format($orderItem->getTotalForeignMinutes() / 60, 2) }} giờ
                                                        </td>
                                                        <td class="text-left">
                                                            {{ number_format($orderItem->getTotalVnMinutes() / 60, 2) }} giờ
                                                        </td>
                                                        <td class="text-left">
                                                            {{ number_format($orderItem->getTotalTutorMinutes() / 60, 2) }} giờ
                                                        </td>
                                                        <td class="text-left">
                                                            {{ number_format($orderItem->getTotalMinutes() / 60, 2) }} giờ
                                                        </td>
                                                        <td class="text-left">
                                                            {{ $orderItem->unit == 'hour' ? 'Giờ' : 'Phút' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ App\Helpers\Functions::formatNumber($orderItem->target) }} 
                                                        </td>
                                                        <td class="text-center">
                                                            <a href="#"
                                                                class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                                                data-kt-menu-trigger="click"
                                                                data-kt-menu-placement="bottom-end" style="margin-left: 0px">
                                                                Thao tác
                                                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                                            <!--begin::Menu-->
                                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                                                data-kt-menu="true">
                                                                <!--begin::Menu item-->
                                                                <div class="menu-item px-3">
                                                                    <a data-order-item-id="{{ $orderItem->id }}"
                                                                        row-action="update-demo-order"
                                                                        class="menu-link px-3">Chỉnh sửa</a>
                                                                </div>
                                                                <div class="menu-item px-3">
                                                                    <a data-order-item-id="{{ $orderItem->id }}"
                                                                        row-action="copy-order-item" href="javascript:;"
                                                                        data-link="{{ action(
                                                                            [App\Http\Controllers\Sales\OrderItemController::class, 'copy'],
                                                                            [
                                                                                'id' => $orderItem->id,
                                                                            ],
                                                                        ) }}"
                                                                        class="menu-link px-3">Copy</a>
                                                                </div>
                                                                <div class="menu-item px-3">
                                                                    <a data-order-item-id="{{ $orderItem->id }}"
                                                                        href="{{ action(
                                                                            [App\Http\Controllers\Sales\OrderItemController::class, 'delete'],
                                                                            [
                                                                                'id' => $orderItem->id,
                                                                            ],
                                                                        ) }}"
                                                                        row-action="delete-demo-order"
                                                                        class="menu-link px-3">Xóa</a>
                                                                </div>
                                                                <!--end::Menu item-->
                                                            </div>
                                                            <!--end::Menu-->
                                                        </td>
                                                    </tr>
                                                <?php
                                                }   
                                                ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    <?php 
                    } else {
                    ?>
                        {{-- NOT EXIST ANY ORDER ITEMS IN THIS ORDER CASE... --}}
                        <div class="text-center">
                            <label class="fs-6 fw-semibold fs-3 d-flex align-items-center justify-content-center"
                                for="order-type-select">
                                Chưa có dịch vụ nào được thêm vào hợp đồng này. Nhấn các nút thêm dịch vụ bên trên để thêm dịch vụ vào hợp đồng.
                            </label>
                        </div>
                    <?php
                    }
                    ?>
                    </div>
                </div>

                <script>
                    /**
                     * Get init data of order items
                     * @returns {scheduleItems} - schedule (array of items)
                     */
                    var getOrderItem = () => {
                        let scheduleItems = null;

                        @if ($order && $order != null && $order->schedule_items)
                            if (Array.isArray({!! json_encode($order->schedule_items) !!})) {
                                scheduleItems = {!! json_encode($order->schedule_items) !!};
                            } else {
                                scheduleItems = JSON.parse({!! json_encode($order->schedule_items) !!});
                            }

                            if (scheduleItems !== null && scheduleItems) {
                                if (scheduleItems.length > 0) {
                                    for (let i = 0; i < scheduleItems.length; i++) {
                                        scheduleItems[i] = JSON.parse(scheduleItems[i]);
                                    }
                                }
                            }
                        @endif

                        return scheduleItems;
                    };
                </script>

                {{-- PRICE FORM --}}
                {{-- EDU ORDER PRICE MANAGER --}}
                @if ($order->isEdu())
                    @include('sales.orders._eduPriceManager')
                @endif

                {{-- ABROAD ORDER PRICE MANAGER--}}
                @if ($order->isAbroad())
                    @include('sales.orders._abroadPriceManager')
                @endif

                {{-- ABROAD ORDER PRICE MANAGER--}}
                @if ($order->isExtra())
                    @include('sales.orders._extraPriceManager')
                @endif

                {{-- SAVE --}}
                <div class="row mt-8">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 fs-5 text-start">
                        <button id="save-contract-dta-btn" class="btn btn-primary">
                            <span class="d-flex align-items-center justify-content-center">
                                <span class="material-symbols-rounded me-1">
                                    save
                                </span>
                                <span>Lưu thông tin hợp đồng</span>
                            </span>
                        </button>
                    </div>
                </div>
            </form>

            @if ($order && $order->type != App\Models\Order::TYPE_REQUEST_DEMO)
                {{-- SHOW RESULT (TOTAL PRICE, DISCOUNT, ...) --}}
                <div class="form-outline my-10">
                    <div class="row d-flex justify-content-end align-items-end">
                        <div class="col-lg-4 col-sm-4 col-xs-4 col-md-4 col-xl-4">
                            <div class="mb-5">
                                <div class="fs-4 mb-2 d-flex justify-content-end align-items-end">
                                    <span class="fw-bold text-end text-nowrap">Tổng giá:</span>
                                </div>
                                <div class="fs-4 d-flex justify-content-end align-items-end mb-2">
                                    <span class="fw-bold text-end text-nowrap">Giảm giá:</span>
                                </div>
                                <div class="fs-4 d-flex justify-content-end align-items-end">
                                    <span class="fw-bold text-end text-nowrap">Tổng cộng:</span>
                                </div>
                            </div>
                        </div>

                        <div class="w-auto ps-0">
                            <div id="finalPriceContainer" class="w-auto">
                                <div class="mb-5">
                                    <div class="fs-4 me-0 mb-2 d-flex justify-content-end">
                                        <span class="me-0 text-primary fw-bold text-nowrap">{{ number_format($order->getPriceBeforeDiscount(), 0, '.', ',') }}&nbsp;₫</span>
                                    </div>
                                    <div class="fs-4 me-0 d-flex justify-content-end mb-2">
                                        <span class="me-0 text-primary fw-bold text-nowrap">{{ number_format($order->getPriceBeforeDiscount() - $order->getTotal(), 0, '.', ',') }}&nbsp;₫</span>
                                    </div>
                                    <div class="fs-4 me-0 d-flex justify-content-end">
                                        <span class="me-0 text-primary fw-bold text-nowrap">{{ number_format($order->getTotal(), 0, '.', ',') }}&nbsp;₫</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            {{-- SUBMIT --}}
            <div class="form-outline mt-10 d-flex justify-content-center">
                <div class="mt-5">
                    @if ($order && $order->type != App\Models\Order::TYPE_REQUEST_DEMO) 
                        <button id="doneCreateOrdersBtn" class="btn btn-primary me-1">Hoàn tất</button>
                    @endif
                    @if ($order && $order->type != App\Models\Order::TYPE_REQUEST_DEMO && $order->canRequestApprove()) 
                        <input type="submit" class="btn btn-primary me-1" name="save_and_request"
                            value="{{ $order && $order->type != App\Models\Order::TYPE_REQUEST_DEMO ? 'Xác nhận và yêu cầu duyệt' : 'Hoàn tất' }}" id="comfirmAndRequestApproveBtn">
                    @elseif ($order && $order->type == App\Models\Order::TYPE_REQUEST_DEMO)
                        <input type="submit" class="btn btn-primary me-1" name="save_and_request"
                        value="Hoàn tất" id="comfirmAndRequestApproveBtn">
                    @endif
                        <a href="{{ action([App\Http\Controllers\Sales\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL]) }}"
                        id="cancelCreateConstractBtn" class="btn btn-light">Hủy</a>
                </div>
            </div>
        </div>

        <script>
            var EDU_TYPE = "{!! App\Models\Order::TYPE_EDU !!}";
            var ABROAD_TYPE = "{!! App\Models\Order::TYPE_ABROAD !!}";
            var DEMO_TYPE = "{!! App\Models\Order::TYPE_REQUEST_DEMO !!}";
            var EXTRA_TYPE = "{!! App\Models\Order::TYPE_EXTRACURRICULAR !!}";

            var salesManager;
            var trainOrderItemForm;
            var demoOrderItemForm;
            var eduFormManage;
            var eduPriceManager;
            var abroadPriceManager;
            var extraPriceManager;
            var staffTimesManager;
            var revenueDistribution;
            var extraPopup;

            $(() => {
                AddTrainOrderPopup.init();
                AddExtraItemPopup.init();
                AddAbroadOrderPopup.init();
                AddDemoOrderPopup.init();

                $('[data-selector="sale"]').on('change', e => {
                    
                })
            });

            var Constract = class {
                constructor(options) {
                    this.orderId = options.orderId;
                    this.container = document.querySelector("#create-constract-container");
                    this.trainOrderItems = document.querySelectorAll('[list-control="train-order-item"]');
                    this.abroadOrderItems = document.querySelectorAll('[list-control="abroad-order-item"]');
                    this.initEvents();
                    this.events();
                };

                getContainer() {
                    return this.container;
                };

                getCopyBtns() {
                    return this.container.querySelectorAll('[row-action="copy-order-item"]');
                };

                getCreateTrainOrderBtn() {
                    return document.querySelector("#addTrainOrder");
                };

                getCreateExtraItemBtn() {
                    return document.querySelector("#addExtraOrder");
                };

                getCreateDemoOrderBtn() {
                    return document.querySelector("#addDemoOrder");
                };

                getCreateAbroadOrderBtn() {
                    return document.querySelector("#addTStudyAbroadOrder");
                };

                getSavaDataConstractBtn() {
                    return document.querySelector("#save-contract-dta-btn");
                };

                getDoneCreateConstractBtn() {
                    return document.querySelector("#doneCreateOrdersBtn");
                };

                getConfirmAndRequestApproveBtn() {
                    return this.container.querySelector('#comfirmAndRequestApproveBtn');
                };

                showCreateTraiOrderPopup() {
                    AddTrainOrderPopup.updateUrl(
                        "{!! action('App\Http\Controllers\Sales\OrderController@createTrainOrder', ['contactId' => $order->contact_id, 'orderId' => $order->id,]) !!}"
                    );
                };

                showCreateExtraItemPopup(url) {
                    AddExtraItemPopup.updateUrl(
                        "{!! action([App\Http\Controllers\Sales\OrderController::class, 'showCreateExtraPopup'], ['orderId' => $order->id]) !!}"
                    );
                };

                showCreateDemoOrderPopup() {
                    AddDemoOrderPopup.updateUrl(
                        "{!! action([App\Http\Controllers\Sales\OrderController::class, 'createDemoOrder'], ['orderId' => $order->id]) !!}"
                    );
                };

                showCreateAbroadOrderPopup() {
                    AddAbroadOrderPopup.updateUrl(
                        "{!! action([App\Http\Controllers\Sales\OrderController::class, 'createAbroadOrder'], ['orderId' => $order->id]) !!}"
                    );
                };

                getConstractForm() {
                    return $("#create-constract-form");
                };

                getConstractData() {
                    return this.getConstractForm().serialize();
                };

                getUpdateTrainOrderBtns() {
                    return document.querySelectorAll('[row-action="update-train-order"]');
                };

                getDeleteTrainOrderBtns() {
                    return document.querySelectorAll('[row-action="delete-train-order"]');
                };

                getUpdateDemoOrderBtns() {
                    return document.querySelectorAll('[row-action="update-demo-order"]');
                };

                getDeleteDemoOrderBtns() {
                    return document.querySelectorAll('[row-action="delete-demo-order"]');
                };

                getUpdateAbroadOrderBtns() {
                    return document.querySelectorAll('[row-action="update-abroad-order"]');
                };

                getUpdateExtraOrderBtns() {
                    return document.querySelectorAll('[row-action="update-extra-order"]');
                };

                getDeleteAbroadOrderBtns() {
                    return document.querySelectorAll('[row-action="delete-abroad-order"]');
                };

                getOrderDateInput() {
                    return this.getContainer().querySelector('[name="order_date"]');
                };

                getOrderDateValue() {
                    return this.getOrderDateInput().value;
                };

                setOrderDate(date) {
                    this.getOrderDateInput().value = date;
                };

                getNow() {
                    return (new Date(Date.now())).toLocaleDateString('en-CA');
                };

                loadOrderDate() {
                    const _this = this;
                    const currOrderDate = _this.getOrderDateValue();

                    if (!currOrderDate) {
                        // Load now
                        const now = _this.getNow();

                        _this.setOrderDate(now);
                    }
                };

                addSubmitEffect() {
                    if (this.getDoneCreateConstractBtn()) {
                        this.getDoneCreateConstractBtn().setAttribute('data-kt-indicator', 'on');
                        this.getDoneCreateConstractBtn().setAttribute('disabled', true);
                    }
                };

                removeSubmitEffect() {
                    if (this.getDoneCreateConstractBtn()) {
                        this.getDoneCreateConstractBtn().removeAttribute('data-kt-indicator');
                        this.getDoneCreateConstractBtn().removeAttribute('disabled');
                    }
                };

                addLoadingEffect() {
                    this.container.classList.add("list-loading");

                    if (!this.container.querySelector('[list-action="loader"]')) {
                        $(this.container).before(`
                            <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                                <div class="spinner-border" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>
                        `);
                    };
                };

                removeLoadingEffect() {
                    this.container.classList.remove("list-loading");
                    if (this.container.querySelector('[list-action="loader"]')) {
                        this.container.querySelector('[list-action="loader"]').remove();
                    };
                    
                    KTComponents.init();
                };

                saveConstractData() {
                    let formData = this.getConstractData() + `&order_id=${this.orderId}`;

                    this.addLoadingEffect();

                    $.ajax({
                        url: "{{ action('App\Http\Controllers\Sales\OrderController@saveConstractData') }}",
                        method: "POST",
                        data: formData
                    }).done(response => {
                        let updateContent = $(response).find('#create-constract-content');
                        $('#create-constract-content').html(updateContent);
                        this.removeLoadingEffect();

                        if ($('#create-constract-content')[0]) {
                            initJs($('#create-constract-content')[0]);
                        };
                    }).fail(response => {
                        this.removeSubmitEffect();
                        this.removeLoadingEffect();

                        let updateContent = $(response).find('#create-constract-content');
                        $('#create-constract-content').html(updateContent);

                        if ($('#create-constract-content')[0]) {
                            initJs($('#create-constract-content')[0]);
                        };
                    });
                };

                confirmAndRequestApproveConstractData() {
                    let formData = this.getConstractData() + `&order_id=${this.orderId}` +
                        `&save_and_request="save_and_request"`;

                    this.addSubmitEffect();
                    this.addLoadingEffect();

                    $.ajax({
                        url: "{{ action('App\Http\Controllers\Sales\OrderController@doneCreateConstractData') }}",
                        method: "POST",
                        data: formData
                    }).done(response => {
                        this.removeSubmitEffect();
                        this.removeLoadingEffect();

                        ASTool.alert({
                            message: response.message,
                            ok: () => {
                                this.addLoadingEffect();
                                const screenType =
                                    "{{ $order->type == 'request-demo' ? 'request-demo' : 'general' }}";
                                window.location.href =
                                    `{{ action('App\Http\Controllers\Sales\OrderController@index', ['type' => '']) }}${screenType}`;
                            }
                        });
                    }).fail(response => {
                        this.removeSubmitEffect();
                        this.removeLoadingEffect();

                        let updateContent = $(response.responseText).find('#create-constract-content');

                        $('#create-constract-content').html(updateContent);

                        if ($('#create-constract-content')[0]) {
                            initJs($('#create-constract-content')[0]);
                        };
                    });
                };

                doneCreateConstractData() {
                    let formData = this.getConstractData() + `&order_id=${this.orderId}`;

                    this.addSubmitEffect();
                    this.addLoadingEffect();

                    $.ajax({
                        url: "{{ action('App\Http\Controllers\Sales\OrderController@doneCreateConstractData') }}",
                        method: "POST",
                        data: formData
                    }).done(response => {
                        this.removeSubmitEffect();
                        this.removeLoadingEffect();

                        ASTool.alert({
                            message: response.message,
                            ok: () => {
                                this.addLoadingEffect();
                                const screenType =
                                    "{{ $order->type == 'request-demo' ? 'request-demo' : 'general' }}";
                                window.location.href =
                                    `{{ action('App\Http\Controllers\Sales\OrderController@index', ['type' => '']) }}${screenType}`;
                            }
                        });
                    }).fail(response => {
                        this.removeSubmitEffect();
                        this.removeLoadingEffect();

                        let updateContent = $(response.responseText).find('#create-constract-content');

                        $('#create-constract-content').html(updateContent);

                        if ($('#create-constract-content')[0]) {
                            initJs($('#create-constract-content')[0]);
                        };
                    });
                };

                loadOrderItemsContent(content) {
                    let updateContent = $(content).find('#orderItemsListContent');
                    let updatePriceContent = $(content).find('#finalPriceContainer');

                    $('#orderItemsListContent').html(updateContent);
                    $('#finalPriceContainer').html(updatePriceContent);
                    
                    KTComponents.init();
                    
                    this.events();
                    this.initEvents();
                    
                    if ($('#create-constract-content')[0]) {
                        initJs($('#create-constract-content')[0]);
                    };
                };

                initEvents() {
                    let _this = this;

                    if (this.getCopyBtns() && this.getCopyBtns().length > 0) {
                        this.getCopyBtns().forEach(button => {
                            let copyOrderItemManager = new CopyOrderItemManager({
                                contract: this,
                                link: button,
                                url: button.getAttribute('data-link')
                            });
                        });
                    };

                    _this.loadOrderDate();
                };

                events() {
                    let _this = this;

                    if (this.getConfirmAndRequestApproveBtn()) {
                        $(this.getConfirmAndRequestApproveBtn()).on('click', function(e) {
                            e.preventDefault();
                            _this.confirmAndRequestApproveConstractData();
                        });
                    };

                    if (this.getCreateTrainOrderBtn()) {
                        this.getCreateTrainOrderBtn().outerHTML = this.getCreateTrainOrderBtn().outerHTML;

                        this.getCreateTrainOrderBtn().addEventListener('click', e => {
                            e.preventDefault();
                            this.showCreateTraiOrderPopup();
                        });
                    };

                    if (this.getCreateExtraItemBtn()) {
                        this.getCreateExtraItemBtn().outerHTML = this.getCreateExtraItemBtn().outerHTML;

                        this.getCreateExtraItemBtn().addEventListener('click', e => {
                            e.preventDefault();
                            this.showCreateExtraItemPopup();
                        });
                    };

                    if (this.getCreateAbroadOrderBtn()) {
                        this.getCreateAbroadOrderBtn().outerHTML = this.getCreateAbroadOrderBtn().outerHTML;

                        this.getCreateAbroadOrderBtn().addEventListener('click', e => {
                            e.preventDefault();
                            this.showCreateAbroadOrderPopup();
                        });
                    };

                    if (this.getCreateDemoOrderBtn()) {
                        this.getCreateDemoOrderBtn().outerHTML = this.getCreateDemoOrderBtn().outerHTML;
                        this.getCreateDemoOrderBtn().addEventListener('click', e => {
                            e.preventDefault();
                            this.showCreateDemoOrderPopup();
                        });
                    };

                    if (this.getSavaDataConstractBtn()) {
                        this.getSavaDataConstractBtn().outerHTML = this.getSavaDataConstractBtn().outerHTML;

                        this.getSavaDataConstractBtn().addEventListener('click', e => {
                            e.preventDefault();
                            this.saveConstractData();
                        });
                    };

                    if (this.getDoneCreateConstractBtn()) {
                        this.getDoneCreateConstractBtn().outerHTML = this.getDoneCreateConstractBtn().outerHTML;

                        this.getDoneCreateConstractBtn().addEventListener('click', e => {
                            e.preventDefault();
                            this.doneCreateConstractData();
                        });
                    };

                    if (this.getUpdateTrainOrderBtns()) {
                        this.getUpdateTrainOrderBtns().forEach(button => {
                            $(button).on('click', function(e) {
                                e.preventDefault();

                                const orderItemId = this.getAttribute('data-order-item-id');
                                const url = " {!! action('App\Http\Controllers\Sales\OrderController@createTrainOrder', ['orderItemId' => 'PLACEHOLDER', 'contactId' => $order->contact_id, 'orderId' => $order->id]) !!} ";
                                const updatedUrl = url.replace('PLACEHOLDER', orderItemId);

                                AddTrainOrderPopup.updateUrl(updatedUrl);
                            });
                        });
                    };

                    if (this.getUpdateDemoOrderBtns()) {
                        this.getUpdateDemoOrderBtns().forEach(button => {
                            button.addEventListener('click', function(e) {
                                e.preventDefault();

                                const orderItemId = this.getAttribute('data-order-item-id');
                                const url = " {!! action('App\Http\Controllers\Sales\OrderController@createDemoOrder', ['orderItemId' => 'PLACEHOLDER', 'contactId' => $order->contact_id, 'orderId' => $order->id]) !!} ";
                                const updatedUrl = url.replace('PLACEHOLDER', orderItemId);

                                AddDemoOrderPopup.updateUrl(updatedUrl);
                            });
                        });
                    };

                    if (this.getDeleteTrainOrderBtns()) {
                        this.getDeleteTrainOrderBtns().forEach(button => {
                            const _this = this;

                            button.addEventListener('click', function(e) {
                                e.preventDefault();

                                const url = this.getAttribute('href');

                                ASTool.confirm({
                                    message: "Bạn có chắc muốn xóa Dịch vụ đào tạo này không?",
                                    ok: function() {
                                        ASTool.addPageLoadingEffect();

                                        $.ajax({
                                            url: url,
                                            method: "DELETE",
                                            data: {
                                                _token: "{{ csrf_token() }}"
                                            }
                                        }).done(response => {
                                            const orderId =
                                                " {{ $orderId }} ";

                                            ASTool.alert({
                                                message: response.message,
                                                ok: function() {
                                                    _this.loadOrderItemsContent(response);
                                                    if (eduPriceManager) {
                                                        eduPriceManager.loadOrderPrice();
                                                    }
                                                    
                                                    if (abroadPriceManager) {
                                                        abroadPriceManager.loadOrderPrice();
                                                    }

                                                    if (extraPriceManager) {
                                                        extraPriceManager.loadOrderPrice();
                                                    }
                                                }
                                            })
                                        }).fail(function() {}).always(function() {
                                            ASTool.removePageLoadingEffect();
                                        })
                                    }
                                });
                            })
                        });
                    };

                    if (this.getDeleteDemoOrderBtns()) {
                        this.getDeleteDemoOrderBtns().forEach(button => {
                            const _this = this;

                            button.addEventListener('click', function(e) {
                                e.preventDefault();

                                const url = this.getAttribute('href');

                                ASTool.confirm({
                                    message: "Bạn có chắc muốn xóa dịch vụ này không?",
                                    ok: function() {
                                        ASTool.addPageLoadingEffect();

                                        $.ajax({
                                            url: url,
                                            method: "DELETE",
                                            data: {
                                                _token: "{{ csrf_token() }}"
                                            }
                                        }).done(response => {
                                            const orderId =
                                                " {{ $orderId }} ";

                                            ASTool.alert({
                                                message: response.message,
                                                ok: function() {
                                                    _this.loadOrderItemsContent(response);
                                                    if (eduPriceManager) {
                                                        eduPriceManager.loadOrderPrice();
                                                    }
                                                    
                                                    if (abroadPriceManager) {
                                                        abroadPriceManager.loadOrderPrice();
                                                    }

                                                    if (extraPriceManager) {
                                                        extraPriceManager.loadOrderPrice();
                                                    }
                                                }
                                            })
                                        }).fail(function() {}).always(function() {
                                            ASTool.removePageLoadingEffect();
                                        })
                                    }
                                });
                            })
                        });
                    };

                    if (this.getUpdateAbroadOrderBtns()) {
                        this.getUpdateAbroadOrderBtns().forEach(button => {
                            const _this = this;
                            button.addEventListener('click', function(e) {
                                e.preventDefault();

                                const orderItemId = this.getAttribute('data-order-item-id');
                                const url = " {!! action('App\Http\Controllers\Sales\OrderController@createAbroadOrder', ['orderItemId' => 'PLACEHOLDER', 'contactId' => $order->contact_id, 'orderId' => $order->id]) !!} ";
                                const updatedUrl = url.replace('PLACEHOLDER', orderItemId);

                                AddAbroadOrderPopup.updateUrl(updatedUrl);
                            });
                        });
                    };

                    if (this.getUpdateExtraOrderBtns()) {
                        this.getUpdateExtraOrderBtns().forEach(button => {
                            const _this = this;
                            button.addEventListener('click', function(e) {
                                e.preventDefault();

                                const orderItemId = this.getAttribute('data-order-item-id');
                                const url = " {!! action('App\Http\Controllers\Sales\OrderController@showCreateExtraPopup', ['orderItemId' => 'PLACEHOLDER', 'contactId' => $order->contact_id, 'orderId' => $order->id]) !!} ";
                                const updatedUrl = url.replace('PLACEHOLDER', orderItemId);

                                AddExtraItemPopup.updateUrl(updatedUrl);
                            });
                        });
                    };

                    if (this.getDeleteAbroadOrderBtns()) {
                        this.getDeleteAbroadOrderBtns().forEach(button => {
                            button.addEventListener('click', function(e) {
                                e.preventDefault();

                                const url = this.getAttribute('href');

                                ASTool.confirm({
                                    message: "Bạn có chắc muốn xóa dịch vụ này không?",
                                    ok: function() {
                                        ASTool.addPageLoadingEffect();

                                        $.ajax({
                                            url: url,
                                            method: "DELETE",
                                            data: {
                                                _token: "{{ csrf_token() }}"
                                            }
                                        }).done(response => {
                                            const orderId = " {{ $orderId }} ";

                                            ASTool.alert({
                                                message: response.message,
                                                ok: function() {
                                                    _this.loadOrderItemsContent(response);
                                                    
                                                    if (abroadPriceManager) {
                                                        abroadPriceManager.loadOrderPrice();
                                                    }

                                                    if (extraPriceManager) {
                                                        extraPriceManager.loadOrderPrice();
                                                    }
                                                }
                                            })
                                        }).fail(function() {}).always(function() {
                                            ASTool.removePageLoadingEffect();
                                        })
                                    }
                                });
                            })
                        });
                    };
                };
            };

            var CopyOrderItemManager = class {
                editPopup = null;
                popupLink = null;

                constructor(options) {
                    this.contract = options.contract;
                    this.link = options.link;
                    this.url = options.url;
                    this.events();

                    const existingIndex = CopyOrderItemManager.all.findIndex(item => this.isEqual(item));

                    if (existingIndex !== -1) {
                        CopyOrderItemManager.all[existingIndex].destroy();
                    };

                    CopyOrderItemManager.all.push(this);
                };

                isEqual(orderItem) {
                    return this.link === orderItem.link;
                };

                destroy() {
                    let i = CopyOrderItemManager.all.indexOf(this);
                    CopyOrderItemManager.all.splice(i, 1);
                };

                static all = [];

                setPopup(type) {
                    switch (type) {
                        case EDU_TYPE:
                            this.editPopup = AddTrainOrderPopup;
                            this.popupLink = "{!! action('App\Http\Controllers\Sales\OrderController@createTrainOrder', ['orderItemId' => 'PLACEHOLDER', 'currOrderItemId' => 'CURR_ID']) !!}";
                            break;
                        case ABROAD_TYPE:
                            this.editPopup = AddAbroadOrderPopup;
                            this.popupLink = "{!! action('App\Http\Controllers\Sales\OrderController@createAbroadOrder', ['orderItemId' => 'PLACEHOLDER', 'currOrderItemId' => 'CURR_ID']) !!}";
                            break;
                        case DEMO_TYPE:
                            this.editPopup = AddDemoOrderPopup;
                            this.popupLink = "{!! action('App\Http\Controllers\Sales\OrderController@createDemoOrder', ['orderItemId' => 'PLACEHOLDER', 'currOrderItemId' => 'CURR_ID']) !!}";
                            break;
                        case EXTRA_TYPE:
                            this.editPopup = AddExtraItemPopup;
                            this.popupLink = "{!! action('App\Http\Controllers\Sales\OrderController@showCreateExtraPopup', ['orderItemId' => 'PLACEHOLDER', 'currOrderItemId' => 'CURR_ID']) !!}";
                            break;
                        default:
                            this.editPopup = AddTrainOrderPopup;
                            this.popupLink = "{!! action('App\Http\Controllers\Sales\OrderController@createTrainOrder', ['orderItemId' => 'PLACEHOLDER', 'currOrderItemId' => 'CURR_ID']) !!}";
                    }
                };

                showPopupEdit(response) {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(response, 'text/html');
                    const lastCopiedOrderItem = doc.querySelector('#last-copied-order-item');

                    if (lastCopiedOrderItem) {
                        const newOrderItemId = lastCopiedOrderItem.getAttribute('data-id');
                        const orderItemId = this.link.getAttribute('data-order-item-id');
                        const type = lastCopiedOrderItem.getAttribute('data-type');

                        this.setPopup(type);

                        const url = this.popupLink;
                        const orderId = {!! $order->id !!}
                        const updatedUrl = url.replace('PLACEHOLDER', newOrderItemId) + `&orderId=${orderId}`;
                        const updatedCurrIdUrl = updatedUrl.replace('CURR_ID', orderItemId);

                        this.editPopup.updateUrl(updatedCurrIdUrl);
                    };
                };

                copy() {
                    $.ajax({
                        url: this.url,
                    }).done(response => {
                        this.contract.loadOrderItemsContent(response);

                        if (eduPriceManager) {
                            eduPriceManager.loadOrderPrice();
                        }
                        
                        if (abroadPriceManager) {
                            abroadPriceManager.loadOrderPrice();
                        }

                        if (extraPriceManager) {
                            extraPriceManager.loadOrderPrice();
                        }

                        this.showPopupEdit(response);
                    }).fail(response => {
                        throw new Error(response);
                    });
                };

                events() {
                    this.link.addEventListener('click', e => {
                        e.preventDefault();
                        this.copy();
                    })
                };
            };

            var createManage = new Constract({
                orderId: "{{ $orderId }}"
            });

            var OrderForm = class {
                #url = "{{ action('App\Http\Controllers\Sales\OrderController@saveOrderItemData') }}";
                #orderId = "{{ $orderId }}";

                constructor(options) {
                    this.form = options.form;
                    this.submitBtnId = options.submitBtnId;
                    this.popup = options.popup;
                    this.orderItemId = options.orderItemId;
                    this.orderFormEvents();
                };

                getFormData() {
                    return this.form.serialize();
                };

                getSaveDataBtn() {
                    return document.querySelector(`#${this.submitBtnId}`);
                };

                loadOrderItemsContent(content) {
                    let updateContent = $(content).find('#orderItemsListContent');
                    let updatePriceContent = $(content).find('#finalPriceContainer');

                    $('#orderItemsListContent').html(updateContent);
                    $('#finalPriceContainer').html(updatePriceContent);
                    
                    KTComponents.init();
                    createManage.events();
                    createManage.initEvents();

                    if ($('#create-constract-content')[0]) {
                        initJs($('#create-constract-content')[0]);
                    };
                };

                addSubmitEffect() {
                    this.getSaveDataBtn().setAttribute('data-kt-indicator', 'on');
                    this.getSaveDataBtn().setAttribute('disabled', true);
                };

                removeSubmitEffect() {
                    this.getSaveDataBtn().removeAttribute('data-kt-indicator');
                    this.getSaveDataBtn().removeAttribute('disabled');
                };

                /**
                 * Save order item data
                 * @param formData order item data in form (popup)
                 * @return void
                 */ 
                saveDataIntoOrder(formData) {
                    var _this = this;

                    formData += `&order_id=${this.#orderId}&order_item_id=${this.orderItemId}`;

                    this.addSubmitEffect();

                    $.ajax({
                        url: this.#url,
                        method: "POST",
                        data: formData
                    }).done(response => {
                        const orderId = this.#orderId;
                        
                        this.removeSubmitEffect();
                        this.popup.hide();

                        ASTool.alert({
                            message: response.message,
                            ok: () => {
                                this.loadOrderItemsContent(response);

                                if (eduPriceManager) {
                                    eduPriceManager.loadOrderPrice();
                                }

                                if (abroadPriceManager) {
                                    abroadPriceManager.loadOrderPrice();
                                }

                                if (extraPriceManager) {
                                    extraPriceManager.loadOrderPrice();
                                }
                            }
                        });
                    }).fail(response => {
                        this.removeSubmitEffect();
                        this.popup.setContent(response.responseText);
                        
                        if (this.getSaveDataBtn()) {
                            this.getSaveDataBtn().addEventListener('click', e => {
                                e.preventDefault();

                                this.saveDataIntoOrder(this.getFormData());
                            });
                        };
                    });
                };

                orderFormEvents() {
                    if (this.getSaveDataBtn()) {
                        this.getSaveDataBtn().outerHTML = this.getSaveDataBtn().outerHTML;

                        // Click save order item
                        this.getSaveDataBtn().addEventListener('click', e => {
                            e.preventDefault();
                            
                            this.saveDataIntoOrder(this.getFormData());
                        });
                    }
                };
            };

            var PriceManager = class {
                #VN_CURRENCY = '₫';
                #USD_CURRENCY = '$';

                constructor(options) {
                    this.container = options.container;
                    this.orderItemScheduleList = options.orderItemScheduleList;
                    this.orderId = "{{ $orderId }}";
                    this.scheduleManager = new ScheduleManager({
                        priceManager: this
                    });

                    this.#init();
                    this.scheduleManager.refreshForm();
                    this.events();
                }

                // Getter & setter
                getOrderItemScheduleList() {
                    return this.orderItemScheduleList;
                };

                getOrderId() {
                    return this.orderId;
                };

                getPriceInput() {
                    if (this.container) {
                        return this.container.querySelector('#price-create-input');
                    };
                };

                setPrice(price) {
                    if (this.getPriceInput()) {
                        this.getPriceInput().value = price;
                    }
                };

                getPriceInputValue() {
                    if (this.getPriceInput()) {
                        return this.getPriceInput().value;
                    }
                };

                getExchangeInput() {
                    if (this.container) {
                        return this.container.querySelector('#exchange-input');
                    };
                };

                getExchangeInputValue() {
                    if (this.getExchangeInput()) {
                        return this.getExchangeInput().value;
                    }
                };

                getCurrencyCodeInput() {
                    if (this.container) {
                        return this.container.querySelector('#currency-select');
                    };
                };

                getCurrencyCodeInputValue() {
                    if (this.getCurrencyCodeInput()) {
                        return this.getCurrencyCodeInput().value;
                    };
                };

                getDiscountPercentInput() {
                    if (this.container) {
                        return this.container.querySelector('#discount-create-input');
                    };
                };

                getDiscountPercentInputValue() {
                    if (this.getDiscountPercentInput()) {
                        return isNaN(this.getDiscountPercentInput().valueAsNumber) ? 0 : this.getDiscountPercentInput().valueAsNumber;
                    };
                };

                getPriceBeforeDiscountLabel() {
                    if (this.container) {
                        return this.container.querySelector('[data-action="markup-price"]');
                    };
                };

                getListCurrencySymbols() {
                    if (this.container) {
                        return this.container.querySelectorAll('[list-symbol="currency"]');
                    };
                };

                getDiscountPercentErrorLabel() {
                    if (this.container) {
                        return this.container.querySelector('#error-discount-percent');
                    };
                };

                getPriceErrorLabel() {
                    if (this.container) {
                        return this.container.querySelector('#error-price');
                    };
                };

                getPayAllCheckBox() {
                    if (this.container) {
                        return this.container.querySelector('#is-payall-checkbox');
                    };
                };

                getSchedulePaymentForm() {
                    if (this.container) {
                        return this.container.querySelector('#schedule-payment-form');
                    };
                };
                getDebtDueDate() {
                    if (this.container) {
                        return this.container.querySelector('#debt-due-date');
                    };
                };

                getDebtAllow() {
                    if (this.container) {
                        return this.container.querySelector('#action-debt-allow');
                    };
                };
                getDebtAllowCheckBox() {
                    if (this.container) {
                        return this.container.querySelector('#debt-allow');
                    };
                };

                getExchangeForm() {
                    if (this.container) {
                        return this.container.querySelector('#exchange-form');
                    };
                };

                getExchangeErrorLabel() {
                    if (this.container) {
                        return this.container.querySelector('#error-exchange');
                    };
                };

                getOrderItemPriceForm() {
                    if (this.container) {
                        return this.container.querySelector('[data-control="order-item-price-form"]');
                    };
                };

                loadOrderPrice() {
                    const _this = this;

                    $.ajax({
                        url: '{{ action('App\Http\Controllers\Sales\OrderController@getTotalPriceOfItems') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: _this.getOrderId()
                        },
                        method: 'post'
                    }).done(response => {
                        _this.setPrice(parseInt(response));
                        this.makeMaskForPriceInput();
                        this.refresh();
                        this.scheduleManager.refreshForm();
                    }).fail(response => {
                        throw new Error(response);
                    })
                }

                // Caculate
                // Business: currency must be in VND format in all cases
                #caculatePriceBeforeDiscount() {
                    if (!(this.#validateDiscountPercentInput() &&
                            this.#validatePriceInput() &&
                            this.#validateExchangeInput())) {
                        return 0;
                    };

                    let currPriceValue = parseFloat(String(this.getPriceInputValue()).trim().replace(/[.\s,]/g, ''));
                    let currDiscountPercent = this.getDiscountPercentInputValue();
                    let currExchange = this.getExchangePriceValue();

                    // return currPriceValue * currExchange / ((100 - currDiscountPercent) / 100);
                    return  currPriceValue * currExchange - ((currPriceValue * currExchange) / 100 * currDiscountPercent);
                };

                getPriceAfterDiscountValue() {
                    return parseFloat(String(this.getPriceInputValue()).trim().replace(/[.\s,]/g, ''));
                };

                getExchangePriceValue() {
                    if (this.getCurrencyCodeInputValue() === "{!! \App\Models\Order::CURRENCY_CODE_VND !!}") {
                        return 1;
                    };

                    let exchange = parseFloat(String(this.getExchangeInputValue()).trim().replace(/[.\s,]/g, ''));

                    if (isNaN(exchange) || exchange === 0) {
                        exchange = 1;
                    };

                    return exchange;
                };

                // Handle errors
                showDiscountErrorLabel() {
                    if (this.getDiscountPercentErrorLabel()) {
                        this.getDiscountPercentErrorLabel().classList.remove('d-none');
                    };
                };

                hideDiscountErrorLabel() {
                    if (this.getDiscountPercentErrorLabel()) {
                        this.getDiscountPercentErrorLabel().classList.add('d-none');
                    };
                };

                showExchangeErrorLabel() {
                    if (this.getExchangeErrorLabel()) {
                        this.getExchangeErrorLabel().classList.remove('d-none');
                    };
                };

                hideExchangeErrorLabel() {
                    if (this.getExchangeErrorLabel()) {
                        this.getExchangeErrorLabel().classList.add('d-none');
                    };
                };

                showPriceErrorLabel() {
                    if (this.getPriceErrorLabel()) {
                        this.getPriceErrorLabel().classList.remove('d-none');
                    };
                };

                hidePriceErrorLabel() {
                    if (this.getPriceErrorLabel()) {
                        this.getPriceErrorLabel().classList.add('d-none');
                    };
                };

                // Actions
                #validatePriceInput() {
                    let priceValue = String(this.getPriceInputValue()).trim().replace(/[.\s,]/g, '');

                    let isValid = true;

                    if (priceValue === '') {
                        return isValid;
                    };

                    isValid = String(parseFloat(priceValue)) === priceValue &&
                        (parseFloat(priceValue) >= 0);

                    if (!isValid) {
                        this.showPriceErrorLabel();
                    } else {
                        this.hidePriceErrorLabel();
                    };

                    return isValid;
                };

                #validateExchangeInput() {
                    let priceValue = String(this.getExchangeInputValue()).trim().replace(/[.\s,]/g, '');
                    let isValid = true;

                    if (priceValue === '') {
                        return isValid;
                    };

                    isValid = String(parseFloat(priceValue)) === priceValue &&
                        (parseFloat(priceValue) >= 0);

                    if (!isValid) {
                        this.showExchangeErrorLabel();
                    } else {
                        this.hideExchangeErrorLabel();
                    };

                    return isValid;
                };

                #validateDiscountPercentInput() {
                    let percentValue = String(this.getDiscountPercentInputValue()).trim();

                    let isValid = true;

                    if (percentValue === '') {
                        return isValid;
                    };

                    isValid = String(parseFloat(percentValue)) === percentValue &&
                        (parseFloat(percentValue) >= 0 && parseFloat(percentValue) <= 100);

                    if (!isValid) {
                        this.showDiscountErrorLabel();
                    } else {
                        this.hideDiscountErrorLabel();
                    };

                    return isValid;
                };

                updatePriceBeforeDiscountLabel(discountedPrice) {
                    /** 
                     * If discountedPrice is NaN: 
                     * It means that the user has previously entered a price, then deleted it
                     * Resulting in price === 0
                     */
                    if (isNaN(discountedPrice)) {
                        discountedPrice = 0;
                    };

                    if (this.getPriceBeforeDiscountLabel()) {
                        this.getPriceBeforeDiscountLabel().value = this.convertNumberWithCommas(discountedPrice);
                    }
                };

                updateAllCurrencyDisplay() {
                    let currCurrency;

                    currCurrency = this.getCurrencyCodeInputValue() === "{!! \App\Models\Order::CURRENCY_CODE_VND !!}" ? this.#VN_CURRENCY : this.#USD_CURRENCY;

                    if (this.getListCurrencySymbols()) {
                        this.getListCurrencySymbols().forEach(label => {
                            label.innerHTML = currCurrency;
                        });
                    };
                };

                convertNumberWithCommas(number) {
                    return parseFloat(number)
                        .toFixed(0)
                        .toString()
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                };

                convertDateFormat(dateInput) {
                    const parts = dateInput.split('-');
                    return `${parts[2]}-${parts[1]}-${parts[0]}`;
                };

                #handleCheckPayall() {
                    let isCheck = this.getPayAllCheckBox().checked;

                    if (isCheck) {
                        this.hideSchedulePaymentForm();
                    } else {
                        this.showSchedulePaymentForm();
                    };
                };

                showSchedulePaymentForm() {
                    this.getPayAllCheckBox().checked = false;
                    this.getSchedulePaymentForm().classList.remove('d-none');

                    this.getDebtAllow().classList.add('d-none');
                    this.scheduleManager.enableItems();
                };

                hideSchedulePaymentForm() {
                    this.getPayAllCheckBox().checked = true;
                    this.getSchedulePaymentForm().classList.add('d-none');
                    this.getDebtAllow().classList.remove('d-none');
                    this.scheduleManager.disableItems();
                };

                #handleCheckDebtAllow() {
                    let isCheckDebtAllow = this.getDebtAllowCheckBox().checked;

                    if (isCheckDebtAllow) {
                        this.hideDebtDueDate();
                    } else {
                        this.showDebtDueDate();
                    };
                };

                showDebtDueDate() {
                    this.getDebtAllowCheckBox().checked = false;
                    this.getDebtDueDate().classList.add('d-none');

                    this.scheduleManager.enableItems();
                };

                hideDebtDueDate() {
                    this.getDebtAllowCheckBox().checked = true;
                    this.getDebtDueDate().classList.remove('d-none');
                    this.scheduleManager.disableItems();
                };


                #showExchangeForm() {
                    if (this.getExchangeForm()) {
                        this.getExchangeForm().classList.remove('d-none');
                    };
                };

                #hideExchangeForm() {
                    if (this.getExchangeForm()) {
                        this.getExchangeForm().classList.add('d-none');
                    };
                };

                #exchangeFormHandle() {
                    const isUsd = this.getCurrencyCodeInputValue() === "{!! \App\Models\Order::CURRENCY_CODE_USD !!}";

                    if (isUsd) {
                        this.#showExchangeForm();
                    } else {
                        this.#hideExchangeForm();
                    };
                };

                /**
                 * Refresh when (in events): 
                 *   + Change price input
                 *   + Change currency 
                 *   + Change discount percent input
                 *   + Change exchange input (in case: the currency is USD)   
                 */
                refresh() {
                    this.updatePriceBeforeDiscountLabel(this.#caculatePriceBeforeDiscount());
                    this.updateAllCurrencyDisplay();
                    this.#validateDiscountPercentInput();
                    this.#validatePriceInput();
                    this.#validateExchangeInput();
                };

                makeMaskForPriceInput() {
                    if (this.getPriceInput()) {
                        const priceInputMask = IMask(this.getPriceInput(), {
                            mask: Number,
                            scale: 2,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                            max: 999999999999,
                        });
                    };
                };

                makeMaskForExchangeInput() {
                    if (this.getExchangeInput()) {
                        const exchangeInputMask = IMask(this.getExchangeInput(), {
                            mask: Number,
                            scale: 2,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                            max: 999999999999,
                        });
                    };
                };

                #init() {
                    // Init input mask
                    this.makeMaskForPriceInput();
                    this.makeMaskForExchangeInput();
                };

                events() {
                    $(this.getDiscountPercentInput()).on('change', e => {
                        e.preventDefault();

                        // $(this.scheduleManager.getBalancePriceLabel()).html($(this.getPriceBeforeDiscountLabel()).val())
                        setTimeout(() => {
                            this.scheduleManager.updateBalanceLabel();
                        }, 0);
                    })

                    // Change price input
                    if (this.getPriceInput()) {
                        this.getPriceInput().addEventListener('change', e => {
                            e.preventDefault();

                            this.refresh();
                        });
                    };

                    // Change currency 
                    if (this.getCurrencyCodeInput()) {
                        this.getCurrencyCodeInput().addEventListener('change', e => {
                            e.preventDefault();

                            this.#exchangeFormHandle();
                            this.refresh();
                        });
                    };

                    // Change discount percent input
                    if (this.getDiscountPercentInput()) {
                        this.getDiscountPercentInput().addEventListener('change', e => {
                            e.preventDefault();

                            this.refresh();
                        });
                    };

                    // Change exchange input
                    if (this.getExchangeInput()) {
                        this.getExchangeInput().addEventListener('change', e => {
                            e.preventDefault();

                            this.refresh();
                        });
                    };

                    if (this.getPayAllCheckBox()) {
                        this.getPayAllCheckBox().addEventListener('change', e => {
                            e.preventDefault();

                            this.#handleCheckPayall();
                        });
                    };
                    if (this.getDebtAllowCheckBox()) {
                        this.getDebtAllowCheckBox().addEventListener('change', e => {
                            e.preventDefault();

                            this.#handleCheckDebtAllow();
                        });
                    };

                    this.#exchangeFormHandle();
                };
            };

            var ItemPriceManager = class extends PriceManager {
                constructor(options) {
                    super(options);
                    super.events();
                    this.#handleCheckIncludedInPackageContract();
                }

                getPriceFormItems() {
                    if (this.container) {
                        return this.container.querySelectorAll('[data-control="price-form-item"]');
                    };
                };

                getIncludedInPackageContractCheckbox() {
                    if (this.container) {
                        return this.container.querySelector('[data-action="check-included-in-package-contract"]');
                    };
                };

                #handleCheckIncludedInPackageContract() {
                    if (this.getIncludedInPackageContractCheckbox()) {
                        let isCheck = this.getIncludedInPackageContractCheckbox().checked;

                        if (!isCheck) {
                            this.hideOrderItemPriceform();
                        } else {
                            this.showOrderItemPriceform();
                        };
                    }
                };

                showOrderItemPriceform() {
                    if (this.getIncludedInPackageContractCheckbox()) {
                        this.getIncludedInPackageContractCheckbox().checked = true;
                        this.getOrderItemPriceForm().classList.remove('d-none');
                        this.enablePriceFormItems();
                    };
                };

                hideOrderItemPriceform() {
                    if (this.getIncludedInPackageContractCheckbox()) {
                        this.getIncludedInPackageContractCheckbox().checked = false;
                        this.getOrderItemPriceForm().classList.add('d-none');
                        this.disablePriceFormItems();
                    };
                };

                enablePriceFormItems() {
                    const items = this.getPriceFormItems();

                    if (items && items.length > 0) {
                        this.getPriceFormItems().forEach(item => {
                            item.removeAttribute('disabled');
                        });
                    };
                };

                disablePriceFormItems() {
                    const items = this.getPriceFormItems();

                    if (items && items.length > 0) {
                        this.getPriceFormItems().forEach(item => {
                            item.setAttribute('disabled', '');
                        });
                    };
                };

                events() {
                    if (this.getIncludedInPackageContractCheckbox()) {
                        this.getIncludedInPackageContractCheckbox().addEventListener('change', e => {
                            e.preventDefault();

                            this.#handleCheckIncludedInPackageContract();
                        });
                    };
                };
            };

            var ScheduleManager = class {
                #priceManager
                #discountedPrice
                #scheduleItemIndex = 0;
                #scheduleItems = [];
                #schedulePriceInputMask; 

                constructor(options) {
                    this.#priceManager = options.priceManager;
                    this.#discountedPrice = options.discountedPrice;

                    this.#init();
                    this.#render();
                    this.#events();
                }

                // Getters & setters
                getSchedulePriceInput() {
                    if (this.#priceManager.container) {
                        return this.#priceManager.container.querySelector('#schedule-price-input');
                    }
                };

                getSchedulePriceInputValue() {
                    if (this.getSchedulePriceInput()) {
                        return this.getSchedulePriceInput().value;
                    };
                };

                setSchedulePrice(price) {
                    this.getSchedulePriceInput().value = price;
                };

                getScheduleDateInput() {
                    if (this.#priceManager.container) {
                        return this.#priceManager.container.querySelector('#schedule-date-input');
                    }
                };

                getScheduleDateInputValue() {
                    return this.getScheduleDateInput().value;
                };

                getBalancePriceLabel() {
                    if (this.#priceManager.container) {
                        return this.#priceManager.container.querySelector('#balance-form');
                    }
                };

                getListScheduleItemsForm() {
                    if (this.#priceManager.container) {
                        return this.#priceManager.container.querySelector('#list-schedule-items-content');
                    }
                };

                getAddScheduleButton() {
                    if (this.#priceManager.container) {
                        return this.#priceManager.container.querySelector('#add-schedule-btn');
                    }
                };

                getItemPriceErrorLabel() {
                    if (this.#priceManager.container) {
                        return this.#priceManager.container.querySelector('#error-price-schedule');
                    }
                };

                getItemDateErrorLabel() {
                    if (this.#priceManager.container) {
                        return this.#priceManager.container.querySelector('#error-date-schedule');
                    }
                };

                getDeleteItemBtns() {
                    if (this.#priceManager.container) {
                        return this.#priceManager.container.querySelectorAll('[row-action="delete-item-btn"]');
                    }
                };

                getExistedScheduleList() {
                    return this.#priceManager.getOrderItemScheduleList();
                };

                getDataItems() {
                    if (this.#priceManager.container) {
                        return this.#priceManager.container.querySelectorAll('[data-item="schedule-item"]');
                    }
                };

                // Handle errors
                showItemPriceErrorLabel() {

                    this.getItemPriceErrorLabel().classList.remove('d-none');
                };

                hideItemPriceErrorLabel() {

                    this.getItemPriceErrorLabel().classList.add('d-none');
                };

                showItemDateErrorLabel() {

                    this.getItemDateErrorLabel().classList.remove('d-none');
                };

                hideItemDateErrorLabel() {

                    this.getItemDateErrorLabel().classList.add('d-none');
                };

                // Actions
                #validateItemPriceInputValue() {

                    let priceValue = String(this.getSchedulePriceInputValue()).trim().replace(/[.\s,]/g, '');
                    let isValid = true;

                    isValid = String(parseFloat(priceValue)) === priceValue &&
                        (parseFloat(priceValue) >= 0) && (priceValue !== '');

                    if (!isValid) {
                        isValid = false;
                    } else {
                        isValid = true;
                    };

                    return isValid;
                };

                #validateItemDateInputValue() {
                    const dateInput = this.getScheduleDateInputValue();

                    if (!/^\d{4}-\d{2}-\d{2}$/.test(dateInput)) {
                        return false;
                    };

                    const parts = dateInput.split('-');
                    const year = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10);
                    const day = parseInt(parts[2], 10);

                    if (year < 1000 || year > 9999 || month < 1 || month > 12 || day < 1 || day > 31) {
                        return false;
                    };

                    if (day > 30 && (month === 4 || month === 6 || month === 9 || month === 11)) {
                        return false;
                    };

                    // Validate leap years
                    if (month === 2) {
                        const isLeapYear = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);

                        if (day > 29 || (day > 28 && !isLeapYear)) {
                            return false;
                        };
                    };

                    return true;
                };

                observePriceAfterDiscountChanges() {
                    const priceAfterDiscount = this.#priceManager.getPriceBeforeDiscountLabel();

                    const observer = new MutationObserver((mutationsList) => {
                        for (const mutation of mutationsList) {
                            if (mutation.type === 'childList') {
                                this.#render();
                            };
                        };
                    });

                    if (priceAfterDiscount) {
                        observer.observe(priceAfterDiscount, {
                            childList: true
                        });
                    };
                };

                #addScheduleItem() {
                    // At the time of executing this function, the entered values for price and date have already been validated
                    let currPrice = parseFloat(String(this.getSchedulePriceInputValue()).trim().replace(/[.\s,]/g, ''));
                    let currDate = this.getScheduleDateInputValue();

                    const newItem = {
                        index: this.#scheduleItemIndex,
                        price: currPrice,
                        date: currDate
                    };

                    this.#scheduleItems.push(newItem);
                    this.#upIndex();
                    this.#render();
                };

                #refreshScheduleItemInputForm() {
                    if (this.getSchedulePriceInput()) {
                        this.getSchedulePriceInput().value = '';
                    };

                    if (this.getScheduleDateInput()) {
                        this.getScheduleDateInput().value = '';
                    };

                    /** 
                     * Have to make the mask update its value using the updateValue() method to make it work; 
                     * This is a feature of the input mask;
                     * Unless => Input mask alert in console
                     */
                    if (this.#schedulePriceInputMask) {
                        this.#schedulePriceInputMask.updateValue("");
                    };
                };

                handleAddItemErrors() {
                    let handlePriceResult = false;
                    let handleDateResult = false;

                    if (!this.#validateItemPriceInputValue()) {
                        this.showItemPriceErrorLabel();
                        handlePriceResult = false;
                    } else {
                        this.hideItemPriceErrorLabel();
                        handlePriceResult = true;
                    };

                    if (!this.#validateItemDateInputValue()) {
                        this.showItemDateErrorLabel();
                        handleDateResult = false;
                    } else {
                        this.hideItemDateErrorLabel();
                        handleDateResult = true;
                    };

                    return handlePriceResult && handleDateResult;
                }

                #upIndex() {
                    this.#scheduleItemIndex++;
                };

                #getTotalPriceOfScheduleItems() {
                    return this.#scheduleItems.reduce((acc, curr) => acc + curr.price, 0);
                };

                #caculateBalancePrice() {
                    // let currPriceAfterDiscountValue = this.#priceManager.getPriceAfterDiscountValue();
                    let currPriceAfterDiscountValue = parseFloat(String(this.#priceManager.getPriceBeforeDiscountLabel().value).trim().replace(/[.\s,]/g, ''));
                    let currTotalPriceOfScheduleItems = this.#getTotalPriceOfScheduleItems();

                    /**
                     * In case currPriceAfterDiscountValue === 0, 
                     * Tt means the user has not entered a value for the selling price field yet
                     */
                    if (isNaN(currPriceAfterDiscountValue)) {
                        currPriceAfterDiscountValue = 0;
                    };

                    if (this.#priceManager.getCurrencyCodeInputValue() === "{!! \App\Models\Order::CURRENCY_CODE_USD !!}") {
                        let currExchange = this.#priceManager.getExchangePriceValue();
                        currPriceAfterDiscountValue /= currExchange;
                    };

                    return currPriceAfterDiscountValue - currTotalPriceOfScheduleItems;
                };

                updateBalanceLabel() {
                    if (this.getBalancePriceLabel()) {
                        this.getBalancePriceLabel().innerHTML = this.#priceManager.convertNumberWithCommas(this.#caculateBalancePrice());
                    };
                };

                // Refresh when render done
                refreshForm() {
                    this.#refreshScheduleItemInputForm();
                    this.updateBalanceLabel();
                };

                #removeItemByIndex(index) {
                    let itemToRemoveIndex = -1;

                    this.#scheduleItems.forEach(item => {

                        let flag = true;

                        if (item.index === parseInt(index)) {
                            itemToRemoveIndex = item.index;
                        };
                    });

                    const removeIndex = this.#scheduleItems.findIndex(schedule => schedule.index === itemToRemoveIndex);

                    if (removeIndex !== -1) {
                        this.#scheduleItems.splice(removeIndex, 1);
                        this.#render();
                    };
                };

                enableItems() {
                    const items = this.getDataItems();

                    if (items && items.length > 0) {
                        this.getDataItems().forEach(item => {
                            item.removeAttribute('disabled');
                        });
                    };
                };

                disableItems() {
                    const items = this.getDataItems();

                    if (items && items.length > 0) {
                        this.getDataItems().forEach(item => {
                            item.setAttribute('disabled', '');
                        });
                    };
                };

                #handleReloadScheduleForm(isShow) {
                    if (this.#priceManager.getPayAllCheckBox()) {
                        if (isShow) {
                            this.#priceManager.getPayAllCheckBox().checked = false;
                            this.#priceManager.getSchedulePaymentForm().classList.remove('d-none');
                            this.#priceManager.getDebtAllow().classList.add('d-none');


                            this.enableItems();
                        } else {
                            this.#priceManager.getPayAllCheckBox().checked = true;
                            this.#priceManager.getSchedulePaymentForm().classList.add('d-none');
                            this.#priceManager.getDebtAllow().classList.remove('d-none');


                            this.disableItems();
                        };
                    };
                };

                #loadExistedScheduleItemList() {
                    let existedList = this.getExistedScheduleList();

                    const isExisted = existedList !== null;

                    // this.#handleReloadScheduleForm(isExisted);

                    if (existedList) {
                        existedList.forEach(item => {
                            this.#scheduleItems.push({
                                index: this.#scheduleItemIndex,
                                price: item.price,
                                date: item.date,
                            });

                            this.#upIndex();
                        });
                    };

                    this.#render();
                };

                #init() {
                    // Init input mask
                    if (document.getElementById('schedule-price-input')) {
                        this.#schedulePriceInputMask = IMask(document.getElementById('schedule-price-input'), {
                            mask: Number,
                            scale: 2,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                            max: 999999999999,
                        });
                    };
                };

                /** 
                 * Render when: 
                 *  + Init instance 
                 *  + Add item 
                 *  + Remove item 
                 *  + Change value of price after discount => observePriceAfterDiscountChanges()
                 */
                #render() {
                    let content = '';

                    this.#scheduleItems.forEach(item => {
                        content +=
                            `
                        <li data-index=${item.index} class="list-group-item d-flex align-items-center justify-content-between">
                            <input type="hidden" name="schedule_items[]" data-item="schedule-item" value='${JSON.stringify({ price: item.price, date: item.date })}'>
                            <label class="fs-6 fw-semibold" for="target-input">${this.#priceManager.convertNumberWithCommas(item.price)}&nbsp;₫</div>&nbsp;&nbsp;|&nbsp;&nbsp;${this.#priceManager.convertDateFormat(item.date)}</label>
                            <span row-action="delete-item-btn" data-index=${item.index} class="material-symbols-rounded cursor-pointer">delete</span>
                        </li>
                    `
                    });

                    if (this.getListScheduleItemsForm()) {
                        this.getListScheduleItemsForm().innerHTML = content;
                    };

                    this.refreshForm();
                    this.#eventsAfterRender();
                    this.#priceManager.updateAllCurrencyDisplay();
                    $(this.getListScheduleItemsForm());

                    if (this.#priceManager.container) {
                        initJs(this.#priceManager.container);
                    };
                };

                #events() {
                    const _this = this;
                    this.#loadExistedScheduleItemList();

                    // When value of price after discount change
                    this.observePriceAfterDiscountChanges();

                    if (this.getAddScheduleButton()) {
                        this.getAddScheduleButton().addEventListener('click', e => {
                            e.preventDefault();

                            if (!this.handleAddItemErrors()) {
                                return;
                            };


                            this.#addScheduleItem();
                        });

                        $(_this.getScheduleDateInput()).keydown(function(event) {
                            if (event.keyCode == 13) {
                                if (!_this.handleAddItemErrors()) {
                                    return;
                                };

                                _this.#addScheduleItem();
                            }
                        })

                        $(_this.getSchedulePriceInput()).keydown(function(event) {
                            if (event.keyCode == 13) {
                                if (!_this.handleAddItemErrors()) {
                                    return;
                                };

                                _this.#addScheduleItem();
                            }
                        })

                        // $(window).keydown(function(event){
                        //     if(event.keyCode == 13) {
                        //         event.preventDefault();
                        //         return false;
                        //     }
                        // });
                    };
                };

                #eventsAfterRender() {
                    if (this.getDeleteItemBtns()) {
                        this.getDeleteItemBtns().forEach(button => {

                            button.addEventListener('click', e => {
                                e.preventDefault();

                                this.#removeItemByIndex(button.getAttribute('data-index'));
                            });
                        });
                    };
                };
            };

            var AddDemoOrderPopup = function() {
                var AddOrderPopup;

                return {
                    init: () => {
                        AddOrderPopup = new Popup();
                    },
                    updateUrl: newUrl => {
                        AddOrderPopup.url = newUrl;
                        AddOrderPopup.load();
                    },
                    getPopup: () => {
                        return AddOrderPopup;
                    }
                }
            }();

            var AddTrainOrderPopup = function() {
                var AddOrderPopup;

                return {
                    init: () => {
                        AddOrderPopup = new Popup();
                    },
                    updateUrl: newUrl => {
                        AddOrderPopup.url = newUrl;
                        AddOrderPopup.load();
                    },
                    getPopup: () => {
                        return AddOrderPopup;
                    }
                }
            }();

            var AddExtraItemPopup = function() {
                var popup;

                return {
                    init: () => {
                        popup = new Popup();
                    },
                    updateUrl: newUrl => {
                        popup.url = newUrl;
                        popup.load();
                    },
                    getPopup: () => {
                        return popup;
                    }
                }
            }();

            var AddAbroadOrderPopup = function() {
                var AddOrderPopup;

                return {
                    init: () => {
                        AddOrderPopup = new Popup();
                    },
                    updateUrl: newUrl => {
                        AddOrderPopup.url = newUrl;
                        AddOrderPopup.load();
                    },
                    getPopup: () => {
                        return AddOrderPopup;
                    }
                }
            }();

            var ServicesManager = class {
                #container;
                #servicesSystem;
                #serviceTypes = [];
                #packages = [];
                #types = [];
                #services = [];
                #levels = [];
                #currPackage;
                #currServiceType;
                #currType;
                #currService;
                #currLevel;
                #packageSelect;
                #typeSelect;
                #levelSelect;
                #orderTypeResponse = null;
                #dataResponse = {
                    package: null,
                    type: null,
                    service: null,
                    level: null
                };

                constructor(options) {
                    this.#servicesSystem = options.servicesSystem;
                }

                getServiceTypes() {
                    return this.#serviceTypes;
                };

                setServiceTypes(serviceTypes) {
                    this.#serviceTypes = serviceTypes;
                };

                getTypes() {
                    return this.#types;
                };

                setPackages(packages) {
                    this.#packages = packages;
                };

                setTypes(types) {
                    this.#types = types;
                };

                getServices() {
                    return this.#services;
                };

                setServices(services) {
                    this.#services = services;
                };

                getLevels() {
                    return this.#levels;
                };

                setLevels(levels) {
                    this.#levels = levels;
                };

                setContainer(popupContainerId) {
                    this.#container = document.querySelector(`#${popupContainerId}`);

                    if (this.#container.querySelector('[data-type="package"]')) {
                        this.setPackageSelect();
                        this.setTypeSelect();
                    } else {
                        this.setTypeSelect();
                    };

                    this.setCurrServiceType()
                };

                getPackages() {
                    return this.#packages;
                };

                getServicesSystem() {
                    return this.#servicesSystem;
                };

                getTypeSelect() {
                    return this.#typeSelect;
                };

                setTypeSelect() {
                    this.#typeSelect = this.#container.querySelector('[data-type="product"]');
                };

                setPackageSelect() {
                    this.#packageSelect = this.#container.querySelector('[data-type="package"]');
                };

                getPackageSelect() {
                    return this.#packageSelect;
                };

                getLevelSelect() {
                    return this.#container.querySelector('[data-type="product-level"]');
                };

                setLevelSelect() {
                    this.#levelSelect = this.#container.querySelector('[data-type="product-level"]');
                };

                getServiceSelect() {
                    return this.#container.querySelector('[data-type="product-service"]');
                };

                getCurrPackage() {
                    return this.#currPackage;
                };

                setCurrPackage(currPackage) {
                    if (currPackage && this.#currPackage !== currPackage) {
                        this.#currPackage = currPackage;
                        this.#dataResponse.package = currPackage;
                    } else if (currPackage == '') {
                        this.#currPackage = undefined;
                        this.#dataResponse.package = null;
                    };

                    this.#reloadTypes();
                };

                getCurrServiceType() {
                    return this.#currServiceType;
                };

                setCurrServiceType() {
                    let currServiceType = this.#container.querySelector('.type-input').value;

                    if (currServiceType && (this.#currServiceType !== currServiceType)) {
                        this.#currServiceType = currServiceType;
                    };

                    if (this.#currServiceType === {!! json_encode(App\Models\Order::TYPE_ABROAD) !!} && this.#container.querySelector(
                            '[data-type="package"]')) {
                        this.#reloadPackages();
                    } else {
                        this.#reloadTypes();
                    };
                };

                getCurrType() {
                    return this.#currType;
                };

                setCurrType(currType) {
                    if (currType && this.#currType !== currType) {
                        this.#currType = currType;
                        this.#dataResponse.type = currType;
                    } else if (currType == '') {
                        this.#currType = undefined;
                        this.#dataResponse.type = null;
                    };

                    this.#reloadServices();
                };

                getCurrService() {
                    return this.#currService;
                };

                setCurrService(currService) {
                    if (currService && this.#currService !== currService) {
                        this.#currService = currService;
                    } else if (currService == '') {
                        this.#currService = undefined;
                    }

                    this.#reloadLevels();
                };

                getCurrLvel() {
                    return this.#currLevel;
                };

                setCurrLevel(currlevel) {
                    if (currlevel && this.#currLevel !== currlevel) {
                        this.#currLevel = currlevel;
                    } else if (currlevel == '') {
                        this.#currLevel = undefined;
                    };
                };

                setOrderTypeResponse(orderTypeResponse) {
                    this.#orderTypeResponse = orderTypeResponse;
                };

                setDataResponse(dataResponse) {
                    if (dataResponse.package && dataResponse.package != '') {
                        this.#dataResponse.package = dataResponse.package;
                    } else {
                        this.#dataResponse.package = null;
                    };

                    if (dataResponse.type && dataResponse.type != '') {
                        this.#dataResponse.type = dataResponse.type;
                    } else {
                        this.#dataResponse.type = null;
                    };

                    if (dataResponse.service && dataResponse.service != '') {
                        this.#dataResponse.service = dataResponse.service;
                    } else {
                        this.#dataResponse.service = null;
                    };

                    if (dataResponse.level && dataResponse.level != '') {
                        this.#dataResponse.level = dataResponse.level;
                    } else {
                        this.#dataResponse.level = null;
                    };
                };

                loadPackages(packages) {
                    let orderPackageResponse = this.#dataResponse.package;
                    let packagesContent = `<option value="">Chọn</option>`;

                    if (Array.isArray(packages) && packages.length > 0) {

                        packages.forEach(packagesItem => {
                            let isSelected = '';
                            let value;
                            let key;

                            if (typeof packagesItem === 'string') {
                                value = packagesItem;
                                key = packagesItem;
                            } else if (typeof packagesItem === 'object' && !Array.isArray(packagesItem)) {
                                value = packagesItem['name'];
                                key = packagesItem['itemKey'];
                            } else {
                                value = '';
                            };

                            if (orderPackageResponse === key) {
                                isSelected = "selected";
                                this.setCurrPackage(key);
                            };

                            packagesContent += `<option ${isSelected} value="${key}">${value}</option>`
                        });
                    };

                    if (this.getPackageSelect()) {
                        this.getPackageSelect().innerHTML = packagesContent;
                    };

                    if (!orderPackageResponse) {
                        this.loadTypes(null);
                    };
                };

                loadTypes(types) {
                    let orderTypeResponse = this.#dataResponse.type;
                    let typeContent = `<option value="">Chọn</option>`;

                    if (Array.isArray(types) && types.length > 0) {
                        types.forEach(type => {
                            let isSelected = '';
                            let value;
                            let key;

                            if (typeof type === 'string') {
                                value = type;
                                key = type;
                            } else if (typeof type === 'object' && !Array.isArray(type)) {
                                value = type['name'];
                                key = type['itemKey'];
                            } else {
                                value = '';
                            };

                            if (orderTypeResponse === key) {
                                isSelected = "selected";
                                this.setCurrType(key);
                            };

                            typeContent += `<option ${isSelected} value="${key}">${value}</option>`;
                        });
                    };

                    if (this.getTypeSelect()) {
                        this.getTypeSelect().innerHTML = typeContent;
                        this.#dataResponse.package = null;
                    };

                    if (!orderTypeResponse) {
                        this.loadServices(null);
                    };
                };

                loadServices(services) {
                    let serviceResponse = this.#dataResponse.service;
                    let serviceContent = `<option value="">Chọn</option>`;

                    if (Array.isArray(services) && services.length > 0) {
                        services.forEach(service => {
                            let isSelected = '';
                            let value;
                            let key;

                            if (typeof service === 'string') {
                                value = service;
                                key = service;
                            } else if (typeof service === 'object' && !Array.isArray(service)) {
                                value = service['name'];
                                key = service['itemKey'];
                            } else {
                                value = '';
                            };

                            if (serviceResponse === key) {
                                isSelected = "selected";
                                this.setCurrService(key);
                            };

                            serviceContent += `<option ${isSelected} value="${key}">${value}</option>`;
                        });
                    };

                    if (this.getServiceSelect()) {
                        this.getServiceSelect().innerHTML = serviceContent;
                        this.#dataResponse.type = null;
                    };

                    if (!serviceResponse) {
                        this.loadLevels(null);
                    };
                };

                loadLevels(levels) {
                    let levelResponse = this.#dataResponse.level;
                    let levelContent = `<option value="">Chọn</option>`;

                    if (Array.isArray(levels) && levels.length > 0) {
                        levels.forEach(level => {
                            let isSelected = '';
                            let value;
                            let key;

                            if (typeof level === 'string') {
                                value = level;
                                key = level;
                            } else if (typeof level === 'object' && !Array.isArray(level)) {
                                value = level['name'];
                                key = level['itemKey'];
                            } else {
                                value = '';
                            };

                            if (levelResponse === key) {
                                isSelected = "selected";
                                this.setCurrLevel(key);
                            };

                            levelContent += `<option ${isSelected} value="${level}">${level}</option>`;
                        });
                    };

                    if (this.getLevelSelect()) {
                        this.getLevelSelect().innerHTML = levelContent;
                        this.#dataResponse.service = null;
                    };
                };

                #reloadPackages() {
                    const parentArray = this.getServicesSystem();
                    const currChild = this.getCurrServiceType();
                    let packageValues = [];
                    let packages = this.#getChilds(parentArray, currChild);
                    this.setPackages(packages);

                    if (currChild) {
                        packageValues = this.#getChildKeys(packages);
                    };

                    this.loadPackages(packageValues);
                };

                #reloadTypes() {
                    let parentArray;
                    let currChild;

                    if (this.#container.querySelector('[data-type="package"]')) {
                        parentArray = this.getPackages();
                        currChild = this.getCurrPackage();
                    } else {
                        parentArray = this.getServicesSystem();
                        currChild = this.getCurrServiceType();
                    };

                    let typeValues = [];
                    let types = this.#getChilds(parentArray, currChild);
                    this.setTypes(types);

                    if (currChild) {
                        typeValues = this.#getChildKeys(types);
                    };


                    this.loadTypes(typeValues);
                };

                #reloadServices() {
                    const types = this.getTypes();
                    const currType = this.getCurrType();

                    let serviceValues = [];
                    let services = this.#getChilds(types, currType);

                    this.setServices(services);

                    if (currType) {
                        serviceValues = this.#getChildKeys(services);
                    };

                    this.loadServices(serviceValues);
                };

                #reloadLevels() {
                    const services = this.getServices();
                    const currService = this.getCurrService();

                    let levelValues = [];
                    let levels = this.#getChilds(services, currService);

                    this.setLevels(levels);

                    if (currService) {
                        levelValues = this.#getChildKeys(levels);
                    };

                    this.loadLevels(levelValues);
                };

                #getChilds(parent, childKey) {
                    let childsArray = null;;

                    if (parent && childKey) {
                        parent.forEach(child => {
                            if (child) {
                                if (typeof child === 'string') {
                                    if (child === childKey) {
                                        childsArray = child;
                                    }
                                } else if (typeof child === 'object' && !Array.isArray(child)) {
                                    if (child['itemKey'].trim() === childKey.trim()) {
                                        childsArray = child.values;
                                    }
                                } else {
                                    childsArray = null;
                                };
                            }
                        });
                    };

                    return childsArray;
                };

                #getChildKeys(childs) {
                    let childKeys = [];

                    if (Array.isArray(childs)) {
                        childs.forEach(child => {
                            childKeys.push(child);
                        });
                    } else {
                        childKeys = null;
                    };

                    return childKeys;
                };

                showPopupEvents(popupContainerId) {
                    this.setContainer(popupContainerId)
                    this.events();
                };

                events() {
                    const _this = this;

                    if (this.getPackageSelect()) {
                        $(this.getPackageSelect()).on('change', function() {
                            _this.setCurrPackage(this.value);
                        });
                    };

                    if (this.getTypeSelect()) {
                        $(this.getTypeSelect()).on('change', function() {
                            _this.setCurrType(this.value);
                        });
                    };

                    if (this.getServiceSelect()) {
                        $(this.getServiceSelect()).on('change', function() {
                            _this.setCurrService(this.value);
                        });
                    };
                };
            };

            var ContactInfoBox = class {
                constructor(options) {
                    this.container = options.container;
                    this.selectBox = options.selectBox;
                    this.url = options.url;

                    // load
                    this.load();

                    // events
                    this.events();
                }

                events() {
                    $(this.selectBox).on('change', (e) => {
                        this.load();
                    });
                }

                getContactId() {
                    return $(this.selectBox).val();
                }

                getUrl() {
                    return this.url.replace('CONTACT_ID', this.getContactId());
                }

                load() {
                    if (!this.getContactId()) {
                        this.container.innerHTML = '';
                        return;
                    }

                    $.ajax({
                        url: this.getUrl(),
                        method: 'GET',
                    }).done(response => {
                        $(this.container).html(response);

                        if ($('#create-constract-content')[0]) {
                            initJs($('#create-constract-content')[0]);
                        };
                    });
                }
            };

            // Temporary not using
            var TrainingLocationHandle = class {
                constructor(options) {
                    this.container = options.container;

                    this.init();
                }

                getContainer() {
                    return this.container;
                }

                // Branch
                getBranchSelector() {
                    return this.getContainer().querySelector('#branch-select');
                }

                // Branch value selected
                getBranch() {
                    return this.getBranchSelector().value;
                }

                // Location
                getLocationSelector() {
                    return this.getContainer().querySelector('[name="training_location_id"]');
                }

                // Location value selected
                getLocation() {
                    return this.getLocationSelector().value;
                }

                changeBranch() {
                    this.queryLocations();
                }

                getLocationSelectedId() {
                    const id = "{{ isset($order->training_location_id) ? $order->training_location_id : '' }}";

                    return id;
                }

                createLocationsOptions(locations) {
                    let options = '<option value="">Chọn</option>';
                    const locationSelectedId = this.getLocationSelectedId();
                    let selected = '';

                    locations.forEach(i => {
                        const id = i.id;
                        const name = i.name;

                        if (parseInt(i.id) === parseInt(locationSelectedId)) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }

                        options += `<option value="${id}" ${selected}>${name}</option> `;
                    })

                    return options;
                }

                // Call ajax to get all locations froms server
                queryLocations() {
                    const _this = this;
                    const branch = this.getBranch();
                    const url = "{!! action(
                        [App\Http\Controllers\TrainingLocationController::class, 'getTrainingLocationsByBranch'],
                        ['branch' => 'PLACEHOLDER'],
                    ) !!}";
                    const updateUrl = url.replace('PLACEHOLDER', branch);

                    $.ajax({
                        url: updateUrl,
                        method: 'get'
                    }).done(response => {
                        const options = _this.createLocationsOptions(response);

                        _this.getLocationSelector().innerHTML = options;
                    }).fail(response => {
                        throw new Error(response.message);
                    })
                }

                init() {
                    this.events();
                }

                events() {
                    const _this = this;

                    // Remove events before add event handle
                    _this.getBranchSelector().outerHTML = _this.getBranchSelector().outerHTML;

                    $(_this.getBranchSelector()).on('change', function(e) {
                        e.preventDefault();
                        _this.changeBranch();
                    })
                }
            }

            var ServicesManager = class {
                #container;
                #servicesSystem;
                #serviceTypes = [];
                #packages = [];
                #types = [];
                #services = [];
                #levels = [];
                #currPackage;
                #currServiceType;
                #currType;
                #currService;
                #currLevel;
                #packageSelect;
                #typeSelect;
                #levelSelect;
                #orderTypeResponse = null;
                #dataResponse = {
                    package: null,
                    type: null,
                    service: null,
                    level: null
                };

                constructor(options) {
                    this.#servicesSystem = options.servicesSystem;
                }

                getServiceTypes() {
                    return this.#serviceTypes;
                };

                setServiceTypes(serviceTypes) {
                    this.#serviceTypes = serviceTypes;
                };

                getTypes() {
                    return this.#types;
                };

                setPackages(packages) {
                    this.#packages = packages;
                };

                setTypes(types) {
                    this.#types = types;
                };

                getServices() {
                    return this.#services;
                };

                setServices(services) {
                    this.#services = services;
                };

                getLevels() {
                    return this.#levels;
                };

                setLevels(levels) {
                    this.#levels = levels;
                };

                setContainer(popupContainerId) {
                    this.#container = document.querySelector(`#${popupContainerId}`);

                    if (this.#container.querySelector('[data-type="package"]')) {
                        this.setPackageSelect();
                        this.setTypeSelect();
                    } else {
                        this.setTypeSelect();
                    };

                    this.setCurrServiceType()
                };

                getPackages() {
                    return this.#packages;
                };

                getServicesSystem() {
                    return this.#servicesSystem;
                };

                getTypeSelect() {
                    return this.#typeSelect;
                };

                setTypeSelect() {
                    this.#typeSelect = this.#container.querySelector('[data-type="product"]');
                };

                setPackageSelect() {
                    this.#packageSelect = this.#container.querySelector('[data-type="package"]');
                };

                getPackageSelect() {
                    return this.#packageSelect;
                };

                getLevelSelect() {
                    return this.#container.querySelector('[data-type="product-level"]');
                };

                setLevelSelect() {
                    this.#levelSelect = this.#container.querySelector('[data-type="product-level"]');
                };

                getServiceSelect() {
                    return this.#container.querySelector('[data-type="product-service"]');
                };

                getCurrPackage() {
                    return this.#currPackage;
                };

                setCurrPackage(currPackage) {
                    if (currPackage && this.#currPackage !== currPackage) {
                        this.#currPackage = currPackage;
                        this.#dataResponse.package = currPackage;
                    } else if (currPackage == '') {
                        this.#currPackage = undefined;
                        this.#dataResponse.package = null;
                    };

                    this.#reloadTypes();
                };

                getCurrServiceType() {
                    return this.#currServiceType;
                };

                setCurrServiceType() {
                    let currServiceType = this.#container.querySelector('.type-input').value;

                    if (currServiceType && (this.#currServiceType !== currServiceType)) {
                        this.#currServiceType = currServiceType;
                    };

                    if (this.#currServiceType === {!! json_encode(App\Models\Order::TYPE_ABROAD) !!} && this.#container.querySelector(
                            '[data-type="package"]')) {
                        this.#reloadPackages();
                    } else {
                        this.#reloadTypes();
                    };
                };

                getCurrType() {
                    return this.#currType;
                };

                setCurrType(currType) {
                    if (currType && this.#currType !== currType) {
                        this.#currType = currType;
                        this.#dataResponse.type = currType;
                    } else if (currType == '') {
                        this.#currType = undefined;
                        this.#dataResponse.type = null;
                    };

                    this.#reloadServices();
                };

                getCurrService() {
                    return this.#currService;
                };

                setCurrService(currService) {
                    if (currService && this.#currService !== currService) {
                        this.#currService = currService;
                    } else if (currService == '') {
                        this.#currService = undefined;
                    }

                    this.#reloadLevels();
                };

                getCurrLvel() {
                    return this.#currLevel;
                };

                setCurrLevel(currlevel) {
                    if (currlevel && this.#currLevel !== currlevel) {
                        this.#currLevel = currlevel;
                    } else if (currlevel == '') {
                        this.#currLevel = undefined;
                    };
                };

                setOrderTypeResponse(orderTypeResponse) {
                    this.#orderTypeResponse = orderTypeResponse;
                };

                setDataResponse(dataResponse) {
                    if (dataResponse.package && dataResponse.package != '') {
                        this.#dataResponse.package = dataResponse.package;
                    } else {
                        this.#dataResponse.package = null;
                    };

                    if (dataResponse.type && dataResponse.type != '') {
                        this.#dataResponse.type = dataResponse.type;
                    } else {
                        this.#dataResponse.type = null;
                    };

                    if (dataResponse.service && dataResponse.service != '') {
                        this.#dataResponse.service = dataResponse.service;
                    } else {
                        this.#dataResponse.service = null;
                    };

                    if (dataResponse.level && dataResponse.level != '') {
                        this.#dataResponse.level = dataResponse.level;
                    } else {
                        this.#dataResponse.level = null;
                    };
                };

                loadPackages(packages) {
                    let orderPackageResponse = this.#dataResponse.package;
                    let packagesContent = `<option value="">Chọn</option>`;

                    if (Array.isArray(packages) && packages.length > 0) {

                        packages.forEach(packagesItem => {
                            let isSelected = '';
                            let value;
                            let key;

                            if (typeof packagesItem === 'string') {
                                value = packagesItem;
                                key = packagesItem;
                            } else if (typeof packagesItem === 'object' && !Array.isArray(packagesItem)) {
                                value = packagesItem['name'];
                                key = packagesItem['itemKey'];
                            } else {
                                value = '';
                            };

                            if (orderPackageResponse === key) {
                                isSelected = "selected";
                                this.setCurrPackage(key);
                            };

                            packagesContent += `<option ${isSelected} value="${key}">${value}</option>`
                        });
                    };

                    if (this.getPackageSelect()) {
                        this.getPackageSelect().innerHTML = packagesContent;
                    };

                    if (!orderPackageResponse) {
                        this.loadTypes(null);
                    };
                };

                loadTypes(types) {
                    let orderTypeResponse = this.#dataResponse.type;
                    let typeContent = `<option value="">Chọn</option>`;

                    if (Array.isArray(types) && types.length > 0) {
                        types.forEach(type => {
                            let isSelected = '';
                            let value;
                            let key;

                            if (typeof type === 'string') {
                                value = type;
                                key = type;
                            } else if (typeof type === 'object' && !Array.isArray(type)) {
                                value = type['name'];
                                key = type['itemKey'];
                            } else {
                                value = '';
                            };

                            if (orderTypeResponse === key) {
                                isSelected = "selected";
                                this.setCurrType(key);
                            };

                            typeContent += `<option ${isSelected} value="${key}">${value}</option>`;
                        });
                    };

                    if (this.getTypeSelect()) {
                        this.getTypeSelect().innerHTML = typeContent;
                        this.#dataResponse.package = null;
                    };

                    if (!orderTypeResponse) {
                        this.loadServices(null);
                    };
                };

                loadServices(services) {
                    let serviceResponse = this.#dataResponse.service;
                    let serviceContent = `<option value="">Chọn</option>`;

                    if (Array.isArray(services) && services.length > 0) {
                        services.forEach(service => {
                            let isSelected = '';
                            let value;
                            let key;

                            if (typeof service === 'string') {
                                value = service;
                                key = service;
                            } else if (typeof service === 'object' && !Array.isArray(service)) {
                                value = service['name'];
                                key = service['itemKey'];
                            } else {
                                value = '';
                            };

                            if (serviceResponse === key) {
                                isSelected = "selected";
                                this.setCurrService(key);
                            };

                            serviceContent += `<option ${isSelected} value="${key}">${value}</option>`;
                        });
                    };

                    if (this.getServiceSelect()) {
                        this.getServiceSelect().innerHTML = serviceContent;
                        this.#dataResponse.type = null;
                    };

                    if (!serviceResponse) {
                        this.loadLevels(null);
                    };
                };

                loadLevels(levels) {
                    let levelResponse = this.#dataResponse.level;
                    let levelContent = `<option value="">Chọn</option>`;

                    if (Array.isArray(levels) && levels.length > 0) {
                        levels.forEach(level => {
                            let isSelected = '';
                            let value;
                            let key;

                            if (typeof level === 'string') {
                                value = level;
                                key = level;
                            } else if (typeof level === 'object' && !Array.isArray(level)) {
                                value = level['name'];
                                key = level['itemKey'];
                            } else {
                                value = '';
                            };

                            if (levelResponse === key) {
                                isSelected = "selected";
                                this.setCurrLevel(key);
                            };

                            levelContent += `<option ${isSelected} value="${level}">${level}</option>`;
                        });
                    };

                    if (this.getLevelSelect()) {
                        this.getLevelSelect().innerHTML = levelContent;
                        this.#dataResponse.service = null;
                    };
                };

                #reloadPackages() {
                    const parentArray = this.getServicesSystem();
                    const currChild = this.getCurrServiceType();
                    let packageValues = [];
                    let packages = this.#getChilds(parentArray, currChild);
                    this.setPackages(packages);

                    if (currChild) {
                        packageValues = this.#getChildKeys(packages);
                    };

                    this.loadPackages(packageValues);
                };

                #reloadTypes() {
                    let parentArray;
                    let currChild;

                    if (this.#container.querySelector('[data-type="package"]')) {
                        parentArray = this.getPackages();
                        currChild = this.getCurrPackage();
                    } else {
                        parentArray = this.getServicesSystem();
                        currChild = this.getCurrServiceType();
                    };

                    let typeValues = [];
                    let types = this.#getChilds(parentArray, currChild);
                    this.setTypes(types);

                    if (currChild) {
                        typeValues = this.#getChildKeys(types);
                    };


                    this.loadTypes(typeValues);
                };

                #reloadServices() {
                    const types = this.getTypes();
                    const currType = this.getCurrType();

                    let serviceValues = [];
                    let services = this.#getChilds(types, currType);

                    this.setServices(services);

                    if (currType) {
                        serviceValues = this.#getChildKeys(services);
                    };

                    this.loadServices(serviceValues);
                };

                #reloadLevels() {
                    const services = this.getServices();
                    const currService = this.getCurrService();

                    let levelValues = [];
                    let levels = this.#getChilds(services, currService);

                    this.setLevels(levels);

                    if (currService) {
                        levelValues = this.#getChildKeys(levels);
                    };

                    this.loadLevels(levelValues);
                };

                #getChilds(parent, childKey) {
                    let childsArray = null;;

                    if (parent && childKey) {
                        parent.forEach(child => {
                            if (child) {
                                if (typeof child === 'string') {
                                    if (child === childKey) {
                                        childsArray = child;
                                    }
                                } else if (typeof child === 'object' && !Array.isArray(child)) {
                                    if (child['itemKey'].trim() === childKey.trim()) {
                                        childsArray = child.values;
                                    }
                                } else {
                                    childsArray = null;
                                };
                            }
                        });
                    };

                    return childsArray;
                };

                #getChildKeys(childs) {
                    let childKeys = [];

                    if (Array.isArray(childs)) {
                        childs.forEach(child => {
                            childKeys.push(child);
                        });
                    } else {
                        childKeys = null;
                    };

                    return childKeys;
                };

                showPopupEvents(popupContainerId) {
                    this.setContainer(popupContainerId)
                    this.events();
                };

                events() {
                    const _this = this;

                    if (this.getPackageSelect()) {
                        $(this.getPackageSelect()).on('change', function() {
                            _this.setCurrPackage(this.value);
                        });
                    };

                    if (this.getTypeSelect()) {
                        $(this.getTypeSelect()).on('change', function() {
                            _this.setCurrType(this.value);
                        });
                    };

                    if (this.getServiceSelect()) {
                        $(this.getServiceSelect()).on('change', function() {
                            _this.setCurrService(this.value);
                        });
                    };
                };
            };

            var servicesManager = new ServicesManager({
                servicesSystem: {!! json_encode(config('constractServices')) !!}
            });
        </script>
    </div>
@endsection
