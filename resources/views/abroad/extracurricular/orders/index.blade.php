@extends('layouts.main.app', [
    'menu' => 'extracurricular',
])

@section('sidebar')
    @include('abroad.modules.sidebar', [
        'menu' => 'orders',
        'orderType' => $screenType,
        'sidebar' => 'orders',
    ])
@endsection

@section('content')

    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh sách hợp đồng ngoại khóa</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="javascript:;" class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">{{ $screenType == App\Models\Order::TYPE_REQUEST_DEMO ? "yêu cầu học thử" : "Hợp đồng ngoại khóa" }}</li>
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
            <button list-action="create-constract" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px {{ $screenType == App\Models\Order::TYPE_REQUEST_DEMO ? "d-none" : "" }}" id="buttonCreateConstract">
                <span class="material-symbols-rounded me-2">
                    add
                </span>
                Thêm dịch vụ
            </button>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>

    <div id="OrdersIndexContainer" class="position-relative" id="kt_post">
        <!--begin::Card-->
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
                                    <a row-action="delete-all" href="{{ action([App\Http\Controllers\Abroad\OrderController::class, 'deleteAll']) }}"
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
                            class="form-control w-250px ps-12" placeholder="{{ $screenType == App\Models\Order::TYPE_REQUEST_DEMO ? "Tìm yêu cầu học thử..." : "Tìm dịch vụ..." }}" />
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
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Sa sdle</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="sale-select" class="form-select filter-select"
                                    data-control="select2" data-close-on-select="false" data-placeholder="Chọn sale"
                                    data-allow-clear="true" multiple="multiple">
                                    @foreach (App\Models\Account::extracurricularsAndSales()->get() as $account)
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
                                    @foreach (App\Models\Account::salesSup()->get() as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold">Tình trạng dịch vụ</label>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <select list-action="payment-order-status-select" class="form-select filter-select"
                                data-control="select2" data-placeholder="Chọn tình trạng dịch vụ" data-allow-clear="true" multiple="multiple"  >
                                    @foreach (App\Models\Order::getAllPaymentOrderStatus() as $paymentStatus)
                                        <option value="{{ $paymentStatus['value'] }}">{{ $paymentStatus['label'] }}</option>
                                    @endforeach
                                
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <label class="form-label">Khách hàng</label>
                            <div class="row" list-action="created_at-select">
                                    <div class="form-outline">
                                        <select id="order-filter-contact-select" data-control="select2-ajax" data-url="{{ action('App\Http\Controllers\Abroad\ContactController@select2') }}" class="form-control filter-select" name="contact" data-dropdown-parent="#OrdersIndexContainer" data-control="select2" data-placeholder="Chọn khách hàng/liên hệ..." data-allow-clear="true" data-html="true">
                                            <option value="">Chọn khách hàng/liên hệ</option>
                                            @if (isset($contact)) 
                                                <option value="{{ $contact->id }}" selected>{{ '<strong>' .  $contact->name .'</strong><br>'. $contact->email .'</strong><br>'. $contact->phone }}</option>
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
                                        <select id="order-filter-student-select" data-control="select2-ajax" data-url="{{ action('App\Http\Controllers\Abroad\ContactController@select2') }}" class="form-control filter-select"
                                            name="student_id" data-dropdown-parent="#OrdersIndexContainer" data-control="select2" data-placeholder="Chọn khách hàng/liên hệ..." data-allow-clear="true" data-html="true">
                                            <option value="">Chọn học viên</option>
                                            @if (isset($contact)) 
                                                <option value="{{ $contact->id }}" selected>{{ '<strong>' .  $contact->name .'</strong><br>'. $contact->email .'</strong><br>'. $contact->phone }}</option>
                                            @endif
                                        </select>
                                        
                                        <x-input-error :messages="$errors->get('contact')" class="mt-2" />
                                    </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-5">
                            <label class="form-label">Ngày cập nhật (Từ - Đến)</label>
                            <div class="row" list-action="updated_at-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="updated_at_from" placeholder="=asas" type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="updated_at_to" placeholder="=asas" type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 mb-5">
                            <label class="form-label">Ngày dịch vụ (Từ - Đến)</label>
                            <div class="row" list-action="order_date-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="order_date_from" placeholder="=asas" type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="order_date_to" placeholder="=asas" type="date" class="form-control" placeholder="" />
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
        <!--end::Card header-->
        <div id="OrdersIndexListContent">
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
                OrderList.init();
                filterData.init();
                CreateConstractHandle.init();
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
                    name: '{{ $listViewName }}',
                    saveUrl: '{{ action([App\Http\Controllers\UserController::class, 'saveListColumns']) }}',
                    columns: {!! json_encode($columns) !!},
                    optionsBox: document.querySelector('[columns-control="options-box"]'),
                    getList: function() {
                            return OrderList.getList();
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

    let OrderList = function() {

        let list;

        return {
            init: () => {
                let screenType = "{!! $screenType !!}";

                list = new DataList({
                url: `{{ action('\App\Http\Controllers\Abroad\OrderController@list', ['screenType' => '']) }}${screenType}`,
                container: document.querySelector("#OrdersIndexContainer"),
                listContent: document.querySelector("#OrdersIndexListContent"),
                status: '{{ request()->status ?? 'all' }}',
            });

                list.load();
            },
            getList: () => {
                return list;
            }
        };
    }();

    let CreateConstractHandle = function() {
        let createOrderBtns = document.querySelectorAll('[list-action="create-constract"]');
        let createContractForRequestDemoBtn = document.querySelectorAll('[list-action="add-request-demo"]');

        return {
            init: () => {
                createOrderBtns.forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.preventDefault();
                        
                        pickContactPopup.updateUrl("{{ action('\App\Http\Controllers\Abroad\OrderController@pickContact') }}");
                    });
                });

                createContractForRequestDemoBtn.forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.preventDefault();
                        
                        pickContactPopup.updateUrl("{{ action('\App\Http\Controllers\Abroad\OrderController@pickContactForRequestDemo') }}");
                    });
                });
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
            let contact = null;
            let industries = [];
            let orderTypes = [];
            let types = [];
            let sales = [];
            let saleSups = [];
            let paymentOrderStatus = [];
            let filterBtn = document.querySelector("#filter-orders-btn");
            let actionBox = document.querySelector('[list-action="filter-action-box"]');

            const getContactValue = () => {
                contact = document.querySelector('#order-filter-contact-select').value;
            };

            const getStudentId = () => {
                student_id = document.querySelector('#order-filter-student-select').value;
            };

            // const getOrderTypeValues = () => {
            //     orderTypes = Array.from(document.querySelector('[list-action="order-type-filter-select"]').selectedOptions)
            //         .map(option => option.value);
            // };

            // const getIndustryValues = () => {
            //     industries = Array.from(document.querySelector('[list-action="industry-select"]').selectedOptions)
            //         .map(option => option.value);
            // };

            // const getTypeValues = () => {
            //     types = Array.from(document.querySelector('[list-action="type-select"]').selectedOptions)
            //         .map(option => option.value);
            // };

            const getSaleValues = () => {
                sales = Array.from(document.querySelector('[list-action="sale-select"]').selectedOptions)
                    .map(option => option.value);
                
            };

            const getSaleSupValues = () => {
                saleSups = Array.from(document.querySelector('[list-action="sale-sup-select"]').selectedOptions)
                    .map(option => option.value);
            };

            const getPaymentOrderStatusValues = () => {
                paymentOrderStatus = Array.from(document.querySelector('[list-action="payment-order-status-select"]').selectedOptions)
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
                        getStudentId();
                        // getOrderTypeValues();
                        // getIndustryValues();
                        // getTypeValues();
                        getSaleValues();
                        getSaleSupValues();
                        getPaymentOrderStatusValues();
                        

                        OrderList.getList().setIndustries(industries);
                        OrderList.getList().setContact(contact);
                        OrderList.getList().setStudentId(student_id);
                        OrderList.getList().setOrderTypes(orderTypes);
                        OrderList.getList().setTypes(types);
                        OrderList.getList().setSales(sales);
                        OrderList.getList().setSaleSups(saleSups);
                        OrderList.getList().setPaymentOrderStatus(paymentOrderStatus);
                        OrderList.getList().load();
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

                        OrderList.getList().setCreatedAtFrom(fromDate);
                        OrderList.getList().setCreatedAtTo(toDate);
                        OrderList.getList().load();
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();

                        OrderList.getList().setUpdatedAtFrom(fromDate);
                        OrderList.getList().setUpdatedAtTo(toDate);
                        OrderList.getList().load();
                    });

                    $('[list-action="order_date-select"]').on('change', function() {
                        var fromDate = $('[name="order_date_from"]').val();
                        var toDate = $('[name="order_date_to"]').val();

                        OrderList.getList().setOrderDateFrom(fromDate);
                        OrderList.getList().setOrderDateTo(toDate);
                        OrderList.getList().load();
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
                this.contact;
                this.industries;
                this.orderTypes;
                this.types;
                this.sales;
                this.saleSups;
                this.paymentOrderStatus;
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

            setTypes(types) {
                this.types = types;
            };

            setSales(sales) {
                this.sales = sales;
            };

            setSaleSups(saleSups) {
                this.saleSups = saleSups;
            };

            setPaymentOrderStatus(paymentOrderStatus) {
                this.paymentOrderStatus = paymentOrderStatus;
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

            getPaymentOrderStatus() {
                return this.paymentOrderStatus;
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
                    .checkedCount() + '</strong> dịch vụ';
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

            //order_date_from
            setOrderDateFrom(orderDateFrom) {
                this.order_date_from = orderDateFrom;
            }
            getOrderDateFrom() {
                return this.order_date_from;
            };
            //order_date_to
            setOrderDateTo(orderDateTo) {
                this.order_date_to = orderDateTo;
            }
            getOrderDateTo() {
                return this.order_date_to;
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
                })

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


                    this.getDeleteAllItemsBtn().addEventListener('click', function(e) {

                        e.preventDefault();
                        const url = this.getAttribute('href');
                        const items = _this.getItemCheckedIds();

                        _this.hideFilterActionBox();

                        ASTool.confirm({
                            message: "Bạn có chắc muốn xóa các dịch vụ này không?",
                            ok: function() {
                                ASTool.addPageLoadingEffect();
                                $.ajax({
                                    url: url,
                                    method: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        orders: items
                                    }
                                }).done(response => {
                                    ASTool.alert({
                                        message: response.message,
                                        ok: function() {
                                            OrderList.getList().load();
                                            _this.showSearchForm();
                                            _this.showActionForm();
                                            _this.hideTopActionBox();
                                        }
                                    })
                                }).fail(function() {

                                }).always(function() {
                                    ASTool.removePageLoadingEffect();
                                })
                            }
                        });
                    });


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

                            if (this.getCheckedNoteBtns().length > 0) {
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

                        if (this.getCheckedNoteBtns().length > 0) {
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

                            var url = button.getAttribute("href");
                            

                            window.location.href = url;
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
                                message: "Bạn có chắc muốn xóa dịch vụ này không?",
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
                                                OrderList.getList().load();
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
                        contact: this.getContact(),
                        student_id: this.getStudentId(),
                        industries: this.getIndustries(),
                        orderTypes: this.getOrderTypes(),
                        types: this.getTypes(),
                        sales: this.getSales(),
                        saleSups: this.getSaleSups(),
                        paymentOrderStatus: this.getPaymentOrderStatus(),
                        // columns manager
                        columns: CustomerColumnManager.getColumns(),
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),
                        order_date_from: this.getOrderDateFrom(),
                        order_date_to: this.getOrderDateTo(),
                        status: this.getStatus(),
                    }
                }).done(content => {
                    this.loadContent(content);
                    this.initContentEvents();
                    this.removeLoadEffect();
                    // apply
                    CustomerColumnManager.applyToList();
                }).fail(message => {
                    throw new Error(message);
                })
            };
        }
    </script>
@endsection
