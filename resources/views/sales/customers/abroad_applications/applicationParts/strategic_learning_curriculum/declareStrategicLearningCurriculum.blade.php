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
    <form id="{{ $declareStrategicLearningCurriculumPopup }}" method="PUT" tabindex="-1"  
    action="{{ action(
        [App\Http\Controllers\Sales\LoTrinhChienLuocController::class, 'createLoTrinhHocThuatChienLuoc']
    ) }}">
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
                       <input type="hidden" name="abroadApplicationId" value="{{$abroadApplication->id}}">
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
                                                <input type="hidden" name="type" value="{{ $category }}">
                                            </td>
                                           <td class="line-table fw-bold ">{{ $stt }}</td>
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap" name="content" >{{ $content }} <input type="hidden" name="content" value="{{ $content }}"></td>
                                           <td class="line-table  ">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input data-control="input" value="{{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->intend_time}}" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                                        style="display:none;">close</span>
                                                </div>
                                            </td>
                                            <td class="line-table  ">
                                                <select class="form-select form-control" data-control="select2" name="frequency" id="">
                                                    <option value="">Chọn</option>
                                                    @foreach(config('frequency') as $frequency)   
                                                        <option value="{{ $frequency }}"  {{  $loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->frequency == $frequency ? 'selected' : '' }}>{{ $frequency }}</option>
                                                        
                                                    @endforeach
                                                </select>
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
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap">{{ $content }} <input type="hidden" name="content" value="{{ $content }}"></td>
                                           <td class="line-table ">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input data-control="input" value="{{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->intend_time}}" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                                        style="display:none;">close</span>
                                                </div>
                                            </td>
                                            {{-- <td>
                                                <textarea class="form-control" name="taget" placeholder="Nhập mục tiêu" rows="1" cols="40"></textarea>
                                            </td> --}}
                                            <td class="line-table  ">
                                                <select class="form-select form-control" data-control="select2" name="frequency" id="">
                                                    <option value="">Chọn</option>
                                                    @foreach(config('frequency') as $frequency)   
                                                        <option value="{{ $frequency }}"  {{  $loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->frequency == $frequency ? 'selected' : '' }} >{{ $frequency }}</option>
                                                        
                                                    @endforeach
                                                </select>
                                            </td>
                                           <td class="line-table  ">
                                                <textarea class="form-control" name="taget" placeholder="Nhập mục tiêu." rows="1" cols="40">{{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->taget}}</textarea>
                                            </td>
                                           <td class="line-table  ">
                                                <textarea class="form-control" name="note" placeholder="Nhập ghi chú" rows="1" cols="40">{{$loTrinhHocThuatChienLuocDatas->skip($aria)->take(1)->first()->note}}</textarea>
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
                                                <input type="hidden" name="type" value="{{ $category }}">
                                            </td>
                                           <td class="line-table fw-bold ">{{ $stt }}</td>
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap" name="content" >{{ $content }} <input type="hidden" name="content" value="{{ $content }}"></td>
                                           <td class="line-table">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input data-control="input" value="" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                                        style="display:none;">close</span>
                                                </div>
                                            </td>
                                            <td class="line-table  ">
                                                <select class="form-select form-control" data-control="select2" name="frequency" id="">
                                                    <option value="">Chọn</option>
                                                    @foreach(config('frequency') as $frequency)   
                                                        <option value="{{ $frequency }}"  >{{ $frequency }}</option>
                                                        
                                                    @endforeach
                                                </select>
                                            </td>
                                           <td class="line-table  ">
                                                <textarea class="form-control" name="taget" placeholder="Nhập mục tiêu." rows="1" cols="40"></textarea>
                                            </td>
                                           <td class="line-table  ">
                                                <textarea class="form-control" name="note" placeholder="Nhập ghi chú" rows="1" cols="40"></textarea>
                                            </td>
                                        </tr>
                                        @php $rowSpanApplied = true; @endphp
                                    @else
                                        <tr>
                                           <td class="line-table fw-bold ">{{ $stt }}</td>
                                           <td class="line-table fw-bold text-left mb-1 text-nowrap" name="content"  >{{ $content }} <input type="hidden" name="content" value="{{ $content }}"></td>
                                            <td class="line-table">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input data-control="input" value="" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                                        style="display:none;">close</span>
                                                </div>
                                            </td>
                                            <td class="line-table  ">
                                                <select class="form-select form-control" data-control="select2" name="frequency" id="">
                                                    <option value="">Chọn</option>
                                                    @foreach(config('frequency') as $frequency)   
                                                        <option value="{{ $frequency }}" >{{ $frequency }}</option>
                                                        
                                                    @endforeach
                                                </select>
                                            </td>
                                           <td class="line-table  ">
                                                <textarea class="form-control" name="taget" placeholder="Nhập mục tiêu" rows="1" cols="40"></textarea>
                                            </td>
                                           <td class="line-table  ">
                                                <textarea class="form-control" name="note" placeholder="Nhập ghi chú" rows="1" cols="40"></textarea>
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

                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button id="CreateLoTrinhHocThuatChienLuocButton" type="submit" class="btn btn-primary">
                        <span class="indicator-label">Lưu</span>
                        <span class="indicator-progress">Đang xử lý...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <!--end::Button-->
                    <!--begin::Button-->
                    <button type="reset" id="kt_modal_add_customer_cancel" class="btn btn-light me-3"
                        data-bs-dismiss="modal">Hủy</button>
                    <!--end::Button-->
                </div>
                


            </div>
        </div>
       
    </form>
</div>
<script>
    $(() => {
        createLoTrinhHocThuatChienLuoc.init();
    })

    var createLoTrinhHocThuatChienLuoc = function() {
        let form;
        let submitBtn;

        const handleFormSubmit = () => {

            form.addEventListener('submit', e => {

                e.preventDefault();

                submit();
            })
        }

        submit = () => {
            var url = form.getAttribute('action');
            const formData = $(form).serializeArray();
            const resultArray = [];
            let currentItem = {};
            var type;
            var abroadApplicationId = document.querySelector('input[name="abroadApplicationId"]').value;
            
            formData.forEach(item => {
                    
                    if (item.name === 'type') {
                        // Nếu currentItem không rỗng, đẩy nó vào mảng kết quả
                        if (Object.keys(currentItem).length !== 0) {
                            resultArray.push(currentItem);
                        }
                        // Tạo một đối tượng mới cho phần tử tiếp theo
                        currentItem = {};
                        // Thiết lập giá trị applicationSchool cho đối tượng mới
                        type = item.value;
                        // currentItem.type = item.value;
                    } else if (item.name === 'intend_time') {
                        currentItem.type = type;
                        currentItem.intend_time = item.value;
                    } else if (item.name === 'taget') {
                        currentItem.taget = item.value
                    } else if (item.name === 'frequency') {
                        currentItem.frequency = item.value
                    }else if (item.name === 'content') {
                        currentItem.content = item.value    
                    } else if (item.name === 'note') {
                        currentItem.note = item.value;

                        resultArray.push(currentItem);
                        currentItem = {};
                       
                    }
                }
                );
       
            resultArray.forEach(item => {
                    $.ajax({
                        url: url, // URL endpoint
                      method: 'PUT', 
                        data: {
                            // Dữ liệu cần gửi đi
                            type: item.type,
                            intend_time: item.intend_time,
                            taget: item.taget,
                            content: item.content,
                            note: item.note,
                            frequency: item.frequency,
                            abroadApplicationId: abroadApplicationId,
                            _token: '{{ csrf_token() }}'
                        },
                    }).done(response => {
                       
                        // success alert
                        ASTool.alert({
                            message: response.message,
                            ok: function() {
                                managerPopup.getPopup().hide();
                                strategicLearningCurriculum.load();
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

            createLoTrinhHocThuatChienLuoc = null;
        }

        return {
            init: () => {

                form = document.querySelector('#{{ $declareStrategicLearningCurriculumPopup }}');
                submitBtn = document.querySelector("#CreateLoTrinhHocThuatChienLuocButton");

                handleFormSubmit();
            }
        }
    }();
</script>
@endsection