@extends('layouts.main.app', [
    'menu' => 'edu',
])

@section('sidebar')
    @include('edu.modules.sidebar', [
        'menu' => 'reporting',
        'sidebar' => 'student_section_report',
    ])
@endsection

@section('content')
    {{-- @include('helpers.alert_updating') --}}
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Bảng kê chi tiết buổi học theo ngày</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="#" class="text-muted text-hover-primary">Trang chính</a>
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
                <li class="breadcrumb-item text-dark">Báo cáo chi tiết buổi học theo ngày</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1 d-none">
            <!--begin::Button-->
            <button data-action="under-construction" list-action="create-constract"
                class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" id="buttonCreateConstract">
                <span class="material-symbols-rounded me-2">
                    add
                </span>
                Xuất file excel
            </button>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>

    <div id="StudentHourReportIndexContainer" class="position-relative" id="kt_post">
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
                            <div class="col-md-3 d-none">
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
                                        class="form-control" placeholder=""  />
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
                        
                        <div class="col-md-6">
                            <div class="form-outline pt-8">
                                <div class="d-flex align-items-center">
                                    <button type="button" id="runButton" class="btn btn-primary ms-2" style="padding-top: 7px; padding-bottom: 7px;">
                                            <span>Báo cáo</span>   
                                        </button>
                                    <button type="button" id="exportButton" class="btn btn-primary ms-2"  style="padding-top: 7px; padding-bottom: 7px;">
                                        <span class="indicator-label">Xuất Excel</span>
                                        <span class="indicator-progress">Đang xử lý...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
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
        <div id="StudentHourReportIndexListContent">
        </div>
    </div>
    <script>
        $(function() {
            //list
            StudentHourReportList.init();
            PopupStudentHourDetailReport.init();

        });

        var StudentHourReportList = function() {
            var list;

            return {
                init: function() {

                    // list
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\Edu\Report\StudentSectionReportController@list') }}",
                        container: document.querySelector('#StudentHourReportIndexContainer'),
                    });
                    //Fillter
                    new FilterData({
                        list: list,
                    })
                    // load list
                    list.load();
                },

                getList: function() {
                    return list;
                },
            }
        }();

        //
        var DataList = class {
            constructor(options) {
                //
                if (!options.url) {
                    throw new Error('Bug: list url not found!');
                }
                this.url = options.url;
                this.container = options.container;
                this.listContent = this.getContainer().querySelector('#StudentHourReportIndexListContent');
            
                //
                this.perpage;
                this.page;
                // this.accountIds = [];            
            }

            getContainer() {
                return this.container;
            }

            getContent() {
                return this.listContent;
            }

            setUrl(url) {
                this.url = url;
            }
            //pagination
            setPerpage(perpage) {
                this.perpage = perpage;
            };

            setPage(page) {
                this.page = page;
            };
             // 
            getListItemsCount() {
                return this.getContent().querySelectorAll('[list-control="item"]').length;
            }
            getDetailHourButtons() {
                return this.listContent.querySelectorAll('[row-action="detail-student"]');
            }

            //tạo sự kiện
            initContentEvents() {
                //khi nd danh sach co cac muc
                if (this.getListItemsCount()) {
                    //làm cho cái pagination ajax
                    this.getContentPageLinks().forEach(url => {
                        url.addEventListener('click', (e) => {
                            e.preventDefault();

                            // init
                            var pageNumber = Number(url.getAttribute('href').slice(-1));

                            this.setPage(pageNumber);

                            // Reload page
                            this.load();
                        });
                    });
                    //Pagination per page
                    $('#perPage').change(() => {
                        const perPage = $('#perPage').val();
                        this.setPerpage(perPage);
                        this.setPage(1);
                        this.load();
                    });

                    this.getDetailHourButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');
                            PopupStudentHourDetailReport.load(url);
                        });
                    });
                }
            }
            //pagination ajax
            getContentPageLinks() {
                return this.getContent().querySelectorAll('a.page-link');
            }
            //
            loadContent(content) {
                $(this.getContent()).html(content);

                //
                initJs(this.getContent());
            }

            load() {
                //ajax request list via url
                if (this.listXhr) {
                    this.listXhr.abort();
                }

                var data = {
                    //paginate per page
                    page: this.page,
                    perpage: this.perpage
                }

                if (this.processData) {
                    data = this.processData(data);
                }

                this.listXhr = $.ajax({
                    url: this.url,
                    data: data,
                }).done((content) => {
                    this.loadContent(content);
                    //
                    this.initContentEvents();

                }).fail(function() {

                })
            }
        }
        //
        var PopupStudentHourDetailReport = function() {
            var updatePopup;
            return {
                init: function(updateUrl) {
                    
                    updatePopup = new Popup({
                        url: updateUrl, 
                    });

                },
                load: function(updateUrl) {
                    updatePopup.url = updateUrl;
                    updatePopup.load();
                },
                getPopup: function() {
                    return updatePopup;
                },
            };
        }();
        //
        var FilterData = class {
            constructor(options) {
                this.list = options.list;

                this.list.processData = (data) => {
                    //update_from
                    const updateAtFromElement = this.getUpdateAtFrom();
                    const updateAtToElement = this.getUpdateAtTo();
                    // const accountIdSelectBox = this.getAccountIdSelectBox();

                    if (updateAtFromElement && updateAtFromElement.value) {
                        data.updated_at_from = updateAtFromElement.value;
                    }

                    if (updateAtToElement && updateAtToElement.value) {
                        data.updated_at_to = updateAtToElement.value;
                    }

                    return data;
                }

                this.events();
            }

            getUpdateAtFrom() {
                return this.list.getContainer().querySelector('[name="updated_at_from"]');
            }

            getUpdateAtTo() {
                return this.list.getContainer().querySelector('[name="updated_at_to"]');
            }

            // getAccountIdSelectBox() {
            //     return this.list.getContainer().querySelector('[name="account_ids[]"]');
            // }

            events() {
                $('#runButton').on('click', () => {
                    this.list.load();
                });
                $('#exportButton').on('click', () => {
                    let query = $.param({
                        updated_at_from: this.getUpdateAtFrom().value,
                        updated_at_to: this.getUpdateAtTo().value,
                    });

                    $.ajax({
                        url: "{{ action('\App\Http\Controllers\Edu\Report\StudentSectionReportController@export') }}?" + query,
                        method: 'GET',
                        xhrFields: {
                            responseType: 'blob'
                        },
                        beforeSend: function() {
                                // Show loading indicator
                                $('#exportButton .indicator-label').hide();
                                $('#exportButton .indicator-progress').show();

                                //
                                addMaskLoading('Đang xuất dữ liệu ra Excel file. Vui lòng chờ...');
                        },
                        success: function(data) {
                            var a = document.createElement('a');
                            var url = window.URL.createObjectURL(data);
                            a.href = url;
                            a.download = 'student_sections.xlsx';
                            document.body.append(a);
                            a.click();
                            a.remove();
                            window.URL.revokeObjectURL(url);
                            // Hide loading 
                            $('#exportButton .indicator-label').show();
                            $('#exportButton .indicator-progress').hide();

                            //
                            removeMaskLoading();
                        },
                        error: function() {
                            alert('An error occurred while exporting the data.');
                        }
                    });
                });
            }
        };
    </script>
@endsection
