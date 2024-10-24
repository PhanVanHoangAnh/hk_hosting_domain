@extends('layouts.main.app', [
    'menu' => 'sales-dashboard',
])

@section('sidebar')
    @include('sales.modules.sidebar', [
        'menu' => 'dashboard',
        'sidebar' => 'dashboard',
    ])
@endsection

@section('head')
    <script src="{{ url('/lib/echarts/echarts.js') }}?v=4"></script>
@endsection

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="toolbar d-flex flex-stack flex-wrap mb-3 mb-lg-3 ps-4 w-100" id="kt_toolbar">
        <!--begin::Page title-->
        <div class="page-title w-100">
            <div class="d-flex align-items-center w-100">
                <div>
                    @if (Auth::user()->can('changeBranch', \App\Library\Branch::class)) 
                    <h1 class="d-flex align-items-center my-0">
                        <span class="text-dark fw-bold fs-2">Dashboard của Quản lý phòng sale</span>
                    </h1>
                    @elseif (Auth::user()->can('manager', \App\Models\User::class))  
                    <h1 class="d-flex align-items-center my-0">
                        <span class="text-dark fw-bold fs-2">Dashboard của trưởng nhóm sale</span>
                    </h1>
                    @elseif (Auth::user()->can('mentor', \App\Models\User::class))  
                    <h1 class="d-flex align-items-center my-0">
                        <span class="text-dark fw-bold fs-2">Dashboard của mentor sale</span>
                    </h1>
                    @else
                    <h1 class="d-flex align-items-center my-0">
                        <span class="text-dark fw-bold fs-2">Dashboard của nhân viên sale</span>
                    </h1>
                    @endif
                    <!--end::Title-->
                </div>
                
                <div class="ms-auto d-none">
                    <div class="col-md-12 mb-5">
                        <label class="form-label">Ngày tạo (Từ - Đến)</label>
                        <div class="row" list-action="created_at-select">
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="created_at_from" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-outline">
                                    <div data-control="date-with-clear-button"
                                        class="d-flex align-items-center date-with-clear-button">
                                        <input data-control="input" name="created_at_to" placeholder="=asas"
                                            type="date" class="form-control" placeholder="" />
                                        <span data-control="clear" class="material-symbols-rounded clear-button"
                                            style="display:none;">close</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                @if (Auth::user()->can('changeBranch', \App\Library\Branch::class) || Auth::user()->can('mentor', \App\Models\User::class) || Auth::user()->can('manager', \App\Models\User::class)) 
                    <div class="ms-auto">
                        <div>
                            <!--begin::Toggle-->
                            <button type="button" class="btn btn-light btn-sm rotate" data-kt-menu-trigger="click" data-kt-menu-placement="left-start" data-kt-menu-offset="0,5">
                                
                                {{-- @if (isset($account))
                                    <span class="material-symbols-rounded me-2">
                                        group
                                    </span> Bộ lọc sales/team
                                @else
                                    <span class="material-symbols-rounded me-2">
                                        person
                                    </span> 
                                @endif --}}
                                @if (isset($accountGroup))
                                    <span class="material-symbols-rounded me-2">
                                        group
                                    </span> {{ $accountGroup->name }}
                                @else
                                    <span class="material-symbols-rounded me-2">
                                        person
                                    </span> {{ $account->name }}
                                @endif
        
                                <i class="ki-duotone ki-l fs-3 rotate-180 ms-3 me-0"></i>
                            </button>
                            <!--end::Toggle-->
        
                            <!--begin::Menu-->
                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-400 mw-500px " data-kt-menu="true" style="">
                                <!--begin::Menu item-->
                               
                                <!--end::Menu item-->

                                <!--begin::Menu separator-->
                                <div class="separator opacity-75"></div>
                                <!--end::Menu separator-->

                                <div class="menu-item px-3">
                                    
                                    @if (Auth::user()->can('changeBranch', \App\Library\Branch::class))
                                        <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], ['branch' => \App\Library\Branch::getCurrentBranch()]) }}" 
                                            class="btn btn-sm rotate border-0 menu-item px-3 w-100 " 
                                            data-kt-menu-trigger="hover" 
                                            data-kt-menu-placement="left-start" 
                                            data-kt-menu-offset="0,5">
                                            Chi nhánh {{trans('messages.branch.'.\App\Library\Branch::getCurrentBranch())}}
                                            <i class="ki-duotone ki-l fs-3 rotate-180 ms-3 me-0"></i>
                                        </a>
                                    @endif
                                </div>
                                
                                @if (Auth::user()->can('changeBranch', \App\Library\Branch::class))
                                <div class="menu-item px-3">
                                    <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], [
                                    'account_id' => Auth::user()->account->id,
                                ]) }}" class="menu-link px-3 {{ isset($account) && $account->id == Auth::user()->account->id ? 'active' : '' }}">
                                    {{ Auth::user()->account->name }}
                                </a>
                                </div>
                                    @foreach(App\Models\AccountGroup::salesGroup(\App\Library\Branch::getCurrentBranch())->get() as $group)
                                    <!--begin::Menu item--> 
                                        <div class="menu-item px-3" > 
                                            <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], ['account_group_id' => $group->id]) }}" 
                                                class="btn btn-sm rotate border-0 menu-item px-3 w-100 {{ isset($account) && $account->account_group_id == $group->id  || isset($accountGroup) && $accountGroup->id == $group->id? 'bg-primary' : '' }}" 
                                                data-kt-menu-trigger="hover" 
                                                data-kt-menu-placement="left-start" 
                                                data-kt-menu-offset="0,5">
                                                <span class="material-symbols-rounded me-2">person</span>
                                                {{ $group->name }}
                                                <i class="ki-duotone ki-l fs-3 rotate-180 ms-3 me-0"></i>
                                            </a>
                                            
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200px mw-300px" data-kt-menu="true" style="">
                                                @foreach ($group->members as $member)
                                                
                                                <div class="text-left btn btn-sm rotate border-0 menu-item px-3 {{ isset($account) && $account->id == $member->id ? 'bg-primary' : '' }}">
                                                    <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], [
                                                        'account_id' => $member->id,
                                                    ]) }}" class="menu-item px-3 ">
                                                        {{ $member->name}}  
                                                    </a>
                                                </div>
                                                @endforeach

                                            </div> 
                                            
                                        </div> 
                                    @endforeach
                                @elseif (Auth::user()->can('manager', \App\Models\User::class))  
                                {{-- <div class="menu-item px-3">
                                    <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], [
                                        'account_id' => 'all',
                                    ]) }}" class="menu-link px-3 {{ request()->account_id == 'all' ? 'active' : '' }}">
                                        Bộ lọc sales/team
                                    </a>
                                </div> --}}
                                    <div class="menu-item px-3 {{ isset($accountGroup) && $accountGroup->id == Auth::user()->account->accountGroup->id ? 'bg-primary' : '' }}">
                                        <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], ['account_group_id' => Auth::user()->account->accountGroup->id]) }}" 
                                            class="btn btn-sm rotate border-0 menu-item px-3 w-100 " 
                                            data-kt-menu-trigger="hover" 
                                            data-kt-menu-placement="left-start" 
                                            data-kt-menu-offset="0,5">
                                            <span class="material-symbols-rounded me-2">person</span>
                                            Team {{ Auth::user()->account->accountGroup->name }} s
                                            <i class="ki-duotone ki-l fs-3 rotate-180 ms-3 me-0"></i>
                                        </a>
                                    </div> 
                                   {{-- {{Auth::user()->account->accountGroup->members()->get()}} --}}
                                    @foreach (Auth::user()->account->accountGroup->members()->get() as $member)
                                    
                                        <div class="btn btn-sm rotate border-0 menu-item px-3 {{ isset($account) && $account->id == $member->id ? 'bg-primary' : '' }}">
                                            <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], [
                                                'account_id' => $member->id,
                                            ]) }}" class="menu-item px-3 ">
                                                {{ $member->name}}  {{ $member->id}}  
                                            </a>
                                        </div>
                                    @endforeach
                                    
                                @elseif (Auth::user()->can('mentor', \App\Models\User::class))  
                                    <div class="menu-item px-3">
                                        <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], [
                                        'account_id' => Auth::user()->account->id,
                                    ]) }}" class="menu-link px-3 {{ isset($account) && $account->id == Auth::user()->account->id ? 'active' : '' }}">
                                        {{ Auth::user()->account->name }}
                                    </a>
                                    </div>
                                  
                                
                                  
                                    @foreach (Auth::user()->mentees()->get() as $member)
                                    
                                        <div class="btn btn-sm rotate border-0 menu-item px-3 {{ isset($account) && $account->id == $member->id ? 'bg-primary' : '' }}">
                                            
                                            <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], [
                                                'account_id' => $member->id,
                                            ]) }}" class="menu-item px-3 ">
                                                {{ $member->name}}  
                                            </a>
                                        </div>
                                    @endforeach
                                    
                                @endif
                                {{-- <!--begin::Menu separator-->
                                <div class="separator mb-3 opacity-75"></div>
                                <!--end::Menu separator-->
                                
                                @foreach(App\Models\Account::whereNot('id', Auth::user()->account->id)->get() as $acc)
                                    <!--begin::Menu item-->
                                    <div class="menu-item px-3">
                                        <a href="{{ action([App\Http\Controllers\Sales\DashboardController::class, 'index'], [
                                            'account_id' => $acc->id,
                                        ]) }}" class="menu-link px-3 {{ isset($account) && $account->id == $acc->id ? 'active' : '' }}">
                                            {{ $acc->name }}
                                        </a>
                                    </div>
                                    <!--end::Menu item-->
                                @endforeach --}}
                            </div>
                            <!--end::Menu-->
                        </div>
                    </div>
                @endif
            </div>
                
        </div>
        <!--end::Page title-->

    </div>
    <div id="" class="position-relative" id="kt_post">
        <!--begin::Card-->

        {{-- LINE 1 --}}
        <div class="div">
            <div class="row">
                <!--begin::Col-->
                <div class="col h-100">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-1 fw-semibold">{{ $newContactRequestThisMonthCount }}</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Đơn hàng mới trong tháng</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        psychology_alt
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </div>

                <!--begin::Col-->
                <div class="col h-100">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-1 fw-semibold">{{ $noActionContactRequestCount }}</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Đơn hàng chưa được xử lý</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        info
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </div>
                <div class="col h-100">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-1 fw-semibold">
                                           
                                             {{ $overDueRemindersCount }}
                                        </span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Công nợ quá hạn</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        info
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </div>
                <div class="col h-100">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-1 fw-semibold">
                                            
                                            {{$reachingDueDateRemindersCount}}
                                        </span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Công nợ sắp tới trong tháng </span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        info
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </div>
                <div class="col h-100">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-1 fw-semibold">
                                        {{$accountKpiNoteOutDateCount}}
                                        </span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Dự thu quá hạn</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        info
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </div>

                <!--begin::Col-->
                <div class="col h-100 d-none ">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-1 fw-semibold">{{ $newCustomerThisMonthCount }}</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Khách hàng mới tháng này</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        group
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </div>

                <!--begin::Col-->
                <div class="col h-100 d-none">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-1 fw-semibold">{{ $requestDemoCount }}</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Yêu cầu học thử</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        assignment_ind
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col h-100 d-none">
                    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7 border rounded-4 px-5 bg-white py-2 border-gray-400">
                        <!--begin::Header-->
                        <div class="card-header py-0">
                            <!--begin::Title-->
                            <div class="card-title d-flex flex-column ">
                                <!--begin::Info-->
                                <div class="d-flex align-items-top">
                                    <div>
                                        <!--begin::Amount-->
                                        <span
                                            class="fs-1 fw-semibold">{{ $newContractThisMonthCount }}</span>
                                        <!--end::Amount-->

                                        <span class="d-block text-gray-400 fw-semibold fs-6">Hợp đồng mới tháng này</span>
                                        <!--end::Badge-->
                                    </div>

                                </div>
                                <!--end::Info-->


                            </div>
                            <!--end::Title-->
                        </div>
                        <div class="d-flex align-items-center py-1 pt-5 d-none">
                            <div class="symbol symbol-30px me-0 mb-0 ps-5">
                                <span class="menu-icon">
                                    <span class="material-symbols-rounded fs-2hx ">
                                        order_approve
                                    </span>
                                </span>
                            </div>
                        </div>
                        <!--end::Header-->


                    </div>
                </div>
                <!--end::Col-->
            </div>

        </div>

        <div class="row g-5 g-xl-6 mb-5 mb-xl-6" >
            <!--begin::Col-->
            <div class="col-xl-4" style="height: 620px">
                @include('sales.dashboard.chartContactRequestStatus')
            </div>
            <div class="col-xl-8">
                <div style="height: 300px" class="mb-6">
                    @include('sales.dashboard.chartContactRequestOrder')
                </div>
                <div style="height: 300px" class="mb-6">
                    @include('sales.dashboard.revenueFluctuations')
                </div>
            </div>

                {{-- LINE 2 --}}
                <div class="row mt-4" >
                    <!--begin::Col-->
                    <div class="col-xl-4"  style="height: 264px">
                        @include('sales.dashboard.order')
                    </div>
                    <div class="col-xl-4"  style="height: 264px">
                        @include('sales.dashboard.orderType')
                    </div>
                    <div class="col-xl-4"  style="height: 264px">
                     
                        @include('sales.dashboard.kpi')
                    </div>
                    
              
                    <!--end::Col-->
                </div>
            

            
            <!--end::Col-->
        </div>
    </div>
@endsection
