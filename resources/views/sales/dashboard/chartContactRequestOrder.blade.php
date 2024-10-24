<div id="ContactCustomerContainer" class="card card-flush h-lg-100">
    <!--begin::Header-->
    <div class="card-header pt-3">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column ">
            <span class="card-label fw-bold text-gray-900">Đơn hàng / Hợp đồng</span>
            <span class="text-gray-500 pt-2 fw-semibold fs-6 d-none">Tăng trưởng 40%</span>
        </h3>
        <!--end::Title-->

        <!--begin::Toolbar-->
        <div class="card-toolbar ms-auto">
            <!--begin::Tabs-->
            <ul class="nav " role="tablist">
                <li class="nav-item" role="presentation">
                    <a list-action='change-interval'
                        class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1 active"
                        data-bs-toggle="tab" data-type="week">Tuần </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a list-action='change-interval'
                        class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1"
                        data-bs-toggle="tab" data-type="month">Tháng </a>
                </li>

                <li class="nav-item" role="presentation">
                    <a list-action='change-interval'
                        class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1"
                        data-bs-toggle="tab" data-type="year">Năm</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a 
                        class="nav-link btn btn-sm btn-color-muted btn-active btn-active-light fw-bold px-4 me-1"
                        data-bs-toggle="tab" data-type="custom">Tùy chỉnh</a>
                </li>

                
                <div class="ms-3" item-show="created_at_order-select" data-type="custom" style="z-index:100">
                    <div class="d-flex align-tems-center">
                        <div class="me-2">
                            {{-- <label class="form-label fw-semibold">Từ ngày</label> --}}
                            <div class="form-outline">
                                <div data-control="date-with-clear-button" class="date-with-clear-button d-flex align-items-center">
                                    <input data-control="input" name="custom_date_from" placeholder="=asas" type="date" class="form-control" placeholder=""
                                    style="padding: 5px!important;
                                    height: 33px;width:100px;" />
                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                </div>
                            </div>
                        </div>
                        <div class="me-2">
                            {{-- <label class="form-label fw-semibold">Đến ngày</label> --}}
                            <div class="form-outline">
                                <div data-control="date-with-clear-button" class="date-with-clear-button d-flex align-items-center">
                                    <input data-control="input" name="custom_date_to" placeholder="=asas" type="date" class="form-control" placeholder=""
                                    style="padding: 5px!important;
                                    height: 33px;width:100px;"
                                    />
                                    <span data-control="clear" class="material-symbols-rounded clear-button" style="display:none;">close</span>
                                </div>
                            </div>
                        </div>
                        <!-- Update the data-type attribute in the view -->
                        <div class="d-flex align-tems-center" class="date-with-clear-button d-flex align-items-end ms-3" >
                            <a list-action='change-interval' item-show="created_at_order-select" style="display:none;height:33px;"
                            class=" btn btn-sm btn-outline btn-flex btn-center btn-active-light-default text-nowrap"
                            data-bs-toggle="tab" data-type="custom">Áp dụng</a>
                        </div>
                    </div>
                </div>

                
                
                                
                
            </ul>
            <!--end::Tabs-->
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->
  
    <!--begin::Body-->
    <div class="card-body pt-0 px-0">
        <!--begin::Chart-->
        <div id="ContactCustomerContent" style="height: 230px; width:100% "></div>
        <!--end::Chart-->
    </div>
    <!--end::Body-->

</div>

<script>
    var contactCustomerChart;

    $(document).ready(function() {

        $('[list-action="change-interval"]').click(function () {
        var dataType = $(this).attr('data-type');

        var branch = @json($branch); 
        if (dataType === 'custom') {
            var customDateFrom = $('[name="custom_date_from"]').val();
            var customDateTo = $('[name="custom_date_to"]').val();

            axios.get('/sales/dashboard/custom', {
                params: {
                    custom_date_from: customDateFrom,
                    custom_date_to: customDateTo,
                    account_id: {{ $account ? $account->id : 'null' }},
                    account_group_id: {{ $accountGroup ? $accountGroup->id : 'null' }},
                    branch: branch
                },
            })
            .then(function (response) {
                var newData = response.data;
                createOrUpdateChart(newData);
            })
            .catch(function (error) {
                throw new Error(error);
            });
        } else {
            
            axios.get('/sales/dashboard/' + dataType, {
                params: {
                    account_id: {{ $account ? $account->id : 'null' }},
                    account_group_id: {{ $accountGroup ? $accountGroup->id : 'null' }},
                    // branch: {{ $branch ? $branch : 'null' }},
                    branch: branch
                },
            })
            .then(function (response) {
                var newData = response.data;
                createOrUpdateChart(newData);
            })
            .catch(function (error) {
                throw new Error(error);
            });

        }
    });
        $('[item-show="created_at_order-select"]').hide();

        
        $('.nav-link[data-type="custom"]').click(function () {
            $('[item-show="created_at_order-select"]').toggle();
        });
    });

    function createOrUpdateChart(data) {
        var chart = document.getElementById('ContactCustomerContent');

        if (contactCustomerChart) {
            contactCustomerChart.dispose();
        }

        contactCustomerChart = echarts.init(chart);

        var option = {

            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'cross',
                    label: {
                        backgroundColor: '#6a7985'
                    }
                }
            },
            legend: {
                data: ['Đơn hàng', 'Hợp đồng']
            },
            toolbox: {
                top: '10',
                right: '50',
                feature: {
                    saveAsImage: {}
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: data.xAxisData
            }],
            yAxis: [{
                type: 'value'
            }],
            series: [{
                    name: 'Đơn hàng',
                    type: 'line',
                    // stack: 'Total',
                    areaStyle: {},
                    emphasis: {
                        focus: 'series'
                    },
                    label: {
                        show: true,
                        position: 'top'
                    },
                    data: data.contactRequestCountChart
                },
                {
                    name: 'Hợp đồng',
                    type: 'line',
                    // stack: 'Total',
                    areaStyle: {},
                    emphasis: {
                        focus: 'series'
                    },
                    label: {
                        show: true,
                        position: 'top'
                    },
                    data: data.ordersCountChart
                },
            ]
        };
        contactCustomerChart.setOption(option);
        divElement = contactCustomerChart.getDom().getElementsByTagName('div')[0];
        var canvasElement = contactCustomerChart.getDom().getElementsByTagName('canvas')[0];
        if (canvasElement) {
            canvasElement.style.width = '100%';
            divElement.style.width = '100%';
        }
    }

    createOrUpdateChart({
        xAxisData: @json(array_keys($ordersCountChart)),
        contactRequestCountChart: @json(array_values($contactRequestCountChart)),
        ordersCountChart: @json(array_values($ordersCountChart))
    });
</script>
