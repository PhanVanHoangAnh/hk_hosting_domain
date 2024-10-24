<div class="d-flex align-items-center mb-3">
    <h2 class="mb-0 me-3">3. Thông tin chi tiết dịch vụ</h2>
    <a class="d-flex flex-center rotate-n180 ms-3" data-bs-toggle="collapse" class=" px-5 rotate collapsible collapsed" href="#kt_toggle_block_1" id="show">
        <i class="ki-duotone ki-down fs-3"></i>
    </a>
</div>

<div class="card mb-10 collapse" id="kt_toggle_block_1">
    <div class="card-body">
        <!--begin::Stats-->
        <div class="  py-5 ">
            <div class="row d-flex ">
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
                                {{ isset($abroadApplication->orderItem->gender) ? $abroadApplication->orderItem->gender : '--' }}
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
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                <div class="ms-3">
                                    {{ isset($abroadApplication->orderItem->parent_income) ? $abroadApplication->orderItem->parent_income : '--' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-outline">
                        <div class="fv-row my-3 d-flex border-bottom">
                            <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                                <label class="fs-6 fw-semibold mb-2">
                                    <span class="fw-bold">Khả năng chi trả mỗi năm cho quá trình học của con (bao gồm cả học phí) (USD):</span>
                                </label>
                            </div>
                            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                <div class="ms-3">
                                    {{ isset($abroadApplication->orderItem->financial_capability) ? App\Helpers\Functions::formatNumber($abroadApplication->orderItem->financial_capability) . '₫' : '--' }}
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Thời gian dự kiến nhập học:</span>
                            </label>
                        </div>
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                            <div class="ms-3">
                                {{ isset($abroadApplication->orderItem->is_parent_studied_abroad) ? $abroadApplication->orderItem->is_parent_studied_abroad : '--' }}
                            </div>
                        </div>
                    </div>
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Phụ huynh có người thân đã/đang/sắp đi du học:</span>
                            </label>
                        </div>
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                            <div class="ms-3">
                                {{ isset($abroadApplication->orderItem->is_parent_family_studied_abroad) ? ($abroadApplication->orderItem->is_parent_family_studied_abroad ? 'Có' : 'Không') : '--' }}

                            </div>
                        </div>
                    </div>
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Thời gian có thể đồng hành cùng con:</span>
                            </label>
                        </div>
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
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
                            <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                                <div class="ms-3">
                                    {{ isset($abroadApplication->orderItem->parent_familiarity_abroad) ? $abroadApplication->orderItem->parent_familiarity_abroad : '--' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <!--end::Stats-->
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleBlock = document.getElementById('kt_toggle_block_1');
        var marginBottomElement = document.querySelector('.mb-10');

        toggleBlock.addEventListener('shown.bs.collapse', () => marginBottomElement.classList.add('d-none'));
        toggleBlock.addEventListener('hidden.bs.collapse', () => marginBottomElement.classList.remove('d-none'));
    });

</script>
