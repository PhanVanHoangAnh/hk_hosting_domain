<div class="stepper stepper-pills mb-10" id="kt_stepper_example_basic">
    <!--begin::Nav-->
    <div class="stepper-nav flex-center flex-wrap mt-5">
        <!--begin::Step 1-->
        <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px bg-primary">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">
                        <i class="bi bi-check-lg fs-3 font-weight-bold"></i>
                    </span>
                </div>
                <!--end::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-upload fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black text-black">
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
        <div class="stepper-item mark-completed mx-8 my-4" data-kt-stepper-element="nav">
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                <div class="stepper-icon w-40px h-40px bg-primary">
                    <i class="stepper-check fas fa-check"></i>
                    <span class="stepper-number">
                        <i class="bi bi-check-lg fs-3 font-weight-bold"></i>
                    </span>
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
        <div class="stepper-item mark-completed mx-8 my-4" data-kt-stepper-element="nav">
            <!--begin::Wrapper-->
            <div class="stepper-wrapper d-flex align-items-center">
                <!--begin::Icon-->
                @if ($isDone)
                    <div class="stepper-icon w-40px h-40px bg-primary">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">
                            <i class="bi bi-check-lg fs-3 font-weight-bold"></i>
                        </span>
                    </div>
                @else
                    <div class="stepper-icon w-40px h-40px bg-primary">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number text-white">3</span>
                    </div>
                @endif
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
                @if ($isDone)
                    <div class="stepper-icon w-40px h-40px bg-primary">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">
                            <i class="bi bi-check-lg fs-3 font-weight-bold"></i>
                        </span>
                    </div>
                @else
                    <div class="stepper-icon w-40px h-40px">
                        <i class="stepper-check fas fa-check"></i>
                        <span class="stepper-number">4</span>
                    </div>
                @endif
                <!--begin::Icon-->

                <!--begin::Label-->
                <div class="stepper-label">
                    <h3 class="stepper-title text-left">
                        <i class="bi bi-list-check fs-2"></i>
                    </h3>

                    <div class="stepper-desc text-black text-black">
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


<div class="progress" role="progressbar" aria-label="Animated striped example" aria-valuenow="{{ round($progress['percent']) }}" aria-valuemin="0" aria-valuemax="100" style="height: 25px">
    <div class="progress-bar progress-bar-striped progress-bar-animated fs-4 fw-bold bg-success text-dark" style="width: {{ $progress['percent'] }}%">{{ round($progress['percent'],2) }}%</div>
</div>

<div class="mt-3 ">
    <div class="mb-2 form-label">Tất cả:
        <span class="fw-bold">
            {!! $progress['total'] == 0 ? 'Đang đọc dữ liệu.... ' : App\Helpers\Functions::formatNumber($progress['total']) !!}
        </span>
    </div>
    <div class="mb-2 form-label d-flex align-items-center">
        <span class="me-2">Đã xử lý: </span>
        <span class="d-flex align-items-center">
            <span class="fw-bold me-3">{{ App\Helpers\Functions::formatNumber($progress['processed']) }} / {{ App\Helpers\Functions::formatNumber($progress['total']) }}</span>
        </span>
    </div>
    <div class="mb-2 form-label">Thành công: <span id="updated-contacts-count"
            class="fw-bold text-success">
                {{ App\Helpers\Functions::formatNumber($progress['success']) }}
            </span>
    </div>

    {{-- <div class="mb-2 form-label">Thêm mới thành công: <span id="new-contacts-count"
            class="d-none">
        </span>
    </div> --}}

    <div class="mb-2 form-label">Dữ liệu trống: <span class="fw-bold text-danger">{{ App\Helpers\Functions::formatNumber($progress['failed']) }}
        </span></div>
</div>

@if ($isDone)
    <hr>
    <a data-action="finish-import" href="" class="btn btn-info">Hoàn thành</a>
    <a id="downLogBtn"
        href="{{ action([\App\Http\Controllers\Marketing\ContactController::class, 'downloadFileExportLogsImport']) }}"
        class="btn btn-primary">Tải log</a>

    <script>
        $(() => {
            //
            $('[data-control="importing-spinner"]').hide();

            //
            new ProgressBar({
                finishButton: $('[data-action="finish-import"]'),
                finishUrl: '{{ action([App\Http\Controllers\Marketing\ContactImportController::class, 'finish']) }}',
            });
        });

        var ProgressBar = class {
            constructor(options) {
                var _this = this;
                this.finishButton = options.finishButton;
                this.finishUrl = options.finishUrl;

                this.finishButton.on('click', function(e) {
                    e.preventDefault();

                    _this.finish();
                });
            }

            finish() {
                $.ajax({
                    method: 'POST',
                    url: this.finishUrl,
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                }).done(function(response) {
                    window.location.reload();
                })
            }
        }
    </script>
@endif