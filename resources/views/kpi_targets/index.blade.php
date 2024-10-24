@extends('layouts.main.app',[
    'menu' => 'accounting'
])

@section('sidebar')
    @include('accounting.modules.sidebar', [
        'menu' => 'kpi-target',
        'sidebar' => 'kpi-target',
    ])
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Kế hoạch KPI</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="../../demo5/dist/index.html" class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Bảng kế hoạch</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <a id="ImportKpiTargetButton" href="{{ action([App\Http\Controllers\KpiTargetController::class, 'importUpload']) }}" type="button" class="btn btn-outline btn-outline-default me-2">
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded me-2">
                        deployed_code_update
                    </span>
                    <span>Nhập dữ liệu</span>
                </span>
            </a>

            <a href="{{ action([App\Http\Controllers\KpiTargetController::class, 'importDownloadTemplate']) }}"
                type="button" class="btn btn-outline btn-outline-default me-2"
            >
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded me-2">
                        download
                    </span>
                    <span>Tải mẫu dữ liệu</span>
                </span>
            </a>

            <!--begin::Button-->
            <button id="btnKpiTargetCreate" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px">
                <span class="material-symbols-rounded me-2">
                    add
                </span>
                Thêm kế hoạch
            </button>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div id="KpiTargetContainer" class="position-relative" id="kt_post">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 px-4">
                <!--begin::Group actions-->
                <div list-action="top-action-box" class="menu d-flex justify-content-end align-items-center d-none"
                    data-kt-menu="true">
                    <div class="menu-item my-3" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start">
                        <!--begin::Menu link-->
                        <button type="button" class="btn btn-outline btn-outline-default px-9 "
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Thao tác
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                        </button>
                        <!--end::Menu link-->
                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown p-3 w-200px">

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a list-action="delete-all" href="{{ action([App\Http\Controllers\KpiTargetController::class, 'deleteAll']) }}" class="menu-link px-3">
                                    <span class="menu-title" id="buttonDeleteAccounts">Xóa kế hoạch đã chọn</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->

                    <div class="m-2 font-weight-bold">
                        <div list-control="count-label"></div>
                    </div>
                </div>
                <!--end::Group actions-->

                <!--begin::Card title-->
                <div class="card-title" list-action="search-action-box">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input list-action="keyword-input" type="text" data-kt-customer-table-filter="search"
                            class="form-control w-250px ps-12" placeholder="Nhập để tìm kế hoạch" />
                    </div>
                    <!--end::Search-->
                </div>

                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar" list-action="tool-action-box">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end">
                        <div class="justify-content-end me-3">
                            <td class="text-end">
                                <button type="button" class="btn btn-outline btn-outline-default"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
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
                                                <a data-control="dropdown-close-button" href="javascript:;" class="dropdown-close-button">
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
                        <button type="button" class="btn btn-outline btn-outline-default" id="filterButton">
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
                        <div class="d-inline-block ms-2">
                            @include('components.zoom_button')
                        </div>
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <!--begin::Menu 1-->
            <div class="card-header border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
                <!--begin::Card toolbar-->
                <div class="ccard-toolbar mb-0 w-100" list-action="tool-action-box">
                    <div class="row">
                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Phân loại:</label>
                            <!--end::Label-->
                            <div>
                                <select name="type" class="form-select" data-control="select2" data-allow-clear="true"
                                    data-kt-select2="true" data-placeholder="Chọn loại">
                                    <option></option>
                                    @foreach (\App\Models\KpiTarget::getTypeOptions() as $option)
                                        <option value="{{ $option['value'] }}">{{ $option['text'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Nhân viên</label>
                            <!--end::Label-->
                            <div>
                                <select name="account_ids[]" data-control="select2-ajax"
                                    data-url="{{ action('App\Http\Controllers\AccountController@select2') }}"
                                    class="form-control @if ($errors->has('account_id')) is-invalid @endif"
                                    data-dropdown-parent=""
                                    data-control="select2" data-placeholder="Chọn nhân viên" multiple
                                >
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-5">
                            <div class="row" list-action="created_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <label class="form-label">Từ ngày</label>
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button"
                                        >
                                            <input data-control="input" type="date" name="start_at" class="form-control" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <label class="form-label">Đến ngày</label>
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button"
                                        >
                                            <input data-control="input" type="date" name="end_at" class="form-control" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Menu 1-->
            <!--end::Filter-->
        </div>
        <!--end::Toolbar-->

        <div list-control="content">
        </div>
    </div>
    <!--end::Post-->


    <script>
        var ImportKpiTarget;

        $(function() {
            // list
            KpiTargetList.init();

            // create KPI target
            CreateKpiTarget.init();

            // Import KPI targets
            ImportKpiTarget = new ImportKpiTargetManager({
                button: document.getElementById('ImportKpiTargetButton'),
            });
        });

        var ImportKpiTargetManager = class {
            constructor(options) {
                this.button = options.button;

                // the popup
                this.popup = new Popup({
                    url: this.getButton().getAttribute('href'),
                });

                // events
                this.events();
            }

            getButton() {
                return this.button;
            }

            getPopup() {
                return this.popup;
            }

            events() {
                this.getButton().addEventListener('click', (e) => {
                    e.preventDefault();

                    this.getPopup().load();
                });
            }

            loadPreview(url) {
                this.getPopup().url = url;
                this.getPopup().load();
            }
        }

        //
        var KpiTargetList = function() {
            var list;

            return {
                init: function() {
                    // columns
                    ContactColumnManager.init();
                    
                    // list
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\KpiTargetController@list') }}",
                        container: document.querySelector('#KpiTargetContainer'),
                    });

                    // Filter
                    new KpiTargetFilter({
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
                // Nén ngoại lệ để đảm bảo có url
                if (!options.url) {
                    throw new Error('Bug: list url not found!');
                }
                this.url = options.url;
                this.container = options.container;
                this.listContent = this.getContainer().querySelector('[list-control="content"]');

                this.keyword;

                //
                this.sort_by;
                this.sort_direction;

                //
                this.perpage;
                this.page;
                this.accountIds = [];

                //
                this.events();
            }

            getContainer() {
                return this.container;
            }

            getContent() {
                return this.listContent;
            }

            //
            setKeyword(keyword) {
                this.keyword = keyword;
            }
    
            getKeyword() {
                return this.keyword;
            }

            getFilterButton() {
                return document.getElementById('filterButton');
            }
            // lam cho sk click Filter
            getFilterActionBox() {
                return this.getContainer().querySelector('[list-action="filter-action-box"]');
            }
            //
            getFilterIcon() {
                return document.getElementById('filterIcon');
            }

            //lấy id các mục dã chọn
            getSelectedIds() {
                const ids = [];

                this.getListCheckedBoxes().forEach((checkbox) => {
                    ids.push(checkbox.value);
                });

                return ids;
            }

            events() {
                // Đxử lý các sự kiện liên quan đến tìm kiếm dữ liệu
                this.getkeywordInput().addEventListener('keyup', (e) => {
                    this.setKeyword(this.getkeywordInput().value);

                    // enter key
                    if (event.key === "Enter") {
                        // 
                        this.load();
                    }
                });

                // theo dôi người dùng ra khòi ô tìm kiếm
                // this.getkeywordInput().addEventListener('keyup', (e) => {
                //     this.load();
                // }); //change

                //Khi mà click vào nút lọc
                this.getFilterButton().addEventListener('click', (e) => {
                    if (!this.isFilterActionBoxShowed()) {
                        this.showFilterActionBox();
                    } else {
                        this.hideFilterActionBox();
                    }
                });

                // handle delete all actions
                DeleteAllKpiHandler.init(this);
            }

            //them hieu ung tai
            addLoadEffect() {
                this.getContent().classList.add('list-loading');

                // cho biết dữ liệu đang đc loader
                if (!this.getContainer().querySelector('[list-action="loader"]')) {
                    $(this.getContent()).before(`
                    <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);
                }
            }

            // Pthức dùng để đặt lại  url trong đối tượng DataList
            setUrl(url) {
                this.url = url;
            }

            // Sort

            getSortBy() {
                return this.sort_by;
            };

            // Sort direction

            getSortDirection() {
                return this.sort_direction;
            };

            //pagination
            setPerpage(perpage) {
                this.perpage = perpage;
            };

            setPage(page) {
                this.page = page;
            };

            //xoa hieu ung tai
            removeLoadEffect() {
                this.getContent().classList.remove('list-loading');

                // remove loader
                if (this.getContainer().querySelector('[list-action="loader"]')) {
                    this.getContainer().querySelector('[list-action="loader"]').remove();
                }
            }

            // 
            getListItemsCount() {
                return this.getContent().querySelectorAll('[list-control="item"]').length;
            }

            // tạo sự kiện
            initContentEvents() {
                // 
                SortManager.init(this);

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

                    // khi mà click vào cái nut check all ở table list header
                    this.getCheckAllButton().addEventListener('change', (e) => {
                        var checked = this.getCheckAllButton().checked;

                        if (checked) {
                            // check all list checkboxes
                            this.checkAllList();
                        } else {
                            // check all list checkboxes
                            this.uncheckAllList();
                        }
                    });

                    // khi nhấn vào từng checkbox từng dòng thì làm gì nut button all hien
                    this.getListCheckboxes().forEach(checkbox => {
                        checkbox.addEventListener('change', (e) => {
                            var checked = checkbox.checked;

                            if (checked) {
                                //  
                                if (this.checkedCount() == this.getListCheckboxes().length) {
                                    this.getCheckAllButton().checked = true;
                                }
                            } else {
                                //
                                if (this.checkedCount() < this.getListCheckboxes().length) {
                                    this.getCheckAllButton().checked = false;
                                }
                            }
                        });
                    });

                    // khi có bất cứ dòng nào được check trong list thì hiện cái top list action
                    this.getListCheckboxes().forEach(checkbox => {
                        checkbox.addEventListener('change', (e) => {
                            var checked = checkbox.checked;

                            if (this.checkedCount() > 0) {
                                // show top list action box
                                this.showTopListActionBox();
                                // hide SearchBoxers
                                this.hideSearchBoxes();
                                //
                                this.hideToolBoxes();
                                //
                                this.hideFilterActionBox();
                            } else {
                                // hide top list action box
                                this.hideTopListActionBox();
                                //show Search Boxes
                                this.showSearchBoxes();
                                //
                                this.showToolBoxes();
                                //

                            }
                        });
                    });

                    // khi mà click vào cái nut check all ở table list header
                    this.getCheckAllButton().addEventListener('change', (e) => {
                        var checked = this.getCheckAllButton().checked;

                        if (this.checkedCount() > 0) {
                            // show top list action box
                            this.showTopListActionBox();
                            // hide SearchBoxers
                            this.hideSearchBoxes();
                            //
                            this.hideToolBoxes();
                            //
                            this.hideFilterActionBox();
                        } else {
                            // hide top list action box
                            this.hideTopListActionBox();
                            //show Search Boxes
                            this.showSearchBoxes();
                            //
                            this.showToolBoxes();
                        }
                    });

                    // update handler
                    UpdateKpiTarget.init(this);

                    // delete handler
                    DeleteKpiTarget.init(this);
                }
            }
            //
            showTopListActionBox() {
                this.getTopListActionBox().classList.remove('d-none');
            }
            hideTopListActionBox() {
                this.getTopListActionBox().classList.add('d-none');
            }
            //
            showSearchBoxes() {
                this.getSearchBoxes().classList.remove('d-none');
            }
            hideSearchBoxes() {
                this.getSearchBoxes().classList.add('d-none');
            }
            //
            showToolBoxes() {
                this.getToolBoxes().classList.remove('d-none');
            }
            hideToolBoxes() {
                this.getToolBoxes().classList.add('d-none');
            }
            // click Filter
            isFilterActionBoxShowed() {
                return !this.getFilterActionBox().classList.contains('d-none');
            }
            //khi click Filter show.
            showFilterActionBox() {
                this.getFilterActionBox().classList.remove('d-none');
                this.getFilterIcon().innerHTML = 'expand_less'
            }
            //khi click Filter hide.
            hideFilterActionBox() {
                this.getFilterActionBox().classList.add('d-none');
                this.getFilterIcon().innerHTML = 'expand_more'
            }

            // nut check all button
            getCheckAllButton() {
                if (!this.getContent().querySelector('[list-action="check-all"]')) {
                    throw new Error('Bug: Check all button not found!');
                }
                return this.getContent().querySelector('[list-action="check-all"]');
            }

            //pagination ajax
            getContentPageLinks() {
                return this.getContent().querySelectorAll('a.page-link');
            }

            getkeywordInput() {
                return this.getContainer().querySelector('[list-action="keyword-input"]');
            }

            getListCheckboxes() {
                return this.getContent().querySelectorAll('[list-action="check-item"]');
            }

            getTopListActionBox() {
                return this.getContainer().querySelector('[list-action="top-action-box"]');
            }
            //
            getSearchBoxes() {
                return this.getContainer().querySelector('[list-action="search-action-box"]');
            }
            //
            getToolBoxes() {
                return this.getContainer().querySelector('[list-action="tool-action-box"]');
            }

            checkedCount() {
                return this.getContent().querySelectorAll('[list-action="check-item"]:checked').length;
            }

            checkAllList() {
                this.getListCheckboxes().forEach(checkbox => {
                    checkbox.checked = true;
                });
            }

            //lấy id các mục dã chọn
            getSelectedIds() {
                const ids = [];

                this.getListCheckedBoxes().forEach((checkbox) => {
                    ids.push(checkbox.value);
                });

                return ids;
            }

            getListCheckedBoxes() {
                return this.getContent().querySelectorAll('[list-action="check-item"]:checked');
            }

            uncheckAllList() {
                this.getListCheckboxes().forEach(checkbox => {
                    checkbox.checked = false;
                });
            }


            loadContent(content) {
                $(this.getContent()).html(content);

                // always hide list action box and show 
                this.hideTopListActionBox();
                this.showSearchBoxes();
                this.showToolBoxes();

                // init content
                initJs(this.getContent());
            }

            load() {
                this.addLoadEffect();

                // ajax request list via url
                if (this.listXhr) {
                    this.listXhr.abort();
                }

                var data = {
                    keyword: this.getKeyword(),
                    
                    //sort
                    sort_by: SortManager.getSortBy(),
                    sort_direction: SortManager.getSortDirection(),

                    //paginate per page
                    page: this.page,
                    perpage: this.perpage,

                    // columns manager
                    columns: ContactColumnManager.getColumns(),
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

                    // 
                    this.removeLoadEffect();

                    // apply
                    ContactColumnManager.applyToList();
                }).fail(function() {

                });
            }
        }

        // Filters
        var KpiTargetFilter = class {
            constructor(options) {
                this.list = options.list;

                // handle list data
                this.list.processData = (data) => {
                    // type
                    if (this.getTypeSelectBox().value) {
                        data.type = this.getTypeSelectBox().value;
                    }

                    // start_at
                    if (this.getStartAtInput().value) {
                        data.start_at = this.getStartAtInput().value;
                    }

                    // end_at
                    if (this.getEndAtInput().value) {
                        data.end_at = this.getEndAtInput().value;
                    }

                    // account_id
                    if (this.getAccountIdSelectBox().value) {
                        data.account_ids = $(this.getAccountIdSelectBox()).select2('val');
                    }

                    return data;
                }

                //
                this.events();
            }

            getTypeSelectBox() {
                return this.list.getContainer().querySelector('[name="type"]');
            }

            getStartAtInput() {
                return this.list.getContainer().querySelector('[name="start_at"]');
            }

            getEndAtInput() {
                return this.list.getContainer().querySelector('[name="end_at"]');
            }

            getAccountIdSelectBox() {
                return this.list.getContainer().querySelector('[name="account_ids[]"]');
            }

            events() {
                $(this.getTypeSelectBox()).on('change', (e) => {
                    this.list.load();
                })

                $(this.getStartAtInput()).on('change', (e) => {
                    this.list.load();
                })

                $(this.getEndAtInput()).on('change', (e) => {
                    this.list.load();
                })

                $(this.getAccountIdSelectBox()).on('change', (e) => {
                    this.list.load();
                })
            }
        };

        //
        var ContactColumnManager = function() {
            var manager;

            return {
                init: function() {
                    manager = new ColumnsDisplayManagerClass({
                        name: ' {{ $listViewName }}',
                        saveUrl: '{{ action([App\Http\Controllers\UserController::class, 'saveListColumns']) }}',
                        columns: {!! json_encode($columns) !!},
                        optionsBox: document.querySelector('[columns-control="options-box"]'),
                        getList: function() {
                            return KpiTargetList.getList();
                        }
                    });
                },

                getColumns: function() {
                    return manager.getCheckedColumnIds();
                },

                applyToList: function() {
                    manager.applyToList();
                }
            }
        }();

        //
        var CreateKpiTarget = function() {
            var popup;
            var btnCreate;

            // show
            var load = function() {
                popup.load();
            };

            return {
                init: function() {
                    // create account popup
                    popup = new Popup({
                        url: "{{ action('\App\Http\Controllers\KpiTargetController@create') }}",
                    });

                    // create account  button
                    btnCreate = document.getElementById('btnKpiTargetCreate');

                    // nhấp vào nút tạo thẻ
                    btnCreate.addEventListener('click', (e) => {
                        e.preventDefault();

                        // hiển thị phương thức tạo thẻ
                        load();
                    });
                },

                getPopup: function() {
                    return popup;
                },
            };
        }();

        // Update KpiTarget
        var UpdateKpiTarget = function() {
            var list;
            var popup;
            var links;

            var handleLinksClick = function () {
                links.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();

                        var url = link.getAttribute('href');

                        loadPopup(url);
                    });
                });
            };

            var loadPopup = function (url) {
                popup.url = url;
                popup.load();
            };
            
            return {
                init: function(list) {
                    list = list;

                    // Khởi tạo popup chỉnh sửa chiến dịch
                    popup = new Popup();

                    // links
                    links = list.getContent().querySelectorAll('[row-action="update"]');

                    // 
                    handleLinksClick();
                },

                load: function(updateUrl) {
                    loadPopup(updateUrl);
                },

                getPopup: function() {
                    return popup;
                },
            };
        }();

        // Delete KpiTarget
        var DeleteKpiTarget = function() {
            var list;
            var links;

            var handleLinksClick = function () {
                links.forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();

                        var url = link.getAttribute('href');

                        deleteKpi(url);
                    });
                });
            };

            var deleteKpi = function (url) {
                // success alert
                ASTool.confirm({
                    message: 'Bạn có chắc chắn muốn xóa kế hoạch này chứ?',
                    ok: function() {
                        // effect
                        ASTool.addPageLoadingEffect();

                        // 
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                            }
                        }).done((response) => {
                            // thông báo thành công
                            ASTool.alert({
                                message: response.message,
                                ok: function() {
                                    // reload list
                                    KpiTargetList.getList().load();
                                }
                            });
                        }).fail(function() {

                        }).always(function() {
                            // effect
                            ASTool.removePageLoadingEffect();
                        });
                    }
                });
            };
            
            return {
                init: function(list) {
                    list = list;

                    // links
                    links = list.getContent().querySelectorAll('[row-action="delete"]');

                    // 
                    handleLinksClick();
                }
            };
        }();

        // Delete All selected KpiTarget
        var DeleteAllKpiHandler = function() {
            var list;
            var link;

            var deleteAll = function (list) {
                var url = link.getAttribute('href');

                // success alert
                ASTool.confirm({
                    message: 'Bạn có chắc chắn muốn xóa kế hoạch đã chọn chứ?',
                    ok: function() {
                        // effect
                        ASTool.addPageLoadingEffect();

                        // 
                        $.ajax({
                            url: url,
                            method: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                ids: list.getSelectedIds(),
                            }
                        }).done((response) => {
                            // thông báo thành công
                            ASTool.alert({
                                message: response.message,
                                ok: function() {
                                    // reload list
                                    KpiTargetList.getList().load();
                                }
                            });
                        }).fail(function() {

                        }).always(function() {
                            // effect
                            ASTool.removePageLoadingEffect();
                        });
                    }
                });
            };
            
            return {
                init: function(list) {
                    list = list;

                    // links
                    link = list.getContainer().querySelector('[list-action="delete-all"]');

                    // 
                    link.addEventListener('click', (e) => {
                        e.preventDefault();

                        deleteAll(list);
                    });
                }
            };
        }();
    </script>
@endsection
