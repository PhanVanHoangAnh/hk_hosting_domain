@extends('layouts.main.app')

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
            @include('sales.contacts.detail', [
            'detail' => 'study-abroad',
            ])
            <!--end::Details-->

            @include('sales.contacts.menu', [
            'menu' => 'study-abroad',
            ])
        </div>
    </div>
    <!--end::Navbar-->
    <!--begin::Timeline-->
    <div class="card mb-10">
        <!--begin::Card head-->
        <div class="card-header card-header-stretch">
            <!--begin::Title-->
            <div class="card-title d-flex align-items-center">
                <i class="ki-duotone ki-calendar-8 fs-1 text-primary me-3 lh-0">
                    <span class="path1"></span>
                    <span class="path2"></span>
                    <span class="path3"></span>
                    <span class="path4"></span>
                    <span class="path5"></span>
                    <span class="path6"></span>
                </i>
                <h3 class="fw-bold m-0 text-gray-800">Jan 23, 2023</h3>
            </div>
            <!--end::Title-->
            <!--begin::Toolbar-->
            <div class="card-toolbar m-0">
                <!--begin::Tab nav-->
                <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-6 border-0 fw-bold" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a id="kt_activity_today_tab"
                            class="nav-link justify-content-center text-active-gray-800 active" data-bs-toggle="tab"
                            role="tab" href="#kt_activity_today">Today</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_activity_week_tab" class="nav-link justify-content-center text-active-gray-800"
                            data-bs-toggle="tab" role="tab" href="#kt_activity_week">Week</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_activity_month_tab" class="nav-link justify-content-center text-active-gray-800"
                            data-bs-toggle="tab" role="tab" href="#kt_activity_month">Month</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a id="kt_activity_year_tab"
                            class="nav-link justify-content-center text-active-gray-800 text-hover-gray-800"
                            data-bs-toggle="tab" role="tab" href="#kt_activity_year">2023</a>
                    </li>
                </ul>
                <!--end::Tab nav-->
            </div>
            <!--end::Toolbar-->
        </div>
        <!--end::Card head-->
        <!--begin::Card body-->
        <div class="card-body">
            <!--begin::Tab Content-->
            <div class="tab-content">
                <!--begin::Tab panel-->
                <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel"
                    aria-labelledby="kt_activity_today_tab">
                    <!--begin::Timeline-->
                    <div class="timeline">
                        <!--begin::Timeline item-->
                        <div class="timeline-item">
                            <!--begin::Timeline line-->
                            <div class="timeline-line w-40px"></div>
                            <!--end::Timeline line-->
                            <!--begin::Timeline icon-->
                            <div class="timeline-icon symbol symbol-circle symbol-40px me-4">
                                <div class="symbol-label bg-light">
                                    <i class="ki-duotone ki-message-text-2 fs-2 text-gray-500">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>
                                </div>
                            </div>
                            <!--end::Timeline icon-->
                            <!--begin::Timeline content-->
                            <div class="timeline-content mb-10 mt-n1">
                                <!--begin::Timeline heading-->
                                <div class="pe-3 mb-5">
                                    <!--begin::Title-->
                                    <div class="fs-5 fw-semibold mb-2">Có 3 hoạt động:</div>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <!--begin::Info-->
                                        <div class="text-muted me-2 fs-7">Added at 4:23 PM by
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top" title="Alan Nilson">
                                            <span class="text-primary fs-5">Alan Nilson</span>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Timeline heading-->
                                <!--begin::Timeline details-->
                                <div class="overflow-auto pb-5">
                                    <!--begin::Record-->
                                    <div
                                        class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
                                        <!--begin::Title-->
                                        <a href="../../demo5/dist/apps/projects/project.html"
                                            class="fs-5 text-dark text-hover-primary fw-semibold w-375px min-w-200px">Học
                                            tiếng anh</a>
                                        <!--end::Title-->
                                        <!--begin::Label-->
                                        <div class="min-w-175px pe-2">
                                            <span class="badge badge-light text-muted">Tiếng anh</span>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Users-->
                                        <div class="symbol-group symbol-hover flex-nowrap flex-grow-1 min-w-100px pe-2">
                                            <!--begin::User-->
                                            <span class="text-primary fs-5">Alan Nilson</span>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Users-->

                                        <!--begin::Action-->
                                        <a href="../../demo5/dist/apps/projects/project.html"
                                            class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Record-->
                                    <!--begin::Record-->
                                    <div
                                        class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-5">
                                        <!--begin::Title-->
                                        <a href="../../demo5/dist/apps/projects/project.html"
                                            class="fs-5 text-dark text-hover-primary fw-semibold w-375px min-w-200px">When
                                            to expect new version of Laravel ?</a>
                                        <!--end::Title-->
                                        <!--begin::Label-->
                                        <div class="min-w-175px pe-2">
                                            <span class="badge badge-light text-muted">Viết bài luận</span>
                                        </div>
                                        <!--end::Label-->

                                        <!--begin::Users-->
                                        <div class="symbol-group symbol-hover flex-nowrap flex-grow-1 min-w-100px pe-2">
                                            <!--begin::User-->
                                            <span class="text-primary fs-5">Jocelyn Cole</span>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Users-->
                                        <!--begin::Progress-->
                                        <div class="min-w-125px pe-2">
                                            <span class="badge badge-light-primary">In
                                                Progress</span>
                                        </div>
                                        <!--end::Progress-->
                                        <!--begin::Action-->
                                        <a href="../../demo5/dist/apps/projects/project.html"
                                            class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Record-->
                                    <!--begin::Record-->
                                    <div
                                        class="d-flex align-items-center border border-dashed border-gray-300 rounded min-w-750px px-7 py-3 mb-0">
                                        <!--begin::Title-->
                                        <a href="../../demo5/dist/apps/projects/project.html"
                                            class="fs-5 text-dark text-hover-primary fw-semibold w-375px min-w-200px">Học
                                            tiếng anh</a>
                                        <!--end::Title-->
                                        <!--begin::Label-->
                                        <div class="min-w-175px">
                                            <span class="badge badge-light text-muted">Tiếng anh</span>
                                        </div>
                                        <!--end::Label-->
                                        <!--begin::Users-->
                                        <div class="symbol-group symbol-hover flex-nowrap flex-grow-1 min-w-100px">
                                            <!--begin::User-->
                                            <span class="text-primary fs-5">Alan Nilson</span>
                                            <!--end::User-->
                                        </div>
                                        <!--end::Users-->

                                        <!--begin::Action-->
                                        <a href="../../demo5/dist/apps/projects/project.html"
                                            class="btn btn-sm btn-light btn-active-light-primary">View</a>
                                        <!--end::Action-->
                                    </div>
                                    <!--end::Record-->
                                </div>
                                <!--end::Timeline details-->
                            </div>

                            <!--end::Timeline content-->
                        </div>
                        <!--end::Timeline item-->
                        <!--begin::Timeline item-->
                        <div class="timeline-item">
                            <!--begin::Timeline line-->
                            <div class="timeline-line w-40px"></div>
                            <!--end::Timeline line-->
                            <!--begin::Timeline icon-->
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-duotone ki-flag fs-2 text-gray-500">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <!--end::Timeline icon-->
                            <!--begin::Timeline content-->
                            <div class="timeline-content mb-10 mt-n2">
                                <!--begin::Timeline heading-->
                                <div class="overflow-auto pe-3">
                                    <!--begin::Title-->
                                    <div class="fs-5 fw-semibold mb-2">Tư vấn du học</div>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <!--begin::Info-->
                                        <div class="text-muted me-2 fs-7">Sent at 4:23 PM by
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top" title="Alan Nilson">
                                            <span class="text-primary fs-5">Alan Nilson</span>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Timeline heading-->
                            </div>
                            <!--end::Timeline content-->
                        </div>
                        <!--end::Timeline item-->
                        <!--begin::Timeline item-->
                        <div class="timeline-item">
                            <!--begin::Timeline line-->
                            <div class="timeline-line w-40px"></div>
                            <!--end::Timeline line-->
                            <!--begin::Timeline icon-->
                            <div class="timeline-icon symbol symbol-circle symbol-40px">
                                <div class="symbol-label bg-light">
                                    <i class="ki-duotone ki-flag fs-2 text-gray-500">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </div>
                            </div>
                            <!--end::Timeline icon-->
                            <!--begin::Timeline content-->
                            <div class="timeline-content mb-10 mt-n2">
                                <!--begin::Timeline heading-->
                                <div class="overflow-auto pe-3">
                                    <!--begin::Title-->
                                    <div class="fs-5 fw-semibold mb-2">Phỏng vấn</div>
                                    <!--end::Title-->
                                    <!--begin::Description-->
                                    <div class="d-flex align-items-center mt-1 fs-6">
                                        <!--begin::Info-->
                                        <div class="text-muted me-2 fs-7">Sent at 1:30 PM by
                                        </div>
                                        <!--end::Info-->
                                        <!--begin::User-->
                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip"
                                            data-bs-boundary="window" data-bs-placement="top" title="Alan Nilson">
                                            <span class="text-primary fs-5">Alan Nilson</span>
                                        </div>
                                        <!--end::User-->
                                    </div>
                                    <!--end::Description-->
                                </div>
                                <!--end::Timeline heading-->
                            </div>
                            <!--end::Timeline content-->
                        </div>
                        <!--end::Timeline item-->
                    </div>
                </div>
                <!--end::Tab panel-->
            </div>
            <!--end::Tab Content-->
        </div>

        <!--end::Card body-->
    </div>
    <!--end::Timeline-->


    <!--begin::Row-->
    <div class="row gy-5 g-xl-10">
        <!--begin::Col-->
        <div class="col-xl-12">
            <!--begin::Table Widget 5-->
            <div class="card card-flush h-xl-100">
                <!--begin::Wrapper-->
                <div class="wrapper d-flex flex-column flex-row-fluid mt-5 mt-lg-10" id="kt_wrapper">
                    <!--begin::Content-->
                    <div class="content flex-column-fluid px-10 pb-7" id="kt_content">
                        <!--begin::Toolbar-->
                        <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
                            <!--begin::Page title-->
                            <div class="page-title d-flex flex-column py-1">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center my-1">
                                    <span class="text-dark fw-bold fs-1">Tất cả bài luận</span>
                                    <!--begin::Description-->
                                    <small class="text-muted fs-6 fw-semibold ms-1">(3)</small>
                                    <!--end::Description-->
                                </h1>
                                <!--end::Title-->
                            </div>
                            <!--end::Page title-->
                            <!--begin::Actions-->
                            <div class="d-flex align-items-end py-1">
                                <div class="card-toolbar">
                                    <!--begin::Toolbar-->
                                    <div class="d-flex justify-content-end" data-kt-filemanager-table-toolbar="base">

                                        <!--end::Back to folders-->

                                        <!--begin::Button-->
                                        <button type="button" class="btn btn-flex btn-light-primary me-3"
                                            data-bs-toggle="modal" data-bs-target="#kt_modal_report"
                                            id="kt_toolbar_primary_button">
                                            <i class="ki-duotone ki-add-folder fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>Viết bài luận</button>
                                        <!--end::Button-->
                                        <!--end::Export-->
                                        <!--begin::Add contact-->
                                        <button type="button" class="btn btn-flex btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#kt_modal_upload">
                                            <i class="ki-duotone ki-folder-up fs-2">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>Upload Files</button>
                                        <!--end::Add contact-->
                                    </div>
                                    <!--end::Toolbar-->
                                    <!--begin::Group actions-->
                                    <div class="d-flex justify-content-end align-items-center d-none"
                                        data-kt-filemanager-table-toolbar="selected">
                                        <div class="fw-bold me-5">
                                            <span class="me-2"
                                                data-kt-filemanager-table-select="selected_count"></span>Selected
                                        </div>
                                        <button type="button" class="btn btn-danger"
                                            data-kt-filemanager-table-select="delete_selected">Delete Selected</button>
                                    </div>
                                    <!--end::Group actions-->
                                </div>

                                <!--begin::Modal-->
                                <div class="modal fade" tabindex="-1" id="kt_modal_report">
                                    <div class="modal-dialog" style="max-width: 1000px;">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title">Viết bài luận</h3>

                                                <!--begin::Close-->
                                                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                    data-bs-dismiss="modal" aria-label="Close">
                                                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span
                                                            class="path2"></span></i>
                                                </div>
                                                <!--end::Close-->
                                            </div>

                                            <div class="modal-body">
                                                <div class="post" id="kt_post">
                                                    <!--begin:Form-->
                                                    <form id="kt_devs_ask_form" class="form" action="#"
                                                        data-kt-redirect="../../demo5/dist/apps/devs/question.html">
                                                        <!--begin::Input group-->
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="d-flex align-items-center mb-2">
                                                                <span class="text-gray-700 fs-6 fw-bold required">Tiêu
                                                                    đề</span>
                                                                <span class="ms-1" data-bs-toggle="tooltip"
                                                                    title="Specify your question's title">
                                                                    <i
                                                                        class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                        <span class="path1"></span>
                                                                        <span class="path2"></span>
                                                                        <span class="path3"></span>
                                                                    </i>
                                                                </span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Form control-->
                                                            <input type="text" class="form-control"
                                                                placeholder="Tiêu đề câu hỏi của bạn" name="title" />
                                                            <!--end::Form control-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="d-flex flex-column mb-8">
                                                            <!--begin::Label-->
                                                            <label class="mb-2">
                                                                <span class="text-gray-700 fs-6 fw-bold required">Nội
                                                                    dung</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Form control-->
                                                            <div class="fv-row">
                                                                <textarea class="form-control mb-3" rows="10"
                                                                    name="question"
                                                                    placeholder="Vui lòng nêu rõ câu hỏi của bạn"
                                                                    data-kt-autosize="true"></textarea>
                                                            </div>
                                                            <!--end::Form control-->
                                                            <!--begin::Formating toggle-->
                                                            <div class="text-primary fs-base fw-semibold cursor-pointer"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#kt_devs_ask_formatting">
                                                                Tùy chọn định dạng văn bản</div>
                                                            <!--end::Formating toggle-->
                                                            <!--begin::Formating info-->
                                                            <div class="collapse" id="kt_devs_ask_formatting">
                                                                <div class="pt-3 mb-5 fs-6">Đây là cách thêm một số định
                                                                    dạng HTML vào nhận xét của bạn:</div>
                                                                <ul class="list-unstyled p-0 mb-10">
                                                                    <li class="py-1 fs-6">
                                                                        <b>&lt;strong&gt;&lt;/strong&gt;</b>&nbsp;to
                                                                        make things bold
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <b>&lt;em&gt;&lt;/em&gt;</b>&nbsp;to emphasize
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <b>&lt;ul&gt;&lt;li&gt;</b>&nbsp;or
                                                                        <b>&lt;ol&gt;&lt;li&gt;</b>&nbsp; to make lists
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <b>&lt;h3&gt;</b>&nbsp;or
                                                                        <b>&lt;h4&gt;</b>&nbsp;to make headings
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <b>&lt;pre&gt;&lt;/pre&gt;</b>&nbsp;for code
                                                                        blocks
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <b>&lt;code&gt;&lt;/code&gt;</b>&nbsp;for a few
                                                                        words of code
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <b>&lt;a&gt;&lt;/a&gt;</b>&nbsp;for links
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <b>&lt;img&gt;</b>&nbsp;to paste in an image
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <b>&lt;blockquote&gt;&lt;/blockquote&gt;</b>&nbsp;to
                                                                        quote somebody
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <img alt="happy"
                                                                            src="assets/media/smiles/happy.png" />&nbsp;&nbsp;:)
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <img alt="shocked"
                                                                            src="assets/media/smiles/shocked.png" />&nbsp;&nbsp;:|
                                                                    </li>
                                                                    <li class="py-1 fs-6">
                                                                        <img alt="sad"
                                                                            src="assets/media/smiles/sad.png" />&nbsp;&nbsp;:(
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <!--end::Formating info-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="d-flex flex-column mb-8">
                                                            <!--begin::Label-->
                                                            <label class="mb-2">
                                                                <span class="text-gray-700 fs-6 fw-bold">Thể loại</span>
                                                                <span class="text-muted fs-7">(lựa chọn)</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Form control-->
                                                            <select class="form-select" data-control="select2"
                                                                data-placeholder="Select a product" name="product">
                                                                <option value=""></option>
                                                                <option value="1">Phân tích</option>
                                                                <option value="1">Giải thích</option>
                                                                <option value="2">Báo cáo</option>
                                                                <option value="3">Tường thuật</option>
                                                                <option value="4">Mô tả</option>

                                                            </select>
                                                            <!--end::Form control-->
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="d-flex flex-column mb-8 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="mb-2">
                                                                <span class="text-gray-700 fs-6 fw-bold">Tags</span>
                                                                <span class="text-muted fs-7">(lựa chọn)</span>
                                                            </label>
                                                            <!--end::Label-->
                                                            <!--begin::Form control-->
                                                            <input class="form-control"
                                                                placeholder="E.g: Tiếng anh, báo cáo" name="tags" />
                                                            <!--end::Form control-->
                                                        </div>
                                                        <!--end::Input group-->

                                                    </form>
                                                    <!--end:Form-->
                                                </div>
                                                <!--end::Post-->
                                            </div>

                                            <div class="modal-footer">
                                                <div class="d-flex flex-stack">
                                                    <!--begin::Public-->
                                                    <label
                                                        class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" name="public"
                                                            value="1" checked="checked" />
                                                        <span class="form-check-label fs-7 fw-bold text-gray-800">Public
                                                            <span class="ms-1" data-bs-toggle="tooltip"
                                                                title="Make your question public to help others with solutions">
                                                                <i
                                                                    class="ki-duotone ki-information-5 text-gray-500 fs-6">
                                                                    <span class="path1"></span>
                                                                    <span class="path2"></span>
                                                                    <span class="path3"></span>
                                                                </i>
                                                            </span></span>
                                                    </label>
                                                    <!--end::Public-->

                                                </div>
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Đóng</button>
                                                <!--begin::Submit-->
                                                <button type="submit" id="kt_devs_ask_submit" class="btn btn-primary">
                                                    <!--begin::Indicator label-->
                                                    <span class="indicator-label">Nộp</span>
                                                    <!--end::Indicator label-->
                                                    <!--begin::Indicator progress-->
                                                    <span class="indicator-progress">Vui lòng chờ 1 chút ....
                                                        <span
                                                            class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    <!--end::Indicator progress-->
                                                </button>
                                                <!--begin::Submit-->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Modal-->
                            </div>
                            <!--end::Actions-->

                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Post-->
                        <div class="post" id="kt_post">
                            <!--begin::Questions-->
                            <div class="mb-10">


                                <!--begin::Question-->
                                <div class="mb-0">
                                    <!--begin::Head-->
                                    <div class="d-flex align-items-center mb-4">
                                        <!--begin::Title-->
                                        <a href="../../demo5/dist/apps/devs/question.html"
                                            class="fs-2 fw-bold text-gray-900 text-hover-primary me-1">When to
                                            expect
                                            new version of Laravel ?</a>
                                        <!--end::Title-->
                                        <!--begin::Icons-->
                                        <div class="d-flex align-items-center">
                                            <span class="ms-1" data-bs-toggle="tooltip" title="In-process">
                                                <i class="ki-duotone ki-information-5 text-warning fs-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i>
                                            </span>
                                        </div>
                                        <!--end::Icons-->
                                    </div>
                                    <!--end::Head-->
                                    <!--begin::Summary-->
                                    <div class="fs-base fw-normal text-gray-700 mb-4">When approx. is the next
                                        update
                                        for the Laravel version planned? Waiting for the CRUD, 2nd factor etc.
                                        features
                                        before starting my project. Also can we expect the Laravel + Vue version
                                        in the
                                        next update ?</div>
                                    <!--end::Summary-->
                                    <!--begin::Foot-->
                                    <div class="d-flex flex-stack flex-wrap">
                                        <!--begin::Author-->
                                        <div class="d-flex align-items-center py-1">
                                            <!--begin::Symbol-->
                                            <div class="symbol symbol-35px me-2">
                                                <div
                                                    class="symbol-label bg-light-success fs-3 fw-semibold text-success text-uppercase">
                                                    S</div>
                                            </div>
                                            <!--end::Symbol-->
                                            <!--begin::Name-->
                                            <div class="d-flex flex-column align-items-start justify-content-center">
                                                <span class="text-gray-900 fs-7 fw-semibold lh-1 mb-2">Sandra
                                                    Piquet</span>
                                                <span class="text-muted fs-8 fw-semibold lh-1">1 day ago</span>
                                            </div>
                                            <!--end::Name-->
                                        </div>
                                        <!--end::Author-->
                                        <!--begin::Info-->
                                        <div class="d-flex align-items-center py-1">
                                            <!--begin::Answers-->
                                            <a href="../../demo5/dist/apps/devs/question.html#answers"
                                                class="btn btn-sm btn-outline btn-outline-dashed btn-outline-default px-4 me-2"
                                                data-bs-toggle="modal" data-bs-target="#kt_modal_comment">
                                                2 Answers</a>
                                            <!--end::Answers-->
                                            <!--begin::Modal-->
                                            <div class="modal fade" tabindex="-1" id="kt_modal_comment">
                                                <div class="modal-dialog" style="max-width: 1000px;">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h3 class="modal-title">Viết bài luận</h3>

                                                            <!--begin::Close-->
                                                            <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                                                                data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="ki-duotone ki-cross fs-1"><span
                                                                        class="path1"></span><span
                                                                        class="path2"></span></i>
                                                            </div>
                                                            <!--end::Close-->
                                                        </div>

                                                        <div class="modal-body">
                                                            <div class="post" id="kt_post">
                                                                <!--begin::Body-->

                                                                <!--end::Header-->
                                                                <!--begin::Post-->
                                                                <div class="d-flex align-items-center mb-5">
                                                                    <!--begin::Icon-->
                                                                    <div class="symbol symbol-30px me-5">

                                                                        <img alt="Icon"
                                                                            src="{{ url('/core/assets/media/svg/files/doc.svg') }}">
                                                                    </div>
                                                                    <!--end::Icon-->
                                                                    <!--begin::Details-->
                                                                    <div class="fw-semibold">
                                                                        <a class="fs-6 fw-bold text-dark text-hover-primary"
                                                                            href="#">When to expect new version of
                                                                            Laravel ?
                                                                        </a>
                                                                        <div class="text-gray-400">Due in 1 day
                                                                            <a href="#">Marcus Blake</a>
                                                                        </div>
                                                                    </div>
                                                                    <!--end::Details-->
                                                                    <!--begin::Menu-->

                                                                    <button type="button"
                                                                        class="btn btn-light-primary font-weight-bolder dropdown-toggle ms-auto"
                                                                        data-kt-menu-trigger="click"
                                                                        data-kt-menu-placement="bottom-end">
                                                                        <span class="svg-icon svg-icon-md">
                                                                            <!--begin::Svg Icon | path:/metronic/theme/html/demo9/dist/assets/media/svg/icons/Design/PenAndRuller.svg--><svg
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                                                                width="24px" height="24px"
                                                                                viewBox="0 0 24 24" version="1.1">
                                                                                <g stroke="none" stroke-width="1"
                                                                                    fill="none" fill-rule="evenodd">
                                                                                    <rect x="0" y="0" width="24"
                                                                                        height="24"></rect>
                                                                                    <path
                                                                                        d="M3,16 L5,16 C5.55228475,16 6,15.5522847 6,15 C6,14.4477153 5.55228475,14 5,14 L3,14 L3,12 L5,12 C5.55228475,12 6,11.5522847 6,11 C6,10.4477153 5.55228475,10 5,10 L3,10 L3,8 L5,8 C5.55228475,8 6,7.55228475 6,7 C6,6.44771525 5.55228475,6 5,6 L3,6 L3,4 C3,3.44771525 3.44771525,3 4,3 L10,3 C10.5522847,3 11,3.44771525 11,4 L11,19 C11,19.5522847 10.5522847,20 10,20 L4,20 C3.44771525,20 3,19.5522847 3,19 L3,16 Z"
                                                                                        fill="#000000" opacity="0.3">
                                                                                    </path>
                                                                                    <path
                                                                                        d="M16,3 L19,3 C20.1045695,3 21,3.8954305 21,5 L21,15.2485298 C21,15.7329761 20.8241635,16.200956 20.5051534,16.565539 L17.8762883,19.5699562 C17.6944473,19.7777745 17.378566,19.7988332 17.1707477,19.6169922 C17.1540423,19.602375 17.1383289,19.5866616 17.1237117,19.5699562 L14.4948466,16.565539 C14.1758365,16.200956 14,15.7329761 14,15.2485298 L14,5 C14,3.8954305 14.8954305,3 16,3 Z"
                                                                                        fill="#000000"></path>
                                                                                </g>
                                                                            </svg>
                                                                            <!--end::Svg Icon-->
                                                                        </span> Download
                                                                    </button>

                                                                </div>
                                                                <!--end::Post-->
                                                                <!--begin::Separator-->
                                                                <div class="separator mb-4"></div>
                                                                <!--end::Separator-->
                                                                <!--begin::Replies-->
                                                                <div class="mb-7 px-10">
                                                                    <!--begin::Reply-->
                                                                    <div class="d-flex mb-5">
                                                                        <!--begin::Avatar-->
                                                                        <div class="symbol symbol-45px me-5">
                                                                            <img src="{{ url('/core/assets/media/avatars/300-14.jpg') }}"
                                                                                alt="" />
                                                                        </div>
                                                                        <!--end::Avatar-->
                                                                        <!--begin::Info-->
                                                                        <div class="d-flex flex-column flex-row-fluid">
                                                                            <!--begin::Info-->
                                                                            <div
                                                                                class="d-flex align-items-center flex-wrap mb-1">
                                                                                <a href="#"
                                                                                    class="text-gray-800 text-hover-primary fw-bold me-2">Alice
                                                                                    Danchik</a>
                                                                                <span
                                                                                    class="text-gray-400 fw-semibold fs-7">1
                                                                                    day</span>
                                                                                <a href="#"
                                                                                    class="ms-auto text-gray-400 text-hover-primary fw-semibold fs-7">Reply</a>
                                                                            </div>
                                                                            <!--end::Info-->
                                                                            <!--begin::Post-->
                                                                            <span
                                                                                class="text-gray-800 fs-7 fw-normal pt-1">Long
                                                                                before you sit dow to put digital
                                                                                pen to paper you need to make sure
                                                                                you have to sit down and
                                                                                write.</span>
                                                                            <!--end::Post-->
                                                                        </div>
                                                                        <!--end::Info-->
                                                                    </div>
                                                                    <!--end::Reply-->
                                                                    <!--begin::Reply-->
                                                                    <div class="d-flex">
                                                                        <!--begin::Avatar-->
                                                                        <div class="symbol symbol-45px me-5">
                                                                            <img src="{{ url('/core/assets/media/avatars/300-9.jpg') }}"
                                                                                alt="" />
                                                                        </div>
                                                                        <!--end::Avatar-->
                                                                        <!--begin::Info-->
                                                                        <div class="d-flex flex-column flex-row-fluid">
                                                                            <!--begin::Info-->
                                                                            <div
                                                                                class="d-flex align-items-center flex-wrap mb-1">
                                                                                <a href="#"
                                                                                    class="text-gray-800 text-hover-primary fw-bold me-2">Harris
                                                                                    Bold</a>
                                                                                <span
                                                                                    class="text-gray-400 fw-semibold fs-7">2
                                                                                    days</span>
                                                                                <a href="#"
                                                                                    class="ms-auto text-gray-400 text-hover-primary fw-semibold fs-7">Reply</a>
                                                                            </div>
                                                                            <!--end::Info-->
                                                                            <!--begin::Post-->
                                                                            <span
                                                                                class="text-gray-800 fs-7 fw-normal pt-1">Outlines
                                                                                keep you honest. They stop you from
                                                                                indulging in poorly</span>
                                                                            <!--end::Post-->
                                                                        </div>
                                                                        <!--end::Info-->
                                                                    </div>
                                                                    <!--end::Reply-->
                                                                </div>
                                                                <!--end::Replies-->
                                                                <!--begin::Separator-->
                                                                <div class="separator mb-4"></div>
                                                                <!--end::Separator-->
                                                                <!--begin::Reply input-->
                                                                <form class="position-relative mb-6">
                                                                    <textarea
                                                                        class="form-control border-0 p-0 pe-10 resize-none min-h-25px"
                                                                        data-kt-autosize="true" rows="1"
                                                                        placeholder="Reply.."></textarea>
                                                                    <div class="position-absolute top-0 end-0 me-n5">
                                                                        <span
                                                                            class="btn btn-icon btn-sm btn-active-color-primary pe-0 me-2">
                                                                            <i
                                                                                class="ki-duotone ki-paper-clip fs-2 mb-3"></i>
                                                                        </span>
                                                                        <span
                                                                            class="btn btn-icon btn-sm btn-active-color-primary ps-0">
                                                                            <i
                                                                                class="ki-duotone ki-geolocation fs-2 mb-3">
                                                                                <span class="path1"></span>
                                                                                <span class="path2"></span>
                                                                            </i>
                                                                        </span>
                                                                    </div>
                                                                </form>
                                                                <!--edit::Reply input-->
                                                            </div>
                                                            <!--end::Body-->
                                                        </div>
                                                        <!--end::Post-->
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Modal-->
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Foot-->
                            </div>
                            <!--end::Question-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed border-gray-300 my-8"></div>
                            <!--end::Separator-->
                            <!--begin::Question-->
                            <div class="mb-0">
                                <!--begin::Head-->
                                <div class="d-flex align-items-center mb-4">
                                    <!--begin::Title-->
                                    <a href="../../demo5/dist/apps/devs/question.html"
                                        class="fs-2 fw-bold text-gray-900 text-hover-primary me-1">Could not
                                        get
                                        Demo 7 working</a>
                                    <!--end::Title-->
                                    <!--begin::Icons-->
                                    <div class="d-flex align-items-center">
                                        <span class="ms-1" data-bs-toggle="tooltip" title="In-process">
                                            <i class="ki-duotone ki-information-5 text-warning fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                                <span class="path3"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <!--end::Icons-->
                                </div>
                                <!--end::Head-->
                                <!--begin::Summary-->
                                <div class="fs-base fw-normal text-gray-700 mb-4">could not get demo7
                                    working from
                                    latest metronic version. Had a lot of issues installing, I had to
                                    downgrade my
                                    npm to 6.14.4 as someone else recommended here in the comments, this
                                    goot it to
                                    compile but when I ran it, the browser showed errors TypeErr..</div>
                                <!--end::Summary-->
                                <!--begin::Foot-->
                                <div class="d-flex flex-stack flex-wrap">
                                    <!--begin::Author-->
                                    <div class="d-flex align-items-center py-1">
                                        <!--begin::Symbol-->
                                        <div class="symbol symbol-35px me-2">
                                            <div
                                                class="symbol-label bg-light-success fs-3 fw-semibold text-success text-uppercase">
                                                N</div>
                                        </div>
                                        <!--end::Symbol-->
                                        <!--begin::Name-->
                                        <div class="d-flex flex-column align-items-start justify-content-center">
                                            <span class="text-gray-900 fs-7 fw-semibold lh-1 mb-2">Niko
                                                Roseberg</span>
                                            <span class="text-muted fs-8 fw-semibold lh-1">2 days ago</span>
                                        </div>
                                        <!--end::Name-->
                                    </div>
                                    <!--end::Author-->
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center py-1">
                                        <!--begin::Answers-->
                                        <a href="../../demo5/dist/apps/devs/question.html#answers"
                                            class="btn btn-sm btn-outline btn-outline-dashed btn-outline-default px-4 me-2">4
                                            Answers</a>
                                        <!--end::Answers-->

                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Foot-->
                            </div>
                            <!--end::Question-->
                            <!--begin::Separator-->
                            <div class="separator separator-dashed border-gray-300 my-8"></div>
                            <!--end::Separator-->
                            <!--begin::Question-->
                            <div class="mb-0">
                                <!--begin::Head-->
                                <div class="d-flex align-items-center mb-4">
                                    <!--begin::Title-->
                                    <a href="../../demo5/dist/apps/devs/question.html"
                                        class="fs-2 fw-bold text-gray-900 text-hover-primary me-1">I want to
                                        get
                                        refund</a>
                                    <!--end::Title-->
                                    <!--begin::Icons-->
                                    <div class="d-flex align-items-center">
                                        <span class="ms-1" data-bs-toggle="tooltip" title="Done">
                                            <i class="ki-duotone ki-check-circle text-success fs-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                        </span>
                                    </div>
                                    <!--end::Icons-->
                                </div>
                                <!--end::Head-->
                                <!--begin::Summary-->
                                <div class="fs-base fw-normal text-gray-700 mb-4">Your Metronic theme is so
                                    good but
                                    the reactjs version is typescript only. The description did not write
                                    any warn
                                    about it. Since I only know javascript, I can not do anything with your
                                    theme. I
                                    want to refund.</div>
                                <!--end::Summary-->
                                <!--begin::Foot-->
                                <div class="d-flex flex-stack flex-wrap">
                                    <!--begin::Author-->
                                    <div class="d-flex align-items-center py-1">
                                        <div class="symbol symbol-35px me-2">
                                            <div
                                                class="symbol-label bg-light-success fs-3 fw-semibold text-success text-uppercase">
                                                A</div>
                                        </div>
                                        <!--begin::Name-->
                                        <div class="d-flex flex-column align-items-start justify-content-center">
                                            <span class="text-gray-900 fs-7 fw-semibold lh-1 mb-2">Alex
                                                Bold</span>
                                            <span class="text-muted fs-8 fw-semibold lh-1">1 day ago</span>
                                        </div>
                                        <!--end::Name-->
                                    </div>
                                    <!--end::Author-->
                                    <!--begin::Info-->
                                    <div class="d-flex align-items-center py-1">
                                        <!--begin::Answers-->
                                        <a href="../../demo5/dist/apps/devs/question.html#answers"
                                            class="btn btn-sm btn-outline btn-outline-dashed btn-outline-default px-4 me-2">22
                                            Answers</a>
                                        <!--end::Answers-->

                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Foot-->
                            </div>
                            <!--end::Question-->

                        </div>
                        <!--end::Post-->
                    </div>
                    <!--end::Content-->

                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Table Widget 5-->
        </div>
        <!--end::Col-->
    </div>
    <!--end::Row-->


</div>
<!--end::Post-->
@endsection