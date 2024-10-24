@extends('layouts.main.student', [
    'menu' => 'student',
])
@section('sidebar')
@include('student.modules.sidebar', [
        'menu' => 'courses',
        'sidebar' =>'courses',
])
@endsection
@section('content')
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
                    <a href="{{ action([App\Http\Controllers\Student\CourseController::class, 'index']) }}"
                        class="text-muted text-hover-primary">Trang chủ</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Lớp học</li>
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

    <div class="post" id="kt_post">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                @include('student.courses.detail', [
                    'detail' => 'students',
                ])
                <!--end::Details-->

                @include('student.courses.menu', [
                    'menu' => 'students',
                ])

            </div>
        </div>


       
        <div id="StudentsIndexContainer" class="  position-relative" id="kt_post">
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
                                    <a row-action="delete-all" href="javascript:;"
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
                            <input list-action="keyword-input" type="text" data-kt-customer-table-filter="search"
                                class="form-control w-250px ps-12" placeholder="Tìm tên, điện thoại, email" />
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
                                    <button data-action="under-construction" type="button" class="btn btn-outline btn-outline-default"
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
                            <button data-action="under-construction" type="button" class="btn btn-outline btn-outline-default" id="filterButton">
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
                <div class="card-header border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar mb-0 w-100 d-flex justify-content-center" list-action="tool-action-box">
                        <!--begin::Toolbar-->

                        <div class="row w-100">
                            <!--begin::Content-->
                            <div class="col-md-3 d-none">
                                <!--begin::Label-->
                                {{-- <label class="form-label fw-semibold ">Tag:</label> --}}
                                <!--end::Label-->
                            
                            </div>
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
                        <!--end::Menu 1-->
                        <!--end::Filter-->
                    </div>
                    <!--end::Toolbar-->
                </div>
                <!--end::Card toolbar-->
            </div>
            <!--end::Card header-->
            <div id="studentsIndexListContent">
                
            </div>
            <!--begin::Modals-->
           
            <!--end::Modals-->
        </div>
    
    
    
    <script>
        $(() => {
            StudentsIndex.init();
        });
        
        const StudentsIndex = function() {
            
            return {
                init: () => {
                    // CustomerColumnManager.init();
                   StudentList.init();
                    // filterData.init();
                    UpdateContactPopup.init();
                    NodeLogsStudentPopup.init();
                }
            }
        }();
    
       
    
        let StudentList = function() {
    
            let list;
    
            return {
                init: () => {
                    
    
                    list = new DataList({
                        url: "{{ action('App\Http\Controllers\Student\CourseController@studentList', ['id' => $course->id]) }}",
                        container: document.querySelector("#StudentsIndexContainer"),
                        listContent: document.querySelector("#studentsIndexListContent")
                });
    
                    list.load();
                },
                getList: () => {
                    return list;
                }
            };
        }();
    
        var NodeLogsStudentPopup = function() {
            var popupNodeLogsStudent;
            return {
                init: function(updateUrl) {
                    popupNodeLogsStudent = new Popup({
                        url: updateUrl,

                    });
                },
                load: function(url) {
                    popupNodeLogsStudent.url = url;
                    popupNodeLogsStudent.load();
                },
                getPopup: function() {
                    return popupNodeLogsStudent;
                }
            };
        }();

        var UpdateContactPopup = function() {
            var popupUpdateContact;

            return {
                init: function(updateUrl) {
                    popupUpdateContact = new Popup({
                        url: updateUrl, 
                    });
                },

                load: function(url) {
                    popupUpdateContact.url = url;
                    popupUpdateContact.load();
                },

                getPopup: function() {
                    return popupUpdateContact;
                },

            };
        }();
        
    
        let DeleteStudentPopup = function() {
            let popup;
    
            return {
                init: () => {
                    popup = new Popup();
                },
                updateUrl: newUrl => {
                    popup.url = newUrl;
                    popup.load();
                },
                getPopup: () => {
                    return popup;
                }
            }
        }();
    
        let ShowStudentPopup = function() {
            let popup;
    
            return {
                init: () => {
                    popup = new Popup();
                },
                updateUrl: newUrl => {
                    popup.url = newUrl;
                    popup.load();
                },
                getPopup: () => {
                    return popup;
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
    
            const filterData = function() {
                let contact = null;
                let industries = [];
                let orderTypes = [];
                let types = [];
                let sales = [];
                let saleSups = [];
                let filterBtn = document.querySelector("#filter-orders-btn");
                let actionBox = document.querySelector('[list-action="filter-action-box"]');
    
                const getContactValue = () => {
                    contact = document.querySelector('#order-filter-contact-select').value;
                };
    
                const getStudentTypeValues = () => {
                    orderTypes = Array.from(document.querySelector('[list-action="order-type-filter-select"]').selectedOptions)
                        .map(option => option.value);
                };
    
                const getIndustryValues = () => {
                    industries = Array.from(document.querySelector('[list-action="industry-select"]').selectedOptions)
                        .map(option => option.value);
                };
    
                const getTypeValues = () => {
                    types = Array.from(document.querySelector('[list-action="type-select"]').selectedOptions)
                        .map(option => option.value);
                };
    
                const getSaleValues = () => {
                    sales = Array.from(document.querySelector('[list-action="sale-select"]').selectedOptions)
                        .map(option => option.value);
                };
    
                const getSaleSupValues = () => {
                    saleSups = Array.from(document.querySelector('[list-action="sale-sup-select"]').selectedOptions)
                        .map(option => option.value);
                };
    
                const showActionBox = () => {
                    actionBox.classList.remove('d-none');
                };
    
                const hideActionBox = () => {
                    actionBox.classList.add('d-none');
                };
    
                const getFilterIcon = () => {
                    return document.querySelector("#filterIcon");
                };
    
                const changeFilterIconToExpandMore = () => {
                    getFilterIcon().innerHTML = "expand_more";
                };
    
                const changeFilterIconToExpandLess = () => {
                    getFilterIcon().innerHTML = "expand_less";
                };
    
                const checkIsActionBoxShowing = () => {
                    return !actionBox.classList.contains('d-none');
                };
    
                return {
                    init: () => {
                        $('.filter-select').on('change', () => {
                            getContactValue();
                            getStudentTypeValues();
                            getIndustryValues();
                            getTypeValues();
                            getSaleValues();
                            getSaleSupValues();
    
                            StudentList.getList().setIndustries(industries);
                            StudentList.getList().setContact(contact);
                            StudentList.getList().setStudentTypes(orderTypes);
                            StudentList.getList().setTypes(types);
                            StudentList.getList().setSales(sales);
                            StudentList.getList().setSaleSups(saleSups);
                            StudentList.getList().load();
                        });
    
                        filterBtn.addEventListener('click', e => {
                            e.preventDefault();
    
                            if (checkIsActionBoxShowing()) {
                                hideActionBox();
                                changeFilterIconToExpandMore();
                            } else {
                                showActionBox();
                                changeFilterIconToExpandLess();
                            };
                        });
    
                        $('[list-action="created_at-select"]').on('change', function() {
                            var fromDate = $('[name="created_at_from"]').val();
                            var toDate = $('[name="created_at_to"]').val();
    
                            StudentList.getList().setCreatedAtFrom(fromDate);
                            StudentList.getList().setCreatedAtTo(toDate);
                            StudentList.getList().load();
                        });
    
                        $('[list-action="updated_at-select"]').on('change', function() {
                            var fromDate = $('[name="updated_at_from"]').val();
                            var toDate = $('[name="updated_at_to"]').val();
    
                            StudentList.getList().setUpdatedAtFrom(fromDate);
                            StudentList.getList().setUpdatedAtTo(toDate);
                            StudentList.getList().load();
                        });
    
                    }
                };
            }();
    
            let DataList = class {
    
                constructor(options) {
                if (!options.url) {
                    throw new Error('Bug: list url not found!');
                }

                this.initUrl = options.url;
                this.url = options.url;
                this.container = options.container;
                this.listContent = options.listContent;
                this.keyword;
                this.sort_by;
                this.sort_direction;
                this.status;

                if (typeof(options.status) !== 'undefined') {
                    this.status = options.status;
                }

                this.lead_status_menu;

                if (typeof(options.lead_status_menu) !== 'undefined') {
                    this.lead_status_menu = options.lead_status_menu;
                }

                this.lifecycle_stage_menu;

                if (typeof(options.lifecycle_stage_menu) !== 'undefined') {
                    this.lifecycle_stage_menu = options.lifecycle_stage_menu;
                }

                this.events();
            };

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
            };

            setKeyword(keyword) {
                this.keyword = keyword;
            };

            getKeyword() {
                return this.keyword;
            };

            getColumnsCheckboxes() {
                return this.container.querySelectorAll('[list-action="column-checker"]');
            };

            events() {
                this.getkeywordInput().addEventListener('keyup', (e) => {
                    this.setKeyword(this.getkeywordInput().value);

                    if (event.keyword === "Enter") {
                        this.setUrl(this.initUrl);
                        this.load();
                    };

                });

                // this.getkeywordInput().addEventListener('keyup', (e) => {
                //     this.load();
                // });

                this.getColumnsCheckboxes().forEach(checkbox => {
                    const checkboxes = this.getColumnsCheckboxes();

                    checkbox.addEventListener('change', (e) => {
                        const checked = checkbox.checked;
                        const column = checkbox.value;

                        if (!checked) {
                            // Uncheck the "all" checkbox if any other checkbox is unchecked
                            // allCheckbox.checked = false;
                        };

                        if (checked) {
                            this.addColumn(column);
                        } else {
                            this.removeColumn(column);
                        };

                        this.load();
                    });
                });

                this.getFilterButton().addEventListener('click', (e) => {
                    if (!this.isFilterActionBoxShowed()) {
                        this.showFilterActionBox();
                    } else {
                        this.hideFilterActionBox();
                    };
                });
            };

            addColumn(column) {
                this.columns.push(column);
            };

            removeColumn(column) {
                this.columns = this.columns.filter(e => e !== column);
            };

            addLoadEffect() {
                this.listContent.classList.add('list-loading');

                if (!this.container.querySelector('[list-action="loader"]')) {
                    $(this.listContent).before(`
                        <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    `);
                };
            };

            setUrl(url) {
                this.url = url;
            };

            getSortBy() {
                return this.sort_by;
            };

            getSortDirection() {
                return this.sort_direction;
            };

            setMarketingType(marketingType) {
                this.source_type = marketingType;
            };

            getMarketingType() {
                return this.source_type;
            };

            setMarketingSource(marketingSource) {
                this.channel = marketingSource;
            };

            getMarketingSource() {
                return this.channel;
            };

            setMarketingSourceSub(marketingSourceSub) {
                this.sub_channel = marketingSourceSub;
            };

            getMarketingSourceSub() {
                return this.sub_channel;
            };

            setLifecycleStage(lifecycleStage) {
                this.lifecycle_stage = lifecycleStage;
            };

            setCreatedAtFrom(createdAtFrom) {
                this.created_at_from = createdAtFrom;
            };

            getCreatedAtFrom() {
                return this.created_at_from;
            };

            setCreatedAtTo(createdAtTo) {
                this.created_at_to = createdAtTo;
            };

            getCreatedAtTo() {
                return this.created_at_to;
            };

            setUpdatedAtFrom(updatedAtFrom) {
                this.updated_at_from = updatedAtFrom;
            };

            getUpdatedAtFrom() {
                return this.updated_at_from;
            };

            setUpdatedAtTo(updatedAtTo) {
                this.updated_at_to = updatedAtTo;
            };

            getUpdatedAtTo() {
                return this.updated_at_to;
            };

            getLifecycleStage() {
                return this.lifecycle_stage;
            };

            setLeadStatus(leadStatus) {
                this.lead_status = leadStatus;
            };

            getLeadStatus() {
                return this.lead_status;
            };

            setSalespersonIds(ids) {
                this.salesperson_ids = ids;
            };

            getSalespersonIds() {
                return this.salesperson_ids;
            };

            getLeadStatusMenu() {
                return this.lead_status_menu;
            };

            getLifeCycleStageMenu() {
                return this.lifecycle_stage_menu;
            };

            removeLoadEffect() {
                this.listContent.classList.remove('list-loading');

                if (this.container.querySelector('[list-action="loader"]')) {
                    this.container.querySelector('[list-action="loader"]').remove();
                };
            };

            getkeywordInput() {
                return this.container.querySelector('[list-action="keyword-input"]');
            };

            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
            };

            getFilterButton() {
                return document.getElementById('filterButton');
            };

            getCheckAllButton() {
                if (!this.listContent.querySelector('[list-action="check-all"]')) {
                    throw new Error('Bug: Check all button not found!');
                };

                return this.listContent.querySelector('[list-action="check-all"]');
            };

            getListCheckboxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]');
            };

            getListCheckedBoxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked');
            };

            checkedCount() {
                return this.getListCheckedBoxes().length;
            };

            getSelectedIds() {
                const ids = [];

                this.getListCheckedBoxes().forEach((checkbox) => {
                    ids.push(checkbox.value);
                });

                return ids;
            };

            getTopListActionBox() {
                return this.container.querySelector('[list-action="top-action-box"]');
            };

            getFilterActionBox() {
                return this.container.querySelector('[list-action="filter-action-box"]');
            };

            getFilterIcon() {
                return document.getElementById('filterIcon');
            };

            getSearchBoxes() {
                return this.container.querySelector('[list-action="search-action-box"]');
            };

            getToolBoxes() {
                return this.container.querySelector('[list-action="tool-action-box"]');
            };

            getDeleteButtons() {
                return this.listContent.querySelectorAll('[row-action="delete"]');
            };

            getUpdateButtons() {
                return this.listContent.querySelectorAll('[row-action="update"]');
            };

            getNoteLogsStudentButtons() {
                return this.listContent.querySelectorAll('[row-action="note-logs-customer"]');

            };

            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            };

            getMarketingSourceSelected() {
                return this.container.querySelector('[list-action="marketing-source-select"]');
            };
            
            getMarketingSourceSelectedSub() {
                return this.container.querySelector('[list-action="marketing-source-sub-select"]');
            };

            setMarketingSourceSelectedSubOptions(selectedValue) {
                var subtypes = marketingData[selectedValue] || [];
                var marketingSourceSelectedSub = this.getMarketingSourceSelectedSub();
                marketingSourceSelectedSub.innerHTML = '';
                subtypes.forEach(function(subtype) {
                    var option = new Option(subtype, subtype, false, false);
                    marketingSourceSelectedSub.appendChild(option);
                });

                $(marketingSourceSelectedSub).trigger('change.select2');
            };

            initContentEvents() {
                const _this = this;

                SortManager.init(this);

                if (this.getListItemsCount()) {
                    this.getDeleteAllItemsBtn().addEventListener('click', function(e) {
                        e.preventDefault();

                        const url = this.getAttribute('href');
                        const items = _this.getItemCheckedIds();

                        _this.hideTopListActionBox();
                        _this.showSearchBoxes();

                        ASTool.confirm({
                            message: "Bạn có chắc muốn xóa các học viên này không?",
                            ok: function() {
                                ASTool.addPageLoadingEffect();
                                $.ajax({
                                    url: url,
                                    method: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        contacts: items
                                    }
                                }).done(response => {
                                    ASTool.alert({
                                        message: response.message,
                                        ok: function() {
                                            StudentList.getList().load();
                                        }
                                    })
                                }).fail(function() {
                                }).always(function() {
                                    ASTool.removePageLoadingEffect();
                                })
                            }
                        });
                    });

                    this.getContentPageLinks().forEach(link => {
                        link.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = link.getAttribute('href');

                            this.setUrl(url);
                            this.load();
                        });
                    });

                    $(this.getMarketingSourceSelected()).on('change', () => {
                        var selectedSource = this.getMarketingSourceSelected().value;
                        var subtypes = @json(config('marketingSourceSubs'));

                        var getMarketingSourceSelectedSub = $(this
                            .getMarketingSourceSelectedSub()); // Wrap it in jQuery
                        getMarketingSourceSelectedSub.empty();

                        $.each(subtypes[selectedSource] || [], function(index, subtype) {
                            var option = new Option(subtype, subtype, false, false);
                            getMarketingSourceSelectedSub.append(option);
                        });

                        // Trigger Select2 to refresh the second dropdown
                        $(getMarketingSourceSelectedSub).trigger('change.select2');

                        this.setMarketingSourceSub([]);
                    });

                    this.getCheckAllButton().addEventListener('change', (e) => {
                        var checked = this.getCheckAllButton().checked;

                        if (checked) {
                            this.checkAllList();
                        } else {
                            this.uncheckAllList();
                        }
                    });

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

                            this.updateCountLabel();
                        });
                    });

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

                        this.updateCountLabel();
                    });

                    this.getDeleteButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');

                            this.deleteItem(url);
                        });
                    });

                    this.getUpdateButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');

                            UpdateContactPopup.load(url);
                        });
                    });

                    this.getNoteLogsStudentButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');

                            NodeLogsStudentPopup.load(url);
                        });
                    });

                    $(this.getPerPageSelectBox()).on('change', (e) => {
                        e.preventDefault();

                        var number = this.getPerPageSelectBox().value;

                        this.setPagePage(number);
                        this.setUrl(this.initUrl);
                        this.load();
                    });
                }
            };

            deleteItem(url) {
                ASTool.confirm({
                    message: 'Bạn có chắc chắn muốn xóa học viên này?',
                    ok: function() {
                        ASTool.addPageLoadingEffect();

                        $.ajax({
                            url: url,
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                            }
                        }).done((response) => {
                            ASTool.alert({
                                message: response.message,
                                ok: function() {
                                    StudentList.getList().load();
                                }
                            });
                        }).fail(function() {
                        }).always(function() {
                            ASTool.removePageLoadingEffect();
                        });
                    }
                });
            };

           

           
            showTopListActionBox() {
                this.getTopListActionBox().classList.remove('d-none');
            };

            showFilterActionBox() {
                this.getFilterActionBox().classList.remove('d-none');
                this.getFilterIcon().innerHTML = 'expand_less'
            };

            isFilterActionBoxShowed() {
                return !this.getFilterActionBox().classList.contains('d-none');
            };

            showSearchBoxes() {
                this.getSearchBoxes().classList.remove('d-none');
            };

            showToolBoxes() {
                this.getToolBoxes().classList.remove('d-none');
            };

            updateCountLabel() {
                this.container.querySelector('[list-control="count-label"]').innerHTML = 'Đã chọn <strong>' + this
                    .checkedCount() + '</strong> học viên';
            };

            hideTopListActionBox() {
                this.getTopListActionBox().classList.add('d-none');
            };

            hideFilterActionBox() {
                this.getFilterActionBox().classList.add('d-none');
                this.getFilterIcon().innerHTML = 'expand_more'
            };

            hideSearchBoxes() {
                this.getSearchBoxes().classList.add('d-none');
            };

            hideToolBoxes() {
                this.getToolBoxes().classList.add('d-none');
            };

            checkAllList() {
                this.getListCheckboxes().forEach(checkbox => {
                    checkbox.checked = true;
                });
            };

            uncheckAllList() {
                this.getListCheckboxes().forEach(checkbox => {
                    checkbox.checked = false;
                });
            };

            loadContent(content) {
                $(this.listContent).html(content);
                // always hide list action box and show 
                this.hideTopListActionBox();
                this.showSearchBoxes();
                this.showToolBoxes();

                initJs(this.listContent);
            };

            getStatus() {
                return this.status;
            };

            load() {
                this.addLoadEffect();

                if (this.listXhr) {
                    this.listXhr.abort();
                };

                this.listXhr = $.ajax({
                    url: this.url,
                    data: {
                        keyword: this.getKeyword(),
                        per_page: this.getPerPage(),
                       
                        sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),
                        source_type: this.getMarketingType(),
                        channel: this.getMarketingSource(),
                        sub_channel: this.getMarketingSourceSub(),
                        lifecycle_stage: this.getLifecycleStage(),
                        lead_status: this.getLeadStatus(),
                        salesperson_ids: this.getSalespersonIds(),
                        lead_status_menu: this.getLeadStatusMenu(),
                        lifecycle_stage_menu: this.getLifeCycleStageMenu(),
                        status: this.getStatus(),
                        columns: this.getColumns(),
                        
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),
                    }
                }).done((content) => {
                    this.loadContent(content);
                    this.initContentEvents();
                    this.removeLoadEffect();
                    
                }).fail(function() {
                });
            };

            setPagePage(number) {
                this.per_page = number;
            };

            getPerPage() {
                return this.per_page;
            };

            getPerPageSelectBox() {
                return this.listContent.querySelector('[list-control="per-page"]');
            };
            }
    </script>

@endsection