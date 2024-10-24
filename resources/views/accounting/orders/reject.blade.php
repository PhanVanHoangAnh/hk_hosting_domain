@extends('layouts.main.popup')

@section('title')
    Bạn từ chối duyệt hợp đồng mã số {{ $order->code }}
@endsection

@section('content')
    <form id="OrderRejectFrom"  tabindex="-1" method="POST">
        @csrf

        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
            <!--begin::Input group-->

            <div class="col-md-12 fv-row">
                <!--begin::Label-->
                <label class="required fs-6 fw-semibold mb-2">Vui lòng nhập lý do bên dưới</label>
                <!--end::Label-->
                <!--begin::Textarea-->
                <textarea class="form-control" placeholder="Lý do từ chối duyệt!" name="rejected_reason" rows="5" cols="40"></textarea>
                <!--end::Textarea-->
            </div>
            <x-input-error :messages="$errors->get('rejected_reason')" class="mt-2" />

            <!--end::Scroll-->

            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button id="OrderRejectSubmitButton" type="submit" class="btn btn-primary">
                    <span class="indicator-label">Lưu</span>
                    <span class="indicator-progress">Đang xử lý...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                </button>
                <!--end::Button-->
                <!--begin::Button-->
                <button type="reset" id="kt_modal_add_note_log_cancel" class="btn btn-light me-3"
                    data-bs-dismiss="modal">Hủy</button>
                <!--end::Button-->
            </div>
    </form>
    <script>
        $(function() {
            OrderReject.init();
        });

        var OrderReject = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            //
            submit = () => {
                var data = $(form).serialize();

                addSubmitEffect();
                $.ajax({
                    url: "{{ action('App\Http\Controllers\Accounting\OrderController@reject', ['id' => $order->id]) }}",
                    method: 'POST',
                    data:data,
                }).done(function(response) {
                    //
                    OrderRejectPopup.getPopup().hide();
                    removeSubmitEffect();
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            OrderList.getList().load();
                        }
                    });
                    // hide xem chi tiết
                    ShowOrderPopup.getPopup().hide();
                    // list.load();
                }).fail(function(response) {
                    OrderRejectPopup.getPopup().setContent(response.responseText);
                    //
                    removeSubmitEffect();
                });
            }

            addSubmitEffect = () => {
                // btn effect
                btnSubmit.setAttribute('data-kt-indicator', 'on');
                btnSubmit.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {
                // btn effect
                btnSubmit.removeAttribute('data-kt-indicator');
                btnSubmit.removeAttribute('disabled');
            }
            return {
                init: function() {
                    form = document.getElementById('OrderRejectFrom');
                    btnSubmit = document.getElementById('OrderRejectSubmitButton');
                    handleFormSubmit();
                }
            }
        }();
    </script>

    {{-- asdas
    .fail(function(response) {
        OrderRejectPopup.getPopup().setContent(response.responseText);
        // removeSubmitEffect();
    }); --}}
@endsection
