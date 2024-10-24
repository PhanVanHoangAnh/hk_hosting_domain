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
    <div id="studentsManager">
        <!--begin::Toolbar-->
        <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column py-1">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center my-1">
                    <span class="text-dark fw-bold fs-1">Quản lý xếp lớp</span>
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
                    <li class="breadcrumb-item text-muted">Quản lý xếp lớp</li>
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
            <!--begin::Actions-->
            <div class="d-flex align-items-center py-1">
                <!--begin::Button-->
                <a href="{{ action('App\Http\Controllers\Edu\StudentController@assignToClass') }}"
                    class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px" id="assignToClassBtn">
                    <span class="material-symbols-rounded me-2">
                        person_add
                    </span>
                    Xếp lớp
                </a>
                <!--end::Button-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div id="StaffIndexContainer" class="position-relative" id="kt_post">
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
                                        <a row-action="delete-all"
                                            href="{{ action([App\Http\Controllers\Edu\StaffController::class, 'deleteAll']) }}"
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
                    <div class="card-title" list-action="search-action-box">
                        <!--begin::Search-->
                        <div id="search-form" class="d-flex align-items-center position-relative my-1">
                            <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                            <input list-action="keyword-input" type="text" data-kt-customer-table-filter="search"
                                class="form-control w-250px ps-12" placeholder="Tìm xếp lớp..." />
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
                                                                <div column-control="unchecked-box"
                                                                    class="container-columns">
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
                            <!--begin::Content-->
                            <div class="col-md-3 d-none">
                                <!--begin::Label-->
                                {{-- <label class="form-label fw-semibold ">Tag:</label> --}}
                                <!--end::Label-->
                                <div>
                                    <select list-control="tag-select" class="form-select" data-control="select2"
                                        data-placeholder="Chọn" multiple="multiple" name="tags[]">
                                        {{-- <option></option> --}}
                                        {{-- @foreach ($tags as $tag)
                                            <option value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                                for="tag_{{ $tag->id }}">
                                                {{ $tag->name }}
                                            </option>
                                        @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 mb-5">

                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Học viên:</label>
                                <!--end::Label-->
                                <select list-action="student" class="form-select filter-select" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn học viên" data-allow-clear="true"
                                    multiple="multiple">
                                    @php
                                        $types = App\Models\Contact::students()->pluck('name')->unique();
                                    @endphp
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-5{{ request()->status == 'notEnrolled' ? ' d-none' : '' }}">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Lớp học:</label>
                                <!--end::Label-->

                                <select list-action="class-room" class="form-select filter-select" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn lớp học" data-allow-clear="true"
                                    multiple="multiple">
                                    @php
                                        $types = App\Models\Course::course()->pluck('code')->unique();
                                    @endphp
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}"> {{ $type }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-3 mb-5">
                                <label class="form-label">Tình trạng</label>
                                <select list-action="status-student" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false"
                                    data-placeholder="Chọn tình trạng" data-allow-clear="true">
                                    <option value=""></option>
                                    <option value="enrolled">Đã xếp lớp</option>
                                    <option value="notEnrolled">Chờ xếp lớp</option>

                                </select>
                            </div>

                            <div class="col-md-3 mb-5 d-none">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Giảng viên</label>
                                <!--end::Label-->
                                <select list-action="home-room" class="form-select filter-select" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn giảng viên"
                                    data-allow-clear="true" multiple="multiple">
                                    @php
                                        $types = App\Models\OrderItem::edu()->pluck('home_room')->unique();
                                    @endphp
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}">
                                            {{ App\Models\Teacher::find($type) ? App\Models\Teacher::find($type)->name : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-5">
                                <label class="form-label">Môn học</label>
                                <select list-action="subject-name" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false" data-placeholder="Chọn dịch vụ"
                                    data-allow-clear="true" multiple="multiple">

                                    @php
                                        $types = App\Models\Subject::pluck('name')->unique();
                                    @endphp

                                    @foreach ($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                        <!--end::Menu 1-->
                        <!--begin::Toolbar-->
                        <div class="row">
                            <!--begin::Content-->
                            <div class="col-md-3 mb-5">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Trình độ:</label>
                                <!--end::Label-->
                                <select list-action="level" class="form-select filter-select" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn trình độ" data-allow-clear="true"
                                    multiple="multiple">
                                    <option value="">Chọn</option>
                                    @foreach (config('levels') as $level)
                                        <option value="{{ $level }}"
                                            {{ isset($orderItem) && $orderItem->level == $level ? 'selected' : '' }}>
                                            {{ $level }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-5">
                                <label class="form-label">Lớp phù hợp</label>
                                <select list-action="suitable-class" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false" data-placeholder="Chọn dịch vụ"
                                    data-allow-clear="true">
                                    <option></option>
                                    <option value="greater_than_0">Có lớp</option>
                                    <option value="less_than_0">Không có lớp</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-5">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Chi nhánh:</label>
                                <!--end::Label-->

                                <select id="branch-select" list-action="branch-select" class="form-select filter-select"
                                    data-control="select2" data-placeholder="Chọn chi nhánh đào tạo"
                                    data-close-on-select="false" data-allow-clear="true">
                                    <option value="">Chọn chi nhánh</option>
                                    @foreach (App\Models\TrainingLocation::getBranchs() as $branch)
                                        <option value="{{ $branch }}"
                                            {{ isset($orderItem->training_location_id) &&
                                            $orderItem->getLocationBranch() === $branch
                                                ? 'selected'
                                                : '' }}>
                                            {{ trans('messages.training_location.' . $branch) }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-3 mb-5 ">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Địa điểm</label>
                                <!--end::Label-->
                                <select id="location-select" list-action="location-select"
                                    class="form-select filter-select" name="training_location_id" data-control="select2"
                                    data-placeholder="Chọn địa điểm đào tạo" data-close-on-select="false"
                                    data-allow-clear="true">
                                </select>
                            </div>
                        </div>
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
                        </div>


                        <!--end::Menu 1-->
                        <!--end::Filter-->
                    </div>
                    <!--end::Toolbar-->
                </div>
            </div>

            <div id="ClassAssignmentsList">
            </div>
        </div>

        <script>
            $(() => {
                OrdersFeatureIndex.init();
            });

            const OrdersFeatureIndex = function() {
                return {
                    init: () => {
                        CustomerColumnManager.init();
                        StaffsList.init();
                        FilterData.init();
                        UpdateContactPopup.init();
                        studentsManager = new StudentsManager({
                            container: document.querySelector('#studentsManager')
                        });

                        assignToClassPopup = new AssignToClassPopup({
                            studentsManager: studentsManager
                        });
                    }
                }
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
            let StaffsList = function() {
                let list;
                return {
                    init: () => {
                        list = new DataList({
                            url: "{{ action('\App\Http\Controllers\Edu\ClassAssignmentsController@list') }}",
                            container: document.querySelector("#StaffIndexContainer"),
                            listContent: document.querySelector("#ClassAssignmentsList"),
                            type: '{{ request()->type ?? 'all' }}',
                            status: '{{ request()->status ?? 'all' }}',
                            toolbar: document.querySelector("#kt_toolbar")
                        });

                        list.load();
                    },
                    getList: () => {
                        return list;
                    }
                };
            }();

            var StudentsManager = class {
                constructor(options) {
                    this.container = options.container;

                    this.events();
                };
                getContainer() {
                    return this.container;
                }

                // Branch
                getBranchSelector() {
                    return this.getContainer().querySelector('#branch-select');
                }

                // Branch value selected
                getBranch() {
                    return this.getBranchSelector().value;
                }

                // Location
                getLocationSelector() {
                    return this.getContainer().querySelector('[name="training_location_id"]');
                }

                // Location value selected
                getLocation() {
                    return this.getLocationSelector().value;
                }

                changeBranch() {
                    this.queryLocations();
                }

                getLocationSelectedId() {
                    const id = "{{ isset($orderItem->training_location_id) ? $orderItem->training_location_id : '' }}";
                    return id;
                }
                // Call ajax to get all locations froms server
                queryLocations() {
                    const _this = this;
                    const branch = this.getBranch();
                    const url = "{!! action(
                        [App\Http\Controllers\TrainingLocationController::class, 'getTrainingLocationsByBranch'],
                        ['branch' => 'PLACEHOLDER'],
                    ) !!}";
                    const updateUrl = url.replace('PLACEHOLDER', branch);

                    $.ajax({
                        url: updateUrl,
                        method: 'get'
                    }).done(response => {
                        const options = _this.createLocationsOptions(response);

                        _this.getLocationSelector().innerHTML = options;
                    }).fail(response => {
                        throw new Error(response.message);
                    })
                }

                createLocationsOptions(locations) {
                    let options = '<option value="">Chọn</option>';
                    const locationSelectedId = this.getLocationSelectedId();
                    let selected = '';

                    locations.forEach(i => {
                        const id = i.id;
                        const name = i.name;

                        if (parseInt(i.id) === parseInt(locationSelectedId)) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }

                        options += `<option value="${name}" ${selected}>${name}</option> `;
                    })

                    return options;
                }

                getAssignToClassBtn() {
                    return this.container.querySelector('#assignToClassBtn');
                };

                events() {
                    const _this = this;
                    $(_this.getBranchSelector()).on('change', function(e) {
                        e.preventDefault();
                        _this.changeBranch();
                    })
                    $(_this.getAssignToClassBtn()).on('click', function(e) {
                        e.preventDefault();

                        const url = this.getAttribute('href');

                        assignToClassPopup.updateUrl(url);
                        assignToClassPopup.show();
                    });
                };
            };
            var AssignToClassPopup = class {
                constructor(options) {
                    this.popup = new Popup();
                    this.studentsManager = options.studentsManager
                };

                getPopup() {
                    return this.popup;
                };

                updateUrl(newUrl) {
                    this.popup.url = newUrl;
                };

                show() {
                    this.popup.load();
                };

                hide() {
                    this.popup.hide();
                };
            };
            var CustomerColumnManager = function() {
                var manager;

                return {
                    init: function() {
                        manager = new ColumnsDisplayManagerClass({
                            name: '{{ $listViewName }}',
                            saveUrl: '{{ action([App\Http\Controllers\UserController::class, 'saveListColumns']) }}',
                            columns: {!! json_encode($columns) !!},
                            optionsBox: document.querySelector('[columns-control="options-box"]'),
                            getList: function() {
                                return StaffsList.getList();
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

            const FilterData = function() {
                let subjectName = [];
                let orderType = [];
                let level = [];
                let classType = [];
                let homeRoom = [];
                let statusStudent;
                let numOfStudent = [];
                let studyType = [];
                let student = [];
                let classRoom = [];
                let branchName;
                let locationName;
                let suitableClass;



                let filterBtn = document.querySelector("#filter-orders-btn");
                let actionBox = document.querySelector('[list-action="filter-action-box"]');


                const getBranchNameValues = () => {
                    branchName = document.querySelector('[list-action="branch-select"]').value;
                };
                const getLocationNameValues = () => {
                    locationName = document.querySelector('[list-action="location-select"]').value;
                };
                const getSuitableClassValues = () => {
                    suitableClass = document.querySelector('[list-action="suitable-class"]').value;
                };

                const getLevelValues = () => {
                    level = Array.from(document.querySelector('[list-action="level"]')
                            .selectedOptions)
                        .map(option => option.value);
                };

                const getSubjectNameValues = () => {
                    subjectName = Array.from(document.querySelector('[list-action="subject-name"]')
                            .selectedOptions)
                        .map(option => option.value);
                };

                const getClassRoomValues = () => {
                    classRoom = Array.from(document.querySelector('[list-action="class-room"]')
                            .selectedOptions)
                        .map(option => option.value);
                };
                const getStudentValues = () => {
                    student = Array.from(document.querySelector('[list-action="student"]')
                            .selectedOptions)
                        .map(option => option.value);
                };
                const getHomeRoomValues = () => {
                    homeRoom = Array.from(document.querySelector('[list-action="home-room"]')
                            .selectedOptions)
                        .map(option => option.value);
                };
                const getStatusStudentValues = () => {
                    statusStudent = Array.from(document.querySelector('[list-action="status-student"]')
                            .selectedOptions)
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
                            getSubjectNameValues();
                            getStudentValues();
                            getClassRoomValues();

                            getHomeRoomValues();
                            getStatusStudentValues();
                            getBranchNameValues();
                            getLocationNameValues();
                            getSuitableClassValues();


                            getLevelValues();



                            StaffsList.getList().setStatusStudent(statusStudent);
                            StaffsList.getList().setHomeRoom(homeRoom);
                            StaffsList.getList().setSubjectName(subjectName);

                            StaffsList.getList().setStudent(student);
                            StaffsList.getList().setClassRoom(classRoom);
                            StaffsList.getList().setBranchName(branchName);
                            StaffsList.getList().setLocationName(locationName);
                            StaffsList.getList().setSuitableClass(suitableClass);


                            StaffsList.getList().setLevel(level);





                            StaffsList.getList().load();
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

                            StaffsList.getList().setCreatedAtFrom(fromDate);
                            StaffsList.getList().setCreatedAtTo(toDate);
                            StaffsList.getList().load();
                        });

                        $('[list-action="updated_at-select"]').on('change', function() {
                            var fromDate = $('[name="updated_at_from"]').val();
                            var toDate = $('[name="updated_at_to"]').val();

                            StaffsList.getList().setUpdatedAtFrom(fromDate);
                            StaffsList.getList().setUpdatedAtTo(toDate);
                            StaffsList.getList().load();
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
                    this.subjectName;
                    this.orderType;
                    this.type = options.type;
                    this.status = options.status;
                    this.toolbar = options.toolbar;
                    this.student;
                    this.classRoom;
                    this.branchName;
                    this.locationName;
                    this.suitableClass;
                    this.level;
                    this.homeRoom;
                    this.statusStudent;
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
                getStatus() {
                    return this.status;
                }

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

                getUpdateButtons() {
                    return this.listContent.querySelectorAll('[row-action="update"]');
                };

                getDeleteBtns() {
                    return this.listContent.querySelectorAll('[row-action="delete"]');
                };

                getShowConstractBtns() {
                    return this.listContent.querySelectorAll('[row-action="show"]');
                };

                setOrderType(orderType) {
                    this.orderType = orderType;
                };

                setLevel(level) {
                    this.level = level;
                };
                setClassType(classType) {
                    this.classType = classType;
                };

                setNumOfStudent(numOfStudent) {
                    this.numOfStudent = numOfStudents;
                };
                setStudyType(studyType) {
                    this.studyType = studyType;
                };
                setBranch(branch) {
                    this.branch = branch;
                };
                setStudent(student) {
                    this.student = student;
                };
                setClassRoom(classRoom) {
                    this.classRoom = classRoom;
                };
                setBranchName(branchName) {
                    this.branchName = branchName;
                };
                setLocationName(locationName) {
                    this.locationName = locationName;
                };
                setSuitableClass(suitableClass) {
                    this.suitableClass = suitableClass;
                };


                setHomeRoom(homeRoom) {
                    this.homeRoom = homeRoom;
                };
                getHomeRoom() {
                    return this.homeRoom;
                };
                setStatusStudent(statusStudent) {
                    this.statusStudent = statusStudent;
                };
                getStatusStudent() {
                    return this.statusStudent;
                };


                getClassRoom() {
                    return this.classRoom;
                };
                getBranchName() {
                    return this.branchName;
                };
                getLocationName() {
                    return this.locationName;
                };
                getSuitableClass() {
                    return this.suitableClass;
                };


                getStudent() {
                    return this.student;
                };

                getLevel() {
                    return this.level;
                };
                getClassType() {
                    return this.classType;
                };

                getNumOfStudent() {
                    return this.numOfStudent;
                };
                getStudyType() {
                    return this.studyType;
                };
                getBranch() {
                    return this.branch;
                };
                getStatus() {
                    return this.status;
                };

                getOrderType() {
                    return this.orderType;
                };

                setSubjectName(subjectName) {
                    this.subjectName = subjectName;
                };

                getSubjectName() {
                    return this.subjectName;
                };

                setCreatedAtFrom(createdAtFrom) {
                    this.created_at_from = createdAtFrom;
                }

                getCreatedAtFrom() {
                    return this.created_at_from;
                };

                setCreatedAtTo(createdAtTo) {
                    this.created_at_to = createdAtTo;
                }

                getCreatedAtTo() {
                    return this.created_at_to;
                };

                setUpdatedAtFrom(updatedAtFrom) {
                    this.updated_at_from = updatedAtFrom;
                }

                getUpdatedAtFrom() {
                    return this.updated_at_from;
                };

                setUpdatedAtTo(updatedAtTo) {
                    this.updated_at_to = updatedAtTo;
                }

                getUpdatedAtTo() {
                    return this.updated_at_to;
                };

                getType() {
                    return this.type;
                }
                getAssignToClassBtn() {
                    return this.toolbar.querySelector('#assignToClassBtn');
                };





                events() {

                    /**
                     * SEARCH BY INPUT FORM
                     */
                    const _this = this;
                    $(_this.getAssignToClassBtn()).on('click', function(e) {
                        e.preventDefault();

                        const url = this.getAttribute('href');

                        assignToClassPopup.updateUrl(url);
                        assignToClassPopup.show();
                    });
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

                        /**
                         * PAGINATION PER PAGE
                         */
                        $('#perPage').change(() => {

                            const perPage = $('#perPage').val();
                            this.setPerpage(perPage);
                            this.setPage(1);
                            this.load();
                        });

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
                        this.getUpdateButtons().forEach(button => {
                            button.addEventListener('click', (e) => {
                                e.preventDefault();

                                var url = button.getAttribute('href');

                                UpdateContactPopup.load(url);
                            });
                        });

                        /**
                         * DELETE STAFF
                         */
                        this.getDeleteBtns().forEach(button => {
                            button.addEventListener('click', function(e) {
                                e.preventDefault();
                                const url = this.getAttribute('href')

                                ASTool.confirm({
                                    message: "Bạn có chắc muốn xóa nhân sự này không?",
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
                                                    StaffsList.getList()
                                                        .load();
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

                        this.getDeleteAllItemsBtn().addEventListener('click', function() {

                            const items = _this.getItemCheckedIds();

                            _this.hideTopActionBox();
                            _this.showSearchForm();

                            ASTool.confirm({
                                message: "Bạn có chắc muốn xóa các nhân sự này không?",
                                ok: function() {
                                    ASTool.addPageLoadingEffect();

                                    $.ajax({
                                        url: "{{ action('\App\Http\Controllers\Edu\StaffController@deleteAll') }}",
                                        method: "DELETE",
                                        data: {
                                            _token: "{{ csrf_token() }}",
                                            items: items
                                        }
                                    }).done(response => {
                                        ASTool.alert({
                                            message: response.message,
                                            ok: function() {
                                                StaffsList.getList().load();
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
                            key: this.getKeyword(),
                            page: this.page,
                            perpage: this.perpage,
                            sort_by: this.getSortBy(),
                            sort_direction: this.getSortDirection(),
                            columns: CustomerColumnManager.getColumns(),
                            created_at_from: this.getCreatedAtFrom(),
                            created_at_to: this.getCreatedAtTo(),
                            updated_at_from: this.getUpdatedAtFrom(),
                            updated_at_to: this.getUpdatedAtTo(),
                            type: this.getType(),
                            orderType: this.getOrderType(),
                            subjectName: this.getSubjectName(),

                            level: this.getLevel(),
                            classType: this.getClassType(),
                            homeRoom: this.getHomeRoom(),
                            statusStudent: this.getStatusStudent(),
                            numOfStudent: this.getNumOfStudent(),
                            studyType: this.getStudyType(),
                            branch: this.getBranch(),
                            status: this.getStatus(),
                            student: this.getStudent(),
                            classRoom: this.getClassRoom(),
                            branchName: this.getBranchName(),
                            locationName: this.getLocationName(),
                            suitableClass: this.getSuitableClass(),

                        }
                    }).done(content => {
                        this.loadContent(content);
                        this.initContentEvents();
                        this.removeLoadEffect();
                        CustomerColumnManager.applyToList();

                    }).fail(message => {
                        throw new Error("ERROR: LOAD CONTENT ORDER FAIL!");
                    })
                };
            }
        </script>
    @endsection
