<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">

        <table id="kt_datatable_complex_header" class="table align-middle border fs-6 table-striped">
            <thead>
                <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                    <th class="border ps-5 min-w-100px w-auto">Ngày nộp</th>
                    <th class="border ps-5 min-w-100px w-auto">Mã học viên</th>
                    <th class="border ps-5 min-w-100px w-auto">Mã cũ học viên</th>

                    <th class="border ps-5 min-w-100px w-auto">Họ tên học viên</th>
                    <th class="border ps-5 min-w-100px w-auto">Dịch vụ</th>
                    <th class="border ps-5 min-w-100px w-auto">Nội dung doanh thu</th>
                    <th class="border ps-5 min-w-100px w-auto">Số tiền</th>
                    <th class="border ps-5 min-w-100px w-auto">Giảm trừ doanh thu</th>
                    <th class="border ps-5 min-w-100px w-auto">Doanh thu tính KPI</th>
                    <th class="border ps-5 min-w-100px w-auto">Hình thức thanh toán</th>
                    <th class="border ps-5 min-w-100px w-auto">Mã NV</th>
                    <th class="border ps-5 min-w-100px w-auto">Tên nhân viên Sale</th>
                    <th class="border ps-5 min-w-100px w-auto">Sale Sup</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border" list-control="item">
                        @php
                            $latestPaymentRecord = App\Models\PaymentRecord::latestForOrderAndStudent($order->id, $order->student_id);
                        @endphp
                        <td class="ps-5 min-w-100px w-auto ">
                            {{ \Carbon\Carbon::parse($latestPaymentRecord->payment_date)->format('d/m/Y') }}
                        </td>
                        {{-- <td class="ps-5 min-w-100px w-auto ">{{ $order->contacts->code }}</td> --}}
                        <td class="ps-5">
                            <div class="d-flex align-items-center">
                                <div class="d-flex flex-column">
                                    <a title="Click vào đưa tới thông tin chi tiết học viên" data-bs-toggle="tooltip"
                                        href="{{ action(
                                            [App\Http\Controllers\Sales\CustomerController::class, 'show'],
                                            [
                                                'id' => $order->contacts->id,
                                            ],
                                        ) }}"
                                        lass="mb-1 fw-bold text-nowrap">{{ $order->contacts->code }}</a>
                                </div>
                            </div>
                        </td>
                        <td class="ps-5 min-w-100px w-auto ">{{  $order->contacts->import_id }}</td>
                        <td class="ps-5 min-w-100px w-auto ">{{ $order->student->name }}</td>
                        <td class="ps-5 min-w-100px w-auto ">
                            @foreach (App\Models\OrderItem::where('order_id', $order->id)->get() as $orderItem)
                                {{ $orderItem->subject->name ?? ''}}
                            @endforeach
                        </td>
                        <td class="ps-5 min-w-100px w-auto ">
                            {{ $latestPaymentRecord->description }}
                        </td>
                        <td class="ps-5 min-w-100px w-auto ">
                            {{ App\Helpers\Functions::formatNumber($latestPaymentRecord->amount) }}₫
                        </td>
                        <td class="ps-5 min-w-100px w-auto ">Đang cập nhật</td>
                        <td class="ps-5 min-w-100px w-auto ">Đang cập nhật</td>
                        <td class="ps-5 min-w-100px w-auto ">
                            {{ $latestPaymentRecord->method }}
                        </td>
                        <td class="ps-5 min-w-100px w-auto ">
                            {{ $latestPaymentRecord->account->code ?? 'N/A' }}
                        </td>
                        <td class="ps-5 min-w-100px w-auto ">
                            {{ $order->salesperson->name }}
                        </td>
                        <td class="ps-5 min-w-100px w-auto ">
                            {{ $order->getSaleSupName() }}
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
