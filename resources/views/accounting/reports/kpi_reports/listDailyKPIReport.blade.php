<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky" style="max-height:calc(100vh - 420px);">

        <table id="kt_datatable_complex_header" class="table align-middle border fs-6 table-striped ">
            <thead>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                    <th class="border px-5" rowspan="3">Mã NV</th>
                    <th class="border px-5" rowspan="3">Nhân viên</th>
                    <th class="border px-5" rowspan="3">Thời gian bắt đầu</th>
                    <th class="border px-5" rowspan="3">Thời gian kết thúc</th>
                </tr>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                    <th colspan="3" class="text-center border">Doanh số tháng</th>
                    {{-- <th colspan="3" class="text-center border">Lũy kế quý</th> --}}
                    <th colspan="3" class="text-center border">Lũy kế năm</th>
                </tr>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">KPI</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Thực tế</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Tỉ lệ hoàn thành</th>
                    {{-- <th class="border ps-5 min-w-100px w-auto fw-bold ">KPI</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Thực tế</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Tỉ lệ hoàn thành</th> --}}
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">KPI</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Thực tế</th>
                    <th class="border ps-5 min-w-100px w-auto fw-bold ">Tỉ lệ hoàn thành</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                <tr class="border" list-control="item">
                        <td class="px-5 cell">{{ $account->code }}</td>
                        <td class="px-5">
                            {{ $account->name }} 
                        </td>
                        <td class="px-5 {{ is_null($start) ? 'text-center' : '' }}">{{ !is_null($start) ? \Carbon\Carbon::createFromFormat('Y-m-d', $start)->format('d/m/Y') : '--' }}</td>
                        <td class="px-5 {{ is_null($end) ? 'text-center' : '' }}">{{ !is_null($end) ? \Carbon\Carbon::createFromFormat('Y-m-d', $end)->format('d/m/Y') : '--' }}</td>
                        @php
                        
                            // $accountKpiByMonth = App\Models\KpiTarget::getAccountKpiByMonth($account->id, $request->from_date);
                            $accountKpiByMonth = !is_null($start) ? $account->calculateTotalKPI($start, $end) : 0;
                            // $actualRevenueMonth = !is_null($start) ? $account->getAmountOfPaymentRecordsAccumulatedMonth($start) : 0;
                            $actualRevenueMonth = !is_null($start) ? $account->getRevenueForAccountInDateRange($start, $end) : 0;
                            
                            $completionRateMonth = $accountKpiByMonth != 0 ? ($actualRevenueMonth / $accountKpiByMonth) * 100 : 0;

                            $accountKpiLuyKeQuy = App\Models\KpiTarget::getAccountKpiLuyKeQuy($account->id, $request->to_date);
                            $actualRevenueQuater = !is_null($start) ? $account->getAmountOfPaymentRecordsAccumulatedQuater($start) : 0;
                            $completionRateQuy = $accountKpiLuyKeQuy != 0 ? ($actualRevenueQuater / $accountKpiLuyKeQuy) * 100 : 0;

                            $accountKpiLuyKeNam = App\Models\KpiTarget::getAccountKpiLuyKeNam($account->id, $request->to_date);
                            $actualRevenueYear = !is_null($start) ? $account->getAmountOfPaymentRecordsAccumulatedYear($start) : 0;
                            $completionRateNam = $accountKpiLuyKeNam != 0 ? ($actualRevenueYear / $accountKpiLuyKeNam) * 100 : 0;
                        @endphp
                        <td class="px-5 ">
                            {{ number_format($accountKpiByMonth, 0, '.', ',') }}đ
                        </td>
                        <td class="px-5">{{ number_format($actualRevenueMonth, 0, '.', ',') }}đ
                        </td>
                        <td class="px-5 ">{{ number_format($completionRateMonth, 2, ".", ",") }}%</td>
                        {{-- <td class="px-5 ">
                            {{ number_format($accountKpiLuyKeQuy, 0, '.', ',') }}đ
                        </td>
                        <td class="px-5 ">
                            {{ number_format($actualRevenueQuater, 0, '.', ',') }}đ
                        </td>
                        <td class="px-5">
                            {{ number_format($completionRateQuy, 2, ".", ",") }}%
                        </td> --}}
                        <td class="px-5 ">
                            {{ number_format($accountKpiLuyKeNam, 0, '.', ',') }}đ
                        </td>
                        <td class="px-5">
                            {{ number_format($actualRevenueYear, 0, '.', ',') }}đ
                        </td>
                        <td class="px-5 ">
                            {{ number_format($completionRateNam, 2, ".", ",") }}%
                        </td>
                    </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-5">
        {{ $accounts->links() }}
    </div>
</div>
