@section('head')
    <script src="{{ url('/lib/echarts/echarts.js') }}?v=4"></script>
@endsection

<div class="d-flex flex-wrap flex-sm-nowrap">
    
    <div class="flex-grow-1">
        <!--begin::Title-->
        <div class="d-flex justify-content-between align-items-start flex-wrap ">
            <!--begin::User-->
            <div class="d-flex flex-column">
                <!--begin::Name-->
                <div class="d-flex align-items-center mb-2">
                    <a class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $course->code }}</a>
                    <a>
                        <i class="ki-duotone ki-verify fs-1 text-primary">
                            <span class="path1"></span>
                            <span class="path2"></span>
                        </i>
                    </a>
                </div>
                <!--end::Name-->
                
            </div>
            <!--end::User-->
            <!--begin::Actions-->
            <div class="d-flex  ms-15">
                <div class="">
                    <a href="javascript:;"
                        class="btn btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                        data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        Thao tác
                        <i class="ki-duotone ki-down fs-5 ms-1"></i></a>
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-200px py-4 w-250px"
                        data-kt-menu="true">

                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a data-action="under-construction" row-action="update-contact" 
                                
                                class="menu-link px-3">Chỉnh sửa</a>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-3">
                            <a data-action="under-construction" row-action="delete" id="buttonDeleteCustom"
                            
                                class="menu-link px-3">Xóa</a>
                        </div>
                        <!--end::Menu item-->
                    </div>
                    <!--end::Menu-->
                </div>
                <!--begin::Menu-->

                <!--end::Menu-->
            </div>
            <!--end::Actions-->
        </div>
        <!--end::Title-->
        <!--begin::Stats-->
        <div class="d-flex flex-wrap flex-stack ">
            <div class="d-flex flex-column flex-grow-1 pe-8 d-flex align-items-start">
                <div class="d-flex">
                    <a class="border border-gray-300 border-dashed rounded min-w-125px py-3 me-3 mb-3 profile-stat-box" >
                        
                        <!--begin::Card body-->
                        <div class="card-body pt-2 pb-4 d-flex align-items-center">
                            <!--begin::Chart-->
                            <div class="d-flex flex-center me-5 pt-2">
                                <div id="requestChart" style="min-width: 70px; min-height: 70px" data-kt-size="70" data-kt-line="11"><span></span><canvas height="70" width="70"></canvas></div>
                            </div>
                            <!--end::Chart-->
                            <!--begin::Labels-->
                            <div class="d-flex flex-column content-justify-center w-60">
                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <div class="bullet w-8px h-6px rounded-2 bg-danger me-3"></div>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <div class="text-gray-500 flex-grow-1 w-70px me-3">Tổng giờ học</div>
                                    <!--end::Label-->
                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        {{ number_format($course->getTotalStudyHoursForCourse(), 1) }}
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center my-3">
                                    <!--begin::Bullet-->
                                    <div class="bullet w-8px h-6px rounded-2 bg-primary me-3"></div>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <div class="text-gray-500 flex-grow-1 w-70px me-3">Đã học</div>
                                    <!--end::Label-->
                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        {{ number_format($course->getStudiedHoursForCourse() , 1) }}
                                        
                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                                <!--begin::Label-->
                                <div class="d-flex fs-6 fw-semibold align-items-center">
                                    <!--begin::Bullet-->
                                    <div class="bullet w-8px h-6px rounded-2 me-3" style="background-color: #E4E6EF">
                                    </div>
                                    <!--end::Bullet-->
                                    <!--begin::Label-->
                                    <div class="text-gray-500 flex-grow-1 w-70px me-3">Chưa học</div>
                                    <!--end::Label-->
                                    <!--begin::Stats-->
                                    <div class="fw-bolder text-gray-700 text-xxl-end">
                                        {{ number_format($course->getRemainStudyHoursForCourse(), 1) }}

                                    </div>
                                    <!--end::Stats-->
                                </div>
                                <!--end::Label-->
                            </div>
                            <!--end::Labels-->
                        </div>
                        <!--end::Card body-->
                    </a>
                    <a class="border border-gray-300 border-dashed rounded min-w-200px py-3 me-3 mb-3 ">
                        <div class="card-header pt-3 border-0 ps-5">
                            <div class="card-title d-flex flex-column">
                                <div class="d-flex ">
                                    <div class="card-header py-0">
                                        <div class="card-title d-flex flex-column ">
                                            <div class="d-flex align-items-top">
                                                <div>
                                                    <span class="fs-1 fw-semibold text-info">{{ $course->countStudentsByCourse() }}</span>
                                                    <span class="d-block text-gray-400 fw-semibold fs-6">Học viên</span>
                                                </div>
    
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </a>
                    <a class="border border-gray-300 border-dashed rounded min-w-200px py-3 me-3 mb-3 ">
                        <div class="card-header pt-3 border-0 ps-5">
                            <div class="card-title d-flex flex-column">
                                <div class="d-flex ">
                                    <div class="card-header py-0">
                                        <div class="card-title d-flex flex-column ">
                                            <div class="d-flex align-items-top">
                                                <div>
                                                    <span class="fs-1 fw-semibold text-info">{{ $course->start_at ? date('d/m/Y', strtotime($course->start_at)) : '--' }}</span>
                                                    <span class="d-block text-gray-400 fw-semibold fs-6">Ngày bắt đầu</span>
                                                </div>
    
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
    
                        </div>
                    </a>
                    <a class="border border-gray-300 border-dashed rounded min-w-150px py-3 me-3 mb-3 ">
                        <div class="card-header pt-3 border-0 ps-5">
                            <div class="card-title d-flex flex-column">
                                <div class="d-flex ">
                                    <div class="card-header py-0">
                                        <div class="card-title d-flex flex-column ">
                                            <div class="d-flex align-items-top">
                                                <div>
                                                    <span class="fs-1 fw-semibold text-info">   
                                                        {{ $course->getNumberSections() != 0 ? \Carbon\Carbon::parse($course->end_at)->format('d/m/Y') : '--' }}
                                                    </span>
                                                    <span class="d-block text-gray-400 fw-semibold fs-6">Ngày kết thúc</span>
                                                </div>
    
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
    
                        </div>
                    </a>
                </div>
            </div>
        </div>

        
        <!--end::Stats-->
    </div>
    <!--end::Info-->
</div>

<script>
    var dom = document.getElementById('requestChart');
    var myChart = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });
    var app = {};

    var option;

    option = {
        tooltip: {
            trigger: 'item',
            formatter: '{a} <br/>{b} : {c} giờ'
        },
        series: [
            {
            name: '{{$course->subject->name}}',
            type: 'pie',
            radius: ['40%', '70%'],
            avoidLabelOverlap: false,
            label: {
                show: false,
                position: 'center'
            },
            emphasis: {
                label: {
                show: false,
                fontSize: 40,
                fontWeight: 'bold'
                }
            },
            labelLine: {
                show: false
            },
            data: [
                { value: {{ number_format($course->getStudiedHoursForCourse() , 1) }}, name: 'Đã học' ,itemStyle: {color: '#ed8f0c'},},
                { value:  {{ number_format($course->getTotalStudyHoursForCourse() - $course->getStudiedHoursForCourse(), 1) }}, name: 'Chưa học'  ,itemStyle: {color: '#E4E6EF'},},
               
                
            ]
            }
        ]
    };

    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
</script>
