@extends('layouts.main.popup')
@section('title')
Nhập dữ liệu đơn hàng
@endsection
@section('content')

<style>
.scrollable-table-excel {
    overflow: scroll;
    max-height: 300px;
}

#dtHorizontalVerticalExample {
    border-collapse: collapse;
}

#dtHorizontalVerticalExample th,
#dtHorizontalVerticalExample td {
    padding: 8px 16px;
    border: 1px solid #ddd;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

#dtHorizontalVerticalExample thead {
    position: sticky;
    inset-block-start: 0;
    background-color: #ddd;
}

#dtHorizontalVerticalExample th {
    text-align: center;
}

#dtHorizontalVerticalExample td {
    text-align: center;
    vertical-align: middle;
}

.table-bordered>:not(caption)>* {
    border-width: 0px;
}
</style>

<div class="stepper stepper-pills" id="kt_stepper_example_basic">
    <!--begin::Nav-->
    <div class="stepper-nav flex-center flex-wrap mt-5">
        <!--begin::Step 1-->
        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav"
        >
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">
                        <i class="bi bi-check-lg fs-3 fw-bold"></i>
                    </span>
                </div>
                <!--end::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-upload fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black">
                        Tải dữ liệu
                    </div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Line-->
            <div class="stepper-line h-40px"></div>
            <!--end::Line-->
        </div>
        <!--end::Step 1-->

        <!--begin::Step 2-->
        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav"
        >
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">
                        <i class="bi bi-check-lg fs-3 fw-bold"></i>
                    </span>
                </div>
                <!--begin::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-graph-down-arrow fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black">
                        Xem trước
                    </div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Line-->
            <div class="stepper-line h-40px"></div>
            <!--end::Line-->
        </div>
        <!--end::Step 2-->

        <!--begin::Step 3-->
        <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px bg-primary">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number text-white">3</span>
                </div>
                <!--begin::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-save fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black">
                        Nhập dữ liệu
                    </div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Line-->
            <div class="stepper-line h-40px"></div>
            <!--end::Line-->
        </div>
        <!--end::Step 3-->

        <!--begin::Step 4-->
        <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">4</span>
                </div>
                <!--begin::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-list-check fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black">
                        Kết quả
                    </div>
                </div>
                <!--end::Label-->
            </div>
            <!--end::Wrapper-->

            <!--begin::Line-->
            <div class="stepper-line h-40px"></div>
            <!--end::Line-->
        </div>
        <!--end::Step 4-->
    </div>
    <!--end::Nav-->
</div>


<div class="form" id="kt_modal_upload_form">
    @csrf
    <!--begin::Modal body-->
    <div class="modal-body pt-10 pb-15 px-lg-17">
        <!--begin::Input group-->
        <div class="form-group">
            <!--begin::Dropzone-->
            <div class="dropzone dropzone-queue mb-2" id="kt_modal_upload_dropzone">
                <div class="mb-10">
                    <label class="form-label">Dữ liệu đang được nhập vào hệ
                        thống... (2300/4900)</label>
                    <div class="progress" style="height: 30px">
                        <div class="progress-bar bg-danger progress-bar-striped" role="progressbar" style="width: 3%"
                            aria-valuenow="15" aria-valuemin="0" aria-valuemax="100">3%</div>
                        <div class="progress-bar bg-success progress-bar-striped" role="progressbar" style="width: 58%"
                            aria-valuenow="30" aria-valuemin="0" aria-valuemax="100">58%</div>
                        <div class="progress-bar bg-secondary" role="progressbar" style="width: 39%" aria-valuenow="30"
                            aria-valuemin="0" aria-valuemax="100">2300/4900</div>
                    </div>
                </div>
                <div class="mb-10">
                    <label for="dtHorizontalVerticalExample" class="form-label">Danh sách đơn hàng từ file dữ
                        liệu</label>
                    <div class="scrollable-table-excel">
                        <table id="dtHorizontalVerticalExample" class="table table-striped table-bordered table-sm "
                            cellspacing="0" width="100%">
                            <thead>
                                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                    <th>Họ</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Địa chỉ</th>
                                    <th>Marketing type</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                <!-- Thêm dữ liệu của bạn vào đây -->
                                <tr list-control="item">
                                    <td data-filter="mastercard">
                                        Phan
                                    </td>
                                    <td data-filter="mastercard">
                                        Hoàng Anh
                                    </td>
                                    <td data-filter="mastercard">
                                        pvhoanganh240@gmail.com
                                    </td>
                                    <td data-filter="mastercard">
                                        0971134626
                                    </td>
                                    <td data-filter="mastercard">
                                        71 đường TCH 07, Quận 12, Tp Hồ Chí Minh
                                    </td>
                                    <td data-filter="mastercard">
                                        Digital
                                    </td>
                                </tr>
                                <tr list-control="item">
                                    <td data-filter="mastercard">
                                        Phan
                                    </td>
                                    <td data-filter="mastercard">
                                        Hoàng Anh
                                    </td>
                                    <td data-filter="mastercard">
                                        pvhoanganh240@gmail.com
                                    </td>
                                    <td data-filter="mastercard">
                                        0971134626
                                    </td>
                                    <td data-filter="mastercard">
                                        71 đường TCH 07, Quận 12, Tp Hồ Chí Minh
                                    </td>
                                    <td data-filter="mastercard">
                                        Digital
                                    </td>
                                </tr>
                                <tr list-control="item">
                                    <td data-filter="mastercard">
                                        Phan
                                    </td>
                                    <td data-filter="mastercard">
                                        Hoàng Anh
                                    </td>
                                    <td data-filter="mastercard">
                                        pvhoanganh240@gmail.com
                                    </td>
                                    <td data-filter="mastercard">
                                        0971134626
                                    </td>
                                    <td data-filter="mastercard">
                                        71 đường TCH 07, Quận 12, Tp Hồ Chí Minh
                                    </td>
                                    <td data-filter="mastercard">
                                        Digital
                                    </td>
                                <tr list-control="item">
                                    <td data-filter="mastercard">
                                        Phan
                                    </td>
                                    <td data-filter="mastercard">
                                        Hoàng Anh
                                    </td>
                                    <td data-filter="mastercard">
                                        pvhoanganh240@gmail.com
                                    </td>
                                    <td data-filter="mastercard">
                                        0971134626
                                    </td>
                                    <td data-filter="mastercard">
                                        71 đường TCH 07, Quận 12, Tp Hồ Chí Minh
                                    </td>
                                    <td data-filter="mastercard">
                                        Digital
                                    </td>
                                </tr>
                                <tr list-control="item">
                                    <td data-filter="mastercard">
                                        Phan
                                    </td>
                                    <td data-filter="mastercard">
                                        Hoàng Anh
                                    </td>
                                    <td data-filter="mastercard">
                                        pvhoanganh240@gmail.com
                                    </td>
                                    <td data-filter="mastercard">
                                        0971134626
                                    </td>
                                    <td data-filter="mastercard">
                                        71 đường TCH 07, Quận 12, Tp Hồ Chí Minh
                                    </td>
                                    <td data-filter="mastercard">
                                        Digital
                                    </td>
                                </tr>
                                <tr list-control="item">
                                    <td data-filter="mastercard">
                                        Phan
                                    </td>
                                    <td data-filter="mastercard">
                                        Hoàng Anh
                                    </td>
                                    <td data-filter="mastercard">
                                        pvhoanganh240@gmail.com
                                    </td>
                                    <td data-filter="mastercard">
                                        0971134626
                                    </td>
                                    <td data-filter="mastercard">
                                        71 đường TCH 07, Quận 12, Tp Hồ Chí Minh
                                    </td>
                                    <td data-filter="mastercard">
                                        Digital
                                    </td>
                                </tr>
                                <tr list-control="item">
                                    <td data-filter="mastercard">
                                        Phan
                                    </td>
                                    <td data-filter="mastercard">
                                        Hoàng Anh
                                    </td>
                                    <td data-filter="mastercard">
                                        pvhoanganh240@gmail.com
                                    </td>
                                    <td data-filter="mastercard">
                                        0971134626
                                    </td>
                                    <td data-filter="mastercard">
                                        71 đường TCH 07, Quận 12, Tp Hồ Chí Minh
                                    </td>
                                    <td data-filter="mastercard">
                                        Digital
                                    </td>
                                </tr>
                                <tr list-control="item">
                                    <td data-filter="mastercard">
                                        Phan
                                    </td>
                                    <td data-filter="mastercard">
                                        Hoàng Anh
                                    </td>
                                    <td data-filter="mastercard">
                                        pvhoanganh240@gmail.com
                                    </td>
                                    <td data-filter="mastercard">
                                        0971134626
                                    </td>
                                    <td data-filter="mastercard">
                                        71 đường TCH 07, Quận 12, Tp Hồ Chí Minh
                                    </td>
                                    <td data-filter="mastercard">
                                        Digital
                                    </td>
                                </tr>
                                <tr list-control="item">
                                    <td data-filter="mastercard">
                                        Phan
                                    </td>
                                    <td data-filter="mastercard">
                                        Hoàng Anh
                                    </td>
                                    <td data-filter="mastercard">
                                        pvhoanganh240@gmail.com
                                    </td>
                                    <td data-filter="mastercard">
                                        0971134626
                                    </td>
                                    <td data-filter="mastercard">
                                        71 đường TCH 07, Quận 12, Tp Hồ Chí Minh
                                    </td>
                                    <td data-filter="mastercard">
                                        Digital
                                    </td>
                                </tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div>
                    <button id="denyProgressBtn" class="btn btn-primary">Hủy</button>
                </div>
                <div>
                    <button id="testResult" class="btn btn-light mt-5">Test kết quả</button>
                </div>
            </div>
            <!--end::Dropzone-->
        </div>
        <!--end::Input group-->
    </div>
    <!--end::Modal body-->
</div>

<script>
$(() => {
    formEvents.init();
})

var formEvents = function() {
    let csrfToken;

    return {
        init: () => {
            csrfToken = document.querySelector('input[name="_token"]').value;
            document.querySelector('#testResult').addEventListener('click', e => {
                e.preventDefault();

                ExcelPopup.updateUrl(
                    "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@testImportDone') }}",
                    'POST', csrfToken);

            });

            document.querySelector("#denyProgressBtn").addEventListener('click', e => {
                e.preventDefault();

                ExcelPopup.getPopup().hide();
            });
        }
    }
}();
</script>

@endsection