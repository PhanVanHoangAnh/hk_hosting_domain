@extends('layouts.main.app', [
    'menu' => 'accounting',
])

@section('sidebar')
    @include('accounting.modules.sidebar', [
        'menu' => 'payment_reminder',
        'sidebar' => 'payment_reminder',
    ])
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh sách khoản cần thu</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="#" class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Kế toán</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Danh sách khoản cần thu </li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">


        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div id="PaymentRemindersIndexContainer" class="post" id="kt_post">
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
                                    id="buttonsDeleteAccounts">

                                    <span class="menu-title" id="buttonDeleteAccounts">Xóa tài khoản đã chọn</span>
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
                            class="form-control w-450px ps-12" placeholder="Nhập để tìm khoản thu" />
                    </div>
                    <!--end::Search-->
                </div>





                <!--begin::Card title-->
                <!--begin::Card toolbar-->
                <div class="card-toolbar" list-action="tool-action-box">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end">

                        <div class="d-flex  me-6">

                            <div class="row" list-action="due_date-select">
                                <div class="col-md-6 p-0">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="due_date_from" placeholder="=asas"
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
                                            <input data-control="input" name="due_date_to" placeholder="=asas"
                                                type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                <div class="card-toolbar w-100 mb-0" list-action="tool-action-box">
                    <!--begin::Toolbar-->

                    <div class="row w-100">
                        <!--begin::Content-->

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Loại dịch vụ</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="industry-select" class="form-select filter-select"
                                    data-control="select2" data-kt-customer-table-filter="month"
                                    data-placeholder="Chọn loại dịch vụ" data-allow-clear="true" multiple="multiple">
                                    @foreach (config('industries') as $industry)
                                        <option value="{{ $industry }}">{{ $industry }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Phân loại</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="type-select" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false" data-placeholder="Phân loại"
                                    data-allow-clear="true" multiple="multiple">
                                    @foreach (config('orderTypes') as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Sale</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="sale-select" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false" data-placeholder="Chọn sale"
                                    data-allow-clear="true" multiple="multiple">
                                    @foreach (App\Models\Account::sales()->get() as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Sale sup</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="sale-sup-select" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false" data-placeholder="Chọn sale sup"
                                    data-allow-clear="true" multiple="multiple">
                                    @foreach (App\Models\Account::sales()->get() as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Actions-->

                        <div class="col-md-3 mb-5">
                            <label class="form-label">Khách hàng</label>
                            <div class="row" list-action="created_at-select">
                                <div class="form-outline">
                                    <select id="order-filter-contact-select" data-control="select2-ajax"
                                        data-url="{{ action('App\Http\Controllers\Sales\ContactController@select2') }}"
                                        class="form-control filter-select" name="contact"
                                        data-dropdown-parent="#PaymentRemindersIndexContainer" data-control="select2"
                                        data-placeholder="Chọn khách hàng/liên hệ..." data-allow-clear="true"
                                        data-html="true">
                                        <option value="">Chọn khách hàng/liên hệ</option>
                                        @if (isset($contact))
                                            <option value="{{ $contact->id }}" selected>
                                                {{ '<strong>' . $contact->name . '</strong><br>' . $contact->email . '</strong><br>' . $contact->phone }}
                                            </option>
                                        @endif
                                    </select>

                                    <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <label class="form-label">Học viên</label>
                            <div class="row" list-action="created_at-select">
                                <div class="form-outline">
                                    <select id="order-filter-student-select" data-control="select2-ajax"
                                        data-url="{{ action('App\Http\Controllers\Sales\ContactController@select2') }}"
                                        class="form-control filter-select" name="student_id"
                                        data-dropdown-parent="#PaymentRemindersIndexContainer" data-control="select2"
                                        data-placeholder="Chọn khách hàng/liên hệ..." data-allow-clear="true"
                                        data-html="true">
                                        <option value="">Chọn học viên</option>
                                        @if (isset($contact))
                                            <option value="{{ $contact->id }}" selected>
                                                {{ '<strong>' . $contact->name . '</strong><br>' . $contact->email . '</strong><br>' . $contact->phone }}
                                            </option>
                                        @endif
                                    </select>

                                    <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Loại hợp đồng</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="order-type-filter-select" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false"
                                    data-placeholder="Chọn loại hợp đồng" data-allow-clear="true" multiple="multiple">
                                    @foreach (App\Models\Order::getAllTypeVariable() as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Đợt thanh toán</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="progresses-filter-select" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false"
                                    data-placeholder="Chọn đợt thanh toán" data-allow-clear="true" multiple="multiple">
                                    @foreach (App\Models\PaymentReminder::getAllProgressesOptions() as $type)
                                        <option value="{{ $type }}">{{ $type }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5 d-none">
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
                <!--end::Content-->
            </div>
            <!--end::Menu 1-->
            <!--end::Filter-->
        </div>

        <div id="PaymentRemindersIndexListContent">

        </div>
    </div>


    <script>
        $(function() { // document ready
            //
            PaymentAccountsIndex.init();
        });

        //
        var PaymentAccountsIndex = function() {
            return {
                init: function() {
                    // ColumnsDisplayManager
                    CustomerColumnManager.init();

                    ShowPopup.init();

                    // list
                    PaymentRemindersList.init();

                    FilterData.init();


                }
            };
        }();

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
                            return PaymentRemindersList.getList();
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
        let ShowPopup = function() {
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
        var PaymentRemindersList = function() {
            var list;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\Accounting\PaymentReminderController@list') }}",
                        container: document.querySelector('#PaymentRemindersIndexContainer'),
                        listContent: document.querySelector('#PaymentRemindersIndexListContent'),
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
                    $('#order-filter-contact-select').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);
                        PaymentRemindersList.getList().setContact(selectedValues);

                        // load list
                        PaymentRemindersList.getList().load();
                    });
                    $('#order-filter-student-select').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        PaymentRemindersList.getList().setStudentId(selectedValues);

                        // load list
                        PaymentRemindersList.getList().load();
                    });
                    $('[list-action="industry-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        PaymentRemindersList.getList().setIndustries(selectedValues);

                        // load list
                        PaymentRemindersList.getList().load();
                    });
                    $('[list-action="order-type-filter-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        PaymentRemindersList.getList().setOrderTypes(selectedValues);

                        // load list
                        PaymentRemindersList.getList().load();
                    });
                    $('[list-action="progresses-filter-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        PaymentRemindersList.getList().setProgressesTypes(selectedValues);

                        // load list
                        PaymentRemindersList.getList().load();
                    });

                    $('[list-action="type-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        PaymentRemindersList.getList().setTypes(selectedValues);

                        // load list
                        PaymentRemindersList.getList().load();
                    });
                    $('[list-action="sale-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        PaymentRemindersList.getList().setSales(selectedValues);

                        // load list
                        PaymentRemindersList.getList().load();
                    });
                    $('[list-action="sale-sup-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        PaymentRemindersList.getList().setSaleSups(selectedValues);

                        // load list
                        PaymentRemindersList.getList().load();
                    });
                    $('[list-action="created_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="created_at_from"]').val();
                        var toDate = $('[name="created_at_to"]').val();


                        PaymentRemindersList.getList().setCreatedAtFrom(fromDate);
                        PaymentRemindersList.getList().setCreatedAtTo(toDate);
                        PaymentRemindersList.getList().load();
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();


                        PaymentRemindersList.getList().setUpdatedAtFrom(fromDate);
                        PaymentRemindersList.getList().setUpdatedAtTo(toDate);
                        PaymentRemindersList.getList().load();
                    });

                    $('[list-action="due_date-select"] :input').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="due_date_from"]').val();
                        var toDate = $('[name="due_date_to"]').val();



                        PaymentRemindersList.getList().setDueDateFrom(fromDate);
                        PaymentRemindersList.getList().setDueDateTo(toDate);
                        PaymentRemindersList.getList().load();


                    });

                }
            };
        })();



        let DataList = class {

            constructor(options) {
                // throw exception make sure there is a url
                if (!options.url) {
                    throw new Error('Bug: list url not found!');
                }

                this.url = options.url;
                this.container = options.container;
                this.listContent = options.listContent;
                this.keyword;
                this.sort_by;
                this.sort_direction;


                this.perpage;
                this.page;
                this.accountIds = [];

                // status
                this.status;
                if (typeof(options.status) !== 'undefined') {
                    this.status = options.status;
                }

                //
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

            setUrl(newUrl) {
                this.url = newUrl;
            };

            setSortBy(sortBy) {
                this.sort_by = sortBy;
            };

            setSortDirection(sortDirection) {
                this.sort_direction = sortDirection;
            };

            setContact(contact) {

                this.contact = contact;
            };

            setStudentId(student_id) {
                this.student_id = student_id;
            };

            setIndustries(industries) {
                this.industries = industries;
            };

            setOrderTypes(orderTypes) {
                this.orderTypes = orderTypes;
            };
            setProgressesTypes(progressTypes) {
                this.progressTypes = progressTypes;
            };


            setTypes(types) {
                this.types = types;
            };

            setSales(sales) {
                this.sales = sales;
            };

            setSaleSups(saleSups) {
                this.saleSups = saleSups;
            };

            getIndustries() {
                return this.industries;
            };

            getOrderTypes() {
                return this.orderTypes;
            };

            getContact() {
                return this.contact;
            };

            getStudentId() {
                return this.student_id;
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

            getProgressTypes() {
                return this.progressTypes;
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

            getCheckedNoteBtns() {
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked');
            };

            getCheckedNoteBtnsNumber() {
                return this.getCheckedNoteBtns().length;
            };

            getNoteCheckedIds() {

                let checkedNoteBtnIds = [];

                this.getCheckedNoteBtns().forEach(note => {
                    checkedNoteBtnIds.push(Number(note.getAttribute('data-item-id')));
                });

                return checkedNoteBtnIds;
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
                    .checkedCount() + '</strong> hợp đồng';
            };

            checkedCount() {
                return this.getCheckedNoteBtns().length;
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

            getDeleteBtns() {
                return this.listContent.querySelectorAll('[row-action="delete"]');
            };

            getShowConstractBtns() {
                return this.listContent.querySelectorAll('[row-action="show"]');
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

            //due_date_from
            setDueDateFrom(dueDateFrom) {
                this.due_date_from = dueDateFrom;
            }
            getDueDateFrom() {

                return this.due_date_from;
            };
            //due_date_to
            setDueDateTo(dueDateTo) {
                this.due_date_to = dueDateTo;
            }
            getDueDateTo() {

                return this.due_date_to;
            };

            getStatus() {
                return this.status;
            }

            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            }
            getShowPopupBtns() {
                return this.listContent.querySelectorAll('[row-action="show"]');
            };

            getkeywordInput() {
                return this.container.querySelector('[list-action="keyword-input"]');
            }


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
            // lam cho sk click Filter
            getFilterActionBox() {
                return this.container.querySelector('[list-action="filter-action-box"]');
            }
            //
            getFilterIcon() {
                return document.getElementById('filterIcon');
            }
            //nut check all button
            getCheckAllButton() {
                if (!this.listContent.querySelector('[list-action="check-all"]')) {
                    throw new Error('Bug: Check all button not found!');
                }
                return this.listContent.querySelector('[list-action="check-all"]');
            }



            //pagination ajax
            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
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

            getFilterButton() {
                return document.getElementById('filterButton');
            }

            events() {

                /**
                 * SEARCH BY INPUT FORM
                 */
                this.getSearchKeywordInput().addEventListener("keyup", e => {

                    this.setKeyWord(this.getSearchKeywordInput().value);

                    if (event.keyword === 'Enter') {
                        this.load();
                    }
                });

                this.getSearchKeywordInput().addEventListener('keyup', e => {
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
                })
                this.getFilterButton().addEventListener('click', (e) => {

                    if (!this.isFilterActionBoxShowed()) {
                        this.showFilterActionBox();
                    } else {
                        this.hideFilterActionBox();
                    }
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

                SortManager.init(this);
                // when list content has items
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

                    // khi nhấn vào từng checkbox từng dòng thì làm gì?
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

                    /**
                     * SHOW POPUP 
                     */
                    this.getShowPopupBtns().forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const url = this.getAttribute('href')

                            ShowPopup.updateUrl(url);
                        });
                    });

                };
            };

            load() {
                this.addLoadEffect();


                if (this.listXhr) {
                    this.listXhr.abort();
                }
                this.listXhr = $.ajax({
                    url: this.url,
                    data: {
                        keyword: this.getKeyword(),
                        page: this.page,
                        perpage: this.perpage,
                        sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),
                        contact: this.getContact(),
                        student_id: this.getStudentId(),
                        industries: this.getIndustries(),
                        orderTypes: this.getOrderTypes(),
                        types: this.getTypes(),
                        sales: this.getSales(),
                        saleSups: this.getSaleSups(),
                        progressTypes: this.getProgressTypes(),

                        // columns manager
                        columns: CustomerColumnManager.getColumns(),

                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),

                        due_date_from: this.getDueDateFrom(),
                        due_date_to: this.getDueDateTo(),
                        status: this.getStatus(),
                    }
                }).done(content => {
                    this.loadContent(content);
                    this.initContentEvents();
                    this.removeLoadEffect();

                    // apply
                    CustomerColumnManager.applyToList();

                }).fail(function() {

                });
            };
        }
    </script>
@endsection
