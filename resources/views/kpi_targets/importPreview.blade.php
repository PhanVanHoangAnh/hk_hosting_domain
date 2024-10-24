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
                    'step' => 'preview',
                ])
            </div>

            <!--begin::Content-->
            <div class="flex-row-fluid">
                <form id="{{ $formId }}" action="{{ action('App\Http\Controllers\KpiTargetController@importRun', [
                    'path' => $path,
                ]) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h2>Danh sách kế hoạch KPI từ file</h2>

                    <!--begin::Table-->
                    <table class="table align-middle table-row-dashed fs-6 gy-5 table-bordered" id="kt_customers_table">
                        <thead>
                            <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase text-nowrap">
                                <th width="1%" class="text-white">
                                    Mã NV
                                </th>
                                <th class="text-white">
                                    Nhân viên
                                </th>
                                <th class="text-white">
                                    Phân loại
                                </th>
                                <th class="text-white">
                                    Chỉ tiêu
                                </th>
                                <th class="text-white">
                                    Ngày bắt đầu
                                </th>
                                <th class="text-white">
                                    Ngày kết thúc
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kpiTargets as $kpiTarget)
                                <tr>
                                    <td data-column="account_code" class="text-left" data-filter="mastercard">
                                        {{ $kpiTarget->account->code }}
                                    </td>

                                    <td data-column="account_id" class="text-left" data-filter="mastercard">
                                        {{ $kpiTarget->account->name }}
                                    </td>

                                    <td data-column="account_id" class="text-left" data-filter="mastercard">
                                        {{ trans('messages.kpi_target.type.' . $kpiTarget->type) }}
                                    </td>

                                    <td data-column="amount" class="text-left" data-filter="mastercard">
                                        {{ App\Helpers\Functions::formatNumber($kpiTarget->amount) }}₫
                                    </td>

                                    <td data-column="start_at" class="text-left" data-filter="mastercard">
                                        {{ $kpiTarget->start_at->format('d/m/Y') }}
                                    </td>

                                    <td data-column="end_at" class="text-left" data-filter="mastercard">
                                        {{ $kpiTarget->end_at->format('d/m/Y') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Xác nhận & Nhập dữ liệu</button>
                    </div>
                </form>
            </div>
        </div>
        <!--end::Stepper-->
    </div>

    <script>
        $(function() {
            new KpiImportForm({
                form: document.getElementById('{{ $formId }}'),
            });
        });

        var KpiImportForm = class {
            constructor(options) {
                this.form = options.form;

                //
                this.events();
            }

            getForm() {
                return this.form;
            }

            getUrl() {
                return this.getForm().getAttribute('action');
            }

            import() {
                var formData = new FormData(this.getForm());

                // effect
                ASTool.addPageLoadingEffect();

                $.ajax({
                    url: this.getUrl(),
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false
                }).done((response) => {
                    ImportKpiTarget.getPopup().setContent(response);
                }).fail((response) => {
                    ImportKpiTarget.getPopup().setContent(response.responseText);
                }).always(() => {
                    // effect
                    ASTool.removePageLoadingEffect();
                });
            }

            events() {
                $(this.getForm()).on('submit', (e) => {
                    e.preventDefault();

                    this.import();
                });
            }
        }
    </script>
@endsection