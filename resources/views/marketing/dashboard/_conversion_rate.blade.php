<link rel="stylesheet" href="{{ url('chart_circle/circle.css') }}" />




<div class="col" style="height: 260px">
    <div class="card card-flush h-xl-100 " style=";">
        <!--begin::Header-->
        <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start mb-2"
            data-bs-theme="light">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column pt-3">
                <span class="fw-bold fs-5 mb-3">Tỷ lệ chuyển đổi đơn hàng tháng này</span>
    
                
            </h3>
            <div class="card-toolbar pt-10 d-none">
                {{-- <span class="fw-bold fs-5x mb-3 me-3">{{ $contactRequestCount }}</span> --}}
                <span class="">yêu cầu</span>
            </div>
            <!--end::Toolbar-->
        </div>
        <div class="card-body flush mt-3 py-0" style="align-self: center;;;">
        
            <div class="d-flex align-items-top" style="justify-content: space-between;width:100%;">
                <div>
                    <div class="c100 p{{ round($orderRequestRate) }} center bx-1">

                        <span>
                            <span class="fw-semibold" style="color:#3ba272">{{ \App\Helpers\Functions::formatNumber($orderRequestRate, 2) }}%</span>
                            <br>
                            <span class="fs-7">Chuyển đổi</span>
                        </span>
                        <div class="slice">
                            <div class="bar" style="border-color:#3ba272"></div>
                            <div class="fill" style="border-color:#3ba272"></div>
                        </div>
                    </div>
                    <p class="text-center mt-5 fw-semibold mb-0">
                        {{ \App\Helpers\Functions::formatNumber($orderCount) }} /
                        {{ \App\Helpers\Functions::formatNumber($requestCount) }}
                    </p>
                    <p class=" text-center fs-7 mb-0">Hợp đồng / Tổng đơn hàng</p>
                    <p class=" text-center fs-7">{{ Carbon\Carbon::now()->format('m/Y') }}</p>
                </div>
              
            </div>  
        </div>
        <!--end::Body-->
    </div>
</div>
<div class="col" style="height: 260px">
    <div class="card card-flush h-xl-100 " style=";">
        <!--begin::Header-->
        <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start mb-2"
            data-bs-theme="light">
            <!--begin::Title-->
            <h3 class="card-title align-items-start flex-column pt-3">
                <span class="fw-bold fs-5 mb-3">Tỷ lệ chuyển đổi theo liên hệ tháng này</span>
    
                
            </h3> 
            <div class="card-toolbar pt-10 d-none">
                {{-- <span class="fw-bold fs-5x mb-3 me-3">{{ $contactRequestCount }}</span> --}}
                <span class="">yêu cầu</span>
            </div> 
        </div> 
        <div class="card-body flush mt-3 py-0" style="align-self: center;;;">
        
            <div class="d-flex align-items-top" style="justify-content: space-between;width:100%;">
                <div>
                   
                    <div class="c100 p{{ round($customerContactRate) }} center bx-1">

                        <span>
                            <span class="fw-semibold" style="color:#3ba272">
                                {{ \App\Helpers\Functions::formatNumber($customerContactRate, 2) }}%
                            </span>
                            <br>
                            <span class="fs-7">Chuyển đổi</span>
                        </span>
                        <div class="slice">
                            <div class="bar" style="border-color:#3ba272"></div>
                            <div class="fill" style="border-color:#3ba272"></div>
                        </div>
                    </div>
                    <p class="text-center mt-5 fw-semibold mb-0">
                        {{ \App\Helpers\Functions::formatNumber($customerCount) }}
                        /
                        {{ \App\Helpers\Functions::formatNumber($contactCount) }}</p>
                    <p class=" text-center fs-7 mb-0">Khách hàng / Liên hệ</p>
                    <p class=" text-center fs-7">{{ Carbon\Carbon::now()->format('m/Y') }}</p>
                </div>
                
            </div> 
        </div>
        <!--end::Body-->
    </div>
</div>
<div class="col" style="height: 260px">
    <div class="card card-flush h-xl-100 " style=";">
        <!--begin::Header-->
        <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start mb-2"
            data-bs-theme="light">
            <!--begin::Title-->
            <h3 data-action="under-construction" class="card-title align-items-start flex-column pt-3">
                <span class="fw-bold fs-5 mb-3">ROI tháng này</span>
    
                
            </h3>
            <!--end::Title-->
    
            <!--begin::Toolbar-->
            <div class="card-toolbar pt-10 d-none">
                {{-- <span class="fw-bold fs-5x mb-3 me-3">{{ $contactRequestCount }}</span> --}}
                <span class="">yêu cầu</span>
            </div> 
        </div>
        <div class="card-body flush mt-3 py-0" style=";">
        
            <div data-control="under-construction" class="d-flex align-items-top" style="justify-content: space-between;width:100%;">
                <div>
                   
                    {{-- <p class="text-center mt-5 fw-semibold mb-0">{{ $orderCount }} / {{ $contactRequestCount }}</p>
                    <p class=" text-center fs-7">Hợp đồng / Tổng đơn hàng</p> --}}
                    
                </div>
                <div>
                  
                    {{-- <p class="text-center mt-5 fw-semibold mb-0">{{ number_format($account->getRevenueForAccountInCurrentMonth(), 0, '.', ',') . '₫ ' }}<br>
                        /
                        {{ $kpiTargetByMonth == null ? '--'  : number_format($kpiTargetByMonth, 0, '.', ','). '₫ ' }}
                    </p>
                    <p class=" text-center fs-7 d-none">Doanh thu tháng / KPI tháng</p> --}}
                    
                </div> 
            </div> 
        </div>
        <!--end::Body-->
    </div>
</div>
<div class="col" style="height: 260px">
    <div class="card card-flush h-xl-100 " style=";">
        <!--begin::Header-->
        <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start mb-2"
            data-bs-theme="light">
            <!--begin::Title-->
            <h3 data-action="under-construction" class="card-title align-items-start flex-column pt-3">
                <span class="fw-bold fs-5 mb-3">CLV (Customer Lifetime Value) tháng này</span>
    
                
            </h3> 
            <div class="card-toolbar pt-10 d-none">
                {{-- <span class="fw-bold fs-5x mb-3 me-3">{{ $contactRequestCount }}</span> --}}
                <span class="">yêu cầu</span>
            </div> 
        </div> 
    
        <div class="card-body flush mt-3 py-0" style=";">
        
            <div class="d-flex align-items-top" style="justify-content: space-between;width:100%;">
                <div>
                   
                    {{-- <p class="text-center mt-5 fw-semibold mb-0">{{ $orderCount }} / {{ $contactRequestCount }}</p>
                    <p class=" text-center fs-7">Hợp đồng / Tổng đơn hàng</p> --}}
                    
                </div>
                <div>
                  
                    {{-- <p class="text-center mt-5 fw-semibold mb-0">{{ number_format($account->getRevenueForAccountInCurrentMonth(), 0, '.', ',') . '₫ ' }}<br>
                        /
                        {{ $kpiTargetByMonth == null ? '--'  : number_format($kpiTargetByMonth, 0, '.', ','). '₫ ' }}
                    </p>
                    <p class=" text-center fs-7 d-none">Doanh thu tháng / KPI tháng</p> --}}
                    
                </div> 
            </div> 
        </div>
        <!--end::Body-->
    </div>
</div>
<div class="col" style="height: 260px">
    <div class="card card-flush h-xl-100 " style=";">
        <!--begin::Header-->
        <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start mb-2"
            data-bs-theme="light">
            <!--begin::Title-->
            <h3 data-action="under-construction" class="card-title align-items-start flex-column pt-3">
                <span class="fw-bold fs-5 mb-3">CAC (customer acquisition cost) tháng này</span>
    
                
            </h3> 
            <div class="card-toolbar pt-10 d-none">
                {{-- <span class="fw-bold fs-5x mb-3 me-3">{{ $contactRequestCount }}</span> --}}
                <span class="">yêu cầu</span>
            </div>
            
        </div> 
        <div class="card-body flush mt-3 py-0" style=";">
        
            <div class="d-flex align-items-top" style="justify-content: space-between;width:100%;">
                <div>
                   
                    {{-- <p class="text-center mt-5 fw-semibold mb-0">{{ $orderCount }} / {{ $contactRequestCount }}</p>
                    <p class=" text-center fs-7">Hợp đồng / Tổng đơn hàng</p> --}}
                    
                </div>
                <div>
                  
                    {{-- <p class="text-center mt-5 fw-semibold mb-0">{{ number_format($account->getRevenueForAccountInCurrentMonth(), 0, '.', ',') . '₫ ' }}<br>
                        /
                        {{ $kpiTargetByMonth == null ? '--'  : number_format($kpiTargetByMonth, 0, '.', ','). '₫ ' }}
                    </p>
                    <p class=" text-center fs-7 d-none">Doanh thu tháng / KPI tháng</p> --}}
                    
                </div>
                 
            </div> 
        </div>
        <!--end::Body-->
    </div>
</div>