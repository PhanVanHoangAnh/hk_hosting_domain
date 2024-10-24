<div class="mb-10">
    @if ($currentCourses->count())
        <div class="form-outline mb-7">
            <div class="d-flex align-items-center">
                <label for="" class="form-label fw-semibold text-info">Chọn lớp bảo lưu</label>
            </div>

            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">

                <table class="table table-row-bordered table-hover table-bordered table-fixed">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th style="width:1%"></th>
                            <th class="text-nowrap text-white">Tên lớp học</th>
                            <th class="text-nowrap text-white">Môn học</th>
                            <th class="text-nowrap text-white">Loại hình</th>
                            <th class="text-nowrap text-white">Trạng thái</th>
                            <th class="text-nowrap text-white">Thời gian bắt đầu</th>
                            <th class="text-nowrap text-white">Thời gian kết thúc</th>
                            <th class="text-nowrap text-white">Chủ nhiệm</th>
                            <th class="text-nowrap text-white">Số lượng học viên tối đa</th>
                            <th class="text-nowrap text-white">Tổng giờ học</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($currentCourses as $currentCourse)
                            <tr data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                                data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">
                                <td>
                                    <div
                                        class="form-check form-check-sm form-check-custom d-flex justify-content-center">
                                        <input request-control="select-radio" name="current_course_id"
                                            list-action="check-item" class="form-check-input" type="radio"
                                            value="{{ $currentCourse->id }}"
                                            {{ $currentCourseStudentId = $currentCourse->id ? 'checked' : '' }} />
                                    </div>
                                </td>

                                <td>{{ $currentCourse->code }}</td>
                                <td>{{ $currentCourse->subject->name }}</td>
                                <td>{{ $currentCourse->study_method }}</td>

                                <td>{{ $currentCourse->checkStatusSubject() }}</td>
                                <td>{{ \Carbon\Carbon::parse($currentCourse->start_at)->format('d/m/Y') }}</td>
                                <td>{{ $currentCourse->getNumberSections() != 0 ? \Carbon\Carbon::parse($currentCourse->end_at)->format('d/m/Y') : '--' }}
                                </td>
                                <td>{{ $currentCourse->teacher->name }}</td>
                                <td>{{ $currentCourse->max_students }}</td>
                                <td>{{ $currentCourse->total_hours }}</td>
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
                <label class="required fs-6 fw-semibold mb-2">Chọn thời điểm bảo lưu</label>
                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                    <input data-control="input" value="" name="reserve_start_at" id="reserve_start_at"
                        placeholder="=asas" type="date" class="form-control">
                    <span data-control="clear" class="material-symbols-rounded clear-button"
                        style="display:none;">close</span>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2">Thời điểm kết thúc bảo lưu</label>
                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                    <input data-control="input" value="" name="reserve_end_at" id="reserve_end_at"
                        placeholder="=asas" type="date" class="form-control" readonly>
                    <span data-control="clear" class="material-symbols-rounded clear-button"
                        style="display:none;">close</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('reserve_start_at').addEventListener('change', function() {
        var startDate = new Date(this.value);
        var endDate = new Date(startDate.getFullYear(), startDate.getMonth() + 3, startDate.getDate());

        var dd = String(endDate.getDate()).padStart(2, '0');
        var mm = String(endDate.getMonth() + 1).padStart(2, '0'); // January is 0!
        var yyyy = endDate.getFullYear();

        var formattedEndDate = yyyy + '-' + mm + '-' + dd;

        document.getElementById('reserve_end_at').value = formattedEndDate;
    });
</script>
