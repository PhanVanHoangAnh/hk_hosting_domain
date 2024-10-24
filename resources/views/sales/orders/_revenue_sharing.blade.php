<div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-8 mt-8">
    <div id="{{ $trainOrderRevenueSharingUniqId }}">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xs-12 mb-2">
                <label class="required fs-6 fw-semibold mb-2">Chia doanh thu</label>
            </div>
        </div>
        <div class="card p-10">
            <div class="p-5">
                <div form-data="body">
                    {{-- Load all items here --}}
                </div>
                <div class="row mb-5 mt-5">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 col-xs-12 d-flex justify-content-center">
                        {{-- Button add sale --}}
                        <button class="btn btn-info w-25" action-control="add-sale">+</button>
                    </div>
                </div>
                <div class="row">
                    <div data-container="revenue-sharing-error">
                        <div class="text-danger text-center d-none" label-control="error"></div>
                        <x-input-error :messages="$errors->get('custom_validate_revenue_distribution')" class="mt-2 text-center"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $defaultSale = \App\Models\Account::find(\App\Models\Order::find($orderId)->sale);
        $saleItems = [];

        if (isset($sales_revenued_list) && count($sales_revenued_list) > 0) {
            $saleItems = $sales_revenued_list;
        } elseif (isset($orderItemId) && !isset($copyOrderItemId)) {
            $orderItem = \App\Models\OrderItem::find($orderItemId);
            $collection = $orderItem->revenueDistributions;
            $saleItems = $collection->map(function ($item) use ($orderItemId) {
                $default = 0;
                $saleId = \App\Models\OrderItem::find($orderItemId)->orders->sale;
                $sale = \App\Models\Account::find($saleId);

                if ($item->account_id == $sale->id) {
                    $default = 1;
                }

                $data = $item->toArray();
                
                $data['uniqId'] = '_' . uniqId();
                $data['isDefault'] = $default;
                $data['id'] = $item->account_id;
                $data['price'] = $item->amount;

                return $data;
            })->toArray();
        } elseif (isset($copyOrderItemId) && !is_null($copyOrderItemId)) {
            $orderItem = \App\Models\OrderItem::find($copyOrderItemId);
            $collection = $orderItem->revenueDistributions;
            $saleItems = $collection->map(function ($item) use ($copyOrderItemId) {
                $default = 0;
                $saleId = \App\Models\OrderItem::find($copyOrderItemId)->orders->sale;
                $sale = \App\Models\Account::find($saleId);

                if ($item->account_id == $sale->id) {
                    $default = 1;
                }

                $data = $item->toArray();
                
                $data['uniqId'] = '_' . uniqId();
                $data['isDefault'] = $default;
                $data['id'] = $item->account_id;
                $data['price'] = $item->amount;

                return $data;
            })->toArray();
        } else {
            $saleItems[] = [
                'price' => 0,
                'id' => $defaultSale->id,
                'isDefault' => 1,
                'uniqId' => '_' . uniqId(),
            ];
        }
    @endphp

    {{-- REVENUE SHARING SCRIPT --}}
    <script>
        var RevenueDistribution = class {
            constructor(options) {
                this.container = options.container;
                this.totalPrice = 0;
                this.items = {!! collect($saleItems) !!};
                /**
                 * EXAMPLE:
                 * items = [
                 *      {
                 *          price: 100000,
                 *          id: 2,
                 *          isDefault: 1,
                 *          uniqId: _fwefweefwwe23424,
                 *      },
                 *      {
                 *          price: 400000,
                 *          id: 3,
                 *          isDefault: 0,
                 *          uniqId: _43243dd23d23r2,
                 *      }
                 * ];
                 */

                this.render();
                this.events();
            }

            setParent(parent) {
                this.parent = parent;
            }

            /**
             * Kernel
             * @return void
             */
            shareRevenue() {
                const total = this.totalPrice;

                if (this.items.length === 1) {
                    if (this.convertStringPriceToNumber(this.items[0].price) >= total) return;
                    if (this.convertStringPriceToNumber(this.items[0].price) < total) this.items[0].price = total; 
                    return;
                }

                const test = this.items.reduce((sum, item) => {
                    return sum + (this.convertStringPriceToNumber(item.price) || 0);
                }, 0);

                const sum = this.items.reduce((sum, item) => sum + (this.convertStringPriceToNumber(item.price) || 0), 0);

                if (sum === 0) {
                    this.items.find(item => item.isDefault).price = total;
                    return;
                }

                const DF_ITEM_INDEX = this.items.findIndex(item => item.isDefault);
                const DF_PRICE = this.convertStringPriceToNumber(this.items[DF_ITEM_INDEX].price);

                let isExistPrice = false;

                for (let i = 0; i < this.items.length; ++i) {
                    if (this.convertStringPriceToNumber(this.items[i].price) > 0) {
                        isExistPrice = true;
                        break;
                    }
                }

                if (isExistPrice) {
                    if (DF_PRICE) {
                        return;
                    } 
                }

                if (sum === total) {
                    if (typeof DF_PRICE === 'number' && DF_PRICE !== 0) {
                        return;
                    }
                    
                    this.items[DF_ITEM_INDEX].price = total;

                    for (let i = 0; i < this.items.length; ++i) {
                        if (i !== DF_ITEM_INDEX) {
                            this.items[i].price = 0;
                        }
                    }

                    return;
                }

                if (sum < total || DF_PRICE === 0) {
                    this.items[DF_ITEM_INDEX].price = total;

                    for (let i = 0; i < this.items.length; ++i) {
                        if (i !== DF_ITEM_INDEX) {
                            this.items[i].price = 0;
                        }
                    }

                    return;
                }

                // Case 1.1: DF price >= total
                if (DF_PRICE >= total) {
                    this.items[DF_ITEM_INDEX].price = total;

                    for (let i = 0; i < this.items.length; ++i) {
                        if (i !== DF_ITEM_INDEX) {
                            this.items[i].price = 0;
                        }
                    }

                    return;
                }

                // Case 1.2: DF price < total
                const remainTotal = total - DF_PRICE;

                // Separate remaining total for items which not default
                for (let i = 0; i < this.items.length; ++i) {
                    if (i !== DF_ITEM_INDEX) {
                        this.items[i].price = (total - DF_PRICE) / (this.items.length - 1);
                    }
                }
            }

            catchErrors() {
                let defaultCount = 0;

                if (this.items.length === 0) throw new Error("Empty array items!");

                this.items.forEach(item => {
                    if (item.isDefault === 1) defaultCount += 1;
                })

                if (defaultCount === 0) throw new Error("Default sale not found!");
                if (defaultCount > 1) throw new Error("Sale default count invalid!");
            }

            reset() {
                // Set this total price = total price discounted in staffTimesManager
                const rawData = this.parent.staffTimesManager.getSumSalaryDiscountedValue();
                this.totalPrice = this.convertStringPriceToNumber(rawData);

                this.catchErrors();
                this.shareRevenue();
                this.render();
            }

            convertStringPriceToNumber(strPrice) {
                if (typeof strPrice === 'number' && strPrice > 0) return strPrice;
                if (typeof strPrice !== 'string') return 0;

                let cleanStr = strPrice.replace(/[,|.]/g, '');
                let floatNum = parseFloat(cleanStr);

                return floatNum;
            }

            getBtnAdd() {
                return this.container().querySelector('[action-control="add-sale"]');
            }

            getBody() {
                return this.container().querySelector('[form-data="body"]');
            }

            getBody() {
                return this.container().querySelector('[form-data="body"]');
            }

            generateUniqId() {
                const randomPart = Math.random().toString(36).substr(2, 5);
                const timestamp = new Date().getTime();
                return `_${randomPart}_${timestamp}`;
            }

            render() {
                $.ajax({
                    url: "{{ action([App\Http\Controllers\Sales\RevenueDistributionController::class, 'getSalesRevenuedList']) }}",
                    method: 'post',
                    data: {
                        items: JSON.stringify(this.items),
                        _token: "{{ csrf_token() }}"
                    }
                }).done(response => {
                    $(this.getBody()).html(response);
                    this.eventsAfterRender();
                }).fail(response => {
                    throw new Error(response.messages);
                })
            }

            addSale() {
                this.items.push({
                    price: 0,
                    id: null,
                    isDefault: 0,
                    uniqId: this.generateUniqId()
                });

                this.render();
            }

            getItemByUniqId(uniqIdPrm) {
                return this.items.find(item => item.uniqId === uniqIdPrm);
            }

            removeItem(uniqId) {
                const itemIndex = this.items.findIndex(item => item.uniqId === uniqId);

                if (itemIndex === -1) {
                    throw new Error('Item not found!');
                }

                this.items.splice(itemIndex, 1);
                this.render();
            }

            changePrice(uniqId, price) {
                const itemIndex = this.items.findIndex(item => item.uniqId === uniqId);

                if (itemIndex === -1) {
                    throw new Error('Item not found!');
                }

                this.items[itemIndex].price = price;
                this.render();
            }

            changeSale(uniqId, saleId) {
                const itemIndex = this.items.findIndex(item => item.uniqId === uniqId);

                if (itemIndex === -1) {
                    throw new Error('Item not found!');
                }

                this.items[itemIndex].id = saleId;
                this.render();
            }

            eventsAfterRender() {
                const _this = this;

                $('[row-data="revenue-item"]').each(function() {
                    new Row({
                        box: () => {
                            return this;
                        },
                        parent: () => {
                            return _this;
                        }
                    });
                });
            }

            events() {
                $(this.getBtnAdd()).on('click', (e) => {
                    e.preventDefault();
                    this.addSale();
                })
            }
        }

        var Row = class {
            constructor(options) {
                this.box = options.box;
                this.parent = options.parent;
                this.uniqId = $(this.box()).attr('row-uniq-id');
                this.mask;

                this.assignMask();
                this.events();
            }

            getDeleteBtn() {
                return $(this.box()).find('[action-control="remove-sale"]');
            }

            getPriceInput() {
                return $(this.box()).find('[data-row="price-share"]');
            }

            getSaleSelector() {
                return $(this.box()).find('[data-row="sale-select"]');
            }

            callDelete() {
                this.parent().removeItem(this.uniqId);
            }

            callChangePrice(e) {
                const price = e.target.value;
                this.parent().changePrice(this.uniqId, price);
            }

            callChangeSale(e) {
                const saleId = e.target.value;
                this.parent().changeSale(this.uniqId, saleId);
            }

            assignMask() {
                if ($(this.getPriceInput())) {
                    this.mask = new IMask(this.getPriceInput()[0], {
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
            }

            focusInput(e) {
                const value = e.target.value;

                if (!value || parseFloat(value) === 0) {
                    e.target.value = '';
                } else {
                    setTimeout(() => {
                        this.moveCaretToEnd(e.target);
                    }, 0);
                }
            }

            blurInput(e) {
                const value = e.target.value;

                if (!value || parseFloat(value) === 0) {
                    e.target.value = 0;
                }

                if (value == '') {
                    e.target.value = '';
                }
            }

            moveCaretToEnd(el) {
                if (typeof el.selectionStart == "number") {
                    el.selectionStart = el.selectionEnd = el.value.length;
                } else if (typeof el.createTextRange != "undefined") {
                    el.focus();
                    var range = el.createTextRange();
                    range.collapse(false);
                    range.select();
                }
            }

            events() {
                this.getDeleteBtn().on('click', (e) => {
                    e.preventDefault();
                    this.callDelete();
                })

                this.getPriceInput().on('change keyup', (e) => {
                    e.preventDefault();
                    this.callChangePrice(e);
                    this.mask.updateValue(e.target.value);
                })

                this.getPriceInput().on('focus', (e) => {
                    e.preventDefault();
                    this.focusInput(e);
                })

                this.getPriceInput().on('blur', (e) => {
                    e.preventDefault();
                    this.blurInput(e);
                })

                this.getSaleSelector().on('change keyup', (e) => {
                    e.preventDefault();
                    this.callChangeSale(e);
                })
            }
        }
    </script>
</div>