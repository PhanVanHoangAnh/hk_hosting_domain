

<div class="row" id="admissionLetterScreenId">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">3</span>
            </div>
            <div class="fw-semibold">
                Kết quả dự tuyển
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneRecruitmentResults() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneRecruitmentResults() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="admission_letter" action-control="admission_letter" type="button" class="badge badge-success {{ $abroadApplication->isDoneRecruitmentResults() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
                        &#10004;
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9" form-data="manager-container" >
        
            {{-- Content --}}
        <div class="row">
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <label class="fs-6 fw-bold fs-4">Thời điểm hoàn thành:</label>
            </div>
        </div>

        <div class="row">
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <input type="date" value="{{$dayFinish->admission_letter ?? ''}}" name="admission_letter" class="form-control">
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <a row-action="show" 
                class="fs-6 fw-bold btn {{$checkFill ? 'btn-secondary': 'btn-info'}} btn-sm fs-4 w-100"
                href="{{ action(
                    [App\Http\Controllers\Abroad\AbroadController::class, 'createAdmissionLetter'],
                    [
                        'id' => $abroadApplication->id,
                    ],
                ) }}">{{$checkFill ? 'Cập nhật' : 'Kê khai'}}</a>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <a row-action="show"  class="fs-6 fw-bold btn btn-secondary btn-sm fs-4 w-100"
                href="{{ action(
                    [App\Http\Controllers\Abroad\AbroadController::class, 'showRecruitmentResults'],
                    [
                        'id' => $abroadApplication->id,
                    ],
                ) }}">Xem</a>
            
            </div>
    
            
        </div>
    
        
        <div class="row d-flex justify-content-around d-none">
            {{-- Date input --}}
            <div class="col-md-4">
                <input class="form-control" type="date" placeholder="Thời điểm hoàn thành">
            </div>
           
            <div class="col-md-4 d-none">
                <div class="form-control px-10">
                    @if (isset($paths) && count($paths) > 0)
                        @foreach ($paths as $path)
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
                                <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center d-none">
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
             
             <div class="col-md-4">
                
             </div>
            
        </div>
    </div>
</div>


<script>
    $(() => {
        AdmissionLetter.init(); 
        
        UpdatePopupRecruitmentResults.init();

        admissionLetter = new AdmissionLetterDay({
            container: $('#admissionLetterScreenId')
        });
    });
    var AdmissionLetterDay = class {
        constructor(options) {
            this.container = options.container;
            
            this.init();
        }

        getContainer() {
            return this.container;
        }

        
        init() {
            this.events();
        }
        getDoneBtn() {
            return this.getContainer().find('[action-control="admission_letter"]');
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
                    admissionLetterManager.load();
                     
                 }).fail(message => {
                     // Xử lý khi yêu cầu thất bại
                     throw new Error(message); // In ra thông báo lỗi
                 });

         }
        
        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="admission_letter"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Abroad\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    admission_letter: loTrinhHtClValue,
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
            _this.getContainer().find('input[name="admission_letter"]').on('change', function() {
                _this.dateChangedHandle();
            });
            _this.getDoneBtn().on('click', function(e) {
                e.preventDefault();
                _this.clickDoneBtn();
            })
        }
    }

    var UpdatePopupRecruitmentResults = (function() {
        var updatePopup;

        return {
            init: function() {
                updatePopup = new Popup();
            },
            updateUrl: function(newUrl) {
                updatePopup.url = newUrl;
                updatePopup.load();
            },
            getUpdatePopup: function() {
                return updatePopup;
            }
        };
    })();

    var AdmissionLetter = (function() {
        var listContent;

        

        function getCreateBtn() {
            return document.querySelectorAll('[row-action="show"]');
        }
        

        return {
            init: function() {
                listContent = document.querySelector('#admissionLetterScreenId');
                if (listContent) {
                  
                    getCreateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdatePopupRecruitmentResults.updateUrl(btnUrl);
                        });
                    });

                    

                    
                } else {
                    throw new Error("listContent is undefined or null.");
                }
            }
        };

        
    })();
</script>


{{-- <div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">15</span>
            </div>
            <div class="fw-semibold">
                Kết quả dự tuyển
                <div class="mt-1">
                    <span
                        class="badge badge-{{ $abroadApplication->isDoneAdmissionLetter() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneAdmissionLetter() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-10" form-data="admission-letter-manager-container"
        data-upload-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'storeAdmissionLetter'], ['id' => $abroadApplication->id]) }}"
        data-delete-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'deleteAdmissionLetter'], ['id' => $abroadApplication->id]) }}">
        <div class="row d-flex justify-content-around">
            <div class="col-md-4">
                <label class="fs-6 fw-bold fs-4">Thời điểm hoàn thành:</label>
            </div>
            <div class="col-md-8">
                <label class="fs-6 fw-bold fs-4">
                    <button action-control="upload-admission-letter-btn"
                        class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4">Tải giấy báo trúng
                        tuyển</button>
                </label>
            </div>
        </div>
        <div class="row d-flex justify-content-around">
            <div class="col-md-4">
                <input class="form-control" type="date" placeholder="Thời điểm hoàn thành">
            </div>
            <div class="col-md-8">
                <input type="file" action-control="admission-letter-input" class="d-none">
                <div class="form-control px-10">
                    @if (isset($paths) && count($paths) > 0)
                        @foreach ($paths as $path)
                            <div data-file-name="{{ basename($path) }}" data-control="admission-letter-file"
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
            container: $('[form-data="admission-letter-manager-container"]')
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
                        admissionLetterManager.load();
                    }
                });
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        admissionLetterManager.load();
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

        getUploadUrl() {
            return this.getContainer().attr('data-upload-url');
        }

        getDeleteUrl() {
            return this.getContainer().attr('data-delete-url');
        }

        getAdmissionLetterFileElements() {
            return this.getContainer().find('[data-control="admission-letter-file"]').toArray();
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

        getUpLoadAdmissionLetterBtn() {
            return this.getContainer().find('[action-control="upload-admission-letter-btn"]');
        }

        getAdmissionLetterInput() {
            return this.getContainer().find('[action-control="admission-letter-input"]');
        }

        upload() {
            const _this = this;
            const formData = new FormData();
            const csrfToken = '{{ csrf_token() }}';
            const file = this.getAdmissionLetterInput().prop('files')[0];

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
                admissionLetterManager.load();
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                        // Reload letter content
                        admissionLetterManager.load();
                    }
                });
            })
        }

        init() {
            const admissionLetterElements = this.getAdmissionLetterFileElements();

            this.createFileInstances(admissionLetterElements);
            this.events();
        }

        events() {
            const _this = this;

            _this.getUpLoadAdmissionLetterBtn().on('click', function(e) {
                e.preventDefault();

                _this.getAdmissionLetterInput().click();
            })

            _this.getAdmissionLetterInput().on('change', function(e) {
                e.preventDefault();

                _this.upload();
            })
        }
    }
</script> --}}
