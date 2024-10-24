@extends('layouts.main.popup')

@section('title')
    Cập nhật trạng thái buổi học - {{ $section->course->code }} -
    {{ \Carbon\Carbon::parse($section->end_at)->format('d/m/Y') }}
@endsection

@section('content')
    @php
        $formId = 'F' . uniqid();
    @endphp
    <form id="{{ $formId }}" method="POST" enctype="multipart/form-data" data-action="form" action=""
        class="shift-form">
        @csrf

        <input type="hidden" name="section" value="{{ $section->id }}">


        <div class=" px-lg-17 py-5 ">
            <label class="ms-2">
                <p class="fs-2 fw-bold fw-semibold me-8">
                    <input name="checkShift" value="{{ \App\Models\Section::STATUS_STUDIED }}" list-action="check-item"
                        class="form-check-input mt-1 me-2" checked type="radio" />Học
                </p>
            </label>
            <label class="ms-2">
                <p class="fs-2 fw-bold fw-semibold ">
                    <input name="checkShift" value="{{ \App\Models\Section::STATUS_CANCELLED }}" list-action="check-item"
                        class="form-check-input mt-1 me-2" type="radio" />Nghỉ
                </p>
            </label>
        </div>
        <div class="px-lg-17 py-3" id="shiftWhenStudied">
            @include('edu.sections.shiftWhenStudied')
        </div>

        <!-- Thêm id cho div chứa nội dung khi nghỉ -->
        <div class="px-lg-17 py-3 d-none" id="shiftWhenCancelled">
            @include('edu.sections.shiftWhenCancelled')
        </div>
        <!--end::Scroll-->
        <div class=" px-lg-17 py-3 ">
            <div id="error-message" class="error-message text-danger" style="display: none;"></div>
        </div>

        <div class="d-flex justify-content-center pb-5 py-7">
            <!--begin::Button-->
            <button id="attendanceButton" type="submit" class="btn btn-primary me-2">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>

    <script>
        var transferManager;

        $(() => {
            transferClassManager = new TransferManager({
                container: document.querySelector('#{{ $formId }}')
            })
        });

        var TransferManager = class {
            constructor(options) {
                this.container = options.container;

                this.events();
            };

            getContainer() {
                return this.container;
            };

            getForm() {
                return this.getContainer().querySelector('[data-action="form"]');
            };

            hasCheckCourse() {
                return $('input[name="checkShift"]:checked').length > 0;
            }

            getCheckShift() {
                return $('input[name="checkShift"]:checked').val();
            }

            getCheckShiftCancelled() {
                return $('input[name="checkShift"]:checked').val() ===
                    "{{ \App\Models\Section::STATUS_CANCELLED }}";
            }
            
            getCheckShiftStudied() {
                return $('input[name="checkShift"]:checked').val() ===
                    "{{ \App\Models\Section::STATUS_STUDIED }}";
            }

            getCancelled() {
                return $('input[name="cancelled"]:checked').val() ===
                    "{{ \App\Models\Section::STATUS_CANCELLED }}";
            }

            getUnplannedCancelled() {
                return $('input[name="cancelled"]:checked').val() ===
                    "{{ \App\Models\Section::STATUS_UNPLANNED_CANCELLED }}";
            }

            getUnplannedCancelledSelect() {
                return $('input[name="unplannedCancelled"]:checked').val();
            }

            getNote() {
                return $('.delete-on-note').val() === "";
            }
            
            hideErrorMessage() {
                const errorContainer = document.getElementById('error-message');
                errorContainer.style.display = 'none';
            }

            events() {
                const _this = this;
                let data;

                $('input[name="checkShift"]').change(function() {
                    // Lấy giá trị của radio button được chọn
                    var selectedValue = $(this).val();
                    // Ẩn/hiện phần nội dung và thay đổi id tương ứng
                    if (selectedValue === "{{ \App\Models\Section::STATUS_STUDIED }}") {
                        $('.deselect-on-cancelled').prop('checked', false);
                        $('.delete-on-note').val('');
                        $("#shiftWhenStudied").removeClass("d-none");
                        $("#shiftWhenCancelled").addClass("d-none");
                    } else {
                        $("#shiftWhenStudied").addClass("d-none");
                        $("#shiftWhenCancelled").removeClass("d-none");
                    }
                });

                _this.container.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!_this.getCheckShift()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent = 'Vui lòng chọn trạng thái buổi học để chốt ca.';
                        errorContainer.style.display = 'block';

                        return;
                    }

                    if (_this.getCheckShiftCancelled()) {
                        if (!_this.getCancelled() && !_this.getUnplannedCancelled()) {
                            const errorContainer = document.getElementById('error-message');
                            errorContainer.textContent = 'Vui lòng chọn trạng thái nghỉ của buổi học.';
                            errorContainer.style.display = 'block';

                            return;
                        }

                        if (_this.getUnplannedCancelled()) {
                            if (!_this.getUnplannedCancelledSelect()) {
                                const errorContainer = document.getElementById('error-message');
                                errorContainer.textContent =
                                    'Vui lòng chọn lý do nghỉ không có kế hoạch.';
                                errorContainer.style.display = 'block';

                                return;
                            }

                            if (_this.getNote()) {
                                const errorContainer = document.getElementById('error-message');
                                errorContainer.textContent =
                                    'Vui lòng viết ghi chú cho lý do nghỉ không có kế hoạch.';
                                errorContainer.style.display = 'block';

                                return;
                            }
                        }
                    }
                    if (_this.getCheckShiftStudied()) {
                        var checkboxes = document.querySelectorAll('[list-action="check-item"]:checked');

                        if (checkboxes.length > 0) {
                            var hasReport = false;

                            checkboxes.forEach(function(checkbox) {
                                var status = checkbox.value;

                                if (status === 'present' || status === 'new') {
                                    var reportStatusInput = checkbox.closest('tr').querySelector(
                                        '[name="reportStatus"]');

                                    if (reportStatusInput) {
                                        var reportStatus = reportStatusInput.value.trim();

                                        if (reportStatus === 'Chưa báo cáo') {
                                            hasReport = true;
                                        }
                                    }
                                }
                            });

                            if (hasReport) {
                                const errorContainer = document.getElementById('error-message');

                                errorContainer.textContent = 'Vui lòng viết báo cáo học tập trước khi lưu.';
                                errorContainer.style.display = 'block';

                                return;
                            }

                            var selectedData = [];

                            checkboxes.forEach(function(checkbox) {
                                selectedData.push({
                                    sectionId: checkbox.getAttribute('data-section-id'),
                                    studentId: checkbox.getAttribute('data-student-id'),
                                    status: checkbox.value,
                                    start_at: document.querySelector('[name="start_at"]')
                                        .value,
                                    end_at: document.querySelector('[name="end_at"]').value
                                });
                            });

                            var hiddenInput = document.createElement('input');
                            hiddenInput.type = 'hidden';
                            hiddenInput.name = 'attendance';
                            hiddenInput.value = JSON.stringify(selectedData);

                            data = $(_this.getContainer()).serialize() + '&' + 'attendance=' +
                                encodeURIComponent(JSON.stringify(selectedData));
                        } else {
                            throw new Error('No checkboxes selected.');
                        }
                    } else {
                        data = $(_this.getContainer()).serialize();
                    }

                    const actionWhenStudied =
                        "{{ action([App\Http\Controllers\Edu\SectionController::class, 'saveAttendancePopup'], ['id' => $section->id]) }}";
                    const actionWhenCancelled =
                        "{{ action([App\Http\Controllers\Edu\SectionController::class, 'saveShift'], ['id' => $section->id]) }}";
                    // const url = _this.container.getAttribute('action');
                    const url = _this.getCheckShift() === "{{ \App\Models\Section::STATUS_STUDIED }}" ? actionWhenStudied : actionWhenCancelled;

                    $.ajax({
                        url: url,
                        method: 'post',
                        data: data
                    }).done(response => {
                        AttendancePopup.getPopup().hide();

                        ASTool.alert({
                            message: response.message,
                            ok: () => {
                                if (typeof ContactsList !== 'undefined' &&
                                    ContactsList && typeof ContactsList.getList ===
                                    'function') {
                                    ContactsList.getList().load();
                                }

                                if (typeof StaffsList !== 'undefined' &&
                                    StaffsList && typeof StaffsList.getList ===
                                    'function') {
                                    StaffsList.getList().load();
                                }

                                if (typeof SectionList !== 'undefined') {
                                    SectionList.getList().load();
                                }

                                if (typeof ReportsStudentPopup !== 'undefined') {
                                    ReportsStudentPopup.getPopup().load();
                                }

                                if (typeof StudentList !== 'undefined') {
                                    StudentList.getList().load();
                                }  
                            }
                        });
                    }).fail(response => {
                        if (response.responseJSON && response.responseJSON.message) {
                            const errorMessage = response.responseJSON.message;
                            const errorContainer = document.getElementById('error-message');

                            // Hiển thị thông báo lỗi và hiển thị phần tử chứa thông báo lên giao diện
                            errorContainer.textContent = errorMessage;
                            errorContainer.style.display = 'block';
                        } else {
                            throw new Error('Không có thông báo lỗi được trả về từ server.');
                        }
                    })
                });
            };
        };
    </script>
@endsection
