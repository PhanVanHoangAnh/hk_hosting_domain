{{-- @if (!empty($updated_at_from) && !empty($updated_at_to)) --}}
    <div class="card-body pt-0 mt-5">
        <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

            <table id="kt_datatable_complex_header" class="table align-middle border fs-6 ">
                <thead>
                    <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                        <th class="border px-5" >Thứ</th>
                        <th class="border px-5 " >Ngày</th>
                        <th class="border px-5" >Mã lớp cũ</th>
                        <th class="border px-5" >Mã lớp</th>
                        <th class="border px-5" >Phòng học</th>
                        <th class="border min-w-100px px-5" >Loại hình lớp</th>
                        <th class="border min-w-100px px-5" >Trạng thái lớp</th>
                        <th class="border min-w-150px px-5" >Giờ học</th>
                        <th class="border min-w-250px px-5" >Giáo viên VN</th>
                        <th class="border px-5" >SỐ GIỜ học với GVVN</th>
                        <th class="border min-w-250px px-5" >GVNN</th>
                        <th class="border px-5" >SỐ GIỜ học với GVNN</th>
                        <th class="border min-w-250px px-5" >Gia sư</th>
                        <th class="border px-5" >SỐ GIỜ học với Gia sư</th>
                        <th class="border min-w-250px px-5" >Trợ giảng</th>
                        <th class="border px-5" >SỐ GIỜ học với trợ giảng</th>
                        <th class="border px-5" >Mã học viên cũ</th>
                        <th class="border px-5" >Mã học viên</th>
                        <th class="border min-w-250px px-5" >Tên học viên</th>
                        <th class="border px-5" >Tình trạng</th>
                        <th class="border min-w-150px px-5" >Địa điểm </th>
                        <th class="border min-w-150px px-5" >Chi nhánh </th>
                        <th class="border min-w-150px px-5" >Môn học</th>
                        <th class="border min-w-200px px-5" >Trình độ</th>
                        <th class="border min-w-250px px-5" >Chủ nhiệm</th>
                        <th class="border px-5" >mhv + ten lop</th>
                        <th class="border min-w-200px px-5" >HD+TEN</th>
                        <th class="border px-5" >HỢP ĐỒNG</th>
                        <th class="border min-w-200px px-5" >SALE</th>
                        
                    </tr>

                </thead>
                <tbody>
                    @foreach($studentSections as $studentSection)
                    <tr>
                        <td class="px-5 ">
                            {{ \Carbon\Carbon::parse($studentSection->section->study_date)->dayOfWeekIso+1 }}
                        </td>
                        <td class="px-5 ">
                            {{ date('d/m/Y', strtotime($studentSection->section->study_date)) }}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->section->course->import_id }}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->section->course->code }}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->section->course->class_room }}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->section->course->study_method }}
                        </td>
                        <td class="px-5 ">
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
                            <span
                              class="badge bg-{{ $studentSection->section->status === App\Models\Section::STATUS_DESTROY ? 'danger text-white' : $bgs[$studentSection->section->checkStatusSectionCalendar()] }}"
                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                data-bs-placement="right">
                                {{ $studentSection->section->status === App\Models\Section::STATUS_DESTROY ? 'Đã hủy' : $studentSection->section->checkStatusSectionCalendar() }}
                                
                            </span>
                        </td>
                        <td class="px-5 ">
                            {{ date('H:i', strtotime($studentSection->section->start_at)) }} - {{ date('H::i', strtotime($studentSection->section->end_at)) }}
                            
                        </td>
                        <td class="px-5 ">
                            
                            {{ isset($studentSection->section->vnTeacher)  ? $studentSection->section->vnTeacher->name : '--' }}
                        </td>
                        <td class="px-5">
                            {{ $studentSection->section->calculateInMinutesVnTeacherInSection() != 0 ? number_format($studentSection->section->calculateInMinutesVnTeacherInSection() / 60, 2) : $studentSection->section->calculateInMinutesVnTeacherInSection() }}
                        </td>
                        <td class="px-5 ">
                            
                            {{ isset($studentSection->section->foreignTeacher)  ? $studentSection->section->foreignTeacher->name : '--' }}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->section->calculateInMinutesForeignTeacherInSection() != 0 ? number_format($studentSection->section->calculateInMinutesForeignTeacherInSection() / 60, 2) : $studentSection->section->calculateInMinutesForeignTeacherInSection() }}
                        </td>
                        <td class="px-5 ">
                            
                            {{ isset($studentSection->section->tutor)  ? $studentSection->section->tutor->name : '--' }}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->section->calculateInMinutesTutorInSection() != 0 ? number_format($studentSection->section->calculateInMinutesTutorInSection() / 60, 2) : $studentSection->section->calculateInMinutesTutorInSection() }}
                        </td>
                        <td class="px-5 ">
                            
                            {{ isset($studentSection->assistant->tutor)  ? $studentSection->section->assistant->name : '--' }}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->section->calculateInMinutesAssistantInSection() != 0 ? number_format($studentSection->section->calculateInMinutesAssistantInSection() / 60, 2) : $studentSection->section->calculateInMinutesAssistantInSection() }}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->student->import_id}}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->student->code}}
                        </td>
                        <td class="px-5 ">
                            {{ $studentSection->student->name}}
                        </td>
                        <td class="px-5 "> 
                            {{ trans('messages.student_section.' . $studentSection->status) }}
                        </td>
                        <td class="px-5 "> 
                            {{$studentSection->section->course->trainingLocation->name }}
                        </td>
                        <td class="px-5 "> 
                            {{ isset($studentSection->section->course->trainingLocation) ? trans('messages.training_locations.' . $studentSection->section->course->trainingLocation->branch) : "--" }}
                        </td>
                        <td class="px-5 "> 
                            {{$studentSection->section->course->subject->name }}
                        </td>
                        <td class="px-5 "> 
                            {{$studentSection->section->course->level }}
                        </td>
                        <td class="px-5 "> 
                            {{$studentSection->section->course->teacher->name }}
                        </td>
                        <td class="px-5 "> 
                            {{ $studentSection->student->code}}
                            {{ $studentSection->section->course->code }}
                        </td>
                        <td class="px-5 "> 
                            {{$studentSection->courseStudent->orderItems->order->code }}
                            {{$studentSection->courseStudent->orderItems->order->contacts->name }}
                        </td>
                        <td class="px-5 "> 
                            {{$studentSection->courseStudent->orderItems->order->code }}
                        </td>
                        <td class="px-5 "> 
                            {{ isset($studentSection->courseStudent->orderItems->order->salesperson)  ? $studentSection->courseStudent->orderItems->order->salesperson->name : '--' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        <div class="mt-5">
            {{ $studentSections->links() }}
        </div>
    </div>
{{-- @else
    <p class="fs-4 text-center mb-5 text-danger mt-10">
        Vui lòng chọn ngày bắt đầu và kết thúc
    </p>
@endif --}}
