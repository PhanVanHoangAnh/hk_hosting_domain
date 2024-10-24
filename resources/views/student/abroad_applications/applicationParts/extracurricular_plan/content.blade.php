
<div class="row" id="extracurricular-plan-manager-container">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">2</span>
            </div>
            <div class="fw-semibold">
                Lộ trình hoạt động ngoại khóa
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneLoTrinhHDNK() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneLoTrinhHDNK() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="lo_trinh_hd_nk" action-control="lo-trinh-hd-nk" type="button" class="badge badge-success d-none {{ $abroadApplication->isDoneLoTrinhHDNK() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
                        &#10004;
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9" form-data="extracurricular-plan-manager-container">
        {{-- Content --}}
        <div class="row">
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <label class="fs-6 fw-bold fs-4">Thời điểm hoàn thành:</label>
            </div>
        </div>

        <div class="row">
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <input type="date" value="{{$dayFinish->lo_trinh_hd_nk ?? ''}}" name="lo_trinh_hd_nk" class="form-control pe-none">
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-none">
                <button action-control="declare" data-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'declareExtracurricularPlan'], ['id' => $abroadApplication->id]) }}" class="btn {{$checkFill ? 'btn-info': 'btn-info'}} w-100">{{$checkFill ? 'Cập nhật' : 'Kê khai'}}</button>
            </div>
           
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <button action-control="view-declaration" data-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'viewExtracurricularPlanDeclaration'], ['id' => $abroadApplication->id]) }}" class="btn btn-secondary w-100">Xem</button>
            </div>
        </div>

        </div>
    </div>

<script>
    var extracurricularPlanManager;
    var managerPopup;

    $(() => {
        extracurricularPlanManager = new ExtracurricularPlanManager({
            container: $('#extracurricular-plan-manager-container')
        });
        managerPopup = new ManagerPopup();
    })

    var ExtracurricularPlanManager = class {
        constructor(options) {
            this.container = options.container;
            
            this.init();
        }

        getContainer() {
            return this.container;
        }
        getDoneBtn() {
            return this.getContainer().find('[action-control="lo-trinh-hd-nk"]');
        }

        getDeclareBtn() {
            return this.getContainer().find('[action-control="declare"]');
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
                        extracurricularPlan.load();
                        
                    }).fail(message => {
                        // Xử lý khi yêu cầu thất bại
                        throw new Error(message); // In ra thông báo lỗi
                    });

            }
        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="lo_trinh_hd_nk"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Student\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    lo_trinh_hd_nk: loTrinhHtClValue,
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

            _this.getContainer().find('input[name="lo_trinh_hd_nk"]').on('change', function() {
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