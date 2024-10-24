
<div class="row" id="recommendationLetterScreenId">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">7</span>
            </div>
            <div class="fw-semibold">
                Thư giới thiệu
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneRecommendationLetter() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneRecommendationLetter() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="recommendation_letters" action-control="recommendation_letters" type="button" class="badge badge-success d-none {{ $abroadApplication->isDoneRecommendationLetter() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
                        &#10004;
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9" form-data="manager-container" 
        data-upload-url="{{ action([App\Http\Controllers\Sales\AbroadController::class, 'storeRecommendationLetter'], ['id' => $abroadApplication->id]) }}"
        data-delete-url="{{ action([App\Http\Controllers\Sales\AbroadController::class, 'deleteRecommendationLetter'], ['id' => $abroadApplication->id]) }}">
        <div class="row d-flex justify-content-around">
            <div class="col-md-4">
                <label class="fs-6 fw-bold fs-4">Thời điểm hoàn thành:</label>
            </div>
            <div class="col-md-4 invisible">
                <label class="fs-6 fw-bold fs-4">
                    <button action-control="upload-draft-btn" class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4">Tải bản nháp</button>
                </label>
            </div>
            <div class="col-md-4 invisible">
                <label class="fs-6 fw-bold fs-4">
                    <button action-control="upload-done-btn" class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4">Tải bản hoàn thiện</button>
                </label>
            </div>
        </div>
        <div class="row d-flex justify-content-around">
            {{-- Date input --}}
            <div class="col-md-4">
                <input type="date" value="{{$dayFinish->recommendation_letters ?? ''}}" name="recommendation_letters" class="form-control pe-none">
            </div>
            {{-- Draft form --}}
            <div class="col-md-4">
                <input type="file" action-control="draft-input" class="d-none">
                <div class="form-control px-10">
                    @if (isset($draftPaths) && count($draftPaths) > 0)
                        @foreach ($draftPaths as $path)
                            <div data-file-name="{{ basename($path) }}" data-control="draft-file" class="row my-2">
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
                                <div style="font-style: italic;">Chưa có file nào!</div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            {{-- Done form --}}
            <div class="col-md-4">
                <input type="file" action-control="done-input" class="d-none">
                <div class="form-control px-10">
                    @if (isset($activePaths) && count($activePaths) > 0)
                        @foreach ($activePaths as $path)
                            <div data-file-name="{{ basename($path) }}" data-control="active-file" class="row my-0">
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
                                <div style="font-style: italic;">Chưa có file nào!</div>
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
            container: $('#recommendationLetterScreenId')
        });
    })

    var File = class {
        constructor(options) {
            this.container = options.container;
            this.status = options.status;
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

        getStatus() {
            return this.status;
        }

        getDeleteBtn() {
            return $(this.getContainer()).find('[action-control="delete"]');
        }

        delete() {
            const _this = this;

            const formData = new FormData();
            const csrfToken = '{{ csrf_token() }}';
            const name = this.getName();
            const status = this.getStatus();

            formData.append('_token', csrfToken);
            formData.append('fileName', name);
            formData.append('status', status);

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
                        recommendationLetter.load();
                    }
                });
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        recommendationLetter.load();
                    }
                });
            })
        }

        deleteHandle() {
            ASTool.confirm({
                icon: 'warning',
                message: "Bạn có chắc muốn xóa file này?",
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
            this.statuses = {
                'draft': "{!! \App\Models\RecommendationLetter::STATUS_DRAFT !!}",
                'active': "{!! \App\Models\RecommendationLetter::STATUS_ACTIVE !!}",
            }
        
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

        getDraftFileElements() {
            return this.getContainer().find('[data-control="draft-file"]').toArray();
        }

        getActiveFileElements() {
            return this.getContainer().find('[data-control="active-file"]').toArray();
        }

        createFileInstances(elements, status) {
            const _this = this;

            elements.forEach(elm => {
                new File({
                    container: elm,
                    status: status,
                    manager: _this
                })
            })
        }

        getStatusDraft() {
            return this.statuses.draft;
        }

        getStatusActive() {
            return this.statuses.active;
        }

        getUpLoadDraftBtn() {
            return this.getContainer().find('[action-control="upload-draft-btn"]');
        }

        getUpLoadActiveBtn() {
            return this.getContainer().find('[action-control="upload-done-btn"]');
        }

        getUpLoadDoneBtn() {
            return this.getContainer().find('[action-control="upload-done-btn"]');
        }

        getDraftInput() {
            return this.getContainer().find('[action-control="draft-input"]');
        }

        getDoneInput() {
            return this.getContainer().find('[action-control="done-input"]');
        }
        getDoneBtn() {
            return this.getContainer().find('[action-control="recommendation_letters"]');
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
                    recommendationLetter.load();
                     
                 }).fail(message => {
                     // Xử lý khi yêu cầu thất bại
                     throw new Error(message); // In ra thông báo lỗi
                 });

         }

        upload(status) {
            const _this = this;
            const formData = new FormData();
            const csrfToken = '{{ csrf_token() }}';

            let file;

            if (status === _this.getStatusDraft()) {
                file = this.getDraftInput().prop('files')[0];
            } else if (status === _this.getStatusActive()) {
                file = this.getDoneInput().prop('files')[0];
            } else {
                throw new Error('Invalid status!');
            }

            formData.append('_token', csrfToken);
            formData.append('file', file);
            formData.append('status', status);

            $.ajax({
                url: _this.getUploadUrl(),
                data: formData,
                method: 'POST',
                contentType: false,
                processData: false
            }).done(response => {
                // Reload letter content
                recommendationLetter.load();
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        recommendationLetter.load();
                    }
                });
            })
        }

        init() {
            const draftElements = this.getDraftFileElements();
            const activeElements = this.getActiveFileElements();

            this.createFileInstances(draftElements, this.getStatusDraft());
            this.createFileInstances(activeElements, this.getStatusActive());
            this.events();
        }

        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="recommendation_letters"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Student\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    recommendation_letters: loTrinhHtClValue,
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

            _this.getUpLoadDraftBtn().on('click', function(e) {
                e.preventDefault();

                _this.getDraftInput().click();
            })

            _this.getDraftInput().on('change',function(e) {
                e.preventDefault();

                const status = _this.getStatusDraft();
                _this.upload(status);
            })

            _this.getUpLoadActiveBtn().on('click', function(e) {
                e.preventDefault();

                _this.getDoneInput().click();
            })

            _this.getDoneInput().on('change',function(e) {
                e.preventDefault();

                const status = _this.getStatusActive();
                _this.upload(status);
            })

            _this.getContainer().find('input[name="recommendation_letters"]').on('change', function() {
                _this.dateChangedHandle();
            });
            _this.getDoneBtn().on('click', function(e) {
                e.preventDefault();
                _this.clickDoneBtn();
            })
        }
    }

    /**
     * Popup to create or edit
     */
    var LetterPopup = class {
        constructor(options) {
            this.popup;

            this.init();
        }

        getPopup() {
            return this.popup;
        }

        init() {
            this.popup = new Popup();
        }

        updateUrl(newUrl) {
            this.popup.url = newUrl;
            this.popup.load();
        }
    }
</script>