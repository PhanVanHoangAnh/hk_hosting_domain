@extends('layouts.main.popup')

@section('title')
    Thêm mới hợp đồng
@endsection

@section('content')

<form id="pick-contact-form">
    @csrf
    <div class="scroll-y pe-7  py-10 px-lg-17" id="kt_modal_add_note_log_scroll">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <select id="contact-select" data-control="select2-ajax" data-url="{{ action('App\Http\Controllers\Sales\ContactController@select2') }}" class="form-control" name="contact"
                        data-dropdown-parent="#pick-contact-form"
                        data-control="select2" data-placeholder="Chọn khách hàng/liên hệ..." data-allow-clear="true">
                        <option value="">Chọn khách hàng/liên hệ</option>
                    </select>
                    <x-input-error :messages="$errors->get('contactId')" class="mt-2" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer flex-center">
        <!--begin::Button-->
        <button id="createConstractButton" type="submit" class="btn btn-primary">
            <span class="indicator-label">Lưu</span>
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
        submitContactHandle.init();
    })

    var submitContactHandle = function() {
        
        let submitContactBtn = document.querySelector('#createConstractButton');
        let contactId;

        const selectContactElement = $('#contact-select');

        addSubmitEffect = () => {
            submitContactBtn.setAttribute('data-kt-indicator', 'on');
            submitContactBtn.setAttribute('disabled', true);
        },
        removeSubmitEffect = () => {
            submitContactBtn.removeAttribute('data-kt-indicator');
            submitContactBtn.removeAttribute('disabled');
        }

        return {
            init: () => {

                selectContactElement.on('change', function() {
                    contactId = this.value;
                });

                submitContactBtn.addEventListener('click', e => {
                    e.preventDefault();

                    addSubmitEffect();

                        $.ajax({
                            url: "{{ action('\App\Http\Controllers\Accounting\OrderController@createConstract') }}",
                            method: 'POST',
                            data: {
                                _token: "{{ csrf_token() }}",
                                contactId: contactId
                            }
                        }).done(response => {
                            
                            const orderIdFromResponse = response.orderId;
                            
                            window.location.href = `accounting/orders/create-constract\\${orderIdFromResponse}\\create`; // Hardcode URL
                            // Temporary hardcode URL because there is a bug when using the action to display the "pick contact" popup
                        }).fail(response => {
                            pickContactPopup.getPopup().setContent(response.responseText);
                            removeSubmitEffect();
                        })
                });
            }
        };
    }();
</script>
@endsection