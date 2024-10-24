@extends('layouts.main.popup')

@section('title')
    Danh sách trường yêu cầu tuyển sinh
@endsection
@php
    $createSocialNetwork = 'createSocialNetwork_' . uniqid();
@endphp
@section('content')
    <!--begin::Card body-->

    <form id="popupCreateAbroadUniqId" tabindex="-1">
        @csrf
        <div class="scroll-y
        pe-7 py-10 px-lg-17" >
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
                                        Thời điểm nộp hồ sơ
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Yêu cầu tuyển sinh
                                    </span>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <input type="hidden" name="applicationSchools" value="{{$applicationSchools}}">
                        <!-- Lặp qua từng loại trường -->
                        @foreach (\App\Models\ApplicationSchool::getAllType() as $type)
                            <!-- Dòng đầu tiên của mỗi loại trường -->
                            <tr>
                                <td rowspan="{{ count($applicationSchools->where('type', $type)) + 1 }}" class="text-left mb-1 text-nowrap"> {{ trans('messages.application_school.type.' . $type) }}</td>
                            </tr>
                            <!-- Lặp qua danh sách các trường trong mỗi loại -->
                            @foreach ($applicationSchools->where('type', $type) as $applicationSchool)
                                <tr list-control="item">
                                    <!-- Cột tên trường -->
                                    <td class="text-left mb-1 text-nowrap">{{ $applicationSchool->school ? $applicationSchool->school->name :'--'  }}</td>
                                    <!-- Cột thời điểm nộp hồ sơ -->
                                    <td class="text-left mb-1 text-nowrap">{{ $applicationSchool->apply_date }}</td>
                                    <!-- Cột yêu cầu tuyển sinh -->
                                    <td class="text-left mb-1 text-nowrap">{{ $applicationSchool->school->requirement }}</td>
                                    <!-- Cột thao tác -->
                                   
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

    
@endsection
