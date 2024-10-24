<div class="row" id="scan_of_information">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">16</span>
            </div>
            <div class="fw-semibold">
                Bản scan thông tin cá nhân
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneScanOfInformation() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneScanOfInformation() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="scan_of_information" action-control="scan_of_information" type="button" class="badge badge-success {{ $abroadApplication->isDoneScanOfInformation() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
                        &#10004;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9" form-data="scan-of-information-manager-container"
        data-upload-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'storeScanOfInformation'], ['id' => $abroadApplication->id]) }}"
        data-delete-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'deleteScanOfInformation'], ['id' => $abroadApplication->id]) }}">
        <div class="row d-flex justify-content-around">
            <div class="col-md-4">
                <label class="fs-6 fw-bold fs-4">Thời điểm hoàn thành:</label>
            </div>
            <div class="col-md-8">
                <label class="fs-6 fw-bold fs-4">
                    <button action-control="upload-scan-of-information-btn"
                        class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4">Tải bản Scan</button>
                </label>
            </div>
        </div>
        <div class="row d-flex justify-content-around">
            {{-- Date input --}}
            <div class="col-md-4">
                <input type="date" value="{{$dayFinish->scan_of_information ?? ''}}" name="scan_of_information" class="form-control">
            </div>
            {{-- Draft form --}}
            <div class="col-md-8">
                <input type="file" action-control="scan-of-information-input" class="d-none">
                <div class="form-control px-10">
                    @if (isset($paths) && count($paths) > 0)
                        @foreach ($paths as $path)
                            <div data-file-name="{{ basename($path) }}" data-control="scan-of-information-file"
                                class="row my-2">
                                <div
                                    class="col-md-9 pe-0 cursor-pointer bg-secondary d-flex justify-content-start align-items-center">
                                    <span class="material-symbols-rounded">description</span>&nbsp;&nbsp;&nbsp;
                                    <a class="cursor-pointer" href="{{ $path }}"
                                        download="{{ basename($path) }}">
                                        {{ basename($path) }}
                                        <span class="material-symbols-rounded pt-2">
                                            arrow_downward
                                        </span>
                                    </a>
                                </div>
                                <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center">
                                    <button action-control="delete" class="btn btn-danger btn-sm">Xóa</button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="row my-2">
                            <div class="col-md-12 pe-0 cursor-pointer d-flex justify-content-center align-items-center">
                                <div style="font-style: italic;">Chưa có File!</div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var manager;

    $(() => {
        manager = new Manager({
            container: $('#scan_of_information')
        });
    })

    var File = class {
        constructor(options) {
            this.container = options.container;
            this.manager = options.manager;

            this.init();
        }

        getManager() {
            return this.manager;
        }

        getContainer() {
            return this.container;
        }

        getName() {
            return $(this.getContainer()).attr('data-file-name');
        }

        getDeleteBtn() {
            return $(this.getContainer()).find('[action-control="delete"]');
        }

        delete() {
            const _this = this;

            const formData = new FormData();
            const csrfToken = '{{ csrf_token() }}';
            const name = this.getName();

            formData.append('_token', csrfToken);
            formData.append('fileName', name);

            $.ajax({
                url: _this.getManager().getDeleteUrl(),
                method: 'post',
                data: formData,
                contentType: false,
                processData: false
            }).done(response => {
                ASTool.alert({
                    icon: 'success',
                    message: response.messages,
                    ok: () => {
                        // Reload letter content
                        scanOfInformationManager.load();
                    }
                });
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        scanOfInformationManager.load();
                    }
                });
            })
        }

        deleteHandle() {
            ASTool.confirm({
                icon: 'warning',
                message: "Bạn có chắc muốn xóa File này không?",
                ok: () => {
                    this.delete();
                },
                cancel: () => {}
            })
        }

        init() {
            this.events();
        }

        events() {
            const _this = this;

            _this.getDeleteBtn().on('click', function(e) {
                e.preventDefault();

                _this.deleteHandle();
            })
        }
    }

    var Manager = class {
        constructor(options) {
            this.container = options.container;

            this.init();
        }

        getContainer() {
            return this.container;
        }

        getForm() {
            return this.getContainer().find('[form-data="scan-of-information-manager-container"]');
        }

        getUploadUrl() {
            return this.getForm().attr('data-upload-url');
        }

        getDeleteUrl() {
            return this.getForm().attr('data-delete-url');
        }

        getScanOfInformationFileElements() {
            return this.getForm().find('[data-control="scan-of-information-file"]').toArray();
        }

        createFileInstances(elements, status) {
            const _this = this;

            elements.forEach(elm => {
                new File({
                    container: elm,
                    manager: _this
                })
            })
        }

        getUpLoadScanOfInformationBtn() {
            return this.getForm().find('[action-control="upload-scan-of-information-btn"]');
        }

        getScanOfInformationInput() {
            return this.getForm().find('[action-control="scan-of-information-input"]');
        }

        upload() {
            const _this = this;
            const formData = new FormData();
            const csrfToken = '{{ csrf_token() }}';
            const file = this.getScanOfInformationInput().prop('files')[0];

            formData.append('_token', csrfToken);
            formData.append('file', file);

            $.ajax({
                url: _this.getUploadUrl(),
                data: formData,
                method: 'POST',
                contentType: false,
                processData: false
            }).done(response => {
                // Reload letter content
                scanOfInformationManager.load();
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        scanOfInformationManager.load();
                    }
                });
            })
        }

        init() {
            const scanOfInformationElements = this.getScanOfInformationFileElements();

            this.createFileInstances(scanOfInformationElements);
            this.events();
        }
        getDoneBtn() {
            return this.getContainer().find('[action-control="scan_of_information"]');
        }
        clickDoneBtn() {
             
             var updateFinishDay = this.getDoneBtn().val();
             var abroadApplicationId = '{{ $abroadApplication->id }}';
             $.ajax({
                 url: '{{ action([App\Http\Controllers\Abroad\AbroadApplicationStatusController::class, 'updateDoneAbroadApplication'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                 method: 'PUT', 
                 data: {
                     updateFinishDay: updateFinishDay,
                     abroadApplicationId:abroadApplicationId,
                     _token: '{{ csrf_token() }}'
                 },
                 }).done(response => {
                    scanOfInformationManager.load();
                     
                 }).fail(message => {
                     // Xử lý khi yêu cầu thất bại
                     throw new Error(message); // In ra thông báo lỗi
                 });

         }
        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="scan_of_information"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Abroad\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    scan_of_information: loTrinhHtClValue,
                    abroadApplicationId:abroadApplicationId,
                    _token: '{{ csrf_token() }}'
                },
                }).done(response => {
                
                    
                }).fail(message => {
                    // Xử lý khi yêu cầu thất bại
                    throw new Error(message); // In ra thông báo lỗi
                });

        }
        events() {
            const _this = this;

            _this.getUpLoadScanOfInformationBtn().on('click', function(e) {
                e.preventDefault();

                _this.getScanOfInformationInput().click();
            })

            _this.getScanOfInformationInput().on('change', function(e) {
                e.preventDefault();

                _this.upload();
            })
            _this.getContainer().find('input[name="scan_of_information"]').on('change', function() {
                _this.dateChangedHandle();
            });
            _this.getDoneBtn().on('click', function(e) {
                e.preventDefault();
                _this.clickDoneBtn();
            })
        }
    }
</script>
