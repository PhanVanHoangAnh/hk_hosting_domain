@extends('layouts.main.popup')

@section('title')
    Bàn giao nhân viên sale
@endsection

@section('content')
    <form id="HandoverContactRequestForm">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_contact_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_modal_add_contact_header"
            data-kt-scroll-wrappers="#kt_modal_add_contact_scroll" data-kt-scroll-offset="300px">
            <!--begin::Input group-->
            <input type="hidden" name="contact_request_id" value="{{ $contactRequest->id }}" />
            <div class="fv-row ">
                <label class="fs-6 fw-semibold mb-2 ">Đơn hàng được bàn giao </label>
                <div class="table-responsive">
                    <table class="table  table-bordered">
                        <thead>
                            <tr class="fw-bold fs-6 text-gray-800">
                                <th>Tên đơn hàng</th>
                                <th>Salesperson</th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                            </tr>
                        </thead>
                        <tbody>
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
                                <td>{{ $contactRequest->contact->displayPhoneNumberByUser(Auth::user()) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <label class="fs-6 fw-semibold mb-2 mt-10">Chọn tài khoản để bàn giao</label>
                <div>
                    <select data-dropdown-parent="#HandoverContactRequestForm" class="form-select" data-control="select2" data-placeholder="Select an option" name="accounts">
                        {{-- <option></option> --}}
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <!--end::Scroll-->

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="HandoverContactRequestSubmitButton" type="submit" class="btn btn-primary">
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
            ContactRequestsHandover.init();
        });

        var ContactRequestsHandover = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    submit();
                });
            }

            submit = () => {
                var contactRequestIdInput = form.querySelector('input[name="contact_request_id"]');
                var contactRequestId = contactRequestIdInput.value;
                var data = $(form).serialize();

                addSubmitEffect();

                $.ajax({
                    url: '/marketing/contact_requests/handover/' + contactRequestId,
                    method: 'PUT',
                    data: data,
                }).done(function(response) {
                    // hide popup
                    HandoverContactRequestPopup.getPopup().hide();
                    removeSubmitEffect();

                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            if (typeof ContactRequestsList != 'undefined') ContactRequestsList.getList().load();
                        }
                    });
                    // HandoverContactRequestPopup.getPopup().show();

                    // reload sidebar
                    aSidebar.reloadCounters();
                }).fail(function(response) {
                    HandoverContactRequestPopup.getPopup().setContent(response.responseText);

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
                    form = document.getElementById('HandoverContactRequestForm');
                    btnSubmit = document.getElementById('HandoverContactRequestSubmitButton');
                    
                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
