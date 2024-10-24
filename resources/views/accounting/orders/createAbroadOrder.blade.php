@extends('layouts.main.popup')

@section('title')
{{ !isset($orderItem) ? 'Thêm: Dịch vụ du học' : 'Sửa: Dịch vụ du học' }}
@endsection

@section('content')
<form id="AbroadFormManage" tabindex="-1">
    @csrf
    <div class="scroll-y px-7 py-10 px-lg-17">
        <input class="type-input" type="hidden" name="type" value="Du học">
        <div class="row mb-4">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="train-product-type">Phân loại</label>
                        <select id="product-type" class="form-select form-control" name="order_type"
                            data-control="select2" data-placeholder="Chọn dịch vụ..." data-allow-clear="true" data-dropdown-parent="#AbroadFormManage">
                        </select>
                    </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="product-select">Dịch vụ du học</label>
                    <select id="product-select" class="form-select form-control" name="abroad_product"
                        data-control="select2" data-placeholder="Chọn dịch vụ..." data-allow-clear="true">
                        <option value="">Chọn dịch vụ</option>
                        @foreach(config('abroadProducts') as $product)
                        <option value="{{ $product }}" {{ isset($orderItem) && $orderItem->abroad_product == $product ? 'selected' : '' }}>{{ $product }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('abroad_product')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="apply-time">Thời điểm apply</label>
                    
                    <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                        <input data-control="input" id="apply-time" name="apply_time" type="date" class="form-control" value={{ !isset($orderItem) ? '' : $orderItem->apply_time }}>
                        <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                    </div>

                    <x-input-error :messages="$errors->get('apply_time')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="school-nums-apply">Số trường apply</label>
                    <input id="school-nums-apply" type="number" class="form-control" name="num_of_school_apply" min="0"
                        placeholder="Nhập số trường apply..." value={{ !isset($orderItem) ? '' : $orderItem->num_of_school_apply }}>
                        <x-input-error :messages="$errors->get('num_of_school_apply')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="top-school-select">Top trường</label>
                    <select id="top-school-select" class="form-select form-control" name="top_school"
                        data-control="select2" data-placeholder="Chọn top trường" data-allow-clear="true">
                        <option value="">Chọn top trường</option>
                        @foreach(config('topSchools') as $top)
                        <option value="{{ $top }}" {{ isset($orderItem) && $orderItem->top_school == $top ? 'selected' : '' }}>{{ $top }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>


        <div class="row mb-4">
            <div class="col-lg-2 col-md-2 col-sm-10 col-10 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="price-create-input">Giá bán</label>
                    <input id="price-create-input" type="text" class="form-control"
                        placeholder="Nhập giá bán..." name="price" value="{{ !isset($orderItem) ? '' : "$orderItem->price" }}">
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            <label id="error-price" class="fs-7 fw-semibold mb-2 text-danger d-none">Giá bán không hợp lệ</label>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-2 mb-2 mt-8">
                <div class="form-outline">
                        <select id="currency-select" class="form-select form-control" name="currency_code"
                            data-control="select" data-dropdown-parent="#AbroadFormManage">
                            @foreach(config('currencies') as $currency)
                            <option {{ $orderItem && $currency == $orderItem->currency_code ? 'selected' : '' }} value="{{ $currency }}">{{ $currency }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-10 col-10 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="discount-create-input">Tỷ lệ khuyến mãi</label>
                    <input id="discount-create-input" class="form-control" name="discount_code" type="number" min="0" max="100"
                        placeholder="Nhập khuyến mãi..." value={{ !isset($orderItem) ? '' : $orderItem->discount_code }}>
                        <label id="error-discount-percent" class="fs-7 fw-semibold mb-2 text-danger d-none">Tỷ lệ khuyến mãi không hợp lệ</label>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-2 col-2 mb-2">
                <label list-symbol="percent" class="fs-6 fw-semibold mt-12">%</label>
            </div>
        </div>

        <div class="row mb-4">
            <div id="exchange-form" class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2 d-none">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="exchange-input">Tỷ giá quy đổi (Nếu giá USD)</label>
                    <input id="exchange-input" class="form-control" name="exchange" value={{ !isset($orderItem) ? '' : $orderItem->exchange }}
                        placeholder="Nhập tỷ giá...">
                        <label id="error-exchange" class="fs-7 fw-semibold mb-2 text-danger">Tỷ giá quy đổi không hợp lệ</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-10 col-10 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="price-after-discount">giá bán sau khuyến mãi (VND)</label>
                    <div id="price-after-discount" class="form-control">{{ !isset($orderItem) ? '0' : App\Helpers\Functions::formatNumber($orderItem->price) }}</div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-2 col-2 mb-2">
                <label list-symbol="currency" class="fs-6 fw-semibold mt-12">₫</label>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 col-xl-12">
                <label class="fs-6 fw-semibold mb-2" for="target-input">Tiến độ thanh toán</label>
                <input data-action="check-pay-all" type="checkbox" class="ms-2" id="is-payall-checkbox"> Thanh toán 1 lần
                <div id="schedule-payment-form" class="card p-5">
                    <div class="row">
                        <div id="form1" class="col-lg-8 col-md-12 col-sm-12 col-12 col-xl-8 col-xs-12 mb-2 pe-16 border-end">
                            <div class="row mb-3">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                                    <div class="form-outline">
                                        <label class="required fs-6 fw-semibold mb-2" for="schedule-price-input">Giá hợp đồng</label>
                                        <input id="schedule-price-input" type="text" class="form-control"
                                            placeholder="Nhập giá hợp đồng...">
                                            <label id="error-price-schedule" class="fs-7 fw-semibold mb-2 text-danger d-none">Giá không hợp lệ</label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-12 mb-2">
                                    <div class="form-outline">
                                        <label class="required fs-6 fw-semibold mb-2" for="schedule-date-input">Hạn thanh toán</label>
                                        <input id="schedule-date-input" type="date" class="form-control"
                                            placeholder="Hạn thanh toán...">
                                            <label id="error-date-schedule" class="fs-7 fw-semibold mb-2 text-danger d-none">Ngày thanh toán không hợp lệ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-between">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div id="add-schedule-btn" class="btn btn-secondary w-75 btn-sm d-flex align-items-center justify-content-center">
                                        <span class="material-symbols-rounded">add</span>
                                        &nbsp;Thêm tiến độ
                                    </div>
                                </div>

                                <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 d-flex justify-content-end align-items-center">
                                            <label class="fs-6 fw-semibold" for="balance-form">Số tiền còn lại</label>
                                        </div>
                                        
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7">
                                            <div class="form-outline">
                                                <div id="balance-form" class="form-control">0</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 mb-2">
                                            <label list-symbol="currency" class="fs-6 fw-semibold mt-3">₫</label>
                                        </div>
                                    </div>
                                    <label id="error-balance-schedule" class="fs-7 fw-semibold mb-2 text-danger text-center w-100 d-none">Hello world</label>
                                </div>

                            </div>
                        </div>
                        <div id="form2" class="col-lg-4 col-md-12 col-sm-12 col-12 col-xl-4 col-xs-12 mb-2">
                            <ul id="list-schedule-items-content" class="list-group list-group-flush">

                                {{--  --}}

                            </ul>
                        </div>
                    </div>
                </div>
            </div>            
        </div>

















        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="gender-select">Giới tính</label>
                    <select id="gender-select" class="form-select form-control" name="gender"
                        data-control="select2" data-placeholder="Chọn giới tính" data-allow-clear="true">
                        <option value="">Chọn giới tính</option>
                        @foreach(config('genders') as $gender)
                        <option value="{{ $gender }}" {{ isset($orderItem) && $orderItem->gender == $gender ? 'selected' : '' }}>{{ $gender }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="gpa-input">GPA lớp 9, 10, 11, (12)</label>
                    <input id="gpa-input" type="text" class="form-control" name="GPA" placeholder="Nhập GPA..." value={{ !isset($orderItem) ? '' : $orderItem->GPA }}>
                    <x-input-error :messages="$errors->get('GPA')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="standardized-score-input">Điểm thi chuẩn hóa</label>
                    <input id="standardized-score-input" type="text" class="form-control" name="std_score"
                        placeholder="Nhập điểm thi chuẩn hóa..." value={{ !isset($orderItem) ? '' : $orderItem->std_score }}>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="english-score-input">Điểm thi tiếng anh</label>
                    <input id="english-score-input" type="text" class="form-control" name="eng_score"
                        placeholder="Nhập điểm thi tiếng anh..." value={{ !isset($orderItem) ? '' : $orderItem->eng_score }}>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="current-program-input">Chương trình đang học</label>
                    <input id="current-program-input" type="text" class="form-control" name="current_program"
                        placeholder="vd: THPT VN, IB, A-Level, Tú tài Pháp, etc..." value={{ !isset($orderItem) ? '' : $orderItem->current_program }}>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="plan-apply-input">Chương trình dự kiến apply</label>
                    <input id="plan-apply-input" type="text" class="form-control" name="plan_apply"
                        placeholder="vd: Cử Nhân, Thạc Sĩ, MBA, PhD, etc..." value={{ !isset($orderItem) ? '' : $orderItem->plan_apply }}>
                        <x-input-error :messages="$errors->get('plan_apply')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="intended-major-input">Ngành học dự kiến ở đại
                        học</label>
                    <input id="intended-major-input" type="text" class="form-control" name="intended_major"
                        placeholder="Ngành học dự kiến..." value={{ !isset($orderItem) ? '' : $orderItem->intended_major }}>
                        <x-input-error :messages="$errors->get('train_product')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="academic-awards-select">Các giải thưởng học thuật</label>
                    <select list-action="marketing-type-select" class="form-select" data-control="select2"
                        data-kt-select2="true" data-placeholder="Chọn" multiple name="academic_award">
                        <option value="">Chọn giải thưởng học thuật</option>
                        @foreach(config('academicAwards') as $award)
                        <option value="{{ $award }}" {{ isset($orderItem) && $orderItem->academic_award == $award ? 'selected' : '' }}>{{ $award }}</option>
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
                        name="postgraduate_plan" data-control="select2" data-placeholder="Chọn kế hoạch sau đại học"
                        data-allow-clear="true">
                        <option value="">Chọn kế hoạch sau đại học</option>
                        @foreach(config('postgraduatePlans') as $plan)
                        <option value="{{ $plan }}" {{ isset($orderItem) && $orderItem->postgraduate_plan == $plan ? 'selected' : '' }}>{{ $plan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="personality-select">Bạn là kiểu người</label>
                    <select id="personality-select" class="form-select form-control" name="personality"
                        data-control="select2" data-placeholder="Kiểu người" data-allow-clear="true">
                        <option value="">Chọn kiểu người của bạn</option>
                        @foreach(config('personalities') as $personality)
                        <option value="{{ $personality }}" {{ isset($orderItem) && $orderItem->personality == $personality ? 'selected' : '' }}>{{ $personality }}</option>
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
                        name="subject_preference" data-control="select2" data-placeholder="Chọn sở thích"
                        data-allow-clear="true">
                        <option value="">Chọn sở thích trong các môn học</option>
                        @foreach(config('subjectPreferences') as $interest)
                        <option value="{{ $interest }}" {{ isset($orderItem) && $orderItem->subject_preference == $interest ? 'selected' : '' }}>{{ $interest }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="language-culture-select">Về ngôn ngữ và văn hóa</label>
                    <select id="language-culture-select" class="form-select form-control"
                        name="language_culture" data-control="select2" data-placeholder="Chọn văn hóa"
                        data-allow-clear="true">
                        <option value="">Chọn</option>
                        @foreach(config('languageAndCultures') as $culture)
                        <option value="{{ $culture }}" {{ isset($orderItem) && $orderItem->language_culture == $culture ? 'selected' : '' }}>{{ $culture }}</option>
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
                        data-control="select2" data-placeholder="Đã tìm hiểu hồ sơ chưa" data-allow-clear="true">
                        <option value="">Chọn</option>
                        @foreach(config('researchInfos') as $info)
                        <option value="{{ $info }}" {{ isset($orderItem) && $orderItem->research_info == $info ? 'selected' : '' }}>{{ $info }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="aim-select">Mục tiêu mà bạn nhắm đến</label>
                    <select list-action="marketing-type-select" class="form-select" data-control="select2"
                        data-kt-select2="true" data-placeholder="Chọn" multiple name="aim">
                        <option value="">Chọn mục tiêu</option>
                        @foreach(config('aims') as $aim)
                        <option value="{{ $aim }}" {{ isset($orderItem) && $orderItem->aim == $aim ? 'selected' : '' }}>{{ $aim }}</option>
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
                        name="essay_writing_skill" data-control="select2" data-placeholder="Khả năng viết bài luận tiếng Anh"
                        data-allow-clear="true">
                        <option value="">Chọn khả năng viết phù hợp</option>
                        @foreach(config('essayWritingSkills') as $skill)
                        <option value="{{ $skill }}" {{ isset($orderItem) && $orderItem->essay_writing_skill == $skill ? 'selected' : '' }}>{{ $skill }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="extra-activity-select">Các hoạt động ngoại khóa của bạn</label>
                    <select id="extra-activity-select" class="form-select form-control" name="extra_activity"
                        data-control="select2" data-placeholder="Các hoạt động ngoại khóa" data-allow-clear="true">
                        <option value="">Chọn hoạt động</option>
                        @foreach(config('extraActivities') as $activity)
                        <option value="{{ $activity }}" {{ isset($orderItem) && $orderItem->extra_activity == $activity ? 'selected' : '' }}>{{ $activity }}</option>
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
                        name="personal_countling_need" data-control="select2" data-placeholder="Đơn hàng tư vấn cá nhân"
                        data-allow-clear="true">
                        <option value="">Chọn đơn hàng</option>
                        @foreach(config('personalCounselingNeeds') as $need)
                        <option value="{{ $need }}" {{ isset($orderItem) && $orderItem->personal_countling_need == $need ? 'selected' : '' }}>{{ $need }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="other-need-input">Ghi chú các mong muốn khác</label>
                    <textarea id="other-need-input" name="other_need_note" class="form-control" rows="1"
                        placeholder="Các mong muốn khác...">{{ !isset($orderItem) ? '' : $orderItem->intended_major }}</textarea>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class=" fs-6 fw-semibold mb-2" for="parent-job-select">Nghề nghiệp phụ huynh</label>
                    <select id="parent-job-select" class="form-select form-control" name="parent_job"
                        data-control="select2" data-placeholder="Chọn nghề nghiệp phụ huynh..." data-allow-clear="true">
                        <option value="">Chọn nghề nghiệp phụ huynh</option>
                        @foreach(config('parentJobs') as $job)
                        <option value="{{ $job }}" {{ isset($orderItem) && $orderItem->parent_job == $job ? 'selected' : '' }}>{{ $job }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class=" fs-6 fw-semibold mb-2" for="paren-highest-academic-select">Học vị cao nhất
                        của bố hoặc mẹ</label>
                    <input id="paren-highest-academic-select" type="text" class="form-control"
                        placeholder="Học vị cao nhất của bố hoặc mẹ..." name="parent_highest_academic" value="{{ !isset($orderItem) ? '' : $orderItem->parent_highest_academic }}">
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="parent-ever-studied-abroad-select">Bố mẹ có từng đi du
                        học?</label>
                    <select id="parent-ever-studied-abroad-select" class="form-select form-control"
                        name="is_parent_studied_abroad" data-control="select2" data-placeholder="Chọn trường phù hợp"
                        data-allow-clear="true">
                        <option value="">Chọn</option>
                        @foreach(config('isParentStudiedAbroadOptions') as $option)
                        <option value="{{ $option }}" {{ isset($orderItem) && $orderItem->is_parent_studied_abroad == $option ? 'selected' : '' }}>{{ $option }}</option>
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
                        data-control="select2" data-placeholder="Chọn mức thu nhập của phụ huynh..."
                        data-allow-clear="true">
                        <option value="">Chọn mức thu nhập của phụ huynh</option>
                        @foreach(config('parentIncomes') as $option)
                        <option value="{{ $option }}" {{ isset($orderItem) && $orderItem->parent_income == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class=" fs-6 fw-semibold mb-2" for="is-parent-family-studying-abroad-select">Phụ
                        huynh có người thân đã/đang/sắp đi du học?</label>
                    <select id="is-parent-family-studying-abroad-select" class="form-select form-control"
                        name="is_parent_family_studied_abroad" data-control="select2"
                        data-placeholder="Phụ huynh có người thân đã/đang/sắp đi du học hay không?"
                        data-allow-clear="true">
                        <option value="">Chọn</option>
                        <option value="true" {{ isset($orderItem) && $orderItem->is_parent_family_studied_abroad == true ? 'selected' : '' }}>Có</option>
                        <option value="false" {{ isset($orderItem) && $orderItem->is_parent_family_studied_abroad == false ? 'selected' : '' }}>Không</option>
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
                        name="parent_familiarity_abroad" data-control="select2"
                        data-placeholder="Mức am hiểu về du học của phụ huynh" data-allow-clear="true">
                        <option value="">Chọn mức độ am hiểu của phụ huynh</option>
                        @foreach(config('parentFamiliarAbroad') as $option)
                        <option value="{{ $option }}" {{ isset($orderItem) && $orderItem->parent_familiarity_abroad == $option ? 'selected' : '' }}>{{ $option }}>{{ $option }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class=" fs-6 fw-semibold mb-2" for="spend-time-with-child-select">Thời gian có thể
                        đồng hành cùng con</label>
                    <select id="spend-time-with-child-select" class="form-select form-control"
                        name="parent_time_spend_with_child" data-control="select2"
                        data-placeholder="Chọn thời gian có thể đồng hành cùng con..." data-allow-clear="true">
                        <option value="">Chọn</option>
                        @foreach(config('parentTimeSpendWithChilds') as $option)
                        <option value="{{ $option }}" {{ isset($orderItem) && $orderItem->parent_time_spend_with_child == $option ? 'selected' : '' }}>{{ $option }}</option>
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
                    <input id="financial-capability" type="text" class="form-control" name="financial_capability"
                        placeholder="Khả năng chi trả (USD)..." value={{ !isset($orderItem) ? '' : $orderItem->financial_capability }}>
                        <x-input-error :messages="$errors->get('financial_capability')" class="mt-2" />
                </div>
            </div>
        </div>


        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateCustomerSubmitButton" type="submit" class="btn btn-primary">
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

<script>
    $(() => {
        AbroadFormManage.init();
        ServiceHandle.init();

        initJs(document.querySelector('#AbroadFormManage'));
    });

    var AbroadFormManage = function() {
        let abroadOrderPriceManager;
        let form;

        const getOrderItem = () => {

            let scheduleItems = null;

            @if($orderItem && $orderItem != null && $orderItem->schedule_items)

            scheduleItems = JSON.parse({!! json_encode($orderItem->schedule_items) !!})

            if(scheduleItems !== null && scheduleItems) {
                for (let i = 0; i < scheduleItems.length; i++) {
                    scheduleItems[i] = JSON.parse(scheduleItems[i]);
                }
            }
            @endif

            return scheduleItems;
        }
        
        return {
            init: () => {
                form = new OrderForm({
                    form: $("#AbroadFormManage"),
                    containerId: '#AbroadFormManage',
                    url: "{{ action('App\Http\Controllers\Accounting\OrderController@saveOrderItemData') }}",
                    submitBtnId: "CreateCustomerSubmitButton",
                    popup: AddAbroadOrderPopup.getPopup(),
                    orderItemId: "{{ !isset($orderItem) ? null : $orderItemId }}"
                });

                abroadOrderPriceManager = new PriceManager({
                    container: document.querySelector('#AbroadFormManage'),
                    orderItemScheduleList: getOrderItem()
                });   
            }

        }
    }();    

    var ServiceHandle = function() {
        let currType = document.querySelector('.type-input').value;

        return {
            init: () => {
                servicesManager.setCurrServiceType(currType);
            }
        };
    }();
</script>
@endsection