<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="overflow-x:auto;">

        <table id="kt_datatable_complex_header" class="table align-middle border  fs-6 table-striped ">
            <thead>
                <tr class="fw-bold px-7 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap ">
                    <th class="border ps-5">STT</th>
                    <th class="border ps-5">Ngày</th>
                    <th class="border ps-5">SỐ PHIẾU THU</th>
                    <th class="border ps-5">SỐ REQUEST</th>
                    <th class="border ps-5">SỐ HỢP ĐỒNG</th>
                    <th class="border ps-5">Mã học viên</th>
                    <th class="border ps-5">Mã cũ học viên</th>
                    <th class="border ps-5">Tên học viên</th>
                    <th class="border ps-5">Dịch vụ</th>
                    <th class="border ps-5">Số tiền</th>
                    <th class="border ps-5">Thuế</th>
                    <th class="border ps-5">Tổng tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payments as $payment)
                    <tr class="border" list-control="item">
                        <td class="ps-5 ">{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}</td>
                        <td class="ps-5 ">
                            @if ($payment && $payment->payment_date)
                                {{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}
                            @else
                            @endif
                        </td>
                        <td class="ps-5 ">
                            @if ($payment && $payment->orders)
                                {{ $payment->id }}
                            @else
                            @endif
                        </td>
                        <td class="ps-5">{{ $payment->orders->code }}</td>
                        <td class="ps-5 ">
                            @if ($payment && $payment->orders)
                                {{ $payment->orders->code }}
                            @else
                            @endif
                        </td>
                        <td class="ps-5 ">
                            {{ App\Models\PaymentRecord::find($payment->id)->contact->getCode() }}
                        </td>
                        <td class="ps-5 ">
                            {{ App\Models\PaymentRecord::find($payment->id)->contact->import_id }}
                        </td>
                        <td class="ps-5 ">
                            {{ App\Models\PaymentRecord::find($payment->id)->contact->name }}
                        </td>
                        <td class="ps-5 ">
                            @if ($payment && $payment->orders)
                            {{ $payment->orders->industry }}
                        @else
                        @endif
                        </td>
                        <td class="ps-5 ">
                            {!! number_format($payment->amount) !!}đ
                        </td>
                        <td class="ps-5 cell-under-construction">Đang cập nhật</td>
                        <td class="ps-5">
                            {{ number_format($payment->orders->getTotal()) }}
                        </td>
                    </tr>
            @endforeach

            </tbody>
        </table>
    </div>
    <div class="mt-5">
        {{ $payments->links() }}
    </div>
</div>
