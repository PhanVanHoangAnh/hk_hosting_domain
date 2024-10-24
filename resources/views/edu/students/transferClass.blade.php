@extends('layouts.main.popup')

@section('title')
    Chuyển lớp
@endsection

@php
    $transferClassPopupUniqId = 'transferClass_' . uniqid();
@endphp

@section('content')
    <div id="{{ $transferClassPopupUniqId }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Edu\StudentController@doneTransferClass') }}"
            method="post">
            @csrf
            <div class="py-10">
                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <div class="col-12">
                        @include('edu.students._student_transfer_form', [
                            'formId' => $transferClassPopupUniqId,
                            'student' => $student,
                            'currentCourse' => $currentCourse,
                        ])
                    </div>
                    <div id="error-message" class="error-message text-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="submit" popup-control="save" class="btn btn-primary">
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
            </div>
        </form>
    </div>
    <script>
        var transferClassManager;

        $(() => {
            transferClassManager = new TransferClassManager({
                container: document.querySelector('#{{ $transferClassPopupUniqId }}')
            })
        });

        var TransferClassManager = class {
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
                return $('input[name="current_course_id"]:checked').length > 0;
            }

            hasCheckCourse() {
                return $('input[name="course_transfer_id"]:checked').length > 0;
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
                            'Vui lòng chọn lớp học trước khi chuyển lớp!';
                        errorContainer.style.display = 'block';
                        return;
                    }

                    if (!_this.hasCheckCourse()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent = 'Vui lòng chọn lớp muốn chuyển tới khi chuyển lớp!';
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
                        TransferClassPopup.getPopup().hide();    

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
