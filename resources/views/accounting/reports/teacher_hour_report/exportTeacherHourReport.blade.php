@extends('layouts.main.popup')

@section('title')
    Cấu hình dữ liệu báo cáo giờ tôn giảng viên
@endsection

@section('content')
    <form id="filterContactForm"
        action="{{ action('App\Http\Controllers\Accounting\Report\TeacherHourReportController@exportRun') }}" method="POST">
        @csrf
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
            <div class="card-header border-0 p-4  list-filter-box pt-0 pb-0" list-action="filter-action-box">
                <!--begin::Card toolbar-->
                <div class="row card-toolbar mb-0" list-action="tool-action-box">
                    <!--begin::Toolbar-->
                    <!--begin::Content-->

                    <div class="col-md-12 mb-5">
                        <label class="form-label fw-semibold mb-1">Giảng viên</label>
                        <div class="form-outline">
                            <select list-action="teacher-filter-select" class="form-select form-control filter-select"
                            name="teacher_ids[]" data-control="select2" data-placeholder="Chọn giáo viên"
                            data-allow-clear="true">
                                {{-- <option selected value="{{ Auth::user()->account->id }}">
                                            {{ Auth::user()->account->name }}</option> --}}
                                @foreach (App\Models\Teacher::all() as $teacher)
                                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row" list-action="section_at-select">
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-semibold">Từ ngày</label>
                            <div class="form-outline">
                                <div data-control="date-with-clear-button"
                                    class="d-flex align-items-center date-with-clear-button">
                                    <input data-control="input" name="section_at_from" placeholder="=asas" type="date"
                                        class="form-control" placeholder="" />
                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                        style="display:none;">close</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <label class="form-label fw-semibold">Đến ngày</label>
                            <div class="form-outline">
                                <div data-control="date-with-clear-button"
                                    class="d-flex align-items-center date-with-clear-button">
                                    <input data-control="input" name="section_at_to" placeholder="=asas" type="date"
                                        class="form-control" placeholder="" />
                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                        style="display:none;">close</span>
                                </div>
                            </div>
                        </div>
                        <!--end::Actions-->
                    </div>
                </div>

                <!--end::Menu 1-->
                <!--end::Filter-->
            </div>
            <!--end::Toolbar-->
        </div>
        </div>
        {{-- <button  type="submit"> Xuất</button>s --}}

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="exportContactFilterButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Xuất</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $('#exportContactFilterButton').click(function(event) {
                event.preventDefault();
                exportPayrateFilter();
            });
        });

        function exportPayrateFilter() {

            // Get selected values 
            var selectedTeachers = getSelectedValuesFromMultiSelect($('[list-action="teacher-filter-select"]'));

            // Get date range values
            var sectionFrom = $('[list-action="section_at-select"] input[name="section_at_from"]')
                .val();
            var sectionTo = $('[list-action="section_at-select"] input[name="section_at_to"]').val();

            // serialize form 
            var formData = {
                _token: '{{ csrf_token() }}',
                teacherId: selectedTeachers,
                section_from: sectionFrom,
                section_to: sectionTo,
            };

            $.ajax({
                url: "{{ action('App\Http\Controllers\Accounting\Report\TeacherHourReportController@exportRun') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    // Show loading indicator
                    $('#exportContactFilterButton .indicator-label').hide();
                    $('#exportContactFilterButton .indicator-progress').show();
                },
                success: function(response) {
                    // Download the file
                    window.location =
                        "{{ action('App\Http\Controllers\Accounting\Report\TeacherHourReportController@exportDownload') }}?file=" +
                        response.file;

                    // Hide loading 
                    $('#exportContactFilterButton .indicator-label').show();
                    $('#exportContactFilterButton .indicator-progress').hide();
                },
                error: function(error) {

                    //  throw new Error('Error:', error);

                    // Hide loading 
                    $('#exportContactFilterButton .indicator-label').show();
                    $('#exportContactFilterButton .indicator-progress').hide();
                }
            });
        }

        function getSelectedValuesFromMultiSelect(selectElement) {
            var selectedValues = [];
            $(selectElement).find('option:selected').each(function() {
                var value = $(this).val().trim(); // Get the trimmed value
                if (value !== '') {
                    selectedValues.push(value);
                }
            });
            return selectedValues;
        }
    </script>
@endsection
