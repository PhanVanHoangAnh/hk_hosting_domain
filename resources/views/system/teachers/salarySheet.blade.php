    @extends('layouts.main.app', [
        'menu' => 'system',
    ])

    @section('sidebar')
        @include('system.modules.sidebar', [
            'menu' => 'staffs',
            'sidebar' =>'staffs',
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
                    <span class="text-dark fw-bold fs-1">Thông tin chi tiết</span>
                </h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ action([App\Http\Controllers\Edu\StudentController::class, 'index']) }}"
                            class="text-muted text-hover-primary">Trang chủ</a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-muted">Tài khoản</li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="breadcrumb-item text-dark">Thông tin</li>
                    <!--end::Item-->
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Page title-->

        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        
        <div id="kt_post" class="position-relative">
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xl-10">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    @include('system.teachers.detail', [
                        'detail' => 'salarySheet',
                    ])
                    <!--end::Details-->

                    @include('system.teachers.menu', [
                        'menu' => 'salarySheet',
                    ])

                </div>
            </div>
            <!--end::Navbar-->
            <!--begin::details View-->





            <div class="card" id="SalariesIndexContainer">
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
                                        data-kt-customer-table-select="delete_selected" row-action="delete-all"
                                        id="">

                                        <span class="menu-title">Xoá</span>
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
                    <div class="card-title" list-action="search-action-box">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input list-action="keyword-input" type="text" data-kt-customer-table-filter="search"
                                class="form-control w-250px ps-12" placeholder="Nhập để tìm bậc lương" />
                        </div>
                        <!--end::Search-->
                    </div>

                    <!--begin::Card toolbar-->
                    <div class="card-toolbar" list-action="tool-action-box">
                        <!--begin::Toolbar-->
                        <div class="d-flex justify-content-end">
                            <div class="d-flex align-items-center me-3">
                                <!--begin::Button-->
                                <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px"
                                    id="buttonCreatePayrate">
                                    <i class="ki-duotone ki-abstract-10">
                                        <i class="path1"></i>
                                        <i class="path2"></i>
                                    </i>
                                    Thêm bậc lương
                                </a>
                                <!--end::Button-->
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
                <!--begin::Card toolbar-->
                <div class=" border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar mb-0" list-action="tool-action-box">
                        <!--begin::Toolbar-->

                        <div class="row">

                            <!--begin::Input-->
                            
                        
                            <div class="col-md-4 mb-5">
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

                            <div class="col-md-4 mb-5">
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
                    <!--end::Card header-->


                    <!--end::Card-->
                </div>
            </div>
            <div id="SalariesIndexListContent"></div>
        </div>
        <!--end::Post-->

        <script>
            $(function() {
                
                SalariesIndex.init();
            });

            var SalariesIndex = function() {
                return {
                    init: function() {
                        
                        // ContactColumnManager.init();
                        
                        CreatePayratePopup.init();

                        UpdatePayratePopup.init();

                        PayrateList.init();

                        FilterData.init();

                        

                    }
                };
            }();
            //
            var ContactColumnManager = function() {
                var manager;

                return {
                    init: function() {
                        manager = new ColumnsDisplayManagerClass({
                            
                            optionsBox: document.querySelector('[columns-control="options-box"]'),
                            getList: function() {
                                return PayrateList.getList();
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

        
            var CreatePayratePopup = function() {
                var popupCreatePayrate;
                var buttonCreatePayrate;

                // show
                var showPayrateModal = function() {
                    popupCreatePayrate.load();
                };

                return {
                    init: function() {
                        popupCreatePayrate = new Popup({
                            url: "{{ $teacher ? action([\App\Http\Controllers\Accounting\PayrateController::class, 'create'], ['id' => $teacher->id]) : action([\App\Http\Controllers\Accounting\PayrateController::class, 'create']) }}",


                        });
                        buttonCreatePayrate = document.getElementById('buttonCreatePayrate');

                        buttonCreatePayrate.addEventListener('click', (e) => {
                            e.preventDefault();
                            showPayrateModal();
                        });
                    },

                    getPopup: function() {
                        return popupCreatePayrate;
                    },
                };
            }();

            
            var UpdatePayratePopup = function() {
                var popupUpdatePayrate;
                return {
                    init: function(updateUrl) {
                        popupUpdatePayrate = new Popup({
                            url: updateUrl, 
                        });
                    },
                    load: function(updateUrl) {
                        popupUpdatePayrate.url = updateUrl;
                        popupUpdatePayrate.load();
                    },
                    getPopup: function() {
                        return popupUpdatePayrate;
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

                        sortButtons.forEach(button => {
                            button.addEventListener('click', (e) => {
                                var sortBy = button.getAttribute('sort-by');
                                var sortDirection = button.getAttribute('sort-direction');

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
                
                    var selectedOptions = Array.from(select.selectedOptions);

                    var selectedValues = selectedOptions
                        .filter(function(option) {
                            return option.value.trim() !== ''; 
                        }).map(function(option) {
                            return option.value;
                        });

                    return selectedValues;
                };
                return {
                    init: () => {
                        $('[list-action="account-select"]').on('change', function() {
                            var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                            PayrateList.getList().setPayrateFilter(selectedValues);

                        
                            PayrateList.getList().load();
                        });

                        $('[list-action="created_at-select"]').on('change', function() {
                            // Lấy giá trị từ cả hai trường input
                            var fromDate = $('[name="created_at_from"]').val();
                            var toDate = $('[name="created_at_to"]').val();

                            // Gửi phạm vi ngày tạo đến ContactsList và tải lại danh sách
                            PayrateList.getList().setCreatedAtFrom(fromDate);
                            PayrateList.getList().setCreatedAtTo(toDate);
                            PayrateList.getList().load();
                        });

                        $('[list-action="updated_at-select"]').on('change', function() {
                            // Lấy giá trị từ cả hai trường input
                            var fromDate = $('[name="updated_at_from"]').val();
                            var toDate = $('[name="updated_at_to"]').val();

                            // Gửi phạm vi ngày tạo đến ContactsList và tải lại danh sách
                            PayrateList.getList().setUpdatedAtFrom(fromDate);
                            PayrateList.getList().setUpdatedAtTo(toDate);
                            PayrateList.getList().load();
                        });
                    }
                };
            })();
            //
            var PayrateList = function() {
                var list;

                return {
                    init: function() {
                        list = new DataList({
                            url: "{{ action('\App\Http\Controllers\System\TeacherController@salarySheetList', ['id' => $teacher->id]) }}",
                            container: document.querySelector('#SalariesIndexContainer'),
                            listContent: document.querySelector('#SalariesIndexListContent'),
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

            
                setPayrateFilter(ids) {
                    this.account_filter = ids;
                };
                getPayrateFilter() {
                    return this.account_filter;
                };
                getPayrateId() {
                    const selectedOptions = Array.from(this.getPayrateSelectBox().selectedOptions);
                    return selectedOptions.map(option => option.value);
                }
                getPayrateSelectBox() {

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
                            this.load();
                        }
                    });

                    // theo dôi người dùng ra khòi ô tìm kiếm
                    this.getkeywordInput().addEventListener('keyup', (e) => {
                    if (this.timeoutEvent) {
                        clearTimeout(this.timeoutEvent);
                    }

                    if (e.key === "Enter") {
                        // this.load();
                        return;
                    }

                    this.timeoutEvent = setTimeout(() => {
                        this.load();
                    }, 1500);
                }); //change

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
                                UpdatePayratePopup.load(url);
                            });
                        });
                    }
                }

                deleteItem(url) {
                    // success alert
                    ASTool.confirm({
                        message: 'Bạn có chắc muốn xóa bậc lương',
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
                                        PayrateList.getList().load();
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
                    // this.addLoadEffect();
                    // ajax request list via url
                    $.ajax({
                    url: this.url,
                    method: "GET",
                    data: {
                        key: this.getKeyword(),
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
                            account_filter: this.getPayrateFilter(),

                            
                            // columns manager
                            // columns: ContactColumnManager.getColumns(),
                        }
                    }).done((content) => {
                        this.loadContent(content);
                        //
                        this.initContentEvents();

                        // 
                        this.removeLoadEffect();
                        // apply
                        // ContactColumnManager.applyToList();

                    }).fail(function() {

                    });
                }
            }
        </script>
    @endsection
