<div class="row" id="strategicLearningCurriculumContainer">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">1</span>
            </div>
            <div class="fw-semibold">
                Lộ trình học thuật chiến lược
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneLoTrinhHTCL() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneLoTrinhHTCL() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button action-control="lo-trinh-ht-cl" value="lo_trinh_ht_cl" type="button" class="badge badge-success d-none {{ $abroadApplication->isDoneLoTrinhHTCL() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
                        &#10004;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9" form-data="strategic-learning-curriculum-container">
        {{-- Content --}}
        <div class="row">
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <label class="fs-6 fw-bold fs-4">Thời điểm hoàn thành:</label>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <input type="date" value="{{$dayFinish->lo_trinh_ht_cl ?? ''}}" name="lo_trinh_ht_cl"class="form-control pe-none">
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-none">
                <button action-control="declare" value="lo_trinh_ht_cl" data-url="{{ action([App\Http\Controllers\Sales\AbroadController::class, 'declareStrategicLearningCurriculum'], ['id' => $abroadApplication->id]) }}" class="btn {{$checkFill ? 'btn-info': 'btn-info'}} w-100">{{$checkFill ? 'Cập nhật' : 'Kê khai'}}</button>
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <button action-control="view-declaration" data-url="{{ action([App\Http\Controllers\Sales\AbroadController::class, 'viewStrategicLearningCurriculum'], ['id' => $abroadApplication->id]) }}" class="btn btn-secondary w-100">Xem</button>
            </div>
        </div>

        </div>
    </div>

    <script>
        var strategicLearningCurriculumManager;
        var managerPopup;
    
        $(() => {
            strategicLearningCurriculumManager = new StrategicLearningCurriculumManager({
                container: $('#strategicLearningCurriculumContainer')
            });
            managerPopup = new ManagerPopup();
        })
    
        var StrategicLearningCurriculumManager = class {
            constructor(options) {
                this.container = options.container;
                
                this.init();
            }
    
            getContainer() {
                return this.container;
            }
    
            getDeclareBtn() {
                return this.getContainer().find('[action-control="declare"]');
            }
            getDoneBtn() {
                return this.getContainer().find('[action-control="lo-trinh-ht-cl"]');
            }
            getDoneUrlBtn() {
                return this.getDoneBtn().attr('data-url');
            }
    
            getDeclareUrl() {
                return this.getDeclareBtn().attr('data-url');
            }
    
            getViewDeclarationBtn() {
                return this.getContainer().find('[action-control="view-declaration"]');
            }
    
            getViewDeclarationUrl() {
                return this.getViewDeclarationBtn().attr('data-url');
            }
    
            init() {
                this.events();
            }
    
            clickDeclareHandle() {
                managerPopup.updateUrl(this.getDeclareUrl());
            }
    
            clickViewDeclarationHandle() {
                managerPopup.updateUrl(this.getViewDeclarationUrl());
            }
            // Thêm hàm xử lý khi người dùng thay đổi ngày
            dateChangedHandle() {
                var loTrinhHtClValue = this.getContainer().find('input[name="lo_trinh_ht_cl"]').val(); 
                var abroadApplicationId = '{{ $abroadApplication->id }}';

                $.ajax({
                    url: '{{ action([App\Http\Controllers\Student\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                    method: 'PUT', 
                    data: {
                        lo_trinh_ht_cl: loTrinhHtClValue,
                        abroadApplicationId:abroadApplicationId,
                        _token: '{{ csrf_token() }}'
                    },
                    }).done(response => {
                    
                        
                    }).fail(message => {
                        // Xử lý khi yêu cầu thất bại
                        throw new Error(message); // In ra thông báo lỗi
                    });

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
                        strategicLearningCurriculum.load();
                        
                    }).fail(message => {
                        // Xử lý khi yêu cầu thất bại
                        throw new Error(message); // In ra thông báo lỗi
                    });

            }
    
            events() {
                const _this = this;
    
                // Click declare
                _this.getDeclareBtn().on('click', function(e) {
                    e.preventDefault();
    
                    _this.clickDeclareHandle();
                })
    
                // Click view declaration
                _this.getViewDeclarationBtn().on('click', function(e) {
                    e.preventDefault();
    
                    _this.clickViewDeclarationHandle();
                })

                _this.getContainer().find('input[type="date"]').on('change', function() {
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
         var ManagerPopup = class {
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