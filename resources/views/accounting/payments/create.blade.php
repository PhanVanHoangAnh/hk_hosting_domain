@extends('layouts.main.popup')

@section('title')
    Tạo phiếu thu
@endsection
@php
    $controlId = uniqid();
@endphp
@section('content')
    <form id="CreateReceiptForm-{{ $controlId }}" tabindex="-1" method="post"
        action="{{ action([App\Http\Controllers\Accounting\PaymentRecordController::class, 'store']) }}">
        @csrf 
        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" >
            <!--begin::Input group-->
            <div class="row">
                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Khách hàng</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <select id="contact-select-{{ $controlId }}" list-action="contact-select-change" data-control="select2-ajax" 
                                data-allow-clear="true" data-placeholder="Chọn khách hàng/liên hệ" data-control="select2"  
                                data-dropdown-parent ="#CreateReceiptForm-{{ $controlId }}"
                                data-url="{{ action('App\Http\Controllers\Accounting\PaymentRecordController@select2') }}"
                                class="form-control" name="contact_id" required select2>
                                <option value="">Chọn khách hàng/liên hệ</option>
                            </select>
                            <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
                        </div>
                    </div>
                  
                </div>
                 
                <div class="col-md-6">
                    <div class=" fv-row mb-7">
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Mã hợp đồng</span>
                        </label>
                        <select id="contract-select-{{ $controlId }}" class="form-select form-control" data-placeholder="Chọn mã hợp đồng"
                            data-dropdown-parent ="#CreateReceiptForm-{{ $controlId }}"
                            data-action="order-select" data-control="select2" name="order_id" data-action="order-select" required>
                            <option value="">Chọn mã hợp đồng</option>

                        </select>
                        <x-input-error :messages="$errors->get('order_id')" class="mt-2" />
                    </div>
                </div>
            </div>
            <script>
                $(() => {
                    new OrderBox({
                        box: $('#table-order'),
                        orderList: $('[data-action="order-select"]'),
                        url: '{{ action('\App\Http\Controllers\Accounting\PaymentRecordController@getOrders') }}',
                        getTypeSelectBox: function () {
                            return $('#contact-select-{{ $controlId }}');
                        }
                    });
                    
                });
            
                var OrderBox = class {
                    constructor(options) {
                        this.box = options.box;
                        this.orderList = options.orderList;
                        this.trans = @json(__('messages'));
                        this.url = options.url;
                        this.getTypeSelectBox = options.getTypeSelectBox;
                        this.events();
                        this.render();
                    }
            
                    events() {
                        this.getTypeSelectBox().on('change', (e) => {
                            this.clearSubjects();
                            this.render();
                        });
            
                        if (!this.getTypeSelectBox().val()) {
                            this.box.html('');
                            this.orderList.html('');
                            return;
                        }
                    }
            
                    render() {
                        $.ajax({
                            url: this.url,
                            type: 'GET',
                            data: {
                                contact_id: this.getTypeSelectBox().val(),
                            },
                        }).done((response) => {
                            this.orderList.html('<option value="">Chọn hợp đồng</option>');
                            response.forEach(order => {
                                if (!(order.paid_amount >= order.cache_total)) {
                                    const option = `<option value="${order.id}">${order.code}</option>`;
                                    this.orderList.append(option);
                                }
                            });

                            let tableHtml = `
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
                                    <tbody>`;
            
                            if (Array.isArray(response) && response.length > 0) {
                                response.forEach(order => {
                                    tableHtml += `
                                        <tr>
                                            <td>
                                                <div>
                                                    <a class="fw-semibold text-info"
                                                        data-bs-toggle="tooltip" data-bs-trigger="hover" title="Nhấn để chỉnh sửa hợp đồng này"
                                                        >
                                                        ${order.code}
                                                    </a>
                                                </div>
                                                <span class="badge bg-secondary">
                                                    ${order.status}
                                                </span>
                                            </td>

                                            <td > 
                                                ${(order.paid_amount >= order.cache_total ? '<span class="badge bg-success">Đã thanh toán </span>'
                                                 : (order.paid_amount > 0 ? '<span class="badge bg-info text-white">Đang thanh toán</span>' 
                                                 : '<span class="badge bg-warning">Chưa thanh toán'))}
                                            </td>
                                            <td>
                                                ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.cache_total)}
                                            </td> 
            
                                            <td>
                                                ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.paid_amount)}
                                            </td>
            
                                            <td>
                                                ${new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(order.cache_total-order.paid_amount)}
            
                                            </td>
                                            
                                            <!-- Add more columns as needed -->
                                        </tr>`;
                                });
                            } else {
                                tableHtml += `<tr><td colspan="5">Không có hợp đồng</td></tr>`;
                            }
            
                            tableHtml += `</tbody></table>`;
                            this.box.html(tableHtml);
                        });
                    }
            
                    clearSubjects() {
                        this.box.html('');
                    }
                };
                // $('[data-action="order-select"]').on('change', function () {
                //     var orderId = $(this).val();


                //     if (orderId !== null && orderId !== undefined) {
                //         $.ajax({
                //             url: '{{ action('\App\Http\Controllers\Accounting\PaymentRecordController@getPaymentAccount') }}',
                //             type: 'GET',
                //             data: {
                //                 order_id: orderId
                //             },
                //         }).done((response) => {
                //             var paymentAccountSelect = $('#payment-account-select-{{ $controlId }}');
                //             paymentAccountSelect.html('');

                //             if (response && response.id) {
                //                 const option = `<option value="${response.id}">${response.bank_name} - ${response.account_number} - ${response.account_name}</option>`;
                //                 paymentAccountSelect.append(option);
                //             } 
                //         }).fail(() => {
                //             throw new Error('fail');
                //         });
                //     } else {
                //         throw new Error('orderId is null');
                //     }
                // });
                $('[data-action="order-select"]').on('change', function () {
                    var orderId = $(this).val();
                    

                    if (orderId !== null && orderId !== undefined) {
                        
                        $.ajax({
                            url: '{{ action('\App\Http\Controllers\Accounting\PaymentRecordController@getProgressOrder') }}',
                            type: 'GET',
                            data: {
                                order_id: orderId,
                            },
                        }).done((response) => {
                            $('#progress-order').html(response);
                        }).fail(() => {
                            throw new Error('fail');
                        });
                    } else { 
                        throw new Error('orderId is null');
                    }
                });

                $('#contact-select-{{ $controlId }}').on('change', function () { 
                    $('#progress-order').html(`
                        <div class="">
                            <div class="form-outline">
                                <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                                    error
                                </span>
                                <span>Chưa mã hợp đồng để tiến hành thanh toán!</span>
                            </div>
                        </div>
                    `);
                }); 
            </script>
            
            
            <div class="col-md-12 solid mb-7" id="table-order"></div>

            <script>

              
            </script>
            <div class="col-md-12 solid mb-7" id="progress-order"></div>
           
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
                        <select id="payment-account-select-{{ $controlId }}" 
                        data-dropdown-parent ="#CreateReceiptForm-{{ $controlId }}"
                        class="form-select form-control" data-placeholder="Chọn tài khoản" 
                         data-control="select2" name="payment_account_id" required>
                            <option value="">Chọn tài khoản </option>
                           
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
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Ngày thanh toán</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="payment_date" placeholder="=asas" type="date"
                                    class="form-control" placeholder="" required />
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Số tiền</span>
                        </label>

                        <input type="text" class="form-control" id="price-input" list-action='format-number' name="amount" placeholder="Số tiền"
                            required />
                            
                          

                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                </div>

            </div>

            <div class="col-md-12 fv-row">
                <!--begin::Label-->
                <label class=" fs-6 fw-semibold mb-2">Ghi chú</label>
                <!--end::Label-->
                <!--begin::Textarea-->
                <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="description" rows="5" cols="40"></textarea>
                <!--end::Textarea-->
            </div>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />

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
        </div>
    </form>
    <script>
        $(document).ready(function() {
            initializePriceInput.init();
           
            CreateReceipt.init();
            new ShowPaymentAccount();
            $("#price-input").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
            })
        });

        

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

                        $('#CreateReceiptForm-{{ $controlId }}').on('submit', function() {
                            priceInput.val(priceInput.val().replace(/,/g, ''));
                        });
                    }
                }
            }

        }();

        
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
                    url: "{{ action([App\Http\Controllers\Accounting\PaymentRecordController::class, 'store']) }}",
                    method: 'POST',
                    data: data
                }).done(response => {
                    CreateReceiptPopup.getCreatePopup().hide();

                    ASTool.alert({
                        message: response.message,
                        ok: () => {
                            ReceiptList.getList().load();
                        }
                    });
                }).fail(response => {
                    CreateReceiptPopup.getCreatePopup().setContent(response.responseText);
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
