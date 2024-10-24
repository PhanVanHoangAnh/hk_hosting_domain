<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">

        <table id="kt_datatable_complex_header" class="table align-middle border fs-6 table-striped">
            <thead>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                    <th class="border px-5" rowspan="3">Mã học viên</th>
                    <th class="border px-5" rowspan="3">Mã cũ học viên</th>
                    <th class="border px-5" rowspan="3">Tên học viên</th>
                    <th class="border px-5" rowspan="3">Số hợp đồng</th>
                    <th class="border px-5" rowspan="3">Loại dịch vụ</th>
                    <th class="border px-5" rowspan="3">Tên nhân viên Sale</th>
                    <th class="border px-5" rowspan="3">Sale Sup</th>
                    <th class="border px-5" rowspan="3">Giá trị hợp đồng</th>
                    <th class="border px-5" rowspan="3">Số tiền đã thanh toán</th>
                    <th class="border px-5" rowspan="3">Số tiền còn phải thu</th>
                </tr>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                    <th colspan="2" class="text-center border">Lần thanh toán 1</th>
                    <th colspan="2" class="text-center border">Lần thanh toán 2</th>
                    <th colspan="2" class="text-center border">Lần thanh toán 3</th>
                    <th colspan="2" class="text-center border">Lần thanh toán 4</th>
                    <th colspan="2" class="text-center border">Lần thanh toán 5</th>
                </tr>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Số tiền</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Thời gian</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Số tiền</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Thời gian</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Số tiền</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Thời gian</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Số tiền</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Thời gian</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Số tiền</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Thời gian</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr class="border">
                    {{-- <td class="ps-5">{{$order->contacts->code ?? 'N/A'}}</td> --}}
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
                                    lass="mb-1 fw-bold text-nowrap">{{$order->contacts->code ?? 'N/A'}}</a>
                            </div>
                        </div>
                    </td>
                    <td class="ps-5">{{$order->contacts->import_id ?? 'N/A'}}</td>
                    <td class="ps-5">{{ App\Models\Order::find($order->id)->contacts->name }}</td>
                    <td class="ps-5 ">{{$order->code}}</td>
                    <td class="ps-5 ">{{ $order->type }}</td>
                    <td class="ps-5 ">
                        {{ App\Models\Account::find($order->sale) ? App\Models\Account::find($order->sale)->name : '' }}
                    </td>
                    <td class="ps-5 ">
                        {{ App\Models\Account::find($order->sale_sup) ? App\Models\Account::find($order->sale_sup)->name : '' }}
                    </td>
                    <td class="ps-5">{{ App\Helpers\Functions::formatNumber($order->getTotal()) }}₫</td>
                    <td class="ps-5 ">{{ number_format($order->sumAmountPaid(), 0, '.', ',') }}₫</td>
                    <td class="ps-5">{{ number_format(max($order->getTotal() - $order->sumAmountPaid(), 0), 0, '.', ',') }}₫</td>
                    
                    <td class="ps-5">
                        @php
                        $amount = App\Models\PaymentReminder::where('order_id', $order->id)
                            ->where(function ($query) {
                                $query->whereNull('progress')
                                    ->orWhere('progress', 0)
                                    ->orWhere('progress', 1)
                                    ->orWhere('progress', '');
                            })
                            ->pluck('amount')
                            ->first();

                        echo is_null($amount) || $amount == 0 ? 'N/A' : number_format($amount, 0, '.', ',');
                    @endphp

                    </td>
                    
                    
                    <td class="ps-5">
                        @php
                        $dueDate = App\Models\PaymentReminder::where('order_id', $order->id)
                            ->where(function ($query) {
                                $query->whereNull('progress')
                                    ->orWhere('progress', 0)
                                    ->orWhere('progress', 1)
                                    ->orWhere('progress', '');
                            })
                            ->orderBy('due_date', 'asc')
                            ->value('due_date');
                    
                        $formattedDueDate = $dueDate ? date('d/m/Y', strtotime($dueDate)) : 'N/A';
                        echo $formattedDueDate;
                    @endphp
                    
                    </td>
                    
                    
                    <td class="ps-5">
                        @php
                            $amount = App\Models\PaymentReminder::where('order_id', $order->id)
                                ->where('progress',  2)
                                ->value('amount');
                    
                            echo $amount == 0 ? 'N/A' : number_format($amount, 0, '.', ',');
                        @endphp
                    </td>
                    
                    
                    <td class="ps-5">
                        @php
                            $dueDate = App\Models\PaymentReminder::where('order_id', $order->id)
                                ->where('progress',  2)
                                ->orderBy('due_date', 'asc')
                                ->value('due_date');
                    
                            $formattedDueDate = $dueDate ? date('d/m/Y', strtotime($dueDate)) : 'N/A';
                            echo $formattedDueDate;
                        @endphp
                    </td>
                    <td class="ps-5">
                        @php
                            $amount = App\Models\PaymentReminder::where('order_id', $order->id)
                                ->where('progress',  3)
                                ->value('amount');
                    
                            echo $amount == 0 ? 'N/A' : number_format($amount, 0, '.', ',');
                        @endphp
                    </td>
                    
                    
                    <td class="ps-5">
                        @php
                            $dueDate = App\Models\PaymentReminder::where('order_id', $order->id)
                                ->where('progress',  3)
                                ->orderBy('due_date', 'asc')
                                ->value('due_date');
                    
                            $formattedDueDate = $dueDate ? date('d/m/Y', strtotime($dueDate)) : 'N/A';
                            echo $formattedDueDate;
                        @endphp
                    </td>
                    <td class="ps-5">
                        @php
                            $amount = App\Models\PaymentReminder::where('order_id', $order->id)
                                ->where('progress',  4)
                                ->value('amount');
                    
                            echo $amount == 0 ? 'N/A' : number_format($amount, 0, '.', ',');
                        @endphp
                    </td>
                    
                    
                    <td class="ps-5">
                        @php
                            $dueDate = App\Models\PaymentReminder::where('order_id', $order->id)
                                ->where('progress',  4)
                                ->orderBy('due_date', 'asc')
                                ->value('due_date');
                    
                            $formattedDueDate = $dueDate ? date('d/m/Y', strtotime($dueDate)) : 'N/A';
                            echo $formattedDueDate;
                        @endphp
                    </td>
                    <td class="ps-5">
                        @php
                            $amount = App\Models\PaymentReminder::where('order_id', $order->id)
                                ->where('progress',  5)
                                ->value('amount');
                    
                            echo $amount == 0 ? 'N/A' : number_format($amount, 0, '.', ',');
                        @endphp
                    </td>
                    
                    
                    <td class="ps-5">
                        @php
                            $dueDate = App\Models\PaymentReminder::where('order_id', $order->id)
                                ->where('progress',  5)
                                ->orderBy('due_date', 'asc')
                                ->value('due_date');
                    
                            $formattedDueDate = $dueDate ? date('d/m/Y', strtotime($dueDate)) : 'N/A';
                            echo $formattedDueDate;
                        @endphp
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
