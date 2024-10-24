<div class="card card-flush h-xl-100 " style="overflow: scroll;">
    <!--begin::Header-->
    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start "
        data-bs-theme="light">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column pt-3">
            <span class="fw-bold fs-2 mb-3">Môn học đang mở</span>

            <div class="fs-6">
                <span class=""></span>

            </div>
        </h3>
        <!--end::Title-->

        <!--begin::Toolbar-->
        <div class="card-toolbar pt-3">
            <span class="fw-bold fs-2 mb-3 me-3">Lớp học</span>
            <span class="d-none">yêu cầu</span>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body pt-3 flush" style="overflow: scroll;">

        @foreach ($courseCounts as $courseCount )
            <div class="d-flex flex-stack">
                <!--begin::Wrapper-->
                <div class="d-flex align-items-center me-3">
                    <!--begin::Logo-->
                    <div class="d-flex align-items-center py-1 ">
                        <div class="symbol symbol-30px me-0 mb-0 pe-5">
                            <span class="menu-icon">
                                <span class="material-symbols-rounded">
                                    auto_stories
                                </span>
                            </span>
                        </div>
                    </div>
                    <!--end::Logo-->

                    <!--begin::Section-->
                    <div class="flex-grow-1">
                        <!--begin::Text-->
                        <a href=""
                            class="text-gray-800 text-hover-primary fs-5 fw-bold">{{ $courseCount->subject->name }}</a>
                        <!--end::Text-->


                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Statistics-->
                <div class="d-flex align-items-center">
                    <!--begin::Progress-->

                    <span class="text-gray-800 text-hover-primary fs-5 fw-bold">
                        {{ $courseCount->count }}
                    </span>

                    
                </div>
                <!--end::Statistics-->
            </div>
            <!--end::Item-->
            <div class="separator separator-dashed my-2"></div>
            <!--begin::Separator-->

            <!--end::Item-->
        @endforeach
        
    </div>
    <!--end::Body-->
</div>
