@if ($schedulePayments->count()>0)

    <div class="">
         <label class="fs-6 fw-semibold mb-2">
                <span class="">Tiến độ thanh toán</span>
            </label>

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
                        $schedulePaymentCount = $schedulePayments->count();
                    @endphp

                    @foreach ($schedulePayments as $index => $schedulePayment)
                        @php
                            $nextSchedulePayment = ($index < $schedulePaymentCount - 1) ? $schedulePayments[$index + 1] : null;
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
                        $quantity = count($schedulePayments);
                        $ratio = 92 / $quantity;
                        $sumAmountPaid = intval($order->sumAmountPaid());
                        $sumAmountPaidAfter = $sumAmountPaid;
                    @endphp
                    @foreach ($schedulePayments as $schedulePayment)
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
        <div class="  col-md-12 solid mb-7">
            <div class="table-responsive" id='contract-list'>
                <table class="table table-row-bordered table-hover table-bordered">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th class="text-nowrap text-white">Tên tiến độ</th>
                            <th class="text-nowrap text-white">Tổng trong đợt</th>
                            <th class="text-nowrap text-white">Đã thu trong đợt</th>
                            <th class="text-nowrap text-white">Còn phải thu</th>
                            <th class="text-nowrap text-white">Hạn thanh toán</th>
                            <th class="text-nowrap text-white">Trạng thái</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($schedulePayments as $schedulePayment)
                            <tr  class=" pe-none  bg-light-warning">
                                <td>{{ $schedulePayment->getProgressName() }}</td>
                                <td>
                                    {{ number_format($schedulePayment->amount, 0, '.', ',') }}₫

                                </td>
                                <td>
                                    {{ App\Helpers\Functions::formatNumber($schedulePayment->getPaidAmountInProgress()) }}
                                </td>
                                {{-- <td>
                                    {{ App\Helpers\Functions::formatNumber($schedulePayment->sumAmountPaid()) }}₫
                                </td> --}}
                                <td>
                                    
                                    {{ number_format($schedulePayment->getDebtAmountInProgress(), 0, '.', ',') }}₫

                                </td>

                                <td>
                                    {{ $schedulePayment->due_date ? date('d/m/Y', strtotime($schedulePayment->due_date)) : '' }}

                                </td>

                                <td>
                                    @php
                                        $bgs = [
                                            App\Models\PaymentReminder::STATUS_PAID => 'success',
                                            App\Models\PaymentReminder::STATUS_UNPAID => 'danger text-white',
                                        ];
                                    @endphp

                                    <span title="{{ $schedulePayment->getStatusProgress() }}"
                                        class="badge bg-{{ $bgs[$schedulePayment->getStatusProgress()] ?? 'info' }}"
                                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                        data-bs-placement="right">
                                        {{ trans('messages.payment_reminders.status.' . $schedulePayment->getStatusProgress()) }}

                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="">
        <div class="form-outline">
            <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                error
            </span>
            <span>Chưa mã hợp đồng để tiến hành thanh toán!</span>
        </div>
    </div>
@endif
