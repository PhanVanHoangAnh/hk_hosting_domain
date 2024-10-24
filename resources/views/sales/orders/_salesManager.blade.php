<div class="row" data-box="sales-manager-box">
    <div class="col-3 mb-4">
        <div class="form-outline mb-5">
            <label class="fs-6 fw-semibold mb-2" for="order-sale-select">Sale</label>
         
            <select id="order-sale-select" 
                class="form-select form-control {{ Auth::user()->hasPermission(\App\Library\Permission::SALES_DASHBOARD_ALL) ? "" : "pe-none bg-secondary" }}" 
                name="sale" data-selector="sale"
                data-control="select2" data-placeholder="Chọn sale">
                <option value="">Chọn sale</option>
                @foreach (App\Models\Account::byBranch(\App\Library\Branch::getCurrentBranch())->sales()->get() as $account)
                    <option value="{{ $account->id }}"
                        {{ $order->sale == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('sale')" class="mt-2" />
        </div>
    </div>

    <div class="col-3 mb-4">
        <div class="form-outline">
            <label class="fs-6 fw-semibold mb-2" for="order-sale-sup-select">Sale Sup</label>
            <select id="order-sale-sup-select" class="form-select form-control bg-secondary pe-none" name="sale_sup" data-selector="sale-sup"
                data-control="select2" data-placeholder="Sale chưa có sale sup">
                <option value="">Sale chưa có sale sup</option>
            </select>
            <x-input-error :messages="$errors->get('sale_sup')" class="mt-2" />
        </div>
    </div>

    <div class="col-3 mb-4">
        <div class="form-outline">
            <label class="fs-6 fw-semibold mb-2" for="order-date-input">Ngày hợp đồng</label>
            <input id="order-date-input" name="order_date" type="date"
                value="{{ $order->order_date ? $order->order_date : '' }}" class="form-control"
                placeholder="Ngày hợp đồng...">
        </div>
    </div>

    <div class="col-3 mb-4">
        <div class="form-outline">
            <label class="fs-6 fw-semibold mb-2" for="order-date-input">Mã hợp đồng</label>
            <input readonly value="{{ $order->code ? $order->code : '' }}" class="pe-none fw-bold bg-secondary form-control">
        </div>
    </div>

    <script>
        var SalesManager = class {
            constructor (options) {
                this.box = options.box;
                this.saleSelector = options.saleSelector;
                this.saleSupSelector = options.saleSupSelector;

                this.events();
            }

            getSaleSupsBySale(saleId) {
                return new Promise((resolve, reject) => {
                    let url = "{{ action([App\Http\Controllers\AccountController::class, 'getSaleSupBySale'], ['id' => 'PLACEHOLDER']) }}";
                    const updatedUrl = url.replace('PLACEHOLDER', saleId);

                    $.ajax({
                        url: updatedUrl
                    }).done(response => {
                        resolve(response.saleSup);
                    }).fail(response => {
                        reject(new Error("Get sale sup fail!"));
                    })
                })
            }

            loadSaleSupOptions(saleSup) {
                let content;

                if (!saleSup) {
                    content = `<option value="" selected style="font-style: italic;">Sale chưa có sale sup</option>`;
                } else {
                    content = `<option value="${saleSup.id}" selected>${saleSup.name}</option>`;
                }

                this.saleSupSelector().html(content);
            }

            changeSale(e) {
                const _this = this;
                if (this.saleSelector().data('select2')) {
                    if (this.saleSelector().val()) {
                        this.getSaleSupsBySale(e.target.value)
                            .then(response => {
                                this.loadSaleSupOptions(response);
                            }).catch(response => {
                                throw response;
                            })

                        // Save sale
                        $.ajax({
                            url: "{{ action([App\Http\Controllers\Sales\OrderController::class, 'saveSale']) }}",
                            method: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                orderId: "{{ $order->id }}",
                                sale: _this.saleSelector().val(),
                                saleSup: _this.saleSupSelector().val(),
                            }
                        }).done(res => {
                        }).fail(res => {
                            throw new Error("Save sale data fail!");
                        })
                    }
                }
            }

            events() {
                this.saleSelector().on('change', (e) => {
                    e.preventDefault();
                    this.changeSale(e);
                })
            }
        }
    </script>
</div>

<script>
    $(() => {
        salesManager = new SalesManager({
            box: () => {
                return $('[data-box="sales-manager-box"]');
            },
            saleSelector: () => {
                return $('[data-selector="sale"]');
            },
            saleSupSelector: () => {
                return $('[data-selector="sale-sup"]');
            }
        })
    })

</script>