
@extends('layouts.main.popup', [
    'size' => 'full',
])

@section('title')
    Kê khai lộ trình hoạt động ngoại khoá
@endsection

@php
    $declareExtracurricularPlanPopup = 'declareExtracurricularPlanPopup' . uniqid();
@endphp

@section('content')
<div>
    <form id="{{ $declareExtracurricularPlanPopup }}" method="PUT" tabindex="-1"  
    action="{{ action(
        [App\Http\Controllers\Abroad\LoTrinhHoatDongNgoaiKhoaController::class, 'createLoTrinhHoatDongNgoaiKhoa']
    ) }}">
        @csrf
        <div class="pe-7 py-10 px-lg-17" >
            <div class="table-responsive">

                 <table class="table align-middle table-row-dashed fs-6 gy-5 border" id="dtHorizontalVerticalOrder">
                    <thead>
                        <tr class="text-start bg-info text-light fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                            <th class=" line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        HẠNG MỤC
                                    </span>
                                </span>
                            </th>
                            <th class=" line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        STT
                                    </span>
                                </span>
                            </th>
                            <th class=" line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        HOẠT ĐỘNG THỰC HIỆN
                                    </span>
                                </span>
                            </th>
                            <th class=" line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        THỜI GIAN THỰC HIỆN
                                    </span>
                                </span>
                            </th>
                            <th class=" line-table min-w-125px text-left">
                                <span class="d-flex align-items-center">
                                    <span>
                                        MÔ TẢ HOẠT ĐỘNG
                                    </span>
                                </span>
                            </th>
                           
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                       <input type="hidden" name="abroadApplicationId" value="{{$abroadApplication->id}}">
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
                                            <td class=" fw-bold line-table text-left mb-1 text-nowrap" rowspan="{{ $rowCount }}">
                                                {{ $category }}
                                                <input type="hidden" name="category" value="{{ $category }}">
                                            </td>
                                            <td class="line-table fw-bold">{{ $stt }}</td>
                                            <td class="line-table fw-bold text-left mb-1 text-nowrap" name="activity" >{{ $activity }} <input type="hidden" name="activity" value="{{ $activity }}"></td>
                                            <td class="line-table">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input data-control="input" value="{{$loTrinhHoatDongNgoaiKhoaDatas->skip($aria)->take(1)->first()->intend_time}}" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                                        style="display:none;">close</span>
                                                </div>
                                            </td>
                                            
                                            <td class="line-table">
                                                <textarea class="form-control" name="note" placeholder="Mô tả hoạt động" rows="1" cols="40">{{$loTrinhHoatDongNgoaiKhoaDatas->skip($aria)->take(1)->first()->note}}</textarea>
                                            </td>
                                        </tr>
                                        @php $rowSpanApplied = true; @endphp
                                    @else
                                        <tr>
                                            <td class="line-table fw-bold">{{ $stt }}</td>
                                            <td class="line-table fw-bold text-left mb-1 text-nowrap">{{ $activity }} <input type="hidden" name="activity" value="{{ $activity }}"></td>
                                            <td class="line-table">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input data-control="input" value="{{$loTrinhHoatDongNgoaiKhoaDatas->skip($aria)->take(1)->first()->intend_time}}" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                                        style="display:none;">close</span>
                                                </div>
                                            </td>
                                            {{-- <td>
                                                <textarea class="form-control" name="taget" placeholder="Nhập mục tiêu" rows="1" cols="40"></textarea>
                                            </td> --}}
                                            
                                            <td class="line-table">
                                                <textarea class="form-control" name="note" placeholder="Mô tả hoạt động" rows="1" cols="40">{{$loTrinhHoatDongNgoaiKhoaDatas->skip($aria)->take(1)->first()->note}}</textarea>
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
                                            <td class="line-table text-left mb-1 text-nowrap fw-bold" rowspan="{{ $rowCount }}">
                                                {{ $category }}
                                                <input type="hidden" name="category" value="{{ $category }}">
                                            </td>
                                            <td class="line-table fw-bold">{{ $stt }}</td>
                                            <td class="line-table fw-bold text-left mb-1 text-nowrap" name="activity" >{{ $activity }} <input type="hidden" name="activity" value="{{ $activity }}"></td>
                                            <td class="line-table">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input data-control="input" value="" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                                        style="display:none;">close</span>
                                                </div>
                                            </td>
                                           
                                            <td class="line-table">
                                                <textarea class="form-control" name="note" placeholder="Mô tả hoạt động" rows="1" cols="40"></textarea>
                                            </td>
                                        </tr>
                                        @php $rowSpanApplied = true; @endphp
                                    @else
                                        <tr>
                                            <td class="line-table fw-bold">{{ $stt }}</td>
                                            <td class="line-table fw-bold text-left mb-1 text-nowrap" name="activity"  >{{ $activity }} <input type="hidden" name="activity" value="{{ $activity }}"></td>
                                            <td class="line-table ">
                                                <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                                    <input data-control="input" value="" name="intend_time" id="execution_date"
                                                        placeholder="=asas" type="date" class="form-control">
                                                    <span data-control="clear" class="material-symbols-rounded clear-button"
                                                        style="display:none;">close</span>
                                                </div>
                                            </td>
                                            
                                            <td class="line-table">
                                                <textarea class="form-control" name="note" placeholder="Mô tả hoạt động" rows="1" cols="40"></textarea>
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
                    <button id="createLoTrinhHoatDongNgoaiKhoaButton" type="submit" class="btn btn-primary">
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
        createLoTrinhHoatDongNgoaiKhoa.init();
    })

    var createLoTrinhHoatDongNgoaiKhoa = function() {
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
                    
                    if (item.name === 'category') {
                        // Nếu currentItem không rỗng, đẩy nó vào mảng kết quả
                        if (Object.keys(currentItem).length !== 0) {
                            resultArray.push(currentItem);
                        }
                        // Tạo một đối tượng mới cho phần tử tiếp theo
                        currentItem = {};
                        // Thiết lập giá trị applicationSchool cho đối tượng mới
                        category = item.value;
                        // currentItem.type = item.value;
                    } else if (item.name === 'intend_time') {
                        currentItem.category = category;
                        currentItem.intend_time = item.value;
                    } else if (item.name === 'taget') {
                        currentItem.taget = item.value
                    } else if (item.name === 'activity') {
                        currentItem.activity = item.value    
                    } else if (item.name === 'note') {
                        currentItem.note = item.value;

                        resultArray.push(currentItem);
                        currentItem = {};
                       
                    }
                }
                );
                
           


                let completedRequests = 0;
                let lastMessage = '';

                resultArray.forEach((item, index, array) => {
                    $.ajax({
                        url: url, // URL endpoint
                        method: 'PUT',
                        data: {
                            // Dữ liệu cần gửi đi
                            category: item.category,
                            intend_time: item.intend_time,
                            taget: item.taget,
                            activity: item.activity,
                            note: item.note,
                            abroadApplicationId: abroadApplicationId,
                            _token: '{{ csrf_token() }}'
                        },
                    }).done(response => {
                        // Lưu trữ thông báo cuối cùng
                        lastMessage = response.message;
                        completedRequests++;

                        // Nếu tất cả các yêu cầu đã hoàn thành, hiển thị thông báo cuối cùng
                        if (completedRequests === array.length) {
                                ASTool.alert({
                                message: response.message,
                                ok: function() {
                                    managerPopup.getPopup().hide();
                                    extracurricularPlan.load();
                                }
                            });
                        }
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

            createLoTrinhHoatDongNgoaiKhoa = null;
        }

        return {
            init: () => {
                form = document.querySelector('#{{ $declareExtracurricularPlanPopup }}');
                submitBtn = document.querySelector("#createLoTrinhHoatDongNgoaiKhoaButton");

                handleFormSubmit();
            }
        }
    }();
</script>
@endsection



