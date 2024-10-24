@extends('layouts.main.app', [
    'menu' => 'sales',
])

@section('sidebar')
    @include('sales.modules.sidebar', [
        'menu' => 'accountKpiNote',
        'sidebar' => 'accountKpiNote',
    ])
@endsection
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Dự thu của Sales</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="../../demo5/dist/index.html" class="text-muted text-hover-primary">Trang
                        chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Báo cáo</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Dự thu</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
        <!--begin::Actions-->
        <div class="d-flex align-items-center py-1">
            <!--begin::Button-->
            <div class="d-flex align-items-center py-1 me-3">

                <!--begin::Button-->
                <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px"
                    id="buttonCreateAcountKpi">
                    <span class="material-symbols-rounded me-2">
                        add
                    </span>
                    Thêm dự thu
                </a>
                <!--end::Button-->
            </div>

            <button data-action="under-construction" list-action="create-constract "
                class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px d-none" id="buttonCreateConstract">
                <span class="material-symbols-rounded me-2">
                    add
                </span>
                Xuất file excel
            </button>
            <!--end::Button-->
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Post-->
    <!--begin::Post-->
    <div id="AccountKpiIndexContainer" class="post" id="kt_post">
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
                                    row-action="delete-all">

                                    <span class="menu-title">Xóa báo cáo đã chọn</span>
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

                <!--begin::Card title-->
                <div class="card-title" list-action="search-action-box">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                        <input list-action="keyword-input" type="text" data-kt-customer-table-filter="search"
                            class="form-control w-250px ps-12" placeholder="Nhập để tìm khách hàng" />
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
                                <button type="button" class="btn btn-outline btn-outline-default d-none"
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
                                            <div class="fs-4 text-dark fw-bold">Hiển thị theo
                                                cột</div>
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
                <div class="ccard-toolbar mb-0 w-100 d-flex justify-content-center" list-action="tool-action-box">
                    <div class="row w-100">

                        <div class="col-md-6 mb-5">
                            <label class="form-label">Khách hàng</label>
                            <div>
                                <select list-action="contact-select" class="form-select" data-control="select2"
                                    data-placeholder="Chọn khách hàng/liên hệ" data-allow-clear="true" multiple>
                                    <option value="all">Chọn tất cả</option>
                                    @php
                                        $contactIds = App\Models\AccountKpiNote::pluck('contact_id')->unique();
                                    @endphp

                                    @foreach ($contactIds as $contact)
                                        <option value="{{ $contact }}">
                                            {{ App\Models\Contact::find($contact)->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 mb-5 d-none">
                            <label class="form-label">Ngày dự thu (Từ - Đến)</label>
                            <div class="row" list-action="estimated_payment_date-select">
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="estimated_payment_date_from"
                                                placeholder="=asas" type="date" class="form-control"
                                                placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-outline">
                                        <div data-control="date-with-clear-button"
                                            class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" name="estimated_payment_date_to"
                                                placeholder="=asas" type="date" class="form-control"
                                                placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Content-->
            </div>
            <!--end::Menu 1-->
            <!--end::Filter-->
        </div>

        <div id="AccountKpiIndexListContent">
        </div>
    </div>
    <!--end::Post-->

    <script>
        $(function() { // document ready
            //
            AccountKpiIndex.init();
        });

        //
        var AccountKpiIndex = function() {
            return {
                init: function() {

                    // Create Campaign
                    CreateAccountKpiPopup.init();
                    // Update Campaign
                    UpdateAccountKpiPopup.init();


                    // list
                    AccountKpiList.init();

                    FilterData.init();

                    UploadAvatar.init();
                }
            };
        }();

        var UploadAvatar = {
            init: function() {
                $('input[name="avatar"]').on('change', function() {
                    var input = $(this);
                    var file = input[0].files[0];

                    if (file) {
                        var formData = new FormData();
                        formData.append('avatar', file);
                        var userId = {{ Auth::user()->id }};


                        formData.append('_token', '{{ csrf_token() }}');


                        $.ajax({
                            type: 'POST',
                            url: '/update-profile-picture/' + userId,
                            data: formData,

                            processData: false,
                            contentType: false,
                            success: function(response) {
                                ASTool.alert({
                                    message: response.message,
                                    ok: function() {
                                        // reload page
                                        location.reload();
                                    }
                                });
                            },
                            error: function(error) {

                                throw new Error(error);

                            }
                        });
                    }
                });
            }
        };



        //
        var CreateAccountKpiPopup = function() {
            var popupCreateRole;
            var buttonCreateRole;

            // show campaign modal
            var showCampaignModal = function() {
                popupCreateRole.load();
            };

            return {
                init: function() {
                    // create campaign popup
                    popupCreateRole = new Popup({
                        url: "{{ action('App\Http\Controllers\AccountKpiNoteController@create') }}",
                    });

                    // create campaign button
                    buttonCreateRole = document.getElementById('buttonCreateAcountKpi');

                    // click on create campaign button
                    buttonCreateRole.addEventListener('click', (e) => {
                        e.preventDefault();

                        // show create campaign modal
                        showCampaignModal();
                    });
                },

                getPopup: function() {
                    return popupCreateRole;
                }
            };
        }();

        var UpdateAccountKpiPopup = function() {
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
                    $('[list-action="contact-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        AccountKpiList.getList().setContactIds(selectedValues);
                        // load list
                        AccountKpiList.getList().load();
                    });

                    $('[list-action="estimated_payment_date-select"]').on('change', function() {
                        // Lấy giá trị từ cả hai trường input
                        var fromDate = $('[name="estimated_payment_date_from"]').val();
                        var toDate = $('[name="estimated_payment_date_to"]').val();

                        // Gửi phạm vi ngày tạo đến ReceiptList và tải lại danh sách
                        AccountKpiList.getList().setPaymentDateFrom(fromDate);
                        AccountKpiList.getList().setPaymentDateTo(toDate);
                        AccountKpiList.getList().load();
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

        //
        var AccountKpiList = function() {
            var list;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\AccountKpiNoteController@list') }}",
                        container: document.querySelector('#AccountKpiIndexContainer'),
                        listContent: document.querySelector('#AccountKpiIndexListContent'),
                    });
                    list.load();
                },

                getList: function() {
                    return list;
                }
            }
        }();

        //
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


                this.perpage;
                this.page;
                this.accountIds = [];

                //
                this.events();
            }

            setKeyword(keyword) {
                this.keyword = keyword;
            }

            getKeyword() {
                return this.keyword;
            }


            // Filter by account
            setAccountFilter(ids) {
                this.account_filter = ids;
            };
            getAccountFilter() {
                return this.account_filter;
            };
            getAccountId() {
                const selectedOptions = Array.from(this.getAccountSelectBox().selectedOptions);
                return selectedOptions.map(option => option.value);
            }
            getAccountSelectBox() {

                return this.container.querySelector('[list-control="account-select"]');
            }

            getFilterButton() {
                return document.getElementById('filterButton');
            }
            // lam cho sk click Filter
            getFilterActionBox() {
                return this.container.querySelector('[list-action="filter-action-box"]');
            }
            //
            getFilterIcon() {
                return document.getElementById('filterIcon');
            }

            // setAccountIds(ids) {

            //     this.accountIds = ids;
            // };

            // getAccountIds() {
            //     return this.accountIds;
            // };
            // Filter by lifecycle_saccounte
            setLifecycleSaccounte(lifecycleSaccounte) {
                this.lifecycle_saccounte = lifecycleSaccounte;
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


            // Filter by contacts
            setContactIds(contactIds) {
                this.contact_ids = contactIds;
            };

            getContactIds() {
                return this.contact_ids;
            };
            //Filter by payment_date_from
            setPaymentDateFrom(paymentDateFrom) {
                this.estimated_payment_date_from = paymentDateFrom;
            }
            getPaymentDateFrom() {
                return this.estimated_payment_date_from;
            };
            //payment_date_to
            setPaymentDateTo(paymentDateTo) {
                this.estimated_payment_date_to = paymentDateTo;
            }
            getPaymentDateTo() {
                return this.estimated_payment_date_to;
            };





            events() {
                // keyword input event. search when keyup
                this.getkeywordInput().addEventListener('keyup', (e) => {
                    this.setKeyword(this.getkeywordInput().value);

                    // enter key
                    if (event.keyword === "Enter") {
                        this.setUrl(this.initUrl);
                        this.load();

                    }
                });

                // on focus out of keyword input
                this.getkeywordInput().addEventListener('keyup', (e) => {
                    this.load();

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

            addLoadEffect() {
                this.listContent.classList.add('list-loading');

                // cho biết dữ liệu đang đc loader
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

            removeLoadEffect() {
                this.listContent.classList.remove('list-loading');

                // remove loader
                if (this.container.querySelector('[list-action="loader"]')) {
                    this.container.querySelector('[list-action="loader"]').remove();
                }
            }



            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
            }

            getCheckAllButton() {
                return this.listContent.querySelector('[list-action="check-all"]');
            }

            getListCheckboxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]');
            }

            checkedCount() {
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked').length;
            }

            getTopListActionBox() {
                return this.listContent.querySelector('[list-action="top-action-box"]');
            }

            getDeleteButtons() {
                return this.listContent.querySelectorAll('[row-action="delete"]');
            }

            getUpdateButtons() {
                return this.listContent.querySelectorAll('[row-action="update"]');
            }

            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            }

            setUrl(url) {
                this.url = url;
            }

            // Sort by
            setSortBy(sortBy) {
                this.sort_by = sortBy;
            };

            getSortBy() {
                return this.sort_by;
            };

            // Sort direction
            setSortDirection(sortDirection) {
                this.sort_direction = sortDirection;
            };

            getSortDirection() {
                return this.sort_direction;
            };


            //pagination
            setPerpage(perpage) {
                this.perpage = perpage;
            };

            setPage(page) {
                this.page = page;
            };

            getDeleteAllItemBtn() {
                return document.querySelector('[row-action="delete-all"]');
            };

            getCheckAllBtn() {
                return this.listContent.querySelector('[list-action="check-all"]');
            };

            initContentEvents() {

                SortManager.init(this);
                // when list content has items
                if (this.getListItemsCount()) {

                    //làm cho cái pagination ajax
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

                    //Pagination per page
                    $('#perPage').change(() => {
                        const perPage = $('#perPage').val();
                        this.setPerpage(perPage);
                        this.setPage(1);
                        this.load();
                    });

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


                    /**
                     * DELETE 1 item
                     */
                    this.getDeleteButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');

                            // delete item
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

                    // Nút chỉnh sửa từng items sau load list content
                    this.getUpdateButtons().forEach(button => {
                        button.addEventListener('click', e => {
                            e.preventDefault();

                            let btnUrl = button.getAttribute('href'); // Get URL in each update button

                            UpdateAccountKpiPopup.updateUrl(btnUrl);
                        })

                        // button.addEventListener('click', (e) => {
                        //     e.preventDefault();

                        //     var url = button.getAttribute('href');

                        //     var popup = new Popup({
                        //         url: url
                        //     });
                        //     popup.load();
                        // });
                    });

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
                    message: 'Bạn có chắc chắn muốn xóa dự thu này chứ?',
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
                                    AccountKpiList.getList().load();
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
            deleteAllItems() {
                let tool = ASTool;

                tool.confirm({
                    message: "Bạn có chắc chắn muốn xóa hết tất cả báo cáo đã chọn",
                    ok: () => {
                        tool.addPageLoadingEffect();

                        $.ajax({
                            url: "{{ action('\App\Http\Controllers\AccountKpiNoteController@destroyAll') }}",
                            method: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}",
                                noteIds: this.getNoteCheckedIds()
                            }
                        }).done(response => {
                            tool.alert({
                                message: response.message,
                                ok: () => {
                                    AccountKpiList.getList().load();
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
            updateCountLabel() {
                this.container.querySelector('[list-control="count-note-selected-label"]').innerHTML =
                    'Đã chọn <strong>' + this
                    .checkedCount() + '</strong> báo cáo';
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
            showToolBoxes() {
                this.getToolBoxes().classList.remove('d-none');
            }
            hideToolBoxes() {
                this.getToolBoxes().classList.add('d-none');
            }
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

            //nut check all button
            getCheckAllButton() {
                if (!this.listContent.querySelector('[list-action="check-all"]')) {
                    throw new Error("Bug: check all button not found!");
                }
                return this.listContent.querySelector('[list-action="check-all"]');
            }

            //xóa 1 item trong list
            getDeleteButtons() {
                return this.listContent.querySelectorAll('[row-action="delete"]');
            }

            // Nút chỉnh sửa từng items sau load list content
            getUpdateButtons() {
                return this.listContent.querySelectorAll('[row-action="update"]');
            }

            //pagination ajax
            getContentPageLinks() {
                return this.listContent.querySelectorAll('a.page-link');
            }

            getkeywordInput() {
                return this.container.querySelector('[list-action="keyword-input"]');
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


            //lấy id các mục dã chọn
            getSelectedIds() {
                const ids = [];

                this.getListCheckedBoxes().forEach((checkbox) => {
                    ids.push(checkbox.value);
                });

                return ids;
            }

            getListCheckedBoxes() {
                return this.listContent.querySelectorAll('[list-action="check-item"]:checked');
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

            load() {
                this.addLoadEffect();

                // ajax request list via url
                if (this.listXhr) {
                    this.listXhr.abort();
                }
                this.listXhr = $.ajax({
                    url: this.url,
                    method: "GET",
                    data: {
                        keyword: this.getKeyword(),
                        sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),

                        per_page: this.getPerPage(),

                        //Filter Create Date
                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),

                        //Filter Update Date
                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),

                        //
                        account_filter: this.getAccountFilter(),
                        contact_ids: this.getContactIds(),

                        estimated_payment_date_from: this.getPaymentDateFrom(),
                        estimated_payment_date_to: this.getPaymentDateTo(),



                    }
                }).done((content) => {
                    this.loadContent(content);

                    //
                    this.initContentEvents();

                    // 
                    this.removeLoadEffect();


                    // apply

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
