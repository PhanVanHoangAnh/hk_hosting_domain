@extends('layouts.main.popup')

@section('title')
{{ !isset($orderItem) ? 'Thêm: Dịch vụ đào tạo' : 'Sửa: Dịch vụ đào tạo' }}
@endsection

@section('content')
<form id="EduFormManage" tabindex="-1">
    @csrf
    <div class="scroll-y px-7 py-10 px-lg-17">
        <input class="type-input" type="hidden" name="type" value="Đào tạo">

        <div class="row mb-4">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="train-product-type">Phân loại</label>
                        <select id="product-type" class="form-select form-control" name="order_type"
                            data-control="select2" data-placeholder="Chọn dịch vụ..." data-allow-clear="true" data-dropdown-parent="#EduFormManage">
                        </select>
                    </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                <label class="required fs-6 fw-semibold mb-2" for="product-select">Dịch vụ</label>
                    <select id="product-select" class="form-select form-control" name="train_product"
                        data-control="select2" data-dropdown-parent="#EduFormManage" data-placeholder="Chọn dịch vụ..." data-allow-clear="true" data-dropdown-parent="#EduFormManage">
                        <option value="">Chọn dịch vụ đào tạo</option>
                        @foreach(config('trainProducts') as $product)
                        <option value="{{ $product }}" {{ isset($orderItem) && $orderItem->train_product == $product ? 'selected' : '' }}>{{ $product }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('train_product')" class="mt-2" />
                </div>
            </div>

            <div class="col-lg-2 col-md-2 col-sm-10 col-10 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="price-create-input">Giá bán</label>
                    <input id="price-create-input" type="text" class="form-control"
                        placeholder="Nhập giá bán..." name="price" value="{{ !isset($orderItem) ? '' : "$orderItem->price" }}">
                        <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            <label id="error-price" class="fs-7 fw-semibold mb-2 text-danger d-none">Giá bán không hợp lệ</label>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2 col-2 mb-2 mt-8">
                <div class="form-outline">
                        <select id="currency-select" class="form-select form-control" name="currency_code"
                            data-control="select" data-dropdown-parent="#EduFormManage">
                            @foreach(config('currencies') as $currency)
                            <option {{ $orderItem && $currency == $orderItem->currency_code ? 'selected' : '' }} value="{{ $currency }}">{{ $currency }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-10 col-10 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="discount-create-input">Tỷ lệ khuyến mãi</label>
                    <input id="discount-create-input" class="form-control" name="discount_code" type="number" min="0" max="100"
                        placeholder="Nhập khuyến mãi..." value={{ !isset($orderItem) ? '' : $orderItem->discount_code }}>
                        <label id="error-discount-percent" class="fs-7 fw-semibold mb-2 text-danger d-none">Tỷ lệ khuyến mãi không hợp lệ</label>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-2 col-2 mb-2">
                <label list-symbol="percent" class="fs-6 fw-semibold mt-12">%</label>
            </div>
        </div>

        <div class="row mb-4">
            <div id="exchange-form" class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2 d-none">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="exchange-input">Tỷ giá quy đổi (Nếu giá USD)</label>
                    <input id="exchange-input" class="form-control" name="exchange" value={{ !isset($orderItem) ? '' : $orderItem->exchange }}
                        placeholder="Nhập tỷ giá...">
                        <label id="error-exchange" class="fs-7 fw-semibold mb-2 text-danger">Tỷ giá quy đổi không hợp lệ</label>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-10 col-10 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="price-after-discount">giá bán sau khuyến mãi (VND)</label>
                    <div id="price-after-discount" class="form-control">{{ !isset($orderItem) ? '0' : App\Helpers\Functions::formatNumber($orderItem->price) }}</div>
                </div>
            </div>
            <div class="col-lg-1 col-md-1 col-sm-2 col-2 mb-2">
                <label list-symbol="currency" class="fs-6 fw-semibold mt-12">₫</label>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xs-12 col-xl-12">
                <label class="fs-6 fw-semibold mb-2" for="target-input">Tiến độ thanh toán</label>
                <input data-action="check-pay-all" type="checkbox" class="ms-2" id="is-payall-checkbox"> Thanh toán 1 lần
                <div id="schedule-payment-form" class="card p-5">
                    <div class="row">
                        <div id="form1" class="col-lg-8 col-md-12 col-sm-12 col-12 col-xl-8 col-xs-12 mb-2 pe-16 border-end">
                            <div class="row mb-3">
                                <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                                    <div class="form-outline">
                                        <label class="required fs-6 fw-semibold mb-2" for="schedule-price-input">Giá hợp đồng</label>
                                        <input id="schedule-price-input" type="text" class="form-control"
                                            placeholder="Nhập giá hợp đồng...">
                                            <label id="error-price-schedule" class="fs-7 fw-semibold mb-2 text-danger d-none">Giá không hợp lệ</label>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-md-8 col-sm-12 col-12 mb-2">
                                    <div class="form-outline">
                                        <label class="required fs-6 fw-semibold mb-2" for="schedule-date-input">Hạn thanh toán</label>

                                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                                            <input data-control="input" id="schedule-date-input" name="created_at_from" placeholder="=asas" type="date" class="form-control" placeholder="Hạn thanh toán..." value={{ !isset($orderItem) ? '' : $orderItem->created_at_from }}>
                                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                        </div>
                                            <label id="error-date-schedule" class="fs-7 fw-semibold mb-2 text-danger d-none">Ngày thanh toán không hợp lệ</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-between">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-4">
                                    <div id="add-schedule-btn" class="btn btn-secondary w-75 btn-sm d-flex align-items-center justify-content-center">
                                        <span class="material-symbols-rounded">add</span>
                                        &nbsp;Thêm tiến độ
                                    </div>
                                </div>

                                <div class="col-lg-8 col-md-8 col-sm-8 col-8">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 d-flex justify-content-end align-items-center">
                                            <label class="fs-6 fw-semibold" for="balance-form">Số tiền còn lại</label>
                                        </div>
                                        
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-7">
                                            <div class="form-outline">
                                                <div id="balance-form" class="form-control">0</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 mb-2">
                                            <label list-symbol="currency" class="fs-6 fw-semibold mt-3">₫</label>
                                        </div>
                                    </div>
                                    <label id="error-balance-schedule" class="fs-7 fw-semibold mb-2 text-danger text-center w-100 d-none">Hello world</label>
                                </div>

                            </div>
                        </div>
                        <div id="form2" class="col-lg-4 col-md-12 col-sm-12 col-12 col-xl-4 col-xs-12 mb-2">
                            <ul id="list-schedule-items-content" class="list-group list-group-flush">

                                {{--  --}}

                            </ul>
                        </div>
                    </div>
                </div>
            </div>            
        </div>

        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="level-create-select">Trình độ</label>
                    <select id="level-create-select" class="form-select form-control" name="level"
                        data-control="select2" data-dropdown-parent="#EduFormManage" data-placeholder="Chọn trình độ" data-allow-clear="true">
                        <option value="">Chọn trình độ học viên</option>
                        @foreach(config('levels') as $level)
                        <option value="{{ $level }}" {{ isset($orderItem) && $orderItem->level == $level ? 'selected' : '' }}>{{ $level }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('level')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="class-type">Loại hình lớp</label>
                    <select id="class-type" class="form-select form-control" name="class_type"
                        data-control="select2" data-dropdown-parent="#EduFormManage" data-placeholder="Chọn loại hình lớp" data-allow-clear="true">
                        <option value="">Chọn loại hình lớp</option>
                        @foreach(config('classTypes') as $type)
                        <option value="{{ $type }}" {{ isset($orderItem) && $orderItem->class_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('class_type')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-6 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="home-room-teacher-select">Chủ nhiệm</label>
                    <select id="home-room-teacher-select" class="form-select form-control" name="home_room"
                        data-control="select2" data-dropdown-parent="#EduFormManage" data-placeholder="Chọn chủ nhiệm" data-allow-clear="true">
                        <option value="">Chọn giáo viên chủ nhiệm</option>
                        @foreach(config('homeRooms') as $homeRoom)
                        <option value="{{ $homeRoom }}" {{ isset($orderItem) && $orderItem->home_room == $homeRoom ? 'selected' : '' }}>{{ $homeRoom }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('home_room')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="student-nums-input">Số lượng học viên</label>
                    <input id="student-nums-input" type="number" class="form-control"
                        placeholder="Nhập số lượng học viên..." min="1" name="num_of_student" value={{ !isset($orderItem) ? '' : $orderItem->num_of_student }}>
                        <x-input-error :messages="$errors->get('num_of_student')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="study-type-select">Hình thức học</label>
                    <select id="study-type-select" class="form-select form-control" name="study_type"
                        data-control="select2" data-dropdown-parent="#EduFormManage" data-placeholder="Chọn hình thức học" data-allow-clear="true">
                        <option value="">Chọn hình thức học</option>
                        @foreach(config('studyTypes') as $type)
                        <option value="{{ $type }}" {{ isset($orderItem) && $orderItem->study_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('study_type')" class="mt-2" />
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="branch-select">Chi nhánh đào tạo</label>
                    <select id="branch-select" class="form-select form-control" name="branch"
                        data-control="select2" data-dropdown-parent="#EduFormManage" data-placeholder="Chọn chi nhánh đào tạo" data-allow-clear="true">
                        <option value="">Chọn chi nhánh</option>
                        @foreach(config('branchs') as $branch)
                        <option value="{{ $branch }}" {{ isset($orderItem) && $orderItem->branch == $branch ? 'selected' : '' }}>{{ $branch }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('branch')" class="mt-2" />
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-5 col-md-5 col-sm-5 col-5 mb-2">
                <label class="fs-6 fw-semibold mb-2" for="target-input">Giáo viên</label>
                <div class="card p-5">
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                            <label class="fs-6" for="target-input">Giáo viên Việt Nam</label>
                        </div>
                        <div class="col-lg-4 col-xs-7 col-sm-7 col-md-7 col-7 col-xl-4 ps-1">
                            <input type="number" min="1" class="form-control"
                            placeholder="Thời lượng dạy học" name="vietnam_teacher" value={{ !isset($orderItem) ? '' : $orderItem->vietnam_teacher }}>
                            <x-input-error :messages="$errors->get('vietnam_teacher')" class="mt-2" />
                        </div>
                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                            <label class="fs-6" for="target-input">Giờ</label>
                        </div>
                    </div>
    
                    <div class="row my-5">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                            <label class="fs-6" for="target-input">Giáo viên nước ngoài</label>
                        </div>
                        <div class="col-lg-4 col-xs-7 col-sm-7 col-md-7 col-7 col-xl-4 ps-1">
                            <input type="number" min="1" class="form-control"
                            placeholder="Thời lượng dạy học" name="foreign_teacher" value={{ !isset($orderItem) ? '' : $orderItem->foreign_teacher }}>
                            <x-input-error :messages="$errors->get('foreign_teacher')" class="mt-2" />
                        </div>
                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                            <label class="fs-6" for="target-input">Giờ</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12 col-12 col-xs-12 p-0 m-0 ps-5 pe-1 d-flex align-items-center">
                            <label class="fs-6" for="target-input">Gia sư</label>
                        </div>
                        <div class="col-lg-4 col-xs-7 col-sm-7 col-7 col-md-7 col-xl-4 ps-1">
                            <input type="number" min="1" class="form-control"
                            placeholder="Thời lượng dạy học" name="tutor_teacher" value={{ !isset($orderItem) ? '' : $orderItem->tutor_teacher }}>
                            <x-input-error :messages="$errors->get('tutor_teacher')" class="mt-2" />
                        </div>
                        <div class="col-lg-2 col-md-5 col-sm-5 col-2 col-xs-5 p-0 m-0 d-flex align-items-center justify-content-center">
                            <label class="fs-6" for="target-input">Giờ</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 col-md-7 col-sm-7 col-7 mb-2">

                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="target-input">Target</label>
                        <input id="target-input" type="text" class="form-control"
                            placeholder="Nhập điểm targer nếu có" name="target" value={{ !isset($orderItem) ? '' : $orderItem->target }}>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="duration-input">Thời lượng</label>
                        <input id="duration-input" type="number" min="0" class="form-control"
                            placeholder="Nhập thời lượng buổi học..." name="duration" value={{ !isset($orderItem) ? '' : $orderItem->duration }}>
                            <x-input-error :messages="$errors->get('duration')" class="mt-2" />
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="unit-select">Đơn vị tính</label>
                        <select id="unit-select" class="form-select form-control" name="unit" data-control="select2" data-dropdown-parent="#EduFormManage"
                            data-placeholder="Chọn đơn vị tính thời lượng học..." data-allow-clear="true">
                            <option value="">Chọn đơn vị</option>
                            @foreach(config('units') as $unit)
                            <option value="{{ $unit }}" {{ isset($orderItem) && $orderItem->unit == $unit ? 'selected' : '' }}>{{ $unit }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('unit')" class="mt-2" />
                    </div>
                </div>

            </div>
        </div>

        <div id="demo-container" class="row mb-4">
            
            <div id="have-studied-form" class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="have-studied-select">Đã học demo chưa?</label>
                    <select id="have-studied-select" class="form-select form-control" name="have_studied" data-control="select2" data-dropdown-parent="#EduFormManage"
                        data-placeholder="Chọn" data-allow-clear="true">
                        <option value="">Chọn</option>
                        <option value="true" {{ isset($orderItem) && $orderItem->have_studied == 'true' ? 'selected' : '' }}>Đã học</option>
                        <option value="false" {{ isset($orderItem) && $orderItem->have_studied == 'false' ? 'selected' : '' }}>Chưa học</option>
                    </select>
                    <x-input-error :messages="$errors->get('have_studied')" class="mt-2" />
                </div>
            </div>
            
            <div id="demo-deduction-form" class="col-lg-4 col-md-4 col-sm-4 col-4 mb-2 d-none">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="has-demo-hour-deduction">Có trừ giờ demo hay không?</label>
                    <div class="row">
                    <div id="has-demo-hour-deduction-box-select" class="col-lg-12 col-xs-12 col-sm-12 col-md-12 col-xl-12 pe-0">
                        <select id="has-demo-hour-deduction" class="form-select form-control" name="has_demo_hour_deduction" data-control="select2" data-dropdown-parent="#EduFormManage"
                            data-placeholder="Chọn..." data-allow-clear="true">
                            <option value="">Chọn</option>
                            <option value="true" {{ isset($orderItem) && $orderItem->has_demo_hour_deduction == 'true' ? 'selected' : '' }}>Có</option>
                            <option value="false" {{ isset($orderItem) && $orderItem->has_demo_hour_deduction == 'false' ? 'selected' : '' }}>Không</option>
                        </select>
                        <x-input-error :messages="$errors->get('has_demo_hour_deduction')" class="mt-2" />
                    </div>
                    <div id="demo-letter-box" class="col-lg-4 col-xs-4 col-sm-4 col-md-4 col-xl-4 ps-1 d-none">
                        <input id="demo-letter-input" type="text" class="form-control"
                        placeholder="Phiếu demo" name="demo_letter">
                    </div>
                    </div>
                </div>
            </div>

            <div id="train-hours-form" class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="required fs-6 fw-semibold mb-2" for="hour-edu-input">Số giờ đào tạo</label>
                        <input id="hour-edu-input" type="number" min="0" class="form-control"
                        placeholder="Số giờ đào tạo..." name="train_hours" value="{{ !isset($orderItem) ? '' : $orderItem->train_hours }}">
                    <x-input-error :messages="$errors->get('train_hours')" class="mt-2" />
                </div>
            </div>

        </div>

        <div class="row mb-4">
            <div class="col-lg-7 col-md-7 col-sm-12 col-12 mb-2">
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-2" for="hour-demo-input">Số giờ demo</label>
                        <input id="hour-demo-input" type="number" min="0" class="form-control"
                        placeholder="Số giờ demo..." name="demo_hours" value="{{ !isset($orderItem) ? '' : $orderItem->demo_hours }}">
                </div>
            </div>
        </div>

        <div class="modal-footer flex-center">
            <!--begin::Button-->
            <button id="CreateTrainOrderButton" class="btn btn-primary">
                <span class="indicator-label">Lưu thông tin dịch vụ</span>
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
</form>

<script>
    $(() => {

        EduFormManage.init();
        ServiceHandle.init();
        initJs(document.querySelector('#EduFormManage'));
    });


    var EduFormManage = function() {

        let eduForm;
        let eduPriceManager;
        let demoStudiedHandle;

        const getOrderItem = () => {

            let scheduleItems = null;

            @if($orderItem && $orderItem != null && $orderItem->schedule_items)

            scheduleItems = JSON.parse({!! json_encode($orderItem->schedule_items) !!});

            if(scheduleItems !== null && scheduleItems) {
                if(scheduleItems.length > 0) {
                    for (let i = 0; i < scheduleItems.length; i++) {
                        scheduleItems[i] = JSON.parse(scheduleItems[i]);
                    }
                }
            }
            
            @endif
            return scheduleItems;
        };

        return {
            init: () => {

                eduForm = new EduForm({
                    form: $("#EduFormManage"),
                    url: "{{ action('App\Http\Controllers\Accounting\OrderController@saveOrderItemData') }}",
                    submitBtnId: 'CreateTrainOrderButton',
                    popup: AddTrainOrderPopup.getPopup(),
                    orderItemId: "{{ !isset($orderItem) ? null : $orderItemId }}",
                });

                eduPriceManager = new PriceManager({
                    container: document.querySelector('#EduFormManage'),
                    orderItemScheduleList: getOrderItem()
                });    

                demoStudiedHandle = new DemoStudiedHandle({
                    container: document.querySelector('#demo-container')
                });
            }
        };
    }();

    var DemoStudiedHandle = class {
        constructor(options) {
            this.container = options.container;

            this.init();
            this.events();
        }

        getHaveStudiedForm() {
            return $('#have-studied-form');
        };

        getHaveStudiedInput() {
            return $('#have-studied-select');
        };

        getHaveStudiedValue() {
            return this.getHaveStudiedInput().val();
        };

        getDemoDeductionForm() {
            return $('#demo-deduction-form');
        };

        getDemoDeductionBoxSelect() {
            return $('#has-demo-hour-deduction-box-select');
        };

        getDemoDeductionInput() {
            return $('#has-demo-hour-deduction');
        };

        getDemoDeductionValue() {
            return this.getDemoDeductionInput().val();
        };

        getDemoLetterBox() {
            return this.container.querySelector('#demo-letter-box');
        };

        getTrainHoursForm() {
            return $('#train-hours-form');
        };

        showDemoDeductionForm() {
            this.getDemoDeductionForm().removeClass('d-none');
            this.getHaveStudiedForm().removeClass('col-lg-6 col-md-6 col-sm-12 col-12');
            this.getHaveStudiedForm().addClass('col-lg-4 col-md-4 col-sm-4 col-4');
            this.getTrainHoursForm().removeClass('col-lg-6 col-md-6 col-sm-12 col-12');
            this.getTrainHoursForm().addClass('col-lg-4 col-md-4 col-sm-12 col-12');
        };

        hideDemoDeductionForm() {
            this.getDemoDeductionForm().addClass('d-none');
            this.getHaveStudiedForm().removeClass('col-lg-4 col-md-4 col-sm-4 col-4');
            this.getHaveStudiedForm().addClass('col-lg-6 col-md-6 col-sm-12 col-12');
            this.getTrainHoursForm().removeClass('col-lg-4 col-md-4 col-sm-12 col-12');
            this.getTrainHoursForm().addClass('col-lg-6 col-md-6 col-sm-12 col-12');
        };

        showDemoLetterBox() {
            this.getDemoLetterBox().classList.remove('d-none');
    	    this.getDemoDeductionBoxSelect().removeClass('col-lg-12 col-xs-12 col-sm-12 col-md-12 col-xl-12 pe-0');
            this.getDemoDeductionBoxSelect().addClass('col-lg-8 col-xs-8 col-sm-8 col-md-8 col-xl-8 pe-0');
        };

        hideDemoLetterBox() {
            this.getDemoLetterBox().classList.add('d-none');
            this.getDemoDeductionBoxSelect().removeClass('col-lg-8 col-xs-8 col-sm-8 col-md-8 col-xl-8 pe-0');
            this.getDemoDeductionBoxSelect().addClass('col-lg-12');
        };

        init() {
            let currHaveStudiedVal = this.getHaveStudiedValue();
            let currDemoDeductionVal = this.getDemoDeductionValue();

            if(currHaveStudiedVal == 'true') {
                this.showDemoDeductionForm();
            } else {
                this.hideDemoDeductionForm();
            };

            if(currDemoDeductionVal == 'true') {
                this.showDemoLetterBox();
            } else {
                this.hideDemoLetterBox();
            };
        };

        events() {
            const _this = this;

            this.getHaveStudiedInput().on('change', function() {
                let currVal = $(this).val();

                if(currVal == 'true') {
                    _this.showDemoDeductionForm();
                } else {
                    _this.hideDemoDeductionForm();
                };

            });

            this.getDemoDeductionInput().on('change', function() {
                let currVal = $(this).val();

                if(currVal == 'true') {
                    _this.showDemoLetterBox();
                } else {
                    _this.hideDemoLetterBox();
                };
            });
        };
    };

    var EduForm = class extends OrderForm {
        constructor(options) {
            super(options);
            super.events();
        }

        getProductTypeSelect() {
            return this.form.find('#train-product-type');
        }

        getTypeSelectOptions() {
            return this.getProductTypeSelect().find('option');
        }

        getProductTypeValue() {
            return this.getProductTypeSelect().value;
        }

        updateTypeSelect() {
            const currOptions = this.getTypeSelectOptions();

            for(let i = 0; i < currOptions.length; ++i) {

                if(currOptions[i].value === document.querySelector('#order-type-select').value) {
                    currOptions[i].selected = true;
                }
            }

            const selectedValue = document.querySelector('#order-type-select').value;
            this.getProductTypeSelect().val(selectedValue).trigger('change');
        }

        events() {
            // this.updateTypeSelect();
        }
    }

    var ServiceHandle = function() {
        let currType = document.querySelector('.type-input').value;

        return {
            init: () => {
                servicesManager.setCurrServiceType(currType);
            }
        };
    }();
</script>
@endsection