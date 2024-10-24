<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

        <table id="kt_datatable_complex_header" class="table align-middle border  fs-6 table-striped ">
            <thead>
                <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                    <th class="border ps-5">STT</th>
                    <th class="border ps-5">Ngày</th>
                    <th class="border ps-5">Mã học viên</th>
                    <th class="border ps-5">Mã cũ học viên</th>
                    <th class="border ps-5">Tên học viên</th>
                    <th class="border ps-5">Tên Sale</th>
                    <th class="border ps-5">Số phiếu request demo</th>
                    <th class="border ps-5">Tên lớp demo</th>
                    <th class="border ps-5">Số giờ demo</th>
                    <th class="border ps-5">Hình thức học</th>
                    <th class="border min-w-100px ps-5">Trạng thái</th>
                    <th class="border min-w-200px ps-5">Môn học</th>
                    <th class="border ps-5">Tên giáo viên</th>
                    <th class="border ps-5">Chi phí lương giáo viên</th>
                    <th class="border ps-5">Ngày bắt đầu</th>
                    <th class="border ps-5">Ngày kết thúc</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classes as $class)
                    <tr class="border" list-control="item">
                        <td class="ps-5">{{ ($classes->currentPage() - 1) * $classes->perPage() + $loop->iteration }}
                        </td>
                        <td class="ps-5">
                            {{ \Carbon\Carbon::parse($class->orders->order_date)->format('d/m/Y') }}
                        </td>
                        <td class="ps-5 ">{{ $class->order->contacts->code }}</td>
                        <td class="ps-5 ">{{ $class->order->contacts->import_id }}</td>
                        <td class="ps-5">{{ $class->order->contacts->name }}</td>
                        <td class="ps-5">{{ $class->orders->salesperson->name }}</td>
                        <td class="ps-5">{{ $class->orders->code }}</td>
                        <td class="ps-5">
                            @php
                                $courseList = $class->courseList();
                            @endphp

                            @forelse ($courseList as $course)
                                {{ $course->code }} <br>
                            @empty
                                --
                            @endforelse

                        </td>
                        <td class="ps-5">{{ $class->getTotalMinutes() / 60 }} giờ</td>
                        <td class="ps-5"> {{ trans('messages.courses.class_type.' . $class->class_type) }}</td>
                        <td class="ps-5"> {{ $class->getStatus() }}</td>
                        <td class="ps-5"> {{ $class->subject->name ?? 'N/A' }}</td>
                        <td class="ps-5">
                            @forelse ($courseList as $course)
                                {{ $course->teacher->name }} <br>
                            @empty
                                --
                            @endforelse
                        </td>
                        <td class="ps-5">{{ number_format($class->caculateTotalStaffExpenses(), 0, '.', '.') }} đ</td>
                        <td class="ps-5">
                            @forelse ($courseList as $course)
                                @php
                                    $studentSections = \App\Models\OrderItem::startAtForCourse($class->getStudent()->id, $course->id);
                                @endphp
                                <div>{{ $studentSections ?? '--' }}</div>
                            @empty
                                --
                            @endforelse
                        </td>

                        <td class="ps-5">
                            @forelse ($courseList as $course)
                                @php
                                    $studentSections = \App\Models\StudentSection::endAtForCourse($class->getStudent()->id, $course->id);
                                @endphp
                                <div>{{ $studentSections ?? '--' }}</div>
                            @empty
                                --
                            @endforelse
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-5">
        {{ $classes->links() }}
    </div>
</div>
