@extends('layouts.main.app')
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh Sách Người Dùng</span>
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
                <li class="breadcrumb-item text-muted">Quản lý người dùng</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Danh sách người dùng</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">

            <!--begin::Button-->
            <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" id="buttonCreateUser">
                <span class="material-symbols-rounded me-2">
                    add
                </span>
                Thêm Người Dùng
            </a>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div id="UsersIndexContainer" class="position-relative" id="kt_post">
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
                                <a href="#" class="menu-link px-3"
                                    data-kt-customer-table-select="delete_selected"
                                    id="buttonsDeleteUsers">

                                    <span class="menu-title">Xóa người dùng</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                        <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->

                    <div class="m-2 font-weight-bold">
                        <div list-control="count-note-selected-label"></div>
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
                            class="form-control w-250px ps-12" placeholder="Nhập để tìm tên, email" />
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

                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->

            <div class=" border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
                <!--begin::Card toolbar-->
                <div class="card-toolbar mb-0" list-action="tool-action-box">
                    <!--begin::Toolbar-->

                    <div class="row">
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
                    </div>
                </div>
                <!--end::Toolbar-->
            </div>

        </div>
        <div id="UsersIndexListContent">
        </div>
        <!--end::Post-->
    </div>
    <script>
        $(function() {
            UsersIndex.init();
        });

        //
        var UsersIndex = function() {
            return {
                init: function() {
                    // ColumnsDisplayManager
                    ContactColumnManager.init();
                    //list
                    UsersList.init();

                    //sort
                    SortData.init();

                    // Create User
                    CreateUserPopup.init();

                    //
                    UpdateUserPopup.init();

                    //
                    DeleteUsersPopup.init();

                    FilterData.init();



                }
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

                    $('[list-action="created_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="created_at_from"]').val();
                        var toDate = $('[name="created_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến UsersList và tải lại danh sách
                        UsersList.getList().setCreatedAtFrom(fromDate);
                        UsersList.getList().setCreatedAtTo(toDate);
                        UsersList.getList().load();
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến UsersList và tải lại danh sách
                        UsersList.getList().setUpdatedAtFrom(fromDate);
                        UsersList.getList().setUpdatedAtTo(toDate);
                        UsersList.getList().load();
                    });
                }
            };
        })();
        var ContactColumnManager = function() {
            var manager;
            var test = () => {
                return manager.columns.filter(item => item.checked === true).map(item => item.id);
            }

            return {
                init: function() {
                    manager = new ColumnsDisplayManagerClass({
                        columns: {!! json_encode($columns) !!},
                        optionsBox: document.querySelector('[columns-control="options-box"]'),
                        getList: function() {
                            return UsersList.getList();
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
        //xóa nhiều users
        var DeleteUsersPopup = function() {
            var popupDeleteUsers;
            var buttonsDeleteUsers;
            var userIds = [];
            var showDeleteUsers = function() {
                popupDeleteUsers.setData({
                    user_ids: UsersList.getList().getSelectedIds(),
                });

                popupDeleteUsers.load();
            };
            var handleDeleteUsersButtonClick = function() {
                buttonsDeleteUsers.addEventListener('click', (e) => {
                    e.preventDefault();

                    showDeleteUsers();
                })
            };
            return {
                init: function() {
                    popupDeleteUsers = new Popup({
                        url: "{{ action('\App\Http\Controllers\UserController@deleteUsers') }}",
                    });
                    buttonsDeleteUsers = document.getElementById('buttonsDeleteUsers');
                    handleDeleteUsersButtonClick();
                },
                getPopup: function() {
                    return popupDeleteUsers;
                }
            }
        }();
        //
        var CreateUserPopup = function() {
            var popupCreateUser;
            var buttonCreateUser;

            // // show
            var showUserModal = function() {
                popupCreateUser.load();
            };

            return {
                init: function() {
                    // create user popup
                    popupCreateUser = new Popup({
                        url: "{{ action('\App\Http\Controllers\UserController@create') }}",
                    });

                    // create user  button
                    buttonCreateUser = document.getElementById('buttonCreateUser');

                    // nhấp vào nút tạo thẻ
                    buttonCreateUser.addEventListener('click', (e) => {
                        e.preventDefault();
                        // popupCreateUser.load();
                        // hiển thị phương thức tạo thẻ
                        showUserModal();
                    });
                },

                getPopup: function() {
                    return popupCreateUser;
                },
            };
        }();

        //dùng cho tạo edit
        var UpdateUserPopup = function() {
            var popupUpdateUser;
            return {
                init: function(updateUrl) {
                    // Khởi tạo popup chỉnh sửa chiến dịch
                    popupUpdateUser = new Popup({
                        url: updateUrl, // Sử dụng URL được chuyền vào từ tham số
                    });

                },
                load: function(updateUrl) {
                    popupUpdateUser.url = updateUrl;
                    popupUpdateUser.load();
                },
                getPopup: function() {
                    return popupUpdateUser;
                },
            };
        }();

        //
        var SortData = function() {
            return {
                init: function() {
                    $('[row-action="sort-by"]').on('click', e => {
                        e.preventDefault();

                        let rowAction = e.target.textContent;
                        document.querySelector("#sort-name").innerHTML = rowAction;
                        let sortBy = e.target.getAttribute('data-sort');

                        UsersList.getList().setUrl(e.target.getAttribute('href'));
                        UsersList.getList().setSortBy(sortBy);
                        UsersList.getList().load();
                    });

                    $('[row-action=sort-direction]').on('click', e => {
                        e.preventDefault();

                        let rowAction = e.target.textContent;
                        document.querySelector("#sort-direction").innerHTML = rowAction;
                        let sortDirection = e.target.getAttribute('data-sort');

                        UsersList.getList().setUrl(e.target.getAttribute('href'));
                        UsersList.getList().setSortDirection(sortDirection);
                        UsersList.getList().load();
                    });
                },
            }
        }();

        //
        var UsersList = function() {
            var list;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\UserController@list') }}",
                        container: document.querySelector('#UsersIndexContainer'),
                        listContent: document.querySelector('#UsersIndexListContent'),
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
                if (!options.url) {
                    throw new Error('Bug: list url not found!');
                }
                this.initUrl = options.url;

                this.url = options.url;
                this.container = options.container;
                this.listContent = options.listContent;

                this.keyword;

                //sort
                this.sort_by;
                this.sort_direction;

                //
                this.events();
            }
            updateCountLabel() {
                this.container.querySelector('[list-control="count-note-selected-label"]').innerHTML =
                    'Đã chọn <strong>' + this
                    .checkedCount() + '</strong> khách hàng';
            };

            //
            setUrl(url) {
                this.url = url;
            }

            // Sort
            setSortBy(sortBy) {
                this.sort_by = sortBy;
            };

            getSortBy() {
                return this.sort_by;
            };

            // Sort direction
            setSortDirection(sortDirection) {
                this.sort_direction = sortDirection;
            };

            getSortDirection() {
                return this.sort_direction;
            };

            //search
            setKeyword(keyword) {
                this.keyword = keyword;
            }
            getKeyword() {
                return this.keyword;
            }

            //xóa 1 item trong list
            getDeleteButtons() {
                return this.listContent.querySelectorAll('[row-action="delete"]');
            }

            // Nút chỉnh sửa từng items sau load list content
            getUpdateButtons() {
                return this.listContent.querySelectorAll('[row-action="update"]');
            }

            //pagination
            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
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
            getColumns() {
                return this.columns;
            }

            getSearchBoxes() {
                return this.container.querySelector('[list-action="search-action-box"]');
            }

            getToolBoxes() {
                return this.container.querySelector('[list-action="tool-action-box"]');
            }
            //nd mục List
            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            }

            //tạo sự kiện
            initContentEvents() {
                SortManager.init(this);

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
                            UpdateUserPopup.load(url);
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

                    // khi mà click vào cái nut check all ở table list header
                    this.getCheckAllButton().addEventListener('change', (e) => {
                        var checked = this.getCheckAllButton().checked;

                        if (checked) {
                            // check all list checkboxes
                            this.checkAllList();
                        } else {
                            // check all list checkboxes
                            this.uncheckAllList();
                        };
                        this.updateCountLabel();

                    });

                    //khi nhấn vào từng checkbox từng dòng thì làm gì nut button all hien
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
                            };
                            this.updateCountLabel();

                        });

                    });

                    // khi có bất cứ dòng nào được check trong list thì hiện cái top list action
                    this.getListCheckboxes().forEach(checkbox => {
                        checkbox.addEventListener('change', (e) => {
                            var checked = checkbox.checked;

                            if (this.checkedCount() > 0) {
                                // show top list action box
                                this.showTopListActionBox();
                                //hide search
                                this.hideSearchBoxes();
                                // hide tool boxes
                                this.hideToolBoxes();
                            } else {
                                // hide top list action box
                                this.hideTopListActionBox();
                                //show search
                                this.showSearchBoxes();
                                //show tool boxes
                                this.showToolBoxes();
                            };
                            this.updateCountLabel();

                        });
                    });

                    // khi mà click vào cái nut check all ở table list header
                    this.getCheckAllButton().addEventListener('change', (e) => {
                        var checked = this.getCheckAllButton().checked;

                        if (this.checkedCount() > 0) {
                            // show top list action box
                            this.showTopListActionBox();
                            // 
                            this.hideSearchBoxes();
                            //
                            this.hideToolBoxes();
                        } else {
                            // hide top list action box
                            this.hideTopListActionBox();
                            //show search
                            this.showSearchBoxes();
                            //
                            this.showToolBoxes();
                        };
                        this.updateCountLabel();

                    });
                }
            }
            //

            getListCheckboxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]');
            }

            //check all button
            getCheckAllButton() {
                return this.listContent.querySelector('[list-action="check-all"]');
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

            checkedCount() {
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked').length;
            }

            showTopListActionBox() {
                this.getTopListActionBox().classList.remove('d-none');
            }

            hideTopListActionBox() {
                this.getTopListActionBox().classList.add('d-none');
            }

            getTopListActionBox() {
                return this.container.querySelector('[list-action="top-action-box"]');
            }
            getFilterButton() {
                return document.getElementById('filterButton');
            }
            getFilterIcon() {
                return document.getElementById('filterIcon');
            }
            getFilterActionBox() {
                return this.container.querySelector('[list-action="filter-action-box"]');
            }
            isFilterActionBoxShowed() {
                return !this.getFilterActionBox().classList.contains('d-none');
            }
            showFilterActionBox() {
                this.getFilterActionBox().classList.remove('d-none');
                this.getFilterIcon().innerHTML = 'expand_less'
            }
            hideFilterActionBox() {
                this.getFilterActionBox().classList.add('d-none');
                this.getFilterIcon().innerHTML = 'expand_more'
            }
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
            //
            events() {
                // Đxử lý các sự kiện liên quan đến tìm kiếm dữ liệu
                this.getkeywordInput().addEventListener('keyup', (e) => {
                    this.setKeyword(this.getkeywordInput().value);

                    // enter key
                    if (event.key === "Enter") {
                        // 
                        this.setUrl(this.initUrl);
                        this.load();
                    }
                });

                // theo dôi người dùng ra khòi ô tìm kiếm, tim kim khi nhap luon
                // this.getkeywordInput().addEventListener('keyup', (e) => {
                //     this.load();
                // });
                //Khi mà click vào nút lọc
                this.getFilterButton().addEventListener('click', (e) => {
                    if (!this.isFilterActionBoxShowed()) {
                        this.showFilterActionBox();
                    } else {
                        this.hideFilterActionBox();
                    }
                });
            }

            getkeywordInput() {
                return this.container.querySelector('[list-action="keyword-input"]');
            }

            //
            deleteItem(url) {
                // success alert
                ASTool.confirm({
                    message: 'Bạn có chắc muốn xóa User',
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
                                    UsersList.getList().load();
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

            //hide search
            hideSearchBoxes() {
                this.getSearchBoxes().classList.add('d-none');
            }
            //show search
            showSearchBoxes() {
                this.getSearchBoxes().classList.remove('d-none');
            }

            //hide tool boxes
            hideToolBoxes() {
                this.getToolBoxes().classList.add('d-none');
            }
            //show tool boxes
            showToolBoxes() {
                this.getToolBoxes().classList.remove('d-none');
            }
            loadContent(content) {
                $(this.listContent).html(content);
                //
                this.showSearchBoxes();

                // init content
                initJs(this.listContent);
            }
            load() {
                // this.addLoadEffect();
                $.ajax({
                    url: this.url,
                    data: {
                        keyword: this.getKeyword(),

                        //sort
                        sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),


                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),

                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),
                        //per_page
                        per_page: this.getPerPage(),
                        columns: this.getColumns(),
                        columns: ContactColumnManager.getColumns(),

                    }
                }).done((content) => {
                    this.loadContent(content);
                    //
                    this.initContentEvents();
                    ContactColumnManager.applyToList();

                }).fail(function() {

                });
            }
        }
    </script>
@endsection
