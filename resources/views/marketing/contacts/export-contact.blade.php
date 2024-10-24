@extends('layouts.main.popup')

@section('title')
    Cấu hình dữ liệu liên hệ cần xuất
@endsection

@section('content')
<form id="filterContactForm" action="{{ action('App\Http\Controllers\Marketing\ContactController@exportRun') }}" method="POST">
    @csrf
    <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
        <div class="card-header border-0 p-4  list-filter-box pt-0 pb-0" list-action="filter-action-box">
            <!--begin::Card toolbar-->
            <div class="row card-toolbar mb-0" list-action="tool-action-box">
                <!--begin::Toolbar-->
                    <!--begin::Content-->
                    
                    <div class="col-md-12 mb-5">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 ">Nhân viên sale</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="salesperson-select" class="form-select" data-control="select2"
                                data-placeholder="Chọn nhân viên sales" multiple>
                                <option value="none">Chưa bàn giao</option>
                                @foreach (App\Models\Account::sales()->get() as $account)
                                    <option value="{{ $account->id }}">
                                        @if ($account)
                                            {{ $account->name }}
                                        @endif
                                    </option>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-5">
                        <label class="fs-6 fw-semibold mb-2">Ngày tạo (Từ - Đến)</label>
                        <div class="row" list-action="created_at-select">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="created_at_from" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="=asas" type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="created_at_to" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="=asas" type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-5 d-none">
                        <label class="fs-6 fw-semibold mb-2">Ngày cập nhật (Từ - Đến)</label>
                        <div class="row" list-action="updated_at-select">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="updated_at_from" placeholder="=asas" type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="updated_at_to" placeholder="=asas" type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Actions-->
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

        // initJs(document);
        // document.querySelectorAll('[data-control="date-with-clear-button"]').forEach(function(element) {
        //     new DateClearButton(element);
        // });


        $('[list-action="marketing-source-select"]').on('change', function () {
            var selectedSource = this.value;
            var subtypes = @json(config('marketingSourceSubs'));

            
            var subChannelDropdown = $('[list-action="marketing-source-sub-select"]');
            subChannelDropdown.empty(); 

            
            $.each(subtypes[selectedSource] || [], function (index, subtype) {
                var option = new Option(subtype, subtype, false, false);
                subChannelDropdown.append(option);
            });

        });
        
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

        $('#exportContactFilterButton').click(function(event) {
            event.preventDefault(); 

            // Get selected values 
            var selectedSourceTypes = getSelectedValuesFromMultiSelect($('[list-action="marketing-type-select"]'));
            var selectedChannels = getSelectedValuesFromMultiSelect($('[list-action="marketing-source-select"]'));
            var selectedSubChannels = getSelectedValuesFromMultiSelect($('[list-action="marketing-source-sub-select"]'));
            var selectedLifecycleStages = getSelectedValuesFromMultiSelect($('[list-action="lifecycle-stage-select"]'));
            var selectedLeadStatuses = getSelectedValuesFromMultiSelect($('[list-action="lead-status-select"]'));
            var selectedSalespersons = getSelectedValuesFromMultiSelect($('[list-action="salesperson-select"]'));


            
            // Get date range values
            var createdFrom = $('[list-action="created_at-select"] input[name="created_at_from"]').val();
            var createdTo = $('[list-action="created_at-select"] input[name="created_at_to"]').val();
            var updatedFrom = $('[list-action="updated_at-select"] input[name="updated_at_from"]').val();
            var updatedTo = $('[list-action="updated_at-select"] input[name="updated_at_to"]').val();

            // serialize form 
            var formData = {
                _token: '{{ csrf_token() }}',
                source_type: selectedSourceTypes,
                channel: selectedChannels,
                sub_channel: selectedSubChannels,
                lifecycle_stage: selectedLifecycleStages,
                lead_status: selectedLeadStatuses,
                salesperson_ids: selectedSalespersons,
                created_at_from: createdFrom,
                created_at_to: createdTo,
                updated_at_from: updatedFrom,
                updated_at_to: updatedTo
            };

            $.ajax({
                url: "{{ action('App\Http\Controllers\Marketing\ContactController@exportRun') }}",
                type: 'POST',
                data: formData,
                beforeSend: function() {
                    // Show loading indicator
                    $('#exportContactFilterButton .indicator-label').hide();
                    $('#exportContactFilterButton .indicator-progress').show();
                },
                success: function(response) {
                    // Download the file
                    window.location = "{{ action('App\Http\Controllers\Marketing\ContactController@exportDownload') }}?file=" + response.file;

                    // Hide loading 
                    $('#exportContactFilterButton .indicator-label').show();
                    $('#exportContactFilterButton .indicator-progress').hide();
                },
                error: function(error) {
                    throw new Error('Error:', error);

                    // Hide loading 
                    $('#exportContactFilterButton .indicator-label').show();
                    $('#exportContactFilterButton .indicator-progress').hide();
                }
            });
        });
    });
</script>
@endsection