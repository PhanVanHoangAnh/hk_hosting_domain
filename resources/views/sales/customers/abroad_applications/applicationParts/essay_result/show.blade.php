@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Kết quả chấm luận
@endsection
@php
    $createSocialNetwork = 'createSocialNetwork_' . uniqid();
@endphp

@section('content')
    <!--begin::Card body-->
    <form id="popupCreateAbroadUniqId" tabindex="-1">
        @csrf
        <div class="scroll-y pe-7 py-10 px-lg-17" >
            @if ($essayResults->count())
            <div class="table-responsive">

                <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                    <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th class="text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trường
                                    </span>
                                </span>
                            </th>
                            <th class=" text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Nội dung bài luận
                                    </span>
                                </span>
                            </th>
                            <th class="text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Bài luận
                                    </span>
                                </span>
                            </th>
                            <th class="text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Số từ
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Phân loại
                                    </span>
                                </span>
                            </th>
                            <th class=" text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Quality of Content 
                                    </span>
                                </span>
                            </th>
                            <th class=" text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Execution
                                    </span>
                                </span>
                            </th>
                            <th class="text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Personal Voice
                                    </span>
                                </span>
                            </th>
                            <th class=" text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Overall 
                                    </span>
                                </span>
                            </th>
                            <th class="text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thao tác 
                                    </span>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @foreach ($essayResults as $essayResult)
                            <tr list-control="item">
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $essayResult->school->name }}
                                </td>
                                <td class="min-w-175px text-left mb-1 text-nowrap">
                                    @if(isset($essayResult->path) && $essayResult->path !== 'undefined')
                                    <div data-file-name="{{ basename($essayResult->path) }}" data-control="active-file" class="row my-0">
                                        <div class="col-md-9 pe-0 cursor-pointer d-flex justify-content-start align-items-center"> 
                                            <a class="btn btn-sm  btn-flex btn-left btn-active-light-default cursor-pointer" href="{{ $essayResult->getPath() }}" download="{{  basename($essayResult->path) }}">
                                                {{ $essayResult->path  }}
                                                <span class="material-symbols-rounded ">
                                                arrow_downward
                                            </span>
                                            </a>
                                        </div>
                                        <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center">
                                            <button data-delete-url="{{ action([App\Http\Controllers\Sales\AbroadController::class, 'deleteEssayResultFile'], ['id' => $essayResult->id]) }}"
                                                action-control="delete" class="btn btn-danger btn-sm">Xóa</button>
                                        </div>
                                        
                                    </div>
                                        
                                    @else
                                        <span>Chưa có</span>
                                    @endif
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $essayResult->content }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $essayResult->word_count }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $essayResult->classification }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $essayResult->quality_of_content }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $essayResult->execution }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $essayResult->personal_voice }}
                                </td>
                                <td class="text-left mb-1 text-nowrap">
                                    {{ $essayResult->overall }}
                                </td>
                                <td class="text-left">
                                    <a href="#"
                                        class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                        style="margin-left: 0px">
                                        Thao tác
                                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>

                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                        data-kt-menu="true">
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3" row-action="delete-esay-result" 
                                            class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\AbroadController::class, 'deleteEssayResult'],
                                                [
                                                    'id' => $essayResult->id,
                                                ],
                                            ) }}">Xóa</a>
                                        </div>
                                        <div class="menu-item px-3">
                                            <a class="menu-link px-3" row-action="update-esay-result" 
                                            class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4"
                                            href="{{ action(
                                                [App\Http\Controllers\Sales\AbroadController::class, 'editEssayResult'],
                                                [
                                                    'id' => $essayResult->id,
                                                ],
                                            ) }}">Chỉnh sửa</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>

                <!--end::Table-->
            </div>
            @else
            <div class="py-15">
                <div class="text-center mb-7">
                    <svg style="width:120px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.8 173.8">
                        <g style="isolation:isolate">
                            <g id="Layer_2" data-name="Layer 2">
                                <g id="layer1">
                                    <path
                                        d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z"
                                        style="fill:#cdcdcd" />
                                    <path
                                        d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z"
                                        style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2" />
                                    <path d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z"
                                        style="fill:#f5f5f5" />
                                    <rect x="31.7" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="73.6" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="115.5" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="31.7" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="73.6" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <rect x="115.5" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                    <path d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                        style="fill:#dbdbdb" />
                                    <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                        style="fill:#f5f5f5" />
                                    <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z" style="fill:#f5f5f5" />
                                    <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z" style="fill:#f5f5f5" />
                                    <rect x="32.1" y="29.8" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                    <rect x="32.1" y="36.7" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                    <rect x="73.3" y="96.7" width="10.1" height="8.42"
                                        transform="translate(-38.3 152.9) rotate(-76.2)" style="fill:#595959" />
                                    <path
                                        d="M94.4,35.7a33.2,33.2,0,1,0,24.3,40.1A33.1,33.1,0,0,0,94.4,35.7ZM80.5,92.2a25,25,0,1,1,30.2-18.3A25.1,25.1,0,0,1,80.5,92.2Z"
                                        style="fill:#f8a11f" />
                                    <path
                                        d="M57.6,154.1c-.7,2.8,2,5.9,6,6.9h0c4,1,7.9-.5,8.6-3.3l11.4-46.6c.7-2.8-2-5.9-6-6.9h0c-4.1-1-7.9.5-8.6,3.3Z"
                                        style="fill:#253f8e" />
                                    <path d="M62.2,61.9A25,25,0,1,1,80.5,92.2,25,25,0,0,1,62.2,61.9Z"
                                        style="fill:#fff;mix-blend-mode:screen;opacity:0.6000000000000001" />
                                    <path
                                        d="M107.6,72.9a12.1,12.1,0,0,1-.5,1.8A21.7,21.7,0,0,0,65,64.4a11.6,11.6,0,0,1,.4-1.8,21.7,21.7,0,1,1,42.2,10.3Z"
                                        style="fill:#dbdbdb" />
                                    <path
                                        d="M54.3,60A33.1,33.1,0,0,0,74.5,98.8l-1.2,5.3c-2.2.4-3.9,1.7-4.3,3.4L57.6,154.1c-.7,2.8,2,5.9,6,6.9L94.4,35.7A33.1,33.1,0,0,0,54.3,60Z"
                                        style="fill:#dbdbdb;mix-blend-mode:screen;opacity:0.2" />
                                </g>
                            </g>
                        </g>
                    </svg>
                </div>
                <p class="fs-4 text-center mb-5">
                    Không có kết quả!
                </p>
                
            </div>
        @endif
        </div>
    </form>
    <!--end::Card body-->


<script>
   
    $(function() {

        DeletePopup.init();

        UpdateEssayResult.init();

        UpdatePopupEssayResult.init();

        essayResultManager = new EssayResultManager({
            container: $('#popupCreateAbroadUniqId')
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
        
        getName(deleteBtn) {
            return $(deleteBtn).closest('[data-control="file"]').data('file-name');
        }
        getDeleteBtn() {
            return $(this.getContainer()).find('[action-control="delete"]');
        }
        getDeleteUrl() {
            return this.getContainer().data('delete-url');
        }
       
        delete(fileName, deleteUrl) {
             
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
                UpdatePopupEssay.getUpdatePopup().hide();
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
           
            _this.getDeleteBtn().on('click', function(e) {
                e.preventDefault(); 
                const deleteUrl = $(this).data('delete-url');
                const fileName = _this.getName(this); // Call getFileName() using _this
                
                _this.deleteHandle(fileName, deleteUrl);
            })
        }
    }
    var UpdatePopupEssayResult = (function() {
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
    var UpdateEssayResult = function() {

        return {
            init: () => {
                var buttonsUpdateEssayResult = document.querySelectorAll('[row-action="update-esay-result"]'); 
                buttonsUpdateEssayResult.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var editUrl = this.getAttribute('href');
                        UpdatePopupEssayResult.updateUrl(editUrl);
                    });
                });
            },
            getUpdatePopup: () => {
                return updatePopups;
            },
        };
        }();
    var DeletePopup = function() {
        var deleteEssayResult = function(url) {
            ASTool.confirm({
                message: 'Bạn có chắc chắn muốn xóa kết quả này?',
                ok: function() {
                    $.ajax({
                        url: url,
                        method: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                        
                        },
                    }).done((response) => {
                        UpdatePopupEssay.getUpdatePopup().hide();
                        ASTool.alert({
                            icon: 'success',
                            message: response.messages,
                            ok: () => {
                                // Reload letter content
                                essayResult.load();
                                
                            }
                        });
                    }).fail(function() {
                        
                    });
                }
            });
        };

        return {
            init: () => {
                var deleteButtons = document.querySelectorAll('[row-action="delete-esay-result"]');
                deleteButtons.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var deleteUrl = this.getAttribute('href');
                        
                        deleteEssayResult(deleteUrl);
                    });
                });
            }
        };
    }();
</script>
@endsection
