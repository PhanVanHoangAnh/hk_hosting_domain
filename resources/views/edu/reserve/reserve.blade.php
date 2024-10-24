@extends('layouts.main.popup')

@section('title')
    Bảo lưu
@endsection

@php
    $reservePopupUniqId = 'reserve_' . uniqid();
@endphp

@section('content')
    <div id="{{ $reservePopupUniqId }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Edu\StudentController@doneReserve') }}"
            method="post">
            @csrf
            <div class="py-10">

                <input type="hidden" name="studentId" value="{{ $student->id }}">
                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <div class="col-12">
                        @include('edu.reserve._reserve_form', [
                            'formId' => $reservePopupUniqId,
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
        var reserveManager;

        $(() => {
            reserveManager = new ReserveManager({
                container: document.querySelector('#{{ $reservePopupUniqId }}')
            })
        });

        var ReserveManager = class {
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

            hasCheckCourse() {
                return $('input[name="current_course_id"]:checked').length > 0;
            }
            hasCheckOrderItem() {
                return $('input[name="orderItemIds[]"]:checked').length > 0;
            }
            hasSelectedReserveStartAt() {
                const selectedStudent = this.getContainer().querySelector('[id="reserve_start_at"]').value;
                return selectedStudent !== '';
            }
            hasInputreason() {
                const selectedStudent = this.getContainer().querySelector('[name="reason"]').value;
                return selectedStudent !== '';
            }
            hideErrorMessage() {
                const errorContainer = document.getElementById('error-message');
                errorContainer.style.display = 'none';
            }
            beforeSend() {
                // Show loading indicator
                $(this.getForm()).find('.indicator-label').hide();
                $(this.getForm()).find('.indicator-progress').show();
                $(this.getForm()).addClass('pe-none');
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

                    if (!_this.hasSelectedReserveStartAt()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng chọn ngày bảo lưu!';
                        errorContainer.style.display = 'block';
                        return;
                    }
                    if (!_this.hasCheckOrderItem()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng chọn dịch vụ để bảo lưu!';
                        errorContainer.style.display = 'block';
                        return;
                    }
                    if (!_this.hasInputreason()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng nhập lý do bảo lưu!';
                        errorContainer.style.display = 'block';
                        return;
                    }

                    const url = _this.getForm().getAttribute('action');
                    const data = $(_this.getForm()).serialize();
                    
                    _this.beforeSend();

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
