@if ($orderItems->count())
    <style>
        .demo-item-row.selected {
            background-color: #f0f0f0;
        }
    </style>

    <label for="" class="form-label fw-semibold">Danh sách dịch vụ của hợp đồng đang chọn Chờ xếp lớp</label>
    <div class="table-responsive">
        <table class="table table-row-bordered table-bordered">
            <thead>
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                    <th class="text-nowrap text-white">Xếp lớp</th>
                    <th class="text-nowrap text-white">Mã hợp đồng</th>
                    <th class="text-nowrap text-white">Môn học</th>
                    <th class="text-nowrap text-white">Lớp học</th>
                    <th class="text-nowrap text-white">Trình độ</th>
                    <th class="text-nowrap text-white">Chủ nhiệm đề xuất</th>
                    <th class="text-nowrap text-white">Hình thức học</th>
                    <th class="text-nowrap text-white">Giờ giáo viên Việt Nam còn lại</th>
                    <th class="text-nowrap text-white">Giờ giáo viên nước ngoài còn lại</th>
                    <th class="text-nowrap text-white">Giờ gia sư còn lại</th>
                    <th class="text-nowrap text-white">Chi nhánh</th>
                    <th class="text-nowrap text-white">Điểm target</th>
                </tr>
            </thead>
            <tbody>
                <input class="d-none" value="{{ $student }}" name="studentId">
                @foreach ($orderItems as $orderItem)
                    <tr data-bs-placement="left" data-bs-dismiss="click" class="demo-item-row">
                        
                        <td class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom justify-content-center">
                                <input value="{{ $orderItem->id }}" data-item-id="{{ $orderItem->id }}" name="order_item_id" list-action="check-item" class="form-check-input" type="checkbox" />
                            </div>
                        </td>
                        <td>{{ $orderItem->orders->code }}</td>
                        <td>{{ $orderItem->subject->name }}</td>
                        @php
                            $classFit = App\Models\Course::getCoursesBySubjects(
                                $orderItem->subject->name,
                                $orderItem->getStudent()->id,
                                $orderItem,
                            )->count();

                        @endphp
                        <td>{{ $classFit }}</td>
                        <td>{{ $orderItem->level }}</td>
                        <td {{ isset($orderItem->homeRoom) ? 'style="font-style: italic"' : '' }}>
                            {{ isset($orderItem->homeRoom) ? $orderItem->homeRoom->name : 'Chưa chọn chủ nhiệm đề xuất' }}
                        </td>
                        <td>{{ $orderItem->study_type }}</td>
                        @php
                            $sumMinutesForeignTeacher =
                                $orderItem->getTotalForeignMinutes() -
                                $orderItem->studyHours($orderItem, $orderItem->orders->contacts)[
                                    'sumMinutesForeignTeacher'
                                ];

                            $hourForeignTeacher = floor($sumMinutesForeignTeacher / 60);
                            $minutisForeignTeacher = $orderItem->getTotalForeignMinutes() % 60;

                            $sumMinutesVNTeacher =
                                $orderItem->getTotalVnMinutes() -
                                $orderItem->studyHours($orderItem, $orderItem->orders->contacts)['sumMinutesVNTeacher'];

                            $hourVNTeacher = floor($sumMinutesVNTeacher / 60);
                            $minutisVNTeacher = $orderItem->getTotalVnMinutes() % 60;

                            $sumMinutesTutal =
                                $orderItem->getTotalTutorMinutes() -
                                $orderItem->studyHours($orderItem, $orderItem->orders->contacts)['sumMinutesTutor'];

                            $hourTutal = floor($sumMinutesTutal / 60);
                            $minutisTutal = $orderItem->getTotalTutorMinutes() % 60;
                        @endphp

                        <td>{{ $hourVNTeacher }} giờ {{ $minutisVNTeacher }} phút</td>
                        <td>{{ $hourForeignTeacher }} giờ {{ $minutisForeignTeacher }} phút</td>
                        <td>{{ $hourTutal }} giờ {{ $minutisTutal }} phút</td>
                        <td>{{ $orderItem->branch }}</td>
                        <td>{{ $orderItem->target }}</td>
                    </tr>
                @endforeach

                <script>
                        $(document).ready(function() {
                            $('.demo-item-row').on('click', function() {
                                var checkbox = $(this).find('.demo-item-checkbox');
            
                                checkbox.prop('checked', !checkbox.prop('checked'));
                                $(this).toggleClass('selected', checkbox.prop('checked'));
                                checkbox.trigger("change");
                            });
                        });
                </script>
            </tbody>
        </table>
    </div>
    <div data-control="course-form" class="mt-10"></div>
    <script>
        $(() => {
            new CourseForm({
                box: $('[data-control="course-form"]'),
                url: '{{ action('\App\Http\Controllers\Edu\StudentController@courseForm') }}',
                getOrderCheckBox: function() {
                    return $('[name="order_item_id"]');
                },
                getStudentId: function() {
                    return $('[name="studentId"]').val();
                }
            });
        });

        var CourseForm = class {
            constructor(options) {
                this.box = options.box;
                this.url = options.url;
                this.getOrderCheckBox = options.getOrderCheckBox;
                this.getStudentId = options.getStudentId;

                // this.render();
                this.events();
            };

            events() {
                this.getOrderCheckBox().on('change', (e) => {
                    assignToClassManager.hideErrorMessage();
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
                Học viên này chưa có dịch vụ đào tạo chưa xếp lớp nào trong hợp đồng này!</strong>.
            </p>
        </div>
    </div>
@endif
