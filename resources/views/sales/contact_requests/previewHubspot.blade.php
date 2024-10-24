@extends('layouts.main.popup')

@section('title')
    Nhập dữ liệu đơn hàng từ HubSpot
@endsection

@section('content')
    <form id="AddHandeoversForm">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_contact_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_modal_add_contact_header"
            data-kt-scroll-wrappers="#kt_modal_add_contact_scroll" data-kt-scroll-offset="300px">
            <!--begin::Input group-->
            <div class="fv-row ">
                <label class="fs-6 fw-semibold mb-2">Chọn tài khoản để bàn giao</label>
                <input type="hidden" id="tokenValue" value="{{ $token }}">
                <div>
                    <select data-dropdown-parent="#AddHandeoversForm" class="form-select mb-2" data-control="select2" data-placeholder="Select an option"
                        name="accounts" id="accountSelect">
                        {{-- <option></option> --}}
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>

                <label class="fs-6 fw-semibold mb-2 mt-2 ">Danh sách đơn hàng </label>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th>Tên đơn hàng</th>
                                <th>Email</th>
                                <th>Số điện thoại</th>
                                <th>Địa chỉ</th>
                                <th>Trường học</th>
                                <th>Hubspot ID</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($contactRequests as $contactRequest)
                                {{-- <input type="hidden" name="contact_request_id[]" value="{{ $contactRequest->id }}"> --}}
                                <tr>
                                    <td> {{ $contactRequest['lastname'] }}
                                        {{ $contactRequest['firstname'] }}
                                    </td>
                                    <td> {{ $contactRequest['email'] }}</td>
                                    <td> {{ $contactRequest['phone'] }}</td>
                                    <td> {{ $contactRequest['address'] }}</td>
                                    <td> {{ $contactRequest['school'] }}</td>
                                    <td> {{ $contactRequest['hubstop_id'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="AddContactRequestsHubspotSubmitButton" type="submit" class="btn btn-primary">
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
        $(function() {
            AddContactRequestsHubspot.init();
        })
        var AddContactRequestsHubspot = function() {
            var btnSubmit;
            var popupAddContactRequestsHubspot;

            var handleSubmit = function() {
                addEventListener('submit', (e) => {
                    e.preventDefault();
                    submit();
                });
            }
            submit = () => {
                var account_id = document.getElementById('accountSelect').value;
                var token = document.getElementById('tokenValue').value;
                popupAddContactRequestsHubspot.setData({
                    token: token,
                    account_id: account_id,
                    _token: "{{ csrf_token() }}",
                });
                TokenHubSpotPopup.getPopup().hide();
                popupAddContactRequestsHubspot.loadHubSpot();
            }
            return {
                init: function() {
                    popupAddContactRequestsHubspot = new Popup({
                        url: "{{ action([App\Http\Controllers\HubSpotController::class, 'import']) }}",
                        method: 'POST',
                    });
                    btnSubmit = document.getElementById('AddContactRequestsHubspotSubmitButton');
                    handleSubmit();
                },
                getPopup: function() {
                    return popupAddContactRequestsHubspot;
                }

            }
        }();
    </script>
@endsection
