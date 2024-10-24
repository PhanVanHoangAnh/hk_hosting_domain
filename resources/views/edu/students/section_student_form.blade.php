@if ($sections->count())

    <label for="" class="form-label fw-semibold">Danh sách buổi học đang học</label>
    <div class="table-responsive">
        <table class="table table-row-bordered table-hover table-bordered">
            <thead>
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                    <th style="width:1%"></th>
                    <th class="text-nowrap text-white">Ngày học</th>
                    <th class="text-nowrap text-white">Thời gian</th>
                    <th class="text-nowrap text-white">Trạng thái</th>
                    <th class="text-nowrap text-white">Chủ nhiệm</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sections as $section)
                    <tr data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                        data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">
                        <td>
                            <label class="form-check form-check-custom form-check-solid">

                                <input list-action="check-item" name="section_student_id" class="form-check-input"
                                    type="radio" value="{{ $section->id }}" />
                            </label>
                        </td>
                        <td>{{ date('d/m/Y', strtotime($section->start_at)) }}</td>
                        <td> {{ $section->start_at ? date('H:i', strtotime($section->start_at)) : '' }} -
                            {{ $section->end_at ? date('H:i', strtotime($section->end_at)) : '' }}</td>
                        <td>
                            @php
                                $bgs = [
                                    App\Models\Section::LEARNING_STATUS => 'secondary',
                                    App\Models\Section::COMPLETED_STATUS => 'success',
                                    App\Models\Section::UNSTUDIED_STATUS => 'warning',
                                ];

                            @endphp
                            <span
                                class="badge bg-{{ $section->status === App\Models\Section::STATUS_DESTROY ? 'danger text-white' : $bgs[$section->checkStatusSection()] }}"
                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                data-bs-placement="right">
                                {{ $section->status === App\Models\Section::STATUS_DESTROY ? 'Đã hủy' : $section->checkStatusSection() }}
                            </span>
                        </td>
                        <td>{{ $section->course->teacher->name }} </td>

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
                <span>Lớp học không còn buổi học</span>
            </span>
        </div>
    </div>
@endif
