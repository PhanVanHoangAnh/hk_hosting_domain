@if ($courses->count())
    <label for="" class="form-label fw-semibold">Danh sách lớp học phù hợp</label>
    <div class="table-responsive">
        <table class="table table-row-bordered table-hover table-bordered">
            <thead>
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                    <th style="width:1%"></th>
                    <th class="text-nowrap text-white">Tên lớp học</th>
                    <th class="text-nowrap text-white">Trạng thái</th>
                    <th class="text-nowrap text-white">Thời gian bắt đầu</th>
                    <th class="text-nowrap text-white">Thời gian kết thúc</th>
                    <th class="text-nowrap text-white">Chủ nhiệm</th>
                    <th class="text-nowrap text-white">Số lượng học viên</th>
                    <th class="text-nowrap text-white">Tổng giờ học</th>
                </tr>
            </thead>
            <tbody>
                    @foreach ($courses as $course)
                        <tr data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                            data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">
                            <td>
                                <label class="form-check form-check-custom form-check-solid">
                                    <input request-control="select-radio" name="course_id" value="{{ $course->id }}"
                                        class="form-check-input" type="radio" />
                                    <span class="form-check-label">
                                    </span>
                                </label>
                            </td>
                            <td>{{ $course->code }}</td>
                            <td>{{ $course->checkStatusSubject() }}</td>
                            <td>{{ \Carbon\Carbon::parse($course->start_at)->format('d/m/Y') }}</td>
                            <td>{{ $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->end_at)->format('d/m/Y') : '--' }}
                            </td>
                            <td>{{ $course->teacher->name }}</td>
                            <td>{{ $course->countStudentsByCourse() }} / {{ $course->max_students }}</td>
                            <td>{{ $course->total_hours }}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
        
    </div>
    <div class="row">
        <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
            <label class="fs-6 fw-bold fs-4">Chọn thời điểm bắt đầu học</label>
            <input type="date" class="form-control" name="assignment_date">
        </div>
        
    </div>
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
