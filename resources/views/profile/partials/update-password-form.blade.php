
<section id="ChangePassword">
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>
    
    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf

        @method('PUT')
        <div>
            <div>
                <!--begin::Card header-->
                <div class="card-header border-0 d-block">
                    <!--begin::Card title-->
                    <div>
                        @if (session('status') === 'password-updated')
                            <div class="alert alert-success text-dark d-flex align-items-center p-5 mb-10">
                                <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span></i>                    <div class="d-flex flex-column">
                                    <h4 class="mb-1">Hệ thống</h4>
                                    <div>Mật khẩu đã được cập nhật thành công!</div>
                                </div>
                            </div>
                        @endif
                        <!--begin::Menu-->

                        @if (Auth::user()->change_password_required)
                            <div class="alert alert-warning text-dark d-flex align-items-center p-5 mb-10">
                                <i class="ki-duotone ki-shield-tick fs-2hx text-primary me-4"><span class="path1"></span><span class="path2"></span></i>                    <div class="d-flex flex-column">
                                    <h4 class="mb-1">Hệ thống</h4>
                                    <div>Bạn cần đổi mật khẩu mới để tiếp tục sử dụng tài khoản này!</div>
                                </div>
                            </div>
                        @endif
                        <h2>{{ __('Cập nhật mật khẩu') }}</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Đảm bảo tài khoản của bạn đang sử dụng mật khẩu dài, ngẫu nhiên để giữ an toàn.") }}
                        </p>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0 pb-5">
                    <!--begin::Table wrapper-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed gy-5 table-origin" id="kt_table_users_login_session">
                            <tbody class="fs-6 text-gray-600">
                                <tr>
                                    <td>
                                        <x-input-label for="current_password" :value="__('Current Password')" />
                                    </td>
                                    <td>
                                        <x-text-input id="current_password" name="current_password" type="password"
                                            class="mt-1 block form-control" autocomplete="current-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('current_password')"
                                            class="mt-2" />
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <x-input-label for="password" :value="__('New Password')" />
                                    </td>
                                    <td>
                                        <x-text-input id="password" name="password" type="password"
                                            class="mt-1 block form-control" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('password')"
                                            class="mt-2" />
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                                    </td>
                                    <td>
                                        <x-text-input id="password_confirmation" class="mt-1 block form-control"
                                            name="password_confirmation" type="password" autocomplete="new-password" />
                                        <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                                            class="mt-2" />
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                        <!--end::Table-->
                    </div>
                    <!--end::Table wrapper-->
                </div>
                <!--end::Card body-->
            </div>
        </div>



        <!--begin::Card toolbar-->
        <div class="end d-flex justify-content-end mx-10">
            <!--begin::Update-->
            <x-primary-button class="btn btn-primary rounded">{{ __('Lưu') }}</x-primary-button>
        </div>
        <!--end::Card toolbar-->

    </form>
</section>