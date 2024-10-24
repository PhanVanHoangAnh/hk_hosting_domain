<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($sections->count())
        <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>
                        @if (in_array('course_id', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="course_id"
                                sort-direction="{{ $sortColumn == 'course_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="course_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lớp học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'course_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('import_id', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="import_id"
                                sort-direction="{{ $sortColumn == 'import_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="import_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                       Mã lớp cũ
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'import_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('study_date', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="study_date"
                                sort-direction="{{ $sortColumn == 'study_date' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="study_date">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'study_date' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('start_at', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="start_at"
                                sort-direction="{{ $sortColumn == 'start_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="start_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời gian bắt đầu
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'start_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('end_at', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="end_at"
                                sort-direction="{{ $sortColumn == 'end_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="end_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời gian kết thúc
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'end_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('vietnam_teacher', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="vietnam_teacher"
                                sort-direction="{{ $sortColumn == 'vietnam_teacher' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="vietnam_teacher">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giảng viên việt nam
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'vietnam_teacher' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('foreign_teacher', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="foreign_teacher"
                                sort-direction="{{ $sortColumn == 'foreign_teacher' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="foreign_teacher">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giảng viên nước ngoài
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'foreign_teacher' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('tutor_teacher', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="tutor_teacher"
                                sort-direction="{{ $sortColumn == 'tutor_teacher' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="tutor_teacher">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Gia sư
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'tutor_teacher' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('assistant', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="assistant"
                                sort-direction="{{ $sortColumn == 'assistant' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="assistant">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trợ giảng
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'assistant' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('teacher_id', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="teacher_id"
                                sort-direction="{{ $sortColumn == 'teacher_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="teacher_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giáo viên chủ nhiệm
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'teacher_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        {{-- @if (in_array('section', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="section"
                                sort-direction="{{ $sortColumn == 'section' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="section">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số buổi đã học / Số buổi
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'section' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif --}}

                        @if (in_array('status', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="status"
                                sort-direction="{{ $sortColumn == 'status' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="status">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trạng thái
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'status' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('num_of_students', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="num_of_students"
                                sort-direction="{{ $sortColumn == 'num_of_students' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="num_of_students">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số lượng học viên
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'num_of_students' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('type', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="type"
                                sort-direction="{{ $sortColumn == 'type' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="type">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Phân loại
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'type' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        <th sort-by="status"
                        sort-direction="{{ $sortColumn == 'status' && $sortDirection ? $sortDirection : 'desc' }}"
                        class="min-w-125px text-left" data-column="status">
                        <span class="d-flex align-items-center">
                            <span>
                                Chốt ca
                            </span>

                        </span>
                    </th>
                        <th class="min-w-125px text-left">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($sections as $section)
                        <tr list-control="item">
                            <td class="ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $section->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox" value="{{ $section->id }}" />
                                </div>
                            </td>
                            @if (in_array('course_id', $columns) || in_array('all', $columns))
                                <td data-column="course_id">{{ App\Models\Course::find($section->course->id)->code }}
                                </td>
                            @endif
                            @if (in_array('import_id', $columns) || in_array('all', $columns))
                                <td data-column="import_id">{{ App\Models\Course::find($section->course->id)->import_id }}
                                </td>
                            @endif

                            @if (in_array('study_date', $columns) || in_array('all', $columns))
                                <td data-column="study_date">
                                    {{ \Carbon\Carbon::parse($section->study_date)->format('d/m/Y') }}</td>
                            @endif

                            @if (in_array('start_at', $columns) || in_array('all', $columns))
                                <td data-column="start_at">
                                    {{ \Carbon\Carbon::parse($section->start_at)->format('H:i') }}</td>
                            @endif

                            @if (in_array('end_at', $columns) || in_array('all', $columns))
                                <td data-column="end_at">{{ \Carbon\Carbon::parse($section->end_at)->format('H:i') }}
                                </td>
                            @endif
                            @if (in_array('teacher_id', $columns) || in_array('all', $columns))
                                <td data-column="teacher_id">
                                    {{ $section->course->teacher->name }}
                                </td>
                            @endif
                            @if (in_array('assistant', $columns) || in_array('all', $columns))
                                <td data-column="assistant">
                                    {{ isset($section->assistant) ? $section->assistant->name : '--' }}
                                </td>
                            @endif
                            @if (in_array('vietnam_teacher', $columns) || in_array('all', $columns))
                                <td data-column="vietnam_teacher">
                                    {{ isset($section->vnTeacher) ? $section->vnTeacher->name : '--' }}
                                </td>
                            @endif
                            @if (in_array('foreign_teacher', $columns) || in_array('all', $columns))
                                <td data-column="foreign_teacher">
                                    {{ isset($section->foreignTeacher) ? $section->foreignTeacher->name : '--' }}
                                </td>
                            @endif
                            @if (in_array('tutor_teacher', $columns) || in_array('all', $columns))
                                <td data-column="tutor_teacher">
                                    {{ isset($section->tutor) ? $section->tutor->name : '--' }}
                                </td>
                            @endif

                            @if (in_array('num_of_students', $columns) || in_array('all', $columns))
                                <td data-column="num_of_students">{{ $section->course->max_students }}</td>
                            @endif

                            @if (in_array('status', $columns) || in_array('all', $columns))
                                <td data-column="status">
                                    @php
                                        $bgs = [
                                            App\Models\Section::LEARNING_STATUS => 'secondary',
                                            App\Models\Section::COMPLETED_STATUS => 'success',
                                            App\Models\Section::UNSTUDIED_STATUS => 'warning',
                                            App\Models\Section::COMPLETED_STATUS => 'secondary',
                                            'Đã dừng' => 'secondary',
                                            'Nghỉ có kế hoạch' => 'secondary',
                                            'Nghỉ do giáo viên' => 'secondary',
                                            'Nghỉ do học viên' => 'secondary',
                                        ];
                                        
                                    @endphp
                                    <span class="badge bg-{{  $section->status === App\Models\Section::STATUS_DESTROY ? 'danger text-white' : $bgs[$section->checkStatusSectionCalendar()] }}" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        {{ $section->status === App\Models\Section::STATUS_DESTROY ? 'Đã hủy' : $section->checkStatusSectionCalendar() }}
                                    </span>
                                </td>
                            @endif

                            @if (in_array('type', $columns) || in_array('all', $columns))
                                <td data-column="type">{{ trans('messages.section.' . $section->type) }}</td>
                            @endif

                            <td data-column="status" class="text-left mb-1 text-nowrap" data-filter="mastercard">

                                @php
                                    $bgs = [
                                        'Đã chốt ca' => 'success',
                                        'Sẵn sàng chốt ca' => 'warning',
                                        'Chưa tới giờ chốt ca' => 'secondary',
                                        'Quá hạn chốt ca' => 'secondary',
                                    ];
                                @endphp

                                <span class="badge bg-{{ $bgs[$section->checkStatusShiftClosed()] }}"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right">
                                    {{ $section->checkStatusShiftClosed() }}
                                </span>
                            </td>

                            <td data-column="action">
                                <a href="javascript:;"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3 d-none">
                                        <a class="menu-link px-3" data-action="under-construction">Điểm danh</a>
                                    </div>
                                    @if ($section->status !== App\Models\Section::STATUS_DESTROY)
                                        <div class="menu-item px-3 d-none">
                                            <a row-action="destroy"
                                                href="{{ action(
                                                    [App\Http\Controllers\Teacher\SectionController::class, 'destroy'],
                                                    [
                                                        'id' => $section->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Hủy buổi</a>
                                        </div>
                                    @endif
                                    <div class="menu-item px-3 text-start">
                                        <a  row-action="show"
                                            href="{{ action(
                                                [App\Http\Controllers\Teacher\CourseController::class, 'reschedulePopup'],
                                                [
                                                    'id' => $section->id,
                                                ],
                                            ) }}"
                                            data-ids-update="{{ $section->id }}" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            class="menu-link px-3 {{ $section->checkStatusSectionCalendar() == App\Models\Section::COMPLETED_STATUS ? 'd-none ' : '' }}">Chuyển
                                            buổi</a>
                                    </div>
                                    <div
                                        class="menu-item px-3 {{ $section->checkStatusSectionCalendar() === App\Models\Section::COMPLETED_STATUS ? 'd-none' : '' }}">
                                        <a 
                                            href="{{ action(
                                                [App\Http\Controllers\Teacher\SectionController::class, 'changeTeacherPopup'],
                                                [
                                                    'id' => $section->id,
                                                ],
                                            ) }}"
                                            data-ids-update="{{ $section->id }}" row-action="show"
                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                            class="menu-link px-3 {{ $section->checkStatusSectionCalendar() == App\Models\Section::COMPLETED_STATUS ? 'd-none ' : '' }}">Dạy
                                            thay</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a row-action="shift"
                                            href="{{ action(
                                            [App\Http\Controllers\Teacher\SectionController::class, 'shiftPopup'],
                                                [
                                                    'id' => $section->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Chốt ca</a>
                                    </div>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <div class="mt-5">
            {{ $sections->links() }}
        </div>
    @else
        <div class="py-15">
            <div class="text-center mb-7">
                <svg style="width:120px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.8 173.8">
                    <g style="isolation:isolate">
                        <g id="Layer_2" data-name="Layer 2">
                            <g id="layer1">
                                <path
                                    d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z"
                                    style="fill:#cdcdcd" />
                                <path
                                    d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z"
                                    style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2" />
                                <path d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z"
                                    style="fill:#f5f5f5" />
                                <rect x="31.7" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="73.6" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="115.5" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="31.7" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="73.6" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="115.5" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <path d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                    style="fill:#dbdbdb" />
                                <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                    style="fill:#f5f5f5" />
                                <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z" style="fill:#f5f5f5" />
                                <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z" style="fill:#f5f5f5" />
                                <rect x="32.1" y="29.8" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                <rect x="32.1" y="36.7" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                <rect x="73.3" y="96.7" width="10.1" height="8.42"
                                    transform="translate(-38.3 152.9) rotate(-76.2)" style="fill:#595959" />
                                <path
                                    d="M94.4,35.7a33.2,33.2,0,1,0,24.3,40.1A33.1,33.1,0,0,0,94.4,35.7ZM80.5,92.2a25,25,0,1,1,30.2-18.3A25.1,25.1,0,0,1,80.5,92.2Z"
                                    style="fill:#f8a11f" />
                                <path
                                    d="M57.6,154.1c-.7,2.8,2,5.9,6,6.9h0c4,1,7.9-.5,8.6-3.3l11.4-46.6c.7-2.8-2-5.9-6-6.9h0c-4.1-1-7.9.5-8.6,3.3Z"
                                    style="fill:#253f8e" />
                                <path d="M62.2,61.9A25,25,0,1,1,80.5,92.2,25,25,0,0,1,62.2,61.9Z"
                                    style="fill:#fff;mix-blend-mode:screen;opacity:0.6000000000000001" />
                                <path
                                    d="M107.6,72.9a12.1,12.1,0,0,1-.5,1.8A21.7,21.7,0,0,0,65,64.4a11.6,11.6,0,0,1,.4-1.8,21.7,21.7,0,1,1,42.2,10.3Z"
                                    style="fill:#dbdbdb" />
                                <path
                                    d="M54.3,60A33.1,33.1,0,0,0,74.5,98.8l-1.2,5.3c-2.2.4-3.9,1.7-4.3,3.4L57.6,154.1c-.7,2.8,2,5.9,6,6.9L94.4,35.7A33.1,33.1,0,0,0,54.3,60Z"
                                    style="fill:#dbdbdb;mix-blend-mode:screen;opacity:0.2" />
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <p class="fs-4 text-center mb-5">
                Chưa có buổi học nào!
            </p>
        </div>
    @endif
</div>
<!--end::Card body-->
</div>
<script>
    $(function() {
        SortManager.setSort('{{ $sortColumn }}', '{{ $sortDirection }}');
        HorizonScrollFix.init();
    });

    var HorizonScrollFix = function() {
        var box;
        var setScroll = function(left) {
            window.customersListScrollLeft = left;
        };
        var applyScroll = function() {
            box.scrollLeft(window.customersListScrollLeft);
        };

        return {
            init: function() {
                box = $('.table-responsive');

                applyScroll();

                box.on('scroll', function() {
                    setScroll(box.scrollLeft());
                });
            }
        };
    }();
</script>
