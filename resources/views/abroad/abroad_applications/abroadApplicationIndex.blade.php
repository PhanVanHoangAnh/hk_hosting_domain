@extends('layouts.main.app', [
    'menu' => 'abroad',
])

@section('sidebar')
    @include('abroad.modules.sidebar', [
        'menu' => 'abroad-student',
        'sidebar' => 'abroad-application',
        'status' => '',
    ])
@endsection
<style>
    element.style {
        height: 100px;
    }
</style>
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Quản lý học viên/Hồ sơ du học</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Du học</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Quản lý học viên</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

    </div>
    <!--end::Toolbar-->

    <div id="formId" class="">
        <div class="pe-5">
            <label class="fs-2 text-nowrap fw-bold mb-1">
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded fs-1 me-2">
                        badge
                    </span>
                    <span>Chọn học viên/hồ sơ:</span>
                </span>
            </label>
        </div>
        <div class="w-100">
            <div class="position-relative abroad-application-search-input">
                <select data-action="select-box" data-control="select2-ajax"
                    data-url="{{ action([App\Http\Controllers\Abroad\AbroadApplicationController::class, 'select2ForAbroad']) }}"
                    class="form-control" style="padding-left:20px" placeholder="Nhấn để chọn Hồ sơ/ học viên">
                    <option value="" disabled selected hidden>Nhấn để chọn Hồ sơ/ học viên</option>
                </select>
                <div style="
                position: absolute;
                left: 10px;
                top: 5px;">
                    <span class="material-symbols-rounded" style="font-size: 33px;">
                        manage_search
                    </span>
                </div>
            </div>
        </div>
    </div>


    <script>
        var applicationSelector;

        $(() => {
            applicationSelector = new ApplicationSelector({
                container: document.querySelector('#formId')
            });
        })

        var ApplicationSelector = class {
            constructor(options) {
                this.container = options.container;

                this.init();
            }

            getContainer() {
                return this.container;
            }

            getSelectBox() {
                return this.getContainer().querySelector('[data-action="select-box"]');
            }

            init() {
                this.events();
            }

            getStudentUrl() {
                const id = $('[data-action="select-box"] option:selected').val();
                let baseUrl = "{!! action([App\Http\Controllers\Abroad\AbroadApplicationController::class, 'details'], ['id' => 'PLACEHOLDER']) !!}";
                const updatedUrl = baseUrl.replace('PLACEHOLDER', id);

                return updatedUrl;
            }

            changeSelect() {
                const url = this.getStudentUrl();

                window.location.href = url;
            }

            events() {
                const _this = this;

                $(_this.getSelectBox()).on('change', function(e) {
                    e.preventDefault();

                    _this.changeSelect();
                })
            }
        }
    </script>
@endsection
