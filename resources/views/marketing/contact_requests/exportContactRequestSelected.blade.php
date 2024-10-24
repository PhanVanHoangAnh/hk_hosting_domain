@extends('layouts.main.popup')

@section('title')
    Xuất đơn hàng đã chọn
@endsection

@section('content')
    <form id="formExport" action="{{ action('App\Http\Controllers\Marketing\ContactRequestController@exportContactRequestSelectedRun') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="scroll-y pe-7  px-lg-17 py-5 d-flex flex-stack flex-wrap ">
            <label class="fs-2 fw-bold fw-semibold ">Danh sách đơn hàng</label>
            <label class="fs-4  fw-semibold ">Tổng cộng: <strong>{{$contactRequests->count()}}</strong></label>
        </div>
        <!--begin::Scroll-->
        <div class="scroll-y pe-7   px-lg-17" id="kt_modal_add_contact_scroll" data-kt-scroll="true"
            data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto"
            data-kt-scroll-dependencies="#kt_modal_add_contact_header"
            data-kt-scroll-wrappers="#kt_modal_add_contact_scroll" data-kt-scroll-offset="300px">
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
                                    <td>{{ $contactRequest->contact->displayPhoneNumberByUser(Auth::user()) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
        <!--end::Scroll-->

        <div class="d-flex justify-content-center pb-5 py-7">
            <!--begin::Button-->
            <button id="exportSelectContactRequestButton" type="submit" class="btn btn-primary me-2">
                <span class="indicator-label">Xuất dữ liệu</span>
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
        var contactsData = @json($contactRequests);
        var contactRequestIdsData = @json($contact_request_ids);

        var contactRequestIds = contactRequestIdsData;

        document.getElementById('exportSelectContactRequestButton').addEventListener('click', function(event) {
            event.preventDefault();
            var form = document.getElementById('formExport');
            var formData = new FormData(form);

            // lấy contact_request_ids
            contactRequestIds.forEach(function(contactRequestId) {
                formData.append('contact_request_ids[]', contactRequestId);
            });

            $.ajax({
                url: form.action,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
            }).done(function(response) {
                window.location =
                    "{{ action('App\Http\Controllers\Marketing\ContactRequestController@exportContactRequestSelectedDownload') }}?file=" + response.file;
            }).fail(function(response) {
                throw new Error('fail.');
            });
        });
    </script>
@endsection
