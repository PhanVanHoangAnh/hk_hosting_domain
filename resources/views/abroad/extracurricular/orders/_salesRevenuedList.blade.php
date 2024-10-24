@php
    $salesRevenuedListUniqId = 'F' . uniqid();
@endphp

@if (isset($items) && $items->count() > 0)
    <div id="{{ $salesRevenuedListUniqId }}">
        @php
            $defaultId;

            foreach($items as $item) {
                if (isset($item['isDefault']) && intval($item['isDefault']) == 1) {
                    $defaultId = $item['id'];
                }
            }
        @endphp

        @foreach ($items as $item)
            <div class="row mb-4" row-data="revenue-item" row-uniq-id="{{ $item['uniqId'] }}">
                <div class="col-lg-8 col-md-8 col-sm-8 col-8 col-xl-8 col-xs-8 mb-2">
                    <select data-row="sale-select" class="form-select form-control {{ isset($item['isDefault']) && intval($item['isDefault']) == 1 ? 'bg-secondary pe-none text-danger fw-bold' : '' }}" data-control="select2" data-dropdown-parent="#{{ $salesRevenuedListUniqId }}"
                        data-placeholder="Chọn nhân viên sale..." data-allow-clear="true">
                        @if (isset($item['isDefault']) && intval($item['isDefault']) == 1)
                            <option value="{{ $item['id'] }}" selected>{{ \App\Models\Account::find($item['id'])->name }}</option>
                        @else
                            <option value="">Chọn nhân viên sale</option>
                            @foreach (\App\Models\Account::sales()->get() as $sale)
                                @if ($defaultId != $sale->id)
                                    <option value="{{ $sale->id }}" {{ isset($item['id']) && $item['id'] == $sale->id ? 'selected' : '' }}>{{ $sale->name }}</option>
                                @endif
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-3 col-xl-3 col-xs-3 mb-2 ">
                    <input type="text" class="form-control text-center"
                    placeholder="Nhập số tiền"
                    value="{{ !isset($item['price']) || floatval($item['price']) == 0 ? '' : $item['price'] }}"
                    data-row="price-share">
                </div>
                <div class="col-lg-1 col-md-1 col-sm-1 col-1 col-xl-1 col-xs-1 mb-2 d-flex justify-content-end">
                    <button class="btn btn-danger {{ isset($item['isDefault']) && intval($item['isDefault']) == 1 ? 'd-none' : '' }}" action-control="remove-sale">X</button>
                </div>
            </div>
        @endforeach
        <input type="hidden" name="sales_revenued_list" value="">
        <script>
            var SalesRevenuedList = class {
                constructor(options) {
                    this.container = options.container;
                    this.items = {!! isset($items) ? $items : '[]' !!};

                    this.loadItemsValue();
                }

                loadItemsValue() {
                    $(this.container()).find('[name="sales_revenued_list"]').val(JSON.stringify(this.items));
                }
            }
        </script>
    </div>
    <script>
        $(() => {
            new SalesRevenuedList({
                container: () => {
                    return $('#{{ $salesRevenuedListUniqId }}');
                }
            })
        })
    </script>
@else
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xs-12 mb-2 d-flex justify-content-center align-items-center">
        <span class="text-danger text-center fs-3 fw-bold">
            ĐÃ CÓ LỖI XẢY RA, VUI LÒNG BÁO LỖI CHO ADMIN HOẶC THỬ REFRESH VÀ THAO TÁC LẠI!
        </span>
    </div>
</div>
@endif