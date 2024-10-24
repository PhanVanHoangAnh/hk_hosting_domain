@extends('layouts.main.popup')

@section('title')
    Cấu hình dữ liệu mức lương cần xuất
@endsection

@section('content')
<form id="filterContactRequestForm" action="{{ action('App\Http\Controllers\Sales\ContactRequestController@exportRun') }}" method="POST">
    @csrf
    <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
        <div class="card-header border-0 p-4  list-filter-box pt-0 pb-0" list-action="filter-action-box">
            <!--begin::Card toolbar-->
            <div class="row card-toolbar mb-0" list-action="tool-action-box">
                <!--begin::Toolbar-->
                <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label fw-semibold">Giảng viên</label>
                    <select list-action="teacher-filter-select" class="form-select filter-select"
                        data-control="select2" data-kt-customer-table-filter="month"
                        data-placeholder="Chọn giảng viên" data-allow-clear="true" multiple="multiple">
                        @foreach(App\Models\Teacher::all() as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label fw-semibold">Môn học</label>
                    <select list-action="subject-filter-select" class="form-select filter-select"
                        data-control="select2" data-kt-customer-table-filter="month"
                        data-placeholder="Chọn lớp học" data-allow-clear="true" multiple="multiple">
                        @foreach(App\Models\Subject::all() as $subject)
                            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-5">
                    <!--begin::Label-->
                    <label class="form-label fw-semibold">Loại hình lớp</label>
                    <select list-action="type-filter-select" class="form-select filter-select"
                        data-control="select2" data-kt-customer-table-filter="month"
                        data-placeholder="Chọn loại hình lớp" data-allow-clear="true" multiple="multiple">
                        @foreach(config('classTypes') as $type)
                            <option value="{{ $type }}" {{ isset($orderItem) && $orderItem->class_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12 mb-5">
                    <label class="form-label">Ngày áp dụng (Từ - Đến)</label>
                    <div class="row" list-action="effective_date_select">
                        <div class="col-md-6">
                            <div class="form-outline">
                                <div data-control="date-with-clear-button"
                                    class="d-flex align-items-center date-with-clear-button">
                                    <input data-control="input" name="effective_date_from" placeholder="=asas"
                                        type="date" class="form-control" placeholder="" />
                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                        style="display:none;">close</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-outline">
                                <div data-control="date-with-clear-button"
                                    class="d-flex align-items-center date-with-clear-button">
                                    <input data-control="input" name="effective_date_to" placeholder="=asas"
                                        type="date" class="form-control" placeholder="" />
                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                        style="display:none;">close</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
        <button id="exportPayrateFilterButton" type="submit" class="btn btn-primary">
            <span  class="indicator-label">Xuất</span>
            <span class="indicator-progress">Đang xử lý...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
        <!--end::Button-->
        <!--begin::Button-->
        <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Hủy</button>
        <!--end::Button-->
    </div>
</form>
<script>

    $(document).ready(function() {
        $('#exportPayrateFilterButton').click(function(event) {
            event.preventDefault();
            exportPayrateFilter();
        });
    });

    function exportPayrateFilter() {

        var selectedTeachers = getSelectedValuesFromMultiSelect($('[list-action="teacher-filter-select"]')); 
        var selectedSubjects = getSelectedValuesFromMultiSelect($('[list-action="subject-filter-select"]'));
        var selectedTypeClasses = getSelectedValuesFromMultiSelect($('[list-action="type-filter-select"]'));

        
        var effectiveFrom = $('[list-action="effective_date_select"] input[name="effective_date_from"]').val();
        var effectiveTo = $('[list-action="effective_date_select"] input[name="effective_date_to"]').val();

        
        var formData = {
            _token: '{{ csrf_token() }}',
            teachers: selectedTeachers,
            subjects: selectedSubjects,
            type_classes: selectedTypeClasses,
            effective_date_from: effectiveFrom,
            effective_date_to: effectiveTo
        };
        
        $.ajax({
            url: "{{ action('App\Http\Controllers\Accounting\PayrateController@exportRun') }}",
            type: 'POST',
            data: formData,
            beforeSend: function() {
                // Show loading indicator
                $('#exportPayrateFilterButton .indicator-label').hide();
                $('#exportPayrateFilterButton .indicator-progress').show();
            },
            success: function(response) {
                // Download the file
                window.location = "{{ action('App\Http\Controllers\Accounting\PayrateController@exportDownload') }}?file=" + response.file;

                // Hide loading 
                $('#exportPayrateFilterButton .indicator-label').show();
                $('#exportPayrateFilterButton .indicator-progress').hide();
            },
            error: function(error) {
                throw new Error('Error:', error);

                // Hide loading 
                $('#exportPayrateFilterButton .indicator-label').show();
                $('#exportPayrateFilterButton .indicator-progress').hide();
            }
        });
    }

    
    function getSelectedValuesFromMultiSelect(selectElement) {
        var selectedValues = [];
        $(selectElement).find('option:selected').each(function() {
            var value = $(this).val().trim(); 
            if (value !== '') {
                selectedValues.push(value);
            }
        });
        return selectedValues;
    }

</script>



@endsection