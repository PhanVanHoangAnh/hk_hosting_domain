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
    <div id="kt_post" class="position-relative">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                @include('edu.students.detail', [
                    'detail' => 'note-logs',
                ])
                <!--end::Details-->

                @include('edu.students.menu', [
                    'menu' => 'note-logs',
                ])

            </div>
        </div>
        <!--end::Navbar-->
        <!--begin::details View-->





        <div class="card" id="NoteLogsIndexContainer">
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
                    <div id="search-form" class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input list-action="keyword-input" type="text" data-kt-note-log-table-filter="search"
                            class="form-control w-250px ps-12" placeholder="Nhập để tìm ghi chú" />
                    </div>
                    <!--begin::Search-->


                    <!--end::Search-->
                </div>

                <!--begin::Card toolbar-->
                <div class="card-toolbar" list-action="tool-action-box">
                    <!--begin::Toolbar-->
                    <div class="d-flex justify-content-end">
                        <div class="d-flex align-items-center me-3">
                            <!--begin::Button-->
                            <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px"
                                id="buttonCreateNoteLog">
                                <i class="ki-duotone ki-abstract-10">
                                    <i class="path1"></i>
                                    <i class="path2"></i>
                                </i>
                                Thêm Ghi Chú
                            </a>
                            <!--end::Button-->
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
                        <div class="col-md-4 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Người ghi chú</label>
                            <!--end::Label-->
                            <div>
                                <select list-action="account-select" class="form-select" data-control="select2"
                                    data-allow-clear="true" data-placeholder="Chọn người ghi chú">
                                    <option></option>
                                    @foreach (App\Models\Account::all() as $account)
                                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        <!--end::Input-->
                        <!--begin::Content-->
                        {{-- <div class="col-md-3 mb-5 ">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Khách hàng</label>
                            <!--end::Label-->
                            <div>
                                <select list-action="customer-select" class="form-select" data-control="select2"
                                    data-placeholder="Chọn khách hàng/liên hệ" data-allow-clear="true" multiple>
                                    <option value="all">Chọn tất cả</option>
                                    @foreach (App\Models\Contact::all() as $contact)
                                        <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
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

                        <div class="col-md-4 mb-5">
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
                <!--end::Card header-->


                <!--end::Card-->
            </div>
        </div>
        <div id="NoteLogsIndexListContent"></div>
    </div>
    <!--end::Post-->
    <script>
        $(() => {
            NoteLogIndex.init();


            UpdateContactPopup.init();

        });

        var NoteLogIndex = function() {
            return {
                init: () => {
                    CreateNotePopup.init();
                    createNotlogHandle.init();
                    NoteList.init();
                    UpdateNotelogPopup.init();
                    FilterData.init();
                    updateNotlogHandle.init();
                    // deleteAllNotelog.init();
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

                        NoteList.getList().setAccountId(selectedValues);

                        // load list
                        NoteList.getList().load();
                    });
                    $('[list-action="customer-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        NoteList.getList().setContactIds(selectedValues);

                        // load list
                        NoteList.getList().load();
                    });
                    $('[list-action="created_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="created_at_from"]').val();
                        var toDate = $('[name="created_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến NoteList và tải lại danh sách
                        NoteList.getList().setCreatedAtFrom(fromDate);
                        NoteList.getList().setCreatedAtTo(toDate);
                        NoteList.getList().load();
                    });

                    $('[list-action="updated_at-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="updated_at_from"]').val();
                        var toDate = $('[name="updated_at_to"]').val();

                        // Gửi phạm vi ngày tạo đến NoteList và tải lại danh sách
                        NoteList.getList().setUpdatedAtFrom(fromDate);
                        NoteList.getList().setUpdatedAtTo(toDate);
                        NoteList.getList().load();
                    });
                }
            };
        })();

        var UpdateContactPopup = function() {
            var popupUpdateContact;
            var buttonsEditContact;

            var showEditContact = function(customerId) {

                popupUpdateContact.setData({
                    customer_id: customerId,
                });

                popupUpdateContact.load();
            };

            var handleEditContactButton = function() {
                buttonsEditContact.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var customerId = "{{ $contact->id }}";
                        showEditContact(customerId);
                    });
                });
            };


            return {
                init: function() {
                    // Khởi tạo popup chỉnh sửa thông tin khách hàng với url
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

        let NoteList = function() {

            let noteList;

            return {
                init: () => {

                    noteList = new DataList({

                        url: "{{ action('App\Http\Controllers\Edu\StudentController@noteLogList', ['id' => $contact->id]) }}",
                        container: document.querySelector("#NoteLogsIndexContainer"),
                        listContent: document.querySelector("#NoteLogsIndexListContent")
                    });

                    noteList.load();
                },
                getList: () => {


                    return noteList;
                }
            };
        }();

        var createNotlogHandle = function() {
            return {
                init: () => {
                    document.querySelector('#buttonCreateNoteLog').addEventListener('click', e => {
                        e.preventDefault();
                        CreateNotePopup.updateUrl(
                            "{{ action('\App\Http\Controllers\Sales\NoteLogController@addNoteLog', ['id' => $contact->id]) }}"
                        );
                    });
                }
            };
        }();

        var updateNotlogHandle = function() {

            return {
                init: () => {
                    var buttonsUpdateNoteLog = document.querySelectorAll(
                        '.btn-update-note-log'); // Lựa chọn tất cả nút chỉnh sửa
                    buttonsUpdateNoteLog.forEach(function(button) {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            var editUrl = this.getAttribute('href');
                            UpdateNotelogPopup.updateUrl(editUrl);
                        });
                    });
                },
                getUpdatePopup: () => {
                    return updatePopups;
                },
            };
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
                this.customers_id;
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

            // Filter by customers
            setContactIds(customerIds) {
                this.customer_ids = customerIds;
            };

            getContactIds() {
                return this.customer_ids;
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

                //  SortManager.init(this);

                // When list has items
                if (this.getNumberOfItems()) {

                    /**
                     * Update Popup handle per item
                     */
                    this.getUpdateBtn().forEach(btn => {
                        btn.addEventListener('click', e => {

                            e.preventDefault();

                            let btnUrl = btn.getAttribute('href'); // Get URL in each update button

                            UpdateNotelogPopup.updateUrl(btnUrl);
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
                    message: "Bạn có chắc muốn xóa ghi chú này không?",
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

                                    NoteList.getList().load();
                                }
                            })
                        }).fail(function() {

                        }).always(function() {
                            ASTool.removePageLoadingEffect();
                        })
                    }
                })
            }

            deleteAllItems() {
                let tool = ASTool;

                tool.confirm({
                    message: "Bạn có chắc chắn muốn xóa hết tất cả ghi chú đã chọn",
                    ok: () => {
                        tool.addPageLoadingEffect();

                        $.ajax({
                            url: "{{ action('\App\Http\Controllers\Marketing\NoteLogController@destroyAll') }}",
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                                noteIds: this.getNoteCheckedIds()
                            }
                        }).done(response => {
                            tool.alert({
                                message: response.message,
                                ok: () => {
                                    NoteList.getList().load();
                                    this.hideTopListActionBox();
                                    this.showSearchBoxes();
                                    this.showToolBoxes();
                                }
                            });
                        }).fail(() => {

                        }).always(() => {
                            tool.removePageLoadingEffect();
                        });
                    }
                });
            }





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

                $(this.container).find('[list-action="search-action-box"] i').on('click', (e) => {
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

                    if (event.key === 'Enter') {
                        this.load();
                    }
                });


                // on focus out of keyword input
                this.getSearchKeywordInput().addEventListener('keyup', (e) => {
                    this.load();
                });
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
                        key: this.getKeyword(),
                        customer_ids: this.getContactIds(),
                        account_id: this.getAccountId(),
                        sort_by: this.getSortBy(),
                        sort_direction: this.getSortDirection(),
                        page: this.page,
                        perpage: this.perpage,
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),

                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),

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
