@extends('layouts.main.popup')

@section('title')
    Thêm kế hoạch KPI
@endsection

@php
    $formId = 'F' . uniqid();
@endphp

@section('content')
    <form id="{{ $formId }}" action="{{ action([App\Http\Controllers\KpiTargetController::class, 'store']) }}" method="post">
        @csrf

        @include('kpi_targets._form', [
            'formId' => $formId,
        ])

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button form-control="save" class="btn btn-primary">
                <span class="indicator-label">Thêm</span>
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
            KpiCreateForm.init();
        });

        var KpiCreateForm = function() {
            var form;
            var btnSubmit;

            var handleFormSubmit = () => {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();

                    submit();
                });
            }

            //Pthuc xử lý việc gửi biểu mẫu lên máy chủ thông qua AJAX
            submit = () => {
                // Lấy dữ liệu từ biểu mẫu.
                var url = form.getAttribute('action');
                var data = $(form).serialize();
                // Thêm hiệu ứng
                addSubmitEffect();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: data,
                }).done(function(response) {
                    // hide popup
                    CreateKpiTarget.getPopup().hide();
                    
                    // success alert
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // reload list
                            KpiTargetList.getList().load();
                        }
                    });

                    // reload list
                    if (KpiTargetList) {
                        KpiTargetList.getList().load();
                    }
                }).fail(function(response) {
                    CreateKpiTarget.getPopup().setContent(response.responseText);

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
                    form = document.getElementById('{{ $formId }}');
                    btnSubmit = form.querySelector('[form-control="save"]');

                    // amount input mask
                    new IMask(form.querySelector('[name="amount"]'), {
                        mask: Number,
                        scale: 0,
                        thousandsSeparator: ',',
                        padFractionalZeros: false,
                        normalizeZeros: true,
                        radix: ',',
                        mapToRadix: ['.'],
                        min: 0,
                    });

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
