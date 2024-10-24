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
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <div class="text-center mt-10">
                    {{-- <img class="h-45px h-lg-55px" src="{{ url('/media/logos/asms.svg') }}" /> --}}
                </div>
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    
                    <div class="w-lg-100 d-flex">
                        <div class="w-lg-50 d-flex justify-content-center">
                            <!--begin::Wrapper-->
                            <div class="w-sm-500px ps-10 ps-lg-15 py-20 py-lg-0">
                                <!--begin::Form-->
                                <form method="POST" action="{{ action([App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']) }}">
                                    @csrf
                                    <!--begin::Heading-->
                                    <div class="text-center mb-11">
                                        <!--begin::Title-->
                                        <h1 class="fw-bolder mb-3 text-uppercase text-secondary">Đăng Nhập</h1>
                                        <!--end::Title-->
                                        <!--begin::Subtitle-->
                                        {{-- <div class="text-gray-500 fw-semibold fs-6">KINH DOANH</div> --}}
                                        <!--end::Subtitle=-->
                                    </div>

                                    @include('hk.layouts.main._flash')

                                    
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <label for="" class="form-label fw-bold fs-5">E-Mail</label>
                                        <!--begin::Email-->
                                        <input type="email" placeholder="" name="email" autocomplete="off" class="form-control bg-transparent {{ $errors->get('email') ? 'is-invalid' : '' }}"  />
                                        <!--end::Email-->
                                        {{-- <x-text-input class="form-control" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" /> --}}
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <label for="" class="form-label fw-bold fs-5">Mật khẩu</label>
                                        <!--begin::Password-->
                                        <input type="password" placeholder="" name="password" autocomplete="off" class="form-control bg-transparent" />
                                        <!--end::Password-->

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>
                                    <!--end::Input group=-->
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8 align-items-center mt-5">
                                        <div class="d-flex align-items-center">
                                            <label for="remember_me" class="inline-flex items-center">
                                                <div class="form-check form-check-sm form-check-custom">
                                                    <input id="remember_me" class="form-check-input" type="checkbox" name="remember" />
                                                    <label for="remember_me" class="ms-2 text-gray-600">{{ __('Ghi nhớ đăng nhập') }}</label>
                                                </div>
                                                {{-- <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember"> --}}
                                            </label>
                                        </div>
                                        <!--begin::Link-->
                                        <a data-action="under-construction" href="{{ route('password.request') }}" class="link-primary">Quên Mật Khẩu ?</a>
                                        <!--end::Link-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Submit button-->
                                    <div class="d-grid mb-10">
                                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary py-4">
                                            <!--begin::Indicator label-->
                                            <span class="indicator-label fs-5">Đăng Nhập </span>
                                            <!--end::Indicator label-->
                                            <!--begin::Indicator progress-->
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            <!--end::Indicator progress-->
                                        </button>
                                    </div>
                                    <!--end::Submit button-->
                                    <!--begin::Sign up-->
                                    
                                    <!--end::Sign up-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                            
                        
                            <div class="w-lg-100 d-flex justify-content-center align-items-center">
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
                            
                        </div>
                    </div>
                </div>
                <!--end::Form-->
                <!--begin::Footer-->
                <div class="w-sm-500px d-flex flex-stack px-10 mx-auto">
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
@endsection

@section('footer')
@endsection