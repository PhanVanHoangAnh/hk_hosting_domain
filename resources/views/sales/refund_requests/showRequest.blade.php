@extends('layouts.main.popup')

@section('title')
    Yêu cầu hoàn phí của {{$refundRequest->student->name}} 
@endsection
@php
$formId = 'F' . uniqid();
@endphp

@section('content')
    <form id="{{ $formId }}" >
        @csrf
        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" >
            <input type="hidden" name="contact_id" value="{{$refundRequest->student_id}}">

            @if ($refundRequest->reject_reason  )
            <div class="card px-5 py-5 my-5">
                <label class="fs-5 fw-bold mb-5 d-flex align-items-center ">
                    Lí do từ chối
                </label>
                <div class="text-center">
                    <label class="fs-6  fs-3 d-flex align-items-center " >
                        {{$refundRequest->reject_reason}}
                    </label>
                </div>
            </div>
                
            @endif
            <div class="card px-5 py-5 mb-5">
                <label class="fs-5 fw-bold mb-5 d-flex align-items-center ">
                    Lí do hoàn phí
                </label>
                <div class="text-center">
                    <label class="fs-6  fs-3 d-flex align-items-center"
                        for="order-type-select">
                        {{$refundRequest->reason}}
                    </label>
                </div>
            </div>
            
            <h2 class="text-info text-nowrap  mb-5 ">
                Hợp đồng
            </h2>

            <div class="  col-md-12 solid mb-7">
                <div class="table-responsive" id='contract-list'>
                <table class="table table-row-bordered table-hover table-bordered">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            
                            <th class="text-nowrap text-white">Mã hợp đồng</th>
                            <th class="text-nowrap text-white">Trạng thái thanh toán</th>
                            <th class="text-nowrap text-white">Tổng số tiền</th>
                            <th class="text-nowrap text-white">Đã thu</th>
                            <th class="text-nowrap text-white">Còn lại</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                            data-bs-placement="left" data-bs-dismiss="click"
                            class=" pe-none bg-light">
                            <td>
                                <div>
                                    <a class="fw-semibold text-info" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                        title="Nhấn để chỉnh sửa hợp đồng này">
                                        {{ $refundRequest->orderItem->orders->code }}
                                    </a>
                                </div>
                                <span class="badge bg-secondary">
                                    {{ trans("messages.order.status.{$refundRequest->orderItem->orders->status}") }}

                                </span>
                            </td>

                            <td>

                                @php

                                    $bgs = [
                                        App\Models\PaymentReminder::STATUS_PAID => 'success',
                                        App\Models\PaymentReminder::STATUS_UNPAID => 'danger text-white',
                                    ];

                                    $overallStatus = \App\Models\PaymentReminder::STATUS_PAID;

                                    if ($refundRequest->orderItem->orders->getTotal() - $refundRequest->orderItem->orders->sumAmountPaid() > 1) {
                                        $overallStatus = \App\Models\PaymentReminder::STATUS_UNPAID;
                                    }

                                @endphp

                                <span title="{{ trans('messages.payment_reminders.status.' . $overallStatus) }}"
                                    class="badge bg-{{ $bgs[$overallStatus] ?? 'info' }}">
                                    {{ trans('messages.payment_reminders.status.' . $overallStatus) }}
                                </span>

                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->orders->getTotal(), 0, '.', ',') }}₫

                            </td>

                            <td>
                                {{ number_format($refundRequest->orderItem->orders->sumAmountPaid(), 0, '.', ',') }}₫

                            </td>

                            <td>
                                {{ number_format($refundRequest->orderItem->orders->getTotal() - $refundRequest->orderItem->orders->sumAmountPaid(), 0, '.', ',') }}₫
                            </td>
                                
                         </tr>
                    </tbody>
                </table>
                </div>
            </div>
            @php
                $courseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id);
            @endphp
            @if($courseStudents->count() > 0)
            <h2 class="text-info text-nowrap  mb-5 ">
                Lớp học
            </h2>

            <div class="  col-md-12 solid mb-7">
                <div class="table-responsive" id='contract-list'>
                <table class="table table-row-bordered table-hover table-bordered">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            
                            <th class="text-nowrap text-white">Mã lớp học</th>
                            <th class="text-nowrap text-white">Tên chủ nhiệm</th>
                            <th class="text-nowrap text-white">Tổng giờ</th>
                            <th class="text-nowrap text-white">Đã học</th>
                            <th class="text-nowrap text-white">Hoàn phí</th>
                            <th class="text-nowrap text-white">Còn lại</th>
                        </tr>
                    </thead>
                    <tbody>
                    
                    @foreach($courseStudents as $courseStudent)
                        
                    
                    <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="left" data-bs-dismiss="click"
                        class=" pe-none bg-light">
                        
                        <td>
                            {{$courseStudent->course->code}}
                        </td>
                        <td>
                            {{$courseStudent->course->teacher->name}}
                        </td>
                        <td>
                            {{number_format(\App\Models\StudentSection::calculateTotalHours($refundRequest->student_id, $courseStudent->course_id),2)}} giờ 
                        </td>
                        <td>
                            {{ number_format(\App\Models\StudentSection::calculateTotalHoursStudied($refundRequest->student_id, $courseStudent->course_id),2)}} giờ
                        </td>
                        <td>
                            {{\App\Models\StudentSection::calculateTotalHoursRefund($refundRequest->student_id, $courseStudent->course_id, $refundRequest->refund_date)}} giờ
                        </td>
                        <td>
                            {{number_format(\App\Models\StudentSection::calculateTotalHours($refundRequest->student_id, $courseStudent->course_id) - \App\Models\StudentSection::calculateTotalHoursStudied($refundRequest->student_id, $courseStudent->course_id),2)}} giờ 
                        </td>

                        {{-- @php
                         $totalCourseHours = \App\Models\StudentSection::calculateTotalHours($refundRequest->student_id, $refundRequest->course_id);
                             $totalHours = $refundRequest->courseStudent->orderItem->getTotalMinutes()/60;
                             $totalHoursStudied = \App\Models\StudentSection::calculateTotalHoursStudied($refundRequest->student_id, $refundRequest->course_id);
                             $totalHoursRemain = $totalCourseHours - $totalHoursStudied;
                             
                         @endphp
                         <td>
                             {{$totalCourseHours}} giờ
                             
                          </td>
                          <td>
                             {{$totalHoursStudied}} giờ
                          </td>
                          <td>
                             {{$totalHoursRefund}} giờ
                          </td>
                          <td>
                             {{$totalHoursRemain}} giờ                         
                         </td> --}}
                             
                         </tr>
                         @endforeach
                    </tbody>
                </table>
                </div>
            </div>
            @else

                Học viên chưa xếp lớp cho dịch vụ {{$refundRequest->orderItem->subject->name}}
            @endif

            
           
            <h2 class="text-info text-nowrap  mb-5 ">
                Giờ dạy giáo viên
            </h2>
            <div class="  col-md-12 solid mb-7">
                <div class="table-responsive" id='contract-list'>
                <table class="table table-row-bordered table-hover table-bordered">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th rowspan="3" class="text-center border text-nowrap text-white"></th>
                            <th colspan="2" class="text-center border text-nowrap text-white">Đăng kí học</th>
                            <th colspan="2" class="text-center border text-nowrap text-white">Đã học</th>
                            <th colspan="2" class="text-center border text-nowrap text-white">Còn lại</th>
                            
                            
                        </tr>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white ">Số giờ</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white">Giá trị</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white ">Số giờ</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white">Giá trị</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white ">Số giờ</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white">Giá trị</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                            data-bs-placement="left" data-bs-dismiss="click"
                            class=" pe-none bg-light">
                            <td class="bg-light-warning pe-none bg-light">
                                Giáo viên Việt Nam
                            </td> 
                            <td>
                                {{ number_format($refundRequest->orderItem->getTotalVnMinutes()/60,2) }} giờ 
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getPriceVnTeacherHour() * ($refundRequest->orderItem->getTotalVnMinutes()/60)) }} ₫
                                 
                            </td>
                            <td>
                                @php
                                $studentSection = new \App\Models\StudentSection;
                                $courseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id);
                                $totalHoursStudiedOfVnTeacher = $studentSection->calculateTotalHoursStudiedForCourseStudentsOfVnTeacher($courseStudents, $refundRequest);
                            @endphp
                            
                            {{ number_format($totalHoursStudiedOfVnTeacher, 2) }} giờ
                                 
                               
                            </td> 
                            <td>
                             
                                {{ number_format($refundRequest->orderItem->getPriceVnTeacherHour() * ($totalHoursStudiedOfVnTeacher)) }} ₫
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getTotalVnMinutes()/60 - $totalHoursStudiedOfVnTeacher,2) }} giờ 
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getPriceVnTeacherHour() * ($refundRequest->orderItem->getTotalVnMinutes()/60 - $totalHoursStudiedOfVnTeacher)) }} ₫
                            </td>
                          
                        </tr>
                        <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                            data-bs-placement="left" data-bs-dismiss="click"
                            class=" pe-none bg-light">
                            <td class="bg-light-warning pe-none bg-light">
                                Giáo viên nước ngoài
                            </td> 
                            <td>
                                {{ number_format($refundRequest->orderItem->getTotalForeignMinutes()/60,2)}} giờ
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getPriceForeignTeacherHour() * ($refundRequest->orderItem->getTotalForeignMinutes()/60)) }} ₫
                            </td>
                            <td>
                                @php
                                $studentSection = new \App\Models\StudentSection;
                                $courseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id);
                                $totalHoursStudiedOfForeignTeacher = $studentSection->calculateTotalHoursStudiedForCourseStudentsOfForeignTeacher($courseStudents, $refundRequest);
                            @endphp

                            {{ number_format($totalHoursStudiedOfForeignTeacher, 2) }} giờ
                               
                                
                            </td> 
                            <td>
                                {{ number_format($refundRequest->orderItem->getPriceForeignTeacherHour() * ($totalHoursStudiedOfForeignTeacher)) }} ₫
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getTotalForeignMinutes()/60 - $totalHoursStudiedOfForeignTeacher,2)}} giờ
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getPriceForeignTeacherHour() * ($refundRequest->orderItem->getTotalForeignMinutes()/60 - $totalHoursStudiedOfForeignTeacher)) }} ₫
                            </td>
                          
                        </tr>
                        <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                            data-bs-placement="left" data-bs-dismiss="click"
                            class=" pe-none bg-light">
                            <td class="bg-light-warning pe-none bg-light">
                                Gia sư
                            </td> 
                            <td>
                                {{ number_format($refundRequest->orderItem->getTotalTutorMinutes()/60,2)}} giờ
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getPriceTutorHour() * ($refundRequest->orderItem->getTotalTutorMinutes()/60)) }} ₫
                            </td>
                            <td>
                                @php
                                $studentSection = new \App\Models\StudentSection;
                                $courseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id);
                                $totalHoursStudiedOfTutor = $studentSection->calculateTotalHoursStudiedForCourseStudentsOfTutor($courseStudents, $refundRequest);
                            @endphp

                            {{ number_format($totalHoursStudiedOfTutor, 2) }} giờ

                            </td> 
                            <td>
                                {{ number_format($refundRequest->orderItem->getPriceTutorHour() * ($totalHoursStudiedOfTutor)) }} ₫
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getTotalTutorMinutes()/60 - $totalHoursStudiedOfTutor,2)}} giờ
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getPriceTutorHour() * ($refundRequest->orderItem->getTotalTutorMinutes()/60 - $totalHoursStudiedOfTutor)) }} ₫
                            </td>
                        </tr>
                        <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                            data-bs-placement="left" data-bs-dismiss="click"
                            class=" pe-none bg-light">
                            <td class="bg-light-warning pe-none bg-light">
                               Tổng cộng
                            </td> 
                            <td>
                                {{ number_format($refundRequest->orderItem->getTotalMinutes()/60,2)}} giờ
                            </td>
                            <td>
                                {{ App\Helpers\Functions::formatNumber($refundRequest->orderItem->getTotalPriceOfEdu()) }}₫
                            </td>
                            <td>
                                @php
                                $groupedCourseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id)
                                        ->groupBy('subject_id');
                                @endphp
                    
                                @php
                                    $subjectTotalHoursStudied = 0; 
                                @endphp
                    
                                @if ($groupedCourseStudents->count() > 0)
                                    @foreach ($groupedCourseStudents as $subjectId => $group)
                                        @php
                                            $subjectTotalHoursStudied += $group->sum(function ($courseStudent) use ($refundRequest) {
                                                return \App\Models\StudentSection::calculateTotalHoursStudied($refundRequest->student_id, $courseStudent->course_id);
                                            });
                                        @endphp
                                        {{ number_format($subjectTotalHoursStudied,2) }} giờ
                                    @endforeach
                                @else
                                    0 giờ
                                @endif
                            
                            
                            </td> 
                            <td>
                                {{ number_format(
                                    $refundRequest->orderItem->getPriceTutorHour() * $totalHoursStudiedOfTutor +
                                    $refundRequest->orderItem->getPriceForeignTeacherHour() * $totalHoursStudiedOfForeignTeacher +
                                    $refundRequest->orderItem->getPriceVnTeacherHour() * $totalHoursStudiedOfVnTeacher
                                ) }} ₫
                                
                            </td>
                            <td>
                                {{ number_format($refundRequest->orderItem->getTotalMinutes()/60 - $subjectTotalHoursStudied, 2) }} giờ 
                            </td>
                            <td>
                                {{ number_format(
                                    $refundRequest->orderItem->getPriceVnTeacherHour() * ($refundRequest->orderItem->getTotalVnMinutes() / 60 - $totalHoursStudiedOfVnTeacher) +
                                    $refundRequest->orderItem->getPriceForeignTeacherHour() * ($refundRequest->orderItem->getTotalForeignMinutes() / 60 - $totalHoursStudiedOfForeignTeacher) +
                                    $refundRequest->orderItem->getPriceTutorHour() * ($refundRequest->orderItem->getTotalTutorMinutes() / 60 - $totalHoursStudiedOfTutor)
                                ) }} ₫
                                
                            </td>
                          
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <h2 class="text-info text-nowrap mt-10  mb-5 ">
                Dịch vụ liên quan
            </h2>

            <div class="  col-md-12 solid mb-7">
                <div class="table-responsive" id='contract-list'>
                <table class="table table-row-bordered table-hover table-bordered">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th class="border px-5 text-nowrap text-white" rowspan="3">Mã hợp đồng</th>
                            <th class="border px-5 min-w-100px text-nowrap text-white" rowspan="3">Chủ nhiệm</th>
                            <th class="border px-5 text-nowrap text-white" rowspan="3">Dịch vụ</th>
                            <th class="border px-5 text-nowrap text-white" rowspan="3">Trình độ </th>
                            
                            
                        </tr>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th colspan="2" class="text-center border text-nowrap text-white">Đăng kí học</th>
                            <th colspan="2" class="text-center border text-nowrap text-white">Đã học</th>
                            <th colspan="2" class="text-center border text-nowrap text-white">Còn lại</th>
                            <th rowspan="3" class="border px-5 min-w-100px text-white" >Lý do hoàn phí</th>
                            
                        </tr>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white ">Số giờ</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white">Giá trị</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white ">Số giờ</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white">Giá trị</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white ">Số giờ</th>
                            <th class="border ps-5 min-w-100px w-auto fw-bold text-nowrap text-white">Giá trị</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                        <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="left" data-bs-dismiss="click"
                        class=" pe-none bg-light">
                        <td>
                            {{$refundRequest->orderItem->orders->code}}
                        </td>
                       
                        <td>
                            {{$refundRequest->orderItem->getHomeRoomName()}}
                        </td>
                        <td>
                           {{ $refundRequest->orderItem->subject->name }}
                        </td>
                        <td>
                            {{ $refundRequest->orderItem->level }}
                         </td>
                        <td>
                            {{ number_format($refundRequest->orderItem->getTotalMinutes()/60, 2) }} giờ
                        </td>
                            
                        <td>
                            {{ App\Helpers\Functions::formatNumber($refundRequest->orderItem->getTotalPriceOfEdu()) }}₫
                            
                        </td>
                         
                        <td>
                            @php
                                $groupedCourseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id)
                                    ->groupBy('subject_id');
                            @endphp
                
                            @php
                                $subjectTotalHoursStudied = 0; 
                            @endphp
                
                            @if ($groupedCourseStudents->count() > 0)
                                @foreach ($groupedCourseStudents as $subjectId => $group)
                                    @php
                                        $subjectTotalHoursStudied += $group->sum(function ($courseStudent) use ($refundRequest) {
                                            return \App\Models\StudentSection::calculateTotalHoursStudied($refundRequest->student_id, $courseStudent->course_id);
                                        });
                                    @endphp
                                    {{ $subjectTotalHoursStudied }} giờ
                                @endforeach
                            @else
                                0 giờ
                            @endif
                            
                        
                        </td>
                        <td>
                            {{ number_format(
                                $refundRequest->orderItem->getPriceTutorHour() * $totalHoursStudiedOfTutor +
                                $refundRequest->orderItem->getPriceForeignTeacherHour() * $totalHoursStudiedOfForeignTeacher +
                                $refundRequest->orderItem->getPriceVnTeacherHour() * $totalHoursStudiedOfVnTeacher
                            ) }} ₫
                            
                        </td>
                        
                        
                        <td>
                            {{ number_format($refundRequest->orderItem->getTotalMinutes()/60 - $subjectTotalHoursStudied,2) }} giờ
                        </td>
                          
                        <td>
                            {{ number_format(
                                $refundRequest->orderItem->getPriceVnTeacherHour() * ($refundRequest->orderItem->getTotalVnMinutes() / 60 - $totalHoursStudiedOfVnTeacher) +
                                $refundRequest->orderItem->getPriceForeignTeacherHour() * ($refundRequest->orderItem->getTotalForeignMinutes() / 60 - $totalHoursStudiedOfForeignTeacher) +
                                $refundRequest->orderItem->getPriceTutorHour() * ($refundRequest->orderItem->getTotalTutorMinutes() / 60 - $totalHoursStudiedOfTutor)
                            ) }} ₫
                            
                        </td>
                        <td>
                            {{$refundRequest->reason}}
                        </td>
                            
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <div data-control="contact-selector" class="d-flex align-items-end mb-7" style="width:100%">
                <div style="width:100%">
                    <label class=" fs-6 fw-semibold mb-2">
                        <span class="">Chi từ tài khoản</span>
                    </label>
                    <select id="payment-account-select"  class="form-select form-control" data-placeholder="Chọn tài khoản"
                        data-allow-clear="true" name="payment_account_id" data-control='select2' disabled>
                        <option value="">Chọn tài khoản</option>
                        @foreach($paymentAccounts as $paymentAccount)
                            <option value="{{ $paymentAccount->id }}" >
                                {{$paymentAccount->bank}} - {{$paymentAccount->account_number}} - {{$paymentAccount->account_name}}
                            </option>
                        @endforeach

                    </select>
                    <x-input-error :messages="$errors->get('payment_account_id')" class="mt-2" />

                </div>
                
            </div>


            <div class="row">
                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Ngày yêu cầu hoàn phí</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="" placeholder="=asas" type="date"
                                    class="form-control" placeholder="" value="{{$refundRequest->refund_date}}" disabled
                                     />
                                <span data-control="clear" class="material-symbols-rounded clear-button d-none"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Ngày hoàn phí</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="payment_date" placeholder="=asas" type="date"
                                    class="form-control" placeholder="" value="{{ date('Y-m-d') }}" disabled/>
                                 <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                            <x-input-error :messages="$errors->get('payment_date')" class="mt-2" />
                        </div>
                    </div>
                </div>

                <div class="col-md-12">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2">
                            <span class="">Số tiền</span>
                        </label>

                        <input type="text" class="form-control" name="amount" id="amount-input"
                        value="{{ App\Models\PaymentRecord::getAmountForRefundRequest($refundRequest->order_item_id, $refundRequest->student_id) ?? '' }}"
                        placeholder="Số tiền" disabled/>
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                </div>

            </div>

            <div class="fv-row mb-7">
                <!--begin::Label-->
                <label class="fs-6 fw-semibold mb-2">
                    <span class="">Nội dung ghi chú</span>
                </label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea class="form-control" name="description" placeholder="Nhập nội dung ghi chú mới!" rows="5"
                    cols="40" disabled></textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </div>
            <!--end::Input group-->

        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button data-action="under-construction" id="ApprovedAndCreateReceipt" 
                type="submit" class="btn btn-primary me-3 d-none">
                
                <span class="indicator-label">Duyệt và Tạo phiếu chi</span>

                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>

            <a data-action="under-construction" row-action="reject" 
                id="buttonReject" class="btn btn-info me-3 d-none "> 
                <span class="mx-2">
                    Không duyệt
                </span>
            </a>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
        
        $(document).ready(function() {
            
            $("#amount-input").on("input", function() {
            if (/^0/.test(this.value)) {
                this.value = this.value.replace(/^0/, "")
            }
            })

            UpdatePopup.init();

            
            Reject.init();

            ApprovedAndCreateReceipt.init();
        });

        var UpdatePopup = function() {
            var updatePopup;

            return {
                init: () => {
                    updatePopup = new Popup();
                },
                updateUrl: newUrl => {
                    updatePopup.url = newUrl;
                    updatePopup.load();
                },
                getUpdatePopup: () => {
                    return updatePopup;
                }
            }
        }();
        var Reject = function() {
            return {
                init: function() {
                    document.querySelector('#buttonReject').addEventListener('click', e => {
                        e.preventDefault();
                        UpdatePopup.updateUrl(
                            "{{ action('\App\Http\Controllers\Accounting\RefundRequestController@rejectRefundRequest', ['id' => $refundRequest->id]) }}"
                        );
                    });

                }
            }
        }();


       

        var ApprovedAndCreateReceipt = function() {
            let form;
            let submitBtn;

            const handleFormSubmit = () => {

                form.addEventListener('submit', e => {

                    e.preventDefault();

                    submit();
                })
            }

            submit = () => {
                const formData = $(form).serialize();

                $.ajax({
                    url: "{{ action([App\Http\Controllers\Accounting\RefundRequestController::class, 'saveRefund'], ['id' => $refundRequest->id]) }}",
                    method: 'POST',
                    data: formData
                }).done(response => {
                    UpdateRequestPopup.getUpdatePopup().hide();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            RefundRequestList.getList().load();
                        }
                    });

                }).fail(message => {
                    UpdateRequestPopup.getUpdatePopup().setContent(message.responseText);
                    removeSubmitEffect();
                })
            }

            addSubmitEffect = () => {

                // btn effect
                submitBtn.setAttribute('data-kt-indicator', 'on');
                submitBtn.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {

                // btn effect
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.removeAttribute('disabled');
            }

            
            return {
                init: () => {

                    form = document.getElementById('{{ $formId }}');
                    submitBtn = document.querySelector("#ApprovedAndCreateReceipt");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
