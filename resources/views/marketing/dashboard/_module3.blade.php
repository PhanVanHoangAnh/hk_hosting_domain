<div class="card card-flush h-xl-100">
    <!--begin::Heading-->
    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start h-250px"
        data-bs-theme="light">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column pt-5">
            <span class="fw-bold  mb-3 fs-2">Đơn hàng</span>

            <div class="fs-6">
                <span class="">Tổng cộng</span>

                <span class="position-relative d-inline-block">
                    <a href="/metronic8/demo50/../demo50/pages/user-profile/projects.html"
                        class="link-white  fw-bold d-block mb-1">{{ App\Helpers\Functions::formatNumber($totalContactCount) }}</a>

                    <!--begin::Separator-->
                    <span class="position-absolute  bottom-0 start-0 border-2 border-body border-bottom w-100"></span>
                    <!--end::Separator-->
                </span>

                <span class="">đơn hàng</span>
            </div>
        </h3>
        <!--end::Title-->

        <!--begin::Toolbar-->

        <!--end::Toolbar-->
    </div>
    <!--end::Heading-->

    <!--begin::Body-->
    <div class="card-body">
        <!--begin::Stats-->
        <div class="position-relative">
            <!--begin::Row-->
            <div class="row g-3 g-lg-6">
                <!--begin::Col-->
                <div class="col-6" style="10vh">
                    <!--begin::Items-->
                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-3 py-2">
                        <a href="{{ action(
                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                            ['status' => 'is_new']) }}">
                            <!--begin::Symbol-->
                        
                    
                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">feedback</span>
                                </span>
                                <div>
                                    <!-- Number -->
                                    <span class=" text-gray-700 fw-semibold fs-2 mb-40 mt-20 me-2">
                                        {{ App\Helpers\Functions::formatNumber(App\Models\ContactRequest::isNew()->count()) }}
                                    </span>
                                    <br>
                                    <!-- Desc -->
                                    <span class=" text-gray-500 fs-6">Mới</span>
                                </div>
                            </div>
                        </a>
                        <!--end::Stats-->
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-6" style="10vh">
                    <!--begin::Items-->
                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-3 py-2">
                        <a href="{{ action(
                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                            ['status' => 'is_assigned']) }}">
                        <!--begin::Symbol-->

                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">person_check</span>
                                </span>
                                <div>
                                    <!-- Number -->
                                    <span class=" text-gray-700 fw-semibold fs-2 mb-40 mt-20 me-2">
                                        {{ App\Helpers\Functions::formatNumber(App\Models\ContactRequest::isAssignedCount()) }}
                                    </span>
                                    <br>
                                    <!-- Desc -->
                                    <span class=" text-gray-500 fs-6">Đã bàn giao</span>
                                </div>
                            </div>
                        </a>
                        <!--end::Stats-->
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-6" style="10vh">
                    <!--begin::Items-->
                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-3 py-2">
                        <a href="{{ action(
                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                            ['status' => 'has_action']) }}">
                        <!--begin::Symbol-->

                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">task_alt</span>
                                </span>
                                <div>
                                    <!-- Number -->
                                    <span class=" text-gray-700 fw-semibold fs-2 mb-40 mt-20 me-2">
                                        {{ App\Helpers\Functions::formatNumber(App\Models\ContactRequest::hasActionCount()) }}
                                    </span>
                                    <br>
                                    <!-- Desc -->
                                    <span class=" text-gray-500 fs-6">Đã khai thác</span>
                                </div>
                            </div>
                        </a>
                        <!--end::Stats-->
                    </div>
                    <!--end::Items-->
                </div>
                
                <!--begin::Col-->
                <div class="col-6" style="10vh">
                    <!--begin::Items-->
                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-3 py-2">
                        <a href="{{ action(
                            [App\Http\Controllers\Marketing\ContactRequestController::class, 'index'],
                            ['status' => 'outdated']) }}">
                        <!--begin::Symbol-->
                        
                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">warning</span>
                                </span>
                                <div>
                                    <!-- Number -->
                                    <span class=" text-gray-700 fw-semibold fs-2 mb-40 mt-20 me-2">
                                        {{ App\Helpers\Functions::formatNumber(App\Models\ContactRequest::noActionYet()->outdated()->count()) }}
                                    </span>
                                    <br>
                                    <!-- Desc -->
                                    <span class=" text-gray-500 fs-6">Hết hạn</span>
                                </div>
                            </div>
                        </a>
                        <!--end::Stats-->
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Col-->

            </div>
            <!--end::Row-->
        </div>
        <!--end::Stats-->
    </div>
    <!--end::Body-->
</div>
