@extends('layouts.main.popup')

@section('title')
    Dừng lớp
@endsection

@php
    $stoppedClassPopupUniqId = 'stoppedClass_' . uniqid();
@endphp

@section('content')
    <div id="{{ $stoppedClassPopupUniqId }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Edu\CourseController@doneCourseStopped') }}"
            method="post">
            @csrf
            <div class="py-10">
                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <div class="col-12">
                        @include('edu.courses.courseStoppedlist', [
                            'course' => $course,
                        ])
                    </div>
                    <div id="error-message" class="error-message text-danger" style="display: none;"></div>
                </div>
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="submit" popup-control="save" class="btn btn-primary">
                        <span class="indicator-label">Dừng lớp</span>
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
        var stoppedClassManager;

        $(() => {
            stoppedClassManager = new StoppedClassManager({
                container: document.querySelector('#{{ $stoppedClassPopupUniqId }}')
            })
        });

        var StoppedClassManager = class {
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
            hasSelectedReserveStartAt() {
                const selectedStudent = this.getContainer().querySelector('[name="stopped_at"]').value;
                return selectedStudent !== '';
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
                            'Vui lòng chọn lớp học để dừng lớp!';
                        errorContainer.style.display = 'block';
                        return;
                    }
                    if (!_this.hasSelectedReserveStartAt()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng chọn ngày bắt đầu dừng lớp!';
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
                        ShowOrderPopup.getPopup().hide();

                        ASTool.alert({
                            message: response.message,
                            ok: () => {
                                if (typeof CoursesList !== 'undefined' &&
                                    CoursesList && typeof CoursesList.getList ===
                                    'function') {
                                    CoursesList.getList().load();
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
