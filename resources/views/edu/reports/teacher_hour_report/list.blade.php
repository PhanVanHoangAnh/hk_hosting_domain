@if (!empty($section_from) && !empty($section_to))
<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

        <table id="kt_datatable_complex_header" class="table align-middle border  fs-6 table-striped ">
            <thead>
                <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                    <th class="border ps-5">STT</th>
                    <th class="border ps-5">Mã giáo viên</th>
                    <th class="border min-w-250px ps-5">Tên Giáo viên</th>
                    <th class="border ps-5">Phân loại giáo viên</th>
                    <th class="border ps-5">Giờ chưa dạy</th>
                    <th class="border ps-5">Giờ dạy</th>
                    <th class="border ps-5">Nghỉ có kế hoạch</th>
                    <th class="border ps-5">Nghỉ do giảng viên </th>
                    <th class="border ps-5">Nghỉ do học viên</th>
                    <th class="border ps-5">Tổng cộng</th>
                    <th class="border ps-5">Sô giờ cam kết tối thiểu</th>
                    <th class="border ps-5">Tỉ lệ thực tế/Cam kết</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($teachers as $teacher)
                <tr class="border" list-control="item">
                    <td class="ps-5">{{ ($teachers->currentPage() - 1) * $teachers->perPage() + $loop->iteration }}</td>
                    <td class="ps-5">{{$teacher->id}}</td>
                    <td class="px-5 ">
                        <a row-action="detail-teacher" title="Click vào tên giảng viên xem chi tiết" data-bs-toggle="tooltip"
                            href="{{ action([App\Http\Controllers\Edu\Report\TeacherHourReportController::class, 'listDetailTeacher'],
                            [
                                'id' => $teacher->id,
                                'section_from' => $section_from,
                                'section_to' => $section_to,
                            ]) }}">
                            {{$teacher->name}}
                        </a>
                    </td> 
                    {{-- <td class="ps-5">{{$teacher->name}}</td> --}}
                    <td class="ps-5">{{trans('messages.role.' . $teacher->type)}}</td>
                    @php
                        
                        $teacherHoursActive = $teacher->getTeachedHoursActive($section_from,$section_to);
                        $hourTeacherActive = floor($teacherHoursActive / 60);
                        $minutisTeacherActive = $teacher->getTeachedHoursActive($section_from,$section_to)%60;
                    @endphp
                
                    <td class="ps-5">
                        {{ $hourTeacherActive }} giờ {{ $minutisTeacherActive }} phút 
                    </td>
                    @php
                       

                        $teacherHours = $teacher->getTeachedHours($section_from,$section_to);
                        $hourTeacher = floor($teacherHours / 60);
                        $minutisTeacher = $teacher->getTeachedHours($section_from,$section_to)%60;
                    @endphp
                
                    <td class="ps-5">
                        {{ $hourTeacher }} giờ {{ $minutisTeacher }} phút 
                    </td>

                    @php
                        $teacherHoursCancelled = $teacher-> getCancelledTeachedHours($section_from,$section_to);
                        $hourTeacherCancelled = floor($teacherHoursCancelled / 60);
                        $minutisTeacherCancelled = $teacher-> getCancelledTeachedHours($section_from,$section_to)%60;
                    @endphp
            
                    <td class="ps-5">
                        {{ $hourTeacherCancelled }} giờ {{ $minutisTeacherCancelled }} phút 
                    </td>
                    @php
                        $teacherHoursLateCancelledTeacher = $teacher-> getLateCancelledTeacherHours($section_from,$section_to);
                        $hourTeacherLateCancelledTeacher= floor($teacherHoursLateCancelledTeacher / 60);
                        $minutisTeacherLateCancelledTeacher = $teacher-> getLateCancelledTeacherHours($section_from,$section_to)%60;
                    @endphp
        
                    <td class="ps-5">
                        {{ $hourTeacherLateCancelledTeacher }} giờ {{ $minutisTeacherLateCancelledTeacher }} phút 
                    </td>

                    @php
                        $teacherHoursLateCancelledStudent = $teacher-> getLateCancelledStudentHours($section_from,$section_to);
                        $hourTeacherLateCancelledStudent= floor($teacherHoursLateCancelledStudent / 60);
                        $minutisTeacherLateCancelledStudent = $teacher-> getLateCancelledStudentHours($section_from,$section_to)%60;
                    @endphp
        
                    <td class="ps-5">
                        {{ $hourTeacherLateCancelledStudent }} giờ {{ $minutisTeacherLateCancelledStudent }} phút 
                    </td>

                    @php
                        $teacherHoursTotal = $teacher->getTeachedHoursTotal($section_from,$section_to);
                        $hourTeacherTotal = floor($teacherHoursTotal / 60);
                        $minutisTeacherTotal = $teacher->getTeachedHoursTotal($section_from,$section_to)%60;
                    @endphp
                
                    <td class="ps-5">
                        {{ $hourTeacherTotal }} giờ {{ $minutisTeacherTotal }} phút 
                    </td>
                    @php
                        $teacherHoursCommitted = $teacher->payrates->first()->hours_committed;
                        
                        $hourTeacherCommitted = floor($teacherHoursCommitted / 60);
                        $minutesTeacherCommitted = $teacherHoursCommitted % 60;
                    @endphp

                    <td class="ps-5">
                        {{ $hourTeacherCommitted }} giờ {{ $minutesTeacherCommitted }} phút 
                    </td>
                    @php
                         $teacherHoursRatio = $teacher->getTeachedHoursRatio($section_from,$section_to);
                        
                    @endphp

                    <td class="ps-5">
                        {{$teacherHoursRatio}} % 
                    </td>
                </tr>
            @endforeach

            </tbody>

        </table>
    </div>
    <div class="mt-5">
        {{ $teachers->links()}}
    </div>
@else
    <p class="fs-4 text-center mb-5 text-danger mt-10">
        Vui lòng chọn ngày bắt đầu và kết thúc
    </p>
@endif
