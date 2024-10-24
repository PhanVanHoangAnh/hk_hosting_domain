@extends('layouts.main.popup')

@section('title')
    Bàn giao nhân viên sale
@endsection

@section('content')
    <form id="AddHandeoversForm">
        @csrf
        <div class="pe-7  px-lg-17 py-5 d-flex flex-stack flex-wrap ">
            <label class="fs-2 fw-bold fw-semibold ">Danh sách đơn hàng</label>
        </div>
        <!--begin::Scroll-->
        <div class="scroll-y pe-7  px-lg-17" id="kt_modal_add_contact_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_modal_add_contact_header" data-kt-scroll-wrappers="#kt_modal_add_contact_scroll"
            data-kt-scroll-offset="300px">
            <!--begin::Input group-->
            <div class="fv-row ">

                <div class="table-responsive table-head-sticky">
                    <table class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                <th>Tên đơn hàng</th>
                                <th>Salesperson </th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($contactRequests as $contactRequest)
                                <input type="hidden" name="contact_request_id[]" value="{{ $contactRequest->id }}">
                                <tr>
                                    <td> {{ $contactRequest->contact->name }}</td>
                                    <td>
                                        @php
                                            $account = \App\Models\Account::find($contactRequest->account_id);
                                            if ($account) {
                                                echo $account->name;
                                            } else {
                                                echo '';
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $contactRequest->contact->email }}</td>
                                    <td>{{ $contactRequest->contact->phone }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!--end::Scroll-->
        <div class=" pe-7  py-4 px-lg-17 ">
            <label class="fs-3 fw-semibold mb-2">Chọn tài khoản để bàn giao</label>
            <div>
                <select data-dropdown-parent="#AddHandeoversForm" class="form-select" data-control="select2" data-placeholder="Select an option" name="accounts">
                    {{-- <option></option> --}}
                    @foreach ($accounts as $account)
                        <option value="{{ $account->id }}">{{ $account->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="d-flex justify-content-center pb-5">
            <!--begin::Button-->
            <button id="AddHandeoversSubmitButton" type="submit" class="btn btn-primary me-3">
                <span class="indicator-label">Bàn giao</span>
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
            AddHandeovers.init();
        });

        var AddHandeovers = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                var data = $(form).serialize();
                addSubmitEffect();

                $.ajax({
                    url: "{{ action('\App\Http\Controllers\Sales\ContactRequestController@addHandoverBulkSave') }}",
                    method: 'PUT',
                    data: data,

                }).done(function(response) {
                    // hide popup
                    HandoverContactRequestsPopup.getPopup().hide();
                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload listaaaa
                            if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                        }
                    });
                    // HandoverContactRequestsPopup.getPopup().show();
                }).fail(function(response) {
                    HandoverContactRequestsPopup.getPopup().setContent(response.responseText);

                    // 
                    removeSubmitEffect();
                });
            }

            addSubmitEffect = () => {
                // btn effect
                btnSubmit.setAttribute('data-kt-indicator', 'on');
                btnSubmit.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {
                // btn effect
                btnSubmit.removeAttribute('data-kt-indicator');
                btnSubmit.removeAttribute('disabled');
            }

            return {
                init: function() {
                    form = document.getElementById('AddHandeoversForm');
                    btnSubmit = document.getElementById('AddHandeoversSubmitButton');

                    //data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
