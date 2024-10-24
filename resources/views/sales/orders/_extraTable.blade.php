@php
    $uniqExtraTableId = "uniq_extra_table_" . uniqId();
@endphp

<div class="col-lg-12 col-xl-12 col-md-12 col-sm-12 col-12 mb-4" id="{{ $uniqExtraTableId }}">   
    <div class="form-outline bg-secondary pt-5 px-5">
        <table class="table align-middle fs-6 gy-5 table-origin">
            <thead>
                <tr class="text-start text-dark fw-bold fs-7 text-uppercase gs-0 text-nowrap item-row">
                    <th class="min-w-125px">
                        <span class="d-flex align-items-center">
                            <span class="text-center text-info fw-bold fs-6">
                                Tên hoạt động
                            </span>
                        </span>
                    </th>
                    <th class="min-w-125px">
                        <span class="d-flex align-items-center">
                            <span class="text-center text-info fw-bold fs-6">
                                Giá tiền niêm yết
                            </span>
                        </span>
                    </th>
                    <th class="min-w-125px">
                        <span class="d-flex align-items-center">
                            <span class="text-center text-info fw-bold fs-6">
                                Số tiền thu được
                            </span>
                        </span>
                    </th>
                    <th class="min-w-125px" data-column="start_at">
                        <span class="d-flex align-items-center">
                            <span class="text-center text-info fw-bold fs-6">
                                Thời điểm bắt đầu
                            </span>
                        </span>
                    </th>
                    <th class="min-w-125px" data-column="end_at">
                        <span class="d-flex align-items-center">
                            <span class="text-center text-info fw-bold fs-6">
                                Thời điểm kết thúc
                            </span>
                        </span>
                    </th>
                </tr>
            </thead>

            <tbody class="text-gray-600">
                <tr list-control="item" class="item-row" data-bs-trigger="hover">
                    <td class="mb-1 text-nowrap" data-filter="mastercard">
                        {{ $extracurricular->name }}
                    </td>

                    <td class="mb-1 text-nowrap" data-filter="mastercard">
                        <input type="text" value="{{ isset($orderItem) ? App\Helpers\Functions::formatNumber($orderItem->price) : (isset($extracurricular->price) ? App\Helpers\Functions::formatNumber($extracurricular->price) : 0) }}" name="price" class="border-0">
                    </td>

                    <td data-column="start_at" class="mb-1 text-nowrap" data-filter="mastercard">
                        <input type="text" value="" name="price_after_discount" class="border-0 pe-none bg-secondary" readonly>
                    </td>

                    <td data-column="start_at" class="mb-1 text-nowrap" data-filter="mastercard">
                        {{ \Carbon\Carbon::parse($extracurricular->created_at)->format('d-m-Y') }}
                    </td>
                    <td data-column="end_at" class="mb-1 text-nowrap" data-filter="mastercard">
                        {{ \Carbon\Carbon::parse($extracurricular->end_at)->format('d-m-Y') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(() => {
        new ExtraTable({
            container: () => {
                return $("#{{ $uniqExtraTableId }}");
            }
        })

        // GetPrice.init();
    })

    function formatNumberWithCommas(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    var ExtraTable = class {
        constructor(options) {
            this.container = options.container;
            this.priceMask = IMask(this.getPriceAfterDiscountInput()[0], {
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
            this.initPriceMask = IMask(this.getPriceInput()[0], {
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

            this.setPrice();
            this.events();
        }

        getContainer() {
            return this.container();
        }
        
        getPriceInput() {
            return this.getContainer().find('[name="price"]');
        }

        getListedPrice() {
            return parseFloat("{!! isset($orderItem) ? $orderItem->price : (isset($extracurricular->price) ? $extracurricular->price : 0) !!}");
        }

        getPriceAfterDiscountInput() {
            return this.getContainer().find('[name="price_after_discount"]');
        }

        setPrice(fixedInitPrice=null) {
            let listedPrice;

            if (typeof fixedInitPrice !== 'undefined' && fixedInitPrice) {
                listedPrice = fixedInitPrice;
            } else {
                listedPrice = this.getListedPrice();
            }

            const priceBeforeDiscount = supportFunctions.convertStringPriceToNumber(listedPrice);
            const discountPercent = parseFloat($('[name="discount_percent"]').val());
            const priceAfterDiscount = priceBeforeDiscount - (priceBeforeDiscount / 100 * discountPercent);
            
            this.getPriceAfterDiscountInput().val(parseInt(priceAfterDiscount));
            
            setTimeout(() => {
                IMask(this.getPriceAfterDiscountInput()[0], {
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
            }, 0);

            if (tool) {
                tool.updateTotalPrice(priceAfterDiscount);
            }
        }

        changePriceHandle() {
            const currentPrice = this.getPriceInput().val();

            this.initPriceMask.updateValue(currentPrice);
            this.setPrice(currentPrice);
        }

        events() {
            const _this = this;

            _this.getPriceInput().on('change', e => {
                e.preventDefault();
                _this.changePriceHandle();
            })
        }
    }
</script>
