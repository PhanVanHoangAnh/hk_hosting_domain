<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

        <table id="kt_datatable_complex_header" class="table align-middle border  fs-6 table-striped ">
            <thead>
                <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                    <th class="border ps-5">STT</th>
                    <th class="border ps-5">Ngày</th>
                    <th class="border ps-5">SỐ REQUEST</th>
                    <th class="border ps-5">SỐ HỢP ĐÒNG</th>
                    <th class="border ps-5">Dịch vụ</th>
                    <th class="border ps-5">MÃ HỌC VIÊN</th>
                    <th class="border ps-5">MÃ CŨ HỌC VIÊN</th>
                    <th class="border min-w-250px ps-5">TÊN HỌC VIÊN</th>
                    <th class="border ps-5">TỔNG GIÁ TRỊ HỢP ĐỒNG</th>
                    <th class="border ps-5">TỔNG SỐ TIỀN ĐÃ THANH TOÁN</th>
                    <th class="border ps-5">TỔNG NỢ HỢP ĐỒNG</th>
                    <th class="border ps-5">TỔNG DƯ NỢ</th>
                    <th class="border ps-5">NGÀY KẾT THÚC</th>
                    <th class="border ps-5">NGÀY PHẢI THANH TOÁN ĐỢT GẦN NHẤT</th>
                    <th class="border ps-5">TỔNG NỢ PHẢI THANH TOÁN ĐỢT GẦN NHẤT</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr class="border" list-control="item">
                        <td class="ps-5 ">
                            {{ ($orders->currentPage() - 1) * $orders->perPage() + $loop->iteration }}
                        </td>
                        <td class="ps-5 ">{{ $order->updated_at->format('d/m/Y') }}</td>
                        <td class="ps-5 ">
                            {{ $order->getContactRequestCode() }}
                        </td>
                        <td class="ps-5 ">
                            {{ $order->code }}
                        </td>
                        <td class="ps-5 ">
                            @foreach (App\Models\OrderItem::where('order_id', $order->id)->get() as $orderItem)
                                {{ $orderItem->subject->name ?? ''  }}
                            @endforeach
                        </td>
                        {{-- <td class="ps-5 ">
                            {{ $order->contacts->getCode() }}
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
                        <td class="ps-5 ">
                            {{ $order->contacts->import_id }}
                        </td>
                        <td class="ps-5 ">
                            {{ App\Models\Order::find($order->id)->contacts->name }}
                        </td>
                        {{-- <td class="ps-5 ">{{ $loop->iteration }}</td> --}}
                        
                        
                        
                        <td class="ps-5 ">
                            {{ App\Helpers\Functions::formatNumber($order->cache_total) }}₫
                        </td>
                        <td class="ps-5 ">
                            {{ App\Helpers\Functions::formatNumber($order->sumAmountPaid()) }}₫
                        </td>
                        <td class="ps-5">
                              {{App\Helpers\Functions::formatNumber(max($order->getTotal() - $order->sumAmountPaid(), 0), 0, '.', ',') }}₫
                        </td>
                        <td class="ps-5 ">
                            {{ App\Helpers\Functions::formatNumber($order->getLastRemainAmount()) }}đ
                        </td>
                        <td class="ps-5 ">
                            {{ $order->getLastDueDate() }}
                        </td>
                        <td class="ps-5">
                            {{ $order->getNearestDueDate() }}
                        </td>
                        <td class="ps-5">
                            {{ App\Helpers\Functions::formatNumber($order->getNearestRemainAmount()) }}
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
