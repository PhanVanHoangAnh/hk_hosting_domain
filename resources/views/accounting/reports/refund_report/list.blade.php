<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

        <table id="kt_datatable_complex_header" class="table align-middle border  fs-6 table-striped ">
            <thead>
                <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                    <th class="border ps-5">STT</th>
                    <th class="border ps-5">Mã học viên</th>
                    <th class="border ps-5">Mã cũ học viên</th>
                    <th class="border min-w-250px  ps-5">Tên học viên</th>
                    <th class="border min-w-250px  ps-5">Tên Sale</th>
                    <th class="border min-w-250px  ps-5">Tên dịch vụ</th>
                    <th class="border min-w-250px  ps-5">Tên Chủ nhiệm</th>
                    <th class="border ps-5">Tổng số giờ </th>
                    <th class="border ps-5">Tổng giá trị </th>
                    <th class="border ps-5">Tổng số giờ đã học</th>
                    <th class="border ps-5">Tổng giá trị đã thực hiện</th>
                    <th class="border ps-5">Tổng số giờ chưa thực hiện </th>

                    <th class="border ps-5">Tổng giá trị chưa thực hiện</th>
                    <th class="border ps-5">Tổng giá trị hoàn phí</th>
                    <th class="border min-w-250px ps-5">Diễn giải</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($refundRequests as $refundRequest)
                    <tr class="border" list-control="item">
                        <td class="ps-5 ">
                            {{ ($refundRequests->currentPage() - 1) * $refundRequests->perPage() + $loop->iteration }}
                        </td>
                        <td class="ps-5 ">{{ $refundRequest->student->code }}</td>
                        <td class="ps-5 ">{{ $refundRequest->student->import_id }}</td>
                        {{-- <td class="ps-5 ">{{$refundRequest->student->name}}</td> --}}
                        <td class="ps-5">
                            <a row-action="detail-refund" title="Click vào tên học viên xem chi tiết hợp đồng"
                                data-bs-toggle="tooltip"
                                href="{{ action(
                                    [App\Http\Controllers\Accounting\Report\RefundReportController::class, 'showRequest'],
                                    [
                                        'id' => $refundRequest->id,
                                    ],
                                ) }}">{{ $refundRequest->student->name }}</a>
                        </td>
                        <td class="ps-5 ">{{ $refundRequest->orderItem->orders->salesperson->name }}</td>
                        <td class="ps-5 ">{{ $refundRequest->orderItem->subject->name }}</td>
                        <td class="ps-5 ">{{$refundRequest->orderItem->getHomeRoomName()}}</td>
                        <td class="ps-5 ">{{ number_format($refundRequest->orderItem->getTotalMinutes() / 60, 2) }} giờ
                        </td>
                        <td class="ps-5 ">
                            {{ App\Helpers\Functions::formatNumber($refundRequest->orderItem->getTotalPriceOfEdu()) }}₫</td>
                        <td class="ps-5 ">
                            @php
                                $groupedCourseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id)->groupBy('subject_id');
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
                                    {{ number_format($subjectTotalHoursStudied, 2) }} giờ
                                @endforeach
                            @else
                                0 giờ
                            @endif
                        </td>
                        <td class="ps-5 ">{{ $refundRequest->calculateTotalStudiedAmount() }}₫</td>
                        <td class="ps-5 ">
                            @php
                                $courseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($refundRequest->order_item_id, $refundRequest->student_id);
                            @endphp
                            @if ($courseStudents->count() > 0)
                                @foreach ($courseStudents as $courseStudent)
                                    @php
                                        $totalHoursRefund = \App\Models\StudentSection::calculateTotalHoursRefund($refundRequest->student_id, $courseStudent->course_id, $refundRequest->refund_date);
                                    @endphp
                                    <div>{{ $totalHoursRefund }} giờ</div>
                                @endforeach
                            @else
                                <div> {{ number_format($refundRequest->orderItem->getTotalMinutes() / 60, 2) }} giờ</div>
                            @endif
                        </td>
                       
                        <td class="ps-5 "> 
                            @php
                                $totalValueImplemented = App\Models\PaymentRecord::getAmountForRefundRequest($refundRequest->order_item_id, $refundRequest->student_id) ?? 0;
                                $totalValueNotImplemented = $refundRequest->orderItem->getTotalPriceOfEdu() - $totalValueImplemented;
                            @endphp
                            {{ number_format($totalValueNotImplemented) }}₫</td>
                        <td class="ps-5 ">
                            {{ number_format(App\Models\PaymentRecord::getAmountForRefundRequest($refundRequest->order_item_id, $refundRequest->student_id) ?? 0) }}₫
                        </td>

                        <td class="ps-5 ">{{$refundRequest->reason}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-5">
        {{ $refundRequests->links() }}
    </div>
</div>
