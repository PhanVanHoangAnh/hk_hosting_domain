@if ($orderItems->count())

    <label for="" class="form-label fw-semibold">Chọn 1 trong các dịch vụ bên dưới để chuyển phí</label>
    <div class="table-responsive">
        <table class="table table-row-bordered table-hover table-bordered">
            <thead>
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                    <th style="width:1%"></th>
                    <th class="text-nowrap text-white">Môn học</th>
                    <th class="text-nowrap text-white">Trình độ</th>
                    <th class="text-nowrap text-white">Loại hình lớp</th>
                    <th class="text-nowrap text-white">Mã hợp đồng</th>
                    <th class="text-nowrap text-white">Chi phí</th>
                    <th class="text-nowrap text-white">Tổng giờ</th>
                    <th class="text-nowrap text-white">Đã học</th>
                    <th class="text-nowrap text-white">Còn lại</th>
                    <th class="text-nowrap text-white">Giáo viên Việt Nam</th>
                    <th class="text-nowrap text-white">Giáo viên Nước ngoài</th>
                    <th class="text-nowrap text-white">Giáo viên Gia sư</th>
                    <th class="text-nowrap text-white">Phí còn lại dự tính</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $orderItem)
                    <tr data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                        data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">
                        <td>
                            <label class="form-check form-check-custom form-check-solid">
                                <input request-control="select-radio" name="order_item_id" value="{{ $orderItem->id }}"
                                    class="form-check-input" type="radio" />
                                <span class="form-check-label">
                                </span>
                            </label>
                        </td>

                        <td>{{ $orderItem->subject->name }}</td>
                        <td>{{ $orderItem->level }}</td>
                        <td>{{ $orderItem->study_type }}</td>
                        
                        <td>{{ $orderItem->orders->code }}</td>
                        <td> {{ App\Helpers\Functions::formatNumber($orderItem->price) }}₫</td>
                        <td>{{ number_format($orderItem->getTotalMinutes() / 60, 2) }} giờ </td>
                        @php
                            $subjectTotalHoursStudied = \App\Models\StudentSection::calculateTotalHoursStudied($studentId, $orderItem->course_id);
                            $subjectTotalHoursRemain = $orderItem->getTotalMinutes() / 60 - $subjectTotalHoursStudied;
                            if($orderItem->getTotalMinutes() != 0){
                                $remainChanger = ($orderItem->orders->price / $orderItem->getTotalMinutes() / 60) * $subjectTotalHoursRemain;
                            } else{
                                $remainChanger = 0;
                            }
                           
                        @endphp
                        <td>{{ $subjectTotalHoursStudied }}</td>
                        <td>{{ $subjectTotalHoursRemain }} giờ</td>
                        @php
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
                        <td>{{ $hourTutal }} giờ {{ $minutisTutal }} phút</td>
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
                        <td>{{ $subjectTotalHoursRemain }}</td>
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
                url: '{{ action('\App\Http\Controllers\Edu\StudentController@transferFormDetail') }}',
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
                var selectedOrderId = this.getOrderCheckBox().filter(':checked').val();
                // var selectedOrderIds = this.getOrderCheckBox()
                //     .filter(':checked') // Lọc ra các checkbox đã chọn
                //     .map(function() {
                //         return $(this).val(); // Lấy giá trị của checkbox đã chọn
                //     }).get();
                $.ajax({
                    url: this.url,
                    type: 'GET',
                    data: {
                        order_item_id: selectedOrderId,
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
                <span>Chưa có lớp học nào phù hợp!</span>
            </span>
        </div>
    </div>
@endif
