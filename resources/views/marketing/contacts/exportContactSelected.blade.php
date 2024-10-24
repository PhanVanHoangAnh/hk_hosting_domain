@extends('layouts.main.popup')

@section('title')
    Xuất liên hệ đã chọn
@endsection

@section('content')
    <form id="formExport" action="{{ action('App\Http\Controllers\Marketing\ContactController@exportContactSelectedRun') }}"
        method="POST" enctype="multipart/form-data">
        @csrf
        <div class="scroll-y pe-7  px-lg-17 py-5 d-flex flex-stack flex-wrap ">
            <label class="fs-2 fw-bold fw-semibold ">Danh sách liên hệ</label>
            <label class="fs-4  fw-semibold ">Tổng cộng: <strong>{{$contacts->count()}}</strong></label>
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
                                <th>Tên liên hệ</th>
                                <th>Salesperson </th>
                                <th>Email</th>
                                <th>Điện thoại</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($contacts as $contact)
                                <input type="hidden" name="contact_id[]" value="{{ $contact->id }}">
                                <tr>
                                    <td> {{ $contact->name }}</td>
                                    <td>
                                        @php
                                            $account = \App\Models\Account::find($contact->account_id);
                                            if ($account) {
                                                echo $account->name;
                                            } else {
                                                echo '';
                                            }
                                        @endphp
                                    </td>
                                    <td>{{ $contact->email }}</td>
                                    <td>{{ $contact->displayPhoneNumberByUser(Auth::user()) }}</td>
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
            <button id="exportSelectContactButton" type="submit" class="btn btn-primary me-2">
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
        var contactsData = @json($contacts);
        var contactIdsData = @json($contact_ids);
        var contactIds = contactIdsData;

        document.getElementById('exportSelectContactButton').addEventListener('click', function(event) {
            event.preventDefault();
            var form = document.getElementById('formExport');
            var formData = new FormData(form);

            // lấy contact_ids
            contactIds.forEach(function(contactId) {
                formData.append('contact_ids[]', contactId);
            });

            $.ajax({
                url: form.action,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
            }).done(function(response) {
                window.location =
                    "{{ action('App\Http\Controllers\Marketing\ContactController@exportContactSelectedDownload') }}?file=" + response.file;
            }).fail(function(response) {
                throw new Error('fail.');
            });
        });
    </script>
@endsection
