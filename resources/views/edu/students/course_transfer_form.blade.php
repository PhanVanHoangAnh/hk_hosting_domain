<div class="mb-10">
    @if ($courseTransfers->count())
        <div class="form-outline mb-7">
            <div class="d-flex align-items-center">
                <label for="searchClassCode" class="form-label fw-semibold text-info">Lớp có môn tương ứng</label>
            </div>
            <div class="d-flex align-items-center">
                <input type="text" id="searchClassCode" class="form-control " placeholder="Nhập mã lớp muốn chuyển tới">
            </div>
        </div>
        <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
            <table id="specificTable" class="table table-row-bordered table-hover table-bordered table-fixed">
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
                    @foreach ($courseTransfers as $courseTransfer)
                        <tr data-bs-trigger="hover" data-bs-placement="left"
                            data-bs-original-title="Nhấn để chọn lớp học"
                            data-course-id="{{ $courseTransfer->id }}">
                            <td>
                                <div class=" d-flex justify-content-center">
                                    <input request-control="select-radio" name="course_transfer_id"
                                        list-action="check-item" class="form-check-input" type="radio"
                                        value="{{ $courseTransfer->id }}" />
                                </div>
                            </td>
                            <td>{{ $courseTransfer->code }}</td>
                            <td>{{ $courseTransfer->subject->name }}</td>
                            <td>{{ $courseTransfer->study_method }}</td>
                            <td>{{ $courseTransfer->checkStatusSubject() }}</td>
                            <td>{{ \Carbon\Carbon::parse($courseTransfer->start_at)->format('d/m/Y') }}</td>
                            <td>{{ $courseTransfer->getNumberSections() != 0 ? \Carbon\Carbon::parse($courseTransfer->end_at)->format('d/m/Y') : '--' }}
                            </td>
                            <td>{{ $courseTransfer->teacher->name }}</td>
                            <td>{{ $courseTransfer->max_students }}</td>
                            <td>{{ $courseTransfer->total_hours }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="">
            <div class="form-outline">
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                        error
                    </span>
                    <span>Chưa có lớp đang học có môn tương ứng</span>
                </span>
            </div>
        </div>
    @endif
</div>

<script>
    document.getElementById('searchClassCode').addEventListener('input', function() {
        const searchValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('#specificTable tbody tr');

        rows.forEach(row => {
            const classCode = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            if (classCode.includes(searchValue)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>
