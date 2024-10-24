@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Tạo phiếu thu cho {{ App\Models\PaymentReminder::find($paymentReminder->id)->order->contacts->name }}
@endsection
@php
    $controlId = uniqid();
@endphp
@section('content')
    <form id="CreateReceiptForm-{{ $controlId }}" tabindex="-1" method="post"
        action="{{ action([App\Http\Controllers\Accounting\PaymentRecordController::class, 'store']) }}">

        <input type="hidden" name="contact_id"
            value="{{ App\Models\PaymentReminder::find($paymentReminder->id)->order->contact_id }}">

        <input type="hidden" name="order_id" value="{{ App\Models\PaymentReminder::find($paymentReminder->id)->order->id }}">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_customer_scroll">
            <!--begin::Input group-->

            <div class="row">
                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Khách hàng</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div list-action="contact-select-change" data-allow-clear="true" data-placeholder=""
                            class="form-control" disabled>
                            <strong>
                                {{ App\Models\PaymentReminder::find($paymentReminder->id)->order->contacts->name }}</strong><br>
                            {{ $paymentReminder->order->contacts->email }}<br>
                            {{ $paymentReminder->order->contacts->phone }}

                        </div>


                    </div>

                </div>

                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Mã hợp đồng</span>
                        </label>
                      
                        <div list-action="order-select-change" data-allow-clear="true" data-placeholder=""
                            class="form-control" disabled>
                            <strong>
                                {{ $paymentReminder->order->code }}</strong>

                        </div>


                    </div>

                </div>

            </div>

            <div class="  col-md-12 solid mb-7">
                <div class="table-responsive" id='contract-list'>
                    <table class="table table-row-bordered table-hover table-bordered">
                        <thead>
                            <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">

                                <th class="text-nowrap text-white">Mã hợp đồng</th>
                                <th class="text-nowrap text-white">Trạng thái</th>
                                <th class="text-nowrap text-white">Tổng số tiền</th>
                                <th class="text-nowrap text-white">Đã thu</th>
                                <th class="text-nowrap text-white">Còn lại</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                data-bs-placement="left" data-bs-dismiss="click"
                                data-bs-original-title="Không thể chọn request này do đã có hợp đồng!"
                                class="bg-light-warning pe-none bg-light ">
                                <td>
                                    <div>
                                        <a class="fw-semibold text-info" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            title="Nhấn để chỉnh sửa hợp đồng này">
                                            {{ $paymentReminder->order->code }}
                                        </a>
                                    </div>
                                    <span class="badge bg-secondary">
                                        {{ trans("messages.order.status.{$paymentReminder->order->status}") }}

                                    </span>
                                </td>

                                <td>
                                    @php
                                        $bgs = [
                                            App\Models\PaymentReminder::STATUS_PAID => 'success',
                                            App\Models\PaymentReminder::STATUS_UNPAID => 'danger text-white',
                                        ];

                                        $overallStatus = \App\Models\PaymentReminder::STATUS_PAID;

                                        if ($paymentReminder->order->getTotal() - $paymentReminder->order->sumAmountPaid() > 1) {
                                            $overallStatus = \App\Models\PaymentReminder::STATUS_UNPAID;
                                        }
                                    @endphp

                                    <span title="{{ trans('messages.payment_reminders.status.' . $overallStatus) }}"
                                        class="badge bg-{{ $bgs[$overallStatus] ?? 'info' }}">
                                        {{ trans('messages.payment_reminders.status.' . $overallStatus) }}
                                    </span>
                                </td>
                                <td>
                                    {{ number_format($paymentReminder->order->getTotal(), 0, '.', ',') }}₫

                                </td>

                                <td>
                                    {{ number_format($paymentReminder->getSumAmountPaid(), 0, '.', ',') }}₫

                                </td>

                                <td>
                                    {{ number_format($paymentReminder->order->getTotal() - $paymentReminder->getSumAmountPaid(), 0, '.', ',') }}₫
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($paymentReminder->order->is_pay_all == 'off')
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
                            $nextTrackingAmount = ($nextSchedulePayment) ? $nextSchedulePayment->tracking_amount : $paymentReminder->order->getTotal();
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
                        $sumAmountPaid = intval($paymentReminder->getSumAmountPaid());
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
                            {{ number_format($paymentReminder->getSumAmountPaid(), 0, '.', ',') }}₫</span>
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
                                    <tr
                                        class=" pe-none bg-light {{ $schedulePayment->id == $paymentReminder->id ? 'bg-light-warning' : '' }}">
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
            @endif

            <div class="col-md-12">
                <div class=" fv-row mb-7">
                    <label class="required fs-6 fw-semibold mb-2">
                        <span class="">Phương thức thanh toán</span>
                    </label>
                    <select id="method-payment-select-{{ $controlId }}" class="form-select form-control" data-placeholder="Chọn phương thức "
                        data-allow-clear="true" data-control="select2" name="method" required>
                        <option value="{{ App\Models\PaymentRecord::METHOD_CASH }}">Tiền mặt</option>
                        <option value="{{  App\Models\PaymentRecord::METHOD_BANK_TRANSFER }}">Chuyển khoản ngân hàng </option>
                        <option value="{{  App\Models\PaymentRecord::METHOD_POS }}">Thanh toán POS</option>
                    </select>
                    <x-input-error :messages="$errors->get('method')" class="mt-2" />
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 " id="paymentAccountContainer-{{ $controlId }}" >
                    <div class=" fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Tài khoản</span>
                        </label>
                        <select id="payment-account-select-{{ $controlId }}" class="form-select form-control" data-placeholder="Chọn tài khoản" data-control="select2" name="payment_account_id" required>
                            <option value="">Chọn tài khoản </option>

                            {{-- @if ($paymentReminder->order->salesperson->accountGroup)
                                @foreach( $paymentReminder->order->salesperson->accountGroup->paymentAccountEdu()->get() as $paymentAccount)
        
                                <option value="{{ $paymentAccount->id }}" selected>
                                    {{ $paymentAccount->bank }} - {{ $paymentAccount->account_number }} - {{ $paymentAccount->account_name }}
        
                                </option>
        
                                @endforeach
                            @endif --}}
                            @foreach( \App\Models\PaymentAccount::active()->get() as $paymentAccount)
        
                            <option value="{{ $paymentAccount->id }}" selected>
                                {{ $paymentAccount->bank }} - {{ $paymentAccount->account_number }} - {{ $paymentAccount->account_name }}
    
                            </option>
    
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('payment_account_id')" class="mt-2" />
                    </div>
                </div>

                <div class="col-md-6">
    
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class=" fs-6 fw-semibold mb-2">
                            <span class="">Ngày tạo phiếu thu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div  class="d-flex align-items-center ">
                                <input data-control="input"   type="date"
                                    class="form-control"   value="{{ date('Y-m-d') }}" readonly/>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            

            <div class="row">
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 required">
                            <span class="">Ngày thanh toán</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="" class="d-flex align-items-center">
                                <input data-control="input" name="payment_date" placeholder="=asas" type="date"
                                    value="{{ $paymentReminder->due_date }}" class="form-control"
                                    placeholder="{{ $paymentReminder->due_date ? date('d/m/Y', strtotime($paymentReminder->due_date)) : '' }}"
                                    required />
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 required">
                            <span class="">Số tiền</span>
                        </label>

                        <input type="text" class="form-control" id="price-input" name="amount"
                            value=" {{ $paymentReminder->getReceivableAmount() }}" placeholder="Số tiền" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                </div>

            </div>

            <div class="form-outline">
                <label class="fs-6 fw-semibold mb-2" for="order-notes-text">Ghi chú</label>
                <textarea id="payment-notes-text" rows="4" cols="50" class="form-control" placeholder="Nhập ghi chú..."
                    name="description"></textarea>
            </div>

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateReceiptSubmitButton-{{ $controlId }}" type="submit" class="btn btn-primary">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_note_log_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
       $(() => {
            initializePriceInput();
            CreateReceipt.init();
            new ShowPaymentAccount();

            function initializePriceInput() {
                const priceInput = $('#price-input');

                if (priceInput.length) {
                    const mask = new IMask(priceInput[0], {
                        mask: Number,
                        scale: 0,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                    });

                    $('#CreateReceiptForm-{{ $controlId }}').on('submit', function () {
                        priceInput.val(priceInput.val().replace(/,/g, ''));
                    });
                }
            }
        });


        var ShowPaymentAccount = class {
            constructor(options) {
                this.init();
                this.events();
            }

            getAccountContainer() {
                return $('#paymentAccountContainer-{{ $controlId }}');
            }

            getPaymentMethodSelect() {
                return $('#method-payment-select-{{ $controlId }}');
            }

            getPaymentMethodSelectValue() {
                return this.getPaymentMethodSelect().val();
            }

            getPaymentAccountSelect() {
                return $('#payment-account-select-{{ $controlId }}');
            }

            showAccountContainer() {
                const container = this.getAccountContainer();
                if (container.length) {
                    container.removeClass('d-none');
                    this.getPaymentAccountSelect().prop('required', true);
                }
            }
            
            hideAccountContainer() {
                const container = this.getAccountContainer();
                if (container.length) {
                    container.addClass('d-none');
                    this.getPaymentAccountSelect().prop('required', false);
                }
            }

            init() {
                this.handlePaymentMethodChange(); 
            }

            events() {
                const _this = this;

                this.getPaymentMethodSelect().on('change', function () {
                    _this.handlePaymentMethodChange();
                });
            }

            handlePaymentMethodChange() {
                let currVal = this.getPaymentMethodSelectValue();

                if (currVal === '{{  App\Models\PaymentRecord::METHOD_BANK_TRANSFER }}') {
                    this.showAccountContainer();
                } else {
                    this.hideAccountContainer();
                }
            }
        };

        
        var CreateReceipt = function() {
            let form;
            let submitDataBtn;

            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    submit();
                });
            };

            submit = () => {
                var data = $(form).serialize();
                addSubmitEffect();

                $.ajax({
                    url: "{{ action('\App\Http\Controllers\Accounting\PaymentRecordController@storeReceipt', ['id' => $paymentReminder->id]) }}",
                    method: 'POST',
                    data: data
                }).done(response => {
                    ShowPopup.getPopup().hide();

                    ASTool.alert({
                        message: response.message,
                        ok: () => {
                            PaymentRemindersList.getList().load();
                        }
                    });
                }).fail(response => {
                    ShowPopup.getPopup().setContent(response.responseText);
                    removeSubmitEffect();
                });
            };

            addSubmitEffect = () => {
                submitDataBtn.setAttribute('data-kt-indicator', 'on');
                submitDataBtn.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {
                submitDataBtn.removeAttribute('data-kt-indicator');
                submitDataBtn.removeAttribute('disabled');
            }

            return {
                init: () => {
                    form = document.querySelector("#CreateReceiptForm-{{ $controlId }}");
                    submitDataBtn = document.querySelector("#CreateReceiptSubmitButton-{{ $controlId }}");

                    handleFormSubmit();
                }
            }
        }();
    </script>

@endsection
