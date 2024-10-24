<div class="card card-flush h-xl-100">
    <!--begin::Heading-->
    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start"
        data-bs-theme="light">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column pt-3">
            <span class="fw-bold fs-2 mb-3">Hợp đồng</span>

            <div class="fs-6">
                <span class="">Tổng cộng</span>

                <span class="position-relative d-inline-block">
                    <a href="/metronic8/demo50/../demo50/pages/user-profile/projects.html"
                        class="link-white  fw-bold d-block mb-1">{{ $orderThisMonthCount }} </a>

                    <!--begin::Separator-->
                    <span class="position-absolute  bottom-0 start-0 border-2 border-body border-bottom w-100"></span>
                    <!--end::Separator-->
                </span>

                <span class="">hợp đồng</span>
            </div>
        </h3>
        <!--end::Title-->

        <!--begin::Toolbar-->

        <!--end::Toolbar-->
    </div>
    <!--end::Heading-->

    <!--begin::Body-->
    <div class="card-body py-5">
        <!--begin::Stats-->
        <div class="position-relative">
            <!--begin::Row-->
            <div class="row g-3 g-lg-6">
                <!--begin::Col-->
                <div class="col-6">
                    <!--begin::Items-->
                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-4 py-3">

                        <a href="{{ action(
                            [App\Http\Controllers\Sales\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL],
                            ['status' => 'draft']
                        ) }}" class="d-block">

                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">edit_document</span>
                                </span>
                                <div>
                                    <!--begin::Number-->
                                        <span
                                        class="text-gray-700 fw-bolder fs-2 lh-1 ls-n1 mb-1 me-5">{{ $draftOrderCount }}</span>
                                    <!--end::Number-->
                                    <br>
                                    <!--begin::Desc-->
                                    <span class="text-gray-500">Đang soạn</span>
                                    <!--end::Desc-->
                                </div>
                            </div>
                        </a>
                        <!--end::Stats-->
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-6">
                    <!--begin::Items-->
                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-4 py-3">

                        <a href="{{ action(
                            [App\Http\Controllers\Sales\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL],
                            ['status' => 'pending']) }}" class="d-block">

                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">pending_actions</span>
                                </span>
                                <div>
                                    <!--begin::Number-->
                                        <span
                                        class="text-gray-700 fw-bolder fs-2 lh-1 ls-n1 mb-1 me-5">{{ $pendingOrderCount }}</span>
                                    <!--end::Number-->
                                    <br>
                                    <!--begin::Desc-->
                                    <span class="text-gray-500">Chờ duyệt</span>
                                    <!--end::Desc-->
                                </div>
                            </div>
                        </a>
                        <!--end::Stats-->
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-6">
                    <!--begin::Items-->
                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-4 py-3">
                        <!--begin::Symbol-->
                        <a href="{{ action(
                            [App\Http\Controllers\Sales\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL],
                            ['status' => 'active']) }}" class="d-block">

                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">fact_check</span>
                                </span>
                                <div>
                                    <!--begin::Number-->
                                        <span
                                        class="text-gray-700 fw-bolder fs-2 lh-1 ls-n1 mb-1 me-5">{{ $activeOrderCount }}</span>
                                    <!--end::Number-->
                                    <br>
                                    <!--begin::Desc-->
                                    <span class="text-gray-500">Hoàn thành</span>
                                    <!--end::Desc-->
                                </div>
                            </div>
                        </a>
                        <!--end::Stats-->
                    </div>
                    <!--end::Items-->
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-6">
                    <!--begin::Items-->
                    <div class="bg-gray-100 bg-opacity-70 rounded-2 px-4 py-3">
                        <!--begin::Symbol-->
                        <a href="{{ action(
                            [App\Http\Controllers\Sales\OrderController::class, 'index'], ['type' => App\Models\Order::TYPE_GENERAL],
                            ['status' => 'rejected']) }}" class="d-block">

                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">feedback</span>
                                </span>
                                <div>
                                    <!--begin::Number-->
                                        <span
                                        class="text-gray-700 fw-bolder fs-2 lh-1 ls-n1 mb-1 me-5">{{ $rejectedOrderCount }}</span>
                                    <!--end::Number-->
                                    <br>
                                    <!--begin::Desc-->
                                    <span class="text-gray-500">Từ chối duyệt</span>
                                    <!--end::Desc-->
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
