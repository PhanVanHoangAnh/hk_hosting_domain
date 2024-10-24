@extends('layouts.main.app', [
    'menu' => 'marketing',
])

@section('sidebar')
    @include('marketing.modules.sidebar', [
        'menu' => 'contact-lists',
    ])
@endsection


@section('content')
<!--begin::Toolbar-->
<div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
    <!--begin::Page title-->
    <div class="page-title d-flex flex-column py-1">
        <!--begin::Title-->
        <h1 class="d-flex align-items-center my-1">
            <span class="text-dark fw-bold fs-1">Danh Sách hợp đồng</span>
        </h1>
        <!--end::Title-->
        <!--begin::Breadcrumb-->
        <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">
                <a href="{{ action([App\Http\Controllers\Marketing\DashboardController::class, 'index']) }}" class="text-muted text-hover-primary">Trang chính</a>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-muted">Quản lý hợp đồng</li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item">
                <span class="bullet bg-gray-200 w-5px h-2px"></span>
            </li>
            <!--end::Item-->
            <!--begin::Item-->
            <li class="breadcrumb-item text-dark">Danh sách hợp đồng</li>
            <!--end::Item-->
        </ul>
        <!--end::Breadcrumb-->
    </div>
    <!--end::Page title-->
    <!--begin::Actions-->
    <div class="d-flex align-items-center py-1">

        <!--begin::Button-->
        <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" id="buttonCreateCampaign">
            <i class="ki-duotone ki-abstract-10">
                <i class="path1"></i>
                <i class="path2"></i>
            </i>
            Thêm hợp đồng
        </a>
        <!--end::Button-->
    </div>
    <!--end::Actions-->
</div>
<!--end::Toolbar-->
<!--begin::Post-->
<div id="ContactsIndexContainer" class="post" id="kt_post">
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Group actions-->
            <div list-action="top-action-box" class="d-flex justify-content-end align-items-center d-none">
                <div class="fw-bold me-5">
                    <span class="me-2" data-kt-customer-table-select="selected_count"></span>Selected
                </div>
                <button type="button" class="btn btn-danger" data-kt-customer-table-select="delete_selected">Delete
                    Selected</button>
            </div>
            <!--end::Group actions-->
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <i class="ki-duotone ki-magnifier fs-3 position-absolute ms-5">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                    <input list-action="keyword-input" type="text" data-kt-customer-table-filter="search"
                        class="form-control w-250px ps-12" placeholder="Nhập để tìm hợp đồng" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-outline btn-outline-default px-9" data-kt-menu-trigger="click"
                        data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-filter fs-2">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>Lọc</button>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true"
                        id="kt-toolbar-filter">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-4 text-dark fw-bold">Tùy Chọn Bộ Lọc</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Separator-->
                        <!--begin::Content-->
                        <div class="px-7 py-5">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fs-5 fw-semibold mb-3">Tên hợp đồng:</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select list-action="contact-select" data-dropdown-parent="#kt-toolbar-filter"
                                    class="form-select" data-control="select2"
                                    data-close-on-select="false" data-placeholder="Chọn khách hàng/liên hệ"
                                    data-allow-clear="true" multiple="multiple">
                                    <option value="all">Chọn tất cả</option>
                                    @forEach(App\Models\ContactList::all() as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->name }}</option>
                                    @endforeach
                                </select>
                                <!--end::Input-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <!--begin::Label-->
                                <label class="form-label fs-5 fw-semibold mb-3">Người Tạo:</label>
                                <!--end::Label-->
                                <!--begin::Options-->
                                <div class="d-flex flex-column flex-wrap fw-semibold"
                                    data-kt-customer-table-filter="payment_type">
                                    <!--begin::Option-->
                                    <label
                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                        <input class="form-check-input" type="radio" name="payment_type" value="all"
                                            checked="checked" />
                                        <span class="form-check-label text-gray-600">Tất Cả</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label
                                        class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                        <input class="form-check-input" type="radio" name="payment_type" value="visa" />
                                        <span class="form-check-label text-gray-600">Quản Lý</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="radio" name="payment_type"
                                            value="mastercard" />
                                        <span class="form-check-label text-gray-600">Nhân Viên</span>
                                    </label>
                                    <!--end::Option-->
                                    <!--begin::Option-->
                                    <label class="form-check form-check-sm form-check-custom form-check-solid">
                                        <input class="form-check-input" type="radio" name="payment_type"
                                            value="american_express" />
                                        <span class="form-check-label text-gray-600">Nhân Viên 2</span>
                                    </label>
                                    <!--end::Option-->
                                </div>
                                <!--end::Options-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary me-2"
                                    data-kt-menu-dismiss="true" data-kt-customer-table-filter="reset">Hủy</button>
                                <button type="submit" id="filter-by-conditions-btn" class="btn btn-primary"
                                    data-kt-menu-dismiss="true" data-kt-customer-table-filter="filter">Áp Dụng</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->


        <div id="ContactsIndexListContent">
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
                        <h2 class="fw-bold">Export Tags</h2>
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
                                        <input class="form-check-input" type="checkbox" value="3" name="payment_type" />
                                        <span class="form-check-label text-gray-600 fw-semibold">Mastercard</span>
                                    </label>
                                    <!--end::Radio button-->
                                    <!--begin::Radio button-->
                                    <label class="form-check form-check-custom form-check-sm form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="4" name="payment_type" />
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
    <!--end::Post-->

    <script>
    $(function() { // document ready
        //
        ContactsIndex.init();
    });

    //
    var ContactsIndex = function() {
        return {
            init: function() {
                // Create Campaign
                CreateCampaignPopup.init();
                // Update Campaign
                UpdateCampaignPopup.init();

                SelectContactsEvent.init();
                // list
                ContactsList.init();
            }
        };
    }();

    //
    var CreateCampaignPopup = function() {
        var popupCreateCampaign;
        var buttonCreateCampaign;

        // show campaign modal
        var showCampaignModal = function() {
            popupCreateCampaign.load();
        };

        return {
            init: function() {
                // create campaign popup
                popupCreateCampaign = new Popup({
                    url: "{{ action('App\Http\Controllers\Marketing\ContactListController@create') }}",
                });

                // create campaign button
                buttonCreateCampaign = document.getElementById('buttonCreateCampaign');

                // click on create campaign button
                buttonCreateCampaign.addEventListener('click', (e) => {
                    e.preventDefault();

                    // show create campaign modal
                    showCampaignModal();
                });
            },

            getPopup: function() {
                return popupCreateCampaign;
            }
        };
    }();
    var UpdateCampaignPopup = function() {
        var popupUpdateCampaign;

        return {
            init: function(updateUrl) {
                // Khởi tạo popup chỉnh sửa chiến dịch
                popupUpdateCampaign = new Popup({
                    url: updateUrl, // Sử dụng URL được chuyền vào từ tham số
                });
            },
            showUpdateCampaignModal: function() {
                // Hiển thị cửa sổ popup chỉnh sửa 
                this.popupUpdateCampaign.load();
            },


            getPopup: function() {
                return popupUpdateCampaign;
            },

        };
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
    var ContactsList = function() {
        var list;

        return {
            init: function() {
                list = new DataList({
                    url: "{{ action('\App\Http\Controllers\Marketing\ContactListController@list') }}",
                    container: document.querySelector('#ContactsIndexContainer'),
                    listContent: document.querySelector('#ContactsIndexListContent'),
                });
                list.load();
            },

            getList: function() {
                return list;
            }
        }
    }();
    const SelectContactsEvent = function() {
        return {
            init: function() {
                $('[list-action="contact-select"]').on('change', function() {
                    const selectedOptions = Array.from(this.selectedOptions).map(option => option
                        .value);

                    if ($(this).val() && $(this).val().includes('all')) {
                        $(this).find('option').not(':selected').prop('selected', true);
                    }
                });
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

            this.url = options.url;
            this.container = options.container;
            this.listContent = options.listContent;
            this.keyword;

            //
            this.events();
        }

        setKeyword(keyword) {
            this.keyword = keyword;
        }

        getKeyword() {
            return this.keyword;
        }

        events() {
            // keyword input event. search when keyup
            this.getkeywordInput().addEventListener('keyup', (e) => {
                this.setKeyword(this.getkeywordInput().value);

                // enter key
                if (event.key === "Enter") {
                    // 
                    this.load();
                }
            });

            // on focus out of keyword input
            this.getkeywordInput().addEventListener('change', (e) => {
                this.load();
            });

        }

        addLoadEffect() {
            this.listContent.classList.add('list-loading');

            // cho biết dữ liệu đang đc loader
            if (!this.container.querySelector('[list-action="loader"]')) {
                $(this.listContent).before(
                    `
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

        getkeywordInput() {
            return this.container.querySelector('[list-action="keyword-input"]');
        }

        getContentPageLinks() {
            return this.listContent.querySelectorAll('a.page-link');
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

        initContentEvents() {

            SortManager.init(this);
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

                        if (checked) {
                            // show top list action box
                            this.showTopListActionBox();
                        } else {
                            // hide top list action box
                            this.hideTopListActionBox();
                        }
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


                // khi mà click vào cái nut check all ở table list header
                this.getCheckAllButton().addEventListener('change', (e) => {
                    var checked = this.getCheckAllButton().checked;

                    if (checked) {
                        // show top list action box
                        this.showTopListActionBox();
                    } else {
                        // hide top list action box
                        this.hideTopListActionBox();
                    }
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

                        alert(url);
                        var popup = new Popup({
                            url: url
                        });
                        popup.load();
                    });
                });
            }
        }

        deleteItem(url) {
            // success alert
            ASTool.confirm({
                message: 'Are you sure you want to delete this contact',
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
                                ContactsList.getList().load();
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

        showTopListActionBox() {
            this.getTopListActionBox().classList.remove('d-none');
        }

        hideTopListActionBox() {
            this.getTopListActionBox().classList.add('d-none');
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
                data: {
                    keyword: this.getKeyword(),
                    sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),
                }
            }).done((content) => {
                this.loadContent(content);

                //
                this.initContentEvents();

                // 
                this.removeLoadEffect();
            }).fail(function() {

            });
        }
        getPerPageSelectBox() {
                return this.listContent.querySelector('[list-control="per-page"]');
            }
    }
    </script>
    @endsection