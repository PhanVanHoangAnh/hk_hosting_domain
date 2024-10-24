@extends('layouts.main.app', [
    'menu' => 'system',
])

@section('sidebar')
    @include('system.modules.sidebar', [
        'menu' => 'account-groups',
        'sidebar' =>'account-groups',
        'type' => ''
    ])
@endsection



@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh Sách nhóm tài khoản</span>
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
                <li class="breadcrumb-item text-muted">Quản lý nhóm tài khoản</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Danh sách nhóm tài khoản</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">

            <!--begin::Button-->
            <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px "
                id="buttonCreateAccountGroup">
                <span class="material-symbols-rounded me-2">
                    add
                </span>
                Thêm nhóm tài khoản
            </a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div id="AccountGroupsIndexContainer" class="position-relative" id="kt_post">
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
                        <div class="menu-sub menu-sub-dropdown p-3 w-150px">

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="#" class="menu-link px-3" data-kt-customer-table-select="delete_selected"
                                    id="buttonsDeleteAccountGroups">

                                    <span class="menu-title" id="buttonDeleteAccountGroups">Xóa account group đã chọn</span>
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
                            class="form-control w-250px ps-12" placeholder="Nhập để tìm nhóm tài khoản" />
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

            <!--begin::Menu 1-->
            <div class="card-header border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
                <!--begin::Card toolbar-->
                <div class="ccard-toolbar mb-0 w-100" list-action="tool-action-box">
                    <div class="row">

                        <div class="col-md-6 mb-5">
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

                        <div class="col-md-6 mb-5">
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
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Menu 1-->
            <!--end::Filter-->
        </div>
        <!--end::Toolbar-->

        <div id="AccountGroupsIndexListContent">
        </div>
    </div>
    <!--end::Post-->
    <script>
        $(function() {
            //init load trang
            AccountGroupsIndex.init();
        });

        //
        var AccountGroupsIndex = function() {
            return {
                init: function() {
                    // ColumnsDisplayManager
                    ContactColumnManager.init();
                    // Create AccountGroup
                    CreateAccountGroupPopup.init();

                    // Update AccountGroup
                    UpdateAccountGroupPopup.init();

                    //list
                    AccountGroupsList.init();

                    //
                    FilterData.init();

                    //DeleteAllAccountGroup
                    DeleteAccountGroupsPopup.init();


                }
            };
        }();
        //
        var ContactColumnManager = function() {
            var manager;

            return {
                init: function() {
                    manager = new ColumnsDisplayManagerClass({
                        columns: {!! json_encode($columns) !!},
                        optionsBox: document.querySelector('[columns-control="options-box"]'),
                        getList: function() {
                            return AccountGroupsList.getList();
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

        //delete accounts
        var DeleteAccountGroupsPopup = function() {
            var popupDeleteAccountGroups;
            var buttonsDeleteAccountGroups;
            var accountGroupIds = [];
            var showDeleteAccountGroups = function() {
                popupDeleteAccountGroups.setData({
                    account_group_ids: AccountGroupsList.getList().getSelectedIds(),
                });

                popupDeleteAccountGroups.load();
            };
            var handleDeleteAccountGroupsButtonClick = function() {
                buttonsDeleteAccountGroups.addEventListener('click', (e) => {
                    e.preventDefault();

                    showDeleteAccountGroups();
                })
            };
            return {
                init: function() {
                    popupDeleteAccountGroups = new Popup({
                        url: "{{ action('\App\Http\Controllers\System\AccountGroupController@deleteAccountGroups') }}",
                    });
                    buttonsDeleteAccountGroups = document.getElementById('buttonsDeleteAccountGroups');
                    handleDeleteAccountGroupsButtonClick();
                },
                getPopup: function() {
                    return popupDeleteAccountGroups;
                }
            }

        }();

        //
        var CreateAccountGroupPopup = function() {
            var popupCreateAccountGroup;
            var buttonCreateAccountGroup;

            // show
            var showAccountGroupModal = function() {
                popupCreateAccountGroup.load();
            };

            return {
                init: function() {
                    // create account popup
                    popupCreateAccountGroup = new Popup({
                        url: "{{ action('\App\Http\Controllers\System\AccountGroupController@create') }}",
                    });

                    // create account  button
                    buttonCreateAccountGroup = document.getElementById('buttonCreateAccountGroup');

                    // nhấp vào nút tạo thẻ
                    buttonCreateAccountGroup.addEventListener('click', (e) => {
                        e.preventDefault();

                        // hiển thị phương thức tạo thẻ
                        showAccountGroupModal();
                    });
                },

                getPopup: function() {
                    return popupCreateAccountGroup;
                },
            };
        }();

        //dùng cho tạo edit
        var UpdateAccountGroupPopup = function() {
            var popupUpdateAccountGroup;
            return {
                init: function(updateUrl) {
                    // Khởi tạo popup chỉnh sửa chiến dịch
                    popupUpdateAccountGroup = new Popup({
                        url: updateUrl, // Sử dụng URL được chuyền vào từ tham số
                    });

                },
                load: function(updateUrl) {
                    popupUpdateAccountGroup.url = updateUrl;
                    popupUpdateAccountGroup.load();
                },
                getPopup: function() {
                    return popupUpdateAccountGroup;
                },
            };
        }();

        //sort
        var SortManager = function() {
            var theList;
            var sortButtons;
            var currentSortBy;
            var currentSortDirection;

            var sort = function(sortBy, sortDirection) {
                setSort(sortBy, sortDirection);

                // // load list
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
                    $('[list-action="account-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        AccountGroupsList.getList().setAccountGroupFilter(selectedValues);

                        // load list
                        AccountGroupsList.getList().load();
                    });

                    $('[list-action="created_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="created_at_from"]').val();
                        var toDate = $('[name="created_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến ContactsList và tải lại danh sách
                        AccountGroupsList.getList().setCreatedAtFrom(fromDate);
                        AccountGroupsList.getList().setCreatedAtTo(toDate);
                        AccountGroupsList.getList().load();
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến ContactsList và tải lại danh sách
                        AccountGroupsList.getList().setUpdatedAtFrom(fromDate);
                        AccountGroupsList.getList().setUpdatedAtTo(toDate);
                        AccountGroupsList.getList().load();
                    });
                }
            };
        })();
        //
        var AccountGroupsList = function() {
            var list;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\System\AccountGroupController@list') }}",
                        container: document.querySelector('#AccountGroupsIndexContainer'),
                        listContent: document.querySelector('#AccountGroupsIndexListContent'),
                    });
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
                this.listContent = options.listContent;

                this.keyword;
                //
                this.sort_by;
                this.sort_direction;
                //
                this.perpage;
                this.page;
                this.accountGroupIds = [];

                //
                this.events();
            }
            //
            setKeyword(keyword) {
                this.keyword = keyword;
            }
            //
            getKeyword() {
                return this.keyword;
            }

            // getFillterApplyButton() {
            //     return this.container.querySelector('[list-action="filter-apply"]');
            // }

            // Filter by account
            setAccountGroupFilter(ids) {
                this.account_filter = ids;
            };
            getAccountGroupFilter() {
                return this.account_filter;
            };
            getAccountGroupId() {
                const selectedOptions = Array.from(this.getAccountGroupSelectBox().selectedOptions);
                return selectedOptions.map(option => option.value);
            }
            getAccountGroupSelectBox() {

                return this.container.querySelector('[list-control="account-select"]');
            }

            getFilterButton() {
                return document.getElementById('filterButton');
            }
            // lam cho sk click Filter
            getFilterActionBox() {
                return this.container.querySelector('[list-action="filter-action-box"]');
            }
            //
            getFilterIcon() {
                return document.getElementById('filterIcon');
            }

            // setAccountIds(ids) {

            //     this.accountIds = ids;
            // };

            // getAccountIds() {
            //     return this.accountIds;
            // };
            // Filter by lifecycle_saccounte
            setLifecycleSaccounte(lifecycleSaccounte) {
                this.lifecycle_saccounte = lifecycleSaccounte;
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
            }

            //them hieu ung tai
            addLoadEffect() {
                this.listContent.classList.add('list-loading');

                // cho biết dữ liệu đang đc loader
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
                this.listContent.classList.remove('list-loading');

                // remove loader
                if (this.container.querySelector('[list-action="loader"]')) {
                    this.container.querySelector('[list-action="loader"]').remove();
                }
            }

            //nd mục List
            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            }

            //tạo sự kiện
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

                    // // xóa 1 item trong list
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
                            UpdateAccountGroupPopup.load(url);
                        });
                    });
                }
            }

            deleteItem(url) {
                // success alert
                ASTool.confirm({
                    message: 'Bạn có chắc muốn xóa AccountGroup',
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
                                    AccountGroupsList.getList().load();
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

            //nut check all button
            getCheckAllButton() {
                if (!this.listContent.querySelector('[list-action="check-all"]')) {
                    throw new Error('Bug: Check all button not found!');
                }
                return this.listContent.querySelector('[list-action="check-all"]');
            }

            //xóa 1 item trong list
            getDeleteButtons() {
                return this.listContent.querySelectorAll('[row-action="delete"]');
            }

            // Nút chỉnh sửa từng items sau load list content
            getUpdateButtons() {
                return this.listContent.querySelectorAll('[row-action="update"]');
            }

            //pagination ajax
            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
            }

            getkeywordInput() {
                return this.container.querySelector('[list-action="keyword-input"]');
            }

            getListCheckboxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]');
            }

            getTopListActionBox() {
                return this.container.querySelector('[list-action="top-action-box"]');
            }
            //
            getSearchBoxes() {
                return this.container.querySelector('[list-action="search-action-box"]');
            }
            //
            getToolBoxes() {
                return this.container.querySelector('[list-action="tool-action-box"]');
            }


            checkedCount() {
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked').length;
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
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked');
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
                        //sort
                        sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),

                        //paginate per page
                        page: this.page,
                        perpage: this.perpage,

                        //Filter Create Date
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),

                        //Filter Update Date
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),

                        //
                        account_filter: this.getAccountGroupFilter(),

                        // accountIds: this.getAccountIds().length > 0 ? this.getAccountIds() : null
                        // columns manager
                        columns: ContactColumnManager.getColumns(),
                    }
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
    </script>
@endsection
