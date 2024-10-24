@extends('layouts.main.app', [
    'menu' => 'edu',
])
@section('sidebar')
    @include('edu.modules.sidebar', [
        'menu' => 'students',
        'sidebar' => 'students',
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
    <div class="post" id="kt_post">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                @include('edu.students.detail', [
                    'detail' => 'transferStudentDetail',
                ])
                <!--end::Details-->

                @include('edu.students.menu', [
                    'menu' => 'transferStudentDetail',
                ])
            </div>
        </div>
        <!--end::Navbar-->

        <div class="card" id="ClassesIndexContainer">
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
                                    row-action="delete-all" id="">

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
                    <div id="search-form" class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input list-action="keyword-input" type="text" data-kt-note-log-table-filter="search"
                            class="form-control w-250px ps-12" placeholder="Nhập để tìm lớp học" />
                    </div>
                    <!--begin::Search-->


                    <!--end::Search-->
                </div>

                <!--begin::Card toolbar-->
                <div class="card-toolbar" list-action="tool-action-box">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end">
                        <div class="d-flex align-items-center me-3 d-none">
                            <!--begin::Button-->
                            <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px"
                                id="buttonCreateNoteLog">
                                <i class="ki-duotone ki-abstract-10">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>
                                Thêm Ghi Chú
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
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Môn học</label>
                            <!--end::Label-->
                            <div>
                                <select list-action="subject-filter-select" class="form-select filter-select"
                                    data-control="select2" data-kt-customer-table-filter="month"
                                    data-placeholder="Chọn môn học" data-allow-clear="true" multiple="multiple">>
                                    <option></option>
                                    @foreach ($courseStudents as $courseStudent)
                                        <option value="{{ $courseStudent->course->subject->id }}">
                                            {{ $courseStudent->course->subject->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Input-->

                        <!--begin::Input-->
                        <div class="col-md-4 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Chủ nhiệm</label>
                            <!--end::Label-->
                            <div>
                                <select list-action="teacher-filter-select" class="form-select filter-select"
                                    data-control="select2" data-kt-customer-table-filter="month"
                                    data-placeholder="Chọn chủ nhiệm" data-allow-clear="true" multiple="multiple">
                                    <option></option>
                                    @foreach ($courseStudents as $courseStudent)
                                        <option value="{{ $courseStudent->course->teacher_id }}">
                                            {{ $courseStudent->course->teacher->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Input-->

                        <div class="col-md-4 mb-5">
                            <label class="form-label">Thời gian bắt đầu (Từ - Đến)</label>
                            <div class="row" list-action="start_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="start_at_from" placeholder="=asas"
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
                                            <input data-control="input" name="start_at_to" placeholder="=asas"
                                                type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-5 d-none">
                            <label class="form-label">Thời gian kết thúc (Từ - Đến)</label>
                            <div class="row" list-action="end_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="end_at_from" placeholder="=asas"
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
                                            <input data-control="input" name="end_at_to" placeholder="=asas"
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
        <div id="ClassesIndexListContent">


        </div>
        <!--end::Post-->
        <script>
            $(() => {
                RefundsIndex.init();
            });

            const RefundsIndex = function() {

                return {
                    init: () => {
                        // CustomerColumnManager.init();
                        TransferList.init();
                        FilterData.init();
                        ReportsStudentPopup.init();
                        UpdateReportsStudentPopup.init();
                        TransferClassPopup.init();
                    }
                }
            }();

            var TransferClassPopup = function() {
                var popupTransferClass;
                return {
                    init: function(updateUrl) {

                        popupTransferClass = new Popup({
                            url: updateUrl,
                        });
                    },

                    load: function(url) {
                        popupTransferClass.url = url;
                        popupTransferClass.load();
                    },


                    getPopup: function() {
                        return popupTransferClass;
                    },

                };
            }();
            var CustomerColumnManager = function() {
                var manager;

                return {
                    init: function() {
                        manager = new ColumnsDisplayManagerClass({
                            columns: {!! json_encode($columns) !!},
                            optionsBox: document.querySelector('[columns-control="options-box"]'),
                            getList: function() {
                                return TransferList.getList();
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



            let TransferList = function() {

                let list;

                return {
                    init: () => {


                        list = new DataList({
                            url: "{{ action('App\Http\Controllers\Edu\StudentController@transferList', ['id' => $contact->id]) }}",
                            container: document.querySelector("#ClassesIndexContainer"),
                            listContent: document.querySelector("#ClassesIndexListContent")
                        });

                        list.load();
                    },
                    getList: () => {
                        return list;
                    }
                };
            }();

            var ReportsStudentPopup = function() {
                var popupReportsStudent;
                return {
                    init: function(updateUrl) {
                        popupReportsStudent = new Popup({
                            url: updateUrl,

                        });
                    },
                    load: function(url) {
                        popupReportsStudent.url = url;
                        popupReportsStudent.load();
                    },
                    getPopup: function() {
                        return popupReportsStudent;
                    }
                };
            }();
            var UpdateReportsStudentPopup = function() {
                var popupReportsStudent;
                return {
                    init: function(updateUrl) {
                        popupReportsStudent = new Popup({
                            url: updateUrl,

                        });
                    },
                    load: function(url) {
                        popupReportsStudent.url = url;
                        popupReportsStudent.load();
                    },
                    getPopup: function() {
                        return popupReportsStudent;
                    }
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

            const FilterData = function() {
                let teachers = [];
                let subjects = [];
                let filterBtn = document.querySelector("#filterButton");
                let actionBox = document.querySelector('[list-action="filter-action-box"]');

                const getTeacherValues = () => {
                    teachers = Array.from(document.querySelector('[list-action="teacher-filter-select"]')
                            .selectedOptions)
                        .map(option => option.value);
                };
                const getSubjectValues = () => {
                    subjects = Array.from(document.querySelector('[list-action="subject-filter-select"]')
                            .selectedOptions)
                        .map(option => option.value);
                };

                return {

                    init: () => {
                        $('.filter-select').on('change', () => {
                            getTeacherValues();

                            TransferList.getList().setTeachers(teachers);
                            TransferList.getList().load();
                        });

                        $('.filter-select').on('change', () => {
                            getSubjectValues();

                            TransferList.getList().setSubjects(subjects);
                            TransferList.getList().load();
                        });

                        $('[list-action="start_at-select"]').on('change', function() {

                            var fromDate = $('[name="start_at_from"]').val();
                            var toDate = $('[name="start_at_to"]').val();



                            TransferList.getList().setStartAtFrom(fromDate);
                            TransferList.getList().setStartAtTo(toDate);
                            TransferList.getList().load();
                        });
                        $('[list-action="end_at-select"]').on('change', function() {

                            var fromDate = $('[name="end_at_from"]').val();
                            var toDate = $('[name="end_at_to"]').val();

                            TransferList.getList().setEndAtFrom(fromDate);
                            TransferList.getList().setEndAtTo(toDate);
                            TransferList.getList().load();
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
                    this.teachers;
                    this.subjects;

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
                getTransferClassButtons() {
                    return this.listContent.querySelectorAll('[row-action="class-transfer"]');
                };

                events() {
                    this.getkeywordInput().addEventListener('keyup', (e) => {
                        this.setKeyword(this.getkeywordInput().value);

                        if (event.keyword === "Enter") {
                            this.load();
                        };

                    });

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
                });
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
                getMaxStudents() {
                    return this.maxStudents;
                };

                getTeacherTypes() {
                    return this.teacherTypes;
                };

                getSales() {
                    return this.sales;
                };

                getSaleSups() {
                    return this.saleSups;
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

                getCancelRequestButtons() {
                    return this.listContent.querySelectorAll('[row-action="cancel-request"]');
                };

                getUpdateButtons() {
                    return this.listContent.querySelectorAll('[row-action="update"]');
                };

                getReportsStudentButtons() {
                    return this.listContent.querySelectorAll('[row-action="report-student"]');

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

                //start_at_from
                setStartAtFrom(startAtFrom) {
                    this.start_at_from = startAtFrom;
                }
                getStartAtFrom() {
                    return this.start_at_from;
                };
                //start_at_to
                setStartAtTo(startAtTo) {
                    this.start_at_to = startAtTo;
                }
                getStartAtTo() {
                    return this.start_at_to;
                };
                //end_at_from
                setEndAtFrom(endAtFrom) {
                    this.end_at_from = endAtFrom;
                }
                getEndAtFrom() {
                    return this.end_at_from;
                };
                //end_at_to
                setEndAtTo(endAtTo) {
                    this.end_at_to = endAtTo;
                }
                getEndAtTo() {
                    return this.end_at_to;
                };
                //teacher
                setTeachers(teachers) {
                    this.teachers = teachers;
                };
                getTeachers() {
                    return this.teachers;
                };

                //subject
                setSubjects(subjects) {
                    this.subjects = subjects;
                };
                getSubjects() {
                    return this.subjects;
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
                    this.getTransferClassButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();
                            var url = button.getAttribute('href');
                            TransferClassPopup.load(url);
                        });
                    });

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
                                                TransferList.getList().load();
                                            }
                                        })
                                    }).fail(function() {}).always(function() {
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

                        this.getCancelRequestButtons().forEach(button => {
                            button.addEventListener('click', (e) => {
                                e.preventDefault();

                                var url = button.getAttribute('href');

                                this.cancelRequest(url);
                            });
                        });

                        this.getReportsStudentButtons().forEach(button => {
                            button.addEventListener('click', (e) => {
                                e.preventDefault();

                                var url = button.getAttribute('href');

                                ReportsStudentPopup.load(url);
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

                cancelRequest(url) {
                    ASTool.confirm({
                        message: 'Bạn có chắc chắn muốn hủy yêu cầu này?',
                        ok: function() {
                            ASTool.addPageLoadingEffect();

                            $.ajax({
                                url: url,
                                method: 'POST',
                                data: {
                                    _token: "{{ csrf_token() }}",
                                }
                            }).done((response) => {
                                ASTool.alert({
                                    message: response.message,
                                    ok: function() {
                                        TransferList.getList().load();
                                    }
                                });
                            }).fail(function() {}).always(function() {
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
                    // this.addLoadEffect();
                    this.listXhr = $.ajax({
                        url: this.url,
                        data: {
                            keyword: this.getKeyword(),
                            page: this.page,
                            perpage: this.perpage,
                            sort_by: SortManager.getSortBy(),
                            sort_direction: SortManager.getSortDirection(),
                            maxStudents: this.getMaxStudents(),
                            teacherTypes: this.getTeacherTypes(),
                            // columns: CustomerColumnManager.getColumns(),
                            created_at_from: this.getCreatedAtFrom(),
                            created_at_to: this.getCreatedAtTo(),
                            updated_at_from: this.getUpdatedAtFrom(),
                            updated_at_to: this.getUpdatedAtTo(),
                            teachers: this.getTeachers(),
                            subjects: this.getSubjects(),
                            start_at_from: this.getStartAtFrom(),
                            start_at_to: this.getStartAtTo(),
                            end_at_from: this.getEndAtFrom(),
                            end_at_to: this.getEndAtTo(),
                            status: this.getStatus(),
                        }
                    }).done((content) => {
                        this.loadContent(content);
                        this.initContentEvents();
                        this.removeLoadEffect();

                        // apply
                        // CustomerColumnManager.applyToList();

                    }).fail(function() {});
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