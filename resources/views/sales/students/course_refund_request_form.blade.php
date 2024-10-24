<div class="mb-10">
    @if ($currentCourses->count())
        <div class="form-outline mb-7">
            <div class="d-flex align-items-center">
                <label for="" class="form-label fw-semibold text-info">Học viên sẽ bị xoá ra khỏi lớp</label>
            </div>

            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">

                <table class="table table-row-bordered table-hover table-bordered table-fixed">
                    <thead>
                        <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">

                            <th class="text-nowrap text-white">Tên lớp học</th>
                            <th class="text-nowrap text-white">Môn học</th>
                            <th class="text-nowrap text-white">Tổng giờ học</th>
                            <th class="text-nowrap text-white">Đã học</th>
                            <th class="text-nowrap text-white">Còn lại</th>

                            <th class="text-nowrap text-white">Loại hình</th>

                            <th class="text-nowrap text-white">Chủ nhiệm</th>

                        </tr>
                    </thead>
                    <tbody>

                        @foreach ($currentCourses as $currentCourse)
                            <tr sdata-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-placement="left"
                                data-bs-dismiss="click" data-bs-original-title="Nhấn để chọn lớp học" class="bg-light">
                                {{-- <td>
                                    <div
                                        class="form-check form-check-sm form-check-custom d-flex justify-content-center">
                                        <input request-control="select-radio" name="current_course_id"
                                            list-action="check-item" class="form-check-input" type="checkbox"
                                            value="{{ $currentCourse->id }}" checked />
                                    </div>
                                </td> --}}

                                <td>{{ $currentCourse->code }}</td>
                                <td>{{ $currentCourse->subject->name }}</td>
                                <td>
                                    {{-- {{ $currentCourse->total_hours }}  --}}
                                    {{ number_format(\App\Models\StudentSection::calculateTotalHours($studentId, $currentCourse->id), 2) }}
                                    Giờ
                                </td>
                                <td>
                                    {{ \App\Models\StudentSection::calculateTotalHoursStudied($studentId, $currentCourse->id) }}
                                    Giờ
                                </td>
                                @php
                                    $hoursRemain = number_format(\App\Models\StudentSection::calculateTotalHours($studentId, $currentCourse->id) - \App\Models\StudentSection::calculateTotalHoursStudied($studentId, $currentCourse->id), 2);
                                @endphp

                                <td>{{ $hoursRemain }} Giờ</td>
                                <td>{{ $currentCourse->study_method }}</td>
                                <td>{{ $currentCourse->teacher->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    @else
        <div class="">
            <div class="form-outline">
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded me-2 ms-4" style="vertical-align: middle;">
                        error
                    </span>
                    <span>Chưa có lớp đang học</span>
                </span>
            </div>
        </div>
    @endif
</div>


<div class="mb-10">
    {{-- <div class="row"> --}}
    {{-- <div class="col-6"> --}}
    <div class="form-outline">
        <label class="required fs-6 fw-semibold mb-2">Chọn thời điểm yêu cầu hoàn phí</label>
        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
            <input data-control="input" value="{{ date('Y-m-d') }}" name="reserve_start_at" id="reserve_start_at"
                placeholder="=asas" type="date" class="form-control">
            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
        </div>
    </div>
    {{-- </div> --}}
    {{-- <div class="col-6"> --}}
    <!--begin::Label-->
    <label class="fs-6 fw-semibold mb-2 mt-4">
        <span class="">Lý do hoàn phí</span>
    </label>
    <!--end::Label-->
    <!--begin::Input-->
    <textarea class="form-control" name="reason" placeholder="Nhập lý do hoàn phí!" rows="5" cols="40"></textarea>
    <!--end::Input-->
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
    {{-- </div> --}}
</div>
</div>
