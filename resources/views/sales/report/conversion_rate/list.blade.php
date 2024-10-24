<div class="card-body pt-0 mt-5">
    <div class="table-responsive table-head-sticky " style="overflow-x:auto;">

        <table id="kt_datatable_complex_header" class="table align-middle border fs-6 table-striped">
            <thead>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                    <th class="border px-5" rowspan="4">Mã NV</th>
                    <th class="border px-5" rowspan="4">Tên nhân viên</th>
                    <th class="border px-5" rowspan="4">Sale sup</th>
                </tr>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                    <th colspan="15" class="text-center border">Phân loại nguồn</th>
                    <th rowspan="2" colspan="3" class="text-center border">Tổng cộng</th>
                </tr>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning text-nowrap">
                    <th class="text-center border" colspan="3">Digital</th>
                    <th class="text-center border" colspan="3">Offline</th>
                    <th class="text-center border" colspan="3">Giới thiệu</th>
                    <th class="text-center border" colspan="3">Hotline</th>
                    <th class="text-center border" colspan="3">Khác</th>
                </tr>
                <tr class="fw-bold px-4 text-start text-gray-800 fs-7 text-uppercase gs-0 table-warning ">
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng assign</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng chuyển đổi</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Tỉ lệ</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng assign</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng chuyển đổi</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Tỉ lệ</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng assign</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng chuyển đổi</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Tỉ lệ</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng assign</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng chuyển đổi</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Tỉ lệ</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng assign</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng chuyển đổi</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Tỉ lệ</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng assign</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Số lượng chuyển đổi</th>
                    <th class="border ps-5 min-w-70px w-auto fw-bold ">Tỉ lệ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($accounts as $account)
                <tr class="border">
                    <td class="ps-5 ">{{$account->code}}</td>
                    <td class="ps-5 ">
                         {{$account->name }}
                        </td> 
                    <td class="ps-5">
                        @if ($account->getSaleSub())
                            {{ $account->getSaleSub()->name }}
                        @else
                            --
                        @endif
                    </td>

                    <td class="ps-5">
                        {{ $contactRequestsCount = $account->getContactRequests('Digital', $updated_at_from, $updated_at_to)->count() }}
                    </td>
                    <td class="ps-5">
                        {{ $matchingContactIdsCount = $account->countMatchingContactIdsBySourceType('Digital', $updated_at_from, $updated_at_to) }}
                    </td>
                    <td class="ps-5">
                        @if ($contactRequestsCount > 0)
                            {{ number_format($matchingContactIdsCount / $contactRequestsCount * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                    
                    <td class="ps-5">
                        {{ $offlineContactRequestsCount = $account->getContactRequests('Offline', $updated_at_from, $updated_at_to)->count() }}
                    </td>
                    <td class="ps-5">
                        {{ $matchingOfflineContactIdsCount = $account->countMatchingContactIdsBySourceType('Offline', $updated_at_from, $updated_at_to) }}
                    </td>
                    <td class="ps-5">
                        @if ($offlineContactRequestsCount > 0)
                            {{ number_format($matchingOfflineContactIdsCount / $offlineContactRequestsCount * 100, 2) }}%
                        @else
                            0%s
                        @endif
                    </td>
                    
                    <td class="ps-5">
                        {{ $referralContactRequestsCount = $account->getContactRequests('Referral', $updated_at_from, $updated_at_to)->count() }}
                    </td>
                    <td class="ps-5">
                        {{ $matchingReferralContactIdsCount = $account->countMatchingContactIdsBySourceType('Referral', $updated_at_from, $updated_at_to) }}
                    </td>
                    <td class="ps-5">
                        @if ($referralContactRequestsCount > 0)
                            {{ number_format($matchingReferralContactIdsCount / $referralContactRequestsCount * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>
                    <td class="ps-5">
                        {{ $hotlineContactRequestsCount = $account->getContactRequests('Hotline', $updated_at_from, $updated_at_to)->count() }}
                    </td>
                    <td class="ps-5">
                        {{ $matchingHotlineContactIdsCount = $account->countMatchingContactIdsBySourceType('Hotline', $updated_at_from, $updated_at_to) }}
                    </td>
                    <td class="ps-5">
                        @if ($hotlineContactRequestsCount > 0)
                            {{ number_format($matchingHotlineContactIdsCount / $hotlineContactRequestsCount * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>

                    <td class="ps-5">
                        {{ $otherContactRequestsCount = $account->getContactRequests('Other', $updated_at_from, $updated_at_to)->count() }}
                    </td>
                    <td class="ps-5">
                        {{ $matchingOtherContactIdsCount = $account->countMatchingContactIdsBySourceType('Other', $updated_at_from, $updated_at_to) }}
                    </td>
                    <td class="ps-5">
                        @if ($otherContactRequestsCount > 0)
                            {{ number_format($matchingOtherContactIdsCount / $otherContactRequestsCount * 100, 2) }}%
                        @else
                            0%
                        @endif
                    </td>

                    <td class="ps-5">
                        {{ $totalContactRequestsCount = $account->getContactRequestsTotal($updated_at_from, $updated_at_to)->count() }}
                    </td>
                    <td class="ps-5">
                        {{ $totalMatchingContactIdsCount = $account->sumMatchingContactIdsByTypes($updated_at_from, $updated_at_to) }}
                    
                    </td>
                    <td class="ps-5">
                        @if ($totalContactRequestsCount > 0)
                            {{ number_format($totalMatchingContactIdsCount / $totalContactRequestsCount * 100, 2) }}%
                        @else
                            0%
                        @endif
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
