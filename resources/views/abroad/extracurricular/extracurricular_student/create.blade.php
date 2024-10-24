@extends('layouts.main.popup')

@section('title')
    Thêm học viên vào hoạt động ngoại khoá
@endsection
@php
    $controlId = uniqid();
@endphp
@section('content')
    <form id="CreateReceiptForm-{{ $controlId }}" tabindex="-1"
        action="{{ action([App\Http\Controllers\Abroad\ExtracurricularStudentController::class, 'save']) }}">
        @csrf
        <input type="hidden" name="extracurricularId" value="{{ $id }}">
        <!--begin::Scroll-->
        <div class="scroll-y pe-7  py-10 px-lg-17">
            <!--begin::Input group-->
            <div class="row">
                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Học viên</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <select id="contact-select-{{ $controlId }}" list-action="contact-select-change"
                                data-control="select2-ajax" data-allow-clear="true" data-placeholder="Chọn học viên"
                                data-control="select2" data-dropdown-parent ="#CreateReceiptForm-{{ $controlId }}"
                                data-url="{{ action('App\Http\Controllers\Accounting\PaymentRecordController@select2') }}"
                                class="form-control" name="contact_id" required select2>
                                <option value="">Chọn học viên</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">Cán bộ phụ trách</label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <select name="account_id" data-control="select2-ajax" list-action="sales-select"
                                data-url="{{ action('App\Http\Controllers\Abroad\ExtracurricularStudentController@select2') }}"
                                class="form-control" data-dropdown-parent="" data-control="select2"
                                data-placeholder="Chọn nhân viên">
                                <option>
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                $(() => {
                    new OrderBox({
                        box: $('#table-order'),
                        getTypeSelectBox: function() {
                            return $('#contact-select-{{ $controlId }}');
                        }
                    });

                });

                var OrderBox = class {
                    constructor(options) {
                        this.box = options.box;
                        this.getTypeSelectBox = options.getTypeSelectBox;
                        this.events();
                    }
                    events() {
                        this.getTypeSelectBox().on('change', (e) => {
                            this.clearSubjects();
                        });
                    }
                    clearSubjects() {
                        this.box.html('');
                    }

                };
            </script>

            <div class="row">
                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Ngày thu</span>
                        </label>
                        <!--end::Label-->
                        <!--begin::Input-->
                        <div class="form-outline">
                            <div data-control="date-with-clear-button"
                                class="d-flex align-items-center date-with-clear-button">
                                <input data-control="input" name="payment_date" placeholder="=asas" type="date"
                                    class="form-control" placeholder="" required />
                                <span data-control="clear" class="material-symbols-rounded clear-button"
                                    style="display:none;">close</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="fv-row mb-7">
                        <!--begin::Label-->
                        <label class="required fs-6 fw-semibold mb-2">
                            <span class="">Số tiền</span>
                        </label>

                        <input type="text" class="form-control" id="price-input" list-action='format-number'
                            name="amount" placeholder="Số tiền" required />
                        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                    </div>

                </div>

            </div>

            <div class="col-md-12 fv-row">
                <!--begin::Label-->
                <label class=" fs-6 fw-semibold mb-2">Ghi chú</label>
                <!--end::Label-->
                <!--begin::Textarea-->
                <textarea class="form-control" placeholder="Nhập nội dung ghi chú!" name="description" rows="5" cols="40"></textarea>
                <!--end::Textarea-->
            </div>
            <x-input-error :messages="$errors->get('description')" class="mt-2" />

            <!--end::Scroll-->

            <div class="modal-footer flex-center">
                <!--begin::Button-->
                <button id="CreateReceiptSubmitButton-{{ $controlId }}" type="submit" class="btn btn-primary">
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
        </div>
    </form>


    <script>
        $(document).ready(function() {
            initializePriceInput.init();

            CreateReceipt.init();
        });
        var initializePriceInput = function() {
            return {
                init: () => {
                    const priceInput = $('#price-input');

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

                        $('#CreateReceiptForm-{{ $controlId }}').on('submit', function() {
                            priceInput.val(priceInput.val().replace(/,/g, ''));
                        });
                    }
                }
            }

        }();
        var CreateReceipt = function() {
            let form;
            let submitDataBtn;

            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    submit();
                });
            };

            submit = () => {

                var data = $(form).serialize();
                addSubmitEffect();
                var url = form.getAttribute('action');
                $.ajax({
                    url: url,
                    method: 'PUT',
                    data: data
                }).done(response => {
                   
                   

                    ASTool.alert({
                        message: response.message,
                        ok: () => {
                            UpdateExtracurricularPopup.getUpdatePopup().load();
                            abroadApplicationsList.getList().load();
                        }
                    });
                    CreateExtracurricularPopup.getUpdatePopup().hide();
                }).fail(response => {
                    CreateExtracurricularPopup.getUpdatePopup().setContent(response.responseText);
                    removeSubmitEffect();
                });
            };

            addSubmitEffect = () => {
                submitDataBtn.setAttribute('data-kt-indicator', 'on');
                submitDataBtn.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {
                submitDataBtn.removeAttribute('data-kt-indicator');
                submitDataBtn.removeAttribute('disabled');
            }

            return {
                init: () => {
                    form = document.querySelector("#CreateReceiptForm-{{ $controlId }}");
                    submitDataBtn = document.querySelector("#CreateReceiptSubmitButton-{{ $controlId }}");

                    handleFormSubmit();
                }
            }
        }();
    </script>
@endsection
