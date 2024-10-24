
<div class="row" id="applicationFeesId">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">15</span>
            </div>
            <div class="fw-semibold">
                Đóng phí hồ sơ và xác nhận dự tuyển
                <div class="mt-1"> 
                    <span class="badge badge-{{ $abroadApplication->isDoneApplicationFee() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneApplicationFee() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="application_fees" action-control="application_fees" type="button" class="badge badge-success d-none {{ $abroadApplication->isDoneApplicationFee() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
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
                <input type="date" value="{{$dayFinish->application_fees ?? ''}}" name="application_fees" class="form-control pe-none">
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 text-center d-none">
                <a href="{{ action(
                    [App\Http\Controllers\Sales\AbroadController::class, 'payAndConfirm'],
                    [
                        'id' => $abroadApplication->id,
                    ],
                ) }}"
                    class="btn {{$checkFill ? 'btn-info': 'btn-info'}} w-100" row-action="pay-and-confirm">
                    
                    {{$checkFill ? 'Cập nhật' : 'Kê khai'}}
                </a>
                
            </div>
            <div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3 text-center">
                <a href="{{ action(
                    [App\Http\Controllers\Sales\AbroadController::class, 'showPayAndConfirm'],
                    [
                        'id' => $abroadApplication->id,
                    ],
                ) }}"
                    class="btn btn-info w-100" row-action="show-pay-and-confirm">
                    
                   Xem
                </a>
                
            </div>
            
        </div>

        </div>
    </div>
    <div class="col-md-10 d-none">
        <div class="">

            <!--begin::Card body-->
            <form id="tableApplicationFee" tabindex="-1">
                @csrf
                <div class="table-responsive">
                    
                    @if(!$applicationFees->isEmpty())
                    <table class="table align-middle table-row-dashed fs-6 gy-5 border" id="dtHorizontalVerticalOrder">
                        <thead>
                            <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                    <th class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            <span>
                                            Trường 
                                            </span>
                                        </span>
                                    </th>
                                    <th class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            <span>
                                            Deadline
                                            </span>
                                        </span>
                                    </th>
                                    <th class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            <span>
                                            Thời điểm hoàn thành
                                            </span>
                                        </span>
                                    </th>
                                    <th class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            <span>
                                            Số tiền
                                            </span>
                                        </span>
                                    </th>
                                    <th class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            <span>
                                            Xem bill
                                            </span>
                                        </span>
                                    </th>
                                    <th class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            <span>
                                            Upload bill
                                            </span>
                                        </span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                
                                @foreach ($applicationFees as $applicationFee)
                                <tr>
                                    <td class="text-left mb-1 text-nowrap">
                                        {{$applicationFee->school->name}}
                                    </td>
                                    <td class="text-left mb-1 text-nowrap"> 
                                        
                                        {{ date('d/m/Y', strtotime($applicationFee->deadline)) }}
                                    </td>
                                    <td class="text-left mb-1 text-nowrap"> 
                                        {{ $applicationFee->completion_time ? date('d/m/Y', strtotime($applicationFee->completion_time)) : 'Chưa hoàn thành' }}
                                    </td>
                                    <td class="text-left mb-1 text-nowrap">
                                        {{ App\Helpers\Functions::formatNumber($applicationFee->amount) }}₫
                                    </td>
                                    <td class="min-w-125px text-left">
                                        <span class="d-flex align-items-center">
                                            @if(isset($applicationFee->path) && $applicationFee->path !== 'undefined')
                                            <div data-file-name="{{ basename($applicationFee->path) }}" data-control="active-file" class="row my-0">
                                                <div class="col-md-9 pe-0 cursor-pointer d-flex justify-content-start align-items-center"> 
                                                    <a class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default cursor-pointer" href="{{ $applicationFee->getPath() }}" download="{{  basename($applicationFee->path) }}">
                                                        Xem bill
                                                        <span class="material-symbols-rounded ">
                                                        arrow_downward
                                                    </span>
                                                    </a>
                                                </div>
                                                
                                            </div>
                                                
                                            @else
                                                <span>Chưa có</span>
                                            @endif

                                        </span>
                                    </td>
                                    <td class="min-w-125px text-left">
                                        <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center">
                                            <a row-action="update-application-fee" class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\AbroadController::class, 'editApplicationFee'],
                                                [
                                                    'id' => $applicationFee->id,
                                                ],
                                            ) }}">Chỉnh sửa</a>
                                        </div>
                                    </td>
                                    
                                    
                                </tr>
                            @endforeach
                                
                            </tbody>
                        </table>
                    @endif
                        
                        
                    <div class="d-flex justify-content-end align-items-center mt-3">
                        <!--begin::Button-->
                        <a href="{{ action(
                            [App\Http\Controllers\Sales\AbroadController::class, 'createApplicationFee'],
                            [
                                'id' => $abroadApplication->id,
                            ],
                        ) }}"
                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" row-action="create-application-fee">
                            <span class="material-symbols-rounded me-2">
                                add
                            </span>
                            Thêm
                        </a>
                        <!--end::Button-->
                    </div>
                        
                </div>

            </form>
            <!--end::Card body-->
        </div>
    </div>
</div>

<script>
    $(() => {
        ApplicationFee.init();
        //Update node-log
        UpdatePopupPayAngConfirm.init();

        applicationFees = new ApplicationFees({
            container: $('#applicationFeesId')
        });
    });
    var ApplicationFees = class {
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
            return this.getContainer().find('[action-control="application_fees"]');
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
                    applicationFeeManager.load();
                     
                 }).fail(message => {
                     // Xử lý khi yêu cầu thất bại
                     throw new Error(message); // In ra thông báo lỗi
                 });

         }
        
        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="application_fees"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Student\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    application_fees: loTrinhHtClValue,
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
            _this.getContainer().find('input[name="application_fees"]').on('change', function() {
                _this.dateChangedHandle();
            });
            _this.getDoneBtn().on('click', function(e) {
                e.preventDefault();
                _this.clickDoneBtn();
            })
        }
    }

    var UpdatePopupPayAngConfirm = (function() {
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

    var ApplicationFee = (function() {
        var listContent;

        function getUpdateBtn() {
            return document.querySelectorAll('[row-action="update-application-fee"]');
        }

        function getCreateBtn() {
            return document.querySelectorAll('[row-action="create-application-fee"]');
        }
        function getPayAndConfirmBtn() {
            return document.querySelector('[row-action="pay-and-confirm"]');
        }
        function getShowPayAndConfirmBtn() {
            return document.querySelector('[row-action="show-pay-and-confirm"]');
        }
        return {
            init: function() {
                listContent = document.querySelector('#tableApplicationFee');
                if (listContent) {
                    getUpdateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdatePopupPayAngConfirm.updateUrl(btnUrl);
                        });
                    });
                    getCreateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdatePopupPayAngConfirm.updateUrl(btnUrl);
                        });
                    });
                    
                    getPayAndConfirmBtn().addEventListener('click', function(e) {
                        e.preventDefault();
                        var btnUrl = this.getAttribute('href');
                        UpdatePopupPayAngConfirm.updateUrl(btnUrl);
                    });
                    getShowPayAndConfirmBtn().addEventListener('click', function(e) {
                        e.preventDefault();
                        var btnUrl = this.getAttribute('href');
                        UpdatePopupPayAngConfirm.updateUrl(btnUrl);
                    });
                    
                } else {
                    throw new Error("listContent is undefined or null.");
                }
            }
        };
    })();
</script>