@extends('layouts.main.popup')

@section('title')
    Bảo lưu học viên
@endsection

@php
    $reservePopupUniqId = 'reserve_' . uniqid();
@endphp

@section('content')
    <div id="{{ $reservePopupUniqId }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Edu\StudentController@doneAssignToClass') }}"
            method="post">
            @csrf
            <div class="py-10">
                <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
                    <div class="col-12">
                        @include('edu.reserve._student_form', [
                            'formId' => $reservePopupUniqId,
                            'student' => $student,
                        ])
                    </div>
                </div>
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="submit" popup-control="save" class="btn btn-primary">
                        <span class="indicator-label">Bảo lưu</span>
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
            reserveManager = new reserveManager({
                container: document.querySelector('#{{ $reservePopupUniqId }}')
            })
        });

        var reserveManager = class {
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

            events() {
                const _this = this;

                _this.getForm().addEventListener('submit', function(e) {
                    e.preventDefault();

                    const url = _this.getForm().getAttribute('action');
                    const data = $(_this.getForm()).serialize();
                    $.ajax({
                        url: url,
                        method: 'post',
                        data: data
                    }).done(response => {
                        reservePopup.hide();
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
