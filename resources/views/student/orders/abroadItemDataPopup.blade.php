@extends('layouts.main.popup', [
   
])

@section('title')
Thông tin dịch vụ du học
@endsection

@php
    $popupCreateAbroadUniqId = 'popupCreateAbroad_' . uniqid();
@endphp

@section('content')
<div>
    <form tabindex="-1" id="{{ $popupCreateAbroadUniqId }}">
        @csrf
        <div class="scroll-y px-7 pt-10 px-lg-17">
            <input class="type-input" type="hidden" name="type" value="{{ App\Models\Order::TYPE_ABROAD }}">

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                    <div class="row mb-4">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                            <div class="form-outline">
                                <label class="mb-4 fw-bold" style="font-size: 17px" for="price-create-input">
                                    Giá bán:&nbsp;&nbsp;&nbsp;<span class="fw-light">{{ !isset($orderItem) ? '' : number_format($orderItem->price, 0, '.', ',') }}đ</span>
                                </label>
                                <br>
                                <label class="mb-4 fw-bold" style="font-size: 17px" for="price-create-input">
                                    Giảm giá&nbsp;(<span>{{ $orderItem->order->discount_code }}</span>%):&nbsp;&nbsp;&nbsp;<span class="fw-light">{{ \App\Helpers\Functions::formatNumber($orderItem->getTotalPriceRegardlessTypeBeforeDiscount() - $orderItem->getTotalPriceRegardlessType()) }}đ</span>
                                </label>
                                <br>
                                <label class="mb-4 fw-bold" style="font-size: 17px" for="price-create-input">
                                    Giá sau giảm:&nbsp;&nbsp;&nbsp;<span class="fw-light">{{ \App\Helpers\Functions::formatNumber($orderItem->getTotalPriceRegardlessType()) }}đ</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6 col-6 mb-2">
                    <div class="row mb-4">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                            <div class="form-outline">
                                <label class="mb-4 fw-bold" style="font-size: 17px" for="price-create-input">
                                    Thời điểm apply:&nbsp;&nbsp;&nbsp;<span class="fw-light">{{ date('d/m/Y', strtotime($orderItem->apply_time)) }}</span>
                                </label>
                                <br>
                                <label class="mb-4 fw-bold" style="font-size: 17px" for="price-create-input">
                                    Thời gian dự kiến nhập học:&nbsp;&nbsp;&nbsp;<span class="fw-light">{{ date('d/m/Y', strtotime($orderItem->estimated_enrollment_time)) }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @php
                function hasNonNullField(array $array): bool {
                    foreach ($array as $element) {
                        foreach ($element as $key => $field) {
                            if ($key != '_id' && $field !== null) {
                                return true;
                            }
                        }
                    }

                    return false;
                }
            @endphp

            @if (json_decode($orderItem->top_school, true))
                @if (hasNonNullField(json_decode($orderItem->top_school, true)))
                    <div class="row mb-8">
                        <table>
                            <thead>
                                <tr>
                                    <th>Số trường apply</th>
                                    <th>Top trường</th>
                                    <th>Quốc gia</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (json_decode($orderItem->top_school, true) as $item)
                                    <tr>
                                        <td>
                                            {{ $item['num_of_school_from'] }}
                                        </td>

                                        <td>
                                            {{ $item['top_school_from'] }}
                                        </td>

                                        <td>
                                            {{ $item['country'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            @endif

            @if (count($orderItem->grades()) > 0 || count($orderItem->extraActivities()) > 0 || count($orderItem->academicAwards()) > 0)
                <div class="row border-bottom mt-15 pb-3 mb-3">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-2 text-center border-end fw-bold">
                        GPA
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 text-center border-end fw-bold">
                        Các giải thưởng học thuật
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 text-center fw-bold">
                        Các hoạt động ngoại khóa
                    </div>
                </div>

                <div class="row pb-15 mb-8">
                    <div class="col-lg-2 col-md-2 col-sm-2 col-2 border-end">
                        @php
                            $grades = array_values($orderItem->grades());
                        @endphp
                        
                        @for ($i = 0; $i < count($grades); $i++)
                            @if (!is_null($grades[$i]['point']))
                                <div class="row {{ $i != (count($grades) - 1) ? 'border-bottom' : '' }} py-2">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 fw-bold">
                                        {{ $grades[$i]['gpa']->grade }}
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-7">
                                        {{ $grades[$i]['point'] }}
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 border-end">
                        @php
                            $activities = array_values($orderItem->extraActivities());
                        @endphp
                        
                        @for ($i = 0; $i < count($activities); $i++)
                            @if (!is_null($activities[$i]['extraActivityText']))
                                <div class="row {{ $i != (count($activities) - 1) ? 'border-bottom' : '' }} py-2 ps-10">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 fw-bold">
                                        {{$activities[$i]['extraActivity']->name }}
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-7">
                                        {{$activities[$i]['extraActivityText'] }}
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>

                    <div class="col-lg-5 col-md-5 col-sm-5 col-5">
                        @php
                            $awards = array_values($orderItem->academicAwards());
                        @endphp
                        
                        @for ($i = 0; $i < count($awards); $i++)
                            @if (!is_null($awards[$i]['academicAwardText']))
                                <div class="row {{ $i != (count($awards) - 1) ? 'border-bottom' : '' }} py-2 ps-10">
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-5 fw-bold">
                                        {{$awards[$i]['academicAward']->name }}
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-7 col-7">
                                        {{$awards[$i]['academicAwardText'] }}
                                    </div>
                                </div>
                            @endif
                        @endfor
                    </div>
                </div>

                <div class="row mb-4 p-0">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-outline">
                            <label class="fs-6 fw-semibold mb-2" for="standardized-score-input">Điểm thi chuẩn hóa</label>
                            <input id="standardized-score-input" type="text" class="form-control pe-none bg-secondary" name="std_score"
                                value={{ !isset($orderItem) ? '' : $orderItem->std_score }}>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                        <div class="form-outline">
                            <label class="fs-6 fw-semibold mb-2" for="english-score-input">Điểm thi tiếng anh</label>
                            <input id="english-score-input" type="text" class="form-control pe-none bg-secondary" name="eng_score"
                                value={{ !isset($orderItem) ? '' : $orderItem->eng_score }}>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                        <div class="form-outline">
                            <label class="fs-6 fw-semibold mb-2" for="current-program-select">Chương trình đang học</label>
                            <select id="current-program-select" class=" form-control pe-none bg-secondary"
                                name="current_program_id" data-control="select2"  
                                >
                                <option value="" class="d-none"></option>
                                @foreach(\App\Models\CurrentProgram::all() as $currentProgram)
                                    <option value="{{ $currentProgram->id }}" {{ isset($orderItem->current_program_id) && $orderItem->current_program_id == $currentProgram->id ? 'selected' : '' }}>{{ $currentProgram->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="plan-apply-select">Chương trình dự kiến apply</label>
                        <select id="plan-apply-select" class=" form-control pe-none bg-secondary"
                            name="plan_apply_program_id" data-control="select2" 
                            >
                            <option value="" class="d-none">Chọn chương trình dự kiến apply</option>
                            @foreach(\App\Models\PlanApplyProgram::all() as $planApplyProgram)
                                <option value="{{ $planApplyProgram->id }}" {{ isset($orderItem->plan_apply_program_id) && $orderItem->plan_apply_program_id == $planApplyProgram->id ? 'selected' : '' }}>{{ $planApplyProgram->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="intended-major-select">Ngành học dự kiến apply</label>
                        <select id="intended-major-select" class=" form-control pe-none bg-secondary"
                            name="intended_major_id" data-control="select2"  
                            >
                            <option value="" class="d-none"></option>
                            @foreach(\App\Models\IntendedMajor::all() as $intendedMajor)
                                <option value="{{ $intendedMajor->id }}" {{ isset($orderItem->intended_major_id) && $orderItem->intended_major_id == $intendedMajor->id ? 'selected' : '' }}>{{ $intendedMajor->name }}</option>
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
                        <select id="postgraduate-plan-select" class=" form-control pe-none bg-secondary"
                            name="postgraduate_plan" data-control="select2"  
                            >
                            <option value="" class="d-none"></option>
                            @foreach(config('postgraduatePlans') as $plan)
                            <option value="{{ $plan }}" {{ isset($orderItem) && $orderItem->postgraduate_plan == $plan ? 'selected' : '' }}>{{ $plan }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="personality-select">Bạn là kiểu người</label>
                        <select id="personality-select" class=" form-control pe-none bg-secondary" name="personality"
                            data-control="select2" >
                            <option value="" class="d-none"></option>
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
                        <label class="fs-6 fw-semibold mb-2" for="subject-preferences-select">Sở thích trong các môn học</label>
                        <select id="subject-preferences-select" class=" form-control pe-none bg-secondary"
                            name="subject_preference" data-control="select2" 
                            >
                            <option value="" class="d-none"></option>
                            @foreach(config('subjectPreferences') as $interest)
                                <option value="{{ $interest }}" {{ isset($orderItem) && $orderItem->subject_preference == $interest ? 'selected' : '' }}>{{ $interest }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="language-culture-select">Về ngôn ngữ và văn hóa</label>
                        <select id="language-culture-select" class=" form-control pe-none bg-secondary"
                            name="language_culture" data-control="select2"  
                            >
                            <option value="" class="d-none"></option>
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
                        <label class="fs-6 fw-semibold mb-2" for="is-research-select">Bạn đã tìm hiểu bộ hồ sơ online chưa</label>
                        <select id="is-research-select" class=" form-control pe-none bg-secondary" name="research_info"
                            data-control="select2" >
                            <option value="" class="d-none"></option>
                            @foreach(config('researchInfos') as $info)
                                <option value="{{ $info }}" {{ isset($orderItem) && $orderItem->research_info == $info ? 'selected' : '' }}>{{ $info }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="aim-select">Mục tiêu mà bạn nhắm đến</label>
                        <select list-action="marketing-type-select" class=" form-control pe-none bg-secondary" data-control="select2" 
                            data-kt-select2="true"  name="aim">
                            <option value="" class="d-none"></option>
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
                        <label class="fs-6 fw-semibold mb-2" for="personal-counseling-need-select">Đơn hàng tư vấn cá nhân của bạn</label>
                        <select id="personal-counseling-need-select" class=" form-control pe-none bg-secondary"
                            name="personal_countling_need" data-control="select2"  
                            >
                            <option value="" class="d-none"></option>
                            @foreach(config('personalCounselingNeeds') as $need)
                                <option value="{{ $need }}" {{ isset($orderItem) && $orderItem->personal_countling_need == $need ? 'selected' : '' }}>{{ $need }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="other-need-input">Ghi chú các mong muốn khác</label>
                        <textarea id="other-need-input" name="other_need_note" class="form-control pe-none bg-secondary" rows="1"
                            >{{ !isset($orderItem) ? '' : $orderItem->other_need_note }}</textarea>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="essay-writing-skill-select">Khả năng viết bài luận tiếng Anh của bạn</label>
                        <select id="essay-writing-skill-select" class=" form-control pe-none bg-secondary"
                            name="essay_writing_skill" data-control="select2" 
                            >
                            <option value="" class="d-none"></option>
                            @foreach(config('essayWritingSkills') as $skill)
                            <option value="{{ $skill }}" {{ isset($orderItem) && $orderItem->essay_writing_skill == $skill ? 'selected' : '' }}>{{ $skill }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="ccol-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="parent-job-select">Nghề nghiệp phụ huynh</label>
                        <select id="parent-job-select" class=" form-control pe-none bg-secondary" name="parent_job"
                            data-control="select2" >
                            <option value="" class="d-none"></option>
                            @foreach(config('parentJobs') as $job)
                            <option value="{{ $job }}" {{ isset($orderItem) && $orderItem->parent_job == $job ? 'selected' : '' }}>{{ $job }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="ccol-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="paren-highest-academic-select">Học vị cao nhất của bố hoặc mẹ</label>
                        <input id="paren-highest-academic-select" type="text" class="form-control pe-none bg-secondary"
                           name="parent_highest_academic" value="{{ !isset($orderItem) ? '' : $orderItem->parent_highest_academic }}">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="parent-ever-studied-abroad-select">Bố mẹ có từng đi du học?</label>
                        <select id="parent-ever-studied-abroad-select" class=" form-control pe-none bg-secondary"
                            name="is_parent_studied_abroad" data-control="select2" >
                            <option value="" class="d-none"></option>
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
                        <label class=" fs-6 fw-semibold mb-2" for="parent-income-select">Mức thu nhập của phụ huynh</label>
                        <select id="parent-income-select" class=" form-control pe-none bg-secondary" name="parent_income"
                            data-control="select2"  
                            >
                            <option value="" class="d-none"></option>
                            @foreach(config('parentIncomes') as $option)
                            <option value="{{ $option }}" {{ isset($orderItem) && $orderItem->parent_income == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="is-parent-family-studying-abroad-select">Phụ huynh có người thân đã/đang/sắp đi du học?</label>
                        <select id="is-parent-family-studying-abroad-select" class=" form-control pe-none bg-secondary"
                            name="is_parent_family_studied_abroad" data-control="select2">
                            <option value="" class="d-none"></option>
                            <option value="true" {{ isset($orderItem) && $orderItem->is_parent_family_studied_abroad == true ? 'selected' : '' }}>Có</option>
                            <option value="false" {{ isset($orderItem) && $orderItem->is_parent_family_studied_abroad == false ? 'selected' : '' }}>Không</option>
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="parent-familiarity-with-studying-abroad-select">Mức am hiểu về du học của phụ huynh</label>
                        <select id="parent-familiarity-with-studying-abroad-select" class=" form-control pe-none bg-secondary"
                            name="parent_familiarity_abroad" data-control="select2" 
                           >
                            <option value="" class="d-none"></option>
                            @foreach(config('parentFamiliarAbroad') as $option)
                                <option option value="{{ $option }}" {{ isset($orderItem) && $orderItem->parent_familiarity_abroad == $option ? 'selected' : '' }}>{{ $option }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="spend-time-with-child-select">Thời gian có thể đồng hành cùng con</label>
                        <select id="spend-time-with-child-select" class=" form-control pe-none bg-secondary"
                            name="parent_time_spend_with_child" data-control="select2" 
                           >
                            <option value="" class="d-none"></option>
                            @foreach(config('parentTimeSpendWithChilds') as $option)
                                <option value="{{ $option }}" {{ isset($orderItem) && $orderItem->parent_time_spend_with_child == $option ? 'selected' : '' }}>{{ $option }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="financial-capability">Khả năng chi trả mỗi năm cho quá trình học của con (USD)</label>
                        <input id="financial-capability" type="text" class="form-control pe-none bg-secondary" name="financial_capability" data-check-error="{{ $errors->has('financial_capability') ? 'error' : 'none' }}"
                            value={{ !isset($orderItem) ? '' : $orderItem->financial_capability }}>
                            <x-input-error :messages="$errors->get('financial_capability')" class="mt-2"/>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class=" fs-6 fw-semibold mb-2" for="abroad_branch">Chi nhánh</label>
                        <select id="abroad_branch" class=" form-control pe-none bg-secondary"
                            name="abroad_branch" data-control="select2" 
                           >
                            <option value="" class="d-none"></option>
                            @foreach (\App\Models\OrderItem::getAbroadBranchs() as $branch)
                                <option value="{{ $branch }}" {{ isset($orderItem->abroad_branch) && $orderItem->abroad_branch == $branch ? 'selected' : '' }}>{{ trans('messages.order_item.abroad.branch.' . $branch) }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('abroad_branch')" class="mt-2"/>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
