@extends('layouts.main.popup',['size' => 'full',])

@section('title')
    Kết quả dự tuyển
@endsection
@php
    $createSocialNetwork = 'createSocialNetwork_' . uniqid();
@endphp
@section('content')
    <!--begin::Card body-->

    <form id="{{$createSocialNetwork}}" tabindex="-1" 
    action="{{ action(
        [App\Http\Controllers\Student\AbroadController::class, 'doneCreateRecruitmentResults'],
        [
            'id' => $abroadApplication->id,
        ],
    ) }}">
        @csrf
        <div class="pe-7 py-10 px-lg-17" >
            <div class="table-responsive">

                <table class="table align-middle table-row-dashed fs-6 gy-5 border" id="dtHorizontalVerticalOrder">
                    <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Phân loại
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên trường
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Học bổng
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Xác nhận học bổng
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Kết quả (Đậu\Trượt)
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Xác nhận dự tuyển
                                    </span>
                                </span>
                            </th>
                           
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Theo học
                                    </span>
                                </span>
                            </th>
                           
                        </tr>
                    </thead>
                    <tbody class="text-gray-600" form-data="manager-pay-and-confirm-container">
                        
                        
                        @foreach (\App\Models\ApplicationSchool::getAllType() as $type)
                            <tr>
                                <td rowspan="{{ count($applicationSchools->where('type', $type)) + 1 }}" class="text-left mb-1 text-nowrap"> {{ trans('messages.application_school.type.' . $type) }}</td>
                            </tr>
                            
                            @foreach ($applicationSchools->where('type', $type) as $applicationSchool)
                                <input type="hidden" name="applicationSchool" value="{{$applicationSchool->id}}">

                                <tr list-control="item">
                                    
                                    <td class="text-left mb-1 text-nowrap">{{ $applicationSchool->school ? $applicationSchool->school->name :'--'  }}</td>
                                    <td class="text-left mb-1 text-nowrap">
                                        <input type="text" value="{{$applicationSchool->scholarship}}" class="form-control" id="price-input" list-action='format-number' name="scholarship" placeholder="Số tiền"
                                        required />
                                    </td>
                                   

                                    <td class="text-left mb-1 text-nowrap">
                                        @if(isset($applicationSchool->scholarship_file) )
                                            <div data-file-name="{{ basename($applicationSchool->scholarship_file) }}" data-control="active-file" class="row my-0">
                                                <div class="col-md-9 pe-0 cursor-pointer d-flex justify-content-start align-items-center"> 
                                                    <a class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default cursor-pointer" href="{{ $applicationSchool->getPathOfScholarshipFile() }}" download="{{  basename($applicationSchool->scholarship_file) }}">
                                                        {{$applicationSchool->scholarship_file}}
                                                        <span class="material-symbols-rounded ">
                                                        arrow_downward
                                                    </span>
                                                    </a>
                                                </div>
                                                <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center">
                                                    <button class="btn btn-danger btn-sm delete-btn"
                                                    data-delete-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'deleteScholarshipFile'], ['id' => $applicationSchool->id]) }}"
                                                    class="btn btn-danger btn-sm">Xóa</button>
                                                </div>
                                                
                                            </div>
                                                
                                        @else
                                            <div form-data="fee_paid" data-application-id="{{ $applicationSchool->id }}">
                                                <input type="file" name="scholarship_file" action-control="file-confirmation-{{$applicationSchool->id}}-input" class="d-none">
                                                <button action-control="upload-file-fee-paid-{{$applicationSchool->id}}-btn" class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4 upload-btn"
                                                        data-upload-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'storeScholarshipFile'], ['id' => $applicationSchool->id]) }}">
                                                    Upload
                                                </button>
                                            
                                            </div>
                                        @endif
                                        
                                    </td>
                                    <td class="text-left mb-1 text-nowrap">
                                       
                                        <input list-action="check-item" class="form-check-input" type="radio" value="1" name="result-{{$applicationSchool->id}}" {{ $applicationSchool->result === 'true' ? 'checked' : '' }}>
                                        <span class="me-5">Đậu</span>
                                        <input list-action="check-item" class="form-check-input" type="radio" value="0" name="result-{{$applicationSchool->id}}" {{ $applicationSchool->result === 'false' ? 'checked' : '' }}>
                                        <span>Trượt</span>

                                        {{-- <input  list-action="check-item" class="form-check-input" data-bs-toggle="tooltip" data-bs-placement="right" title="Tích chọn nếu đậu" type="checkbox" name='result' {{ !empty($applicationSchool->result) ? 'checked' : '' }}> --}}
                                    </td>
                        
                                    <td class="text-left mb-1 text-nowrap">
                                        @if(isset($applicationSchool->file_confirmation) )
                                            <div data-file-name="{{ basename($applicationSchool->file_confirmation) }}" data-control="active-file" class="row my-0">
                                                <div class="col-md-9 pe-0 cursor-pointer d-flex justify-content-start align-items-center"> 
                                                    <a class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default cursor-pointer" href="{{ $applicationSchool->getPathOfConfimationFile() }}" download="{{  basename($applicationSchool->file_confirmation) }}">
                                                        {{$applicationSchool->file_confirmation}}
                                                        <span class="material-symbols-rounded ">
                                                        arrow_downward
                                                    </span>
                                                    </a>
                                                </div>
                                                <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center">
                                                    <button class="btn btn-danger btn-sm delete-btn"
                                                    data-delete-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'deleteFileComfirmation'], ['id' => $applicationSchool->id]) }}"
                                                    class="btn btn-danger btn-sm">Xóa</button>
                                                </div>
                                                
                                            </div>
                                                
                                        @else
                                            <div form-data="confirmation" data-application-id="{{ $applicationSchool->id }}">
                                                <input type="file" name="file_confirmation" action-control="file-confirmation-{{$applicationSchool->id}}-input" class="d-none">
                                                <button action-control="upload-file-confirmation-{{$applicationSchool->id}}-btn" class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4 upload-btn"
                                                        data-upload-url="{{ action([App\Http\Controllers\Student\AbroadController::class, 'storeFileConfirmation'], ['id' => $applicationSchool->id]) }}">
                                                    Upload
                                                </button>
                                              
                                            </div>
                                        @endif
                                        
                                    </td>
                                    <td>
                                        <input name="study" data-section-id="" data-student-id="" list-action="check-item" class="form-check-input" type="radio" value="studied" {{ !empty($applicationSchool->study) ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                
                <div class="d-flex bd-highlight">
                    <div class="p-2 flex-grow-1 bd-highlight">
                       
                    </div>
                    <div class="p-2 bd-highlight d-none">
                        
                            <button id="CreateRecruitmentResultsButton" type="submit" class="btn btn-info btn-outline-secondary btn-sm fw-bold border-0 fs-6 h-40px">
                                <span class="indicator-label">Lưu tạm</span>
                                <span class="indicator-progress">Đang xử lý...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                    </div>


                   


                    <div class="p-2 bd-highlight">
                        <a href="{{ action(
                            [App\Http\Controllers\Student\AbroadController::class, 'updateActiveRecruitmentResults'],
                            [
                                'id' => $abroadApplication->id,
                            ],
                        ) }}"
                            class="btn btn-primary btn-outline-secondary btn-sm fw-bold border-0 fs-6 h-40px"
                            row-action="update-status-recruitment-results">
                            Hoàn thành
                        </a>
                    </div>
                </div>
                <!--end::Table-->
                <div id="error-message" class="error-message text-danger" style="display: none;"></div>

               
                {{-- <div class="d-flex justify-content-start align-items-center mt-3">
                    <span>
                        <!--begin::Button-->
                       
                        <!--end::Button-->
                    </span>
                    <span class="d-flex justify-content-end align-items-center">
                        <!--begin::Button-->
                        
                        <!--end::Button-->
                    </span>
                </div> --}}


            </div>
        </div>
    </form>
    <!--end::Card body-->

    <script>
        var manager;
    
        $(() => {
            manager = new Manager({
                container: $('[form-data="manager-pay-and-confirm-container"]')
            });
            initializePriceInput.init();
            createRecruitmentResults.init();
        });

        var createRecruitmentResults = function() {
            let form;
            let submitBtn;

            function hasSelectSchool() {
                const selectSchool = document.querySelector('[name="school"]').value;
                
                return selectSchool == '';
            }
            function hasSelectType() {
                const selectType = document.querySelector('[name="type_school"]').value;

                return selectType == '';
            }
            function getUpdateStatusRecruitmentResults() {
                return document.querySelectorAll('[row-action="update-status-recruitment-results"]');
            }

            const handleFormSubmit = () => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    submit();
                })
                getUpdateStatusRecruitmentResults().forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        submit();
                        var btnUrl = btn.getAttribute('href');
                        submitStatusRecruitmentResults(btnUrl);
                    });
                });
            }
            submitStatusRecruitmentResults =(btnUrl) =>{
               
                    var url = btnUrl;
                    
                    $.ajax({
                        url: url,
                        method: 'PUT',
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                    }).done(response => {
                        // applicationSchoolPopup.getPopup().hide();
                        UpdatePopupRecruitmentResults.getUpdatePopup().hide();
                        // success alert
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                // applicationSchoolManager.load();
                                admissionLetterManager.load();
                            }
                        });

                    }).fail(message => {
                        // UpdatePopup.getUpdatePopup().setContent(message.responseText);
                        removeSubmitEffect();
                    });
                    
               
            }

            submit = () => {
                const formData = $(form).serializeArray();
                var url = form.getAttribute('action');
                const resultArray = [];
                let currentItem = {};

                formData.forEach(item => {
                    if (item.name === 'applicationSchool') {
                        // Nếu currentItem không rỗng, đẩy nó vào mảng kết quả
                        if (Object.keys(currentItem).length !== 0) {
                            resultArray.push(currentItem);
                        }
                        // Tạo một đối tượng mới cho phần tử tiếp theo
                        currentItem = {};
                        // Thiết lập giá trị applicationSchool cho đối tượng mới
                        currentItem.applicationSchool = item.value;
                    } else if (item.name === 'scholarship') {
                        currentItem.scholarship = item.value;
                    } else if (item.name === 'result-'+currentItem.applicationSchool) {
                        currentItem.result = item.value === '1' ? true : false;
                    } else if (item.name === 'study') {
                        currentItem.study = item.value;
                    }
                });

                // Đẩy phần tử cuối cùng vào mảng kết quả
                if (Object.keys(currentItem).length !== 0) {
                    resultArray.push(currentItem);
                }

                resultArray.forEach(item => {
                    $.ajax({
                        url: url, // URL endpoint
                        method: 'PUT', // Phương thức HTTP
                        data: {
                            // Dữ liệu cần gửi đi
                            applicationSchool: item.applicationSchool,
                            scholarship: item.scholarship,
                            result: item.result,
                            study: item.study,
                            _token: '{{ csrf_token() }}'
                        },
                    }).done(response => {
                       UpdatePopupRecruitmentResults.getUpdatePopup().hide();
                        // success alert
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                // applicationSchoolManager.load();
                            }
                        });
                    }).fail(message => {
                        // Xử lý khi yêu cầu thất bại
                        throw new Error(message); // In ra thông báo lỗi
                    });
                });
                
            }

            addSubmitEffect = () => {

                // btn effect
                submitBtn.setAttribute('data-kt-indicator', 'on');
                submitBtn.setAttribute('disabled', true);
            }

            removeSubmitEffect = () => {

                // btn effect
                submitBtn.removeAttribute('data-kt-indicator');
                submitBtn.removeAttribute('disabled');
            }

            deleteUpdatePopup = () => {
                form.removeEventListener('submit', submit);

                createApplicationSchool = null;
            }

            return {
                init: () => {

                    form = document.querySelector('#{{ $createSocialNetwork }}');
                    submitBtn = document.querySelector("#CreateRecruitmentResultsButton");

                    handleFormSubmit();
                }
            }
        }();







        var initializePriceInput = function() {
            return {
                init: () => {
                    const priceInput = $('#price-input');

                    if (priceInput.length) {
                        const mask = new IMask(priceInput[0], {
                            mask: Number,
                            scale: 0,
                            thousandsSeparator: ',',
                            padFractionalZeros: false,
                            normalizeZeros: true,
                            radix: ',',
                            mapToRadix: ['.'],
                            min: 0,
                        });

                        $('#popupCreateAbroadUniqId').on('submit', function() {
                            priceInput.val(priceInput.val().replace(/,/g, ''));
                        });
                    }
                }
            }

        }();
        
        var Manager = class {
            constructor(options) {
                this.container = options.container;
                this.init();
            }
    
            getContainer() {
                return this.container;
            }
    
            getUploadUrl() {
                return this.getUpLoadDraftBtn().data('upload-url');
            }
    
            getDraftFileElement(applicationId) {
                return this.getContainer().find(`[data-application-id="${applicationId}"]`);
            }
    
            getDraftInput(applicationId) {
                return this.getDraftFileElement(applicationId).find('[action-control^="file-confirmation-"]');
            }
            delete(url) {
                const formData = new FormData();
                
                const csrfToken = '{{ csrf_token() }}';
                formData.append('_token', csrfToken);
               
                
                $.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(response => {
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            UpdatePopupRecruitmentResults.getUpdatePopup().load();
                        }
                    });
                }).fail(response => {
                    removeSubmitEffect();
                });
  
            }
            deleteHandle(url) {
                ASTool.confirm({
                    icon: 'warning',
                    message: "Bạn có chắc muốn xóa file này?",
                    ok: () => {
                        this.delete(url);
                    },
                    cancel: () => {}
                });
                
            }
    
            upload(file, uploadUrl, fieldName) {
                const formData = new FormData();
    
                const csrfToken = '{{ csrf_token() }}';
                formData.append('_token', csrfToken);
                formData.append(fieldName, file);
            
    
                $.ajax({
                    url: uploadUrl,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false
                }).done(response => {
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            UpdatePopupRecruitmentResults.getUpdatePopup().load();
                        }
                    });
                }).fail(response => {
                    removeSubmitEffect();
                });
            }
    
            init() {
                this.events();
                
            }
    
            events() {
                const _this = this;

                _this.getContainer().on('click', 'button.upload-btn', function(e) {
                    e.preventDefault();
                    const formDataElement = $(this).closest('[form-data]');
                    const applicationId = formDataElement.data('application-id');
                    const fileInput = formDataElement.find('input[type="file"]');
                    fileInput.data('application-id', applicationId); 
                    fileInput.click();
                });

                _this.getContainer().on('change', 'input[type="file"]', function(e) {
                    e.preventDefault();
                    const fileInput = $(this);
                    const applicationId = fileInput.data('application-id'); 
                    const file = this.files[0];
                    const uploadUrl = fileInput.siblings('button.upload-btn').data('upload-url');
                    _this.upload(file, uploadUrl, fileInput.attr('name'));
                });

                _this.getContainer().on('click', 'button.delete-btn', function(e) {
                    e.preventDefault(); 
                    const formDataElement = $(this).closest('[form-data]');
                    const deleteUrl = $(this).data('delete-url'); 
                    _this.deleteHandle(deleteUrl);
                    
                });


            }

        };
    </script>
    
@endsection
