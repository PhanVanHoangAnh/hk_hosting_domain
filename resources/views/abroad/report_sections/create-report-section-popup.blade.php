@extends('layouts.main.popup')

@section('title')
    Báo cáo học tập của {{$student->name}} trong khóa {{$course->code}}
@endsection

@php
$formId = 'F' . uniqid();
@endphp

@section('content')
<form method="POST" id="{{ $formId }}" action="{{ action([App\Http\Controllers\Abroad\SectionReportsController::class, 'saveReportSectionPopup'], ['id' => $course->id, 'contact_id' => $student->id]) }}">
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
                <input type="hidden" name="section_id" value="">
                <select list-action="section-select" class="form-select form-control" data-placeholder="Chọn buổi học"   data-control="select2" name="section_id" required >
                    @foreach($sections as $section)
                        
                    <option value="{{$section->id}}" >{{date('d/m/Y', strtotime($section->study_date)) }}</option>
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
                                // this.render();
                            }
                            events() {
                                this.getSectionSelectBox().on('change', (e) => {
                                    // this.render();
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

                            $('input[name="tinh_dung_gio"]').prop('checked', false);
                            $('input[name="muc_do_tap_trung"]').prop('checked', false);
                            $('input[name="muc_do_hieu_bai"]').prop('checked', false);
                            $('input[name="muc_do_tuong_tac"]').prop('checked', false);
                            $('input[name="tu_hoc_va_giai_quyet_van_de"]').prop('checked', false);
                            $('input[name="tu_tin_trach_nhiem"]').prop('checked', false);
                            $('input[name="trung_thuc_ky_luat"]').prop('checked', false);
                            $('input[name="ket_qua_tren_lop"]').prop('checked', false);
                        }

                        $('[list-action="section-select"]').on('change', function () {
                            // var sectionId = $('[list-action="section-select"]').val();
                            var studentId = {{$student->id}};
                            var sectionId = $(this).val();

                            
                            $.ajax({
                                url: '{{ action('\App\Http\Controllers\Abroad\SectionReportsController@getSectionReportData') }}',
                                type: 'GET',
                                data: {
                                    section_id: sectionId,
                                    student_id: studentId
                                },
                            }).done((response) => {
                               
                                $('#contentInput').val(response.content);
                                $('#teacherComment').val(response.content);
                                
                                $('input[name="tinh_dung_gio"][value="' + response.tinh_dung_gio + '"]').prop('checked', true);
                                $('input[name="muc_do_tap_trung"][value="' + response.muc_do_tap_trung + '"]').prop('checked', true);
                                $('input[name="muc_do_hieu_bai"][value="' + response.muc_do_hieu_bai + '"]').prop('checked', true);
                                $('input[name="muc_do_tuong_tac"][value="' + response.muc_do_tuong_tac + '"]').prop('checked', true);
                                $('input[name="tu_hoc_va_giai_quyet_van_de"][value="' + response.tu_hoc_va_giai_quyet_van_de + '"]').prop('checked', true);
                                $('input[name="tu_tin_trach_nhiem"][value="' + response.tu_tin_trach_nhiem + '"]').prop('checked', true);
                                $('input[name="trung_thuc_ky_luat"][value="' + response.trung_thuc_ky_luat + '"]').prop('checked', true);
                                $('input[name="ket_qua_tren_lop"][value="' + response.ket_qua_tren_lop + '"]').prop('checked', true);
                            });
                        });
    
                    </script>
                <label class="required fs-6 fw-semibold my-2 py-2">Chọn học viên</label>
                <input type="hidden" name="student_id" value="{{$student->id}}">
               
                <input type="text" class="form-control" name="" value=" {{$student->name}}" readonly />
                <x-input-error :messages="$errors->get('student_id')" class="mt-3" />
        
                <label class="required fs-6 fw-semibold my-2 py-2">Nội dung</label>
                <!--end::Label-->
                <!--begin::Input-->
                <textarea id="contentInput" class="form-control @if ($errors->has('content')) is-invalid @endif" placeholder="" name="content">@if (isset($sectionReport->content)){{ $sectionReport->content }}@endif</textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('content')" class="mt-3" />
        
                <label class="required fs-6 fw-semibold my-2 py-2 ">Nhận xét giáo viên</label>
                <textarea id="teacherComment" class="form-control @if ($errors->has('teacher_comment')) is-invalid @endif" placeholder="" name="teacher_comment"> @if (isset($sectionReport->teacher_comment)){{ $sectionReport->teacher_comment }}@endif</textarea>
                <!--end::Input-->
                <x-input-error :messages="$errors->get('teacher_comment')" class="mt-3" />
            </div>
            <div class="col-md-6 fv-row ps-7">
        
                <label class="required fs-6 fw-semibold pt-5 ">Tính đúng giờ</label>
        
                <div class="mt-3">
                    @php
                        $tinh_dung_gio_value = isset($sectionReport->tinh_dung_gio) ? $sectionReport->tinh_dung_gio : null;
                    @endphp
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" {{ $tinh_dung_gio_value == 1 ? 'checked' : '' }} name="tinh_dung_gio">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" {{ $tinh_dung_gio_value == 2 ? 'checked' : '' }} name="tinh_dung_gio">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" {{ $tinh_dung_gio_value == 3 ? 'checked' : '' }} name="tinh_dung_gio">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" {{ $tinh_dung_gio_value == 4 ? 'checked' : '' }} name="tinh_dung_gio">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" {{ $tinh_dung_gio_value == 5 ? 'checked' : '' }} name="tinh_dung_gio">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('tinh_dung_gio')" class="mt-3" />
        
                <label class="required fs-6 fw-semibold pt-5 ">Mức độ tập trung</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    @php
                        $muc_do_tap_trung_value = isset($sectionReport->muc_do_tap_trung) ? $sectionReport->muc_do_tap_trung : null;
                    @endphp
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $muc_do_tap_trung_value == 1 ? 'checked' : '' }} value="1" name="muc_do_tap_trung">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $muc_do_tap_trung_value == 2 ? 'checked' : '' }} value="2" name="muc_do_tap_trung">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $muc_do_tap_trung_value == 3 ? 'checked' : '' }} value="3" name="muc_do_tap_trung">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $muc_do_tap_trung_value == 4 ? 'checked' : '' }} value="4" name="muc_do_tap_trung">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $muc_do_tap_trung_value == 5 ? 'checked' : '' }} value="5" name="muc_do_tap_trung">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('muc_do_tap_trung')" class="mt-3" />
        
                <label class="required fs-6 fw-semibold pt-5 ">Mức độ hiểu bài</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    @php
                        $muc_do_hieu_bai_value = isset($sectionReport->muc_do_hieu_bai) ? $sectionReport->muc_do_hieu_bai : null;
                    @endphp
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" {{ $muc_do_hieu_bai_value == 1 ? 'checked' : '' }} name="muc_do_hieu_bai">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" {{ $muc_do_hieu_bai_value == 2 ? 'checked' : '' }} name="muc_do_hieu_bai">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" {{ $muc_do_hieu_bai_value == 3 ? 'checked' : '' }} name="muc_do_hieu_bai">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" {{ $muc_do_hieu_bai_value == 4 ? 'checked' : '' }} name="muc_do_hieu_bai">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" {{ $muc_do_hieu_bai_value == 5 ? 'checked' : '' }} name="muc_do_hieu_bai">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('muc_do_hieu_bai')" class="mt-3" />
        
                <label class="required fs-6 fw-semibold pt-5 ">Mức độ tương tác</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    @php
                        $muc_do_tuong_tac_value = isset($sectionReport->muc_do_tuong_tac) ? $sectionReport->muc_do_tuong_tac : null;
                    @endphp
        
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="muc_do_tuong_tac" {{ $muc_do_tuong_tac_value == 1 ? 'checked' : '' }}>Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="muc_do_tuong_tac" {{ $muc_do_tuong_tac_value == 2 ? 'checked' : '' }}>Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="muc_do_tuong_tac" {{ $muc_do_tuong_tac_value == 3 ? 'checked' : '' }}>Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="muc_do_tuong_tac" {{ $muc_do_tuong_tac_value == 4 ? 'checked' : '' }}>Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="muc_do_tuong_tac" {{ $muc_do_tuong_tac_value == 5 ? 'checked' : '' }}>Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('muc_do_tuong_tac')" class="mt-3" />
                  <label class="required fs-6 fw-semibold pt-5 ">Tự học và giải quyết vấn đề</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    @php
                        $tu_hoc_va_giai_quyet_van_de_value = isset($sectionReport->tu_hoc_va_giai_quyet_van_de) ? $sectionReport->tu_hoc_va_giai_quyet_van_de : null;
                    @endphp
        
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" name="tu_hoc_va_giai_quyet_van_de" {{ $tu_hoc_va_giai_quyet_van_de_value == 1 ? 'checked' : '' }}>Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" name="tu_hoc_va_giai_quyet_van_de" {{ $tu_hoc_va_giai_quyet_van_de_value == 2 ? 'checked' : '' }}>Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" name="tu_hoc_va_giai_quyet_van_de" {{ $tu_hoc_va_giai_quyet_van_de_value == 3 ? 'checked' : '' }}>Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" name="tu_hoc_va_giai_quyet_van_de" {{ $tu_hoc_va_giai_quyet_van_de_value == 4 ? 'checked' : '' }}>Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="5" name="tu_hoc_va_giai_quyet_van_de" {{ $tu_hoc_va_giai_quyet_van_de_value == 5 ? 'checked' : '' }}>Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('tu_hoc_va_giai_quyet_van_de')" class="mt-3" />
        
                <label class="required fs-6 fw-semibold pt-5 ">Tự tin trách nhiệm</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    @php
                        $tu_tin_trach_nhiem_value = isset($sectionReport->tu_tin_trach_nhiem) ? $sectionReport->tu_tin_trach_nhiem : null;
                    @endphp
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="1" {{ $tu_tin_trach_nhiem_value == 1 ? 'checked' : '' }} name="tu_tin_trach_nhiem">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="2" {{ $tu_tin_trach_nhiem_value == 2 ? 'checked' : '' }} name="tu_tin_trach_nhiem">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="3" {{ $tu_tin_trach_nhiem_value == 3 ? 'checked' : '' }} name="tu_tin_trach_nhiem">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" value="4" {{ $tu_tin_trach_nhiem_value == 4 ? 'checked' : '' }} name="tu_tin_trach_nhiem">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label"> 
                            <input type="radio" class="form-check-input me-3" value="5" {{ $tu_tin_trach_nhiem_value == 5 ? 'checked' : '' }} name="tu_tin_trach_nhiem">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('tu_tin_trach_nhiem')" class="mt-3" />
        
                <label class="required fs-6 fw-semibold pt-5 ">Trung thực kỷ luật</label>
                <!--end::Label-->
                <!--begin::Input-->
                <div class="mt-3">
                    @php
                        $trung_thuc_ky_luat_value = isset($sectionReport->trung_thuc_ky_luat) ? $sectionReport->trung_thuc_ky_luat : null;
                    @endphp
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $trung_thuc_ky_luat_value == 1 ? 'checked' : '' }} value="1" name="trung_thuc_ky_luat">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $trung_thuc_ky_luat_value == 2 ? 'checked' : '' }} value="2" name="trung_thuc_ky_luat">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $trung_thuc_ky_luat_value == 3 ? 'checked' : '' }} value="3" name="trung_thuc_ky_luat">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $trung_thuc_ky_luat_value == 4 ? 'checked' : '' }} value="4" name="trung_thuc_ky_luat">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $trung_thuc_ky_luat_value == 5 ? 'checked' : '' }} value="5" name="trung_thuc_ky_luat">Excellent
                        </label>
                    </div>
                </div>
                <x-input-error :messages="$errors->get('trung_thuc_ky_luat')" class="mt-3" />
        
                <label class="required fs-6 fw-semibold pt-5 ">Kết quả trên lớp</label>
        
                <div class="mt-3">
                    @php
                        $ket_qua_tren_lop_value = isset($sectionReport->ket_qua_tren_lop) ? $sectionReport->ket_qua_tren_lop : null;
                    @endphp
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $ket_qua_tren_lop_value == 1 ? 'checked' : '' }} value="1" name="ket_qua_tren_lop">Poor
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $ket_qua_tren_lop_value == 2 ? 'checked' : '' }} value="2" name="ket_qua_tren_lop">Fair
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $ket_qua_tren_lop_value == 3 ? 'checked' : '' }} value="3" name="ket_qua_tren_lop">Good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $ket_qua_tren_lop_value == 4 ? 'checked' : '' }} value="4" name="ket_qua_tren_lop">Very good
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input me-3" {{ $ket_qua_tren_lop_value == 5 ? 'checked' : '' }} value="5" name="ket_qua_tren_lop">Excellent
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
        <button data-action="save-edit-btn"  type="submit" class="btn btn-primary me-2">
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


                UpdateReportsStudentPopup.getPopup().hide();
                ASTool.alert({
                    message: response.message
                    , ok: function() {
                        if (typeof SectionList !== 'undefined') {
                            SectionList.getList().load();
                        }
                        if (typeof ReportsStudentPopup !== 'undefined') {
                            ReportsStudentPopup.getPopup().load();
                        }
                        if (typeof StudentList !== 'undefined') {
                            StudentList.getList().load();
                        }  
                    }
                });

            }).fail(function(response) {
                UpdateReportsStudentPopup.getPopup().setContent(response.responseText);
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
                btnSubmit = document.querySelector('[data-action="save-edit-btn"]');
                handleFormSubmit();
            }
        };
    }();

</script>

@endsection

