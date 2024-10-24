
<div class="row">
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">4</span>
            </div>
            <div class="fw-semibold">
                Nộp hồ sơ
                <div class="mt-1"> 
                    <span class="badge badge-primary">Chưa hoàn thành </span>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9">
        <div class="">

            <!--begin::Card body-->
            <form  id="tableApplicationSubmission" tabindex="-1">
                @csrf
                <div class="table-responsive">
                    @if(!$applicationSubmissions->isEmpty())
                    <table class="table align-middle table-row-dashed fs-6 gy-5 bordered"
                        id="dtHorizontalVerticalOrder">
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
                                        Kết quả
                                        </span>
                                    </span>
                                </th>
                                <th class="min-w-125px text-left">
                                    <span class="d-flex align-items-center">
                                        <span>
                                        Upload 
                                        </span>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @foreach ($applicationSubmissions as $applicationSubmission)
                            <tr>
                                <td class="text-left mb-1 text-nowrap">
                                    {{$applicationSubmission->school->name}}
                                </td>
                                <td class="text-left mb-1 text-nowrap"> 
                                    
                                    {{ date('d/m/Y', strtotime($applicationSubmission->deadline)) }}
                                </td>
                                <td class="text-left mb-1 text-nowrap"> 
                                    {{ $applicationSubmission->completion_time ? date('d/m/Y', strtotime($applicationSubmission->completion_time)) : 'Chưa hoàn thành' }}
                                </td>
                                
                                <td class="min-w-125px text-left">
                                    <span class="d-flex align-items-center">
                                        @if(isset($applicationSubmission->path) && $applicationSubmission->path !== 'undefined')
                                        <div data-file-name="{{ basename($applicationSubmission->path) }}" data-control="active-file" class="row my-0">
                                            <div class="col-md-9 pe-0 cursor-pointer d-flex justify-content-start align-items-center"> 
                                                <a class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default cursor-pointer" href="{{ $applicationSubmission->getPath() }}" download="{{  basename($applicationSubmission->path) }}">
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
                                        <a row-action="update-application-submission" class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                        href="{{ action(
                                            [App\Http\Controllers\Sales\AbroadController::class, 'editApplicationSubmission'],
                                            [
                                                'id' => $applicationSubmission->id,
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
                            [App\Http\Controllers\Sales\AbroadController::class, 'createApplicationSubmission'],
                            [
                                'id' => $abroadApplication->id,
                            ],
                        ) }}"
                            class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px" row-action="create-application-submission">
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
        ApplicationSubmission.init();
        //Update node-log
        UpdatePopup.init();
    });

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

    var ApplicationSubmission = (function() {
        var listContent;

        function getUpdateBtn() {
            return document.querySelectorAll('[row-action="update-application-submission"]');
        }

        function getCreateBtn() {
            return document.querySelectorAll('[row-action="create-application-submission"]');
        }

        return {
            init: function() {
                listContent = document.querySelector('#tableApplicationSubmission');
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