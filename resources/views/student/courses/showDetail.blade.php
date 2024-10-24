@extends('layouts.main.student', [
    'menu' => 'student',
])
@section('sidebar')
@include('student.modules.sidebar', [
        'menu' => 'courses',
        'sidebar' =>'courses',
])
@endsection
@section('content')
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title d-flex flex-column py-1">
            <!--begin::Title-->
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Thông tin chi tiết</span>
            </h1>
            <!--end::Title-->
            <!--begin::Breadcrumb-->
            <ul class="breadcrumb breadcrumb-separatorless fs-7 my-1">
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">
                    <a href="{{ action([App\Http\Controllers\Student\CourseController::class, 'index']) }}"
                        class="text-muted text-hover-primary">Trang chủ</a>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-muted">Lớp học</li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-200 w-5px h-2px"></span>
                </li>
                <!--end::Item-->
                <!--begin::Item-->
                <li class="breadcrumb-item text-dark">Thông tin</li>
                <!--end::Item-->
            </ul>
            <!--end::Breadcrumb-->
        </div>
        <!--end::Page title-->
    </div>

    <div class="post" id="kt_post">
        <!--begin::Navbar-->
        <div class="card mb-5 mb-xl-10">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                @include('student.courses.detail', [
                    'detail' => 'showDetail',
                ])
                <!--end::Details-->

                @include('student.courses.menu', [
                    'menu' => 'showDetail',
                ])

            </div>
        </div>
        <div class="card mb-5 mb-xl-10">
            <!--begin::Card header-->
            <div class="card-header cursor-pointer">
                <!--begin::Card title-->
                <div class="card-title m-0">
                    <h3 class="fw-bold m-0">Thông tin cơ bản</h3>
                </div>
                <!--end::Card title-->
                <!--begin::Action-->
                <!--begin::Button-->
                <a class="btn btn-flex btn-sm btn-primary fw-bold border-0 fs-6 h-40px align-self-center d-none"
                    row-action="update-contact" id="buttonsEditContact">
                    <i class="ki-duotone ki-abstract-10">
                        <i class="path1"></i>
                        <i class="path2"></i>
                    </i>
                    Chỉnh sửa thông tin
                </a>

            </div>
            <!--begin::Card header-->
            <!--begin::Card body-->
            <div class="card-body p-9" id="ContactsInformation">
                <!--begin::Row-->
                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 text-muted">Mã môn học</label>
                    <div class="col-lg-4">
                        <span class="fw-bold fs-6 text-gray-800">{{ $course->code }}</span>
                    </div>
                    <label class="col-lg-2 text-muted">Trạng thái</label>
                    <div class="col-lg-4 fv-row">
                        
                        @php
                            $bgs = [
                                App\Models\Course::OPENING_STATUS => 'secondary',
                                App\Models\Course::COMPLETED_STATUS => 'success',
                                App\Models\Course::WAITING_OPEN_STATUS => 'warning',
                            ];
                        @endphp
                            <span class="badge bg-{{ $bgs[$course->checkStatusSubject()] ?? 'info text-white' }}"
                                data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click"
                                data-bs-placement="right">
                                {{$course->checkStatusSubject()}}
                            </span>
                    </div>
                </div>

                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 text-muted">Chủ nhiệm</label>
                    <div class="col-lg-4">
                        <span class="fw-bold fs-6 text-gray-800">{{ $course->teacher->name }}</span>
                    </div>
                    <label class="col-lg-2 text-muted">Thời Lượng Mỗi Buổi Học</label>
                    <div class="col-lg-4 fv-row">
                        <span class="text-gray-800 fs-6">???? phút</span>
                    </div>
                </div>

                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 text-muted">Tổng giờ cần học</label>
                    <div class="col-lg-4">
                        <span class=" fs-6 text-gray-800">{{number_format($course->getTotalStudyHoursForCourse(), 1)}} giờ</span>
                    </div>
                    <label class="col-lg-2 text-muted">Học viên linh hoạt</label>
                    <div class="col-lg-4 fv-row">
                        <span class="text-gray-800 fs-6">{{ $course->flexible_students ?? 0}} học viên </span>
                    </div>
                </div>


                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 text-muted">Học viên tối đa</label>
                    <div class="col-lg-4">
                        <span class=" fs-6 text-gray-800">{{ $course->max_students ?? 0}} học viên</span>
                    </div>
                    <label class="col-lg-2 text-muted">Học viên đã tham gia</label>
                    <div class="col-lg-4 fv-row">
                        <span class="text-gray-800 fs-6"> {{ $course->countStudentsByCourse() }} học viên </span>
                    </div>
                </div>

                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 text-muted">Ngày bắt đầu</label>
                    <div class="col-lg-4">
                        <span class=" fs-6 text-gray-800">{{ $course->start_at ? date('d/m/Y', strtotime($course->start_at)) : '--' }}</span>
                    </div>
                    <label class="col-lg-2 text-muted">Ngày kết thúc</label>
                    <div class="col-lg-4 fv-row">
                        <span class="text-gray-800 fs-6">
                            {{ $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->end_at)->format('d/m/Y') : '--' }}
                        </span>
                    </div>
                </div>

                <div class="row mb-7">
                    <!--begin::Label-->
                    <label class="col-lg-2 text-muted">Loại hình lớp</label>
                    <div class="col-lg-4">
                        <span class=" fs-6 text-gray-800">{{ isset($course->study_method) ? $course->study_method : '--' }}</span>
                    </div>

                    <!--
                    @if(isset($course->study_method) && $course->study_method === \App\Models\Course::STUDY_METHOD_OFFLINE)
                        <label class="col-lg-2 text-muted">Địa điểm phòng học</label>
                        <div class="col-lg-4 fv-row">
                                <span class="text-gray-800 fs-6">
                                    {{ $course->location}}
                                </span>
                            </div>
                        </div>
                    @elseif(isset($course->study_method) && $course->study_method === \App\Models\Course::STUDY_METHOD_ONLINE)
                    <div>
                        <div class="row mt-8 align-items-top" form-control="zoom">
                            <div class="col-lg-11 col-xl-11 col-md-11 col-sm-11 col-11 mb-6">
                                <label class="fs-6 fw-bold mb-3" for="target-input">Link mở phòng học (cho chủ phòng)</label>
                                {{-- <input type="text" class="form-control cursor-pointer" placeholder="Chưa tạo phòng học..." name="zoom_start_link" 
                                value="{{ $course->zoom_start_link ?? '' }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                readonly/> --}}
                                <p>
                                    <a href="{{ $course->zoom_start_link ?? '' }}" target="_blank" class="text-info">
                                        {{ $course->zoom_start_link ?? '' }}
                                    </a>
                                </p>
                            </div>
                            {{-- <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 mb-6 d-flex align-items-end">
                                <button action-control="copy-start-link" class="btn btn-secondary text-bold">Copy</button>
                            </div> --}}
                            <div class="col-lg-11 col-xl-11 col-md-11 col-sm-11 col-11 mb-6">
                                <label class="fs-6 fw-bold mb-3" for="target-input">Link tham gia (cho các học viên)</label>
                                {{-- <input type="text" class="form-control cursor-pointer" placeholder="Chưa tạo phòng học..." name="zoom_join_link" 
                                value="{{ $course->zoom_join_link ?? '' }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                readonly/> --}}
                                <p>
                                    <a href="{{ $course->zoom_join_link ?? '' }}" target="_blank" class="text-info">
                                        {{ $course->zoom_join_link ?? '' }}
                                    </a>
                                </p>
                            </div>
                            {{-- <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 mb-6 d-flex align-items-end">
                                <button action-control="copy-join-link" class="btn btn-secondary text-bold">Copy</button>
                            </div> --}}
                            <div class="col-lg-2 col-xl-2 col-md-2 col-sm-2 col-2 mb-6">
                                <label class="fs-6 fw-bold mb-3" for="target-input">Mật khẩu</label>
                                <input type="password" placeholder="Chưa có mật khẩu" class="form-control cursor-pointer text-center" name="zoom_password" autocomplete="on"
                                value="{{ $course->zoom_password ?? '' }}"
                                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
                                readonly/>
                            </div>
                            <div class="col-lg-1 col-xl-1 col-md-1 col-sm-1 col-1 mb-6 d-flex align-items-end">
                                <button action-control="copy-link-password" class="btn btn-secondary text-bold">Copy</button>
                            </div>

                        </div>
                            <script>
                                var zoomLink;

                                $(() => {
                                    zoomLink = new ZoomLink({
                                        container: document.querySelector('[form-control="zoom"]')
                                    })
                                })

                                var ZoomLink = class {
                                    constructor(options) {
                                        this.container = options.container;

                                        this.events();
                                    }

                                    getContainer() {
                                        return this.container;
                                    }

                                     // Start Link
                                    getZoomStartLinkInput() {
                                        return this.getContainer().querySelector('[name="zoom_start_link"]');
                                    }

                                    getZoomStartLinkValue() {
                                        return this.getZoomStartLinkInput().value;
                                    }

                                    setZoomStartLinkValue(link) {
                                        this.getZoomStartLinkInput().value = link;
                                    }

                                    getCopyStartLinkBtn() {
                                        return this.getContainer().querySelector('[action-control="copy-start-link"]');
                                    }

                                    // Join link
                                    getZoomJoinLinkInput() {
                                        return this.getContainer().querySelector('[name="zoom_join_link"]');
                                    }

                                    getZoomJoinLinkValue() {
                                        return this.getZoomJoinLinkInput().value;
                                    }

                                    setZoomJoinLinkValue(link) {
                                        this.getZoomJoinLinkInput().value = link;
                                    }

                                    getCopyjoinLinkBtn() {
                                        return this.getContainer().querySelector('[action-control="copy-join-link"]');
                                    }

                                    // Zoom password
                                    getZoomPasswordInput() {
                                        return this.getContainer().querySelector('[name="zoom_password"]');
                                    }

                                    getZoomPasswordValue() {
                                        return this.getZoomPasswordInput().value;
                                    }

                                    setZoomPasswordValue(link) {
                                        this.getZoomPasswordInput().value = link;
                                    }

                                    getCopyPasswordBtn() {
                                        return this.getContainer().querySelector('[action-control="copy-link-password"]');
                                    }

                                    changeToCopied(button) {
                                        button.innerHTML = "Copied! <span class='material-symbols-rounded'>done</span>";
                                        button.classList.remove('btn-secondary');
                                        button.classList.add('btn-success');
                                    }

                                    changeToNotCopyYet(button) {
                                        button.innerHTML = "Copy";
                                        button.classList.remove('btn-success');
                                        button.classList.add('btn-secondary');
                                    }

                                    clickCopyHandle(e, value) {
                                        const button = e.target;
                                        
                                        copyToClipboard(value);
                                        this.changeToCopied(button);

                                        setTimeout(() => {
                                            this.changeToNotCopyYet(button);
                                        }, 2000);
                                    }

                                    clickPassWordHandle(e) {
                                        const element = e.target;
                                        const type = element.getAttribute('type');

                                        if (type === 'text') {
                                            element.setAttribute('type', 'password');
                                        } else if (type === 'password') {
                                            element.setAttribute('type', 'text');
                                        } else {
                                            element.setAttribute('type', 'password');
                                        }
                                    }

                                    events() {
                                        const _this = this;

                                        $(_this.getZoomPasswordInput()).on('click', function(e) {
                                            e.preventDefault();
                                            _this.clickPassWordHandle(e);
                                        })

                                        // Copy
                                        // Click Copy start link
                                        $(_this.getCopyStartLinkBtn()).on('click', function(e) {
                                            e.preventDefault();
                                            const value = _this.getZoomStartLinkValue();
                                            _this.clickCopyHandle(e, value);
                                        })

                                        // Click Copy join link
                                        $(_this.getCopyjoinLinkBtn()).on('click', function(e) {
                                            e.preventDefault();
                                            const value = _this.getZoomJoinLinkValue();
                                            _this.clickCopyHandle(e, value);
                                        })

                                        // Click Copy password
                                        $(_this.getCopyPasswordBtn()).on('click', function(e) {
                                            e.preventDefault();
                                            const value = _this.getZoomPasswordValue();
                                            _this.clickCopyHandle(e, value);
                                        })
                                    }
                                }
                            </script>
                    </div>
                    @else 
                        <span class="text-gray-800 fs-6">
                            Lỗi -> chưa có thông tin
                        </span>
                    @endif
                    -->
            </div>
            <!--end::Card body-->
        </div>

@endsection