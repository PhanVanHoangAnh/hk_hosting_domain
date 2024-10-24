@extends('layouts.main.app', [
    'menu' => 'system',
])

@section('sidebar')
    @include('system.modules.sidebar', [
        'menu' => 'settings',
        'sidebar' => 'demands',
        'type' => '',
    ])
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh mục đơn hàng</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="javascript:;" class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Cấu hình</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">

            <!--begin::Button-->
            <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px" id="buttonCreateDemand">
                <span class="material-symbols-rounded me-2">
                    person_add
                </span>
                Thêm mới đơn hàng
            </a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div id="DemandIndexContainer" class="position-relative" id="kt_post">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 px-4">
                <!--begin::Group actions-->
                <div list-action="top-action-box" class="menu d-flex justify-content-end align-items-center d-none"
                    data-kt-menu="true">
                    <div class="menu-item" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start">
                        <!--begin::Menu link-->
                        <button type="button" class="btn btn-outline btn-outline-default px-9 "
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Thao tác
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                        </button>
                        <!--end::Menu link-->

                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown p-3 w-200px">
                            <div class="menu-item px-3">
                                <a row-action="delete-all"
                                    href="{{ action([App\Http\Controllers\System\DemandController::class, 'destroyAll']) }}"
                                    class="menu-link px-3" list-action="sort">Xóa</a>
                            </div>
                        </div>
                        <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->
                    <div class="m-2 font-weight-bold">
                        <div list-control="count-label"></div>
                    </div>

                </div>
                <!--end::Group actions-->

                <div class="card-title" list-action="search-action-box">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input list-action="keyword-input" type="text" data-kt-demand-table-filter="search"
                            class="form-control w-250px ps-12" placeholder="Tìm đơn hàng" />
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

                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-600px" data-kt-menu="true"
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
            <div class="card-header border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
                <!--begin::Card toolbar-->
                <div class="card-toolbar mb-0 w-100 d-flex justify-content-center" list-action="tool-action-box">
                    <!--begin::Toolbar-->

                    <div class="row w-100">
                        <!--begin::Content-->
                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Người tạo</label>
                            <!--end::Label-->
                            <div>
                                <select list-action="account-select" data-control="select2-ajax"
                                    data-url="{{ action('App\Http\Controllers\AccountController@select2') }}"
                                    class="form-control @if ($errors->has('creator_id')) is-invalid @endif"
                                    data-dropdown-parent="" data-control="select2" data-placeholder="Chọn nhân viên"
                                    multiple>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Tình trạng đơn hàng</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="status-select" class="form-select filter-select"
                                    data-control="select2" data-placeholder="Chọn tình trạng đơn hàng"
                                    data-allow-clear="true">
                                    {{-- <option value="all">Chọn tất cả</option> --}}
                                    @foreach (App\Models\Demand::getAllStatus() as $status)
                                        <option value="{{ $status }}">
                                            {{ trans('messages.demand.status.' . $status) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-5">
                            <label class="form-label">Ngày tạo (Từ - Đến)</label>
                            <div class="row" list-action="created_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="created_at_from" placeholder="=asas"
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
                                            <input data-control="input" name="created_at_to" placeholder="=asas"
                                                type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <label class="form-label">Ngày cập nhật (Từ - Đến)</label>
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
                        <!--end::Actions-->
                    </div>

                    <!--end::Menu 1-->
                    <!--end::Filter-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->

            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <div id="DemandsIndexListContent">
        </div>


    </div>
    <!--end::Post-->

    <script>
        $(function() { // document ready
            //
            DemandsIndex.init();
        });

        //
        var DemandsIndex = function() {
            return {
                init: function() {

                    // ColumnsDisplayManager
                    DemandColumnManager.init();

                    // Create Demand
                    CreateDemandPopup.init();

                    // Update Demand
                    UpdateDemandPopup.init();

                    // list
                    DemandsList.init();

                    //filter
                    FilterData.init();


                }
            };
        }();

        var DemandColumnManager = function() {
            var manager;

            return {
                init: function() {
                    manager = new ColumnsDisplayManagerClass({
                        name: '{{ $listViewName }}',
                        saveUrl: '{{ action([App\Http\Controllers\UserController::class, 'saveListColumns']) }}',
                        columns: {!! json_encode($columns) !!},
                        optionsBox: document.querySelector('[columns-control="options-box"]'),
                        getList: function() {
                            return DemandsList.getList();
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
        var CreateDemandPopup = function() {
            var popupCreateDemand;
            var buttonCreateDemand;

            // show campaign modal
            var showDemandModal = function() {
                popupCreateDemand.load();
            };

            return {
                init: function() {
                    // create campaign popup
                    popupCreateDemand = new Popup({
                        url: "{{ action('\App\Http\Controllers\System\DemandController@create') }}",

                    });

                    // create campaign button
                    buttonCreateDemand = document.getElementById('buttonCreateDemand');

                    // click on create campaign button
                    buttonCreateDemand.addEventListener('click', (e) => {
                        e.preventDefault();

                        // show create campaign modal
                        showDemandModal();
                    });
                },

                getPopup: function() {
                    return popupCreateDemand;
                }
            };
        }();

        //
        var UpdateDemandPopup = function() {
            var popupUpdateDemand;
            return {
                init: function(updateUrl) {
                    // Khởi tạo popup chỉnh sửa chiến dịch
                    popupUpdateDemand = new Popup({
                        url: updateUrl, // Sử dụng URL được chuyền vào từ tham số
                    });
                },

                load: function(url) {
                    popupUpdateDemand.url = url;
                    popupUpdateDemand.load(); // Hiển thị cửa sổ chỉnh sửa
                },


                getPopup: function() {
                    return popupUpdateDemand;
                },

            };
        }();


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
                    $('[list-action="status-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        DemandsList.getList().setStatus(selectedValues);

                        // load list
                        DemandsList.getList().load();
                    });

                    $('[list-action="account-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        DemandsList.getList().setAccountId(selectedValues);

                        // load list
                        DemandsList.getList().load();
                    });

                    $('[list-action="created_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="created_at_from"]').val();
                        var toDate = $('[name="created_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến DemandsList và tải lại danh sách
                        DemandsList.getList().setCreatedAtFrom(fromDate);
                        DemandsList.getList().setCreatedAtTo(toDate);
                        DemandsList.getList().load();
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến DemandsList và tải lại danh sách
                        DemandsList.getList().setUpdatedAtFrom(fromDate);
                        DemandsList.getList().setUpdatedAtTo(toDate);
                        DemandsList.getList().load();
                    });
                }
            };
        })();

        var SortManager = function() {
            var theList;
            var sortButtons;
            var currentSortBy;
            var currentSortDirection;
            var sort = function(sortBy, sortDirection) {
                setSort(sortBy, sortDirection);

                theList.load();
            };
            var setSort = function(sortBy, sortDirection) {
                currentSortBy = sortBy;
                currentSortDirection = sortDirection;
            };

            var getButtonBySortBy = function(sortBy) {
                var selectedButton;

                sortButtons.forEach(button => {
                    if (sortBy == button.getAttribute('sort-by')) {
                        selectedButton = button;
                        return;
                    }
                });

                return selectedButton;
            };

            var isCurrentButton = function(button) {
                var sortBy = button.getAttribute('sort-by');

                return currentSortBy == sortBy;
            };

            return {
                init: function(list) {
                    theList = list;
                    sortButtons = theList.listContent.querySelectorAll('[list-action="sort"]');

                    // click on sort buttons
                    sortButtons.forEach(button => {
                        button.addEventListener('click', (e) => {
                            var sortBy = button.getAttribute('sort-by');
                            var sortDirection = button.getAttribute('sort-direction');

                            // đảo chiều sort nếu đang current
                            if (currentSortBy == sortBy) {
                                if (sortDirection == 'asc') {
                                    sortDirection = 'desc';
                                } else {
                                    sortDirection = 'asc';
                                }
                            }

                            sort(sortBy, sortDirection);
                        });
                    });
                },

                getSortBy: function() {
                    return currentSortBy;
                },

                getSortDirection: function() {
                    return currentSortDirection;
                },

                setSort: setSort,
            };
        }();

        var DemandsList = function() {
            var list;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\System\DemandController@list') }}",

                        container: document.querySelector('#DemandIndexContainer'),
                        listContent: document.querySelector(
                            '#DemandsIndexListContent'),
                    });
                    list.load();
                },

                getList: function() {
                    return list;
                }
            }
        }();

        var DataList = class {
            constructor(options) {
                // throw exception make sure there is a url
                if (!options.url) {
                    throw new Error('Bug: list url not found!');
                }

                this.initUrl = options.url;
                this.url = options.url;
                this.container = options.container;
                this.listContent = options.listContent;
                this.keyword;
                this.account_ids;
                this.status;
                this.sort_by;
                this.sort_direction;

                //
                this.events();
            }

            getDeleteAllItemsBtn() {
                return this.container.querySelector('[row-action="delete-all"]');
            };

            getCheckedItemBtns() {
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked');
            };

            getCheckedItemBtnsNumber() {
                return this.getCheckedItemBtns().length;
            };

            getItemCheckedIds() {
                let checkedBtnIds = [];

                this.getCheckedItemBtns().forEach(button => {
                    checkedBtnIds.push(Number(button.getAttribute('data-item-id')));
                });

                return checkedBtnIds;
            };

            getColumns() {
                return this.columns;
            }

            setKeyword(keyword) {
                this.keyword = keyword;
            }

            getKeyword() {
                return this.keyword;
            }

            getColumnsCheckboxes() {
                return this.container.querySelectorAll('[list-action="column-checker"]');
            }

            events() {
                // keyword input event. search when keyup
                this.getkeywordInput().addEventListener('keyup', (e) => {
                    this.setKeyword(this.getkeywordInput().value);
                    // enter key
                    if (event.key === "Enter") {
                        // this.setUrl(this.initUrl);
                        this.load();
                    }
                });

                // khi tick vào phần hiển thị column
                this.getColumnsCheckboxes().forEach(checkbox => {
                    // Lấy danh sách các checkbox
                    const checkboxes = this.getColumnsCheckboxes();

                    // event
                    checkbox.addEventListener('change', (e) => {
                        const checked = checkbox.checked;
                        const column = checkbox.value;

                        if (!checked) {
                            // Uncheck the "all" checkbox if any other checkbox is unchecked
                            // allCheckbox.checked = false;
                        }

                        // Xử lý thêm hoặc xóa cột khỏi danh sách cột nếu cần
                        if (checked) {
                            this.addColumn(column);
                        } else {
                            this.removeColumn(column);
                        }

                        // Load danh sách
                        this.load();
                    });
                });

                //Khi mà click vào nút lọc
                this.getFilterButton().addEventListener('click', (e) => {
                    if (!this.isFilterActionBoxShowed()) {
                        this.showFilterActionBox();
                    } else {
                        this.hideFilterActionBox();
                    }
                });
            }

            addColumn(column) {
                this.columns.push(column);
            }

            removeColumn(column) {
                this.columns = this.columns.filter(e => e !== column);
            }

            addLoadEffect() {
                this.listContent.classList.add('list-loading');

                // loader
                if (!this.container.querySelector('[list-action="loader"]')) {
                    $(this.listContent).before(`
                        <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `);
                }
            }

            setUrl(url) {
                this.url = url;
            }

            getSortBy() {
                return this.sort_by;
            };

            getSortDirection() {
                return this.sort_direction;
            };

            //created_at_from
            setCreatedAtFrom(createdAtFrom) {
                this.created_at_from = createdAtFrom;
            }

            getCreatedAtFrom() {
                return this.created_at_from;
            };

            //created_at_to
            setCreatedAtTo(createdAtTo) {
                this.created_at_to = createdAtTo;
            }

            getCreatedAtTo() {
                return this.created_at_to;
            };

            //updated_at_from
            setUpdatedAtFrom(updatedAtFrom) {
                this.updated_at_from = updatedAtFrom;
            }

            getUpdatedAtFrom() {
                return this.updated_at_from;
            };

            //updated_at_to
            setUpdatedAtTo(updatedAtTo) {
                this.updated_at_to = updatedAtTo;
            }

            getUpdatedAtTo() {
                return this.updated_at_to;
            };

            // Filter by account
            setAccountId(accountId) {
                this.account_ids = accountId;
            };

            getAccountId() {
                return this.account_ids;
            };

            //Status
            setStatus(status) {
                this.status = status;
            };

            getStatus() {
                return this.status;
            };
                
            removeLoadEffect() {
                this.listContent.classList.remove('list-loading');

                // remove loader
                if (this.container.querySelector('[list-action="loader"]')) {
                    this.container.querySelector('[list-action="loader"]').remove();
                }
            }

            getkeywordInput() {
                return this.container.querySelector('[list-action="keyword-input"]');
            }

            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
            }

            getFilterButton() {
                return document.getElementById('filterButton');
            }

            getCheckAllButton() {
                if (!this.listContent.querySelector('[list-action="check-all"]')) {
                    throw new Error('Bug: Check all button not found!');
                }

                return this.listContent.querySelector('[list-action="check-all"]');
            }

            getListCheckboxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]');
            }

            getListCheckedBoxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked');
            }

            checkedCount() {
                return this.getListCheckedBoxes().length;
            }

            getTopListActionBox() {
                return this.container.querySelector('[list-action="top-action-box"]');
            }

            getFilterActionBox() {
                return this.container.querySelector('[list-action="filter-action-box"]');
            }

            getFilterIcon() {
                return document.getElementById('filterIcon');
            }

            getSearchBoxes() {
                return this.container.querySelector('[list-action="search-action-box"]');
            }

            getToolBoxes() {
                return this.container.querySelector('[list-action="tool-action-box"]');
            }

            getDeleteButtons() {
                return this.listContent.querySelectorAll('[row-action="delete"]');
            }

            getUpdateButtons() {
                return this.listContent.querySelectorAll('[row-action="update"]');
            }

            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            }

            initContentEvents() {
                const _this = this;

                // 
                SortManager.init(this);

                /**
                 * DELETE Demand
                 */
                this.getDeleteAllItemsBtn().addEventListener('click', function(e) {
                    e.preventDefault();

                    const url = this.getAttribute('href');
                    const items = _this.getItemCheckedIds();
                    _this.hideTopListActionBox();
                    _this.showSearchBoxes();

                    ASTool.confirm({
                        message: "Bạn có chắc muốn xóa các đơn hàng này không?",
                        ok: function() {
                            ASTool.addPageLoadingEffect();
                            $.ajax({
                                url: url,
                                method: "POST",
                                data: {
                                    _token: "{{ csrf_token() }}",
                                    ids: items,
                                }
                            }).done(response => {
                                ASTool.alert({
                                    message: response.message,
                                    ok: function() {
                                        DemandsList.getList().load();
                                    }
                                })
                            }).fail(function() {}).always(function() {
                                ASTool.removePageLoadingEffect();
                            })
                        }
                    });
                });

                // when list content has items
                if (this.getListItemsCount()) {

                    // làm cho cái pagination ajax
                    this.getContentPageLinks().forEach(link => {
                        link.addEventListener('click', (e) => {
                            e.preventDefault();

                            // init
                            var url = link.getAttribute('href');

                            // load new url
                            this.setUrl(url);

                            // reload list
                            this.load();
                        });
                    });

                    // khi mà click vào cái nut check all ở table list header
                    this.getCheckAllButton().addEventListener('change', (e) => {
                        var checked = this.getCheckAllButton().checked;

                        if (checked) {
                            this.checkAllList();
                        } else {
                            this.uncheckAllList();
                        }
                    });

                    // khi nhấn vào từng checkbox từng dòng thì làm gì?
                    this.getListCheckboxes().forEach(checkbox => {
                        checkbox.addEventListener('change', (e) => {
                            var checked = checkbox.checked;

                            if (checked) {
                                //  
                                if (this.checkedCount() == this
                                    .getListCheckboxes().length) {
                                    this.getCheckAllButton().checked = true;
                                }
                            } else {
                                //
                                if (this.checkedCount() < this
                                    .getListCheckboxes().length) {
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
                                this.showTopListActionBox();
                                this.hideSearchBoxes();
                                this.hideToolBoxes();
                                this.hideFilterActionBox();

                            } else {
                                this.hideTopListActionBox();
                                this.showSearchBoxes();
                                this.showToolBoxes();
                            }

                            // update count label
                            this.updateCountLabel();
                        });
                    });

                    // khi mà click vào cái nut check all ở table list header
                    this.getCheckAllButton().addEventListener('change', (e) => {
                        var checked = this.getCheckAllButton().checked;

                        if (this.checkedCount() > 0) {
                            this.showTopListActionBox();
                            this.hideSearchBoxes();
                            this.hideToolBoxes();
                            this.hideFilterActionBox();
                        } else {
                            this.hideTopListActionBox();
                            this.showSearchBoxes();
                            this.showToolBoxes();
                        }

                        // update count label
                        this.updateCountLabel();
                    });

                    // xóa 1 item trong list
                    this.getDeleteButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');

                            // delete item
                            this.deleteItem(url);
                        });
                    });

                    // Nút chỉnh sửa từng items sau load list content
                    this.getUpdateButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');

                            // show popup
                            UpdateDemandPopup.load(url);
                        });
                    });

                    // change per page select box value
                    $(this.getPerPageSelectBox()).on('change', (e) => {
                        e.preventDefault();

                        var number = this.getPerPageSelectBox().value;

                        this.setPagePage(number);

                        // reload lại list về url bên đầu
                        this.setUrl(this.initUrl);
                        this.load();
                    });
                }
            }

            deleteItem(url) {
                // success alert
                ASTool.confirm({
                    message: 'Bạn có chắc chắn muốn xóa liên hệ này?',
                    ok: function() {
                        // effect
                        ASTool.addPageLoadingEffect();

                        // 
                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                            }
                        }).done((response) => {
                            // thông báo thành công
                            ASTool.alert({
                                message: response.message,
                                ok: function() {
                                    // reload list
                                    DemandsList.getList()
                                        .load();
                                }
                            });
                        }).fail(function() {

                        }).always(function() {
                            // effect
                            ASTool.removePageLoadingEffect();
                        });
                    }
                });
            }

            showTopListActionBox() {
                this.getTopListActionBox().classList.remove('d-none');
            }

            showFilterActionBox() {
                this.getFilterActionBox().classList.remove('d-none');
                this.getFilterIcon().innerHTML = 'expand_less'
            }

            isFilterActionBoxShowed() {
                return !this.getFilterActionBox().classList.contains('d-none');
            }

            showSearchBoxes() {
                this.getSearchBoxes().classList.remove('d-none');
            }

            showToolBoxes() {
                this.getToolBoxes().classList.remove('d-none');
            }

            updateCountLabel() {
                this.container.querySelector('[list-control="count-label"]').innerHTML = 'Đã chọn <strong>' + this
                    .checkedCount() + '</strong> liên hệ';
            }

            hideTopListActionBox() {
                this.getTopListActionBox().classList.add('d-none');
            }

            hideFilterActionBox() {
                this.getFilterActionBox().classList.add('d-none');
                this.getFilterIcon().innerHTML = 'expand_more'
            }

            hideSearchBoxes() {
                this.getSearchBoxes().classList.add('d-none');
            }

            hideToolBoxes() {
                this.getToolBoxes().classList.add('d-none');
            }

            checkAllList() {
                this.getListCheckboxes().forEach(checkbox => {
                    checkbox.checked = true;
                });
            }

            uncheckAllList() {
                this.getListCheckboxes().forEach(checkbox => {
                    checkbox.checked = false;
                });
            }

            loadContent(content) {
                $(this.listContent).html(content);

                // always hide list action box and show 
                this.hideTopListActionBox();
                this.showSearchBoxes();
                this.showToolBoxes();

                // init content
                initJs(this.listContent);
            }

            getStatus() {
                return this.status;
            }

            load() {
                this.addLoadEffect();

                // ajax request list via url
                if (this.listXhr) {
                    this.listXhr.abort();
                }

                this.listXhr = $.ajax({
                    url: this.url,
                    data: {
                        keyword: this.getKeyword(),
                        per_page: this.getPerPage(),
                        sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),
                        columns: DemandColumnManager.getColumns(),
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),
                        account_ids: this.getAccountId(),
                        status: this.getStatus(),
                    }
                }).done((content) => {
                    this.loadContent(content);

                    //
                    this.initContentEvents();

                    // 
                    this.removeLoadEffect();
                    DemandColumnManager.applyToList();
                }).fail(function() {

                });
            }

            setPagePage(number) {
                this.per_page = number;
            }

            getPerPage() {
                return this.per_page;
            }

            getPerPageSelectBox() {
                return this.listContent.querySelector('[list-control="per-page"]');
            }
        }
    </script>
@endsection