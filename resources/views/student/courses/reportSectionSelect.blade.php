@extends('layouts.main.student', [
    'menu' => 'student',
])

@section('sidebar')
    @include('student.modules.sidebar', [
        'menu' => 'courses',
        'sidebar' => 'courses',
        'status' => '',
        'lifecycle_stage_menu' => '',
        'lead_status_menu' => '',
    ])
@endsection
<style>
    element.style {
        height: 100px;
    }
</style>
@section('content')
    <!--begin::Toolbar-->
    @php
        $uniqBarFormId = "bar_form_" . uniqId();
    @endphp
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar" form-index-bar="{{ $uniqBarFormId }}">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Danh sách lớp học</span>
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
                <li class="breadcrumb-item text-muted">Quản lý lớp học</li>
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
    <!--end::Toolbar-->
</div>

    <div id="formIdClass" class="">
        <div class="pe-5">
            <label class="fs-2 text-nowrap fw-bold mb-1">
                <span class="d-flex align-items-center">
                    <span class="material-symbols-rounded fs-1 me-2">
                        school
                    </span>
                    <span>Chọn lớp học muốn xem báo cáo:</span>
                </span>
            </label>
        </div>
        <div class="w-100">
            <input type="hidden" name="contact_id" value="{{$contact->id}}">
            <div class="position-relative abroad-application-search-input">
                
                <select data-action="select-box" class="form-select" data-control="select2"
                    data-kt-select2="true" style="padding-left:20px"  name="type"  >
                    <option value="" disabled selected hidden>Nhấn để chọn lớp học xem báo cáo học tập</option>
                    @foreach($courseStudents as $courseStudent)
                        <option value="{{ $courseStudent->course->id }}" >{{ $courseStudent->course->subject->name }}</option>
                    @endforeach
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
                container: document.querySelector('#formIdClass')
            });

            ReportsStudentPopup.init();
        })

        var ReportsStudentPopup = function() {
                var popupReportsStudent;
                return {
                    init: function(updateUrl) {
                        popupReportsStudent = new Popup({
                            url: updateUrl,

                        });
                    },
                    load: function(url) {
                        popupReportsStudent.url = url;
                        popupReportsStudent.load();
                    },
                    getPopup: function() {
                        return popupReportsStudent;
                    }
                };
            }();

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
                const id =document.querySelector('input[name="contact_id"]').value;
                const course_id = $('[data-action="select-box"] option:selected').val();
                let baseUrl = "{!! action([App\Http\Controllers\Student\SectionReportsController::class, 'reportSectionPopup'], ['id' => 'PLACEHOLDER', 'course_id'=>'COURSE']) !!}";
                const updatedUrl = baseUrl.replace('PLACEHOLDER', id).replace('COURSE',course_id);

                return updatedUrl;
            }

            changeSelect() {
                const url = this.getStudentUrl();
                ReportsStudentPopup.load(url);
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
