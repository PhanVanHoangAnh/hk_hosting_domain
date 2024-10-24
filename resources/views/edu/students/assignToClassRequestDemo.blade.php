@extends('layouts.main.popup')

@section('title')
    Xếp lớp demo
@endsection

@php
    $assignToClassPopupUniqId = 'assignToClassRequestDemo_' . uniqid();
@endphp

@section('content')
    <div id="{{ $assignToClassPopupUniqId }}">
        <form data-action="form"
            action="{{ action('\App\Http\Controllers\Edu\StudentController@doneAssignToClassRequestDemo') }}" method="post">
            @csrf
            <div class="py-10">
                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <input type="hidden" value="{{ $student->id }}" name="studentId">
                    <div class="col-12">
                        @include('edu.students._student_form_request_demo', [
                            'formId' => $assignToClassPopupUniqId,
                            'student' => $student,
                        ])
                    </div>
                    <div id="error-message" class="error-message text-danger" style="display: none;"></div>
                </div>

                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="submit" popup-control="save" class="btn btn-primary">
                        <span class="indicator-label">Xếp lớp</span>
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
        var assignToClassRequestDemoManager;

        $(() => {
            assignToClassRequestDemoManager = new AssignToClassRequestDemoManager({
                container: document.querySelector('#{{ $assignToClassPopupUniqId }}')
            })
        });

        var AssignToClassRequestDemoManager = class {
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
            hasSelectedStudent() {
                const selectedStudent = this.getContainer().querySelector('[form-control="contact-select"]').value;
                return selectedStudent !== '';
            }

            hasCheckOrderItem() {
                return $('input[name="order_item_id"]:checked').length > 0;
            }
            hasCheckCourse() {
                return $('input[name="course_id"]:checked').length > 0;
            }
            hasCheckSection() {
                return $('input[name="sectionIds[]"]:checked').length > 0;
            }
            hideErrorMessage() {
                const errorContainer = document.getElementById('error-message');
                errorContainer.style.display = 'none';
            }
            events() {
                const _this = this;

                _this.getForm().addEventListener('submit', function(e) {
                    e.preventDefault();
                    if (!_this.hasSelectedStudent()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent = 'Vui lòng chọn học viên.';
                        errorContainer.style.display = 'block';
                        return;
                    }
                    if (!_this.hasCheckOrderItem()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng chọn dịch vụ của hợp đồng trước khi xếp lớp!';
                        errorContainer.style.display = 'block';
                        return;
                    }
                    if (!_this.hasCheckCourse()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent = 'Vui lòng chọn lớp trước khi xếp lớp!';
                        errorContainer.style.display = 'block';
                        return;
                    }
                    if (!_this.hasCheckSection()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent = 'Vui lòng chọn buổi học để xếp lớp!';
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
                        assignToClassPopup.hide();
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
