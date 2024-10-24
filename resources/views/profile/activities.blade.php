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



                    <!--begin::Page title-->
                    
                    <!--end::Page title-->

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
                                    <div class="d-flex flex-center flex-column py-5">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-100px symbol-circle mb-7">
                                            <img src="{{ url('/core/assets/media/avatars/blank.png') }}" alt="image" />
                                        </div>
                                        <!--end::Avatar-->

                                        <!--begin::Name-->
                                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">
                                            {{ Auth::User()->name }}</a>
                                        <!--end::Name-->

                                        <!--begin::Position-->
                                        <div class="mb-9">
                                            <!--begin::Badge-->
                                            <div class="badge badge-lg badge-light-primary d-inline">
                                                @foreach (Auth::user()->roles as $role)
                                                        <span
                                                            class="badge badge-light-primary mb-1">
                                                            <span class="d-flex align-items-center">
                                                                <span>{{ trans('messages.module.' . $role->module) }}</span> <span class="material-symbols-rounded">
                                                                arrow_right
                                                                </span> <span> {{ $role->name }}</span>
                                                            </span>
                                                        </span>
                                                    @endforeach
                                            </div>
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
                                    <li class="breadcrumb-item text-muted">Hoạt động</li>
                                    <!--end::Item-->
                                   
                                </ul>
                                <!--end::Breadcrumb-->
                            </div>

                            <!--begin:::Tabs-->
                            @include('profile._menu', [
                                'menu' => 'activities',
                            ])
                            <!--end:::Tabs-->

                            <!--begin:::Tab content-->
                            <!--begin:::Tab pane-->
                                <div class="" id="" role="tabpanel">
                                    <!--begin::Card-->
                                    <div class="card pt-4 mb-6 mb-xl-9">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2>Hoạt động</h2>
                                            </div>
                                            <!--end::Card title-->

                                            <!--begin::Card toolbar-->
                                            <div class="card-toolbar d-none">
                                                <!--begin::Filter-->
                                                <button type="button" class="btn btn-sm btn-flex btn-light-primary"
                                                    id="kt_modal_sign_out_sesions">
                                                    <i class="ki-duotone ki-entrance-right fs-3"><span
                                                            class="path1"></span><span class="path2"></span></i>Xem thêm
                                                </button>
                                                <!--end::Filter-->
                                            </div>
                                            <!--end::Card toolbar-->
                                        </div>
                                        <!--end::Card header-->

                                        <!--begin::Card body-->
                                        <div class="card-body pt-0 pb-5 scroll-y pe-7" style="height: 500px; overflow-y: auto;">
                                            <!--begin::Table wrapper-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <div class="timeline timeline-border-dashed">

                                                    @foreach ($notes as $note)

                                                    <!--begin::Timeline item-->
                                                    <div class="timeline-item">
                                                        <!--begin::Timeline line-->
                                                        <div class="timeline-line"></div>
                                                        <!--end::Timeline line-->

                                                        <!--begin::Timeline icon-->
                                                        <div class="timeline-icon me-4">
                                                            <i class="ki-duotone ki-flag fs-2 text-gray-500"><span
                                                                    class="path1"></span><span class="path2"></span></i>
                                                        </div>
                                                        <!--end::Timeline icon-->

                                                        <!--begin::Timeline content-->
                                                        <div class="timeline-content mb-10 ">
                                                            <!--begin::Timeline heading-->
                                                            <div class="overflow-auto pe-3">
                                                                <!--begin::Title-->
                                                                <div class="fs-5 fw-semibold mb-2">{{$note->content}}</div>
                                                                <!--end::Title-->

                                                                <!--begin::Description-->
                                                                <div class="d-flex align-items-center mt-1 fs-6">
                                                                    <!--begin::Info-->
                                                                    <div class="text-muted me-2 fs-7">Cập nhật lúc {{date('d/m/Y h:m', strtotime($note->updated_at))}} bởi
                                                                    </div>
                                                                    <!--end::Info-->

                                                                    <!--begin::User-->
                                                                    <div class="symbol symbol-circle symbol-25px"
                                                                        data-bs-toggle="tooltip" data-bs-placement="right" title="{{$note->account->name}}">
                                                                        
                                                                        @if (Storage::disk('public')->exists("avatar/" . Auth::User()->id . "/profile_avatar.png"))
                                                                            <img src="{{ asset("storage/avatar/" . Auth::User()->id . "/profile_avatar.png") }}" alt="User Image">
                                                                        @else
                                                                            <img src="{{ asset('/core/assets/media/avatars/blank.png') }}" alt="Default Image">
                                                                        @endif
                                                                    </div>
                                                                    <!--end::User-->
                                                                </div>
                                                                <!--end::Description-->
                                                            </div>
                                                            <!--end::Timeline heading-->
                                                        </div>
                                                        <!--end::Timeline content-->
                                                    </div>
                                                    <!--end::Timeline item-->
                                                   @endforeach
                                                    



                                                </div>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Table wrapper-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->

                                    
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
    @endsection
