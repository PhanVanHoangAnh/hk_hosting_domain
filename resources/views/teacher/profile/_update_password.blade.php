@extends('layouts.main.teacher', [
    'menu' => 'teacher',
])

@section('sidebar')
    @include('teacher.modules.sidebar', [
        'menu' => 'profile',  
    ])
@endsection

@section('content')
    <div class="app-main flex-column flex-row-fluid " id="kt_app_main">
        <!--begin::Content wrapper-->
        <div class="d-flex flex-column flex-column-fluid">
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
                                    <!--begin::User Info-->
                                    <div class="d-flex  flex-sm-nowrap flex-center flex-column py-5">
                                        <!--begin::Avatar-->
                                        <div class="image-input image-input-empty" data-kt-image-input="true">
                                        <div class="symbol symbol-100px symbol-circle mb-7">
                                            @if (Storage::disk('public')->exists("avatar/" . Auth::User()->id . "/profile_avatar.png"))
                                                <img src="{{ asset("storage/avatar/" . Auth::User()->id . "/profile_avatar.png") }}" alt="User Image">
                                            @else
                                                <img src="{{ asset('/core/assets/media/avatars/blank.png') }}" alt="Default Image">
                                            @endif
                                            <label class=" d-none btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow"
                                                data-kt-image-input-action="change"
                                                data-bs-toggle="tooltip"
                                                data-bs-dismiss="click"
                                                title="Change avatar" 
                                                style="top:70px">
                                                <span class="material-symbols-rounded d-flex align-items-center">
                                                    edit
                                                </span>
                                                <input  type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                            </label>
                                        </div>
                                    </div>
                                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">
                                            {{ Auth::User()->name }}</a>
                                        <div class="mb-9">
                                            <div class="badge badge-lg badge-light-primary d-inline">
                                                {{ Auth::User()->account->teacher->type }}
                                            </div>
                                        </div>
                                        <div class="fw-bold mb-3 d-none">
                                            Assigned Tickets
                                            <span class="ms-2" ddata-bs-toggle="popover" data-bs-trigger="hover"
                                                data-bs-html="true"
                                                data-bs-content="Number of support tickets assigned, closed and pending this week.">
                                                <i class="ki-duotone ki-information fs-7">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                    <span class="path3"></span>
                                                </i> 
                                            </span>
                                        </div>
                                    </div>
                                    <!--begin::Details toggle-->
                                    <div class="d-flex flex-stack fs-4 py-3">
                                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse"
                                            href="#kt_user_view_details" role="button" aria-expanded="false"
                                            aria-controls="kt_user_view_details">
                                            Chi tiết
                                            <span class="ms-2 rotate-180">
                                                <i class="ki-duotone ki-down fs-3">
                                                </i>
                                            </span>
                                        </div>

                                        <span data-bs-toggle="tooltip" data-bs-trigger="hover" class="d-none"
                                            data-bs-original-title="Edit customer details" data-kt-initialized="1">
                                            <a href="#" class="btn btn-sm btn-light-primary" data-bs-toggle="modal"
                                                data-bs-target="#kt_modal_update_details">
                                                Chỉnh sửa
                                            </a>
                                        </span>
                                    </div>
                                    <div class="separator"></div>
                                    <div id="kt_user_view_details" class="collapse show">
                                        <div class="pb-5 fs-6">
                                            <!--begin::Details item-->
                                            <div class="fw-bold mt-5">Account ID</div>
                                            <div class="text-gray-600">{{ Auth::User()->id }}</div>
                                            <div class="fw-bold mt-5">Email</div>
                                            <div class="text-gray-600">
                                                <a href="#" class="text-gray-600 text-hover-primary">
                                                    {{ Auth::User()->email }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end::Details content-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
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
                            @include('teacher.profile._menu', [
                                'menu' => 'updatePassword',
                            ])
                            <!--end:::Tabs-->
                                <!--begin:::Tab pane-->
                                <div class=" " id=""
                                    role="tabpanel">
                                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6   mb-6 mb-xl-9">
                                        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg mb-10 card">
                                            <div class="max-w-xl">
                                                @include('teacher.profile.partials.update-password-form')
                                            </div>
                                        </div>
                                    </div>
                                    <!--begin::Card-->
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
    // $(function() {
    //     UploadAvatar.init();
    // });

    var UploadAvatar = {
        init: function () {
            $('input[name="avatar"]').on('change', function () {
                var input = $(this);
                var file = input[0].files[0];

                if (file) {
                    var formData = new FormData();
                    var userId = {{ Auth::user()->id }}; 

                    formData.append('avatar', file);
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        type: 'POST',
                        url: '/update-profile-picture/' + userId,
                        data: formData,
                        processData: false,  
                        contentType: false,  
                        success: function (response) {
                            ASTool.alert({
                                message: response.message,
                                ok: function() {
                                    // reload page
                                    location.reload();
                                }
                            });
                        },
                        error: function (error) {
                            throw new Error(error);
                        }
                    });
                }
            });
        }
    };
</script>
@endsection
