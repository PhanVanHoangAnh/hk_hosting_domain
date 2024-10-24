@extends('layouts.main.popup')

@section('title')
    Hồ sơ du học
@endsection
@php
    $createStudyAbroadApplication = 'createStudyAbroadApplication_' . uniqid();
@endphp
@section('content')
    <!--begin::Card body-->

    <form id="{{$createStudyAbroadApplication}}" tabindex="-1">
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
                                       Hồ sơ
                                    </span>
                                </span>
                            </th>
                           
                           
                        </tr>
                    </thead>
                    <tbody class="text-gray-600" form-data="manager-pay-and-confirm-container">
                        <input type="hidden" name="applicationSchools" value="{{$applicationSchools}}">
                        
                        @foreach (\App\Models\ApplicationSchool::getAllType() as $type)
                        
                            <tr>
                                <td rowspan="{{ count($applicationSchools->where('type', $type)) + 1 }}" class="text-left mb-1 text-nowrap"> {{ trans('messages.application_school.type.' . $type) }}</td>
                            </tr>
                            
                            @foreach ($applicationSchools->where('type', $type) as $applicationSchool)
                                <tr list-control="item">
                                    
                                    <td class="text-left mb-1 text-nowrap">{{ $applicationSchool->school ? $applicationSchool->school->name :'--'  }}</td>
                                    
                                    <td class="text-left mb-1 text-nowrap">
                                        @if(isset($applicationSchool->study_abroad_application) )
                                            <div data-file-name="{{ basename($applicationSchool->study_abroad_application) }}" data-control="active-file" class="row my-0">
                                                <div class="col-md-9 pe-0 cursor-pointer d-flex justify-content-start align-items-center"> 
                                                    <a class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default cursor-pointer" href="{{ $applicationSchool->getPathOfStudyFile() }}" download="{{  basename($applicationSchool->study_abroad_application) }}">
                                                        {{$applicationSchool->study_abroad_application}}
                                                        <span class="material-symbols-rounded ">
                                                        arrow_downward
                                                    </span>
                                                    </a>
                                                </div>
                                                <div class="col-md-3 ps-0 d-flex justify-content-start align-items-center">
                                                    <button class="btn btn-danger btn-sm delete-btn"
                                                    data-delete-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'deleteFileStudyAbroadApplication'], ['id' => $applicationSchool->id]) }}"
                                                    class="btn btn-danger btn-sm">Xóa</button>
                                                </div>
                                                
                                            </div>
                                                
                                        @else
                                            <div form-data="confirmation" data-application-id="{{ $applicationSchool->id }}">
                                                <input type="file" name="study_abroad_application" action-control="file-study-abroad-application-{{$applicationSchool->id}}-input" class="d-none">
                                                <button action-control="upload-file-study-abroad-application-{{$applicationSchool->id}}-btn" class="fs-6 fw-bold btn btn-info btn-outline-secondary btn-sm fs-4 upload-btn"
                                                        data-upload-url="{{ action([App\Http\Controllers\Abroad\AbroadController::class, 'storeFileStudyAbroadApplication'], ['id' => $applicationSchool->id]) }}">
                                                    Upload
                                                </button>
                                              
                                            </div>
                                        @endif
                                        
                                    </td>
                        
                                    
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                
                

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
        });
        
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
                return this.getDraftFileElement(applicationId).find('[action-control^="file-study-abroad-application-"]');
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
                            UpdateStudyAbroadPopup.getUpdatePopup().load();
                            studyAbroadApplicationManager.load();
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
                            UpdateStudyAbroadPopup.getUpdatePopup().load();
                            studyAbroadApplicationManager.load();
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

