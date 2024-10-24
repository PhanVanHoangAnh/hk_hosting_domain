@extends('layouts.main.app', [
    'menu' => 'sales',
])
@section('sidebar')
    @include('sales.modules.sidebar', [
        'menu' => 'contact_request',
        'sidebar' => 'contact_request',
    ])
@endsection
@section('content')
    <!--begin::Toolbar-->
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Thông tin chi tiết</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ action([App\Http\Controllers\Sales\ContactRequestController::class, 'index']) }}"
                        class="text-muted text-hover-primary">Trang chủ</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Tài khoản</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Thông tin</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->

    </div>
    <!--end::Toolbar-->
    <!--begin::Post-->
    <div class="post" id="kt_post">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                @include('sales.contact_requests.detail', [
                    'detail' => 'show',
                ])
                <!--end::Details-->

                @include('sales.contact_requests.menu', [
                    'menu' => 'show',
                ])

            </div>
        </div>
        <!--end::Navbar-->
        <!--begin::details View-->
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Thông tin chung</h3>
                </div>
                <!--end::Card title-->
                <!--begin::Action-->
                <!--begin::Button-->
                <div class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px align-self-center"
                    row-action="update" id="buttonsEditContactRequest">
                    <i class="ki-duotone ki-abstract-10">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    Chỉnh sửa thông tin
                </div>

            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9" id="ContactRequestsInformation">
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Họ tên</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-bold fs-6 text-gray-800">{{ $contactRequest->contact->name }}</span>
                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Email

                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 fv-row">
                        <span class="fw-semibold text-gray-800 fs-6">{{ $contactRequest->contact->email }}</span>
                        <span class="badge badge-success">Verified</span>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Số điện thoại
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->contact->phone }}</span>

                    </div>
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Thời gian phù hợp

                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->time_to_call }}</span>

                    </div>


                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Ngày sinh
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            {{ $contactRequest->contact->birthday ? date('d/m/Y', strtotime($contactRequest->contact->birthday)) : '--' }}
                        </span>

                    </div>

                    <label class="col-lg-2 fw-semibold text-muted">Trường học
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->school)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->school;
                                }
                            @endphp</span>

                    </div>

                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Đơn hàng
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->demand }}</span>

                    </div>

                    <label class="col-lg-2 fw-semibold text-muted">Quốc gia
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->country)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->country;
                                }
                            @endphp</span>

                    </div>

                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Tỉnh/ Thành phố
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->city)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->city;
                                }
                            @endphp</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Quận/ Huyện</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->district)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->district;
                                }
                            @endphp
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-7">

                    <label class="col-lg-2 fw-semibold text-muted">Phường
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->ward }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Địa chỉ
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->address }}</span>

                    </div>

                    <!--end::Col-->
                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">EFC
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->efc)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->efc;
                                }
                            @endphp</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Danh sách</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->list)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->list;
                                }
                            @endphp
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Mục tiêu
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->targer)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->target;
                                }
                            @endphp
                        </span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Campaign
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->campaign)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->campaign;
                                }
                            @endphp
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Adset
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->adset)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->adset;
                                }
                            @endphp
                        </span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Ads</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->ads)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->ads;
                                }
                            @endphp
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Placement
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->placement }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Term</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->term)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->term;
                                }
                            @endphp
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">First URL
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->first_url)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->first_url;
                                }
                            @endphp
                        </span>

                    </div>

                    <label class="col-lg-2 fw-semibold text-muted">Conversion Url
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->last_url)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->last_url;
                                }
                            @endphp
                        </span>

                    </div>


                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">ContactRequest Owner
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->contact_owner)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->contact_owner;
                                }
                            @endphp
                        </span>
                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Type Match
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->type_match)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->type_match;
                                }
                            @endphp
                        </span>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Channel
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->channel }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Sub-Channel </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contactRequest->sub_channel)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contactRequest->sub_channel;
                                }
                            @endphp
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Phân loại nguồn
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->source_type }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Salesperson</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                $account = \App\Models\Account::find($contactRequest->account_id);
                                if ($account) {
                                    echo $account->name;
                                } else {
                                    echo 'Chưa xác định';
                                }
                            @endphp
                        </span>
                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Gclid
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->gclid }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Fbclid</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">

                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->fbcid }}</span>


                    </div>
                    <!--end::Col-->
                </div>
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Lead status
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contactRequest->lead_status }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Lifecycle stage</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            {{ $contactRequest->lifecycle_stage }}
                        </span>
                    </div>
                    <!--end::Col-->
                </div>

            </div>
            <!--end::Card body-->
        </div>
        <!--end::details View-->


    </div>
    <!--end::Post-->

    <script>
        $(function() { // document ready
            //
            ContactRequestInformation.init();

        });
        var ContactRequestInformation = function() {
            return {
                init: function() {

                    UpdateContactRequestPopup.init();
                    // list
                    ContactRequestsList.init();

                    HandoverContactRequestPopup.init();

                    DeleteContactRequest.init();


                }
            };
        }();


        var DeleteContactRequest = function() {
            let buttonDeleteCustom;

            const handleDelete = () => {
                buttonDeleteCustom.addEventListener('click', (e) => {
                    e.preventDefault();
                    const contactRequestId = buttonDeleteCustom.getAttribute('data-contact-id');

                    ASTool.confirm({
                        message: 'Bạn có chắc chắn muốn xóa đơn hàng này?',
                        ok: () => {
                            ASTool.addPageLoadingEffect();

                            $.ajax({
                                url: "/sales/contact_requests/" + contactRequestId,
                                method: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                }
                            }).done((response) => {
                                ASTool.alert({
                                    message: response.message,
                                    ok: () => {
                                        window.location.href =
                                            "{{ action('\App\Http\Controllers\Sales\ContactRequestController@index') }}";
                                    }
                                });
                            }).fail(() => {
                                // Handle failure
                            }).always(() => {
                                ASTool.removePageLoadingEffect();
                            });
                        }
                    });
                });
            };

            return {
                init: () => {
                    buttonDeleteCustom = document.getElementById('buttonDeleteCustom');
                    if (buttonDeleteCustom) {
                        handleDelete();
                    }
                }
            };
        }();

        var HandoverContactRequestPopup = function() {
            var popupHandoverContactRequest;
            var buttonsHandoverContactRequest;

            var showEditContactRequest = function(contactRequestId) {

                popupHandoverContactRequest.setData({
                    contact_request_id: contactRequestId,
                });
                popupHandoverContactRequest.load();
            };

            var handleHandoverContactRequestButtonClick = function() {
                buttonsHandoverContactRequest.addEventListener('click', function(e) {
                    e.preventDefault();
                    var contactRequestId = "{{ $contactRequest->id }}";

                    showEditContactRequest(contactRequestId);
                });
            };

            return {
                init: function() {
                    // Khởi tạo popup chỉnh sửa thông tin đơn hàng với url
                    popupHandoverContactRequest = new Popup({
                        url: "{{ action('App\Http\Controllers\Sales\ContactRequestController@addHandover', ['id' => $contactRequest->id]) }}",
                    });
                    buttonsHandoverContactRequest = document.getElementById('buttonHandoverCustom');
                    handleHandoverContactRequestButtonClick();
                },
                getPopup: function() {
                    return popupHandoverContactRequest;
                }
            }
        }();
        var UpdateContactRequestPopup = function() {
            var popupEditContactRequest;
            var buttonsEditContactRequest;

            var showEditContactRequest = function(contactRequestId) {

                popupEditContactRequest.setData({
                    contact_request_id: contactRequestId,
                });

                popupEditContactRequest.load();
            };

            var handleEditContactRequestButtonClick = function() {
                buttonsEditContactRequest.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var contactRequestId = "{{ $contactRequest->id }}";
                        showEditContactRequest(contactRequestId);
                    });
                });
            };

            return {
                init: function() {
                    // Khởi tạo popup chỉnh sửa thông tin đơn hàng với url
                    popupEditContactRequest = new Popup({
                        url: "{{ action('App\Http\Controllers\Sales\ContactRequestController@edit', ['id' => $contactRequest->id]) }}",
                    });
                    buttonsEditContactRequest = document.querySelectorAll('[row-action="update"]');
                    handleEditContactRequestButtonClick();
                },
                getPopup: function() {
                    return popupEditContactRequest;
                }
            }
        }();

        var ContactRequestsList = function() {
            var list;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('App\Http\Controllers\Sales\ContactRequestController@show', ['id' => $contactRequest->id]) }}",
                        container: document.querySelector('#ContactRequestInformation'),
                    });

                    list.load();
                },
                getList: function() {
                    location.reload();
                    return list;
                },
            }
        }();

        var DataList = class {
            constructor(options) {
                // throw exception make sure there is a url
                if (!options.url) {
                    throw new Error('Bug: list url not found!');
                }

                this.initUrl = options.url;
                this.url = options.url;
                this.container = options.container;
            }

            setUrl(url) {
                this.url = url;
            }

            loadContent(content) {
                $(this.container).html(content);
                initJs(this.container);
            }

            load() {
                this.listXhr = $.ajax({
                    url: this.url,
                }).done((content) => {
                    this.loadContent(content);
                }).fail(function() {
                     throw new Error("ERROR!");
                });
            }
        }
    </script>
@endsection
