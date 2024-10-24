<link rel="stylesheet" href="{{ url('chart_circle/circle.css') }}" />


<div class="card card-flush h-xl-100 ">
    <!--begin::Header-->
    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start mb-2 pt-3"
        data-bs-theme="light">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column ">
            <span class="fw-bold fs-2 mb-3">Tỷ lệ loại hợp đồng trong tháng này</span>
            {{-- <span class="card-label fw-bold text-gray-900 pb-7">Tỷ lệ loại hợp đồng</span> --}}
            <span class="text-gray-500 pt-2 fw-semibold fs-6 d-none">Tăng trưởng 40%</span>
        </h3>
        <!--end::Title-->

        <!--begin::Toolbar-->
        <div class="card-toolbar">

        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->
    <div class="card-body pt-0 px-0"
        style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;">
        <!--begin::Chart-->
        <div style="height: 100%; position: relative; margin: 0;">
            <div id="orderTypeChart" style="height: 100%; position: absolute; bottom: 5; width: 100%;"></div>
            
        </div>
        <!--end::Chart-->

        <!-- Center the buttons at the bottom -->
       
    </div>

    <script>
        var dom = document.getElementById('orderTypeChart');
        var myChart = echarts.init(dom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });
        var app = {};
    
        var option;
    
        option = {
            title: {
            left: 'center'
        },
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b} : {c} ({d}%)'
            },
            legend: {
                
                orient: 'vertical',
                left: 'left',
                left: '25',
                
            },
           
            series: [{
                name: 'Hợp đồng',
                type: 'pie',
                radius: '85%',
                center: ['50%', '45%'],
                // roseType: 'area',
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
                left: 100,
                data: [
                    @foreach ($typesCount as $type => $count)
    
                        {
                            value: {{ $count }},
                            name: '{{ trans('messages.order.type.' . $type) }}'
                        },
                    @endforeach
                ],
                labelLine: {
    
                    smooth: 0.2,
                    length: 20,
                    length2: 20
                },
            }]
        };
    
    
        if (option && typeof option === 'object') {
            myChart.setOption(option);
        }
    
        window.addEventListener('resize', myChart.resize);
    </script> 
   
</div>
