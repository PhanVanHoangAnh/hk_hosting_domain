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
                                <input type="hidden" name="applicationSchool" value="{{$applicationSchool->id}}" disabled>

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
                                            </div>
                                        @endif
                                        
                                    </td>
                                    {{-- <td class="text-left mb-1 text-nowrap">ff
                                        <input  list-action="check-item" class="form-check-input" type="checkbox" name='result' {{ !empty($applicationSchool->result) ? 'checked' : '' }} disabled>
                                    </td> --}}

                                    <td class="text-left mb-1 text-nowrap">
                                       
                                        <input list-action="check-item" class="form-check-input" type="radio" value="1" name="result-{{$applicationSchool->id}}" {{ $applicationSchool->result === 'true' ? 'checked' : '' }} disabled>
                                        <span class="me-5">Đậu</span>
                                        <input list-action="check-item" class="form-check-input" type="radio" value="0" name="result-{{$applicationSchool->id}}" {{ $applicationSchool->result === 'false' ? 'checked' : '' }} disabled>
                                        <span>Trượt</span>
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
                                            </div>
                                        @else
                                            <div form-data="confirmation" data-application-id="{{ $applicationSchool->id }}">
                                                <input type="file" name="file_confirmation" action-control="file-confirmation-{{$applicationSchool->id}}-input" class="d-none"disabled>
                                            </div>
                                        @endif
                                        
                                    </td>





                                    <td>
                                        <input name="study" data-section-id="" data-student-id="" list-action="check-item" class="form-check-input" type="radio" value="studied" {{ !empty($applicationSchool->study) ? 'checked' : '' }} disabled>
                                    </td>
                        
                                    
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
                
                
                <!--end::Table-->
                <div id="error-message" class="error-message text-danger" style="display: none;"></div>



            </div>
        </div>
    </form>
    <!--end::Card body-->

    
    
@endsection
