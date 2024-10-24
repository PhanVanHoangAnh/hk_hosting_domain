<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($courses->count())
        <div id="courses-table-box" class="table-responsive scrollable-orders-table freeze-column">
            
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>

                        @if (in_array('class_code', $columns) || in_array('class_code', $columns))
                            <th class="min-w-125px text-left bg-info" data-column="class_code" data-control="freeze-column">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã lớp học
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('class_code_old', $columns) || in_array('class_code_old', $columns))
                            <th class="min-w-125px text-left bg-info" data-column="class_code_old" data-control="freeze-column">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã lớp cũ
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('subject_id', $columns) || in_array('subject_id', $columns))
                            <th list-action="sort" sort-by="subject_id" 
                                sort-direction="{{ $sortColumn == 'subject_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="subject_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên môn học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'subject_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('assistant', $columns) || in_array('assistant', $columns))
                            <th list-action="sort" sort-by="assistant"
                                sort-direction="{{ $sortColumn == 'assistant' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="assistant">
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

                        @if (in_array('start_at', $columns) || in_array('start_at', $columns))
                            <th list-action="sort" sort-by="start_at"
                                sort-direction="{{ $sortColumn == 'start_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="start_at">
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

                        @if (in_array('end_at', $columns) || in_array('end_at', $columns))
                            <th list-action="sort" sort-by="end_at"
                                sort-direction="{{ $sortColumn == 'end_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="end_at">
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
                        @if (in_array('stopped_at', $columns)  || in_array('stopped_at', $columns))
                            <th list-action="sort" sort-by="stopped_at"
                                sort-direction="{{ $sortColumn == 'stopped_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="stopped_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời gian dừng lớp 
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'stopped_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif



                        @if (in_array('teacher_id', $columns) || in_array('teacher_id', $columns))
                            <th list-action="sort" sort-by="teacher_id"
                                sort-direction="{{ $sortColumn == 'teacher_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="teacher_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giáo viên
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
                        @if (in_array('study_method', $columns) || in_array('study_method', $columns))
                            <th list-action="sort" sort-by="study_method"
                                sort-direction="{{ $sortColumn == 'study_method' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="study_method">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Hình thức học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'study_method' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('class_type', $columns) || in_array('class_type', $columns))
                            <th list-action="sort" sort-by="class_type"
                                sort-direction="{{ $sortColumn == 'class_type' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="class_type">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Hình thức học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'class_type' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('level', $columns) || in_array('level', $columns))
                            <th list-action="sort" sort-by="level"
                                sort-direction="{{ $sortColumn == 'level' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="level">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trình độ
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'level' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('training_location_id', $columns) || in_array('training_location_id', $columns))
                            <th list-action="sort" sort-by="training_location_id"
                                sort-direction="{{ $sortColumn == 'training_location_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="training_location_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Chi nhánh
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'training_location_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('min_students', $columns) || in_array('min_students', $columns))
                            <th list-action="sort" sort-by="min_students"
                                sort-direction="{{ $sortColumn == 'min_students' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="min_students">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số lượng học viên tối thiểu
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'min_students' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('number_students', $columns) || in_array('number_students', $columns))
                            <th list-action="sort" sort-by="max_students"
                                sort-direction="{{ $sortColumn == 'max_students' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="number_students">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số lượng học viên
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'max_students' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('suitable_students', $columns) || in_array('suitable_students', $columns))
                            <th list-action="sort" sort-by="max_students"
                                sort-direction="{{ $sortColumn == 'max_students' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="suitable_students">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Học viên phù hợp
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'max_students' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif


                        @if (in_array('location', $columns) || in_array('location', $columns))
                            <th list-action="sort" sort-by="training_locations.name"
                                sort-direction="{{ $sortColumn == 'training_locations.name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="location">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Địa điểm học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'training_locations.name' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('total_hours_vn', $columns) || in_array('total_hours_vn', $columns))
                            <th sort-by="status"
                                sort-direction="{{ $sortColumn == 'total_hours_vn' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="total_hours_vn">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giờ dạy GV Việt Nam
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('total_hours_foreign', $columns) || in_array('total_hours_foreign', $columns))
                            <th sort-by="status"
                                sort-direction="{{ $sortColumn == 'total_hours_foreign' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="total_hours_foreign">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giờ dạy GV Nước Ngoài
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('total_hours_tutor', $columns) || in_array('total_hours_tutor', $columns))
                            <th sort-by="status"
                                sort-direction="{{ $sortColumn == 'total_hours_tutor' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="total_hours_tutor">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giờ dạy Gia sư
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('total_hours_assistant', $columns) || in_array('total_hours_assistant', $columns))
                        <th sort-by="status"
                            sort-direction="{{ $sortColumn == 'total_hours_assistant' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="total_hours_assistant">
                            <span class="d-flex align-items-center">
                                <span>
                                    Giờ dạy Trợ giảng
                                </span>
                            </span>
                        </th>
                    @endif

                        @if (in_array('total_hours', $columns) || in_array('total_hours', $columns))
                            <th sort-by="status"
                                sort-direction="{{ $sortColumn == 'total_hours' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="total_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tổng giờ học
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('test_hours', $columns) || in_array('test_hours', $columns))
                            <th sort-by="status"
                                sort-direction="{{ $sortColumn == 'test_hours' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="test_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tổng kiểm tra
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('studied_hours', $columns) || in_array('studied_hours', $columns))
                            <th sort-by="status"
                                sort-direction="{{ $sortColumn == 'studied_hours' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="studied_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giờ đã học
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('remain_hours', $columns) || in_array('remain_hours', $columns))
                            <th sort-by="status"
                                sort-direction="{{ $sortColumn == 'remain_hours' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="remain_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giờ chưa học
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('status', $columns) || in_array('status', $columns))
                            <th sort-by="status"
                                sort-direction="{{ $sortColumn == 'status' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="status">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trạng thái
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('created_at', $columns) || in_array('created_at', $columns))
                            <th list-action="sort" sort-by="created_at"
                                sort-direction="{{ $sortColumn == 'created_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="created_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày tạo khóa học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'created_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('updated_at', $columns) || in_array('updated_at', $columns))
                            <th list-action="sort" sort-by="updated_at"
                                sort-direction="{{ $sortColumn == 'updated_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="updated_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày cập nhật khóa học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'updated_at' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        <th class="min-w-125px text-left">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($courses as $course)
                        <tr list-control="item">
                            <td class="text-left ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $course->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            @if (in_array('class_code', $columns) || in_array('all', $columns))
                                <td data-column="class_code" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard" data-control="freeze-column">
                                    {{ $course->code }}
                                </td>
                            @endif
                            @if (in_array('class_code_old', $columns) || in_array('all', $columns))
                                <td data-column="class_code_old" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard" data-control="freeze-column">
                                    {{ $course->import_id }}
                                </td>
                            @endif
                            
                            @if (in_array('subject_id', $columns) || in_array('all', $columns))
                                <td data-column="subject_id" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $course->subject->name }}
                                </td>
                            @endif

                            @if (in_array('assistant', $columns) || in_array('all', $columns))
                                <td data-column="assistant" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    @foreach ($course->getAssistants() as $assistant)
                                        {{ isset($assistant->name) ? '- ' . $assistant->name : '' }}
                                        <br>
                                    @endforeach
                                </td>
                            @endif

                            @if (in_array('start_at', $columns) || in_array('all', $columns))
                                <td data-column="start_at" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ \Carbon\Carbon::parse($course->start_at)->format('d/m/Y') }}
                                </td>
                            @endif

                            @if (in_array('end_at', $columns) || in_array('all', $columns))
                                <td data-column="end_at" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->end_at)->format('d/m/Y') : '--' }}
                                </td>
                            @endif
                            @if (in_array('stopped_at', $columns)  || in_array('all', $columns))
                                <td data-column="stopped_at" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->stop_at)->format('d/m/Y') : '--' }}
                                </td>
                            @endif
                            @if (in_array('total_hours_vn', $columns) || in_array('all', $columns))
                                <td data-column="total_hours_vn" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ number_format($course->getTotalMinutesOfTeacher('VNTeacher') / 60, 2) }} giờ
                                </td>
                            @endif 
                            @if (in_array('total_hours_foreign', $columns) || in_array('all', $columns))
                                <td data-column="total_hours_foreign" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ number_format($course->getTotalMinutesOfTeacher('ForeignTeacher') / 60, 2) }} giờ
                                </td>
                            @endif 
                            @if (in_array('total_hours_tutor', $columns) || in_array('all', $columns))
                                <td data-column="total_hours_tutor" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ number_format($course->getTotalMinutesOfTeacher('Tutor') / 60, 2) }} giờ
                                </td>
                            @endif
                            @if (in_array('total_hours_assistant', $columns) || in_array('all', $columns))
                                <td data-column="total_hours_assistant" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ number_format($course->getTotalMinutesOfTeacher('Assistant') / 60, 2) }} giờ
                                </td>
                            @endif
                            

                            @if (in_array('total_hours', $columns) || in_array('all', $columns))
                                <td data-column="total_hours" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $course->total_hours }} giờ
                                </td>
                            @endif
                                
                            @if (in_array('test_hours', $columns) || in_array('all', $columns))
                                <td data-column="test_hours" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $course->test_hours }} giờ
                                </td>
                            @endif

                            @if (in_array('studied_hours', $columns) || in_array('all', $columns))
                                <td data-column="studied_hours" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">

                                    {{ number_format($course->getStudiedHoursForCourse() , 2) }} giờ
                                </td>
                            @endif

                            @if (in_array('remain_hours', $columns) || in_array('all', $columns))
                                <td data-column="remain_hours" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ number_format($course->getTotalStudyHoursForCourse() - $course->getStudiedHoursForCourse() , 2) }} giờ
                                </td>
                            @endif

                            @if (in_array('teacher_id', $columns) || in_array('all', $columns))
                                <td data-column="teacher_id" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ isset($course->teacher_id) ? App\Models\Teacher::find($course->teacher_id)->name : '' }}
                                </td>
                            @endif

                            @if (in_array('status', $columns) || in_array('all', $columns))
                                <td data-column="status" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    @php
                                        $bgs = [
                                            App\Models\Course::OPENING_STATUS => 'secondary',
                                            App\Models\Course::COMPLETED_STATUS => 'success',
                                            App\Models\Course::WAITING_OPEN_STATUS => 'warning',
                                        ];
                                    @endphp
                                    <span
                                        class="badge bg-{{ $bgs[$course->checkStatusSubject()] ?? 'info text-white' }}"
                                        data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                        data-bs-placement="right">
                                        {{ $course->checkStatusSubject() }}
                                    </span>
                                </td>
                            @endif
                            @if (in_array('study_method', $columns) || in_array('all', $columns))
                                <td data-column="study_method" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ isset($course->study_method) ? $course->study_method : '' }}
                                </td>
                            @endif
                            @if (in_array('class_type', $columns) || in_array('all', $columns))
                                <td data-column="class_type" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ isset($course->class_type) ? trans('messages.courses.class_type.' . $course->class_type) : '' }}
                                </td>
                            @endif
                            @if (in_array('level', $columns) || in_array('all', $columns))
                                <td data-column="level" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ isset($course->level) ? $course->level : '' }}
                                </td>
                            @endif
                            @if (in_array('training_location_id', $columns) || in_array('all', $columns))
                                <td data-column="training_location_id" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ isset($course->training_location_id) ? trans('messages.training_locations.' . \App\Models\TrainingLocation::find($course->training_location_id)->branch) : "" }}
                                </td>
                            @endif
                            @if (in_array('min_students', $columns) || in_array('all', $columns))
                                <td data-column="min_students" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ isset($course->min_students) ? $course->min_students : '' }}
                                </td>
                            @endif
                            @if (in_array('number_students', $columns) || in_array('all', $columns))
                                <td data-column="number_students" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $course->countStudentsByCourse() }}&nbsp; /
                                    {{ $course->max_students }}
                                </td>
                            @endif
                            @if (in_array('suitable_students', $columns) || in_array('all', $columns))
                                @php

                                    $orderItems = App\Models\OrderItem::getOrderItemByCourse($course);
                                    $classFit = count($orderItems);

                                @endphp
                                <td data-column="suitable_students" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ isset($classFit) ? $classFit : '' }}
                                </td>
                            @endif

                            @if (in_array('location', $columns) || in_array('all', $columns))
                                <td data-column="location" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{-- {{ isset($course->location) ? $course->location : '' }} --}}
                                    {{ isset($course->training_location_id) ? \App\Models\TrainingLocation::find($course->training_location_id)->name : "" }}
                                </td>
                            @endif

                            @if (in_array('created_at', $columns) || in_array('all', $columns))
                                <td data-column="created_at" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ \Carbon\Carbon::parse($course->created_at)->format('d/m/Y') }}
                                </td>
                            @endif

                            @if (in_array('updated_at', $columns) || in_array('all', $columns))
                                <td data-column="updated_at" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ \Carbon\Carbon::parse($course->updated_at)->format('d/m/Y') }}
                                </td>
                            @endif

                            <td class="text-left">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                    style="margin-left: 0px">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    @if (!$course->hasFinished())
                                        <div class="menu-item px-3">
                                            <a href="{{ action(
                                                [App\Http\Controllers\Edu\CourseController::class, 'showDetail'],
                                                    [
                                                        'id' => $course->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">
                                                Xem
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a data-course-id="{{ $course->id }}" href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'add'], ['courseCopyId' => $course->id]) }}"
                                                row-action="copy" class="menu-link px-3">Sao chép</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a data-ids-update="{{ $course->id }}"
                                                {{-- @if ($course->hasFinished()) data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true" title="Lớp học này đã hoàn thành, không thể chỉnh sửa!"
                                                @else  --}}
                                                href="{{ action(
                                                    [App\Http\Controllers\Edu\CourseController::class, 'editCalendar'],
                                                    [
                                                        'id' => $course->id,
                                                    ],
                                                ) }}" 
                                                {{-- @endif --}}
                                                row-action="edit"
                                                class="menu-link px-3 {{ $course->hasFinished() ? 'disabled="disabled"' : '' }}">Thay đổi thời khóa biểu</a>
                                        </div>
                                        <div
                                            class="menu-item px-3 {{ $course->checkStatusSubject() === App\Models\Course::WAITING_OPEN_STATUS ? 'd-none' : '' }}">
                                            <a data-ids-update="{{ $course->id }}"
                                                href="{{ action(
                                                    [App\Http\Controllers\Edu\SectionReportsController::class, 'reportSection'],
                                                    [
                                                        'id' => $course->id,
                                                    ],
                                                ) }}"
                                                row-action="show" class="menu-link px-3">Báo cáo học tập</a>
                                        </div>
                                        <div class="menu-item px-3 ">
                                            <a data-ids-update="{{ $course->id }}"
                                                href="{{ action(
                                                    [App\Http\Controllers\Edu\CourseController::class, 'courseStopped'],
                                                    [
                                                        'id' => $course->id,
                                                    ],
                                                ) }}"
                                                row-action="stopped-class" class="menu-link px-3">Dừng lớp</a>
                                        </div>
                                        <div class="menu-item px-3 ">
                                            <a data-ids-update="{{ $course->id }}"
                                                href="{{ action(
                                                    [App\Http\Controllers\Edu\CourseController::class, 'assignStudentToClass'],
                                                    [
                                                        'id' => $course->id,
                                                    ],
                                                ) }}"
                                                row-action="assign-to-class" class="menu-link px-3">Xếp lớp</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a data-ids-delete="{{ $course->id }}"
                                                href="{{ action(
                                                    [App\Http\Controllers\Edu\CourseController::class, 'delete'],
                                                    [
                                                        'id' => $course->id,
                                                    ],
                                                ) }}"
                                                row-action="delete" class="menu-link px-3">Xóa</a>
                                        </div>
                                    @else
                                        <div class="menu-item px-3">
                                            <a href="{{ action(
                                                [App\Http\Controllers\Edu\CourseController::class, 'showDetail'],
                                                    [
                                                        'id' => $course->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">
                                                Xem
                                            </a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a data-ids-update="{{ $course->id }}"
                                                {{-- @if ($course->hasFinished()) data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true" title="Lớp học này đã hoàn thành, không thể chỉnh sửa!"
                                                @else  --}}
                                                href="{{ action(
                                                    [App\Http\Controllers\Edu\CourseController::class, 'editCalendar'],
                                                    [
                                                        'id' => $course->id,
                                                    ],
                                                ) }}" 
                                                {{-- @endif --}}
                                                row-action="edit"
                                                class="menu-link px-3 ">Thay đổi thời khóa biểu</a>
                                        </div>
                                    @endif
                                </div>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <div class="mt-5">
            {{ $courses->links() }}
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
                Chưa có khóa học nào!
            </p>
            <p class="text-center">
                <a list-action="create-constract"
                    href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'add']) }}"
                    id="buttonCreateNewCourse" class="btn btn-outline btn-outline-default">
                    <span class="material-symbols-rounded me-2">
                        add
                    </span>
                    Thêm mới khóa học
                </a>
            </p>
        </div>
    @endif
    <script>
        $(() => {
            HorizonScrollFix.init();
        });

        var HorizonScrollFix = function() {
            let coursesBox = $('#courses-table-box');

            let setScroll = distanceFromLeft => {
                window.ordersListScrollFromLeft = distanceFromLeft;
            };

            let applyScroll = () => {
                coursesBox.scrollLeft(window.ordersListScrollFromLeft);
            }

            return {
                init: function() {

                    applyScroll();

                    coursesBox.on('scroll', () => {
                        setScroll(coursesBox.scrollLeft());
                    });
                }
            }
        }();
    </script>
</div>
