<div class="row" id="financial_document">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">10</span>
            </div>
            <div class="fw-semibold">
                Hồ sơ tài chính
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneFinancialDocument() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneFinancialDocument() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="financial_document" action-control="financial_document" type="button" class="badge badge-success d-none {{ $abroadApplication->isDoneFinancialDocument() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
                        &#10004;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9" form-data="financial-document-manager-container" 
        data-upload-url="{{ action([App\Http\Controllers\Sales\AbroadController::class, 'storeFinancialDocument'], ['id' => $abroadApplication->id]) }}"
        data-delete-url="{{ action([App\Http\Controllers\Sales\AbroadController::class, 'deleteFinancialDocument'], ['id' => $abroadApplication->id]) }}">
        <div class="row d-flex justify-content-around">
            <div class="col-md-4">
                <label class="fs-6 fw-bold fs-4">Thời điểm hoàn thành:</label>
            </div>
            <div class="col-md-8 invisible">
                <label class="fs-6 fw-bold fs-4">
                    <button action-control="upload-financial-document-btn" class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4">Tải hồ sơ</button>
                </label>
            </div>
        </div>
        <div class="row d-flex justify-content-around">
            {{-- Date input --}}
            <div class="col-md-4">
                <input type="date" value="{{$dayFinish->financial_document ?? ''}}" name="financial_document" class="form-control pe-none">
            </div>
            {{-- Draft form --}}
            <div class="col-md-8">
                <input type="file" action-control="financial-document-input" class="d-none">
                <div class="form-control px-10">
                    @if (isset($paths) && count($paths) > 0)
                        @foreach ($paths as $path)
                            <div data-file-name="{{ basename($path) }}" data-control="financial-document-file" class="row my-2">
                                <div class="col-md-9 pe-0 cursor-pointer bg-secondary d-flex justify-content-start align-items-center">
                                    <span class="material-symbols-rounded">description</span>&nbsp;&nbsp;&nbsp;
                                    <a class="cursor-pointer" href="{{ $path }}" download="{{  basename($path) }}">
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
                                <div style="font-style: italic;">Chưa có hồ sơ!</div>
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
            container: $('#financial_document')
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
                        financialDocumentManager.load();
                    }
                });
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        financialDocumentManager.load();
                    }
                });
            })
        }

        deleteHandle() {
            ASTool.confirm({
                icon: 'warning',
                message: "Bạn có chắc muốn xóa hồ sơ này không?",
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

        getUploadUrl() {
            return this.getContainer().attr('data-upload-url');
        }

        getDeleteUrl() {
            return this.getContainer().attr('data-delete-url');
        }

        getFinancialDocumentFileElements() {
            return this.getContainer().find('[data-control="financial-document-file"]').toArray();
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

        getUpLoadFinancialDocumentBtn() {
            return this.getContainer().find('[action-control="upload-financial-document-btn"]');
        }

        getFinancialDocumentInput() {
            return this.getContainer().find('[action-control="financial-document-input"]');
        }

        upload() {
            const _this = this;
            const formData = new FormData();
            const csrfToken = '{{ csrf_token() }}';
            const file = this.getFinancialDocumentInput().prop('files')[0];

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
                financialDocumentManager.load();
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        financialDocumentManager.load();
                    }
                });
            })
        }

        init() {
            const financialDocumentElements = this.getFinancialDocumentFileElements();

            this.createFileInstances(financialDocumentElements);
            this.events();
        }

        getDoneBtn() {
            return this.getContainer().find('[action-control="financial_document"]');
        }

        clickDoneBtn() {
             var updateFinishDay = this.getDoneBtn().val();
             var abroadApplicationId = '{{ $abroadApplication->id }}';
             $.ajax({
                 url: '{{ action([App\Http\Controllers\Student\AbroadApplicationStatusController::class, 'updateDoneAbroadApplication'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                 method: 'PUT', 
                 data: {
                     updateFinishDay: updateFinishDay,
                     abroadApplicationId:abroadApplicationId,
                     _token: '{{ csrf_token() }}'
                 },
                 }).done(response => {
                    financialDocumentManager.load();
                     
                 }).fail(message => {
                     // Xử lý khi yêu cầu thất bại
                     throw new Error(message); // In ra thông báo lỗi
                 });
         }

        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="financial_document"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Student\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    financial_document: loTrinhHtClValue,
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

            _this.getUpLoadFinancialDocumentBtn().on('click', function(e) {
                e.preventDefault();
                
                _this.getFinancialDocumentInput().click();
            })

            _this.getFinancialDocumentInput().on('change',function(e) {
                e.preventDefault();

                _this.upload();
            })

            _this.getContainer().find('input[name="financial_document"]').on('change', function() {
                _this.dateChangedHandle();
            });
            _this.getDoneBtn().on('click', function(e) {
                e.preventDefault();
                _this.clickDoneBtn();
            })
        }
    }
</script>