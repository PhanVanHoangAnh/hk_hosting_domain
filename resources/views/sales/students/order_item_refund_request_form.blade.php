@if ($orderItems->count())

    <label for="" class="form-label fw-semibold">Dịch vụ liên quan</label>
    <div class="table-responsive">
        <table class="table table-row-bordered table-hover table-bordered">
            <thead>
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                    <th style="width:1%"></th>
                    <th class="text-nowrap text-white">Dịch vụ</th>
                    <th class="text-nowrap text-white">Trình độ </th>
                    <th class="text-nowrap text-white">Mã hợp đồng</th>
                    <th class="text-nowrap text-white">Chi phí</th>
                    <th class="text-nowrap min-w-100px text-white">Tổng giờ</th>
                    <th class="text-nowrap min-w-100px text-white">Đã học</th>
                    <th class="text-nowrap min-w-100px text-white">Giá trị đã học</th>
                    <th class="text-nowrap min-w-100px text-white">Còn lại</th>
                    <th class="text-nowrap min-w-100px text-white">Giá trị còn lại</th>
                    {{-- <th class="text-nowrap text-white">Giáo viên Việt Nam</th>
                    <th class="text-nowrap text-white">Giáo viên Nước ngoài</th>
                    <th class="text-nowrap text-white">Giáo viên Gia sư</th> --}}
                    <th class="text-nowrap text-white d-none">Phí còn lại dự tính</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $orderItem)
                    <tr data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                        data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">
                        <td>
                            <label class="form-check form-check-custom form-check-solid">
                                <input request-control="select-radio" name="orderItemIds[]" value="{{ $orderItem->id }}"
                                    class="form-check-input" type="checkbox" />
                                <span class="form-check-label">
                                </span>
                            </label>
                        </td>
                        <td>{{ $orderItem->subject->name }}</td>
                        <td>{{ $orderItem->level }}</td>
                        <td>{{ $orderItem->orders->code }}</td>
                        <td> {{ App\Helpers\Functions::formatNumber($orderItem->orders->getTotal()) }}₫</td>
                        <td>{{ number_format($orderItem->getTotalMinutes() / 60, 2) }} giờ </td>

                        <td>
                            @php
                                $groupedCourseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($orderItem->id, $orderItem->orders->contact_id)->groupBy('subject_id');
                            @endphp

                            @php
                                $subjectTotalHoursStudied = 0;
                            @endphp

                            @if ($groupedCourseStudents->count() > 0)
                                @foreach ($groupedCourseStudents as $subjectId => $group)
                                    @php
                                        $subjectTotalHoursStudied += $group->sum(function ($courseStudent) use ($orderItem) {
                                            return \App\Models\StudentSection::calculateTotalHoursStudied($orderItem->orders->contact_id, $courseStudent->course_id);
                                        });
                                    @endphp
                                    {{ $subjectTotalHoursStudied }} giờ
                                @endforeach
                            @else
                                0 giờ
                            @endif
                        </td>
                        <td>
                            {{ App\Helpers\Functions::formatNumber($orderItem->calculateTotalStudiedAmount()) }}₫
                        </td>
                        <td>
                            {{ number_format($orderItem->getTotalMinutes() / 60 - $subjectTotalHoursStudied, 2) }} giờ

                        </td>
                        <td>
                            {{ App\Helpers\Functions::formatNumber($orderItem->orders->getTotal() - $orderItem->calculateTotalStudiedAmount()) }}₫
                        </td>
                        {{-- @php
                            $sumMinutesForeignTeacher = $orderItem->getTotalForeignMinutes() - $orderItem->studyHours($orderItem, $orderItem->orders->contacts)['sumMinutesForeignTeacher'];
                            $hourForeignTeacher = floor($sumMinutesForeignTeacher / 60);
                            $minutisForeignTeacher = $orderItem->getTotalForeignMinutes() % 60;

                            $sumMinutesVNTeacher = $orderItem->getTotalVnMinutes() - $orderItem->studyHours($orderItem, $orderItem->orders->contacts)['sumMinutesVNTeacher'];
                            $hourVNTeacher = floor($sumMinutesVNTeacher / 60);
                            $minutisVNTeacher = $orderItem->getTotalVnMinutes() % 60;

                            $sumMinutesTutal = $orderItem->getTotalTutorMinutes() - $orderItem->studyHours($orderItem, $orderItem->orders->contacts)['sumMinutesTutor'];
                            $hourTutal = floor($sumMinutesTutal / 60);
                            $minutisTutal = $orderItem->getTotalTutorMinutes() % 60;
                        @endphp
                        <td>{{ $hourVNTeacher }} giờ {{ $minutisVNTeacher }} phút</td>
                        <td>{{ $hourForeignTeacher }} giờ {{ $minutisForeignTeacher }} phút</td>
                        <td>{{ $hourTutal }} giờ {{ $minutisTutal }} phút</td> --}}
                        {{-- <td>
                            {{ number_format(\App\Models\StudentSection::calculateTotalHoursOfvnTeacherPresent($studentId, $courseStudent->course_id),2) }}
                            /
                            {{ number_format(\App\Models\StudentSection::calculateTotalHoursOfvnTeacher($studentId, $courseStudent->course_id),2) }}
                            Giờ
                        </td>
                        <td>
                            {{ number_format(\App\Models\StudentSection::calculateTotalHoursOfForeignTeacherPresent($studentId, $courseStudent->course_id),2) }}
                            /
                            {{ number_format(\App\Models\StudentSection::calculateTotalHoursOfForeignTeacher($studentId, $courseStudent->course_id),2) }}
                            Giờ
                        </td>
                        <td>
                            {{ number_format(\App\Models\StudentSection::calculateTotalHoursOfTutorPresent($studentId, $courseStudent->course_id),2) }}
                            /
                            {{ number_format(\App\Models\StudentSection::calculateTotalHoursOfTutor($studentId, $courseStudent->course_id),2) }}
                            Giờ
                        </td> --}}
                        {{-- <td></td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div data-control="course-form" class="mt-10"></div>
    <script>
        $(() => {


            new CourseForm({
                box: $('[data-control="course-form"]'),
                url: '{{ action('\App\Http\Controllers\Sales\StudentController@courseRefundRequestForm') }}',
                getOrderCheckBox: function() {
                    return $('[name="orderItemIds[]"]');
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
                this.render();
                this.events();
            };

            events() {
                this.getOrderCheckBox().on('change', (e) => {
                    transferClassManager.hideErrorMessage();
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
            <span class="d-flex align-items-center">
                <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                    error
                </span>
                <span>Chưa có dịch vụ!</span>
            </span>
        </div>
    </div>
@endif
