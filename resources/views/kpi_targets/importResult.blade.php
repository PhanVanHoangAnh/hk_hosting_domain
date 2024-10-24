@extends('layouts.main.popup')

@section('title')
    Tải file dữ liệu
@endsection

@php
    $formId = 'F' . uniqid();
@endphp

@section('content')
    <div class="px-20 py-20">
        <!--begin::Stepper-->
        <div class="stepper stepper-pills stepper-column d-flex flex-column flex-lg-row" id="kt_stepper_example_vertical">
            <!--begin::Aside-->
            <div class="d-flex flex-row-auto w-100 w-lg-300px">
                @include('kpi_targets._steps', [
                    'step' => 'result',
                ])
            </div>

            <!--begin::Content-->
            <div class="flex-row-fluid">
                <label class="form-label fs-2 fw-semibold">Hoành thành</label>

                <div class="alert alert-success text-dark">
                    Đã cập nhật thành công <strong>{{ $success }}</strong> kế hoạch KPI.
                </div>

                <div class="mt-4">
                    <button data-control="import-close" type="button" class="btn btn-light">Đóng</button>
                </div>
            </div>
        </div>
        <!--end::Stepper-->
    </div>

    <script>
        $(function() {
            $('[data-control="import-close"]').on('click', () => {
                ImportKpiTarget.getPopup().hide();

                KpiTargetList.getList().load();
            })
        });
    </script>
@endsection