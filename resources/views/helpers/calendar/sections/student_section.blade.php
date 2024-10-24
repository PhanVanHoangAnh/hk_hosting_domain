@if (date('y-m-d', strtotime($calendar->getActiveYear() . '-' . $calendar->getActiveMonth() . '-' . $date . ' -' . 0 . ' day')) == date('y-m-d', strtotime($event[0])))
    <div style="position: relative;" data-item="event" data-code="{{ $event[5] }}">
        <div list-data="event" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-html="true"
            title=
                '
                    <div class="tooltip-content" style="position: relative;">
                        @if($event[24] === App\Models\Section::TYPE_TEST)
                            <div class="custom-type-section">Kiểm tra</div>
                        @elseif($event[26] === \App\Models\StudentSection::STATUS_RESERVE)
                            <div class="custom-type-section">Đã bảo lưu</div>
                        @else
                            <div class="custom-type-section">Buổi học</div>
                        @endif
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 text-bold text-info d-flex justify-content-start fs-3 mb-2">
                                @if(isset($isShowCode) && $isShowCode)
                                    <div class="row px-3 fw-bold text-dark">
                                        {{ $event[22] }}
                                    </div>&nbsp;&nbsp;({{ substr($event[1], 11, 5) }} - {{ substr($event[2], 11, 5) }})
                                @else
                                {{ substr($event[1], 11, 5) }} - {{ substr($event[2], 11, 5) }}
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                {{ Carbon\Carbon::parse($event[2])->diffInMinutes(Carbon\Carbon::parse($event[1])) }} phút | 
                                {{ number_format(Carbon\Carbon::parse($event[2])->diffInMinutes(Carbon\Carbon::parse($event[1])) / 60, 1) }} giờ
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                <span class="fw-bold">Trạng thái:&nbsp;</span> {{ trans('messages.student_section.' . $event[26]) }}
                            </div>

                            @if($event[6] && $event[6] !== '' && $event[6] !== 'false' && $event[6] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                    <span class="fw-bold">Giáo viên Việt Nam:&nbsp;</span> {{ $event[7] ? App\Models\Teacher::find($event[7])->name : "" }} ({{ $event[8] }} - {{ $event[9] }})
                                </div>
                            @endif

                            @if($event[10] && $event[10] !== '' && $event[10] !== 'false' && $event[10] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                    <span class="fw-bold">Giáo viên nước ngoài:&nbsp;</span> {{ $event[11] ? App\Models\Teacher::find($event[11])->name : "" }} ({{ $event[12] }} - {{ $event[13] }})
                                </div>
                            @endif

                            @if($event[14] && $event[14] !== '' && $event[14] !== 'false' && $event[14] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                    <span class="fw-bold">Gia sư:&nbsp;</span> {{ $event[15] ? App\Models\Teacher::find($event[15])->name : "" }} ({{ $event[16] }} - {{ $event[17] }})
                                </div>
                            @endif

                            @if($event[18] && $event[18] !== '' && $event[18] !== 'false' && $event[18] !== "0")
                                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 d-flex justify-content-start text-left mb-2">
                                    <span class="fw-bold">Trợ giảng:&nbsp;</span> {{ $event[19] ? App\Models\Teacher::find($event[19])->name : "" }} ({{ $event[20] }} - {{ $event[21] }})
                                </div>
                            @endif
                        </div>
                    </div>
                '
            class="event {{ $event[24] === App\Models\Section::TYPE_TEST ? 'red' : 'blue' }} mt-2 p-2 fw-500 fs-14 rounded-1 text-light"
                    
            @if($event[26] === \App\Models\StudentSection::STATUS_RESERVE)
                style="background-color: purple !important"
            @endif

            @if($event[26] === \App\Models\StudentSection::STATUS_TRANSFERRED)
                style="background-color: #aaa !important"
            @endif

            @if(!((!$event[4] || $event[4] === 'false' || $event[4] === "0" || $event[4] === "") && !($event[23] === '1' || $event[23] || $event[23] === '')) && ($event[23] || $event[23] === '1'))
                style="border: 3px solid purple !important"
            @endif
            >
            @if(isset($isShowCode) && $isShowCode)
                <div class="row px-3 fw-bold" style="color: #fdf9f9">
                    {{ $event[22] }}
                </div>
            @endif
            <div class="row px-3 fs-8 fw-bold" style="color: #ede7fa">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 p-0 d-flex justify-content-start align-items-center">
                    <div class="row d-flex justify-content-center align-items-center" style="font-size: 12px">
                       
                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 col-xl-3 mx-auto ps-3 pe-3 py-0 my-0 text-center">
                            ({{ $event[27] }})
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 col-xl-4 text-center mx-auto ps-2 py-0 my-0">
                            {{ strlen($event[1]) > 10 ? substr($event[1], 11, 5) : $event[1] }}
                        </div>

                        <div class="col-lg-1 col-md-1 col-sm-1 col-1 col-xl-1 mx-auto p-0 my-0 text-center" style="font-size: 14px">
                            -
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-4 col-4 col-xl-4 text-center mx-auto p-0 pe-2 my-0">
                            {{ strlen($event[2]) > 10 ? substr($event[2], 11, 5) : $event[2] }}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 p-e d-flex justify-content-end align-items-center">
                    <div class="row d-flex justify-content-center align-items-center">

                        @if($event[6] && $event[6] !== '' && $event[6] !== 'false' && $event[6] !== "0")
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 col-xl-6 mx-auto pe-1 py-0 ps-1 my-0">
                                <div class="bg-secondary d-flex justify-content-center align-items-center" style="border-radius: 100%; width: 18px; height: 18px; font-size: 9px"><span class="text-dark fw-bold">VN</span></div>
                            </div>
                        @endif

                        @if($event[10] && $event[10] !== '' && $event[10] !== 'false' && $event[10] !== "0")
                            <div class="col-lg-6 col-md-6 col-sm-6 col-6 col-xl-6 mx-auto p-0 my-0">
                                <div class="bg-info d-flex justify-content-center align-items-center" style="border-radius: 100%; width: 18px; height: 18px; font-size: 9px"><span class="fw-bold">NN</span></div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="d-none p-6" action-control="event-action" style="position: absolute; bottom: 20%; right: -20%; width: 50px; height: 40px; transition: transform 0.3s ease; z-index: 1000"
            onmouseover="this.style.transform='scale(1.2)'"
            onmouseout="this.style.transform='scale(1)'"
        >
            <div class="row" actions-control="event-actions">
                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 mb-1 ms-7">
                    <span data-control="edit-event" class="material-symbols-rounded text-center d-flex align-items-center justify-content-center hover-overlay hover-zoom hover-shadow ripple action-custom"
                        data-bs-toggle="tooltip" data-bs-placement="right" title="Chỉnh sửa"
                        onmouseover="this.style.transform='scale(2)'"
                        onmouseout="this.style.transform='scale(1)'"
                    >
                        edit
                    </span>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12 col-12 col-xl-12 mt-1 ms-7">
                    <span data-control="delete-event" class="material-symbols-rounded text-center d-flex align-items-center justify-content-center hover-overlay hover-zoom hover-shadow ripple action-custom"
                        data-bs-toggle="tooltip" data-bs-placement="right" title="Xóa"
                        onmouseover="this.style.transform='scale(2)'"
                        onmouseout="this.style.transform='scale(1)'"
                    >
                        delete
                    </span>
                </div>
            </div>
        </div>
    </div>
@endif