@extends('layouts.main.popup')

@section('title')
    Thêm yêu cầu học thử
    @if (isset($copyFromOrder))
        (Sao chép thông tin từ yêu cầu #{{ $copyFromOrder->code }})
    @endif
@endsection

@php
    $formId = 'F' . uniqid();
@endphp

@section('content')

<form id="{{ $formId }}" method="POST" action="{{ action('\App\Http\Controllers\Abroad\OrderController@createConstract') }}">
    @csrf
    <input type="hidden" name="type" value="{{ App\Models\Order::TYPE_REQUEST_DEMO }}"/>

    <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10 mt-10">
        <div class="col-12">
            @include('abroad.extracurricular.orders._contact_form', [
                'formId' => $formId,
            ])
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
    var contactRequestManager;

    $(() => {
        submitContactHandle.init();
    })

    var submitContactHandle = function() {
        
        let submitContactBtn = document.querySelector('#createConstractButton');
        let form;

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
                form = document.querySelector('#{{ $formId }}');

                form.addEventListener('submit', e => {
                    e.preventDefault();

                    var data = $(form).serialize();

                    addSubmitEffect();

                        $.ajax({
                            url: "{{ action('\App\Http\Controllers\Abroad\OrderController@createConstract') }}",
                            method: 'POST',
                            data: data
                        }).done(response => {
                            
                            const orderIdFromResponse = response.orderId;
                            
                            window.location.href = response.redirect; // `sales/orders/create-constract\\${orderIdFromResponse}\\create`; // Hardcode URL
                            // Temporary hardcode URL because there is a bug when using the action to display the "pick contact" popup
                        }).fail(response => {
                            pickContactPopup.getPopup().setContent(response.responseText);
                            removeSubmitEffect();
                        })
                })
            }
        };
    }();
</script>
@endsection