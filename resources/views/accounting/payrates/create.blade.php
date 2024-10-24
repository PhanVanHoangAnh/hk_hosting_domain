@extends('layouts.main.popup')

@section('title')
    Thêm bậc lương
@endsection

@php
    $formId = 'F' . uniqid();
@endphp
    
@section('content')

<form id="{{ $formId }}" action="{{ action([\App\Http\Controllers\Accounting\PayrateController::class, 'store']) }}" method="post">
        @csrf

        @include('accounting.payrates._form', [
            'formId' => $formId,
        ])

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreatePayrateSubmitButton" type="submit" class="btn btn-primary">
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
            PayrateCreate.init();
        });

        var PayrateCreate = function() {
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

                addSubmitEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                }).done(function(response) {
                    CreatePayratePopup.getPopup().hide();
                    
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            PayrateList.getList().load();
                        }
                    });
                }).fail(function(response) {
                    CreatePayratePopup.getPopup().setContent(response.responseText);
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
                    btnSubmit = document.getElementById('CreatePayrateSubmitButton');

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
