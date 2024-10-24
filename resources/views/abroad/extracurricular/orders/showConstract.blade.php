@extends('layouts.main.popup')

@section('title')
    @if ($order->isRequestDemo())
        Yêu cầu học thử
    @else
        Thông tin dịch vụ
    @endif
@endsection

@section('content')
    <div id="showConstractContainer">
        @csrf
        <div class="scroll-y px-7 px-lg-17">
            <div class="modal-body flex-end px-0 d-flex justify-content-end">
                @if (Auth::user()->can('update', $order))
                    <button data-ids="{{ $order->id }}" row-action="update" id="editConstractBtn" class="btn btn-light me-2">
                        <span class="indicator-label fw-bold">Chỉnh sửa</span>
                    </button>
                @endif
                <button data-action="under-construction" class="btn btn-light">
                    <span class="indicator-label fw-bold">Xuất PDF</span>
                </button>
            </div>
            <div class="row">
                <div class="col-12 col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="form-control">
                        <h2 class="text-info text-nowrap mt-5 mb-5">
                            Thông tin chung
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
                                    <div class="fv-row my-3 d-flex border-bottom">
                                        <div
                                            class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                            <label class="fs-6 fw-semibold mb-2">
                                                <span class="fw-bold">Nội dung yêu cầu:</span>
                                            </label>
                                        </div>
                                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                            <div>{{ $order->contactRequest->demand }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div
                                        class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Số dịch vụ:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->code }}</div>
                                    </div>
                                </div>
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
                            </div>



                        </div>

                        <h2 class="text-info text-nowrap mt-10 mb-3">
                            @if ($order->contact_id == $order->student_id)
                                Khách hàng, Người ký dịch vụ, Học viên
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

                        {{-- <div class="row d-flex justify-content-between mt-3">
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Họ và tên:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ App\Models\Order::find($order->id)->contacts->name }}</div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Ngày tháng năm sinh:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->birthday }}</div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Số điện thoại:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->phone }}</div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Email:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->email }}</div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Trường đang học:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->current_school }}</div>
                                    </div>
                                </div>
                            </div>
                            
    
                            <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Họ và tên Phụ Huynh:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->parent_fullname }}</div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Số điện thoại phụ huynh:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->parent_phone }}</div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Email phụ huynh:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->parent_email }}</div>
                                    </div>
                                </div>
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Ghi chú:</span>
                                        </label>
                                    </div>
                                    <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                        <div>{{ $order->parent_note }}</div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
            @if ($order->is_pay_all == 'off')
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
                            $nextSchedulePayment =
                                $index < $schedulePaymentCount - 1 ? $paymentReminders[$index + 1] : null;
                            $nextTrackingAmount = $nextSchedulePayment
                                ? $nextSchedulePayment->tracking_amount
                                : $order->getTotal();
                        @endphp

                        <div class="d-flex justify-content-between">
                            <div class='stacking-order '>
                                <div
                                    class="circle fw-semibold flex-column {{ $schedulePayment->getStatus() == App\Models\PaymentReminder::STATUS_PAID ? ' active bg-success' : '' }}">
                                    <span>{{ $schedulePayment->getProgressName() }}</span>
                                    <span>{{ $schedulePayment->due_date ? date('d/m/y', strtotime($schedulePayment->due_date)) : '' }}</span>
                                </div>
                                <div
                                    class="circle2 fw-semibold flex-column  {{ $schedulePayment->getStatus() == App\Models\PaymentReminder::STATUS_PAID ? ' active bg-success' : '' }}">
                                </div>
                                <span
                                    class="fw-semibold d-flex justify-content-center">{{ number_format($nextTrackingAmount, 0, '.', ',') }}₫</span>
                            </div>
                        </div>
                    @endforeach
                    @php
                        $percentage = 0;
                        $schedulePaymentCheck = 0;
                        $result = 0;
                        $quantity = count($paymentReminders);
                        $ratio = ($quantity != 0) ? (92 / $quantity) : 0;
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
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                data-bs-placement="right">
                                                {{ trans('messages.payment_reminders.status.' . $paymentReminder->getStatusProgress()) }}

                                            </span>


                                        </td>

                                        <td class="text-end d-none" data-title="Chưa thanh toán đợt trước">

                                            <a href="{{ action(
                                                [App\Http\Controllers\Accounting\PaymentRecordController::class, 'createReceipt'],
                                                [
                                                    'id' => $paymentReminder->id,
                                                ],
                                            ) }}"
                                                row-action="add-receipt" data-bs-toggle="tooltip" data-bs-placement="top"
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
                                            {{-- <th class="min-w-125px text-left">Trạng thái</th> --}}
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
                                            <th class="min-w-125px text-left">Số giờ demo đã trừ</th>
                                            {{-- <th class="min-w-125px text-left">Chủ nhiệm</th>
                                            <th class="min-w-125px text-left">Thời lượng</th> --}}
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
                                                    {{ App\Helpers\Functions::formatNumber($orderItem->getTotalPriceOfEduBeforeDiscount()) }} ₫</td>
                                                <td class="text-left">
                                                    {{ $orderItem->order->discount_code . '%'}} </td>
                                                <td class="text-left">
                                                    {{ App\Helpers\Functions::formatNumber($orderItem->getTotalPriceOfEdu()) }}
                                                    ₫
                                                </td>
                                                {{-- <td class="text-left">{{ $orderItem->status }}</td> --}}
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
                                                <td class="text-left">{{ $orderItem->unit == 'hour' ? 'Giờ' : 'Phút' }}</td>
                                                <td class="text-left">{{ $orderItem->target }}</td>
                                                <td class="text-left"> {{ number_format($orderItem->getTotalMinutesForSubtractedDemoItems() / 60, 2) }} giờ</td>
                                                {{-- <td class="text-left">{{ $orderItem->home_room }}</td>
                                                <td class="text-left">{{ $orderItem->duration }}</td> --}}
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
                                <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                                    <thead>
                                        <tr
                                            class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                            <th class="min-w-125px text-left">Loại dịch vụ</th>
                                            <th class="min-w-125px text-left">Giá dịch vụ</th>
                                            <th class="min-w-125px text-left">Thời điểm apply</th>
                                            <th class="min-w-125px text-left">Thời điểm dự kiến nhập học</th>
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
                                            <th class="min-w-125px text-left">Phụ huynh có anh chị em đã/đang/sắp đi du
                                                học</th>
                                            <th class="min-w-125px text-left">Thời gian đồng hành cùng con</th>
                                            <th class="min-w-125px text-left">Khả năng chi trả mỗi năm</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600">
                                        @foreach ($orderItems as $orderItem)
                                            <tr list-control="abroad-order-item">
                                                <td class="text-left">
                                                    {{ trans('messages.order.type.' .  \App\Models\Order::TYPE_ABROAD) }}
                                                </td>
                                                <td class="text-left">
                                                    {{ App\Helpers\Functions::formatNumber($orderItem->price) }}₫
                                                </td>
                                                <td class="text-left">
                                                    {{ date('d/m/Y', strtotime($orderItem->apply_time)) }}</td>
                                                <td class="text-left">
                                                    {{ date('d/m/Y', strtotime($orderItem->estimated_enrollment_time)) }}
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
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
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
                                                class="me-0 text-primary fw-bold">{{ number_format($order->getPriceBeforeDiscount(), 0, '.', ',') }}&nbsp;₫</span>
                                        </div>
                                        <div class="fs-4 me-0 d-flex justify-content-end mb-2">
                                            <span
                                                class="me-0 text-primary fw-bold">{{ number_format($order->getPriceBeforeDiscount() - $order->getTotal(), 0, '.', ',') }}&nbsp;₫</span>
                                        </div>
                                        <div class="fs-4 me-0 d-flex justify-content-end">
                                            <span
                                                class="me-0 text-primary fw-bold">{{ number_format($order->getTotal(), 0, '.', ',') }}&nbsp;₫</span>
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
        });

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

                    window.location.href = `sales/orders/create-constract\\${currentOrderId}\\update`;
                })
            };
        };
    </script>
@endsection
