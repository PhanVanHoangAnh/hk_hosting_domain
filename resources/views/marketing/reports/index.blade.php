@extends('layouts.main.app', [
    'menu' => 'marketing',
])
@section('sidebar')
    @include('marketing.modules.sidebar', [
        'menu' => 'report',
        'sidebar' => 'report',
    ])
@endsection

@section('head')
    <script src="{{ url('/lib/echarts/echarts.js') }}?v=4"></script>
@endsection

@section('content')
    <div id="ReportContainer" class="container">
        <h1 class="mb-0">Báo cáo marketing</h1>

        <div class="border p-4 my-5">
            <label class="fw-semibold mb-2 d-block">
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded me-1">
                        bookmarks
                    </span>
                    <span>Báo cáo đã lưu:</span>

                </span>
            </label>

            <div class="" id="ListButtons">
                {{-- @include('marketing.reports.viewButtons') --}}
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <!-- Phần bên trái với 5 select box -->
                <label class="form-label fw-semibold mt-2">Hàng ngang:</label>
                <!--end::Label-->
                <div>
                    <select report-control="x-type-select" class="form-select " data-control="select2"
                        data-kt-select2="true" data-placeholder="Chọn dữ liệu hàng ngang" data-allow-clear="true">
                        <option></option>
                        <option value="source_type">Phân loại nguồn</option>
                        <option value="sales">Nhân viên KD</option>
                        <option value="channel">Channel</option>
                        <option value="lead_status">Lead Status</option>
                        <option value="school">Trường học</option>
                        <option value="list">List</option>
                        <option value="pic">PIC</option>
                        <option value="type_match">Type Match</option>
                        <option value="birthday">Ngày sinh</option>
                        <option value="campaign">Campaign</option>
                        <option value="adset">Adset</option>
                        <option value="term">Term</option>
                        <option value="ads">Ads</option>
                        <option value="placement">Placement</option>

                    </select>
                    <div report-control="x-type-select-error" class="text-danger"></div>
                </div>
                <!--begin::Label-->

                <label class="form-label fw-semibold pt-6">Hàng dọc:</label>
                <div>
                    <div>
                        <select report-control="y-type-select" class="form-select " data-control="select2"
                            data-kt-select2="true" data-placeholder="Chọn dữ liệu hàng dọc" data-allow-clear="true">
                            <option></option>
                            <option value="source_type">Phân loại nguồn</option>
                            <option value="sales">Nhân viên KD</option>
                            <option value="channel">Channel</option>
                            <option value="lead_status">Lead Status</option>
                            <option value="school">Trường học</option>
                            <option value="list">List</option>
                            <option value="pic">PIC</option>
                            <option value="type_match">Type Match</option>
                            <option value="birthday">Ngày sinh</option>
                            <option value="campaign">Campaign</option>
                            <option value="adset">Adset</option>
                            <option value="device">Device</option>
                            <option value="term">Term</option>
                            <option value="ads">Ads</option>
                            <option value="placement">Placement</option>



                        </select>
                        <div report-control="y-type-select-error" class="text-danger"></div>
                    </div>
                </div>

                <label class="form-label fw-semibold pt-6">Dữ liệu:</label>
                <div>
                    <div>
                        <select report-control="data-type-select" class="form-select " data-control="select2"
                            data-kt-select2="true" data-placeholder="Chọn loại dữ liệu" data-allow-clear="true">
                            <option></option>
                            <option value="new_contact">Số lượng đơn hàng mới</option>
                            <option value="new_customer">Tỉ lệ chuyển đổi theo đơn hàng</option>
                        </select>
                        <div report-control="data-type-select-error" class="text-danger"></div>
                    </div>
                </div>

                <div class="d-none">
                    <label class="form-label pt-6">Ngày tạo (Từ - Đến)</label>
                    <div class="row" list-action="created_at-select">
                        <div class="col-md-6">
                            <div class="form-outline">
                                <div data-control="date-with-clear-button"
                                    class="d-flex align-items-center date-with-clear-button">
                                    <input data-control="input" name="created_at_from" placeholder="=asas" type="date"
                                        class="form-control" placeholder="" />
                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                        style="display:none;">close</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-outline">
                                <div data-control="date-with-clear-button"
                                    class="d-flex align-items-center date-with-clear-button">
                                    <input data-control="input" name="created_at_to" placeholder="=asas" type="date"
                                        class="form-control" placeholder="" />
                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                        style="display:none;">close</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <label class="form-label pt-6">Ngày cập nhật (Từ - Đến)</label>
                <div class="row" list-action="updated_at-select">
                    <div class="col-md-6">
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="updated_at_from" placeholder="=asas" type="date"
                                    class="form-control" placeholder="" />
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="updated_at_to" placeholder="=asas" type="date"
                                    class="form-control" placeholder="" />
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filter --}}
                <button report-control="filter-button" type="button"
                    class=" pt-6 btn btn-outline  border-0 btn-outline-default  w-100">
                    {{-- <span class="d-flex align-items-center "> --}}
                    <span class="text-uppercase ms-0">Bộ Lọc</span>

                    <span class="material-symbols-rounded me-2 text-gray-600">
                        <span id="filterIcon">expand_more</span>
                    </span>

                    {{-- </span> --}}
                </button>

                <!--begin::Content-->
                <div class="d-none" list-action="filter-action-box">
                    <label class="form-label fw-semibold ">Phân loại nguồn:</label>
                    <!--end::Label-->
                    <div>
                        <select list-action="source-type-select" class="form-select " data-control="select2"
                            data-kt-select2="true" data-placeholder="Chọn Phân loại nguồn" data-allow-clear="true">
                            <option></option>
                            @php
                                $uniqueSourceType = \App\Helpers\Functions::getSourceTypes();
                            @endphp
                            @foreach ($uniqueSourceType as $source_type)
                                <option value="{{ $source_type }}">{{ $source_type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!--begin::Label-->
                    <label class="form-label fw-semibold pt-6">Channel:</label>
                    <!--end::Label-->
                    <div>
                        <select list-action="marketing-source-select" class="form-select " data-control="select2"
                            data-kt-select2="true" data-placeholder="Chọn channel" data-allow-clear="true">
                            {{-- <option></option>
                            @php
                                $uniqueMarketingSource = App\Models\Contact::pluck('channel')->unique();
                            @endphp
                            @foreach ($uniqueMarketingSource as $channel)
                                <option value="{{ $channel }}">{{ $channel }}
                                </option>
                            @endforeach --}}
                        </select>
                    </div>
                    <!--begin::Label-->
                    <label class="form-label fw-semibold pt-6">Sub-Channel:</label>
                    <!--end::Label-->
                    <div>
                        <select list-action="marketing-source-sub-select" class="form-select " data-control="select2"
                            data-kt-select2="true" data-placeholder="Chọn sub-channel">
                        </select>
                    </div>
                    <!--begin::Label-->
                    <label class="form-label fw-semibold pt-6">Lifecycle Stage:</label>
                    <!--end::Label-->
                    <div>
                        <select list-action="lifecycle-stage-select" class="form-select " data-control="select2"
                            data-kt-select2="true" data-placeholder="Chọn life cycle stage" data-allow-clear="true">
                            <option></option>
                            @php
                                $uniqueLifecycleStage = App\Models\ContactRequest::pluck('lifecycle_stage')->unique();
                            @endphp
                            @foreach ($uniqueLifecycleStage as $lifecycle_stage)
                                <option value="{{ $lifecycle_stage }}">{{ $lifecycle_stage }}</option>
                                </option>
                                </option>
                            @endforeach
                        </select>
                        <!--begin::Label-->

                        <label class="form-label fw-semibold pt-6 ">Lead Status:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="lifecycle-stage-sub-select" class="form-select" data-kt-select2="true"
                                data-control="select2" data-placeholder="Chọn lead status">

                            </select>
                        </div>

                    </div>
                    <label class="form-label fw-semibold pt-6">Nhân viên sale</label>
                    <!--end::Label-->
                    <div>
                        <select list-action="salesperson-select" class="form-select"
                            data-control="select2"data-kt-select2="true" data-control="select2"data-allow-clear="true"
                            data-placeholder="Chọn nhân viên sales">
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

                <div class="d-flex justify-content-end pt-6 ">
                    <button report-control="save-button" class="btn btn-light me-3" id="">
                        <span class="d-flex align-items-center">
                            <span class="material-symbols-rounded me-1">
                                bookmarks
                            </span>
                            <span>Lưu báo cáo</span>
                        </span>
                    </button>

                    <button report-control="load" class="btn btn-primary">Hiển thị</button>
                </div>
            </div>

            <div class="col-md-9 ">
                <div report-control="result-container" class="position-relative">
                    <div class="" id="HideImg">
                        <img src="{{ asset('core/assets/media/illustrations/unitedpalms-1/19.png') }}" alt="Hình ảnh"
                            class="rounded mx-auto d-block" style="width: 300px; height: 300px;">
                        <figcaption class="figure-caption text-center">
                            <h2>Chọn trường dữ liệu bên trái để hiển thị thống kê chi tiết</h2>
                        </figcaption>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var report;
        var buttonManager;

        $(function() {

            report = new ReportManager({
                container: document.getElementById('ReportContainer'),
                url: '{{ action([App\Http\Controllers\Marketing\ReportController::class, 'result']) }}'
            });
            buttonManager = new ViewManager({
                container: document.getElementById('ReportContainer'),
                listButtons: document.getElementById('ListButtons'),
                url: "{{ action('\App\Http\Controllers\Marketing\ReportController@viewButtons') }}",
            })
            buttonManager.load();

            FilterData.init();
            // ViewManager.load();
            addViewNamePopup.init(); //

        });
        var addViewNamePopup = function() {
            var popupAddViewName;
            return {
                init: function() {
                    popupAddViewName = new Popup({
                        url: "{{ action('\App\Http\Controllers\Marketing\ReportController@createButtonName') }}"
                    });
                },
                getPopup: function() {
                    return popupAddViewName;
                },
                setName: function(name) {
                    return buttonManager.addView(name);
                }
            }
        }();
        var ViewManager = class {
            constructor(options) {
                this.container = options.container;
                this.listButtons = options.listButtons;
                this.url = options.url;

                // events
                this.events()

            }

            events() {
                this.getSaveButton().addEventListener('click', (e) => {
                    e.preventDefault();

                    if (!report.valid()) {
                        return;
                    }
                    addViewNamePopup.getPopup().load();
                });
            }

            afterLoadEvents() {
                // remove view
                this.getRemoveButtons().forEach(button => {
                    var name = button.getAttribute('view-name');

                    button.addEventListener('click', (e) => {
                        this.removeView(name);
                    });
                });
                // load view
                this.getLoadViewButtons().forEach(button => {
                    var name = button.getAttribute('view-name');

                    button.addEventListener('click', (e) => {
                        this.selectViewButton(button);
                        this.loadView(name);
                    });
                });
            }

            selectViewButton(button) {
                this.getLoadViewButtons().forEach(btn => {
                    btn.classList.add('btn-light');
                    btn.classList.remove('btn-info');
                });

                button.classList.remove('btn-light');
                button.classList.add('btn-info');
            }

            load() {
                $.ajax({
                    type: 'get',
                    url: this.url,
                }).done(response => {
                    this.renderViewButtons(response);

                    this.afterLoadEvents();
                });
            }

            renderViewButtons(content) {
                $(this.listButtons).html(content);
                initJs(this.listButtons);
            }

            addView(name) {
                var _this = this;

                $.ajax({
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name,
                        data: report.getCurrentViewData(),
                    },
                    type: 'POST',
                    url: "{{ action('\App\Http\Controllers\Marketing\ReportController@addView') }}",
                    success: function(response) {
                        _this.load();
                    },
                    error: function(error) {
                        throw new Error('Lỗi khi lưu giá trị vào session: ' + error);
                    }
                });
            }

            loadView(name) {
                var _this = this;

                // remove view
                $.ajax({
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name,
                    },
                    type: 'POST',
                    url: "{{ action('\App\Http\Controllers\Marketing\ReportController@loadView') }}",
                    success: function(response) {
                        var data = response
                        report.applyView(data);
                        report.load();
                    },
                    error: function(error) {
                        throw new Error('Lỗi khi lưu giá trị vào session: ' + error);
                    }
                });
            }
            removeView(name) {
                var _this = this;

                $.ajax({
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name,
                        data: report.getCurrentViewData(),
                    },
                    type: 'POST',
                    url: "{{ action('\App\Http\Controllers\Marketing\ReportController@removeView') }}",
                    success: function(response) {
                        _this.load();
                    },
                    error: function(error) {
                        throw new Error('Lỗi khi xoá giá trị trong session: ' + error);
                    }
                });
            }


            getSaveButton() {
                return this.container.querySelector('[report-control="save-button"]');
            }

            getRemoveButtons() {
                return this.container.querySelectorAll('[view-control="remove"]');
            }

            getLoadViewButtons() {
                return this.container.querySelectorAll('[view-control="load"]');
            }
        };

        var FilterData = (function() {
            var getSelectedValuesFromMultiSelect = function(select) {
                // Get an array of selected option elements
                var selectedOptions = Array.from(select.selectedOptions);

                // Extract values from selected options
                var selectedValues = selectedOptions
                    .filter(function(option) {
                        return option.value.trim() !== ''; // Filter out empty values
                    }).map(function(option) {
                        return option.value;
                    });

                return selectedValues;
            };

            return {
                init: () => {
                    $('[list-action="source-type-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);
                        report.setSourceType(selectedValues);
                    });

                    $('[list-action="marketing-type-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);
                        report.setMarketingType(selectedValues);
                    });

                    $('[list-action="marketing-source-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);
                        report.setMarketingSource(selectedValues);
                    });

                    $('[list-action="marketing-source-sub-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);
                        report.setMarketingSourceSub(selectedValues);
                    });

                    $('[list-action="lifecycle-stage-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);
                        report.setLifecycleStage(selectedValues);
                    });

                    $('[list-action="lifecycle-stage-sub-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);
                        report.setLeadStatus(selectedValues);
                    });

                    $('[list-action="salesperson-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);
                        report.setSalespersonIds(selectedValues);
                    });

                    $('[list-action="created_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="created_at_from"]').val();
                        var toDate = $('[name="created_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến ContactRequestsList và tải lại danh sách
                        report.setCreatedAtFrom(fromDate);
                        report.setCreatedAtTo(toDate);
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến ContactRequestsList và tải lại danh sách
                        report.setUpdatedAtFrom(fromDate);
                        report.setUpdatedAtTo(toDate);
                    });
                }
            };
        })();

        var ReportManager = class {
            constructor(options) {
                // chứa toàn bộ cái report
                this.container = options.container;
                // result url
                this.url = options.url;

                // events
                this.events();
                this.initContentEvents();
            }

            events() {
                this.getLoadButton().addEventListener('click', (e) => {
                    e.preventDefault();

                    //
                    this.load();
                });
                
                this.getFilterButton().addEventListener('click', (e) => {

                    if (!this.isFilterActionBoxShowed()) {
                        this.showFilterActionBox();
                    } else {
                        this.hideFilterActionBox();
                    }
                });
            }

            //Filter SalesPerson
            setSalespersonIds(ids) {
                this.salesperson_ids = ids;
            }
            getSalespersonIds() {
                return this.salesperson_ids;
            };

            // Filter by channels
            setMarketingSource(marketingSource) {
                this.channel = marketingSource;
            };
            getMarketingSource() {
                return this.channel;
            };
            // Filter by sub_channels
            setMarketingSourceSub(marketingSourceSub) {
                this.sub_channel = marketingSourceSub;
            };
            getMarketingSourceSub() {
                return this.sub_channel;
            };
            // Filter by marketing_types
            setMarketingType(marketingType) {
                this.marketing_type = marketingType;
            };
            setSourceType(sourceType) {
                this.source_type = sourceType;
            }
            setSourceTypeValue() {
                return this.source_type;
            }
            getMarketingType() {
                return this.marketing_type;
            };
            // Filter by lifecycle_stage
            setLifecycleStage(lifecycleStage) {
                this.lifecycle_stage = lifecycleStage;
            };

            getLifecycleStage() {
                return this.lifecycle_stage;
            };
            // Filter by lead_status
            setLeadStatus(leadStatus) {
                this.lead_status = leadStatus;
            };

            getLeadStatus() {
                return this.lead_status;
            };
            //created_at_from
            setCreatedAtFrom(createdAtFrom) {
                this.created_at_from = createdAtFrom;
            }
            setCreatedAtFromFilter() {
                return this.created_at_from;
            };
            setCreatedAtFromFilter() {
                return this.created_at_from;
            };
            //created_at_to
            setCreatedAtTo(createdAtTo) {
                this.created_at_to = createdAtTo;
            }
            setCreatedAtToFilter() {
                return this.created_at_to;
            };
            //updated_at_from
            setUpdatedAtFrom(updatedAtFrom) {
                this.updated_at_from = updatedAtFrom;
            }
            setUpdatedAtFromFilter() {
                return this.updated_at_from;
            };
            //updated_at_to
            setUpdatedAtTo(updatedAtTo) {
                this.updated_at_to = updatedAtTo;
            }
            setUpdatedAtToFilter() {
                return this.updated_at_to;
            };
            getSourceType() {
                return this.container.querySelector('[list-action="source-type-select"]');
            }
            getMarketingSourceSelected() {
                return this.container.querySelector('[list-action="marketing-source-select"]');
            }
            getLifecycleStageSelected() {
                return this.container.querySelector('[list-action="lifecycle-stage-select"]');
            }
            getMarketingSourceSelectedSub() {
                return this.container.querySelector('[list-action="marketing-source-sub-select"]');
            }

            getLifecycleStageSelectedSub() {
                return this.container.querySelector('[list-action="lifecycle-stage-sub-select"]');
            }
            getSalespersonSelected() {
                return this.container.querySelector('[list-action="salesperson-select"]');
            }
            getCreatedAtFrom() {
                return this.container.querySelector('[name="created_at_from"]');
            }
            getCreatedAtTo() {
                return this.container.querySelector('[name="created_at_to"]');
            }
            getUpdatedAtFrom() {
                return this.container.querySelector('[name="updated_at_from"]');
            }
            getUpdatedAtTo() {
                return this.container.querySelector('[name="updated_at_to"]');
            }

            showFilterActionBox() {
                this.getFilterActionBox().classList.remove('d-none');
                this.getFilterIcon().innerHTML = 'expand_less'
            }
            hideFilterActionBox() {
                this.getFilterActionBox().classList.add('d-none');
                this.getFilterIcon().innerHTML = 'expand_more'
            }
            isFilterActionBoxShowed() {
                return !this.getFilterActionBox().classList.contains('d-none');
            }
            getFilterIcon() {
                return document.getElementById('filterIcon');
            }
            getFilterActionBox() {
                return document.querySelector('[list-action="filter-action-box"]')
            }

            getLoadButton() {
                return this.container.querySelector('[report-control="load"]');
            }


            getContainer() {
                return this.container;
            }
            getFilterButton() {
                return this.getContainer().querySelector('[report-control="filter-button"]');
            }

            getReportResultContainer() {
                return this.getContainer().querySelector('[report-control="result-container"]');
            }

            getUrl() {
                return this.url;
            }

            getXTypeSelectBox() {
                return this.getContainer().querySelector('[report-control="x-type-select"]');
            }

            getYTypeSelectBox() {
                return this.getContainer().querySelector('[report-control="y-type-select"]');
            }

            getDataTypeSelectBox() {
                return this.getContainer().querySelector('[report-control="data-type-select"]');
            }

            getXType() {
                return this.getXTypeSelectBox().value
            }

            getYType() {
                return this.getYTypeSelectBox().value
            }

            getDataType() {
                return this.getDataTypeSelectBox().value;
            }

            getXErrorLabel() {
                return this.container.querySelector('[report-control="x-type-select-error"]');
            }

            getYErrorLabel() {
                return this.container.querySelector('[report-control="y-type-select-error"]');
            }

            getDataErrorLabel() {
                return this.container.querySelector('[report-control="data-type-select-error"]');
            }

            valid() {
                var valid = true;

                // x type validator
                if (!this.getXType()) {
                    this.getXErrorLabel().innerHTML = 'Vui lòng chọn dữ liệu hàng ngang';
                    valid = false;
                } else {
                    this.getXErrorLabel().innerHTML = '';
                }

                // y type validator
                if (!this.getYType()) {
                    this.getYErrorLabel().innerHTML = 'Vui lòng chọn dữ liệu hàng dọc';
                    valid = false;
                } else {
                    this.getYErrorLabel().innerHTML = '';
                }

                // data type validator
                if (!this.getDataType()) {
                    this.getDataErrorLabel().innerHTML = 'Vui lòng chọn loại dữ liệu báo cáo';
                    valid = false;
                } else {
                    this.getDataErrorLabel().innerHTML = '';
                }

                return valid;
            }

            setResult(html) {
                $(this.getReportResultContainer()).html(html);
            }

            addLoadingEffect() {

                this.getReportResultContainer().classList.add("list-loading");

                // When there is none, it adds a loading element to the HTML interface
                if (!this.getReportResultContainer().querySelector('[list-action="loader"]')) {
                    $(this.getReportResultContainer()).prepend(`
                        <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `);
                };
            };

            // Effect loading
            removeLoadingEffect() {
                this.getReportResultContainer().classList.remove("list-loading");

                if (this.getReportResultContainer().querySelector('[list-action="loader"]')) {
                    this.getReportResultContainer().querySelector('[list-action="loader"]').remove();
                };
            };
            initContentEvents() {
                $(this.getSourceType()).on('change', () => {
                    var selectedSource = this.getSourceType().value;
                    var subtypes = @json(config('sourceType'));

                    // Clear and update options in the second dropdown
                    var getMarketingSourceSelected = $(this
                        .getMarketingSourceSelected()); // Wrap it in jQuery
                    getMarketingSourceSelected.empty();

                    $.each(subtypes[selectedSource] || [], function(index, subtype) {
                        var option = new Option(subtype, subtype, false, false);
                        getMarketingSourceSelected.append(option);
                    });

                    // Trigger Select2 to refresh the second dropdown
                    $(getMarketingSourceSelected).trigger('change.select2');

                    // cho sub_channel = []
                    this.setMarketingSourceSub([]);
                });
                // Khi chọn marketing source thì sẽ hiện thị ra marrketing source sub tương ứng
                $(this.getMarketingSourceSelected()).on('change', () => {
                    var selectedSource = this.getMarketingSourceSelected().value;
                    var subtypes = @json(config('marketingSourceSubs'));

                    // Clear and update options in the second dropdown
                    var getMarketingSourceSelectedSub = $(this
                        .getMarketingSourceSelectedSub()); // Wrap it in jQuery
                    getMarketingSourceSelectedSub.empty();

                    $.each(subtypes[selectedSource] || [], function(index, subtype) {
                        var option = new Option(subtype, subtype, false, false);
                        getMarketingSourceSelectedSub.append(option);
                    });

                    // Trigger Select2 to refresh the second dropdown
                    $(getMarketingSourceSelectedSub).trigger('change.select2');

                    // cho sub_channel = []
                    this.setMarketingSourceSub([]);
                });

                $(this.getLifecycleStageSelected()).on('change', () => {
                    var selectedSource = this.getLifecycleStageSelected().value;
                    var subtypes = @json(config('lifecycleStagesSub'));

                    // Clear and update options in the second dropdown
                    var getLifecycleStageSelectedSub = $(this
                        .getLifecycleStageSelectedSub()); // Wrap it in jQuery
                    getLifecycleStageSelectedSub.empty();

                    $.each(subtypes[selectedSource] || [], function(index, subtype) {
                        var option = new Option(subtype, subtype, false, false);
                        getLifecycleStageSelectedSub.append(option);
                    });

                    // Trigger Select2 to refresh the second dropdown
                    $(getLifecycleStageSelectedSub).trigger('change.select2');

                    // cho sub_channel = []
                    this.setMarketingSourceSub([]);
                });

            }

            getFilterType() {
                var filter_type = {
                    source_type: this.setSourceTypeValue(),
                    marketing_type: this.getMarketingType(),
                    channel: this.getMarketingSource(),
                    sub_channel: this.getMarketingSourceSub(),
                    lifecycle_stage: this.getLifecycleStage(),
                    lead_status: this.getLeadStatus(),
                    salesperson_ids: this.getSalespersonIds(),

                    created_at_from: this.setCreatedAtFromFilter(),
                    created_at_to: this.setCreatedAtToFilter(),

                    updated_at_from: this.setUpdatedAtFromFilter(),
                    updated_at_to: this.setUpdatedAtToFilter(),

                }
                return filter_type
            }

            getDataManager() {
                var data = {
                    name: 'pp',
                    x_type: this.getXType(),
                    y_type: this.getYType(),
                    data_type: this.getDataType(),
                    filter_type: this.getFilterType(),
                }
                return data;
            }

            getCurrentViewData() {
                var data = {
                    x_type: this.getXType(),
                    y_type: this.getYType(),
                    data_type: this.getDataType(),
                    filter_type: this.getFilterType(),
                }
                return data;
            }
            applyView(data) {

                const xTypeSelectBox = this.getXTypeSelectBox();
                xTypeSelectBox.value = data.data.x_type;
                $(xTypeSelectBox).trigger('change');

                const yTypeSelectBox = this.getYTypeSelectBox();
                yTypeSelectBox.value = data.data.y_type;
                $(yTypeSelectBox).trigger('change');

                const dataTypeSelectBox = this.getDataTypeSelectBox();
                dataTypeSelectBox.value = data.data.data_type;
                $(dataTypeSelectBox).trigger('change');

                const marketingSourceSelected = this.getMarketingSourceSelected();
                const marketingSourceSelectedSub = this.getMarketingSourceSelectedSub();
                const lifecycleStageSelected = this.getLifecycleStageSelected();
                const lifecycleStageSelectedSub = this.getLifecycleStageSelectedSub();
                const salespersonSelected = this.getSalespersonSelected();
                const createAtFrom = this.getCreatedAtFrom();
                const createAtTo = this.getCreatedAtTo();
                const updatedAtFrom = this.getUpdatedAtFrom();
                const updatedAtTo = this.getUpdatedAtTo();



                if (data.data.filter_type) {
                    if (data.data.filter_type) {
                        marketingSourceSelected.value = data.data.filter_type.channel;
                        $(marketingSourceSelected).trigger('change');
                    } else {
                        marketingSourceSelected.value = '';
                        $(marketingSourceSelected).trigger('change');
                    }

                    if (data.data.filter_type.sub_channel) {
                        marketingSourceSelectedSub.value = data.data.filter_type.sub_channel;
                        $(marketingSourceSelectedSub).trigger('change');
                    } else {
                        marketingSourceSelectedSub.value = '';
                        $(marketingSourceSelectedSub).trigger('change');
                    }

                    if (data.data.filter_type.lifecycle_stage) {
                        lifecycleStageSelected.value = data.data.filter_type.lifecycle_stage;
                        $(lifecycleStageSelected).trigger('change');
                    } else {
                        lifecycleStageSelected.value = '';
                        $(lifecycleStageSelected).trigger('change');
                    }

                    if (data.data.filter_type.lead_status) {
                        lifecycleStageSelectedSub.value = data.data.filter_type.lead_status;
                        $(lifecycleStageSelectedSub).trigger('change');
                    } else {
                        lifecycleStageSelectedSub.value = '';
                        $(lifecycleStageSelectedSub).trigger('change');
                    }

                    if (data.data.filter_type.salesperson_ids) {
                        salespersonSelected.value = data.data.filter_type.salesperson_ids;
                        $(salespersonSelected).trigger('change');
                    } else {
                        salespersonSelected.value = '';
                        $(salespersonSelected).trigger('change');
                    }

                    if (data.data.filter_type.created_at_from) {
                        createAtFrom.value = data.data.filter_type.created_at_from;
                        $(createAtFrom).trigger('change');
                    } else {
                        createAtFrom.value = '';
                        $(createAtFrom).trigger('change');
                    }

                    if (data.data.filter_type.created_at_to) {
                        createAtTo.value = data.data.filter_type.created_at_to;
                        $(createAtTo).trigger('change');
                    } else {
                        createAtTo.value = '';
                        $(createAtTo).trigger('change');
                    }

                    if (data.data.filter_type.updated_at_from) {
                        updatedAtFrom.value = data.data.filter_type.updated_at_from;
                        $(updatedAtFrom).trigger('change');
                    } else {
                        updatedAtFrom.value = '';
                        $(updatedAtFrom).trigger('change');
                    }

                    if (data.data.filter_type.updated_at_to) {
                        updatedAtTo.value = data.data.filter_type.updated_at_to;
                        $(updatedAtTo).trigger('change');

                    } else {
                        updatedAtTo.value = '';
                        $(updatedAtTo).trigger('change');
                    }
                } else {
                    marketingSourceSelected.value = '';
                    $(marketingSourceSelected).trigger('change');
                    marketingSourceSelectedSub.value = '';
                    $(marketingSourceSelectedSub).trigger('change');
                    lifecycleStageSelected.value = '';
                    $(lifecycleStageSelected).trigger('change');
                    lifecycleStageSelectedSub.value = '';
                    $(lifecycleStageSelectedSub).trigger('change');
                    salespersonSelected.value = '';
                    $(salespersonSelected).trigger('change');
                    createAtFrom.value = '';
                    $(createAtFrom).trigger('change');
                    createAtTo.value = '';
                    $(createAtTo).trigger('change');
                    updatedAtFrom.value = '';
                    $(updatedAtFrom).trigger('change');
                    updatedAtTo.value = '';
                    $(updatedAtTo).trigger('change');
                }



            }

            load() {

                // validate
                if (!this.valid()) {
                    return;
                }
                var postData = this.getCurrentViewData();
                postData._token = '{{ csrf_token() }}';
                // add loading effect
                this.addLoadingEffect();

                $.ajax({
                    url: this.getUrl(),
                    type: 'POST',
                    data: postData,
                }).done((response) => {
                    this.setResult(response);
                    this.initContentEvents();
                }).always(() => {
                    // remove loading effect

                    this.removeLoadingEffect();
                });
            }
        };
    </script>
@endsection
