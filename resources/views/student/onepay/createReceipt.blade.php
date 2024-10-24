@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Tạo link thanh toán OnePay cho {{ $order->contacts->name }}
@endsection

@php
    $controlId = uniqid();
@endphp
@section('content')
    <form id="CreateReceiptForm-{{ $controlId }}" tabindex="-1" method="post">
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
                            {{ $order->contacts->name }}</strong><br>
                            {{ $order->contacts->email }}<br>
                            {{ $order->contacts->phone }}

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
                                  
                                </td>

                               
                                <td>
                                    {{ number_format($order->getTotal(), 0, '.', ',') }}₫

                                </td>

                                <td>
                                    {{ number_format($order->getPaidAmount(), 0, '.', ',') }}₫

                                </td>

                                <td>
                                    {{ number_format($order->getRemainAmount(), 0, '.', ',') }}₫
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="row">
                
                <div class="col-md-6">
                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 required">
                            <span class="">Số tiền</span>
                        </label>

                        <input type="text" class="form-control" id="price-input" name="amount"
                            value="" placeholder="Số tiền" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>
                </div>

            </div>


        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <a row-action="show-link" class="btn btn-primary" id="create-link"
                href="{{ action(
                    [App\Http\Controllers\Student\OnePayController::class, 'showLink'],
                    [
                        'id' => $order->id,
                        'amount' => '__AMOUNT__',
                    ]
                ) }}"
            class="menu-link px-3">Tạo link</a>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_note_log_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
       $(() => {
    ShowOnePayPopup.init();
        const linkOnePayPopup = new LinkOnePayPopup({
            container: $('#CreateReceiptForm-{{ $controlId }}')
        });
        linkOnePayPopup.initializePriceInput();
    });

    class LinkOnePayPopup {
        constructor(options) {
            this.container = options.container;
            this.events();
        }

        getButtonCreateLink() {
            return this.container.find('#create-link');
        }

        events() {
            this.getButtonCreateLink().on('click', (e) => {
                e.preventDefault();
                const amount_value = $('#price-input').val();
               
                const amount = Number(amount_value.replace(/,/g, ''));

                const url = this.getButtonCreateLink().attr('href').replace('__AMOUNT__', amount); 
               
                ShowOnePayPopup.updateUrl(url);
            });
        }

        initializePriceInput() {
            const priceInput = this.container.find('#price-input');

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

                this.container.on('submit', () => {
                    priceInput.val(priceInput.val().replace(/,/g, ''));
                });
            }
        }
    }

    const ShowOnePayPopup = (() => {
        let popup;

        return {
            init: () => {
                popup = new Popup();
            },
            updateUrl: (newUrl) => {
                popup.url = newUrl;
                popup.load();
            },
            getPopup: () => {
                return popup;
            }
        };
    })();

        
        
    </script>

@endsection
