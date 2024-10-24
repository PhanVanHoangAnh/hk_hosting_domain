<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">

        <table id="kt_datatable_complex_header" class="table align-middle border fs-6 table-striped">
            <thead>
                <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                    <th class="border ps-5">Số Request</th>
                    <th class="border ps-5">Ngày Request</th>
                    <th class="border ps-5">Tên học viên</th>
                    <th class="border ps-5">Loại dịch vụ</th>
                    <th class="border ps-5">Tình trạng request</th>
                    <th class="border ps-5">Phòng kế toán</th>
                    <th class="border ps-5">Phòng đào tạo</th>
                    <th class="border ps-5">Phòng du học</th>
                    <th class="border ps-5">Nhân viên KD</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orderItems as $orderItem)
                    <tr class="border">
                        <th class="ps-5">{{ $orderItem->orders->code }}</th>
                        <td class="ps-5">{{ $orderItem->orders->updated_at->format('d/m/Y') }}</td>
                        <td class="ps-5">{{ App\Models\Order::find($orderItem->orders->id)->contacts->name }}</td>
                        <td class="ps-5">{{ trans('messages.order_item.' .$orderItem->orders->type) }}</td>
                        <td class="ps-5">
                            <span class="badge bg-light-primary fw-bolder">
                                @php
                                    $bgs = [
                                        App\Models\Order::STATUS_DRAFT => 'secondary',
                                        App\Models\Order::STATUS_PENDING => 'warning',
                                        App\Models\Order::STATUS_APPROVED => 'success',
                                        App\Models\Order::STATUS_REJECTED => 'danger text-white',
                                        App\Models\Order::STATUS_DELETED => 'primary',
                                    ];
                                @endphp
                                @if ($orderItem->orders->isRejected())
                                    <span title="{{ $orderItem->orders->rejected_reason }}"
                                        class="badge bg-{{ $bgs[$orderItem->orders->status] ?? 'info' }}" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        {{ trans('messages.order.status.' . $orderItem->orders->status) }}
                                    </span>
                                @else
                                    <span
                                        class="badge bg-{{ $bgs[$orderItem->orders->status] ?? 'info' }}">{{ trans('messages.order.status.' . $orderItem->orders->status) }}</span>
                                @endif
                            </span>
                        </td>
                        <td class="ps-5">
                            <span class="badge bg-light-primary fw-bolder">
                                @php
                                    $bgs = [
                                        App\Models\Order::STATUS_DRAFT => 'secondary',
                                        App\Models\Order::STATUS_PENDING => 'warning',
                                        App\Models\Order::STATUS_APPROVED => 'success',
                                        App\Models\Order::STATUS_REJECTED => 'danger text-white',
                                        App\Models\Order::STATUS_DELETED => 'primary',
                                    ];
                                @endphp
                                @if ($orderItem->orders->isRejected())
                                    <span title="{{ $orderItem->orders->rejected_reason }}"
                                        class="badge bg-{{ $bgs[$orderItem->orders->status] ?? 'info' }}" data-bs-toggle="tooltip"
                                        data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
                                        {{ trans('messages.order.status.' . $orderItem->orders->status) }} 
                                    </span>
                                @else
                                    <span
                                        class="badge bg-{{ $bgs[$orderItem->orders->status] ?? 'info' }}">{{ trans('messages.order.status.' . $orderItem->orders->status) }}</span>
                                @endif
                            </span>
                        </td>
                        {{-- @php
                            $orderItems = $order->orderItems()->get();

                        @endphp --}}
                        <td>
                            {{-- @foreach ($orderItems as $orderItem) --}}
                            <span class="badge bg-light-primary fw-bolder">
                              
                                @if ($orderItem->order->isEdu())
                                    @php
                                        $bgs = [
                                            App\Models\Order::STATUS_DRAFT => 'secondary',
                                            App\Models\Order::STATUS_PENDING => 'warning',
                                            App\Models\Order::STATUS_APPROVED => 'success',
                                            App\Models\Order::STATUS_REJECTED => 'danger text-white',
                                            App\Models\Order::STATUS_DELETED => 'primary',
                                        ];
                                    @endphp
                                    @if ($orderItem->orders->isApproved())
                                        <span class="badge bg-light-primary fw-bolder">
                                            @php
                                                $status = $orderItem->getStatus();
                                                $classForStatus = $status === 'Đã xếp lớp' ? 'success' : 'warning'; // Kiểm tra và áp dụng class màu đỏ
                                            @endphp
                                            <span class="badge bg-{{ $classForStatus }}" data-bs-toggle="tooltip"
                                                data-bs-trigger="hover" data-bs-dismiss="click"
                                                    data-bs-placement="right">
                                                {{ $orderItem->getStatus() }}
                                            </span>
                                        </span>
                                    @else
                                        <span
                                            class="badge bg-{{ $bgs[$orderItem->orders->status] ?? 'info' }}">{{ trans('messages.order.status.' . $orderItem->orders->status) }}</span>
                                    @endif
                                @endif
                            </span>
                            {{-- @endforeach --}}
                        </td>
                        <td class="ps-5">
                            <span class="badge bg-light-primary fw-bolder"> 
                                @if ($orderItem->order->isAbroad())
                                    @php
                                        $bgs = [
                                            App\Models\Order::STATUS_DRAFT => 'secondary',
                                            App\Models\Order::STATUS_PENDING => 'warning',
                                            App\Models\Order::STATUS_APPROVED => 'success',
                                            App\Models\Order::STATUS_REJECTED => 'danger text-white',
                                            App\Models\Order::STATUS_DELETED => 'primary',
                                        ];
                                        $randomStatus = rand(0, 1) == 0 ? 'Đã tiếp nhận' : 'Từ chối duyệt';
                                        $colors = [
                                            'Đã tiếp nhận' => 'success',
                                            'Từ chối duyệt' => 'danger text-white',
                                        ];
                                    @endphp
                                    @if ($orderItem->orders->isApproved())
                                        <span
                                            class="badge bg-{{ $colors[$randomStatus] ?? 'info' }}">{{ $randomStatus }}</span>
                                    @else
                                        <span
                                            class="badge bg-{{ $bgs[$orderItem->orders->status] ?? 'info' }}">{{ trans('messages.order.status.' . $orderItem->orders->status) }}</span>
                                    @endif
                                @endif
                            </span>
                        </td>
                        <td class="ps-5">{{ $orderItem->orders->salesperson->name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <div class="mt-5">
        {{ $orderItems->links() }}
    </div>
</div>
