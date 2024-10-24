<section>
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('student.profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <div>
                <!--begin::Card header-->
                <div class="card-header border-0">
                    <!--begin::Card title-->
                    <div>
                        <h2>{{ __('Thông tin cá nhân') }}</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __("Cập nhật thông tin hồ sơ và địa chỉ email của tài khoản của bạn.") }}
                        </p>
                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->

                <!--begin::Card body-->
                <div class="card-body pt-0 pb-5">
                    @if (session('status') == 'profile-updated')
                        <div class="alert alert-success text-dark">
                            {{ __('Tài khoản đã được cập nhật thành công')  }}
                        </div>
                    @endif

                    <!--begin::Table wrapper-->
                    <div class="table-responsive">
                        <!--begin::Table-->
                        <table class="table align-middle table-row-dashed gy-5 table-origin" id="kt_table_users_login_session">
                            <tbody class="fs-6 text-gray-600">
                                <tr>
                                    <td>
                                        <x-input-label for="name" :value="__('Name')" />
                                    </td>
                                    <td>
                                        <x-text-input id="name" name="name" type="text"
                                            class="mt-1 block form-control " :value="old('name', $user->name)"
                                            required autofocus autocomplete="name" />
                                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <x-input-label for="email" :value="__('Email')" />
                                    </td>
                                    <td>
                                        <x-text-input id="email" name="email" type="email"
                                            class="mt-1 block form-control" :value="old('email', $user->email)"
                                            required autocomplete="username" />
                                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                    </td>

                                </tr>
                                <tr>
                                    <td>
                                        <x-input-label for="phone" :value="__('Phone')" />
                                    </td>
                                    <td>
                                        <x-text-input id="phone" name="phone" type="text"
                                            class="mt-1 block form-control" :value="old('phone', $user->phone)"
                                            required />
                                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
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

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
            <div class="mx-7 d-none">
                <p class="text-sm mt-2 text-gray-800">
                    {{ __('Địa chỉ email của bạn chưa được xác thực.') }}
                    <button class="btn btn-light rounded" form="send-verification"
                        class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ __('Bấm vào đây để gửi lại email xác minh.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600">
                    {{ __('Một liên kết xác minh mới đã được gửi đến địa chỉ email của bạn.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <!--begin::Card toolbar-->
        <div class="end d-flex justify-content-end mx-10">
            <!--begin::Add-->
            <x-primary-button class="btn btn-primary rounded">{{ __('Lưu') }}</x-primary-button>
            @if (session('status') === 'profile-updated')
            @endif
            <!--begin::Menu-->
        </div>
        <!--end::Card toolbar-->
    </form>
</section>