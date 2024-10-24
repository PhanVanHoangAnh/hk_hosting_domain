<div class="card card-flush h-xl-100 " style="overflow: scroll;">
    <!--begin::Header-->
    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start "
        data-bs-theme="light">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column pt-3">
            <span class="fw-bold fs-2 mb-3">Thời khóa biểu</span>

            <div class="fs-6">
                <span class=""></span>

            </div>
        </h3>
        <!--end::Title-->

        <!--begin::Toolbar-->
        
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body pt-3 flush mt-3" style="overflow: scroll;">
        @if ($sectionsInComing->isEmpty())
            <div class="alert alert-danger">Chưa có lịch học sắp tới</div>
        @else
            @foreach ($sectionsInComing as $section )
                <div class="d-flex flex-stack">
                    
                    <div class="d-flex align-items-center me-3">
                        
                        <div class="flex-grow-1">
                            <a href="#" class="text-gray-800 text-hover-primary fs-5 fw-bold">{{isset($section->course->subject ) ? $section->course->subject->name : "" }}</a>
                            
                            <span class="d-block"> 
                                {{ \Carbon\Carbon::parse($section->course->start_at)->format('d/m/Y') }} -  {{ \Carbon\Carbon::parse($section->course->end_at)->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                    
                        <span class="text-gray-800 text-hover-primary fw-bold lh-0">
                            {{ $section->getDiffTimeStudyDate() }} 
                        </span>

                    </div>
                    <!--end::Statistics-->
                </div>
                <!--end::Item-->
                <div class="separator separator-dashed my-2"></div>
                <!--begin::Separator-->

                <!--end::Item-->
            @endforeach
        @endif
            
           
    </div>
    <!--end::Body-->
</div>
