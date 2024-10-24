@extends('layouts.main.app', [
    'menu' => 'extracurricular',
])

@section('sidebar')
    @include('abroad.modules.sidebar', [
        'menu' => 'extracurricular-application',
        'sidebar' => 'extracurricular-student',
    ])
@endsection

@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Quản lý học viên</span>
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
                <li class="breadcrumb-item text-muted">Hoạt động ngoại khoá</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Danh sách</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

       
    </div>

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
                    data-url="{{ action([App\Http\Controllers\Abroad\AbroadApplicationController::class, 'select2ForExtracurricular']) }}"
                    class="form-control">
                    <option>
                        {{ '<strong>' . 'Mã hồ sơ: ' . $abroadApplication->code . '</strong><br>' . $abroadApplication->contact->name . '<br>' . $abroadApplication->contact->email }}
                    </option>
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
    <hr>

    <div id="formId">

        <!-- 1. Thông tin học viên -->
        @include('abroad.abroad_applications._studentInfo')

        <!-- 2. Thông tin quản lý chung -->
        @include('abroad.abroad_applications._managementInfo')

        <!-- 3. Thông tin chi tiết dịch vụ-->
        @include('abroad.abroad_applications._serviceInfo')

        <!-- 4. Thành phần hồ sơ-->
        @include('abroad.extracurricular._applicationParts')

      
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
                let baseUrl = "{!! action([App\Http\Controllers\Abroad\ExtracurricularController::class, 'details'], ['id' => 'PLACEHOLDER']) !!}";
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
