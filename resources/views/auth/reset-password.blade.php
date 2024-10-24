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
                                
                                <form method="POST" action="{{ route('password.store') }}">
                                    @csrf

                                    <!-- Password Reset Token -->
                                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                    <div class="fv-row mb-8">
                                        <label for="" class="form-label fw-bold fs-5">Email</label>
                                        <!--begin::Email-->
                                        <input type="email" placeholder="" name="email" value="{{ old('email', $request->email) }}" autocomplete="off" class="form-control bg-transparent {{ $errors->get('email') ? 'is-invalid' : '' }}"  />
                                        <!--end::Email-->
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <!-- Password -->
                                    <div class="fv-row mb-8">
                                        <label for="" class="form-label fw-bold fs-5">Mật khẩu</label>
                                        <!--begin::Password-->
                                        <input type="password" placeholder="" name="password" autocomplete="off" class="form-control bg-transparent" />
                                        <!--end::Password-->

                                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="fv-row mb-8">
                                        <label for="" class="form-label fw-bold fs-5">Mật khẩu</label>
                                        <!--begin::Password-->
                                        <input type="password" placeholder="" name="password_confirmation" autocomplete="off" class="form-control bg-transparent" />
                                        <!--end::Password-->

                                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                    </div>
                                    
                                    <div class="flex items-center justify-end mt-4">
                                        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary py-4">
                                            <!--begin::Indicator label-->
                                            <span class="indicator-label fs-5">{{ __('Lưu mật khẩu') }}</span>
                                            <!--end::Indicator label-->
                                            <!--begin::Indicator progress-->
                                            <span class="indicator-progress">Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                            <!--end::Indicator progress-->
                                        </button>
                                    </div>
                                </form>
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
