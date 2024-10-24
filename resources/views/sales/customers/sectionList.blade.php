<!--begin::Card body-->
<div class="card-body pt-0 mt-5">
    @if ($sections->count())
        <div id="courses-table-box" class="table-responsive scrollable-orders-table">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                <thead>
                    <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                        <th class="w-10px pe-2 ps-1">
                            <div class="form-check form-check-sm form-check-custom me-3">
                                <input list-action="check-all" class="form-check-input" type="checkbox" />
                            </div>
                        </th>

                        <th sort-by="stt"
                            sort-direction="{{ $sortColumn == 'stt' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="stt">
                            <span class="d-flex align-items-center">
                                <span>
                                    STT
                                </span>
                            </span>
                        </th>

                        <th sort-by="name"
                            sort-direction="{{ $sortColumn == 'name' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="name">
                            <span class="d-flex align-items-center">
                                <span>
                                    Môn học
                                </span>
                            </span>
                        </th>

                        <th sort-by="code"
                            sort-direction="{{ $sortColumn == 'code' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="code">
                            <span class="d-flex align-items-center">
                                <span>
                                    Mã lớp học
                                </span>
                            </span>
                        </th>
                        <th sort-by="class_code_old"
                            sort-direction="{{ $sortColumn == 'class_code_old' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="class_code_old">
                            <span class="d-flex align-items-center">
                                <span>
                                    Mã lớp cũ
                                </span>
                            </span>
                        </th>

                        <th list-action="sort" sort-by="study_date"
                            sort-direction="{{ $sortColumn == 'study_date' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="study_date">
                            <span class="d-flex align-items-center">
                                <span>
                                    Ngày học
                                </span>
                                <span>
                                    <span>
                                        <span
                                            class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'start_at' ? '' : 'text-muted' }}">
                                            sort
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </th>

                        <th list-action="sort" sort-by="start_at"
                            sort-direction="{{ $sortColumn == 'start_at' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="start_at">
                            <span class="d-flex align-items-center">
                                <span>
                                    Thời gian học
                                </span>
                                <span>
                                    <span>
                                        <span
                                            class="material-symbols-rounded ms-2 sort-icon {{ $sortColumn == 'start_at' ? '' : 'text-muted' }}">
                                            sort
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </th>
                        <th sort-by="status"
                            sort-direction="{{ $sortColumn == 'status' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="status">
                            <span class="d-flex align-items-center">
                                <span>
                                    Trạng thái
                                </span>

                            </span>
                        </th>
                        <th sort-by="report_section"
                            sort-direction="{{ $sortColumn == 'report_section' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="report_section">
                            <span class="d-flex align-items-center">
                                <span>
                                    Báo cáo
                                </span>
                            </span>
                        </th>
                        <th sort-by="report_section"
                            sort-direction="{{ $sortColumn == 'report_section' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="report_section">
                            <span class="d-flex align-items-center">
                                <span>
                                    Loại
                                </span>
                            </span>
                        </th>
                        <th sort-by="teacher_id"
                            sort-direction="{{ $sortColumn == 'teacher_id' && $sortDirection ? $sortDirection : 'desc' }}"
                            class="min-w-125px text-left" data-column="teacher_id">
                            <span class="d-flex align-items-center">
                                <span>
                                    Chủ nhiệm
                                </span>
                            </span>
                        </th>

                        <th class="min-w-125px text-left">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @php
                        $count = 1;
                    @endphp

                    @foreach ($sections as $section)
                        <tr list-control="item">
                            <td class="text-left ps-1">
                                <div class="form-check form-check-sm form-check-custom">
                                    <input data-item-id="{{ $section->id }}" list-action="check-item"
                                        class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td>
                            <td data-column="stt" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                {{-- {{  $count*(($section->page + 1) + $section->per_page) }} --}}
                                {{ ($sections->currentPage() - 1) * $sections->perPage() + $loop->iteration }}
                            </td>

                            <td data-column="name" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                {{ optional($section->course->subject)->name ?? 'N/A' }}
                            </td>

                            <td data-column="code" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                {{ $section->course->code }}
                            </td>
                            <td data-column="class_code_old" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                {{ $section->course->import_id }}
                            </td>

                            <td data-column="study_date" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                {{ date('d/m/Y', strtotime($section->study_date)) }}

                            </td>

                            <td data-column="start_at" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                {{ $section->start_at ? date('H:i', strtotime($section->start_at)) : '' }} -
                                {{ $section->end_at ? date('H:i', strtotime($section->end_at)) : '' }}
                            </td>
                            <td data-column="status" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                @php
                                    $bgs = [
                                        '' => 'secondary',
                                        trans('messages.student_section.present') => 'success',
                                        trans('messages.student_section.status_new') => 'secondary',
                                        trans('messages.student_section.study_partner') => 'secondary',
                                        trans('messages.student_section.unexcused_absence') => 'warning',
                                        trans('messages.student_section.excused_absence') => 'warning',
                                        trans('messages.student_section.reserve') => 'danger text-white',
                                        trans('messages.student_section.refund') => 'danger text-white',
                                        trans('messages.student_section.stopped') => 'secondary',
                                    ];
                                @endphp
                            <span
                                class="badge bg-{{ $bgs[trans('messages.student_section.' . $contact->getStudentSectionStatus($section))] ?? 'secondary' }}"
                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                data-bs-placement="right">
                                {{ trans('messages.student_section.' . $contact->getStudentSectionStatus($section)) }}
                            </span>
                                </span>
                            </td>
                            <td data-column="report_section" class="text-left mb-1 text-nowrap"
                                data-filter="mastercard">
                                <a row-action="report-student"
                                    href="{{ action(
                                        [App\Http\Controllers\Sales\SectionReportsController::class, 'reportSectionPopup'],
                                        [
                                            'id' => $contact->id,
                                            'course_id' => $section->course->id,
                                        ],
                                    ) }}">
                                    @if ($section->hasReportForStudent($contact->id))
                                        <span class="badge badge-success">Đã báo cáo</span>
                                    @else
                                        <span class="badge badge-secondary">Chưa báo cáo</span>
                                    @endif
                                </a>
                            </td> --}}
                            <td data-column="teacher_id" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                @php
                                    $bgs = [
                                        App\Models\Section::TYPE_GENERAL => 'info text-white',
                                        App\Models\Section::TYPE_TEST => 'danger text-white',
                                    ];
                                @endphp
                                <span class="badge bg-{{ $bgs[$section->type] ?? 'info text-white' }}"
                                    data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                    data-bs-placement="right">
                                    {{ trans('messages.section.' . $section->type) }}
                                </span>
                            </td>
                            <td data-column="teacher_id" class="text-left mb-1 text-nowrap" data-filter="mastercard">
                                {{ optional($section->course->teacher)->name ?? 'N/A' }} 
                            </td>
                            <td class="text-left">
                                <a href="#"
                                    class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                    style="margin-left: 0px">
                                    Thao tác 
                                    <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                    data-kt-menu="true">
                                    <div
                                        class="menu-item px-3 {{ $section->studentSections->first()->status == App\Models\StudentSection::STATUS_EXCUSED_ABSENCE ? '' : 'd-none' }}">
                                        <a row-action="study-partner"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\StudentController::class, 'studyPartner'],
                                                [
                                                    'id' => $section->id,
                                                    'studentId' => $contact,
                                                ],
                                            ) }}"
                                            class="menu-link px-3">Học bù </a>
                                    </div>
                                    <div
                                        class="menu-item px-3 {{ $section->checkStatusSection() == App\Models\Section::COMPLETED_STATUS ? 'd-none' : '' }}">
                                        <a data-ids-update="{{ $section->id }}" row-action="update"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\CourseController::class, 'reschedulePopup'],
                                                [
                                                    'id' => $section->id,
                                                ],
                                            ) }}"
                                            row-action="edit" data-bs-toggle="tooltip" data-bs-placement="top"
                                            title="{{ $section->checkStatusSection() == App\Models\Section::COMPLETED_STATUS ? 'Đã học' : '' }}"
                                            class="menu-link px-3 d-none">Chuyển buổi học</a>
                                    </div>
                                    <div class="menu-item px-3 {{ $contact->getStudentSectionStatus($section) === App\Models\StudentSection::STATUS_PRESENT ? '' : 'd-none' }} {{ $section->hasReportForStudent($contact->id) ? 'd-none' : '' }}">

                                        <a data-ids-delete="{{ $section->id }}"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\SectionReportsController::class, 'create'],
                                                [
                                                    'id' => $section->id,
                                                    'contact_id' => $contact->id,
                                                ],
                                            ) }}"
                                            row-action="update" 
                                            class="menu-link px-3 ">Báo cáo học tập 
                                       </a>
                                    </div>
                                    <div class="menu-item px-3  ">
                                        <a data-ids-delete="{{ $section->id }}"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\SectionReportsController::class, 'edit'],
                                                [
                                                    'id' => $section->id,
                                                    'contact_id' => $contact->id,
                                                ],
                                            ) }}"
                                            row-action="update"
                                            class="menu-link px-3  {{ $section->hasReportForStudent($contact->id) ? '' : 'd-none' }}">Sửa
                                            báo cáo
                                        </a>
                                    </div>
                                    <div class="menu-item px-3  ">
                                        <a data-ids-delete="{{ $section->id }}"
                                            data-contact-id="{{ $contact->id }}"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\SectionReportsController::class, 'destroy'],
                                                ['section_id' => $section->id, 'contact_id' => $contact->id],
                                            ) }}"
                                            row-action="delete-report"
                                            class="menu-link px-3  {{ $section->hasReportForStudent($contact->id) ? '' : 'd-none' }}">
                                            Xóa báo cáo
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">

                                        <a data-ids-delete="{{ $section->id }}"
                                            data-dayname-control=" {{ strtolower(substr(date('l', strtotime($section->study_date)), 0, 3)) }}"
                                            data-id-control="{{ $section->code }}"
                                            href="{{ action([App\Http\Controllers\Sales\CourseController::class, 'delete'], ['id' => $section->id]) }}"
                                            row-action="delete" class="menu-link px-3 d-none">Hủy buổi học
                                        </a>
                                    </div>
                                </div>
                        </tr>
                        @php
                            $count++;
                        @endphp
                    @endforeach
                </tbody>
            </table>
            <!--end::Table-->
        </div>
        <div class="mt-5">
            {{ $sections->links() }}
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
                Chưa có buổi học nào!
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
    <script>
        $(() => {
            HorizonScrollFix.init();

        });

        var HorizonScrollFix = function() {
            let coursesBox = $('#courses-table-box');

            let setScroll = distanceFromLeft => {
                window.ordersListScrollFromLeft = distanceFromLeft;
            };

            let applyScroll = () => {
                coursesBox.scrollLeft(window.ordersListScrollFromLeft);
            }

            return {
                init: function() {
                    applyScroll();

                    coursesBox.on('scroll', () => {
                        setScroll(coursesBox.scrollLeft());
                    });
                }
            }
        }();
    </script>
</div>
