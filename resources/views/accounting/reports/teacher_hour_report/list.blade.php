@if (!empty($section_from) && !empty($section_to))
    <div class="card-body pt-0 mt-5">
        <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

            <table id="kt_datatable_complex_header" class="table align-middle border  fs-6 table-striped ">
                <thead>
                    <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                        <th class="border ps-5">Mã giáo viên</th>
                        <th class="border min-w-250px ps-5">Giáo viên</th>
                        <th class="border ps-5">Phân loại giáo viên</th>
                        <th class="border ps-5 d-none">Tutor/TA</th>
                        <th class="border min-w-300px ps-5">Mã Lớp</th>
                        <th class="border min-w-300px ps-5">Mã Lớp cũ</th>
                        <th class="border ps-5">Số lượng học viên</th>
                        <th class="border min-w-300px ps-5">Môn học</th>
                        <th class="border ps-5">Loại hình lớp</th>
                        <th class="border min-w-250px ps-5">Khung giờ</th>
                        <th class="border ps-5">Tình trạng</th>
                        <th class="border min-w-150px ps-5">Số giờ</th>
                        <th class="border min-w-150px ps-5">Rate</th>
                        <th class="border min-w-250px ps-5">Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($teachers as $teacher)
                    <tr class="border" list-control="item">
                        <td class="ps-5">{{$teacher->id}}</td>
                        <td class="ps-5">{{$teacher->name}}</td>
                        <td class="ps-5">{{ trans('messages.role.' . $teacher->type) }}</td>
                        <td class="ps-5 cell-under-construction d-none">
                        
                            Đang cập nhật
                        </td>
                        <td class="ps-5">
                            @foreach ($teacher->getCoursesForTeacherFromTo($section_from, $section_to) as $course)
                                <li>{{ $course->code }}</li>
                            @endforeach
                        </td>
                        <td class="ps-5">
                            @foreach ($teacher->getCoursesForTeacherFromTo($section_from, $section_to) as $course)
                                <li>{{ $course->import_id }}</li>
                            @endforeach
                        </td>
                        <td class="ps-5">
                            @foreach ($teacher->getCoursesForTeacherFromTo( $section_from, $section_to) as $course)
                                <li>{{ $course->countStudentsByCourse() }}&nbsp; /
                                    {{ $course->max_students }}&nbsp;học viên</li> 
                            @endforeach
                        </td>
                        <td class="ps-5 nowrap">  
                            @foreach ($teacher->getCoursesForTeacherFromTo( $section_from, $section_to) as $course)
                                <li>{{ $course->subject->name}}</li> 
                            @endforeach
                        </td>
                        <td class="ps-5">
                            @foreach ($teacher->getCoursesForTeacherFromTo( $section_from, $section_to) as $course)
                                <li> {{ trans('messages.courses.class_type.' . $course->class_type) }}</li> 
                            @endforeach
                        </td>
                        <td class="ps-5">
                            @foreach ($teacher->getCoursesForTeacherFromTo( $section_from, $section_to) as $course)
                                <li>  {{ \Carbon\Carbon::parse($course->start_at)->format('d/m/Y') }} -  {{ $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->end_at)->format('d/m/Y') : '--' }}</li> 
                            @endforeach
                        </td> 
                        <td class="ps-5  ">  
                            @foreach ($teacher->getCoursesForTeacherFromTo( $section_from, $section_to) as $course)
                                {{ $course->checkStatusSubject() }}
                            @endforeach
                        </td>
                        <td class="ps-5">
                            @php
                                $totalStudiedHours = 0; 
                            @endphp
                            @foreach ($teacher->getCoursesForTeacherFromTo( $section_from, $section_to) as $course)
                                <li> 
                                    @php
                                    
                                    $studiedHours = 0;
                                    if ($teacher->type === App\Models\Teacher::TYPE_VIETNAM) {
                                        $studiedHours = $course->getStudiedHoursForCourseFromToOfTeacher('vn_teacher', $section_from, $section_to);
                                    } elseif ($teacher->type === App\Models\Teacher::TYPE_FOREIGN) {
                                        $studiedHours = $course->getStudiedHoursForCourseFromToOfTeacher('foreign_teacher', $section_from, $section_to);
                                    } elseif ($teacher->type === App\Models\Teacher::TYPE_TUTOR) {
                                        $studiedHours = $course->getStudiedHoursForCourseFromToOfTeacher('tutor', $section_from, $section_to);
                                    }
                                    $totalStudiedHours += $studiedHours; 
                                    @endphp
                            
                                    {{ number_format($studiedHours, 2) }} giờ
                                </li>
                            @endforeach
                        </td>
                        <td class="ps-5">
                            @foreach ($teacher->getCoursesForTeacherFromTo( $section_from, $section_to) as $course)
                                <li>
                                    @php
                                        $rate = $teacher->getAmountForSubjectOfCourse($course);
                                        $formattedRate = $rate !== null ? ($rate->currency === \App\Models\Order::CURRENCY_CODE_VND ? '₫' : ($rate->currency === \App\Models\Order::CURRENCY_CODE_USD ? '$' : '')) . number_format($rate->amount) . ($rate->currency === \App\Models\Order::CURRENCY_CODE_VND ? '' : ($rate->currency === \App\Models\Order::CURRENCY_CODE_USD ? '' : '₫')) : 'Chưa có rate';
                                    @endphp
                                    
                                    {{ $formattedRate }}
                                
                                </li> 
                            @endforeach
                        </td>
                        <td class="ps-5">
                            @php
                                $totalAmount = 0; 
                            @endphp
                             @foreach ($teacher->getCoursesForTeacherFromTo($section_from, $section_to) as $course)
                             <li>
                                @php
                                    $studiedHoursOfTeacher = 0;
                                    if ($teacher->type === App\Models\Teacher::TYPE_VIETNAM) {
                                        $studiedHoursOfTeacher = $course->getStudiedHoursForCourseFromToOfTeacher('vn_teacher', $section_from, $section_to);
                                    } elseif ($teacher->type === App\Models\Teacher::TYPE_FOREIGN) {
                                        $studiedHoursOfTeacher = $course->getStudiedHoursForCourseFromToOfTeacher('foreign_teacher', $section_from, $section_to);
                                    } elseif ($teacher->type === App\Models\Teacher::TYPE_TUTOR) {
                                        $studiedHoursOfTeacher = $course->getStudiedHoursForCourseFromToOfTeacher('tutor', $section_from, $section_to);
                                    }
                                    
                                    $payrate = $teacher->getAmountForSubjectOfCourse($course);
                                    $rate = $payrate ? $payrate->amount : null;
                                    $amount = $rate !== null ? $studiedHoursOfTeacher * $rate : 0;
                                    $totalAmount += $amount; 
                                @endphp
                            
                                {{ $rate !== null ? ($payrate->currency === \App\Models\Order::CURRENCY_CODE_VND ? '₫' : ($payrate->currency === \App\Models\Order::CURRENCY_CODE_USD ? '$' : '')) . number_format($amount) . ($payrate->currency === \App\Models\Order::CURRENCY_CODE_VND ? '' : ($payrate->currency === \App\Models\Order::CURRENCY_CODE_USD ? '' : '₫')) : 'Chưa có rate' }}
                            </li>
                            
                            
                            @endforeach
                           
                            
                        </td>
                    </tr>
                    <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap"> 
                        
                        <th class="border px-5" colspan="9">Tổng cộng</th>
                        <th class="border px-5" colspan="1"> {{ number_format($totalStudiedHours, 2) }} giờ</th>
                        <th class="border px-5" colspan="1"></th>
                        <th class="border px-5" colspan="1">{{ number_format($totalAmount) }}₫</th>
                    </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
        <div class="mt-5">
    {{ $teachers->links()}}
        </div>
    </div>
@else
    <p class="fs-4 text-center mb-5 text-danger mt-10">
        Vui lòng chọn ngày bắt đầu và kết thúc
    </p>
@endif
