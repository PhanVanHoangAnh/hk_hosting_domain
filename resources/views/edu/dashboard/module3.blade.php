<div class="card card-flush h-xl-100">
    <!--begin::Heading-->
    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start"
        data-bs-theme="light">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column pt-3">
            <span class="fw-bold fs-2 mb-3">Lớp học</span>

            <div class="fs-6">
                <span class="">Tổng cộng</span>

                <span class="position-relative d-inline-block">
                    <a href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'index']) }}"
                        class="link-white  fw-bold d-block mb-1">{{ App\Models\Course::get()->count() }}</a>
                    <!--begin::Separator-->
                    <span class="position-absolute  bottom-0 start-0 border-2 border-body border-bottom w-100"></span>
                    <!--end::Separator-->
                </span>

                <span class="">lớp học</span>
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

                        <a href="{{ action([App\Http\Controllers\Edu\CourseController::class, 'index']) }}" class="d-block">
                           
                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">summarize</span>
                                </span>
                                <div>
                                    <!--begin::Number-->
                                        <span
                                        class="text-gray-700 fw-bolder fs-2 lh-1 ls-n1 mb-1 me-5">{{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->count() }}</span>
                                    <!--end::Number-->
                                    <br>
                                    <!--begin::Desc-->
                                    <span class="text-gray-500">Tất cả</span>
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
                            [App\Http\Controllers\Edu\CourseController::class, 'index'],
                            [
                                'status' => App\Models\Course::OPENING_STATUS,
                            ],
                        ) }}" class="d-block">

                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">door_open</span>
                                </span>
                                <div>
                                    <!--begin::Number-->
                                        <span
                                        class="text-gray-700 fw-bolder fs-2 lh-1 ls-n1 mb-1 me-5">{{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->getIsLearning()->count() }}</span>
                                    <!--end::Number-->
                                    <br>
                                    <!--begin::Desc-->
                                    <span class="text-gray-500">Đang học</span>
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
                            [App\Http\Controllers\Edu\CourseController::class, 'index'],
                            [
                                'status' => App\Models\Course::WAITING_OPEN_STATUS,
                            ],
                        ) }}" class="d-block">

                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">door_back</span>
                                </span>
                                <div>
                                    <!--begin::Number-->
                                        <span
                                        class="text-gray-700 fw-bolder fs-2 lh-1 ls-n1 mb-1 me-5">{{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->getIsUnstudied()->count() }}</span>
                                    <!--end::Number-->
                                    <br>
                                    <!--begin::Desc-->
                                    <span class="text-gray-500">Chưa bắt đầu</span>
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
                            [App\Http\Controllers\Edu\CourseController::class, 'index'],
                            [
                                'status' => App\Models\Course::COMPLETED_STATUS,
                            ],
                        ) }}" class="d-block">

                            <!-- Stats -->
                            <div class="m-0 d-flex align-items-center">
                                <span class="menu-icon symbol symbol-30px me-5 mt-2" style="width: 30px;">
                                    <span class="material-symbols-rounded fs-2hx">task_alt</span>
                                </span>
                                <div>
                                    <!--begin::Number-->
                                        <span
                                        class="text-gray-700 fw-bolder fs-2 lh-1 ls-n1 mb-1 me-5">{{ App\Models\Course::byBranch(\App\Library\Branch::getCurrentBranch())->getIsStudied()->count() }}</span>
                                    <!--end::Number-->
                                    <br>
                                    <!--begin::Desc-->
                                    <span class="text-gray-500">Đã hoàn thành</span>
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
