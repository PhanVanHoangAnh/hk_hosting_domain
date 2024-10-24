@extends('layouts.main.app', [
    'menu' => 'abroad',
])

@section('sidebar')
    @include('abroad.modules.sidebar', [
        'menu' => 'abroad-application',
        'sidebar' => 'abroad',
    ])
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh sách hồ sơ du học</span>
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
                <li class="breadcrumb-item text-muted">Quản lý hồ sơ du học</li>
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
    <div id="CoursesIndexContainer" class="position-relative" id="kt_post">
        <div class="card ">
            <!--begin::Card header-->
            <div class="card-header border-0 px-4">
                <!--begin::Group actions-->
                <div list-action="top-action-box" class="d-flex justify-content-end align-items-center d-none">
                    <div class="justify-content-end">
                        <td class="text-end">
                            <a href="#" class="btn btn-outline btn-flex btn-center btn-active-light-default"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                <div> Thao tác</div>
                                <i class="ki-duotone ki-down fs-5 ms-1"></i>
                            </a>
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                data-kt-menu="true">
                                <!--begin::Menu item-->
                                <div class="menu-item px-3">
                                    <a row-action="delete-all"
                                        href="{{ action([App\Http\Controllers\Abroad\CourseController::class, 'deleteAll']) }}"
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
                            class="form-control w-250px ps-12" placeholder="Tìm hồ sơ..." />
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

                    <div class="row w-100">
                        <!--begin::Content-->
                        @if (Auth::user()->can('changeBranch', \App\Models\User::class) || Auth::user()->can('manager', \App\Models\User::class)) 
                            <div class="col-md-3 mb-5">
                                <!--begin::Label-->
                                <label class="form-label fw-semibold ">Nhân viên tư vấn du học chiến lược:</label>
                                <!--end::Label-->
                                    <select list-action="filter-nvtvdhcl-select" class="form-select filter-select" data-control="select2"
                                        data-close-on-select="false" data-placeholder="Chọn nhân viên" data-allow-clear="true"
                                        multiple="multiple" name="account1">
                                        {{-- <option value="all">Chọn tất cả</option> --}}
                                        @if (Auth::user()->can('changeBranch', \App\Models\User::class)) 
                                            @foreach(App\Models\User::byBranch(\App\Library\Branch::getCurrentBranch())->byModule(\App\Library\Module::ABROAD)->get() as $user)
                                                <option value="{{ $user->account->id }}" >{{ $user->account->name }} </option>
                                            @endforeach
                                        @endif
                                        @if (Auth::user()->can('manager', Auth::user()))
                                            @foreach(Auth::user()->account->accountGroup->members as $member)
                                                <option value="{{ $member->id }}" >{{ $member->name }} </option>
                                            @endforeach
                                        @endif
                                    </select>
                            </div>
                        
                        @endif
                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Nhân viên truyền thông và sự kiện:</label>
                            <!--end::Label-->

                            <select list-action="filter-nvttvsk-select" class="form-select filter-select" data-control="select2"
                                data-close-on-select="false" data-placeholder="Chọn nhân viên" data-allow-clear="true"
                                multiple="multiple" name="account2">
                                {{-- <option value="all">Chọn tất cả</option> --}}
                                @foreach(App\Models\User::byBranch(\App\Library\Branch::getCurrentBranch())->byModule(\App\Library\Module::EXTRACURRICULAR)->get() as $user)
                                    <option value="{{ $user->account->id }}">{{ $user->account->name }} </option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Nhân viên tư vấn</label>
                            <!--end::Label-->
                            <div>
                                <select list-action="salesperson-select" class="form-select" data-control="select2"
                                    data-placeholder="Chọn nhân viên tư vấn" multiple>
                                    <option value="none">Chưa bàn giao</option>
                                    @foreach (App\Models\Account::sales()->get() as $account)
                                        <option value="{{ $account->id }}">
                                            @if ($account)
                                                {{ $account->name }}
                                            @endif
                                        </option>
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Trạng thái:</label>
                            <!--end::Label-->
                            <select list-action="abroad_status" class="form-select filter-select" data-control="select2"
                                data-close-on-select="false" data-placeholder="Chọn trạng thái" data-allow-clear="true"
                                multiple="multiple">
                                
                                @foreach (\App\Models\AbroadApplication::getStatusAbroad() as $status)
                                    <option value="{{ $status['value'] }}">{{ $status['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                  
                        <div class="col-md-3 mb-5">
                            <label class="form-label">Ngày tạo hồ sơ (Từ - Đến)</label>
                            <div class="row" list-action="created_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="created_at_from"
                                                placeholder="=asas" type="date" class="form-control"
                                                placeholder="" />
                                            <span data-control="clear"
                                                class="material-symbols-rounded clear-button"
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
                                            <span data-control="clear"
                                                class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                               
                            
                       
                        <div class="col-md-3 mb-5">
                            <div class="row">
                                <div class="col-md-12">
                                    <label class="form-label">Ngày cập nhật hồ sơ (Từ - Đến)</label>
                                    <div class="row" list-action="updated_at-select">
                                        <div class="col-md-6">
                                            <div class="form-outline">
                                                <div data-control="date-with-clear-button"
                                                    class="d-flex align-items-center date-with-clear-button">
                                                    <input data-control="input" name="updated_at_from"
                                                        placeholder="=asas" type="date" class="form-control"
                                                        placeholder="" />
                                                    <span data-control="clear"
                                                        class="material-symbols-rounded clear-button"
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
                                                    <span data-control="clear"
                                                        class="material-symbols-rounded clear-button"
                                                        style="display:none;">close</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Khả năng chi trả:</label>
                            <!--end::Label-->
                            <div>
                                <select multiple id="financial_capabilities" name="financial_capabilities[]" data-control="select2-ajax" data-url="{{ action('App\Http\Controllers\Abroad\AbroadController@financialCapabilitySelect2') }}" class="form-control">
                                    
                                </select>
                            </div>
                        </div>
                            
                  
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->
                </div>
                <!--end::Toolbar-->
            </div>
        </div>
        <div id="AbroadProfileListContent">
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
                    <!--begin::Modal body-->
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <!--begin::Form-->
                        <form id="kt_contacts_export_form" class="form" action="#">
                            <!--begin::Input group-->
                            <div class="fv-row mb-10">
                                <!--begin::Label-->
                                <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select data-control="select2" data-placeholder="Select a format" data-hide-search="true"
                                    name="format" class="form-select">
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
                                        <input class="form-check-input" type="checkbox" value="1" checked="checked"
                                            name="payment_type" />
                                        <span class="form-check-label text-gray-600 fw-semibold">All</span>
                                    </label>
                                    <!--end::Radio button-->
                                    <!--begin::Radio button-->
                                    <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" value="2" checked="checked"
                                            name="payment_type" />
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
                                <button type="reset" id="kt_contacts_export_cancel"
                                    class="btn btn-light me-3">Discard</button>
                                <button type="submit" id="kt_contacts_export_submit" class="btn btn-primary">
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
    <!--end::Post-->

    <script>
        $(() => {
            OrdersFeatureIndex.init();
        });

        const OrdersFeatureIndex = function() {
            return {
                init: () => {
                    CustomerColumnManager.init();
                    abroadApplicationsList.init();
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
                            return abroadApplicationsList.getList();
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


        let abroadApplicationsList = function() {
            let list;

            return {
                init: () => {

                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\Abroad\AbroadController@list') }}",
                        container: document.querySelector("#CoursesIndexContainer"),
                        listContent: document.querySelector("#AbroadProfileListContent"),
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
            let abroadStatuses = [];
            let account1 = [];
            let account2 = [];
            let filterBtn = document.querySelector("#filter-orders-btn");
            let actionBox = document.querySelector('[list-action="filter-action-box"]');

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

            const getAbroadStatuses = () => {
                abroadStatuses = Array.from(document.querySelector('[list-action="abroad_status"]')
                        .selectedOptions)
                    .map(option => option.value);
            };
            const getAccount1 = () => {
                account1 = Array.from(document.querySelector('[list-action="filter-nvtvdhcl-select"]').selectedOptions)
                    .map(option => option.value);
                account1 = account1.filter(element => element !== null && element !== undefined && element !== "");
            };

            const getAccount2 = () => {
                account2 = Array.from(document.querySelector('[list-action="filter-nvttvsk-select"]').selectedOptions)
                    .map(option => option.value);
                account2 = account2.filter(element => element !== null && element !== undefined && element !== "");
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
                        getAbroadStatuses();
                        getAccount1();
                        getAccount2();

                        abroadApplicationsList.getList().setAbroadStatuses(abroadStatuses);
                        abroadApplicationsList.getList().setAccount1(account1);
                        abroadApplicationsList.getList().setAccount2(account2);
                        abroadApplicationsList.getList().load();
                    });

                    $('#max-students-filter-input').on('change', () => {
                        getMaxStudentsValue();
                        abroadApplicationsList.getList().setMaxStudents(maxStudents);
                        abroadApplicationsList.getList().load();
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

                    $('[list-action="created_at-select"]').on('change', function() {
                        var fromDate = $('[name="created_at_from"]').val();
                        var toDate = $('[name="created_at_to"]').val();

                        abroadApplicationsList.getList().setCreatedAtFrom(fromDate);
                        abroadApplicationsList.getList().setCreatedAtTo(toDate);
                        abroadApplicationsList.getList().load();
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();

                        abroadApplicationsList.getList().setUpdatedAtFrom(fromDate);
                        abroadApplicationsList.getList().setUpdatedAtTo(toDate);
                        abroadApplicationsList.getList().load();
                    });

                    $('[list-action="salesperson-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        abroadApplicationsList.getList().setSalespersonIds(selectedValues);

                        // load list
                        if (typeof abroadApplicationsList != 'undefined') abroadApplicationsList.getList().load();
                    });


                    $('[list-action="start_at-select"]').on('change', function() {
                        var fromDate = $('[name="started_time_from"]').val();
                        var toDate = $('[name="started_time_to"]').val();

                        abroadApplicationsList.getList().setStartAtFrom(fromDate);
                        abroadApplicationsList.getList().setStartAtTo(toDate);
                        abroadApplicationsList.getList().load();
                    });

                    $('[list-action="end_at-select"]').on('change', function() {
                        var fromDate = $('[name="end_time_from"]').val();
                        var toDate = $('[name="end_time_to"]').val();

                        abroadApplicationsList.getList().setEndAtFrom(fromDate);
                        abroadApplicationsList.getList().setEndAtTo(toDate);
                        abroadApplicationsList.getList().load();
                    });

                    $('[name="financial_capabilities[]"]').on('change', function() {
                        if (typeof abroadApplicationsList != 'undefined') {
                            abroadApplicationsList.getList().load();
                        }
                    });
                }
            };
        }();

        let DataList = class {
            constructor(options) {
                this.status = options.status;
                this.url = options.url;
                this.container = options.container;
                this.listContent = options.listContent;
                this.keyword;
                this.page;
                this.perpage;
                this.sort_by;
                this.sort_direction;
                this.abroadStatuses;
                this.account1;
                this.account2;

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

            setAbroadStatuses(abroadStatuses) {
                this.abroadStatuses = abroadStatuses;
            };

            getAbroadStatuses() {
                return this.abroadStatuses;
            };

            setAccount1(account1) {
                this.account1 = account1;
            };

            getAccount1() {
                return this.account1;
            };

            setAccount2(account2) {
                this.account2 = account2;
            };

            getAccount2() {
                return this.account2;
            };

            //Filter SalesPerson
            setSalespersonIds(ids) {
                this.salesperson_ids = ids;
            }
            getSalespersonIds() {
                return this.salesperson_ids;
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
                    'Đã chọn <strong>' + this.checkedCount() + '</strong> hồ sơ du học';
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

            getDeleteBtns() {
                return this.listContent.querySelectorAll('[row-action="delete"]');
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

            getStatus() {
                return this.status;
            }

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

                            window.location.href =
                                `sales/orders/create-constract\\${currentOrderId}\\update`;
                        })
                    });

                    /**
                     * DELETE ORDER
                     */
                    this.getDeleteBtns().forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const url = this.getAttribute('href')

                            ASTool.confirm({
                                message: "Bạn có chắc muốn xóa hồ sơ du học này không?",
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
                                                abroadApplicationsList.getList().load();
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
                            message: "Bạn có chắc muốn xóa các hồ sơ du học này không?",
                            ok: function() {
                                ASTool.addPageLoadingEffect();

                                $.ajax({
                                    url: "{{ action('\App\Http\Controllers\Abroad\AbroadController@deleteAll') }}",
                                    method: "DELETE",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        items: items
                                    }
                                }).done(response => {
                                    ASTool.alert({
                                        message: response.message,
                                        ok: function() {
                                            abroadApplicationsList.getList()
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
                        abroadStatuses: this.getAbroadStatuses(),
                        columns: CustomerColumnManager.getColumns(),
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),
                        status: this.getStatus(),
                        account1: this.getAccount1(),
                        account2: this.getAccount2(),
                        salesperson_ids: this.getSalespersonIds(),
                        financial_capabilities: $('[name="financial_capabilities[]"]').val()
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
