<div class="row py-3">
    <div class="col-md-6 fv-row">
        <!--begin::Label-->
        <label class="required fs-6 fw-semibold my-2 py-2">Khóa học</label>
        <!--end::Label-->
        <!--begin::Input-->

        <input type="text" class="form-control" name="course_id" value="{{$section->course->code}}" readonly />
        <!--end::Input-->
        <x-input-error :messages="$errors->get('course_id')" class="mt-3" />

        <label class="required fs-6 fw-semibold my-2 py-2">Chọn buổi học</label>
        <input type="hidden" name="section_id" value="{{$section->id}}">
        <select list-action="section-select" class="form-select form-control" data-placeholder="Chọn học viên"   data-control="select2" name="section_id" required disabled>
            
            <option value="{{$section->id}}" selected>{{ date('d/m/Y', strtotime($section->study_date)) }}</option>
        </select>
       
        <x-input-error :messages="$errors->get('section_id')" class="mt-3" />
            

        <label class="required fs-6 fw-semibold my-2 py-2">Chọn học viên</label>
        <input type="hidden" name="student_id" value="{{$contact->id}}">
        <select list-action="student-select" class="form-select form-control" data-placeholder="Chọn học viên"  data-control="select2" name="student_id" required disabled>
            
            <option value="{{$contact->id}}" selected>{{$contact->name}}</option>
        </select>
        <x-input-error :messages="$errors->get('student_id')" class="mt-3" />

        <label class="required fs-6 fw-semibold my-2 py-2">Nội dung</label>
        <!--end::Label-->
        <!--begin::Input-->
        <textarea id="contentInput" class="form-control @if ($errors->has('content')) is-invalid @endif" placeholder="" name="content">@if (isset($sectionReport->content)){{ $sectionReport->content }}@endif</textarea>
        <!--end::Input-->
        <x-input-error :messages="$errors->get('content')" class="mt-3" />

        <label class="required fs-6 fw-semibold my-2 py-2 ">Nhận xét giáo viên</label>
        <textarea id="teacherComment" class="form-control @if ($errors->has('teacher_comment')) is-invalid @endif" placeholder="" name="teacher_comment">@if (isset($sectionReport->teacher_comment)){{ $sectionReport->teacher_comment }}@endif</textarea>
        <!--end::Input-->
        <x-input-error :messages="$errors->get('teacher_comment')" class="mt-3" />
    </div>
    <div class="col-md-6 fv-row ps-7">

        <label class="required fs-6 fw-semibold pt-3 ">Tính đúng giờ</label>

        <div class="mt-3">
            @php
                $tinh_dung_gio_value = isset($sectionReport->tinh_dung_gio) ? $sectionReport->tinh_dung_gio : 5;
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

        <label class="required fs-6 fw-semibold pt-3 ">Mức độ tập trung</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="mt-3">
            @php
                $muc_do_tap_trung_value = isset($sectionReport->muc_do_tap_trung) ? $sectionReport->muc_do_tap_trung : 5;
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


        <label class="required fs-6 fw-semibold pt-3 ">Mức độ hiểu bài</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="mt-3">
            @php
                $muc_do_hieu_bai_value = isset($sectionReport->muc_do_hieu_bai) ? $sectionReport->muc_do_hieu_bai : 5;
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

        <label class="required fs-6 fw-semibold pt-3 ">Mức độ tương tác</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="mt-3">
            @php
                $muc_do_tuong_tac_value = isset($sectionReport->muc_do_tuong_tac) ? $sectionReport->muc_do_tuong_tac : 5;
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
          <label class="required fs-6 fw-semibold pt-3 ">Tự học và giải quyết vấn đề</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="mt-3">
            @php
                $tu_hoc_va_giai_quyet_van_de_value = isset($sectionReport->tu_hoc_va_giai_quyet_van_de) ? $sectionReport->tu_hoc_va_giai_quyet_van_de : 5;
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

        <label class="required fs-6 fw-semibold pt-3 ">Tự tin trách nhiệm</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="mt-3">
            @php
                $tu_tin_trach_nhiem_value = isset($sectionReport->tu_tin_trach_nhiem) ? $sectionReport->tu_tin_trach_nhiem : 5;
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

        <label class="required fs-6 fw-semibold pt-3 ">Trung thực kỷ luật</label>
        <!--end::Label-->
        <!--begin::Input-->
        <div class="mt-3">
            @php
                $trung_thuc_ky_luat_value = isset($sectionReport->trung_thuc_ky_luat) ? $sectionReport->trung_thuc_ky_luat : 5;
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

        <label class="required fs-6 fw-semibold pt-3 ">Kết quả trên lớp</label>

        <div class="mt-3">
            @php
                $ket_qua_tren_lop_value = isset($sectionReport->ket_qua_tren_lop) ? $sectionReport->ket_qua_tren_lop : 5;
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