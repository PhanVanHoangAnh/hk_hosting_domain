@extends('layouts.main.popup')

@section('title')
Báo cáo học tập
@endsection

@php
$formId = 'F' . uniqid();
@endphp

@section('content')
<form method="POST" id="{{ $formId }}" action="{{ action([App\Http\Controllers\Abroad\SectionReportsController::class, 'saveReportSectionInCourse'], ['id' => $course->id]) }}">
    @csrf
    <!--begin::Scroll-->
    <div class="pe-7 py-5   px-lg-17">
        <div class="row py-3">
            <div class="col-md-6 fv-row">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold my-2 py-2">Khóa học</label>
                <!--end::Label-->
                <!--begin::Input-->

                <input type="text" class="form-control" name="course_id" value="{{$course->code}}" readonly />
                <!--end::Input-->
                <x-input-error :messages="$errors->get('course_id')" class="mt-3" />

                <label class="required fs-6 fw-semibold my-2 py-2">Chọn buổi học</label>
                <select list-action="section-select" class="form-select " name="section_id" data-control="select2" data-kt-customer-table-filter="month" data-placeholder="Chọn buổi học" data-allow-clear="true">
                    @foreach ($sections as $section)
                    <option value="{{ $section->id }}">{{ date('d/m/Y', strtotime($section->study_date)) }}</option>

                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('section_id')" class="mt-3" />
                    <script>
                        $(() => {
                            new SectionBox({
                                box: $('[list-action="student-select"]'), 
                                url: '{{ action('\App\Http\Controllers\Abroad\SectionReportsController@getStudents') }}', getSectionSelectBox: function() {
                                    return $('[list-action="section-select"]');
                                }
                            , });
                        });
    
                        var SectionBox = class {
                            constructor(options) {
                                this.box = options.box;
                                this.url = options.url;
                                this.getSectionSelectBox = options.getSectionSelectBox;
                                this.events();
                                this.render();
                            }
                            events() {
                                this.getSectionSelectBox().on('change', (e) => {
                                    this.render();
                                    removeData()
                                });
    
                                if (!this.getSectionSelectBox().val()) {
                                    this.box.html('');
                                    return;
                                }
                            }
    
                            render() {
                                $.ajax({
                                    url: this.url
                                    , type: 'GET'
                                    , data: {
                                        section_id: this.getSectionSelectBox().val()
                                    , }
                                , }).done((response) => {
    
                                    this.box.html('<option value="">Chọn học viên</option>');
    
                                    response.forEach(student => {
                                        const option = `<option value="${student.id}">${student.name}</option>`;
                                        this.box.append(option);
                                    });
                                });
                            }
                        };
                        function removeData() {
                            $('#contentInput').val('');
                            $('#teacherComment').val('');

                            $('input[name="tinh_dung_gio"][value="5"]').prop('checked', false);
                            $('input[name="muc_do_tap_trung"][value="5"]').prop('checked', false);
                            $('input[name="muc_do_hieu_bai"][value="5"]').prop('checked', false);
                            $('input[name="muc_do_tuong_tac"][value="5"]').prop('checked', false);
                            $('input[name="tu_hoc_va_giai_quyet_van_de"][value="5"]').prop('checked', false);
                            $('input[name="tu_tin_trach_nhiem"][value="5"]').prop('checked', false);
                            $('input[name="trung_thuc_ky_luat"][value="5"]').prop('checked', false);
                            $('input[name="ket_qua_tren_lop"][value="5"]').prop('checked', false);
                        }

                        $('[list-action="student-select"]').on('change', function () {
                            var sectionId = $('[list-action="section-select"]').val();
                            var studentId = $(this).val();
                         
                            
                            $.ajax({
                                url: '{{ action('\App\Http\Controllers\Abroad\SectionReportsController@getSectionReportData') }}',
                                type: 'GET',
                                data: {
                                    section_id: sectionId,
                                    student_id: studentId
                                },
                            }).done((response) => {
                               
                                if ($.isEmptyObject(response)) {
                                    // Set default values for radio buttons
                                    $('input[name="tinh_dung_gio"][value="5"]').prop('checked', true);
                                    $('input[name="muc_do_tap_trung"][value="5"]').prop('checked', true);
                                    $('input[name="muc_do_hieu_bai"][value="5"]').prop('checked', true);
                                    $('input[name="muc_do_tuong_tac"][value="5"]').prop('checked', true);
                                    $('input[name="tu_hoc_va_giai_quyet_van_de"][value="5"]').prop('checked', true);
                                    $('input[name="tu_tin_trach_nhiem"][value="5"]').prop('checked', true);
                                    $('input[name="trung_thuc_ky_luat"][value="5"]').prop('checked', true);
                                    $('input[name="ket_qua_tren_lop"][value="5"]').prop('checked', true);
                                } else {
                                    $('#contentInput').val(response.content);
                                    $('#teacherComment').val(response.teacher_comment);

                                    $('input[name="tinh_dung_gio"][value="' + response.tinh_dung_gio + '"]').prop('checked', true);
                                    $('input[name="muc_do_tap_trung"][value="' + response.muc_do_tap_trung + '"]').prop('checked', true);
                                    $('input[name="muc_do_hieu_bai"][value="' + response.muc_do_hieu_bai + '"]').prop('checked', true);
                                    $('input[name="muc_do_tuong_tac"][value="' + response.muc_do_tuong_tac + '"]').prop('checked', true);
                                    $('input[name="tu_hoc_va_giai_quyet_van_de"][value="' + response.tu_hoc_va_giai_quyet_van_de + '"]').prop('checked', true);
                                    $('input[name="tu_tin_trach_nhiem"][value="' + response.tu_tin_trach_nhiem + '"]').prop('checked', true);
                                    $('input[name="trung_thuc_ky_luat"][value="' + response.trung_thuc_ky_luat + '"]').prop('checked', true);
                                    $('input[name="ket_qua_tren_lop"][value="' + response.ket_qua_tren_lop + '"]').prop('checked', true);
                                }
                            });
                        });
    
                    </script>

                <label class="required fs-6 fw-semibold my-2 py-2">Chọn học viên</label>

                <select list-action="student-select" class="form-select form-control" data-placeholder="Chọn học viên" data-allow-clear="true" data-control="select2" name="student_id" required>
                    <option value="">Chọn học viên </option>

                </select>
                <x-input-error :messages="$errors->get('student_id')" class="mt-3" />

                    

                <label class="fs-6 fw-semibold my-2 py-2">Nội dung</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea id="contentInput" class="form-control @if ($errors->has('content')) is-invalid @endif" placeholder="" name="content"></textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('content')" class="mt-3" />

                <label class="fs-6 fw-semibold my-2 py-2 ">Nhận xét giáo viên</label>
                <textarea id="teacherComment" class="form-control @if ($errors->has('teacher_comment')) is-invalid @endif" placeholder="" name="teacher_comment"></textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('teacher_comment')" class="mt-3" />
            </div>
            <div class="col-md-6 fv-row ps-7">

                <label class="required fs-6 fw-semibold pt-5 ">Tính đúng giờ</label>

                <div class="mt-3">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="tinh_dung_gio">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="tinh_dung_gio">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="tinh_dung_gio">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="tinh_dung_gio">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="tinh_dung_gio">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('tinh_dung_gio')" class="mt-3" />

                <label class="required fs-6 fw-semibold pt-5 ">Mức độ tập trung</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="muc_do_tap_trung">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="muc_do_tap_trung">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="muc_do_tap_trung">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="muc_do_tap_trung">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="muc_do_tap_trung">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('muc_do_tap_trung')" class="mt-3" />

                <label class="required fs-6 fw-semibold pt-5 ">Mức độ hiểu bài</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="muc_do_hieu_bai">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="muc_do_hieu_bai">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="muc_do_hieu_bai">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="muc_do_hieu_bai">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="muc_do_hieu_bai">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('muc_do_hieu_bai')" class="mt-3" />

                <label class="required fs-6 fw-semibold pt-5 ">Mức độ tương tác</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="muc_do_tuong_tac">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="muc_do_tuong_tac">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="muc_do_tuong_tac">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="muc_do_tuong_tac">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="muc_do_tuong_tac">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('muc_do_tuong_tac')" class="mt-3" />
                  <label class="required fs-6 fw-semibold pt-5 ">Tự học và giải quyết vấn đề</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="tu_hoc_va_giai_quyet_van_de">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="tu_hoc_va_giai_quyet_van_de">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="tu_hoc_va_giai_quyet_van_de">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="tu_hoc_va_giai_quyet_van_de">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="tu_hoc_va_giai_quyet_van_de">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('tu_hoc_va_giai_quyet_van_de')" class="mt-3" />
    
                <label class="required fs-6 fw-semibold pt-5 ">Tự tin trách nhiệm</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="tu_tin_trach_nhiem">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="tu_tin_trach_nhiem">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="tu_tin_trach_nhiem">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="tu_tin_trach_nhiem">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="tu_tin_trach_nhiem">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('tu_tin_trach_nhiem')" class="mt-3" />
    
                <label class="required fs-6 fw-semibold pt-5 ">Trung thực kỷ luật</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="trung_thuc_ky_luat">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="trung_thuc_ky_luat">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="trung_thuc_ky_luat">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="trung_thuc_ky_luat">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="trung_thuc_ky_luat">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('trung_thuc_ky_luat')" class="mt-3" />
    
                <label class="required fs-6 fw-semibold pt-5 ">Kết quả trên lớp</label>
    
                <div class="mt-3">
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="ket_qua_tren_lop">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="ket_qua_tren_lop">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="ket_qua_tren_lop">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="ket_qua_tren_lop">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="ket_qua_tren_lop">Excellent
                        </label>
                    </div>
                </div>
    
                <!--end::Input-->
                <x-input-error :messages="$errors->get('ket_qua_tren_lop')" class="mt-3" />
            </div>
            

        </div>


  


    </div>


    <!--end::Scroll-->
    <div class="d-flex justify-content-center pb-5 py-7">
        <!--begin::Button-->
        <button data-action="save-edit-btn" id="CreateAccountGroupSubmitButton" type="submit" class="btn btn-primary me-2">
            <span class="indicator-label">Lưu</span>
            <span class="indicator-progress">Đang xử lý...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
            </span>
        </button>
        <!--end::Button-->
        <!--begin::Button-->
        <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Hủy</button>
        <!--end::Button-->
    </div>
</form>

<script>
    $(function() {
        
        ReportSection.init();
        
    });

    var ReportSection = function() {
        var form;
        var btnSubmit;

        var handleFormSubmit = () => {
            form.addEventListener('submit', (e) => {
                e.preventDefault();
                submit();
            });
        };

        var submit = () => {
            var data = $(form).serialize();
            var url = form.getAttribute('action');
            addSubmitEffect();

            $.ajax({
                url: url
                , method: 'POST'
                , data: data
            , }).done(function(response) {


              ShowOrderPopup.getPopup().hide();
                ASTool.alert({
                    message: response.message
                    , ok: function() {
                        CoursesList.getList().load();
                    }
                });

            }).fail(function(response) {
                ShowOrderPopup.getPopup().setContent(response.responseText);
                removeSubmitEffect();

            });
        };

        var addSubmitEffect = () => {
            // btn effect
            btnSubmit.setAttribute('data-kt-indicator', 'on');
            btnSubmit.setAttribute('disabled', true);
        };

        var removeSubmitEffect = () => {
            // btn effect
            btnSubmit.removeAttribute('data-kt-indicator');
            btnSubmit.removeAttribute('disabled');
        };

        return {
            init: function() {
                form = document.getElementById('{{ $formId }}');
                btnSubmit = document.getElementById('CreateAccountGroupSubmitButton');
                handleFormSubmit();
            }
        };
    }();

</script>

@endsection

