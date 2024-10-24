@if ($orderItems->count())
    <label for="" class="form-label fw-semibold">Danh sách dịch vụ yêu cầu demo chưa xếp lớp</label>
    <div class="table-responsive">
        <table class="table table-row-bordered table-bordered">
            <thead>
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                    <th class="text-nowrap text-white">Xếp lớp</th>
                    <th class="text-nowrap text-white">Số request demo</th>
                    <th class="text-nowrap text-white">Môn học</th>
                    <th class="text-nowrap text-white">Lớp học</th>

                    <th class="text-nowrap text-white">Giá dịch vụ</th>
                    <th class="text-nowrap text-white">Trình độ</th>
                    <th class="text-nowrap text-white">Hình thức học</th>
                    <th class="text-nowrap text-white">Chi nhánh</th>
                    <th class="text-nowrap text-white">Điểm target</th>

                </tr>
            </thead>
            <tbody>
                {{-- <input class="d-none" value="{{ json_encode($orderItems->pluck('id')->toArray()) }}" name="orderItems"> --}}
                @foreach ($orderItems as $orderItem)
                    <tr data-bs-placement="left" data-bs-dismiss="click">
                        <td class="ps-1">
                            <div class="form-check form-check-sm form-check-custom justify-content-center">
                                <input data-item-id="{{ $orderItem->id }}" list-action="check-item" name="order_item_id"
                                    class="form-check-input" type="radio" value="{{ $orderItem->id }}" />
                            </div>
                        </td>

                        <td>{{ $orderItem->orders->code }}</td>
                        <td>{{ $orderItem->subject->name }}</td>
                        <td>{{ $orderItem->courseCount($orderItem->subject->name) }}</td>
                        <td>{{ $orderItem->price }}</td>
                        <td>{{ $orderItem->level }}</td>
                        <td>{{ $orderItem->study_type }}</td>
                        <td>{{ $orderItem->branch }}</td>
                        <td>{{ $orderItem->target }}</td>

                    </tr>
                    {{-- <input type="hidden" name="order_item_id" value="{{ $orderItem->id }}"> --}}
                @endforeach
            </tbody>
        </table>
    </div>
    <div data-control="course-form-request-demo" class="mt-10"></div>
    <script>
        $(() => {


            new CourseFormRequestDemo({
                box: $('[data-control="course-form-request-demo"]'),
                url: '{{ action('\App\Http\Controllers\Edu\StudentController@courseFormRequestDemo') }}',
                getOrderCheckBox: function() {
                    return $('[name="order_item_id"]');
                },
                getStudentId: function() {
                    return assignToClassRequestDemoManager.container.querySelector('[name="studentId"]')
                        .value;
                }
            });
        });



        var CourseFormRequestDemo = class {
            constructor(options) {
                this.box = options.box;
                this.url = options.url;
                this.getOrderCheckBox = options.getOrderCheckBox;
                this.getStudentId = options.getStudentId;
                this.render();
                this.events();
            };

            events() {
                this.getOrderCheckBox().on('change', (e) => {
                    // assignToClassManager.hideErrorMessage();
                    this.render();
                });

                if (!this.getOrderCheckBox().val()) {
                    this.box.html('');
                    return;
                };
            };

            render() {
                var selectedOrderIds = this.getOrderCheckBox()
                    .filter(':checked') // Lọc ra các checkbox đã chọn
                    .map(function() {
                        return $(this).val(); // Lấy giá trị của checkbox đã chọn
                    }).get();
                $.ajax({
                    url: this.url,
                    type: 'GET',
                    data: {
                        order_item_ids: selectedOrderIds,
                        studentId: this.getStudentId,
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
            <p class="mb-0">
                Học viên này chưa có yêu cầu học thử!</strong>.
            </p>
        </div>
    </div>
@endif
