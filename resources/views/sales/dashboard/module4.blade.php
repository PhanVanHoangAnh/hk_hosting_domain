<div class="card card-flush h-xl-100 " style="overflow: scroll;">
    <!--begin::Header-->
    <div class="card-header rounded bgi-no-repeat bgi-size-cover bgi-position-y-top bgi-position-x-center align-items-start mb-7"
        data-bs-theme="light">
        <!--begin::Title-->
        <h3 class="card-title align-items-start flex-column pt-3">
            <span class="fw-bold fs-2 mb-3">{{ $contactRequestCount }}</span>

            <div class="fs-6">
                <span class="">Đơn hàng từ các kênh quảng cáo</span>

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
    <div class="card-body pt-5 flush mt-3" style="overflow: scroll;">

        <!--begin::Item-->
        @foreach ($contactCount as $channel => $count)
            <div class="d-flex flex-stack">
                <!--begin::Wrapper-->
                <div class="d-flex align-items-center me-3">
                    <!--begin::Logo-->
                    <img src="{{ url('/core/assets/media/logos/' . $channel . '.png') }}" class="me-4 w-30px h-30px"
                        alt="">
                    <!--end::Logo-->

                    <!--begin::Section-->
                    <div class="flex-grow-1">
                        <!--begin::Text-->
                        <a href="#"
                            class="text-gray-800 text-hover-primary fs-5 fw-bold">{{ $channel }}</a>
                        <!--end::Text-->


                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Wrapper-->

                <!--begin::Statistics-->
                <div class="d-flex align-items-center">
                    <!--begin::Progress-->

                    <span class="text-gray-800 text-hover-primary fs-5 fw-bold">
                        {{ $count }}
                    </span>

                    <!--end::Progress-->

                    <!--begin::Value-->

                    <!--end::Value-->
                </div>
                <!--end::Statistics-->
            </div>
            <!--end::Item-->
            <div class="separator separator-dashed my-2"></div>
            <!--begin::Separator-->

            <!--end::Item-->
        @endforeach
    </div>
    <!--end::Body-->
</div>
