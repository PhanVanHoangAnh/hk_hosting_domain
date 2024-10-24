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
            <div id="requestChart" style="height: 100%; position: absolute; bottom: 5; width: 100%;"></div>
            
        </div>
        <!--end::Chart-->

        <!-- Center the buttons at the bottom -->
       
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
    <!--begin::Body-->
    {{-- @php
        function calculatePercentage($count, $total)
        {
            return $total != 0 ? round(($count / max($total, 1)) * 100) : 0;
        }
    @endphp --}}
    {{-- <div class="card-body flush mt-3 py-0">
        <div class="d-flex align-items-top" style="justify-content: space-between;width:100%;">
            <div>
                <div class="c100  center bx-1 p{{ calculatePercentage($newOrderCount, $orderAllCount) }}">
                    <span class="fw-semibold  text-center justify-content">
                        <p style="color:#3ba272 ;font-size: 30px;">
                            {{ calculatePercentage($newOrderCount, $orderAllCount) }}%</p>
                    </span>
                    <div class="slice">
                        <div class="bar" style="border-color:#3ba272"></div>
                        <div class="fill" style="border-color:#3ba272"></div>
                    </div>
                    
                </div>
                
                <p class="text-center mt-5 fw-semibold mb-0">{{$newOrderCount}} / {{$orderAllCount}}</p>
                <p class=" text-center fs-7">Hợp đồng mới</p>
            </div>
            <div>
                <div class="c100  center bx-2 p{{ calculatePercentage($orderPartPaidCount, $orderAllCount) }}">
                    <span class="fw-semibold  text-center justify-content">
                        <p style="color:#5b7bda ;font-size: 30px;">
                            {{ calculatePercentage($orderPartPaidCount, $orderAllCount) }}%</p>
                    </span>

                    <div class="slice">
                        <div class="bar" style="border-color:#5b7bda"></div>
                        <div class="fill" style="border-color:#5b7bda"></div>
                    </div>
                    
                </div>
                <p class="text-center mt-5 fw-semibold mb-0">{{$orderPartPaidCount}} / {{$orderAllCount}}</p>
                <p class=" text-center fs-7">Thanh toán 1 phần</p>
            </div>
            <div>
                <div class="c100  center bx-3 p{{ calculatePercentage($orderPaidCount, $orderAllCount) }}">
                    <span class="fw-semibold  text-center justify-content">
                        <p style="color:#fc8452 ;font-size: 30px;">
                            {{ calculatePercentage($orderPaidCount, $orderAllCount) }}%
                        </p>
                    </span>
                    <div class="slice">
                        <div class="bar" style="border-color:#fc8452"></div>
                        <div class="fill" style="border-color:#fc8452"></div>
                    </div>
                </div>
                <p class="text-center mt-5 fw-semibold mb-0">{{$orderPaidCount}} / {{$orderAllCount}}</p>
                <p class=" text-center fs-7">Thanh toán đủ</p>
            </div>

        </div>

    </div> --}}
    {{-- <div class="card-body flush mt-3 py-0" >
        <div class="d-flex align-items-top" style="justify-content: space-between;width:100%;">
            <div>
                <div class="c100  center bx-1 p{{ round($newOrderCount / $orderAllCount * 100) }}">
                    <span class="fw-semibold fs-2hx text-start ps-3" style="color:#3ba272">{{ round($newOrderCount / $orderAllCount * 100) }}%</span>
                    <div class="slice"><div class="bar" style="border-color:#3ba272"></div><div class="fill" style="border-color:#3ba272"></div></div>
                </div>
                <p class="text-center mt-5 fw-semibold mb-0">Hợp đồng mới <br>/ Tổng Hợp đồng</p>
            </div>
            <div>
                <div class="c100  center bx-2 p{{ round($orderPartPaidCount / $orderAllCount * 100) }}">
                   <span class="fw-semibold fs-2hx text-start ps-3" style="color:#5b7bda">{{ round($orderPartPaidCount / $orderAllCount * 100) }}%</span>
                    
                    <div class="slice"><div class="bar" style="border-color:#5b7bda"></div><div class="fill" style="border-color:#5b7bda"></div></div>
                </div>
                <p class="text-center mt-5 fw-semibold mb-0">Thanh toán 1 phần <br>/ Tổng Hợp đồng</p>
            </div>
            <div>
                <div class="c100  center bx-3 p{{ round($orderPaidCount / $orderAllCount * 100) }}">
                    <span class="fw-semibold fs-2hx text-start ps-3" style="color:#fc8452">{{ round($orderPaidCount / $orderAllCount * 100) }}%</span>
                    <div class="slice"><div class="bar" style="border-color:#fc8452"></div><div class="fill" style="border-color:#fc8452"></div></div>
                </div>
                <p class="text-center mt-5 fw-semibold mb-0">Thanh toán đủ <br>/ Tổng Hợp đồng</p>
            </div>
            
        </div>
        
    </div> --}}
    <!--end::Body-->
</div>


<script src="{{ url('chart_circle/js/mk_charts.js') }}"></script>
