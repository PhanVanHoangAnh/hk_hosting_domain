@extends('layouts.main.popup')

@section('title')
    Tạo thông tin học viên
@endsection

@section('content')
    @php
        $formCreateNewContact = "form_create_new_contact_" . uniqId();
    @endphp

    

    <form id="{{ $formCreateNewContact }}" action="{{ action([App\Http\Controllers\Student\AccountController::class, 'setupStudentSave']) }}" method="POST">
        @csrf
        <input type="hidden" name="contact_id" value="new">
        <div class="scroll-y px-7 py-10 px-lg-17">
            <p class="mb-2">Xin chào <strong>{{ Auth::user()->name }}</strong>,</p>
    <p>Tài khoản của bạn chưa có thông tin học viên tương ứng. Vui lòng xác nhận thông tin bên dưới để tạo tài khoản học viên tương ứng.</p>

            <div class="mb-4 d-none">
                <label class="required fs-6 fw-semibold mb-3" for="student-name">Email</label>
                <input data-control="email-input" id="email_input" data-action="markup-price" type="text" class="form-control" readonly
                    name="email"
                    value="{{ Auth::user()->email }}">
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>

            <div class="mb-4">
                <label class="required fs-6 fw-semibold form-label" for="student-name">Tên học viên</label>
                <input data-control="name-input" id="name_input" data-action="markup-price" type="text" class="form-control"
                        placeholder="Nhập tên học viên..." readonly name="name"
                        value="{{ Auth::user()->name }}">
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                @php
                    $createStudentPopupId = "create_student_popup_id_" . uniqId();
                @endphp
                <button id="{{ $createStudentPopupId }}" class="btn btn-primary">
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
            new CreateNewContact({
                form: $('#{{ $formCreateNewContact }}')
            })
        })
    </script>
@endsection