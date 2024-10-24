<link rel="stylesheet" href="{{ url('chart_circle/circle.css') }}" />


<div class="card card-flush h-xl-100 " style="overflow: scroll;">
    <!--begin::Header-->
    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start mb-2"
        data-bs-theme="light">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column pt-3">
            <span class="fw-bold fs-2 mb-3">KPI (triệu đồng)</span>

            <div class="fs-6">
                @if ($account) 
                    <span class="">Tỉ lệ hoàn thành chỉ tiêu của {{ $account->name }}</span>
                @elseif ($accountGroup) 
                    <span class="">Tỉ lệ hoàn thành chỉ tiêu của team {{ $accountGroup->name }}</span>
                @else
                    <span class="">Tỉ lệ hoàn thành chỉ tiêu tại ASMS</span>
                @endif

            </div>
        </h3>
        <!--end::Title-->

        <!--begin::Toolbar-->
        <div class="card-toolbar pt-10 d-none">
            <span class="fw-bold fs-2x mb-3 me-3">{{ $contactRequestCount }}</span>
            <span class="">yêu cầu</span>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
   


    <div class="card-body flush mt-3 py-0" style="overflow: scroll;">
    @if(isset($accountGroup))
    
        @foreach ($accountGroup->members as $member)
           <div class="d-flex pt-7" style="justify-content: space-between;width:100%;align-items: center;">
                <div style="">
                    <p class=" text-center fw-semibold fs-7">{{$member->name}}</p> 
                </div>
                <div>
                    <div class="c100 p{{ min(\App\Helpers\Functions::calculatePercentage($member->saleOrders()->count(), $member->contactRequests()->count()), 100) }} center bx-1"> 
                        <span>
                            <span class="fw-semibold" style="color:#3ba272">{{\App\Helpers\Functions::calculatePercentage($member->saleOrders()->count(), $member->contactRequests()->count())}}%</span>
                            <br>
                            <span class="fs-7">Chuyển đổi</span>
                        </span>
                        <div class="slice">
                            <div class="bar" style="border-color:#3ba272"></div>
                            <div class="fill" style="border-color:#3ba272"></div>
                        </div>
                    </div>
                    
                    <p class=" text-center fs-7">Hợp đồng / Tổng đơn hàng</p>
                    
                </div>
                <div>
                    <div class="c100 p{{ min(($member->kpiTarget()->month()->latest()->value('amount') !== null ? \App\Helpers\Functions::calculatePercentage($member->getRevenueForAccountInCurrentMonth(), $member->kpiTarget()->month()->latest()->value('amount')) : 0), 100) }} center bx-2">
                        <span>
                            <span class="fw-semibold" style="color:#5b7bda">
                                {{ $member->kpiTarget()->month()->latest()->value('amount') == null ? '--'  : \App\Helpers\Functions::calculatePercentage($member->getRevenueForAccountInCurrentMonth(), $member->kpiTarget()->month()->latest()->value('amount')) . '%'}} </span>
                            <br>
                            <span class="fs-7">KPI Tháng</span>
                        </span>
                        
                        <div class="slice"><div class="bar" style="border-color:#5b7bda"></div><div class="fill" style="border-color:#5b7bda"></div></div>
                    </div>
                    <p class="text-center mt-5 fw-semibold mb-0">{{ number_format($member->getRevenueForAccountInCurrentMonth(), 0, '.', ',') . '₫ ' }}<br>
                        /
                        {{ $member->kpiTarget()->month()->latest()->value('amount') == null ? '--'  : number_format($member->kpiTarget()->month()->latest()->value('amount'), 0, '.', ','). '₫ ' }}
                    </p>
                    <p class=" text-center fs-7 d-none">Doanh thu tháng / KPI tháng</p>
                    
                </div>
               
               
            </div>
            
        @endforeach
    @else
        <div class="d-flex align-items-top" style="justify-content: space-between;width:100%;">
            <div>
                <div class="c100 p{{ min(\App\Helpers\Functions::calculatePercentage($orderCount, $contactRequestCount), 100) }} center bx-1"> 
                    <span>
                        <span class="fw-semibold" style="color:#3ba272">{{\App\Helpers\Functions::calculatePercentage($orderCount, $contactRequestCount)}}%</span>
                        <br>
                        <span class="fs-7">Chuyển đổi</span>
                    </span>
                    <div class="slice">
                        <div class="bar" style="border-color:#3ba272"></div>
                        <div class="fill" style="border-color:#3ba272"></div>
                    </div>
                </div>
                <p class="text-center mt-5 fw-semibold mb-0">{{ $orderCount }} / {{ $contactRequestCount }}</p>
                <p class=" text-center fs-7">Hợp đồng / Tổng đơn hàng</p>
                
            </div>
            <div>
                <div class="c100 p{{ min(($kpiTargetByMonth !== null ? \App\Helpers\Functions::calculatePercentage($account->getRevenueForAccountInCurrentMonth(), $kpiTargetByMonth) : 0), 100) }} center bx-2">

                    <span>
                        <span class="fw-semibold" style="color:#5b7bda">
                            {{ $kpiTargetByMonth == null ? '--'  : \App\Helpers\Functions::calculatePercentage($account->getRevenueForAccountInCurrentMonth(), $kpiTargetByMonth) . '%'}} </span>
                        <br>
                        <span class="fs-7">KPI Tháng</span>
                    </span>
                    
                    <div class="slice"><div class="bar" style="border-color:#5b7bda"></div><div class="fill" style="border-color:#5b7bda"></div></div>
                </div>
                <p class="text-center mt-5 fw-semibold mb-0">{{ number_format($account->getRevenueForAccountInCurrentMonth(), 0, '.', ',') . '₫ ' }}<br>
                    /
                    {{ $kpiTargetByMonth == null ? '--'  : number_format($kpiTargetByMonth, 0, '.', ','). '₫ ' }}
                </p>
                <p class=" text-center fs-7 d-none">Doanh thu tháng / KPI tháng</p>
                
            </div>
           
           
        </div>
    @endif
        
    </div>
    <!--end::Body-->
</div>


<script src="{{ url('chart_circle/js/mk_charts.js') }}"></script>