<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

        <table id="kt_datatable_complex_header" class="table align-middle border  fs-6 table-striped ">
            <thead>
                <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                    <th class="border ps-5 min-w-100px w-auto">STT</th>
                    <th class="border ps-5 min-w-100px w-auto">Mã khách</th>
                    <th class="border ps-5 min-w-100px w-auto">Ngày nộp</th>
                    <th class="border ps-5 min-w-100px w-auto">Họ tên học viên</th>
                    <th class="border ps-5 min-w-100px w-auto">Loại dịch vụ</th>
                    <th class="border ps-5 min-w-100px w-auto">Phân loại</th>
                    <th class="border ps-5 min-w-100px w-auto">Dịch vụ</th>
                    <th class="border ps-5 min-w-100px w-auto">Số tiền</th>
                    <th class="border ps-5 min-w-100px w-auto">Số tiền lũy kế đã thu</th>
                    <th class="border ps-5 min-w-100px w-auto">Tổng giá trị hợp đồng</th>
                    <th class="border ps-5 min-w-300px w-auto">Nội dung doanh thu</th>
                    <th class="border ps-5 min-w-200px w-auto">Ghi chú</th>
                    <th class="border ps-5 min-w-100px w-auto">Mã NV</th>
                    <th class="border ps-5 min-w-100px w-auto">Tên Sale</th>
                    <th class="border ps-5 min-w-100px w-auto">Sale Sup</th>
                    <th class="border ps-5 min-w-100px w-auto">Nguồn</th>
                    <th class="border ps-5 min-w-100px w-auto">Chi nhánh</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border" list-control="item">

                        @php
                            $latestPaymentRecord = App\Models\PaymentRecord::latestForOrderAndStudent($order->id, $order->student_id);
                        @endphp
                        <td class="px-5">
                            {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                        </td>
                        {{-- <td class="px-5">
                            {{ $order->student_id }}
                        </td> --}}
                        <td class="ps-5">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-column">
                                    <a title="Click vào đưa tới thông tin chi tiết học viên" data-bs-toggle="tooltip"
                                        href="{{ action(
                                            [App\Http\Controllers\Edu\StudentController::class, 'show'],
                                            [
                                                'id' => $order->contacts->id,
                                            ],
                                        ) }}"
                                        lass="mb-1 fw-bold text-nowrap">{{ $order->contacts->code }}</a>
                                </div>
                            </div>
                        </td>
                        <td class="px-5">
                            {{ isset($latestPaymentRecord) ? \Carbon\Carbon::parse($latestPaymentRecord->updated_at)->format('d/m/Y') : ""}}
                        </td>

                        <td class="px-5">{{ $order->student->name }}</td>
                        <td class="px-5">{{ $order->type }}</td>
                        <td class="px-5">{{ $order->type }}</td>
                        <td class="px-5">
                            @foreach (App\Models\OrderItem::where('order_id', $order->id)->get() as $orderItem)
                                {{ $orderItem->subject->name ?? '' }}
                            @endforeach
                        </td>
                        <td class="px-5">

                            {{ isset($latestPaymentRecord) ? \App\Helpers\Functions::formatNumber($latestPaymentRecord->amount) . '₫' : '' }}
                        </td>
                        <td class="px-5">

                            {{ App\Helpers\Functions::formatNumber($order->sumAmountPaid()) }}₫
                        </td>
                        <td class="px-5">
                            {{ App\Helpers\Functions::formatNumber($order->getTotal()) }}₫
                        </td>

                        <td class="px-5">
                            @foreach ($orderItem->revenues()->get() as $revenue)
                                <li>{{ $revenue->account->name }}:
                                    {{ App\Helpers\Functions::formatNumber($revenue->amount) }}₫</li>
                            @endforeach
                            {{ isset($latestPaymentRecord) ? $latestPaymentRecord->description : '' }}
                        </td>
                        <td class="px-5">
                            {{ $order->parent_note }}
                        </td>

                        <td class="px-5">
                            {{ $latestPaymentRecord->account->code ?? 'N/A' }}
                        </td>
                        <td>
                            {{ $order->salesperson->name }}
                        </td>
                        <td class="px-5">
                            {{ $order->getSaleSupName() }}
                        </td>
                        <td class="px-5">
                            {{ $order->contactRequest->source_type ?? 'N/A' }}
                        </td>
                        <td class="px-5">
                            {{ App\Models\OrderItem::where('order_id', $order->id)->first()->training_location->branch ?? 'N/A' }}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>
    <div class="mt-5">
        {{ $orders->links() }}
    </div>
</div>
