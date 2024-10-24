<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($abroadApplications->count())
        <div id="abroad-application-table-box" class="table-responsive scrollable-orders-table freeze-column">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>

                        @if (in_array('name', $columns) || in_array('name', $columns))
                            <th list-action="sort" sort-by="name" data-control="freeze-column"
                                sort-direction="{{ $sortColumn == 'name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left bg-info" data-column="name">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên hoạt động
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
                        @if (in_array('type', $columns) || in_array('type', $columns))
                            <th list-action="sort" sort-by="type"
                                sort-direction="{{ $sortColumn == 'type' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="type">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Loại chương trình
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
                        @if (in_array('address', $columns) || in_array('name', $columns))
                            <th list-action="sort" sort-by="address"
                                sort-direction="{{ $sortColumn == 'address' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="address">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Địa điểm
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
                        @if (in_array('coordinator', $columns) || in_array('coordinator', $columns))
                            <th list-action="sort" sort-by="coordinator"
                                sort-direction="{{ $sortColumn == 'coordinator' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="coordinator">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Người điều phối
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'coordinator' ? '' : 'text-muted' }}">
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
                                        Thời điểm bắt đầu
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
                                        Thời điểm kết thúc
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
                        @if (in_array('price', $columns) || in_array('price', $columns))
                            <th list-action="sort" sort-by="price"
                                sort-direction="{{ $sortColumn == 'price' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="price">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Giá gốc
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
                        @if (in_array('max_student', $columns) || in_array('max_student', $columns))
                            <th list-action="sort" sort-by="max_student"
                                sort-direction="{{ $sortColumn == 'max_student' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="max_student">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số lượng học viên tối đa
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'max_student' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('min_student', $columns) || in_array('min_student', $columns))
                            <th list-action="sort" sort-by="min_student"
                                sort-direction="{{ $sortColumn == 'min_student' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="min_student">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số lượng học viên tối thiểu
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'min_student' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('expected_costs', $columns) || in_array('expected_costs', $columns))
                            <th list-action="sort" sort-by="expected_costs"
                                sort-direction="{{ $sortColumn == 'name' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="expected_costs">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Chi phí dự kiến
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'expected_costs' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('actual_costs', $columns) || in_array('actual_costs', $columns))
                            <th list-action="sort" sort-by="actual_costs"
                                sort-direction="{{ $sortColumn == 'actual_costs' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="actual_costs">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Chi phí thực tế
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'actual_costs' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('profit', $columns) || in_array('profit', $columns))
                            <th list-action="sort" 
                            {{-- sort-by="name" --}}
                                {{-- sort-direction="{{ $sortColumn == 'profit' && $sortDirection ? $sortDirection : 'desc' }}" --}}
                                class="min-w-125px text-left" data-column="profit">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lợi nhuận
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        @if (in_array('total_revenue', $columns) || in_array('total_revenue', $columns))
                            <th list-action="sort" 
                                {{-- sort-by="name"
                                sort-direction="{{ $sortColumn == 'name' && $sortDirection ? $sortDirection : 'desc' }}" --}}
                                class="min-w-125px text-left" data-column="total_revenue">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tổng doanh thu
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
                                        Hình thức
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
                        {{-- @if (in_array('student_code', $columns) || in_array('student_code', $columns))
                            <th list-action="sort" sort-by="student_code"
                                sort-direction="{{ $sortColumn == 'student_code' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="student_code">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã học viên
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'student_code' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif --}}
                        @if (in_array('student_apply', $columns) || in_array('student_apply', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="student_apply">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Học viên tham gia
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'student_apply' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('hours_per_week', $columns) || in_array('hours_per_week', $columns))
                            <th list-action="sort" sort-by="hours_per_week"
                                sort-direction="{{ $sortColumn == 'hours_per_week' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="hours_per_week">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số giờ trong tuần
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'hours_per_week' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('weeks_per_year', $columns) || in_array('weeks_per_year', $columns))
                            <th list-action="sort" sort-by="weeks_per_year"
                                sort-direction="{{ $sortColumn == 'weeks_per_year' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="weeks_per_year">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số tuần trong năm
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'weeks_per_year' ? '' : 'text-muted' }}">
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
                    @foreach ($abroadApplications as $abroadApplication)
                        <tr list-control="item">
                            <td class="text-left ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $abroadApplication->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>

                            @if (in_array('name', $columns) || in_array('all', $columns))
                                <td data-column="name" class="text-left mb-1 text-nowrap" data-control="freeze-column"
                                    data-filter="mastercard">
                                    {{ $abroadApplication->name }}
                                </td>
                            @endif
                            @if (in_array('type', $columns) || in_array('all', $columns))
                                <td data-column="type" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $abroadApplication->type }}
                                </td>
                            @endif
                            @if (in_array('address', $columns) || in_array('all', $columns))
                                <td data-column="address" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $abroadApplication->address }}
                                </td>
                            @endif
                            @if (in_array('coordinator', $columns) || in_array('all', $columns))
                                <td data-column="coordinator" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ isset($abroadApplication->account) ? $abroadApplication->account->name : "" }}
                                </td>
                            @endif
                            @if (in_array('price', $columns) || in_array('all', $columns))
                                <td data-column="price" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    
                                    {{ App\Helpers\Functions::formatNumber($abroadApplication->price) }}₫
                                </td>
                            @endif
                            @if (in_array('max_student', $columns) || in_array('all', $columns))
                                <td data-column="max_student" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $abroadApplication->max_student }}
                                </td>
                            @endif
                            @if (in_array('min_student', $columns) || in_array('all', $columns))
                                <td data-column="min_student" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $abroadApplication->min_student }}
                                </td>
                            @endif
                            @if (in_array('expected_costs', $columns) || in_array('all', $columns))
                                <td data-column="expected_costs" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ App\Helpers\Functions::formatNumber($abroadApplication->expected_costs) }}₫
                                    
                                </td>
                            @endif
                            @if (in_array('actual_costs', $columns) || in_array('all', $columns))
                                <td data-column="actual_costs" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ App\Helpers\Functions::formatNumber($abroadApplication->actual_costs) }}₫
                                    
                                </td>
                            @endif
                            @if (in_array('profit', $columns) || in_array('all', $columns))
                                <td data-column="profit" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ App\Helpers\Functions::formatNumber($abroadApplication->getProfit()) }}₫
                                    
                                </td>
                            @endif
                            @if (in_array('total_revenue', $columns) || in_array('all', $columns))
                                <td data-column="total_revenue" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ \App\Helpers\Functions::formatNumber($abroadApplication->totalRevenue()) }}đ  
                                </td>
                            @endif
                            @if (in_array('study_method', $columns) || in_array('all', $columns))
                                <td data-column="study_method" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $abroadApplication->study_method }}
                                </td>
                            @endif



                            @if (in_array('start_at', $columns) || in_array('all', $columns))
                                <td data-column="start_at" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->start_at ? date('d/m/Y', strtotime($abroadApplication->start_at)) : '' }}
                                    
                                </td>
                            @endif
                            @if (in_array('end_at', $columns) || in_array('all', $columns))
                                <td data-column="end_at" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->end_at ? date('d/m/Y', strtotime($abroadApplication->end_at)) : '' }}
                                    
                                </td>
                            @endif
                            @if (in_array('created_at', $columns) || in_array('all', $columns))
                                <td data-filter="mastercard" data-column="created_at">
                                    {{ $abroadApplication->created_at->format('d/m/Y') }}
                                </td>
                            @endif
                            {{-- @if (in_array('student_code', $columns) || in_array('all', $columns))
                                <td data-column="student_code" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    --
                                </td>
                            @endif --}}
                            @if (in_array('student_apply', $columns) || in_array('all', $columns))
                                <td data-column="student_apply" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{-- {{ $abroadApplication->countStudents() }}fff --}}
                                    <a row-action="report-student" class="badge badge-secondary"
                                    href="{{ action(
                                        [App\Http\Controllers\Abroad\ExtracurricularStudentController::class, 'indexShow'],
                                        [
                                            'id' => $abroadApplication->id,
                                        ],
                                    ) }}">
                                    {{ $abroadApplication->countStudents() }} học viên

                                </a>
                                </td>
                            @endif
                            @if (in_array('hours_per_week', $columns) || in_array('all', $columns))
                                <td data-column="hours_per_week" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $abroadApplication->hours_per_week ?? '0'}} Giờ

                                </td>
                            @endif
                            @if (in_array('weeks_per_year', $columns) || in_array('all', $columns))
                                <td data-column="weeks_per_year" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $abroadApplication->weeks_per_year ?? '0'}} Tuần
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
                                    <div class="menu-item px-3">
                                        <a row-action="updateStatusAbroadApplication"
                                            href="{{ action(
                                                [App\Http\Controllers\Abroad\ExtracurricularStudentController::class, 'index'],
                                                [
                                                    'id' => $abroadApplication->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Quản lý học viên</a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a row-action="updateStatusAbroadApplication"
                                            href="{{ action(
                                                [App\Http\Controllers\Abroad\ExtracurricularController::class, 'edit'],
                                                [
                                                    'id' => $abroadApplication->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Chỉnh sửa</a>
                                    </div>
                                    
                                    @if (Auth::user()->hasPermission(App\Library\Permission::EXTRACURRICULAR_MANAGE_ALL)) 
                                    <div class="menu-item px-3 {{$abroadApplication->checkCountStudent()?'d-none':''}}">
                                        <a href="{{ action(
                                            [App\Http\Controllers\Abroad\ExtracurricularController::class, 'delete'],
                                            [
                                                'id' => $abroadApplication->id,
                                            ],
                                        ) }}"
                                            row-action="delete" class="menu-link px-3">Xóa</a>
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
            {{ $abroadApplications->links() }}
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
                Chưa có hoạt động ngoại khoá nào
            </p>
            <p class="text-center d-none">
                <a list-action="create-constract"
                    href="{{ action([App\Http\Controllers\Abroad\CourseController::class, 'add']) }}"
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

            UpdateExtracurricularPopup.init();

            ReportsStudentPopup.init();
        });
        var ReportsStudentPopup = function() {
                var popupReportsStudent;
                return {
                    init: function(updateUrl) {
                        popupReportsStudent = new Popup({
                            url: updateUrl,

                        });
                    },
                    load: function(url) {
                        popupReportsStudent.url = url;
                        popupReportsStudent.load();
                    },
                    getPopup: function() {
                        return popupReportsStudent;
                    }
                };
            }();
        var HorizonScrollFix = function() {
            let coursesBox = $('#abroad-application-table-box');

            let setScroll = distanceFromLeft => {
                window.ordersListScrollFromLeft = distanceFromLeft;
            };

            let applyScroll = () => {
                coursesBox.scrollLeft(window.ordersListScrollFromLeft);
            }
            function getReportsStudentButtons() {
                return document.querySelectorAll('[row-action="report-student"]');
            };
            function getUpdateBtn() {
                return document.querySelectorAll('[row-action="updateStatusAbroadApplication"]');
            }

            return {
                init: function() {

                    applyScroll();

                    coursesBox.on('scroll', () => {
                        setScroll(coursesBox.scrollLeft());
                    });
                    getUpdateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdateExtracurricularPopup.updateUrl(btnUrl);
                        });
                    });
                    getReportsStudentButtons().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var url = btn.getAttribute('href');
                            ReportsStudentPopup.load(url);
                        });
                    });
                    
                }
            }
        }();

        var UpdateExtracurricularPopup = (function() {
            var updatePopup;

            return {
                init: function() {
                    updatePopup = new Popup();
                },
                updateUrl: function(newUrl) {
                    updatePopup.url = newUrl;
                    updatePopup.load();
                },
                getUpdatePopup: function() {
                    return updatePopup;
                }
            };
        })();
    </script>
</div>
