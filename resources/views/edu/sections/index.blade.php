 @extends('layouts.main.app', [
    'menu' => 'edu',
])


@section('sidebar')
    @include('edu.modules.sidebar', [
        'menu' => 'sections',
        'sidebar' =>'sections',
        'status' => '',
        'lifecycle_stage_menu' => '',
        'lead_status_menu' => ''
    ])
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh sách thời khóa biểu</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Lịch học</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Danh sách</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->

    <div class="card-body pb-0">
        @include('edu.sections.menu', [
            'menu' => 'list',
        ])
    </div>

    <div id="SectionIndexContainer" class="position-relative" id="kt_post">
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
                                    <a row-action="delete-all" href="{{ action([App\Http\Controllers\Edu\SectionController::class, 'deleteAll']) }}"
                                        class="menu-link px-3" list-action="sort">Hủy</a>
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
                <div class="card-title" list-action="search-action-box">
                    <!--begin::Search-->
                    <div id="search-form" class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input list-action="keyword-input" type="text" data-kt-customer-table-filter="search"
                            class="form-control w-250px ps-12" placeholder="Tìm buổi học..." />
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
                        <button type="button" class="btn btn-outline btn-outline-default" id="filter-orders-btn">
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
            <div class="card-header border-0 p-4 pb-0 d-none list-filter-box" list-action="filter-action-box">
                <!--begin::Card toolbar-->
                <div class="card-toolbar w-100 mb-0" list-action="tool-action-box">
                    <!--begin::Toolbar-->
                    <div class="row w-100">
                        <!--begin::Content-->
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Lớp học</label>
                            <select list-action="course-filter-select" class="form-select form-control filter-select"
                                data-control="select2" data-kt-customer-table-filter="month"
                                data-placeholder="Chọn lớp học" data-allow-clear="true" multiple="multiple">
                                @foreach(App\Models\Course::all() as $course)
                                    <option value="{{ $course->id }}">{{ $course->code }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Môn học</label>
                            <select list-action="subject-filter-select" class="form-select form-control filter-select"
                                data-control="select2" data-kt-customer-table-filter="month"
                                data-placeholder="Chọn lớp học" data-allow-clear="true" multiple="multiple">
                                @foreach(App\Models\Subject::all() as $subject)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 mb-5">
                            <label class="form-label fw-semibold">Học viên</label>
                            @include('helpers.contactSelector', [
                                'name' => 'contact_id',
                                'url' => action('App\Http\Controllers\Edu\StudentController@select2'),
                                'controlParent' => '#SectionIndexContainer',
                                'placeholder' => 'Tìm học viên từ hệ thống',
                                'value' => null,
                                'text' => null,
                                'createUrl' => action('\App\Http\Controllers\Edu\StudentController@create'),
                                'editUrl' => action('\App\Http\Controllers\Edu\StudentController@edit', 'CONTACT_ID'),
                                'notAdd' => true,
                                'notEdit' => true,
                                'multiple' => true,
                            ])
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Phân loại</label>
                                <select list-action="type-filter-select" class="form-select form-control filter-select" name="type"
                                data-control="select2" data-placeholder="Phân loại" data-allow-clear="true" multiple="multiple">
                                <option value="">Phân loại</option>
                                @foreach( App\Models\Section::getAllType() as $type )
                                <option value="{{ $type }}">{{ trans('messages.section.' . $type) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row w-100">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Giáo viên</label>
                                <select list-action="teacher-filter-select" class="form-select form-control filter-select" name="teacher_id"
                                data-control="select2" data-placeholder="Chọn giáo viên" data-allow-clear="true" multiple="multiple">
                                <option value="">Chọn giáo viên</option>
                                @foreach( App\Models\Teacher::get() as $teacher )
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Chủ nhiệm</label>
                                <select list-action="homeroom-filter-select" class="form-select form-control filter-select" name="home_room_id"
                                data-control="select2" data-placeholder="Chọn giáo viên" data-allow-clear="true" multiple="multiple">
                                <option value="">Chọn chủ nhiệm</option>
                                @foreach( App\Models\Teacher::homeRooms()->inArea(\App\Library\Branch::getCurrentBranch())->get() as $teacher )
                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 mb-5">
                            <label class="form-label">Ngày bắt đầu học (Từ - Đến)</label>
                            <div class="row" list-action="start_end_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="start_at_from" placeholder="=asas" type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="start_at_to" placeholder="=asas" type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
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
        </div>

        <div id="SectionIndexListContent">
        </div>
        <!--begin::Modals-->
        <!--begin::Modal - Adjust Balance-->
        <div class="modal fade" id="kt_contacts_export_modal" tabindex="-1" aria-hidden="true">
            <!--begin::Modal dialog-->
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <!--begin::Modal content-->
                <div class="modal-content">
                    <!--begin::Modal header-->
                    <div class="modal-header">
                        <!--begin::Modal title-->
                        <h2 class="fw-bold">Export Contacts</h2>
                        <!--end::Modal title-->
                        <!--begin::Close-->
                        <div id="kt_contacts_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                        <!--end::Close-->
                    </div>
                    <!--end::Modal header-->
                </div>
                <!--end::Modal content-->
            </div>
            <!--end::Modal dialog-->
        </div>
        <!--end::Modal - New Card-->
        <!--end::Modals-->
    </div>
    <!--end::Post-->

    <script>
        $(() => {
            OrdersFeatureIndex.init();
        });
        
        const OrdersFeatureIndex = function() {
            
            return {
                init: () => {
                    CustomerColumnManager.init();
                    SectionsList.init();
                    filterData.init();
                    DeleteOrderPopup.init();
                    ShowOrderPopup.init();
                }
            }
        }();

        var CustomerColumnManager = function() {
            var manager;

            return {
                init: function() {
                    manager = new ColumnsDisplayManagerClass({
                        name: ' {{ $listViewName }}',
                        saveUrl: '{{ action([App\Http\Controllers\UserController::class, 'saveListColumns']) }}',
                        columns: {!! json_encode($columns) !!},
                        optionsBox: document.querySelector('[columns-control="options-box"]'),
                        getList: function() {
                                return SectionsList.getList();
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
    
    
        let SectionsList = function() {
    
            let list;
    
            return {
                init: () => {
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\Edu\SectionController@list') }}",
                        container: document.querySelector("#SectionIndexContainer"),
                        listContent: document.querySelector("#SectionIndexListContent"),
                        status: '{{ request()->status ?? 'all' }}',
                    });
    
                    list.load();
                },
                getList: () => {
                    return list;
                }
            };
        }();
    
        let DeleteOrderPopup = function() {
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
    
        let ShowOrderPopup = function() {
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
    
            const filterData = function() {
                let maxStudents = 30;
                let courses = [];
                let subjects = [];
                let teachers = [];
                let homeRooms = [];
                let types = [];
                let sales = [];
                let saleSups = [];
                let filterBtn = document.querySelector("#filter-orders-btn");
                let actionBox = document.querySelector('[list-action="filter-action-box"]');
    
                const getMaxStudentsValue = () => {
                    maxStudents = document.querySelector('#max-students-filter-input').value;
                };
    
                const getCourseValues = () => {
                    courses = Array.from(document.querySelector('[list-action="course-filter-select"]').selectedOptions)
                        .map(option => option.value);
                };

                const getSubjectValues = () => {
                    subjects = Array.from(document.querySelector('[list-action="subject-filter-select"]').selectedOptions)
                        .map(option => option.value);
                };

                const getTeacherValues = () => {
                    teachers = Array.from(document.querySelector('[list-action="teacher-filter-select"]').selectedOptions)
                        .map(option => option.value).filter(function(value) {return Boolean(value); });
                };

                const getHomeRoomValues = () => {
                    homeRooms = Array.from(document.querySelector('[list-action="homeroom-filter-select"]').selectedOptions)
                        .map(option => option.value).filter(function(value) {return Boolean(value); });
                };

                const getTypeValues = () => {
                    types = Array.from(document.querySelector('[list-action="type-filter-select"]').selectedOptions)
                        .map(option => option.value).filter(function(value) {return Boolean(value); });
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

                const studentSelectBox = function() {
                    return $('[name="contact_id"]');
                }
    
                return {
                    init: () => {
    
                        $('.filter-select').on('change', () => {
                            getCourseValues();
                            getSubjectValues();
                            getTeacherValues();
                            getHomeRoomValues();
                            getTypeValues();
    
                            SectionsList.getList().setCourses(courses);
                            SectionsList.getList().setSubjects(subjects);
                            SectionsList.getList().setTeachers(teachers);
                            SectionsList.getList().setHomeRooms(homeRooms);
                            SectionsList.getList().setTypes(types);
                            SectionsList.getList().load();
                        });

                        studentSelectBox().on('change', function(e) {
                            e.preventDefault();

                            SectionsList.getList().setStudentId(studentSelectBox().val());
                            SectionsList.getList().load();
                        })

                        $('#max-students-filter-input').on('change', () => {
                            getMaxStudentsValue();
                            SectionsList.getList().setMaxStudents(maxStudents);
                            SectionsList.getList().load();
                        })
    
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
    
                        $('[list-action="start_end_at-select"]').on('change', function() {
                            var startAtFrom = $('[name="start_at_from"]').val();
                            var startAtTo = $('[name="start_at_to"]').val();
    
                            SectionsList.getList().setStartAtFrom(startAtFrom);
                            SectionsList.getList().setStartAtTo(startAtTo);
                            SectionsList.getList().load();
                        });
                    }
                };
            }();
    
            let DataList = class {
                constructor(options) {
                    this.url = options.url;
                    this.container = options.container;
                    this.listContent = options.listContent;
                    this.keyword;
                    this.page;
                    this.perpage;
                    this.sort_by;
                    this.sort_direction;
                    this.maxStudents;
                    this.courses;
                    this.subjects;
                    this.teachers;
                    this.types;
                    this.studentId;
                    this.sales;
                    this.saleSups;
                    this.status = options.status;
    
                    this.events();
                }
    
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
                    }
                };
    
                removeLoadEffect() {
                    this.listContent.classList.remove('list-loading');
    
                    // remove loader
                    if (this.container.querySelector('[list-action="loader"]')) {
                        this.container.querySelector('[list-action="loader"]').remove();
                    }
                };

                getDeleteAllItemsBtn() {
                    return this.container.querySelector('[row-action="delete-all"]');
                };
    
                setUrl(newUrl) {
                    this.url = newUrl;
                };
    
                setSortBy(sortBy) {
                    this.sort_by = sortBy;
                };
    
                setSortDirection(sortDirection) {
                    this.sort_direction = sortDirection;
                };
    
                setMaxStudents(maxStudents) {
                    this.maxStudents = maxStudents;
                };
    
                setCourses(courses) {
                    this.courses = courses;
                };

                setStudentId(studentId) {
                    this.studentId = studentId;
                };

                getStudentId() {
                    return this.studentId;
                };

                setSubjects(subjects) {
                    this.subjects = subjects;
                };

                setTeachers(teachers) {
                    this.teachers = teachers;
                };

                setHomeRooms(homeRooms) {
                    this.homeRooms = homeRooms;
                }

                setTypes(types) {
                    this.types = types;
                };

                setSales(sales) {
                    this.sales = sales;
                };
    
                setSaleSups(saleSups) {
                    this.saleSups = saleSups;
                };
    
                getMaxStudents() {
                    return this.maxStudents;
                };
    
                getCourses() {
                    return this.courses;
                };

                getSubjects() {
                    return this.subjects;
                };

                getTeachers() {
                    return this.teachers;
                };

                getHomeRooms() {
                    return this.homeRooms;
                };

                getTypes() {
                    return this.types;
                };
    
                getSales() {
                    return this.sales;
                };
    
                getSaleSups() {
                    return this.saleSups;
                };
    
                loadContent(content) {
                    $(this.listContent).html(content);
    
                    initJs(this.listContent);
                };
    
                getNumberOfItems() {
                    return this.listContent.querySelectorAll('[list-control="item"]').length;
                };
    
                getPageUrl() {
                    return this.listContent.querySelectorAll('a.page-link');
                };

                getPerPageSelectBox() {
                    return this.listContent.querySelector('[list-control="per-page"]');
                }
    
                setPerpage(perpage) {
                    this.perpage = perpage;
                };
    
                setPage(page) {
                    this.page = page;
                };
    
                getSortBy() {
                    return this.sort_by;
                };
    
                getSortDirection() {
                    return this.sort_direction;
                };
    
                getCheckNoteBtns() {
                    return this.listContent.querySelectorAll('[list-action="check-item"]');
                };
    
                getCheckAllBtn() {
                    return this.listContent.querySelector('[list-action="check-all"]');
                };
    
                getCheckedItemBtns() {
                    return this.listContent.querySelectorAll('[list-action="check-item"]:checked');
                };
    
                getCheckedItemBtnsNumber() {
                    return this.getCheckedItemBtns().length;
                };
    
                getItemCheckedIds() {
                    let checkedNoteBtnIds = [];
    
                    this.getCheckedItemBtns().forEach(note => {
                        checkedNoteBtnIds.push(Number(note.getAttribute('data-item-id')));
                    });
    
                    return checkedNoteBtnIds;
                };
    
                showSearchForm() {
                    document.querySelector('#search-form').classList.remove("d-none");
                };
    
                showActionForm() {
                    document.querySelector('[list-action="tool-action-box"]').classList.remove('d-none');
                };
    
                hideActionForm() {
                    document.querySelector('[list-action="tool-action-box"]').classList.add('d-none');
                };
    
                hideSearchForm() {
                    document.querySelector('#search-form').classList.add("d-none");
                };
    
                getTopActionBox() {
                    return document.querySelector('[list-action="top-action-box"]');
                };
    
                hideTopActionBox() {
                    this.getTopActionBox().classList.add('d-none');
                };
    
                showTopActionBox() {
                    this.getTopActionBox().classList.remove('d-none');
                };
    
                getFilterActionBox() {
                    return document.querySelector('[list-action="filter-action-box"]');
                };
    
                showFilterActionBox() {
                    this.getFilterActionBox().classList.remove('d-none');
                };
    
                hideFilterActionBox() {
                    this.getFilterActionBox().classList.add('d-none');
                };
    
                updateCountLabel() {
                    this.container.querySelector('[list-control="count-note-selected-label"]').innerHTML =
                        'Đã chọn <strong>' + this
                        .checkedCount() + '</strong> khóa học';
                };
    
                checkedCount() {
                    return this.getCheckedItemBtns().length;
                };
    
                getColumnsCheckboxes() {
                    return this.container.querySelectorAll('[list-action="column-checker"]');
                };
    
                addColumn(column) {
                    this.columns.push(column);
                };
    
                removeColumn(column) {
                    this.columns = this.columns.filter(e => e !== column);
                };
    
                getColumns() {
                    return this.columns;
                };
    
                setKeyWord(keyword) {
                    this.keyword = keyword;
                };
    
                getKeyword() {
                    return this.keyword;
                };
    
                getSearchKeywordInput() {
                    return this.container.querySelector('[list-action="keyword-input"]');
                };
    
                getColumnHeaders() {
                    return document.querySelectorAll('[list-action="sort"]');
                };
    
                getUpdateBtns() {
                    return this.listContent.querySelectorAll('[row-action="update"]');
                };
                getShiftBtns() {
                    return this.listContent.querySelectorAll('[row-action="shift"]');
                };
               
                getDeleteBtns() {
                    return this.listContent.querySelectorAll('[row-action="destroy"]');
                };
    
                getShowConstractBtns() {
                    return this.listContent.querySelectorAll('[row-action="show"]');
                };
    
                setStartAtFrom(startAtFrom) {
                    this.startAtFrom = startAtFrom;
                };

                getStartAtFrom() {
                    return this.startAtFrom;
                };
                
                setStartAtTo(startAtTo) {
                    this.startAtTo = startAtTo;
                };

                getStartAtTo() {
                    return this.startAtTo;
                };

                getStatus() {
                    return this.status;
                };
    
                events() {
                    /**
                     * SEARCH BY INPUT FORM
                     */
                    this.getSearchKeywordInput().addEventListener("keyup", e => {
                        this.setKeyWord(this.getSearchKeywordInput().value);

                        if (event.key === 'Enter') {
                            this.load();
                        }
                    });
    
                    this.getSearchKeywordInput().addEventListener('keyup', e => {
                        this.load();
                    });
    
                    /**
                     * SHOW COLUMNS
                     */
                    this.getColumnsCheckboxes().forEach(checkbox => {
                        const checkboxes = this.getColumnsCheckboxes();
    
                        checkbox.addEventListener('change', e => {
                            const isChecked = checkbox.checked;
                            const column = checkbox.value;
    
                            if (!isChecked) {
                                // Uncheck "check all" box when exist any box is unchecked
                                // allCheckbox.checked = false
                            }
    
                            if (isChecked) {
                                this.addColumn(column);
                            } else {
                                this.removeColumn(column);
                            }
    
                            this.load();
                        });
                    });
                };
    
                initContentEvents() {
                    let _this = this;
    
                    // When list has items
                    if (this.getNumberOfItems()) {
                        /**
                         * HANDLE PAGE ITEMS LIST PER PAGE
                         */
                        this.getPageUrl().forEach(url => {
                            url.addEventListener('click', e => {
                                e.preventDefault();
    
                                let u = new URL(url.getAttribute('href'));
                                let params = new URLSearchParams(u.search);
                                let pageNumber = params.get('page');
    
                                this.setPage(pageNumber);
                                this.load();
                            })
                        });
    
                        // /**
                        //  * PAGINATION PER PAGE
                        //  */
                        $('#perPage').change(() => {
                            const perPage = $('#perPage').val();
                            this.setPerpage(perPage);
                            this.setPage(1);
                            this.load();
                        });

                        // change per page select box value
                        // $(this.getPerPageSelectBox()).on('change', (e) => {
                        //     e.preventDefault();

                        //     var number = this.getPerPageSelectBox().value;

                        //     // this.setPagePage(number);
                        //     this.setPerpage(number)

                        //     // reload lại list về url bên đầu
                        //     this.setUrl(this.initUrl);
                        //     this.load();
                        // });
    
                        /**
                         * CHECK ITEMS, CHECK ALL ITEMS
                         */
                        this.getCheckNoteBtns().forEach(button => {
                            const isChecked = button.checked;
    
                            button.addEventListener('change', e => {
                                this.hideFilterActionBox();
    
                                const isAnyNoteChecked = Array
                                    .from(this.getCheckNoteBtns())
                                    .some(item => {
                                        return !item.checked;
                                    });
    
                                this.getCheckAllBtn().checked = !isAnyNoteChecked;
    
                                if (this.getCheckedItemBtns().length > 0) {
                                    this.hideSearchForm();
                                    this.hideActionForm();
                                    this.showTopActionBox();
                                } else {
                                    this.showSearchForm();
                                    this.showActionForm();
                                    this.hideTopActionBox();
                                }
    
                                this.updateCountLabel();
                            })
                        });
    
                        this.getCheckAllBtn().addEventListener('change', e => {
                            this.hideFilterActionBox();
    
                            this.getCheckNoteBtns().forEach(button => {
                                button.checked = e.target.checked;
                            });
    
                            if (this.getCheckedItemBtns().length > 0) {
                                this.hideSearchForm();
                                this.hideActionForm();
                                this.showTopActionBox();
                            } else {
                                this.showSearchForm();
                                this.showActionForm();
                                this.hideTopActionBox();
                            };
    
                            this.updateCountLabel();
                        });
    
                        // When click header column => sort by direction on column clicked
                        this.getColumnHeaders().forEach(columnHeader => {
                            let sortBy = columnHeader.getAttribute('sort-by');
                            let sortDirection = columnHeader.getAttribute('sort-direction');
                            let currSortDirection;
    
                            columnHeader.addEventListener('click', e => {
                                e.preventDefault();
    
                                currSortDirection = this.getSortDirection();
    
                                if (currSortDirection && currSortDirection == sortDirection) {
                                    if (currSortDirection === 'desc') {
                                        sortDirection = 'asc';
                                    } else {
                                        sortDirection = 'desc';
                                    };
                                };
    
                                this.setSortBy(sortBy);
                                this.setSortDirection(sortDirection);
                                this.setSortDirection(sortDirection);
    
                                this.load();
                            })
                        });
    
                        /**
                         * When click Update item
                         */
                        this.getUpdateBtns().forEach(button => {
                            button.addEventListener("click", function(e) {
                                e.preventDefault();
    
                                const currentOrderId = this.getAttribute("data-ids");
    
                                _this.addLoadEffect();
    
                                window.location.href = `sales/orders/create-constract\\${currentOrderId}\\update`;
                            })
                        });
                        
                        this.getShiftBtns().forEach(button => {
                            button.addEventListener('click', (e) => {
                                e.preventDefault();
    
                                var url = button.getAttribute('href');
    
                                ShowOrderPopup.updateUrl(url);
                            });
                        });
                        
    
                        /**
                         * DELETE ORDER
                         */
                        this.getDeleteBtns().forEach(button => {
                            button.addEventListener('click', function(e) {
                                e.preventDefault();
                                const url = this.getAttribute('href')
    
                                ASTool.confirm({
                                    message: "Bạn có chắc muốn hủy buổi học này không?",
                                    ok: function() {
                                        ASTool.addPageLoadingEffect();
    
                                        $.ajax({
                                            url: url,
                                            method: "DELETE",
                                            data: {
                                                _token: "{{ csrf_token() }}"
                                            }
                                        }).done(response => {
                                            ASTool.alert({
                                                message: response.message,
                                                ok: function() {
                                                    SectionsList.getList().load();
                                                }
                                            })
                                        }).fail(function() {
    
                                        }).always(function() {
                                            ASTool.removePageLoadingEffect();
                                        })
                                    }
                                });
                            });
                        });
    
                        /**
                         * SHOW ORDER
                         */
                         this.getShowConstractBtns().forEach(button => {
                            button.addEventListener('click', function(e) {
                                e.preventDefault();
                                const url = this.getAttribute('href')
    
                                ShowOrderPopup.updateUrl(url);
                            });
                        });

                        this.getDeleteAllItemsBtn().addEventListener('click', function() {
                            const items = _this.getItemCheckedIds();

                            _this.hideTopActionBox();
                            _this.showSearchForm();

                            ASTool.confirm({
                                message: "Bạn có chắc muốn hủy các buổi học này không?",
                                ok: function() {
                                    ASTool.addPageLoadingEffect();

                                    $.ajax({
                                        url: "{{ action('\App\Http\Controllers\Edu\SectionController@deleteAll') }}",
                                        method: "DELETE",
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            items: items
                                        }
                                    }).done(response => {
                                        ASTool.alert({
                                            message: response.message,
                                            ok: function() {
                                                SectionsList.getList().load();
                                            }
                                        })
                                    }).fail(function() {

                                    }).always(function() {
                                        ASTool.removePageLoadingEffect();
                                    })
                                }
                            });
                        });
                    };
                };
    
                load() {
                    this.addLoadEffect();
                    this.listXhr = $.ajax({
                        url: this.url,
                        data: {
                            keyword: this.getKeyword(),
                            page: this.page,
                            perpage: this.perpage,
                            sort_by: this.getSortBy(),
                            sort_direction: this.getSortDirection(),
                            maxStudents: this.getMaxStudents(),
                            courses: this.getCourses(),
                            subjects: this.getSubjects(),
                            teachers: this.getTeachers(),
                            homeRooms: this.getHomeRooms(),
                            types: this.getTypes(),
                            studentId: this.getStudentId(),
                            columns: CustomerColumnManager.getColumns(),
                            start_at_from: this.getStartAtFrom(),
                            start_at_to: this.getStartAtTo(),
                            status: this.getStatus(),
                        }
                    }).done(content => {
                        this.loadContent(content);
                        this.initContentEvents();
                        this.removeLoadEffect();
    
                        // apply
                        CustomerColumnManager.applyToList();
                    }).fail(message => {
                        throw new Error("ERROR: LOAD CONTENT ORDER FAIL!");
                    })
                };
            }
    </script>
@endsection

