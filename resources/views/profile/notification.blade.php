@extends('layouts.main.app')
@section('content')
    <!--begin::Toolbar-->
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">

            <!--begin::Toolbar-->
            <div id="kt_app_toolbar" class="app-toolbar  py-3 py-lg-6 ">
                <!--begin::Toolbar container-->
                <div id="kt_app_toolbar_container" class="app-container  container-xxl d-flex flex-stack ">

                </div>
                <!--end::Toolbar container-->
            </div>
            <!--end::Toolbar-->

            <!--begin::Content-->
            <div id="kt_app_content" class="app-content  flex-column-fluid ">


                <!--begin::Content container-->
                <div id="kt_app_content_container" class="app-container  container-xxl ">
                    <!--begin::Layout-->
                    <div class="d-flex flex-column flex-lg-row">
                        <!--begin::Sidebar-->
                        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">

                            <!--begin::Card-->
                            <div class="card mb-5 mb-xl-8">
                                <!--begin::Card body-->
                                <div class="card-body">
                                    <!--begin::Summary-->


                                    <!--begin::User Info-->
                                    <div class="d-flex  flex-sm-nowrap flex-center flex-column py-5">
                                        <!--begin::Avatar-->
                                        <div class="image-input image-input-empty" data-kt-image-input="true">
                                            <div class="symbol symbol-100px symbol-circle mb-7">
                                                {{-- <img class="image-input-wrapper" src="{{ url('/core/assets/media/avatars/blank.png') }}" alt="image" /> --}}
                                                @if (Storage::disk('public')->exists('avatar/' . Auth::User()->id . '/profile_avatar.png'))
                                                    <img src="{{ asset('storage/avatar/' . Auth::User()->id . '/profile_avatar.png') }}"
                                                        alt="User Image">
                                                @else
                                                    <img src="{{ asset('/core/assets/media/avatars/blank.png') }}"
                                                        alt="Default Image">
                                                @endif


                                                <label
                                                    class=" d-none btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                    data-kt-image-input-action="change" data-bs-toggle="tooltip"
                                                    data-bs-dismiss="click" title="Change avatar" style="top:70px">
                                                    <span class="material-symbols-rounded d-flex align-items-center">
                                                        edit
                                                    </span>

                                                    <!--begin::Inputs-->
                                                    <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />

                                                    <!--end::Inputs-->
                                                </label>
                                            </div>
                                        </div>


                                        <!--end::Avatar-->

                                        <!--begin::Name-->
                                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">
                                            {{ Auth::User()->name }}</a>
                                        <!--end::Name-->

                                        <!--begin::Position-->
                                        <div class="mb-9">
                                            <!--begin::Badge-->
                                            <div class="badge badge-lg badge-light-primary d-inline"> @foreach (Auth::user()->roles as $role)
                                                        <span
                                                            class="badge badge-light-primary mb-1">
                                                            <span class="d-flex align-items-center">
                                                                <span>{{ trans('messages.module.' . $role->module) }}</span> <span class="material-symbols-rounded">
                                                                arrow_right
                                                                </span> <span> {{ $role->name }}</span>
                                                            </span>
                                                        </span>
                                                    @endforeach</div>
                                            <!--begin::Badge-->
                                        </div>
                                        <!--end::Position-->

                                        <!--begin::Info-->
                                        <!--begin::Info heading-->
                                        <div class="fw-bold mb-3 d-none">
                                            Assigned Tickets

                                            <span class="ms-2" ddata-bs-toggle="popover" data-bs-trigger="hover"
                                                data-bs-html="true"
                                                data-bs-content="Number of support tickets assigned, closed and pending this week.">
                                                <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span
                                                        class="path2"></span><span class="path3"></span></i> </span>
                                        </div>
                                        <!--end::Info heading-->

                                        <div class="d-flex flex-wrap flex-center d-none">
                                            <!--begin::Stats-->
                                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                                <div class="fs-4 fw-bold text-gray-700">
                                                    <span class="w-75px">243</span>
                                                    <i class="ki-duotone ki-arrow-up fs-3 text-success"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </div>
                                                <div class="fw-semibold text-muted">Total</div>
                                            </div>
                                            <!--end::Stats-->

                                            <!--begin::Stats-->
                                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                                <div class="fs-4 fw-bold text-gray-700">
                                                    <span class="w-50px">56</span>
                                                    <i class="ki-duotone ki-arrow-down fs-3 text-danger"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </div>
                                                <div class="fw-semibold text-muted">Solved</div>
                                            </div>
                                            <!--end::Stats-->

                                            <!--begin::Stats-->
                                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                                <div class="fs-4 fw-bold text-gray-700">
                                                    <span class="w-50px">188</span>
                                                    <i class="ki-duotone ki-arrow-up fs-3 text-success"><span
                                                            class="path1"></span><span class="path2"></span></i>
                                                </div>
                                                <div class="fw-semibold text-muted">Open</div>
                                            </div>
                                            <!--end::Stats-->
                                        </div>
                                        <!--end::Info-->
                                    </div>
                                    <!--end::User Info-->
                                    <!--end::Summary-->

                                    <!--begin::Details toggle-->
                                    <div class="d-flex flex-stack fs-4 py-3">
                                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                            href="#kt_user_view_details" role="button" aria-expanded="false"
                                            aria-controls="kt_user_view_details">
                                            Chi tiết
                                            <span class="ms-2 rotate-180">
                                                <i class="ki-duotone ki-down fs-3"></i> </span>
                                        </div>

                                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" class="d-none"
                                            data-bs-original-title="Edit customer details" data-kt-initialized="1">
                                            <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_update_details">
                                                Chỉnh sửa
                                            </a>
                                        </span>
                                    </div>
                                    <!--end::Details toggle-->

                                    <div class="separator"></div>

                                    <!--begin::Details content-->
                                    <div id="kt_user_view_details" class="collapse show">
                                        <div class="pb-5 fs-6">
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5">Account ID</div>
                                            <div class="text-gray-600">{{ Auth::User()->id }}</div>
                                            <!--begin::Details item-->
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5">Email</div>
                                            <div class="text-gray-600"><a href="#"
                                                    class="text-gray-600 text-hover-primary">{{ Auth::User()->email }}</a>
                                            </div>
                                            <!--begin::Details item-->


                                        </div>
                                    </div>
                                    <!--end::Details content-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                            <!--begin::Connected Accounts-->

                            <!--end::Connected Accounts-->
                        </div>
                        <!--end::Sidebar-->

                        <!--begin::Content-->
                        <div class="flex-lg-row-fluid ms-lg-15">
                            <div class="page-title d-flex flex-column py-1 ">
                                <!--begin::Title-->
                                <h1 class="d-flex align-items-center my-1">
                                    <span class="text-dark fw-bold fs-1">Thông tin cá nhân</span>
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
                                    <li class="breadcrumb-item text-muted">Tài khoản</li>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    <li class="breadcrumb-item">
                                        <span class="bullet bg-gray-200 w-5px h-2px"></span>
                                    </li>
                                    <!--end::Item-->
                                    <!--begin::Item-->
                                    <li class="breadcrumb-item text-muted">Thông tin</li>
                                    <!--end::Item-->

                                </ul>
                                <!--end::Breadcrumb-->
                            </div>
                            <!--begin:::Tabs-->
                            @include('profile._menu', [
                                'menu' => 'notification',
                            ])
                            <!--end:::Tabs-->

                            <!--begin:::Tab content-->



                            <!--begin:::Tab pane-->
                            <div class=" " id="" role="tabpanel">
                                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6   mb-6 mb-xl-9">
                                    <h2>Thông báo mới</h2>
                                    @if (!Auth::user()->unreadNotifications()->count())
                                        <div class="card mb-10">
                                            <div class="card-body">
                                                <div class="text-center mb-0 mt-5">
                                                    <svg style="width:60px;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 173.8 173.8">
                                                        <g style="isolation:isolate">
                                                            <g id="Layer_2" data-name="Layer 2">
                                                                <g id="layer1">
                                                                    <path
                                                                        d="M173.8,86.9A86.9,86.9,0,0,1,0,86.9,86,86,0,0,1,20.3,31.2a66.6,66.6,0,0,1,5-5.6A87.3,87.3,0,0,1,44.1,11.3,90.6,90.6,0,0,1,58.6,4.7a87.6,87.6,0,0,1,56.6,0,90.6,90.6,0,0,1,14.5,6.6A85.2,85.2,0,0,1,141,18.8a89.3,89.3,0,0,1,18.5,20.3A86.2,86.2,0,0,1,173.8,86.9Z"
                                                                        style="fill:#cdcdcd" />
                                                                    <path
                                                                        d="M159.5,39.1V127a5.5,5.5,0,0,1-5.5,5.5H81.3l-7.1,29.2c-.7,2.8-4.6,4.3-8.6,3.3s-6.7-4.1-6.1-6.9l6.3-25.6h-35a5.5,5.5,0,0,1-5.5-5.5V16.8a5.5,5.5,0,0,1,5.5-5.5h98.9A85.2,85.2,0,0,1,141,18.8,89.3,89.3,0,0,1,159.5,39.1Z"
                                                                        style="fill:#6a6a6a;mix-blend-mode:color-burn;opacity:0.2" />
                                                                    <path d="M23.3,22.7V123a5.5,5.5,0,0,0,5.5,5.5H152a5.5,5.5,0,0,0,5.5-5.5V22.7Z"
                                                                        style="fill:#f5f5f5" />
                                                                    <rect x="31.7" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                                                    <rect x="73.6" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                                                    <rect x="115.5" y="44.7" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                                                    <rect x="31.7" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                                                    <rect x="73.6" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                                                    <rect x="115.5" y="84.1" width="33.7" height="34.51" style="fill:#dbdbdb" />
                                                                    <path d="M157.5,12.8A5.4,5.4,0,0,0,152,7.3H28.8a5.5,5.5,0,0,0-5.5,5.5v9.9H157.5Z"
                                                                        style="fill:#dbdbdb" />
                                                                    <path d="M147.7,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,147.7,15Z"
                                                                        style="fill:#f5f5f5" />
                                                                    <path d="M138.3,15a3.4,3.4,0,1,1,6.7,0,3.4,3.4,0,0,1-6.7,0Z" style="fill:#f5f5f5" />
                                                                    <path d="M129,15a3.4,3.4,0,1,1,3.3,3.3A3.4,3.4,0,0,1,129,15Z" style="fill:#f5f5f5" />
                                                                    <rect x="32.1" y="29.8" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                                                    <rect x="32.1" y="36.7" width="116.6" height="3.85" style="fill:#dbdbdb" />
                                                                    <rect x="73.3" y="96.7" width="10.1" height="8.42"
                                                                        transform="translate(-38.3 152.9) rotate(-76.2)" style="fill:#595959" />
                                                                    <path
                                                                        d="M94.4,35.7a33.2,33.2,0,1,0,24.3,40.1A33.1,33.1,0,0,0,94.4,35.7ZM80.5,92.2a25,25,0,1,1,30.2-18.3A25.1,25.1,0,0,1,80.5,92.2Z"
                                                                        style="fill:#f8a11f" />
                                                                    <path
                                                                        d="M57.6,154.1c-.7,2.8,2,5.9,6,6.9h0c4,1,7.9-.5,8.6-3.3l11.4-46.6c.7-2.8-2-5.9-6-6.9h0c-4.1-1-7.9.5-8.6,3.3Z"
                                                                        style="fill:#253f8e" />
                                                                    <path d="M62.2,61.9A25,25,0,1,1,80.5,92.2,25,25,0,0,1,62.2,61.9Z"
                                                                        style="fill:#fff;mix-blend-mode:screen;opacity:0.6000000000000001" />
                                                                    <path
                                                                        d="M107.6,72.9a12.1,12.1,0,0,1-.5,1.8A21.7,21.7,0,0,0,65,64.4a11.6,11.6,0,0,1,.4-1.8,21.7,21.7,0,1,1,42.2,10.3Z"
                                                                        style="fill:#dbdbdb" />
                                                                    <path
                                                                        d="M54.3,60A33.1,33.1,0,0,0,74.5,98.8l-1.2,5.3c-2.2.4-3.9,1.7-4.3,3.4L57.6,154.1c-.7,2.8,2,5.9,6,6.9L94.4,35.7A33.1,33.1,0,0,0,54.3,60Z"
                                                                        style="fill:#dbdbdb;mix-blend-mode:screen;opacity:0.2" />
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </svg>
                                                </div>
                                                <p class="text-center mb-5">
                                                    Không có thông báo mới!
                                                </p>
                                            </div>
                                        </div>
                                    @endif

                                    @if (Auth::user()->unreadNotifications()->count())
                                        <div class="card mb-10">
                                            <div class="card-body">
                                                @foreach (Auth::user()->unreadNotifications as $notification)
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack py-4">
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Symbol-->
                                                            <div class="symbol symbol-35px me-4">
                                                                <div class="symbol symbol-35px">
                                                                    <div class="symbol-label fs-2 fw-semibold text-success">
                                                                        S</div>
                                                                </div>
                                                            </div>
                                                            <!--end::Symbol-->
                                                            <!--begin::Title-->
                                                            <div class="mb-0 me-2">
                                                                <a href="javascript:;">
                                                                    <span
                                                                        class="fs-6 text-gray-800 text-hover-primary fw-bold me-2">Hệ
                                                                        thống</span>
                                                                        
                                                                    <br />
                                                                    <span
                                                                        class="text-gray-600 fs-6">{!! $notification->data['message'] ?? null !!}</span>
                                                                </a>
                                                            </div>
                                                            <!--end::Title-->
                                                        </div>
                                                        <!--end::Section-->
                                                        <!--begin::Label-->
                                                        <span class="ms-auto">
                                                            <span
                                                                class="badge badge-light fs-8">{{ $notification->created_at->diffForHumans() }}
                                                            </span>
                                                            @if ($notification->read_at)
                                                                <span class="badge badge-secondary">Đã đọc</span>
                                                            @else
                                                                <span class="badge badge-warning">Chưa đọc</span>
                                                            @endif
                                                        </span>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Item-->
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    <h2>Thông báo đã xem</h2>
                                    <div class="card">
                                        <div class="card-body">
                                            @foreach (Auth::user()->readNotifications()->limit(100)->get() as $notification)
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack py-4">
                                                    <!--begin::Section-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-35px me-4">
                                                            <div class="symbol symbol-35px">
                                                                <div class="symbol-label fs-2 fw-semibold text-success">
                                                                    S</div>
                                                            </div>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Title-->
                                                        <div class="mb-0 me-2">
                                                            <a href="javascript:;">
                                                                <span
                                                                    class="fs-6 text-gray-800 text-hover-primary fw-bold me-2">Hệ
                                                                    thống</span>
                                                                    
                                                                <br />
                                                                <span
                                                                    class="text-gray-600 fs-6">{!! $notification->data['message'] ?? null !!}</span>
                                                            </a>
                                                        </div>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Section-->
                                                    <!--begin::Label-->
                                                    <span class="ms-auto">
                                                        <span
                                                            class="badge badge-light fs-8">{{ $notification->created_at->diffForHumans() }}
                                                        </span>
                                                        @if ($notification->read_at)
                                                            <span class="badge badge-secondary">Đã đọc</span>
                                                        @else
                                                            <span class="badge badge-warning">Chưa đọc</span>
                                                        @endif
                                                    </span>
                                                    <!--end::Label-->
                                                </div>
                                                <!--end::Item-->
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!--end:::Tab pane-->


                        </div>
                        <!--end:::Tab content-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Layout-->



            </div>
            <!--end::Content-->

        </div>
        <!--end::Content wrapper-->



    </div>
    <!--end::Toolbar-->

    <script>
        $(function() {
            new NotificationManager();
        });

        var NotificationManager = class {
            constructor() {
                this.unreadAll()
            }

            getUnreadAllUrl() {
                return '{{ action([App\Http\Controllers\NotificationController::class, 'unreadAll']) }}';
            }

            unreadAll() {
                var _this = this;

                $.ajax({
                    url: this.getUnreadAllUrl(),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                    }
                }).done(function(response) {})
            }
        }
    </script>
@endsection
