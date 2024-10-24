@if ($sections->count())

    <label for="" class="form-label fw-semibold">Danh sách buổi học của lớp tương ứng</label>
    <div class="table-responsive overflow-auto section-table">
        <table class="table table-row-bordered table-hover table-bordered table-section">
            <thead class="sticky-top">
                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                    <th style="width:1%"></th>
                    <th class="text-nowrap text-white">Ngày học</th>
                    <th class="text-nowrap text-white">Thời gian học</th>
                    <th class="text-nowrap text-white">Giáo viên Việt Nam</th>
                    <th class="text-nowrap text-white">Giáo viên nước ngoài</th>
                    <th class="text-nowrap text-white">Gia sư</th>
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

                                <input list-action="check-item" name="sectionIds[]" class="form-check-input"
                                    type="checkbox" value="{{ $section->id }}" />
                            </label>
                        </td>
                        <td>{{ date('d/m/Y', strtotime($section->study_date)) }}</td>
                        <td>
                            @php
                                $startAt = Carbon\Carbon::parse($section->start_at);
                                $endAt = Carbon\Carbon::parse($section->end_at);
                                $hoursDifference = $startAt->diffInHours($endAt);
                                $minutesDifference = $startAt->diffInMinutes($endAt) % 60;
                            @endphp

                            {{ $startAt->format('H:i') }} - {{ $endAt->format('H:i') }} <br>
                            ({{ $hoursDifference }} giờ {{ $minutesDifference }} phút)
                        </td>

                        <td>
                            @php
                                $VNTeacherFrom = Carbon\Carbon::parse($section->vn_teacher_from);
                                $VNTeacherTo = Carbon\Carbon::parse($section->vn_teacher_to);
                                $hoursDifferenceVNTeacher = $VNTeacherFrom->diffInHours($VNTeacherTo);
                                $minutesDifferenceVNTeacher = $VNTeacherFrom->diffInMinutes($VNTeacherTo) % 60;
                            @endphp

                            {{ $VNTeacherFrom->format('H:i') }} - {{ $VNTeacherTo->format('H:i') }} <br>
                            ({{ $hoursDifferenceVNTeacher }} giờ {{ $minutesDifferenceVNTeacher }} phút)
                        </td>

                        <td>
                            @php
                                $foreignTeacherFrom = Carbon\Carbon::parse($section->foreign_teacher_from);
                                $foreignTeacherTo = Carbon\Carbon::parse($section->foreign_teacher_to);
                                $hoursDifferenceForeignTeacher = $foreignTeacherFrom->diffInHours($foreignTeacherTo);
                                $minutesDifferenceForeignTeacher = $foreignTeacherFrom->diffInMinutes($foreignTeacherTo) % 60;
                            @endphp

                            {{ $foreignTeacherFrom->format('H:i') }} - {{ $foreignTeacherTo->format('H:i') }} <br>
                            ({{ $hoursDifferenceForeignTeacher }} giờ {{ $minutesDifferenceForeignTeacher }} phút)
                        </td>
                        <td>
                            @php
                                $tutorFrom = Carbon\Carbon::parse($section->tutor_from);
                                $tutorTo = Carbon\Carbon::parse($section->tutor_to);
                                $hoursDifferenceTutor = $tutorFrom->diffInHours($tutorTo);
                                $minutesDifferenceTutor = $tutorFrom->diffInMinutes($tutorTo) % 60;
                            @endphp

                            {{ $tutorFrom->format('H:i') }} - {{ $tutorTo->format('H:i') }} <br>
                            ({{ $hoursDifferenceTutor }}giờ {{ $minutesDifferenceTutor }} phút)
                        </td>
                        <td>
                            @php
                                $bgs = [
                                    App\Models\Section::LEARNING_STATUS => 'secondary',
                                    App\Models\Section::COMPLETED_STATUS => 'success',
                                    App\Models\Section::UNSTUDIED_STATUS => 'warning',
                                ];

                            @endphp
                            <span
                                class="badge bg-{{ $section->status === App\Models\Section::STATUS_DESTROY ? 'danger text-white' : $bgs[$section->checkStatusSectionCalendar()] }}"
                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                data-bs-placement="right">
                                {{ $section->status === App\Models\Section::STATUS_DESTROY ? 'Đã hủy' : $section->checkStatusSectionCalendar() }}
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
                <span>Lớp học chưa có buổi học tương ứng</span>
            </span>
        </div>
    </div>
@endif
