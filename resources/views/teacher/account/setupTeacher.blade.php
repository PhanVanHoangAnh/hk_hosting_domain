@extends('layouts.main.clean')

@section('content')
    <!-- Authentication -->
    <form method="POST" action="{{ route('logout') }}" class="d-block">
        @csrf

        <div class="text-end mt-4 pe-5">
            <a href="{{ route('logout') }}" class="btn btn-light py-2"
                onclick="event.preventDefault();
                                    this.closest('form').submit();">
                {{ __('Đăng xuất') }}
            </a>
        </div>
            
    </form>

    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Sign-in -->
        <div class="d-flex flex-column flex-lg-row flex-column-fluid">
            <!--begin::Body-->
            <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
                <!--begin::Form-->
                <div class="d-flex flex-center flex-column flex-lg-row-fluid pb-10">
                    <div class="mb-20">
                        <img class="h-65px" src="{{ url('/media/logos/asms.svg') }}" />
                    </div>
                    <!--begin::Wrapper-->
                    <div class="row mt-10 mw-1000px justify-content-center w-100">
                        <h1 class="text-center fw-normal mb-20">
                            Tài khoản người dùng chưa có liên kết với nhân sự giảng dạy tương ứng. Vui lòng liên hệ ASMS để được hỗ trợ.
                        </h1>

                        <h1 class="text-center fw-normal mb-20 d-none">
                            @if(!$sameEmailTeachers->count())
                                {{ __('Chọn tạo mới tài khoản bên dưới để tiếp tục:') }}
                            @else
                                {{ __('Chọn thông tin nhân sự của bạn ở dưới để tiếp tục:') }}
                            @endif
                        </h1>
                            <div class="d-flex justify-content-center d-none">
                                <script>
                                    var CreateTeacherForm = class {
                                        constructor(options) {
                                            this.form = options.form;
                                        
                                            this.events();
                                        }

                                        events() {
                                            $(this.form).on('click', e => {
                                                e.preventDefault();
                                                this.form.submit();
                                            })
                                        }
                                    }
                                </script>

                                @foreach ($sameEmailTeachers->get() as $teacher)
                                    <form id="teacher_form_create_{{ $teacher->id }}" data-control="teacher-form-create" action="{{ action([App\Http\Controllers\Teacher\AccountController::class, 'setupTeacherSave']) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                                        <input type="hidden" name="email" value="{{ $teacher->email }}">
                                        <a href="javascript:;" data-id="{{ $teacher->id }}" class="d-block py-8 px-10 mb-5 hover-elevate-up text-gray-800 as-module mw-md-450px">
                                            <span class="mb-10 d-block text-center">
                                                <span class="material-symbols-rounded" style="font-size:90px;">
                                                    assignment_ind
                                                </span>
                                            </span>
                                            <label class="fw-bold fs-3 d-block text-start mb-2 fw-bolder" for="">{{ $teacher->name }}</label>
                                            <p class="fs-6 mb-0">
                                                {{ $teacher->email }}
                                            </p>
                                        </a>
                                    </form>

                                    <script>
                                        new CreateTeacherForm({
                                            form: $('#teacher_form_create_{{ $teacher->id }}')
                                        })
                                    </script>
                                @endforeach

                                <script>
                                    var CreateNewTeacher = class {
                                        constructor(options) {
                                            this.form = options.form;
                                        }

                                        clickHandle() {
                                            $.ajax({
                                                url: this.getUrl(),
                                                method: 'post',
                                            }).done(response => {
                                                window.location.href = response.redirect_url;
                                            }).fail(response => {
                                                throw new Error("Add teacher fail!");
                                            })
                                        }

                                        events() {
                                            this.form.on('click', e => {
                                                e.preventDefault();
                                                this.clickHandle();
                                                // $(this.form).submit()
                                            })
                                        }
                                    }
                                </script>

                                @if(!$sameEmailTeachers->count())
                                    @php
                                        $createUserUniqId = "create_user_id" . uniqId();
                                    @endphp
                                    <div class="" style="" id="{{ $createUserUniqId }}">
                                        <a href="javascrip:;" data-id="new" class="d-block py-8 px-10 mb-5 hover-elevate-up text-gray-800 as-module mw-md-450px">
                                            <span class="mb-10 d-block text-center">
                                                <span class="material-symbols-rounded text-success" style="font-size:90px;">
                                                    person_add
                                                </span>
                                            </span>
                                            <label class="fw-bold fs-3 d-block text-start mb-2 fw-bolder" for="">Tạo mới</label>
                                            <p class="fs-6 mb-0">
                                                Tạo nhân sự mới
                                            </p>
                                        </a>

                                        <script>
                                            $(() => {
                                                createNewUserPopup = new CreateNewUserPopup();

                                                new CreateUser({
                                                    container: () => {
                                                        return $('#{{ $createUserUniqId }}')
                                                    }
                                                })
                                            })
                                        </script>

                                        <script>
                                            var createNewUserPopup;

                                            var CreateNewUserPopup = class {
                                                constructor(options) {
                                                    this.popup = new Popup();
                                                }

                                                get() {
                                                    return this.popup;
                                                }

                                                updateUrl(url) {
                                                    this.get().url = url;
                                                    this.get().load();
                                                }

                                                hide() {
                                                    this.get().hide();
                                                } 
                                            }

                                            var CreateUser = class {
                                                constructor(options) {
                                                    this.container = options.container;
                                                    
                                                    this.events();
                                                }

                                                getContainer() {
                                                    return this.container();
                                                }

                                                events() {
                                                    this.getContainer().on('click', e => {
                                                        e.preventDefault();

                                                        createNewUserPopup.updateUrl("{{ route('register.create.teacher') }}")
                                                    })
                                                }
                                            }
                                        </script>
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
                <!--end::Form-->
                
            </div>
            <!--end::Body-->
        </div>
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
@endsection

@section('footer')
@endsection