<h2>1. Thông tin học viên</h2>

<div class="card mb-10">
    <div class="card-body">
        <!--begin::Stats-->
        <div class="d-block">
            <div class="row d-flex justify-content-between">
                <div class="col-5 col-xs-5 col-sm-5 col-md-5 col-lg-5 col-xl-5">
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Mã học viên:</span>
                            </label>
                        </div>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div>{{$abroadApplication->contact->code }}</div>
                        </div>
                    </div>
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Mã cũ học viên:</span>
                            </label>
                        </div>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div>{{$abroadApplication->contact->import_id }}</div>
                        </div>
                    </div>

                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Số điện thoại:</span>
                            </label>
                        </div>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div>{{ $abroadApplication->contact->phone }}</div>
                        </div>
                    </div>
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Email:</span>
                            </label>
                        </div>
                        <div class="col-6 col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                            <div>{{ $abroadApplication->contact->email }}</div>
                        </div>
                    </div>

                </div>
                <div class="col-7 col-xs-7 col-sm-7 col-md-7 col-lg-7 col-xl-7">
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Tên học viên:</span>
                            </label>
                        </div>
                        <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                            <div>{{$abroadApplication->student->name }}</div>
                        </div>
                    </div>
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Ngày tháng năm sinh:</span>
                            </label>
                        </div>
                        <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                            <div>

                                @php
                                $formattedBirthday = $abroadApplication->student->birthday ? date('d/m/Y', strtotime($abroadApplication->student->birthday)) : '--';
                            @endphp
                    
                            {{ $formattedBirthday }}
                            </div>


                        </div>
                    </div>
                    <div class="fv-row my-3 d-flex border-bottom">
                        <div class="col-4 col-xs-4 col-sm-4 col-md-4 col-lg-4 col-xl-4 d-flex align-items-center">
                            <label class="fs-6 fw-semibold mb-2">
                                <span class="fw-bold">Thời điểm apply:</span>
                            </label>
                        </div>
                        <div class="col-8 col-xs-8 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                            <div>
                                {{ date('d/m/Y', strtotime($abroadApplication->orderItem->apply_time)) }}

                            </div>
                        </div>
                    </div>

                </div>



            </div>
        </div>
        <!--end::Stats-->
    </div>
</div>
