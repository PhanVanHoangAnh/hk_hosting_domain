@if ($orders->count())
    @php
        $orderFormId = 'orderForm_' . uniqid();
    @endphp
    <label class="form-label fw-semibold d-none">Chọn hợp đồng</label>
    <div id="{{ $orderFormId }}" class="table-responsive d-none">
        <input type="d-none" name="orders" value="{{ $orders }}">
        <select form-control="contact-select" class="form-control" name="order_id"
            data-dropdown-parent="#{{ $orderFormId }}" data-control="select2" data-placeholder="Chọn hợp đồng" multiple>
            @foreach ($orders as $order)
                <option value="{{ $order->id }}" selected>{{ $order->code_year }}/{{ $order->code_number }}</option>
            @endforeach
        </select>
    </div>


    <div data-control="order-item-form-request-demo" class="mt-10"></div>


    <script>
        $(() => {
            new OrderItemForm({
                box: $('[data-control="order-item-form-request-demo"]'),
                url: '{{ action('\App\Http\Controllers\Edu\StudentController@orderItemFormRequestDemo') }}',
                getOrderSelectBox: function() {
                    return $('[name="order_id"]');
                }
            });


        });

        var OrderItemForm = class {
            constructor(options) {
                this.box = options.box;
                this.url = options.url;
                this.getOrderSelectBox = options.getOrderSelectBox;

                this.render();
                this.events();
            };

            events() {
                this.getOrderSelectBox().on('change', (e) => {
                    this.render();
                });

                if (!this.getOrderSelectBox().val()) {
                    this.box.html('');
                    return;
                };
            };

            render() {
                $.ajax({
                    url: this.url,
                    type: 'GET',
                    data: {
                        order_ids: this.getOrderSelectBox().val(),
                        // orders: $('[name="orders"]').val(),
                    },
                }).done((response) => {
                    this.box.html(response);
                    initJs(this.box[0]);
                });
            };
        };
    </script>
@else
    <div class="">
        <div class="form-outline">
            <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                error
            </span>
            <span>Học viên này chưa đăng ký hợp đồng nào!</span>
        </div>
    </div>
@endif

<script></script>
