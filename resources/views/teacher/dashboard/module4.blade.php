<div class="card card-flush h-lg-100">
    <!--begin::Header-->
    <div class="card-header pt-3">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column ">
            <span class="card-label fw-bold text-gray-900 pb-7">Tình trạng đào tạo trong tháng</span>
            <span class="text-gray-500 pt-2 fw-semibold fs-6 d-none">Tăng trưởng 40%</span>
        </h3>
        <!--end::Title-->

        <!--begin::Toolbar-->
        <div class="card-toolbar">

        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    <div class="card-body pt-0 px-0"
        style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
        <!--begin::Chart-->
        <div style="height: 100%; position: relative; margin: 0;">
            <div id="requestChart" style="height: 100%; position: absolute; bottom: 5; width: 100%;"></div>
        </div>
        <!--end::Chart-->

        <!-- Center the buttons at the bottom -->
        <div class="text-center mt-10">
            <a list-action='add-request-contact' class="btn btn-info me-3 rounded d-none">Thêm đơn hàng</a>
            <a href="{{ action([App\Http\Controllers\Accounting\OrderController::class, 'index']) }}"
                class="btn btn-light rounded d-none">Xem danh sách</a>
        </div>
    </div>
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
            formatter: '{a} <br/>{b} : {c} ({d}%)'
        },
        legend: {
            top: '0',
            left: 'center',
        },
        
        series: [{
            name: 'Tình trạng đào tạo',
            type: 'pie',
            radius: '60%',
            center: ['50%', '63%'], 
            
            itemStyle: {
                borderRadius: 0
            },
            emphasis: {
                label: {
                    show: true,
                    fontSize: 15,
                    fontWeight: 'bold'
                }
            },
            data: [
                @foreach ($trainingCount as $status => $count)

                {
                    value: {{ $count }},
                    name: @json(trans('messages.student_section.' . $status))
                },
                @endforeach
            ],
            labelLine: {

                smooth: 0.2,
                length: 10,
                length2: 10
            },
        }]
    };


    if (option && typeof option === 'object') {
        myChart.setOption(option);
    }

    window.addEventListener('resize', myChart.resize);
</script>


