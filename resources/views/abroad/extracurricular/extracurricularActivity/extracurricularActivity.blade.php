
<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">6</span>
            </div>
            <div class="fw-semibold">
               Hoạt động ngoại khoá
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneExtracurricularActivity() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneExtracurricularActivity() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
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
                <input type="date" readonly value="{{$dayFinish->extracurricular_activity ?? ''}}" name="extracurricular_activity" class="form-control">
            </div>
            {{-- <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <button action-control="extracurricular-activity-declare" data-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'extracurricularActivityDeclaration'], ['id' => $abroadApplication->id,]) }}" class="btn btn-info w-100">Kê khai</button>
            </div> --}}
            <div class="col-4 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                <button action-control="extracurricular-activity-show" data-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'extracurricularActivityShow'], ['id' => $abroadApplication->id]) }}" class="btn btn-secondary w-100">Xem</button>
            </div>
        </div>

        </div>
    </div>

<script>
    var extracurricularPlanManager;
    var extracurricularActivityPopup;

    $(() => {
        extracurricularPlanManager = new ExtracurricularPlanManager({
            container: $('[form-data="extracurricular-plan-manager-container"]')
        });
        extracurricularActivityPopup = new ExtracurricularActivityPopup();
    })

    var ExtracurricularPlanManager = class {
        constructor(options) {
            this.container = options.container;
            
            this.init();
        }

        getContainer() {
            return this.container;
        }

        getDeclareBtn() {
            return this.getContainer().find('[action-control="extracurricular-activity-declare"]');
        }

        getDeclareUrl() {
            return this.getDeclareBtn().attr('data-url');
        }

        getViewDeclarationBtn() {
            return this.getContainer().find('[action-control="extracurricular-activity-show"]');
        }

        getViewDeclarationUrl() {
            return this.getViewDeclarationBtn().attr('data-url');
        }

        init() {
            this.events();
        }

        clickDeclareHandle() {
            extracurricularActivityPopup.updateUrl(this.getDeclareUrl());
        }

        clickViewDeclarationHandle() {
            extracurricularActivityPopup.updateUrl(this.getViewDeclarationUrl());
        }

        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="extracurricular_activity"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Abroad\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    extracurricular_activity: loTrinhHtClValue,
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

            _this.getContainer().find('input[name="extracurricular_activity"]').on('change', function() {
                _this.dateChangedHandle();
            });
        }
    }

    /**
     * Popup to create or edit
     */
     var ExtracurricularActivityPopup = class {
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










































