<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($classes->count())
        <div id="staffs-table-box" class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>

                        @if (in_array('order_type', $columns) || in_array('order_type', $columns))
                            <th list-action="sort" sort-by="order_type"
                                sort-direction="{{ $sortColumn == 'order_type' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left d-none" data-column="order_type">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Phân loại
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'order_type' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('order_date', $columns) || in_array('order_date', $columns))
                            <th list-action="sort" sort-by="order_date"
                                sort-direction="{{ $sortColumn == 'order_date' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left " data-column="order_date">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày hợp đồng
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'order_date' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('created_at', $columns) || in_array('created_at', $columns))
                            <th list-action="sort" sort-by="created_at"
                                sort-direction="{{ $sortColumn == 'created_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left " data-column="created_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày tạo
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

                        @if (in_array('parent_note', $columns) || in_array('parent_note', $columns))
                            <th class="min-w-400px text-left " data-column="parent_note">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ghi chú
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('code', $columns) || in_array('code', $columns))
                            <th list-action="sort" sort-by="code"
                                sort-direction="{{ $sortColumn == 'code' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="code">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã hợp đồng
                                        <span>
                                            <span>
                                                <span
                                                    class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'code' ? '' : 'text-muted' }}">
                                                    sort
                                                </span>
                                            </span>
                                        </span>
                                    </span>
                            </th>
                        @endif
                        @if (in_array('import_id', $columns) || in_array('import_id', $columns))
                            <th list-action="sort" sort-by="orders.import_id"
                                sort-direction="{{ $sortColumn == 'orders.import_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="import_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã hợp đồng cũ
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'orders.import_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('code_student', $columns) || in_array('code_student', $columns))
                            <th list-action="sort" sort-by="orders.code"
                                sort-direction="{{ $sortColumn == 'orders.code' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="code_student">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã học viên
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'orders.code' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('student_code_old', $columns) || in_array('student_code_old', $columns))
                            <th list-action="sort" sort-by="orders.code"
                                sort-direction="{{ $sortColumn == 'orders.code' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="student_code_old">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã cũ học viên
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'orders.code' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('name', $columns) || in_array('name', $columns))
                            <th list-action="sort" sort-by="name"
                                sort-direction="{{ $sortColumn == 'name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left bg-info" data-column="name" data-control="freeze-column">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên học viên
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'name' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('email', $columns) || in_array('email', $columns))
                            <th list-action="sort" sort-by="email"
                                sort-direction="{{ $sortColumn == 'email' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="email">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Email
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'email' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('phone', $columns) || in_array('phone', $columns))
                            <th list-action="sort" sort-by="phone"
                                sort-direction="{{ $sortColumn == 'phone' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="phone">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số điện thoại
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'phone' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('subject_name', $columns) || in_array('subject_name', $columns))
                            <th list-action="sort" sort-by="code"
                                sort-direction="{{ $sortColumn == 'code' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="subject_name">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Môn học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'code' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('train_style', $columns) || in_array('train_style', $columns))
                            <th class="min-w-125px text-left" data-column="train_style">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Hình thức học
                                    </span>
                                    <span>

                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('status', $columns) || in_array('status', $columns))
                            <th class="min-w-125px text-left" data-column="status">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tình trạng
                                    </span>
                                    <span>

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
                        @if (in_array('class_code', $columns) || in_array('class_code', $columns))
                            <th class="min-w-125px text-left" data-column="class_code">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lớp phù hợp
                                    </span>

                                </span>
                            </th>
                        @endif
                        @if (in_array('class_code', $columns) || in_array('class_code', $columns))
                            <th class="min-w-125px text-left" data-column="class_code">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã lớp học
                                    </span>

                                </span>
                            </th>
                        @endif
                        @if (in_array('import_contact_id', $columns) || in_array('import_contact_id', $columns))
                            <th class="min-w-125px text-left" data-column="import_contact_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã lớp học cũ
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
                                        Loại hình lớp
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
                        @if (in_array('home_room', $columns) || in_array('home_room', $columns))
                            <th list-action="sort" sort-by="home_room"
                                sort-direction="{{ $sortColumn == 'home_room' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="home_room">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Chủ nhiệm
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'home_room' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('num_of_student', $columns) || in_array('num_of_student', $columns))
                            <th list-action="sort" sort-by="num_of_student"
                                sort-direction="{{ $sortColumn == 'num_of_student' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="num_of_student">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số lượng học viên
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'num_of_student' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('study_type', $columns) || in_array('study_type', $columns))
                            <th list-action="sort" sort-by="study_type"
                                sort-direction="{{ $sortColumn == 'study_type' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="study_type">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Hình thức học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'study_type' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('branch', $columns) || in_array('branch', $columns))
                            <th list-action="sort" sort-by="branch"
                                sort-direction="{{ $sortColumn == 'branch' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="branch">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Chi nhánh
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'branch' ? '' : 'text-muted' }}">
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
                                        Địa điểm
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
                        @if (in_array('vietnam_teacher', $columns) || in_array('vietnam_teacher', $columns))
                            <th class="min-w-125px text-left" data-column="vietnam_teacher">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giáo viên Việt Nam
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('foreign_teacher', $columns) || in_array('foreign_teacher', $columns))
                            <th class="min-w-125px text-left" data-column="foreign_teacher">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giáo viên nước ngoài
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('tutor_teacher', $columns) || in_array('tutor_teacher', $columns))
                            <th class="min-w-125px text-left" data-column="tutor_teacher">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Gia sư
                                    </span>
                                </span>
                            </th>
                        @endif
                        {{-- @if (in_array('vietnam_teacher_minutes_per_section', $columns) || in_array('vietnam_teacher_minutes_per_section', $columns))
                            <th list-action="sort" sort-by="vietnam_teacher_minutes_per_section"
                                sort-direction="{{ $sortColumn == 'vietnam_teacher_minutes_per_section' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="vietnam_teacher_minutes_per_section">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giờ dạy giáo viên Việt Nam trên 1 buổi học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'vietnam_teacher_minutes_per_section' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('foreign_teacher_minutes_per_section', $columns) || in_array('foreign_teacher_minutes_per_section', $columns))
                            <th list-action="sort" sort-by="foreign_teacher_minutes_per_section"
                                sort-direction="{{ $sortColumn == 'foreign_teacher_minutes_per_section' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="foreign_teacher_minutes_per_section">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giờ dạy giáo viên nước ngoài trên 1 buổi học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'foreign_teacher_minutes_per_section' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('tutor_minutes_per_section', $columns) || in_array('tutor_minutes_per_section', $columns))
                            <th list-action="sort" sort-by="tutor_minutes_per_section"
                                sort-direction="{{ $sortColumn == 'tutor_minutes_per_section' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="tutor_minutes_per_section">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giờ dạy gia sư trên 1 buổi học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'tutor_minutes_per_section' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('target', $columns) || in_array('target', $columns))
                            <th list-action="sort" sort-by="target"
                                sort-direction="{{ $sortColumn == 'target' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="target">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Target
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'target' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif --}}
                        @if (in_array('duration', $columns) || in_array('duration', $columns))
                            <th class="min-w-125px text-left" data-column="duration">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời lượng buổi học
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('train_hours', $columns) || in_array('train_hours', $columns))
                            <th class="min-w-125px text-left" data-column="train_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số giờ đào tạo
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('father_email', $columns) || in_array('father_email', $columns))
                            <th  class="min-w-125px text-left" data-column="father_email">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Email bố
                                    </span>
                                   
                                </span>
                            </th>
                        @endif
                        @if (in_array('father_phone', $columns) || in_array('father_phone', $columns))
                            <th  class="min-w-125px text-left" data-column="father_phone">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số điện thoại bố
                                    </span>
                                   
                                </span>
                            </th>
                        @endif
                        @if (in_array('mother_email', $columns) || in_array('mother_email', $columns))
                            <th  class="min-w-125px text-left" data-column="mother_email">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Email mẹ
                                    </span>
                                
                                </span>
                            </th>
                        @endif
                        @if (in_array('mother_phone', $columns) || in_array('mother_phone', $columns))
                            <th  class="min-w-125px text-left" data-column="mother_phone">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số điện thoại mẹ
                                    </span>
                                   
                                </span>
                            </th>
                        @endif
                      
                        
                        <th class="min-w-125px text-left">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach ($classes as $class)
                        <tr list-control="item">
                            <td class="text-left ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $class->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            @if (in_array('code', $columns) || in_array('all', $columns))
                                <td data-column="code" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->getOrderStudent() ? $class->getOrderStudent()->code : '' }}
                                </td>
                            @endif
                            @if (in_array('import_id', $columns) || in_array('all', $columns))
                                <td data-column="import_id" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{$class->getOrderStudent() ? $class->getOrderStudent()->import_id : '' }}
                                </td>
                            @endif
                            @if (in_array('order_date', $columns) || in_array('all', $columns))
                                <td data-column="order_date" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ \Carbon\Carbon::parse($class->order->order_date)->format('d/m/Y') }}
                                </td>
                            @endif
                            @if (in_array('created_at', $columns) || in_array('all', $columns))
                                <td data-column="created_at" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->created_at->format('d/m/Y') }}
                                </td>
                            @endif
                            @if (in_array('parent_note', $columns) || in_array('all', $columns))
                                <td data-column="parent_note" class="text-left mb-1"
                                    data-filter="mastercard">
                                    {{ $class->order->parent_note }}
                                </td>
                            @endif
                            @if (in_array('code_student', $columns) || in_array('all', $columns))
                                <td data-column="code_student" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->getStudent() ? $class->getStudent()->code : '' }}
                                </td>
                            @endif
                            @if (in_array('student_code_old', $columns) || in_array('all', $columns))
                                <td data-column="student_code_old" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->getStudent() ? $class->getStudent()->import_id : '' }}
                                </td>
                            @endif
                            @if (in_array('name', $columns) || in_array('all', $columns))
                                <td data-column="name" class="text-left mb-1 text-nowrap" data-filter="mastercard" data-control="freeze-column">
                                    {{ $class->getStudent() ? $class->getStudent()->name : '' }}
                                </td>
                            @endif
                            @if (in_array('email', $columns) || in_array('all', $columns))
                                <td data-column="email" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->getStudent() ? $class->getStudent()->email : '' }}

                                </td>
                            @endif
                            @if (in_array('phone', $columns) || in_array('all', $columns))
                                <td data-column="phone" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->getStudent() ? $class->getOrderStudent()->phone : '' }}

                                </td>
                            @endif


                            @if (in_array('order_type', $columns) || in_array('all', $columns))
                                <td data-column="order_type" class="text-left mb-1 text-nowrap d-none"
                                    data-filter="mastercard">
                                    {{ $class->order_type }}

                                </td>
                            @endif
                            @if (in_array('subject_name', $columns) || in_array('all', $columns))
                                <td data-column="subject_name" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->subject->name ?? 'N/A' }}

                                </td>
                            @endif

                            @if (in_array('train_style', $columns) || in_array('all', $columns))
                                <td data-column="train_style" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->study_type }}
                                </td>
                            @endif





                            @if (in_array('status', $columns) || in_array('all', $columns))
                                {{-- <td data-column="status" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->getStatus() }}
                                </td> --}}
                                <td data-column="status" class="text-left" data-filter="mastercard">
                                    @php

                                        $status = $class->getStatus();
                                        $classForStatus = $status === 'Đã xếp lớp' ? 'success' : 'warning'; // Kiểm tra và áp dụng class màu đỏ
                                    @endphp
                                    <span class="badge bg-{{ $classForStatus }}" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        {{ $class->getStatus() }}
                                    </span>

                                </td>
                            @endif
                            @if (in_array('level', $columns) || in_array('all', $columns))
                                <td data-column="level" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->level }}
                                </td>
                            @endif
                            @if (in_array('class_type', $columns) || in_array('all', $columns))
                                <td data-column="class_type" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ isset($class->class_type) ? trans('messages.courses.class_type.' . $class->class_type) : '' }}
                                </td>
                            @endif
                            @if (in_array('class_code', $columns) || in_array('all', $columns))
                                @php

                                    $classFitDemo = App\Models\Course::getCoursesBySubjectsDemo(
                                        $class->subject->name,
                                        $class->getStudent()->id,
                                        $class,
                                    )->count();

                                @endphp
                                 @php
                                    $classFit = App\Models\Course::getCoursesBySubjects(
                                        $class->subject->name,
                                        $class->getStudent()->id,
                                        $class,
                                    )->count();

                                @endphp
                                <td data-column="class_code" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $classFit }}
                                </td>
                            @endif
                            @if (in_array('class_code', $columns) || in_array('all', $columns))
                                <td data-column="class_code" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    @php
                                        $courseList = $class->courseList();
                                    @endphp

                                    @if ($courseList->isNotEmpty())
                                        @foreach ($courseList as $course)
                                            {{ $course->code }} <br>
                                        @endforeach
                                    @else
                                        --
                                    @endif
                                </td>
                            @endif
                            @if (in_array('import_contact_id', $columns) || in_array('all', $columns))
                                <td data-column="import_contact_id" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    @php
                                        $courseList = $class->courseList();
                                    @endphp

                                    @if ($courseList->isNotEmpty())
                                        @foreach ($courseList as $course)
                                            {{ $course->import_id }} <br>
                                        @endforeach
                                    @else
                                        --
                                    @endif
                                </td>
                            @endif

                            @if (in_array('home_room', $columns) || in_array('all', $columns))
                                <td data-column="home_room" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->home_room }}
                                </td>
                            @endif
                            @if (in_array('num_of_student', $columns) || in_array('all', $columns))
                                <td data-column="num_of_student" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->num_of_student }}
                                </td>
                            @endif
                            @if (in_array('study_type', $columns) || in_array('all', $columns))
                                <td data-column="study_type" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->study_type }}
                                </td>
                            @endif
                            @if (in_array('branch', $columns) || in_array('all', $columns))
                                <td data-column="branch" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->training_location && $class->training_location->branch ? trans('messages.training_location.' . $class->training_location->branch) : '' }}
                                </td>
                            @endif
                            @if (in_array('training_location_id', $columns) || in_array('all', $columns))
                                <td data-column="training_location_id" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->training_location && $class->training_location->name ? $class->training_location->name : '' }}
                                </td>
                            @endif

                            @php
                                $sumMinutesForeignTeacher = $class->getTotalForeignMinutes();

                                $hourForeignTeacher = floor($sumMinutesForeignTeacher / 60);
                                $minutisForeignTeacher = $class->getTotalForeignMinutes() % 60;

                                $sumMinutesVNTeacher = $class->getTotalVnMinutes();

                                $hourVNTeacher = floor($sumMinutesVNTeacher / 60);
                                $minutisVNTeacher = $class->getTotalVnMinutes() % 60;

                                $sumMinutesTutal = $class->getTotalTutorMinutes();
                                $hourTutal = floor($sumMinutesTutal / 60);
                                $minutisTutal = $class->getTotalTutorMinutes() % 60;
                            @endphp
                            @if (in_array('vietnam_teacher', $columns) || in_array('all', $columns))
                                <td data-column="vietnam_teacher" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $hourVNTeacher }} giờ {{ $minutisVNTeacher }} phút
                                </td>
                            @endif
                            @if (in_array('foreign_teacher', $columns) || in_array('all', $columns))
                                <td data-column="foreign_teacher" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $hourForeignTeacher }} giờ {{ $minutisForeignTeacher }} phút
                                </td>
                            @endif
                            @if (in_array('tutor_teacher', $columns) || in_array('all', $columns))
                                <td data-column="tutor_teacher" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $hourTutal }} giờ {{ $minutisTutal }} phút
                                </td>
                            @endif
                            {{-- @if (in_array('vietnam_teacher_minutes_per_section', $columns) || in_array('all', $columns))
                                <td data-column="vietnam_teacher_minutes_per_section" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->vietnam_teacher_minutes_per_section }}Giờ/Buổi
                                </td>
                            @endif
                            @if (in_array('foreign_teacher_minutes_per_section', $columns) || in_array('all', $columns))
                                <td data-column="foreign_teacher_minutes_per_section" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->foreign_teacher_minutes_per_section }}Giờ/Buổi
                                </td>
                            @endif
                            @if (in_array('tutor_minutes_per_section', $columns) || in_array('all', $columns))
                                <td data-column="tutor_minutes_per_section" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->tutor_minutes_per_section }}Giờ/Buổi
                                </td>
                            @endif
                            @if (in_array('target', $columns) || in_array('all', $columns))
                                <td data-column="target" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $class->target }}
                                </td>
                            @endif --}}

                            @if (in_array('duration', $columns) || in_array('all', $columns))
                                <td data-column="duration" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->duration }} {{ $class->unit }}
                                </td>
                            @endif
                            @if (in_array('train_hours', $columns) || in_array('all', $columns))
                                <td data-column="train_hours" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->train_hours }}
                                </td>
                            @endif
                            @if (in_array('father_email', $columns) || in_array('all', $columns))
                                <td data-column="father_email" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                  
                                    {{ $class->getStudent() ? ($class->getStudent()->getFather()? $class->getStudent()->getFather()->email : '') : '' }}
                                   
                                </td>
                            @endif
                            @if (in_array('father_phone', $columns) || in_array('all', $columns))
                                <td data-column="father_phone" class="text-left mb-1 text-nowrap"
                                    data-filter="father_phone">
                                    {{ $class->getStudent() ? ($class->getStudent()->getFather()? $class->getStudent()->getFather()->phone : '') : '' }}
                                </td>
                            @endif
                            
                            @if (in_array('mother_email', $columns) || in_array('all', $columns))
                                <td data-column="mother_email" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->getStudent() ? ($class->getStudent()->getMother()? $class->getStudent()->getMother()->email : '') : '' }}
                                </td>
                            @endif
                            @if (in_array('mother_phone', $columns) || in_array('all', $columns))
                                <td data-column="mother_phone" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $class->getStudent() ? ($class->getStudent()->getMother()? $class->getStudent()->getMother()->phone : '') : '' }}
                                </td>
                            @endif
                            <td data-column="action">
                                <a href="javascript:;"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a href="{{ action(
                                            [App\Http\Controllers\Edu\StudentController::class, 'class'],
                                            [
                                                'id' => $class->getStudent()->id,
                                            ],
                                        ) }}"
                                            class="menu-link px-3">Xem</a>
                                    </div>
                                    <div class="menu-item px-3 {{ $type === 'request-demo' ? 'd-none' : '' }}">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'assignToClass'],
                                                [
                                                    'id' => $class->getStudent()->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xếp lớp</a>
                                    </div>
                                    <div
                                        class="menu-item px-3 {{ $type === 'edu' ? 'd-none' : '' }}{{ $type === \App\Models\Order::TYPE_EDU ? 'd-none' : '' }}">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'assignToClassRequestDemo'],
                                                [
                                                    'id' => $class->getStudent()->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xếp lớp demo</a>
                                    </div>
                                    <div class="menu-item px-3 text-start d-none">
                                        <a row-action="note-logs-customer"
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'noteLogsPopup'],
                                                [
                                                    'id' => 170,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Ghi chú</a>
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
            {{ $classes->links() }}
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
                Chưa có lớp học nào!
            </p>
            <p class="text-center d-none">
                <a list-action="create-constract" href="javascript:;" id="buttonCreateNewCourse"
                    class="btn btn-outline btn-outline-default">
                    <span class="material-symbols-rounded me-2">
                        add
                    </span>
                    Xếp lớp
                </a>
            </p>
        </div>
    @endif
    <script>
        $(function() {
            SortManager.setSort('{{ $sortColumn }}', '{{ $sortDirection }}');
        });
    </script>
</div>
