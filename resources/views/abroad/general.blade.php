@extends('layouts.main.app', [
    'menu' => 'abroad',
])

@section('sidebar')
    @include('abroad.modules.sidebar', [
        'menu' => 'abroad-application',
        'sidebar' => 'abroad-application',
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
                    <a href="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'index']) }}"
                        class="text-muted text-hover-primary">Trang chủ</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Du học</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Hồ sơ du học</li>
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
                @include('abroad._header', [
                    '_header' => 'general',
                ])
                <!--end::Details-->

                @include('abroad.menu', [
                    'menu' => 'general',
                ])

            </div>
        </div>
        <!--end::Navbar-->
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Thông tin chung</h3>
                </div>
                <!--end::Card title-->
                <!--begin::Action-->
                <!--begin::Button-->
                <a class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px align-self-center d-none"
                    row-action="update-contact" id="buttonsEditContact">
                    <i class="ki-duotone ki-abstract-10">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    Chỉnh sửa thông tin
                </a>

            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <form id="popupCreateAbroadUniqId" tabindex="-1">
                @csrf
                <div class="scroll-y px-7 py-10 px-lg-17">
                    <input class="type-input" type="hidden" name="type" value="{{ App\Models\Order::TYPE_ABROAD }}">
                    
                    <h3 class="mt-15 mb-10">Chi tiết du học</h3>

                    <div class="row d-flex justify-content-between">
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Thời điểm apply:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ !isset($abroadApplication->orderItem->apply_time) ? '--' : date('d/m/Y', strtotime($abroadApplication->orderItem->apply_time)) }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Giới tính:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                    {{   isset($abroadApplication->orderItem->gender) ? $abroadApplication->orderItem->gender : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">GPA:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->GPA) ? $abroadApplication->orderItem->GPA : '--' }} 
                                    </div>
                                </div>
                            </div>
                                
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Chương tình đang học:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->current_program) ? $abroadApplication->orderItem->current_program : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Ngành học dự kiến apply:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->intended_major) ? $abroadApplication->orderItem->intended_major : '--' }}     
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Kế hoạch sau đại học:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->postgraduate_plan) ? $abroadApplication->orderItem->postgraduate_plan : '--' }}     
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Sở thích trong các môn học:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->subject_preference) ? $abroadApplication->orderItem->subject_preference : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Bạn đã tìm hiểu bộ hồ sơ online chưa:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->research_info) ? $abroadApplication->orderItem->research_info : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Khả năng viết bài luận tiếng Anh:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->essay_writing_skill) ? $abroadApplication->orderItem->essay_writing_skill : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Đơn hàng tư vấn cá nhân:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->personal_countling_need) ? $abroadApplication->orderItem->personal_countling_need : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Nghề nghiệp phụ huynh:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->parent_job) ? $abroadApplication->orderItem->parent_job : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="form-outline">
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Học vị cao nhất của bố hoặc mẹ:</span>
                                        </label>
                                    </div>
                                    <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                        <div class="ms-3">
                                            {{ isset($abroadApplication->orderItem->parent_highest_academic) ? $abroadApplication->orderItem->parent_highest_academic : '--' }} 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-outline">
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Mức thu nhập của phụ huynh:</span>
                                        </label>
                                    </div>
                                    <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                        <div class="ms-3">
                                            {{ isset($abroadApplication->orderItem->parent_income) ? $abroadApplication->orderItem->parent_income : '--' }} 
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="form-outline">
                                
                            </div>

                        </div>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Thời gian dự kiến nhập học:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ !isset($abroadApplication->orderItem->estimated_enrollment_time) ? '--' : date('d/m/Y', strtotime($abroadApplication->orderItem->estimated_enrollment_time)) }}
                                    </div>
                                </div>
                            </div>
                            
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Điểm thi chuẩn hóa:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->std_score) ? $abroadApplication->orderItem->std_score : '--' }} 
                                    </div>
                                </div>
                            </div>
                        
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Điểm thi tiếng Anh:</span>
                                    </label>
                                </div>
                                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->eng_score) ? $abroadApplication->orderItem->eng_score : '--' }} 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Chương trình dự kiến apply:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->plan_apply) ? $abroadApplication->orderItem->plan_apply : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Các giải thưởng học thuật:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->academic_award) ? $abroadApplication->orderItem->academic_award : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Bạn là kiểu người:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->personality) ? $abroadApplication->orderItem->personality : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Về ngôn ngữ và văn hóa:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->language_culture) ? $abroadApplication->orderItem->language_culture : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Mục tiêu mà bạn nhắm đến:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->aim) ? $abroadApplication->orderItem->aim : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Các hoạt động ngoại khóa của bạn:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->extra_activity) ? $abroadApplication->orderItem->extra_activity : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Ghi chú các mong muốn khác:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->intended_major) ? $abroadApplication->orderItem->intended_major : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Bố mẹ từng đi du học:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->is_parent_studied_abroad) ? $abroadApplication->orderItem->is_parent_studied_abroad : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Phụ huynh có người thân đã/đang/sắp đi du học?:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->is_parent_family_studied_abroad) ? ($abroadApplication->orderItem->is_parent_family_studied_abroad ? 'Có' : 'Không') : '--' }}

                                    </div>
                                </div>
                            </div>
                            <div class="fv-row my-3 d-flex border-bottom">
                                <div
                                    class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                    <label class="fs-6 fw-semibold mb-2">
                                        <span class="fw-bold">Thời gian có thể đồng hành cùng con:</span>
                                    </label>
                                </div>
                                <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                    <div class="ms-3">
                                        {{ isset($abroadApplication->orderItem->parent_time_spend_with_child) ? $abroadApplication->orderItem->parent_time_spend_with_child : '--' }} 
                                    </div>
                                </div>
                            </div>
                            <div class="form-outline">
                                <div class="fv-row my-3 d-flex border-bottom">
                                    <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                        <label class="fs-6 fw-semibold mb-2">
                                            <span class="fw-bold">Mức am hiểu du học của phụ huynh:</span>
                                        </label>
                                    </div>
                                    <div class="col-9 col-xs-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
                                        <div class="ms-3">
                                            {{ isset($abroadApplication->orderItem->parent_familiarity_abroad) ? $abroadApplication->orderItem->parent_familiarity_abroad : '--' }} 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="fv-row my-3 d-flex border-bottom">
                            <div class="d-flex align-items-center">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="fw-bold">Khả năng chi trả mỗi năm cho quá trình học của con (bao gồm cả học phí) (USD):</span>
                                </label>
                                <div class="ms-3">
                                    
                                    {{ isset($abroadApplication->orderItem->financial_capability) ? App\Helpers\Functions::formatNumber($abroadApplication->orderItem->financial_capability) . '₫' : '--' }} 
                                </div>
                            </div>
                            
                        </div>

                    </div>
                  
                    <div class="d-none">
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-4">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2" for="apply-time">Thời điểm apply</label>
                                    
                                    <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" id="apply-time" name="apply_time" type="date" class="form-control" data-check-error="{{ $errors->has('apply_time') ? 'error' : 'none' }}" value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->apply_time }}>
                                        <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                    </div>
                
                                    <x-input-error :messages="$errors->get('apply_time')" class="mt-2" />
                                </div>
                            </div>
                
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-4">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2" for="estimated-enrollment-time-input">Thời gian dự kiến nhập học</label>
                                    
                                    <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" id="estimated-enrollment-time-input" name="estimated_enrollment_time" type="date" class="form-control" data-check-error="{{ $errors->has('estimated_enrollment_time') ? 'error' : 'none' }}" value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->estimated_enrollment_time }}>
                                        <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                    </div>
                
                                    <x-input-error :messages="$errors->get('estimated_enrollment_time')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                
                        
                
                        <div class="row mb-4 p-0">
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2" for="gender-select">Giới tính</label>
                                    <select id="gender-select" class="form-select form-control" name="gender" data-check-error="{{ $errors->has('gender') ? 'error' : 'none' }}"
                                        data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Chọn giới tính" data-allow-clear="true">
                                        <option value="">Chọn giới tính</option>
                                        @foreach(config('genders') as $gender)
                                        <option value="{{ $gender }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->gender == $gender ? 'selected' : '' }}>{{ $gender }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2" for="gpa-input">GPA lớp 9, 10, 11, (12)</label>
                                    <input id="gpa-input" type="text" class="form-control" name="GPA" placeholder="Nhập GPA..." data-check-error="{{ $errors->has('GPA') ? 'error' : 'none' }}" value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->GPA }}>
                                    <x-input-error :messages="$errors->get('GPA')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="standardized-score-input">Điểm thi chuẩn hóa</label>
                                    <input id="standardized-score-input" type="text" class="form-control" name="std_score"
                                        placeholder="Nhập điểm thi chuẩn hóa..." value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->std_score }}>
                                        <x-input-error :messages="$errors->get('std_score')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="english-score-input">Điểm thi tiếng anh</label>
                                    <input id="english-score-input" type="text" class="form-control" name="eng_score"
                                        placeholder="Nhập điểm thi tiếng anh..." value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->eng_score }}>
                                        <x-input-error :messages="$errors->get('eng_score')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="current-program-input">Chương trình đang học</label>
                                    <input id="current-program-input" type="text" class="form-control" name="current_program"
                                        placeholder="vd: THPT VN, IB, A-Level, Tú tài Pháp, etc..." value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->current_program }}>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2" for="plan-apply-input">Chương trình dự kiến apply</label>
                                    <input id="plan-apply-input" type="text" class="form-control" name="plan_apply" data-check-error="{{ $errors->has('plan_apply') ? 'error' : 'none' }}"
                                        placeholder="vd: Cử Nhân, Thạc Sĩ, MBA, PhD, etc..." value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->plan_apply }}>
                                        <x-input-error :messages="$errors->get('plan_apply')" class="mt-2" />
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="intended-major-input">Ngành học dự kiến ở đại
                                        học</label>
                                    <input id="intended-major-input" type="text" class="form-control" name="intended_major"
                                        placeholder="Ngành học dự kiến..." value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->intended_major }}>
                                        <x-input-error :messages="$errors->get('train_product')" class="mt-2" />
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="academic-awards-select">Các giải thưởng học thuật</label>
                                    <select list-action="marketing-type-select" class="form-select form-control" data-control="select2"
                                        data-kt-select2="true" data-placeholder="Chọn" multiple name="academic_award" data-dropdown-parent="#popupCreateAbroadUniqId">
                                        <option value="">Chọn giải thưởng học thuật</option>
                                        @foreach(config('academicAwards') as $award)
                                        <option value="{{ $award }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->academic_award == $award ? 'selected' : '' }}>{{ $award }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="postgraduate-plan-select">Kế hoạch sau đại học</label>
                                    <select id="postgraduate-plan-select" class="form-select form-control"
                                        name="postgraduate_plan" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Chọn kế hoạch sau đại học"
                                        data-allow-clear="true">
                                        <option value="">Chọn kế hoạch sau đại học</option>
                                        @foreach(config('postgraduatePlans') as $plan)
                                        <option value="{{ $plan }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->postgraduate_plan == $plan ? 'selected' : '' }}>{{ $plan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="personality-select">Bạn là kiểu người</label>
                                    <select id="personality-select" class="form-select form-control" name="personality"
                                        data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Kiểu người" data-allow-clear="true">
                                        <option value="">Chọn kiểu người của bạn</option>
                                        @foreach(config('personalities') as $personality)
                                        <option value="{{ $personality }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->personality == $personality ? 'selected' : '' }}>{{ $personality }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="subject-preferences-select">Sở thích trong các môn
                                        học</label>
                                    <select id="subject-preferences-select" class="form-select form-control"
                                        name="subject_preference" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Chọn sở thích"
                                        data-allow-clear="true">
                                        <option value="">Chọn sở thích trong các môn học</option>
                                        @foreach(config('subjectPreferences') as $interest)
                                        <option value="{{ $interest }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->subject_preference == $interest ? 'selected' : '' }}>{{ $interest }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="language-culture-select">Về ngôn ngữ và văn hóa</label>
                                    <select id="language-culture-select" class="form-select form-control"
                                        name="language_culture" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Chọn văn hóa"
                                        data-allow-clear="true">
                                        <option value="">Chọn</option>
                                        @foreach(config('languageAndCultures') as $culture)
                                        <option value="{{ $culture }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->language_culture == $culture ? 'selected' : '' }}>{{ $culture }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="is-research-select">Bạn đã tìm hiểu bộ hồ sơ online
                                        chưa</label>
                                    <select id="is-research-select" class="form-select form-control" name="research_info"
                                        data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Đã tìm hiểu hồ sơ chưa" data-allow-clear="true">
                                        <option value="">Chọn</option>
                                        @foreach(config('researchInfos') as $info)
                                        <option value="{{ $info }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->research_info == $info ? 'selected' : '' }}>{{ $info }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="aim-select">Mục tiêu mà bạn nhắm đến</label>
                                    <select list-action="marketing-type-select" class="form-select" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId"
                                        data-kt-select2="true" data-placeholder="Chọn" multiple name="aim">
                                        <option value="">Chọn mục tiêu</option>
                                        @foreach(config('aims') as $aim)
                                        <option value="{{ $aim }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->aim == $aim ? 'selected' : '' }}>{{ $aim }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="essay-writing-skill-select">Khả năng viết bài luận tiếng
                                        Anh của bạn</label>
                                    <select id="essay-writing-skill-select" class="form-select form-control"
                                        name="essay_writing_skill" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Khả năng viết bài luận tiếng Anh"
                                        data-allow-clear="true">
                                        <option value="">Chọn khả năng viết phù hợp</option>
                                        @foreach(config('essayWritingSkills') as $skill)
                                        <option value="{{ $skill }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->essay_writing_skill == $skill ? 'selected' : '' }}>{{ $skill }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="extra-activity-select">Các hoạt động ngoại khóa của
                                        bạn</label>
                                    <select id="extra-activity-select" class="form-select form-control" name="extra_activity"
                                        data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Các hoạt động ngoại khóa" data-allow-clear="true">
                                        <option value="">Chọn hoạt động</option>
                                        @foreach(config('extraActivities') as $activity)
                                        <option value="{{ $activity }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->extra_activity == $activity ? 'selected' : '' }}>{{ $activity }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="personal-counseling-need-select">Đơn hàng tư vấn cá nhân
                                        của bạn</label>
                                    <select id="personal-counseling-need-select" class="form-select form-control"
                                        name="personal_countling_need" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Đơn hàng tư vấn cá nhân"
                                        data-allow-clear="true">
                                        <option value="">Chọn đơn hàng</option>
                                        @foreach(config('personalCounselingNeeds') as $need)
                                        <option value="{{ $need }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->personal_countling_need == $need ? 'selected' : '' }}>{{ $need }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="other-need-input">Ghi chú các mong muốn khác</label>
                                    <textarea id="other-need-input" name="other_need_note" class="form-control" rows="1"
                                        placeholder="Các mong muốn khác...">{{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->intended_major }}</textarea>
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                                <div class="form-outline">
                                    <label class=" fs-6 fw-semibold mb-2" for="parent-job-select">Nghề nghiệp phụ huynh</label>
                                    <select id="parent-job-select" class="form-select form-control" name="parent_job"
                                        data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Chọn nghề nghiệp phụ huynh..." data-allow-clear="true">
                                        <option value="">Chọn nghề nghiệp phụ huynh</option>
                                        @foreach(config('parentJobs') as $job)
                                        <option value="{{ $job }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->parent_job == $job ? 'selected' : '' }}>{{ $job }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                                <div class="form-outline">
                                    <label class=" fs-6 fw-semibold mb-2" for="paren-highest-academic-select">Học vị cao nhất
                                        của bố hoặc mẹ</label>
                                    <input id="paren-highest-academic-select" type="text" class="form-control"
                                        placeholder="Học vị cao nhất của bố hoặc mẹ..." name="parent_highest_academic" value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->parent_highest_academic }}>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="parent-ever-studied-abroad-select">Bố mẹ có từng đi du
                                        học?</label>
                                    <select id="parent-ever-studied-abroad-select" class="form-select form-control"
                                        name="is_parent_studied_abroad" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Chọn trường phù hợp"
                                        data-allow-clear="true">
                                        <option value="">Chọn</option>
                                        @foreach(config('isParentStudiedAbroadOptions') as $option)
                                        <option value="{{ $option }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->is_parent_studied_abroad == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class=" fs-6 fw-semibold mb-2" for="parent-income-select">Mức thu nhập của phụ
                                        huynh</label>
                                    <select id="parent-income-select" class="form-select form-control" name="parent_income"
                                        data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId" data-placeholder="Chọn mức thu nhập của phụ huynh..."
                                        data-allow-clear="true">
                                        <option value="">Chọn mức thu nhập của phụ huynh</option>
                                        @foreach(config('parentIncomes') as $option)
                                        <option value="{{ $option }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->parent_income == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class=" fs-6 fw-semibold mb-2" for="is-parent-family-studying-abroad-select">Phụ
                                        huynh có người thân đã/đang/sắp đi du học?</label>
                                    <select id="is-parent-family-studying-abroad-select" class="form-select form-control"
                                        name="is_parent_family_studied_abroad" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId"
                                        data-placeholder="Phụ huynh có người thân đã/đang/sắp đi du học hay không?"
                                        data-allow-clear="true">
                                        <option value="">Chọn</option>
                                        <option value="true" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->parent_income == true ? 'selected' : '' }}>Có</option>
                                        <option value="false" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->parent_income == false ? 'selected' : '' }}>Không</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="fs-6 fw-semibold mb-2" for="parent-familiarity-with-studying-abroad-select">Mức am
                                        hiểu về du học của phụ huynh</label>
                                    <select id="parent-familiarity-with-studying-abroad-select" class="form-select form-control"
                                        name="parent_familiarity_abroad" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId"
                                        data-placeholder="Mức am hiểu về du học của phụ huynh" data-allow-clear="true">
                                        <option value="">Chọn mức độ am hiểu của phụ huynh</option>
                                        @foreach(config('parentFamiliarAbroad') as $option)
                                        <option value="{{ $option }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->parent_familiarity_abroad == $option ? 'selected' : '' }}>{{ $option }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class=" fs-6 fw-semibold mb-2" for="spend-time-with-child-select">Thời gian có thể
                                        đồng hành cùng con</label>
                                    <select id="spend-time-with-child-select" class="form-select form-control"
                                        name="parent_time_spend_with_child" data-control="select2" data-dropdown-parent="#popupCreateAbroadUniqId"
                                        data-placeholder="Chọn thời gian có thể đồng hành cùng con..." data-allow-clear="true">
                                        <option value="">Chọn</option>
                                        @foreach(config('parentTimeSpendWithChilds') as $option)
                                        <option value="{{ $option }}" {{ isset($abroadApplication->orderItem) && $abroadApplication->orderItem->parent_time_spend_with_child == $option ? 'selected' : '' }}>{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                
                        <div class="row mb-4">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2" for="financial-capability">Khả năng chi trả mỗi năm
                                        cho quá trình học của con (bao gồm cả học phí) (USD)</label>
                                    <input id="financial-capability" type="text" class="form-control" name="financial_capability" data-check-error="{{ $errors->has('financial_capability') ? 'error' : 'none' }}"
                                        placeholder="Khả năng chi trả (USD)..." value={{ !isset($abroadApplication->orderItem) ? '' : $abroadApplication->orderItem->financial_capability }}>
                                        <x-input-error :messages="$errors->get('financial_capability')" class="mt-2" />
                                </div>
                            </div>
                        </div>  
                    </div>
                    
                    <!--id="CreateAbroadOrderButton"-->
                    <div class="modal-footer flex-center d-none">
                        <!--begin::Button-->
                        <button id="CreateAbroadOrderButton"  type="submit" class="btn btn-primary me-3" data-action="under-construction">
                            <span class="indicator-label">Lưu thông tin dịch vụ</span>
                            <span class="indicator-progress">Đang xử lý...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                        </button>
                        <!--end::Button-->
                        <!--begin::Button-->
                        <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                            data-bs-dismiss="modal">Hủy</button>
                        <!--end::Button-->
                    </div>
                </div>
            </form>
            <!--end::Card body-->
        </div>
        <!--end::details View-->


    </div>
    <!--end::Post-->

    
@endsection
