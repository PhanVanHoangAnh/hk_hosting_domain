<!--begin::Menu- wrapper-->
<div notification-control="main-icon" class="btn btn-icon btn-active-light btn-active-color-primary w-30px h-30px w-md-40px h-md-40px position-relative"
    data-kt-menu-trigger="click" data-kt-menu-attach="parent"
    data-kt-menu-placement="bottom-end">
    <span class="material-symbols-rounded fs-1">
        notifications
    </span>
    @if (Auth::user()->unreadNotifications()->count())
        <span
            class="bullet bullet-dot bg-danger h-15px w-15px position-absolute translate-middle top-0 start-50 animation-blink notification-badge" style="top:3px!important">
                {{ Auth::user()->unreadNotifications()->count() }}
        </span>
        </span>
    @endif
</div>

<!--begin::Menu-->
<div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-400px"
    data-kt-menu="true" id="kt_menu_notifications"
>
    <!--begin::Heading-->
    <div class="d-flex flex-column bgi-no-repeat rounded-top"
    style="background-image: url('{{ asset('/core/assets/media/misc/menu-header-bg.jpg') }}')">
        <!--begin::Title-->
        <h3 class="text-white fw-semibold px-9 mt-10 mb-6">
            <span class="d-flex align-items-center">
                <span class="me-3">Thông Báo</span>
            </span>
        </h3>
        <!--end::Title-->
        <!--begin::Tabs-->
        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
            <li class="nav-item">
                <a notification-control="unread-tab-button" class="nav-link text-white opacity-75 opacity-state-100 pb-4 active"
                    data-bs-toggle="tab" href="#kt_topbar_notifications_2">Chưa
                    đọc
                    <span
                        class="opacity-75 badge badge-secondary text-dark ms-2">{{ Auth::user()->unreadNotifications()->count() }}
                    </span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4"
                    data-bs-toggle="tab" href="#kt_topbar_notifications_1">Tất cả</a>
            </li>
            <li class="nav-item d-none">
                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4"
                    data-bs-toggle="tab" href="#kt_topbar_notifications_3">Logs</a>
            </li>
        </ul>
        <!--end::Tabs-->
        </div>
        <!--end::Heading-->
        <!--begin::Tab content-->
        <div class="tab-content">

            <!--begin::Tab panel-->
            <div class="tab-pane fade show active" id="kt_topbar_notifications_2" role="tabpanel">
                <!--begin::Items-->
                <div notification-control="unread-notifications" class="scroll-y mh-325px mt-0 px-0 mb-0">
                    @if (!Auth::user()->unreadNotifications()->count())
                        <div>
                            <div class="text-center mb-7 mt-10">
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
                    @endif

                    @foreach (Auth::user()->unreadNotifications as $notification)
                        <!--begin::Item-->
                        <div class="d-flex flex-stack py-4 border-bottom px-5">
                            <!--begin::Section-->
                            <div class="d-flex align-items-center w-100">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-35px me-4">
                                    <div class="symbol symbol-35px">
                                        <div
                                            class="symbol-label fs-2 fw-semibold text-success">
                                            S</div>
                                    </div>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Title-->
                                <div class="mb-0 me-0 w-100">
                                    <{{ App\Helpers\Functions::getNotificationUrl($notification) ? 'a' : 'div' }} href="{{ App\Helpers\Functions::getNotificationUrl($notification) ?? '' }}"
                                        class="d-block"
                                    >
                                        <span class="d-flex align-items-center mb-1">
                                            <span
                                                class="fs-6 text-gray-800 text-hover-primary fw-bold">Hệ
                                                thống</span>
                                            <!--begin::Label-->
                                            <span class="fs-8 ms-auto bg-light px-1 rounded">{{ $notification->created_at->diffForHumans() }}</span>
                                            <!--end::Label-->
                                        </span>
                                        <span
                                            class="text-gray-600 fs-6">{!! $notification->data['message'] ?? null !!}</span>
                                    </{{ App\Helpers\Functions::getNotificationUrl($notification) ? 'a' : 'div' }}>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                    @endforeach
                </div>
                <!--end::Items-->
                <!--begin::View more-->
                <div class="py-3 text-center border-top">
                    <a
                        href="{{ action([App\Http\Controllers\ProfileController::class, 'notification']) }}"
                        class="btn btn-color-gray-600 btn-active-color-primary">Xem tất cả
                        <i class="ki-duotone ki-arrow-right fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i></a>
                </div>
                <!--end::View more-->
            </div>
            <!--end::Tab panel-->

            <!--begin::Tab panel-->
            <div class="tab-pane fade" id="kt_topbar_notifications_1"
                role="tabpanel">
                <!--begin::Items-->
                <div class="scroll-y mh-325px mt-0 px-0 mb-0"  notification-control="all-notifications">
                    @foreach (Auth::user()->notifications as $notification)
                        <!--begin::Item-->
                        <div class="d-flex flex-stack py-4 border-bottom px-5">
                            <!--begin::Section-->
                            <div class="d-flex align-items-center w-100">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-35px me-4">
                                    <div class="symbol symbol-35px">
                                        <div
                                            class="symbol-label fs-2 fw-semibold text-success">
                                            S</div>
                                    </div>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Title-->
                                <div class="mb-0 me-0 w-100">
                                    <{{ App\Helpers\Functions::getNotificationUrl($notification) ? 'a' : 'div' }} href="{{ App\Helpers\Functions::getNotificationUrl($notification) ?? '' }}"
                                        class="d-block"
                                    >
                                        <span class="d-flex align-items-center mb-1">
                                            <span
                                                class="fs-6 text-gray-800 text-hover-primary fw-bold">Hệ
                                                thống</span>
                                            <!--begin::Label-->
                                            <span class="fs-8 ms-auto bg-light px-1 rounded">{{ $notification->created_at->diffForHumans() }}</span>
                                            <!--end::Label-->
                                        </span>
                                        <span
                                            class="text-gray-600 fs-6">{!! $notification->data['message'] ?? null !!}</span>
                                    </{{ App\Helpers\Functions::getNotificationUrl($notification) ? 'a' : 'div' }}>
                                </div>
                                <!--end::Title-->
                            </div>
                            <!--end::Section-->
                        </div>
                        <!--end::Item-->
                    @endforeach
                </div>
                <!--end::Items-->
                <!--begin::View more-->
                <div class="py-3 text-center border-top">
                    <a href="{{ action([App\Http\Controllers\ProfileController::class, 'notification']) }}"
                        class="btn btn-color-gray-600 btn-active-color-primary">Xem tất cả
                        <i class="ki-duotone ki-arrow-right fs-5">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i></a>
                </div>
                <!--end::View more-->
            </div>
            <!--end::Tab panel-->
        
        
        </div>
        <!--end::Tab content--> 
    </div>
    <!--end::Menu-->

</div>
<!--end::Menu wrapper-->

