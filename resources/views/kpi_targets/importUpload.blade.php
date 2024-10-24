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
                    'step' => 'upload',
                ])
            </div>

            <!--begin::Content-->
            <div class="flex-row-fluid">
                <form id="{{ $formId }}" action="{{ action('App\Http\Controllers\KpiTargetController@importUpload') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!--begin::Input group-->
                    <div class="form-group">
                        <!--begin::Dropzone-->
                        <div class="dropzone dropzone-queue mb-2" id="kt_modal_upload_dropzone">
                            <label class="form-label fs-2 fw-semibold">Chọn file dữ liệu kế hoạch KPI</label>
                            <p class="mb-10">Chọn tập tin dữ liệu cần nhập từ máy của. Nếu chưa có tập tin dữ liệu nhấn
                                <a href="{{ action([App\Http\Controllers\KpiTargetController::class, 'importDownloadTemplate']) }}" class="fw-bold">
                                    vào đây
                                </a> để tải tập tin mẫu và điền thông tin kế hoạch KPI.
                            </p>
                            <!--begin::Controls-->
                            <div class="mb-10 mt-10">
                                <label for="exampleFormControlInput1" class="required form-label">Chọn tập tin để nhập</label>
                                <input type="file" class="form-control test-input-file" name="file" />
                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                                <!--begin::Hint-->
                                <p class="form-text fs-6 small mt-2 mb-0">Dung lượng tối đa của tập tin là <strong>{{ ini_get('upload_max_filesize') }}</strong>.</p>
                                <!--end::Hint-->
                            </div>
                            <div>
                                <button form-control="submit" class="btn btn-primary">Tải dữ liệu</button>
                            </div>
                            <!--end::Items-->
                        </div>
                        <!--end::Dropzone-->
                    </div>
                    <!--end::Input group-->
                    
                </form>
            </div>
        </div>
        <!--end::Stepper-->
    </div>

    <script>
        $(function() {
            new KpiUploadForm({
                form: document.getElementById('{{ $formId }}'),
            });
        });

        var KpiUploadForm = class {
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

            getSubmitButton() {
                return this.getForm().querySelector('[form-control="submit"]');
            }

            upload() {
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
                    ImportKpiTarget.loadPreview(response.previewUrl);
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

                    this.upload();
                });
            }
        }
    </script>
@endsection