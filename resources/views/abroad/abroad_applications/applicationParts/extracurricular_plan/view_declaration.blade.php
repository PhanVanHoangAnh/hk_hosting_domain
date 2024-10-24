
@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Kê khai lộ trình học thuật chiến lược
@endsection

@php
    $declareExtracurricularPlanPopup = 'declareExtracurricularPlanPopup' . uniqid();
@endphp

@section('content')
<div>
    <form id="{{ $declareExtracurricularPlanPopup }}" method="PUT" tabindex="-1"  
   >
        @csrf
        <div class="pe-7 py-10 px-lg-17" >
            <div class="table-responsive">

                 <table class="table align-middle table-row-dashed fs-6 gy-5 border" id="dtHorizontalVerticalOrder">
                    <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        HẠNG MỤC
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        STT
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        HOẠT ĐỘNG THỰC HIỆN
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        THỜI GIAN THỰC HIỆN
                                    </span>
                                </span>
                            </th>
                            <th class="min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        MÔ TẢ HOẠT ĐỘNG
                                    </span>
                                </span>
                            </th>
                           
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                       <input  readonly type="hidden" name="abroadApplicationId" value="{{$abroadApplication->id}}">
                        @if(isset($loTrinhHoatDongNgoaiKhoaDatas) && $loTrinhHoatDongNgoaiKhoaDatas->count()!==0 )
                            @php
                                $aria = 0;
                            @endphp
                            @foreach($loTrinhHoatDongNgoaiKhoa as $category => $activitys)
                                @php
                                    $rowCount = count($activitys);
                                    $rowSpanApplied = false;
                                    $stt = 1;
                                    
                                @endphp
                                    
                                @foreach($activitys as $key => $activity)
                                    
                                    @if ($key === 0 && !$rowSpanApplied)
                                        <tr>
                                            <td class="text-left mb-1 text-nowrap" rowspan="{{ $rowCount }}">
                                                {{ $category }}
                                                <input  readonly type="hidden" name="category" value="{{ $category }}">
                                            </td>
                                            <td>{{ $stt }}</td>
                                            <td class="text-left mb-1 text-nowrap" name="activity" >{{ $activity }} <input  readonly type="hidden" name="activity" value="{{ $activity }}"></td>
                                            <td>
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input  readonly data-control="input" value="{{$loTrinhHoatDongNgoaiKhoaDatas->skip($aria)->take(1)->first()->intend_time}}" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <textarea  readonly  class="form-control" name="note" placeholder="Mô tả hoạt động" rows="1" cols="40">{{$loTrinhHoatDongNgoaiKhoaDatas->skip($aria)->take(1)->first()->note}}</textarea>
                                            </td>
                                        </tr>
                                        @php $rowSpanApplied = true; @endphp
                                    @else
                                        <tr>
                                            <td>{{ $stt }}</td>
                                            <td class="text-left mb-1 text-nowrap">{{ $activity }} <input  readonly type="hidden" name="activity" value="{{ $activity }}"></td>
                                            <td>
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input  readonly data-control="input" value="{{$loTrinhHoatDongNgoaiKhoaDatas->skip($aria)->take(1)->first()->intend_time}}" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    
                                                </div>
                                            </td>
                                            {{-- <td>
                                                <textarea  readonly  class="form-control" name="taget" placeholder="Nhập mục tiêu" rows="1" cols="40"></textarea>
                                            </td> --}}
                                            
                                            <td>
                                                <textarea  readonly  class="form-control" name="note" placeholder="Mô tả hoạt động" rows="1" cols="40">{{$loTrinhHoatDongNgoaiKhoaDatas->skip($aria)->take(1)->first()->note}}</textarea>
                                            </td>
                                        </tr>
                                    @endif
                                    @php
                                        $stt++;
                                        $aria++;
                                    @endphp
                                @endforeach
                            @endforeach
                            
                        @else
                            @foreach($loTrinhHoatDongNgoaiKhoa as $category => $activitys)
                                @php
                                    $rowCount = count($activitys);
                                    $rowSpanApplied = false;
                                    $stt = 1;
                                @endphp
                                    
                                @foreach($activitys as $key => $activity)
                                    
                                    @if ($key === 0 && !$rowSpanApplied)
                                        <tr>
                                            <td class="text-left mb-1 text-nowrap" rowspan="{{ $rowCount }}">
                                                {{ $category }}
                                                <input  readonly type="hidden" name="category" value="{{ $category }}">
                                            </td>
                                            <td>{{ $stt }}</td>
                                            <td class="text-left mb-1 text-nowrap" name="activity" >{{ $activity }} <input  readonly type="hidden" name="activity" value="{{ $activity }}"></td>
                                            <td>
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input  readonly data-control="input" value="" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    
                                                </div>
                                            </td>
                                           
                                            <td>
                                                <textarea  readonly  class="form-control" name="note" placeholder="Mô tả hoạt động" rows="1" cols="40"></textarea>
                                            </td>
                                        </tr>
                                        @php $rowSpanApplied = true; @endphp
                                    @else
                                        <tr>
                                            <td>{{ $stt }}</td>
                                            <td class="text-left mb-1 text-nowrap" name="activity"  >{{ $activity }} <input  readonly type="hidden" name="activity" value="{{ $activity }}"></td>
                                            <td>
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input  readonly data-control="input" value="" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    
                                                </div>
                                            </td>
                                            
                                            <td>
                                                <textarea  readonly  class="form-control" name="note" placeholder="Mô tả hoạt động" rows="1" cols="40"></textarea>
                                            </td>
                                        </tr>
                                    @endif
                                    @php
                                        $stt++;
                                    @endphp
                                @endforeach
                            @endforeach
                        @endif
                       
                    </tbody>
                </table>
                
                

                <!--end::Table-->
                <div id="error-message" class="error-message text-danger" style="display: none;"></div>

                
                


            </div>
        </div>
       
    </form>
</div>

@endsection



