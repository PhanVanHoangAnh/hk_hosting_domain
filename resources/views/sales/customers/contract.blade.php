@extends('layouts.main.app', [
'menu' => 'sales',
])
@section('sidebar')
@include('sales.modules.sidebar', [
'menu' => 'customer',
'sidebar' => 'customer',
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
                <a href="../../demo5/dist/index.html" class="text-muted text-hover-primary">Trang chủ</a>
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
            @include('sales.customers.detail', [
            'detail' => 'contract',
            ])
            <!--end::Details-->

            @include('sales.customers.menu', [
            'menu' => 'contract',
            ])
        </div>
    </div>
    <!--end::Navbar-->

    <!--begin::Row-->
    <div class="card" id="OrdersIndexContainer">
        <!--begin::Card header-->
        <div class="card-header border-0 px-4">
            <!--begin::Group actions-->
            <div list-action="top-action-box" class="menu d-flex justify-content-end align-items-center d-none"
                data-kt-menu="true">
                <div class="menu-item" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start">
                    <!--begin::Menu link-->
                    <button type="button" class="btn btn-outline btn-outline-default px-9 " data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
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
                        class="form-control w-250px ps-12" placeholder="Nhập để tìm hợp đồng " />
                </div>
                <!--begin::Search-->


                <!--end::Search-->
            </div>

            <!--begin::Card toolbar-->
            <div class="card-toolbar" list-action="tool-action-box">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <div class="d-flex align-items-center py-1">
                        <button data-action="under-construction" list-action="add-request-demo"
                            class="btn btn-flex btn-sm btn-light fw-bold border-0 fs-6 h-40px me-3 {{ $screenType == App\Models\Order::TYPE_REQUEST_DEMO ? "" : "
                            d-none" }}" id="addRequestDemoBtn">
                            <span class="material-symbols-rounded me-2">
                                add
                            </span>
                            Yêu cầu học thử
                        </button>
                        <!--begin::Button-->
                        <button list-action="create-constract"
                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px {{ $screenType == App\Models\Order::TYPE_REQUEST_DEMO ? "
                            d-none" : "" }}" id="buttonCreateConstract">
                            <span class="material-symbols-rounded me-2">
                                add
                            </span>
                            Thêm hợp đồng
                        </button>
                        <!--end::Button-->
                    </div>

                    <!--begin::Filter-->
                    <button type="button" class="btn btn-outline btn-outline-default d-none" id="filterButton">
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
        <div class="card-header border-0 p-4 d-none list-filter-box pt-0 pb-0" list-action="filter-action-box">
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
                                <option value="{{ $tag->id }}" id="tag_{{ $tag->id }}" for="tag_{{ $tag->id }}">
                                    {{ $tag->name }}
                                </option>
                                @endforeach --}}
                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mb-5">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold ">Phân loại nguồn:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="marketing-type-select" class="form-select" data-control="select2"
                                data-kt-select2="true" data-placeholder="Chọn Phân loại nguồn" multiple>
                                <option></option>
                                @php
                                $uniqueMarketingTypes = \App\Helpers\Functions::getSourceTypes();
                                @endphp
                                @foreach ($uniqueMarketingTypes as $source_type)
                                <option value="{{ $source_type }}">{{ $source_type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold ">Channel:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="marketing-source-select" class="form-select " data-control="select2"
                                data-kt-select2="true" data-placeholder="Chọn channel" data-allow-clear="true">
                                <option></option>
                                @php
                                $uniqueMarketingSource = App\Models\ContactRequest::pluck('channel')->unique();
                                @endphp
                                @foreach ($uniqueMarketingSource as $channel)
                                <option value="{{ $channel }}">{{ $channel }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold ">Sub-Channel:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="marketing-source-sub-select" class="form-select "
                                data-control="select2" data-kt-select2="true" data-placeholder="Chọn sub-channel"
                                multiple>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold ">Lifecycle Stage:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="lifecycle-stage-select" class="form-select " data-control="select2"
                                data-kt-select2="true" data-placeholder="Chọn life cycle stage" data-allow-clear="true">
                                <option></option>
                                @php
                                $uniqueLifecycleStage = App\Models\ContactRequest::pluck('lifecycle_stage')->unique();
                                @endphp
                                @foreach ($uniqueLifecycleStage as $lifecycle_stage)
                                <option value="{{ $lifecycle_stage }}">{{ $lifecycle_stage }}</option>
                                </option>
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mb-5">
                        <!--begin::Label-->

                        <label class="form-label fw-semibold ">Lead Status:</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="lifecycle-stage-sub-select" class="form-select" data-kt-select2="true"
                                data-control="select2" data-placeholder="Chọn lead status" multiple>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-3 mb-5">
                        <!--begin::Label-->
                        <label class="form-label fw-semibold ">Nhân viên sale</label>
                        <!--end::Label-->
                        <div>
                            <select list-action="salesperson-select" class="form-select" data-control="select2"
                                data-placeholder="Chọn nhân viên sales" multiple>
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
                                        <input data-control="input" name="created_at_to" placeholder="=asas" type="date"
                                            class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 mb-5">
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
                                        <input data-control="input" name="updated_at_to" placeholder="=asas" type="date"
                                            class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end::Actions-->
                </div>

                <!--end::Menu 1-->
                <!--end::Filter-->
            </div>
            <!--end::Toolbar-->
        </div>

    </div>
    <!--end::Toolbar-->
    <!--end::Card header-->


    <!--end::Card-->

    <div id="OrdersIndexListContent">

        
    </div>
</div>
<!--end::Post-->
<script>
    $(() => {
        OrdersFeatureIndex.init();
    });
    
    const OrdersFeatureIndex = function() {
        
        return {
            init: () => {
                // CustomerColumnManager.init();
                OrderList.init();
                // filterData.init();
                CreateConstractHandle.init();
                DeleteOrderPopup.init();
                ShowOrderPopup.init();
            }
        }
    }();

    

    let OrderList = function() {

        let list;

        return {
            init: () => {
                // let screenType = "{!! $screenType !!}";

                list = new DataList({
                    url: "{{ action('App\Http\Controllers\Sales\CustomerController@contractList', ['id' => $contact->id]) }}",
                    container: document.querySelector("#OrdersIndexContainer"),
                    listContent: document.querySelector("#OrdersIndexListContent")
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
                        pickContactPopup.updateUrl("{{ action( [App\Http\Controllers\Sales\OrderController::class, 'pickContact'],  [ 'contact_request_id' => $contact->id,], ) }}");
                    });
                });

                createContractForRequestDemoBtn.forEach(btn => {
                    btn.addEventListener('click', e => {
                        e.preventDefault();
                        
                        pickContactPopup.updateUrl("{{ action('\App\Http\Controllers\Sales\OrderController@pickContactForRequestDemo') }}");
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
            let filterBtn = document.querySelector("#filter-orders-btn");
            let actionBox = document.querySelector('[list-action="filter-action-box"]');

            const getContactValue = () => {
                contact = document.querySelector('#order-filter-contact-select').value;
            };

            const getOrderTypeValues = () => {
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
                        getOrderTypeValues();
                        getIndustryValues();
                        getTypeValues();
                        getSaleValues();
                        getSaleSupValues();

                        OrderList.getList().setIndustries(industries);
                        OrderList.getList().setContact(contact);
                        OrderList.getList().setOrderTypes(orderTypes);
                        OrderList.getList().setTypes(types);
                        OrderList.getList().setSales(sales);
                        OrderList.getList().setSaleSups(saleSups);
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

            getIndustries() {
                return this.industries;
            };

            getOrderTypes() {
                return this.orderTypes;
            };

            getContact() {
                return this.contact;
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

            getStatus() {
                return this.status;
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

                            window.location.href = `sales/orders/create-constract\\${currentOrderId}\\update`;
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
                                message: "Bạn có chắc muốn xóa hợp đồng này không?",
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
                // this.addLoadEffect();
                this.listXhr = $.ajax({
                    url: this.url,
                    data: {
                        keyword: this.getKeyword(),
                        page: this.page,
                        perpage: this.perpage,
                        sort_by: this.getSortBy(),
                        sort_direction: this.getSortDirection(),
                        contact: this.getContact(),
                        industries: this.getIndustries(),
                        orderTypes: this.getOrderTypes(),
                        types: this.getTypes(),
                        sales: this.getSales(),
                        saleSups: this.getSaleSups(),
                        // columns manager
                        // columns: CustomerColumnManager.getColumns(),
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),
                        status: this.getStatus(),
                    }
                }).done(content => {
                    this.loadContent(content);
                    this.initContentEvents();
                    this.removeLoadEffect();
                    // apply
                    // CustomerColumnManager.applyToList();
                }).fail(message => {
                    throw new Error("ERROR: LOAD CONTENT ORDER FAIL!");
                })
            };
        }
    </script>
@endsection