

<div class="row" id="studyAbroadApplicationScreenId">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">12</span>
            </div>
            <div class="fw-semibold">
                Hồ sơ du học
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneStudyAbroadApplication() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneStudyAbroadApplication() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="study_abroad_applications" action-control="study_abroad_applications" type="button" class="badge badge-success d-none {{ $abroadApplication->isDoneStudyAbroadApplication() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
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
            <div class="col-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                <input type="date" value="{{$dayFinish->study_abroad_applications ?? ''}}" name="study_abroad_applications" class="form-control pe-none">
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 d-none">
                <a row-action="show-study-abroad-application"
                class="fs-6 fw-bold btn {{$checkFill ? 'btn-secondary': 'btn-info'}} btn-sm fs-4 w-100"
                href="{{ action(
                    [App\Http\Controllers\Sales\AbroadController::class, 'createStudyAbroadApplication'],
                    [
                        'id' => $abroadApplication->id,
                    ],
                ) }}">{{$checkFill ? 'Cập nhật' : 'Kê khai'}}</a>
            </div>
            
        </div>
    
        
        
    </div>
</div>
<script>
    $(() => {
        AdmissionLetter.init(); 
        
        UpdateStudyAbroadPopup.init();

        studyAbroadApplication = new StudyAbroadApplication({
            container: $('#studyAbroadApplicationScreenId')
        });
    });
    
    var StudyAbroadApplication = class {
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
            return this.getContainer().find('[action-control="study_abroad_applications"]');
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
                    studyAbroadApplicationManager.load();
                     
                 }).fail(message => {
                     // Xử lý khi yêu cầu thất bại
                     throw new Error(message); // In ra thông báo lỗi
                 });

         }
        
        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="study_abroad_applications"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Student\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    study_abroad_applications: loTrinhHtClValue,
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
            _this.getContainer().find('input[name="study_abroad_applications"]').on('change', function() {
                _this.dateChangedHandle();
            });
            _this.getDoneBtn().on('click', function(e) {
                e.preventDefault();
                _this.clickDoneBtn();
            })
        }
    }

    var UpdateStudyAbroadPopup = (function() {
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
            return document.querySelectorAll('[row-action="show-study-abroad-application"]');
        }
        

        return {
            init: function() {
                listContent = document.querySelector('#studyAbroadApplicationScreenId');
                if (listContent) {
                  
                    getCreateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdateStudyAbroadPopup.updateUrl(btnUrl);
                        });
                    });

                    

                    
                } else {
                    throw new Error("listContent is undefined or null.");
                }
            }
        };

        
    })();
</script>



