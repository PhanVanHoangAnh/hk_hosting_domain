
<div class="row" id="application-school-manager-container">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">3</span>
            </div>
            <div class="fw-semibold">
                Danh sách trường, yêu cầu tuyển sinh
                <div class="mt-1">
                    {{-- <span class="badge badge-{{ $abroadApplication->isDoneApplicationSchool() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneApplicationSchool() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span> --}}
                    <span class="badge badge-{{ $abroadApplication->isDoneApplicationSchool() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneApplicationSchool() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="application_school" action-control="application_school" type="button" class="badge badge-success d-none {{ $abroadApplication->isDoneApplicationSchool() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
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
                <input type="date" value="{{$dayFinish->application_school ?? ''}}" name="application_school" class="form-control pe-none">
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-none">
                <button action-control="application-school-declare" data-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'applicationSchoolDeclaration'], ['id' => $abroadApplication->id,]) }}" class="btn {{$checkFill ? 'btn-info': 'btn-info'}} w-100">{{$checkFill ? 'Cập nhật' : 'Kê khai'}}</button>
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                <button action-control="application-school-show" data-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'applicationSchoolShow'], ['id' => $abroadApplication->id]) }}" class="btn btn-secondary w-100">Xem</button>
            </div>
        </div>

        </div>
    </div>

<script>
    var applicationSchoolsManager;
    var applicationSchoolPopup;

    $(() => {
        applicationSchoolsManager = new ApplicationSchoolsManager({
            container: $('#application-school-manager-container')
        });
        applicationSchoolPopup = new CertificationsPopup();
    })

    var ApplicationSchoolsManager = class {
        constructor(options) {
            this.container = options.container;
            
            this.init();
        }

        getContainer() {
            return this.container;
        }

        getDeclareBtn() {
            return this.getContainer().find('[action-control="application-school-declare"]');
        }
        getDoneBtn() {
            return this.getContainer().find('[action-control="application_school"]');
        }

        getDeclareUrl() {
            return this.getDeclareBtn().attr('data-url');
        }

        getViewDeclarationBtn() {
            return this.getContainer().find('[action-control="application-school-show"]');
        }

        getViewDeclarationUrl() {
            return this.getViewDeclarationBtn().attr('data-url');
        }

        init() {
            this.events();
        }

        clickDeclareHandle() {
            applicationSchoolPopup.updateUrl(this.getDeclareUrl());
        }

        clickViewDeclarationHandle() {
            applicationSchoolPopup.updateUrl(this.getViewDeclarationUrl());
        }

        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="application_school"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Student\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    application_school: loTrinhHtClValue,
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
                    applicationSchoolManager.load();
                     
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
            _this.getContainer().find('input[name="application_school"]').on('change', function() {
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
     var CertificationsPopup = class {
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






















