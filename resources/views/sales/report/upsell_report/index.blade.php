@extends('layouts.main.app', [
    'menu' => 'sales',
])

@section('sidebar')
    @include('sales.modules.sidebar', [
        'menu' => 'reporting',
        'sidebar' => 'upsell-report',
    ])
@endsection

@section('content')

    {{-- @include('helpers.alert_updating') --}}

    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Báo cáo Upsell đào tạo</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index']) }}" class="text-muted text-hover-primary">Trang chính</a>
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
                <li class="breadcrumb-item text-dark">Upsell đào tạo</li>
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
                    href="{{ action([\App\Http\Controllers\Sales\Report\UpsellReportController::class, 'showFilterForm']) }}"
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

    <div id="UpsellReportIndexContainer" class="position-relative" id="kt_post">
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
                        @if (Auth::user()->hasPermission(App\Library\Permission::SALES_REPORT_ALL))
                            <div class="col-md-3">
                                <label class="form-label fw-semibold mb-1">Nhân viên</label>
                                <div class="form-outline">
                                    <select name="account_ids[]" data-control="select2-ajax"
                                        data-url="{{ action('App\Http\Controllers\AccountController@select2') }}"
                                        class="form-control"
                                        data-dropdown-parent=""
                                        data-control="select2" data-placeholder="Chọn nhân viên"
                                        multiple
                                    >
                                        <option selected value="{{ Auth::user()->account->id }}">{{ Auth::user()->account->name }}</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                        <div class="col-md-3">
                            <label class="form-label fw-semibold mb-1">Từ ngày</label>
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
                                ">Báo cáo</button>
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
                        <div class="justify-content-end me-3">
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
                            class="btn btn-outline btn-outline-default" id="filter-orders-btn">
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


                        <!--end::Actions-->

                        <div class="col-md-6 mb-5">
                            <label class="form-label">Ngày tạo (Từ - Đến)</label>
                            <div class="row" list-action="created_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input name="created_at_from" placeholder="=asas" type="date"
                                            class="form-control" placeholder="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input name="created_at_to" type="date" class="form-control"
                                            placeholder="" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-5">
                            <label class="form-label">Ngày cập nhật (Từ - Đến)</label>
                            <div class="row" list-action="updated_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input name="updated_at_from" type="date" class="form-control"
                                            placeholder="" />
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <input name="updated_at_to" type="date" class="form-control"
                                            placeholder="" />
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
        <!--end::Card header-->
        <div id="UpsellReportIndexListContent">
        </div>
    </div>
    <script>
        $(function() {
            UpsellReportIndex.init();
        });
        //
        var UpsellReportIndex = function() {
            return {
                init: function() {
                    UpsellReportList.init();
                    //
                    FilterData.init();
                    //
                    ExportExcel.init();
                }
            };
        }();
        //
        var ExportExcel = function() {
            var popupExcelContactStatusReport;

            // show campaign modal
            var showExportModal = function() {
                popupExcelContactStatusReport.load();
            };

            return {
                init: function() {
                    // create campaign popup
                    popupExcelContactStatusReport = new Popup({
                        url: "{{ action('\App\Http\Controllers\Sales\Report\UpsellReportController@showFilterForm') }}",
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
                    return popupExcelContactStatusReport;
                }
            };
        }();
        //
        var FilterData = function() {
            return {
                init: () => {
                    $('#runButton').on('click', function() {
                        applyDateFilter();
                    });
                    function applyDateFilter() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();
                        // Gửi phạm vi ngày tạo đến UpsellReportList và tải lại danh sách
                        UpsellReportList.getList().setCreatedAtFrom(fromDate);
                        UpsellReportList.getList().setCreatedAtTo(toDate);
                        UpsellReportList.getList().load();
                    };
                }
            };
        }();
        //
        var UpsellReportList = function() {
            var list;
            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('App\Http\Controllers\Sales\Report\UpsellReportController@list') }}",
                        container: document.querySelector('#UpsellReportIndexContainer'),
                        listContent: document.querySelector('#UpsellReportIndexListContent'),
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
            }

            //
            setUrl(url) {
                this.url = url;
            }
            //pagination
            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
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
            initContentEvents() {
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
            loadContent(content) {
                $(this.listContent).html(content);
                //

                // init content
                initJs(this.listContent);
            }
            load() {
                // this.addLoadEffect();
                $.ajax({
                    url: this.url,
                    data: {
                        updated_at_from: this.getCreatedAtFrom(),
                        updated_at_to: this.getCreatedAtTo(),

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