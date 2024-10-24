<div class="mb-10">
    @if ($course)
        <div class="form-outline mb-7">
            <div class="d-flex align-items-center">
                <label for="" class="form-label fw-semibold text-info">Lớp đang học</label>
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
                        <tr data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                            data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học">
                            <td>
                                <div class="d-flex justify-content-center">
                                    <input request-control="select-radio" name="course_id" list-action="check-item"
                                        class="form-check-input" type="radio" value="{{ $course->id }}" checked />
                                </div>
                            </td>

                            <td>{{ $course->code }}</td>
                            <td>{{ $course->subject->name }}</td>
                            <td>{{ $course->study_method }}</td>

                            <td>{{ $course->checkStatusSubject() }}</td>
                            <td>{{ \Carbon\Carbon::parse($course->start_at)->format('d/m/Y') }}</td>
                            <td>{{ $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->getEndAt())->format('d/m/Y') : '--' }}
                            </td>
                            <td>{{ $course->teacher->name }}</td>
                            <td>{{ $course->max_students }}</td>
                            <td>{{ $course->total_hours }}</td>
                        </tr>

                    </tbody>
                </table>

            </div>
        </div>
        <div class="mb-10">
            <div class="row">
                <div class="col-6">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2">Chọn thời điểm dừng lớp</label>
                        <div data-control="date-with-clear-button"
                            class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" value="" name="stopped_at" placeholder="=asas"
                                type="date" class="form-control">
                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                style="display:none;">close</span>
                        </div>
                    </div>
                </div>

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
