@extends('layouts.main.popup')

@section('title')
Yêu cầu dịch vụ du học
@endsection

@section('content')
<form id="AbroadFormManage" tabindex="-1">
    @csrf

    <div class="scroll-y px-7 py-10 px-lg-17">
        <input type="hidden" name="type" value="0">
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="product-select">Dịch vụ</label>
                    <select id="product-select" class="form-select form-control" name="abroad_product"
                        data-control="select2" data-placeholder="Chọn dịch vụ..." data-allow-clear="true">
                        <option value="">Chọn dịch vụ</option>
                        @foreach(config('abroadProducts') as $product)
                        <option value="{{ $product }}">{{ $product }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('abroad_product')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="apply-time">Thời điểm apply</label>
                    <input id="apply-time" type="text" class="form-control"
                        placeholder="Nhập thời điểm apply..." name="apply_time" />
                        <x-input-error :messages="$errors->get('apply_time')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="school-nums-apply">Số trường apply</label>
                    <input id="school-nums-apply" type="number" class="form-control" name="num_of_school_apply"
                        placeholder="Nhập số trường apply..." />
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
                        <option value="{{ $top }}">{{ $top }}</option>
                        @endforeach
                    </select>
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
                        <option value="male">Nam</option>
                        <option value="female">Nữ</option>
                        <option value="female">Khác</option>
                    </select>
                    <x-input-error :messages="$errors->get('gender')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="gpa-input">GPA lớp 9, 10, 11, (12)</label>
                    <input id="gpa-input" type="text" class="form-control" name="GPA" placeholder="Nhập GPA..." />
                    <x-input-error :messages="$errors->get('GPA')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="standardized-score-input">Điểm thi chuẩn hóa</label>
                    <input id="standardized-score-input" type="text" class="form-control" name="std_score"
                        placeholder="Nhập điểm thi chuẩn hóa..." />
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="english-score-input">Điểm thi tiếng anh</label>
                    <input id="english-score-input" type="text" class="form-control" name="eng_score"
                        placeholder="Nhập điểm thi tiếng anh..." />
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="current-program-input">Chương trình đang học</label>
                    <input id="current-program-input" type="text" class="form-control" name="current_program"
                        placeholder="vd: THPT VN, IB, A-Level, Tú tài Pháp, etc..." />
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="plan-apply-input">Chương trình dự kiến apply</label>
                    <input id="plan-apply-input" type="text" class="form-control" name="plan_apply"
                        placeholder="vd: Cử Nhân, Thạc Sĩ, MBA, PhD, etc..." />
                        <x-input-error :messages="$errors->get('train_product')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="intended-major-input">Ngành học dự kiến ở đại
                        học</label>
                    <input id="intended-major-input" type="text" class="form-control" name="intended_major"
                        placeholder="Ngành học dự kiến..." />
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
                        <option value="{{ $award }}">{{ $award }}</option>
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
                        <option value="{{ $plan }}">{{ $plan }}</option>
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
                        <option value="{{ $personality }}">{{ $personality }}</option>
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
                        <option value="{{ $interest }}">{{ $interest }}</option>
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
                        <option value="{{ $culture }}">{{ $culture }}</option>
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
                        <option value="{{ $info }}">{{ $info }}</option>
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
                        <option value="{{ $aim }}">{{ $aim }}</option>
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
                        <option value="{{ $skill }}">{{ $skill }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="extra-activity-select">Các hoạt động ngoại khóa của
                        bạn</label>
                    <select id="extra-activity-select" class="form-select form-control" name="extra_activity"
                        data-control="select2" data-placeholder="Các hoạt động ngoại khóa" data-allow-clear="true">
                        <option value="">Chọn hoạt động</option>
                        @foreach(config('extraActivities') as $activity)
                        <option value="{{ $activity }}">{{ $activity }}</option>
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
                        <option value="{{ $need }}">{{ $need }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="other-need-input">Ghi chú các mong muốn khác</label>
                    <textarea id="other-need-input" name="other_need_note" class="form-control" rows="1"
                        placeholder="Các mong muốn khác..."></textarea>
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
                        <option value="{{ $job }}">{{ $job }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class=" fs-6 fw-semibold mb-2" for="paren-highest-academic-select">Học vị cao nhất
                        của bố hoặc mẹ</label>
                    <input id="paren-highest-academic-select" type="text" class="form-control"
                        placeholder="Học vị cao nhất của bố hoặc mẹ..." name="parent_highest_academic" />
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
                        <option value="{{ $option }}">{{ $option }}</option>
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
                        <option value="{{ $option }}">{{ $option }}</option>
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
                        <option value="yes">Có</option>
                        <option value="no">Không</option>
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
                        <option value="{{ $option }}">{{ $option }}</option>
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
                        <option value="{{ $option }}">{{ $option }}</option>
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
                        placeholder="Khả năng chi trả (USD)..." />
                        <x-input-error :messages="$errors->get('financial_capability')" class="mt-2" />
                </div>
            </div>
        </div>


        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button data-action="under-construction" id="CreateCustomerSubmitButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Lưu</span>
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
    });

    var AbroadFormManage = function() {
        let form;
        
        return {
            init: () => {
                form = new OrderForm({
                    form: $("#AbroadFormManage"),
                    url: "{{ action('App\Http\Controllers\Marketing\OrderController@saveConstractData') }}",
                    submitBtnId: "CreateCustomerSubmitButton",
                    popup: AddAbroadOrderPopup.getPopup()
                });
            }
        }
    }();
</script>
@endsection