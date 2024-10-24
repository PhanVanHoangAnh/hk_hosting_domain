
@if (!empty($updated_at_from) && !empty($updated_at_to))
    <div class="card-body pt-0 mt-5">
        <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

            <table id="kt_datatable_complex_header" class="table align-middle border fs-6 ">
                <thead>
                    <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                        <th class="border px-5" rowspan="3">STT</th>
                        <th class="border px-5 d-none" rowspan="3">Ngày</th>
                        <th class="border px-5" rowspan="3">Mã học viên</th>
                        <th class="border px-5" rowspan="3">Mã cũ học viên</th>
                        <th class="border min-w-200px px-5" rowspan="3">Tên học viên</th>
                        <th class="border px-5" rowspan="3">Môn học</th>
                        <th class="border px-5" rowspan="3">Lớp</th>
                        <th class="border px-5" rowspan="3">Trình độ</th>
                        <th class="border px-5" rowspan="3">Loại hình giáo viên</th>
                        <th class="border px-5" rowspan="3">Số giờ khoá học</th>
                        <th class="border px-5" rowspan="3">Giá trị</th>
                        <th class="border px-5" rowspan="3">Số giờ đã học luỹ kế</th>
                        <th class="border px-5" rowspan="3">Giá trị</th>
                        <th class="border px-5" rowspan="3">Số giờ đầu kỳ</th>
                        <th class="border px-5" rowspan="3">Giá trị</th>
                        <th class="border px-5" rowspan="3">Số giờ đã học trong kỳ</th>
                        <th class="border px-5" rowspan="3">Giá trị</th>
                        <th class="border min-w-150px px-5" rowspan="3">Cuối kỳ </th>
                        <th class="border min-w-100px px-5" rowspan="3">Giá trị</th>

                    </tr>

                </thead>
                <tbody>
                    @foreach($orderItems as $orderItem)
                        @php
                            
                            //Khóa học
                            $totalKhoaHoc = $orderItem->calculateTotalHoursStudiedForOrderItem($updated_at_from)['sum_minutes'];
                            $hoursTotalKhoaHoc = floor($totalKhoaHoc / 60);
                            $minutesTotalKhoaHoc = $totalKhoaHoc % 60;

                            $totalKhoaHocOfForeign = $orderItem->calculateTotalHoursStudiedForOrderItem($updated_at_from)['foreign_teacher_minutes'];
                            $hourKhoaHocOfForeignTeacher = floor($totalKhoaHocOfForeign / 60);
                            $minutesKhoaHocOfForeignTeacher = $totalKhoaHocOfForeign % 60;
                           
                            $totalKhoaHocOfVNTeacher = $orderItem->calculateTotalHoursStudiedForOrderItem($updated_at_from)['vn_teacher_minutes'];
                            $hourKhoaHocOfVNTeacher = floor($totalKhoaHocOfVNTeacher / 60);
                            $minutesKhoaHocOfVNTeacher = $totalKhoaHocOfVNTeacher % 60;

                            $totalKhoaHocOfTutor = $orderItem->calculateTotalHoursStudiedForOrderItem($updated_at_from)['tutor_minutes'];
                            $hourKhoaHocOfTutor = floor($totalKhoaHocOfTutor / 60);
                            $minutesKhoaHocOfTutor = $totalKhoaHocOfTutor % 60;


                            //Lũy kế
                            $totaLuyKe = $orderItem->calculateTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)['sum_minutes'];
                            $hourTotalLuyKe = floor($totaLuyKe / 60);
                            $minutesTotalLuyKe = $totaLuyKe % 60;

                            $vnTeacherLuyKe = $orderItem->calculateTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)['vn_teacher_minutes'];
                            $hourVnLuyKe = floor($vnTeacherLuyKe / 60);
                            $minutesVnLuyKe =  $vnTeacherLuyKe % 60;

                            $foreignTeacherLuyKe = $orderItem->calculateTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)['foreign_teacher_minutes'];
                            $hourForeignLuyKe = floor($foreignTeacherLuyKe / 60);
                            $minutesForeignLuyKe = $foreignTeacherLuyKe % 60;

                            $tutorLuyKe = $orderItem->calculateTotalHoursStudiedByLuyKeForOrderItem($updated_at_to)['tutor_minutes'];
                            $hourTutorLuyKe = floor($tutorLuyKe / 60);
                            $minutesTutorLuyKe = $tutorLuyKe % 60;

                            // Đầu kỳ
                            $totaDauKy = $orderItem->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_to)['sum_minutes'];
                            $hourTotalDauKy = floor($totaDauKy / 60);
                            $minutesTotalDauKy = $totaDauKy % 60;

                            $vnTeacherDauKy = $orderItem->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_to)['vn_teacher_minutes'];
                            $hourVnDauKy = floor($vnTeacherDauKy / 60);
                            $minutesVnDauKy =  $vnTeacherDauKy % 60;

                            $foreignTeacherDauKy = $orderItem->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_to)['foreign_teacher_minutes'];
                            $hourForeignDauKy = floor($foreignTeacherDauKy / 60);
                            $minutesForeignDauKy = $foreignTeacherDauKy % 60;

                            $tutorDauKy = $orderItem->calculateTotalHoursStudiedByDauKyForOrderItem($updated_at_to)['tutor_minutes'];
                            $hourTutorDauKy = floor($tutorDauKy / 60);
                            $minutesTutorDauKy = $tutorDauKy % 60;


                             // Trong kỳ
                            $totaTrongKy = $orderItem->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['sum_minutes'];
                            $hourTotalTrongKy = floor($totaTrongKy / 60);
                            $minutesTotalTrongKy = $totaTrongKy % 60;

                            $vnTeacherTrongKy = $orderItem->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['vn_teacher_minutes'];
                            $hourVnTrongKy = floor($vnTeacherTrongKy / 60);
                            $minutesVnTrongKy =  $vnTeacherTrongKy % 60;

                            $foreignTeacherTrongKy = $orderItem->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['foreign_teacher_minutes'];
                            $hourForeignTrongKy = floor($foreignTeacherTrongKy / 60);
                            $minutesForeignTrongKy = $foreignTeacherTrongKy % 60;

                            $tutorTrongKy = $orderItem->calculateTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)['tutor_minutes'];
                            $hourTutorTrongKy = floor($tutorTrongKy / 60);
                            $minutesTutorTrongKy = $tutorTrongKy % 60;

                            // Cuối kỳ
                            $totalHoursCuoiKy= $totaDauKy - $totaTrongKy;
                            $hourTotalCuoiKy= floor($totalHoursCuoiKy/ 60);
                            $minutesTotalCuoiKy= $totalHoursCuoiKy % 60;

                            $vnHoursCuoiKy= $vnTeacherDauKy - $vnTeacherTrongKy;
                            $hourVnCuoiKy= floor($vnHoursCuoiKy/ 60);
                            $minutesVnCuoiKy= $vnHoursCuoiKy % 60;

                            $foreignHoursCuoiKy= $foreignTeacherDauKy - $foreignTeacherTrongKy;
                            $hourForeignCuoiKy= floor($foreignHoursCuoiKy/ 60);
                            $minutesForeignCuoiKy= $foreignHoursCuoiKy % 60;

                            $tutorHoursCuoiKy= $tutorDauKy - $tutorTrongKy;
                            $hourTutorCuoiKy= floor($tutorHoursCuoiKy/ 60);
                            $minutesTutorCuoiKy= $tutorHoursCuoiKy % 60;
                            
                        @endphp
                        <tr class="border" list-control="item">
                            <td rowspan="4" class="px-5 ">{{ ($orderItems->currentPage() - 1) * $orderItems->perPage() + $loop->iteration }}</td>
                            <td rowspan="4" class="px-5 d-none">Đang cập nhật</td>
                            <td rowspan="4" class="px-5 ">{{$orderItem->orders->contacts->code}}</td>
                            <td rowspan="4" class="px-5 ">{{$orderItem->orders->contacts->import_id}}</td>
                            <td rowspan="4" class="px-5 ">
                                <a row-action="detail-student" title="Click vào tên học viên xem chi tiết" data-bs-toggle="tooltip"
                                    href="{{ action([App\Http\Controllers\Accounting\Report\StudentHourReportController::class, 'listDetailStudent'],
                                    [
                                        'id' => $orderItem->id,
                                    ]) }}">
                                    {{ $orderItem->orders->student->name }}
                                </a>

                            </td> 
                            <td rowspan="4" class="px-5 "> {{$orderItem->subject->name}}</td>
                            {{-- <td rowspan="4" class="px-5 "> {{$orderItem->courseStudent->course->code}}</td> --}}
                            {{-- <td rowspan="4" class="px-5 "> {{ optional($orderItem->courseStudent)->course->code ?? 'Chưa xếp lớp' }}</td> --}}
                            <td rowspan="4" class="px-5 ">
                                @php
                                    $courseList = $orderItem->courseList();
                                @endphp

                                @if ($courseList->isNotEmpty())
                                    @foreach ($courseList as $course)
                                        {{ $course->code }} <br>
                                    @endforeach
                                @else
                                    Chưa xếp lớp
                                @endif
                            </td>
                            <td rowspan="4" class="px-5 "> {{$orderItem->level}}</td>
                            <td class="px-5 ">Tổng</td>
                        
                                
                            <td class="px-5 "> 
                                {{ $hoursTotalKhoaHoc }} giờ {{ $minutesTotalKhoaHoc }} phút
                               </td>
                        
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedForOrderItem($updated_at_from)) }}₫ </td>
                            <td class="px-5 ">{{ $hourTotalLuyKe }} giờ {{ $minutesTotalLuyKe }} phút </td>
                            <td class="px-5 ">  {{App\Helpers\Functions::formatNumber($orderItem-> calculatePriceTotalHoursStudiedByLuyKeForOrderItem( $updated_at_to))}}₫ </td>
                            
                            <td class="px-5 "> {{ $hourTotalDauKy }} giờ {{ $minutesTotalDauKy }} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedByDauKyForOrderItem($updated_at_from)) }}₫</td>
                           

                            <td class="px-5 "> {{ $hourTotalTrongKy}} giờ {{ $minutesTotalTrongKy}} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedByTrongKyForOrderItem($updated_at_from, $updated_at_to)) }}₫</td>
                            
                            <td class="px-5 "> {{ $hourTotalCuoiKy}} giờ {{ $minutesTotalCuoiKy}} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedByCuoiKyForOrderItem($updated_at_from, $updated_at_to)) }}₫</td>
                        </tr>

                        <tr class="border" list-control="item">
                            <td class="px-5 ">Giáo viên nước ngoài</td>
                            <td class="px-5 "> {{ $hourKhoaHocOfForeignTeacher }} giờ {{ $minutesKhoaHocOfForeignTeacher }} phút</td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfForeignTeacherForOrderItem($updated_at_from)) }}₫ </td>
                            <td class="px-5 ">{{ $hourForeignLuyKe }} giờ {{ $minutesForeignLuyKe }} phút </td>
                            <td class="px-5 ">  {{App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfForeignTeacherByLuyKeForOrderItem( $updated_at_to))}}₫ </td>
                        
                            <td class="px-5 "> {{ $hourForeignDauKy }} giờ {{ $minutesForeignDauKy }} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfForeignTeacherByDauKyForOrderItem($updated_at_from)) }}₫</td>
                            <td class="px-5 "> {{ $hourForeignTrongKy}} giờ {{ $minutesForeignTrongKy}} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfForeignTeacherByTrongKyForOrderItem($updated_at_from, $updated_at_to)) }}₫</td>
                            <td class="px-5 "> {{ $hourForeignCuoiKy}} giờ {{ $minutesForeignCuoiKy}} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfForeignTeacherByCuoiKyForOrderItem($updated_at_from, $updated_at_to)) }}₫</td>
                        </tr>
                        <tr class="border" list-control="item">
                            <td class="px-5 ">Gia sư</td>
                            <td class="px-5 ">{{ $hourKhoaHocOfTutor }} giờ {{ $minutesKhoaHocOfTutor }} phút</td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfTutorForOrderItem($updated_at_from)) }}₫ </td>
                            <td class="px-5 ">{{ $hourTutorLuyKe }} giờ {{ $minutesTutorLuyKe }} phút </td>
                            <td class="px-5 ">  {{App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfTutorByLuyKeForOrderItem( $updated_at_to))}}₫ </td>

                            <td class="px-5 "> {{ $hourTutorDauKy }} giờ {{ $minutesTutorDauKy }} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfTutorByDauKyForOrderItem($updated_at_from)) }}₫</td>
                            <td class="px-5 "> {{ $hourTutorTrongKy}} giờ {{ $minutesTutorTrongKy}} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfTutorByTrongKyForOrderItem( $updated_at_from, $updated_at_to)) }}₫</td>
                            <td class="px-5 "> {{ $hourTutorCuoiKy}} giờ {{ $minutesTutorCuoiKy}} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfTutorByCuoiKyForOrderItem( $updated_at_from, $updated_at_to)) }}₫</td>
                        </tr>
                        <tr class="border" list-control="item">
                            <td class="px-5 ">Giáo viên Việt Nam</td>
                            <td class="px-5 "> {{ $hourKhoaHocOfVNTeacher }} giờ {{ $minutesKhoaHocOfVNTeacher }} phút</td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfVNTeacherForOrderItem($updated_at_from)) }}₫ </td>
                            <td class="px-5 ">{{ $hourVnLuyKe }} giờ {{ $minutesVnLuyKe }} phút</td>
                            <td class="px-5 ">  {{App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfVNTeacherByLuyKeForOrderItem( $updated_at_to))}}₫ </td>
                            <td class="px-5 "> {{ $hourVnDauKy }} giờ {{ $minutesVnDauKy }} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfVNTeacherByDauKyForOrderItem($updated_at_from)) }}₫</td>
                            <td class="px-5 "> {{ $hourVnTrongKy}} giờ {{ $minutesVnTrongKy}} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfVNTeacherByTrongKyForOrderItem($updated_at_from, $updated_at_to)) }}₫</td>
                            <td class="px-5 "> {{ $hourVnCuoiKy}} giờ {{ $minutesVnCuoiKy}} phút </td>
                            <td class="px-5 ">{{ App\Helpers\Functions::formatNumber($orderItem->calculatePriceTotalHoursStudiedOfVNTeacherByCuoiKyForOrderItem($updated_at_from, $updated_at_to)) }}₫</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
        <div class="mt-5">
            {{ $orderItems->links() }}
        </div>
    </div>
@else
    <p class="fs-4 text-center mb-5 text-danger mt-10">
        Vui lòng chọn ngày bắt đầu và kết thúc
    </p>
@endif