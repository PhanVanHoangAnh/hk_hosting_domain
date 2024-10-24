<div class="mb-10">
    @if ($currentCourses->count())
        <div class="form-outline mb-7">
            <div class="d-flex align-items-center">
                <label for="" class="form-label fw-semibold text-info">Học viên sẽ bị xoá ra khỏi lớp</label>
            </div>

            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">

                <table class="table table-row-bordered table-hover table-bordered table-fixed">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">

                            <th class="text-nowrap text-white">Tên lớp học</th>
                            <th class="text-nowrap text-white">Môn học</th>
                            <th class="text-nowrap text-white">Tổng giờ học</th>
                            <th class="text-nowrap text-white">Đã học</th>
                            <th class="text-nowrap text-white">Còn lại</th>

                            <th class="text-nowrap text-white">Loại hình</th>

                            <th class="text-nowrap text-white">Chủ nhiệm</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($currentCourses as $currentCourse)
                            <tr sdata-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                                data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">

                                <input request-control="select-radio" name="current_course_ids[]"
                                    list-action="check-item" class="form-check-input" type="hidden"
                                    value="{{ $currentCourse->id }}" checked />


                                <td>{{ $currentCourse->code }}</td>
                                <td>{{ $currentCourse->subject->name }}</td>
                                <td>
                                    {{-- {{ $currentCourse->total_hours }}  --}}
                                    {{ number_format(\App\Models\StudentSection::calculateTotalHours($studentId, $currentCourse->id), 2) }}
                                    Giờ
                                </td>
                                <td>
                                    {{ \App\Models\StudentSection::calculateTotalHoursStudied($studentId, $currentCourse->id) }}
                                    Giờ
                                </td>
                                @php
                                    $hoursRemain = number_format(\App\Models\StudentSection::calculateTotalHours($studentId, $currentCourse->id) - \App\Models\StudentSection::calculateTotalHoursStudied($studentId, $currentCourse->id), 2);
                                @endphp

                                <td>{{ $hoursRemain }} Giờ</td>
                                <td>{{ $currentCourse->study_method }}</td>
                                <td>{{ $currentCourse->teacher->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    @else
        <div class="">
            <div class="form-outline">
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                        error
                    </span>
                    <span>Chưa có lớp đang học</span>
                </span>
            </div>
        </div>
    @endif
</div>


<div class="mb-10">
    <div class="row">
        <div class="col-6">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2">Bắt đầu bảo lưu từ</label>
                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                    <input data-control="input" value="{{ date('Y-m-d') }}" name="reserve_start_at"
                        id="reserve_start_at" placeholder="=asas" type="date" class="form-control">
                    <span data-control="clear" class="material-symbols-rounded clear-button"
                        style="display:none;">close</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2">Thời điểm kết thúc bảo lưu</label>
                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                    <input data-control="input" value="{{ date('Y-m-d', strtotime('+6 months')) }}"
                        name="reserve_end_at" id="reserve_end_at" placeholder="=asas" type="date"
                        class="form-control">
                    <span data-control="clear" class="material-symbols-rounded clear-button"
                        style="display:none;">close</span>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="col-6"> --}}
    <!--begin::Label-->
    <label class="fs-6 fw-semibold mb-2 mt-4">
        <span class="">Nội dung ghi chú</span>
    </label>
    <!--end::Label-->
    <!--begin::Input-->
    <textarea class="form-control" name="reason" placeholder="Nhập nội dung ghi chú mới!" rows="5" cols="40"></textarea>
    <!--end::Input-->
    <x-input-error :messages="$errors->get('description')" class="mt-2" />

</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var startDateInput = document.getElementById('reserve_start_at');
        var endDateInput = document.getElementById('reserve_end_at');

        // Tính toán thời điểm kết thúc khi trang web được tải
        var startDate = new Date(startDateInput.value);
        var endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 6, startDate.getDate());

        var dd = String(endDate.getDate()).padStart(2, '0');
        var mm = String(endDate.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = endDate.getFullYear();

        var formattedEndDate = yyyy + '-' + mm + '-' + dd;

        endDateInput.value = formattedEndDate;
    });

    // Xử lý sự kiện khi thay đổi thời điểm bắt đầu
    document.getElementById('reserve_start_at').addEventListener('change', function() {
        var startDate = new Date(this.value);
        var endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 6, startDate.getDate());

        var dd = String(endDate.getDate()).padStart(2, '0');
        var mm = String(endDate.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = endDate.getFullYear();

        var formattedEndDate = yyyy + '-' + mm + '-' + dd;

        document.getElementById('reserve_end_at').value = formattedEndDate;
    });
</script>
