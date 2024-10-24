
<div class="row" id="cultural_orientation">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">5</span>
            </div>
            <div class="fw-semibold">
                Định hướng du học
                <div class="mt-1"> 
                    <span class="badge badge-{{ $abroadApplication->isDoneCulturalOrientation() ||isset($culturalOrientation)  ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneCulturalOrientation() || isset($culturalOrientation)  ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="cultural_orientation" action-control="cultural_orientation" type="button" class="badge badge-success {{ $abroadApplication->isDoneCulturalOrientation() || isset($culturalOrientation)  ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
                        &#10004;
                    </button>
                   
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <!--begin::details View-->
        <div class="">

            <!--begin::Card body-->
            <form id="tableCulturalOrientation" tabindex="-1">
                @csrf
                <div class="table-responsive">
                    @if($culturalOrientation)
                    <table class="table align-middle table-row-dashed fs-6 gy-5 border" id="dtHorizontalVerticalOrder">
                        <thead>
                            <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                <th class="min-w-125px text-left">Tình trạng (học văn hoá Mỹ)</th>
                                <th class="min-w-125px text-left">Học viên có cần mở tài khoản ngân hàng</th>
                                <th class="min-w-125px text-left">Học sinh cần mua sim điện thoại</th>
                                <th class="min-w-125px text-left">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600"> 
                          
                                <tr list-control="item">
                                    <td class="text-left mb-1 text-nowrap">{{ $culturalOrientation->american_cultural_education_status ? 'Hoàn thành' : 'Chưa hoàn thành' }}</td>
                                    <td class="text-left mb-1 text-nowrap">{{ $culturalOrientation->need_open_bank_account ? 'Có' : 'Không' }}</td>
                                    <td class="text-left mb-1 text-nowrap">{{ $culturalOrientation->need_buy_sim ? 'Có' : 'Không' }}</td>
                                    <td class="text-left">
                                        <a href="#"
                                            class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                            style="margin-left: 0px">
                                            Thao tác
                                            <i class="ki-duotone ki-down fs-5 ms-1"></i>
                                        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                            data-kt-menu="true">
                                            <div class="menu-item px-3">
                                                <a row-action="update-cultural-orientation"
                                                    class="menu-link px-3"
                                                    href="{{ action(
                                                        [App\Http\Controllers\Abroad\AbroadController::class, 'updateCulturalOrientation'],
                                                        ['id' => $culturalOrientation->id]
                                                    ) }}">
                                                    Cập nhật
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            
                           
                        </tbody>
                    </table>
                    
                    @endif
                        
                        <!--end::Table-->
                        @if(!$culturalOrientation)
                        <p class="fs-4 text-center mb-5 text-danger mt-10 d-none">
                            Chưa có định hướng văn hóa
                        </p>
                            <div class="d-flex justify-content-end align-items-center mt-3">
                                <!--begin::Button-->
                                <a href="{{ action(
                                    [App\Http\Controllers\Abroad\AbroadController::class, 'createCulturalOrientation'],
                                    [
                                        'id' => $abroadApplication->id,
                                    ],
                                ) }}"
                                    class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" row-action="create-cultural-orientation">
                                    <span class="material-symbols-rounded me-2">
                                        add
                                    </span>
                                    Thêm mới 
                                </a>
                                <!--end::Button-->
                            </div>
                        @endif
                </div>

            </form>
            <!--end::Card body-->
        </div>
        <!--end::details View-->
    </div>
</div>
    
    

    <script>
        var culturalOrientationManager;
        $(() => {
            CulturalOrientation.init();
            culturalOrientationManager = new CulturalOrientationManager({
                container: $('#cultural_orientation')
            });
            //Update node-log
            UpdatePopup.init();
        });
        var CulturalOrientationManager = class {
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
                return this.getContainer().find('[action-control="cultural_orientation"]');
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
                        culturalOrientations.load();
                        
                    }).fail(message => {
                        // Xử lý khi yêu cầu thất bại
                        throw new Error(message); // In ra thông báo lỗi
                    });

            }
            events() {
                const _this = this;

                _this.getDoneBtn().on('click', function(e) {
                    e.preventDefault();
                    _this.clickDoneBtn();
                })
            }
        }
        var UpdatePopup = (function() {
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

        var CulturalOrientation = (function() {
            var listContent;

            function getUpdateBtn() {
                return document.querySelectorAll('[row-action="update-cultural-orientation"]');
            }

            function getCreateBtn() {
                return document.querySelectorAll('[row-action="create-cultural-orientation"]');
            }

            return {
                init: function() {
                    listContent = document.querySelector('#tableCulturalOrientation');
                    if (listContent) {
                        getUpdateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                UpdatePopup.updateUrl(btnUrl);
                            });
                        });
                        getCreateBtn().forEach(function(btn) {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();
                                var btnUrl = btn.getAttribute('href');
                                UpdatePopup.updateUrl(btnUrl);
                            });
                        });
                    } else {
                        throw new Error("listContent is undefined or null.");
                    }
                }
            };
        })();
    </script>