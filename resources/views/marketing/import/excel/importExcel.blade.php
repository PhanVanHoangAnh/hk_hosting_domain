@extends('layouts.main.popup')
@section('title')
    Nhập dữ liệu liên hệ
@endsection
@section('content')
    <!--begin::Stepper-->
    <div class="stepper stepper-pills" id="kt_stepper_example_basic">
        <!--begin::Nav-->
        <div class="stepper-nav flex-center flex-wrap mt-5">


            <!--begin::Step 1-->
            <div class="stepper-item mark-completed mx-8 my-4" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px bg-primary">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number text-white">
                            1
                        </span>
                    </div>
                    <!--end::Icon-->

                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title text-left">
                            <i class="bi bi-upload fs-2"></i>
                        </h3>

                        <div class="stepper-desc text-black">
                            Tải dữ liệu
                        </div>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
            </div>
            <!--end::Step 1-->

            <!--begin::Step 2-->
            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">2</span>
                    </div>
                    <!--begin::Icon-->

                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title text-left">
                            <i class="bi bi-graph-down-arrow fs-2"></i>
                        </h3>

                        <div class="stepper-desc text-black">
                            Xem trước
                        </div>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
            </div>
            <!--end::Step 2-->

            <!--begin::Step 3-->
            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">3</span>
                    </div>
                    <!--begin::Icon-->

                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title text-left">
                            <i class="bi bi-save fs-2"></i>
                        </h3>

                        <div class="stepper-desc text-black">
                            Nhập dữ liệu
                        </div>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
            </div>
            <!--end::Step 3-->

            <!--begin::Step 4-->
            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                <!--begin::Wrapper-->
                <div class="stepper-wrapper d-flex align-items-center">
                    <!--begin::Icon-->
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">4</span>
                    </div>
                    <!--begin::Icon-->

                    <!--begin::Label-->
                    <div class="stepper-label">
                        <h3 class="stepper-title text-left">
                            <i class="bi bi-list-check fs-2"></i>
                        </h3>

                        <div class="stepper-desc text-black">
                            Kết quả
                        </div>
                    </div>
                    <!--end::Label-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Line-->
                <div class="stepper-line h-40px"></div>
                <!--end::Line-->
            </div>
            <!--end::Step 4-->
        </div>
        <!--end::Nav-->
    </div>
    <!--end::Stepper-->

    <form data-control="upload-form" class="form" action="{{ action([App\Http\Controllers\Marketing\ContactController::class, 'importExcelUpload']) }}"
        id="kt_modal_upload_form" method="POST" enctype="multipart/form-data">
        @csrf
        <!--begin::Modal body-->
        <div class="modal-body pt-10 pb-15 px-lg-17">
            <!--begin::Input group-->
            <div class="form-group">
                <!--begin::Dropzone-->
                <div class="dropzone dropzone-queue mb-2" id="kt_modal_upload_dropzone">
                    <label class="form-label fs-2">Chọn file dữ liệu liên hệ để nhập vào hệ thống</label>
                    <p class="mb-10">Nhấn
                        <a href="{{ url('/templates/contact-import-template.xlsx') }}" class="fw-bold">
                            vào đây
                        </a> để tải tập tin mẫu về máy
                    </p>
                    <!--begin::Controls-->
                    <div class="mb-10 mt-10">
                        <label for="exampleFormControlInput1" class="required form-label">Chọn tập tin để nhập</label>
                        <input type="file" class="form-control test-input-file" name="file" required/>
                        <!--begin::Hint-->
                        <span class="form-text fs-6 small">Max file size is 1MB per file.</span>
                        <!--end::Hint-->
                        @if (isset($error) && $error)
                            <x-input-error :messages="[$error]" class="mt-2" />
                        @endif
                    </div>
                    <div>
                        <button data-control="upload-run" class="btn btn-info" title="Khuyến nghị dành cho dữ liệu ban đầu, số lượng nhiều > 10,000, tự động cập nhật dữ liệu nếu trùng">Tải & Tự động nhập</button>
                        <button class="btn btn-light d-none">Tải & Xem trước</button>
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Dropzone-->
            </div>
            <!--end::Input group-->
        </div>
        <!--end::Modal body-->
    </form>
    <script>
        $(() => {
            formEvents.init();

            // 
            new AutoImport({
                form: $('[data-control="upload-form"]'),
                button: $('[data-control="upload-run"]'),
                url: '{{ action([App\Http\Controllers\Marketing\ContactImportController::class, 'uploadAndRun']) }}'
            });

            // running load progress
            @if (App\Library\ImportContact::isRunning())
                ExcelPopup.getPopup().url = '{{ action([\App\Http\Controllers\Marketing\ContactImportController::class, 'progress']) }}';
                ExcelPopup.getPopup().load();
            @endif
        })

        var AutoImport = class {
            constructor(options) {
                var _this = this;
                this.form = options.form;
                this.button = options.button;
                this.url = options.url;

                // events
                this.button.on('click', function(e) {
                    e.preventDefault();

                    if (!_this.validate()) {
                        return;
                    }
                    
                    _this.run();
                });
            }

            validate() {
                if(!this.form[0].checkValidity()) {
                    ASTool.warning({
                        message: 'Chọn tập tin dữ liệu',
                        ok: function() {
                        }
                    });

                    return false;
                }

                return true;
            }

            run() {
                addMaskLoading();

                var data = new FormData(this.form[0]);

                $.ajax({
                    url: this.url,
                    method: "POST",
                    data: data,
                    processData: false, // Set this because we have to send file type (haven't convert to String type), if not => error: Illegal invocation
                    contentType: false, // With this atrribute, we can get the file data
                }).done(response => {
                    ExcelPopup.getPopup().url = response.progressUrl;
                    ExcelPopup.getPopup().load();

                    removeMaskLoading();
                }).fail((response) => {
                    // ExcelPopup.getPopup().setContent(response.responseText);

                    removeMaskLoading();
                }).always(function() {
                    
                });
            }
            
        }

        var formEvents = function(url) {
            let form;

            var upload = function() {
                addMaskLoading();

                var data = new FormData(document.querySelector("#kt_modal_upload_form"));

                $.ajax({
                    url: $(form).attr('action'),
                    method: "POST",
                    data: data,
                    processData: false, // Set this because we have to send file type (haven't convert to String type), if not => error: Illegal invocation
                    contentType: false, // With this atrribute, we can get the file data
                }).done(response => {
                    ExcelPopup.getPopup().url = response.url;
                    ExcelPopup.getPopup().load();

                    removeMaskLoading();
                }).fail((response) => {
                    ExcelPopup.getPopup().setContent(response.responseText);

                    removeMaskLoading();
                }).always(function() {
                    
                });
            };

            return {
                init: () => {
                    form = document.querySelector('#kt_modal_upload_form');
                    
                    //events
                    form.addEventListener('submit', e => {
                        e.preventDefault();

                        upload();
                    });
                }
            };
        }();
    </script>
@endsection
