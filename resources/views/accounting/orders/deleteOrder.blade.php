@extends('layouts.main.popup')

@section('title')
    Xóa hợp đồng
@endsection

@section('content')

<form id="pick-contact-form">
    @csrf
    <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2 fs-2 text-center">
                Bạn có chắc chắn muốn xóa hợp đồng này không ?
            </div>
        </div>
    </div>

    <div class="modal-footer flex-center">
        <!--begin::Button-->
        <button id="deleteConstractButton" type="submit" class="btn btn-primary">
            <span class="indicator-label">Xóa</span>
            <span class="indicator-progress">Đang xử lý...
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
        </button>
        <!--end::Button-->
        <!--begin::Button-->
        <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3" data-bs-dismiss="modal">Hủy</button>
        <!--end::Button-->
    </div>
</form>

<script>
    $(() => {
        deleteOrderIndex.init();
    })


    var deleteOrderIndex = function() {
        let deleteOrderBtn;

        return {
            init: () => {
                deleteOrderBtn = document.querySelector("#deleteConstractButton");

                deleteOrderBtn.addEventListener('click', e => {
                    e.preventDefault();

                    let data = {
                        _token: " {{ csrf_token() }} ",
                        orderId: " {{ $orderId }} "
                    };

                    $.ajax({
                        url: " {{action('\App\Http\Controllers\Accounting\OrderController@delete')}} ",
                        method: "POST",
                        data: data
                    }).done(response => {
                        DeleteOrderPopup.getPopup().hide();
                        OrderList.getList().load();
                    }).fail(respsonse => {
                        throw new Error("FAIL!");
                    })
                })
            }
        }
    }();
</script>
@endsection