<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($requests->count())
        <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_contacts_table">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>
                        @if (in_array('student_id', $columns) || in_array('student_id', $columns))
                            <th list-action="sort" sort-by="student_id"
                                sort-direction="{{ $sortColumn == 'student_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-125px text-left" data-column="student_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên học viên
                                    </span>
                                    <span>
                                        <span>
                                            <span
                                                class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'student_id' ? '' : 'text-muted' }}">
                                                sort
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </th>
                        @endif
                        @if (in_array('class', $columns) || in_array('class', $columns))
                            <th list-action="sort" 
                                class="min-w-125px text-left" data-column="class">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lớp học
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                       
                       
                        @if (in_array('orderItem_id', $columns) || in_array('orderItem_id', $columns))
                            <th sort-by="orderItem_id"
                                sort-direction="{{ $sortColumn == 'orderItem_id' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="orderItem_id">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên dịch vụ
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        @if (in_array('level', $columns) || in_array('level', $columns))
                            <th list-action="sort" 
                                class="min-w-125px text-left" data-column="level">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trình độ
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        
                        @if (in_array('train_hours', $columns) || in_array('train_hours', $columns))
                            <th list-action="sort" 
                                class="min-w-125px text-left" data-column="train_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tổng số giờ khóa học
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        
                        @if (in_array('studied_hours', $columns) || in_array('studied_hours', $columns)) 
                            <th  sort-by="studied_hours"
                                sort-direction="{{ $sortColumn == 'studied_hours' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="studied_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tổng số giờ đã học
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        
                        @if (in_array('price_studied_hours', $columns) || in_array('price_studied_hours', $columns)) 
                            <th  sort-by="price_studied_hours"
                                sort-direction="{{ $sortColumn == 'price_studied_hours' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8 d-none" data-column="price_studied_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tổng giá trị giờ đã học
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        
                        @if (in_array('refund_hours', $columns) || in_array('refund_hours', $columns)) 
                            <th  sort-by="refund_hours"
                                sort-direction="{{ $sortColumn == 'refund_hours' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="refund_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tổng số giờ hoàn phí
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                    
                        @if (in_array('remain_hours', $columns) || in_array('remain_hours', $columns)) 
                            <th  sort-by="remain_hours"
                                sort-direction="{{ $sortColumn == 'remain_hours' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="remain_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tổng số giờ còn lại
                                    </span>
                                    
                                </span> 
                            </th>
                        @endif
                
                        @if (in_array('price_remain_hours', $columns) || in_array('remain_hours', $columns)) 
                            <th sort-by="price_remain_hours"
                                sort-direction="{{ $sortColumn == 'price_remain_hours' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8 d-none" data-column="price_remain_hours">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tổng giá trị còn lại
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
            
                        @if (in_array('reason', $columns) || in_array('reason', $columns)) 
                            <th  sort-by="reject_reason"
                                sort-direction="{{ $sortColumn == 'reason' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="reason">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lý do hoàn phí
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
        
                        @if (in_array('refund_date', $columns) || in_array('refund_date', $columns)) 
                            <th  sort-by="reject_reason"
                                sort-direction="{{ $sortColumn == 'refund_date' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="refund_date">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ngày yêu cầu hoàn phí
                                    </span>
                                    
                                </span>
                            </th>
                        @endif

                        @if (in_array('reject_reason', $columns) || in_array('reject_reason', $columns)) 
                            <th  sort-by="reject_reason"
                                sort-direction="{{ $sortColumn == 'reject_reason' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="reject_reason">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Lý do từ chối
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                        

                        @if (in_array('status', $columns) || in_array('status', $columns)) 
                            <th  sort-by="status"
                                sort-direction="{{ $sortColumn == 'status' && $sortDirection ? $sortDirection : 'desc' }}"
                                class="min-w-100px fs-8" data-column="status">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trạng thái
                                    </span>
                                    
                                </span>
                            </th>
                        @endif
                       
                        <th class="min-w-125px ">Thao tác</th>
                    </tr>
                </thead>
                

                <tbody class="text-gray-600">
                    @foreach ($requests as $request)
                        <tr list-control="item">
                            <td class="text-center ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $request->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            @if (in_array('student_id', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="student_id">
                                    {{ $request->student->name }}
                                </td>
                            @endif
                            @if (in_array('class', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="class">
                                    @php
                                        $courseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($request->order_item_id, $request->student_id);
                                    @endphp
                                    @if ($courseStudents->count() > 0)
                                        @foreach ($courseStudents as $courseStudent)
                                            <div>{{ $courseStudent->course->code }}</div>
                                        @endforeach
                                    @else
                                        Chưa xếp lớp
                                    @endif
                                </td>
                            @endif    
                            @if (in_array('orderItem_id', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="orderItem_id">
                                    
                                    {{-- {{ $request->courseStudent->orderItems->subject->name }} --}}
                                    {{ $request->orderItem->subject->name }}
                                </td>
                            @endif
                            @if (in_array('level', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="level">
                                    {{ $request->orderItem->level }} 
                                </td>
                            @endif
                            
                            @if (in_array('train_hours', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="train_hours">
                                    {{ number_format($request->orderItem->getTotalMinutes()/60,2) }} giờ
                                </td>
                            @endif
                            @if (in_array('studied_hours', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="studied_hours">
                                    @php
                                        $groupedCourseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($request->order_item_id, $request->student_id)
                                            ->groupBy('subject_id');
                                    @endphp
                        
                                    @php
                                        $subjectTotalHoursStudied = 0; 
                                    @endphp
                        
                                    @if ($groupedCourseStudents->count() > 0)
                                        @foreach ($groupedCourseStudents as $subjectId => $group)
                                            @php
                                                $subjectTotalHoursStudied += $group->sum(function ($courseStudent) use ($request) {
                                                    return \App\Models\StudentSection::calculateTotalHoursStudied($request->student_id, $courseStudent->course_id);
                                                });
                                            @endphp
                                            {{ $subjectTotalHoursStudied }} giờ
                                        @endforeach
                                    @else
                                        0 giờ
                                    @endif
                                </td>
                            @endif
                                {{-- <td class="text-left mb-1 text-nowrap d-none" data-filter="mastercard" data-column="price_studied_hours"> 
                                    {{ App\Helpers\Functions::formatNumber($studiedPrice) }}₫
                                </td> --}}
                            @if (in_array('refund_hours', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="refund_hours"> 
                                    @php
                                        $courseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($request->order_item_id, $request->student_id);
                                    @endphp
                                    @if ($courseStudents->count() > 0)
                                        @foreach ($courseStudents as $courseStudent)
                                            @php
                                                $totalHoursRefund = \App\Models\StudentSection::calculateTotalHoursRefund($request->student_id, $courseStudent->course_id, $request->refund_date);
                                            @endphp
                                            <div>{{ $totalHoursRefund }} giờ</div>
                                        @endforeach
                                    @else
                                        <div> {{ number_format($request->orderItem->getTotalMinutes()/60, 2) }} giờ</div>
                                    @endif
                                
                                </td>
                            @endif
                            @if (in_array('remain_hours', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="remain_hours"> 
                                    @php
                                        $groupedCourseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($request->order_item_id, $request->student_id)
                                            ->groupBy('subject_id');
                                    @endphp
                        
                                    @php
                                        $subjectTotalHoursStudied = 0; 
                                    @endphp
                        
                                    @if ($groupedCourseStudents->count() > 0)
                                        @foreach ($groupedCourseStudents as $subjectId => $group)
                                            @php
                                                $subjectTotalHoursStudied += $group->sum(function ($courseStudent) use ($request) {
                                                    return \App\Models\StudentSection::calculateTotalHoursStudied($request->student_id, $courseStudent->course_id);
                                                });
                                            @endphp
                                            
                                        @endforeach
                                    

                                    @endif
                                    {{ number_format($request->orderItem->getTotalMinutes()/60 - $subjectTotalHoursStudied,2) }} giờ
                                    
                                </td>
                            @endif
                            @if (in_array('reason', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="reason">   
                                    <div class="d-flex" >
                                        <span class="d-inline-block  text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $request->reason }}" data-filter="mastercard" data-column="reason">
                                            {{ $request->reason }} 
                                        </span> 
                                    </div> 
                                </td>
                            @endif
                            @if (in_array('refund_date', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="refund_date"> 
                                    <div class="d-flex" >
                                        <span class="d-inline-block  text-truncate" style="max-width: 150px;" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $request->reason }}" data-filter="mastercard" data-column="reason">
                                            {{  date('d/m/Y', strtotime($request->refund_date))  }}
                                        </span> 
                                    </div> 
                                </td>
                            @endif
                            @if (in_array('reject_reason', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="reject_reason"> 
                                    <div class="d-flex" >
                                        <span class="d-inline-block text-truncate" style="max-width: 150px;"
                                            @if(isset($request->reject_reason))
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $request->reject_reason }}"
                                            @endif
                                            data-filter="mastercard" data-column="reason">
                                            {{ $request->reject_reason ?? '--' }}
                                        </span>
                                    </div> 
                                </td>
                            @endif
                            @if (in_array('status', $columns) || in_array('all', $columns))
                                <td class="text-left mb-1 text-nowrap" data-filter="mastercard" data-column="status"> 
                                    @php
                                            $bgs = [
                                                App\Models\RefundRequest::STATUS_APPROVED => 'success text-white',
                                                App\Models\RefundRequest::STATUS_PENDING => 'warning text-white',
                                                App\Models\RefundRequest::STATUS_REJECTED => 'danger text-white',
                                            ];
                                        @endphp
                                        
                                            <span class="badge bg-{{ $bgs[$request->status] ?? 'info text-white' }}"
                                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                                data-bs-placement="right">
                                                
                                                {{ trans('messages.refund_requests.status.' . $request->status) }}

                                            </span>
                                </td>
                            @endif
                            
                            <td class="text-left">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                    style="margin-left: 0px">
                                    Thao tác
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3 ">
                                        <a row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Accounting\RefundRequestController::class, 'showRequest'],
                                                [
                                                    'id' => $request->id,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Xem chi tiết</a>
                                    </div>
                                    
                                    <!--end::Menu item-->
                                </div>
                                <!--end::Menu-->
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--end::Table-->
        <div class="mt-5">
            {{ $requests->links() }}
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
                Không có yêu cầu nào!
            </p>
        </div>
    @endif
</div>


<script>
   
</script>
