@extends('layouts.main.popup')

@section('title')
    Dừng bảo lưu
@endsection

@php
    $reserveCancelled = 'transferClass_' . uniqid();
@endphp

@section('content')
    <div id="{{ $reserveCancelled }}">
        <form data-action="form" action="{{ action('\App\Http\Controllers\Edu\ReserveController@doneReserveCancelled') }}"
            method="post">
            @csrf
            <div class="py-10 px-10">
                @if ($reserve->count())
                    <label for="" class="form-label fw-semibold">Bảo lưu muốn dừng bảo lưu</label>
                    <input type="hidden" name="reserve" value="{{ $reserve->id }}">
                    <div class="table-responsive">
                        <table class="table table-row-bordered table-hover table-bordered">
                            <thead>
                                <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">

                                    <th class="text-nowrap text-white">Tên học viên</th>
                                    <th class="text-nowrap text-white">Điện thoại</th>
                                    <th class="text-nowrap text-white">Email</th>
                                    <th class="text-nowrap text-white">Trạng thái</th>
                                    <th class="text-nowrap text-white">Ngày bảo lưu</th>
                                    <th class="text-nowrap text-white">Ngày hết hạn bảo lưu</th>
                                    <th class="text-nowrap text-white">Lý do bảo lưu</th>

                                </tr>
                            </thead>
                            <tbody>
                                <td>{{ $reserve->student->name }}</td>
                                <td>{{ $reserve->student->phone }}</td>
                                <td>{{ $reserve->student->email }}</td>
                                <td>{{ $reserve->status }}</td>



                                @php
                                    $reserve->start_at = new \DateTime($reserve->start_at);
                                @endphp
                                <td class="text-nowrap" data-column="start_at">
                                    {{ $reserve->start_at->format('d/m/Y') }}
                                </td>
                                @php
                                    $reserve->end_at = new \DateTime($reserve->end_at);
                                @endphp
                                <td class="text-nowrap" data-column="end_at">
                                    {{ $reserve->end_at->format('d/m/Y') }}
                                </td>
                                <td>{{ $reserve->reason }}</td>

                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="mb-10">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-outline">
                                    <label class="required fs-6 fw-semibold mb-2">Gian hạn thời điểm kết thúc bảo
                                        lưu</label>
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" value="" name="reserve_end_at" id="reserve_end_at"
                                            placeholder="=asas" type="date" class="form-control">
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div id="error-message" class="error-message text-danger" style="display: none;"></div>
                @endif



                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="submit" popup-control="save" class="btn btn-primary">
                        <span class="indicator-label">Dừng bảo lưu</span>
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
        var reserveCancelledManager;

        $(() => {
            reserveCancelledManager = new ReserveCancelledManager({
                container: document.querySelector('#{{ $reserveCancelled }}')
            })
        });

        var ReserveCancelledManager = class {
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



            hideErrorMessage() {
                const errorContainer = document.getElementById('error-message');
                errorContainer.style.display = 'none';
            }
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
