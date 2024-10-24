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
                <a href="{{ action([App\Http\Controllers\Sales\CustomerController::class, 'index']) }}"
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
            @include('sales.customers.detail', [
            'detail' => 'request-contact',
            ])
            <!--end::Details-->

            @include('sales.customers.menu', [
            'menu' => 'request-contact',
            ])

        </div>
    </div>
    <!--end::Navbar-->
    <!--begin::details View-->
    <div class="card" id="ContactRequestIndexContainer">
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
                        class="form-control w-250px ps-12" placeholder="Nhập để tìm đơn hàng " />
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
                            Thêm Nhu Cầu
                        </a>
                        <!--end::Button-->
                    </div>
                    @if (Auth::user()->can('create', App\Models\ContactRequest::class))
                    <!--begin::Button-->
                    <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px me-3"
                        id="buttonCreateContactRequest">
                        <span class="material-symbols-rounded me-2">
                            person_add
                        </span>
                        Thêm đơn hàng
                    </a>
                    <!--end::Button-->
                    <script>
                    $(function() {
                        $('#buttonCreateContactRequest').on('click', function(e) {
                            e.preventDefault();
                            
                            var popup = new Popup({
                                url: "{{ action([App\Http\Controllers\Sales\ContactRequestController::class, 'create'], ['contact_id' => $contact->id]) }}",
                            });
                            
                            popup.load();
                        });
                    });
                    </script>
                    @endif

                    <!--begin::Filter-->
                    <button type="button" class="btn btn-outline btn-outline-default d-none " id="filterButton">
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
</div>
</div>
<div id="ContactRequestIndexListContent"></div>
</div>
<!--end::Post-->
<script>
    $(() => {
        ContactRequestIndex.init();


        

    });

    var ContactRequestIndex = function() {
        return {
            init: () => {
                CreateNotePopup.init();

                ContactRequestsList.init();
                UpdateContactRequestPopup.init();
                FilterData.init();

                UpdateContactPopup.init();


            }
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
                $('[list-action="account-select"]').on('change', function() {
                    var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                    ContactRequestsList.getList().setAccountId(selectedValues);

                    // load list
                    if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                });
                $('[list-action="contact-select"]').on('change', function() {
                    var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                    ContactRequestsList.getList().setContactIds(selectedValues);

                    // load list
                    if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                });
                $('[list-action="created_at-select"]').on('change', function() {
                    // Lấy giá trị từ cả hai trường input
                    var fromDate = $('[name="created_at_from"]').val();
                    var toDate = $('[name="created_at_to"]').val();

                    // Gửi phạm vi ngày tạo đến ContactRequestsList và tải lại danh sách
                    ContactRequestsList.getList().setCreatedAtFrom(fromDate);
                    ContactRequestsList.getList().setCreatedAtTo(toDate);
                    if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                });

                $('[list-action="updated_at-select"]').on('change', function() {
                    // Lấy giá trị từ cả hai trường input
                    var fromDate = $('[name="updated_at_from"]').val();
                    var toDate = $('[name="updated_at_to"]').val();

                    // Gửi phạm vi ngày tạo đến ContactRequestsList và tải lại danh sách
                    ContactRequestsList.getList().setUpdatedAtFrom(fromDate);
                    ContactRequestsList.getList().setUpdatedAtTo(toDate);
                    if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                });
            }
        };
    })();

    var UpdateContactPopup = function() {
        var popupUpdateContact;
        var buttonsEditContact;

        var showEditContact = function(contactId) {

            popupUpdateContact.setData({
                contact_id: contactId,
            });

            popupUpdateContact.load();
        };

        var handleEditContactButton = function() {
            buttonsEditContact.forEach(function(button) {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    var contactId = "{{ $contact->id }}";
                    showEditContact(contactId);
                });
            });
        };


        return {
            init: function() {
                // Khởi tạo popup chỉnh sửa thông tin học viên với url
                popupUpdateContact = new Popup({
                    url: "{{ action('App\Http\Controllers\Sales\ContactController@edit', ['id' => $contact->id]) }}",
                });
                buttonsEditContact = document.querySelectorAll('[row-action="update-contact"]');
                handleEditContactButton();
            },
            getPopup: function() {
                return popupUpdateContact;
            }
        }


    }();

    let ContactRequestsList = function() {

        let contactRequestsList;

        return {
            init: () => {

                contactRequestsList = new DataList({

                    url: "{{ action('App\Http\Controllers\Sales\CustomerController@requestContactList', ['id' => $contact->id]) }}",
                    container: document.querySelector("#ContactRequestIndexContainer"),
                    listContent: document.querySelector("#ContactRequestIndexListContent")
                });

                contactRequestsList.load();
            },
            getList: () => {


                return contactRequestsList;
            }
        };
    }();



    var UpdateContactRequestPopup = function() {
        var popupUpdateContactRequest;
        return {
            init: function(updateUrl) {
                // Khởi tạo popup chỉnh sửa chiến dịch
                popupUpdateContactRequest = new Popup({
                    url: updateUrl, // Sử dụng URL được chuyền vào từ tham số
                });
            },

            load: function(url) {
                popupUpdateContactRequest.url = url;
                popupUpdateContactRequest.load(); // Hiển thị cửa sổ chỉnh sửa
            },


            getPopup: function() {
                return popupUpdateContactRequest;
            },

        };
    }();

    const CreateNotePopup = function() {
            let createPopup;

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
                .checkedCount() + '</strong> liên hệ';
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

        showSearchForm() {
            document.querySelector('#search-form').classList.remove("d-none");
        };

        hideSearchForm() {
            document.querySelector('#search-form').classList.add("d-none");
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

        getSearchKeywordInput() {
            return this.container.querySelector('[list-action="keyword-input"]');
        };

        // Filter by contacts
        setContactIds(contactIds) {
            this.contact_ids = contactIds;
        };

        getContactIds() {
            return this.contact_ids;
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

                        let btnUrl = btn.getAttribute('href'); // Get URL in each upsdate button

                        UpdateContactRequestPopup.load(btnUrl);
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
                            this.hideSearchForm();
                            this.showTopActionBox();
                        } else {
                            this.showSearchForm();
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
                        this.hideSearchForm();
                        this.showTopActionBox();
                    } else {
                        this.showSearchForm();
                        this.hideTopActionBox();
                    };

                    this.updateCountLabel();
                });
            };
        };

        deleteItem(url) {
            ASTool.confirm({
                message: "Bạn có chắc muốn xóa đơn hàng này không?",
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
                                if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                            }
                        })
                    }).fail(function() {

                    }).always(function() {
                        ASTool.removePageLoadingEffect();
                    })
                }
            })
        }



        events() {
            //Khi mà click vào nút lọc
            this.getFilterButton().addEventListener('click', (e) => {
                if (!this.isFilterActionBoxShowed()) {
                    this.showFilterActionBox();
                } else {
                    this.hideFilterActionBox();
                }
            });

            /**
             * Feature search by input form
             */
            this.getSearchKeywordInput().addEventListener("keyup", e => {

                this.setKeyWord(this.getSearchKeywordInput().value);

                if (event.keyword === 'Enter') {
                    this.load();
                }
            });


            // on focus out of keyword input
            this.getSearchKeywordInput().addEventListener('keyup', (e) => {
                this.load();
            });
        };
        getFilterButton() {
            return document.getElementById('filterButton');
        }
        getFilterIcon() {
            return document.getElementById('filterIcon');
        }
        getFilterActionBox() {
            return this.container.querySelector('[list-action="filter-action-box"]');
        }
        showFilterActionBox() {
            this.getFilterActionBox().classList.remove('d-none');
            this.getFilterIcon().innerHTML = 'expand_less'
        }
        isFilterActionBoxShowed() {
            return !this.getFilterActionBox().classList.contains('d-none');
        }
        hideFilterActionBox() {
            this.getFilterActionBox().classList.add('d-none');
            this.getFilterIcon().innerHTML = 'expand_more'
        }
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



        load() {

            // this.addLoadingEffect();

            $.ajax({
                url: this.url,
                method: "GET",
                data: {
                    keyword: this.getKeyword(),
                    contact_ids: this.getContactIds(),
                    account_id: this.getAccountId(),

                    page: this.page,
                    perpage: this.perpage,
                    created_at_from: this.getCreatedAtFrom(),
                    created_at_to: this.getCreatedAtTo(),

                    updated_at_from: this.getUpdatedAtFrom(),
                    updated_at_to: this.getUpdatedAtTo(),

                    sort_by: SortManager.getSortBy(),
                    sort_direction: SortManager.getSortDirection(),

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
                this.showSearchForm();
            }).fail(message => {
                throw new Error(message);
            })
        };
    }
</script>
@endsection