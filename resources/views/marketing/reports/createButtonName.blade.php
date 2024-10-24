@extends('layouts.main.popup')

@section('title')
    Nhập tên cho nút báo cáo:
@endsection

@section('content')
    @csrf

    <!--begin::Scroll-->
    <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_contact_scroll">
        <!--begin::Input group-->
        {{-- <input type="text" id="buttonNameInput">
        <button id="saveButtonName">Lưu</button> --}}

        <div class="row">
            <div class="fv-row mb-7">
                <!--begin::Input-->
                <input type="text" class="form-control" id="buttonNameInput" />
                <!--end::Input-->
            </div>
        </div>
        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="saveButtonName" type="submit" class="btn btn-primary">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_contact_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </div>

    <!--end::Scroll-->
@endsection
<script>
    $('#saveButtonName').click(function() {
        buttonName = $('#buttonNameInput').val();

        // Ensure buttonName is not empty
        if (buttonName.trim() === "") {
            alert("Please enter a button name.");
            return;
        }

        addViewNamePopup.setName(buttonName);
        addViewNamePopup.getPopup().hide();
        ASTool.alert({
            message: 'Lưu báo cáo thành công!',
        });
    });
</script>
