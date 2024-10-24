@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Tạo phiếu thu cho {{ App\Models\Order::find($order->id)->contacts->name }}
@endsection

@php
    $controlId = uniqid();
@endphp

@section('content')
    <form id="CreateReceiptContactForm--{{ $controlId }}" tabindex="-1">
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
            <!--begin::Input group-->
            <input type="hidden" name="contact_id" value=" {{ App\Models\Order::find($order->id)->contacts->id }}">
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <div class="row">
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Khách hàng</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div id="contact-select" list-action="contact-select-change" data-control="select2-ajax"
                                data-allow-clear="true" data-placeholder="" data-control="select2" class="form-control pe-none"
                                name="contact_id" disabled>
                                <strong> {{ App\Models\Order::find($order->id)->contacts->name }}</strong><br>
                                {{ $order->contacts->email }}<br>
                                {{ $order->contacts->phone }}
                            </div>
                            <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Mã hợp đồng</span>
                        </label>
                        <select id="contact-select" list-action="contact-select-change" data-control="select2-ajax"
                            data-control="select2" data-allow-clear="true" data-placeholder="{{ $order->code }}"
                            class="form-control pe-none" name="order_id" disabled>
                        </select>
                        <x-input-error :messages="$errors->get('order_id')" class="mt-2" />
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
                                            {{ $order->code }}
                                        </a>
                                    </div>
                                    <span class="badge bg-secondary">
                                        {{ trans("messages.order.status.{$order->status}") }}

                                    </span>
                                </td>
                                <td>
                                    @php
                                        $bgs = [
                                            App\Models\PaymentReminder::STATUS_PAID => 'success',
                                            App\Models\PaymentReminder::STATUS_UNPAID => 'danger text-white',
                                        ];

                                        $overallStatus = \App\Models\PaymentReminder::STATUS_PAID;

                                        if ($order->getTotal() - $order->sumAmountPaid() > 1) {
                                            $overallStatus = \App\Models\PaymentReminder::STATUS_UNPAID;
                                        }

                                    @endphp

                                    <span title="{{ trans('messages.payment_reminders.status.' . $overallStatus) }}"
                                        class="badge bg-{{ $bgs[$overallStatus] ?? 'info' }}">
                                        {{ trans('messages.payment_reminders.status.' . $overallStatus) }}
                                    </span>
                                </td>
                                <td>
                                    {{ number_format($order->getTotal(), 0, '.', ',') }}₫
                                </td>
                                <td>
                                    {{ number_format($order->sumAmountPaid(), 0, '.', ',') }}₫
                                </td>
                                <td>
                                    {{ number_format($order->getTotal() - $order->sumAmountPaid(), 0, '.', ',') }}₫
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @if ($order->is_pay_all == 'off')
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Tiến độ thanh toán</span>
                </label>

                <div class="progress-container">
                    <div class="d-flex justify-content-between">
                        <div class='stacking-order '>
                            <div class="circle fw-semibold flex-column active bg-success">
                                <span>Bắt đầu</span>
                            </div>
                            <div class="circle2 fw-semibold flex-column active bg-success">

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
                <div class="col-md-12 solid mb-7">
                    <div class="table-responsive" id='contract-list'>
                        <table class="table table-row-bordered table-hover table-bordered">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                                    <th class="text-nowrap text-white">Tên tiến độ</th>
                                    <th class="text-nowrap text-white">Tổng trong đợt</th>
                                    <th class="text-nowrap text-white">Đã thu trong đợt</th>
                                    <th class="text-nowrap text-white">Còn nợ trong đợt</th>
                                    <th class="text-nowrap text-white">Hạn thanh toán</th>
                                    <th class="text-nowrap text-white">Trạng thái</th>
                                    <th class="text-nowrap text-white">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($schedulePayments as $schedulePayment)
                                    <tr class="  bg-light ">
                                        <td>{{ $schedulePayment->getProgressName() }}</td>
                                        <td>
                                            {{ number_format($schedulePayment->amount, 0, '.', ',') }}₫
                                        </td>
                                        <td>
                                            {{ App\Helpers\Functions::formatNumber($schedulePayment->getPaidAmountInProgress()) }}
                                        </td>
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
                                            <span title="{{ $schedulePayment->getStatusProgress() == App\Models\PaymentReminder::STATUS_PAID ? 'Đã thanh toán' : '' }}"
                                                class="badge bg-{{ $bgs[$schedulePayment->getStatusProgress()] ?? 'info' }}"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                data-bs-placement="right">
                                                {{ trans('messages.payment_reminders.status.' . $schedulePayment->getStatusProgress()) }}
                                            </span>
                                        </td>
                                        <td class="">
                                            <button type="button" data-action="fill-payment-detail" 
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-receivable-amount="{{ number_format($schedulePayment->getDebtAmountInProgress(), 0, '.', ',') }}"
                                                data-due-date="{{ $schedulePayment->due_date ? date('Y-m-d', strtotime($schedulePayment->due_date)) : '' }}"
                                                class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap {{ $schedulePayment->getStatusProgress() == App\Models\PaymentReminder::STATUS_PAID ? 'bg-gray-300 link-under-construction' : '' }}"
                                                title="{{ $schedulePayment->getStatusProgress() == App\Models\PaymentReminder::STATUS_PAID ? 'Đã thanh toán' : '' }}">
                                            Thanh toán
                                        </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Phương thức thanh toán</span>
                        </label>
                        <select id="method-payment-select-{{ $controlId }}" class="form-select form-control" data-placeholder="Chọn phương thức"
                            data-check-error="{{ $errors->has('method') ? 'error' : '' }}"
                            data-allow-clear="true" data-control="select2" name="method">
                            <option value="{{ App\Models\PaymentRecord::METHOD_CASH }}">Tiền mặt</option>
                            <option value="{{  App\Models\PaymentRecord::METHOD_BANK_TRANSFER }}">Chuyển khoản ngân hàng </option>
                            <option value="{{  App\Models\PaymentRecord::METHOD_POS }}">Thanh toán POS</option>
                        </select>
                        <x-input-error :messages="$errors->get('method')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Số tiền</span>
                        </label>
                        <input type="text" class="form-control required" id="price-input" name="amount" data-check-error="{{ $errors->has('amount') ? 'error' : '' }}"
                            placeholder="Số tiền" value="{{ App\Models\PaymentReminder::getDebtAmountForOrder($order, $schedulePayments) }}
                            "/>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2"/>
                        <span data-error="amount-error" class='d-none' style="color:red">Vui lòng nhập số tiền nhỏ hơn số tiền còn lại</span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6" id="paymentAccountContainer-{{ $controlId }}" >
                    <div class="fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Tài khoản</span>
                        </label>
                        <select id="payment-account-select-{{ $controlId }}" 
                        data-dropdown-parent ="#CreateReceiptContactForm--{{ $controlId }}"
                         class="form-select form-control" data-placeholder="Chọn tài khoản" data-control="select2" name="payment_account_id" required readonly>
                            
                                {{-- @foreach( $paymentAccounts->get() as $paymentAccount)
                                    <option value="{{ $paymentAccount->id }}">
                                        {{ $paymentAccount->bank }} - {{ $paymentAccount->account_number }} - {{ $paymentAccount->account_name }} 
                                    </option>
                                @endforeach --}}
                            @foreach( \App\Models\PaymentAccount::active()->get() as $paymentAccount)
        
                            <option value="{{ $paymentAccount->id }}" selected>
                                {{ $paymentAccount->bank }} - {{ $paymentAccount->account_number }} - {{ $paymentAccount->account_name }}
    
                            </option>
    
                            @endforeach
                            
                        </select>
                        <x-input-error :messages="$errors->get('payment_account_id')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class=" fs-6 fw-semibold mb-2">
                            <span class="">Ngày tạo phiếu thu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div class="d-flex align-items-center" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                title=
                                '
                                    <div class="class="tooltip-content" style="position: relative;">Hệ thống tự động tính toán trường này, không thể chỉnh sửa!</div>
                                '
                            >
                                <input data-control="input" type="date"
                                    class="form-control bg-secondary pe-none" placeholder="" value="{{ date('Y-m-d') }}" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Ngày thanh toán</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button required">
                                <input data-control="input" name="payment_date" placeholder="=asas" type="date"
                                    data-check-error="{{ $errors->has('payment_date') ? 'error' : '' }}"
                                    class="form-control" placeholder="" value="{{ date('Y-m-d') }}"/>
                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                                </div>
                                <x-input-error :messages="$errors->get('payment_date')" class="mt-2"/>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 fv-row">
                <!--begin::Label-->
                <label class=" fs-6 fw-semibold mb-2">Ghi chú</label>
                <!--end::Label-->
                <!--begin::Textarea-->
                <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="description" rows="5"
                    cols="40"></textarea>
                <!--end::Textarea-->
            </div>
            <x-input-error :messages="$errors->get('description')" class="mt-2"/>

            <!--end::Scroll-->

            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button id="CreateReceiptContactSubmitButton--{{ $controlId }}" type="submit"
                    class="btn btn-primary">
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
        var scrollToErrorHandle;

        $(document).ready(function() {
            fillPaymentDetails();
            initializePriceInput.init();
            CreateReceipt.init();
            
            new ShowPaymentAccount();

            scrollToErrorHandle = new ScrollToErrorManager({
                container: document.querySelector('#CreateReceiptContactForm--{{ $controlId }}')
            })
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

        var initializePriceInput = function() {
            return {
                init: () => {
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

                        $('#CreateReceiptContactForm--{{ $controlId }}').on('submit', function() {
                            priceInput.val(priceInput.val().replace(/,/g, ''));
                        });
                    }
                }
            }

        }();

        var fillPaymentDetails = function() {
            function handleButtonClick(button) {
                var receivableAmount = button.getAttribute('data-receivable-amount');
                var dueDate = button.getAttribute('data-due-date');

                document.querySelector('input[name="amount"]').value = receivableAmount;
                // document.querySelector('input[name="payment_date"]').value = dueDate;
            }

            var buttons = document.querySelectorAll('[data-action="fill-payment-detail"]');

            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    handleButtonClick(button);
                });
            });
        };

        var CreateReceipt = function() {
            let form;
            let submitDataBtn;
            let maxAmount = {{ $order->getTotal() - $order->sumAmountPaid() }};

            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();
                    submit();
                });
            };

            submit = () => {
                initializePriceInput.init();
                var data = $(form).serialize();

                addSubmitEffect();
                
                var contactId = "{{ App\Models\Order::find($order->id)->contacts->id }}";
                var data = $(form).serialize();
                var amountInput = document.querySelector('input[name="amount"]');
                var amountpp = parseFloat(amountInput.value.replace(/,/g, ''));
                data = data.replace(/amount=[^&]*/, 'amount=' + amountpp);

                if (amountpp - maxAmount > 1) {
                    document.querySelector('[data-error="amount-error"]').classList.remove('d-none');
                    removeSubmitEffect();
                    return;
                }

                $.ajax({
                    url: "{{ action('\App\Http\Controllers\Student\PaymentRecordController@storeReceiptContact', ['id' => 'contactId']) }}",
                    method: "POST",
                    data: data
                }).done(response => {
                    ShowOrderPopup.getPopup().hide();
                    ASTool.alert({
                        message: response.message,
                        ok: () => {
                            OrderList.getList().load();
                        }
                    });
                }).fail(response => {
                    ShowOrderPopup.getPopup().setContent(response.responseText);

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
                    form = document.querySelector("#CreateReceiptContactForm--{{ $controlId }}");
                    submitDataBtn = document.querySelector("#CreateReceiptContactForm--{{ $controlId }}");
                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
