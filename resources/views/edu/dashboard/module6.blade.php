<link rel="stylesheet" href="{{ url('chart_circle/circle.css') }}" />


<div class="card card-flush h-xl-100 ">
    <!--begin::Header-->
    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start mb-2"
        data-bs-theme="light">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column pt-3">
            <span class="fw-bold fs-2 mb-3">Tỉ lệ</span>

            <div class="fs-6">
                <span>Trạng thái nhân sự đào tạo</span>

            </div>
        </h3>
        <!--end::Title-->

        <!--begin::Toolbar-->
        <div class="card-toolbar pt-10 d-none">
            <span class="fw-bold fs-2x mb-3 me-3"></span>
            <span class="">yêu cầu</span>
        </div>
        <!--end::Toolbar-->
    </div>
    <!--end::Header-->

    <!--begin::Body-->
    @php
       
    @endphp
    <div class="card-body flush mt-3 py-0">
        <div class="d-flex align-items-top" style="justify-content: space-between;width:100%;">
            @php
                if (!function_exists('calculatePercentage')) {
                    function calculatePercentage($count, $total)
                    {
                        return $total != 0 ? round(($count / max($total, 1)) * 100) : 0;
                    }
                }
            @endphp
        
            <a href="{{ action( [App\Http\Controllers\Edu\StaffController::class, 'index'],
                [
                    'type' => App\Models\Teacher::TYPE_VIETNAM,
                ],
            ) }}">
                 <div>
                    <div class="c100 p{{ calculatePercentage(App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isVietNam()->count(),  App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->byBranch(\App\Library\Branch::getCurrentBranch())->count()) }} center bx-1">
                        <span><span class="fw-semibold" style="color:#3ba272">{{ calculatePercentage(App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isVietNam()->count() ,  App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count()) }}%</span><br><span class="fs-7">Việt Nam</span></span>
                        <div class="slice"><div class="bar" style="border-color:#3ba272"></div><div class="fill" style="border-color:#3ba272"></div></div>
                    </div>
                    <p class="text-center mt-5 fw-semibold mb-0">{{ App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->byBranch(\App\Library\Branch::getCurrentBranch())->isVietNam()->count() }} / {{ App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->byBranch(\App\Library\Branch::getCurrentBranch())->get()->count() }}</p>
                    <p class=" text-center fs-7">Số lượng / Tổng</p>
                </div>
                
                
            </a>
            <a href="{{ action( [App\Http\Controllers\Edu\StaffController::class, 'index'],
                [
                    'type' => App\Models\Teacher::TYPE_FOREIGN,
                ],
            ) }}">
                <div>
                    <div class="c100 p{{ calculatePercentage(App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isForeign()->count(),  App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count()) }} center bx-1">
                        <span>
                            <span class="fw-semibold" style="color:#5b7bda">{{ calculatePercentage(App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isForeign()->count() ,  App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count()) }}%</span>
                            <br>
                            <span class="fs-7">nước ngoài</span>
                        </span>
                        <div class="slice"><div class="bar" style="border-color:#5b7bda"></div><div class="fill" style="border-color:#5b7bda"></div></div>
                    </div>
                    <p class="text-center mt-5 fw-semibold mb-0">{{ App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isForeign()->count() }} / {{ App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count() }}</p>
                    <p class=" text-center fs-7">Số lượng / Tổng</p>
                </div>
                
            </a>
            <a href="{{ action( [App\Http\Controllers\Edu\StaffController::class, 'index'],
                [
                    'type' => App\Models\Teacher::TYPE_TUTOR,
                ],
            ) }}">
                <div>
                    <div class="c100 p{{ calculatePercentage(App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isTutor()->count(),  App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count()) }} center bx-1">
                        <span>
                            <span class="fw-semibold" style="color:#fc8452">{{ calculatePercentage(App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isTutor()->count() ,  App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count()) }}%</span>
                            <br>
                            <span class="fs-7">gia sư</span>
                        </span>
                        <div class="slice"><div class="bar" style="border-color:#fc8452"></div><div class="fill" style="border-color:#fc8452"></div></div>
                    </div>
                    <p class="text-center mt-5 fw-semibold mb-0">{{ App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->isTutor()->count() }} / {{ App\Models\Teacher::byBranch(\App\Library\Branch::getCurrentBranch())->get()->count() }}</p>
                    <p class=" text-center fs-7">Số lượng / Tổng</p>
                </div>
                
            </a>

        </div>

    </div>
    
    <!--end::Body-->
</div>


<script src="{{ url('chart_circle/js/mk_charts.js') }}"></script>
