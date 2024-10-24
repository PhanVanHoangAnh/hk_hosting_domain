@extends('layouts.main.app', [
    'menu' => 'sales',
])

@section('sidebar')
    @include('sales.modules.sidebar', [
        'menu' => 'reporting',
        'sidebar' => 'sales-report',
    ])
@endsection

@section('content')
    {{-- @include('helpers.alert_updating') --}}

    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Báo cáo doanh thu</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index']) }}"
                        class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Báo cáo</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Doanh thu</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Button-->
            <div class="me-3" list-action="export-contact" >
                <a type="button"
                    href="{{ action([\App\Http\Controllers\Sales\Report\SalesReportController::class, 'showFilterForm']) }}"
                    class="btn btn-outline btn-outline-default btn-menu " data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">
                    <span class="d-flex align-items-center">
                        <span class="material-symbols-rounded me-2">
                            export_notes
                        </span>
                        <span>Xuất dữ liệu</span>
                    </span>
                </a>

                <!--end::Menu link-->
            </div>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>

    <div id="SalesReportIndexContainer" class="position-relative" id="kt_post">
        <!--begin::Card-->
        <div class="card ">
            <!--begin::Card header-->
            <div class="card-header border-0 px-4">
                <!--begin::Group actions-->
                <div list-action="top-action-box" class="d-flex justify-content-end align-items-center d-none">
                    <div class="justify-content-end">
                        <td class="text-end">
                            <a href="#" class="btn btn-outline btn-flex btn-center btn-active-light-default"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <div>Thao tác</div>
                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a data-action="under-construction" row-action="delete-all" href="javasripr:;"
                                        class="menu-link px-3" list-action="sort">Xóa</a>
                                </div>
                                <!--end::Menu item-->
                            </div>
                            <!--end::Menu-->
                        </td>
                    </div>
                    <div class="m-2 font-weight-bold">
                        <div list-control="count-note-selected-label" class="fs-6"></div>
                    </div>
                </div>
                <!--end::Group actions-->
                <div class="card-title" list-action="search-action-box" style="width:80%;">
                    <div class="row w-100 mb-1 list-filter-box" list-action="created_at-select">
                        {{-- @if (Auth::user()->hasPermission(App\Library\Permission::SALES_REPORT_ALL)) --}}
                            <div class="col-md-3">
                                <label class="form-label fw-semibold mb-1">Nhân viên</label>
                                <div class="form-outline">
                                    <select name="account_ids[]" data-control="select2-ajax"
                                        data-url="{{ action('App\Http\Controllers\AccountController@select2') }}"
                                        class="form-control" data-dropdown-parent="" data-control="select2"
                                        data-placeholder="Chọn nhân viên" multiple>
                                        {{-- <option selected value="{{ Auth::user()->account->id }}">
                                            {{ Auth::user()->account->name }}</option> --}}
                                            @foreach (App\Models\Account::sales()->get() as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        {{-- @endif --}}
                        <div class="col-md-3">
                            <label class="form-label fw-semibold mb-1">Từ ngày</label>
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
                        <div class="col-md-3">
                            <label class="form-label fw-semibold mb-1">Đến ngày</label>
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
                        <div class="col-md-3">

                            <div class="form-outline pt-8">
                                <div class="d-flex align-items-center date-with-clear-button">
                                    <button type="button" id="runButton" class="btn btn-primary ms-2"
                                        style="
                                    padding-top: 7px;
                                    padding-bottom: 7px;
                                ">Báo
                                        cáo</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar d-none" list-action="tool-action-box">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end">
                        <div class="justify-content-end me-3 d-none">
                            <td class="text-end">
                                <button type="button" class="btn btn-outline btn-outline-default"
                                    data-action="under-construction" data-kt-menu-trigger="click"
                                    data-kt-menu-placement="bottom-end">
                                    <span class="d-flex align-items-center">
                                        <span class="material-symbols-rounded me-2 text-gray-600">
                                            view_week
                                        </span>
                                        <span>Hiển thị</span>
                                    </span>
                                </button>

                                <div class="menu menu-sub menu-sub-dropdown" style="width:600px;" data-kt-menu="true"
                                    id="kt-toolbar-filter">
                                    <!--begin::Header-->
                                    <div class="px-7 py-5">
                                        <div class="d-flex align-items-center">
                                            <div class="fs-4 text-dark fw-bold">Hiển thị theo cột</div>
                                            <div class="ms-auto d-flex align-items-center">
                                                <a data-control="dropdown-close-button" href="javascript:;"
                                                    class="dropdown-close-button">
                                                    <span class="material-symbols-rounded fs-1">
                                                        close
                                                    </span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Header-->
                                    <!--begin::Separator-->
                                    <div class="separator border-gray-200"></div>
                                    <!--end::Separator-->
                                    <!--begin::Content-->
                                    <div class="px-7 py-5">
                                        <div columns-control="options-box">
                                            <div class="d-flex align-items-top">
                                                <div column-control="checked-box-container" class="me-3 w-300px"
                                                    style="width:50%">
                                                    <div class="p-3 rounded border bg-light">
                                                        <div class="" style="height: 250px; overflow-y: scroll;">
                                                            <div column-control="checked-box" class="container-columns">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div column-control="unchecked-box-container" class="w-300px"
                                                    style="width:50%">
                                                    <div class="p-3 rounded border bg-light">
                                                        <div class="" style="height: 250px; overflow-y: scroll;">
                                                            <div column-control="unchecked-box" class="container-columns">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Content-->
                                </div>
                            </td>
                        </div>
                        <!--begin::Filter-->
                        <button type="button" data-action="under-construction"
                            class="btn btn-outline btn-outline-default" id="filterButton">
                            <span class="d-flex align-items-center">
                                <span class="material-symbols-rounded me-2 text-gray-600">
                                    filter_alt
                                </span>
                                <span>Lọc</span>

                                <span class="material-symbols-rounded me-2 text-gray-600">
                                    <span id="filterIcon">expand_more</span>
                                </span>

                            </span>
                        </button>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <div class="card-header border-0 p-4 d-none list-filter-box" list-action="filter-action-box">
                <!--begin::Card toolbar-->
                <div class="card-toolbar w-100" list-action="tool-action-box">
                    <!--begin::Toolbar-->

                    <div class="row w-100">
                        <!--begin::Content-->
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5 d-none">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Chi nhánh</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="type-select" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false" data-placeholder="Phân loại"
                                    data-allow-clear="true" multiple="multiple">
                                    @foreach (config('orderTypes') as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Dịch vụ</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="industry-select" class="form-select filter-select"
                                    data-control="select2" data-kt-customer-table-filter="month"
                                    data-placeholder="Chọn loại dịch vụ" data-allow-clear="true" multiple="multiple">
                                    @foreach (config('industries') as $industry)
                                        <option value="{{ $industry }}">{{ $industry }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Sale</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="sale-select" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false" data-placeholder="Chọn sale"
                                    data-allow-clear="true" multiple="multiple">
                                    @foreach (App\Models\Account::sales()->get() as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Sale sup</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="sale-sup-select" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false" data-placeholder="Chọn sale sup"
                                    data-allow-clear="true" multiple="multiple">
                                    @foreach (App\Models\Account::sales()->get() as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
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
        <!--end::Card header-->
        <div id="SalesReportIndexListContent">
        </div>
    </div>
    <script>
        $(function() {
            SalesReportIndex.init();
        });
        //
        var SalesReportIndex = function() {
            return {
                init: function() {
                    SalesReportList.init();
                    //
                    FilterData.init();
                    //
                    ExportExcel.init();
                }
            };
        }();
        //
        var ExportExcel = function() {
            var popupExcelSalesReport;

            // show campaign modal
            var showExportModal = function() {
                popupExcelSalesReport.load();
            };

            return {
                init: function() {
                    // create campaign popup
                    popupExcelSalesReport = new Popup({
                        url: "{{ action('\App\Http\Controllers\Sales\Report\SalesReportController@showFilterForm') }}",
                    });

                    // create campaign button
                    var buttonCreateExportList = document.querySelectorAll('[list-action="export-contact"]');

                    // Add click event listener to each button
                    buttonCreateExportList.forEach(function(buttonCreateExport) {
                        buttonCreateExport.addEventListener('click', function(e) {
                            e.preventDefault();

                            // show create campaign modal
                            showExportModal();
                        });
                    });
                },

                getPopup: function() {
                    return popupExcelSalesReport;
                }
            };
        }();
        //
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
                    $('[list-action="industry-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        SalesReportList.getList().setIndustries(selectedValues);

                        // load list
                        SalesReportList.getList().load();
                    });
                    $('[list-action="sale-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        SalesReportList.getList().setSales(selectedValues);

                        // load list
                        SalesReportList.getList().load();
                    });
                    $('[list-action="sale-sup-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        SalesReportList.getList().setSaleSups(selectedValues);

                        // load list
                        SalesReportList.getList().load();
                    });

                    $('#runButton').on('click', function() {
                        applyDateFilter();
                    });

                    function applyDateFilter() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();
                        // Gửi phạm vi ngày tạo đến ReportStatusList và tải lại danh sách
                        SalesReportList.getList().setCreatedAtFrom(fromDate);
                        SalesReportList.getList().setCreatedAtTo(toDate);
                        SalesReportList.getList().load();
                    };
                }
            }
        })();
        //
        var SalesReportList = function() {
            var list;
            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('App\Http\Controllers\Sales\Report\SalesReportController@list') }}",
                        container: document.querySelector('#SalesReportIndexContainer'),
                        listContent: document.querySelector('#SalesReportIndexListContent'),
                    });
                    list.load();
                },
                getList: function() {
                    return list;
                }
            }
        }();
        //
        var DataList = class {
            constructor(options) {
                if (!options.url) {
                    throw new Error('Bug: list url not found!');
                }
                this.initUrl = options.url;

                this.url = options.url;
                this.container = options.container;
                this.listContent = options.listContent;

                this.industries;
                this.sales;
                this.saleSups;
                //
                this.events();
            }

            //
            setUrl(url) {
                this.url = url;
            }
            //pagination
            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
            }
            getTagId() {
                const selectedOptions = Array.from(this.getTagSelectBox().selectedOptions);
                return selectedOptions.map(option => option.value);
            }
            //updated_at_from
            setCreatedAtFrom(createdAtFrom) {
                this.updated_at_from = createdAtFrom;
            }
            getCreatedAtFrom() {
                return this.updated_at_from;
            };
            //updated_at_to
            setCreatedAtTo(createdAtTo) {
                this.updated_at_to = createdAtTo;
            }
            getCreatedAtTo() {
                return this.updated_at_to;
            };
            getAccountIds() {
                return $(this.container).find('[name="account_ids[]"]').select2('val');
            };
            //Filter Industry
            setIndustries(industries) {
                this.industries = industries;
            };
            getIndustries() {
                return this.industries;
            };
            //Filter sales
            setSales(sales) {
                this.sales = sales;
            };
            getSales() {
                return this.sales;
            };
            //Filter Salesups
            setSaleSups(saleSups) {
                this.saleSups = saleSups;
            };
            getSaleSups() {
                return this.saleSups;
            };

            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            }
            //per_page
            getPerPageSelectBox() {
                return this.listContent.querySelector('[list-control="per-page"]');
            }
            //per_page
            setPagePage(number) {
                this.per_page = number;
            }
            getPerPage() {
                return this.per_page;
            }
            //nd mục List
            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            }
            events() {
                //Khi mà click vào nút lọc
                this.getFilterButton().addEventListener('click', (e) => {
                    if (!this.isFilterActionBoxShowed()) {
                        this.showFilterActionBox();
                    } else {
                        this.hideFilterActionBox();
                    }
                });
            }
            initContentEvents() {
                //khi nd danh sach co cac muc
                if (this.getListItemsCount()) {
                    //lam cho pagination cai ajax
                    this.getContentPageLinks().forEach(link => {
                        link.addEventListener('click', (e) => {
                            e.preventDefault();
                            //init
                            var url = link.getAttribute('href');
                            //load
                            this.setUrl(url);
                            //load list
                            this.load();
                        });
                    });
                    //per_page
                    $(this.getPerPageSelectBox()).on('change', (e) => {
                        e.preventDefault();

                        var number = this.getPerPageSelectBox().value;

                        this.setPagePage(number);

                        this.setUrl(this.initUrl);
                        this.load();
                    });
                }
            }
            getFilterButton() {
                return document.getElementById('filterButton');
            }
            getFilterActionBox() {
                return this.container.querySelector('[list-action="filter-action-box"]');
            }
            getFilterIcon() {
                return document.getElementById('filterIcon');
            }
            showFilterActionBox() {
                this.getFilterActionBox().classList.remove('d-none');
                this.getFilterIcon().innerHTML = 'expand_less'
            }
            hideFilterActionBox() {
                this.getFilterActionBox().classList.add('d-none');
                this.getFilterIcon().innerHTML = 'expand_more'
            }
            // click Filter
            isFilterActionBoxShowed() {
                return !this.getFilterActionBox().classList.contains('d-none');
            }

            loadContent(content) {
                $(this.listContent).html(content);
                //

                // init content
                initJs(this.listContent);
            }
            load() {
                // this.addLoadEffect();
                if (this.listXhr) {
                    this.listXhr.abort();
                }

                this.listXhr = $.ajax({
                    url: this.url,
                    data: {
                        updated_at_from: this.getCreatedAtFrom(),
                        updated_at_to: this.getCreatedAtTo(),

                        industries: this.getIndustries(),
                        sales: this.getSales(),
                        saleSups: this.getSaleSups(),
                        //per_page
                        per_page: this.getPerPage(),

                        account_ids: this.getAccountIds(),

                    }
                }).done((content) => {
                    this.loadContent(content);
                    //
                    this.initContentEvents();

                }).fail(function() {

                });
            };
        }
    </script>
@endsection
