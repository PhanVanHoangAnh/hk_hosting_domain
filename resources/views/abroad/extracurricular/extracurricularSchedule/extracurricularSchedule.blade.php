
<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">4</span>
            </div>
            <div class="fw-semibold">
               Kế hoạch ngoại khoá
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneExtracurricularSchedule() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneExtracurricularSchedule() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
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
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <input readonly type="date" value="{{$dayFinish->extracurricular_schedule ?? ''}}" name="extracurricular_schedule" class="form-control">
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <button action-control="extracurricular-schedule-declare" data-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'extracurricularScheduleDeclaration'], ['id' => $abroadApplication->id,]) }}" class="btn btn-info w-100">Kê khai</button>
            </div>
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <button action-control="extracurricular-schedule-show" data-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'extracurricularScheduleShow'], ['id' => $abroadApplication->id]) }}" class="btn btn-secondary w-100">Xem</button>
            </div>
        </div>

        </div>
    </div>

<script>
    var extracurricularScheduleManager;
    var extracurricularSchedulePopup;

    $(() => {
        extracurricularScheduleManager = new ExtracurricularScheduleManager({
            container: $('[form-data="extracurricular-plan-manager-container"]')
        });
        extracurricularSchedulePopup = new ExtracurricularSchedulePopup();
    })

    var ExtracurricularScheduleManager = class {
        constructor(options) {
            this.container = options.container;
            
            this.init();
        }

        getContainer() {
            return this.container;
        }

        getDeclareBtn() {
            return this.getContainer().find('[action-control="extracurricular-schedule-declare"]');
        }

        getDeclareUrl() {
            return this.getDeclareBtn().attr('data-url');
        }

        getViewDeclarationBtn() {
            return this.getContainer().find('[action-control="extracurricular-schedule-show"]');
        }

        getViewDeclarationUrl() {
            return this.getViewDeclarationBtn().attr('data-url');
        }

        init() {
            this.events();
        }

        clickDeclareHandle() {
            extracurricularSchedulePopup.updateUrl(this.getDeclareUrl());
        }

        clickViewDeclarationHandle() {
            extracurricularSchedulePopup.updateUrl(this.getViewDeclarationUrl());
        }
        
        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="extracurricular_schedule"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Abroad\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    extracurricular_schedule: loTrinhHtClValue,
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

            _this.getContainer().find('input[name="extracurricular_schedule"]').on('change', function() {
                _this.dateChangedHandle();
            });
        }
    }

    /**
     * Popup to create or edit
     */
     var ExtracurricularSchedulePopup = class {
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










































