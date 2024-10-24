<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">

        <table id="kt_datatable_complex_header" class="table align-middle border fs-6 table-striped ">
            <thead>
                <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                    <th class="border ps-5">Mã học viên</th>
                    <th class="border ps-5">Mã cũ học viên</th>
                    <th class="border ps-5">Học viên</th>
                    <th class="border ps-5">Khóa học</th>
                    <th class="border ps-5">Lớp</th>
                    <th class="border ps-5">Số giờ của khóa</th>
                    <th class="border ps-5">Số giờ đã học</th>
                    <th class="border ps-5">Số giờ còn lại</th>
                    <th class="border ps-5">Thời gian dự kiến kết thúc khóa học</th>
                    <th class="border ps-5">Tên nhân viên sale</th>
                    <th class="border ps-5">Sale Sup</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sortedItems = $orderItems->map(function ($item) {
                        $student = \App\Models\Order::find($item->order_id)->student;
                        $orderItemId = $item->id;
                        $courseStudents = \App\Models\CourseStudent::where('student_id', $student->id)
                            ->where('order_item_id', $orderItemId)
                            ->get();
                        $total = 0;

                        foreach ($courseStudents as $i) {
                            $total += \App\Models\StudentSection::calculateTotalHoursStudied($student->id, $i->course_id);
                        }

                        $item->remain_time = $item->getTotalMinutes() / 60 - $total;

                        return $item;
                    });

                    $items = $sortedItems->sortBy('remain_time')->reverse();
                    $subjectTotalHoursStudied =0;
                @endphp
                @foreach ($orderItems as $orderItem)
                    @php
                        $conditionResult = isset($subjectTotalHoursStudied) && $orderItem->getTotalMinutes() / 60 - $subjectTotalHoursStudied < 10;
                    @endphp
                    <tr class="border {{ $conditionResult ? 'table-danger' : '' }}">
                        <td class="ps-5">{{ $orderItem->orders->contacts->code ?? 'N/A' }}</td>
                        <td class="ps-5">{{ $orderItem->orders->contacts->import_id ?? 'N/A' }}</td>
                        <td class="ps-5">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-column">
                                    <a title="Click vào đưa tới thông tin chi tiết học viên" data-bs-toggle="tooltip"
                                        href="{{ action(
                                            [App\Http\Controllers\Sales\CustomerController::class, 'show'],
                                            [
                                                'id' => $orderItem->orders->contacts->id,
                                            ],
                                        ) }}"
                                        class="mb-1 fw-bold text-nowrap">{{ $orderItem->orders->student->name }}</a>
                                </div>
                            </div>
                        </td>
                        <td class="ps-5">{{ $orderItem->subject->name ?? 'N/A' }}</td>
                        <td class="ps-5">
                            @php
                                $courseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($orderItem->id, $orderItem->orders->student_id);
                            @endphp
                            @if ($courseStudents->count() > 0)
                                @foreach ($courseStudents as $courseStudent)
                                    <div>{{ $courseStudent->course->code }}</div>
                                @endforeach
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="ps-5">{{ number_format($orderItem->getTotalMinutes() / 60, 2) }} Giờ</td>
                        <td class="ps-5">
                            @php
                                $groupedCourseStudents = \App\Models\CourseStudent::getCourseStudentsByOrderItemAndStudent($orderItem->id, $orderItem->orders->student_id)->groupBy('subject_id');
                            @endphp

                            @php
                                $subjectTotalHoursStudied = 0;
                            @endphp

                            @if ($groupedCourseStudents->count() > 0)
                                @foreach ($groupedCourseStudents as $subjectId => $group)
                                    @php
                                        $subjectTotalHoursStudied += $group->sum(function ($courseStudent) use ($orderItem) {
                                            return \App\Models\StudentSection::calculateTotalHoursStudied($orderItem->orders->student->id, $courseStudent->course_id);
                                        });
                                    @endphp
                                    {{ $subjectTotalHoursStudied }} giờ
                                @endforeach
                            @else
                                0 giờ
                            @endif
                        </td>
                        <td class="ps-5">
                            {{ number_format($orderItem->remain_time, 2) }} Giờ
                        </td>
                        <td class="ps-5">
                            @if ($courseStudents->count() > 0)
                                @php
                                    $studentSections = \App\Models\StudentSection::endAtForCourse($orderItem->orders->student->id, $courseStudent->course_id);
                                    // $studentSections = '2024-01-29 17:21';
                                @endphp
                                <div>{{ $studentSections }}</div>
                            @else
                                Chưa xếp lớp
                            @endif
                        </td>
                        <td class="ps-5">
                            {{ App\Models\Account::find($orderItem->orders->sale) ? App\Models\Account::find($orderItem->orders->sale)->name : '' }}
                        </td>
                        <td class="ps-5">
                            {{ App\Models\Account::find($orderItem->orders->sale_sup) ? App\Models\Account::find($orderItem->orders->sale_sup)->name : '' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
