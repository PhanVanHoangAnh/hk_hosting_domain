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
                        @if (in_array('birthday', $columns) || in_array('all', $columns))
                            <th data-control="freeze-column"
                                class="min-w-125px text-left bg-info" data-column="name">
                                <span class="d-flex align-items-center">
                                    <span>
                                       Ngày sinh
                                    </span>
                                </span>
                            </th>
                        @endif

                        @if (in_array('code_student', $columns) || in_array('code_student', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="code_student">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã học viên
                                    </span>
                                </span>
                            </th>
                        @endif


                        @if (in_array('email', $columns) || in_array('email', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="email">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Email
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('phone', $columns) || in_array('phone', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="phone">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số điện thoại
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('school', $columns) || in_array('school', $columns))
                            <th class="min-w-125px text-left" data-column="school">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trường học
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('country', $columns) || in_array('country', $columns))
                            <th class="min-w-125px text-left" data-column="country">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Quốc gia Apply
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('financial_capability', $columns) || in_array('financial_capability', $columns))
                            <th class="min-w-125px text-left" data-column="financial_capability">
                                <span class="d-flex align-items-center">
                                    <span>
                                       Khả năng chi trả
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('father_id', $columns) || in_array('father_id', $columns))
                            <th
                                class="min-w-125px text-left" data-column="father_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Cha
                                    </span>
                                </span>
                            </th>
                        @endif
                      
                        @if (in_array('mother_id', $columns) || in_array('mother_id', $columns))
                            <th
                                class="min-w-125px text-left" data-column="mother_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mẹ
                                    </span>
                                </span>
                            </th>
                        @endif
                       
                        @if (in_array('code', $columns) || in_array('code', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="code">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mã hợp đồng
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('plan_apply_program_id', $columns) || in_array('plan_apply_program_id', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="plan_apply_program_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                    Chương trình dự kiến Apply
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('intended_major_id', $columns) || in_array('intended_major_id', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="intended_major_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngành học dự kiến apply
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('estimated_enrollment_time', $columns) || in_array('estimated_enrollment_time', $columns))
                            <th list-action="sort" sort-by="estimated_enrollment_time"
                                sort-direction="{{ $sortColumn == 'estimated_enrollment_time' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="estimated_enrollment_time">
                                <span class="d-flex align-items-center">
                                    <span>
                                       Thời điểm nhập học
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'estimated_enrollment_time' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        
                        @if (in_array('manager', $columns) || in_array('manager', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="manager">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Cán bộ quản lý
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('status_abroad', $columns) || in_array('status_abroad', $columns))
                            <th class="min-w-125px text-left" data-column="status_abroad">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tình trạng hồ sơ
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        @if (in_array('apply', $columns) || in_array('apply', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="apply">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Năm apply
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        @if ((in_array('account_manager_abroad_id', $columns) || in_array('account_manager_abroad_id', $columns)))
                            <th
                                class="min-w-125px text-left" data-column="account_manager_abroad_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trưởng nhóm du học
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if ((in_array('nvtvdhcl', $columns) || in_array('nvtvdhcl', $columns)))
                            <th
                                class="min-w-125px text-left" data-column="nvtvdhcl">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Nhân viên tư vấn du học chiến lược
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if ((in_array('nvttsk', $columns) || in_array('nvttsk', $columns)))
                            <th
                                class="min-w-125px text-left" data-column="nvttsk">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Nhân viên truyền thông & sự kiện
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
                                        Ngày tạo hồ sơ
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
                                        Ngày cập nhật hồ sơ
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

                        @if (in_array('top_school', $columns) || in_array('top_school', $columns))
                            <th 
                                class="min-w-125px text-left" data-column="top_school">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Top trường
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('sale', $columns) || in_array('sale', $columns))
                            <th
                                class="min-w-125px text-left" data-column="sale">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Nhân viên tư vấn
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
                                <td data-column="name" data-control="freeze-column" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    <a href="{{ action(
                                        [App\Http\Controllers\Abroad\AbroadApplicationController::class, 'details'],
                                        [
                                            'id' => $abroadApplication->id,
                                        ],
                                    ) }}" class="link-primary fw-bold">{{ $abroadApplication->student ? $abroadApplication->student->name : '' }}</a>
                                </td>
                            @endif
                            @if (in_array('birthday', $columns) || in_array('all', $columns))
                                <td data-column="birthday" data-control="freeze-column" class="text-left mb-1 text-nowrap" >
                                    {{ $abroadApplication->student ?   date('d/m/Y', strtotime($abroadApplication->student->birthday)) : '' }}
                                </td>
                            @endif

                            
                            @if (in_array('code_student', $columns) || in_array('all', $columns))
                                <td data-column="code_student" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->student ? $abroadApplication->student->code : '' }}
                                </td>
                            @endif

                            @if (in_array('email', $columns) || in_array('all', $columns))
                                <td data-column="email" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->student ? $abroadApplication->student->email : '' }}
                                </td>
                            @endif
                            @if (in_array('phone', $columns) || in_array('all', $columns))
                                <td data-column="phone" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->student ? $abroadApplication->student->phone : '' }}

                                </td>
                            @endif
                            @if (in_array('school', $columns) || in_array('all', $columns))
                                <td data-column="school" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->student ? $abroadApplication->student->school : '' }}
                                </td>
                            @endif
                           
                            @if (in_array('country', $columns) || in_array('all', $columns))
                                <td data-column="country" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    @foreach ($abroadApplication->orderItem->getTopSchool() ?? [] as $topSchoolItem)
                                        <div><li>{{  $topSchoolItem['country'] }}</li></div>
                                    @endforeach
                                </td>
                            @endif
                            
                            @if (in_array('financial_capability', $columns) || in_array('all', $columns))
                                <td data-column="financial_capability" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->financial_capability ? $abroadApplication->financial_capability.'$' : '' }}
                                </td>
                            @endif

                            @if (in_array('father_id', $columns) || in_array('all', $columns))
                                <td data-column="father_id" class="text-left mb-1 text-nowrap" style=""
                                    data-filter="mastercard">
                                    @if ($abroadApplication->student->father)
                                        {{$abroadApplication->student->father->name }}
                                        @if ($abroadApplication->student->father->phone)
                                            <div>
                                                (📱 {{ $abroadApplication->student->father->phone }})
                                            </div>
                                        @endif
                                    @endif
                                    
                                </td>
                            @endif
                            

                            @if (in_array('mother_id', $columns) || in_array('all', $columns))
                                <td data-column="mother_id" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    @if ($abroadApplication->student->mother)
                                        {{ $abroadApplication->student->mother->name }}
                                        @if ($abroadApplication->student->mother->phone)
                                            <div>
                                                (📱 {{ $abroadApplication->student->mother->phone }})
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            @endif
                           

                            @if (in_array('code', $columns) || in_array('all', $columns))
                                <td data-column="code" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->orderItem->order->code }}
                                </td>
                            @endif
                            @if (in_array('plan_apply_program_id', $columns) || in_array('all', $columns))
                                <td data-column="plan_apply_program_id" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->planApplyProgram->name }}
                                </td>
                            @endif
                            @if (in_array('intended_major_id', $columns) || in_array('all', $columns))
                                <td data-column="intended_major_id" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->intendedMajor ? $abroadApplication->intendedMajor->name : '' }}
                                </td>
                            @endif
                            @if (in_array('estimated_enrollment_time', $columns) || in_array('all', $columns))
                                <td data-column="estimated_enrollment_time" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{$abroadApplication->estimated_enrollment_time ? \Carbon\Carbon::parse($abroadApplication->estimated_enrollment_time)->format('d/m/Y') : '' }}
                                </td>
                            @endif
                            
                            @if (in_array('manager', $columns) || in_array('all', $columns))
                                <td data-column="manager" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                   Đang cập nhật
                                </td>
                            @endif
                            @if (in_array('status_abroad', $columns) || in_array('all', $columns))
                                <td data-column="status_abroad" class="text-left mb-1 text-nowrap {{ $abroadApplication->status == 'cancel' ? 'text-danger' : '' }}" data-filter="mastercard">
                                    @if ($abroadApplication->status == 'cancel')
                                        Đã huỷ
                                    @elseif ($abroadApplication->status == 'reserve')
                                        Bảo lưu
                                    @elseif ($abroadApplication->status == 'unreserve')
                                        Đã dừng bảo lưu
                                    @else
                                        {{ trans('messages.abroad.hsdt_status.' . $abroadApplication->hsdt_status) }}
                                    @endif
                                </td>
                                
                            @endif
                            @if (in_array('apply', $columns) || in_array('all', $columns))
                                <td data-column="apply" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ date('d/m/Y', strtotime($abroadApplication->orderItem->apply_time)) }}
                                </td>
                            @endif
                            @if ( (in_array('account_manager_abroad_id', $columns) || in_array('all', $columns)))
                            <td data-column="account_manager_abroad_id" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                {{ $abroadApplication->managerAbroad ? $abroadApplication->managerAbroad->name : '---'}}
                            </td>
                            @endif
                            @if ( (in_array('nvtvdhcl', $columns) || in_array('all', $columns)))
                            <td data-column="nvtvdhcl" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                {{ $abroadApplication->account1 ? $abroadApplication->account1->name : '---'}}
                            </td>
                            @endif
                            @if ((in_array('nvttsk', $columns) || in_array('all', $columns)))
                                <td data-column="nvttsk" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                    {{ $abroadApplication->account2 ? $abroadApplication->account2->name : '---' }}
                                </td>
                            @endif
                            
                            @if (in_array('created_at', $columns) || in_array('all', $columns))
                                <td data-column="created_at" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ \Carbon\Carbon::parse($abroadApplication->created_at)->format('d/m/Y') }}
                                </td>
                            @endif

                            @if (in_array('updated_at', $columns) || in_array('all', $columns))
                                <td data-column="updated_at" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ \Carbon\Carbon::parse($abroadApplication->updated_at)->format('d/m/Y') }}
                                </td>
                            @endif

                            @if (in_array('top_school', $columns) || in_array('all', $columns))
                                <td data-column="top_school" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    @foreach ($abroadApplication->orderItem->getTopSchool() ?? [] as $topSchoolItem)
                                        <div><li>{{ $topSchoolItem['num_of_school_from'] ? $topSchoolItem['num_of_school_from'] . " trường" : '' }} {{ $topSchoolItem['top_school_from'] ? "TOP " . $topSchoolItem['top_school_from'] : '' }} {{ $topSchoolItem['country'] ? " tại " . $topSchoolItem['country'] : '' }}</li></div>
                                    @endforeach
                                </td>
                            @endif
                            @if (in_array('sale', $columns) || in_array('all', $columns))
                                <td data-column="sale" class="text-left mb-1 text-nowrap"
                                    data-filter="mastercard">
                                    {{ $abroadApplication->orderItem->order->salesperson ? $abroadApplication->orderItem->order->salesperson->name: '' }}
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
                                        <a href="{{ action(
                                                [App\Http\Controllers\Abroad\AbroadApplicationController::class, 'details'],
                                                [
                                                    'id' => $abroadApplication->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xem hồ sơ</a>
                                    </div>
                                    <div class="menu-item px-3 d-none">
                                        <a data-action="under-construction"
                                            href="{{ action(
                                                [App\Http\Controllers\Abroad\AbroadController::class, 'general'],
                                                [
                                                    'id' => $abroadApplication->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xem chi tiết</a>
                                    </div>
                                    <div class="menu-item px-3 d-none">
                                        <a data-action="under-construction" href="" row-action="show"
                                            class="menu-link px-3">Cập nhật trạng thái</a>
                                    </div>
                                    <div class="menu-item px-3 d-none">
                                        <a data-action="under-construction" href="" row-action="score"
                                            class="menu-link px-3">Chấm điểm</a>
                                    </div>
                                    @if (Auth()->user()->can('handover', $abroadApplication) && $abroadApplication->status !== 'cancel' && $abroadApplication->status !== 'reserve')
                                        <div class="menu-item px-3 ">
                                            <a  row-action="updateStatusAbroadApplication"
                                                class="menu-link px-3 {{ $status == 'assigned' ? 'd-none' : ''}}"
                                                href="{{ action(
                                                    [App\Http\Controllers\Abroad\AbroadController::class, 'updateStatusAbroadApplication'],
                                                    [
                                                        'id' => $abroadApplication->id,
                                                    ],
                                                ) }}">
                                                Bàn giao
                                            </a>
                                        </div>
                                    @endif
                                    @if ($abroadApplication->status !== 'cancel')
                                        <div class="menu-item px-3">
                                            <a row-action="cancel" 
                                            data-customer-name="{{ $abroadApplication->student->name }}"
                                                href="{{ action(
                                                    [App\Http\Controllers\Abroad\AbroadController::class, 'cancel'],
                                                    [
                                                        'id' => $abroadApplication->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Huỷ hồ sơ du học</a>
                                        </div>
                                    @endif
                                    @if ($abroadApplication->status !== 'reserve' && $abroadApplication->status !== 'cancel')
                                        <div class="menu-item px-3">
                                            <a row-action="reserve" 
                                            data-customer-name="{{ $abroadApplication->student->name }}"
                                                href="{{ action(
                                                    [App\Http\Controllers\Abroad\AbroadController::class, 'reserve'],
                                                    [
                                                        'id' => $abroadApplication->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Bảo lưu hồ sơ du học</a>
                                        </div>
                                    @endif
                                    @if ($abroadApplication->status !== 'unreserve' && $abroadApplication->status !== 'cancel')
                                        <div class="menu-item px-3">
                                            <a row-action="unreserve" 
                                            data-customer-name="{{ $abroadApplication->student->name }}"
                                                href="{{ action(
                                                    [App\Http\Controllers\Abroad\AbroadController::class, 'unreserve'],
                                                    [
                                                        'id' => $abroadApplication->id,
                                                    ],
                                                ) }}"
                                                class="menu-link px-3">Dừng bảo lưu</a>
                                        </div>
                                    @endif
                                   
                                    <div class="menu-item px-3 d-none">
                                        <a data-action="under-construction" href="" row-action="approve"
                                            class="menu-link px-3">PGĐ duyệt</a>
                                    </div>
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
                Chưa có khóa học nào!
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

            UpdateNotelogPopup.init();

            Cancel.init();

            Reserve.init();

            Unreserve.init();
        });

        var HorizonScrollFix = function() {
            let coursesBox = $('#abroad-application-table-box');

            let setScroll = distanceFromLeft => {
                window.ordersListScrollFromLeft = distanceFromLeft;
            };

            let applyScroll = () => {
                coursesBox.scrollLeft(window.ordersListScrollFromLeft);
            }

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
                            UpdateNotelogPopup.updateUrl(btnUrl);
                        });
                    });
                }
            }
        }();

        var UpdateNotelogPopup = (function() {
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
        var Cancel = function() {
            var list;
            var links;

            var request = function(url) {
                ASTool.addPageLoadingEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                    }
                }).done((response) => {
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            list.load();
                        }
                    });

                    list.load();
                }).fail(function(response) {
                    ASTool.alert({
                        message: response.responseText,
                        ok: function() {
                            list.load();
                        }
                    });
                }).always(function() {
                    ASTool.removePageLoadingEffect();
                })
            }

            return {
                init: function() {
                    list = abroadApplicationsList.getList();
                    links = list.container.querySelectorAll('[row-action="cancel"]');

                    //events
                    links.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            let url = link.getAttribute('href');
                            var customerName = link.getAttribute('data-customer-name');
                            ASTool.confirm({
                                message: 'Bạn có chắc chắn là huỷ hồ sơ du học của học viên '+ customerName +' không?',
                                ok: function() {
                                    request(url);
                                }
                            });
                        });
                    });
                },
            };
        }();
        var Reserve = function() {
            var list;
            var links;

            var request = function(url) {
                ASTool.addPageLoadingEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                    }
                }).done((response) => {
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            list.load();
                        }
                    });

                    list.load();
                }).fail(function(response) {
                    ASTool.alert({
                        message: response.responseText,
                        ok: function() {
                            list.load();
                        }
                    });
                }).always(function() {
                    ASTool.removePageLoadingEffect();
                })
            }

            return {
                init: function() {
                    list = abroadApplicationsList.getList();
                    reserve = list.container.querySelectorAll('[row-action="reserve"]');

                    //events
                    reserve.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            let url = link.getAttribute('href');
                            var customerName = link.getAttribute('data-customer-name');
                            ASTool.confirm({
                                message: 'Bạn có chắc chắn là bảo lưu hồ sơ du học của học viên '+ customerName +' không?',
                                ok: function() {
                                    request(url);
                                }
                            });
                        });
                    });
                },
            };
        }();
        var Unreserve = function() {
            var list;
            var links;

            var request = function(url) {
                ASTool.addPageLoadingEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                    }
                }).done((response) => {
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            list.load();
                        }
                    });

                    list.load();
                }).fail(function(response) {
                    ASTool.alert({
                        message: response.responseText,
                        ok: function() {
                            list.load();
                        }
                    });
                }).always(function() {
                    ASTool.removePageLoadingEffect();
                })
            }

            return {
                init: function() {
                    list = abroadApplicationsList.getList();
                    links = list.container.querySelectorAll('[row-action="unreserve"]');

                    //events
                    links.forEach(link => {
                        link.addEventListener('click', e => {
                            e.preventDefault();
                            let url = link.getAttribute('href');
                            var customerName = link.getAttribute('data-customer-name');
                            ASTool.confirm({
                                message: 'Bạn có chắc chắn là huỷ bảo lưu hồ sơ du học của học viên '+ customerName +' không?',
                                ok: function() {
                                    request(url);
                                }
                            });
                        });
                    });
                },
            };
        }();
    </script>
</div>
