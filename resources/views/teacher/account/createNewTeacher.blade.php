@extends('layouts.main.popup')

@section('title')
    Thông tin nhân sự
@endsection

@section('content')
    @php
        $formCreateNewTeacher = "form_create_new_teacher_" . uniqId();
    @endphp

    <form id="{{ $formCreateNewTeacher }}" action="{{ action([App\Http\Controllers\Teacher\AccountController::class, 'setupTeacherSave']) }}" method="POST">
        @csrf
        <input type="hidden" name="teacher_id" value="new">
        <div class="scroll-y px-7 py-10 px-lg-17">
            <div class="mb-4 d-none">
                <label class="required fs-6 fw-semibold mb-3" for="student-name">Email</label>
                <input data-control="email-input" id="email_input" data-action="markup-price" type="text" class="form-control"
                placeholder="Nhập email..." name="email"
                value="{{ Auth::user()->email }}">
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <div class="mb-4">
                <label class="required fs-6 fw-semibold" for="student-name">Tên</label>
                <input data-control="name-input" id="name_input" data-action="markup-price" type="text" class="form-control"
                        placeholder="Nhập tên..." name="name"
                        value="">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                @php
                    $createTeacherPopupId = "create_student_popup_id_" . uniqId();
                @endphp
                <button id="{{ $createTeacherPopupId }}" class="btn btn-primary">
                    <span class="indicator-label">Lưu & Tiếp tục</span>
                    <span class="indicator-progress">Đang xử lý...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                    data-bs-dismiss="modal">Hủy</button>
                <!--end::Button-->
            </div>
        </div>
    </form>

    <script>
        $(() => {
            new CreateNewTeacher({
                form: $('#{{ $formCreateNewTeacher }}')
            })
        })
    </script>
@endsection