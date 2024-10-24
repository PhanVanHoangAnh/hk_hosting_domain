@extends('layouts.main.popup')

@section('title')
Sửa: Dịch vụ du học
@endsection

@php
    $popupEditAbroadUniqId = 'popupEditAbroadItem_' . uniqid();
@endphp

@section('content')
<div>
    <form tabindex="-1" id="{{ $popupEditAbroadUniqId }}">
        @csrf
        <div class="scroll-y px-7 py-10 px-lg-17">
            <input class="type-input" type="hidden" name="type" value="{{ App\Models\Order::TYPE_ABROAD }}">
            <input class="type-input" type="hidden" name="abroad_application_id" value="{{ $abroadApplication->id }}">
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="apply-time">Thời điểm apply</label>
                        
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" id="apply-time" name="apply_time" type="date" class="form-control" data-check-error="{{ $errors->has('apply_time') ? 'error' : 'none' }}" value={{ !isset($abroadApplication) ? '' : $abroadApplication->apply_time }}>
                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                        </div>
                        <x-input-error :messages="$errors->get('apply_time')" class="mt-2"/>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-4">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="estimated-enrollment-time-input">Thời gian dự kiến nhập học</label>
                        
                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" id="estimated-enrollment-time-input" name="estimated_enrollment_time" type="date" class="form-control" data-check-error="{{ $errors->has('estimated_enrollment_time') ? 'error' : 'none' }}" value={{ !isset($abroadApplication) ? '' : $abroadApplication->estimated_enrollment_time }}>
                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                        </div>
                        <x-input-error :messages="$errors->get('estimated_enrollment_time')" class="mt-2"/>
                    </div>
                </div>
            </div>
    
            <div class="row card my-10" form-control="topSchoolTool">
                <table class="table border-10 w-100">
                    <thead>
                        <tr>
                            <th class="text-center col fs-6" colspan="2">Số trường apply</th>
                            <th class="text-center col fs-6" colspan="2" >Top trường</th>
                            <th class="text-center col fs-6" colspan="6" rowspan="2">Quốc gia</th>
                            <th class="text-center col fs-6" rowspan="2"></th>
                        </tr>
                        <tr>
                            <th class="text-center col fs-6">Từ</th>
                            <th class="text-center col fs-6">Đến</th>
                            <th class="text-center col fs-6">Từ</th>
                            <th class="text-center col fs-6">Đến</th>
                        </tr>
                    </thead>
                    <tbody form-control="top-school-table-body">
                    </tbody>
                </table>
                <div class="text-danger text-center my-6 d-none" data-control="error-label"></div>
                <div class="row d-flex justify-content-center mb-5">
                    <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                        <button class="btn btn-info w-100" action-control="addTopSchoolRow">
                            <span class="material-symbols-rounded fs-50">add</span>
                        </button>
                    </div>
                </div>
                <input type="hidden" name="top_school" value="">
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-3 col-md-3 col-sm-3 col-3 my-5">
                    <div class="accordion" id="gpa_accordian">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingGpa">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGpa" aria-expanded="false" aria-controls="collapseGpa">
                                <label class="fs-6 fw-semibold mb-2 text-dark">GPA</label>
                            </button>
                            </h2>
                            <div id="collapseGpa" class="accordion-collapse collapse" aria-labelledby="headingGpa" data-bs-parent="#gpa_accordian">
                                <div class="accordion-body">
                                    @include('generals.orders._gpas')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-5 my-5">
                    <div class="accordion" id="academic_award_accordian">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                <label class="fs-6 fw-semibold mb-2 text-dark">Các giải thưởng học thuật</label>
                            </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#academic_award_accordian">
                                <div class="accordion-body">
                                    @include('generals.orders._academicAwards')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-4 col-sm-4 col-4 my-4">
                    <div class="accordion" id="extra_activity_accordian">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <label class="fs-6 fw-semibold mb-2 text-dark">Các hoạt động ngoại khóa</label>
                            </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#extra_activity_accordian">
                                <div class="accordion-body">
                                    @include('generals.orders._extraActivities')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mb-4 p-0">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="standardized-score-input">Điểm thi chuẩn hóa</label>
                        <input id="standardized-score-input" type="text" class="form-control" name="std_score"
                            placeholder="Nhập điểm thi chuẩn hóa..." value={{ !isset($abroadApplication) ? '' : $abroadApplication->std_score }}>
                            <x-input-error :messages="$errors->get('std_score')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="english-score-input">Điểm thi tiếng anh</label>
                        <input id="english-score-input" type="text" class="form-control" name="eng_score"
                            placeholder="Nhập điểm thi tiếng anh..." value={{ !isset($abroadApplication) ? '' : $abroadApplication->eng_score }}>
                            <x-input-error :messages="$errors->get('eng_score')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="current-program-select">Chương trình đang học</label>
                        <select id="current-program-select" class="form-select form-control"
                            name="current_program_id" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Chọn chương trình học hiện tại"
                            data-allow-clear="true">
                            <option value="">Chọn chương trình học hiện tại</option>
                            @foreach(\App\Models\CurrentProgram::all() as $currentProgram)
                                <option value="{{ $currentProgram->id }}" {{ isset($abroadApplication->current_program_id) && $abroadApplication->current_program_id == $currentProgram->id ? 'selected' : '' }}>{{ $currentProgram->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('current_program_id')" class="mt-2"/>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="plan-apply-select">Chương trình dự kiến apply</label>
                        <select id="plan-apply-select" class="form-select form-control"
                            name="plan_apply_program_id" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Chọn chương trình dự kiến apply"
                            data-allow-clear="true">
                            <option value="">Chọn chương trình dự kiến apply</option>
                            @foreach(\App\Models\PlanApplyProgram::all() as $planApplyProgram)
                                <option value="{{ $planApplyProgram->id }}" {{ isset($abroadApplication->plan_apply_program_id) && $abroadApplication->plan_apply_program_id == $planApplyProgram->id ? 'selected' : '' }}>{{ $planApplyProgram->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('plan_apply_program_id')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="intended-major-select">Ngành học dự kiến apply</label>
                        <select id="intended-major-select" class="form-select form-control"
                            name="intended_major_id" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Chọn Ngành học dự kiến apply"
                            data-allow-clear="true">
                            <option value="">Chọn Ngành học dự kiến apply</option>
                            @foreach(\App\Models\IntendedMajor::all() as $intendedMajor)
                                <option value="{{ $intendedMajor->id }}" {{ isset($abroadApplication->intended_major_id) && $abroadApplication->intended_major_id == $intendedMajor->id ? 'selected' : '' }}>{{ $intendedMajor->name }}</option>
                            @endforeach
                        </select>
                            <x-input-error :messages="$errors->get('train_product')" class="mt-2"/>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="postgraduate-plan-select">Kế hoạch sau đại học</label>
                        <select id="postgraduate-plan-select" class="form-select form-control"
                            name="postgraduate_plan" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Chọn kế hoạch sau đại học"
                            data-allow-clear="true">
                            <option value="">Chọn kế hoạch sau đại học</option>
                            @foreach(config('postgraduatePlans') as $plan)
                            <option value="{{ $plan }}" {{ isset($abroadApplication) && $abroadApplication->postgraduate_plan == $plan ? 'selected' : '' }}>{{ $plan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="personality-select">Bạn là kiểu người</label>
                        <select id="personality-select" class="form-select form-control" name="personality"
                            data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Kiểu người" data-allow-clear="true">
                            <option value="">Chọn kiểu người của bạn</option>
                            @foreach(config('personalities') as $personality)
                            <option value="{{ $personality }}" {{ isset($abroadApplication) && $abroadApplication->personality == $personality ? 'selected' : '' }}>{{ $personality }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="subject-preferences-select">Sở thích trong các môn học</label>
                        <select id="subject-preferences-select" class="form-select form-control"
                            name="subject_preference" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Chọn sở thích"
                            data-allow-clear="true">
                            <option value="">Chọn sở thích trong các môn học</option>
                            @foreach(config('subjectPreferences') as $interest)
                                <option value="{{ $interest }}" {{ isset($abroadApplication) && $abroadApplication->subject_preference == $interest ? 'selected' : '' }}>{{ $interest }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="language-culture-select">Về ngôn ngữ và văn hóa</label>
                        <select id="language-culture-select" class="form-select form-control"
                            name="language_culture" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Chọn văn hóa"
                            data-allow-clear="true">
                            <option value="">Chọn</option>
                            @foreach(config('languageAndCultures') as $culture)
                                <option value="{{ $culture }}" {{ isset($abroadApplication) && $abroadApplication->language_culture == $culture ? 'selected' : '' }}>{{ $culture }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="is-research-select">Bạn đã tìm hiểu bộ hồ sơ online chưa</label>
                        <select id="is-research-select" class="form-select form-control" name="research_info"
                            data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Đã tìm hiểu hồ sơ chưa" data-allow-clear="true">
                            <option value="">Chọn</option>
                            @foreach(config('researchInfos') as $info)
                                <option value="{{ $info }}" {{ isset($abroadApplication) && $abroadApplication->research_info == $info ? 'selected' : '' }}>{{ $info }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="aim-select">Mục tiêu mà bạn nhắm đến</label>
                        <select list-action="marketing-type-select" class="form-select" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}"
                            data-kt-select2="true" data-placeholder="Chọn" name="aim">
                            <option value="">Chọn mục tiêu</option>
                            @foreach(config('aims') as $aim)
                                <option value="{{ $aim }}" {{ isset($abroadApplication) && $abroadApplication->aim == $aim ? 'selected' : '' }}>{{ $aim }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="personal-counseling-need-select">Đơn hàng tư vấn cá nhân của bạn</label>
                        <select id="personal-counseling-need-select" class="form-select form-control"
                            name="personal_countling_need" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Đơn hàng tư vấn cá nhân"
                            data-allow-clear="true">
                            <option value="">Chọn đơn hàng</option>
                            @foreach(config('personalCounselingNeeds') as $need)
                                <option value="{{ $need }}" {{ isset($abroadApplication) && $abroadApplication->personal_countling_need == $need ? 'selected' : '' }}>{{ $need }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="other-need-input">Ghi chú các mong muốn khác</label>
                        <textarea id="other-need-input" name="other_need_note" class="form-control" rows="1"
                            placeholder="Các mong muốn khác...">{{ !isset($abroadApplication) ? '' : $abroadApplication->other_need_note }}</textarea>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="essay-writing-skill-select">Khả năng viết bài luận tiếng Anh của bạn</label>
                        <select id="essay-writing-skill-select" class="form-select form-control"
                            name="essay_writing_skill" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Khả năng viết bài luận tiếng Anh"
                            data-allow-clear="true">
                            <option value="">Chọn khả năng viết phù hợp</option>
                            @foreach(config('essayWritingSkills') as $skill)
                            <option value="{{ $skill }}" {{ isset($abroadApplication) && $abroadApplication->essay_writing_skill == $skill ? 'selected' : '' }}>{{ $skill }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="ccol-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="parent-job-select">Nghề nghiệp phụ huynh</label>
                        <select id="parent-job-select" class="form-select form-control" name="parent_job"
                            data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Chọn nghề nghiệp phụ huynh..." data-allow-clear="true">
                            <option value="">Chọn nghề nghiệp phụ huynh</option>
                            @foreach(config('parentJobs') as $job)
                            <option value="{{ $job }}" {{ isset($abroadApplication) && $abroadApplication->parent_job == $job ? 'selected' : '' }}>{{ $job }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="ccol-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="paren-highest-academic-select">Học vị cao nhất
                            của bố hoặc mẹ</label>
                        <input id="paren-highest-academic-select" type="text" class="form-control"
                            placeholder="Học vị cao nhất của bố hoặc mẹ..." name="parent_highest_academic" value={{ !isset($abroadApplication) ? '' : $abroadApplication->parent_highest_academic }}>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="parent-ever-studied-abroad-select">Bố mẹ có từng đi du học?</label>
                        <select id="parent-ever-studied-abroad-select" class="form-select form-control"
                            name="is_parent_studied_abroad" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Chọn trường phù hợp"
                            data-allow-clear="true">
                            <option value="">Chọn</option>
                            @foreach(config('isParentStudiedAbroadOptions') as $option)
                            <option value="{{ $option }}" {{ isset($abroadApplication) && $abroadApplication->is_parent_studied_abroad == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="parent-income-select">Mức thu nhập của phụ huynh</label>
                        <select id="parent-income-select" class="form-select form-control" name="parent_income"
                            data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}" data-placeholder="Chọn mức thu nhập của phụ huynh..."
                            data-allow-clear="true">
                            <option value="">Chọn mức thu nhập của phụ huynh</option>
                            @foreach(config('parentIncomes') as $option)
                            <option value="{{ $option }}" {{ isset($abroadApplication) && $abroadApplication->parent_income == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="is-parent-family-studying-abroad-select">Phụ huynh có người thân đã/đang/sắp đi du học?</label>
                        <select id="is-parent-family-studying-abroad-select" class="form-select form-control"
                            name="is_parent_family_studied_abroad" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}"
                            data-placeholder="Phụ huynh có người thân đã/đang/sắp đi du học hay không?"
                            data-allow-clear="true">
                            <option value="">Chọn</option>
                            <option value="true" {{ isset($abroadApplication) && $abroadApplication->is_parent_family_studied_abroad == true ? 'selected' : '' }}>Có</option>
                            <option value="false" {{ isset($abroadApplication) && $abroadApplication->is_parent_family_studied_abroad == false ? 'selected' : '' }}>Không</option>
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="parent-familiarity-with-studying-abroad-select">Mức am hiểu về du học của phụ huynh</label>
                        <select id="parent-familiarity-with-studying-abroad-select" class="form-select form-control"
                            name="parent_familiarity_abroad" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}"
                            data-placeholder="Mức am hiểu về du học của phụ huynh" data-allow-clear="true">
                            <option value="">Chọn mức độ am hiểu của phụ huynh</option>
                            @foreach(config('parentFamiliarAbroad') as $option)
                                <option option value="{{ $option }}" {{ isset($abroadApplication) && $abroadApplication->parent_familiarity_abroad == $option ? 'selected' : '' }}>{{ $option }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="spend-time-with-child-select">Thời gian có thể đồng hành cùng con</label>
                        <select id="spend-time-with-child-select" class="form-select form-control"
                            name="parent_time_spend_with_child" data-control="select2" data-dropdown-parent="#{{ $popupEditAbroadUniqId }}"
                            data-placeholder="Chọn thời gian có thể đồng hành cùng con..." data-allow-clear="true">
                            <option value="">Chọn</option>
                            @foreach(config('parentTimeSpendWithChilds') as $option)
                            <option value="{{ $option }}" {{ isset($abroadApplication) && $abroadApplication->parent_time_spend_with_child == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="financial-capability">Khả năng chi trả mỗi năm cho quá trình học của con (bao gồm cả học phí) (USD)</label>
                        <input id="financial-capability" type="text" class="form-control" name="financial_capability" data-check-error="{{ $errors->has('financial_capability') ? 'error' : 'none' }}"
                            placeholder="Khả năng chi trả (USD)..." value={{ !isset($abroadApplication) ? '' : $abroadApplication->financial_capability }}>
                            <x-input-error :messages="$errors->get('financial_capability')" class="mt-2"/>
                    </div>
                </div>
            </div>

            <div class="modal-footer flex-center">
                <!--begin::Button-->
                @php
                    $editAbroadItemBtnId = "edit_abroad_item_btn_id_" . uniqId();
                @endphp
                <button id="{{ $editAbroadItemBtnId }}"  type="submit" class="btn btn-primary">
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
</div>

<script>
    var topSchoolTool;

    $(() => {
        AbroadFormManage.init();

        topSchoolTool = new TopSchoolTool({
            container: document.querySelector('#{{ $popupEditAbroadUniqId }}')
        })
    });

    var AbroadFormManage = function() {
        let abroadOrderPriceManager;
        let form;
        let scrollToErrorManager;

        const getOrderItem = () => {
            let scheduleItems = null;

            @if($abroadApplication && $abroadApplication != null && $abroadApplication->schedule_items)

            scheduleItems = JSON.parse({!! json_encode($abroadApplication->schedule_items) !!})

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
                    form: $("#{{ $popupEditAbroadUniqId }}"),
                    containerId: '#{{ $popupEditAbroadUniqId }}',   
                    url: "{{ action('App\Http\Controllers\Sales\OrderController@saveOrderItemData') }}",
                    submitBtnId: "{{ $editAbroadItemBtnId }}",
                    popup: editAbroadItemPopup,
                    orderItemId: "{{ !isset($orderItem) ? null : $orderItemId }}"
                });

                const financialCapabilityInputMask = IMask(document.querySelector('#financial-capability'), {
                    mask: Number,
                    scale: 2,
                    thousandsSeparator: '.',
                    padFractionalZeros: false,
                    normalizeZeros: true,
                    radix: ',',
                    mapToRadix: ['.'],
                    min: 0,
                    max: 9999999999999999999999,
                });

                // scrollToErrorManager = new ScrollToErrorManager({
                //     container: document.querySelector('#{{ $popupEditAbroadUniqId }}')
                // });

                // IMask(document.querySelector('[data-control="price-input"]'), {
                //     mask: Number,
                //     scale: 2,
                //     thousandsSeparator: ',',
                //     padFractionalZeros: false,
                //     normalizeZeros: true,
                //     radix: ',',
                //     mapToRadix: ['.'],
                //     min: 0,
                //     max: 999999999999,
                // });
            }
        }
    }();

    var OrderForm = class {
        #url = "{{ action('App\Http\Controllers\Abroad\AbroadController@saveAbroadItemData') }}";
        #orderId = "{{ $orderId }}";

        constructor(options) {
            this.form = options.form;
            this.submitBtnId = options.submitBtnId;
            this.popup = options.popup;
            this.orderItemId = options.orderItemId;
            this.orderFormEvents();
        };

        getFormData() {
            return this.form.serialize();
        };

        getSaveDataBtn() {
            return document.querySelector(`#${this.submitBtnId}`);
        };

        loadOrderItemsContent(content) {
            let updateContent = $(content).find('#orderItemsListContent');
            let updatePriceContent = $(content).find('#finalPriceContainer');

            $('#orderItemsListContent').html(updateContent);
            $('#finalPriceContainer').html(updatePriceContent);
            
            KTComponents.init();
            // createManage.events();
            // createManage.initEvents();

            if ($('#create-constract-content')[0]) {
                initJs($('#create-constract-content')[0]);
            };
        };

        addSubmitEffect() {
            this.getSaveDataBtn().setAttribute('data-kt-indicator', 'on');
            this.getSaveDataBtn().setAttribute('disabled', true);
        };

        removeSubmitEffect() {
            this.getSaveDataBtn().removeAttribute('data-kt-indicator');
            this.getSaveDataBtn().removeAttribute('disabled');
        };

        /**
         * Save order item data
         * @param formData order item data in form (popup)
         * @return void
         */ 
        saveDataIntoOrder(formData) {
            var _this = this;

            formData += `&order_id=${this.#orderId}&order_item_id=${this.orderItemId}`;

            this.addSubmitEffect();

            $.ajax({
                url: this.#url,
                method: "POST",
                data: formData
            }).done(response => {
                const orderId = this.#orderId;
                
                this.removeSubmitEffect();

                editAbroadItemPopup.getPopup().hide();

                ASTool.alert({
                    message: response.messages,
                    ok: () => {
                        window.location.reload();
                    }
                });
            }).fail(response => {
                this.removeSubmitEffect();
                editAbroadItemPopup.getPopup().setContent(response.responseText);
            });
        };

        orderFormEvents() {
            if (this.getSaveDataBtn()) {
                this.getSaveDataBtn().outerHTML = this.getSaveDataBtn().outerHTML;

                // Click save order item
                this.getSaveDataBtn().addEventListener('click', e => {
                    e.preventDefault();
                    
                    this.saveDataIntoOrder(this.getFormData());
                });
            }
        };
    };

    var TopSchoolTool = class {
        errors = [];

        constructor(options) {
            this.container = options.container;
            // All action handle by this data
            @if(isset($abroadApplication->top_school))
                this.data = JSON.parse({!! json_encode($abroadApplication->top_school) !!});
            @else
                this.data = [
                    {
                        _id: this.generateUniqId(),
                        num_of_school_from: null,
                        num_of_school_to: null,
                        top_school_from: null,
                        top_school_to: null,
                        country: null,
                    }
                ]
            @endif

            this.init();
        }

        getContainer() {
            return this.container;
        }

        getData() {
            return this.data;
        }

        // Error handle
        getErrors() {
            return this.errors;
        }

        addError(errorMsg) {
            this.errors.push(errorMsg);
        }

        resetError() {
            this.errors = [];
        }
        
        isExistError() {
            return this.getErrors().length > 0;
        }

        getFirstError() {
            return this.getErrors()[0];
        }

        getErrorLabel() {
            return this.getContainer().querySelector('[data-control="error-label"]');
        }

        showErrorLabel() {
            this.getErrorLabel().classList.remove('d-none');
        }

        hideErrorLabel() {
            this.getErrorLabel().classList.add('d-none');
        }

        addErrorToLabel(errMsg) {
            this.getErrorLabel().innerHTML = errMsg;
        }

        resetErrorLabel() {
            this.getErrorLabel().innerHTML = "";
        }

        // Send data to server
        getDataInputSendToServer() {
            return this.getContainer().querySelector('[name="top_school"]');
        }

        setDataInputSendToServer(data) {
            this.getContainer().querySelector('[name="top_school"]').value = data;
        }

        // Table
        getTopSchoolTableBody() {
            return this.getContainer().querySelector('[form-control="top-school-table-body"]');
        }

        // Getter/Setter fill/select/button
        // Add row button
        getAddTopSchoolRowBtn() {
            return this.getContainer().querySelector('[action-control="addTopSchoolRow"]');
        }
        
        // All number of school from - to
        getAllNumFromInputs() {
            return this.getContainer().querySelectorAll('[input-action="num-from"]');
        }

        getAllNumToInputs() {
            return this.getContainer().querySelectorAll('[input-action="num-to"]');
        }

        // All top school from - to
        getAllTopFromInputs() {
            return this.getContainer().querySelectorAll('[input-action="top-from"]');
        }

        getAllTopToInputs() {
            return this.getContainer().querySelectorAll('[input-action="top-to"]');
        }

        // All country select box
        getAllCountrySelects() {
            return this.getContainer().querySelectorAll('[select-action="country"]');
        }

        getAllDeleteButtons() {
            return this.getContainer().querySelectorAll('[action="delete-row"]');
        }

        // Action/Method
        render() {
            const _this = this;
            const data = this.getData();
            let rowsData = ``;

            this.resetError();
            this.validate();

            data.forEach(row => {
                let countryData = row.country ? row.country.toLowerCase() : row.country;
                const countries = {!! json_encode(config('countries')) !!};
                let selected = '';
                let options = ``;

                // Loop to get country selected in countries from server compare with selected country
                countries.forEach(country => {
                    // Find selected option
                    if(country && countryData) {
                        if (country.toLowerCase() === countryData.toLowerCase()) {
                            selected = 'selected';
                        } else {
                            selected = '';
                        }
                    }

                    // All option in select box in row with selected option
                    options += `<option value="${country}" ${selected}>${country}</option>`
                })

                let numSchoolFrom = parseInt(row.num_of_school_from) ? parseInt(row.num_of_school_from) : "";
                let numSchoolTo = parseInt(row.num_of_school_to) ? parseInt(row.num_of_school_to) : "";
                let topSchoolFrom = parseInt(row.top_school_from) ? parseInt(row.top_school_from) : "";
                let topSchoolTo = parseInt(row.top_school_to) ? parseInt(row.top_school_to) : "";

                // Add one row to all rows variable 'rowsData'
                rowsData += 
                `
                    <tr class="">
                        <td class="text-center col">
                            <input input-action="num-from" row-id-control="${row._id}" type="number" class="form-control border-0 text-center" value="${numSchoolFrom}">
                        </td>
                        <td class="text-center col">
                            <input input-action="num-to" row-id-control="${row._id}" type="number" class="form-control border-0 text-center" value="${numSchoolTo}">
                        </td>
                        <td class="text-center col">
                            <input input-action="top-from" row-id-control="${row._id}" type="number" class="form-control border-0 text-center" value="${topSchoolFrom}">
                        </td>
                        <td class="text-center col">
                            <input input-action="top-to" row-id-control="${row._id}" type="number" class="form-control border-0 text-center" value="${topSchoolTo}">
                        </td>
                        <td class="text-center" colspan="6">
                            <select select-action="country" row-id-control="${row._id}" class="form-select form-control border-0 text-center" data-control="select2"
                            data-dropdown-parent="#{{ $popupEditAbroadUniqId }}">
                                <option value="">Chọn quốc gia</option>
                                ${options}
                            </select>
                        </td>
                        <td class="text-center pe-2" style="height: 100%; align-content: center;">
                            <span action="delete-row" class="material-symbols-rounded fs-50 fs-50 cursor-pointer" style="display: inline-block; vertical-align: middle;" 
                            onmouseover="this.style.transform='scale(1.5)'; this.style.color='red'"
                            onmouseout="this.style.transform='scale(1)'; this.style.color='inherit'"
                            row-id-control="${row._id}">
                            delete
                        </span>
                        </td>
                    </tr>
                `;

                // Add all rows to table body
            })

            _this.getTopSchoolTableBody().innerHTML = rowsData;
            _this.events();
            _this.setDataToSendServer();
        }

        handleError() {
            if(this.isExistError()) {
                const errMsg = this.getFirstError();

                this.addErrorToLabel(errMsg);
                this.showErrorLabel();
            } else {
                this.resetErrorLabel();
                this.hideErrorLabel();
            }
        }

        validate() {
            const data = this.getData();
            let errorFound = false;

            data.forEach((item, index) => {
                const numFrom = parseInt(item.num_of_school_from);
                const numTo = parseInt(item.num_of_school_to);
                const topFrom = parseInt(item.top_school_from);
                const topTo = parseInt(item.top_school_to);

                if(numFrom !== null && numTo !== null && numTo < numFrom && !errorFound) {
                    const serial = index + 1;

                    errorFound = true;
                    this.addError(`Dữ liệu số trường apply tại hàng thứ ${serial} không hợp lệ, dữ liệu "đến" không được nhỏ hơn dữ liệu "từ"`);
                } else if(topFrom !== null && topTo !== null && topTo < topFrom && !errorFound) {
                    const serial = index + 1;

                    errorFound = true;
                    this.addError(`Dữ liệu top trường tại hàng thứ ${serial} không hợp lệ, dữ liệu "đến" không được nhỏ hơn dữ liệu "từ"`);
                }
            })

            this.handleError();
        }
        
        getRowDataById(id) {
            const data = this.getData();
            let found = false;
            let dataGetted = null;

            data.forEach(row => {
                if (row._id === id && !found) {
                    found = true;
                    dataGetted = row;
                    return; // Out loop when data found
                }
            })

            if (found && dataGetted) {
                return dataGetted;
            }

            return null;
        }

        addDataToDataList(data) {
            this.data.push(data);
        }

        setDataToSendServer() {
            const currData = JSON.stringify(this.getData());
            this.setDataInputSendToServer(currData);
        }

        generateUniqId() {
            return Date.now().toString(36) + Math.random().toString(36).substr(2);
        }

        // Remove data from datalist by id 
        removeDataFromListById(id) {
            this.data = this.getData().filter(data => data._id !== id);

            // If all elements are deleted from the array, 
            // it is necessary to keep one empty element to display an empty row in the UI for users to input data
            if (this.getData().length === 0) {
                const emptyRowData = {
                    _id: this.generateUniqId(),
                    num_of_school_from: null,
                    num_of_school_to: null,
                    top_school_from: null,
                    top_school_to: null,
                    country: null,
                }
                
                this.addDataToDataList(emptyRowData);
            }
        }

        // Change value actions
        updateNumOfSchoolFromById(id, newNum) {
            const index = this.getData().findIndex(item => item._id === id);

            if (index !== -1) {
                // item found
                // => Update value
                this.getData()[index].num_of_school_from = newNum;
                this.render();
            } else {
                throw new Error('Can not found item by _id');
            }
        }

        updateNumOfSchoolToById(id, newNum) {
            const index = this.getData().findIndex(item => item._id === id);

            if (index !== -1) {
                // item found
                // => Update value
                this.getData()[index].num_of_school_to = newNum;
                this.render();
            } else {
                throw new Error('Can not found item by _id');
            }
        }

        updateTopSchoolFromById(id, newTop) {
            const index = this.getData().findIndex(item => item._id === id);

            if (index !== -1) {
                // item found
                // => Update value
                this.getData()[index].top_school_from = newTop;
                this.render();
            } else {
                throw new Error('Can not found item by _id');
            }
        }

        updateTopSchoolToById(id, newTop) {
            const index = this.getData().findIndex(item => item._id === id);

            if (index !== -1) {
                // item found
                // => Update value
                this.getData()[index].top_school_to = newTop;
                this.render();
            } else {
                throw new Error('Can not found item by _id');
            }
        }

        updateCountryById(id, newCountry) {
            const index = this.getData().findIndex(item => item._id === id);

            if (index !== -1) {
                // item found
                // => Update value
                this.getData()[index].country = newCountry;
                this.render();
            } else {
                throw new Error('Can not found item by _id');
            }
        }

        clickDeleteRowBtnHandle(button) {
            const dataIdDelete = button.getAttribute('row-id-control');

            // find data in Data list by data Id, if data existing in data list  => Remove it from list
            if (this.getRowDataById(dataIdDelete)) {
                this.removeDataFromListById(dataIdDelete);
            } else {
                throw new Error('Data not found in data list!');
            }
            
            // Rerender table body
            this.render();
        }

        clickTheAddBtnHandle() {
            const emptyRowData = {
                _id: this.generateUniqId(),
                num_of_school_from: null,
                num_of_school_to: null,
                top_school_from: null,
                top_school_to: null,
                country: null,
            }
            
            this.addDataToDataList(emptyRowData);
            this.render();
        }

        // Remove all events from a specific element.
        removeEventsListenerFromElement(element) {
            element.outerHTML = element.outerHTML;
        }

        // Handle when change value num of school from 
        changeNumOfSchoolFrom(event) {
            const value = event.target.value;
            const id = event.target.getAttribute('row-id-control');

            this.updateNumOfSchoolFromById(id, value);
        }

        // Handle when change value num of school from 
        changeNumOfSchoolTo(event) {
            const value = event.target.value;
            const id = event.target.getAttribute('row-id-control');

            this.updateNumOfSchoolToById(id, value);
        }

        // Handle when change value top school from 
        changeTopSchoolFrom(event) {
            const value = event.target.value;
            const id = event.target.getAttribute('row-id-control');

            this.updateTopSchoolFromById(id, value);
        }

        // Handle when change value top school from 
        changeTopSchoolTo(event) {
            const value = event.target.value;
            const id = event.target.getAttribute('row-id-control');

            this.updateTopSchoolToById(id, value);
        }

        // Handle when change country
        changeCountryHandle(event) {
            const value = event.target.value;
            const id = event.target.getAttribute('row-id-control');

            this.updateCountryById(id, value);
        }

        events() {
            const _this = this;

            // Need to perform clearing all events related to the add row button.
            // Because each render will overwrite and add a new event to this button.
            this.removeEventsListenerFromElement(this.getAddTopSchoolRowBtn());

            // Click the delete button on each data row
            _this.getAllDeleteButtons().forEach(button => {
                $(button).on('click', function(e) {
                    e.preventDefault();
                    _this.clickDeleteRowBtnHandle(button);
                })
            })

            // Click the add row button
            $(_this.getAddTopSchoolRowBtn()).on('click', function(e) {
                e.preventDefault();
                _this.clickTheAddBtnHandle();
            })

            // Change the value in each cell.
            // Change value in num of school from cells
            _this.getAllNumFromInputs().forEach(input => {
                $(input).on('change', function(e) {
                    e.preventDefault();
                    _this.changeNumOfSchoolFrom(e);
                })
            })

            // Change value in num of school to cells
            _this.getAllNumToInputs().forEach(input => {
                $(input).on('change', function(e) {
                    e.preventDefault();
                    _this.changeNumOfSchoolTo(e);
                })
            })

            // Change value in top school from cells
            _this.getAllTopFromInputs().forEach(input => {
                $(input).on('change', function(e) {
                    e.preventDefault();
                    _this.changeTopSchoolFrom(e);
                })
            })

            // Change value in top school to cells
            _this.getAllTopToInputs().forEach(input => {
                $(input).on('change', function(e) {
                    e.preventDefault();
                    _this.changeTopSchoolTo(e);
                })
            })

            // Change country
            _this.getAllCountrySelects().forEach(select => {
                $(select).on('change', function(e) {
                    e.preventDefault();
                    _this.changeCountryHandle(e);
                })
            })
        }

        init() {
            this.render();
        }
    }

    var ErrorManager = class {
        constructor(options) {
            this.tool = options.tool;
            this.container = options.container;
            this.errors = [];
        }

        // ACTION/METHOD

        getContainer() {
            return this.container;
        }

        getTool() {
            return this.tool;
        }

        // Label show error
        getLabel() {
            return this.getContainer().querySelector('[label-control="error"]');
        }

        showLabel() {
            this.getLabel().classList.remove('d-none');
        }

        hideLabel() {
            this.getLabel().classList.add('d-none');
        }

        setMessageToLabel(msg) {
            this.getLabel().innerHTML = msg;
        }

        resetLabel() {
            this.setMessageToLabel('');
        }

        getErrors() {
            return this.errors;
        }

        getFirstError() {
            return this.getErrors()[0];
        }

        addError(errorMsg) {
            this.errors.push(errorMsg);
        }

        resetErrors() {
            this.errors = [];
        }

        isHasErrors() {
            return this.getErrors().length > 0;
        }

        reset() {
            this.resetErrors();
            this.resetLabel();
            this.hideLabel();
        }

        handle() {
            this.resetLabel();

            if (this.isHasErrors()) {
                const errorMsg = this.getFirstError();
                this.setMessageToLabel(errorMsg);
                this.showLabel();
            } else {
                this.hideLabel();
            }
        }
    }
</script>
@endsection
