@extends('layouts.main.app', [
    'menu' => 'system',
])

@section('sidebar')
    @include('system.modules.sidebar', [
        'menu' => 'backup',
        'sidebar' => 'backup',
        'type' => '',
    ])
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Cấu hình sao lưu & Phục hồi</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="../../demo5/dist/index.html" class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Sao lưu & Phục hồi</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="position-relative" id="kt_post">

        <form action="{{ action([App\Http\Controllers\System\BackupController::class, 'save']) }}" method="POST">
            @csrf
            <!--begin::Scroll-->
            <div class="">

                <div class="row">
                    <!--begin::Col-->
                    <div class="col-md-6">
                        <!--begin::Alert-->
                        <div class="alert alert-info d-flex align-items-center p-5">
                            <!--begin::Icon-->
                            <i class="ki-duotone ki-shield-tick fs-2hx text-info me-4"><span class="path1"></span><span class="path2"></span></i>
                            <!--end::Icon-->

                            <!--begin::Wrapper-->
                            <div class="d-flex flex-column">
                                <!--begin::Title-->
                                <h4 class="mb-1 text-dark">Lưu ý</h4>
                                <!--end::Title-->

                                <!--begin::Content-->
                                <span>Nếu chưa rõ cấu hình bên dưới, vui lòng lên hệ với nhân viên hỗ trợ kỹ thuật phần mềm để được hướng dẫn tư vấn cho cấu hình này.</span>
                                <!--end::Content-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Alert-->

                        <div class="mb-5">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Thời gian backup về local server</label>
                            <!--end::Label-->

                            

                            <!--begin::Input-->
                            <select class="form-select filter-select" data-control="select2" data-close-on-select="false"
                                data-placeholder="Chọn thời điểm backup" data-allow-clear="true" multiple="multiple"
                                name="backup_server_times[]">
                                @foreach (App\Models\Setting::getTimeOptions() as $time)
                                    <option
                                        {{ in_array($time, App\Models\Setting::get('backup.server.times')) ? 'selected' : '' }}
                                        value="{{ $time }}">
                                        {{ $time }}
                                    </option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                            <x-input-error :messages="$errors->get('backup_server_times')" class="mt-2" />
                        </div>

                        <div class="mb-5">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Thời gian upload trên cloud</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <select class="form-select filter-select" data-control="select2" data-close-on-select="false"
                                data-placeholder="Chọn thời điểm backup" data-allow-clear="true" multiple="multiple"
                                name="backup_cloud_times[]">
                                @foreach (App\Models\Setting::getTimeOptions() as $time)
                                    <option
                                        {{ in_array($time, App\Models\Setting::get('backup.cloud.times')) ? 'selected' : '' }}
                                        value="{{ $time }}">
                                        {{ $time }}
                                    </option>
                                @endforeach
                            </select>
                            <!--end::Input-->
                            <x-input-error :messages="$errors->get('backup_cloud_times')" class="mt-2" />
                        </div>

                        <div class="mb-5">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold mb-2">Cloud Backup Key</label>
                            <!--end::Label-->

                            <!--begin::Input-->
                            <input type="password" class="form-control disabled" disabled value="base64:IeYDZiWzUFbwXcLF9qBB+BXCFKvLDE1WGM/WQWlwm8Q=" />
                            <!--end::Input-->
                            <x-input-error :messages="$errors->get('backup_server_times')" class="mt-2" />
                        </div>

                        <div class="modal-footer flex-center mt-10">
                            <!--begin::Button-->
                            <button id="UpdateAccountSubmitButton" type="submit" class="btn btn-primary me-4">
                                <span class="indicator-label">Lưu</span>
                                <span class="indicator-progress">Đang xử lý...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <!--end::Button-->
                        </div>
                    </div>
                    <!--end::Col-->
                </div>
                <!--end::Scroll-->


            </div>
        </form>
    </div>
    <!--end::Post-->
@endsection
