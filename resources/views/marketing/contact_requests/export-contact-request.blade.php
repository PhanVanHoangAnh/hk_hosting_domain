@extends('layouts.main.popup')

@section('title')
    Cấu hình dữ liệu đơn hàng cần xuất
@endsection

@section('content')
    <form id="filterContactRequestForm"
        action="{{ action('App\Http\Controllers\Marketing\ContactRequestController@exportRun') }}" method="POST">
        @csrf
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
            <div class="card-header border-0 p-4  list-filter-box pt-0 pb-0" list-action="filter-action-box">
                <!--begin::Card toolbar-->
                <div class="row card-toolbar mb-0" list-action="tool-action-box">
                    <!--begin::Toolbar-->
                    <!--begin::Content-->
                    <div class="col-md-6 mb-5">
                        <label class="fs-6 fw-semibold mb-2">Ngày tạo (Từ - Đến)</label>
                        <div class="row" list-action="created_at-select">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="created_at_from"
                                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}"
                                            placeholder="=asas" type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="created_at_to"
                                            value="{{ Carbon\Carbon::now()->format('Y-m-d') }}" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 ">Phân loại nguồn:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="marketing-type-select" class="form-select " name="source_types[]"
                                data-control="select2" data-kt-select2="true" data-placeholder="Tất cả phân loại nguồn" data-allow-clear="true" multiple>
                                <option></option>
                                @php
                                    $uniqueMarketingTypes = \App\Helpers\Functions::getSourceTypes();
                                @endphp
                                @foreach ($uniqueMarketingTypes as $source_type)
                                    <option value="{{ $source_type }}">{{ $source_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5 d-none">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 ">Channel:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="marketing-source-select" class="form-select " data-control="select2"
                                data-kt-select2="true" data-placeholder="Chọn channel" data-allow-clear="true">
                                <option></option>
                                @php
                                    $uniqueMarketingSource = App\Models\ContactRequest::pluck('channel')->unique();
                                @endphp
                                @foreach ($uniqueMarketingSource as $channel)
                                    <option value="{{ $channel }}">{{ $channel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5 d-none">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 ">Sub-Channel:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="marketing-source-sub-select" class="form-select " data-control="select2"
                                data-kt-select2="true" data-placeholder="Chọn sub-channel" multiple>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5 d-none">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 ">Lifecycle Stage:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="lifecycle-stage-select" class="form-select " data-control="select2"
                                data-placeholder="Chọn life cycle stage">
                                <option></option>
                                @php
                                    $uniqueLifecycleStage = App\Models\ContactRequest::pluck(
                                        'lifecycle_stage',
                                    )->unique();
                                @endphp
                                @foreach ($uniqueLifecycleStage as $lifecycle_stage)
                                    {{-- <option value="{{ $lifecycle_stage }}">{{ $lifecycle_stage }} --}}
                                    <option {{ $lifecycle_stage_name == $lifecycle_stage ? 'selected' : '' }}
                                        value="{{ $lifecycle_stage }}">{{ $lifecycle_stage }}</option>
                                    </option>
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mb-5 d-none">
                        <!--begin::Label-->
                        <label class="fs-6 fw-semibold mb-2 ">Lead Status:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="lifecycle-stage-sub-select" class="form-select" data-kt-select2="true"
                                data-control="select2" data-placeholder="Chọn lead status" multiple>
                                @foreach (config('leadStatuses') as $lstatus)
                                    <option value="{{ $lstatus }}">{{ $lstatus }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-5 d-none">
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

                    <div class="col-md-6 mb-5 d-none">
                        <label class="fs-6 fw-semibold mb-2">Ngày cập nhật (Từ - Đến)</label>
                        <div class="row" list-action="updated_at-select">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="updated_at_from" placeholder="=asas"
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
                                        <input data-control="input" name="updated_at_to" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-5 d-none">
                        <label class="fs-6 fw-semibold mb-2">HubSport Source Date (Từ - Đến)</label>
                        <div class="row" list-action="hs_latest_source">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="hs_latest_source_from" placeholder="=asas"
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
                                        <input data-control="input" name="hs_latest_source_to" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
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
            <button id="exportContactRequestFilterButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Xuất</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button data-action="under-construction" id="GoogleSheetExportButton" type="submit" class="btn btn-light">
                <span class="indicator-label">Xuất đến Google Sheet</span>
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

            // initJs(document);
            // document.querySelectorAll('[data-control="date-with-clear-button"]').forEach(function(element) {
            //     new DateClearButton(element);
            // });


            $('#filterContactRequestForm [list-action="marketing-source-select"]').on('change', function() {
                var selectedSource = this.value;
                var subtypes = @json(config('marketingSourceSubs'));


                var subChannelDropdown = $('#filterContactRequestForm [list-action="marketing-source-sub-select"]');
                subChannelDropdown.empty();


                $.each(subtypes[selectedSource] || [], function(index, subtype) {
                    var option = new Option(subtype, subtype, false, false);
                    subChannelDropdown.append(option);
                });

            });
            $('#filterContactRequestForm [list-action="lifecycle-stage-select"]').on('change', function() {
                var selectedSource = this.value;
                var subtypes = @json(config('lifecycleStagesSub'));


                var subChannelDropdown = $('#filterContactRequestForm [list-action="lifecycle-stage-sub-select"]');
                subChannelDropdown.empty();


                $.each(subtypes[selectedSource] || [], function(index, subtype) {
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

            $('#exportContactRequestFilterButton').click(function(event) {
                event.preventDefault();

                // Get selected values 
                var selectedSourceTypes = getSelectedValuesFromMultiSelect($(
                    '[list-action="marketing-type-select"]'));
                var selectedChannels = getSelectedValuesFromMultiSelect($(
                    '[list-action="marketing-source-select"]'));
                var selectedSubChannels = getSelectedValuesFromMultiSelect($(
                    '[list-action="marketing-source-sub-select"]'));
                var selectedLifecycleStages = getSelectedValuesFromMultiSelect($(
                    '[list-action="lifecycle-stage-select"]'));
                var selectedLeadStatuses = getSelectedValuesFromMultiSelect($(
                    '[list-action="lead-status-select"]'));
                var selectedSalespersons = getSelectedValuesFromMultiSelect($(
                    '[list-action="salesperson-select"]'));

                // Get date range values
                var createdFrom = $('#filterContactRequestForm [list-action="created_at-select"] input[name="created_at_from"]')
            .val();
                var createdTo = $('#filterContactRequestForm [list-action="created_at-select"] input[name="created_at_to"]').val();
                var updatedFrom = $('#filterContactRequestForm [list-action="updated_at-select"] input[name="updated_at_from"]')
            .val();
                var updatedTo = $('#filterContactRequestForm [list-action="updated_at-select"] input[name="updated_at_to"]').val();

                // hs source date
                var hs_latest_source_from = $(
                    '[list-action="hs_latest_source"] input[name="hs_latest_source_from"]').val();
                var hs_latest_source_to = $(
                    '[list-action="hs_latest_source"] input[name="hs_latest_source_to"]').val();

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
                    updated_at_to: updatedTo,
                    hs_latest_source_from: hs_latest_source_from,
                    hs_latest_source_to: hs_latest_source_to
                };

                $.ajax({
                    url: "{{ action('App\Http\Controllers\Marketing\ContactRequestController@exportRun') }}",
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        // Show loading indicator
                        $('#exportContactRequestFilterButton .indicator-label').hide();
                        $('#exportContactRequestFilterButton .indicator-progress').show();

                        //
                        addMaskLoading('Đang xuất dữ liệu re Excel file. Vui lòng chờ...');
                    },
                    success: function(response) {
                        // Download the file
                        window.location =
                            "{{ action('App\Http\Controllers\Marketing\ContactRequestController@exportDownload') }}?file=" +
                            response.file;

                        // Hide loading 
                        $('#exportContactRequestFilterButton .indicator-label').show();
                        $('#exportContactRequestFilterButton .indicator-progress').hide();

                        //
                        removeMaskLoading();
                    },
                    error: function(error) {

                        throw new Error('Error:', error);

                        // Hide loading 
                        $('#exportContactRequestFilterButton .indicator-label').show();
                        $('#exportContactRequestFilterButton .indicator-progress').hide();

                        //
                        removeMaskLoading();
                    }
                });
            });


        });


        $(function() {
            new GoogleSheetExporter({
                button: $('#GoogleSheetExportButton'),
                url: "{{ action('App\Http\Controllers\Marketing\ContactRequestController@exportToGoogleSheet') }}",
            });
        });

        var GoogleSheetExporter = class {
            constructor(options) {
                this.button = options.button;
                this.url = options.url;

                this.button.click((event) => {
                    event.preventDefault();
                    this.run();
                })

            }

            addLoading() {
                // Show loading indicator
                this.button.find('.indicator-label').hide();
                this.button.find('.indicator-progress').show();

                //
                addMaskLoading('Đang xuất dữ liệu đến Google Sheet. Vui lòng chờ...');
            }

            removeLoading() {
                // Show loading indicator
                this.button.find('.indicator-label').show();
                this.button.find('.indicator-progress').hide();

                //
                removeMaskLoading();
            }

            getSelectedValuesFromMultiSelect(selectElement) {
                var selectedValues = [];
                $(selectElement).find('option:selected').each(function() {
                    var value = $(this).val().trim(); // Get the trimmed value
                    if (value !== '') {
                        selectedValues.push(value);
                    }
                });
                return selectedValues;
            }

            run() {
                var _this = this;

                // Get selected values 
                var selectedSourceTypes = _this.getSelectedValuesFromMultiSelect($(
                    '[list-action="marketing-type-select"]'));
                var selectedChannels = _this.getSelectedValuesFromMultiSelect($(
                    '[list-action="marketing-source-select"]'));
                var selectedSubChannels = _this.getSelectedValuesFromMultiSelect($(
                    '[list-action="marketing-source-sub-select"]'));
                var selectedLifecycleStages = _this.getSelectedValuesFromMultiSelect($(
                    '[list-action="lifecycle-stage-select"]'));
                var selectedLeadStatuses = _this.getSelectedValuesFromMultiSelect($(
                '[list-action="lead-status-select"]'));
                var selectedSalespersons = _this.getSelectedValuesFromMultiSelect($(
                '[list-action="salesperson-select"]'));

                // Get date range values
                var createdFrom = $('#filterContactRequestForm [list-action="created_at-select"] input[name="created_at_from"]').val();
                var createdTo = $('#filterContactRequestForm [list-action="created_at-select"] input[name="created_at_to"]').val();
                var updatedFrom = $('#filterContactRequestForm [list-action="updated_at-select"] input[name="updated_at_from"]').val();
                var updatedTo = $('#filterContactRequestForm [list-action="updated_at-select"] input[name="updated_at_to"]').val();

                // hs source date
                var hs_latest_source_from = $(
                    '[list-action="hs_latest_source"] input[name="hs_latest_source_from"]').val();
                var hs_latest_source_to = $('#filterContactRequestForm [list-action="hs_latest_source"] input[name="hs_latest_source_to"]')
                    .val();

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
                    updated_at_to: updatedTo,
                    hs_latest_source_from: hs_latest_source_from,
                    hs_latest_source_to: hs_latest_source_to
                };

                $.ajax({
                    url: _this.url,
                    type: 'POST',
                    data: formData,
                    beforeSend: function() {
                        _this.addLoading();
                    },
                    success: function(response) {
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                            }
                        });
                        // Hide loading 
                        _this.removeLoading();
                    },
                    error: function(error) {

                        throw new Error('Error:', error);

                        // Hide loading 
                        _this.removeLoading();
                    }
                });
            }
        }
    </script>
@endsection
