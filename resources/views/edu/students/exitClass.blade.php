@extends('layouts.main.popup')

@section('title')
    Thoát lớp
@endsection

@php
    $exitClassPopupUniqId = 'exitClass_' . uniqid();
@endphp

@section('content')
    <div id="{{ $exitClassPopupUniqId }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Edu\StudentController@doneExitClass') }}"
            method="post">
            @csrf
            <div class="py-10">
                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <div class="col-12">
                        <div class="mb-10">
                            @if ($course)
                                <input type="hidden" name="studentId" value="{{ $student->id }}">
                                <div class="form-outline mb-7">
                                    <div class="d-flex align-items-center">
                                        <label for="" class="form-label fw-semibold text-info">Học viên sẽ ngừng
                                            toàn bộ buổi chưa học của lớp này</label>
                                    </div>

                                    <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">

                                        <table class="table table-row-bordered table-hover table-bordered table-fixed">
                                            <thead>
                                                <tr
                                                    class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                                                    <th style="width:1%"></th>
                                                    <th class="text-nowrap text-white">Tên lớp học</th>
                                                    <th class="text-nowrap text-white">Môn học</th>
                                                    <th class="text-nowrap text-white">Loại hình</th>
                                                    <th class="text-nowrap text-white">Trạng thái</th>
                                                    <th class="text-nowrap text-white">Thời gian bắt đầu</th>
                                                    <th class="text-nowrap text-white">Thời gian kết thúc</th>
                                                    <th class="text-nowrap text-white">Chủ nhiệm</th>
                                                    <th class="text-nowrap text-white">Số lượng học viên tối đa</th>
                                                    <th class="text-nowrap text-white">Tổng giờ học</th>
                                                </tr>
                                            </thead>
                                            <tbody>


                                                <tr data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="left" data-bs-dismiss="click"
                                                    data-bs-original-title="Nhấn để chọn lớp học">
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <input request-control="select-radio" name="course_id"
                                                                list-action="check-item" class="form-check-input"
                                                                type="radio" value="{{ $course->id }}" checked />
                                                        </div>
                                                    </td>

                                                    <td>{{ $course->code }}</td>
                                                    <td>{{ $course->subject->name }}</td>
                                                    <td>{{ $course->study_method }}</td>

                                                    <td>{{ $course->checkStatusSubject() }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($course->start_at)->format('d/m/Y') }}</td>
                                                    <td>{{ $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->getEndAt())->format('d/m/Y') : '--' }}
                                                    </td>
                                                    <td>{{ $course->teacher->name }}</td>
                                                    <td>{{ $course->max_students }}</td>
                                                    <td>{{ $course->total_hours }}</td>
                                                </tr>

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            @else
                                <div class="">
                                    <div class="form-outline">
                                        <span class="d-flex align-items-center">
                                            <span class="material-symbols-rounded me-2 ms-4"
                                                style="vertical-align: middle;">
                                                error
                                            </span>
                                            <span>Chưa có lớp đang học</span>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                    <div id="error-message" class="error-message text-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="submit" popup-control="save" class="btn btn-primary">
                        <span class="indicator-label">Thoát lớp</span>
                        <span class="indicator-progress">Đang xử lý...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                        data-bs-dismiss="modal">Hủy</button>
                    <!--end::Button-->
                </div>
            </div>
        </form>
    </div>
    <script>
        var exitClassManager;

        $(() => {
            exitClassManager = new ExitClassManager({
                container: document.querySelector('#{{ $exitClassPopupUniqId }}')
            })
        });

        var ExitClassManager = class {
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

            hasCheckOrderItem() {
                return $('input[name="course_id"]:checked').length > 0;
            }
            hideErrorMessage() {
                const errorContainer = document.getElementById('error-message');
                errorContainer.style.display = 'none';
            }
            events() {
                const _this = this;

                _this.getForm().addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!_this.hasCheckOrderItem()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng chọn lớp học trước khi chuyển lớp!';
                        errorContainer.style.display = 'block';
                        return;
                    }

                    const url = _this.getForm().getAttribute('action');
                    const data = $(_this.getForm()).serialize();
                    $.ajax({
                        url: url,
                        method: 'post',
                        data: data
                    }).done(response => {
                        UpdateContactPopup.getPopup().hide();

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

                            }
                        });
                    }).fail(response => {
                        throw new Error(response);
                    })
                });
            };
        };
    </script>
@endsection
