<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($students->count())
        <div class="table-responsive table-head-sticky freeze-column" style="max-height:calc(100vh - 420px);">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_customers_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>
                        @if (in_array('name', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="name" data-control="freeze-column"
                                sort-direction="{{ $sortColumn == 'name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8 bg-info" data-column="name">
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

                        @if (in_array('code', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="code"
                                sort-direction="{{ $sortColumn == 'code' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="code">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã học viên
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
                        @if (in_array('student_code_old', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="import_id"
                                sort-direction="{{ $sortColumn == 'import_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="student_code_old">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã cũ học viên
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

                        @if (in_array('class', $columns) || in_array('all', $columns))
                            <th class="min-w-100px fs-8" data-column="class">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lớp học
                                    </span>

                                </span>
                            </th>
                        @endif
                        @if (in_array('awaiting_class_arrangement', $columns) || in_array('all', $columns))
                            <th class="min-w-100px fs-8" data-column="awaiting_class_arrangement">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Đợi xếp lớp
                                    </span>

                                </span>
                            </th>
                        @endif
                        @if (in_array('reserve', $columns) || in_array('all', $columns))
                            <th class="min-w-100px fs-8" data-column="reserve">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Bảo lưu
                                    </span>

                                </span>
                            </th>
                        @endif
                        @if (in_array('phone', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="phone"
                                sort-direction="{{ $sortColumn == 'phone' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="phone">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Điện thoại
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
                        @if (in_array('time_to_call', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="time_to_call"
                                sort-direction="{{ $sortColumn == 'time_to_call' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="time_to_call">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời gian phù hợp
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'time_to_call' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('age', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="age"
                                sort-direction="{{ $sortColumn == 'age' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="age">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Độ tuổi học sinh
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'age' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('birthday', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="birthday"
                                sort-direction="{{ $sortColumn == 'birthday' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="birthday">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày sinh
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'birthday' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('email', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="email"
                                sort-direction="{{ $sortColumn == 'email' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="email">
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

                        @if (in_array('father', $columns) || in_array('all', $columns))
                            <th class="min-w-100px fs-8" data-column="father">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Cha
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('mother', $columns) || in_array('all', $columns))
                            <th class="min-w-100px fs-8" data-column="mother">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mẹ
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('address', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="address"
                                sort-direction="{{ $sortColumn == 'address' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="address">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Địa Chỉ
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'address' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('deadline', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="assigned_at"
                                sort-direction="{{ $sortColumn == 'deadline' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="deadline">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời hạn
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'deadline' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif


                        @if (in_array('demand', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="demand" style="min-width:200px!important;"
                                sort-direction="{{ $sortColumn == 'demand' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="demand">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Đơn hàng
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'demand' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('country', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="country"
                                sort-direction="{{ $sortColumn == 'country' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="country">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Quốc gia
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'country' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('city', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="city"
                                sort-direction="{{ $sortColumn == 'city' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="city">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thành phố
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'city' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('district', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="district"
                                sort-direction="{{ $sortColumn == 'district' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="district">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Quận/ Huyện
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'district' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('ward', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="ward"
                                sort-direction="{{ $sortColumn == 'ward' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="ward">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Phường
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'ward' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif


                        @if (in_array('school', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="school"
                                sort-direction="{{ $sortColumn == 'school' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="school">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trường
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'school' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('efc', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="efc"
                                sort-direction="{{ $sortColumn == 'efc' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="efc">
                                <span class="d-flex align-items-center">
                                    <span>
                                        EFC
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'efc' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('list', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="list"
                                sort-direction="{{ $sortColumn == 'list' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="list">
                                <span class="d-flex align-items-center">
                                    <span>
                                        List
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'list' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('target', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="target"
                                sort-direction="{{ $sortColumn == 'target' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="target">
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
                        @endif
                        @if (in_array('lead_status', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="lead_status"
                                sort-direction="{{ $sortColumn == 'lead_status' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="lead_status">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Status
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'lead_status' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('lifecycle_stage', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="lifecycle_stage"
                                sort-direction="{{ $sortColumn == 'lifecycle_stage' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="lifecycle_stage">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lifecycle stage
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'lifecycle_stage' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('created_at', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="created_at"
                                sort-direction="{{ $sortColumn == 'created_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="created_at">
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

                        @if (in_array('updated_at', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="updated_at"
                                sort-direction="{{ $sortColumn == 'updated_at' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="updated_at">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày cập nhật
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

                        @if (in_array('tag', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="tag"
                                sort-direction="{{ $sortColumn == 'tag' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="tag">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tag
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'tag' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('pic', $columns) || in_array('all', $columns))
                            <th list-action="sort" sort-by="pic"
                                sort-direction="{{ $sortColumn == 'pic' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="pic">
                                <span class="d-flex align-items-center">
                                    <span>
                                        PIC
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'pic' ? '' : 'text-muted' }}">
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
                    @foreach ($students as $student)
                        <tr list-control="item">
                            <td class="ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $student->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox" value="{{ $student->id }}" />
                                </div>
                            </td>
                            @if (in_array('name', $columns) || in_array('all', $columns))
                                <td data-column="name" data-control="freeze-column">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <a href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'show'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                                class="mb-1 fw-bold text-nowrap">{{ $student->name }}</a>
                                        </div>
                                        <!--begin::User details-->
                                    </div>
                                </td>
                            @endif

                            @if (in_array('code', $columns) || in_array('all', $columns))
                                <td data-column="code">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            <a href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'show'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                                class="mb-1 fw-bold text-nowrap">{{ $student->code }}</a>
                                        </div>
                                        <!--begin::User details-->
                                    </div>
                                </td>
                            @endif
                            @if (in_array('student_code_old', $columns) || in_array('all', $columns))
                                <td data-column="student_code_old">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">

                                            {{ $student->import_id }}


                                        </div>
                                        <!--begin::User details-->
                                    </div>


                                </td>
                            @endif
                            
                            @if (in_array('class', $columns) || in_array('all', $columns))
                                <td data-column="class">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">


                                            {{ App\Models\Contact::whichHasCousrse($student->id) }}
                                        </div>
                                        <!--begin::User details-->
                                    </div>


                                </td>
                            @endif
                            @if (in_array('awaiting_class_arrangement', $columns) || in_array('all', $columns))
                                <td data-column="awaiting_class_arrangement">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">
                                            {{ $student->whichHaDoesntCousrse($student->id) }}
                                        </div>
                                        <!--begin::User details-->
                                    </div>


                                </td>
                            @endif
                            @if (in_array('reserve', $columns) || in_array('all', $columns))
                                <td data-column="reserve">
                                    <div class="d-flex align-items-center">
                                        <div class="d-flex flex-column">

                                            {{ $student->getReserveCoursesCount() }}


                                        </div>
                                        <!--begin::User details-->
                                    </div>


                                </td>
                            @endif
                            @if (in_array('phone', $columns) || in_array('all', $columns))
                                <td data-column="phone" list-control="phone-inline-edit"
                                    data-url="{{ action('\App\Http\Controllers\Edu\StudentController@save', [
                                        'id' => $student->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    <div>
                                        <div class="text-nowrap">
                                            <span inline-control="data-phone">
                                                @if ($student->phone)
                                                    {{ $student->phone }}
                                                @else
                                                    <span class="text-gray-500">Chưa có số điện thoại</span>
                                                @endif
                                            </span>
                                            {{-- <a href="javascript:;" inline-control="edit-button-phone">
                                                <span class="material-symbols-rounded fs-6 inline-edit-button">
                                                    edit
                                                </span>
                                            </a> --}}
                                            <div inline-control="form-edit-phone" style="display:none;">
                                                <div class="d-flex align-items-center">
                                                    <input type="text" class="form-control" name="phone"
                                                        placeholder="" value="{{ $student->phone }}"
                                                        inline-control="input-edit-phone" />
                                                    <button inline-control="close-button-phone" type="button"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            close
                                                        </span>
                                                    </button>
                                                    <button type="button" inline-control="done-button-phone"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            done
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            @if (in_array('time_to_call', $columns) || in_array('all', $columns))
                                <td data-column="time_to_call">{{ $student->time_to_call }}</td>
                            @endif
                            @if (in_array('birthday', $columns) || in_array('all', $columns))
                                <td data-column="birthday">
                                    {{ $student->birthday ? date('d/m/Y', strtotime($student->birthday)) : '--' }}
                                </td>
                            @endif
                            @if (in_array('age', $columns) || in_array('all', $columns))
                                <td data-column="age">
                                    {{ $student->age }}
                                </td>
                            @endif
                            @if (in_array('email', $columns) || in_array('all', $columns))
                                <td data-column="email" list-control="email-inline-edit"
                                    data-url="{{ action('\App\Http\Controllers\Edu\StudentController@save', [
                                        'id' => $student->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    <div>
                                        <div>
                                            <span inline-control="data-email">
                                                @if ($student->email)
                                                    {{ $student->email }}
                                                @else
                                                    <span class="text-gray-500">Chưa có email</span>
                                                @endif
                                            </span>
                                            {{-- <a href="javascript:;" inline-control="edit-button-email">
                                                <span class="material-symbols-rounded fs-6 inline-edit-button">
                                                    edit
                                                </span>
                                            </a> --}}
                                            <div inline-control="form-edit-email" style="display:none;">
                                                <div class="d-flex align-items-center">
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="e.g., sean@dellito.com"
                                                        value="{{ $student->email }}"
                                                        inline-control="input-edit-email" />
                                                    <button inline-control="close-button-email" type="button"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            close
                                                        </span>
                                                    </button>
                                                    <button type="button" inline-control="done-button-email"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            done
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            @if (in_array('father', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="father">
                                    {{ $student->getFather() ? $student->getFather()->name : '' }}</td>
                            @endif
                            @if (in_array('mother', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="mother">
                                    {{ $student->getMother() ? $student->getMother()->name : '' }}</td>
                            @endif
                            @if (in_array('address', $columns) || in_array('all', $columns))
                                <td data-column="address">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $student->address }}</a>
                                </td>
                            @endif
                            @if (in_array('deadline', $columns) || in_array('all', $columns))
                                <td data-column="deadline" class="text-nowrap">
                                    @if ($student->assigned_at)
                                        <span
                                            class="{{ $student->isOutdated() ? 'text-danger' : '' }}">{{ $student->getDeadlineCountDownInMinutes() }}</span>
                                    @else
                                        <span class="text-muted">--</span>
                                    @endif
                                </td>
                            @endif
                            @if (in_array('demand', $columns) || in_array('all', $columns))
                                @php
                                    // Lấy danh sách các `demand` từ các yêu cầu liên lạc của sinh viên
                                    $demands = $student->contactRequests->pluck('demand')->filter()->toArray();
                                @endphp
                                <td data-column="demand">
                                    <!-- Hiển thị các `demand` dưới dạng một chuỗi -->
                                    <a href="javascript:;" class="text-hover-primary mb-1">
                                        {{ implode(', ', $demands) }}
                                    </a>
                                </td>
                            @endif
                            @if (in_array('country', $columns) || in_array('all', $columns))
                                <td data-column="country">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $student->country }}</a>
                                </td>
                            @endif
                            @if (in_array('city', $columns) || in_array('all', $columns))
                                <td data-column="city">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->city }}</a>
                                </td>
                            @endif
                            @if (in_array('district', $columns) || in_array('all', $columns))
                                <td data-column="district">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $student->district }}</a>
                                </td>
                            @endif
                            @if (in_array('ward', $columns) || in_array('all', $columns))
                                <td data-column="ward">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->ward }}</a>
                                </td>
                            @endif
                            @if (in_array('school', $columns) || in_array('all', $columns))
                                <td data-column="school">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->school }}</a>
                                </td>
                            @endif
                            @if (in_array('efc', $columns) || in_array('all', $columns))
                                <td data-column="efc">
                                    <a href="javascript:;" class="text-hover-primary mb-1">
                                        @if (isset($student->efc) && $student->efc !== '')
                                            {{ $student->efc . ' $' }}
                                        @else
                                            {{ $student->efc }}
                                        @endif
                                    </a>
                                </td>
                            @endif
                            @if (in_array('list', $columns) || in_array('all', $columns))
                                <td data-column="list">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->list }}</a>
                                </td>
                            @endif
                            @if (in_array('target', $columns) || in_array('all', $columns))
                                <td data-column="target">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->target }}</a>
                                </td>
                            @endif
                            @if (in_array('source_type', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="source_type">{{ $student->source_type }}
                                </td>
                            @endif
                            @if (in_array('channel', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="channel">
                                    {{ $student->channel }}</td>
                            @endif
                            @if (in_array('sub_channel', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="sub_channel">
                                    {{ $student->sub_channel }}</td>
                            @endif
                            @if (in_array('campaign', $columns) || in_array('all', $columns))
                                <td data-column="campaign">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $student->campaign }}</a>
                                </td>
                            @endif
                            @if (in_array('adset', $columns) || in_array('all', $columns))
                                <td data-column="adset">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->adset }}</a>
                                </td>
                            @endif
                            @if (in_array('ads', $columns) || in_array('all', $columns))
                                <td data-column="ads">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->ads }}</a>
                                </td>
                            @endif
                            @if (in_array('device', $columns) || in_array('all', $columns))
                                <td data-column="device">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->device }}</a>
                                </td>
                            @endif
                            @if (in_array('placement', $columns) || in_array('all', $columns))
                                <td data-column="placement">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $student->placement }}</a>
                                </td>
                            @endif
                            @if (in_array('term', $columns) || in_array('all', $columns))
                                <td data-column="term">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->term }}</a>
                                </td>
                            @endif
                            @if (in_array('type_match', $columns) || in_array('all', $columns))
                                <td data-column="type_match">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $student->type_match }}</a>
                                </td>
                            @endif
                            @if (in_array('first_url', $columns) || in_array('all', $columns))
                                <td data-column="first_url">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $student->first_url }}</a>
                                </td>
                            @endif
                            @if (in_array('last_url', $columns) || in_array('all', $columns))
                                <td data-column="last_url">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $student->last_url }}</a>
                                </td>
                            @endif
                            @if (in_array('contact_owner', $columns) || in_array('all', $columns))
                                <td data-column="contact_owner">
                                    <a href="javascript:;"
                                        class="text-hover-primary mb-1">{{ $student->contact_owner }}</a>
                                </td>
                            @endif
                            @if (in_array('lead_status', $columns) || in_array('all', $columns))
                                <td data-column="lead_status" list-control="lead_status-inline-edit"
                                    data-url="{{ action('\App\Http\Controllers\Edu\StudentController@save', [
                                        'id' => $student->id,
                                    ]) }}"
                                    class="text-nowrap">
                                    <div>
                                        <div>
                                            <span inline-control="data-lead_status">
                                                {!! $student->lead_status ?? '<span class="text-gray-500">Chưa khai thác</span>' !!}
                                            </span>
                                            <a href="javascript:;" inline-control="edit-button-lead_status">
                                                <span class="material-symbols-rounded fs-6 inline-edit-button">
                                                    edit
                                                </span>
                                            </a>
                                            <div inline-control="form-lead_status" style="display:none;">
                                                <div class="d-flex align-items-center">
                                                    <select inline-control="input-lead_status" class="form-select"
                                                        data-control="select2" data-placeholder="Select an option">
                                                        <option value="">Select an option</option>
                                                        @foreach (App\Models\ContactRequest::getEditableLeadStatuses() as $type)
                                                            <option value="{{ $type }}"
                                                                {{ $student->lead_status === $type ? 'selected' : '' }}>
                                                                {{ $type ?? 'None' }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <button inline-control="close-lead_status" type="button"
                                                        class="btn btn-icon">
                                                        <span class="material-symbols-rounded">
                                                            close
                                                        </span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            @endif
                            @if (in_array('lifecycle_stage', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="lifecycle_stage">
                                    {{ $student->lifecycle_stage }}
                                </td>
                            @endif
                            @if (in_array('gclid', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="gclid">
                                    {{ $student->gclid }}
                                </td>
                            @endif
                            @if (in_array('fbcid', $columns) || in_array('all', $columns))
                                <td class="text-nowrap" data-column="fbcid">
                                    {{ $student->fbcid }}
                                </td>
                            @endif
                            @if (in_array('created_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="created_at">
                                    {{ $student->created_at->format('d/m/Y') }}
                                </td>
                            @endif
                            @if (in_array('updated_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="updated_at">
                                    {{ $student->updated_at->format('d/m/Y') }}
                                </td>
                            @endif
                            @if (in_array('tag', $columns) || in_array('all', $columns))
                                <td class="min-w-125px fs-8" data-column="tag">
                                    @foreach ($student->tags as $tag)
                                        <span class="badge badge-primary">{{ $tag->name }}</span>
                                    @endforeach
                                </td>
                            @endif
                            @if (in_array('pic', $columns) || in_array('all', $columns))
                                <td data-column="pic">
                                    <a href="javascript:;" class="text-hover-primary mb-1">{{ $student->pic }}</a>
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
                                            [App\Http\Controllers\Edu\StudentController::class, 'show'],
                                            [
                                                'id' => $student->id,
                                            ],
                                        ) }}"
                                            class="menu-link px-3">Xem</a>
                                    </div>
                                    <div class="menu-item px-3 ">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'showFreeTimeScheduleOfStudent'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Thêm lịch rảnh</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a row-action="update" 
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'refundRequest'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Yêu cầu hoàn phí</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a row-action="update" data-action="under-construction"
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'transfer'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3" >Chuyển phí</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a row-action="update" 
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'reserve'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Bảo lưu</a>
                                    </div>
                                    <div class="menu-item px-3 d-none">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'assignToClass'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xếp lớp</a>
                                    </div>
                                    <div class="menu-item px-3 d-none">
                                        <a row-action="study-partner"data-action="under-construction"
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'studyPartner'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Học bù</a>
                                    </div>
                                    <div class="menu-item px-3 text-start d-none">
                                        <a row-action="note-logs-customer"
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'noteLogsPopup'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Ghi chú</a>
                                    </div>
                                    <div class="menu-item px-3 d-none">
                                        <a row-action="delete"
                                            href="{{ action(
                                                [App\Http\Controllers\Edu\StudentController::class, 'destroy'],
                                                [
                                                    'id' => $student->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xóa</a>
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
            {{ $students->links() }}
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
                Chưa có học viên!
            </p>
        </div>
    @endif
</div>
<!--end::Card body-->
</div>
<script></script>
