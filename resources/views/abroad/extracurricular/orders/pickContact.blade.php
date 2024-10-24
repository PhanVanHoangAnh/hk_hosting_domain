@extends('layouts.main.popup')

@section('title')
    Thêm mới dịch vụ
    @if (isset($copyFromOrder))
        (Sao chép thông tin từ dịch vụ #{{ $copyFromOrder->code }})
    @endif
@endsection

@php
    $formId = 'F' . uniqid();
@endphp

@section('content')

<form id="{{ $formId }}" method="POST" action="{{ action('\App\Http\Controllers\Abroad\OrderController@createConstract') }}">
    @csrf

    <div class="mt-10">
        {{-- <div class="row w-100 px-15 mx-auto d-flex justify-content-around mt-10 {{ isset($copyFromOrder) ? 'd-none' : '' }}">
            <div class="col-12">
                <label for="" class="form-label fw-semibold text-info">Loại dịch vụ</label>
            </div>
        </div> --}}

        <div class="pb-10 d-none">
            <input type="hidden" name="type" value="{{ \App\Models\Order::TYPE_EXTRACURRICULAR }}">
            <div class="row w-100 px-15 mx-auto d-flex justify-content-around order-type-select">
                {{-- <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-12">
                    <input type="radio" {{ $order->type == App\Models\Order::TYPE_ABROAD ? 'checked' : '' }} class="btn-check" name="type" value="{{ App\Models\Order::TYPE_ABROAD }}" {{ isset($type) && $type == App\Models\Order::TYPE_ABROAD ? 'checked' : '' }} id="{{ App\Models\Order::TYPE_ABROAD . '_type_radio'}}"/>
                    <label class="btn btn-outline btn-outline-info btn-active-primary text-gray-800 d-flex align-items-center justify-content-center" for="{{ App\Models\Order::TYPE_ABROAD . '_type_radio'}}">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <span class="material-symbols-rounded fs-1 me-5" style="vertical-align: middle;">
                                flightsmode
                            </span>
                            <span class="fw-semibold text-center">
                                <span class="fw-bold fs-3">Du học</span>
                            </span>
                        </div>
                    </label>
                </div>

                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-12">
                    <input type="radio" {{ $order->type == App\Models\Order::TYPE_EDU ? 'checked' : '' }} class="btn-check" name="type" value="{{ App\Models\Order::TYPE_EDU }}" {{ isset($type) && $type == App\Models\Order::TYPE_EDU ? 'checked' : '' }} id="{{ App\Models\Order::TYPE_EDU . '_type_radio'}}"/>
                    <label class="btn btn-outline btn-outline-info btn-active-primary text-gray-800 d-flex align-items-center justify-content-center" for="{{ App\Models\Order::TYPE_EDU . '_type_radio'}}">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <span class="material-symbols-rounded fs-1 me-5" style="vertical-align: middle;">
                                school
                            </span>
                            <span class="fw-semibold text-center">
                                <span class="fw-bold fs-3">Đào tạo</span>
                            </span>
                        </div>
                    </label>
                </div>

                <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-12 d-none">
                    <input type="radio" {{ $order->type == App\Models\Order::TYPE_KIDS ? 'checked' : '' }} class="btn-check" name="type" value="{{ App\Models\Order::TYPE_KIDS }}" {{ isset($type) && $type == App\Models\Order::TYPE_KIDS ? 'checked' : '' }} id="{{ App\Models\Order::TYPE_KIDS . '_type_radio'}}"/>
                    <label data-action="under-construction" class="btn btn-outline btn-outline-info btn-active-primary text-gray-800 d-flex align-items-center justify-content-center" for="{{ App\Models\Order::TYPE_KIDS . '_type_radio'}}">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <span class="material-symbols-rounded fs-1 me-5" style="vertical-align: middle;">
                                keyboard_hide
                            </span>
                            <span class="fw-semibold text-center">
                                <span class="fw-bold fs-3">KIDs</span>
                            </span>
                        </div>
                    </label>
                </div> --}}

                {{-- <div class="col-lg-4 col-xl-4 col-md-4 col-sm-4 col-12">
                    <input type="radio" {{ $order->type == App\Models\Order::TYPE_EXTRACURRICULAR ? 'checked' : '' }} class="btn-check" name="type" value="{{ App\Models\Order::TYPE_EXTRACURRICULAR }}" {{ isset($type) && $type == App\Models\Order::TYPE_EXTRACURRICULAR ? 'checked' : '' }} id="{{ App\Models\Order::TYPE_EXTRACURRICULAR . '_type_radio'}}"/>
                    <label class="btn btn-outline btn-outline-info btn-active-primary text-gray-800 d-flex align-items-center justify-content-center" for="{{ App\Models\Order::TYPE_EXTRACURRICULAR . '_type_radio'}}">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                            <span class="material-symbols-rounded fs-1 me-5" style="vertical-align: middle;">
                                directions_run
                            </span>
                            <span class="fw-semibold text-center">
                                <span class="fw-bold fs-3">Ngoại khóa</span>
                            </span>
                        </div>
                    </label>
                </div> --}}
            </div>

            <div class="row w-100 px-15 mx-auto d-flex justify-content-around">
                <div class="col-12">
                    <x-input-error :messages="$errors->get('type')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row w-100 px-15 mx-auto d-flex justify-content-around mb-10">
            <div class="col-12">
                @include('abroad.extracurricular.orders._contact_form', [
                    'formId' => $formId,
                    'orderType' => \App\Models\Order::TYPE_GENERAL
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
                            window.location.href = response.redirect;
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