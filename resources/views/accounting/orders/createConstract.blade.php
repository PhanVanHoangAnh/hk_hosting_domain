@extends('layouts.main.app', [
    'menu' => 'accounting',
])

@section('sidebar')
    @include('accounting.modules.sidebar', [
        'menu' => 'orders',
        'sidebar' =>'create_constract'
    ])
@endsection

@section('content')
<div id="create-constract-content">
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="order-content">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Hợp đồng</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a class="text-muted text-hover-primary">Trang chính</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Hợp đồng</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Hợp đồng</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>
    
    <div class="card-header border-0" id="create-constract-container">
        <form id="create-constract-form">
            @csrf
            <div class="row mb-4">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-request-number-input">Liên hệ</label>
                        <select id="order-request-number-input"  data-control="select2-ajax" data-url="{{ action('App\Http\Controllers\Sales\ContactController@select2') }}" class="form-control " name="contact_id"
                            data-control="select2" data-placeholder="Chọn khách hàng/liên hệ" data-allow-clear="true">
                            @if ($order->contact_id)
                                <option value="{{ $order->contact_id }}" selected>{{ '<strong>' . $order->contacts->name .'</strong><br>'. $order->contacts->email }}</option>
                            @endif
                            {{-- @forEach(App\Models\Contact::all() as $contact)
                            <option value="{{ $contact->id }}" {{ $contact->id == $contactId ? "selected" : ""}}>{{ $contact->name }}</option>
                            @endforeach --}}
                        </select>
                        <x-input-error :messages="$errors->get('contact_id')" class="mt-2" />
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-sale-select">Sale</label>
                        <select id="order-sale-select" class="form-select form-control " name="sale"
                            data-control="select2" data-placeholder="Chọn sale" data-allow-clear="true">
                            <option value="">Chọn sale</option>
                            @forEach(App\Models\Account::all() as $account)
                            <option value="{{ $account->id }}" {{ $order->sale == $account->id ? "selected" : "" }}>{{ $account->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('sale')" class="mt-2" />
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-sale-sup-select">Sale Sup</label>
                        <select id="order-sale-sup-select" class="form-select form-control " name="sale_sup"
                            data-control="select2" data-placeholder="Chọn sale sup" data-allow-clear="true">
                            <option value="">Chọn sale sup</option>
                            @forEach(App\Models\Account::all() as $account)
                            <option value="{{ $account->id }}" {{ $order->sale_sup == $account->id ? "selected" : "" }}>{{ $account->name }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('sale_sup')" class="mt-2" />
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-name-input">Họ và tên học viên</label>
                        <input id="order-name-input" type="text" class="form-control"
                            placeholder="Nhập họ và tên học sinh..." name="fullname" value="{{ $order->name ?? App\Models\Contact::find($contactId)->name }}" />
                            <x-input-error :messages="$errors->get('fullname')" class="mt-2" />
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-birthday-input">Ngày tháng năm sinh</label>

                        <div data-control="date-with-clear-button" class="d-flex align-items-center date-with-clear-button">
                            <input data-control="input" id="order-birthday-input" name="birthday" type="date" class="form-control" placeholder="Nhập ngày sinh..." value="{{ $order->birthday }}">
                            <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                        </div>
                            <x-input-error :messages="$errors->get('birthday')" class="mt-2" />
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-phone-input">Số điện thoại</label>
                        <input id="order-phone-input" type="text" class="form-control"
                            placeholder="Nhập số điện thoại học sinh..." name="phone" value="{{ $order->phone ?? App\Models\Contact::find($contactId)->phone }}" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-4 col-md-4 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-email-input">Email</label>
                        <input id="order-email-input" type="email" class="form-control"
                            placeholder="nguyenvana@gmail.com..." name="email" value="{{ $order->email ?? App\Models\Contact::find($contactId)->email }}" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>
                </div>
                <div class="col-lg-8 col-md-8 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="order-school-input">Trường đang học</label>
                        <input id="order-school-input" type="text" class="form-control"
                            placeholder="Nhập trường học..." name="current_school" value="{{ $order->school ?? App\Models\Contact::find($contactId)->school }}"/>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-parent-name-input">Họ và tên phụ
                            huynh</label>
                        <input id="order-parent-name-input" type="text" class="form-control"
                            placeholder="Nguyễn Văn B" name="parent_fullname" value="{{ $order->parent_fullname }}"/>
                            <x-input-error :messages="$errors->get('parent_fullname')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-parent-phone-input">Số điện thoại phụ
                            huynh</label>
                        <input id="order-parent-phone-input" type="text" class="form-control"
                            placeholder="Nhập số điện thoại phụ huynh..." name="parent_phone" value="{{ $order->parent_phone }}"/>
                            <x-input-error :messages="$errors->get('parent_phone')" class="mt-2"/>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-2">
                    <div class="form-outline">
                        <label class="required fs-6 fw-semibold mb-2" for="order-parent-email-input">Email phụ huynh</label>
                        <input id="order-parent-email-input" type="text" class="form-control"
                            placeholder="tranvanb@gmail..." name="parent_email" value="{{ $order->parent_email }}"/>
                            <x-input-error :messages="$errors->get('parent_email')" class="mt-2"/>
                    </div>
                </div>
            </div>
    
            <div class="row mb-4">
                <div class="col-lg-6 col-md-6 col-sm-12 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="order-notes-text">Ghi chú</label>
                        <textarea id="order-notes-text" class="form-control" rows="1" placeholder="Nhập ghi chú..."
                            name="parent_note">{{ $order->parent_note }}</textarea>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="order-industry-select">Loại dịch vụ</label>
                        <select id="order-industry-select" class="form-select form-control " name="industry"
                            data-control="select2" data-placeholder="Chọn loại dịch vụ" data-allow-clear="true">
                            <option value="">Chọn loại dịch vụ</option>
                            @foreach(config('industries') as $industry)
                            <option value="{{ $industry }}" {{ $order->industry == $industry ? "selected" : "" }}>{{ $industry }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-12 mb-2">
                    <div class="form-outline">
                        <label class="fs-6 fw-semibold mb-2" for="order-type-select">Phân loại</label>
                        <select id="order-type-select" class="form-select form-control " name="type"
                            data-control="select2" data-placeholder="Phân loại" data-allow-clear="true">
                            <option value="">Chọn loại hàng</option>
                            @foreach(config('orderTypes') as $type)
                            <option value="{{ $type }}" {{ $order->type == $type ? "selected" : "" }}>{{ $type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </form>
    
        <div class="form-outline mt-10 d-flex justify-content-center">
            <button id="addTrainOrder" class="btn btn-primary btn-sm mx-5" style="background-color: #243E8E !important;">
                <span class="material-symbols-rounded" style="vertical-align: middle;">
                    school
                </span>
                <span class="mx-2">
                    Yêu cầu dịch vụ đào tạo
                </span>
            </button>
            <button data-action="under-construction" id="demoRequestBtn" class="btn btn-primary btn-sm mx-5"
                style="background-color: #243E8E !important;">
                <span class="material-symbols-rounded" style="vertical-align: middle;">
                    add
                </span>
                <span class="mx-2">
                    Yêu cầu học thử
                </span>
            </button>
            <button id="addTStudyAbroadOrder" class="btn btn-primary btn-sm mx-5"
                style="background-color: #243E8E !important;">
                <span class="material-symbols-rounded" style="vertical-align: middle;">
                    flightsmode
                </span>
                <span class="mx-2">
                    Yêu cầu dịch vụ du học
                </span>
            </button>
        </div>
    
        <div class="card px-10 py-10 mt-10">
            <?php
            if(count($orderItems) > 0) {
            ?>
                @if(count($orderItems) > 0 && collect($orderItems)->contains(function($item) {
                    return $item->type == "Đào tạo";
                }))
                <div class="form-outline">
                    <label class="fs-6 fw-semibold mb-5 fs-3 d-flex align-items-center" for="order-type-select">
                        Dịch vụ đào tạo đã chọn: 
                        <span class="badge badge-primary ms-2 p-2">{{ $orderItems->where('order_items.type', 1)->count() }} Dịch vụ</span>
                    </label>            
                    <div class="table-responsive scrollable-orders-table">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                            <thead>
                                <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom me-3">
                                            <input list-action="check-all" class="form-check-input" type="checkbox" />
                                        </div>
                                    </th>
                                    <th class="min-w-125px text-left">Dịch vụ</th>
                                    <th class="min-w-125px text-left">Môn học</th>
                                    <th class="min-w-125px text-left">Giá dịch vụ</th>
                                    <th class="min-w-125px text-left">% khuyến mãi</th>
                                    <th class="min-w-125px text-left">Giá dịch vụ sau khuyến mãi</th>
                                    {{-- <th class="min-w-125px text-left">Trạng thái</th> --}}
                                    <th class="min-w-125px text-left">Trình độ</th>
                                    <th class="min-w-125px text-left">Loại hình lớp</th>
                                    <th class="min-w-125px text-left">Số lượng học viên</th>
                                    <th class="min-w-125px text-left">Hình thức học</th>
                                    <th class="min-w-125px text-left">Địa điểm đào tạo</th>
                                    <th class="min-w-125px text-left">Số giờ GVNN</th>
                                    <th class="min-w-125px text-left">Số giờ GV Việt Nam</th>
                                    <th class="min-w-125px text-left">Số giờ gia sư</th>
                                    <th class="min-w-125px text-left">Số giờ TA</th>

                                    <th class="min-w-125px text-left">Đơn vị tính</th>
                                    <th class="min-w-125px text-left">target</th>
                                    <th class="min-w-125px text-left">Số giờ demo đã trừ</th>
                                    {{-- <th class="min-w-125px text-left">Chủ nhiệm</th>
                                    <th class="min-w-125px text-left">Thời lượng</th> --}}
                                    <th class="min-w-125px text-left">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @foreach($orderItems as $orderItem)
                                <?php
                                 if($orderItem->type == "Đào tạo") {
                                ?>
                                     <tr list-control="train-order-item">
                                         <td class="text-left">
                                             <div class="form-check form-check-sm form-check-custom">
                                                 <input list-action="check-item" class="form-check-input" type="checkbox" value="1" />
                                             </div>
                                         </td>
                                         <td class="text-left">{{ $orderItem->train_product }}</td>
                                         <td class="text-left">
                                            {{ App\Helpers\Functions::formatNumber($orderItem->price) }} ₫</td>
                                        <td class="text-left">
                                            {{ $orderItem->discount_code . '%'}} ₫</td>
                                        <td class="text-left">
                                            {{ App\Helpers\Functions::formatNumber($orderItem->price) }} ₫</td>
                                         <td class="text-left">{{ $orderItem->level }}</td>
                                         <td class="text-left">{{ $orderItem->class_type }}</td>
                                         <td class="text-left">{{ $orderItem->num_of_student }}</td>
                                         <td class="text-left">{{ $orderItem->study_type == 1 ? "Online" : "Offline"}}</td>
                                         <td class="text-left">{{ $orderItem->branch }}</td>
                                         <td class="text-left">{{ $orderItem->teacher == 1 ? "Giáo viên Việt Nam" : "Giáo viên nước ngoài"}}</td>
                                         <td class="text-left">{{ $orderItem->target }}</td>
                                         <td class="text-left">{{ $orderItem->home_room }}</td>
                                         <td class="text-left">{{ $orderItem->duration }}</td>
                                         <td class="text-left">{{ $orderItem->unit == "hour" ? "Giờ" : "Phút"}}</td>
                                     
                                         <td class="text-center">
                                             <a href="#" class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                                 data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                 style="margin-left: 0px">
                                                 Thao tác
                                                 <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                             <!--begin::Menu-->
                                             <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                                 data-kt-menu="true">
                                                 <!--begin::Menu item-->
                                                 <div class="menu-item px-3">
                                                     <a data-order-item-id="{{ $orderItem->id }}" row-action="update-train-order" class="menu-link px-3">Chỉnh
                                                         sửa</a>
                                                 </div>
                                                 <div class="menu-item px-3">
                                                     <a data-order-item-id="{{ $orderItem->id }}" href="{{ action([App\Http\Controllers\Accounting\OrderItemController::class, 'delete'], [
                                                        'id' => $orderItem->id,
                                                    ]) }}" row-action="delete-train-order" class="menu-link px-3">Xóa</a>
                                                 </div>
                                                 <!--end::Menu item-->
                                             </div>
                                             <!--end::Menu-->
                                         </td>
                                     </tr>
                                <?php
                                 }   
                                ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else 
                <div class="form-outline mt-15">
                    <label class="fs-6 fw-semibold mb-5 fs-3" for="order-type-select">Chưa có Dịch vụ đào tạo!</label>
                </div>
                @endif
        
                @if(count($orderItems) > 0 && collect($orderItems)->contains(function($item) {
                    return $item->type == "Du học";
                }))
                <div class="form-outline mt-15">
                    <label class="fs-6 fw-semibold mb-5 fs-3 d-flex align-items-center" for="order-type-select">
                        Dịch vụ du học đã chọn: 
                        <span class="badge badge-primary ms-2 p-2">{{ $orderItems->where('order_items.type', 0)->count() }} Dịch vụ</span>
                    </label> 
                    <div class="table-responsive scrollable-orders-table">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed fs-6 gy-5" id="dtHorizontalVerticalOrder">
                            <thead>
                                <tr class="text-start text-gray-800 fw-bold fs-7 text-uppercase gs-0 bg-light text-nowrap">
                                    <th class="w-10px pe-2">
                                        <div class="form-check form-check-sm form-check-custom me-3">
                                            <input list-action="check-all" class="form-check-input" type="checkbox" />
                                        </div>
                                    </th>
                                    <th class="min-w-125px text-left">Dịch vụ</th>
                                    <th class="min-w-125px text-left">Giá dịch vụ</th>
                                    <th class="min-w-125px text-left">Thời điểm apply</th>
                                    <th class="min-w-125px text-left">Số trường apply</th>
                                    <th class="min-w-125px text-left">Top trường</th>
                                    <th class="min-w-125px text-left">Giới tính</th>
                                    <th class="min-w-125px text-left">Chương trình đang học</th>
                                    <th class="min-w-125px text-left">GPA lớp 9, 10, 11, 12</th>
                                    <th class="min-w-125px text-left">Điểm thi chuẩn hóa</th>
                                    <th class="min-w-125px text-left">Điểm thi tiếng anh</th>
                                    <th class="min-w-125px text-left">Chương trình dự kiến apply</th>
                                    <th class="min-w-125px text-left">Ngành học dự kiến apply</th>
                                    <th class="min-w-125px text-left">Các giải thưởng học thuật</th>
                                    <th class="min-w-125px text-left">Kế hoạch sau đại học</th>
                                    <th class="min-w-125px text-left">Bạn là người</th>
                                    <th class="min-w-125px text-left">Sở thích trong các môn học</th>
                                    <th class="min-w-125px text-left">Về ngôn ngữ, văn hóa</th>
                                    <th class="min-w-125px text-left">Đã tìm hiểu về hồ sơ</th>
                                    <th class="min-w-125px text-left">Mục tiêu nhắm đến</th>
                                    <th class="min-w-125px text-left">Khả năng viết bài luận tiếng anh</th>
                                    <th class="min-w-125px text-left">hoạt hoạt động ngoại khóa</th>
                                    <th class="min-w-125px text-left">Đơn hàng tư vấn cá nhân</th>
                                    <th class="min-w-125px text-left">Mong muốn khác</th>
                                    <th class="min-w-125px text-left">Nghề nghiệp phụ huynh</th>
                                    <th class="min-w-125px text-left">Học vị cao nhất của phụ huynh</th>
                                    <th class="min-w-125px text-left">Bố mẹ từng đi du học?</th>
                                    <th class="min-w-125px text-left">Thu nhập của phụ huynh</th>
                                    <th class="min-w-125px text-left">Mức am hiểu về du học của phụ huynh</th>
                                    <th class="min-w-125px text-left">Phụ huynh có anh chị em đã/đang/sắp đi du học</th>
                                    <th class="min-w-125px text-left">Thời gian đồng hành cùng con</th>
                                    <th class="min-w-125px text-left">Khả năng chi trả mỗi năm</th>
                                    <th class="min-w-125px text-left">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-600">
                                @foreach($orderItems as $orderItem)
                                <?php
                                 if($orderItem->type == "Du học") {
                                ?>
                                
                                <tr list-control="abroad-order-item">
                                    <td class="text-left">
                                        <div class="form-check form-check-sm form-check-custom">
                                            <input list-action="check-item" class="form-check-input" type="checkbox" value="1" />
                                        </div>
                                    </td>
                                    <td class="text-left">{{ $orderItem->abroad_product }}</td>
                                    <td class="text-left">{{ App\Helpers\Functions::formatNumber($orderItem->price) }}₫</td>
                                    <td class="text-left">{{ $orderItem->apply_time }}</td>
                                    <td class="text-left">{{ $orderItem->num_of_school_apply }}</td>
                                    <td class="text-left">{{ $orderItem->top_school }}</td>
                                    <td class="text-left">{{ $orderItem->gender == "male" ? "Nam" : "Nữ"}}</td>
                                    <td class="text-left">{{ $orderItem->current_program }}</td>
                                    <td class="text-left">{{ $orderItem->GPA }}</td>
                                    <td class="text-left">{{ $orderItem->std_score }}</td>
                                    <td class="text-left">{{ $orderItem->eng_score }}</td>
                                    <td class="text-left">{{ $orderItem->plan_apply }}</td>
                                    <td class="text-left">{{ $orderItem->intended_major }}</td>
                                    <td class="text-left">{{ $orderItem->academic_award }}</td>
                                    <td class="text-left">{{ $orderItem->postgraduate_plan }}</td>
                                    <td class="text-left">{{ $orderItem->personality }}</td>
                                    <td class="text-left">{{ $orderItem->subject_preference }}</td>
                                    <td class="text-left">{{ $orderItem->language_culture }}</td>
                                    <td class="text-left">{{ $orderItem->research_info }}</td>
                                    <td class="text-left">{{ $orderItem->aim }}</td>
                                    <td class="text-left">{{ $orderItem->essay_writing_skill }}</td>
                                    <td class="text-left">{{ $orderItem->extra_activity }}</td>
                                    <td class="text-left">{{ $orderItem->personal_countling_need }}</td>
                                    <td class="text-left">{{ $orderItem->other_need_note }}</td>
                                    <td class="text-left">{{ $orderItem->parent_job }}</td>
                                    <td class="text-left">{{ $orderItem->parent_highest_academic }}</td>
                                    <td class="text-left">{{ $orderItem->is_parent_studied_abroad }}</td>
                                    <td class="text-left">{{ $orderItem->parent_income }}</td>
                                    <td class="text-left">{{ $orderItem->parent_familiarity_abroad }}</td>
                                    <td class="text-left">{{ $orderItem->is_parent_family_studied_abroad == "yes" ? "Có" : "Không có"}}</td>
                                    <td class="text-left">{{ $orderItem->parent_time_spend_with_child }}</td>
                                    <td class="text-left">{{ $orderItem->financial_capability }} $</td>
                                    
                                    <td class="text-left">
                                        <a href="#" class="btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                                            data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                            style="margin-left: 0px">
                                            Thao tác
                                            <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                                        <!--begin::Menu-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4"
                                            data-kt-menu="true">
                                            <!--begin::Menu item-->
            
                                            <div class="menu-item px-3">
                                                <a data-order-item-id="{{ $orderItem->id }}" row-action="update-abroad-order" class="menu-link px-3">Chỉnh
                                                    sửa</a>
                                            </div>
                                            <div class="menu-item px-3">
                                                <a data-order-item-id="{{ $orderItem->id }}" href="{{ action([App\Http\Controllers\Accounting\OrderItemController::class, 'delete'], [
                                                    'id' => $orderItem->id,
                                                ]) }}" row-action="delete-abroad-order" class="menu-link px-3">Xóa</a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu-->
                                    </td>
                                </tr>
            
                                <?php
                                 }   
                                ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
        
                @else
                <div class="form-outline mt-15">
                    <label class="fs-6 fw-semibold mb-5 fs-3" for="order-type-select">Chưa có Dịch vụ du học!</label>
                </div>
                @endif
            <?php 
            } else {
            ?> 
                <div class="text-center">
                    <label class="fs-6 fw-semibold fs-3 d-flex align-items-center justify-content-center" for="order-type-select">
                        Chưa có dịch vụ nào được thêm vào hợp đồng này. Nhấn các nút thêm dịch vụ bên trên để thêm dịch vụ vào hợp đồng.
                    </label>
                </div>
            <?php
            }
            ?>
        </div>
        
        <div class="text-right form-outline my-10 d-flex flex-column justify-content-end align-items-end px-20">
            <div class="row w-25">
                <div class="col-lg-5 col-sm-5 col-xs-5 col-md-5 col-xl-5">
                    <div class="mb-5">
                        <div class="fs-4 mb-2">
                            <span class="fw-bold">Tổng giá:</span> 
                        </div>
                        <div class="fs-4 mb-2">
                            <span class="fw-bold">Giảm giá:</span>
                        </div>
                        <div class="fs-4">
                            <span class="fw-bold">Tổng cộng:</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 col-sm-7 col-xs-7 col-md-7 col-xl-7">
                    <div class="mb-5">
                        <div class="fs-4 me-0 mb-2 d-flex justify-content-end">
                            <span
                                class="me-0 text-primary fw-bold">{{ number_format($order->getPriceBeforeDiscount(), 0, '.', ',') }}₫</span>
                        </div>
                        <div class="fs-4 me-0 d-flex justify-content-end mb-2">
                            <span
                                class="me-0 text-primary fw-bold">{{ number_format($order->getPriceBeforeDiscount() - $order->getTotal(), 0, '.', ',') }}₫</span>
                        </div>
                        <div class="fs-4 me-0 d-flex justify-content-end">
                            <span
                                class="me-0 text-primary fw-bold">{{ number_format($order->getTotal(), 0, '.', ',') }}₫</span>
                        </div>
                    </div>
                </div>
            </div>
    
        </div>
    
        <div class="form-outline mt-10 d-flex justify-content-center">
            <div class="mt-5">
                <button id="saveOrdersBtn" class="btn btn-primary">Lưu hợp đồng</button>
                <a href="{{action('App\Http\Controllers\Accounting\OrderController@index')}}" id="cancelCreateConstractBtn"
                    class="btn btn-secondary">Hủy</a>
            </div>
    
        </div>
    </div>
    
    <script>
    $(() => {
        OrdersIndex.init();
    });
    
    var OrdersIndex = function() {
        return {
            init: () => {
                AddTrainOrderPopup.init();
                AddAbroadOrderPopup.init();
                CreateConstractManager.init();
            }
        }
    }();
    
    var CreateConstractManager = function() {
        
        let createManage;
        let servicesManager;
        
        return {
            init: () => {
                createManage = new Constract({
                    orderId : "{{ $orderId }}"
                });
            }
        };
    }();
    
    var Constract = class {
        constructor(options) {
            this.orderId = options.orderId;
            this.container = document.querySelector("#create-constract-container");
            this.trainOrderItems = document.querySelectorAll('[list-control="train-order-item"]');
            this.abroadOrderItems = document.querySelectorAll('[list-control="abroad-order-item"]');
    
            this.events();
        };
    
        getCreateTrainOrderBtn() {
            return document.querySelector("#addTrainOrder");
        };
    
        getCreateAbroadOrderBtn() {
            return document.querySelector("#addTStudyAbroadOrder");
        };
    
        getSaveConstractBtn() {
            return document.querySelector("#saveOrdersBtn");
        };
    
        showCreateTraiOrderPopup() {
            AddTrainOrderPopup.updateUrl("{{ action('App\Http\Controllers\Accounting\OrderController@createTrainOrder') }}");
        };
    
        showCreateAbroadOrderPopup() {
            AddAbroadOrderPopup.updateUrl("{{ action('App\Http\Controllers\Accounting\OrderController@createAbroadOrder') }}")
        };
    
        getConstractForm() {
            return $("#create-constract-form");
        };
    
        getConstractData() {
            return this.getConstractForm().serialize();
        };

        getUpdateTrainOrderBtns() {
            return document.querySelectorAll('[row-action="update-train-order"]');
        };

        getDeleteTrainOrderBtns() {
            return document.querySelectorAll('[row-action="delete-train-order"]');
        };

        getUpdateAbroadOrderBtns() {
            return document.querySelectorAll('[row-action="update-abroad-order"]');
        };

        getDeleteAbroadOrderBtns() {
            return document.querySelectorAll('[row-action="delete-abroad-order"]');
        };
    
        addSubmitEffect() {
            this.getSaveConstractBtn().setAttribute('data-kt-indicator', 'on');
            this.getSaveConstractBtn().setAttribute('disabled', true);
        };
    
        removeSubmitEffect() {
            this.getSaveConstractBtn().removeAttribute('data-kt-indicator');
            this.getSaveConstractBtn().removeAttribute('disabled');
        };
    
        addLoadingEffect() {
    
            this.container.classList.add("list-loading");
    
            if (!this.container.querySelector('[list-action="loader"]')) {
                $(this.container).before(`
                    <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);
            };
        };
    
        removeLoadingEffect() {
            this.container.classList.remove("list-loading");
    
            if (this.container.querySelector('[list-action="loader"]')) {
                this.container.querySelector('[list-action="loader"]').remove();
            };
        };
    
        saveConstractData() {
            let formData = this.getConstractData() + `&order_id=${this.orderId}`;
    
            this.addSubmitEffect();
            this.addLoadingEffect();
    
            $.ajax({
                url: "{{ action('App\Http\Controllers\Accounting\OrderController@saveConstractData') }}",
                method: "POST",
                data: formData
            }).done(response => {
    
                this.removeSubmitEffect();
                this.removeLoadingEffect();
    
                ASTool.alert({
                    message: response.message,
                    ok: () => {
                        this.addLoadingEffect();
                        window.location.href = `orders`;
                    }
                });
    
            }).fail(response => {
                this.removeSubmitEffect();
                this.removeLoadingEffect();
    
                let updateContent = $(response.responseText).find('#create-constract-content');

                $('#create-constract-content').html(updateContent);

                initJs($('#create-constract-content')[0]);
            });
        };
    
        events() {

            let _this = this;
            
            /**
             * When click create train order button
             */
            this.getCreateTrainOrderBtn().addEventListener('click', e => {
                e.preventDefault();
                this.showCreateTraiOrderPopup();
            });
    
            /**
             * When click create abroad study order button
             */
            this.getCreateAbroadOrderBtn().addEventListener('click', e => {
                e.preventDefault();
                this.showCreateAbroadOrderPopup();
            });
    
            /** 
            * When click save constract 
            */
            this.getSaveConstractBtn().addEventListener('click', e => {
                    e.preventDefault();
        
                    this.saveConstractData();
            });

           /**
            * Click update train order item
            */ 
           this.getUpdateTrainOrderBtns().forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const orderItemId = this.getAttribute('data-order-item-id');

                    const url = " {{ action('App\Http\Controllers\Accounting\OrderController@createTrainOrder', ['orderItemId' => 'PLACEHOLDER']) }} ";

                    const updatedUrl = url.replace('PLACEHOLDER', orderItemId);

                    AddTrainOrderPopup.updateUrl(updatedUrl);
                });
           });

           /**
            * Click delete train order item
            */ 
           this.getDeleteTrainOrderBtns().forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const url = this.getAttribute('href');

                    ASTool.confirm({
                        message: "Bạn có chắc muốn xóa Dịch vụ đào tạo này không?",
                        ok: function() {
                            ASTool.addPageLoadingEffect();

                            $.ajax({
                                url: url,
                                method: "DELETE",
                                data: {
                                    _token: "{{ csrf_token() }}"
                                }
                            }).done(response => {

                                const orderId = " {{ $orderId }} ";

                                _this.addLoadingEffect();

                                ASTool.alert({
                                    message: response.message,
                                    ok: function() {
                                        window.location.href = `orders/create-constract\\${orderId}\\update`;
                                    }
                                })
                            }).fail(function() {

                            }).always(function() {
                                ASTool.removePageLoadingEffect();
                            })
                        }
                    });
                })
           });

           /**
            * Click delete abroad order item
            */ 
            this.getDeleteAbroadOrderBtns().forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const url = this.getAttribute('href');

                    ASTool.confirm({
                        message: "Bạn có chắc muốn xóa Dịch vụ du học này không?",
                        ok: function() {
                            ASTool.addPageLoadingEffect();

                            $.ajax({
                                url: url,
                                method: "DELETE",
                                data: {
                                    _token: "{{ csrf_token() }}"
                                }
                            }).done(response => {

                                const orderId = " {{ $orderId }} ";

                                _this.addLoadingEffect();

                                ASTool.alert({
                                    message: response.message,
                                    ok: function() {
                                        window.location.href = `orders/create-constract\\${orderId}\\update`;
                                    }
                                })
                            }).fail(function() {

                            }).always(function() {
                                ASTool.removePageLoadingEffect();
                            })
                        }
                    });
                })
           });

           /**
            * Click update abroad order item
            */ 
           this.getUpdateAbroadOrderBtns().forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const orderItemId = this.getAttribute('data-order-item-id');

                    const url = " {{ action('App\Http\Controllers\Accounting\OrderController@createAbroadOrder', ['orderItemId' => 'PLACEHOLDER']) }} ";

                    const updatedUrl = url.replace('PLACEHOLDER', orderItemId);

                    AddAbroadOrderPopup.updateUrl(updatedUrl);
                });
           })
        };
    };
    
    var OrderForm = class {
        constructor(options) {
            this.container = document.querySelector("#create-constract-container");
            this.form = options.form;
            this.containerId = options.containerId;
            this.url = options.url;
            this.submitBtnId = options.submitBtnId;
            this.orderId = "{{ $orderId }}";
            this.orderItemId = options.orderItemId;
            this.popup = options.popup;
            this.events();
        };

        getFormData() {
            return this.form.serialize();
        };

        getSaveDataBtn() {
            return document.querySelector(`#${this.submitBtnId}`);
        };
    
        addSubmitEffect() {
            this.getSaveDataBtn().setAttribute('data-kt-indicator', 'on');
            this.getSaveDataBtn().setAttribute('disabled', true);
        };
    
        removeSubmitEffect() {
            this.getSaveDataBtn().removeAttribute('data-kt-indicator');
            this.getSaveDataBtn().removeAttribute('disabled');
        };
    
        addLoadingEffect() {
    
            this.container.classList.add("list-loading");
    
            if (!this.container.querySelector('[list-action="loader"]')) {
                $(this.container).before(`
                    <div list-action="loader" class="py-20 px-3 text-center position-absolute" style="left:calc(50% - 20px);top:20px;">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `);
            };
        };
    
        removeLoadingEffect() {
            this.container.classList.remove("list-loading");
    
            if (this.container.querySelector('[list-action="loader"]')) {
                this.container.querySelector('[list-action="loader"]').remove();
            };
        };
    
        saveDataIntoOrder(formData) {
    
            formData += `&order_id=${this.orderId}&order_item_id=${this.orderItemId}`;
    
            this.addSubmitEffect();
    
            $.ajax({
                url: this.url,
                method: "POST",
                data: formData
            }).done(response => {
                const orderId = this.orderId;
    
                this.removeSubmitEffect();
                this.popup.hide();
                
                ASTool.alert({
                    message: response.message,
                    ok: () => {
                        this.addLoadingEffect();
                        window.location.href = `orders/create-constract\\${orderId}\\create`;
                    }
                });
            }).fail(response => {
                this.removeSubmitEffect();
                this.popup.setContent(response.responseText);
                initJs(document.querySelector(this.containerId));
            });
        };
    
        events() {
            this.getSaveDataBtn().addEventListener('click', e => {
                e.preventDefault();

                this.saveDataIntoOrder(this.getFormData());
            })
        };
    }

    var PriceManager = class {
        #VN_CURRENCY = '₫';
        #USD_CURRENCY = '$';

        constructor(options) {
            this.container = options.container;
            this.orderItemScheduleList = options.orderItemScheduleList;
            this.scheduleManager = new ScheduleManager({
                priceManager: this
            });

            this.#init();
            this.events();
        }

        // Getter & setter
        getOrderItemScheduleList() {

            return this.orderItemScheduleList;
        };
        
        getPriceInput() {

            return this.container.querySelector('#price-create-input');
        };

        getPriceInputValue() {

            return this.getPriceInput().value;
        };

        getExchangeInput() {

            return this.container.querySelector('#exchange-input');
        };

        getExchangeInputValue() {

            return this.getExchangeInput().value;
        };
        
        getCurrencyCodeInput() {

            return this.container.querySelector('#currency-select');
        };

        getCurrencyCodeInputValue() {

            return this.getCurrencyCodeInput().value;
        };

        getDiscountPercentInput() {

            return this.container.querySelector('#discount-create-input');
        };

        getDiscountPercentInputValue() {

            return this.container.querySelector('#discount-create-input').value;
        };

        getPriceAfterDiscountLabel() {

            return this.container.querySelector('#price-after-discount');
        };

        getListCurrencySymbols() {

            return this.container.querySelectorAll('[list-symbol="currency"]');
        };

        getDiscountPercentErrorLabel() {

            return this.container.querySelector('#error-discount-percent');
        };

        getPriceErrorLabel() {

            return this.container.querySelector('#error-price');
        };

        getPayAllCheckBox() {

            return this.container.querySelector('#is-payall-checkbox');
        };

        getSchedulePaymentForm() {

            return this.container.querySelector('#schedule-payment-form');
        };

        getExchangeForm() {
            return this.container.querySelector('#exchange-form');
        };

        getExchangeErrorLabel() {
            return this.container.querySelector('#error-exchange');
        };

        // Caculate
        // Business: currency must be in VND format in all cases
        #caculatePriceAfterDiscount() {

            if(!(this.#validateDiscountPercentInput() 
                && this.#validatePriceInput() 
                && this.#validateExchangeInput())) {
                return 0;
            };

            let currPriceValue = parseFloat(String(this.getPriceInputValue()).trim().replace(/[.\s,]/g, ''));
            let currDiscountPercent = this.getDiscountPercentInputValue();
            let currExchange = this.getExchangePriceValue();

            return currPriceValue * currExchange * (1 - currDiscountPercent / 100);
        };

        getPriceAfterDiscountValue() {

            return this.#caculatePriceAfterDiscount();
        };

        getExchangePriceValue() {

            if(this.getCurrencyCodeInputValue() === 'VND') {
                return 1;
            };

            let exchange = parseFloat(String(this.getExchangeInputValue()).trim().replace(/[.\s,]/g, ''));

            if(isNaN(exchange) || exchange === 0) {
                exchange = 1;
            };

            return exchange;
        };

        // Handle errors
        showDiscountErrorLabel() {

            this.getDiscountPercentErrorLabel().classList.remove('d-none');
        };

        hideDiscountErrorLabel() {

            this.getDiscountPercentErrorLabel().classList.add('d-none');
        };

        showExchangeErrorLabel() {

            this.getExchangeErrorLabel().classList.remove('d-none');
        };

        hideExchangeErrorLabel() {

            this.getExchangeErrorLabel().classList.add('d-none');
        };

        showPriceErrorLabel() {

            this.getPriceErrorLabel().classList.remove('d-none');
        };

        hidePriceErrorLabel() {

            this.getPriceErrorLabel().classList.add('d-none');
        };

        // Actions
        #validatePriceInput() {

            let priceValue = String(this.getPriceInputValue()).trim().replace(/[.\s,]/g, '');

            let isValid = true;
        
            if(priceValue === '') {
                return isValid;
            };

            isValid = String(parseFloat(priceValue)) === priceValue 
                    && (parseFloat(priceValue) >= 0);

            if(!isValid) {
                this.showPriceErrorLabel();
            } else {
                this.hidePriceErrorLabel();
            };

            return isValid;
        };

        #validateExchangeInput() {

            let priceValue = String(this.getExchangeInputValue()).trim().replace(/[.\s,]/g, '');
            let isValid = true;
        
            if(priceValue === '') {
                return isValid;
            };

            isValid = String(parseFloat(priceValue)) === priceValue 
                    && (parseFloat(priceValue) >= 0);

            if(!isValid) {
                this.showExchangeErrorLabel();
            } else {
                this.hideExchangeErrorLabel();
            };

            return isValid;
        };

        #validateDiscountPercentInput() {

            let percentValue = String(this.getDiscountPercentInputValue()).trim();

            let isValid = true;
        
            if(percentValue === '') {
                return isValid;
            };

            isValid = String(parseFloat(percentValue)) === percentValue 
                    && (parseFloat(percentValue) >= 0 && parseFloat(percentValue) <= 100);

            if(!isValid) {
                this.showDiscountErrorLabel();
            } else {
                this.hideDiscountErrorLabel();
            };

            return isValid;
        };
        
        updatePriceAfterDiscountLabel(discountedPrice) {

            /** 
             * If discountedPrice is NaN: 
             * It means that the user has previously entered a price, then deleted it
             * Resulting in price === 0
             */
            if(isNaN(discountedPrice)) {
                discountedPrice = 0;
            };

            this.getPriceAfterDiscountLabel().innerHTML = this.convertNumberWithCommas(discountedPrice);
        };

        updateAllCurrencyDisplay() {

            let currCurrency;

            currCurrency = this.getCurrencyCodeInputValue() === 'VND' ? this.#VN_CURRENCY : this.#USD_CURRENCY;

            this.getListCurrencySymbols().forEach(label => {
                label.innerHTML = currCurrency;
            });
        };

        convertNumberWithCommas(number) {

            return parseFloat(number)
                    .toFixed(0)
                    .toString()
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        };

        convertDateFormat(dateInput) {

            const parts = dateInput.split('-');
            return `${parts[2]}-${parts[1]}-${parts[0]}`;
        };

        #handleCheckPayall() {

            let isCheck = this.getPayAllCheckBox().checked;

            if(isCheck) {
                this.hideSchedulePaymentForm();
            } else {
                this.showSchedulePaymentForm();
            };
        };

        showSchedulePaymentForm() {

            this.getPayAllCheckBox().checked = false;
            this.getSchedulePaymentForm().classList.remove('d-none');
            this.scheduleManager.enableItems();
        };

        hideSchedulePaymentForm() {

            this.getPayAllCheckBox().checked = true;
            this.getSchedulePaymentForm().classList.add('d-none');
            this.scheduleManager.disableItems();
        };

        #showExchangeForm() {
            this.getExchangeForm().classList.remove('d-none');
        };

        #hideExchangeForm() {
            this.getExchangeForm().classList.add('d-none');
        };

        #exchangeFormHandle() {

            const isUsd = this.getCurrencyCodeInputValue() === "{!! \App\Models\Order::CURRENCY_CODE_USD !!}";

            if(isUsd) {
                this.#showExchangeForm();
            } else {
                this.#hideExchangeForm();
            };
        };

        /**
        * Refresh when (in events): 
        *   + Change price input
        *   + Change currency 
        *   + Change discount percent input
        *   + Change exchange input (in case: the currency is USD)   
        */
        refresh() {

            this.updatePriceAfterDiscountLabel(this.#caculatePriceAfterDiscount());
            this.updateAllCurrencyDisplay();
            this.#validateDiscountPercentInput();
            this.#validatePriceInput();
            this.#validateExchangeInput();
        };

        #init() {

            // Init input mask
            const priceInputMask = IMask(this.getPriceInput(), {
                mask: Number,
                scale: 2,
                thousandsSeparator: ',',
                padFractionalZeros: false,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.'],
                min: 0,
                max: 999999999999,
            });

            const exchangeInputMask = IMask(this.getExchangeInput(), {
                mask: Number,
                scale: 2,
                thousandsSeparator: ',',
                padFractionalZeros: false,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.'],
                min: 0,
                max: 999999999999,
            });
        };

        events() {

            // Change price input
            this.getPriceInput().addEventListener('change', e => {
                e.preventDefault();
                
                this.refresh();
            });

            // Change currency 
            this.getCurrencyCodeInput().addEventListener('change', e => {
                e.preventDefault();

                this.#exchangeFormHandle();
                this.refresh();
            });

            // Change discount percent input
            this.getDiscountPercentInput().addEventListener('change', e => {
                e.preventDefault();

                this.refresh();
            });

             // Change exchange input
             this.getExchangeInput().addEventListener('change', e => {
                e.preventDefault();
                
                this.refresh();
            });

            this.getPayAllCheckBox().addEventListener('change', e => {
                e.preventDefault();

                this.#handleCheckPayall();
            });

            this.#exchangeFormHandle();
        };
    };

    var ScheduleManager = class {
        #priceManager
        #discountedPrice
        #scheduleItemIndex = 0;
        #scheduleItems = [];
        #schedulePriceInputMask;

        constructor(options) {
            this.#priceManager = options.priceManager;
            this.#discountedPrice = options.discountedPrice;

            this.#init();
            this.#render();
            this.#events();
        }

        // Getters & setters
        getSchedulePriceInput() {
            return this.#priceManager.container.querySelector('#schedule-price-input');
        };

        getSchedulePriceInputValue() {
            return this.getSchedulePriceInput().value;
        };

        getScheduleDateInput() {
            return this.#priceManager.container.querySelector('#schedule-date-input');
        };

        getScheduleDateInputValue() {
            return this.getScheduleDateInput().value;
        };

        getBalancePriceLabel() {
            return this.#priceManager.container.querySelector('#balance-form');
        };

        getListScheduleItemsForm() {
            return this.#priceManager.container.querySelector('#list-schedule-items-content');
        };

        getAddScheduleButton() {
            return this.#priceManager.container.querySelector('#add-schedule-btn');
        };

        getItemPriceErrorLabel() {
            return this.#priceManager.container.querySelector('#error-price-schedule');
        };

        getItemDateErrorLabel() {
            return this.#priceManager.container.querySelector('#error-date-schedule');
        };
        
        getDeleteItemBtns() {
            return this.#priceManager.container.querySelectorAll('[row-action="delete-item-btn"]');
        };

        getExistedScheduleList() {
            return this.#priceManager.getOrderItemScheduleList();
        };

        getDataItems() {
            return this.#priceManager.container.querySelectorAll('[data-item="schedule-item"]');
        };

        // Handle errors
        showItemPriceErrorLabel() {

            this.getItemPriceErrorLabel().classList.remove('d-none');
        };

        hideItemPriceErrorLabel() {

            this.getItemPriceErrorLabel().classList.add('d-none');
        };

        showItemDateErrorLabel() {

            this.getItemDateErrorLabel().classList.remove('d-none');
        };

        hideItemDateErrorLabel() {

            this.getItemDateErrorLabel().classList.add('d-none');
        };

        // Actions
        #validateItemPriceInputValue() {

            let priceValue = String(this.getSchedulePriceInputValue()).trim().replace(/[.\s,]/g, '');
            let isValid = true;

            isValid = String(parseFloat(priceValue)) === priceValue 
                    && (parseFloat(priceValue) >= 0) && (priceValue !== '');

            if(!isValid) {
                isValid = false;
            } else {
                isValid = true;
            };

            return isValid;
        };

        #validateItemDateInputValue() {
            
            const dateInput = this.getScheduleDateInputValue();

            if (!/^\d{4}-\d{2}-\d{2}$/.test(dateInput)) {
                return false;
            };

            const parts = dateInput.split('-');
            const year = parseInt(parts[0], 10);
            const month = parseInt(parts[1], 10);
            const day = parseInt(parts[2], 10);

            if (year < 1000 || year > 9999 || month < 1 || month > 12 || day < 1 || day > 31) {
                return false;
            };

            if (day > 30 && (month === 4 || month === 6 || month === 9 || month === 11)) {
                return false;
            };

            // Validate leap years
            if (month === 2) {
                const isLeapYear = (year % 4 === 0 && year % 100 !== 0) || (year % 400 === 0);

                if (day > 29 || (day > 28 && !isLeapYear)) {
                    return false;
                };
            };

            return true;
        };

        observePriceAfterDiscountChanges() {

            const priceAfterDiscount = this.#priceManager.getPriceAfterDiscountLabel();

            const observer = new MutationObserver((mutationsList) => {
                for (const mutation of mutationsList) {
                    if (mutation.type === 'childList') {
                        this.#render();
                    };
                };
            });

            observer.observe(priceAfterDiscount, { childList: true });
        };

        #addScheduleItem() {

            // At the time of executing this function, the entered values for price and date have already been validated
            let currPrice = parseFloat(String(this.getSchedulePriceInputValue()).trim().replace(/[.\s,]/g, ''));
            let currDate = this.getScheduleDateInputValue();

            const newItem = {
                index: this.#scheduleItemIndex,
                price: currPrice,
                date: currDate
            };

            this.#scheduleItems.push(newItem);
            this.#upIndex();
            this.#render();
        };

        #refreshScheduleItemInputForm() {

            this.getSchedulePriceInput().value = '';
            this.getScheduleDateInput().value = '';

            /** 
             * Have to make the mask update its value using the updateValue() method to make it work; 
             * This is a feature of the input mask;
             * Unless => Input mask alert in console
             */
            this.#schedulePriceInputMask.updateValue("");
        };

        handleAddItemErrors() {

            let handlePriceResult = false;
            let handleDateResult = false;

            if(!this.#validateItemPriceInputValue()) {
                this.showItemPriceErrorLabel();
                handlePriceResult = false;
            } else {
                this.hideItemPriceErrorLabel();
                handlePriceResult = true;
            };

            if(!this.#validateItemDateInputValue()) {
                this.showItemDateErrorLabel();
                handleDateResult = false;
            } else {
                this.hideItemDateErrorLabel();
                handleDateResult = true;
            };

            return handlePriceResult && handleDateResult;
        }

        #upIndex() {

            this.#scheduleItemIndex++;
        };

        #getTotalPriceOfScheduleItems() {

            return this.#scheduleItems.reduce((acc, curr) => acc + curr.price, 0);
        };     

        #caculateBalancePrice() {

            let currPriceAfterDiscountValue = this.#priceManager.getPriceAfterDiscountValue();
            let currTotalPriceOfScheduleItems = this.#getTotalPriceOfScheduleItems();
            
            /** 
             * In case currPriceAfterDiscountValue === 0, 
             * Tt means the user has not entered a value for the selling price field yet
             */
            if(isNaN(currPriceAfterDiscountValue)) {
                currPriceAfterDiscountValue = 0;
            };
            
            if(this.#priceManager.getCurrencyCodeInputValue() === "{!! \App\Models\Order::CURRENCY_CODE_USD !!}") {
                let currExchange = this.#priceManager.getExchangePriceValue();
                currPriceAfterDiscountValue /= currExchange;
            };

            return currPriceAfterDiscountValue - currTotalPriceOfScheduleItems;
        };

        #updateBalanceLabel() {

            this.getBalancePriceLabel().innerHTML = this.#priceManager.convertNumberWithCommas(this.#caculateBalancePrice());
        };

        // Refresh when render done
        #refreshForm() {

            this.#refreshScheduleItemInputForm();
            this.#updateBalanceLabel();
        };

        #removeItemByIndex(index) {

            let itemToRemoveIndex = -1;

            this.#scheduleItems.forEach(item => {
                
                let flag = true;

                if(item.index === parseInt(index)) {
                    itemToRemoveIndex = item.index;
                };
            });

            const removeIndex = this.#scheduleItems.findIndex(schedule => schedule.index === itemToRemoveIndex);

            if(removeIndex !== -1) {
                this.#scheduleItems.splice(removeIndex, 1);
                this.#render();
            };
        };
        
        enableItems() {
            const items = this.getDataItems();

            if(items && items.length > 0) {
                this.getDataItems().forEach(item => {
                    item.removeAttribute('disabled');
                });
            };
        };

        disableItems() {
            const items = this.getDataItems();

            if(items && items.length > 0) {
                this.getDataItems().forEach(item => {
                    item.setAttribute('disabled', '');
                });
            };
        };

        #handleReloadScheduleForm(isShow) {

            if(isShow) {
                this.#priceManager.getPayAllCheckBox().checked = false;
                this.#priceManager.getSchedulePaymentForm().classList.remove('d-none');
                this.enableItems();
            } else {
                this.#priceManager.getPayAllCheckBox().checked = true;
                this.#priceManager.getSchedulePaymentForm().classList.add('d-none');
                this.disableItems();
            };
        };

        #loadExistedScheduleItemList() {
            let existedList = this.getExistedScheduleList();

            const isExisted = existedList !== null;

            this.#handleReloadScheduleForm(isExisted);

            if(existedList) {
                existedList.forEach(item => {
                    this.#scheduleItems.push({
                        index: this.#scheduleItemIndex,
                        price: item.price,
                        date: item.date,
                    });

                    this.#upIndex();
                });
            };

            this.#render();
        };

        #init() {
            // Init input mask
            this.#schedulePriceInputMask = IMask(document.getElementById('schedule-price-input'), {
                mask: Number,
                scale: 2,
                thousandsSeparator: ',',
                padFractionalZeros: false,
                normalizeZeros: true,
                radix: ',',
                mapToRadix: ['.'],
                min: 0,
                max: 999999999999,
            })
        };

        /** 
         * Render when: 
         *  + Init instance 
         *  + Add item 
         *  + Remove item 
         *  + Change value of price after discount => observePriceAfterDiscountChanges()
        */
        #render() {

            let content = '';

            this.#scheduleItems.forEach(item => {
                content += 
                    `
                        <li data-index=${item.index} class="list-group-item d-flex align-items-center justify-content-between">
                            <input type="hidden" name="schedule_items[]" data-item="schedule-item" value='${JSON.stringify({ price: item.price, date: item.date })}'>
                            <label class="fs-6 fw-semibold" for="target-input">${this.#priceManager.convertNumberWithCommas(item.price)}&nbsp;<div class="d-inline" list-symbol="currency"></div>&nbsp;&nbsp;|&nbsp;&nbsp;${this.#priceManager.convertDateFormat(item.date)}</label>
                            <span row-action="delete-item-btn" data-index=${item.index} class="material-symbols-rounded cursor-pointer">delete</span>
                        </li>
                    `
            });

            this.getListScheduleItemsForm().innerHTML = content;
            this.#refreshForm();
            this.#eventsAfterRender();
            this.#priceManager.updateAllCurrencyDisplay();
            $(this.getListScheduleItemsForm());
            initJs(this.#priceManager.container);
        };

        #events() {

            this.#loadExistedScheduleItemList();

            // When value of price after discount change
            this.observePriceAfterDiscountChanges();

            this.getAddScheduleButton().addEventListener('click', e => {
                e.preventDefault();

                if(!this.handleAddItemErrors()) {
                    return;
                };

                this.#addScheduleItem();
            });
        };

        #eventsAfterRender() {

            this.getDeleteItemBtns().forEach(button => {

                button.addEventListener('click', e => {
                    e.preventDefault();

                    this.#removeItemByIndex(button.getAttribute('data-index'));
                });
            });
        };
    };
    
    var AddTrainOrderPopup = function() {
        let AddOrderPopup;
    
        return {
            init: () => {
                AddOrderPopup = new Popup();
            },
            updateUrl: newUrl => {
                AddOrderPopup.url = newUrl;
                AddOrderPopup.load();
            },
            getPopup: () => {
                return AddOrderPopup;
            }
        }
    }();
    
    var AddAbroadOrderPopup = function() {
        let AddOrderPopup;
    
        return {
            init: () => {
                AddOrderPopup = new Popup();
            },
            updateUrl: newUrl => {
                AddOrderPopup.url = newUrl;
                AddOrderPopup.load();
            },
            getPopup: () => {
                return AddOrderPopup;
            }
        }
    }();

    var ServicesManager = class {
        #servicesSystem;
        #currServiceType;
        #currType
        #currService
        
        constructor(options) {
            this.#servicesSystem = options.servicesSystem;

            this.#init();
            this.#events();
        }

        getTypeSelect() {
            return document.querySelector('#product-type');
        };

        loadTypes(types) {

            let typeContent = 
            `
                <option value="">Chọn loại hàng</option>
            `;

            types.forEach(type => {
                typeContent += `<option value="${type}">${type}</option>`
            });

            this.getTypeSelect().innerHTML = typeContent;
        };

        getServicesSystem() {
            return this.#servicesSystem;
        };

        setCurrServiceType(currServiceType) {
            if(this.#currServiceType !== currServiceType) {
                this.#currServiceType = currServiceType;
            };

            this.#reloadAllCurrValues();
        };

        getCurrServiceType() {
            return this.#currServiceType;
        };

        setCurrType(currType) {
            if(this.#currType !== currType) {
                this.#currType = currType;
            };

            this.#reloadAllCurrValues();
        };

        getCurrType() {
            return this.#currType;
        };

        setCurrService(currService) {
            if(this.#currService !== currService) {
                this.#currService = currService;
            };

            this.#reloadAllCurrValues();
        };

        getCurrService() {
            return this.#currService;
        };

        #reloadAllCurrValues() {
            const servicesSystem = this.getServicesSystem();
            const currServiceType = this.getCurrServiceType();
            const currType = this.getCurrType();
            const currService = this.getCurrService();

            let newType;
            let newService;

            let services = [];
            let types = [];

            if(!currServiceType) {
                newType = null;
                newService = null;
            } else {
                types = this.#getChilds(servicesSystem, currServiceType);
                this.loadTypes(types);
            };
        };

        #getChilds(parent, childKey) {
            let childs = [];
            let arrayItem = null;

            parent.forEach(child => {
                if (child.hasOwnProperty(childKey) || typeof child === 'string') {
                    arrayItem = child[childKey];
                };
            });

            if(Array.isArray(arrayItem)) {
                arrayItem.forEach(child => {
                    if(typeof child === 'string') {
                        childs.push(child);
                    } else if (typeof child === 'object' && !Array.isArray(child)) {
                        Object.keys(child).forEach(key => {
                            childs.push(key);
                        });
                    };
                });
            } else {
                childs = null;
            };

            return childs;
        };

        #init() {

            this.getServicesSystem();
        };

        #events() {

        };
    }
    </script>

</div>


@endsection