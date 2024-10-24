@extends('layouts.main.popup')

@section('title')
    Hồ sơ du học
@endsection

@php
    $formId = 'createStudyAbroadApplicationPopup_' . uniqid();
@endphp

@section('content')
<div>
    <form id="popupCreateAbroadUniqId" tabindex="-1">
        @csrf
        <div  class="scroll-y pe-7 py-10 px-lg-17" >
            <div class="table-responsive">
                
                <table class="table align-middle table-row-dashed fs-6 gy-5" >
                    <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                
                            
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Tên
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        File
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Trạng thái
                                    </span>
                                </span>
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        
                        @foreach ($studyAbroadApplications as $studyAbroadApplication)
                            <tr list-control="item">
                             
                                <td class="text-left" data-filter="mastercard">
                                    {{ $studyAbroadApplication->name }}
                                </td>
                                <td class="text-left" data-filter="mastercard">
                                    @if(isset($studyAbroadApplication->path) && $studyAbroadApplication->path !== 'undefined')
                                    <div data-file-name="{{ basename($studyAbroadApplication->path) }}" data-control="active-file" class="row my-0">
                                        <div class="col-md-9 pe-0 cursor-pointer d-flex justify-content-start align-items-center"> 
                                            <a class="btn btn-sm  btn-flex btn-center btn-active-light-default cursor-pointer" href="{{ $studyAbroadApplication->getPath() }}" download="{{  basename($studyAbroadApplication->path) }}">
                                                {{ $studyAbroadApplication->path  }}
                                                <span class="material-symbols-rounded ">
                                                arrow_downward
                                            </span>
                                            </a>
                                        </div>
                                        
                                    </div>
                                        
                                    @else
                                        <span>Chưa có</span>
                                    @endif
                                </td>
                                <td class="text-left" data-filter="mastercard">
                                    {{ $studyAbroadApplication->status  }}
                                </td>
                                
                            <tr>
                        @endforeach
                        

                    </tbody>
                </table>

            </div>
        </div>
        <div class="modal-footer flex-center">
           
            <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                data-bs-dismiss="modal">Đóng</button>
           
        </div>
    </form>

</div>

 

@endsection