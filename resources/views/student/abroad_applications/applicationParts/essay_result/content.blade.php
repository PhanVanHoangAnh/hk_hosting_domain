
<div class="row" id="essayResultScreenId" >
    <!-- Other HTML content -->
    <div class="col-md-3">
        <div class="d-flex">
            <div class="me-3">
                <span class="badge badge-info">8</span>
            </div>
            <div class="fw-semibold">
                Kết quả chấm luận
                <div class="mt-1">
                    <span class="badge badge-{{ $abroadApplication->isDoneEssayResult() ? 'success' : 'primary' }}">{{ $abroadApplication->isDoneEssayResult() ? 'Hoàn thành' : 'Chưa hoàn thành' }}</span>
                    <button value="essay_results" action-control="essay_results" type="button" class="badge badge-success d-none {{ $abroadApplication->isDoneEssayResult() ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-placement="right" title="Bấm vào đây nếu đã hoàn thành">
                        &#10004;
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-9" form-data="manager-container" >
        <div class="row">
            <div class="col-md-4">
                <label class="fs-6 fw-bold fs-4">Thời điểm hoàn thành:</label>
            </div>
         
            <div class="col-md-4">
                <label class="fs-6 fw-bold fs-4">
                    {{-- <button action-control="upload-done-btn" class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4">Upload</button> --}}
                </label>
            </div>
            
            
                
            
        </div>
        <div class="row"  >
            
            {{-- Date input --}}
            <div class="col-md-4">
                <input type="date" value="{{$dayFinish->essay_results ?? ''}}" name="essay_results" class="form-control pe-none">
            </div>
           
            <div class="col-md-4">
                <div class="form-control px-10">
                    @if (isset($paths) && count($paths) > 0)
                        @foreach ($essayResults as $essayResult)
                        @if (isset($essayResult->path))
                            <div data-file-name="{{ basename($essayResult->getPath()) }}" data-control="file" class="row my-0">
                                <div class="col-md-9 pe-0 cursor-pointer bg-secondary d-flex justify-content-start align-items-center">
                                    <span class="material-symbols-rounded">description</span>&nbsp;&nbsp;&nbsp;
                                    <a class="cursor-pointer" href="{{ $essayResult->getPath() }}" download="{{  basename($essayResult->getPath()) }}">
                                        {{ basename($essayResult->getPath()) }}
                                        <span class="material-symbols-rounded pt-2">
                                            arrow_downward
                                        </span>
                                    </a>
                                </div>
                                <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center ">
                                    <button data-delete-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'deleteEssayResultFile'], ['id' => $essayResult->id]) }}"
                                    action-control="delete" class="btn btn-danger btn-sm">Xóa</button>
                                </div>
                            </div>
                            @endif
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
             
            
               
            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2  d-none">
                <a row-action="create-esay-result" 
                class="fs-6 fw-bold btn {{$checkFill ? 'btn-secondary': 'btn-info'}}  btn-sm fs-4 w-100"
                href="{{ action(
                    [App\Http\Controllers\Student\AbroadController::class, 'createEssayResult'],
                    [
                        'id' => $abroadApplication->id,
                    ],
                ) }}">{{$checkFill ? 'Cập nhật' : 'Kê khai'}}</a>
            </div>

            <div class="col-2 col-sm-2 col-md-2 col-lg-2 col-xl-2">
                <a row-action="create-esay-result"  class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4 w-100"
                href="{{ action(
                    [App\Http\Controllers\Student\AbroadController::class, 'showEssayResult'],
                    [
                        'id' => $abroadApplication->id,
                    ],
                ) }}">Xem</a>
            </div>
                
             
            
        </div>
    </div>
</div>


<script>
    $(() => {
        EssayResult.init(); 
        
        UpdatePopupEssay.init();

        essayResultManager = new EssayResultManager({
            container: $('#essayResultScreenId')
        });
    });
    var EssayResultManager = class {
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
            return this.getContainer().find('[action-control="essay_results"]');
        }
        getName(deleteBtn) {
            return $(deleteBtn).closest('[data-control="file"]').data('file-name');
        }
        getDeleteBtn() {
            return $(this.getContainer()).find('[action-control="delete"]');
        }
        getDeleteUrl() {
            return this.getContainer().data('delete-url');
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
                    essayResult.load();
                     
                 }).fail(message => {
                     // Xử lý khi yêu cầu thất bại
                     throw new Error(message); // In ra thông báo lỗi
                 });

         }

        
        dateChangedHandle() {
            var loTrinhHtClValue = this.getContainer().find('input[name="essay_results"]').val(); 
            const abroadApplicationId = '{{ $abroadApplication->id }}';

            $.ajax({
                url: '{{ action([App\Http\Controllers\Student\AbroadApplicationFinishDayController::class, 'updateFinishDay'], ['id' => ':id']) }}'.replace(':id', abroadApplicationId),
                method: 'PUT', 
                data: {
                    essay_results: loTrinhHtClValue,
                    abroadApplicationId:abroadApplicationId,
                    _token: '{{ csrf_token() }}'
                },
                }).done(response => {
                    
                }).fail(message => {
                    // Xử lý khi yêu cầu thất bại
                    throw new Error(message); // In ra thông báo lỗi
                });

        }
        delete(fileName, deleteUrl) {
            const _this = this;

            const formData = new FormData();
            const csrfToken = '{{ csrf_token() }}'; 

            formData.append('_token', csrfToken);
            formData.append('fileName', fileName);
             
            $.ajax({
                url: deleteUrl,
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
                        essayResult.load();
                    }
                });
            }).fail(response => {
                ASTool.alert({
                    icon: 'warning',
                    message: JSON.parse(response.responseText).messages,
                    ok: () => {
                      
                       
                    }
                });
            })
        }
        deleteHandle(fileName, deleteUrl) {
            ASTool.confirm({
                icon: 'warning',
                message: "Bạn có chắc muốn xóa file bài luận này không?",
                ok: () => {
                    this.delete(fileName, deleteUrl);
                },
                cancel: () => {}
            })
        }
       
        events() {
            const _this = this;
            _this.getContainer().find('input[name="essay_results"]').on('change', function() {
                _this.dateChangedHandle();
            });
            _this.getDoneBtn().on('click', function(e) {
                e.preventDefault();
                _this.clickDoneBtn();
            })
            _this.getDeleteBtn().on('click', function(e) {
                e.preventDefault(); 
                const deleteUrl = $(this).data('delete-url');
                const fileName = _this.getName(this); 
                
                _this.deleteHandle(fileName, deleteUrl);
            })
        }
    }

    var UpdatePopupEssay = (function() {
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

    var EssayResult = (function() {
        var listContent;

        

        function getCreateBtn() {
            return document.querySelectorAll('[row-action="create-esay-result"]');
        }
        

        return {
            init: function() {
                listContent = document.querySelector('#essayResultScreenId');
                if (listContent) {
                  
                    getCreateBtn().forEach(function(btn) {
                        btn.addEventListener('click', function(e) {
                            e.preventDefault();
                            var btnUrl = btn.getAttribute('href');
                            UpdatePopupEssay.updateUrl(btnUrl);
                        });
                    });

                    

                    
                } else {
                    throw new Error("listContent is undefined or null.");
                }
            }
        };

        
    })();
</script>
