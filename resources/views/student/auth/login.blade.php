@extends('layouts.main.clean')

@section('content')
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <div class="text-center mt-10">
                    <img class="h-45px h-lg-55px" src="{{ url('/media/logos/asms.svg') }}" />
                </div>
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                    
                    <div class="w-lg-100 d-flex">
                        <div class="w-lg-50 d-flex justify-content-center">
                            <!--begin::Wrapper-->
                            <div class="w-sm-500px ps-10 ps-lg-15 py-20 py-lg-0">
                                <!--begin::Form-->
                                <form method="POST" action="{{ route('student.login.save') }}">
                                    @csrf
                                    <!--begin::Heading-->
                                    <div class="text-center mb-11">
                                        <!--begin::Title-->
                                        <div class="d-flex align-items-center justify-content-center">
                                            <div class="me-3">
                                                <svg style="width:50px;height:50px;" xmlns="http://www.w3.org/2000/svg" id="Layer_2" viewBox="0 0 77.23 43.59"><g id="Layer_1-2"><path d="M18.11,16.63v19.86c0,2.27,15.96,7.11,20.5,7.11s20.5-4.84,20.5-7.11v-19.86H18.11Z" style="fill:#184f78; stroke-width:0px;"/><polygon points="18.11 25.83 38.62 33.57 59.12 25.83 59.12 18.63 18.11 18.63 18.11 25.83" style="fill:#000; opacity:.3; stroke-width:0px;"/><polygon points="38.62 0 0 14.58 38.62 29.15 77.23 14.58 38.62 0" style="fill:#184f78; stroke-width:0px;"/><polygon points="38.62 29.15 0 14.58 0 16.58 38.62 31.15 77.23 16.58 77.23 14.58 38.62 29.15" style="fill:#467293; stroke-width:0px;"/><path d="M61.56,32.72h-1.72s-3.78,5.34-1.29,10.69h4.31c2.49-5.35-1.29-10.69-1.29-10.69Z" style="fill:#fdc00f; stroke-width:0px;"/><path d="M62.06,42.53c.09-.49.05-1.08.08-1.69.01-.31,0-.63-.03-.95-.03-.32-.06-.65-.08-.97-.02-.33-.09-.64-.14-.96-.06-.31-.11-.62-.16-.91-.16-.58-.26-1.13-.42-1.57-.27-.91-.52-1.47-.52-1.47,0,0,.21.59.41,1.52.12.46.19,1.01.3,1.59.03.29.06.6.1.91.03.31.08.62.07.94,0,.32,0,.63.01.94.02.31,0,.61-.04.91-.07.58-.06,1.13-.19,1.58-.1.42-.17.76-.23,1.02h.72c.04-.25.08-.54.13-.88Z" style="fill:#fed96f; stroke-width:0px;"/><path d="M59.96,42.39c-.12-.44-.11-1-.19-1.58-.04-.29-.05-.6-.04-.91,0-.31,0-.63.01-.94,0-.32.04-.63.07-.94.03-.31.07-.62.1-.91.11-.58.18-1.14.3-1.59.2-.93.41-1.52.41-1.52,0,0-.25.56-.52,1.47-.16.45-.26,1-.42,1.57-.05.3-.11.6-.16.91-.05.32-.13.63-.14.96-.03.33-.06.65-.09.97-.04.32-.04.64-.03.95.03.62-.02,1.21.08,1.69.05.35.09.63.13.88h.72c-.06-.26-.14-.6-.23-1.02Z" style="fill:#fed96f; stroke-width:0px;"/><path d="M63.27,41.75c.05-.31.08-.63.07-.98.02-.34,0-.69-.04-1.04-.02-.35-.11-.7-.16-1.04-.3-1.38-.89-2.58-1.38-3.41-.5-.83-.91-1.29-.91-1.29,0,0,.37.51.81,1.38.43.87.93,2.11,1.11,3.43.03.33.1.66.09.99.01.33.02.64-.02.95-.01.31-.06.6-.12.86-.05.27-.11.53-.19.75-.13.46-.3.8-.43,1.04,0,0,0,.01-.01.02h.77c.05-.11.09-.22.13-.34.04-.15.09-.29.13-.46.08-.26.13-.55.16-.86Z" style="fill:#fed96f; stroke-width:0px;"/><path d="M60.7,33.99l-.35,9.41h.7l-.35-9.41Z" style="fill:#fed96f; stroke-width:0px;"/><path d="M59.3,43.39c-.13-.24-.29-.58-.43-1.04-.09-.22-.15-.47-.19-.75-.07-.27-.11-.56-.12-.86-.04-.31-.04-.62-.02-.95,0-.33.06-.65.09-.99.19-1.32.69-2.56,1.12-3.43.44-.87.81-1.38.81-1.38,0,0-.4.47-.91,1.29-.49.83-1.08,2.03-1.38,3.41-.06.35-.15.69-.16,1.04-.04.35-.06.7-.04,1.04,0,.34.02.67.07.98.04.31.08.6.16.86.04.17.09.31.13.46.05.11.08.22.13.34h.77s0-.01-.01-.02Z" style="fill:#fed96f; stroke-width:0px;"/><path d="M58.75,32.72c0-1.08.87-1.95,1.95-1.95s1.95.87,1.95,1.95-.87,1.95-1.95,1.95-1.95-.87-1.95-1.95Z" style="fill:#fed96f; stroke-width:0px;"/><ellipse cx="38.62" cy="14.58" rx="6.14" ry="3.64" style="fill:#000; opacity:.3; stroke-width:0px;"/><path d="M44.63,15.31c-.21.6-.66,1.14-1.3,1.59l-.03.1,16.39,4.85v10.87h2v-12.36l-17.07-5.04Z" style="fill:#fdc00f; stroke-width:0px;"/><path d="M32.48,14.07c0-1.73,2.37-3.13,5.28-3.13s5.28,1.4,5.28,3.13-2.37,3.13-5.28,3.13-5.28-1.4-5.28-3.13Z" style="fill:#184f78; stroke-width:0px;"/></g></svg>
                                            </div>
                                            <div>
                                                <h1 class="fw-bolder mb-0 text-uppercase text-secondary">CỔNG HỌC VIÊN</h1>
                                            </div>
                                        </div>
                                        <!--end::Title-->
                                        <!--begin::Subtitle-->
                                        {{-- <div class="text-gray-500 fw-semibold fs-6">KINH DOANH</div> --}}
                                        <!--end::Subtitle=-->
                                    </div>

                                    @include('layouts.main._flash')

                                    {{-- <p class="fs-5">Vui lòng nhập E-Mail và mật khẩu của bạn dưới đây để truy cập vào tài khoản của bạn tại ASMS.</p> --}}
                                    <!--begin::Heading-->
                                    {{-- <!--begin::Login options-->
                                    <div class="row g-3 mb-9">
                                        <!--begin::Col-->
                                        <div class="col-md-6">
                                            <!--begin::Google link=-->
                                            <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                            <img alt="Logo" src="{{ url('/core/assets/media/svg/brand-logos/google-icon.svg') }}" class="h-15px me-3" />Sign in with Google</a>
                                            <!--end::Google link=-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-md-6">
                                            <!--begin::Google link=-->
                                            <a href="#" class="btn btn-flex btn-outline btn-text-gray-700 btn-active-color-primary bg-state-light flex-center text-nowrap w-100">
                                            <img alt="Logo" src="{{ url('/core/assets/media/svg/brand-logos/apple-black.svg') }}" class="theme-light-show h-15px me-3" />
                                            <img alt="Logo" src="{{ url('/core/assets/media/svg/brand-logos/apple-black-dark.svg') }}" class="theme-dark-show h-15px me-3" />Sign in with Apple</a>
                                            <!--end::Google link=-->
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Login options-->
                                    <!--begin::Separator-->
                                    <div class="separator separator-content my-14">
                                        <span class="w-125px text-gray-500 fw-semibold fs-7">Or with email</span>
                                    </div>
                                    <!--end::Separator--> --}}
                                    <!--begin::Input group=-->
                                    <div class="fv-row mb-8">
                                        <label for="" class="form-label fw-bold fs-5">E-Mail</label>
                                        <!--begin::Email-->
                                        <input type="email" placeholder="Nhập email học viên" name="email" value="{{ request()->email }}" autocomplete="off" class="form-control bg-transparent {{ $errors->get('email') ? 'is-invalid' : '' }}"  />
                                        <!--end::Email-->
                                        {{-- <x-text-input class="form-control" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" /> --}}
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>
                                    <!--end::Input group=-->
                                    <div class="fv-row mb-3">
                                        <label for="" class="form-label fw-bold fs-5">Mật khẩu</label>
                                        <!--begin::Password-->
                                        <input type="password" placeholder="Mật khẩu" name="password" autocomplete="off" class="form-control bg-transparent" />
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
                                            <span class="indicator-label fs-5">Đăng Nhập ASMS</span>
                                            <!--end::Indicator label-->
                                            <!--begin::Indicator progress-->
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            <!--end::Indicator progress-->
                                        </button>
                                    </div>
                                    <!--end::Submit button-->
                                    <!--begin::Sign up-->
                                    <div class="text-gray-700 fw-semibold fs-6 d-none">Bạn chưa có tài khoản trên ASMS?
                                    <a href="{{ route('register.create') }}" class="link-primary">Đăng ký tại đây</a></div>
                                    <!--end::Sign up-->
                                </form>
                                <!--end::Form-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <div class="w-lg-50 d-flex justify-content-center align-items-center d-none d-lg-flex">
                            <div class="text-center">
                                <div class="mb-10 mt-10">
                                    <img class="w-lg-450px rounded-3 shadow-sm" src="{{ url('as-banner.jpeg') }}" alt="">
                                </div>
                                <div>
                                    <h2 class="text-center my-4">
                                        AMERICAN STUDY – TRUNG TÂM TƯ VẤN DU HỌC MỸ, CANADA
                                    </h2>
                                    <div class="d-flex justify-content-center">
                                        <p class="w-500px fs-5 text-center">American Study là tổ chức chuyên luyện thi và tư vấn du học Mỹ và Canada hàng đầu Việt Nam. Với đội ngũ giáo viên và chuyên gia tư vấn người Mỹ đến từ các trường đại học hàng đầu</p>
                                    </div>
                                </div>
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
                            <!--end::Menu item-->
                            {{-- <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="Spanish">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="{{ url('/core/assets/media/flags/spain.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">Spanish</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="German">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="{{ url('/core/assets/media/flags/germany.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">German</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="Japanese">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="{{ url('/core/assets/media/flags/japan.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">Japanese</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3">
                                <a href="#" class="menu-link d-flex px-5" data-kt-lang="French">
                                    <span class="symbol symbol-20px me-4">
                                        <img data-kt-element="lang-flag" class="rounded-1" src="{{ url('/core/assets/media/flags/france.svg') }}" alt="" />
                                    </span>
                                    <span data-kt-element="lang-name">French</span>
                                </a>
                            </div>
                            <!--end::Menu item--> --}}
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