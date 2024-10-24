@extends('layouts.main.popup')
@section('title')
    Nhập dữ liệu đơn hàng từ HubSpot
@endsection
@section('content')
    <form class="form">
        @csrf

        <!--begin::Modal body-->
        <div class="modal-body">
            <!--begin::Input group-->
            <div class="form-group">
                <!--begin::Dropzone-->
                <div class="dropzone dropzone-queue">
                    <label class="form-label d-flex">Dữ liệu đang được nhập vào hệ thống</label>
                    <div class="d-inline-block w-100">
                        @include('marketing.contact_requests.progressHandler', [
                            'newContactRequestsCount' => $newContactRequestsCount,
                            'updatedContactRequestsCount' => $updatedContactRequestsCount,
                            'errorsCount' => $errorsCount,
                        ])
                    </div>
                    <!--end::Error message-->

                    <!--end::Items-->
                </div>
                <!--end::Dropzone-->

            </div>
            <!--end::Input group-->
        </div>
        <!--end::Modal body-->
    </form>
@endsection
