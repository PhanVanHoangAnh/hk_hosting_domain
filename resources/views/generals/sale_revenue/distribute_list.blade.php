@foreach ($revenueData as $revenue)
    <div class="row mb-4" row-data="revenue-item">
        <input type="hidden" name="c_id" value="{{ $revenue['c_id'] }}">
        <div class="col-lg-8 col-md-8 col-sm-8 col-8 col-xl-8 col-xs-8 mb-2">
            <select class="form-select form-control {{ !$revenue['is_primary'] ? '' : 'bg-secondary pe-none' }}" data-control="select2" data-dropdown-parent="#{{ $parentId }}"
                data-placeholder="Chọn nhân viên sale..." data-allow-clear="true">
                    <option value="">Chọn nhân viên sale</option>
                    @foreach (\App\Models\Account::all() as $sale)
                        <option value="{{ $sale->id }}" {{ isset($revenue['account_id']) && $revenue['account_id'] == $sale->id ? 'selected' : '' }}>{{ $sale->name }}</option>
                    @endforeach
            </select>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-3 col-xl-3 col-xs-3 mb-2">
            <input type="hidden" name="account_id" value="{{ isset($revenue['account_id']) && $revenue['account_id'] ? $revenue['account_id'] : '' }}">
            <input type="hidden" name="order_item_id" value="{{ isset($revenue['order_item_id']) && $revenue['order_item_id'] ? $revenue['order_item_id'] : '' }}">
            <input type="text" class="form-control text-center"
            placeholder="Nhập số tiền"
            value="{{ isset($revenue['amount']) && $revenue['amount'] ? $revenue['amount'] : '' }}"
            data-row="price-share">
        </div>

        @if (!$revenue['is_primary'])
            {{-- Delete button --}}
            <div class="col-lg-1 col-md-1 col-sm-1 col-1 col-xl-1 col-xs-1 mb-2 d-flex justify-content-end">
                <button class="btn btn-danger" action-control="remove-sale">X</button>
            </div>
        @endif
    </div>
@endforeach

<script>
    $(() => {
        tool.container().find('[row-data="revenue-item"]').each((key, elm) => {
            new Row({
                container: () => {
                    return $(elm);
                },
                tool: tool // Global variable exclude this view
            })
        })
    })

    var Row = class {
        constructor(options) {
            this.container = options.container;
            this.amountInputMask;
            this.tool = options.tool;

            this.assignAmountInputMask();
            this.events();
            this.updateToolData();
        }

        /* GETTER SETTER */

        /**
         * Get account ID from the row.
         * 
         * @return {string} - The account ID.
         */
        getAccountId() {
            return this.container().find('[name="account_id"]').val();
        }

        /**
         * Get order item ID from the row.
         * 
         * @return {string} - The order item ID.
         */
        getOrderItemId() {
            return this.container().find('[name="order_item_id"]').val();
        }

        /**
         * Get the input element for the amount from the row.
         * 
         * @return {JQuery} - jQuery object containing the amount input element.
         */
        getAmountInput() {
            return this.container().find('[data-row="price-share"]');
        }

        /**
         * Get the amount from the row.
         * 
         * @return {string} - The amount.
         */
        getAmount() {
            return this.getAmountInput().val();
        }

        /**
         * Get the select element for person from the row.
         * 
         * @return {JQuery} - jQuery object containing the select element for person.
         */
        getPersonSelect() {
            return this.container().find('select');
        }

        /**
         * Get the person ID from the row.
         * 
         * @return {string} - The person ID.
         */
        getPersonId() {
            return this.getPersonSelect().val();
        }

        /**
         * Get the c_id from the row.
         * 
         * @return {string} - The c_id.
         */
        getCId() {
            return this.container().find('[name="c_id"]').val();
        }

        /**
         * Get delete button
         * 
         * @return {Jquery} jQuery object containing the delete button element(s)
         */
        getDeleteBtn() {
            return this.container().find('[action-control="remove-sale"]');
        }

        /* METHOD */

        assignAmountInputMask() {
            const _this = this;

            this.amountInputMask = new IMask(_this.getAmountInput()[0], {
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
        }

        /**
         * Get current values of the row.
         * 
         * @return {Object} - Object containing current values.
         */
        getCurrValues() {
            return {
                c_id: this.getCId(),
                account_id: this.getPersonId(),
                amount: this.getAmount()
            }
        }

        updateToolData() {
            const currValue = this.getCurrValues();

            this.tool.updateData(currValue);
            this.tool.loadDataToSave();
        }

        /**
         * Handle all events of the row instance.
         * 
         * @return {void}
         */
        events() {
            const _this = this;

            // Delete row
            _this.getDeleteBtn().on('click', e => {
                e.preventDefault();

                _this.tool.removeData(this.getCId());
            })

            // Change sale
            _this.getPersonSelect().on('change blur', e => {
                e.preventDefault();

                _this.updateToolData();
            })

            // Change amount value
            _this.getAmountInput().on('change blur', e => {
                e.preventDefault();

                this.amountInputMask.updateValue(_this.getAmount());
                
                _this.updateToolData();
                setTimeout(() => {
                    tool.load();
                }, 100);
            })
        }
    }
</script>