<div list-action="alertUpdating" class="d-none">
    @include('helpers.alert_updating')
</div>
<ul class="nav nav-tabs nav-line-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
            role="tab" aria-controls="home" aria-selected="true">Dữ liệu báo cáo</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="visualization1-tab" data-bs-toggle="tab" data-bs-target="#visualization1"
            type="button" role="tab" aria-controls="visualization1" aria-selected="false">Biểu đồ 1</button>
    </li>
    @if (isset($report['data_1']) && $report['data_1'] != null)
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="visualization2-tab" data-bs-toggle="tab" data-bs-target="#visualization2"
                type="button" role="tab" aria-controls="visualization2" aria-selected="false">Biểu đồ 2</button>
        </li>
    @endif
</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

        <div class="table-responsive py-5">
            @if (isset($report['data_1']) && $report['data_1'] != null)
                <table class="table table-bordered">
                    <thead>
                        <tr class="fw-bold fs-6 bg-info text-white">
                            <th class="text-white" width="200px"></th>
                            @foreach ($report['xColumns'] as $xColumn)
                                <th class="text-white text-center" colspan="3">{{ $xColumn['text'] }}</th>
                            @endforeach
                            <th class="text-white text-center"colspan="3">Tổng cộng</th>
                        </tr>
                        <tr class="fw-bold fs-6 bg-info text-white">
                            <th class="text-white bg-dark-info" width="200px"></th>
                            @foreach ($report['xColumns'] as $xColumn)
                                <th class="text-white bg-dark-info text-nowrap">Hợp đồng</th>
                                <th class="text-white bg-dark-info text-nowrap">Đơn hàng</th>
                                <th class="text-white bg-dark-info text-nowrap">Tỷ lệ CĐ</th>
                            @endforeach
                            <th class="text-white bg-dark-info text-nowrap">Hợp đồng</th>
                            <th class="text-white bg-dark-info text-nowrap">Đơn hàng</th>
                            <th class="text-white bg-dark-info text-nowrap">Tỷ lệ CĐ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report['yColumns'] as $key => $yColumn)
                            @php
                                $isEvenColumnTotal = $key % 2 === 0; // Kiểm tra xem cột có phải là cột chẵn không (tính từ 0)
                            @endphp
                            <tr class="">
                                <td width="1%" class="text-white bg-info text-nowrap px-5">{{ $yColumn['text'] }}
                                </td>
                                @foreach ($report['xColumns'] as $index => $xColumn)
                                    @php
                                        $isEvenColumn = $index % 2 === 0; // Kiểm tra xem cột có phải là cột chẵn không (tính từ 0)
                                    @endphp

                                    <td class="{{ $isEvenColumn ? 'table-light' : '' }}">
                                        {{ $report['data_2'][$xColumn['value']][$yColumn['value']] }}
                                    </td>
                                    <td class="{{ $isEvenColumn ? 'table-light' : '' }}">
                                        {{ $report['data_1'][$xColumn['value']][$yColumn['value']] }}
                                    </td>
                                    <td class="{{ $isEvenColumn ? 'table-light' : '' }}">
                                        {{ $report['data'][$xColumn['value']][$yColumn['value']] }}
                                    </td>
                                @endforeach
                                <th class="bg-light fw-semibold">{{ $report['yTotal_2'][$yColumn['value']] }}</th>
                                <th class="bg-light fw-semibold">{{ $report['yTotal_1'][$yColumn['value']] }}</th>
                                <th class="bg-light fw-semibold">{{ $report['yTotal'][$yColumn['value']] }}</th>
                            </tr>
                        @endforeach
                        <tr>
                            <th class="text-end text-white bg-info">Tổng cộng</th>
                            @foreach ($report['xTotal_2'] as $key => $value)
                                <th class="bg-light fw-semibold">{{ $report['xTotal_2'][$key] }}</th>

                                <th class="bg-light fw-semibold">{{ $report['xTotal_1'][$key] }}</th>
                                <th class="bg-light fw-semibold">{{ $report['xTotal'][$key] }}</th>
                            @endforeach
                            {{-- @for ($i = 1; $i <= count($report['xTotal']); $i++) --}}
                            {{-- <th class="bg-light fw-semibold">{{ $report['xTotal_2'][$i] }}</th> --}}
                            {{-- <th class="bg-light fw-semibold">{{ $report['xTotal_1'][$i] }}</th>
                                <th class="bg-light fw-semibold">{{ $report['xTotal'][$i] }}</th> --}}
                            {{-- @endfor --}}
                            <th class="bg-light fw-semibold fs-2">{{ $report['total_2'] }}</th>
                            <th class="bg-light fw-semibold fs-2">{{ $report['total_1'] }}</th>
                            <th class="bg-light fw-semibold fs-2">{{ $report['total'] }}</th>
                        </tr>
                    </tbody>
                </table>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr class="fw-bold fs-6 bg-info text-white">
                            <th class="text-white" width="200px"></th>
                            @foreach ($report['xColumns'] as $xColumn)
                                <th class="text-white">{{ $xColumn['text'] }}</th>
                            @endforeach
                            <th class="text-white">Tổng cộng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($report['yColumns'] as $yColumn)
                            <tr>
                                <td>{{ $yColumn['text'] }}</td>
                                @foreach ($report['xColumns'] as $xColumn)
                                    <td>{{ $report['data'][$xColumn['value']][$yColumn['value']] }}</td>
                                @endforeach
                                <th class="bg-light fw-semibold">{{ $report['yTotal'][$yColumn['value']] }}</th>
                            </tr>
                        @endforeach
                        <tr>
                            <th class="text-end">Tổng cộng</th>
                            @foreach ($report['xTotal'] as $value)
                                <th class="bg-light fw-semibold">{{ $value }}</th>
                            @endforeach
                            <th class="bg-light fw-semibold fs-2">{{ $report['total'] }}</th>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>
        <div class="d-flex align-items-center justify-content-end py-1 ">
            <div>
                <a action-button="export-excel" type="button" class="btn btn-outline btn-outline-default btn-menu "
                    data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                    <span class="d-flex align-items-end">
                        <span class="material-symbols-rounded me-2">
                            export_notes
                        </span>
                        <span>Xuất báo cáo</span>
                    </span>
                </a>
            </div>
        </div>
    </div>

    <div data-control="chart-pane" class="tab-pane fade active show" id="visualization1" role="tabpanel">
        <div class="py-5">
            <div id="visualization1Chart" role="tabpanel" style="width:100%; height:650px;"
                aria-labelledby="visualization1-tab">

            </div>
        </div>
    </div>
    @if (isset($report['data_1']) && $report['data_1'] != null)
        <div data-control="chart-pane2" class="tab-pane fade active show" id="visualization2" role="tabpanel">
            <div class="py-5">
                <div id="visualization2Chart" role="tabpanel" style="width:100%; height:650px;"
                    aria-labelledby="visualization2-tab">

                </div>
            </div>
        </div>
    @endif

</div>
</div>
<script>
    $(function() {
        Visualization1.init();
        if (@json(isset($report['data_1']) && $report['data_1'] !== [])) {
            Visualization2.init();
        }

        var exportReport = new ExportReport({
            container: document.getElementById('myTabContent'),

            url: "{{ action('\App\Http\Controllers\Marketing\ReportController@downloadExcelReport') }}",
        });
    })

    var ExportReport = class {
        constructor(options) {
            this.container = options.container;
            this.report;
            this.url = options.url;
            this.event();
        }

        getButtonExport() {
            return this.container.querySelector('[action-button="export-excel"]');
        }

        event() {
            this.getButtonExport().addEventListener('click', (e) => {
                e.preventDefault();
                @php
                    $report = $report;
                @endphp
                this.report = {!! json_encode($report) !!};

                $.ajax({
                    data: {
                        _token: '{{ csrf_token() }}',
                        report: this.report,
                    },
                    type: 'POST',
                    url: this.url,
                    success: function(response) {
                        // Download the file
                        window.location =
                            "{{ action('\App\Http\Controllers\Marketing\ReportController@exportDownload') }}?file=" +
                            response.file;
                    },
                })
            })
        }
    };
    var AlertUpdating = function() {
        var getAlertUpdating = document.querySelector('[list-action="alertUpdating"]');

        return {
            init: function() {
                if (report.getDataType() == 'new_customer')
                    getAlertUpdating.classList.remove('d-none');
            }
        }
    }();
    var Visualization1 = function() {
        var visualization1 = null; // Biến để lưu trữ thể hiện biểu đồ
        var customColumnNames = ['column1', 'column2', 'column3']; // Mảng tên cột mới

        return {
            init: function() {
                var chartDom1 = document.getElementById('visualization1Chart');

                // Kiểm tra xem biểu đồ đã được khởi tạo trước đó không
                if (visualization1) {
                    visualization1.dispose(); // Xóa biểu đồ hiện có
                }

                visualization1 = echarts.init(chartDom1); // Khởi tạo biểu đồ mới

                this.updateChart(customColumnNames); // Cập nhật biểu đồ với mảng tên cột mới
            },
            updateChart: function() {

                @php
                    $series = [];
                    foreach ($report['yColumns'] as $yColumn) {
                        $numbers = [];
                        foreach ($report['xColumns'] as $xColumn) {
                            $value = $report['data'][$xColumn['value']][$yColumn['value']];
                            $numbers[] = is_numeric($value) ? $value : (float) str_replace('%', '', $value);
                        }

                        $yColumnName = $yColumn['text'];
                        $series[] = [
                            'data' => $numbers,
                            'type' => 'bar',
                            'name' => $yColumnName,
                        ];
                    }
                @endphp

                option = {
                    legend: {},
                    tooltip: {
                        formatter: function(params) {
                            let tooltipString = params.seriesName + ': ';
                            // Kiểm tra nếu giá trị là số hoặc chuỗi có ký tự "%"
                            if (!isNaN(params.value) || (typeof params.value === 'string' && params
                                    .value.includes('%'))) {
                                // Nếu giá trị là chuỗi có ký tự "%", chuyển đổi thành số thực và thêm đơn vị "%"
                                tooltipString += typeof params.value === 'string' ? parseFloat(params
                                    .value) + '%' : params.value + '%';
                            } else {
                                tooltipString += params
                                    .value; // Giữ nguyên giá trị nếu không phải là số hoặc chuỗi có ký tự "%"
                            }
                            return tooltipString;
                        }
                    },
                    xAxis: {
                        type: 'category',
                        data: {!! json_encode(
                            array_map(function ($column) {
                                return $column['text'];
                            }, $report['xColumns']),
                        ) !!},
                        axisLabel: {
                            interval: 0,
                            rotate: -45,
                        }
                    },
                    yAxis: {
                        type: 'value',
                        axisLabel: {
                            formatter: function(value) {
                                // Kiểm tra nếu giá trị là số, hoặc chuỗi có ký tự "%"
                                if (!isNaN(value) || (typeof value === 'string' && value.includes(
                                        '%'))) {
                                    // Nếu giá trị là chuỗi có ký tự "%", chuyển đổi thành số thực và thêm đơn vị "%"
                                    return typeof value === 'string' ? parseFloat(value) + '%' : value +
                                        '%';
                                } else {
                                    return value; // Giữ nguyên giá trị nếu không phải là số hoặc chuỗi có ký tự "%"
                                }
                            }
                        }
                    },
                    series: {!! json_encode($series) !!}
                };

                option && visualization1.setOption(option);

                // hack: fix chart size not calculated when not visible
                $('[data-control="chart-pane"]').removeClass('show');
                $('[data-control="chart-pane"]').removeClass('active');
            }
        };
    }();
    
    var Visualization2 = function() {
        var visualization2 = null; // Biến để lưu trữ thể hiện biểu đồ
        var customColumnNames = ['column1', 'column2', 'column3']; // Mảng tên cột mới

        return {
            init: function() {
                var chartDom2 = document.getElementById('visualization2Chart');

                // Kiểm tra xem biểu đồ đã được khởi tạo trước đó không
                if (visualization2) {
                    visualization2.dispose(); // Xóa biểu đồ hiện có
                }

                visualization2 = echarts.init(chartDom2); // Khởi tạo biểu đồ mới

                this.updateChart(customColumnNames); // Cập nhật biểu đồ với mảng tên cột mới
            },
            updateChart: function() {
                @if (isset($report['data_1']) && $report['data_1'] != null)

                    @php
                        $series = [];
                        $names = ['Hợp đồng', 'Chưa khai thác'];
                        foreach ($names as $name) {
                            $numbers1 = [];
                            $numbers2 = [];

                            foreach ($report['yColumns'] as $yColumn) {
                                $number1 = $report['yTotal_1'][$yColumn['value']];
                                $number2 = $report['yTotal_2'][$yColumn['value']];

                                $numbers1[] = $number2;
                                $numbers2[] = $number1 - $number2;
                            }

                            $xColumnName = $xColumn['text'];

                            $series[] = [
                                'data' => $name === 'Chưa khai thác' ? $numbers2 : $numbers1,
                                'type' => 'bar',
                                'stack' => 'total',
                                'label' => ['show' => true],
                                'name' => $name,
                                'emphasis' => ['focus' => 'series'],
                            ];
                        }
                    @endphp
                    option = {
                        legend: {},
                        tooltip: {
                            trigger: 'axis',
                            axisPointer: {
                                // Use axis to trigger tooltip
                                type: 'shadow' // 'shadow' as default; can also be 'line' or 'shadow'
                            }
                        },
                        grid: {
                            left: '3%',
                            right: '4%',
                            bottom: '3%',
                            containLabel: true
                        },
                        xAxis: {
                            type: 'value'
                        },
                        yAxis: {
                            type: 'category',
                            data: {!! json_encode(
                                array_map(function ($column) {
                                    return $column['text'];
                                }, $report['yColumns']),
                            ) !!},

                        },

                        series: {!! json_encode($series) !!}
                    };

                    option && visualization2.setOption(option);

                    // hack: fix chart size not calculated when not visible
                    $('[data-control="chart-pane2"]').removeClass('show');
                    $('[data-control="chart-pane2"]').removeClass('active');
                @endif
            }
        };
    }();
</script>
