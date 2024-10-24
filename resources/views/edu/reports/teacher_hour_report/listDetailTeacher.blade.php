@extends('layouts.main.popup', [
    'size' => 'full',
])
@section('title')
    Báo cáo chi tiết giờ dạy của giảng viên {{$teacher->name}}
@endsection

@section('content')
<div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_contact_scroll">
    <div class="card-body pt-0 mt-5">
        <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

            <table id="kt_datatable_complex_header" class="table align-middle border  fs-6 table-striped ">
                <thead>
                    <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                        <th class="border ps-5">STT</th>
                        <th class="border ps-5">Số phiếu đào tạo</th>
                        <th class="border min-w-250px ps-5">Ngày</th>
                        <th class="border ps-5">Mã giáo viên</th>
                        <th class="border ps-5 d-none">Giáo viên</th>
                        <th class="border min-w-300px ps-5">Phân loại giáo viên</th>
                        <th class="border ps-5">Mã lớp</th>
                        <th class="border ps-5">Mã lớp cũ</th>
                        <th class="border min-w-300px ps-5">Môn học</th>
                        <th class="border ps-5">Trình độ</th>
                        <th class="border min-w-250px ps-5">Số lượng học viên</th>
                        <th class="border ps-5">Loại hình lớp</th>
                        <th class="border min-w-150px ps-5">Khung giờ</th>
                        <th class="border min-w-150px ps-5">Tình trạng</th>
                        <th class="border min-w-250px ps-5">Số giờ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sectionsInRange as $index => $section)
                    <tr class="border" list-control="item">
                            <td class="px-5">{{ $index + 1 }}</td>
                            <td class="ps-5"> {{ $section->getCode() }}</td>
                            <td class="ps-5">{{ date('d/m/Y', strtotime($section->study_date)) }}</td>
                            <td class="ps-5">{{ $teacher->id }}</td>
                            <td class="ps-5 "> {{ trans('messages.role.' . $teacher->type) }} </td>
                            <td class="ps-5 "> {{$section->course->code}} </td>
                            <td class="ps-5 "> {{$section->course->import_id}} </td>
                            <td class="ps-5 "> {{isset($section->course->subject ) ? $section->course->subject->name : "" }} </td>
                            <td class="ps-5 "> {{$section->course->level}} </td>
                            <td class="ps-5 ">
                                {{ $section->course->countStudentsByCourse() }}&nbsp; /
                                {{ $section->course->max_students }}&nbsp;học viên </td>
                            <td class="ps-5 "> 
                                {{ trans('messages.courses.class_type.' . $section->course->class_type)}} 
                            </td>
                            <td class="ps-5 "> 
                                {{ \Carbon\Carbon::parse($section->start_at)->format('H:i') }} -    {{ \Carbon\Carbon::parse($section->end_at)->format('H:i') }}    
                                 
                            </td>
                            <td data-column="status" class="text-left mb-1 text-nowrap" data-filter="mastercard">

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
                                    class="badge bg-{{ $section->status === App\Models\Section::STATUS_DESTROY ? 'danger text-white' : $bgs[$section->checkStatusSectionCalendar()] }}"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right">
                                    {{ $section->status === App\Models\Section::STATUS_DESTROY ? 'Đã hủy' : $section->checkStatusSectionCalendar() }}
                                </span>
                            </td>
                            <td class="ps-5 "> 
                                @if ($teacher->type == App\Models\Teacher::TYPE_VIETNAM)
                                    
                                    {{number_format($section->calculateInMinutesVnTeacherInSection() / 60, 2) . ' giờ' }}
                                @elseif ($teacher->type == App\Models\Teacher::TYPE_FOREIGN)
                                    
                                    {{number_format($section->calculateInMinutesForeignTeacherInSection() / 60, 2) . ' giờ' }}
                                @elseif ($teacher->type == App\Models\Teacher::TYPE_TUTOR)
                                    {{number_format($section->calculateInMinutesTutorInSection() / 60, 2) . ' giờ' }}
                                    
                                @endif
                            </td>
                          
                        </tr>
                    @endforeach
                       
                        
                </tbody>
                

            </table>
        </div>
        <div class="mt-5">

        </div>
    </div>
</div>
@endsection
