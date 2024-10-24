<h2>2. Thông tin quản lý chung</h2>

<div class="card mb-10">
    <div class="card-body">
        <!--begin::Stats-->
        <div class="d-block">
            <div class="row d-flex justify-content-between">
                <div class="col-3 col-xs-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Chi nhánh:</span>
                            </label>
                        </div>
                        <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                            <div>
                                {{ $abroadApplication->orderItem->training_location->branch ?? '--' }}

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">

                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Nhân viên Tư vấn chiến lược :</span>
                            </label>
                        </div>
                        <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                            <div>
                                {{ $abroadApplication->account1->name ?? '--' }}
                            </div>


                        </div>
                    </div>
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Nhân viên Truyền thông sự kiện :</span>
                            </label>
                        </div>
                        <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                            <div>
                                {{ $abroadApplication->account2->name ?? '--' }}
                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>
        <!--end::Stats-->
    </div>
</div>
