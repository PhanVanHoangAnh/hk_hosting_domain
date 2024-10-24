<div class="row" data-box="sales-manager-box">
    <div class="col-3 mb-4">
        <div class="form-outline mb-5">
            <label class="fs-6 fw-semibold mb-2" for="order-sale-select">Nhân viên ngoại khóa</label>
            <select id="order-sale-select" class="form-select form-control {{ Auth::user()->hasPermission(\App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL) ? "" : "pe-none bg-secondary" }}" name="sale" data-selector="sale"
                data-control="select2" data-placeholder="Chọn nhân viên">
                <option value="">Chọn nhân viên</option>
                @foreach (App\Models\Account::byBranch(\App\Library\Branch::getCurrentBranch())->extracurriculars()->get() as $account)
                    <option value="{{ $account->id }}"
                        {{ $order->sale == $account->id ? 'selected' : '' }}>{{ $account->name }}</option>
                @endforeach
        </select>
            <x-input-error :messages="$errors->get('sale')" class="mt-2" />
        </div>
    </div>

    <div class="col-3 mb-4">
        <div class="form-outline">
            <label class="fs-6 fw-semibold mb-2" for="order-sale-sup-select">Quản lý</label>
            <select id="order-sale-sup-select" class="form-select form-control bg-secondary pe-none" name="sale_sup" data-selector="sale-sup"
                data-control="select2" data-placeholder="Nhân viên chưa có quản lý">
                <option value="">Nhân viên chưa có quản lý</option>
            </select>
            <x-input-error :messages="$errors->get('sale_sup')" class="mt-2" />
        </div>
    </div>

    <div class="col-3 mb-4">
        <div class="form-outline">
            <label class="fs-6 fw-semibold mb-2" for="order-date-input">Ngày dịch vụ</label>
            <input id="order-date-input" name="order_date" type="date"
                value="{{ $order->order_date ? $order->order_date : '' }}" class="form-control"
                placeholder="Ngày dịch vụ...">
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
                        reject(new Error("Get quản lý fail!"));
                    })
                })
            }

            loadSaleSupOptions(saleSup) {
                let content;

                if (!saleSup) {
                    content = `<option value="" selected style="font-style: italic;">Nhân viên chưa có quản lý</option>`;
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
                            url: "{{ action([App\Http\Controllers\Abroad\OrderController::class, 'saveSale']) }}",
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