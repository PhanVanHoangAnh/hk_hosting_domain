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
    <div id="studentsManager">
        <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
            <!--begin::Page title-->
            <div class="page-title d-flex flex-column py-1">
                <!--begin::Title-->
                <h1 class="d-flex align-items-center my-1">
                    <span class="text-dark fw-bold fs-1">Danh sách học viên</span>
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
                    <li class="breadcrumb-item text-muted">Học viên</li>
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
            <div class="d-flex align-items-center py-1 d-none">
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
        </div>
        <!--end::Toolbar-->
        <!--begin::Post-->
        <div id="StudentsIndexContainer" class="position-relative" id="kt_post">
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
                                        href="javascript:;"
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
                                    <button list-action="export-excel" type="button" class="btn btn-outline btn-outline-default me-2">
                                        <span class="d-flex align-items-center">
                                            <span class="material-symbols-rounded me-2">
                                                export_notes
                                            </span>
                                            <span class="indicator-label">Xuất dữ liệu</span>
                                            <span class="indicator-progress">Đang xử lý...
                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                        </span>
                                    </button>
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

                            <div class="col-md-3 mb-5 d-none">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Giảng viên</label>
                                <!--end::Label-->
                                <select list-action="home-room" class="form-select filter-select" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn dịch vụ" data-allow-clear="true"
                                    multiple="multiple">
                                    @php
                                        $types = App\Models\OrderItem::edu()
                                            ->pluck('home_room')
                                            ->unique();
                                    @endphp
                                    @foreach ($types as $type)
                                    <option value="{{ $type }}">{{ App\Models\Teacher::find($type) ? App\Models\Teacher::find($type)->name : '' }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3 mb-5">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Lớp học:</label>
                                <!--end::Label-->

                                <select list-action="class-room" class="form-select filter-select" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn lớp học" data-allow-clear="true"
                                    multiple="multiple">
                                    @php
                                        $types = App\Models\Course::course()
                                            ->pluck('code')
                                            ->unique();
                                    @endphp
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}"> {{ $type }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="col-md-3 mb-5">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Học viên:</label>
                                <!--end::Label-->
                                <select list-action="student" class="form-select filter-select" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn dịch vụ" data-allow-clear="true"
                                    multiple="multiple">
                                    @php
                                        $types = App\Models\Contact::students()
                                            ->pluck('name')
                                            ->unique();
                                    @endphp
                                    @foreach ($types as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 mb-5">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Chi nhánh:</label>
                                <!--end::Label-->
                                <select list-action="branch" class="form-select filter-select" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn lớp học" data-allow-clear="true"
                                    multiple="multiple">
                                        @foreach (\App\Models\TrainingLocation::getBranchs() as $branch)
                                            <option value="{{ $branch }}"> {{ trans('messages.training_locations.' . $branch) }}</option>
                                        @endforeach
                                </select>
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
            <!--begin::Modal - Adjust Balance-->
            <div class="modal fade" id="kt_customers_export_modal" tabindex="-1" aria-hidden="true">
                <!--begin::Modal dialog-->
                <div class="modal-dialog modal-dialog-centered mw-650px">
                    <!--begin::Modal content-->
                    <div class="modal-content">
                        <!--begin::Modal header-->
                        <div class="modal-header">
                            <!--begin::Modal title-->
                            <h2 class="fw-bold">Export Students</h2>
                            <!--end::Modal title-->
                            <!--begin::Close-->
                            <div id="kt_customers_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                                <i class="ki-duotone ki-cross fs-1">
                                    <span class="path1"></span>
                                    <span class="path2"></span>
                                </i>
                            </div>
                            <!--end::Close-->
                        </div>
                        <!--end::Modal header-->
                        <!--begin::Modal body-->
                        <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                            <!--begin::Form-->
                            <form id="kt_customers_export_form" class="form" action="#">
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select data-control="select2" data-placeholder="Select a format"
                                        data-hide-search="true" name="format" class="form-select">
                                        <option value="excell">Excel</option>
                                        <option value="pdf">PDF</option>
                                        <option value="cvs">CVS</option>
                                        <option value="zip">ZIP</option>
                                    </select>
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Input group-->
                                <div class="fv-row mb-10">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-semibold form-label mb-5">Select Date Range:</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input class="form-control" placeholder="Pick a date" name="date" />
                                    <!--end::Input-->
                                </div>
                                <!--end::Input group-->
                                <!--begin::Row-->
                                <div class="row fv-row mb-15">
                                    <!--begin::Label-->
                                    <label class="fs-5 fw-semibold form-label mb-5">Payment Type:</label>
                                    <!--end::Label-->
                                    <!--begin::Radio group-->
                                    <div class="d-flex flex-column">
                                        <!--begin::Radio button-->
                                        <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" value="1"
                                                checked="checked" name="payment_type" />
                                            <span class="form-check-label text-gray-600 fw-semibold">All</span>
                                        </label>
                                        <!--end::Radio button-->
                                        <!--begin::Radio button-->
                                        <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" value="2"
                                                checked="checked" name="payment_type" />
                                            <span class="form-check-label text-gray-600 fw-semibold">Visa</span>
                                        </label>
                                        <!--end::Radio button-->
                                        <!--begin::Radio button-->
                                        <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                            <input class="form-check-input" type="checkbox" value="3"
                                                name="payment_type" />
                                            <span class="form-check-label text-gray-600 fw-semibold">Mastercard</span>
                                        </label>
                                        <!--end::Radio button-->
                                        <!--begin::Radio button-->
                                        <label class="form-check form-check-custom form-check-sm form-check-solid">
                                            <input class="form-check-input" type="checkbox" value="4"
                                                name="payment_type" />
                                            <span class="form-check-label text-gray-600 fw-semibold">American
                                                Express</span>
                                        </label>
                                        <!--end::Radio button-->
                                    </div>
                                    <!--end::Input group-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Actions-->
                                <div class="text-center">
                                    <button type="reset" id="kt_customers_export_cancel"
                                        class="btn btn-light me-3">Discard</button>
                                    <button type="submit" id="kt_customers_export_submit" class="btn btn-primary">
                                        <span class="indicator-label">Submit</span>
                                        <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    </button>
                                </div>
                                <!--end::Actions-->
                            </form>
                            <!--end::Form-->
                        </div>
                        <!--end::Modal body-->
                    </div>
                    <!--end::Modal content-->
                </div>
                <!--end::Modal dialog-->
            </div>
            <!--end::Modal - New Card-->
            <!--end::Modals-->
        </div>
    </div>
    <!--end::Post-->
    <script>
        var studentsManager;
        var assignToClassPopup;

        $(function() {
            StudentsIndex.init();
            studentsManager = new StudentsManager({
                container: document.querySelector('#studentsManager')
            });

            assignToClassPopup = new AssignToClassPopup({
                studentsManager: studentsManager
            });
        });

        var StudentsIndex = function() {
            return {
                init: function() {
                    StudentColumnManager.init();
                    CreateNotePopup.init();
                    UpdateNotelogPopup.init();
                    UpdateContactPopup.init();
                    ContactsList.init();
                    FilterData.init();
                    NodeLogsStudentPopup.init();
                }
            };
        }();

        var CreateNotePopup = function() {
            var createPopup;

            return {
                init: () => {
                    createPopup = new Popup();
                },
                updateUrl: newUrl => {
                    createPopup.url = newUrl;
                    createPopup.load();
                },
                getCreatePopup: () => {
                    return createPopup;
                }
            }
        }();

        var UpdateNotelogPopup = function() {
            var updatePopup;

            return {
                init: () => {
                    updatePopup = new Popup();
                },
                updateUrl: newUrl => {
                    updatePopup.url = newUrl;
                    updatePopup.load();
                },
                getUpdatePopup: () => {
                    return updatePopup;
                }
            }
        }();

        var StudentColumnManager = function() {
            var manager;

            return {
                init: function() {
                    manager = new ColumnsDisplayManagerClass({
                        name: '{{ $listViewName }}',
                        saveUrl: '{{ action([App\Http\Controllers\UserController::class, 'saveListColumns']) }}',
                        columns: {!! json_encode($columns) !!},
                        optionsBox: document.querySelector('[columns-control="options-box"]'),
                        getList: function() {
                            return ContactsList.getList();
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

        var FilterData = (function() {
            let subjectName = [];
            let homeRoom = [];
            let classRoom = [];
            let student = [];
            let branchs = [];
            let filterBtn = document.querySelector("#filterButton");
            let actionBox = document.querySelector('[list-action="filter-action-box"]');

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

            const getBranchsValue = () => {
                branchs = Array.from(document.querySelector('[list-action="branch"]').selectedOptions)
                               .map(option => option.value);
            };

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

            const checkIsActionBoxShowing = () => {
                return !actionBox.classList.contains('d-none');
            };

            const hideActionBox = () => {
                actionBox.classList.add('d-none');
            };

            const changeFilterIconToExpandMore = () => {
                getFilterIcon().innerHTML = "expand_more";
            };

            const showActionBox = () => {
                actionBox.classList.remove('d-none');
            };

            const changeFilterIconToExpandLess = () => {
                getFilterIcon().innerHTML = "expand_less";
            };

            const getFilterIcon = () => {
                return document.querySelector("#filterIcon");
            };

            return {
                init: () => {
                    $('.filter-select').on('change', () => {
                        getSubjectNameValues();
                        getClassRoomValues();
                        getStudentValues();
                        getHomeRoomValues();
                        getBranchsValue();
                        ContactsList.getList().setSubjectName(subjectName);
                        ContactsList.getList().setClassRoom(classRoom);
                        ContactsList.getList().setStudent(student);
                        ContactsList.getList().setHomeRoom(homeRoom);
                        ContactsList.getList().setBranchs(branchs);
                        ContactsList.getList().load();
                    });

                    $('[list-action="created_at-select"]').on('change', function() {
                        var fromDate = $('[name="created_at_from"]').val();
                        var toDate = $('[name="created_at_to"]').val();

                        ContactsList.getList().setCreatedAtFrom(fromDate);
                        ContactsList.getList().setCreatedAtTo(toDate);
                        ContactsList.getList().load();
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();

                        ContactsList.getList().setUpdatedAtFrom(fromDate);
                        ContactsList.getList().setUpdatedAtTo(toDate);
                        ContactsList.getList().load();
                    });

                    $('[list-action="export-excel"]').on('click', function() {
                        getSubjectNameValues();
                        getClassRoomValues();
                        getStudentValues();
                        getHomeRoomValues();
                        getBranchsValue();
                        
                        const query = {
                            subjectName: subjectName,
                            homeRoom: homeRoom,
                            classRoom: classRoom,
                            student: student,
                            branchs: branchs
                        };

                        $.ajax({
                            url: "{{ action('\App\Http\Controllers\Edu\StudentController@export') }}",
                                type: "GET",
                                data: query,
                                xhrFields: {
                                    responseType: 'blob' 
                                },
                                beforeSend: function() {
                                    // Show loading indicator
                                    $('.indicator-label').hide();
                                    $('.indicator-progress').show();

                                    //
                                    addMaskLoading('Đang xuất dữ liệu ra Excel file. Vui lòng chờ...');
                                },
                                success: function(response) {
                                    const url = window.URL.createObjectURL(new Blob([response]));
                                    const link = document.createElement('a');
                                    link.href = url;
                                    link.setAttribute('download', 'students.xlsx');
                                    document.body.appendChild(link);
                                    link.click();
                                    window.URL.revokeObjectURL(url);
                                    // Hide loading 
                                    $('.indicator-label').show();
                                    $('.indicator-progress').hide();

                                    //
                                    removeMaskLoading();
                                },
                                error: function() {
                                    console.error("error occurred while exporting the data!");
                                    throw new Error(error);
                                }
                            });
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

        var ContactsList = function() {
            var list;
            var resetUrl;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\Edu\StudentController@list') }}",
                        container: document.querySelector('#StudentsIndexContainer'),
                        listContent: document.querySelector(
                            '#studentsIndexListContent'),

                        @if ($status)
                            status: '{{ $status }}',
                        @endif

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
                this.subjectName;
                this.classRoom;
                this.student;
                this.homeRoom;
                this.branchs;

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

                    if (event.key === "Enter") {
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
            setSubjectName(subjectName) {
                this.subjectName = subjectName;
            };
            getSubjectName() {
                return this.subjectName;
            };
            setClassRoom(classRoom) {
                this.classRoom = classRoom;
            };
            getClassRoom() {
                return this.classRoom;
            };
            setStudent(student) {
                this.student = student;
            };
            getStudent() {
                return this.student;
            };

            setHomeRoom(homeRoom) {
                this.homeRoom = homeRoom;
            };

            getHomeRoom() {
                return this.homeRoom;
            };

            setBranchs(branchs) {
                this.branchs = branchs;
            };

            getBranchs() {
                return this.branchs;
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
            getStudyPartnerButtons() {
                return this.listContent.querySelectorAll('[row-action="study-partner"]');
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
                                            ContactsList.getList().load();
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


                    this.getStudyPartnerButtons().forEach(button => {
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
                                    ContactsList.getList().load();
                                }
                            });
                        }).fail(function() {}).always(function() {
                            ASTool.removePageLoadingEffect();
                        });
                    }
                });
            };

            getTagSelectBox() {
                return this.container.querySelector('[list-control="tag-select"]');
            };


            getTagId() {
                const selectedOptions = Array.from(this.getTagSelectBox().selectedOptions);
                return selectedOptions.map(option => option.value);
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
                        tag_id: this.getTagId(),
                        sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),
                        source_type: this.getMarketingType(),
                        status: this.getStatus(),
                        columns: this.getColumns(),
                        columns: StudentColumnManager.getColumns(),
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),
                        subjectName: this.getSubjectName(),
                        classRoom: this.getClassRoom(),
                        student: this.getStudent(),
                        homeRoom: this.getHomeRoom(),
                        branchs: this.getBranchs(),
                    }
                }).done((content) => {
                    this.loadContent(content);
                    this.initContentEvents();
                    this.removeLoadEffect();
                    StudentColumnManager.applyToList();
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
        };

        var StudentsManager = class {
            constructor(options) {
                this.container = options.container;

                this.events();
            };

            getAssignToClassBtn() {
                return this.container.querySelector('#assignToClassBtn');
            };

            events() {
                const _this = this;

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
                // this.studentsManager = options.studentsManager;
                this.pp = 'pp';

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
    </script>
@endsection
