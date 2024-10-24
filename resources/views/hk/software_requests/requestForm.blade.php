@extends('hk.layouts.main.clean')

<style>
    .d-flex {
        display: flex;
    }
    .align-items-center {
        align-items: center;
    }
    .symbol-orange {
        background-color: orange;
        border: 5px solid white; 
        border-radius: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .symbol-label {
        font-size: 2rem;
        font-weight: 600;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height:70px;
    }
    .text-white {
        color: white; 
    }
    .title{
        font-size: 25px;
        color:gray
    }
    .item {
        display: flex;
        align-items: center;
        text-decoration: none;
        margin-bottom: 1rem; 
    }
    .button-pulse {
        animation: pulse 1s infinite 2s cubic-bezier(0.75, 0, 1, 1);
    }
    .button {
        background: red;
        position: relative;
        color: whitesmoke;
        text-decoration: none;
        display: inline-block;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 2px solid white;
        border-radius: 200px;
        padding: 15px 25px;
        margin: 15px;
        
        &:hover {
            cursor: pointer;
            background: red;
            color: #1F4141;
            animation: none;
        }
        }
</style>

@section('content')
    <!--begin::Root-->
    <form method="POST" action="{{ route('logout') }}" class="d-block">
        @csrf

        <div class="text-end mt-4 pe-5">
            <a href="{{ route('contact.login') }}" class="btn btn-light py-2"
                onclick="event.preventDefault();
                                    this.closest('form').submit();">
                {{ __('Đăng nhập') }}
            </a>
        </div>
            
    </form>
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    <div class="w-lg-100 d-flex">
                        <div class="w-lg-50 d-flex justify-content-center align-items-center  d-lg-flex">
                            <section class="w-sm-500px ps-10 ps-lg-15 py-20 py-lg-0">
                                <div class='mb-10'>
                                  <h1 style='font-size:25px'>ĐĂNG KÝ NHÂN TƯ VẤN MIỄN PHÍ</h1>
                                </div>
                                <div class="item-list">
                                  <div class="item">
                                    <div class="symbol-orange ">
                                        <div class="symbol-label fs-2 fw-semibold text-white">
                                            01
                                        </div>
                                    </div>
                                    <div class="ms-2">
                                      <h2 class="title">All-in-one</h2>
                                      <p >Quản lý dữ liệu từ các kênh bán hàng trên 1 nền tảng
                                    </div>
                                  </div>
                                  <div class="item">
                                    <div class="  symbol-orange">
                                        <div class="symbol-label fs-2 fw-semibold text-white">
                                            02
                                        </div>
                                    </div>
                                    <div class="ms-2">
                                      <h2 class="title">Quản lý khách hàng</h2>
                                      <p >Quản lý & Phân loại Khách hàng theo điều kiện
                                    </div>
                                  </div>
                                  <div href="/" class="item">
                                    <div class="  symbol-orange">
                                        <div class="symbol-label fs-2 fw-semibold text-white">
                                            03
                                        </div>
                                    </div>
                                    <div class="ms-2">
                                      <h2 class="title">Tối ưu hóa quá trình CSKH</h2>
                                      <p >Hệ thống chăm sóc khách hàng.
                                    </div>
                                  </div>
                                  
                                </div>
                               
                            </section>
                        </div>
                        <div class="w-lg-50 d-flex justify-content-center">
                            <!--begin::Wrapper-->
                            <div class="w-sm-700px  py-20 py-lg-0">
                                <!--begin::Form-->
                                <form class="form mt-0 mt-lg-10 fv-plugins-bootstrap fv-plugins-framework" id="request_form_create" 
                                    method="POST" action="{{ route('request.store') }}">
                                    @csrf
                                    <div class="text-center mb-11">
                                        <h1 class="fw-bolder mb-3 text-uppercase text-secondary">ĐĂNG KÝ TƯ VẤN</h1>
                                    </div>
                                    <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                        
                                        <div class="form-group mb-5 ">
                                            <label class='fs-6 fw-semibold'>Họ tên</label>
                                            <input type="text" class="form-control form-control-solid form-control-lg" name="name" placeholder="Họ tên" >
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <!--begin::Input-->
                                                <div class="form-group mb-5 ">
                                                    <label class='fs-6 fw-semibold'>Số điện thoại</label>
                                                    <input type="tel" class="form-control form-control-solid form-control-lg" name="phone" placeholder="Số điện thoại" >
                                                    <span class="form-text text-muted">Vui lòng nhập số điện thoại.</span>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group mb-5 ">
                                                    <label class='fs-6 fw-semibold'>Email</label>
                                                    <input type="email" class="form-control form-control-solid form-control-lg" name="email" placeholder="Email" >
                                                    <span class="form-text text-muted">Vui lòng nhập email.</span>
                                                </div>
                                                <!--end::Input-->
                                            </div>
                                        </div>
                                    </div>
    
                                    <div class="pb-5" >
                                        <div class="form-group mb-5 fv-plugins-icon-container">
                                            <label class='fs-6 fw-semibold'>Tên công ty</label>
                                            <input type="text" class="form-control form-control-solid form-control-lg" name="company_name" placeholder="Tên công ty">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-6">
                                            <div class="form-group mb-5 fv-plugins-icon-container">
                                                <label class='fs-6 fw-semibold'>Quy mô công ty</label>
                                                <select data-control="select2" class="form-select form-control" name="company_size">
                                                    <option value="1 - 15 nhân sự">1 - 15 nhân sự</option>
                                                    <option value="16 - 50 nhân sự">16 - 50 nhân sự</option>
                                                    <option value="51 - 100 nhân sự">51 - 100 nhân sự</option>
                                                    <option value="101 - 300 nhân sự">101 - 300 nhân sự</option>
                                                    <option value="301- 500 nhân sự">301- 500 nhân sự</option>
                                                    <option value="501 - 1000 nhân sự">501 - 1000 nhân sự</option>
                                                    <option value="-Trên 1000 nhân sự">-Trên 1000 nhân sự</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group mb-5 fv-plugins-icon-container">
                                                <label class='fs-6 fw-semibold'>Số lượng chi nhánh</label>
                                                <input type="number" class="form-control form-control-solid form-control-lg" name="company_branch" placeholder="Số lượng chi nhánh">
                                            </div>
                                        </div>
                                        <div class="pb-5" >
                                        
                                            <div class="form-group mb-5 fv-plugins-icon-container">
                                                <label class='fs-6 fw-semibold'>Ngành nghề hoạt động</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="line_of_business" placeholder="Ngành nghề hoạt động">
                                            </div>
                                        </div>
                                        <div class="pb-5" > 
                                            <div class="form-group mb-5 fv-plugins-icon-container">
                                                <label class='fs-6 fw-semibold'>Nội dung yêu cầu</label>
                                                <textarea type="text" class="form-control form-control-solid form-control-lg" name="note" placeholder="Mô tả thông tin yêu cầu của quý khách"></textarea>
                                            </div>
                                        </div>
                                    
                                    <div class="d-flex justify-content-center border-top mt-5 ">
                                        <div>
                                            <button type="submit" class="bg-red fw-semibold button button-pulse">Đăng ký ngay</button>
                                        </div>
                                    </div>
                                    <!--end: Wizard Actions-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                    </div>
                </div>
                <!--end::Form-->
                <!--begin::Footer-->
                <div class="w-sm-500px d-flex flex-stack px-10 mx-auto d-none">
                    <!--begin::Languages-->
                    <div  class="me-10" >
                        <!--begin::Toggle-->
                        <button  class="btn btn-flex btn-link btn-color-gray-700 btn-active-color-primary rotate fs-base" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start" data-kt-menu-offset="0px, 0px">
                            <img data-kt-element="current-lang-flag" class="w-20px h-20px rounded me-3" src="{{ url('/core/assets/media/flags/vietnam.svg') }}" alt="" />
                            <span data-kt-element="current-lang-name" class="me-1">Tiếng Việt</span>
                            <span class="d-flex flex-center rotate-180">
                                <i class="ki-outline ki-down fs-5 text-muted m-0"></i>
                            </span>
                        </button>
                        <!--end::Toggle-->
                        <!--begin::Menu-->
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4 fs-7" data-kt-menu="true" id="kt_auth_lang_menu">
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a data-action="under-construction" href="#" class="menu-link d-flex px-5" data-kt-lang="English">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="{{ url('/core/assets/media/flags/united-states.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">English</span>
                                </a>
                            </div>
                        </div>
                        <!--end::Menu-->
                    </div>
                    <!--end::Languages-->
                    <!--begin::Links-->
                    <div class="d-flex fw-semibold text-primary fs-base gap-5" >
                        <a data-action="under-construction" href="../../demo39/dist/pages/team.html" target="_blank">Điều Khoản</a>
                        <a data-action="under-construction" href="../../demo39/dist/pages/pricing/column.html" target="_blank">Tài Liệu</a>
                        <a data-action="under-construction" href="../../demo39/dist/pages/contact.html" target="_blank">Hỗ trợ</a>
                    </div>
                    <!--end::Links-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <script>
        $(function() {
            new CreateNewRequest({
                form: $('#request_form_create')
            });
        });
        class CreateNewRequest {
            constructor(options) {
                this.form = options.form;
                this.events(); // Ensure events are bound
            }

            clickHandle() {
                var data = this.form.serialize();

                $.ajax({
                    url: this.getUrl(),
                    method: 'POST',
                    data: data,
                }).done(response => {
                    ASTool.alert({
                        message: response.message,
                        ok: function() {
                            // location.reload()
                            window.location.href = "{{ route('success') }}";
                        }   
                    });
                    
                }).fail(response => {
                    ASTool.alert({
                        message: JSON.parse(response.responseText).firstError,
                        icon: 'warning',
                        ok: function() {
                            
                        }
                    });
                });
            }
        
            events() {
                this.form.on('click', 'button[type="submit"]', e => {
                    e.preventDefault();
                    this.clickHandle();
                });
            }

            getUrl() {
                return this.form.attr('action');
            }
        }
    </script>
@endsection

@section('footer')
@endsection