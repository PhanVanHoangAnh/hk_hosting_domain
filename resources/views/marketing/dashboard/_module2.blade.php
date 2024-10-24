<div class="card card-flush h-lg-100">
    <!--begin::Header-->
    <div class="card-header pt-3">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column ">
            <span class="card-label fw-bold text-gray-900 fs-2">Tình trạng xử lý đơn hàng</span>
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
        <div style="height: 100%; position: relative; margin: 0; ">
            <div id="RequestChart" style="height: 100%; position: absolute; bottom: 0;; width: 100%;"></div>
        </div>
        <!--end::Chart-->

        <!-- Center the buttons at the bottom -->
        <div class="text-center mt-10">
            <a list-action='add-request-contact' class="btn btn-info me-3 rounded">Thêm đơn hàng</a>
            <a href="{{ action([App\Http\Controllers\Marketing\ContactRequestController::class, 'index']) }}"
                class="btn btn-light rounded">Xem danh sách</a>
        </div>
    </div>
</div>

<script>
    var dom = document.getElementById('RequestChart');
    var myChart2 = echarts.init(dom, null, {
        renderer: 'canvas',
        useDirtyRect: false
    });
    var app = {};
    colors = ["#5470c6",
"#91cc75",
"#fac858",
"#ee6666",
"#73c0de",
"#3ba272",
"#fc8452",
"#9a60b4",
"#ea7ccc",
"#5470c6",
"#91cc75",
"#fac858",
"#ee6666",
"#73c0de",
"#3ba272",
"#fc8452",
"#9a60b4",
"#ea7ccc",];

    var option;
    option = {
        grid: {
            left: '3%',
            // right: '14%',
            bottom: '3%',
            top: '3%',
            containLabel: true
        },
        tooltip: {
            trigger: 'axis',
            axisPointer: {
                type: 'shadow'
            }
        },
        xAxis: {
            type: 'value',
            // boundaryGap: [0, 0.01],
            // interval: 0,
        },
        yAxis: {
            type: 'category',
            data: {!! json_encode(array_map(
                function($item, $key) {
                    return  trans('messages.contact_request.lead_status.' . $key) ;
                }, $countLeadStatuses, array_keys($countLeadStatuses)))
            !!},
            interval: 0,
        },
        series: [{
            data: [
                @php $i = 0; @endphp
                @foreach ($countLeadStatuses as $status => $count)
                    {
                        value: {{ $count }},
                        itemStyle: {color: colors[{{ $i }}]},
                        label: {
                            show: true,
                            formatter: function(params) {
                                return params.value.toLocaleString();
                            }
                        }
                    },
                    @php $i += 1; @endphp
                @endforeach
                // {
                //     value: 200,
                //     itemStyle: {color: 'red'},
                // },
                // {
                //     value: 150,
                //     itemStyle: {color: 'green'},
                // }
            ],
            type: 'bar'
        }]
    };

    // option = {
    //     xAxis: {
    //         type: 'category',
    //         data: ['Đơn hàng','Đơn hàng 3']
    //     },
    //     yAxis: {
    //         type: 'value'
    //     },
    //     series: [
    //         @foreach ($countLeadStatuses as $status => $count)

    //                 {
    //                     data: [{{ $count }}],
    //                     type: 'bar'
    //                 },
    //         @endforeach
    //         // {
    //         //     data: [120, 200, 150, 80, 70, 110, 130],
    //         //     type: 'bar'
    //         // },
    //         // {
    //         //     data: [120, 200, 150, 80, 70, 110, 130],
    //         //     type: 'bar'
    //         // }
    //     ]
    // };

    // option = {
    //     tooltip: {
    //         trigger: 'item',
    //         formatter: '{a} <br/>{b} : {c} ({d}%)'
    //     },
    //     legend: {
    //         // bottom: '-8',
    //         left: 'center'
    //     },
    //     // toolbox: {
    //     //     show: true,
    //     //     bottom: '0',
    //     //     right: '10',
    //     //     feature: {
    //     //         mark: {
    //     //             show: true
    //     //         },
    //     //         dataView: {
    //     //             show: true,
    //     //             readOnly: false
    //     //         },
    //     //         restore: {
    //     //             show: true
    //     //         },
    //     //         saveAsImage: {
    //     //             show: true
    //     //         }
    //     //     }
    //     // },
    //     series: [{
    //         name: 'Đơn hàng',
    //         type: 'bar',
    //         radius: '60%',
    //         center: ['50%', '63%'], // Center the chart 
    //         // roseType: 'area',
    //         itemStyle: {
    //             borderRadius: 0
    //         },
    //         emphasis: {
    //             label: {
    //                 show: true,
    //                 fontSize: 15,
    //                 fontWeight: 'bold'
    //             }
    //         },

    //         data: [
    //             @foreach ($countLeadStatuses as $status => $count)

    //                 {
    //                     value: {{ $count }},
    //                     name: '{{ $status }}'
    //                 },
    //             @endforeach
    //         ],
    //         // roseType: 'radius',
    //         labelLine: {

    //             smooth: 0.2,
    //             length: 10,
    //             length2: 10
    //         },
    //     }]
    // };


    if (option && typeof option === 'object') {
        myChart2.setOption(option);
    }

    window.addEventListener('resize', myChart2.resize);
</script>


<script>
    $(function() {

        CreateContactRequestPopup.init();
    });

    var CreateContactRequestPopup = function() {
        var popup;
        var btnCreate;

        // show campaign modal
        var showContactModal = function() {
            popup.load();
        };

        return {
            init: function() {
                // create campaign popup
                popup = new Popup({
                    url: "{{ action('\App\Http\Controllers\Marketing\ContactRequestController@create') }}",
                });

                // create campaign button
                btnCreate = document.querySelector('[list-action="add-request-contact"]');

                // click on create campaign button
                btnCreate.addEventListener('click', (e) => {
                    e.preventDefault();

                    // show create campaign modal
                    showContactModal();
                });
            },

            getPopup: function() {
                return popup;
            }
        };
    }();
</script>
