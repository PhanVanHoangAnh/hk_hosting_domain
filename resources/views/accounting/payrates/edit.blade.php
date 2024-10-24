@extends('layouts.main.popup')

@section('title')
    Chỉnh sửa bậc lương
@endsection

@php
    $formId = 'F' . uniqid();
@endphp

@section('content')
    <form id="{{ $formId }}"
        action="{{ action(
            [App\Http\Controllers\Accounting\PayrateController::class, 'update'],
            [
                'id' => $salarySheet->id,
            ],
        ) }}"
        method="post">
        @csrf

        @include('accounting.payrates._form', [
            'formId' => $formId,
        ])
        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="UpdatePayrateSubmitButton" type="submit" class="btn btn-primary">
                <span class="indicator-label">Lưu</span>
                <span class="indicator-progress">Đang xử lý...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
            <!--end::Button-->
            <!--begin::Button-->
            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Hủy</button>
            <!--end::Button-->
        </div>
    </form>
    <script>
        $(function() {
            PayrateEdit.init();

            initializePriceInput();

            function initializePriceInput() {
                const priceInput = $('#amount-input');

                if (priceInput.length) {
                    const mask = new IMask(priceInput[0], {
                        mask: Number,
                        scale: 0,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                    });

                    $('#{{ $formId }}').on('submit', function () {
                        priceInput.val(priceInput.val().replace(/,/g, ''));
                    });
                }
            }
        });

        //
        var PayrateEdit = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            submit = () => {
                var data = $(form).serialize();
                var url = form.getAttribute('action');

                //hieu ung
                addSubmitEffect();

                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: data,
                }).done(function(response) {
                    // hide popup
                    UpdatePayratePopup.getPopup().hide();
                    // removeSubmitEffect();
                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // load lai list
                            PayrateList.getList().load();
                        }
                    });
                }).fail(function(response) {
                    UpdatePayratePopup.getPopup().setContent(response.responseText);

                    // remove hieu ung
                    // removeSubmitEffect();
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
                    form = document.getElementById('{{ $formId }}');
                    btnSubmit = document.getElementById('UpdatePayrateSubmitButton');

                    // data-kt-indicator="on"

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
