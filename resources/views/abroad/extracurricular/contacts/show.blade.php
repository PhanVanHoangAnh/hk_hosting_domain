@extends('layouts.main.app', [
    'menu' => 'abroad',
])
@section('sidebar')
    @include('abroad.modules.sidebar', [
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
                    <a href="{{ action([App\Http\Controllers\Abroad\ContactController::class, 'index']) }}"
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
                @include('abroad.extracurricular.contacts.detail', [
                    'detail' => 'show',
                ])
                <!--end::Details-->

                @include('abroad.extracurricular.contacts.menu', [
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
                <a class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px align-self-center"
                    row-action="update-contact" id="buttonsEditContact">
                    <i class="ki-duotone ki-abstract-10">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    Chỉnh sửa thông tin
                </a>

            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9" id="ContactsInformation">
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 text-muted">Họ tên</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fw-bold fs-6 text-gray-800">{{ $contact->name }}</span>
                    </div>
                    <label class="col-lg-2 text-muted">Email
                        
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 fv-row">
                        <span class="text-gray-800 fs-6">{{ $contact->email }}</span>
                    </div>
                    <!--end::Col-->
                </div>

                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 text-muted">Số điện thoại
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center">
                        <span class="fs-6 text-gray-800 me-2">{{ $contact->phone }}</span>

                    </div>
                    {{-- <!--begin::Label-->
                    <label class="col-lg-2 text-muted d-none">Thời gian phù hợp

                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4 d-flex align-items-center d-none">
                        <span class="fs-6 text-gray-800 me-2">{{ $contact->time_to_call }}</span>

                    </div> --}}
                    <label class="col-lg-2 text-muted">Salesperson</label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fs-6 text-gray-800 me-2">
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
                    <label class="col-lg-2 text-muted">Địa chỉ
                    </label>
                    <!--end::Label-->
                    <!--begin::Col-->
                    <div class="col-lg-4">
                        <span class="fs-6 text-gray-800 me-2">
                            {{ $contact->getFullAddress() }}
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


                    // list
                    ContactsList.init();

                    DeleteContact.init();

                    UpdateContactPopup.init();
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
                                url: "/sales/contacts/" + contactId,
                                method: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                }
                            }).done((response) => {
                                ASTool.alert({
                                    message: response.message,
                                    ok: () => {
                                        window.location.href =
                                            "{{ action('\App\Http\Controllers\Abroad\ContactController@index') }}";
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

        var UpdateContactPopup = function() {
            var popupUpdateContact;
            var buttonsEditContact;

            var showEditContact = function(contactId) {

                popupUpdateContact.setData({
                    contact_id: contactId,
                });

                popupUpdateContact.load();
            };

            var handleEditContactButton = function() {
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
                    // Khởi tạo popup chỉnh sửa thông tin khách hàng với url
                    popupUpdateContact = new Popup({
                        url: "{{ action('App\Http\Controllers\Abroad\ContactController@edit', ['id' => $contact->id]) }}",
                    });
                    buttonsEditContact = document.querySelectorAll('[row-action="update-contact"]');
                    handleEditContactButton();
                },
                getPopup: function() {
                    return popupUpdateContact;
                }
            }
        }();

        var ContactsList = function() {
            var list;

            return {
                init: function() {
                    list = new DataList({
                        url: "{{ action('App\Http\Controllers\Abroad\ContactController@show', ['id' => $contact->id]) }}",
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
                    throw new Error("ERROR!");
                });
            }
        }
    </script>
@endsection
