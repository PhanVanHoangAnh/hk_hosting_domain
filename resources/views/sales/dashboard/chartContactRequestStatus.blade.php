<div class="card card-flush h-lg-100">
    <!--begin::Header-->
    <div class="card-header pt-3">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column ">
            <span class="card-label fw-bold text-gray-900">Tình trạng xử lý đơn hàng</span>
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
            <a list-action='add-request-contact' class="btn btn-info me-3 rounded">Thêm đơn hàng</a>
            <a href="{{ action([App\Http\Controllers\Sales\ContactRequestController::class, 'index']) }}"
                class="btn btn-light rounded">Xem danh sách</a>
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
        // toolbox: {
        //     show: true,
        //     bottom: '0',
        //     right: '10',
        //     feature: {
        //         mark: {
        //             show: true
        //         },
        //         dataView: {
        //             show: true,
        //             readOnly: false
        //         },
        //         restore: {
        //             show: true
        //         },
        //         saveAsImage: {
        //             show: true
        //         }
        //     }
        // },
        series: [{
            name: 'Đơn hàng',
            type: 'pie',
            radius: '60%',
            center: ['50%', '63%'], // Center the chart both horizontally and vertically
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
            data: [
                @foreach ($leadStatusesCount as $status => $count)
                    {
                        value: {{ $count }},
                        name: "{{ trans('messages.contact_request.lead_status.' . $status) }}"
                    }{{ !$loop->last ? ',' : '' }}
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
                    url: "{{ action('\App\Http\Controllers\Sales\ContactRequestController@create') }}",
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
