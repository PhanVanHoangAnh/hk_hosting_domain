@extends('layouts.main.popup', [
    'size' => 'full',
])
@section('title')
    Báo cáo chi tiết giờ tồn của học viên
@endsection

@section('content')
    <!--begin::Scroll-->
    <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_contact_scroll">
        
        <div class="card-body pt-0 mt-5">
            <div class="table-responsive table-head-sticky" style="overflow-x:auto;">
                <div class="mb-10">
                    <div class="scrollable-table-excel">
                        <table id="kt_datatable_complex_header" class="table  table-bordered table-sm "
                            cellspacing="0" width="100%">
                            <thead>
                                <tr
                                    class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                                    <th class="border px-5" rowspan="3">STT</th>
                                    <th class="border px-5" rowspan="3">Ngày</th>
                                    <th class="border px-5" rowspan="3">Số phiếu Đào tạo</th>
                                    
                                    <th class="border px-5" rowspan="3">Số hợp đồng</th>
                                    <th class="border px-5" rowspan="3">Mã học viên</th>
                                    <th class="border px-5" rowspan="3">Mã cũ học viên</th>

                                    <th class="border min-w-150px px-5" rowspan="3">Tên học viên</th>
                                    <th class="border min-w-100px px-5" rowspan="3">Môn học</th>
                                    <th class="border min-w-100px px-5" rowspan="3">Lớp học</th>
                                    <th class="border px-5" rowspan="3">Loại hình giáo viên</th>
                                </tr>
                                <tr
                                    class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                                    <th colspan="1" class="text-center border">Đăng kí</th>
                                    <th colspan="1" class="text-center border">Đã học</th>
                                </tr>
                                <tr
                                    class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                                    <th class="border ps-5 min-w-10px w-auto fw-bold ">Giờ học</th>
                                    
                                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Giờ học</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                @if($orderItem->num_of_vn_teacher_sections)
                                    <tr>
                                        <td class="px-5 "></td>
                                        <td class="px-5 ">
                                            {{ date('d/m/Y', strtotime($orderItem->orders->order_date)) }}
                                        </td>
                                        <td class="px-5 "></td>
                                        
                                        <td class="px-5 ">
                                            {{$orderItem->orders->code}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->orders->contacts->code}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->orders->contacts->import_id}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->orders->student->name}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->subject->name}}
                                        </td>
                                        <td class="px-5 ">
                                        
                                        </td>
                                        <td class="px-5 ">
                                           Giáo viên Việt Nam
                                        </td>
                                        <td class="px-5 ">
                                            {{ number_format($orderItem->getTotalVnMinutes()/60, 2) }} giờ
                                        </td>
                                     
                                        <td class="px-5 "></td>
                                        
                                    </tr>
                                @endif
                                @if($orderItem->num_of_foreign_teacher_sections)
                                    <tr>
                                        <td class="px-5 "></td>
                                        <td class="px-5 ">
                                            {{ date('d/m/Y', strtotime($orderItem->orders->order_date)) }}
                                        </td>
                                        <td class="px-5 "></td>
                                        
                                        <td class="px-5 ">
                                            {{$orderItem->orders->code}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->orders->contacts->code}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->orders->student->name}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->subject->name}}
                                        </td>
                                        <td class="px-5 ">
                                        
                                        </td>
                                        <td class="px-5 ">
                                           Giáo viên nước ngoài
                                        </td>
                                        <td class="px-5 ">
                                            {{ number_format($orderItem->getTotalForeignMinutes()/60, 2) }} giờ
                                        </td>
                                        
                                        <td class="px-5 "></td>
                                    </tr>
                                @endif
                                @if($orderItem->num_of_tutor_sections)
                                    <tr>
                                        <td class="px-5 "></td>
                                        <td class="px-5 ">
                                            {{ date('d/m/Y', strtotime($orderItem->orders->order_date)) }}
                                        </td>
                                        <td class="px-5 "></td>
                                        
                                        <td class="px-5 ">
                                            {{$orderItem->orders->code}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->orders->contacts->code}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->orders->student->name}}
                                        </td>
                                        <td class="px-5 ">
                                            {{$orderItem->subject->name}}
                                        </td>
                                        <td class="px-5 ">
                                        
                                        </td>
                                        <td class="px-5 ">
                                           Gia sư
                                        </td>
                                        <td class="px-5 ">
                                            {{ number_format($orderItem->getTotalTutorMinutes()/60, 2) }} giờ
                                        </td>
                                       
                                        <td class="px-5 "></td>
                                    </tr>
                                @endif
                                @php
                                    $rowIndex = 1;
                                @endphp
                                @foreach($studentSections as $studentSection) 
                                    @if($studentSection->section->is_vn_teacher_check)
                                        <tr class="border">
                                            <td class="px-5">{{ $rowIndex++ }}</td>

                                            <td class="px-5 ">
                                                {{ date('d/m/Y', strtotime($studentSection->section->study_date)) }}
                                            </td>
                                            <td class="px-5 ">{{$studentSection->section->getCode()}}</td>
                                            
                                            <td class="px-5 ">
                                                {{$orderItem->orders->code}}
                                            </td>

                                            <td class="px-5 ">
                                                {{$orderItem->orders->contacts->code}}
                                            </td>

                                            <td class="px-5 ">
                                                {{$orderItem->orders->student->name}}
                                            </td>

                                            <td class="px-5 ">
                                                {{$orderItem->subject->name}}
                                            </td>

                                            <td class="px-5 ">
                                                {{$studentSection->section->course->code}}
                                            </td>

                                            <td class="px-5 ">
                                                Giáo viên Việt Nam
                                                {{$studentSection->section->vnTeacher->name}}
                                            </td>

                                            <td class="px-5 "></td>
                                            
                                            <td class="px-5 ">
                                                {{ $studentSection->status === App\Models\StudentSection::STATUS_PRESENT ? number_format($studentSection->section->calculateInMinutesVnTeacherInSection() / 60, 2) . ' giờ' : '0 giờ' }}
                                            </td>
                                           
                                        </tr>
                                    @endif
                                    @if($studentSection->section->is_foreign_teacher_check)
                                        <tr class="border">
                                            <td class="px-5">{{ $rowIndex++ }}</td>

                                            <td class="px-5 ">
                                                {{ date('d/m/Y', strtotime($studentSection->section->study_date)) }}
                                            </td>
                                            <td class="px-5 ">{{$studentSection->section->getCode()}}</td>
                                            
                                            <td class="px-5 ">
                                                {{$orderItem->orders->code}}
                                            </td>

                                            <td class="px-5 ">
                                                {{$orderItem->orders->contacts->code}}
                                            </td>

                                            <td class="px-5 ">
                                                {{$orderItem->orders->student->name}}
                                            </td>

                                            <td class="px-5 ">
                                                {{$orderItem->subject->name}}
                                            </td>

                                            <td class="px-5 ">
                                                {{$studentSection->section->course->code}}
                                            </td>

                                            <td class="px-5 ">
                                                Giáo viên nước ngoài
                                                {{$studentSection->section->foreignTeacher->name}}
                                            </td>

                                            <td class="px-5 "></td>
                                           
                                            <td class="px-5 ">
                                                {{ $studentSection->status === App\Models\StudentSection::STATUS_PRESENT ? number_format($studentSection->section->calculateInMinutesForeignTeacherInSection() / 60, 2) . ' giờ' : '0 giờ' }}
                                            </td>
                                           
                                        </tr>
                                    @endif
                                    @if($studentSection->section->is_tutor_check)
                                        <tr class="border">
                                            <td class="px-5">{{ $rowIndex++ }}</td>
                                            <td class="px-5 ">
                                                {{ date('d/m/Y', strtotime($studentSection->section->study_date)) }}
                                            </td>
                                            <td class="px-5 ">{{$studentSection->section->getCode()}}</td>
                                            
                                            <td class="px-5 ">
                                                {{$orderItem->orders->code}}
                                            </td>
                                            <td class="px-5 ">
                                                {{$orderItem->orders->contacts->code}}
                                            </td>
                                            <td class="px-5 ">
                                                {{$orderItem->orders->student->name}}
                                            </td>
                                            <td class="px-5 ">
                                                {{$orderItem->subject->name}}
                                            </td>
                                            <td class="px-5 ">
                                                {{$studentSection->section->course->code}}
                                            </td>
                                            <td class="px-5 ">
                                            Gia sư
                                            {{$studentSection->section->tutor->name}}
                                            </td>
                                            <td class="px-5 ">
                                                
                                            </td>
                                            
                                            <td class="px-5 ">
                                                {{ $studentSection->status === App\Models\StudentSection::STATUS_PRESENT ? number_format($studentSection->section->calculateInMinutesTutorInSection() / 60, 2) . ' giờ' : '0 giờ' }}
                                            </td>
                                          
                                        </tr>
                                    @endif
                                        
                                @endforeach
                                <tr class="text-start bg-info text-light fw-bold fs-7  gs-0 text-nowrap border">
                                    <td class="px-5 text-white ">Tổng cộng</td>
                                    <td class="px-5 text-white"> </td>
                                    <td class="px-5 text-white"> </td>
                                    <td class="px-5 text-white"> </td>
                                    <td class="px-5 text-white"> </td>
                                    <td class="px-5 text-white"> </td>
                                    <td class="px-5 text-white"> </td>
                                    <td class="px-5 text-white"> </td>
                                    <td class="px-5 text-white"> </td>
                                    <td class="px-5 text-white">
                                        {{ number_format($orderItem->getTotalMinutes()/60, 2) }} giờ
                                    </td>
                                    
                                    <td class="px-5 text-white">
                                        
                                        {{$orderItem->calculateTotalHoursStudiedForCourseStudents()}} giờ
                                    </td>
                                    
                                </tr>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
            <div class="mt-5">

            </div>
        </div>
    </div>
@endsection

