@php
    $eduPriceManagerUniqId = 'G' . uniqid();
@endphp

<h3 class="mt-10 mb-5 fs-2 text-primary {{ $order && $order->type == \App\Models\Order::TYPE_REQUEST_DEMO ? 'd-none' : '' }}">Giá dịch vụ</h3>
<div data-container="edu-price-manager" id="{{ $eduPriceManagerUniqId }}">
    <div class="row mb-4">
        <div class="col-12 col-md-4">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2" for="price-after-discount">Giá bán</label>
                <div id="price-after-discount" data-action="markup-price" class="form-control cursor-pointer">
                    {{ isset($order) ? number_format($order->getPriceBeforeDiscount(), 0, '.', ',') : 0 }}
                </div>
                <x-input-error :messages="$errors->get('price')" class="mt-2"/>
                <label id="error-price" class="fs-7 fw-semibold mb-2 text-danger d-none">Giá bán không hợp lệ</label>
            </div>
        </div>
        <div class="col-12 col-md-2">
            <div class="form-outline">
                <label class="fs-6 fw-semibold mb-2" for="currency-select"
                    style="visibility:hidden;">.</label>
                <select id="currency-select" class="form-select form-control" name="currency_code"
                    data-control="select2" data-dropdown-parent="#create-constract-form">
                    @foreach (config('currencies') as $currency)
                        <option
                            {{ isset($order) && $order->currency_code == $currency ? 'selected' : '' }}
                            value="{{ $currency }}">{{ $currency }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12 col-md-3 mb-2">
            <div class="form-outline">
                <label class="fs-6 fw-semibold mb-2" for="discount-create-input">Tỷ lệ khuyến mãi (%)</label>
                <div class="d-flex align-items-center" style="width:100%">
                    <div style="width:100%">
                        <input id="discount-create-input" class="form-control" name="discount_code"
                            type="number" min="0" max="100"
                            placeholder="Nhập khuyến mãi..."
                            value="{{ isset($order) ? $order->discount_code : 0 }}" />
                    </div>
                </div>
                <label id="error-discount-percent" class="fs-7 fw-semibold mb-2 text-danger d-none">Tỷ lệ khuyến mãi không hợp lệ</label>
            </div>
        </div>
        <div id="exchange-form" class="col-12 col-md-3 mb-2 d-none">
            <div class="">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="exchange-input">Tỷ giá quy đổi (Nếu giá USD)</label>
                    <input id="exchange-input" class="form-control" name="exchange"
                        placeholder="Nhập tỷ giá..."
                        value="{{ isset($order) ? $order->exchange : 0 }}">
                    <label id="error-exchange" class="fs-7 fw-semibold mb-2 text-danger">Tỷ giá quy đổi không hợp lệ</label>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-4 col-md-4 col-sm-10 col-10 mb-2">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2 border-none" for="price-create-input">Giá bán sau khuyến mãi (VND)</label>
                <input id="price-create-input" type="text" class="form-control border-0 bg-light-info ps-0 fs-2 text-end fw-semibold"
                    readonly data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                    title='Giá trị dịch vụ bằng tổng giá trị các dịch vụ của dịch vụ!'
                    name="price" value="{{ isset($order) ? $order->getTotal(): 0 }}">
            </div>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-2 col-2 mb-2">
            <label class="fs-6 fw-semibold mt-12 fs-2">₫</label>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 col-xl-12">
            <label class="fs-6 fw-semibold mb-2" for="target-input">Tiến độ thanh toán</label>
            <input data-action="check-pay-all" type="checkbox" name="is_pay_all"
                {{ isset($order) && $order->is_pay_all == 'on' ? 'checked' : '' }} class="ms-2"
                id="is-payall-checkbox"> Thanh toán 1 lần
            <div id="schedule-payment-form"
                class="card p-5 {{ isset($order) && $order->is_pay_all == 'on' ? 'd-none' : '' }}">
                <div class="row">
                    <div id="form1"
                        class="col-lg-8 col-md-12 col-sm-12 col-12 col-xl-8 col-xs-12 mb-2 pe-16 border-end">
                        <div class="row mb-3">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2"
                                        for="schedule-price-input">Giá dịch vụ</label>
                                    <input data-mask="schedule-price-input" id="schedule-price-input"
                                        type="text" class="form-control"
                                        placeholder="Nhập giá dịch vụ...">
                                    <label id="error-price-schedule"
                                        class="fs-7 fw-semibold mb-2 text-danger d-none">Giá không hợp lệ</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2"
                                        for="schedule-date-input">Hạn thanh toán</label>

                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" id="schedule-date-input"
                                            name="created_at_from" placeholder="=asas" type="date"
                                            class="form-control" placeholder="Hạn thanh toán..."
                                            value={{ !isset($orderItem) ? '' : $orderItem->created_at_from }}>
                                        <span data-control="clear"
                                            class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                    <label id="error-date-schedule"
                                        class="fs-7 fw-semibold mb-2 text-danger d-none">Ngày thanh toán không hợp lệ</label>
                                </div>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-between">
                            <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                <div id="add-schedule-btn"
                                    class="btn btn-light w-75 btn-sm d-flex align-items-center justify-content-center">
                                    <span class="material-symbols-rounded">add</span>&nbsp;Thêm tiến độ
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                <div class="row">
                                    <div
                                        class="col-lg-4 col-md-4 col-sm-4 col-4 d-flex justify-content-end align-items-center">
                                        <label class="fs-6 fw-semibold" for="balance-form">Số tiền còn lại (₫)</label>
                                    </div>
                                    <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                        <div class="form-outline">
                                            <div id="balance-form" class="form-control border-0 bg-light-info ps-0 fs-4 text-end fw-semibold">0</div>
                                        </div>
                                    </div>
                                </div>
                                <label id="error-balance-schedule"
                                    class="fs-7 fw-semibold mb-2 text-danger text-center w-100 d-none"></label>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('total_schedules')" class="mt-2" />
                    </div>
                    <div id="form2"
                        class="col-lg-4 col-md-12 col-sm-12 col-12 col-xl-4 col-xs-12 mb-2">
                        <ul id="list-schedule-items-content" class="list-group list-group-flusF">
                        </ul>
                    </div>
                </div>
            </div>

            <div id="action-debt-allow"
                class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 col-xl-12 d-none">
                <label class="fs-6 fw-semibold mb-2" for="target-input">Cho công nợ</label>
                <input data-action="check-debt-allow" type="checkbox" name="debt_allow"
                    class="ms-2" id="debt-allow">

                <div id="debt-due-date" class='d-none'>
                    <label class="required fs-6 fw-semibold mb-2" for="schedule-date-input">Công nợ đến ngày</label>
                    <div data-control="date-with-clear-button"
                        class="d-flex align-items-center date-with-clear-button">
                        <input data-control="input" id="schedule-date-input" name="debt_due_date"
                            placeholder="=asas" type="date" class="form-control"
                            placeholder="Hạn thanh toán..."
                            value={{ !isset($orderItem) ? '' : $orderItem->created_at_from }}>
                        <span data-control="clear" class="material-symbols-rounded clear-button"
                            style="display:none;">close</span>
                    </div>
                    {{-- </div> --}}
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(() => {
        eduPriceManager = new PriceManager({
            container: document.querySelector('#{{ $eduPriceManagerUniqId }}'),
            orderItemScheduleList: getOrderItem()
        });
    })
</script>