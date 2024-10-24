@extends('layouts.main.popup')

@section('title')
    Yêu cầu hoàn phí
@endsection

@php
    $transferClassPopupUniqId = 'transferClass_' . uniqid();
@endphp

@section('content')
    <div id="{{ $transferClassPopupUniqId }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Sales\StudentController@doneRefundRequest') }}"
            method="post">
            @csrf
            <div class="py-10">

                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <div class="col-12">
                        @include('sales.students._refund_request_form', [
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
                            'Vui lòng chọn ngày yêu cầu hoàn phí!';
                        errorContainer.style.display = 'block';
                        return;
                    }

                    if (!_this.hasCheckOrderItem()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng chọn dịch vụ để yêu cầu hoàn phí!';
                        errorContainer.style.display = 'block';
                        return;
                    }

                    if (!_this.hasInputreason()) {
                        const errorContainer = document.getElementById('error-message');
                        errorContainer.textContent =
                            'Vui lòng nhập lý do hoàn phí!';
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
                        if (typeof UpdateContactPopup !== 'undefined' && UpdateContactPopup && typeof UpdateContactPopup.getPopup ==='function') 
                        {
                            UpdateContactPopup.getPopup().hide();
                        }
                        if (typeof CreateReceiptPopup !== 'undefined' && CreateReceiptPopup && typeof CreateReceiptPopup.getCreatePopup ==='function') 
                        {
                            CreateReceiptPopup.getCreatePopup().hide();
                        }
                        

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
                                if (typeof RefundList !== 'undefined' &&
                                RefundList && typeof RefundList.getList ===
                                    'function') {
                                        RefundList.getList().load();
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
