<div class="d-flex align-items-center mb-3">
    <div class="row w-100">
        <div class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-flex align-items-center">
            <h2 class="mb-0 me-3">3. Thông tin chi tiết dịch vụ</h2>
            <a class="d-flex flex-center rotate-n180 ms-3" data-bs-toggle="collapse" class=" px-5 rotate collapsible collapsed" href="#kt_toggle_block_1" id="show">
                <i class="ki-duotone ki-down fs-3"></i>
            </a>
        </div>

        @php
            $editAbroadItemFormId = "edit_abroad_item_form_id_" . uniqId();
        @endphp

        <div id="{{ $editAbroadItemFormId }}" class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
            <button data-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'editAbroadItem'], ['id' => $abroadApplication->id]) }}" class="btn btn-sm btn-secondary d-flex align-items-center">
                <span class="material-symbols-rounded">
                    build
                </span>
                &nbsp;
                <span>
                    Cập nhật/Chỉnh sửa
                </span>
            </button>
        </div>

        <script>
            var editAbroadItemManager;
            var editAbroadItemPopup;

            $(() => {
                editAbroadItemPopup = new EditAbroadItemPopup();

                editAbroadItemManager = new EditAbroadItemManager({
                    container: () => {
                        return $('#{{ $editAbroadItemFormId }}');
                    }
                })
            })

            /**
             * Manage handle edit abroad item
             */
            var EditAbroadItemManager = class {
                constructor(options) {
                    this.container = options.container;

                    this.events()
                }

                getContainer() {
                    return this.container();
                }

                getEditButton() {
                    return this.getContainer().find('button');
                }

                getUrl() {
                    return this.getEditButton().attr('data-url');
                }

                showPopup() {
                    const url = this.getUrl();

                    editAbroadItemPopup.updateUrl(url);
                }

                clickButton() {
                    this.showPopup();
                }

                events() {
                    this.getEditButton().on('click', e => {
                        e.preventDefault();
                        this.clickButton();
                    })
                }
            }

            /**
             * Popup to edit abroad item
             */
            var EditAbroadItemPopup = class {
                constructor(options) {
                    this.popup = new Popup();
                }

                getPopup() {
                    return this.popup;
                }

                updateUrl(newUrl) {
                    this.popup.url = newUrl;
                    this.popup.load();
                }
            }
        </script>
    </div>
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
                                {{ !isset($abroadApplication->apply_time) ? '--' : date('d/m/Y', strtotime($abroadApplication->apply_time)) }}
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
                                @foreach ($abroadApplication->grades() as $grade)
                                    <span class="fw-bold">{{ $grade['gpa']?->grade }}</span>: {{ $grade['point'] }} <br>
                                @endforeach 
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
                                {{ $abroadApplication->currentProgram->name ?? '--' }}
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
                                {{ $abroadApplication->intendedMajor->name ?? '--' }}
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
                                {{ isset($abroadApplication->postgraduate_plan) ? $abroadApplication->postgraduate_plan : '--' }}
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
                                {{ isset($abroadApplication->subject_preference) ? $abroadApplication->subject_preference : '--' }}
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
                                {{ isset($abroadApplication->research_info) ? $abroadApplication->research_info : '--' }}
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
                                {{ isset($abroadApplication->essay_writing_skill) ? $abroadApplication->essay_writing_skill : '--' }}
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
                                {{ isset($abroadApplication->personal_countling_need) ? $abroadApplication->personal_countling_need : '--' }}
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
                                {{ isset($abroadApplication->parent_job) ? $abroadApplication->parent_job : '--' }}
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
                                    {{ isset($abroadApplication->parent_highest_academic) ? $abroadApplication->parent_highest_academic : '--' }}
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
                                    {{ isset($abroadApplication->parent_income) ? $abroadApplication->parent_income : '--' }}
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
                                    {{ isset($abroadApplication->financial_capability) ? App\Helpers\Functions::formatNumber(App\Helpers\Functions::convertStringPriceToNumber($abroadApplication->financial_capability)) . '₫' : '--' }}
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
                                {{ !isset($abroadApplication->estimated_enrollment_time) ? '--' : date('d/m/Y', strtotime($abroadApplication->estimated_enrollment_time)) }}
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
                                {{ isset($abroadApplication->std_score) ? $abroadApplication->std_score : '--' }}
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
                                {{ isset($abroadApplication->eng_score) ? $abroadApplication->eng_score : '--' }}
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
                                {{ $abroadApplication->planApplyProgram->name ?? '--' }}
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
                                @foreach ($abroadApplication->academicAwards() as $grade)
                                    <span class="fw-bold">{{ $grade['academicAward']?->grade }}</span>: {{ $grade['academicAwardText'] }} <br>
                                @endforeach 
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
                                {{ isset($abroadApplication->personality) ? $abroadApplication->personality : '--' }}
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
                                {{ isset($abroadApplication->language_culture) ? $abroadApplication->language_culture : '--' }}
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
                                {{ isset($abroadApplication->aim) ? $abroadApplication->aim : '--' }}
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
                                @foreach ($abroadApplication->extraActivities() as $grade)
                                    <span class="fw-bold">{{ $grade['extraActivity']?->grade }}</span>: {{ $grade['extraActivityText'] }} <br>
                                @endforeach 
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
                                {{ isset($abroadApplication->other_need_note) ? $abroadApplication->other_need_note : '--' }}
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
                                {{ isset($abroadApplication->is_parent_studied_abroad) ? $abroadApplication->is_parent_studied_abroad : '--' }}
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
                                {{ isset($abroadApplication->is_parent_family_studied_abroad) ? ($abroadApplication->is_parent_family_studied_abroad ? 'Có' : 'Không') : '--' }}

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
                                {{ isset($abroadApplication->parent_time_spend_with_child) ? $abroadApplication->parent_time_spend_with_child : '--' }}
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
                                    {{ isset($abroadApplication->parent_familiarity_abroad) ? $abroadApplication->parent_familiarity_abroad : '--' }}
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
