@extends('layouts.main.app',[
    'menu' => 'sales'
])

@section('sidebar')
    @include('sales.modules.sidebar', [
        'menu' => 'refunds',
        'sidebar' => 'refunds',
    ])
@endsection


@section('content')
<div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
    <!--begin::Page title-->
    <div class="page-title d-flex flex-column py-1">
        <!--begin::Title-->
        <h1 class="d-flex align-items-center my-1">
            <span class="text-dark fw-bold fs-1">Yêu cầu hoàn phí</span>
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
            <li class="breadcrumb-item text-muted">Đào tạo</li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Yêu cầu hoàn phí</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
    <!--begin::Actions-->
    <div class="d-flex align-items-center py-1 ">
        <!--begin::Button-->
        <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" id="buttonCreateReceipt">
            <span class="material-symbols-rounded me-2">
                add
            </span>
            Tạo yêu cầu hoàn phí
        </a>
       
        <!--end::Button-->
    </div>
    <!--end::Actions-->
</div>
<!--end::Toolbar-->

<!--begin::Post-->
<div id="ReceiptIndexContainer" class="position-relative" id="kt_post">
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
                    <input list-action="keyword-input" type="text" data-kt-note-log-table-filter="search"
                        class="form-control w-250px ps-12" placeholder="Nhập để tìm yêu cầu" />
                </div>
                <!--end::Search-->
            </div>

            <!--begin::Card toolbar-->
            <div class="card-toolbar" list-action="tool-action-box">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <div class="justify-content-end me-3">
                        <td class="text-end">
                            <button type="button"  class="btn btn-outline btn-outline-default"
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
                    <button  type="button"  class="btn btn-outline btn-outline-default" id="filterButton">
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
        <!--begin::Card toolbar-->
        <div class=" border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
            <!--begin::Card toolbar-->
            <div class="card-toolbar mb-0" list-action="tool-action-box">
                <!--begin::Toolbar-->

                <div class="row">

                    <!--begin::Input-->
                    <div class="col-md-4 mb-5 d-none">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold ">Mã đơn hàng</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="order-select" class="form-select" data-control="select2" data-allow-clear="true"
                                data-placeholder="Chọn đơn hàng">
                                <option></option>
                                @php
                                    $orderIds = App\Models\PaymentRecord::pluck('order_id')->unique();
                                @endphp
                                @foreach ($orderIds as $orderId)
                                    @php
                                        $order = App\Models\Order::find($orderId);
                                    @endphp
                                    @if ($order)
                                        <option value="{{ $orderId }}">{{ $order->code }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    <!--end::Input-->
                    <!--begin::Content-->
                    <div class="col-md-4 mb-5 ">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold ">Khách hàng</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="contact-select" class="form-select" data-control="select2"
                                data-placeholder="Chọn khách hàng/liên hệ" data-allow-clear="true" multiple>
                                <option value="all">Chọn tất cả</option>
                                @php
                                    $contactIds = App\Models\RefundRequest::pluck('student_id')->unique();
                                @endphp
                                
                                @foreach ($contactIds as $contact)
                                    <option value="{{ $contact }}">{{ App\Models\Contact::find($contact)->name }}</option>
                                @endforeach
                            
                            </select>
                        </div>
                    </div>
                    <!--begin::Input-->
                    <div class="col-md-4 mb-5 d-none">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold ">Người tạo</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="account-select" class="form-select" data-control="select2"
                                data-allow-clear="true" data-placeholder="Chọn người tạo">
                                <option></option>
                                @foreach (App\Models\Account::all() as $account)
                                    <option value="{{ $account->id }}">{{ $account->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>
                    <!--end::Input-->
                    <div class="col-md-4 mb-5">
                        <label class="form-label">Ngày hoàn phí (Từ - Đến)</label>
                        <div class="row" list-action="refund_date-select">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="refund_date_from" placeholder="=asas"
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
                                        <input data-control="input" name="refund_date_to" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Actions-->
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

                    <div class="col-md-4 mb-5 d-none">
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



    <div id="ReceiptIndexListContent">
    </div>
</div>

<!--end::Post-->

<script>
    $(() => {
        RefundIndex.init();
    });

    var RefundIndex = function() {
        return {
            init: () => {

                // ColumnsDisplayManager
                ContactColumnManager.init();


                CreateReceiptPopup.init();


                UpdateRequestPopup.init();

                createReceiptHandle.init();



                RefundList.init();


                FilterData.init();


            }
        };
    }();

    var ContactColumnManager = function() {
        var manager;

        return {
            init: function() {
                manager = new ColumnsDisplayManagerClass({
                    columns: {!! json_encode($columns) !!},
                    optionsBox: document.querySelector('[columns-control="options-box"]'),
                    getList: function() {
                        return RefundList.getList();
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

    var CreateReceiptPopup = function() {
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

    var UpdateRequestPopup = function() {
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


    var RefundList = function() {

        let refundRequestList;

        return {
            init: () => {

                refundRequestList = new DataList({
                    url: "{{ action('App\Http\Controllers\Sales\RefundRequestController@list') }}",
                    container: document.querySelector("#ReceiptIndexContainer"),
                    listContent: document.querySelector("#ReceiptIndexListContent"),

                    @if ($status)
                            status: '{{ $status }}',
                        @endif
                   
                });

                refundRequestList.load();
            },
            getList: () => {

                return refundRequestList;
            }
        };
    }();

    let createReceiptHandle = function() {
        return {
            init: () => {
                document.querySelector('#buttonCreateReceipt').addEventListener('click', e => {
                    e.preventDefault();
                    CreateReceiptPopup.updateUrl(
                        "{{ action([App\Http\Controllers\Sales\StudentController::class, 'refundRequest'],['id' => '',],) }}"
                    );
                });
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

                $('[list-action="order-select"]').on('change', function() {
                    var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);
                    RefundList.getList().setOrderId(selectedValues);

                    // load list
                    RefundList.getList().load();
                });

                $('[list-action="account-select"]').on('change', function() {
                    var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                    RefundList.getList().setAccountId(selectedValues);

                    // load list
                    RefundList.getList().load();
                });
                $('[list-action="contact-select"]').on('change', function() {
                    var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                    RefundList.getList().setContactIds(selectedValues);

                    // load list
                    RefundList.getList().load();
                });
                $('[list-action="refund_date-select"]').on('change', function() {
                    // Lấy giá trị từ cả hai trường input
                    var fromDate = $('[name="refund_date_from"]').val();
                    var toDate = $('[name="refund_date_to"]').val();

                    // Gửi phạm vi ngày tạo đến RefundList và tải lại danh sách
                    RefundList.getList().setRefundateFrom(fromDate);
                    RefundList.getList().setRefunđateTo(toDate);
                    RefundList.getList().load();
                });
                $('[list-action="created_at-select"]').on('change', function() {
                    // Lấy giá trị từ cả hai trường input
                    var fromDate = $('[name="created_at_from"]').val();
                    var toDate = $('[name="created_at_to"]').val();

                    // Gửi phạm vi ngày tạo đến RefundList và tải lại danh sách
                    RefundList.getList().setCreatedAtFrom(fromDate);
                    RefundList.getList().setCreatedAtTo(toDate);
                    RefundList.getList().load();
                });

                $('[list-action="updated_at-select"]').on('change', function() {
                    // Lấy giá trị từ cả hai trường input
                    var fromDate = $('[name="updated_at_from"]').val();
                    var toDate = $('[name="updated_at_to"]').val();


                    RefundList.getList().setUpdatedAtFrom(fromDate);
                    RefundList.getList().setUpdatedAtTo(toDate);
                    RefundList.getList().load();
                });
            }
        };
    })();



    var DataList = class {

        constructor(options) {
            // The object's attributes
            this.url = options.url; // URL to call request get List of data
            this.container = options.container; // HTML element which contain the content in this feature
            this.listContent = options
                .listContent; // HTML element which contain the returned list of data from backend

            this.keyword;
            this.sort_by;
            this.sort_direction;
            this.account_id;
            this.contacts_id;
            this.perpage;
            this.page;
            this.order_id;

            this.status;
            if (typeof(options.status) !== 'undefined') {
                this.status = options.status;
            }

            // lead status
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

        loadContent(content) {

            $(this.listContent).html(content);

            initJs(this.listContent);
        };

        /**
         * The method add a loading effect while waiting for data to be returned from ther server
         */
        addLoadingEffect() {

            this.listContent.classList.add("list-loading");

            // When there is none, it adds a loading element to the HTML interface
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

        // Effect loading
        removeLoadingEffect() {
            this.listContent.classList.remove("list-loading");

            if (this.container.querySelector('[list-action="loader"]')) {
                this.container.querySelector('[list-action="loader"]').remove();
            };
        };

        getUpdateBtn() {
            return this.listContent.querySelectorAll('[row-action="update"]');
        };

        getDeleteItemBtns() {
            return this.listContent.querySelectorAll('[row-action="delete"]');
        };

        getDeleteAllItemBtn() {
            return document.querySelector('[row-action="delete-all"]');
        };

        getCancelRequestButtons() {
            return this.listContent.querySelectorAll('[row-action="cancel-request"]');
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

        updateCountLabel() {
            this.container.querySelector('[list-control="count-note-selected-label"]').innerHTML =
                'Đã chọn <strong>' + this
                .checkedCount() + '</strong> khách hàng';
        };

        checkedCount() {
            return this.getCheckedNoteBtns().length;
        };

        // Return number of items in list returned
        getNumberOfItems() {
            return this.listContent.querySelectorAll('[list-control="item"]').length;
        };

        getCheckNoteBtns() {
            return this.listContent.querySelectorAll('[list-action="check-item"]');
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

         //refund_date_from
        setRefundateFrom(refunđateFrom) {
            this.refund_date_from = refunđateFrom;
        }
        getRefundateFrom() {
            return this.refund_date_from;
        };
        //refund_date_to
        setRefunđateTo(refunđateTo) {
            this.refund_date_to = refunđateTo;
        }
        getRefundateTo() {
            return this.refund_date_to;
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



        getCheckAllBtn() {
            return this.listContent.querySelector('[list-action="check-all"]');
        };

        getPageUrl() {
            return this.listContent.querySelectorAll('a.page-link');
        };

        // URL
        setUrl(newUrl) {
            this.url = newUrl;
        };

        getUrl() {
            return this.url;
        };



        getSortBy() {
            return this.sort_by;
        };



        getSortDirection() {
            return this.sort_direction;
        };

        // Search by keyword
        setKeyWord(keyword) {
            this.keyword = keyword;
        };

        getKeyword() {
            return this.keyword;
        };

        getkeywordInput() {
            return this.container.querySelector('[list-action="keyword-input"]');
        };

        // Filter by contacts
        setContactIds(contactIds) {
            this.contact_ids = contactIds;
        };

        getContactIds() {
            return this.contact_ids;
        };
        getListCheckboxes() {
            return this.listContent.querySelectorAll('[list-action="check-item"]');
        }
        getCheckAllButton() {
            if (!this.listContent.querySelector('[list-action="check-all"]')) {
                throw new Error('Bug: Check all button not found!');
            }

            return this.listContent.querySelector('[list-action="check-all"]');
        }
        hideTopListActionBox() {
            this.getTopListActionBox().classList.add('d-none');
        }
        showTopListActionBox() {
            this.getTopListActionBox().classList.remove('d-none');
        }
        getTopListActionBox() {
            return this.container.querySelector('[list-action="top-action-box"]');
        }
        hideSearchBoxes() {
            this.getSearchBoxes().classList.add('d-none');
        }
        getSearchBoxes() {
            return this.container.querySelector('[list-action="search-action-box"]');
        }
        showSearchBoxes() {
            this.getSearchBoxes().classList.remove('d-none');
        }
        getStatus() {
            return this.status;
        }
        // Filter by order
        setOrderId(orderId) {
            this.order_id = orderId;
        };

        getOrderId() {
            return this.order_id;
        };
        
        // Filter by account
        setAccountId(accountId) {
            this.account_id = accountId;
        };

        getAccountId() {
            return this.account_id;
        };

        setPerpage(perpage) {
            this.perpage = perpage;
        };

        setPage(page) {
            this.page = page;
        };

        initEvents() {

            SortManager.init(this);

            // When list has items
            if (this.getNumberOfItems()) {

                /**
                 * Update Popup handle per item
                 */
                this.getUpdateBtn().forEach(btn => {
                    btn.addEventListener('click', e => {

                        e.preventDefault();

                        let btnUrl = btn.getAttribute('href'); // Get URL in each update button

                        UpdateRequestPopup.updateUrl(btnUrl);
                    })
                });

                /**
                 * Handle Page items list per page
                 */
                this.getPageUrl().forEach(url => {

                    /**
                     * Asign click event for each page button
                     */
                    url.addEventListener('click', e => {
                        e.preventDefault();

                        let u = new URL(url.getAttribute('href'));
                            let params = new URLSearchParams(u.search);
                            let pageNumber = params.get('page');

                        this.setPage(pageNumber);

                        // Reload page
                        this.load();
                    });
                });

                /**
                 * DELETE item
                 */
                this.getDeleteItemBtns().forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.preventDefault();

                        let url = btn.getAttribute('href');

                        this.deleteItem(url);
                    });
                });

                /**
                 * DELETE all Items
                 */
                this.getDeleteAllItemBtn().addEventListener('click', e => {
                    e.preventDefault();

                    this.deleteAllItems();
                });

                /**
                 * CANCEL REPORT
                 */
                 this.getCancelRequestButtons().forEach(button => {
                    button.addEventListener('click', (e) => {
                        e.preventDefault();

                        var url = button.getAttribute('href');

                        this.cancelRequest(url);
                    });
                });


                /**
                 * Pagination per page
                 */
                $('#perPage').change(() => {
                    const perPage = $('#perPage').val();
                    this.setPerpage(perPage);
                    this.setPage(1);
                    this.load();
                });

                /**
                 * Check items, check all
                 */
                this.getCheckNoteBtns().forEach(button => {

                    const isChecked = button.checked;

                    button.addEventListener('change', e => {
                        const isAnyNoteChecked = Array
                            .from(this.getCheckNoteBtns())
                            .some(item => {
                                return !item.checked;
                            });

                        this.getCheckAllBtn().checked = !isAnyNoteChecked;

                        if (this.getCheckedNoteBtns().length > 0) {
                            this.showTopActionBox();
                        } else {
                            this.hideTopActionBox();
                        }

                        this.updateCountLabel();
                    });

                });

                this.getCheckAllBtn().addEventListener('change', e => {

                    this.getCheckNoteBtns().forEach(button => {
                        button.checked = e.target.checked;
                    });

                    if (this.getCheckedNoteBtns().length > 0) {
                        this.showTopActionBox();
                    } else {
                        this.hideTopActionBox();
                    };

                    this.updateCountLabel();
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

            };
        };

        deleteItem(url) {
            ASTool.confirm({
                message: "Bạn có chắc muốn xóa phiếu thu này không?",
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

                                RefundList.getList().load();
                            }
                        })
                    }).fail(function() {

                    }).always(function() {
                        ASTool.removePageLoadingEffect();
                    })
                }
            })
        }

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
                                RefundList.getList().load();
                            }
                        });
                    }).fail(function() {}).always(function() {
                        ASTool.removePageLoadingEffect();
                    });
                }
            });
        };





        events() {

            /**
             * Feature search by input form
             */
            this.getkeywordInput().addEventListener("keyup", e => {

                this.setKeyWord(this.getkeywordInput().value);

                if (event.key === 'Enter') {
                    this.load();
                }
            });
            // on focus out of keyword input
            this.getkeywordInput().addEventListener('keyup', (e) => {
                this.load();
            });

            /**
             * SHOW COLUMNS
             */

            // khi tick vào phần hiển thị column
            this.getColumnsCheckboxes().forEach(checkbox => {
                // Lấy danh sách các checkbox
                const checkboxes = this.getColumnsCheckboxes();
                // event
                checkbox.addEventListener('change', (e) => {
                    const checked = checkbox.checked;
                    const column = checkbox.value;

                    if (!checked) {
                        // Uncheck the "all" checkbox if any other checkbox is unchecked
                        // allCheckbox.checked = false;
                    }

                    // Xử lý thêm hoặc xóa cột khỏi danh sách cột nếu cần
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
        };



        setKeyword(keyword) {
            this.keyword = keyword;
        }

        getKeyword() {
            return this.keyword;
        }

        getColumnsCheckboxes() {
            return this.container.querySelectorAll('[list-action="column-checker"]');
        }

        addColumn(column) {
            this.columns.push(column);
        }

        removeColumn(column) {
            this.columns = this.columns.filter(e => e !== column);
        }

        getColumns() {
            return this.columns;
        }

        getFilterActionBox() {
            return this.container.querySelector('[list-action="filter-action-box"]');
        }
        getFilterButton() {
            return document.getElementById('filterButton');
        }
        getFilterIcon() {
            return document.getElementById('filterIcon');
        }
        getToolBoxes() {
            return this.container.querySelector('[list-action="tool-action-box"]');
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
        showToolBoxes() {
            this.getToolBoxes().classList.remove('d-none');
        }
        hideToolBoxes() {
            this.getToolBoxes().classList.add('d-none');
        }
        load() {

            this.addLoadingEffect();

            $.ajax({
                url: this.url,
                method: "GET",
                data: {
                    key: this.getKeyword(),
                    contact_ids: this.getContactIds(),
                    account_id: this.getAccountId(),

                    page: this.page,
                    perpage: this.perpage,
                    status: this.getStatus(),

                    refund_date_from: this.getRefundateFrom(),
                    refund_date_to: this.getRefundateTo(),

                    created_at_from: this.getCreatedAtFrom(),
                    created_at_to: this.getCreatedAtTo(),

                    updated_at_from: this.getUpdatedAtFrom(),
                    updated_at_to: this.getUpdatedAtTo(),


                    sort_by: SortManager.getSortBy(),
                    sort_direction: SortManager.getSortDirection(),
                    
                    order_id: this.getOrderId(),

                    columns: ContactColumnManager.getColumns(),
                }
            }).done(response => {

                if (this.url.includes("perpage")) {
                    let tmp = this.url;
                    this.url = tmp.substring(0, tmp.indexOf("?perpage"));
                }

                this.loadContent(response);
                this.initEvents();
                this.removeLoadingEffect();
                this.hideTopActionBox();

                ContactColumnManager.applyToList();
            }).fail(message => {
                throw new Error(message);
            })
        };
    }
</script>
@endsection