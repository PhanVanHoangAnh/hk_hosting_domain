@extends('hk.layouts.main.app', [
    'menu' => 'internal'
])

@section('sidebar')
    @include('hk.modules.sidebar', [
        'menu' => 'contacts',
        'sidebar' => 'contacts',
    ])
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh sách khách hàng</span>
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
                <li class="breadcrumb-item text-muted">khách hàng</li>
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
    <div id="ContactsIndexContainer" class="position-relative" id="kt_post">
        <!--begin::Card-->
        <div class="card">
            <!--begin::Card header-->
            <div class="card-header border-0 px-4">
                <!--begin::Group actions-->
                <div list-action="top-action-box" class="menu d-flex justify-content-end align-items-center d-none"
                    data-kt-menu="true">
                    <div class="menu-item py-2" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start">
                        <!--begin::Menu link-->
                        <button type="button" class="btn btn-outline btn-outline-default px-9 "
                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                            Thao tác
                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                        </button>
                        <div class="menu-sub menu-sub-dropdown p-3 w-200px">
                            <div class="menu-item">
                                <a row-action="delete-all" href="{{ action([App\Http\Controllers\Hk\ContactController::class, 'deleteAll']) }}"
                                    class="menu-link px-3" list-action="sort">Xóa</a>
                            </div>
                        </div>
                        <!--end::Menu link-->
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
                        <input list-action="keyword-input" type="text" data-kt-contact-table-filter="search"
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
            </div>
        </div>

        <div id="ContactsIndexListContent">
        </div>

        <div class="modal fade" id="kt_contacts_export_modal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered mw-650px">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="fw-bold">Export Contacts</h2>
                        <div id="kt_contacts_export_close" class="btn btn-icon btn-sm btn-active-icon-primary">
                            <i class="ki-duotone ki-cross fs-1">
                                <span class="path1"></span>
                                <span class="path2"></span>
                            </i>
                        </div>
                    </div>
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <form id="kt_contacts_export_form" class="form" action="#">
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                                <select data-control="select2" data-placeholder="Select a format" data-hide-search="true"
                                    name="format" class="form-select">
                                    <option value="excell">Excel</option>
                                    <option value="pdf">PDF</option>
                                    <option value="cvs">CVS</option>
                                    <option value="zip">ZIP</option>
                                </select>
                            </div>
                            <div class="fv-row mb-10">
                                <label class="fs-5 fw-semibold form-label mb-5">Select Date Range:</label>
                                <input class="form-control" placeholder="Pick a date"
                                    name="date" />
                            </div>
                            <div class="row fv-row mb-15">
                                <label class="fs-5 fw-semibold form-label mb-5">Payment Type:</label>
                                <div class="d-flex flex-column">
                                    <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" value="1" checked="checked"
                                            name="payment_type" />
                                        <span class="form-check-label text-gray-600 fw-semibold">All</span>
                                    </label>
                                    <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" value="2" checked="checked"
                                            name="payment_type" />
                                        <span class="form-check-label text-gray-600 fw-semibold">Visa</span>
                                    </label>
                                    <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" value="3"
                                            name="payment_type" />
                                        <span class="form-check-label text-gray-600 fw-semibold">Mastercard</span>
                                    </label>
                                    <label class="form-check form-check-custom form-check-sm form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="4"
                                            name="payment_type" />
                                        <span class="form-check-label text-gray-600 fw-semibold">American
                                            Express</span>
                                    </label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="reset" id="kt_contacts_export_cancel"
                                    class="btn btn-light me-3">Discard</button>
                                <button type="submit" id="kt_contacts_export_submit" class="btn btn-primary">
                                    <span class="indicator-label">Submit</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() { 
            ContactsIndex.init();
        });

        //
        var ContactsIndex = function() {
            return {
                init: function() {
                    //add note-logs
                    CreateNotePopup.init();

                    //Update node-log
                    UpdateNotelogPopup.init();

                    // ColumnsDisplayManager
                    ContactColumnManager.init();

                    // Update Contact
                    UpdateContactPopup.init();

                    // list
                    ContactsList.init();

                    //filter
                    FilterData.init();

                    //Bàn giao nhân viên
                    NodeLogsContactPopup.init();
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
                },
                getPopup: () => {
                    return updatePopup;
                }
            }
        }();

        var ContactColumnManager = function() {
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

        var NodeLogsContactPopup = function() {
            var popupNodeLogsContact;

            return {
                init: function(updateUrl) {
                    // create campaign popup
                    popupNodeLogsContact = new Popup({
                        url: updateUrl,

                    });
                },
                load: function(url) {
                    popupNodeLogsContact.url = url;
                    popupNodeLogsContact.load(); // Hiển thị cửa sổ chỉnh sử
                },

                getPopup: function() {
                    return popupNodeLogsContact;
                }
            };
        }();

        var UpdateContactPopup = function() {
            var popupUpdateContact;
            return {
                init: function(updateUrl) {
                    // Khởi tạo popup chỉnh sửa chiến dịch
                    popupUpdateContact = new Popup({
                        url: updateUrl, // Sử dụng URL được chuyền vào từ tham số
                    });
                },

                load: function(url) {
                    popupUpdateContact.url = url;
                    popupUpdateContact.load(); // Hiển thị cửa sổ chỉnh sửa
                },


                getPopup: function() {
                    return popupUpdateContact;
                },

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

                        // Gửi phạm vi ngày tạo đến ContactsList và tải lại danh sách
                        ContactsList.getList().setCreatedAtFrom(fromDate);
                        ContactsList.getList().setCreatedAtTo(toDate);
                        ContactsList.getList().load();
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến ContactsList và tải lại danh sách
                        ContactsList.getList().setUpdatedAtFrom(fromDate);
                        ContactsList.getList().setUpdatedAtTo(toDate);
                        ContactsList.getList().load();
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

        var ContactsList = function() {
            var list;
            var resetUrl;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\Hk\ContactController@list') }}",
                        container: document.querySelector('#ContactsIndexContainer'),
                        listContent: document.querySelector('#ContactsIndexListContent'),
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
                // throw exception make sure there is a url
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

                // status
                this.status;

                if (typeof(options.status) !== 'undefined') {
                    this.status = options.status;
                }

                this.events();
            }

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
            }

            setKeyword(keyword) {
                this.keyword = keyword;
            }

            getKeyword() {
                return this.keyword;
            }

            getColumnsCheckboxes() {
                return this.container.querySelectorAll('[list-action="column-checker"]');
            }

            events() {
                // keyword input event. search when keyup
                this.getkeywordInput().addEventListener('keyup', (e) => {
                    this.setKeyword(this.getkeywordInput().value);
                    // enter key
                    if (event.key === "Enter") {
                        this.setUrl(this.initUrl);
                        this.load();
                    }
                });

                // on focus out of keyword input
                this.getkeywordInput().addEventListener('keyup', (e) => {
                    if (this.timeoutEvent) {
                        clearTimeout(this.timeoutEvent);
                    }

                    if (e.key === "Enter") {
                        // this.load();
                        return;
                    }

                    this.timeoutEvent = setTimeout(() => {
                        this.setUrl(this.initUrl);
                        this.load();
                    }, 1500);
                });

                $(this.container).find('[list-action="search-action-box"] i').on('click', (e) => {
                    this.load();
                });

                this.getColumnsCheckboxes().forEach(checkbox => {
                    const checkboxes = this.getColumnsCheckboxes();

                    // event
                    checkbox.addEventListener('change', (e) => {
                        const checked = checkbox.checked;
                        const column = checkbox.value;

                        if (!checked) {
                            // Uncheck the "all" checkbox if any other checkbox is unchecked
                            // allCheckbox.checked = false;
                        }

                        if (checked) {
                            this.addColumn(column);
                        } else {
                            this.removeColumn(column);
                        }

                        // Load danh sách
                        this.load();
                    });
                });

                //Khi mà click vào nút lọc
                this.getFilterButton().addEventListener('click', (e) => {
                    if (!this.isFilterActionBoxShowed()) {
                        this.showFilterActionBox();
                    } else {
                        this.hideFilterActionBox();
                    }
                });
            }

            addColumn(column) {
                this.columns.push(column);
            }

            removeColumn(column) {
                this.columns = this.columns.filter(e => e !== column);
            }

            addLoadEffect() {
                this.listContent.classList.add('list-loading');

                // loader
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

            setUrl(url) {
                this.url = url;
            }

            getSortBy() {
                return this.sort_by;
            };

            getSortDirection() {
                return this.sort_direction;
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

            removeLoadEffect() {
                this.listContent.classList.remove('list-loading');

                // remove loader
                if (this.container.querySelector('[list-action="loader"]')) {
                    this.container.querySelector('[list-action="loader"]').remove();
                }
            }

            getkeywordInput() {
                return this.container.querySelector('[list-action="keyword-input"]');
            }

            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
            }

            getFilterButton() {
                return document.getElementById('filterButton');
            }

            getCheckAllButton() {
                if (!this.listContent.querySelector('[list-action="check-all"]')) {
                    throw new Error('Bug: Check all button not found!');
                }

                return this.listContent.querySelector('[list-action="check-all"]');
            }

            getListCheckboxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]');
            }

            getListCheckedBoxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked');
            }

            checkedCount() {
                return this.getListCheckedBoxes().length;
            }

            getSelectedIds() {
                const ids = [];

                this.getListCheckedBoxes().forEach((checkbox) => {
                    ids.push(checkbox.value);
                });

                return ids;
            }

            getTopListActionBox() {
                return this.container.querySelector('[list-action="top-action-box"]');
            }

            getFilterActionBox() {
                return this.container.querySelector('[list-action="filter-action-box"]');
            }

            getFilterIcon() {
                return document.getElementById('filterIcon');
            }

            getSearchBoxes() {
                return this.container.querySelector('[list-action="search-action-box"]');
            }

            getToolBoxes() {
                return this.container.querySelector('[list-action="tool-action-box"]');
            }

            getDeleteButtons() {
                return this.listContent.querySelectorAll('[row-action="delete"]');
            }

            getUpdateButtons() {
                return this.listContent.querySelectorAll('[row-action="update"]');
            }

            getNoteLogsContactButtons() {
                return this.listContent.querySelectorAll('[row-action="note-logs-contact"]');

            }

            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            }
            
            initContentEvents() {
                const _this = this;

                // 
                SortManager.init(this);

                /**
                 * DELETE CONTACTS
                 */
                this.getDeleteAllItemsBtn().addEventListener('click', function(e) {

                    e.preventDefault();
                    const url = this.getAttribute('href');
                    const items = _this.getItemCheckedIds();

                    _this.hideTopListActionBox();
                    _this.showSearchBoxes();

                    ASTool.confirm({
                        message: "Bạn có chắc muốn xóa các khách hàng này không?",
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
                            }).fail(function() {

                            }).always(function() {
                                ASTool.removePageLoadingEffect();
                            })
                        }
                    });
                });

                // when list content has items
                if (this.getListItemsCount()) {

                    // làm cho cái pagination ajax
                    this.getContentPageLinks().forEach(link => {
                        link.addEventListener('click', (e) => {
                            e.preventDefault();

                            // init
                            var url = link.getAttribute('href');

                            // load new url
                            this.setUrl(url);

                            // reload list
                            this.load();
                        });
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

                    // khi có bất cứ dòng nào được check trong list thì hiện cái top list action
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

                            // update count label
                            this.updateCountLabel();
                        });
                    });

                    // khi mà click vào cái nut check all ở table list header
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

                        // update count label
                        this.updateCountLabel();
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

                            // show popup
                            UpdateContactPopup.load(url);
                        });
                    });

                    // mở popup hiển thị ghi chú
                    this.getNoteLogsContactButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');
                            // show popup
                            NodeLogsContactPopup.load(url);
                        });
                    });

                    // change per page select box value
                    $(this.getPerPageSelectBox()).on('change', (e) => {
                        e.preventDefault();

                        var number = this.getPerPageSelectBox().value;

                        this.setPagePage(number);

                        // reload lại list về url bên đầu
                        this.setUrl(this.initUrl);
                        this.load();
                    });
                }
            }

            deleteItem(url) {
                // success alert
                ASTool.confirm({
                    message: 'Bạn có chắc chắn muốn xóa khách hàng này?',
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
                                    ContactsList.getList()
                                        .load();
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

            getTagSelectBox() {
                return this.container.querySelector('[list-control="tag-select"]');
            }

            getTagId() {
                const selectedOptions = Array.from(this.getTagSelectBox().selectedOptions);
                return selectedOptions.map(option => option.value);
            }

            showTopListActionBox() {
                this.getTopListActionBox().classList.remove('d-none');
            }

            showFilterActionBox() {
                this.getFilterActionBox().classList.remove('d-none');
                this.getFilterIcon().innerHTML = 'expand_less'
            }

            isFilterActionBoxShowed() {
                return !this.getFilterActionBox().classList.contains('d-none');
            }

            showSearchBoxes() {
                this.getSearchBoxes().classList.remove('d-none');
            }

            showToolBoxes() {
                this.getToolBoxes().classList.remove('d-none');
            }

            updateCountLabel() {
                this.container.querySelector('[list-control="count-label"]').innerHTML = 'Đã chọn <strong>' + this
                    .checkedCount() + '</strong> khách hàng';
            }

            hideTopListActionBox() {
                this.getTopListActionBox().classList.add('d-none');
            }

            hideFilterActionBox() {
                this.getFilterActionBox().classList.add('d-none');
                this.getFilterIcon().innerHTML = 'expand_more'
            }

            hideSearchBoxes() {
                this.getSearchBoxes().classList.add('d-none');
            }

            hideToolBoxes() {
                this.getToolBoxes().classList.add('d-none');
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

            loadContent(content) {
                $(this.listContent).html(content);

                // always hide list action box and show 
                this.hideTopListActionBox();
                this.showSearchBoxes();
                this.showToolBoxes();

                // init content
                initJs(this.listContent);
            }

            getStatus() {
                return this.status;
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
                        per_page: this.getPerPage(),
                        sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),
                        status: this.getStatus(),
                        columns: ContactColumnManager.getColumns(),
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),
                    }
                }).done((content) => {
                    this.loadContent(content);
                    this.initContentEvents();
                    this.removeLoadEffect();

                    ContactColumnManager.applyToList();
                }).fail(function() {

                });
            }

            setPagePage(number) {
                this.per_page = number;
            }

            getPerPage() {
                return this.per_page;
            }

            getPerPageSelectBox() {
                return this.listContent.querySelector('[list-control="per-page"]');
            }
        }
    </script>
@endsection
