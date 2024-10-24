<div class="ms-2">

    <p class="fs-2 fw-bold fw-semibold ">
        Lớp học diễn ra bình thường, điểm danh viết báo cáo học tập
    </p>
    {{-- (Mời cỏ lú Thư vào lm tiếp) --}}
    @if ($students->count())
        <div class="" id="StudentIndexContainer">
            <div list-action="top-action-box" class="d-flex justify-content-end align-items-center  px-lg-17 pb-5 d-none"
                style="flex-direction: row;">

                <div class="justify-content-end">
                    <td class="text-end">
                        <div class="btn btn-sm btn-outline btn-flex btn-center  text-nowrap px-3">
                            <a list-action="check-all" class="  text-nowrap px-3" list-action="sort">Chọn tất cả</a>
                        </div>
                    </td>
                </div>
                <div class="m-2 font-weight-bold">
                    <div list-control="count-label"></div>
                </div>
            </div>


            <!--begin::Scroll-->
            <div class=" pe-7 pt-7" id="StudentIndexListContent">

                <!--begin::Input group-->
                <div class="fv-row ">
                    <div class="table-responsive table-head-sticky">
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                            <thead>
                                <tr
                                    class="border text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                    <th rowspan="2" class="ps-3 min-w-150px">Tên học viên</th>

                                    <th colspan="3" class="text-center">
                                        Điểm danh
                                    </th>
                                    <th rowspan="2" class="ps-3 text-center">Vào</th>
                                    <th rowspan="2" class="ps-3 text-center">Ra</th>
                                    <th rowspan="2" class="ps-3 text-center">Báo cáo học tập</th>
                                    <th rowspan="2" class="ps-3 text-center">Thao tác</th>
                                </tr>
                                <tr
                                    class="border text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                    <th class="text-center">
                                        Có học
                                    </th>
                                    <th class="text-center">
                                        Vắng có phép
                                    </th>
                                    <th class="text-center">
                                        Vắng không phép
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="text-gray-600">
                                @foreach ($students as $student)
                                    <tr >
                                        <td class="ps-3"> {{ $student->student->name }}</td>
                                        <td>
                                            @php
                                                $status = $student->status;
                                                $startAt = $student->start_at;
                                                $endAt = $student->end_at;
                                                $sectionId = $section->id;
                                                $studentId = $student->student->id;
                                                $attendanceExists = \App\Models\Attendance::checkAttendance(
                                                    $studentId,
                                                    $sectionId,
                                                );
                                            @endphp

                                            <div
                                                class="form-check form-check-sm form-check-custom d-flex justify-content-center"  >

                                                <input name="attendance{{ $student->id }}"
                                                    data-section-id="{{ $section->id }}"
                                                    data-student-id="{{ $student->student->id }}"
                                                    list-action="check-item" class="form-check-input" type="radio"
                                                    value="present" {{ $student->absence_request_reason ? 'disabled' : ''  }} 
                                                    {{ $status === \App\Models\StudentSection::STATUS_PRESENT || $status === \App\Models\StudentSection::STATUS_NEW ? 'checked' : '' }} />
                                            </div>
                                        </td>
                                        <td
                                            @if($student->absence_request_reason)
                                                data-bs-toggle="tooltip"
                                                data-bs-placement="top"
                                                data-bs-html="true"
                                                title="{!! $student->absence_request_reason !!} lúc <b>{{ $student->absence_request_at }}</b>"
                                            @endif 
                                            >

                                            <div
                                                class="form-check form-check-sm form-check-custom d-flex justify-content-center">
                                                <input name="attendance{{ $student->id }}"
                                                    data-section-id="{{ $section->id }}"
                                                    data-student-id="{{ $student->student->id }}"
                                                    list-action="check-item" class="form-check-input" type="radio"
                                                    value="excused_absence"
                                                    
                                                    {{ $status === \App\Models\StudentSection::STATUS_EXCUSED_ABSENCE || !empty($student->absence_request_reason) ? 'checked' : '' }} />
                                            </div>
                                        </td>
                                        <td>

                                            <div
                                                class="form-check form-check-sm form-check-custom d-flex justify-content-center" >

                                                <input name="attendance{{ $student->id }}"
                                                    data-section-id="{{ $section->id }}"
                                                    data-student-id="{{ $student->student->id }}"
                                                    list-action="check-item" class="form-check-input" type="radio"
                                                    value="unexcused_absence" {{ $student->absence_request_reason ? 'disabled' : ''  }}
                                                    {{ $status === \App\Models\StudentSection::STATUS_UNEXCUSED_ABSENCE ? 'checked' : '' }} />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center date-with-clear-button">
                                                <input data-action="start-at-input" type="time"
                                                    @if (
                                                        ($status == \App\Models\StudentSection::STATUS_PRESENT || $status === \App\Models\StudentSection::STATUS_NEW) &&
                                                            $startAt) value="{{ date('H:i', strtotime($startAt)) }}"
                                                    @else
                                                        value="{{ $section->start_at ? date('H:i', strtotime($section->start_at)) : '' }}"
                                                        @if (!$status == \App\Models\StudentSection::STATUS_PRESENT && !$status === \App\Models\StudentSection::STATUS_NEW)
                                                            disabled @endif
                                                    @endif
                                                class="form-control border-0 bg-transparent"
                                                placeholder="" name="start_at"/>
                                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                                    style="display:none;">close</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center date-with-clear-button">
                                                <input data-action="end-at-input" type="time"
                                                    @if ($status == \App\Models\StudentSection::STATUS_PRESENT || $status === \App\Models\StudentSection::STATUS_NEW) value="{{ $section->end_at ? date('H:i', strtotime($section->start_at)) : '' }}"
                                                    
                                                    @else
                                                        disabled @endif
                                                    class="form-control border-0 bg-transparent" placeholder=""
                                                    name="end_at" />
                                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                                    style="display:none;">close</span>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $section->hasReportForStudent($student->student->id) ? 'Đã báo cáo' : 'Chưa báo cáo' }}
                                            <input type="hidden" name="reportStatus"
                                                value="{{ $section->hasReportForStudent($student->student->id) ? 'Đã báo cáo' : 'Chưa báo cáo' }}">
                                        </td>
                                        <td class="text-left">
                                            <a href="#" name="action"
                                                class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                style="margin-left: 0px">
                                                Thao tác
                                                <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                                data-kt-menu="true">
                                                <div
                                                    class="menu-item px-3 
                                                        {{-- {{ $student->student->getStudentSectionStatus($section) === App\Models\StudentSection::STATUS_PRESENT ? '' : 'd-none' }} --}}
                                                        
                                                        {{-- {{ $section->checkStatusSection() === App\Models\Section::COMPLETED_STATUS ? '' : 'd-none' }} --}}
                                                         {{ $section->hasReportForStudent($student->student->id) ? 'd-none' : '' }}">

                                                    <a data-ids-delete="{{ $section->id }}"
                                                        href="{{ action(
                                                            [App\Http\Controllers\Edu\SectionReportsController::class, 'create'],
                                                            [
                                                                'id' => $section->id,
                                                                'contact_id' => $student->student->id,
                                                            ],
                                                        ) }}"
                                                        row-action="report" class="menu-link px-3 btn-update-report">Báo
                                                        cáo học tập </a>
                                                </div>
                                                <div class="menu-item px-3  ">

                                                    <a data-ids-delete="{{ $section->id }}"
                                                        href="{{ action(
                                                            [App\Http\Controllers\Edu\SectionReportsController::class, 'edit'],
                                                            [
                                                                'id' => $section->id,
                                                                'contact_id' => $student->student->id,
                                                            ],
                                                        ) }}"
                                                        row-action="report"
                                                        class="menu-link px-3 btn-update-report {{ $section->hasReportForStudent($student->student->id) ? '' : 'd-none' }}">
                                                        Sửa báo cáo
                                                    </a>
                                                </div>
                                                <div class="menu-item px-3  ">

                                                    <a data-ids-delete="{{ $section->id }}"
                                                        data-contact-id="{{ $student->student->id }}"
                                                        href="{{ action(
                                                            [App\Http\Controllers\Edu\SectionReportsController::class, 'destroy'],
                                                            ['section_id' => $section->id, 'contact_id' => $student->student->id],
                                                        ) }}"
                                                        row-action="delete-report"
                                                        class="menu-link px-3 btn-delete-report {{ $section->hasReportForStudent($student->student->id) ? '' : 'd-none' }}">
                                                        Xóa báo cáo
                                                    </a>

                                                </div>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    @else
        <div class="py-15">
            <div class="text-center mb-7">
                <svg style="width:120px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.8 173.8">
                    <g style="isolation:isolate">
                        <g id="Layer_2" data-name="Layer 2">
                            <g id="layer1">
                                <path
                                    d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z"
                                    style="fill:#cdcdcd" />
                                <path
                                    d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z"
                                    style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2" />
                                <path d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z"
                                    style="fill:#f5f5f5" />
                                <rect x="31.7" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="73.6" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="115.5" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="31.7" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="73.6" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <rect x="115.5" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                <path d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                    style="fill:#dbdbdb" />
                                <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                    style="fill:#f5f5f5" />
                                <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z" style="fill:#f5f5f5" />
                                <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z" style="fill:#f5f5f5" />
                                <rect x="32.1" y="29.8" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                <rect x="32.1" y="36.7" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                <rect x="73.3" y="96.7" width="10.1" height="8.42"
                                    transform="translate(-38.3 152.9) rotate(-76.2)" style="fill:#595959" />
                                <path
                                    d="M94.4,35.7a33.2,33.2,0,1,0,24.3,40.1A33.1,33.1,0,0,0,94.4,35.7ZM80.5,92.2a25,25,0,1,1,30.2-18.3A25.1,25.1,0,0,1,80.5,92.2Z"
                                    style="fill:#f8a11f" />
                                <path
                                    d="M57.6,154.1c-.7,2.8,2,5.9,6,6.9h0c4,1,7.9-.5,8.6-3.3l11.4-46.6c.7-2.8-2-5.9-6-6.9h0c-4.1-1-7.9.5-8.6,3.3Z"
                                    style="fill:#253f8e" />
                                <path d="M62.2,61.9A25,25,0,1,1,80.5,92.2,25,25,0,0,1,62.2,61.9Z"
                                    style="fill:#fff;mix-blend-mode:screen;opacity:0.6000000000000001" />
                                <path
                                    d="M107.6,72.9a12.1,12.1,0,0,1-.5,1.8A21.7,21.7,0,0,0,65,64.4a11.6,11.6,0,0,1,.4-1.8,21.7,21.7,0,1,1,42.2,10.3Z"
                                    style="fill:#dbdbdb" />
                                <path
                                    d="M54.3,60A33.1,33.1,0,0,0,74.5,98.8l-1.2,5.3c-2.2.4-3.9,1.7-4.3,3.4L57.6,154.1c-.7,2.8,2,5.9,6,6.9L94.4,35.7A33.1,33.1,0,0,0,54.3,60Z"
                                    style="fill:#dbdbdb;mix-blend-mode:screen;opacity:0.2" />
                            </g>
                        </g>
                    </g>
                </svg>
            </div>
            <p class="fs-4 text-center mb-5">
                Không có học viên nào trong buổi này!
            </p>
            <p class="text-center d-none">
                <a list-action="create-constract" href="javascript:;" id="buttonCreateNewCourse"
                    class="btn btn-outline btn-outline-default">
                    <span class="material-symbols-rounded me-2">
                        add
                    </span>
                    Thêm mới buổi học
                </a>
            </p>
        </div>
    @endif

</div>
<script>
    var checkSwitch;

    $(() => {
        checkSwitch = new CheckSwitch({});


        Report.init();


        UpdateReportsStudentPopup.init();

        DeletePopup.init();

    });
    var UpdateReportsStudentPopup = function() {
        var popupUpdateUser;
        return {
            init: function(updateUrl) {

                popupUpdateUser = new Popup({
                    url: updateUrl,
                });

            },
            load: function(updateUrl) {
                popupUpdateUser.url = updateUrl;
                popupUpdateUser.load();
            },
            getPopup: function() {
                return popupUpdateUser;
            },
        };
    }();
    var DeletePopup = function() {
        var deleteReport = function(url, section_id, contact_id) {
            ASTool.confirm({
                message: 'Bạn có chắc chắn muốn xóa báo cáo này?',
                ok: function() {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            section_id: section_id,
                            contact_id: contact_id
                        },
                    }).done((response) => {
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                if (typeof SectionList !== 'undefined') {
                                    SectionList.getList().load();
                                }
                                if (typeof ReportsStudentPopup !==
                                    'undefined') {
                                    ReportsStudentPopup.getPopup().load();
                                }
                                if (typeof StudentList !== 'undefined') {
                                    StudentList.getList().load();
                                }
                                if (typeof AttendancePopup !== 'undefined') {
                                    AttendancePopup.reload();
                                }
                            }
                        });
                    }).fail(function() {

                    });
                }
            });
        };

        return {
            init: () => {
                var deleteButtons = document.querySelectorAll('.btn-delete-report');
                deleteButtons.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var deleteUrl = this.getAttribute('href');
                        var section_id = button.getAttribute('data-ids-delete');
                        var contact_id = button.getAttribute('data-contact-id');
                        deleteReport(deleteUrl, section_id, contact_id);
                    });
                });
            }
        };
    }();

    var CheckSwitch = class {
        constructor() {
            this.currentElement = null; 
            this.events();
        }

        setCurrentElement(element) {
            this.currentElement = element;
        }

        getContainer() {
            return $(this.currentElement).closest('tr'); 
        }

        getStudied() {
            return this.getContainer().find('input[value="present"]:checked');
        }

        getExcusedAbsence() {
            return this.getContainer().find('input[value="excused_absence"]:checked');
        }

        getUnexcusedAbsence() {
            return this.getContainer().find('input[value="unexcused_absence"]:checked');
        }

        getStartAt() {
            return this.getContainer().find('input[name="start_at"]');
        }

        getEndAt() {
            return this.getContainer().find('input[name="end_at"]');
        }

        getAction() {
            return this.getContainer().find('a[name="action"]');
        }

        handleRadioChange() { 
            var studied = this.getStudied();
            var excusedAbsence = this.getExcusedAbsence();
            var unexcusedAbsence = this.getUnexcusedAbsence();
            var startAtInput = this.getStartAt();
            var endAtInput = this.getEndAt();
            var actionButton = this.getAction();

            if (studied.length > 0) {
                const startAtValue = "{{ isset($startAt) ? date('H:i', strtotime($startAt)) : (isset($section) ? date('H:i', strtotime($section->start_at)) : '') }}";
                const endAtValue = "{{ isset($endAt) ? date('H:i', strtotime($endAt)) : (isset($section) ? date('H:i', strtotime($section->end_at)) : '') }}";

                startAtInput.prop('disabled', false).val(startAtValue);
                endAtInput.prop('disabled', false).val(endAtValue);
                actionButton.removeClass('disabled');
            } else if (excusedAbsence.length > 0 || unexcusedAbsence.length > 0) {
                startAtInput.prop('disabled', true).val('');
                endAtInput.prop('disabled', true).val('');
                actionButton.addClass('disabled');
            }
        }

        events() {
            var _this = this;

            $('input[name^="attendance"]').on('change', function() {
                _this.setCurrentElement(this);
                _this.handleRadioChange();
            });

            $('input[name^="attendance"]').each(function() {
                _this.setCurrentElement(this);
                _this.handleRadioChange();
            });
        }
    };


    var Report = function() {

        return {
            init: () => {
                var buttonsUpdateReport = document.querySelectorAll(
                    '.btn-update-report');
                buttonsUpdateReport.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var editUrl = this.getAttribute('href');
                        UpdateReportsStudentPopup.load(editUrl);
                    });
                });
            },
            getUpdatePopup: () => {
                return updatePopups;
            },
        };
    }();
</script>
