@if(isset($orderItem))
    @if ($orderItem->getSubtractedAndNotSubtractedDemoItems()->count() > 0)
        <style>
            .demo-item-row.selected {
                background-color: #f0f0f0;
            }
        </style>

        <label class="fs-6 fw-semibold mb-2" for="hour-demo-input">Các yêu cầu học thử đã đăng ký ({{ $orderItem->getSubtractedAndNotSubtractedDemoItems()->count() }} yêu cầu)</label>
        <div class="table-responsive">
            <table class="table table-row-bordered table-hover table-bordered">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                        <th style="width:1%"></th>
                        <th class="text-nowrap text-white">Môn học</th>
                        <th class="text-nowrap text-white">Phân loại</th>
                        <th class="text-nowrap text-white">Loại hình lớp</th>
                        <th class="text-nowrap text-white">Chủ nhiệm</th>
                        <th class="text-nowrap text-white">Hình thức học</th>
                        <th class="text-nowrap text-white">Chi nhánh đào tạo</th>
                        <th class="text-nowrap text-white">Số giờ học</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orderItem->getSubtractedAndNotSubtractedDemoItems() as $demoItem)
                        <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="left" data-bs-dismiss="click"
                        class="demo-item-row">
                            <td>
                                <div class="form-check form-check-sm form-check-custom justify-content-center">
                                    <input data-item-id="{{ $demoItem->id }}" list-action="check-item" name="subtract_demo[]"
                                        class="form-check-input demo-item-checkbox" type="checkbox" value="{{ $demoItem->id }}" 
                                        {{ \App\Models\OrderItemDemo::where('demo_order_item_id', $demoItem->id)->get()->count() > 0 ? 'checked' : '' }}/>
                                </div>
                            </td>
                            <td>{{ \App\Models\Subject::find($demoItem->subject_id)->name }}</td>
                            <td>{{ $demoItem->order_type }}</td>
                            <td>{{ trans('messages.courses.class_type.' . $demoItem->class_type) }}</td>
                            <td>{{ $demoItem->home_room }}</td>
                            <td>{{ $demoItem->study_type }}</td>
                            <td>{{ $demoItem->branch }}</td>
                            <td>{{ number_format($demoItem->getTotalMinutes()/60, 2) . ' giờ' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            $(document).ready(function() {
                $('.demo-item-row').on('click', function() {
                    var checkbox = $(this).find('.demo-item-checkbox');

                    checkbox.prop('checked', !checkbox.prop('checked'));
                    $(this).toggleClass('selected', checkbox.prop('checked'));
                });
            });
        </script>
    @else
        <div>
            <span class="d-flex align-items-start">
                <span class="material-symbols-rounded me-2" style="vertical-align: middle;">
                    error
                </span>
                <span>Khách hàng/Người ký hợp đồng/Học viên này chưa ký hợp đồng học thử nào hoặc đã trừ hết giờ học demo!</span>
            </span>
        </div>
    @endif
@elseif (!isset($orderItem))
    @if (\App\Models\OrderItem::getDemoItemsByContactId(\App\Models\Order::find($orderId)->contact_id)->count() > 0)
        <style>
            .demo-item-row.selected {
                background-color: #f0f0f0;
            }
        </style>

        <label class="fs-6 fw-semibold mb-2" for="hour-demo-input">Các yêu cầu học thử đã đăng ký ({{ \App\Models\OrderItem::getDemoItemsByContactId(\App\Models\Order::find($orderId)->contact_id)->count() }} yêu cầu)</label>
        <div class="table-responsive">
            <table class="table table-row-bordered table-hover table-bordered">
                <thead>
                    <tr class="fw-semibold fs-6 text-gray-800 border-bottom-2 border-gray-200 bg-info">
                        <th style="width:1%"></th>
                        <th class="text-nowrap text-white">Môn học</th>
                        <th class="text-nowrap text-white">Phân loại</th>
                        <th class="text-nowrap text-white">Loại hình lớp</th>
                        <th class="text-nowrap text-white">Chủ nhiệm</th>
                        <th class="text-nowrap text-white">Hình thức học</th>
                        <th class="text-nowrap text-white">Chi nhánh đào tạo</th>
                        <th class="text-nowrap text-white">Số giờ học</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach(\App\Models\OrderItem::getDemoItemsByContactId(\App\Models\Order::find($orderId)->contact_id) as $demoItem)
                        <tr request-control="row" data-bs-toggle="tooltip" data-bs-trigger="hover"
                        data-bs-placement="left" data-bs-dismiss="click"
                        class="demo-item-row">
                            <td>
                                <div class="form-check form-check-sm form-check-custom justify-content-center">
                                    <input data-item-id="{{ $demoItem->id }}" list-action="check-item" name="subtract_demo[]"
                                        class="form-check-input demo-item-checkbox" type="checkbox" value="{{ $demoItem->id }}" 
                                        {{ \App\Models\OrderItemDemo::where('demo_order_item_id', $demoItem->id)->get()->count() > 0 ? 'checked' : '' }}/>
                                </div>
                            </td>
                            <td>{{ \App\Models\Subject::find($demoItem->subject_id)->name }}</td>
                            <td>{{ $demoItem->order_type }}</td>
                            <td>{{ trans('messages.courses.class_type.' . $demoItem->class_type) }}</td>
                            <td>{{ $demoItem->home_room }}</td>
                            <td>{{ $demoItem->study_type }}</td>
                            <td>{{ $demoItem->branch }}</td>
                            <td>{{ number_format($demoItem->getTotalMinutes()/60, 2) . ' giờ' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script>
            $(document).ready(function() {
                $('.demo-item-row').on('click', function() {
                    var checkbox = $(this).find('.demo-item-checkbox');

                    checkbox.prop('checked', !checkbox.prop('checked'));
                    $(this).toggleClass('selected', checkbox.prop('checked'));
                });
            });
        </script>
    @else
        <div>
            <span class="d-flex align-items-start">
                <span class="material-symbols-rounded me-2" style="vertical-align: middle;">
                    error
                </span>
                <span>Khách hàng/Người ký hợp đồng/Học viên này chưa ký hợp đồng học thử nào hoặc đã trừ hết giờ demo!</span>
            </span>
        </div>
    @endif
@endif