@extends('layouts.main.app', [
    'menu' => 'marketing',
])

@section('sidebar')
    @include('marketing.modules.sidebar', [
        'menu' => 'contact_request',
        'sidebar' => 'contact_request',
        // 'status' => 'all'
    ])
@endsection
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh sách đơn hàng</span>
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
                <li class="breadcrumb-item text-muted">Đơn hàng</li>
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
            @if (Auth::user()->can('exportContactRequest', \App\Models\Contact::class)) 
            <div class="me-3" list-action="export-contact">
                <a type="button"
                    href="{{ action([\App\Http\Controllers\Marketing\ContactRequestController::class, 'showFilterForm']) }}"
                    class="btn btn-outline btn-outline-default btn-menu " data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">
                    <span class="d-flex align-items-center">
                        <span class="material-symbols-rounded me-2">
                            export_notes
                        </span>
                        <span>Xuất dữ liệu</span>
                    </span>
                </a>

                <!--end::Menu link-->
            </div>
            @endif
            <!--end::Button-->
            <div class="dropdown d-none">
                <!--begin::Menu-->
                <div class="menu menu-rounded menu-column menu-gray-600 menu-state-bg fw-semibold  me-3"
                    data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item" data-kt-menu-trigger="hover" data-kt-menu-placement="bottom-start">
                        <!--begin::Menu link-->
                        <a href="{{ action([App\Http\Controllers\Marketing\ImportController::class, 'index']) }}" class="btn btn-outline btn-outline-default">
                            <span class="d-flex align-items-center">
                                <span class="material-symbols-rounded me-2">
                                    deployed_code_update
                                </span>
                                <span>Nhập dữ liệu</span>
                            </span>
                        </a>
                        <!--end::Menu link-->

                        <!--begin::Menu sub-->
                        <div class="menu-sub menu-sub-dropdown p-3 w-150px d-none">

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="#" id="buttonExcel" class="menu-link px-3">
                                    <span class="menu-bullet me-0">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Excel</span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a  href="#"
                                    id="buttonHubSpot" class="menu-link px-3">
                                    <span class="menu-bullet me-0">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">HubSpot</span>
                                </a>
                            </div>
                            <!--end::Menu item-->


                        </div>
                        <!--end::Menu sub-->
                    </div>
                    <!--end::Menu item-->

                </div>
                <!--end::Menu-->
            </div>

            @if (Auth::user()->can('create', App\Models\ContactRequest::class))
                <!--begin::Button-->
                <a href="#" class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-45px"
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
                            CreateContactRequestPopup.getPopup().load();
                        });
                    });
                </script>
            @endif
            
        </div>
        <!--end::Actions-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div id="ContactRequestsIndexContainer" class="position-relative" id="kt_post">
        <!--begin::Card-->
        <div class="card ">
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
                        <div class="menu-sub menu-sub-dropdown p-3 w-200px">
                            <!--begin::Menu item-->
                            <div class="menu-item d-none">
                                <a href="#" class="menu-link px-3">

                                    <span data-kt-contact-table-select="selected_count" class="menu-title "
                                        id="buttonsEditTags">Thêm Tag</span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item d-none">
                                <a href="#" class="menu-link px-3" data-kt-contact-table-select="delete_selected"
                                    row-action="handover-contacts" id="buttonsDeleteTags">
                                    <span class="menu-title">Xóa tag</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="#" class="menu-link px-3" data-kt-contact-table-select="delete_selected"
                                    row-action="handover-contacts" id="buttonHandoverContactRequests">
                                    <span class="menu-title">Bàn giao nhân viên sale</span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <!--begin::Menu item-->
                            <div class="menu-item">
                                <a href="#" data-action="under-construction" class="menu-link px-3 d-none"
                                    data-kt-contact-table-select="export_selected" row-action="handover-contacts"
                                    id="buttonExportContactRequests">
                                    <span class="menu-title">Xuất đơn hàng đang chọn</span>
                                </a>
                            </div>
                            <!--end::Menu item-->

                            <div class="menu-item">
                                <a row-action="delete-all"
                                    href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'deleteAll']) }}"
                                    class="menu-link px-3" list-action="sort">Xóa</a>
                            </div>

                        </div>
                        <!--end::Menu sub-->
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
                                        <option value="{{ $tag->id }}" id="tag_{{ $tag->id }}"
                                            for="tag_{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <label class="form-label">Liên hệ/Khách hàng</label>
                            <select list-action="contact-select" id="contact-select" data-control="select2-ajax"
                                data-url="{{ action('App\Http\Controllers\Marketing\ContactController@select2') }}"
                                class="form-control" name="contact" data-placeholder="Chọn khách hàng/liên hệ..."
                                data-allow-clear="true">
                                <option value="">Chọn khách hàng/liên hệ</option>
                                @if (request()->contact_id)
                                    @php
                                        $contact = App\Models\Contact::find(request()->contact_id);
                                    @endphp
                                    <option value="{{ $contact->id }}" selected>
                                        {!! '<strong>' . $contact->name . '</strong><br>' . $contact->email !!}
                                    </option>
                                @endif
                            </select>
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
                                        <option value="{{ $source_type }}">{{ trans('messages.contact_request.source_type.' . $source_type) }} </option>
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
                                    data-kt-select2="true" data-placeholder="Chọn life cycle stage"
                                    data-allow-clear="true">
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
                                <select list-action="lifecycle-stage-sub-select" class="form-select"
                                    data-kt-select2="true" data-control="select2" data-placeholder="Chọn lead status"
                                    multiple>
                                    
                                    @foreach (config('leadStatuses') as $lstatus)
                                        <option value="{{ $lstatus }}">{{ trans('messages.contact_request.lead_status.' . $lstatus) }}</option>
                                    @endforeach
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
                                            <input data-control="input" name="created_at_to" placeholder="=asas"
                                                type="date" class="form-control" placeholder="" />
                                            <span data-control="clear" class="material-symbols-rounded clear-button"
                                                style="display:none;">close</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Nhập từ:</label>
                            <!--end::Label-->
                            <div>
                                <select list-filter="added-from" class="form-select" data-control="select2"
                                    data-kt-select2="true" data-placeholder="Chọn"
                                    data-allow-clear="true">
                                    <option></option>
                                    @foreach ([
                                        App\Models\Contact::ADDED_FROM_SYSTEM,
                                        App\Models\Contact::ADDED_FROM_HUBSPOT,
                                        App\Models\Contact::ADDED_FROM_EXCEL,
                                        App\Models\Contact::ADDED_FROM_GOOGLE_SHEET,
                                    ] as $from)
                                        <option value="{{ $from }}">{{ trans('messages.contact.added_from.' . $from) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Google Sheet ID:</label>
                            <!--end::Label-->
                            <div>
                                <select list-filter="google-sheet-id" class="form-select" data-control="select2"
                                    data-kt-select2="true" data-placeholder="Chọn"
                                    data-allow-clear="true">
                                    <option></option>
                                    @foreach (\App\Library\GoogleSheetImporter::getAll() as $importer)
                                        <option value="{{ $importer->sheetId }}">{{ $importer->getName() }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">Trường:</label>
                            <!--end::Label-->
                            <div>
                                <select multiple id="school-select" name="schools[]" data-control="select2-ajax" data-url="{{ action('App\Http\Controllers\Marketing\ContactRequestController@schoolSelect2') }}" class="form-control">
                                    
                                </select>
                                <style>
                                    #school-select + .select2-container .select2-selection__clear {
                                        display: none !important;
                                    }
                                </style>
                            </div>
                        </div>
                        
                        <div class="col-md-3 mb-5">
                            <!--begin::Label-->
                            <label class="form-label fw-semibold ">List</label>
                            <!--end::Label-->
                            <div>
                                @php
                                    $uniqueList = App\Models\ContactRequest::whereNotNull('list')
                                        ->where('list','!=', '')
                                        ->pluck('list')->unique();
                                @endphp
                                <select list-action="list-select" class="form-select" data-control="select2"
                                    data-placeholder="Chọn list" multiple="multiple" data-allow-clear="true">
                                    @foreach ($uniqueList as $list)
                                        <option value="{{ $list }}">{{ $list }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!--end::Actions-->
                    </div>

                    <!--end::Menu 1-->
                    <!--end::Filter-->
                </div>
                <!--end::Toolbar-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <div id="ContactRequestsIndexListContent">
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
                        <h2 class="fw-bold">Export ContactRequests</h2>
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
        $(function() {
            //
            ContactRequestsIndex.init();
        });

        //
        var ContactRequestsIndex = function() {
            return {
                init: function() {
                    // ColumnsDisplayManager
                    ContactRequestColumnManager.init();

                    @if (Auth::user()->can('create', App\Models\ContactRequest::class))
                        // Create ContactRequest
                        CreateContactRequestPopup.init();
                    @endif
                    ExportContactRequestSelectedPopup.init();
                    //Excel
                    ExcelPopup.init();
                    excelHandle.init();
                    // Update ContactRequest
                    UpdateContactRequestPopup.init();
                    // list
                    ContactRequestsList.init();

                    //filter
                    FilterData.init();
                    //Bàn giao nhân viên
                    HandoverContactRequestPopup.init();
                    //Bàn giao nhân viên hàng loạt
                    HandoverContactRequestsPopup.init();
                    //Xóa nhiều tag 1 lần 
                    DeleteTagsPopup.init();
                    //Edit nhiều tags 1 lần
                    EditTagsPopup.init();
                    
                    //HubSpot
                    HubSpotPopup.init();
                    // displayColumnUpDown();
                    NodeLogsContactPopup.init();
                    //export
                    ExportContactRequestHandle.init();


                }
            };
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
                    popupNodeLogsContact.load(); // Hiển thị cửa sổ chỉnh sửa
                },

                getPopup: function() {
                    return popupNodeLogsContact;
                }
            };
        }();

        var ExportContactRequestSelectedPopup = function() {
            var popupExportContactRequests;
            var buttonExportContactRequests;
            var contactRequestIds = [];

            var showHandoverContactRequests = function() {
                // gán cái data để khi popup load thì truyền data này theo
                popupExportContactRequests.setData({
                    contact_request_ids: ContactRequestsList.getList().getSelectedIds(),
                });

                popupExportContactRequests.load();
            };

            var handleHandoverButtonClick = function() {
                buttonExportContactRequests.addEventListener('click', (e) => {
                    e.preventDefault();

                    showHandoverContactRequests();
                })
            };

            return {
                init: function() {
                    // init
                    popupExportContactRequests = new Popup({
                        url: "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@exportContactRequestSelected') }}",
                    });
                    buttonExportContactRequests = document.getElementById('buttonExportContactRequests');

                    // events
                    handleHandoverButtonClick();
                },
                getPopup: function() {
                    return popupExportContactRequests;
                }
            }

        }();

        var ExportContactRequestHandle = function() {
            var popupExportContactRequest;

            // show campaign modal
            var showExportModal = function() {
                popupExportContactRequest.load();
            };

            return {
                init: function() {
                    // create campaign popup
                    popupExportContactRequest = new Popup({
                        url: "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@showFilterForm') }}",
                    });

                    // create campaign button
                    var buttonCreateExportList = document.querySelectorAll('[list-action="export-contact"]');

                    // Add click event listener to each button
                    buttonCreateExportList.forEach(function(buttonCreateExport) {
                        buttonCreateExport.addEventListener('click', function(e) {
                            e.preventDefault();

                            // show create campaign modal
                            showExportModal();
                        });
                    });
                },

                getPopup: function() {
                    return popupExportContactRequest;
                }
            };
        }();


        var ContactRequestColumnManager = function() {
            var manager;

            return {
                init: function() {
                    manager = new ColumnsDisplayManagerClass({
                        name: '{{ $listViewName }}',
                        saveUrl: '{{ action([App\Http\Controllers\UserController::class, 'saveListColumns']) }}',
                        columns: {!! json_encode($columns) !!},
                        optionsBox: document.querySelector('[columns-control="options-box"]'),
                        getList: function() {
                            return ContactRequestsList.getList();
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

        var HubSpotPopup = function() {
            var popupHubSpot;
            var buttonHubSpot;
            var handleHubSpot = function() {
                buttonHubSpot.addEventListener('click', (e) => {
                    e.preventDefault();
                    popupHubSpot.load();
                })
            }
            return {
                init: function() {
                    popupHubSpot = new Popup({
                        url: "{{ action('\App\Http\Controllers\HubSpotController@index') }}",
                    });
                    buttonHubSpot = document.getElementById('buttonHubSpot');
                    handleHubSpot();
                },
                getPopup: function() {
                    return popupHubSpot;
                }

            }
        }();


        //edit nhiều handover 1 lần 
        var HandoverContactRequestsPopup = function() {
            var popupHandoverContactRequests;
            var buttonHandoverContactRequests;
            var contactRequestIds = [];

            var showHandoverContactRequests = function() {
                // gán cái data để khi popup load thì truyền data này theo
                popupHandoverContactRequests.setData({
                    contact_request_ids: ContactRequestsList.getList().getSelectedIds(),
                });

                popupHandoverContactRequests.load();
            };

            var handleHandoverButtonClick = function() {
                buttonHandoverContactRequests.addEventListener('click', (e) => {
                    e.preventDefault();

                    showHandoverContactRequests();
                })
            };

            return {
                init: function() {
                    // init
                    popupHandoverContactRequests = new Popup({
                        url: "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@addHandoverBulk') }}",
                    });
                    buttonHandoverContactRequests = document.getElementById('buttonHandoverContactRequests');

                    // events
                    handleHandoverButtonClick();
                },
                getPopup: function() {
                    return popupHandoverContactRequests;
                }
            }

        }();
        //Edit nhiều tags 1 lần
        var EditTagsPopup = function() {
            var popupEditTags;
            var buttonsEditTags;
            var contactRequestIds = [];
            var showEditTags = function() {
                popupEditTags.setData({
                    contact_request_ids: ContactRequestsList.getList().getSelectedIds(),
                });

                popupEditTags.load();
            };
            var handleEditTagsButtonClick = function() {
                buttonsEditTags.addEventListener('click', (e) => {
                    e.preventDefault();

                    showEditTags();
                })
            };
            return {
                init: function() {
                    popupEditTags = new Popup({
                        url: "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@addTagsBulk') }}",
                    });
                    buttonsEditTags = document.getElementById('buttonsEditTags');
                    handleEditTagsButtonClick();
                },
                getPopup: function() {
                    return popupEditTags;
                }
            }
        }();
        //delete tags in contacts
        var DeleteTagsPopup = function() {
            var popupDeleteTags;
            var buttonsDeleteTags;
            var contactRequestIds = [];
            var showDeleteTags = function() {
                popupDeleteTags.setData({
                    contact_request_ids: ContactRequestsList.getList().getSelectedIds(),
                });

                popupDeleteTags.load();
            };
            var handleDeleteTagsButtonClick = function() {
                buttonsDeleteTags.addEventListener('click', (e) => {
                    e.preventDefault();

                    showDeleteTags();
                })
            };
            return {
                init: function() {
                    popupDeleteTags = new Popup({
                        url: "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@deleteTags') }}",
                    });
                    buttonsDeleteTags = document.getElementById('buttonsDeleteTags');
                    handleDeleteTagsButtonClick();
                },
                getPopup: function() {
                    return popupDeleteTags;
                }
            }

        }();

        var ExcelPopup = function() {
            var popupExcelImport;
            var buttonExcelImport;
            var showExcelImportModal = function() {
                popupExcelImport.load();
            };

            return {
                init: function() {
                    excelPopup = new Popup();
                },
                updateUrl: (newUrl, method, token, data) => {

                    excelPopup.url = newUrl;
                    excelPopup.method = !method ? null : method;
                    excelPopup.header = !token ? null : {
                        'X-CSRF-TOKEN': token
                    };

                    excelPopup.data = !data ? null : data;
                    excelPopup.load();
                },
                updateUrlImportFile: (newUrl, method, token, data) => {

                    excelPopup.url = newUrl;
                    excelPopup.method = !method ? null : method;
                    excelPopup.header = !token ? null : {
                        'X-CSRF-TOKEN': token
                    };
                    excelPopup.data = !data ? null : data;
                    excelPopup.loadExcelFile();
                },
                updateUrlSaveDatas: (newUrl, method, token, data) => {

                    excelPopup.url = newUrl;
                    excelPopup.method = !method ? null : method;
                    excelPopup.header = !token ? null : {
                        'X-CSRF-TOKEN': token
                    };
                    excelPopup.data = !data ? null : data;
                    excelPopup.loadJsonData();
                    // ContactsList.getList().load();
                },
                getPopup: function() {
                    return excelPopup;
                },
                hidePopup: () => {
                    excelPopup.hide();
                }
            };
        }();

        const excelHandle = function() {
            let buttonExcelImport;
            let importExcelDataForm;

            return {
                init: () => {
                    if (document.querySelector('#buttonExcel')) {
                        buttonExcelImport = document.querySelector('#buttonExcel');
                        buttonExcelImport.addEventListener('click', e => {
                            e.preventDefault();

                            ExcelPopup.updateUrl(
                                "{{ action('\App\Http\Controllers\Marketing\ContactController@importExcel') }}"
                            );
                        });
                    }

                }
            };
        }();

        //
        var UpdateContactRequestPopup = function() {
            var popupUpdateContactRequest;
            return {
                init: function(updateUrl) {
                    // Khởi tạo popup chỉnh sửa chiến dịch
                    popupUpdateContactRequest = new Popup({
                        url: updateUrl, // Sử dụng URL được truyền vào từ tham số
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

        var HandoverContactRequestPopup = function() {
            var popupHandoverContactRequest;
            return {
                init: function(updateUrl) {
                    // create campaign popup
                    popupHandoverContactRequest = new Popup({
                        url: updateUrl,

                    });
                },
                load: function(url) {
                    popupHandoverContactRequest.url = url;
                    popupHandoverContactRequest.load(); // Hiển thị cửa sổ chỉnh sử
                },

                getPopup: function() {
                    return popupHandoverContactRequest;
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

            // Contact select handle
            var handleContactSelect = function() {
                // init value
                var currentContactId = $('[list-action="contact-select"]').val();

                if (currentContactId) {
                    ContactRequestsList.getList().setContactId(currentContactId);
                    if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();

                    // open filter
                    ContactRequestsList.getList().showFilterActionBox();
                }

                // events
                $('[list-action="contact-select"]').on('change', function() {
                    var contactId = $(this).select2('val');

                    // Gửi phạm vi ngày tạo đến ContactRequestsList và tải lại danh sách
                    ContactRequestsList.getList().setContactId(contactId);

                    if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                });
            };

            return {
                init: () => {
                    $('[list-action="marketing-type-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        ContactRequestsList.getList().setMarketingType(selectedValues);

                        // load list
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });

                    $('[list-action="marketing-school-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        ContactRequestsList.getList().setMarketingSchool(selectedValues);

                        // load list
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });
                   
                    $('[list-action="marketing-source-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        ContactRequestsList.getList().setMarketingSource(selectedValues);

                        // load list
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });

                    $('[list-action="marketing-source-sub-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        ContactRequestsList.getList().setMarketingSourceSub(selectedValues);

                        // load list
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });

                    $('[list-action="lifecycle-stage-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        ContactRequestsList.getList().setLifecycleStage(selectedValues);

                        // load list
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });

                    $('[list-action="lifecycle-stage-sub-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        ContactRequestsList.getList().setLeadStatus(selectedValues);

                        // load list
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });

                    $('[list-action="salesperson-select"]').on('change', function() {
                        var selectedValues = getSelectedValuesFromMultiSelect($(this)[0]);

                        ContactRequestsList.getList().setSalespersonIds(selectedValues);

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

                    // added from filrer
                    $('[list-filter="added-from"]').on('change', function() {
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });

                    // google sheet id
                    $('[list-filter="google-sheet-id"]').on('change', function() {
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });

                    // schools
                    $('[name="schools[]"]').on('change', function() {
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });

                    // list
                    $('[list-action="list-select"]').on('change', function() {
                        if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                    });

                    // contact id
                    handleContactSelect();
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

        var ContactRequestsList = function() {
            var list;
            var resetUrl;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@list') }}",
                        container: document.querySelector('#ContactRequestsIndexContainer'),
                        listContent: document.querySelector(
                            '#ContactRequestsIndexListContent'),

                        @if ($status)
                            status: '{{ $status }}',
                        @endif
                        @if (request()->lead_status_menu)
                            lead_status_menu: '{{ request()->lead_status_menu }}',
                        @endif
                        @if (request()->lifecycle_stage_menu)
                            lifecycle_stage_menu: '{{ request()->lifecycle_stage_menu }}',
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

                // lead status
                this.lead_status_menu;
                if (typeof(options.lead_status_menu) !== 'undefined') {
                    this.lead_status_menu = options.lead_status_menu;
                }
                this.lifecycle_stage_menu;
                if (typeof(options.lifecycle_stage_menu) !== 'undefined') {
                    this.lifecycle_stage_menu = options.lifecycle_stage_menu;
                }

                //
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

            setKeyword(keyword) {
                this.keyword = keyword;
            }

            getKeyword() {
                return this.keyword ?? '';
            }

            events() {
                // on focus out of keyword input
                this.getkeywordInput().addEventListener('keyup', (e) => {
                    if (e.key === "Enter") {
                        this.setKeyword(this.getkeywordInput().value);

                        if (this.timeoutEvent) {
                            clearTimeout(this.timeoutEvent);
                        }

                        this.timeoutEvent = setTimeout(() => {
                            this.setUrl(this.initUrl);
                            this.load();
                        }, 500);

                        
                        return;
                    }

                    if (this.getKeyword().trim() == this.getkeywordInput().value.trim()) {
                        return;
                    }

                    this.setKeyword(this.getkeywordInput().value);

                    if (this.timeoutEvent) {
                        clearTimeout(this.timeoutEvent);
                    }
                    this.timeoutEvent = setTimeout(() => {
                        this.setUrl(this.initUrl);
                        this.load();
                    }, 1500);
                });

                $(this.container).find('[list-action="search-action-box"] i').on('click', (e) => {
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

            // Filter by source_types
            setMarketingType(marketingType) {
                this.source_type = marketingType;
            };

            setMarketingSchool(marketingSchool) {
                this.school = marketingSchool;
            };

            getMarketingSchool() {
                return this.school;
            };

            getMarketingType() {
                return this.source_type;
            };

            // Filter by channels
            setMarketingSource(marketingSource) {
                this.channel = marketingSource;
            };

            getMarketingSource() {
                return this.channel;
            };

            // Filter by sub_channels
            setMarketingSourceSub(marketingSourceSub) {
                this.sub_channel = marketingSourceSub;
            };

            getMarketingSourceSub() {
                return this.sub_channel;
            };

            // Filter by lifecycle_stage
            setLifecycleStage(lifecycleStage) {
                this.lifecycle_stage = lifecycleStage;
            };

            getLifecycleStage() {
                return this.lifecycle_stage;
            };

            // Filter by lead_status
            setLeadStatus(leadStatus) {
                this.lead_status = leadStatus;
            };

            getLeadStatus() {
                return this.lead_status;
            };

            //Filter SalesPerson
            setSalespersonIds(ids) {
                this.salesperson_ids = ids;
            }
            
            getSalespersonIds() {
                return this.salesperson_ids;
            };

            getLeadStatusMenu() {
                return this.lead_status_menu;
            };

            getLifeCycleStageMenu() {
                return this.lifecycle_stage_menu;
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

            getHandoverContactRequestButtons() {
                return this.listContent.querySelectorAll('[row-action="handover-contact"]');
            }

            getListItemsCount() {
                return this.listContent.querySelectorAll('[list-control="item"]').length;
            }
            getMarketingSourceSelected() {
                return this.container.querySelector('[list-action="marketing-source-select"]');
            }
            getLifecycleStageSelected() {
                return this.container.querySelector('[list-action="lifecycle-stage-select"]');
            }
            getMarketingSourceSelectedSub() {
                return this.container.querySelector('[list-action="marketing-source-sub-select"]');
            }

            getLifecycleStageSelectedSub() {
                return this.container.querySelector('[list-action="lifecycle-stage-sub-select"]');
            }
            setMarketingSourceSelectedSubOptions(selectedValue) {
                var subtypes = marketingData[selectedValue] || [];
                var marketingSourceSelectedSub = this.getMarketingSourceSelectedSub();

                marketingSourceSelectedSub.innerHTML = '';

                subtypes.forEach(function(subtype) {
                    var option = new Option(subtype, subtype, false, false);
                    marketingSourceSelectedSub.appendChild(option);
                });

                // Trigger sự thay đổi của select 2
                $(marketingSourceSelectedSub).trigger('change.select2');
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
            }

            setContactId(id) {
                this.contact_id = id;
            }

            getContactId() {
                return this.contact_id;
            }

            initContentEvents() {
                const _this = this;

                SortManager.init(this);

                // when list content has items
                if (this.getListItemsCount()) {
                    /**
                     * DELETE CONTACT REQUESTS
                     */
                    this.getDeleteAllItemsBtn().addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = this.getAttribute('href');
                        const items = _this.getItemCheckedIds();

                        _this.hideTopListActionBox();
                        _this.showSearchBoxes();

                        ASTool.confirm({
                            message: "Bạn có chắc muốn xóa các đơn hàng này không?",
                            ok: function() {
                                ASTool.addPageLoadingEffect();
                                $.ajax({
                                    url: url,
                                    method: "POST",
                                    data: {
                                        _token: "{{ csrf_token() }}",
                                        contactRequests: items
                                    }
                                }).done(response => {
                                    ASTool.alert({
                                        message: response.message,
                                        ok: function() {
                                            ContactRequestsList.getList()
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

                    // Khi chọn marketing source thì sẽ hiện thị ra marrketing source sub tương ứng
                    $(this.getMarketingSourceSelected()).on('change', () => {
                        var selectedSource = this.getMarketingSourceSelected().value;
                        var subtypes = @json(config('marketingSourceSubs'));

                        // Clear and update options in the second dropdown
                        var getMarketingSourceSelectedSub = $(this
                            .getMarketingSourceSelectedSub()); // Wrap it in jQuery
                        getMarketingSourceSelectedSub.empty();

                        $.each(subtypes[selectedSource] || [], function(index, subtype) {
                            var option = new Option(subtype, subtype, false, false);
                            getMarketingSourceSelectedSub.append(option);
                        });

                        // Trigger Select2 to refresh the second dropdown
                        $(getMarketingSourceSelectedSub).trigger('change.select2');

                        // cho sub_channel = []
                        this.setMarketingSourceSub([]);
                    });

                    $(this.getLifecycleStageSelected()).on('change', () => {
                        var selectedSource = this.getLifecycleStageSelected().value;
                        var subtypes = @json(config('lifecycleStagesSub'));

                        // Clear and update options in the second dropdown
                        var getLifecycleStageSelectedSub = $(this
                            .getLifecycleStageSelectedSub()); // Wrap it in jQuery
                        getLifecycleStageSelectedSub.empty();

                        $.each(subtypes[selectedSource] || [], function(index, subtype) {
                            var option = new Option(subtype, subtype, false, false);
                            getLifecycleStageSelectedSub.append(option);
                        });

                        // Trigger Select2 to refresh the second dropdown
                        $(getLifecycleStageSelectedSub).trigger('change.select2');

                        // cho sub_channel = []
                        this.setMarketingSourceSub([]);
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
                            UpdateContactRequestPopup.load(url);
                        });
                    });

                    // mở popup chọn account để bàn giao
                    this.getHandoverContactRequestButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');

                            // show popup
                            HandoverContactRequestPopup.load(url);
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

                     // mở popup hiển thị ghi chú
                     this.getNoteLogsContactButtons().forEach(button => {
                        button.addEventListener('click', (e) => {
                            e.preventDefault();

                            var url = button.getAttribute('href');
                            // show popup
                            NodeLogsContactPopup.load(url);
                        });
                    });
                }
            }
            
            deleteItem(url) {
                // success alert
                ASTool.confirm({
                    message: 'Bạn có chắc chắn muốn xóa đơn hàng này?',
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
                                    ContactRequestsList.getList()
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
                    .checkedCount() + '</strong> đơn hàng';
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
            getNoteLogsContactButtons() {
                return this.listContent.querySelectorAll('[row-action="note-logs-contact"]');

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
                        tag_id: this.getTagId(),
                        sort_by: SortManager.getSortBy(),
                        sort_direction: SortManager.getSortDirection(),
                        source_type: this.getMarketingType(),
                        school :this.getMarketingSchool(),
                        channel: this.getMarketingSource(),
                        sub_channel: this.getMarketingSourceSub(),
                        lifecycle_stage: this.getLifecycleStage(),
                        lead_status: this.getLeadStatus(),
                        salesperson_ids: this.getSalespersonIds(),
                        lead_status_menu: this.getLeadStatusMenu(),
                        lifecycle_stage_menu: this.getLifeCycleStageMenu(),
                        status: this.getStatus(),

                        created_at_from: this.getCreatedAtFrom(),
                        created_at_to: this.getCreatedAtTo(),

                        updated_at_from: this.getUpdatedAtFrom(),
                        updated_at_to: this.getUpdatedAtTo(),

                        // columns manager
                        columns: ContactRequestColumnManager.getColumns(),

                        // contact id
                        contact_id: this.getContactId(),

                        // add_from
                        added_from: $('[list-filter="added-from"]').val(),

                        // google_sheet_id
                        google_sheet_id: $('[list-filter="google-sheet-id"]').val(),

                        // schools
                        schools: $('[name="schools[]"]').val(),

                        // list
                        list: $('[list-action="list-select"]').val(),
                    }
                }).done((content) => {
                    this.loadContent(content);

                    //
                    this.initContentEvents();

                    // 
                    this.removeLoadEffect();

                    // apply
                    ContactRequestColumnManager.applyToList();
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
