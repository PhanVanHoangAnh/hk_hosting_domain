<ul class="nav nav-tabs nav-line-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button"
            role="tab" aria-controls="home" aria-selected="true">Datatable</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="visualization1-tab" data-bs-toggle="tab" data-bs-target="#visualization1"
            type="button" role="tab" aria-controls="visualization1" aria-selected="false">Visualization 1</button>
    </li>
    <!-- <li class="nav-item" role="presentation">
        <button class="nav-link" id="visualization2-tab" data-bs-toggle="tab" data-bs-target="#visualization2"
            type="button" role="tab" aria-controls="visualization2" aria-selected="false">Visualization 2</button>
    </li> -->

</ul>
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
        <div id="ReportIndexContainer" class="position-relative pt-6" id="kt_post">
            <div class="table-responsive">

                <table class="table table-bordered">
                    <thead class="fw-bold fs-6 text-light align-top">
                        <tr>
                            @if (!empty($xColumns))
                                <th class="bg-info text-white"></th>
                                @foreach ($xColumns as $source)
                                    <th class="bg-info text-white">{{ $source }}</th>
                                @endforeach
                                <th class="bg-info text-white">Tổng cộng</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="fw-bold fs-6 text-light align-top">
                        @foreach ($yColumns as $yColumn)
                            <tr>
                                <td class="bg-info text-white">{{ $yColumn }}</td>
                                @foreach ($xColumns as $xColumn)
                                    <td>{{ $data[$xColumn][$yColumn] }}</td>
                                @endforeach
                                <td class="bg-secondary">{{ $data['tổng Columnx'][$yColumn] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            @if (!empty($yColumns))
                                <td class="bg-info text-white">Tổng cộng</td>
                                @foreach ($xColumns as $xColumn)
                                    <td class="bg-secondary">{{ $data[$xColumn]['tổng Columny'] }}</td>
                                @endforeach
                                <td class="bg-secondary">{{ $data['tổng Columnx']['tổng Columny'] }}</td>
                            @endif
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="d-flex align-items-center justify-content-end py-1 d-none">
            <div data-action="under-construction">
                <a type="button" class="btn btn-outline btn-outline-default btn-menu " data-kt-menu-trigger="click"
                    data-kt-menu-placement="bottom-end">
                    <span class="d-flex align-items-end">
                        <span class="material-symbols-rounded me-2">
                            export_notes
                        </span>
                        <span>Xuất dữ liệu DataTable</span>
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div data-control="chart-pane" class="tab-pane fade active show" id="visualization1" role="tabpanel"
        aria-labelledby="visualization1-tab">
        <div class="mt-5" id="Visualization1" style="width:100%; height:650px;">

        </div>
    </div>
    <div data-control="chart-pane2" class="tab-pane fade active show" id="visualization2" role="tabpanel"
        aria-labelledby="visualization2-tab">
        <div class="mt-5" id="Visualization2" style="width:100%; height:650px;">

        </div>
    </div>


</div>

@section('head')
    <script src="{{ url('/lib/echarts/echarts.js') }}?v=4"></script>
@endsection

<script>
    $(function() {
        Visualization1.init();
        Visualization2.init();

    });


    var Visualization2 = function() {
        var visualization1 = null;
        return {
            init: function() {
                var chartDom2 = document.getElementById('Visualization2')
                // Kiểm tra xem biểu đồ đã được khởi tạo trước đó không
                if (visualization1) {
                    visualization1.dispose(); // Xóa biểu đồ hiện có
                }

                visualization1 = echarts.init(chartDom2); // Khởi tạo biểu đồ mới

                this.updateChart(); // Cập nhật biểu đồ
            },
            updateChart: function() {
                // Dữ liệu từ biến $data đã được chuyển đổi thành biến JavaScript
                var data = {!! json_encode($data) !!};
                var xColumns = {!! json_encode($xColumns) !!};
                var yColumns = {!! json_encode($yColumns) !!};
                var series = [];

                for (var i = 0; i < yColumns.length; i++) {
                    var yColumn = yColumns[i];
                    var randomData = [];

                    for (var j = 0; j < xColumns.length; j++) {
                        var xColumn = xColumns[j];
                        randomData.push(data[xColumn][yColumn]);
                    }

                    series.push({
                        name: yColumn,
                        type: 'bar',
                        stack: 'total', // Đặt tất cả các cột vào cùng một stack
                        label: {
                            show: true
                        },
                        emphasis: {
                            focus: 'series'
                        },
                        data: randomData,
                        // Sử dụng thuộc tính z để xác định thứ tự hiển thị của các cột
                        z: i // i là vị trí của yColumn trong mảng yColumns
                    });
                }

                // Tính toán giá trị "End" dựa trên các series hiện có
                var endData = [];
                for (var j = 0; j < xColumns.length; j++) {
                    var endValue = 0; // Giá trị khởi tạo cho "End"
                    for (var i = 0; i < yColumns.length; i++) {
                        endValue += 100 - data[xColumns[j]][yColumns[i]];
                    }
                    endData.push(endValue);
                }

                // Thêm series mới cho "End" vào mảng series
                series.push({
                    name: 'End',
                    type: 'bar',
                    stack: 'total',
                    label: {
                        show: true
                    },
                    emphasis: {
                        focus: 'series'
                    },
                    data: endData,
                    // Sử dụng thuộc tính z để xác định thứ tự hiển thị của "End"
                    z: yColumns.length // Đặt nó ở cuối danh sách để hiển thị "End" sau các series khác
                });

                var option2 = {
                    tooltip: {
                        trigger: 'axis',
                        axisPointer: {
                            // Use axis to trigger tooltip
                            type: 'shadow' // 'shadow' as default; can also be 'line' or 'shadow'
                        }
                    },
                    legend: {},
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
                        data: xColumns,
                        axisLabel: {
                            interval: 0,
                            rotate: -45,
                        }
                    },
                    series: series
                };
                option2 && visualization1.setOption(option2);
                // hack: fix chart size not calculated when not visible
                $('[data-control="chart-pane2"]').removeClass('show');
                $('[data-control="chart-pane2"]').removeClass('active');
            }

        }
    }();


    var Visualization1 = function() {
        var visualization1 = null; // Biến để lưu trữ thể hiện biểu đồ

        return {
            init: function() {
                var chartDom1 = document.getElementById('Visualization1');

                // Kiểm tra xem biểu đồ đã được khởi tạo trước đó không
                if (visualization1) {
                    visualization1.dispose(); // Xóa biểu đồ hiện có
                }

                visualization1 = echarts.init(chartDom1); // Khởi tạo biểu đồ mới

                this.updateChart(); // Cập nhật biểu đồ
            },
            updateChart: function() {
                // Dữ liệu từ biến $data đã được chuyển đổi thành biến JavaScript
                var data = {!! json_encode($data) !!};

                var xColumns = {!! json_encode($xColumns) !!};
                var yColumns = {!! json_encode($yColumns) !!};

                var series = [];

                for (var i = 0; i < yColumns.length; i++) {
                    var yColumn = yColumns[i];
                    var randomData = [];

                    for (var j = 0; j < xColumns.length; j++) {
                        var xColumn = xColumns[j];
                        randomData.push(data[xColumn][yColumn]);
                    }

                    series.push({
                        name: yColumn,
                        type: 'bar',
                        data: randomData
                    });
                }

                var option = {
                    xAxis: {
                        type: 'category',
                        data: xColumns,
                        axisLabel: {
                            interval: 0,
                            rotate: -45,
                        }
                    },
                    yAxis: {},
                    legend: {
                        data: yColumns,
                    },
                    series: series
                };

                option && visualization1.setOption(option);

                // hack: fix chart size not calculated when not visible
                $('[data-control="chart-pane"]').removeClass('show');
                $('[data-control="chart-pane"]').removeClass('active');
            }
        };
    }();
</script>
