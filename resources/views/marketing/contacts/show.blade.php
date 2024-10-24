@extends('layouts.main.app', [
    'menu' => 'marketing',
])
@section('sidebar')
    @include('marketing.modules.sidebar', [
        'menu' => 'contact',
        'sidebar' => 'contact',
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
                    <a href="{{ action([App\Http\Controllers\Marketing\ContactController::class, 'index']) }}"
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
                @include('marketing.contacts.detail', [
                    'detail' => 'show',
                ])
                <!--end::Details-->

                @include('marketing.contacts.menu', [
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
                    row-action="update" id="buttonsEditContact">
                    <i class="ki-duotone ki-abstract-10">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    Chỉnh sửa thông tin
                </div>

            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9" id="ContactsInformation">
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Họ tên</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-bold fs-6 text-gray-800">{{ $contact->name }}</span>
                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Email

                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 fv-row">
                        <span class="fw-semibold text-gray-800 fs-6">{{ $contact->email }}</span>
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
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->displayPhoneNumberByUser(Auth::user()) }}</span>

                    </div>
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Thời gian phù hợp

                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->time_to_call }}</span>

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
                            {{ $contact->birthday ? date('d/m/Y', strtotime($contact->birthday)) : '--' }}
                            </span>

                    </div>

                    <label class="col-lg-2 fw-semibold text-muted">Trường học
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contact->school)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->school;
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
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->demand }}</span>

                    </div>

                    <label class="col-lg-2 fw-semibold text-muted">Quốc gia
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contact->country)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->country;
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
                                if (empty($contact->city)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->city;
                                }
                            @endphp</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Quận/ Huyện</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contact->district)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->district;
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
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->ward }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Địa chỉ
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->address }}</span>

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
                                if (empty($contact->efc)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->efc;
                                }
                            @endphp</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Danh sách</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contact->list)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->list;
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
                                if (empty($contact->targer)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->target;
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
                                if (empty($contact->campaign)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->campaign;
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
                                if (empty($contact->adset)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->adset;
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
                                if (empty($contact->ads)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->ads;
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
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->placement }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Term</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contact->term)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->term;
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
                                if (empty($contact->first_url)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->first_url;
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
                                if (empty($contact->last_url)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->last_url;
                                }
                            @endphp
                        </span>

                    </div>


                </div>
                <div class="row mb-7 d-none">
                    <!--begin::Label-->
                    <label class="col-lg-2 fw-semibold text-muted">Contact Owner
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contact->contact_owner)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->contact_owner;
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
                                if (empty($contact->type_match)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->type_match;
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
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->channel }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Sub-Channel </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                if (empty($contact->sub_channel)) {
                                    echo 'Chưa xác định';
                                } else {
                                    // Xử lý khi biến không rỗng
                                    echo $contact->sub_channel;
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
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->source_type }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Salesperson</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            @php
                                $account = \App\Models\Account::find($contact->account_id);
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
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->gclid }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Fbclid</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">

                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->fbcid }}</span>


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
                        <span class="fw-semibold fs-6 text-gray-800 me-2">{{ $contact->lead_status }}</span>

                    </div>
                    <label class="col-lg-2 fw-semibold text-muted">Lifecycle stage</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-semibold fs-6 text-gray-800 me-2">
                            {{ $contact->lifecycle_stage }}
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
            ContactInformation.init();

        });
        var ContactInformation = function() {
            return {
                init: function() {

                    UpdateContactPopup.init();
                    // list
                    ContactsList.init();

                    HandoverContactPopup.init();

                    DeleteContact.init();


                }
            };
        }();


        var DeleteContact = function() {
            let buttonDeleteCustom;

            const handleDelete = () => {
                buttonDeleteCustom.addEventListener('click', (e) => {
                    e.preventDefault();
                    const contactId = buttonDeleteCustom.getAttribute('data-contact-id');

                    ASTool.confirm({
                        message: 'Bạn có chắc chắn muốn xóa liên hệ này?',
                        ok: () => {
                            ASTool.addPageLoadingEffect();

                            $.ajax({
                                url: "/marketing/contacts/" + contactId,
                                method: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                }
                            }).done((response) => {
                                ASTool.alert({
                                    message: response.message,
                                    ok: () => {
                                        window.location.href =
                                            "{{ action('\App\Http\Controllers\Marketing\ContactController@index') }}";
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

        var HandoverContactPopup = function() {
            var popupHandoverContact;
            var buttonsHandoverContact;

            var showEditContact = function(contactId) {

                popupHandoverContact.setData({
                    contact_id: contactId,
                });
                popupHandoverContact.load();
            };

            var handleHandoverContactButtonClick = function() {
                buttonsHandoverContact.addEventListener('click', function(e) {
                    e.preventDefault();
                    var contactId = "{{ $contact->id }}";

                    showEditContact(contactId);
                });
            };

            return {
                init: function() {
                    // Khởi tạo popup chỉnh sửa thông tin liên hệ với url
                    popupHandoverContact = new Popup({
                        url: "{{ action('App\Http\Controllers\Marketing\ContactController@addHandover', ['id' => $contact->id]) }}",
                    });
                    buttonsHandoverContact = document.getElementById('buttonHandoverCustom');
                    handleHandoverContactButtonClick();
                },
                getPopup: function() {
                    return popupHandoverContact;
                }
            }
        }();
        var UpdateContactPopup = function() {
            var popupEditContact;
            var buttonsEditContact;

            var showEditContact = function(contactId) {

                popupEditContact.setData({
                    contact_id: contactId,
                });

                popupEditContact.load();
            };

            var handleEditContactButtonClick = function() {
                buttonsEditContact.forEach(function(button) {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();
                        var contactId = "{{ $contact->id }}";
                        showEditContact(contactId);
                    });
                });
            };

            return {
                init: function() {
                    // Khởi tạo popup chỉnh sửa thông tin liên hệ với url
                    popupEditContact = new Popup({
                        url: "{{ action('App\Http\Controllers\Marketing\ContactController@edit', ['id' => $contact->id]) }}",
                    });
                    buttonsEditContact = document.querySelectorAll('[row-action="update"]');
                    handleEditContactButtonClick();
                },
                getPopup: function() {
                    return popupEditContact;
                }
            }
        }();

        var ContactsList = function() {
            var list;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('App\Http\Controllers\Marketing\ContactController@show', ['id' => $contact->id]) }}",
                        container: document.querySelector('#ContactInformation'),
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
                    throw new Error("ERROR");
                });
            }
        }
    </script>
@endsection
