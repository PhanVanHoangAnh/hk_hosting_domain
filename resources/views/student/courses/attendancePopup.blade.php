@extends('layouts.main.popup')

@section('title')
    Điểm danh ngày {{ date('d/m/Y', strtotime($section->study_date)) }}
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp
    <form id="{{ $formId }}" method="POST" enctype="multipart/form-data"
        action="{{ action([App\Http\Controllers\Student\SectionController::class, 'saveAttendancePopup'], ['id' => $section->id]) }}">
        @csrf
        <div class=" px-lg-17 py-5 d-flex flex-stack flex-wrap ">
            {{-- {{$students->get()}} --}}
            <label class="fs-2 fw-bold fw-semibold ">Danh sách học viên trong buổi học này</label>
            <label class="fs-4  fw-semibold ">Tổng cộng: <strong>{{ $students->count() }}</strong></label>
        </div>
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
                <div class=" pe-7 px-lg-17 pt-7" id="StudentIndexListContent">

                    <!--begin::Input group-->
                    <div class="fv-row ">
                        <div class="table-responsive table-head-sticky">
                            <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                                <thead>
                                    <tr
                                        class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                        <th class="ps-3">Tên học viên</th>
                                        <th>Email </th>
                                        <th>Điện thoại</th>
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
                                        <tr>
                                            <td class="ps-3"> {{ $student->student->name }}</td>
                                            <td>{{ $student->student->email }}</td>
                                            <td>{{ $student->student->phone }}</td>
                                            <td>
                                                @php
                                                    $status = $student->status;
                                                    $sectionId = $section->id;
                                                    $studentId = $student->student->id;
                                                    $attendanceExists = \App\Models\Attendance::checkAttendance($studentId, $sectionId);
                                                @endphp

                                                <div
                                                    class="form-check form-check-sm form-check-custom d-flex justify-content-center">

                                                    <input name="attendance{{ $student->id }}"
                                                        data-section-id="{{ $section->id }}"
                                                        data-student-id="{{ $student->student->id }}"
                                                        list-action="check-item" class="form-check-input" type="radio"
                                                        value="present"
                                                        {{ $status === \App\Models\StudentSection::STATUS_PRESENT || $status === \App\Models\StudentSection::STATUS_NEW ? 'checked' : '' }} />
                                                </div>
                                            </td>
                                            <td>

                                                <div
                                                    class="form-check form-check-sm form-check-custom d-flex justify-content-center">
                                                    <input name="attendance{{ $student->id }}"
                                                        data-section-id="{{ $section->id }}"
                                                        data-student-id="{{ $student->student->id }}"
                                                        list-action="check-item" class="form-check-input" type="radio"
                                                        value="excused_absence"
                                                        {{ $status === \App\Models\StudentSection::STATUS_EXCUSED_ABSENCE ? 'checked' : '' }} />
                                                </div>
                                            </td>
                                            <td>

                                                <div
                                                    class="form-check form-check-sm form-check-custom d-flex justify-content-center">

                                                    <input name="attendance{{ $student->id }}"
                                                        data-section-id="{{ $section->id }}"
                                                        data-student-id="{{ $student->student->id }}"
                                                        list-action="check-item" class="form-check-input" type="radio"
                                                        value="unexcused_absence"
                                                        {{ $status === \App\Models\StudentSection::STATUS_UNEXCUSED_ABSENCE ? 'checked' : '' }} />
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
        <!--end::Scroll-->


        <div class="d-flex justify-content-center pb-5 py-7">
            <!--begin::Button-->
            @if ($students->count())
                <button id="attendanceButton" type="submit" class="btn btn-primary me-2">
                    <span class="indicator-label">Lưu</span>
                    <span class="indicator-progress">Đang xử lý...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
            @endif
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>


    <script>
        $(function() {
            AttendanceIndex.init();
        });

        var AttendanceIndex = function() {

            return {
                init: () => {
                    AttendenceCheckBox.init();

                    SaveAttendence.init();
                }
            }
        }();
        var SaveAttendence = function() {
            let form;
            let submitDataBtn;

            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    submit();
                });
            };

            const submit = () => {
                var checkboxes = document.querySelectorAll('[list-action="check-item"]:checked');
                var selectedData = [];

                checkboxes.forEach(function(checkbox) {

                    selectedData.push({
                        sectionId: checkbox.getAttribute('data-section-id'),
                        studentId: checkbox.getAttribute('data-student-id'),
                        status: checkbox.value,
                    });

                });

                var hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput
                    .name = 'attendance';
                hiddenInput.value = JSON.stringify(selectedData);

                var url = form.getAttribute('action');
                addSubmitEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        attendance: JSON.stringify(selectedData)
                    },
                }).done(response => {

                    AttendancePopup.getPopup().hide();
                    ASTool.alert({
                        message: response.message,
                        ok: () => {
                            SectionList.getList().load();
                        }
                    });
                }).fail(response => {
                    AttendancePopup.getPopup().setContent(response.responseText);
                    removeSubmitEffect();
                });
            };

            const addSubmitEffect = () => {
                submitDataBtn.setAttribute('data-kt-indicator', 'on');
                submitDataBtn.setAttribute('disabled', true);
            };

            const removeSubmitEffect = () => {
                submitDataBtn.removeAttribute('data-kt-indicator');
                submitDataBtn.removeAttribute('disabled');
            };

            return {
                init: () => {
                    form = document.querySelector("#{{ $formId }}");
                    submitDataBtn = document.querySelector("#attendanceButton");

                    handleFormSubmit();
                }
            };
        }();

        var AttendenceCheckBox = function() {
            const listContent = document.querySelector('#StudentIndexListContent');
            const container = document.querySelector('#StudentIndexContainer');


            return {
                getCheckAllButton() {
                    return container.querySelector('[list-action="check-all"]');
                },
                updateCountLabel() {
                    container.querySelector('[list-control="count-label"]').innerHTML = 'Đã chọn <strong>' +
                        this
                        .checkedCount() + '</strong> học viên';
                },
                getListCheckboxes() {
                    return listContent.querySelectorAll('[list-action="check-item"]');
                },
                getListCheckedBoxes() {
                    return listContent.querySelectorAll('[list-action="check-item"]:checked');
                },
                checkedCount() {
                    return this.getListCheckedBoxes().length;
                },
                checkAllList() {
                    this.getListCheckboxes().forEach(checkbox => {
                        checkbox.checked = true;
                    });
                },
                uncheckAllList() {
                    this.getListCheckboxes().forEach(checkbox => {
                        checkbox.checked = false;
                    });
                },
                init() {
                    const checkAllButton = this.getCheckAllButton();


                    this.getListCheckboxes().forEach(checkbox => {
                        checkbox.addEventListener('change', () => {
                            this.handleCheckboxChange();
                        });
                    });

                    this.getCheckAllButton().addEventListener('click', () => {

                        this.handleCheckAllClick();
                    });

                    this.updateCountLabel();
                },
                handleCheckboxChange() {
                    var allChecked = this.getListCheckboxes().length === this.checkedCount();

                    if (allChecked) {
                        this.getCheckAllButton().textContent = 'Bỏ chọn tất cả';
                    }
                    this.getCheckAllButton().textContent = 'Chọn tất cả';

                    this.updateCountLabel();
                },
                handleCheckAllClick() {
                    const checkboxes = Array.from(this.getListCheckboxes());

                    var allChecked = checkboxes.every(checkbox => checkbox.checked);

                    if (!allChecked) {
                        this.checkAllList();
                        this.getCheckAllButton().textContent = 'Bỏ chọn tất cả';
                    } else {
                        this.uncheckAllList();
                        this.getCheckAllButton().textContent = 'Chọn tất cả';
                    }

                    this.updateCountLabel();
                },

            }
        }();
    </script>
@endsection
