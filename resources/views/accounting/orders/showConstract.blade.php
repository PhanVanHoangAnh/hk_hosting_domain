@extends('layouts.main.popup')

@section('title')
    Thông tin hợp đồng
    <td data-column="status" class="text-left" data-filter="mastercard">
        @php
            $bgs = [
                App\Models\Order::STATUS_DRAFT => 'secondary',
                App\Models\Order::STATUS_PENDING => 'warning',
                App\Models\Order::STATUS_APPROVED => 'success',
                App\Models\Order::STATUS_REJECTED => 'danger text-white',
            ];
        @endphp
        @if ($order->isRejected())
            <span title="{{ $order->rejected_reason }}" class="badge bg-{{ $bgs[$order->status] ?? 'info' }}"
                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                {{ trans('messages.order.status.' . $order->status) }}
            </span>
        @else
            <span
                class="badge bg-{{ $bgs[$order->status] ?? 'info' }}">{{ trans('messages.order.status.' . $order->status) }}</span>
        @endif
    </td>
@endsection

@section('content')
    <div id="showConstractContainer">
        @csrf
        <div class="scroll-y px-7 px-lg-17">
            <div class="row">
                <div class="col-md-6">
                    <div class="modal-body flex-end px-0 justify-content-end">
                        @if (Auth::user()->can('approve', $order))
                            <a data-ids="{{ $order->id }}" row-action="approveDetail"
                                href="{{ action(
                                    [App\Http\Controllers\Accounting\OrderController::class, 'approve'],
                                    [
                                        'id' => $order->id,
                                    ],
                                ) }}"
                                class="btn btn-light me-5">
                                <span class="indicator-label fw-bold">Duyệt</span>
                            </a>
                        @endif
                        @if (Auth::user()->can('reject', $order))
                            <a data-ids="{{ $order->id }}" class="btn btn-light" row-action="rejectDetail"
                                row-action="reject"
                                href="{{ action(
                                    [App\Http\Controllers\Accounting\OrderController::class, 'reject'],
                                    [
                                        'id' => $order->id,
                                    ],
                                ) }}">
                                <span class="indicator-label fw-bold">Từ chối duyệt</span>
                            </a>
                        @endif
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="modal-body flex-end px-0 d-flex justify-content-end">
                        <button data-ids="{{ $order->id }}" row-action="update" id="editConstractBtn"
                            class="btn btn-light me-5 d-none">
                            <span class="indicator-label fw-bold">Chỉnh sửa</span>
                        </button>
                        {{-- <button data-ids="{{ $order->id }}" data-action="under-construction" class="btn btn-light">
                            <span class="indicator-label fw-bold">Xuất PDF</span>
                        </button>
                         --}}
                        <a row-action="export-pdf" class='btn btn-light'
                            href="{{ action(
                                [App\Http\Controllers\Accounting\OrderController::class, 'exportOrder'],
                                [
                                    'id' => $order->id,
                                ],
                            ) }}">
                            <span class="indicator-label fw-bold">Xuất PDF</span>
                        </a>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="form-control">
                        <h2 class="text-info text-nowrap mt-5 mb-5">
                            Thông tin chung
                            <span title="{{ $order->rejected_reason }}" class="badge bg-warning" data-bs-toggle="tooltip"
                                data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                {{ trans('messages.order.type.' . $order->type) }}
                            </span>
                        </h2>

                        <div class="row d-flex justify-content-between">
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Ngày:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->created_at->format('d/m/Y') }}</div>
                                    </div>
                                </div>
                                @if ($order->contactRequest)
                                    <div class="fv-row my-3 d-flex border-bottom">
                                        <div
                                            class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                            <label class="fs-6 fw-semibold mb-2">
                                                <span class="fw-bold">Số request:</span>
                                            </label>
                                        </div>
                                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                            <div>{{ $order->contactRequest->code }}</div>
                                        </div>
                                    </div>
                                @endif
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Số hợp đồng:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->code }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Sale sup:</span>
                                        </label>
                                    </div>
                                    <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                        <div>
                                            {{ App\Models\Account::find($order->sale_sup) ? App\Models\Account::find($order->sale_sup)->name : '' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Sale:</span>
                                        </label>
                                    </div>
                                    <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                        <div>
                                            {{ App\Models\Account::find($order->sale) ? App\Models\Account::find($order->sale)->name : '' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Mã học viên:</span>
                                        </label>
                                    </div>
                                    <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                        <div>
                                            {{ $order->student ? $order->student->code : ''  }}
                                        </div>
                                    </div>
                                </div>
                            </div>



                        </div>

                        <h2 class="text-info text-nowrap mt-10 mb-3">
                            @if ($order->contact_id == $order->student_id)
                                Khách hàng, Người ký hợp đồng, Học viên
                            @else
                                {{ trans('messages.order.customer_name') }}
                            @endif
                        </h2>

                        <div class="row d-flex justify-content-between mt-3">
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Họ và tên:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->contacts->name }}</div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Ngày tháng năm sinh:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>
                                            {{ $order->contacts->birthday ? date('d/m/Y', strtotime($order->contacts->birthday)) : '--' }}
                                        </div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Số điện thoại:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->contacts->phone }}</div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Email:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->contacts->email }}</div>
                                    </div>
                                </div>

                                @if ($order->contact_id != $order->student_id)
                                    <div class="fv-row my-3 d-flex border-bottom">
                                        <div
                                            class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                            <label class="fs-6 fw-semibold mb-2">
                                                <span class="fw-bold">Quan hệ với học viên:</span>
                                            </label>
                                        </div>
                                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                            <div>{{ $order->getRelationshipName() }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                        @if ($order->contact_id != $order->student_id)
                            <h2 class="text-info text-nowrap mt-10 mb-3">
                                Thông tin học viên
                            </h2>

                            <div class="row d-flex justify-content-between mt-3">


                                <div class="row d-flex justify-content-between mt-3">
                                    <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                        <div class="fv-row my-3 d-flex border-bottom">
                                            <div
                                                class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="fw-bold">Họ và tên:</span>
                                                </label>
                                            </div>
                                            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                                <div>{{ $order->student->name }}</div>
                                            </div>
                                        </div>
                                        <div class="fv-row my-3 d-flex border-bottom">
                                            <div
                                                class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="fw-bold">Ngày tháng năm sinh:</span>
                                                </label>
                                            </div>
                                            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                                <div>
                                                    {{ $order->student->birthday ? date('d/m/Y', strtotime($order->student->birthday)) : '--' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fv-row my-3 d-flex border-bottom">
                                            <div
                                                class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="fw-bold">Số điện thoại:</span>
                                                </label>
                                            </div>
                                            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                                <div>{{ $order->student->phone }}</div>
                                            </div>
                                        </div>
                                        <div class="fv-row my-3 d-flex border-bottom">
                                            <div
                                                class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                                <label class="fs-6 fw-semibold mb-2">
                                                    <span class="fw-bold">Email:</span>
                                                </label>
                                            </div>
                                            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                                <div>{{ $order->student->email }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if ($order->isEdu())
                <h2 class="text-info text-nowrap mt-10 mb-5 ">
                    Dự toán
                </h2>

                <div class=" ">
                    <?php
                        if(count($orderItems) > 0) {
                        ?>

                    <div class="form-outline">
                        @foreach ($orderItems as $orderItem)
                            @if ($orderItem->type === App\Models\OrderItem::TYPE_EDU)
                               
                                <div class="d-flex align-items-center">
                                    <p class="fs-5 fw-bold my-5 d-flex align-items-center">
                                        {{ $orderItem->subject->name ?? '--' }}
                                    </p>
                                    <a class="d-flex flex-center rotate-n180 ms-3" data-bs-toggle="collapse" class=" px-5 rotate collapsible collapsed" href="#revenue_price_{{$orderItem->id}}" id="show">
                                        <i class="ki-duotone ki-down fs-3"></i>
                                    </a>
                                </div>
                                
                                <div class="collapse" id="revenue_price_{{$orderItem->id}}">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Giáo viên nước ngoài</label>
                                        <select id="foreign-teachers-select-{{$orderItem->id}}" list-action="teacher-filter-select" class="form-select filter-select"
                                            data-control="select2" data-kt-customer-table-filter="month"
                                            data-placeholder="Chọn giáo viên nước ngoài" data-allow-clear="true" multiple="multiple">
                                            @foreach ($orderItem->getForeignTeachers() as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Giáo viên Việt Nam</label>
                                        <select id="vietnam-teachers-select-{{$orderItem->id}}" list-action="teacher-filter-select" class="form-select filter-select"
                                            data-control="select2" data-kt-customer-table-filter="month"
                                            data-placeholder="Chọn giáo viên Việt Nam" data-allow-clear="true" multiple="multiple">
                                            @foreach ($orderItem->getVietnameseTeachers() as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-5">
                                        <!--begin::Label-->
                                        <label class="form-label fw-semibold">Gia sư</label>
                                        <select id="tutor-teachers-select-{{$orderItem->id}}" list-action="teacher-filter-select" class="form-select filter-select"
                                            data-control="select2" data-kt-customer-table-filter="month"
                                            data-placeholder="Chọn gia sư" data-allow-clear="true" multiple="multiple">
                                            @foreach ($orderItem->getTutorTeachers() as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                    <div class=" card px-5 py-5 table-responsive ">
                                        <!--begin::Table-->
                                        <div id="selected-teachers-table" class="table-responsive table-head-sticky">
                                            <table class="table align-middle table-row-dashed fs-6 gy-5">
                                                <thead>
                                                    <tr
                                                        class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                                        <th class="min-w-200px text-left">Giảng viên</th>
                                                        <th class="min-w-125px text-left">Giờ dạy Việt Nam</th>
                                                        <th class="min-w-125px text-left">Giờ dạy nước ngoài</th>
                                                        <th class="min-w-125px text-left">Giờ dạy gia sư</th>
                                                        <th class="min-w-125px text-left">Giá trị dịch vụ</th>
                                                        <th class="min-w-125px text-left">Chi phí giảng viên</th>
                                                        <th class="min-w-125px text-left">Chênh lệch</th>
                                                        <th class="min-w-125px text-left">Lãi lỗ - Tỷ lệ</th>
                                                        <th class="min-w-125px text-left">Chọn giảng viên</th>
    
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600">
    
                                                    @foreach ($orderItem->getTeachers() as $teacher)
                                                        <tr id="teacher_{{ $teacher->id }}">
                                                            <td class="text-left">{{ $teacher->name }} </td>
                                                            <td class="text-center">
                                                                {{ $teacher->checkIsVietnam() ? number_format($orderItem->getTotalVnMinutes() / 60, 1) . ' giờ' : '--' }}
                                                            </td>
    
                                                            <td class="text-center">
                                                                {{ $teacher->checkIsForeign() ? number_format($orderItem->getTotalForeignMinutes() / 60, 1) . ' giờ' : '--' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $teacher->checkIsTutor() ? number_format($orderItem->getTotalTutorMinutes() / 60, 1) . ' giờ' : '--' }}
                                                            </td>
                                                            <td class="text-left">
                                                                {{ $teacher->checkIsVietnam() ? App\Helpers\Functions::formatNumber($orderItem->vn_teacher_price) . '₫' : '' }}
                                                                {{ $teacher->checkIsForeign() ? App\Helpers\Functions::formatNumber($orderItem->foreign_teacher_price) . '₫' : '' }}
                                                                {{ $teacher->checkIsTutor() ? App\Helpers\Functions::formatNumber($orderItem->tutor_price) . '₫' : '' }}
                                                                
                                                            </td>
                                                            
                                                            <td class="text-left ">
                                                                {{ $teacher->getAmountForSubject($orderItem->subject_id) ? App\Helpers\Functions::formatNumber($teacher->calculateTotalAmountForOrderItem($orderItem)) . '₫' : '--' }}
    
    
                                                            </td>
                                                            <td class="text-left">
                                                                {{ $teacher->checkIsVietnam() && $teacher->getAmountForSubject($orderItem->subject_id) ? App\Helpers\Functions::formatNumber($orderItem->vn_teacher_price - $teacher->calculateTotalAmountForOrderItem($orderItem))  . '₫' : '' }}
    
                                                                {{ $teacher->checkIsForeign() && $teacher->getAmountForSubject($orderItem->subject_id) ? App\Helpers\Functions::formatNumber($orderItem->foreign_teacher_price - $teacher->calculateTotalAmountForOrderItem($orderItem))  . '₫' : '' }}
                                                                
                                                                {{ $teacher->checkIsTutor() && $teacher->getAmountForSubject($orderItem->subject_id) ? App\Helpers\Functions::formatNumber($orderItem->tutor_price - $teacher->calculateTotalAmountForOrderItem($orderItem))  . '₫' : '' }}
                                                                
    
                                                            </td>
                                                            <td>
                                                                 {{-- tỉ lệ lãi/lỗ cho giáo viên Việt Nam --}}
                                                                @if($teacher->checkIsVietnam())
                                                                    @php
                                                                        $teacherPrice = $orderItem->vn_teacher_price;
                                                                        $teacherCost = $teacher->calculateTotalAmountForOrderItem($orderItem);
                                                                        $profitPercentage = ($teacherPrice != 0) ? (($teacherPrice - $teacherCost) / $teacherPrice) * 100 : 0;
                                                                    @endphp
                                                                    {{ number_format($profitPercentage, 2) }}%
                                                                @endif

                                                                {{-- tỉ lệ lãi/lỗ cho giáo viên nước ngoài --}}
                                                                @if($teacher->checkIsForeign())
                                                                    @php
                                                                        $teacherPrice = $orderItem->foreign_teacher_price;
                                                                        $teacherCost = $teacher->calculateTotalAmountForOrderItem($orderItem);
                                                                        $profitPercentage = ($teacherPrice != 0) ? (($teacherPrice - $teacherCost) / $teacherPrice) * 100 : 0;
                                                                    @endphp
                                                                    {{ number_format($profitPercentage, 2) }}%
                                                                @endif

                                                                {{-- tỉ lệ lãi/lỗ cho gia sư --}}
                                                                @if($teacher->checkIsTutor())
                                                                    @php
                                                                        $teacherPrice = $orderItem->tutor_price;
                                                                        $teacherCost = $teacher->calculateTotalAmountForOrderItem($orderItem);
                                                                        $profitPercentage = ($teacherPrice != 0) ? (($teacherPrice - $teacherCost) / $teacherPrice) * 100 : 0;
                                                                    @endphp
                                                                
                                                                    {{ number_format($profitPercentage, 2) }}%
                                                                @endif

                                                            </td>
                                                            <td class="ps-1 ">
                                                                <div class="text-center ">
                                                                    <input list-action="check-item" 
                                                                        class="form-check-input"
                                                                        data-order-item-total="{{ \App\Helpers\Functions::convertStringPriceToNumber($orderItem->price) }}"
                                                                        data-order-item-id="{{ $orderItem->id }}"
                                                                        data-expense-class="expense"
                                                                        {{ !$teacher->getAmountForSubject($orderItem->subject_id) ? 'disabled' : '' }}
                                                                        type="radio" name="{{$teacher->type}}"
                                                                        value="{{ $teacher->calculateTotalAmountForOrderItem($orderItem) }}" />
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row pt-5">
                                        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 col-12">
                                            <div
                                                class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border  px-5 bg-white py-2 border-gray-400">
                                                <div class="py-0">
                                                    <div class="card-title d-flex flex-column">
                                                        <div class="d-flex align-items-top">
                                                            <div>
                                                                <span name='price-amount'
                                                                    data-order-item-id="{{ $orderItem->id }}"
                                                                    class="fs-1 fw-semibold total">
                                                                    {{ App\Helpers\Functions::formatNumber($orderItem->price) }}₫
                                                                </span>
                                                                <span class="d-block text-gray-400 fw-semibold fs-6">Giá trị dịch
                                                                    vụ</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 col-12">
                                            <div
                                                class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border  px-5 bg-white py-2 border-gray-400">
                                                <div class="py-0">
                                                    <div class="card-title d-flex flex-column">
                                                        <div class="d-flex align-items-top">
                                                            <div>
                                                                <span name='price-amount'
                                                                    data-order-item-id="{{ $orderItem->id }}"
                                                                    class="fs-1 fw-semibold expense"> --</span>
                                                                <span class="d-block text-gray-400 fw-semibold fs-6">Chi phí</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
                                        <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 col-12">
                                            <div
                                                class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border  px-5 bg-white py-2 border-gray-400">
                                                <div class="py-0">
                                                    <div class="card-title d-flex flex-column">
                                                        <div class="d-flex align-items-top">
                                                            <div>
                                                                <span name='price-amount'
                                                                    data-order-item-id="{{ $orderItem->id }}"
                                                                    class="fs-1 fw-semibold profit">-- </span>
                                                                <span class="d-block text-gray-400 fw-semibold fs-6">Chênh
                                                                    lệch</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
    
    
                                    </div>
                                </div>
                               
                            @endif
                        @endforeach
                    </div>

                    <?php 
                        } else {
                        ?>
                    <div class="text-center">
                        <label class="fs-6 fw-semibold fs-3 d-flex align-items-center justify-content-center"
                            for="order-type-select">
                            Chưa có dịch vụ nào!
                        </label>
                    </div>
                    <?php
                        }
                        ?>
                </div>
            @endif
            @if ($order->isEdu())
                <div class="row w-100  ms-auto d-flex justify-content-around ">
                    <div class="col-10 ps-0">
                        <h2 class="text-info text-nowrap mt-5 mb-5 ">
                            Trạng thái thanh toán
                        </h2>

                    </div>
                    <div class="col-2 text-end my-auto">
                        <td data-column="status" class="text-left" data-filter="mastercard">

                            @php
                                $bgs = [
                                    App\Models\PaymentReminder::STATUS_PAID => 'success',
                                    App\Models\PaymentReminder::STATUS_UNPAID => 'danger text-white',
                                ];

                                $overallStatus = \App\Models\PaymentReminder::STATUS_UNPAID;

                                if ($order->getTotal() <= $order->sumAmountPaid()) {
                                    $overallStatus = \App\Models\PaymentReminder::STATUS_PAID;
                                }

                            @endphp

                            <span title="{{ trans('messages.payment_reminders.status.' . $overallStatus) }}"
                                class="badge bg-{{ $bgs[$overallStatus] ?? 'info' }}">
                                {{ trans('messages.payment_reminders.status.' . $overallStatus) }}
                            </span>

                        </td>
                    </div>

                </div>


                <div class="row">
                    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 col-12">
                        <div
                            class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border  px-5 bg-white py-2 border-gray-400">
                            <!--begin::Header-->
                            <div class="card-header py-0">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column" data-action="under-construction">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-top">
                                        <div>
                                            <!--begin::Amount-->
                                            <span
                                                class="me-0 text-primary  fs-1 fw-semibold">{{ number_format($order->getTotal(), 0, '.', ',') }}₫</span>
                                            <!--end::Amount-->

                                            <span class="d-block text-gray-400 fw-semibold fs-6">Tổng giá trị</span>
                                            <!--end::Badge-->
                                        </div>

                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 col-12">
                        <div
                            class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border  px-5 bg-white py-2 border-gray-400">
                            <!--begin::Header-->
                            <div class="card-header py-0">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column" data-action="under-construction">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-top">
                                        <div>
                                            <!--begin::Amount-->
                                            <span
                                                class="fs-1 fw-semibold">{{ number_format($order->sumAmountPaid(), 0, '.', ',') }}₫</span>

                                            <!--end::Amount-->

                                            <span class="d-block text-gray-400 fw-semibold fs-6">Đã thu</span>
                                            <!--end::Badge-->
                                        </div>

                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                    </div>

                    <div class="col-lg-6 col-xl-4 col-md-6 col-sm-6 col-12">
                        <div
                            class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border  px-5 bg-white py-2 border-gray-400">
                            <!--begin::Header-->
                            <div class="card-header py-0">
                                <!--begin::Title-->
                                <div class="card-title d-flex flex-column" data-action="under-construction">
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-top">
                                        <div>
                                            <!--begin::Amount-->
                                            <span
                                                class="fs-1 fw-semibold">{{ number_format(max($order->getTotal() - $order->sumAmountPaid(), 0), 0, '.', ',') }}₫
                                            </span>
                                            <!--end::Amount-->

                                            <span class="d-block text-gray-400 fw-semibold fs-6">Còn lại</span>
                                            <!--end::Badge-->
                                        </div>

                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Header-->
                        </div>
                    </div>


                </div>


                @if ($order->is_pay_all == 'off' && $order->status == 'approved')
                    <div class="row w-100  ms-auto d-flex justify-content-around ">
                        <h2 class="text-info text-nowrap mt-5 mb-5 p-0">
                            Tiến độ thanh toán
                        </h2>

                    </div>
                    <div class="progress-container">
                        <div class="d-flex justify-content-between">
                            <div class='stacking-order '>
                                <div class="circle fw-semibold flex-column  active bg-success">
                                    <span>Bắt đầu</span>
                                </div>
                                <div class="circle2 fw-semibold flex-column   active bg-success">
    
                                </div>
                                <span class="fw-semibold d-flex justify-content-center">0</span>
    
    
                            </div>
                        </div>
                        <div class="progress1 progress-bar progress-bar-warning" id="progress" style="width: 92%;">
                        </div>
    
    
                        @php
                            $schedulePaymentCount = $paymentReminders->count();
                        @endphp
    
                        @foreach ($paymentReminders as $index => $schedulePayment)
                            @php
                                $nextSchedulePayment = ($index < $schedulePaymentCount - 1) ? $paymentReminders[$index + 1] : null;
                                $nextTrackingAmount = ($nextSchedulePayment) ? $nextSchedulePayment->tracking_amount : $order->getTotal();
                            @endphp
    
                            <div class="d-flex justify-content-between">
                                <div class='stacking-order '>
                                    <div class="circle fw-semibold flex-column {{ $schedulePayment->getStatus() == App\Models\PaymentReminder::STATUS_PAID ? ' active bg-success' : '' }}">
                                        <span>{{ $schedulePayment->getProgressName() }}</span>
                                        <span>{{ $schedulePayment->due_date ? date('d/m/y', strtotime($schedulePayment->due_date)) : '' }}</span>
                                    </div>
                                    <div class="circle2 fw-semibold flex-column  {{ $schedulePayment->getStatus() == App\Models\PaymentReminder::STATUS_PAID ? ' active bg-success' : '' }}">
                                    </div>
                                    <span class="fw-semibold d-flex justify-content-center">{{ number_format($nextTrackingAmount, 0, '.', ',') }}₫</span>
                                </div>
                            </div>
                        @endforeach
                        @php
                            $percentage = 0;
                            $schedulePaymentCheck = 0;
                            $result = 0;
                            $quantity = count($paymentReminders);
                            $ratio = 92 / $quantity;
                            $sumAmountPaid = intval($order->sumAmountPaid());
                            $sumAmountPaidAfter = $sumAmountPaid;
                        @endphp
                        @foreach ($paymentReminders as $schedulePayment)
                            @if ($schedulePaymentCheck < $sumAmountPaid)
                                @php
                                    $result = $ratio * ($sumAmountPaidAfter / $schedulePayment->amount);
                                    if ($result >= $ratio) {
                                        $percentage += $ratio;
                                    } else {
                                        $percentage += $result;
                                    }
                                    $sumAmountPaidAfter = $sumAmountPaidAfter - $schedulePayment->amount;
                                @endphp
                            @endif
                            @php
                                $schedulePaymentCheck += $schedulePayment->amount;
    
                            @endphp
                        @endforeach
                        <div class="progress2 progress-bar progress-bar-active " id="progress"
                            style="width: {{ $percentage + 0.5 }}%;">
    
    
                        </div>
    
                        <div class="progress3 progress-bar progress-bar-active " id="progress"
                            style="width: {{ $percentage + 3 }}%;">
                            <span class="d-flex justify-content-end">
                                {{ number_format($order->sumAmountPaid(), 0, '.', ',') }}₫</span>
                        </div>
                        <div class="progress4 progress-bar progress-bar-active " id="progress"
                            style="width: {{ $percentage + 0.9 }}%; ">
                            <span class="d-flex justify-content-end  ">
                                <span class="material-symbols-rounded text-bold stacking-order2"
                                    style="color: rgb(255, 0, 0); ">
                                    attach_money
                                </span>
    
                            </span>
    
                        </div>
    
    
    
                    </div>




                    <div class="row w-100  d-flex justify-content-around ">
                        <div class="" id='schedule-payment-reminder-list'>
                            <table class="table table-bordered ">
                                <thead>
                                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                                        <th class="text-nowrap text-white">Tên tiến độ</th>
                                        <th class="text-nowrap text-white">Tổng trong đợt</th>
                                        <th class="text-nowrap text-white">Đã thu trong đợt</th>
                                        <th class="text-nowrap text-white">Còn phải thu</th>
                                        <th class="text-nowrap text-white">Hạn thanh toán</th>
                                        <th class="text-nowrap text-white">Trạng thái</th>
                                        <th class="text-nowrap text-white">Thao tác</th>
                                        <th class="text-nowrap text-white text-end pe-10 d-none">Thao tác</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($paymentReminders as $paymentReminder)
                                        <tr class="">
                                            <td>{{ $paymentReminder->getProgressName() }}</td>
                                            <td>
                                                {{ number_format($paymentReminder->amount, 0, '.', ',') }}₫

                                            </td>
                                            <td>
                                                {{ App\Helpers\Functions::formatNumber($paymentReminder->getPaidAmountInProgress()) }}
                                            </td>
                                            {{-- <td>
                                                {{ App\Helpers\Functions::formatNumber($paymentReminder->getSumAmountPaid()) }}₫
                                            </td> --}}
                                            <td>
                                                {{ number_format($paymentReminder->getDebtAmountInProgress(), 0, '.', ',') }}₫

                                            </td>

                                            <td>
                                                {{ $paymentReminder->due_date ? date('d/m/Y', strtotime($paymentReminder->due_date)) : '' }}

                                            </td>

                                            <td>
                                                @php
                                                    $bgs = [
                                                        App\Models\PaymentReminder::STATUS_PAID => 'success',
                                                        App\Models\PaymentReminder::STATUS_UNPAID => 'danger text-white',
                                                    ];
                                                @endphp

                                                <span title="{{ $paymentReminder->getStatusProgress() }}"
                                                    class="badge bg-{{ $bgs[$paymentReminder->getStatusProgress()] ?? 'info' }}"
                                                    data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-dismiss="click" data-bs-placement="right">
                                                    {{ trans('messages.payment_reminders.status.' . $paymentReminder->getStatusProgress()) }}

                                                </span>


                                            </td>

                                            <td class="text-end" data-title="Chưa thanh toán đợt trước">

                                                <a href="{{ action(
                                                    [App\Http\Controllers\Accounting\PaymentRecordController::class, 'createReceipt'],
                                                    [
                                                        'id' => $paymentReminder->id,
                                                    ],
                                                ) }}"
                                                    row-action="add-receipt" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    title="{{ $paymentReminder->getStatusProgress() == App\Models\PaymentReminder::STATUS_PAID ? 'Đã thanh toán' : '' }}"
                                                    class="btn btn-sm btn-outline btn-flex btn-center  text-nowrap  {{ $paymentReminder->getStatusProgress() == App\Models\PaymentReminder::STATUS_PAID ? 'bg-gray-300 link-under-construction ' : '' }}">Tạo
                                                    phiếu thu</a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
            <div class="card px-10 py-10 mt-10">
                <?php
                if(count($orderItems) > 0) {
                ?>
                @if ($order->type == App\Models\Order::TYPE_EDU || $order->type == App\Models\Order::TYPE_REQUEST_DEMO)
                <div class="form-outline mb-15">
                    <label class="fs-5 fw-bold mb-5 d-flex align-items-center" for="order-type-select">
                        Dịch vụ đào tạo:
                    </label>
                    <div class="table-responsive scrollable-orders-table">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                            <thead>
                                <tr
                                    class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                    <th class="min-w-125px text-left">Dịch vụ</th>
                                    <th class="min-w-125px text-left">Môn học</th>
                                    <th class="min-w-125px text-left">Giá dịch vụ</th>
                                    <th class="min-w-125px text-left">% khuyến mãi</th>
                                    <th class="min-w-125px text-left">Giá dịch vụ sau khuyến mãi</th>
                                    <th class="min-w-125px text-left">Trình độ</th>
                                    <th class="min-w-125px text-left">Loại hình lớp</th>
                                    <th class="min-w-125px text-left">Số lượng học viên</th>
                                    <th class="min-w-125px text-left">Hình thức học</th>
                                    <th class="min-w-125px text-left">Địa điểm đào tạo</th>
                                    <th class="min-w-125px text-left">Số giờ GVNN</th>
                                    <th class="min-w-125px text-left">Số giờ GV Việt Nam</th>
                                    <th class="min-w-125px text-left">Số giờ gia sư</th>
                                    <th class="min-w-125px text-left">Tổng giờ</th>
                                    <th class="min-w-125px text-left">target</th>
                                    <th class="min-w-125px text-left">Số giờ demo đã trừ</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @foreach ($orderItems as $orderItem)
                                    <tr list-control="train-order-item">
                                        <td class="text-left">
                                           Đào tạo
                                        </td>
                                        <td class="text-left">
                                            {{ $orderItem->subject->name ?? '--' }}
                                        </td>
                                        <td class="text-left">
                                            {{ number_format($orderItem->getTotalPriceRegardlessTypeBeforeDiscount(), 0, '.', ',') }}&nbsp;₫</td>
                                        <td class="text-left">
                                            {{ $orderItem->order->discount_code . '%'}} </td>
                                        <td class="text-left">
                                            {{ number_format($orderItem->getTotalPriceRegardlessType(), 0, '.', ',') }}
                                        </td>
                                        <td class="text-left">{{ $orderItem->level }}</td>
                                        <td class="text-left">{{ $orderItem->class_type }}</td>
                                        <td class="text-left">{{ $orderItem->num_of_student }}</td>
                                        <td class="text-left">{{ $orderItem->study_type }}
                                        </td>
                                        <td class="text-left">{{ $orderItem->getTrainingLocationName() }} - <span class="fw-bold">{{ trans('messages.training_locations.'. $orderItem->getTrainingLocationBranch()) }}</span></td>

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
                                        <td class="text-left">{{ $orderItem->target }}</td>
                                        <td class="text-left"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            @if ($order->type == App\Models\Order::TYPE_EXTRACURRICULAR)
                <div class="form-outline mb-15">
                    <label class="fs-5 fw-bold mb-5 d-flex align-items-center" for="order-type-select">
                        Dịch vụ ngoại khóa:
                    </label>
                    <div class="table-responsive scrollable-orders-table">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                            <thead>
                                <tr
                                    class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                    <th class="min-w-125px text-left">Dịch vụ</th>
                                    <th class="min-w-125px text-left">Tên hoạt động</th>
                                    <th class="min-w-125px text-left">Loại chương trình</th>
                                    <th class="min-w-125px text-left">Địa điểm</th>
                                    <th class="min-w-125px text-left">Người điều phối</th>
                                    <th class="min-w-125px text-left">Giá gốc</th>
                                    <th class="min-w-125px text-left">Chi phí dự kiến</th>
                                    <th class="min-w-125px text-left">Chi phí thực tế</th>
                                    <th class="min-w-125px text-left">Hình thức</th>
                                    <th class="min-w-125px text-left">Số giờ trong tuần</th>
                                    <th class="min-w-125px text-left">Số tuần trong năm</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                
                                @foreach ($order->orderItems as $orderItem)
                                
                                    <td> Ngoại khóa</td>    
                                    <td> {{ $orderItem->extracurricular->name }}</td>
                                    <td> {{ $orderItem->extracurricular->type }}</td>
                                    <td> {{ $orderItem->extracurricular->address }}</td>
                                    <td>  {{ isset($orderItem->extracurricular->account) ? $orderItem->extracurricular->account->name : "" }}</td>
                                    <td> 
                                        {{ App\Helpers\Functions::formatNumber($orderItem->extracurricular->price) }}₫
                                    </td>
                                    <td> 
                                        {{ App\Helpers\Functions::formatNumber($orderItem->extracurricular->expected_costs) }}₫
                                    </td>
                                    <td> 
                                        {{ App\Helpers\Functions::formatNumber($orderItem->extracurricular->actual_costs) }}₫
                                    </td>
                                    <td> {{ $orderItem->extracurricular->study_method }}</td>
                                    <td> 
                                        {{ $orderItem->extracurricular->hours_per_week ?? '0'}} Giờ
                                    </td>
                                    <td>
                                        {{ $orderItem->extracurricular->weeks_per_year ?? '0'}} Tuần
                                    </td>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

                @if ($order->type == App\Models\Order::TYPE_ABROAD)
                    <div class="form-outline">
                        <label class="fs-5 fw-bold mb-5 d-flex align-items-center" for="order-type-select">
                            Dịch vụ du học:
                        </label>
                        <div class="table-responsive scrollable-orders-table">
                            <!--begin::Table-->
                            @php
                                $abroadTableUniq = 'abroad_items_table_' . uniqId();
                            @endphp

                            <table data-items-table="{{ $abroadTableUniq }}" class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                                <thead>
                                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                        <th class="min-w-125px text-left">Loại dịch vụ</th>
                                        <th class="min-w-125px text-left">Giá dịch vụ</th>
                                        <th class="min-w-125px text-left">Giá dịch vụ sau khuyến mãi</th>
                                        <th class="min-w-125px text-left">Thời điểm apply</th>
                                        <th class="min-w-125px text-left">Thời điểm dự kiến nhập học</th>
                                        <th class="min-w-400px text-left">Top trường</th>
                                    </tr>
                                </thead>
                                <tbody class="text-gray-600">
                                    @foreach ($orderItems as $orderItem)
                                        <?php
                                        if($orderItem->type == App\Models\Order::TYPE_ABROAD) {
                                        ?>
                                            <tr data-url="{{ action([App\Http\Controllers\Sales\OrderItemController::class, 'showAbroadItemDataPopup'], ['id' => $orderItem->id]) }}" list-control="abroad-order-item">
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
                                            </tr>
                                        <?php
                                        }   
                                        ?>
                                    @endforeach
                                </tbody>
                            </table>

                            <script>
                                $(() => {
                                    new ItemsTable({
                                        table: () => {
                                            return $('[data-items-table="{{ $abroadTableUniq }}"]')
                                        }
                                    })
                                })

                                var ItemsTable = class {
                                    constructor(options) {
                                        this.table = options.table;
                                        this.initRows();
                                    }

                                    initRows() {
                                        const _this = this;

                                        this.table().find('[list-control="abroad-order-item"]').each((key, row) => {
                                            new AbroadItemRow({
                                                row: () => {
                                                    return $(row);
                                                },
                                                table: _this
                                            })
                                        })
                                    }
                                }

                                var AbroadItemRow = class {
                                    constructor(options) {
                                        this.row = options.row;
                                        this.table = options.table;
                                        this.popup = new DataPopup();

                                        this.events();
                                    }

                                    getUrl() {
                                        return this.row().attr('data-url');
                                    }

                                    events() {
                                        this.row().on('click', e => {
                                            e.preventDefault();

                                            this.popup.updateUrl(this.getUrl());
                                        })
                                    }
                                }

                                var DataPopup = class {
                                    constructor(options) {
                                        this.popup = new Popup();
                                    }

                                    updateUrl(newUrl) {
                                        this.popup.url = newUrl;
                                        this.popup.load();
                                    }

                                    getPopup() {
                                        return this.popup;
                                    }
                                }
                            </script>
                        </div>
                    </div>
                @endif
                <?php 
                } else {
                ?>
                <div class="text-center">
                    <label class="fs-6 fw-semibold fs-3 d-flex align-items-center justify-content-center"
                        for="order-type-select">
                        Chưa có dịch vụ nào!
                    </label>
                </div>
                <?php
                }
                ?>
            </div>

            <div class="mt-5">
                <div class="text-right d-flex justify-content-end py-5">
                    <div class="w-50 d-flex justify-content-end form-outline">
                        <div class="card w-75 py-5 mb-20">
                            <div class="row d-flex justify-content-center">
                                <div class="col-lg-4 col-sm-4 col-xs-4 col-md-4 col-xl-4">
                                    <div class="mb-5">
                                        <div class="fs-4 d-flex justify-content-end align-items-end mb-2">
                                            <span class="fw-bold">Tổng giá:</span>
                                        </div>
                                        <div class="fs-4 d-flex justify-content-end align-items-end mb-2">
                                            <span class="fw-bold">Giảm giá:</span>
                                        </div>
                                        <div class="fs-4 d-flex justify-content-end align-items-end">
                                            <span class="fw-bold">Tổng cộng:</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-sm-4 col-xs-4 col-md-4 col-xl-4">
                                    <div class="mb-5">
                                        <div class="fs-4 me-0 mb-2 d-flex justify-content-end">
                                            <span
                                                class="me-0 text-primary fw-bold">{{ number_format($order->getPriceBeforeDiscount(), 0, '.', ',') }}₫</span>
                                        </div>
                                        <div class="fs-4 me-0 d-flex justify-content-end mb-2">
                                            <span
                                                class="me-0 text-primary fw-bold">{{ number_format($order->getPriceBeforeDiscount() - $order->getTotal(), 0, '.', ',') }}₫</span>
                                        </div>
                                        <div class="fs-4 me-0 d-flex justify-content-end">
                                            <span
                                                class="me-0 text-primary fw-bold">{{ number_format($order->getTotal(), 0, '.', ',') }}₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(() => {
            let showConstractManager = new ShowConstractManager({
                container: document.querySelector('#showConstractContainer')
            });

            RejectDetail.init();

            ApproveDetail.init();
            CreateReceipt.init();
            UpdateAmount.init();
            Export.init();


        });
        var Export = function() {
            return {
                init: function() {
                    var buttonExport = document.querySelector("[row-action='export-pdf']");

                    buttonExport.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');

                        fetch(url)
                            .then(response => response.blob())
                            .then(blob => { 
                                const blobUrl = URL.createObjectURL(blob); 
                                window.open(blobUrl, '_blank');
                            })
                            .catch(error => console.error('Error :', error));
                    });
                }
            };
        }();
        var UpdateAmount = function() {
            function updateSumElements(orderItemId, sum, orderItemTotal) {
                var expenseSpan = $('span.expense[data-order-item-id="' + orderItemId + '"]');
                var profitSpan = $('span.profit[data-order-item-id="' + orderItemId + '"]');

                expenseSpan.text(formatNumber(sum));

                var profit = orderItemTotal - sum;

                profitSpan.text(formatNumber(profit));
            }

            function formatNumber(number) {
                var formattedNumber = number.toLocaleString('en-US');
                return formattedNumber + ' ₫';
            }

            function calculateSum(orderItemId, orderItemTotal) {
                var sum = 0;
                $('input[list-action="check-item"][data-order-item-id="' + orderItemId + '"]:checked')
                    .each(function() {
                        if (!$(this).closest('tr').hasClass('d-none')) {
                            sum += parseFloat($(this).val()) || 0;
                        }
                    });
 
                updateSumElements(orderItemId, sum, orderItemTotal);
            }

            function updateCheckboxAmount() {
                const selectElements = $('[list-action="teacher-filter-select"]');
                const selectedTeacherIds = [];

                selectElements.each(function() {
                    $(this).find('option:selected').each(function() {
                        selectedTeacherIds.push($(this).val());
                    });
                });

                $('#selected-teachers-table tbody tr').each(function() {
                    const teacherId = $(this).attr('id').split('_')[1];
                    const checkbox = $(this).find('input[list-action="check-item"]');

                    if (selectedTeacherIds.includes(teacherId)) {
                        $(this).removeClass('d-none'); 
                        checkbox.prop('disabled', false); 
                        calculateSum(checkbox.data('order-item-id'), checkbox.data('order-item-total')); // Tính toán tổng
                        
                    } else {
                        $(this).addClass('d-none'); 
                        checkbox.prop('disabled', true); 
                        checkbox.prop('checked', false);
                        calculateSum(checkbox.data('order-item-id'), checkbox.data('order-item-total')); // Tính toán tổng
                    }
                    
                });
            }
            function updateAmountOnCheckboxChange() {
                $('input[list-action="check-item"]').change(function() {
                    var orderItemId = $(this).data('order-item-id');
                    var orderItemTotal = $(this).data('order-item-total');
                    calculateSum(orderItemId, orderItemTotal);
                });
               
            }

            return {
                init: function() {
                    $('[list-action="teacher-filter-select"]').change(updateCheckboxAmount);
                    updateCheckboxAmount();

                    updateAmountOnCheckboxChange();
                }
            };
        }();


        var CreateReceipt = function() {

            return {
                init: () => {
                    var buttonsUpdateNoteLog = document.querySelectorAll("[row-action='add-receipt']");
                    buttonsUpdateNoteLog.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const url = this.getAttribute('href')

                            ShowPopup.updateUrl(url);
                        });
                    });
                },

            };
        }();
        //
        var RejectDetail = function() {
            var list;
            var links;

            return {
                init: function() {
                    links = document.querySelectorAll('[row-action="rejectDetail"]');

                    //events
                    links.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            let url = link.getAttribute('href');

                            // 
                            OrderRejectPopup.load(url);
                        });
                    });
                },
            };
        }();

        var ApproveDetail = function() {
            var list;
            var links;

            var request = function(url) {
                ASTool.addPageLoadingEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                    }
                }).done((response) => {
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            OrderList.getList().load();
                        }
                    });
                    ShowOrderPopup.getPopup().hide();
                    // OrderList.getList().load();
                }).fail(function(response) {
                    ASTool.alert({
                        message: response.responseText,
                        ok: function() {
                            OrderList.getList().load();
                        }
                    });
                }).always(function() {
                    ASTool.removePageLoadingEffect();
                })
            }

            return {
                init: function() {
                    links = document.querySelectorAll('[row-action="approveDetail"]');

                    //events
                    links.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            let url = link.getAttribute('href');

                            ASTool.confirm({
                                message: 'Bạn đã duyệt hợp đồng mã số {{ $order->code }}',
                                ok: function() {
                                    request(url);
                                }
                            });
                        });
                    });
                },
            };
        }();

        var ShowConstractManager = class {
            constructor(options) {
                this.container = options.container;

                this.events();
            };

            getUpdateBtns() {
                return this.container.querySelectorAll('[row-action="update"]');
            };

            getEditConstractBtn() {
                return this.container.querySelector('#editConstractBtn');
            };

            addLoadEffect() {

                this.container.classList.add('list-loading');

                if (!this.container.querySelector('[list-action="loader"]')) {
                    $(this.listContent).before(`
                <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                `);
                }
            };

            events() {
                const _this = this;

                /**
                 * When click Update item
                 */
                this.getEditConstractBtn().addEventListener("click", function(e) {
                    e.preventDefault();

                    const currentOrderId = this.getAttribute("data-ids");

                    _this.addLoadEffect();

                    window.location.href = `accounting/orders/create-constract\\${currentOrderId}\\update`;
                })
            };
        };
    </script>


@endsection
