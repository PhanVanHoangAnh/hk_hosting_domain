@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Kê khai lộ trình học thuật chiến lược
@endsection

@php
    $declareStrategicLearningCurriculumPopup = 'declareStrategicLearningCurriculumPopup_' . uniqid();
@endphp

@section('content')
<div>
    <form id="{{ $declareStrategicLearningCurriculumPopup }}" >
        @csrf
        <div class="pe-7 py-10 px-lg-17" >
            <div class="table-responsive">

                <table  class="table  align-middle table-row-dashed fs-6 gy-5 table-bordered" id="dtHorizontalVerticalOrder">
                    <thead>
                        <tr  class="text-start text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th  class="line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Các khoản mục
                                    </span>
                                </span>
                            </th>
                            <th class="line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        STT
                                    </span>
                                </span>
                            </th>
                            <th class="line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Nội dung công việc
                                    </span>
                                </span>
                            </th>
                            <th class="line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Thời gian dự kiến
                                    </span>
                                </span>
                            </th>
                            <th class="line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                       Tần suất
                                    </span>
                                </span>
                            </th>

                            



                            <th class="line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Mục tiêu
                                    </span>
                                </span>
                            </th>
                            <th class="line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        Ghi chú
                                    </span>
                                </span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        @if(isset($loTrinhHocThuatChienLuocDatas) && $loTrinhHocThuatChienLuocDatas->count()!==0 )
                            @php
                                $aria = 0;
                            @endphp
                            @foreach($loTrinhHocThuatChienLuoc as $category => $contents)
                                @php
                                    $rowCount = count($contents);
                                    $rowSpanApplied = false;
                                    $stt = 1;
                                    
                                @endphp
                                    
                                @foreach($contents as $key => $content)
                                    
                                    @if ($key === 0 && !$rowSpanApplied)
                                        <tr>
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap" rowspan="{{ $rowCount }}">
                                                {{ $category }}
                                                <input readonly type="hidden" name="type" value="{{ $category }}">
                                            </td>
                                           <td class="line-table fw-bold ">{{ $stt }}</td>
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap" name="content" >{{ $content }} <input readonly type="hidden" name="content" value="{{ $content }}"></td>
                                           <td class="line-table  ">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input readonly readonly data-control="input" value="{{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->intend_time}}" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    
                                                </div>
                                            </td>
                                            <td class="line-table  ">
                                                {{  $loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->frequency }}
                                            </td>
                                           <td class="line-table  ">
                                            {{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->taget}}
                                            </td>
                                           <td class="line-table  ">
                                            {{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->note}}
                                            </td>
                                        </tr>
                                        @php $rowSpanApplied = true; @endphp
                                    @else
                                        <tr>
                                           <td class="line-table fw-bold ">{{ $stt }}</td>
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap">{{ $content }} <input readonly type="hidden" name="content" value="{{ $content }}"></td>
                                           <td class="line-table ">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input readonly  data-control="input" value="{{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->intend_time}}" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    
                                                </div>
                                            </td>
                                            <td class="line-table  ">
                                                  
                                                         {{  $loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->frequency  }}
                                                        
                                                   
                                            </td>
                                           <td class="line-table  ">
                                            {{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->taget}}
                                            </td>
                                           <td class="line-table  ">
                                            {{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->note}}
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
                            @foreach($loTrinhHocThuatChienLuoc as $category => $contents)
                                @php
                                    $rowCount = count($contents);
                                    $rowSpanApplied = false;
                                    $stt = 1;
                                @endphp
                                    
                                @foreach($contents as $key => $content)
                                    
                                    @if ($key === 0 && !$rowSpanApplied)
                                        <tr>
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap" rowspan="{{ $rowCount }}">
                                                {{ $category }}
                                                <input readonly type="hidden" name="type" value="{{ $category }}">
                                            </td>
                                           <td class="line-table fw-bold ">{{ $stt }}</td>
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap" name="content" >{{ $content }} <input readonly type="hidden" name="content" value="{{ $content }}"></td>
                                           <td class="line-table">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input readonly data-control="input" value="" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    
                                                </div>
                                            </td>
                                            <td class="line-table  ">
                                              ''
                                            </td>
                                           <td class="line-table  ">
                                                {{-- <textarea class="form-control" name="taget" placeholder="Nhập mục tiêu." rows="1" cols="40"></textarea> --}}
                                            </td>
                                           <td class="line-table  ">
                                                {{-- <textarea class="form-control" name="note" placeholder="Nhập ghi chú" rows="1" cols="40"></textarea> --}}
                                            </td>
                                        </tr>
                                        @php $rowSpanApplied = true; @endphp
                                    @else
                                        <tr>
                                           <td class="line-table fw-bold ">{{ $stt }}</td>
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap" name="content"  >{{ $content }} <input readonly type="hidden" name="content" value="{{ $content }}"></td>
                                            <td class="line-table">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input readonly data-control="input" value="" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    
                                                </div>
                                            </td>
                                            <td class="line-table  ">
                                                ''
                                            </td>
                                           <td class="line-table  ">
                                                {{-- <textarea class="form-control" name="taget" placeholder="Nhập mục tiêu" rows="1" cols="40"></textarea> --}}
                                            </td>
                                           <td class="line-table  ">
                                                {{-- <textarea class="form-control" name="note" placeholder="Nhập ghi chú" rows="1" cols="40"></textarea> --}}
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